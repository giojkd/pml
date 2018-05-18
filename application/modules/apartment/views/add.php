
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
                    <form class="apartment_add_form" id="apartment_add_form1" action="<?php echo site_url() ?>apartment/addsave" method="post" >
                        <div class="form-body col-xs-12">
                            <div class="form-group">
                                <label class="control-label">Select Owner &nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-primary btn-xs add-owner">Add New Owner</a></label>
                                <div class="controls">
                                    <div class="chosen-container">

                                        <select name="owner" class="form-control" data-placeholder="Choose an Owner" tabindex="1" required="">
                                            <option value="">Owner List</option>
                                            <?php
                                            foreach ($users as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value['id']; ?>"><?php echo $value['name'] . " " . $value['family_name']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?php echo 'Address'; ?></label>
                                <textarea name="address" id="address" class="form-control" required=""></textarea>
                            </div>
                            <div class="form-group" style="display: none;">
                                <div id="map" style="width:100%;height: 450px;"></div>
                            </div>
                            <!--
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label class="control-label">Latitude</label>
                                        <input class="form-control" type="text" name="map_lat" id="map_lat" placeholder="Latitude">
                                    </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-5">
                                        <label class="control-label">Langitude</label>
                                        <input class="form-control" type="text" name="map_lang" id="map_lang" placeholder="Langitude">
                                    </div>
                                </div>
                            </div>
                        -->

                        <div class="form-group">
                            <label class="control-label"><?php echo 'Post Code'; ?></label>
                            <input type="text" name="zip_code" required placeholder="<?php echo 'Post Code'; ?>" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo 'Floor'; ?></label>
                            <input type="text" name="floor" required placeholder="<?php echo 'Floor'; ?>" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo 'Flat/House number'; ?></label>
                            <input type="text" name="nr" required placeholder="<?php echo 'Nr.'; ?>" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo 'Contract From'; ?></label>
                            <input type="text" name="contract_from" id="contract_from" required placeholder="<?php echo 'Contract From'; ?>" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo 'Contract To'; ?></label>
                            <input type="text" name="contract_to" id="contract_to" required placeholder="<?php echo 'Contract To'; ?>" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo "PML's Rent"; ?></label>
                            <input type="text" name="contract_cost" required placeholder="<?php echo 'Licence Fee'; ?>" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo 'Day of the Month'; ?></label>

                            <select class="form-control" id="day_of_month" name="day_of_month" required>
                                <option value="">Select Day</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                                <option value="24">24</option>
                                <option value="25">25</option>
                                <option value="26">26</option>
                                <option value="27">27</option>
                                <option value="28">28</option>
                                <option value="29">29</option>
                                <option value="30">30</option>
                                <option value="31">31</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo 'Months in advance'; ?></label>

                            <select class="form-control" id="month_in_advance" name="month_in_advance" required>
                                <option value="">Select month in advance</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo 'Standard Payment'; ?></label>

                            <select class="form-control" id="standard_payment" name="standard_payment" required>
                                <option value="">Select standard payment</option>
                                <option value="1">1</option>
                                <option value="3">3</option>
                                <option value="6">6</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo "Deposit"; ?></label>
                            <input type="number" name="deposit" required placeholder="<?php echo 'Deposit'; ?>" class="form-control"/>
                        </div>

                        <!-- <div class="form-group">
                            <label class="control-label"><?php //echo 'Payment due date (7 days in advance)'; ?></label>
                            <input type="text" name="payment_date_to_owner" id="payment_date_to_owner" required placeholder="<?php //echo 'Payment due date'; ?>" class="form-control"/>
                        </div> -->

                        <div class="form-group">
                            <label class="control-label"><?php echo 'Note'; ?></label>
                            <textarea name="note" id="note" placeholder="<?php echo 'Note'; ?>" class="form-control"></textarea>
                        </div>

                        <div class="form-group hidden">
                            <label class="control-label">Service charge for Water</label>
                            <input type="number" name="water" value="0" placeholder="Service charge for Water" class="form-control"/>
                        </div>

                        <div class="form-group hidden">
                            <label class="control-label">Service charge for Gas</label>
                            <input type="number" name="gas" value="0" placeholder="Service charge for Gas" class="form-control"/>
                        </div>

                        <div class="form-group hidden">
                            <label class="control-label">Service charge for Electricity</label>
                            <input type="number" name="electricity" value="0" placeholder="Service charge for Electricity" class="form-control"/>
                        </div>

                        <div class="form-group hidden">
                            <label class="control-label">Service charge for Internet</label>
                            <input type="number" name="internet" value="0" placeholder="Service charge for Internet" class="form-control"/>
                        </div>

                        <div class="form-group hidden">
                            <label class="control-label">Service charge for Council Tax</label>
                            <input type="number" name="council_tax" value="0" placeholder="Service charge for Council Tax" class="form-control"/>
                        </div>

                            <!--
                            <h3>Common Area</h3>
                            <div class="row group common_area1">
                                <div class="col-sm-5">
                                    <label class="control-label"><?php //echo 'Name';        ?></label>
                                    <div class="form-group">
                                        <input name="common_area_type[]" type="text" class="form-control">
                                    </div>
                                </div> 
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label"><?php //echo 'Quantity';        ?></label>
                                        <input name="common_area_qty[]" type="text" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                    <label class="control-label"><?php //echo '&nbsp';        ?></label><br/>
                                    <button type="button" id="btnAdd-1" class="btn btn-primary btn-add btn-add-common"><i class="fa fa-plus"></i></button>
                                    
                                    </div>
                                </div>
                            </div>

                            <h3>Private Area</h3>
                            <div class="row group private_area1">
                                <div class="col-sm-5">
                                    <label class="control-label"><?php //echo 'Name';        ?></label>
                                    <div class="form-group">
                                        <input name="private_area_type[]" type="text" class="form-control">
                                    </div>
                                </div> 
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label"><?php //echo 'Quantity';        ?></label>
                                        <input name="private_area_qty[]" type="text" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                    <label class="control-label"><?php //echo '&nbsp';        ?></label><br/>
                                    <button type="button" id="btnAdd-1" class="btn btn-primary btn-add-private"><i class="fa fa-plus"></i></button>
                                    
                                    </div>
                                </div>
                            </div>
                            
                        -->

                        <h3>Rooms</h3>

                            <!-- <div class="form-group">
                                <label class="control-label">Rooms in Flat</label>
                                <input type="number" name="room1_qty" required placeholder="<?php //echo 'Room Quantity'; ?>" value="1" class="form-control"/>
                            </div> -->

                            <div class="form-group">
                                <label class="control-label">Max couples allowed in flat</label>
                                <!--                                 <input type="number" name="max_couples_allowed" required placeholder="<?php //echo 'Max couples allowed in flat'; ?>" value="1" class="form-control"/> -->
                                <select class="form-control" name="max_couples_allowed" required>
                                    <option value="">Select</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <button type="button" class="btn btn-sm btn-success add_room"><i class="fa fa-plus"> Add Room</i></button>
                            </div>
                            <input type="hidden" name="room_repeater" value="no">
                            <table class="table table-striped table-bordered table-hover apartment-stock-repeater">
                                <thead>
                                    <tr>
                                        <th>Room Name</th>
                                        <th>EnSuite</th>
                                        <th>Market Price</th>
                                        <th>Room Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="room_name[]" value="<?php echo set_value("room_name"); ?>" class="form-control room_name" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="checkbox" name="check_box[]" class="check_box form-control" value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="market_price[]" value="<?php echo set_value("market_price"); ?>" class="form-control"/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="room_description[]" value="<?php echo set_value("room_description"); ?>" class="form-control"/>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="btn btn-danger row-delete"><i class="fa fa-minus"></i></a>
                                            <a href="javascript:void(0)" class="btn btn-success row-add"><i class="fa fa-plus"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="form-group">
                                <div id="attachmentFileUpload">Upload</div>
                                <div id="uploadedContractFiles"></div>
                            </div>

                            <div class="form-group" style="display: none;">
                                <label class="control-label">Room for Couples</label>
                                <input type="number" name="room2_qty" required placeholder="<?php echo 'Room Quantity'; ?>" value="1" class="form-control"/>
                            </div>

                            <div class="form-actions">
                                <input class="form-control" type="hidden" name="map_lat" id="map_lat">
                                <input class="form-control" type="hidden" name="map_lang" id="map_lang">
                                <button type="submit" class="btn blue"><i class="icon-ok"></i> <?php echo lang('btn_save') ?></button>
                                <a href="<?php echo base_url_tr() ?>apartment" class="btn btn-danger"><i class="icon-remove"></i> <?php echo lang('btn_cancel') ?></a>
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

<!-- Modal -->
<div id="add-owner-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form class="owner-add-form" action="<?php echo site_url() ?>user/addsave" method="post" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Owner</h4>
                </div>
                <div class="modal-body clearfix">
                    <!-- BEGIN FORM-->

                    <div class="form-body col-xs-12">
                        <div class="form-group">
                            <label class="control-label">First Name</label>
                            <input type="text" name="name"  placeholder="<?php echo lang('name') ?>" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">Last Name</label>
                            <input type="text" name="family_name"  placeholder="Family Name" class="form-control " />
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?php echo lang('phone'); ?></label>
                            <input type="text" name="phone_no"  placeholder="<?php echo lang('phone'); ?>" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?php echo lang('email') ?></label>
                            <div class="controls">
                                <input type="email"  name="email" placeholder="<?php echo lang('user_email') ?>" class="form-control" />
                            </div>
                        </div>

                        <input type="hidden"  name="password" value="123456"/>
                        <input type="hidden"  name="password_confirm" value="123456"/>

                        <div class="form-group">
                            <label class="control-label"><?php echo lang('company_name'); ?></label>
                            <input type="text" name="company_name"  placeholder="<?php echo lang('company_name'); ?>" class="form-control " />
                        </div>

                        <div class="form-group">
                            <label class="control-label">Agent Name</label>
                            <input type="text" name="agent_name"  placeholder="Agent Name" class="form-control " />
                        </div>

                        <div class="form-group">
                            <label class="control-label">Agent Phone</label>
                            <input type="text" name="agent_phone"  placeholder="Agent Phone" class="form-control " />
                        </div>

                        <div class="form-group">
                            <label class="control-label">Agent Email</label>
                            <input type="text" name="agent_email"  placeholder="Agent Email" class="form-control " />
                        </div>

                        <input name="status" type="hidden" value="1" />
                        <input name="type" type="hidden" value="6" />
                        <input name="return_user" type="hidden" value="1" />

                    </div> 
                    <div class="validation_errors col-xs-12">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><?php echo lang('btn_save') ?></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>

    </div>
</div>

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

        $(document).on('click','.check_box', function(){
            if($(this).attr('checked'))
            {
                $(this).val("1");
            }
            else{
                $(this).val("0");
            }
        });

        $('.apartment-stock-repeater').hide();
        
        $('.add_room').on('click', function(){
            $('input[name=room_repeater]').val('yes');
            $('.apartment-stock-repeater').show();
            $(this).parent('div').css('display','none');
        });

        $('.apartment-stock-repeater').on('click', '.row-add', function () {
            var row = $(this).parents('table').find('tbody tr:first').clone();
            //$(row).find('input[type=checkbox]').uniform();
            $(row).find('input').each(function () {
                $(this).val('');
            });
            $(row).find('input[type=checkbox]').val("0");

            var html = $(row).find('input[type=checkbox]').parents('span').html();
            $(row).find('input[type=checkbox]').parents('div').html(html);

            $(this).parents('table').find('tbody').append(row);
            $('input[type=checkbox]').uniform();
        });

        $('.apartment-stock-repeater').on('click', '.row-delete', function () {
            if ($(this).parents('tbody').find('tr').length < 2)
            {
                $('.apartment-stock-repeater').hide();
                $('.add_room').parent('div').removeAttr('style');
                $('input[name=room_repeater]').val("no");
            }
            if ($(this).parents('tbody').find('tr').length > 1) {

                $(this).parents('tr').remove();
            }
        });

        $(document).on('click', '.btn-add-common', function (e)
        {
            e.preventDefault();

            var controlForm = $('#apartment_add_form1'),
            currentEntry = $(this).parents('.common_area1:first'),
                    //newEntry = $(currentEntry.clone()).appendTo(controlForm);
                    newEntry = $(currentEntry.clone()).insertAfter(currentEntry);
                    console.log(currentEntry);

                    newEntry.find('input').val('');
                    controlForm.find('.common_area1:not(:last) .btn-add-common')
                    .removeClass('btn-add-common').addClass('btn-remove-common')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="glyphicon glyphicon-minus"></span>');
                }).on('click', '.btn-remove-common', function (e)
                {

                    $(this).parents('.common_area1:first').remove();
                    e.preventDefault();
                    return false;
                });

                $(document).on('click', '.btn-add-private', function (e)
                {
                    e.preventDefault();

                    var controlForm = $('#apartment_add_form1'),
                    currentEntry = $(this).parents('.private_area1:first'),
                    //newEntry = $(currentEntry.clone()).appendTo(controlForm);
                    newEntry = $(currentEntry.clone()).insertAfter(currentEntry);
                    console.log(currentEntry);

                    newEntry.find('input').val('');
                    controlForm.find('.private_area1:not(:last) .btn-add-private')
                    .removeClass('btn-add-private').addClass('btn-remove-private')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="glyphicon glyphicon-minus"></span>');
                }).on('click', '.btn-remove-private', function (e)
                {

                    $(this).parents('.private_area1:first').remove();
                    e.preventDefault();
                    return false;
                });


                $('#apartment_add_form1').submit(function (e) {
                    e.preventDefault();
                    if($('input[name=room_repeater]').val() == "yes")
                    {
                        if($('.room_name').val() == "")
                        {
                            $('.validation_errors').html('<div class="alert alert-danger">Room Name is required</div>');
                            $('html, body').animate({ scrollTop: 0 }, 'slow')
                            return false;
                        }
                    }
                    var $form = $(this);
                    $(this).find('form').remove();
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


function initMap() {
        // Create a map object and specify the DOM element for display.
        var obj = {
            'mapID': 'map',
            'lat': 51.509865,
            'lng': -0.118092,
            'zoomLevel': 15,
        };
        var map = new GMPlugin(obj);
        // map.centerCurrentLocationWithMarker('Drag marker to get latitude langitude','',true,'map_lat','map_lang');

        $("#address").on('change', function () {
            map.makeSingleMarkerTextAddress($(this).val(), '', 'map_lat', 'map_lang');
        });

    }

    $('#contract_from').datetimepicker({
        datepicker: true,
        timepicker: false,
        format: 'd-m-Y',
        mask: false
    });

    $('#contract_to').datetimepicker({
        datepicker: true,
        timepicker: false,
        format: 'd-m-Y',
        mask: false
    });

    $('#payment_date_to_owner').datetimepicker({
        datepicker: true,
        timepicker: false,
        format: 'd-m-Y',
        mask: false
    });


    $(document).on('ready', function () {
        $('.add-owner').on('click', function () {
            $('#add-owner-modal').modal('show');
        });

        $('.owner-add-form').on('submit', function (e) {
            e.preventDefault();
            var form = this;
            var data = $(this).serialize();
            $.ajax({
                url: $(form).attr('action'),
                type: 'POST',
                data: data,
                beforeSend: function (xhr) {
                    $(form).find('.validation_errors').html('');
                },
                success: function (response) {
                    var result = JSON.parse(response);
                    if (result.status) {
                        $('select[name="owner"]').append('<option value="' + result.user.id + '">' + result.user.name + ' ' + result.user.family_name + '</option>');
                        $('select[name="owner"]').val(result.user.id).change();
                        $(form).resetForm();
                        $('#add-owner-modal').modal('hide');
                    } else {
                        $(form).find('.validation_errors').html('<div class="alert alert-danger">' + result.message + '</div>');
                    }
                }
            });
        });
    });
</script>