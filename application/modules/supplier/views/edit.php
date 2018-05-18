
<!-- BEGIN PAGE CONTENT-->
<div class="row">
  <div class="col-md-12">
    <div class="tabbable tabbable-custom boxless">
      <!---start form -->
      <div class="portlet box blue ">

        <div class="portlet-title">
          <div class="caption">
            <i class="fa fa-user"></i><?php echo $title; ?>
          </div>
          <div class="tools">
            <a href="javascript:;" class="collapse">
            </a>
            <a href="#portlet-config" data-toggle="modal" class="config">
            </a>
            <a href="javascript:;" class="reload">
            </a>
            <a href="javascript:;" class="remove">
            </a>
          </div>
        </div>
        <div class="portlet-body form">
          <div class="validation_errors">
            <?php if (validation_errors()): ?>
              <div class="alert alert-danger" style="color: #b42020">
                <button class="close" data-dismiss="alert" type="button">x</button>
                <?php echo validation_errors(); ?>
              </div>
            <?php endif; ?>
          </div>
          <!-- BEGIN FORM-->
          <form class="tenant_add_request_form" action="<?php echo site_url() ?>supplier/update" method="post" >
            <div class="form-body col-xs-12">

              <div class="form-group">
                <label class="control-label">Company</label>
                <input type="text" class="form-control" value="<?php echo set_value('company',$supplier['company'])?>" name="company" required>
              </div>

              <div class="form-group">
                <label class="control-label">Name</label>
                <input type="text" class="form-control" value="<?php echo set_value('name',$supplier['name'])?>" name="name">
              </div>

              <div class="form-group">
                <label class="control-label">Surname</label>
                <input type="text" class="form-control" value="<?php echo set_value('surname',$supplier['surname'])?>" name="surname">
              </div>

              <div class="form-group">
                <label class="control-label">Vat no.</label>
                <input type="text" class="form-control" value="<?php echo set_value('vat_no',$supplier['vat_no'])?>" name="vat_no">
              </div>

              <div class="form-group">
                <label class="control-label">Address</label>
                <input type="text" class="form-control" value="<?php echo set_value('address',$supplier['address'])?>" name="address">
              </div>

              <div class="form-group">
                <label class="control-label">Telephone</label>
                <input value="<?php echo set_value('supplier_telephone',$supplier['supplier_telephone'])?>" type="text" class="form-control" name="supplier_telephone">
              </div>

              <div class="form-group">
                <label class="control-label">Email</label>
                <input  value="<?php echo set_value('supplier_email',$supplier['supplier_email'])?>" type="text" class="form-control" name="supplier_email">
              </div>

              <div class="form-group" >
                <label class="control-label">Type</label>
                <select class="form-control" required name="supplier_type">
                  <option value="">Choose...</option>
                  <option <?php echo ($supplier['supplier_type']=='Plumber') ? 'selected' : ''  ?> value="Plumber">Plumber</option>
                  <option <?php echo ($supplier['supplier_type']=='Electrician') ? 'selected' : ''  ?> value="Electrician">Electrician</option>
                  <option <?php echo ($supplier['supplier_type']=='Painter') ? 'selected' : ''  ?> value="Painter">Painter</option>
                </select>
              </div>

              <div class="form-group">
                <label class="control-label">Note</label>
                <textarea class="form-control" name="notes"><?php echo $supplier['notes']?></textarea>
              </div>

              <div class="form-actions">
                <button type="submit" class="btn blue"><i class="icon-ok"></i> <?php echo lang('btn_save') ?></button>
                <a href="<?php echo base_url_tr() ?>supplier" class="btn btn-danger"><i class="icon-remove"></i> <?php echo lang('btn_cancel') ?></a>
                <input type="hidden" name="supplier_id" value="<?php echo $supplier['id']?>">
              </div>
            </div>
          </form>
          <!-- END FORM-->
          <div class="clearfix"></div>
        </div>
      </div>
      <!---end form -->
    </div>
  </div>
</div>
<!-- END PAGE CONTENT-->


<script>
$(document).ready(function () {
  $("#county_code").on("change", function () {
    var county_code = $(this).val();

    if (county_code) {
      $.ajax({
        url: "<?php echo base_url_tr('supplier/get_city_dropdown'); ?>",
        type: "post",
        data: {county_code: county_code},
        beforeSend:function(){
          $('#city_code').prepend($('<option value=""></option>').html('Loading...'));
        },
        success: function (result) {
          $("#city_code").html(result);
        }
      });
    }
  });
});
</script>
