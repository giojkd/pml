<div class="clearfix"></div>

			<!-- END PAGE CONTENT-->
		</div>
	</div>
	<!-- END CONTENT -->
	<!-- BEGIN QUICK SIDEBAR -->

	<!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="page-footer-inner">
		 <?php echo getSettingSingle('copywrite_text'); ?>
	</div>
	<div class="scroll-to-top">
		<i class="icon-arrow-up"></i>
	</div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="../../assets/global/plugins/respond.min.js"></script>
<script src="../../assets/global/plugins/excanvas.min.js"></script>
<![endif]-->

<script src="<?php echo site_url('admin_assets/global/plugins/jquery-migrate.min.js');?>" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo site_url('admin_assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js');?>" type="text/javascript"></script>
<!-- <script src="<?php echo site_url('admin_assets/global/plugins/bootstrap/js/bootstrap.min.js');?>" type="text/javascript"></script> -->
<script src="<?php echo site_url('admin_assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js');?>" type="text/javascript"></script>
<script src="<?php echo site_url('admin_assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js');?>" type="text/javascript"></script>
<script src="<?php echo site_url('admin_assets/global/plugins/jquery.blockui.min.js');?>" type="text/javascript"></script>
<script src="<?php echo site_url('admin_assets/global/plugins/jquery.cokie.min.js');?>" type="text/javascript"></script>
<script src="<?php echo site_url('admin_assets/global/plugins/uniform/jquery.uniform.min.js');?>" type="text/javascript"></script>
<script src="<?php echo site_url('admin_assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js');?>" type="text/javascript"></script>
<script src="<?php echo site_url('admin_assets/global/plugins/jquery-validation/js/jquery.validate.min.js');?>" type="text/javascript"></script>
<script src="<?php echo site_url('admin_assets/global/plugins/bootstrap-toastr/toastr.min.js');?>" type="text/javascript"></script>
<script src="<?php echo site_url('admin_assets/global/plugins/bootbox/bootbox.min.js');?>" type="text/javascript"></script>
<script src="<?php echo site_url('admin_assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js');?>" type="text/javascript"></script>
<script src="<?php echo site_url('admin_assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js');?>" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<script src="<?php echo site_url('admin_assets/global/scripts/metronic.js');?>" type="text/javascript"></script>
<script src="<?php echo site_url('admin_assets/layout/scripts/layout.js');?>" type="text/javascript"></script>
<script src="<?php echo site_url('admin_assets/layout/scripts/quick-sidebar.js');?>" type="text/javascript"></script>
<script src="<?php echo site_url('admin_assets/layout/scripts/demo.js');?>" type="text/javascript"></script>
<script src="<?php echo site_url('admin_assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js');?>" type="text/javascript"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAFUh9RdWMgjRnmzuy4dtNZMCK9eEofnM0&libraries=places&callback=initMap"></script>
<!-- <script src="<?php echo site_url('assets/js/sweetalert.min.js');?>" type="text/javascript"></script> -->




<script src="<?php echo site_url('admin_assets/custom_js/common.js');?>"></script>



<script>
      jQuery(document).ready(function() {
          $(':input[type=number]').on('mousewheel',function(e){ $(this).blur(); });
          $(':input[type=text]').on('mousewheel',function(e){ return false; });

           var pgurl = window.location.href;
     $(".page-sidebar-menu ul li a").each(function(){

          if($(this).attr("href") == pgurl || $(this).attr("href") == '' ){
              $(this).parent('li').addClass("active");
              $(this).parent('li').parents('li').addClass("open");
              $(this).parent('li').parents('ul.sub-menu').css("display","block");
          }

     });
     
     $('.date-own').datepicker({
         minViewMode: 2,
         format: 'yyyy',
         autoclose: true
       });

     $('.date-month').datepicker({
         minViewMode: 1,
         format: 'yyyy/mm',
         autoclose: true
     });

     $('.richeditor').wysihtml5();

         Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features

<?php if($this->session->flashdata('alertmsg')){ ?>

toastr['<?php echo $this->session->flashdata('alertType');?>']("", "<?php echo $this->session->flashdata('alertmsg');?>");


            <?php } ?>

      });

			///////////////////////////for success or error message///////////////////////////
	    <?php if($this->session->flashdata('flash_message')){ ?>
	      swal({
	            title: "<?php echo $this->session->flashdata('flash_title'); ?>",
	            type: "<?php echo $this->session->flashdata('flash_type'); ?>",
	            text: "<?php echo strip_tags($this->session->flashdata('flash_message_text'));?>"
	          });
	    <?php } ?>
   </script>
   
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
