<div class="page-sidebar-wrapper">
  <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
  <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
  <div class="page-sidebar navbar-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->
    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <ul class="page-sidebar-menu text-capitalize" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
      <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
      <li class="sidebar-toggler-wrapper">
        <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
        <div class="sidebar-toggler">
        </div>
        <!-- END SIDEBAR TOGGLER BUTTON -->
      </li>

      <li class="start">
        <a href="<?php echo base_url_tr('dashboard'); ?>">
          <i class="icon-home"></i>
          <span class="title"><?php echo lang('dashboard'); ?></span>
        </a>
      </li>
      <?php $user_type = getUserdata('user_type'); ?>

      <li>
        <a href="javascript:;">
          <i class="icon-user"></i>
          <span class="title">Occupant / Owners</span>
          <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
          <li><a href="<?php echo base_url_tr('user/tenant'); ?>"><i class="icon-list"></i> Show Occupant list</a></li>
          <li><a href="<?php echo base_url_tr('user/owner'); ?>"><i class="icon-list"></i> Show Owner List</a></li>
          <!--  <li><a href="<?php echo base_url_tr('user/add_tenant'); ?>"><i class="icon-plus"></i> Add Occupant</a></li>
          <li><a href="<?php echo base_url_tr('user/add_owner'); ?>"><i class="icon-plus"></i> Add Owner</a></li>-->
        </ul>
      </li>

      <li>
        <a href="javascript:;">
          <i class="icon-user"></i>
          <span class="title">Suppliers</span>
          <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
          <li><a href="<?php echo base_url_tr('supplier'); ?>"><i class="icon-list"></i> Show List</a></li>
          <li><a href="<?php echo base_url_tr('supplier/create'); ?>"><i class="icon-plus"></i> Add Supplier</a></li>
        </ul>
      </li>

      <li>
        <a href="javascript:;">
          <i class="icon-users"></i>
          <span class="title">Apartment Management</span>
          <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
          <li><a href="<?php echo base_url_tr('apartment/add'); ?>"><i class="icon-plus"></i> Add Apartment </a></li>
          <li><a href="<?php echo base_url_tr('apartment'); ?>"><i class="icon-list"></i> Apartment List</a></li>
          
          
        </ul>
      </li>

      <li>
        <a href="javascript:;">
          <i class="icon-basket"></i>
          <span class="title">Booking</span>
          <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
          <li style="display: none;"><a href="<?php echo base_url_tr('apartment/calendar/calendar_view'); ?>"><i class="icon-calendar"></i> Calendar 1</a></li>
          <li><a href="<?php echo base_url_tr('apartment/calendar/newc'); ?>"><i class="icon-calendar"></i> Calendar</a></li>
          <li><a href="<?php echo base_url_tr('apartment/booking_list'); ?>"><i class="icon-list"></i> Booking</a></li>
          <li><a href="<?php echo base_url_tr('apartment/add_booking'); ?>"><i class="icon-plus"></i> Add New</a></li>
          <li><a href="<?php echo base_url_tr('apartment/renewal_list'); ?>"><i class="icon-list"></i> Renewal</a></li>
        </ul>
      </li>

      <li>
        <a href="javascript:;">
          <i class="fa fa-list"></i>
          <span class="title">Cleaning</span>
          <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
          <li><a href="<?php echo base_url_tr('cleaning/add'); ?>"><i class="icon-plus"></i> Add Cleaning</a></li>
          <li><a href="<?php echo base_url_tr('cleaning'); ?>"><i class="icon-list"></i> Cleaning List</a></li>
        </ul>
      </li>

      <li>
        <a href="javascript:;">
          <i class="fa fa-list"></i>
          <span class="title">Maintenance</span>
          <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
          <li><a href="<?php echo base_url_tr('cashmanager/outgoing/maintenance_add'); ?>"><i class="icon-plus"></i> Add Maintenance</a></li>
          <li><a href="<?php echo base_url_tr('cashmanager/outgoing/maintenance_list'); ?>"><i class="icon-list"></i> Maintenance List</a></li>
          <!--<li><a href="<?php echo base_url_tr('cashmanager/outgoing/oc_list_sent'); ?>"><i class="icon-list"></i> Past Maintenance Jobs</a></li>-->
        </ul>
      </li>

      <li>
        <a href="javascript:;">
          <i class="icon-social-dropbox"></i>
          <span class="title">Stock Manager</span>
          <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
          <!--                        <li><a href="<?php //echo base_url_tr('stock/item_list'); ?>"><i class="icon-list"></i> Item List</a></li>-->
          <li><a href="<?php echo base_url_tr('stock/external_item_list'); ?>"><i class="icon-list"></i> External Stock</a></li>
          <li><a href="<?php echo base_url_tr('stock/apartment_item_list'); ?>"><i class="icon-list"></i> Apartment Stock</a></li>
        </ul>
      </li>

      <li>
        <a href="javascript:;">
          <i class="fa fa-university"></i>
          <span class="title">Check IN/OUT</span>
          <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
          <li><a href="<?php echo base_url_tr('apartment/check_in'); ?>"><i class="icon-list"></i> Check IN</a></li>
          <li><a href="<?php echo base_url_tr('apartment/check_out'); ?>"><i class="icon-list"></i> Check OUT</a></li>
        </ul>
      </li>
      
      <li>
        <a href="javascript:;">
          <i class="glyphicon glyphicon-wrench"></i>
          <span class="title"><?php echo lang('setting'); ?></span>
          <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
          <li><a href="<?php echo base_url_tr('settings/email_settings'); ?>"><i class="icon-envelope"></i> <?php echo lang('email_setting'); ?></a></li>
          <li><a href="<?php echo base_url_tr('settings/site_settings'); ?>"><i class="icon-settings"></i> <?php echo lang('site_setting'); ?></a></li>
        </ul>
      </li>
    </ul>
    <!-- END SIDEBAR MENU -->
  </div>
</div>
