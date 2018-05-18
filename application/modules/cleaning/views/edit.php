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
                    
                    <?php 
                        $user_type=getUserData('user_type');
                    ?>
                    <form class="user_edit_form" action="<?php echo site_url() ?>user/editsave" method="post" >
                        <div class="form-body col-xs-12">
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('name') ?></label>
                                <input type="text" name="name" value="<?php echo $user['name']; ?>"  placeholder="<?php echo lang('name') ?>" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label class="control-label">Family Name</label>
                                <input type="text" name="family_name" value="<?php echo $user['family_name']; ?>"  placeholder="Family Name" class="form-control " />
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('phone'); ?></label>
                                <input type="text" name="phone_no" value="<?php echo $user['phone_no']; ?>"  placeholder="<?php echo lang('phone'); ?>" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('user_email') ?></label>
                                <div class="controls">
                                    <input disabled type="email" value="<?php echo $user['email']; ?>"  name="email" placeholder="<?php echo lang('user_email') ?>" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('password') ?></label>
                                <div class="controls">
                                    <input type="password" name="password" id="password" placeholder="<?php echo lang('password') ?>" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('password_confirm') ?></label>
                                <div class="controls">
                                    <input type="password" name="password_confirm" placeholder="<?php echo lang('password_confirm') ?>" class="form-control" />
                                </div>
                            </div>
                            <?php if($user_type=='admin'){?>
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('user_type') ?></label>
                                <div class="controls">
                                    <div class="chosen-container">
                                        <?php
                                        $user_types = get_user_types();
                                        ?>
                                        <select  name="type" class="form-control" data-placeholder="Choose a Type" tabindex="1">
                                            <option value="">Choose a Type</option>
                                            <?php
                                            foreach ($user_types as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value['type_code']; ?>" <?php echo $user['type'] == $value['type_code'] ? 'selected' : ''; ?>><?php echo $value['display_text']; ?></option>
                                                <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="user_type_5_prop user_type_prop" style="<?php echo $user['type'] != 5 ? 'display: none;' : ''; ?>">
                                <div class="form-group">
                                    <label class="control-label">Date of Birth</label>
                                    <input type="text" name="birthday"  placeholder="Date of Birth" class="birthday form-control" value="<?php echo isDateZero($user['birthday']) ? date('d-m-Y') : date('d-m-Y', strtotime($user['birthday'])); ?>"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?php echo lang('country') ?></label>
                                    <div class="controls">
                                        <div class="chosen-container">
                                            <select  name="country_id" class="form-control">
                                                <option value="">Choose a Country</option>
                                                <?php foreach ($countries as $key => $value) { ?>
                                                    <option value="<?php echo $value->country_id; ?>" <?php echo $value->country_id == $user['country_id'] ? 'selected' : ''; ?>><?php echo $value->country_shortName; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?php echo lang('city') ?></label>
                                    <div class="controls">
                                        <div class="chosen-container">
                                            <select name="city_id"  class="form-control" data-placeholder="Choose a City" tabindex="1">
                                                <option value="">Choose a City</option>
                                                <?php foreach ($cities as $key => $value) { ?>
                                                    <option value="<?php echo $value->city_id; ?>" <?php echo $value->city_id == $user['city_id'] ? 'selected' : ''; ?>><?php echo $value->city_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Address</label>
                                    <div class="controls">
                                        <textarea name="tenant_address"  placeholder="Address" class="form-control"><?php echo $user['tenant_address']; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Post Address</label>
                                    <div class="controls">
                                        <textarea name="tenant_post_address" placeholder="Post Address" class="form-control"><?php echo $user['tenant_post_address']; ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">National Ins. Nr.</label>
                                    <div class="controls">
                                        <input type="text"  name="national_ins_nr" value="<?php echo $user['national_ins_nr']; ?>" placeholder="National Ins. Nr." class="form-control" />
                                    </div>
                                </div> 

                                <div class="form-group">
                                    <label class="control-label">Document No.</label>
                                    <input type="text" name="document_no" value="<?php echo $user['document_no']; ?>"  placeholder="Document No." class="form-control " />
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Work Reference File</label>
                                    <div class="controls">
                                        <a href="#tenantWorkFileUpload" data-toggle="modal" class="btn btn-default">Upload</a>
                                        <?php if($user['work_reference_file'] != "") { ?>
                                        <a title="Work Reference File" href="<?php echo site_url() ?>uploads/user_file/<?php echo $user['work_reference_file'] ?>" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-download-alt"></i></a>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="form-group" id="work_hidden_file_info">
                                
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Education Program File</label>
                                    <div class="controls">
                                        <a href="#tenantEduFileUpload" data-toggle="modal" class="btn btn-default">Upload</a>
                                        <?php if($user['education_program_file'] != "") { ?>
                                        <a title="Education Program File" href="<?php echo base_url_tr() ?>uploads/user_file/<?php echo $user['education_program_file'] ?>" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-download-alt"></i></a>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="form-group" id="edu_hidden_file_info">
                                
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Passport File</label>
                                    <div class="controls">
                                        <a href="#tenantPassFileUpload" data-toggle="modal" class="btn btn-default">Upload</a>
                                        <?php if($user['passport_file'] != "") { ?>
                                        <a title="Passport File" href="<?php echo base_url_tr() ?>uploads/user_file/<?php echo $user['passport_file'] ?>" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-download-alt"></i></a>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="form-group" id="pass_hidden_file_info">
                                
                                </div>
                            </div>
                            <div class="user_type_4_prop user_type_6_prop user_type_prop" style="<?php echo $user['type'] != 4 && $user['type'] != 6 ? 'display: none;' : ''; ?>">
                                <div class="form-group">
                                    <label class="control-label"><?php echo lang('company_name'); ?></label>
                                    <input type="text" name="company_name" value="<?php echo $user['company_name']; ?>"  placeholder="<?php echo lang('company_name'); ?>" class="form-control " />
                                </div>
                            </div>
                            
                            <div class="user_type_6_prop user_type_prop" style="<?php echo $user['type'] != 6 ? 'display: none;' : ''; ?>">
                                <div class="form-group">
                                    <label class="control-label">Agent Name</label>
                                    <input type="text" name="agent_name" value="<?php echo $user['owner_agent_name']; ?>"  placeholder="Agent Name" class="form-control " />
                                </div>
                            </div>
                            
                            <div class="user_type_6_prop user_type_prop" style="<?php echo $user['type'] != 6 ? 'display: none;' : ''; ?>">
                                <div class="form-group">
                                    <label class="control-label">Agent Phone</label>
                                    <input type="text" name="agent_phone" value="<?php echo $user['owner_agent_phone']; ?>"  placeholder="Agent Phone" class="form-control " />
                                </div>
                            </div>
                            
                            <div class="user_type_6_prop user_type_prop" style="<?php echo $user['type'] != 6 ? 'display: none;' : ''; ?>">
                                <div class="form-group">
                                    <label class="control-label">Agent Email</label>
                                    <input type="text" name="agent_email" value="<?php echo $user['owner_agent_email']; ?>"  placeholder="Agent Email" class="form-control " />
                                </div>
                            </div>
                            
                            <?php if($user_type=='admin'){?>
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('label_status') ?></label>
                                <div class="controls">
                                    <div class="success-toggle-button">
                                        <input name="status" type="checkbox" class="make-switch" <?php echo $user['status'] ? 'checked' : ''; ?>/>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                            <div class="form-actions">
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>"/>
                                <button type="submit" class="btn blue"><i class="icon-ok"></i> <?php echo lang('btn_save') ?></button>
                                <a href="<?php echo base_url_tr() ?>user" class="btn btn-danger"><i class="icon-remove"></i> <?php echo lang('btn_cancel') ?></a>
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
        $('select[name="country_id"]').on("change", function () {
            $.ajax({
                url: "<?php echo base_url_tr('common_ajax/get_city_dropdown'); ?>",
                type: "post",
                data: {country_id: $(this).val()},
                beforeSend: function () {
                    $('select[name="city_id"]').html('');
                    $('select[name="city_id"]').append($('<option />', {text: 'Loading Cities...'}));
                },
                success: function (result) {

                    $('select[name="city_id"]').html(result);

                },
                error: function (a, b, c) {
                    $('select[name="city_id"]').html('');
                    $('select[name="city_id"]').append($('<option />', {text: 'City'}));
                    alert(b);
                }
            });
        });
        
        $('select[name="type"]').change(function () {
            $('.user_type_prop').hide('500');
            var user_type = $(this).val();
            if (user_type) {
                $('.user_type_' + user_type + '_prop').show(500);
            }
        });
        
        $('.birthday').datetimepicker({
            datepicker: true,
            timepicker: false,
            format: 'd-m-Y',
            mask: true
        });
        
        $('.user_edit_form').validate({
            rules: {
                password_confirm: {
                    equalTo: "#password"
                }
            }
        });
        
        $('.user_edit_form').submit(function () {
            var $form = $(this);
            if ($form.valid()) {
                console.log('submitted');
                var formData = $form.serializeArray();
                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function (response) {
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

        $("#document_type").on("change", function () {
            var doc_type = $(this).val();
            if (doc_type != "")
            {
                $(".tenant-file").show();
            } else {
                $(".tenant-file").hide();
            }
            $('#tenantFileUpload').modal('show');
            $("#tenant_add_file").uploadFile({
                url: baseUrl + "user/user_file_upload",
                allowedTypes: doc_type,
                multiple: true,
                fileName: "myfile",
                autoSubmit: true,
                maxFileSize: 10 * 1024 * 1024,
                showStatusAfterSuccess: false,
                sequential: true,
                sequentialCount: 1,
                onSuccess: function (files, data, xhr) {
                    //$("#complaint").val("1");
                    //console.log(data);
                    //
                    var info = JSON.parse(data);
                    var orig_name = info.upload_data.orig_name;
                    console.log(orig_name);

                    $("#tenant_add_files_response").append("<div>" + info.upload_data.orig_name + "  " + "<span style='color:green'>Uploaded</span> </div><input type='hidden' name='file_name' value='" + info.upload_data.file_name + "' /><input type='hidden' name='orig_name' value='" + info.upload_data.orig_name + "'/>");
                     $("#hidden_file_info").html("<div>" + info.upload_data.orig_name + "  " + "<span style='color:green'>Uploaded</span> </div><input type='hidden' name='file_name' value='" + info.upload_data.file_name + "' /><input type='hidden' name='orig_name' value='" + info.upload_data.orig_name + "'/>");
//                var image = '<a href="' + baseUrl + "uploads/feedback_file/" + info.upload_data.file_name + '"></a>'+"<input type='hidden' name='file_name' value='" + info.upload_data.file_name + "' /><input type='hidden' name='orig_name' value='" + info.upload_data.orig_name + ";
//                $(".gallery").append(image);
               $('#tenantFileUpload').modal('hide');
               

                }
            });
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
    });
</script>