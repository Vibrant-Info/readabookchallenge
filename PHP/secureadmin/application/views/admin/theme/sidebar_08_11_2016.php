<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->  
  
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header text-right"><?php echo $this->config->item('product_name').' '.$this->config->item('product_version'); ?></li>
      
      <li><a href="<?php echo site_url()."admin/dash_board"; ?>"><i class="fa fa-tachometer"></i><span><?php echo $this->lang->line('dashboard');?></span></a></li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-bell"></i>
          <span><?php echo $this->lang->line('Librarian Section');?></span>
          <i class="fa fa-angle-left pull-right"></i>
        </a> 
        <ul class="treeview-menu">
          <li><a href="<?php echo site_url()."librarian/assigning"; ?>"><i class="fa fa-list-alt"></i> <span><?php echo $this->lang->line('assigning');?></span></a></li>
          <li><a href="<?php echo site_url()."librarian/packaging"; ?>"><i class="fa fa-envelope"></i> <span><?php echo $this->lang->line('packaging');?></span></a></li>
          <li><a href="<?php echo site_url()."librarian/labeling"; ?>"><i class="fa fa-motorcycle"></i> <span> <?php echo $this->lang->line('labeling & Delivery');?></span></a></li>
        </ul>
      </li>
     <!-- <li><a href="<?php echo site_url()."admin_config"; ?>"><i class="fa fa-cogs"></i><span><?php echo $this->lang->line('general settings');?></span></a></li>-->
      
      <li class="treeview">
        <a href="#">
          <i class="fa fa-book"></i>
          <span><?php echo $this->lang->line('book');?></span>
          <i class="fa fa-angle-left pull-right"></i>
        </a> 
        <ul class="treeview-menu">
          <li><a href="<?php echo site_url()."admin/config_category"; ?>"><i class="fa fa-list-ol"></i> <span><?php echo $this->lang->line('book categories');?></span></a></li>
          <li><a href="<?php echo site_url()."admin/book_list"; ?>"><i class="fa fa-book"></i> <span><?php echo $this->lang->line('book');?></span></a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-list"></i>
          <span><?php echo $this->lang->line('Orders');?></span>
          <i class="fa fa-angle-left pull-right"></i>
        </a> 
        <ul class="treeview-menu">
          <li><a href="<?php echo site_url()."librarian/openOrders"; ?>"><i class="fa fa-list-ol"></i> <span><?php echo $this->lang->line('Open Orders');?></span></a></li>
          <li><a href="<?php echo site_url()."librarian/closeOrders"; ?>"><i class="fa fa-check"></i> <span><?php echo $this->lang->line('Closed Orders');?></span></a></li>
          <li><a href="<?php echo site_url()."librarian/dueOrders"; ?>"><i class="fa fa-calendar"></i> <span><?php echo $this->lang->line('Due Orders');?></span></a></li>
        </ul>
      </li>
	  <li><a href="<?php echo site_url()."admin/vendor_list"; ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('Vendors');?></span></a></li>
	
		<li><a href="<?php echo site_url()."admin/site_users"; ?>"><i class="fa fa-group"></i> <span><?php echo $this->lang->line('Site Users');?></span></a></li>
      <!--<li class="treeview">
        <a href="#">
          <i class="fa fa-user"></i>
          <span><?php echo $this->lang->line('member');?></span>
          <i class="fa fa-angle-left pull-right"></i>
        </a> 
        <ul class="treeview-menu">
          <li><a href="<?php echo site_url()."admin/config_member_type"; ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('member types');?></span></a></li>
          <li><a href="<?php echo site_url()."admin/config_member"; ?>"><i class="fa fa-group"></i> <span><?php echo $this->lang->line('member');?></span></a></li>
          <li><a href="<?php echo site_url()."admin/generate_id"; ?>"><i class="fa fa-credit-card"></i> <span><?php echo $this->lang->line('generate member ID');?></span></a></li>
        </ul>
      </li> -->

      
	<!--	<li><a href="<?php echo site_url()."admin/circulation"; ?>"><i class="fa fa-exchange"></i> <span><?php echo $this->lang->line('issue & return');?></span></a></li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-retweet"></i>
          <span><?php echo $this->lang->line('circulation');?></span>
          <i class="fa fa-angle-left pull-right"></i>
        </a> 
        <ul class="treeview-menu">          
           <li><a href="<?php echo site_url()."admin/config_circulation"; ?>"><i class="fa fa-cog"></i><span><?php echo $this->lang->line('circulation settings');?></span></a></li>
           <li><a href="<?php echo site_url()."admin/circulation"; ?>"><i class="fa fa-exchange"></i> <span><?php echo $this->lang->line('issue & return');?></span></a></li>
        </ul>
      </li> 

      <li class="treeview">
        <a href="#">
          <i class="fa fa-bell"></i>
          <span><?php echo $this->lang->line('notification');?></span>
          <i class="fa fa-angle-left pull-right"></i>
        </a> 
        <ul class="treeview-menu">
          <li><a href="<?php echo site_url()."admin_config_sms/index"; ?>"><i class="fa fa-envelope"></i> <span><?php echo $this->lang->line('SMS settings');?></span></a></li>
          <li><a href="<?php echo site_url()."admin_config_email/index"; ?>"><i class="fa fa-envelope-o"></i> <span><?php echo $this->lang->line('email SMTP settings');?></span></a></li>
          <li><a href="<?php echo site_url()."reminder/index"; ?>"><i class="fa fa-clock-o"></i> <span> <?php echo $this->lang->line('notify delayed members');?></span></a></li>
        </ul>
      </li>
      -->

      <!--<li><a href="<?php echo site_url()."admin/daily_read_material"; ?>"><i class="fa fa-folder-open"></i> <span><?php echo $this->lang->line('daily read books');?></span></a></li>-->      
		
		<li class="treeview">
        <a href="#">
          <i class="fa fa-inbox"></i>
          <span><?php echo $this->lang->line('Requests');?></span>
          <i class="fa fa-angle-left pull-right"></i>
        </a> 
        <ul class="treeview-menu">
          <li><a href="<?php echo site_url()."admin/requested_books"; ?>"><i class="fa  fa-book"></i> <span><?php echo $this->lang->line('requested books');?></span></a></li>
          <li><a href="<?php echo site_url()."admin/requested_amount"; ?>"><i class="fa  fa-money"></i> <span><?php echo $this->lang->line('Withdraw requests');?></span></a></li>         
        </ul>
      </li>

      <!--<li class="treeview">
        <a href="#">
          <i class="fa fa-file-pdf-o"></i>
          <span><?php echo $this->lang->line('Report');?></span>
          <i class="fa fa-angle-left pull-right"></i>
        </a> 
        <ul class="treeview-menu">
          <li><a href="<?php echo site_url()."report/index"; ?>"><i class="fa fa-money"></i> <span><?php echo $this->lang->line('fine report');?></span></a></li>
          <li><a href="<?php echo site_url()."report/notification_report"; ?>"><i class="fa fa-envelope-o"></i> <span><?php echo $this->lang->line('notification report');?></span></a></li>         
        </ul>
      </li>-->
	    <li><a href="<?php echo site_url()."admin/delivery_area"; ?>"><i class="fa fa-truck"></i> <span><?php echo $this->lang->line('Deliery Area');?></span></a></li> 
		<li><a href="<?php echo site_url()."admin/logs_wallet"; ?>"><i class="fa fa-history"></i> <span><?php echo $this->lang->line('Wallet Logs');?></span></a></li>
		<li><a href="<?php echo site_url()."admin/update_bookstock"; ?>"><i class="fa fa-barcode"></i> <span><?php echo $this->lang->line('Book Stock Update');?></span></a></li>

    </ul>
  </section>
  <!-- /.sidebar -->
</aside>