
 
  <header class="main-header">
    <!-- Logo -->
    
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <!--a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a-->
		
		<div class="container">
			
			<div class="navbar-header">
			  <a href="" class="navbar-brand" ><b>Merchant</b></a>
			  <!--button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
				<i class="fa fa-bars"></i>
			  </button-->
			</div>
			
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
			  <ul class="nav navbar-nav">
				<li ><a href="<?php echo base_url('dashboard') ?>">Dashboard</a></li>
				<li ><a href="<?php echo base_url('Controller_Scratch_Card') ?>">Scratch Card</a></li>
				
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Transaction <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="<?php echo base_url('Controller_Partner_Transaction/') ?>">Total Transaction</a></li>
						<li><a href="<?php echo base_url('Controller_transaction/') ?>">Transaction</a></li>
						<li><a href="<?php echo base_url('Controller_Total_Transaction/') ?>">Tổng hợp giao dịch</a></li>
					</ul>
				</li>
				<li ><a href="<?php echo base_url('Controller_All_Order/') ?>">Order Manage</a></li>
			  </ul>
			</div>
			<!-- /.navbar-collapse -->
			
			<!-- Navbar Right Menu -->
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<li class="dropdown user user-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<!-- The user image in the navbar-->
							<i class="fa fa-fw fa-user"></i>
							<!-- hidden-xs hides the username on small devices so only the image appears. -->
							<span class="hidden-xs"><?php echo (!empty($merchant_name)) ? $merchant_name : ''; ?></span>
							<i class="fa fa-fw fa-caret-down"></i>
						</a>
						<ul class="dropdown-menu">
							<!--li class="user-header">
							</li>
							<li class="user-body">
							</li-->
							<li class="user-footer">
								<div class="pull-left">
									<a href="<?php echo base_url('Controller_Change_Pass/') ?>" class="btn btn-default btn-flat">Change password</a>
								</div>
								<div class="pull-right">
									<a href="<?php echo base_url('auth/logout') ?>" class="btn btn-default btn-flat">Logout</a>
								</div>
							</li>
						</ul>
					</li>
				</ul>
			</div>
			<!-- /.navbar-custom-menu -->
		  </div>
		  <!-- /.container-fluid -->
		
    
    </nav>
  </header>