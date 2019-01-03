
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        
        <li id="dashboardMainMenu">
          <a href="<?php echo base_url('dashboard') ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li id="dashboardMainMenu">
          <a href="<?php echo base_url('Controller_Scratch_Card') ?>">
            <i class="fa fa-dashboard"></i> <span>Scratch Card</span>
          </a>
        </li>
        <li id="brandNav">
              <a href="<?php echo base_url('Controller_Partner_Transaction/') ?>">
                <i class="fa fa-cart-arrow-down"></i> <span>Total Transaction</span>
              </a>
            </li>
        <li id="brandNav">
              <a href="<?php echo base_url('Controller_transaction/') ?>">
                <i class="fa fa-cart-arrow-down"></i> <span>Transaction</span>
              </a>
            </li>
            <li id="brandNav">
              <a href="<?php echo base_url('Controller_Change_Pass/') ?>">
                <i class="fa fa-cart-arrow-down"></i> <span>Change password</span>
              </a>

              
            </li>

            
        <!-- user permission info -->
        <li><a href="<?php echo base_url('auth/logout') ?>"><i class="glyphicon glyphicon-log-out"></i> <span>Logout</span></a></li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>