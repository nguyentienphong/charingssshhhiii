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
      Scratch Cards
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

        <div id="messages">
        <?php if(!empty($error)) echo $error; ?>
        </div>
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

        <form class="form-horizontal" action="" method="post" >
        
			<div class="box box-info">
				<div class="box-header with-border">
					<div class="form-group">
						<label class="col-sm-1 control-label">Loại thẻ</label>
						<div class="col-sm-3">
							<select name="telcoCode" class="form-control">
								<option value="0">Chọn loại thẻ</option>
								<option value="ViettelNN">Thẻ Vietel</option>
								<option value="VinaNN">Thẻ Vinaphone</option>
							</select>
						</div>
						
						<label class="col-sm-1 control-label">Serial</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" name="cardSerial" placeholder = "Nhập mã serial nằm sau thẻ" value="" />
						</div>
						
						<label class="col-sm-1 control-label">Mã thẻ</label>
						<div class="col-sm-3">
							 <input type="text" class="form-control" name="cardPin" placeholder="Nhập mã số sau lớp bạc mỏng" value="" />
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-1 control-label">Mệnh giá thẻ</label>
						<div class="col-sm-3">
							 <select name="cardAmount" class="form-control">
								<option value="10000">10,000</option>
								<option value="20000">20,000</option>
								<option value="50000">50,000</option>
								<option value="100000">100,000</option>
								<option value="200000">200,000</option>
								<option value="500000">500,000</option>
								<option value="1000000">1,000,000</option>
							</select>
						</div>
						
						<label class="col-sm-1 control-label">Mobile number</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" name="phoneNumber" placeholder="Nhập số điện thoại cần nạp" value="" />
						</div>
					</div>
					
					<input class="btn btn-primary" type="submit" name="frm_submit" value="Thanh toán">
				</div>
			</div>
        </form>
        
        
        
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

<!--script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script-->