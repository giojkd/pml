
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

          </div>
          <!-- BEGIN FORM-->
          <form class="cleaning_add_form" action="<?php echo site_url() ?>cleaning/addSave" method="post" >
            <div class="form-body col-xs-12">
              <div class="form-group">
                <label class="control-label"><?php echo lang('date') ?></label>
                <input type="text" name="cleaning_date" id="cleaning_date" value="<?php echo date('d-m-Y');?>"  placeholder="<?php echo lang('date') ?>" class="form-control" />
              </div>

              <div class="form-group">
                <label class="control-label"><?php echo lang('cleaning_property') ?></label>
                <div class="controls">
                  <div class="chosen-container">
                    <select  name="apartment_id" id="apartment" class="form-control" data-placeholder="<?php echo lang('cleaning_choose_property');?>" tabindex="1">
                      <option value=""><?php echo lang('cleaning_choose_property');?></option>
                      <?php
                      foreach ($apartments as $key => $value) { ?>
                        <option value="<?php echo $value['id']; ?>"><?php echo $value['id']." - ".$value['address']; ?></option>
                      <?php }?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label"><?php echo lang('cleaning_area'); ?></label>
                <div class="controls">
                  <div class="chosen-container">

                    <select name="room_id" id="room" class="form-control" data-placeholder="Select Room" tabindex="1">

                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label"><?php echo lang('cleaner'); ?></label>
                <div class="controls">
                  <div class="chosen-container">
                    <select name="cleaner_id"  class="form-control" data-placeholder="Select a Cleaner" tabindex="1">
                      <option value="">Select a Cleaner</option>
                      <?php foreach($cleaners as $cleaner) {?>
                        <option value="<?php echo $cleaner['cleaner_id'];?>"><?php echo $cleaner['cleaner_name'];?></option>
                      <?php }?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label">Who is reponsible?</label>
                <div class="controls">
                  <div class="chosen-container">

                    <select name="who_pay" id="who_pay" class="form-control" data-placeholder="Select" tabindex="1">

                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label">Revenue amount</label>
                <input type="number" name="cleaning_cost"  placeholder="Revenue amount" class="form-control" />
              </div>



              <div class="form-group">
                <label class="control-label">Supplier</label>
                <select  name="supplier_id" id="apartment" class="form-control" data-placeholder="Supplier" tabindex="1">
                  <option value="">Choose...</option>
                  <?php

                  foreach ($suppliers as $key => $value) { ?>
                    <option value="<?php echo $value['id']; ?>"><?php echo $value['id']." - ".$value['company']; ?></option>
                  <?php }?>
                </select>
              </div>

              <div class="form-group">
                <label class="control-label">Supplier cost</label>
                <input type="number" name="supplier_cost"  placeholder="Supplier cost" class="form-control" />
              </div>



              <div class="form-group">
                <div id="attachmentFileUpload">Upload</div>
                <div id="uploadedContractFiles"></div>
              </div>

              <div class="form-actions">
                <button type="submit" class="btn blue"><i class="icon-ok"></i> <?php echo lang('btn_save') ?></button>
                <a href="<?php echo base_url_tr() ?>cleaning" class="btn btn-danger"><i class="icon-remove"></i> <?php echo lang('btn_cancel') ?></a>
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

  $('input[name="cleaning_date"]').datetimepicker({
    timepicker: false,
    format: 'd-m-Y',
    mask: true,
    minDate: '<?php echo date('d-m-Y'); ?>', //or 1986/12/08,
    // theme: 'dark',
  });

  $("#apartment").on("change", function () {
    var apartment_id = $(this).val();
    //alert(apartment_id);exit;
    if (apartment_id) {
      $("#room").html("");
      // $("#who_pay").html("");
      $.ajax({
        url: "<?php echo base_url_tr('cleaning/get_room_dropdown'); ?>",
        type: "post",
        data: {apartment_id: apartment_id},
        success: function (result) {
          //console.log(result);
          console.log(result);
          var result = JSON.parse(result);
          var rooms = result.rooms;
          // var bookings = result.bookings;
          // var room_IDs = result.room_IDs;
          // var previous_bookings = result.previous_bookings;

          var room_dropdown_list = "";
          var room_dropdown = '<option value="">Select a Room</option>'
          +'<option value="0">Common Area</option>';
          for(var i = 0; i < rooms.length; i++)
          {
            room_dropdown_list += '<option value="'+rooms[i]['id']+'">'+rooms[i]['room_description']+'</option>';

          }
          $("#room").append(room_dropdown+room_dropdown_list);

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

  $("#room").on("change", function () {
    var room_id = $(this).val();
    var apartment_id = $("#apartment").val();
    var cleaning_date = $("#cleaning_date").val();
    if (apartment_id && room_id) {
      $("#who_pay").html("");
      $.ajax({
        url: "<?php echo base_url_tr('cleaning/get_who_pay'); ?>",
        type: "post",
        data: {apartment_id: apartment_id, room_id: room_id, cleaning_date: cleaning_date},
        success: function (result) {
          var result = JSON.parse(result);
          // var bookings = result.bookings;
          // var room_IDs = result.room_IDs;
          if(result.room_select == "yes")
          {
            var previous_licensee = result.previous_licensee;
            var current_licensee = result.current_licensee;
            console.log(result);

            var who_pay_dropdown = '<option value="">Select</option>'
            +'<option value="pml">PML</option>'
            +'<option value="all_licensee">All Occupants</option>'
            +'<option value="apartment_owner">Appartment Owner</option>';
            $('#who_pay').html(who_pay_dropdown);

            if(current_licensee.length > 0)
            {
              $.each( current_licensee, function( key, value ) {
                $('#who_pay').append(value);
              });
            }

            if(previous_licensee.length > 0)
            {
              $.each( previous_licensee, function( key, value ) {
                $('#who_pay').append(value);
              });
            }
          }
          else if(result.room_select == "no")
          {
            var room_IDs = result.room_IDs;
            var previous_bookings = result.previous_bookings;

            var who_pay_dropdown = '<option value="">Select</option>'
            +'<option value="pml">PML</option>'
            +'<option value="all_licensee">All Occupants</option>'
            +'<option value="apartment_owner">Property Owner</option>';
            $('#who_pay').html(who_pay_dropdown);
            //console.log(previous_bookings[6][0]);

            // $.each( room_IDs, function( key, value ) {
            //     //console.log(previous_bookings[value]);
            //    for(var j = 0; j < previous_bookings[parseInt(value)].length; j++)
            //      {
            //          $('#who_pay').append(previous_bookings[value][j]);
            //      }
            // });
          }


        }
      })
    }
  });

  $('.cleaning_add_form').submit(function () {
    var $form = $(this);
    if ($form.valid()) {
      console.log('submitted');
      var formData = $form.serializeArray();
      $.ajax({
        url: $form.attr('action'),
        type: 'POST',
        data: formData,
        success: function (response) {
          //console.log(response);exit;
          try {
            var result = JSON.parse(response);
            if (result.status) {
              $('.validation_errors').html('<div class="alert alert-success">' + result.message + '</div>');
              $("html, body").animate({scrollTop: 0}, 500, 'swing', function () {
                if (result.redirectto) {
                  window.location.replace(result.redirectto);
                }
              });

            } else {
              $('.validation_errors').html('<div class="alert alert-danger">' + result.message + '</div>');
              $("html, body").animate({scrollTop: 0}, 500, 'swing', function () {
                if (result.redirectto) {
                  window.location.replace(result.redirectto);
                }
              });
            }
          } catch (e) {
            console.log(e.message);
          }
        },
        error: function (e) {
          console.log(e);
        },
      });
    }
    return false;
  });

});
</script>
