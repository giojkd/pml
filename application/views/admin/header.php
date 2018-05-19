<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.1
Version: 3.6
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
  <meta charset="utf-8"/>
  <title><?php if (isset($title) && $title) {
    echo $title;
  } else {
    echo "Admin Panel";
  } ?></title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <meta content="" name="description"/>
  <meta content="" name="author"/>
  <!-- BEGIN GLOBAL MANDATORY STYLES -->
  <link href="<?php echo site_url('admin_assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css'); ?>" rel="stylesheet" type="text/css"/>
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
  <link href="<?php echo site_url('admin_assets/global/plugins/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css"/>
  <link href="<?php echo site_url('admin_assets/global/plugins/simple-line-icons/simple-line-icons.min.css'); ?>" rel="stylesheet" type="text/css"/>
  <link href="<?php echo site_url('admin_assets/global/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css"/>
  <link href="<?php echo site_url('admin_assets/global/plugins/jquery-ui.css'); ?>" rel="stylesheet" type="text/css"/>
  <link href="<?php echo site_url('admin_assets/global/plugins/uniform/css/uniform.default.css'); ?>" rel="stylesheet" type="text/css"/>
  <link href="<?php echo site_url('admin_assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css'); ?>" rel="stylesheet" type="text/css"/>
  <link href="<?php echo site_url('admin_assets/global/plugins/bootstrap-toastr/toastr.min.css'); ?>" rel="stylesheet" type="text/css"/>
  <!-- <link href="<?php echo site_url('admin_assets/data-tables/DT_bootstrap.css'); ?>" rel="stylesheet" type="text/css"/> -->

  <link rel="stylesheet" href="<?php echo base_url('admin_assets/datatables/css/jquery.dataTables.min.css') ?>" />
  <link rel="stylesheet" href="<?php echo base_url('admin_assets/datatables/css/jquery.dataTables.yadcf.css') ?>" />
  <link rel="stylesheet" href="<?php echo base_url('admin_assets/datatables/css/responsive.dataTables.min.css') ?>" />

  <!-- END GLOBAL MANDATORY STYLES -->
  <!-- BEGIN THEME STYLES -->
  <link href="<?php echo site_url('admin_assets/global/css/components.css'); ?>" id="style_components" rel="stylesheet" type="text/css"/>
  <link href="<?php echo site_url('admin_assets/global/css/plugins.css'); ?>" rel="stylesheet" type="text/css"/>
  <link href="<?php echo site_url('admin_assets/layout/css/layout.css'); ?>" rel="stylesheet" type="text/css"/>
  <link id="style_color" href="<?php echo site_url('admin_assets/layout/css/themes/grey.css'); ?>" rel="stylesheet" type="text/css"/>
  <link href="<?php echo site_url('admin_assets/layout/css/custom.css'); ?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('admin_assets//fancybox/dist/jquery.fancybox.min.css'); ?>">
  <link href="<?php echo site_url('admin_assets/custom_css/uploadfile.css'); ?>" rel="stylesheet" type="text/css"/>
  <link href="<?php echo site_url('admin_assets/global/plugins/ui-dropdown/dropdown.css'); ?>" rel="stylesheet" type="text/css"/>
  <!--<link href="<?php // echo site_url('admin_assets/select-two/select2.min.css'); ?>" rel="stylesheet" type="text/css"/>-->
  <link rel="stylesheet" href="<?php echo base_url('admin_assets/custom_css/select2-3.5.css'); ?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo base_url('admin_assets/custom_css/select2-bootstrap.css'); ?>" type="text/css"/>

  <!-- <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>"> -->
  <link rel="stylesheet" href="<?php echo base_url('admin_assets/global/plugins/datetime/datetimepicker.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url(); ?>admin_assets/custom_css/admin.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>admin_assets/multiple-select/multiple-select.css">
  <link rel="stylesheet" href="<?php echo base_url('admin_assets/custom_css/momin.css'); ?>">

  <link rel="stylesheet" href="<?php echo base_url('admin_assets/custom_css/magnific-popup.css'); ?>">
  <link href="<?php echo site_url('admin_assets/global/plugins/bootstrap-datepicker/css/datepicker.css');?>" rel="stylesheet" type="text/css"/>
  <!-- END THEME STYLES -->
  <script src="<?php echo site_url('admin_assets/global/plugins/jquery.min.js'); ?>" type="text/javascript"></script>
  <script src="<?php echo site_url('admin_assets/global/plugins/bootstrap/js/bootstrap.min.js'); ?>" type="text/javascript"></script>

  <script src="<?php echo base_url('admin_assets/datatables/js/jquery.dataTables.min.js') ?>" type="text/javascript"></script>
  <script src="<?php echo base_url('admin_assets/datatables/js/jquery.dataTables.yadcf.js') ?>" type="text/javascript"></script>
  <script src="<?php echo base_url('admin_assets/datatables/js/dataTables.responsive.min.js') ?>" type="text/javascript"></script>
  <script src="<?php echo base_url('admin_assets/fancybox/dist/jquery.fancybox.min.js'); ?>" type="text/javascript"></script>


  <script type="text/javascript">
  var baseUrl = "<?php echo base_url_tr(); ?>";

  </script>

  <script src="<?php echo site_url('admin_assets/js_language/' . getLanguage() . '.js'); ?>"></script>



  <script src="<?php echo site_url('admin_assets/custom_js/bootbox.js'); ?>"></script>

  <script src="<?php echo site_url('admin_assets/custom_js/uploadfile.js'); ?>"></script>
  <script src="<?php echo site_url('admin_assets/custom_js/task_image_upload.js'); ?>"></script>
  <script src="<?php echo site_url('admin_assets/custom_js/jquery.magnific-popup.min.js'); ?>"></script>
  <script src="<?php echo site_url('admin_assets/global/plugins/ui-dropdown/dropdown.js'); ?>"></script>
  <!--<script src="<?php //echo site_url('admin_assets/select-two/select2.full.min.js'); ?>"></script>-->

  <script type="text/javascript" src="<?php echo base_url('admin_assets/custom_js/select2-3.5.min.js') ?>"></script>
  <script src="<?php echo site_url('admin_assets/global/plugins/datetime/datetimepicker.js'); ?>"></script>

  <script type="text/javascript" src="<?php echo base_url('admin_assets/multiple-select/multiple-select.js') ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('admin_assets/gmplugin/gmplugin.js');?>"></script>
  <!-- Date Picker -->
  <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>admin_assets/global/plugins/bootstrap-datepicker/css/datepicker.css"> -->
  <!-- <script src="<?php echo base_url(); ?>admin_assets/global/plugins/bootstrap-datepicker/jd/bootstrap-datepicker.js"></script> -->
  <!-- Date Picker -->


  <link rel="shortcut icon" href="favicon.ico"/>


  <script>
  $(document).ready(function() {
    $('.datatable').DataTable( {
      responsive: true
    } );
  });

  </script>
