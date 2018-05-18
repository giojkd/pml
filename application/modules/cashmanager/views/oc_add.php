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
          <form class="item_add_form" action="<?php echo site_url() ?>cashmanager/outgoing/oc_add_save" method="post">
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
                <input type="text" name="job_description" value="<?php echo set_value("job_description"); ?>" class="form-control"/>
              </div>

              <div class="form-group">
                <label class="control-label">Reported Date</label>
                <input type="text" name="reported_date" id="reported_date" class="form-control" required />
              </div>

              <div class="form-group">
                <label class="control-label">Reported by</label>
                <input type="text" name="reported_by" value="<?php echo set_value("reported_by"); ?>" class="form-control"/>
              </div>

              <div class="form-group">
                <label class="control-label">Comments</label>
                <input type="text" name="comments" value="<?php echo set_value("comments"); ?>" class="form-control"/>
              </div>

              <div class="form-group">
                <label class="control-label">Who is responsible</label>
                <input type="text" name="who_is_responsible" value="<?php echo set_value("who_is_responsible"); ?>" class="form-control"/>
              </div>

              <div class="form-group">
                <label class="control-label">Internal PML</label><br />
                <label><input type="radio" name="internal_pml" value="Yes" class="form-control" /> Yes</label>
                <label><input type="radio" name="internal_pml" value="No" class="form-control" /> No</label>
              </div>

              <div class="form-group" style="display: none;">
                <label class="control-label">Related to</label>
                <select name="related_to" id="related_to" class="form-control">
                  <option value="">..Select..</option>
                  <?php foreach($related_to as $key=>$val) {?>
                    <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                  <?php } ?>
                </select>
              </div>

              <div class="form-group" id="employer_area" style="display: none;">
                <label class="control-label">Employer</label>
                <select name="employer_user_id[]" id="employer_user_id" class="form-control" multiple="multiple" style="display: none;">
                  <?php foreach($employers as $value) {?>
                    <option value="<?php echo $value["id"]; ?>"><?php echo $value["name"]; ?></option>
                  <?php } ?>
                </select>
              </div>

              <div class="form-group general_cost_form_element">
                <label class="control-label">Supplier</label>
                <div class="controls">
                  <div class="chosen-container">
                    <select name="supplier_id" id="supplier_id" class="form-control">
                      <option value="">... Select ...</option>
                      <?php foreach ($suppliers as $value): ?>
                        <option <?php echo set_select('supplier_id',$value["id"]); ?> value="<?php echo $value["id"]; ?>"><?php echo $value["name"]." ".$value["surname"].' ('.$value["company"].') '; ?></option>
                      <?php endforeach;?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group general_cost_form_element">
                <label class="control-label">Supplier Invoice Amount</label>
                <input type="text" name="supplier_invoice_amount" id="supplier_invoice_amount" value="<?php echo set_value('supplier_invoice_amount');?>" class="form-control"/>
              </div>

              <div class="form-group general_cost_form_element">
                <label class="control-label">Supplier Invoice date</label>
                <input type="text" name="supplier_invoice_date" id="supplier_invoice_date" value="<?php echo set_value('supplier_invoice_date');?>" class="form-control"/>
              </div>

              <div class="form-group general_cost_form_element">
                <label class="control-label">Supplier Invoice number</label>
                <input type="text" name="supplier_invoice_number" value="<?php echo set_value('supplier_invoice_number');?>" class="form-control"/>
              </div>

              <div class="form-group">
                <label class="control-label">Payment Due Date</label>
                <input type="text" name="payment_date" id="payment_date" class="form-control" value="<?php echo date('d-m-Y',date(strtotime("+2 day", strtotime(date("d-m-Y"))))); ?>" />
              </div>

              <!--
              <div class="form-group">
              <label class="control-label">Job Duration</label>
              <input type="text" name="job_duration" value="<?php //echo set_value("job_duration", "same day"); ?>" class="form-control" required/>
            </div>
          -->

          <div class="form-group">
            <label class="control-label">Contractor's Cost (£)</label>
            <input type="text" name="amount" value="<?php echo set_value("item_quantity"); ?>" class="form-control" required/>
          </div>

          <div class="form-group general_cost_form_element">
            <label class="control-label">Cost Code</label>
            <div class="controls">
              <div class="chosen-container">
                <select name="nominal_code" id="nominal_code" class="form-control">
                  <option value="">... Select ...</option>
                  <?php foreach ($cost_codes as $value): ?>
                    <option <?php echo set_select('nominal_code',$value["nominal_code"]); ?> value="<?php echo $value["nominal_code"]; ?>"><?php echo $value["nominal_code"].' - '.$value["ledger_name"].' ('.$value["category"].')'; ?></option>
                  <?php endforeach;?>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group" id="tenant_checkbox">
            <label class="control-label"><input type="checkbox" name="to_tenant" id="to_tenant" value="1" class="form-control"/> To Occupant</label>
          </div>

          <div id="tenant_area"> <!-- start of tenant area -->

            <div class="form-group">
              <label class="control-label">Select Room</label>
              <div class="controls">
                <div class="chosen-container">
                  <select name="room_id[]" class="form-control" data-placeholder="Select Room" tabindex="1" multiple="multiple" id="room">
                    <option value="">Select Room</option>
                  </select>
                </div>
              </div>
            </div>


            <div class="form-group">
              <label class="control-label">Occupant</label>
              <select name="tenant_user_id[]" id="tenant_user_id" multiple="multiple" class="form-control"></select>
            </div>

            <div class="form-group" style="display:none">
              <label class="control-label">Invoice Amount</label>
              <input type="text" name="revenue_amount" id="revenue_amount" value="<?php echo set_value("item_quantity"); ?>" class="form-control"/>
            </div>

            <div class="form-group">
              <label class="control-label">Expired Date</label>
              <input type="text" name="expired_date" id="expired_date" class="form-control" value="<?php echo date('d-m-Y'); ?>"/>
            </div>
          </div> <!-- end of tenant area -->

          <div class="form-group" id="owner_checkbox">
            <input type="checkbox" name="to_owner" id="to_owner" value="1" class="form-control"/>
            <label class="control-label">To Owner</label>
          </div>

          <div id="owner_area"> <!-- start of owner area -->
            <div class="form-group">
              <label class="control-label">Owner</label>
              <select name="owner_user_id" id="owner_user_id" class="form-control">
                <?php foreach($owners as $value) {?>
                  <option value="<?php echo $value["id"]; ?>"><?php echo $value["name"]." ".$value["family_name"]; ?></option>
                <?php } ?>
              </select>
            </div>

            <div class="form-group">
              <label class="control-label">Invoice Amount</label>
              <input type="text" name="owner_revenue_amount" id="owner_revenue_amount" value="<?php echo set_value("item_quantity"); ?>" class="form-control"/>
            </div>

            <div class="form-group">
              <label class="control-label">Expired Date</label>
              <input type="text" name="owner_expired_date" id="owner_expired_date" class="form-control" value="<?php echo date('d-m-Y'); ?>"/>
            </div>
          </div> <!-- end of owner area -->

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

  //$('#apartment_id').select2();
  //$('#cost_type').select2();
  //$('#nominal_code').select2();
  //$('#tenant_user_id').select2();

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
          //console.log(result);
          var result = JSON.parse(result);
          console.log(result);
          var rooms = result.rooms;
          // var bookings = result.bookings;
          // var room_IDs = result.room_IDs;
          // var previous_bookings = result.previous_bookings;

          var room_dropdown_list = "";
          var room_dropdown = '<option value="">All Appartment</option>'
          +'<option value="0">Common Area</option>';
          for(var i = 0; i < rooms.length; i++)
          {
            room_dropdown_list += '<option value="'+rooms[i]['id']+'">'+rooms[i]['id']+'</option>';

          }
          $("#room").append(room_dropdown+room_dropdown_list);
          $("#room_list").append(room_dropdown+room_dropdown_list);

          // var who_pay_dropdown = '<option value="">Select</option>'
          //                         +'<option value="PML">PML</option>'
          //                         +'<option value="All Licensees">All Licensees</option>'
          //                         +'<option value="Appartment Owner">Appartment Owner</option>';
          // $('#who_pay').html(who_pay_dropdown);
          //console.log(previous_bookings[6][0]);

          // $.each( room_IDs, function( key, value ) {
          //     //console.log(previous_bookings[value]);
          //    for(var j = 0; j < previous_bookings[parseInt(value)].length; j++)
          //      {
          //          $('#who_pay').append(previous_bookings[value][j]);
          //      }
          // });



        }
      })
    }
  });

  /*  $("#apartment_id").on("change",function(){
  var xx = $(this).val();
  var yy = $("#related_to").val();

  if((xx == "0") && (yy == "4")){
  $("#employer_area").show();
  $('#employer_user_id').multipleSelect();

  $('#to_tenant').prop('checked', false).parents('span').removeClass('checked'); // Unchecks it
  $("#tenant_checkbox").hide();
  $("#tenant_area").hide();
}
else if(xx != "0"  && (yy == "1")) {
$('#to_tenant').prop('checked', false).parents('span').removeClass('checked'); // Unchecks it
}
else if(xx == "0") {
$('#to_tenant').prop('checked', false).parents('span').removeClass('checked'); // Unchecks it
$("#tenant_checkbox").hide();
$("#tenant_area").hide();
}
else {
$("#employer_area").hide();
$("#tenant_checkbox").show();
}

if (xx) {
$.ajax({
url: baseUrl + "apartment/get_room_dropdown",
type: "post",
data: {apartment_id: xx},
success: function (result) {
$("#room").html(result);
}
})
}

/*$.ajax({
url: baseUrl + "cashmanager/outgoing/ajax_get_apartment_all_tenant",
data: {
apartment_id : xx
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
});*/


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
