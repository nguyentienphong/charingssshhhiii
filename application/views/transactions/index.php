<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage Transactions
  
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Transactions</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

        <?php if($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif($this->session->flashdata('error')): ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>

        <form name="inputform" action="" method="post" >
        <label for="email">Reqid:</label><span> <input name="requestId" type="text" value="<?php if(isset($_POST['requestId'])){echo $_POST['requestId'];}else{echo $_SESSION['storeValues'][1];} ?>"></span>
        <br><label for="email">Fromdate:</label><span> <input name="fromDate" type="text" value="<?php if(isset($_POST['fromDate'])){ echo $_POST['fromDate'];}else{echo $_SESSION['storeValues'][2];} ?>" id="datepicker" autocomplete="off">
        <label for="email">Todate:</label><span>  <input name="toDate" type="text" value="<?php if(isset($_POST['toDate'])){echo $_POST['toDate'];}else{echo $_SESSION['storeValues'][3];} ?>" id="datepicker1" autocomplete="off">
        <label for="email">Serial:</label><span> <input name="serial" type="text" value="<?php if(isset($_POST['serial'])){echo $_POST['serial'];}else{echo $_SESSION['storeValues'][4];} ?>">
        <label for="email">Pin:</label><span> <input name="pin" type="text" value="<?php if(isset($_POST['pin'])){echo $_POST['pin'];}else{echo $_SESSION['storeValues'][5];} ?>">
        <br> <label for="email">Status:</label>
        <select name="slFinalStatus">
          <option value="" <?php echo isset($_POST["slFinalStatus"]) && $_POST["slFinalStatus"] == "0" ? "selected" : "" ?>>Chọn trạng thái</option> 
          <option value="00" <?php echo isset($_POST["slFinalStatus"]) && $_POST["slFinalStatus"] == "00" ? "selected" : "" ?>>Thành công</option>
          <option value="99" <?php echo isset($_POST["slFinalStatus"]) && $_POST["slFinalStatus"] == "99" ? "selected" : "" ?>>Pending</option>
        </select>
        <br>
        <input type="submit" name="submit" text="Search" class="button">
        
        </form>
        <div class="box">
        <div class="box-body">
            <?php if (isset($results)) { ?>
                <table id="manageTable" class="table table-bordered table-striped" style="width: 100%;display: block;overflow-x: auto;white-space: nowrap;">
                    <tr>
                    <th>Request Id</th>
                    <th>P Id</th>
                    <th>Username</th>
                    <th>Card Pin</th>
                    <th>Card Seri</th>
                    <th>Provider</th>
                    <th>Received date</th>
                    <th>Response date</th>
                    <th>Status</th>
                    <th>Message</th>
                    <th>Amount</th>
                    <th>Print Amount</th>
                    </tr>
                    <?php foreach ($results as $data) { ?>
                        <tr>
                            <td><?php echo $data->request_id ?></td>
                            <td><?php echo $data->partner_id ?></td>
                            <td><?php echo $data->partner_username ?></td>
                            <td><?php echo $data->card_pin ?></td>
                            <td><?php echo $data->card_serial ?></td>
                            <td><?php echo $data->provider_code ?></td>
                            <td><?php echo $data->receive_date ?></td>
                            <td><?php echo $data->response_date ?></td>
                            <td><?php echo $data->final_status ?></td>
                            <td><?php echo $data->provider_message ?></td>
                            <td><?php echo $data->response_amount ?></td>
                            <td><?php echo $data->post_amount ?></td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <div>No user(s) found.</div>
            <?php } ?>
 
            <?php if (isset($links)) { ?>
                <?php echo $links ?>
            <?php } ?>
            </div>
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
$( function() {
    $( "#datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' });
  } );

  $( function() {
    $( "#datepicker1" ).datepicker({ dateFormat: 'dd/mm/yy' });
  } );

</script>
<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

.form-inline {  
  display: flex;
  flex-flow: row wrap;
  align-items: center;
}

.form-inline label {
  margin: 5px 10px 5px 0;
}

.form-inline input {
  vertical-align: middle;
  margin: 5px 10px 5px 0;
  padding: 10px;
  background-color: #fff;
  border: 1px solid #ddd;
}

.form-inline button {
  padding: 10px 20px;
  background-color: dodgerblue;
  border: 1px solid #ddd;
  color: white;
}

.form-inline button:hover {
  background-color: royalblue;
}

@media (max-width: 800px) {
  .form-inline input, .form-inline .button {
    margin: 10px 0;
  }
  
  .form-inline {
    flex-direction: column;
    align-items: stretch;
  }
}
</style>

<script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>