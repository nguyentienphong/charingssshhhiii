
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage Order
  
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Manage Order</li>
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

        <!--div class="box"-->
			<div class="box box-info">
			
				<div class="box-header with-border">
					<form class="form-horizontal" action="" method="post" >
						<div class="form-group">
							<label class="col-sm-1 control-label">Fromdate</label>
							<div class="col-sm-3">
								<input class="form-control" name="fromDate" type="text" value="<?php if(isset($_POST['fromDate'])){ echo $_POST['fromDate'];} ?>" id="datepicker" autocomplete="off">
							</div>
							
							<label class="col-sm-1 control-label">Todate</label>
							<div class="col-sm-3">
								<input class="form-control" name="toDate" type="text" value="<?php if(isset($_POST['fromDate'])){ echo $_POST['toDate'];} ?>" id="datepicker1" autocomplete="off">
							</div>
						</div>
					
						<div class="form-group">
							<label class="col-sm-1 control-label">Order Name</label>
							<div class="col-sm-3">
								<input class="form-control" name="order_name" type="text" value="<?php if(isset($_POST['order_name'])){ echo $_POST['order_name'];} ?>" autocomplete="off">
							</div>
							
							<label class="col-sm-1 control-label">Order Satus</label>
							<div class="col-sm-3">
								<input class="form-control" name="order_status" type="text" value="<?php if(isset($_POST['order_status'])){ echo $_POST['order_status'];} ?>" autocomplete="off">
							</div>
							
							<label class="col-sm-1 control-label">Provider</label>
							<div class="col-sm-3">
								<input class="form-control" name="Provider" type="text" value="<?php if(isset($_POST['Provider'])){ echo $_POST['Provider'];} ?>" autocomplete="off">
							</div>
						</div>
					 
						<input class="btn btn-primary" type="submit" value="Search" text="Search">
					</form>
				</div>
				
				<div class="box-body">
					
					<?php if (isset($results)) { ?>
						<div class="col-sm-12" style="overflow-x: auto;">
							<table id="manageTable" class="table table-bordered table-hover" style="width: 100%;overflow-x: auto;white-space: nowrap;">
								<thead>
									<tr>
										<th>Order ID</th>
										<th>Order Name</th>
										<th>Total Amount</th>
										<th>Total Quantity</th>
										<th>Create Date</th>
										<th>Order Status</th>
										<th>Provider</th>
										<th>Charged Success Amount</th>
										<th>Finished Date</th>
										<th></th>
									</tr>
								</thead>
								
								<tbody>
									<?php foreach ($results as $data) { ?>
									<tr>
										<td><?php echo $data->order_id ?></td>
										<td><?php echo $data->order_name ?></td>
										<td style="text-align: right;"><?php echo number_format($data->order_total_amount) ?></td>
										<td style="text-align: right;"><?php echo number_format($data->order_total_quantity) ?></td>
										<td><?php echo $data->order_created_date ?></td>
										<td><?php echo $data->order_status ?></td>
										<td><?php echo $data->provider_code ?></td>
										<td style="text-align: right;"><?php echo number_format($data->charged_success_amt) ?></td>
										<td><?php echo $data->finished_date ?></td>
										<td><a href="<?php echo base_url() . 'Controller_All_Order/detail/' . $data->order_id ?>" class="btn btn-success btn-sm ad-click-event">Detail</a></td>
									</tr>
									<?php } ?>
								</tbody>
								
							</table>
						</div>
						<!--div>Total Amount: <?php echo number_format($totalAmount)?></div-->
					<?php } else { ?>
						<div>No trans(s) found.</div>
					<?php } ?>
					<?php if (isset($links)) { ?>
						<?php echo $links ?>
					<?php } ?>
				</div>
			
            </div>
        <!--/div-->
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
    $( "#datepicker" ).datepicker({ format: 'dd/mm/yyyy', todayHighlight: true, autoclose: true });
  
    $( "#datepicker1" ).datepicker({ format: 'dd/mm/yyyy', todayHighlight: true, autoclose: true });
	
	$('#manageTable').DataTable({
	  "searching": false,
	  "info": false
	});
  } );


</script>
