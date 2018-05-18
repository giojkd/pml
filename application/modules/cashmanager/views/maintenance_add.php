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
          <?php if (validation_errors()): ?>
            <div class="alert alert-danger" style="color: #b42020">
              <button class="close" data-dismiss="alert" type="button">x</button>
              <?php echo validation_errors(); ?>
            </div>
          <?php endif; ?>
          <!-- BEGIN FORM-->
          <form class="item_add_form" action="<?php echo site_url() ?>cashmanager/outgoing/save_maintenance" method="post">
            <div class="form-body col-xs-12">
              <div class="form-group">
                <label class="control-label">Property</label>
                <select name="apartment_id" id="apartment_id" class="form-control" required>
                  <option value="">..Select..</option>
                  <?php foreach($apartments as $value) {?>
                    <option value="<?php echo $value["id"]; ?>"><?php echo $value["id"]." (".$value["address"].")"; ?></option>
                  <?php } ?>
                </select>
              </div>

              <div class="form-group">
                <label class="control-label"><?php echo lang('cleaning_area'); ?></label>
                <div class="controls">
                  <div class="chosen-container">

                    <select name="room_id" id="room_list" class="form-control" data-placeholder="Select Room" tabindex="1">

                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label">Job Description</label>
                <input type="text" name="maintenance_description" value="<?php echo set_value("job_description"); ?>" class="form-control"/>
              </div>

              <div class="form-group">
                <label class="control-label">Reported Date</label>
                <input type="text" name="maintenance_reported_date" id="reported_date" class="form-control" required />
              </div>

              <div class="form-group">
                <label class="control-label">Reported by</label>
                <input type="text" name="maintenance_reported_by" value="<?php echo set_value("reported_by"); ?>" class="form-control"/>
              </div>

              <div class="form-group">
                <label class="control-label">Comments</label>
                <input type="text" name="maintenance_comments" value="<?php echo set_value("comments"); ?>" class="form-control"/>
              </div>

              <div class="form-group">
                <label class="control-label">Who is responsible</label>
                <input type="text" name="maintenance_responsible" value="<?php echo set_value("who_is_responsible"); ?>" class="form-control"/>
              </div>

              <div class="form-group">
                <div id="attachmentFileUpload">Upload</div>
                <div id="uploadedContractFiles"></div>
              </div>

              <div class="form-actions">
                <button type="submit" class="btn blue"><i class="icon-ok"></i> <?php echo lang('btn_save'); ?></button>
                <a href="<?php echo base_url_tr() ?>cashmanager/outgoing/oc_list" class="btn btn-danger"><i class="icon-remove"></i> <?php echo lang('btn_cancel'); ?></a>
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
$(document).ready(function() {

  $("#attachmentFileUpload").uploadFile({
    url: baseUrl + "apartment/apartment_photo_upload/",
    allowedTypes: "gif,jpg,png,jpeg",
    fileName: "myfile",
    // autoSubmit: true,
    // showStatusAfterSuccess: false,
    // sequential: true,
    // sequentialCount: 1,
    showPreview: true,
    dragDrop: true,
    previewHeight: "100px",
    previewWidth: "100px",
    showDelete: true,
    extraHTML:function()
    {
      var html = "<div><b>Attachment Title:</b><input type='text' name='attachment_title' class='form-control'/> <br/>";
      html += "</div>";
      return html;
    },
    onSuccess: function (files, data, xhr) {
      //$("#complaint").val("1");
      console.log(data);
      var info = JSON.parse(data);
      // var orig_name = info.upload_data.orig_name;
      // console.log(orig_name);

      $("#uploadedContractFiles").append('<input type="hidden" name="file_name" value="'+info.upload_data.file_name+'">');
      // var image = '<a href="' + baseUrl + "uploads/feedback_file/" + info.upload_data.file_name + '"></a>';
      // $(".gallery").append(image);
    },
    deleteCallback: function(files, data, xhr){
      var file_info = JSON.parse(files);
      $('input[value="'+file_info['fileName']+'"').remove();
    }
  });


  //$('#employer_user_id').multipleSelect();
  $("#tenant_area").hide();
  $("#employer_area").hide();
  $("#owner_area").hide();
  //$('#room').select2();

  $('#reported_date ').datetimepicker({
    datepicker: true,
    timepicker: false,
    format: 'd-m-Y',
    mask: false,
    scrollMonth : false,
    scrollInput : false
  });

  $('#payment_date').datetimepicker({
    datepicker: true,
    timepicker: false,
    format: 'd-m-Y',
    mask: false,
    scrollMonth : false,
    scrollInput : false
  });

  $('#expired_date').datetimepicker({
    datepicker: true,
    timepicker: false,
    format: 'd-m-Y',
    mask: false,
    scrollMonth : false,
    scrollInput : false
  });

  $('#owner_expired_date').datetimepicker({
    datepicker: true,
    timepicker: false,
    format: 'd-m-Y',
    mask: false,
    scrollMonth : false,
    scrollInput : false
  });

  $("#supplier_invoice_date").datetimepicker({
    datepicker: true,
    timepicker: false,
    format: 'd-m-Y',
    scrollMonth : false,
    scrollInput : false
  });

  $("#apartment_id").on("change", function () {
    var apartment_id = $(this).val();
    //alert(apartment_id);exit;
    if (apartment_id) {
      $("#room","#room_list").html("");
      // $("#who_pay").html("");
      $.ajax({
        url: "<?php echo base_url_tr('cleaning/get_room_dropdown'); ?>",
        type: "post",
        data: {apartment_id: apartment_id},
        success: function (result) {

          var result = JSON.parse(result);
          console.log(result);
          var rooms = result.rooms;

          var room_dropdown_list = "";
          var room_dropdown = '<option value="">All Appartment</option>'
          +'<option value="0">Common Area</option>';
          for(var i = 0; i < rooms.length; i++)
          {
            room_dropdown_list += '<option value="'+rooms[i]['id']+'">'+rooms[i]['id']+'</option>';

          }
          $("#room").append(room_dropdown+room_dropdown_list);
          $("#room_list").append(room_dropdown+room_dropdown_list);




        }
      })
    }
  });



  $("#room").on("change",function(){
    var ids = $(this).val();
    $.ajax({
      url: baseUrl + "cashmanager/outgoing/ajax_get_apartment_all_tenant",
      data: {
        rooms_id : ids
      },
      type: "POST",
      dataType: 'json',
      success: function(result){
        var html = '';
        $.each(result, function(key, value){
          html += '<option value="'+value['id']+'">'+value['name']+' '+value['family_name']+'</option>';
        });
        $("#tenant_user_id").html(html).select2();
      }
    });
  });

  $("#related_to").on("change",function(){
    var x = $(this).val();
    var y = $("#apartment_id").val();
    if(x=="1")
    {
      $('#to_tenant').prop('checked', false).parents('span').removeClass('checked'); // Unchecks it
      $("#owner_area").show();
      $("#tenant_area").hide();
      $("#tenant_checkbox").hide();

    }
    else{
      $("#owner_area").hide();
      var ap_id = $("#apartment_id").val();
      if(ap_id == "0")
      {
        $('#to_tenant').prop('checked', false).parents('span').removeClass('checked'); // Unchecks it
        $("#tenant_area").hide();
        $("#tenant_checkbox").hide();
      }
      else{
        $("#owner_area").hide();
        $("#tenant_area").hide();
        $("#tenant_checkbox").show();
      }

    }
    if((x=="4") && (y=="0")){
      $("#employer_area").show();
      $('#employer_user_id').multipleSelect();
    }
    else {
      $("#employer_area").hide();
    }
  });

  $('#to_tenant').change(function() {
    if(this.checked) {
      $('#to_owner').prop('checked',false).change().parent('span').removeClass('checked');
      $("#tenant_area").show();
    }else{
      $("#tenant_area").hide();
    }
  });

  $('#to_owner').change(function() {
    if(this.checked) {
      $('#to_tenant').prop('checked',false).change().parent('span').removeClass('checked');
      $("#owner_area").show();
    }else{
      $("#owner_area").hide();
    }
  });

});
</script>
