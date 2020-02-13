<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class M_main extends CI_Model {

		public function insert($data){
            return $this->db->insert('data_blockchain', $data);
		}

		public function get_data(){
            $query = $this->db->query('SELECT * FROM data_blockchain')->result();
            return $query;
        }

        public function get_data_with_indeks($indeks){
            $query = $this->db->query("SELECT * FROM data_blockchain WHERE indeks='$indeks'")->result();
            return $query;
        }

        public function get_last_data()
        {
            $query = $this->db->query("SELECT * FROM data_blockchain ORDER BY indeks DESC LIMIT 1;")->row_array();
            return $query;
        }

        public function get_rows()
        {
            $query = $this->db->query("SELECT count(*) AS jumlah FROM data_blockchain");
            return $row_cnt = $query->num_rows;
        }

        public function hacker($indeks, $data)
        {
            $query = $this->db->query("UPDATE data_blockchain SET data = '$data' WHERE indeks = '$indeks'");
		    return $query;
        }
	}