</head>




<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
<body class="page-header-fixed page-quick-sidebar-over-content">

  <style type="text/css">
  input[type="number"]::-webkit-outer-spin-button,
  input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }
  input[type="number"] {
    -moz-appearance: textfield;
  }
  </style>

  <!-- BEGIN HEADER -->
  <div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner">
      <!-- BEGIN LOGO -->
      <div class="page-logo">
        <a href="<?php echo base_url_tr('dashboard'); ?>">
          <img src="<?php echo base_url('admin_assets/img/main-logo.jpg'); ?>" alt="Ap4Rent"/>
        </a>
        <div class="menu-toggler sidebar-toggler hide">
          <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
        </div>
      </div>
      <!-- END LOGO -->
      <!-- BEGIN RESPONSIVE MENU TOGGLER -->
      <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
      </a>
      <!-- END RESPONSIVE MENU TOGGLER -->
      <!-- BEGIN TOP NAVIGATION MENU -->
      <?php
      $user_type = getUserdata('user_type');
      ?>

      <div class="top-menu">
        <ul class="nav navbar-nav pull-right">
          <?php
          if($user_type=='backend_user'){

            $payment_alert=get_delaya_payments_alert();
            ?>
            <li class="dropdown dropdown-notification">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                <span class="notification-info"><i class="fa fa-info-circle"></i>
                  <?php if(!empty($payment_alert)){?>
                    <span class="noti-count"><?php echo count($payment_alert);?></span>
                  <?php } ?>
                </span>
              </a>
              <ul class="dropdown-menu dropdown-menu-default">
                <?php if(!empty($payment_alert)){?>
                  <li>
                    <a href="#" class="text-center">You have <?php echo count($payment_alert);?> due payment alert.</a>
                    <a href="<?php echo base_url('dashboard/payment_alert_list');?>" class="text-center">See All</a>
                  </li>
                <?php }else{ ?>
                  <li>
                    <a href="">No due payment alert.</a>
                  </li>
                <?php } ?>
              </ul>
            </li>
          <?php } ?>

          <li class="dropdown dropdown-quick-sidebar-toggler">
            <?php echo language_selector(); ?>
          </li>
          <!-- BEGIN USER LOGIN DROPDOWN -->
          <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
          <?php $this->load->view('admin/login_dropdown'); ?>
          <!-- END USER LOGIN DROPDOWN -->
          <!-- BEGIN QUICK SIDEBAR TOGGLER -->
          <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
          <li class="dropdown dropdown-quick-sidebar-toggler">
            <a href="<?php echo base_url_tr('authentication/logout'); ?>" class="dropdown-toggle">
              <i class="icon-logout"></i>
            </a>
          </li>
          <!-- END QUICK SIDEBAR TOGGLER -->
        </ul>
      </div>


      <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
  </div>
  <!-- END HEADER -->
  <div class="clearfix">
  </div>
  <!-- BEGIN CONTAINER -->
  <div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php
    $user_type = getUserdata('user_type');
    if($user_type!=''){
      $this->load->view('admin/sidebar/'.$user_type);
    } ?>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
      <div class="page-content">


        <!-- BEGIN PAGE HEADER-->
        <h3 class="page-title">
          <?php if (isset($page_title) && $page_title) {
            echo $page_title;
          } ?>
        </h3>
        <div class="page-bar">
          <ul class="page-breadcrumb">
            <li>
              <i class="fa fa-home"></i>
              <a href="<?php echo base_url_tr(); ?>">Home</a>
              <i class="fa fa-angle-right"></i>
            </li>
            <?php breadCrumb(); ?>
          </ul>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->

        <script type="text/javascript">
        $('ul.dropdown-menu.stopPropagation').on('click', function (event) {
          // The event won't be propagated up to the document NODE and
          // therefore delegated events won't be fired
          event.stopPropagation();
        });
        </script>
