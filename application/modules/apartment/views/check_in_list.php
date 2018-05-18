<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title"><?php echo $title; ?></h2>
    </div>

    <div class="panel-body">
        <div class="alert alert-success alert-dismissable" id="check_in_list_success">
            <a href="#"></a>
            <strong>Success!</strong> Updated
        </div>
        <?php //echo $this->session->flashdata('save_success') ? $this->session->flashdata('save_success') : ''; ?>
        
        <table class="table table-striped table-bordered table-hover display responsive nowrap" id="apartment_list1" width="100%">
            <thead>
                <tr>
                    <th>Check-in Date</th>
                    <th>Occupant</th>
                    <th>Room and Address</th>
                    
                    <th>Passport/Visa</th>
                    <th>Education Program</th>
                    <th>Work Reference</th>
                    
                    <th>Payment Received</th>
                    <th>Payment Comment</th>
                    <th>Occupant keys ready?</th>
                    <th>Files</th>
                </tr>
            </thead>

            <tbody>
                <?php
                foreach ($check_in_list as $value) {
                ?>
                    <tr class="odd gradeX">
                        <td><?php echo mydate($value['rent_from'],"-"); ?></td>
                        <td><?php echo $value['family_name']." ".$value['name'] ?></td>
                        <td>
                            Room No: <?php echo $value['room_id'] ?><br>
                            Property: <?php echo $value['apartment_id']." (".$value['address'].")" ?>
                        </td>
                        
                        <td>
                            <?php if($value["passport_file"] == "") {?>
                            <div class="controls">
                                <a href="#" class="btn btn-default red upload_passport_document" data-userid="<?php echo $value['user_id'] ?>">Upload</a>
                            </div>
                            <div class="form-group pass_hidden_file_info"></div>
                            <?php } else {?>
                                <a href="<?php echo base_url('apartment/user_passport_download/'.$value['user_id']); ?>" class="btn btn-default green">Download</a>
                            <?php } ?>
                        </td>
                        
                        <td>
                            <?php if($value["education_program_file"] == "") {?>
                            <div class="controls">
                                <a href="#" class="btn btn-default red upload_education_program_file" data-userid="<?php echo $value['user_id'] ?>">Upload</a>
                            </div>
                            <div class="form-group pass_hidden_file_info"></div>
                            <?php } else {?>
                                <a href="<?php echo base_url('apartment/education_program_file_download/'.$value['user_id']); ?>" class="btn btn-default green">Download</a>
                            <?php } ?>
                        </td>
                        
                        <td>
                            <?php if($value["work_reference_file"] == "") {?>
                            <div class="controls">
                                <a href="#" class="btn btn-default red upload_work_reference_file" data-userid="<?php echo $value['user_id'] ?>">Upload</a>
                            </div>
                            <div class="form-group pass_hidden_file_info"></div>
                            <?php } else {?>
                                <a href="<?php echo base_url('apartment/work_reference_file_download/'.$value['user_id']); ?>" class="btn btn-default green">Download</a>
                            <?php } ?>
                        </td>
                        
                        <td>
                            <select class="form-control payment_received" data-id="<?php echo $value['booking_id'] ?>" name="payment_received">
                                <option value="" <?php echo $value['payment_received']=="0"?"selected":""; ?>>------</option>
                                <option value="1" <?php echo $value['payment_received']=="1"?"selected":""; ?>>Yes</option>
                                <option value="2" <?php echo $value['payment_received']=="2"?"selected":""; ?>>No</option>
                            </select>
                        </td>
                        <td>
                            <div class="input-group">
                              <input class="form-control payment_comment" value="<?php echo $value['payment_comment'];?>" type="text" name="payment_comment" placeholder="">
                              <span class="input-group-btn">
                                <a data-id ="<?php echo $value['booking_id']; ?>" class="btn btn-success btn-sm payment_comment_submit" style="padding: 7px 10px; margin: 0;"><i class="glyphicon glyphicon-plus"></i></a>
                              </span>
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                              <input class="form-control licensee_key" type="text" value="<?php echo $value['licensee_key_return_time_location'];?>" name="licensee_key" placeholder="">
                              <span class="input-group-btn">
                                <a data-id ="<?php echo $value['booking_id']; ?>" class="btn btn-success btn-sm licensee_key_submit" style="padding: 7px 10px; margin: 0;"><i class="glyphicon glyphicon-plus"></i></a>
                              </span>
                            </div>
                        </td>
                        <td>
                            <?php 
                                if($value['work_reference_file']) {
                                    echo "<b>Work Reference: </b>"."Yes".'<br>';
                                }
                                else {
                                     echo "<b>Work Reference: </b>"."No".'<br>';
                                }

                                if($value['education_program_file']) {
                                    echo "<b>Education Program: </b>"."Yes".'<br>';
                                }
                                else {
                                     echo "<b>Education Program: </b>"."No".'<br>';
                                }

                                if($value['passport_file']) {
                                    echo "<b>Passport: </b>"."Yes".'<br>';
                                }
                                else {
                                     echo "<b>Passport: </b>"."No".'<br>';
                                }
                            ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        
        
        <!-- Modal: Passport File Upload -->
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
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="modalClose1">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal: Education Program File Upload -->
        <div id="educationProgramFileUpload" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                       <label class="control-label">Education Program File</label>
                        <div class="controls">
                            <div id="education_file" class="fileuploader">Upload</div>
                            <div id="education_files_response"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="modalClose1">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal: Work Reference File Upload -->
        <div id="workReferenceFileUpload" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                       <label class="control-label">Work Reference File</label>
                        <div class="controls">
                            <div id="work_file" class="fileuploader">Upload</div>
                            <div id="work_files_response"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="modalClose1">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<script type="text/javascript">
    $("#check_in_list_success").hide();
    
    $(document).ready(function () {
        
        $(".licensee_key_submit").on("click", function(){
            var licensee_key = $(this).parent().prev('input').val();
            var booking_id = $(this).data("id");
            $.ajax({
                url: "<?php echo base_url('apartment/check_in_licensee_key'); ?>",
                type: "post",
                data: {licensee_key: licensee_key, booking_id: booking_id},
                success: function (result) {
                    $("#check_in_list_success").show();
                }
            });

        });

        $('.payment_received').on('change', function(){
            var booking_id = $(this).data('id');
            var payment_received = $(this).val();
            $.ajax({
                url: "<?php echo base_url('apartment/check_in_payment'); ?>",
                type: "post",
                data: {payment_received: payment_received, booking_id: booking_id},
                success: function (result) {
                    $("#check_in_list_success").show();
                }
            });
        });

        $(".payment_comment_submit").on("click", function(){
            var payment_comment = $(this).parent().prev('input').val();
            var booking_id = $(this).data("id");
            $.ajax({
                url: "<?php echo base_url('apartment/check_in_payment_comment'); ?>",
                type: "post",
                data: {payment_comment: payment_comment, booking_id: booking_id},
                success: function (result) {
                    $("#check_in_list_success").show();
                }
            });

        });
        
        $(".upload_passport_document").on("click", function(){
            $("#tenantPassFileUpload").modal('show');
            //alert($(this).attr('data-userid'));
            var userid = $(this).attr('data-userid');
            
            $("#passport_file").uploadFile({
                url: baseUrl + "apartment/user_passport_upload",
                formData: { user_id: userid},
                allowedTypes: 'gif,jpg,png,jpeg,pdf,doc,docx',
                multiple: false,
                fileName: "myfile",
                autoSubmit: true,
                maxFileSize: 10 * 1024 * 1024,
                showStatusAfterSuccess: false,
                sequential: true,
                sequentialCount: 1,
                onSuccess: function (files, data, xhr) {

                   $("#passport_files_response").append("<span style='color:green'>File has been uploaded</span>");
                    //$("#passport_files_response").append("<div>" + info.upload_data.orig_name + "  " + "<span style='color:green'>Uploaded</span> </div><input type='hidden' name='file_name' value='" + info.upload_data.file_name + "' /><input type='hidden' name='orig_name' value='" + info.upload_data.orig_name + "'/>");
                    //$("#pass_hidden_file_info").html("<div>" + info.upload_data.orig_name + "  " + "<span style='color:green'>Uploaded</span> </div><input type='hidden' name='passport_file_name' value='" + info.upload_data.file_name + "' /><input type='hidden' name='passport_orig_name' value='" + info.upload_data.orig_name + "'/>");
                    //var image = '<a href="' + baseUrl + "uploads/feedback_file/" + info.upload_data.file_name + '"></a>'+"<input type='hidden' name='file_name' value='" + info.upload_data.file_name + "' /><input type='hidden' name='orig_name' value='" + info.upload_data.orig_name + ";
                    //$("#tenantPassFileUpload").modal('hide');
                }
            });
        });
        
        $('#tenantPassFileUpload').on('hidden.bs.modal', function () {
            location.reload();
        });
        
        
        // code to upload education program file
        $(".upload_education_program_file").on("click", function(){
            $("#educationProgramFileUpload").modal('show');
            var userid = $(this).attr('data-userid');
            
            $("#education_file").uploadFile({
                url: baseUrl + "apartment/education_program_file_upload",
                formData: { user_id: userid},
                allowedTypes: 'gif,jpg,png,jpeg,pdf,doc,docx',
                multiple: false,
                fileName: "myfile",
                autoSubmit: true,
                maxFileSize: 10 * 1024 * 1024,
                showStatusAfterSuccess: false,
                sequential: true,
                sequentialCount: 1,
                onSuccess: function (files, data, xhr) {
                   $("#education_files_response").append("<span style='color:green'>File has been uploaded</span>");
                }
            });
        });
        
        $('#educationProgramFileUpload').on('hidden.bs.modal', function () {
            location.reload();
        });
        
        // code to upload work reference file
        $(".upload_work_reference_file").on("click", function(){
            
            $("#workReferenceFileUpload").modal('show');
            var userid = $(this).attr('data-userid');
            
            $("#work_file").uploadFile({
                url: baseUrl + "apartment/work_reference_file_upload",
                formData: { user_id: userid},
                allowedTypes: 'gif,jpg,png,jpeg,pdf,doc,docx',
                multiple: false,
                fileName: "myfile",
                autoSubmit: true,
                maxFileSize: 10 * 1024 * 1024,
                showStatusAfterSuccess: false,
                sequential: true,
                sequentialCount: 1,
                onSuccess: function (files, data, xhr) {
                   $("#work_files_response").append("<span style='color:green'>File has been uploaded</span>");
                }
            });
        });
        
        $('#workReferenceFileUpload').on('hidden.bs.modal', function () {
            location.reload();
        });
        

    });
</script>