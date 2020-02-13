<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){
		parent::__construct();
		$this->load->model('m_main');
	}

	public function index()
	{
		$data['list'] = $this->m_main->get_data();
		$this->load->view('partial/header.php');
		$this->load->view('main.php', $data);
	}

	public function insert(){
		$prev_data= $this->m_main->get_last_data();
		$indeks = $prev_data['indeks']+1;
		$data = $this->input->post('data_input');
		$date = date('Y-m-d H:i:s');
		$prevhash = $prev_data['hash'];
		$gabung_string = $indeks.$data.$date.$prevhash;
		$hash = hash('adler32',$gabung_string);
		$data_genesis = array(
			'indeks' => $indeks,
			'data'	=> $data,
			'date' => $date,
			'prevhash' => $prevhash,
			'hash' => $hash
		);
		$this->m_main->insert($data_genesis);
		$this->session->set_flashdata('message','<center><div class="alert alert-success" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
                    <h4>Data Berhasil Disimpan</h4>
                    <p>Success</p>
				</div></center>');
		redirect(base_url());
	}

	public function action_insert()
	{
		$cek_db = $this->m_main->get_data();
		if (!$cek_db)
		{
			$indeks = 0;
			$data = "genesis";
			$date = date('Y-m-d H:i:s');
			$prevhash = 0;
			$gabung_string = $indeks.$data.$date.$prevhash;
			$hash = hash('adler32',$gabung_string);
			$data_genesis = array(
				'indeks' => $indeks,
				'data'	=> $data,
				'date' => $date,
				'prevhash' => $prevhash,
				'hash' => $hash
			);
			$this->m_main->insert($data_genesis);
			$this->insert();
		}
		else
		{
			$this->insert();
		};
	}

	public function cek_data()
	{
		$i=0;
		$verified = "true";
		$jumlah_data = $this->m_main->get_rows();
		while ($i < $jumlah_data){
			$prev_data = $this->m_main->get_data($i);
			$gabung_string_prev = $prev_data['indeks'].$prev_data['data'].$prev_data['date'].$prev_data['prevhash'];
			$indeks_current_data = $i+1;
			$current_data = $this->m_main->get_data($indeks_current_data);
			$gabung_string_current = $current_data['indeks'].$current_data['data'].$current_data['date'].$current_data['prevhash'];
			if (hash('adler32',$gabung_string_prev)==hash('adler32',$gabung_string_current))
			{
				$verified = "true";
			}
			else
			{
				$verified = "false";
			};
			$i=$i+1;
		}
		if($verified == "true")
		{
			$this->session->set_flashdata('message','<center><div class="alert alert-success" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
                    <h4>Data Masih Asli</h4>
                    <p>Verified</p>
				</div></center>');
			redirect(base_url());
		}
		else
		{
			$this->session->set_flashdata('message','<center><div class="alert alert-danger" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
                    <h4>Data Sudah Teretas</h4>
                    <p>Hacked</p>
				</div></center>');
			echo hash('adler32',$gabung_string_prev);
			echo hash('adler32',$gabung_string_current);
			redirect(base_url());
		};
	}
}