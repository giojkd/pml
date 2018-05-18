
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
                    <form class="apartment_add_form" id="booking_add_form1" action="<?php echo site_url() ?>apartment/save_booking" method="post" >
                        <div class="form-body col-xs-12">
                            <div class="form-group">
                                <label class="control-label"><?php echo 'Select Property'; ?></label>
                                <div class="controls">
                                    <div class="chosen-container">

                                        <select name="apartment_id" class="form-control" data-placeholder="Choose an Owner" tabindex="1" required="" id="apartment">
                                            <option value="">Select Property</option>
                                            <?php
                                            foreach ($apartments as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value['id']; ?>"><?php echo $value['id'] . " - " . $value['address']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?php echo 'Select Room'; ?></label>
                                <div class="controls">
                                    <div class="chosen-container">

                                        <select name="room_id" class="form-control" data-placeholder="Select Room" tabindex="1" required="" id="room">
                                            <option value="">Select Room</option>

                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="control-label">Select Occupant &nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-primary btn-xs add-occupant">Add New Occupant</a></label>
                                <div class="controls">
                                    <div class="chosen-container">

                                        <select name="user_id[]" class="form-control" data-placeholder="Choose an Occupant" tabindex="1" required="" id="tenant_user_id" multiple>
                                            <option value="">Select Occupant</option>
                                            <?php
                                            foreach ($tenants as $key => $value) {
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
                                <label class="control-label"><?php echo 'From'; ?></label>
                                <input type="text" readonly="" name="rent_from" required placeholder="<?php echo 'From'; ?>" class="form-control" id="rent_from"/>
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?php echo 'To'; ?></label>
                                <input type="text" readonly="" name="rent_to" required placeholder="<?php echo 'To'; ?>" class="form-control" id="rent_to"/>
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?php echo 'Date for monthly payment'; ?></label>

                                <select class="form-control" id="payment_date1" name="payment_date" required>
                                    <option value="">Select Date</option>
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
                                <label class="control-label"><?php echo 'Licence Fee'; ?></label>
                                <input type="number" name="monthly_fee" required placeholder="<?php echo ''; ?>" class="form-control"/>
                            </div>


                            <div class="form-group">
                                <label class="control-label"><?php echo 'Deposit'; ?></label>
                                <input type="number" name="deposit_fee" required placeholder="<?php echo ''; ?>" class="form-control"/>
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?php echo 'Agent’s Introduction Fee (£)'; ?></label>
                                <input type="number" name="booking_fee" required placeholder="<?php echo ''; ?>" class="form-control"/>
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?php echo 'Initial Admin Fee'; ?></label>
                                <input type="number" name="admin_fee" required placeholder="<?php echo ''; ?>" class="form-control"/>
                            </div>

                            <div class="form-group">
                                <label class="control-label">
                                    <input type="radio" name="internal_external" value="internal" checked> Internal
                                </label>

                                <label class="control-label">
                                    <input type="radio" name="internal_external" value="external"> External
                                </label>
                            </div>

                            <div class="form-group internal_div">
                                <label class="control-label">Agents</label>
                                <select class="form-control" id="agent_id" name="agent_id">
                                    <option value="">Select Agent</option>
                                    <?php
                                    foreach ($agents as $key => $value) {?>
                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['name'] . " " . $value['family_name']; ?></option>
                                    <?php }?>
                                </select>
                            </div>

                            <div class="form-group external_div">
                                <label class="control-label"><?php echo 'External'; ?></label>
                                <input type="text" name="external" placeholder="<?php echo ''; ?>" class="form-control"/>
                            </div>

                            <div class="form-group external_div">
                                <label class="control-label">Sorces</label>
                                <select class="form-control" id="source_id" name="source_id">
                                    <option value="">Select Source</option>
                                    <?php
                                    foreach ($sorces as $key => $value) {?>
                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['source_name']; ?></option>
                                    <?php }?>
                                </select>
                            </div>


                            <div class="form-actions text-center">
                                <button type="submit" class="btn blue"><i class="icon-ok"></i> <?php echo lang('btn_save') ?></button>
                                <a href="<?php echo base_url_tr() ?>apartment/booking_list" class="btn btn-danger"><i class="icon-remove"></i> <?php echo lang('btn_cancel') ?></a>
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
<div id="add-occupant-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form class="occupant-add-form" action="<?php echo site_url() ?>user/addsave" method="post" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Occupant</h4>
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

                        <input name="type" type="hidden" value="5" />

                        <div class="form-group">
                            <label class="control-label">Date of Birth</label>
                            <input type="text" name="birthday"  placeholder="Date of Birth" class="birthday form-control" value="<?php echo date('d-m-Y'); ?>"/>
                        </div>

                        <input type="hidden" name="country_id" value="0"/>
                        <input type="hidden" name="city_id" value="0"/>
                        <input type="hidden" name="tenant_address" value="N/A"/>
                        <input type="hidden" name="tenant_post_address" value="N/A"/>
                        <input type="hidden" name="national_ins_nr" value="0"/>
                        <input type="hidden" name="document_no" value="0"/>

                        <div class="form-group">
                            <label class="control-label">Work Reference File</label>
                            <div class="controls">
                                <a href="#tenantWorkFileUpload" data-toggle="modal" class="btn btn-default">Upload</a>
                            </div>
                        </div>

                        <div class="form-group" id="work_hidden_file_info">

                        </div>

                        <div class="form-group">
                            <label class="control-label">Education Program File</label>
                            <div class="controls">
                                <a href="#tenantEduFileUpload" data-toggle="modal" class="btn btn-default">Upload</a>
                            </div>
                        </div>

                        <div class="form-group" id="edu_hidden_file_info">

                        </div>

                        <div class="form-group">
                            <label class="control-label">Passport File</label>
                            <div class="controls">
                                <a href="#tenantPassFileUpload" data-toggle="modal" class="btn btn-default">Upload</a>
                            </div>
                        </div>

                        <div class="form-group" id="pass_hidden_file_info">

                        </div>

                        <input name="status" type="hidden" value="1" />
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

<!-- Modal -->
<div id="tenantWorkFileUpload" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <label class="control-label">Work Reference File</label>
                <div class="controls">
                    <div id="work_reference_file" class="fileuploader">Upload</div>
                    <div id="work_reference_files_response"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="tenantEduFileUpload" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <label class="control-label">Education Program File</label>
                <div class="controls">
                    <div id="education_program_file" class="fileuploader">Upload</div>
                    <div id="education_program_files_response"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="tenantPassFileUpload" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <label class="control-label">Passport File</label>
                <div class="controls">
                    <div id="passport_file" class="fileuploader">Upload</div>
                    <div id="passport_files_response"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {

        $('.external_div').hide();

        $('input[type=radio][name=internal_external]').change(function() {
            if (this.value == 'internal') {
                //alert("realtedai");
                $(".internal_div").show();
                $(".external_div").hide();
            }
            else if (this.value == 'external') {
                //alert("general");
                $(".internal_div").hide();
                $(".external_div").show();
            }
        });

        $('#booking_add_form1').submit(function () {
            var $form = $(this);
            if ($form.valid()) {
                console.log('submitted');
                var formData = $form.serializeArray();
                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        console.log(response);
                        //exit;
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

        $("#apartment").on("change", function () {
            var apartment_id = $(this).val();
            //alert(apartment_id);exit;
            if (apartment_id) {
                $.ajax({
                    url: "<?php echo base_url_tr('apartment/get_room_dropdown'); ?>",
                    type: "post",
                    data: {apartment_id: apartment_id},
                    success: function (result) {
                        console.log(result);
                        $("#room").html(result);
                        // updateHTMLselect("#city_id");
                    }
                })
            }
        });

        $("#rent_from").datetimepicker({
            datepicker: true,
            timepicker: false,
            format: 'd-m-Y',
            minDate: 0,
            scrollMonth: false,
            scrollInput: false
        });

        $("#rent_to").datetimepicker({
            datepicker: true,
            timepicker: false,
            format: 'd-m-Y',
            minDate: 0,
            scrollMonth: false,
            scrollInput: false
        });

        $("#payment_date1").select2();

        $('#apartment').select2();
        $('#room').select2();
        $('#tenant_user_id').select2();
        $('#agent_id').select2();
        $('#source_id').select2();

    });

    $(document).on('ready', function () {

        $('.birthday').datetimepicker({
            datepicker: true,
            timepicker: false,
            format: 'd-m-Y',
            mask: true
        });

        //Uplode to Word Reference File
        $("#work_reference_file").uploadFile({
            url: baseUrl + "user/user_file_upload/",
            allowedTypes: 'gif,jpg,png,jpeg,pdf,doc,docx',
            multiple: false,
            fileName: "myfile",
            autoSubmit: true,
            maxFileSize: 10 * 1024 * 1024,
            showStatusAfterSuccess: false,
            sequential: true,
            sequentialCount: 1,
            onSuccess: function (files, data, xhr) {
                var info = JSON.parse(data);
                var orig_name = info.upload_data.orig_name;

                //$("#work_reference_files_response").append("<div>" + info.upload_data.orig_name + "  " + "<span style='color:green'>Uploaded</span> </div><input type='hidden' name='file_name' value='" + info.upload_data.file_name + "' /><input type='hidden' name='orig_name' value='" + info.upload_data.orig_name + "'/>");
                $("#work_hidden_file_info").html("<div>" + info.upload_data.orig_name + "  " + "<span style='color:green'>Uploaded</span> </div><input type='hidden' name='work_file_name' value='" + info.upload_data.file_name + "' /><input type='hidden' name='work_orig_name' value='" + info.upload_data.orig_name + "'/>");
                //var image = '<a href="' + baseUrl + "uploads/feedback_file/" + info.upload_data.file_name + '"></a>'+"<input type='hidden' name='file_name' value='" + info.upload_data.file_name + "' /><input type='hidden' name='orig_name' value='" + info.upload_data.orig_name + ";
                //$(".gallery").append(image);
                $("#tenantWorkFileUpload").modal('hide');
            }
        });

        //Uplode to Education Prorgam File
        $("#education_program_file").uploadFile({
            url: baseUrl + "user/user_file_upload",
            allowedTypes: 'gif,jpg,png,jpeg,pdf,doc,docx',
            multiple: false,
            fileName: "myfile",
            autoSubmit: true,
            maxFileSize: 10 * 1024 * 1024,
            showStatusAfterSuccess: false,
            sequential: true,
            sequentialCount: 1,
            onSuccess: function (files, data, xhr) {
                var info = JSON.parse(data);
                var orig_name = info.upload_data.orig_name;

                //$("#education_program_files_response").append("<div>" + info.upload_data.orig_name + "  " + "<span style='color:green'>Uploaded</span> </div><input type='hidden' name='file_name' value='" + info.upload_data.file_name + "' /><input type='hidden' name='orig_name' value='" + info.upload_data.orig_name + "'/>");
                $("#edu_hidden_file_info").html("<div>" + info.upload_data.orig_name + "  " + "<span style='color:green'>Uploaded</span> </div><input type='hidden' name='education_file_name' value='" + info.upload_data.file_name + "' /><input type='hidden' name='education_orig_name' value='" + info.upload_data.orig_name + "'/>");
                //var image = '<a href="' + baseUrl + "uploads/feedback_file/" + info.upload_data.file_name + '"></a>'+"<input type='hidden' name='file_name' value='" + info.upload_data.file_name + "' /><input type='hidden' name='orig_name' value='" + info.upload_data.orig_name + ";
                //$(".gallery").append(image);
                $("#tenantEduFileUpload").modal('hide');
            }
        });

        //Uplode to Passport File
        $("#passport_file").uploadFile({
            url: baseUrl + "user/user_file_upload",
            allowedTypes: 'gif,jpg,png,jpeg,pdf,doc,docx',
            multiple: false,
            fileName: "myfile",
            autoSubmit: true,
            maxFileSize: 10 * 1024 * 1024,
            showStatusAfterSuccess: false,
            sequential: true,
            sequentialCount: 1,
            onSuccess: function (files, data, xhr) {
                var info = JSON.parse(data);
                var orig_name = info.upload_data.orig_name;

                //$("#passport_files_response").append("<div>" + info.upload_data.orig_name + "  " + "<span style='color:green'>Uploaded</span> </div><input type='hidden' name='file_name' value='" + info.upload_data.file_name + "' /><input type='hidden' name='orig_name' value='" + info.upload_data.orig_name + "'/>");
                $("#pass_hidden_file_info").html("<div>" + info.upload_data.orig_name + "  " + "<span style='color:green'>Uploaded</span> </div><input type='hidden' name='passport_file_name' value='" + info.upload_data.file_name + "' /><input type='hidden' name='passport_orig_name' value='" + info.upload_data.orig_name + "'/>");
                //var image = '<a href="' + baseUrl + "uploads/feedback_file/" + info.upload_data.file_name + '"></a>'+"<input type='hidden' name='file_name' value='" + info.upload_data.file_name + "' /><input type='hidden' name='orig_name' value='" + info.upload_data.orig_name + ";
                //$(".gallery").append(image);
                $("#tenantPassFileUpload").modal('hide');
            }
        });

        $('.add-occupant').on('click', function () {
            $('#add-occupant-modal').modal('show');
        });

        $('.occupant-add-form').on('submit', function (e) {
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
                        $('#tenant_user_id').append('<option value="' + result.user.id + '">' + result.user.name + ' ' + result.user.family_name + '</option>').change();
                        $("#tenant_user_id").select2("val", $("#tenant_user_id").select2("val").concat(result.user.id));

                        $(form).resetForm();
                        $("#work_hidden_file_info").html('');
                        $("#edu_hidden_file_info").html('');
                        $("#pass_hidden_file_info").html('');

                        $('#add-occupant-modal').modal('hide');
                    } else {
                        $(form).find('.validation_errors').html('<div class="alert alert-danger">' + result.message + '</div>');
                    }
                }
            });
        });
    });
</script>
