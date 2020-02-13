<script>   
    $('#notifications').slideDown('slow').delay(3000).slideUp('slow');
</script>
<div class="container">
    <div class="card" style="width:50%; margin-top:30%; margin-left:25%; margin-bottom:15%; padding:20px;">
        <h3 style="text-align:center;">Block chain</h3>
        <form action="<?php echo base_url() ?>index.php/welcome/action_insert" method="POST">
        <div id="notifications"><?php echo $this->session->flashdata('message'); ?></div>
          <div class="input-group mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroup-sizing-default">Masukkan Data</span>
              </div>
              <input type="text" class="form-control" name="data_input" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
          </div>
          <div>
              <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
              <button type="button" class="btn btn-secondary btn-lg btn-block" data-toggle="modal" data-target="#staticBackdrop">Lihat Data</button>
          </div>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Data yang tersimpan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="table_id" class="display">
          <thead>
              <tr>
                  <th>Indeks</th>
                  <th>Data</th>
                  <th>Tanggal</th>
              </tr>
          </thead>
          <tbody>
            <?php
            foreach ($list as $data_blockchain){
              echo "<tr>";
              echo "<td>$data_blockchain->indeks</td>";
              echo "<td>$data_blockchain->data</td>";
              echo "<td>$data_blockchain->date</td>";
              echo "</tr>";
            }
            ?>
          </tbody>
      </table>
      </div>
      <form action="<?php echo base_url() ?>index.php/welcome/cek_data">
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" >Cek Data</button>
      </div>
    </div>
  </div>
</div>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $('#table_id').DataTable();
});
</script>