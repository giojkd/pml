<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title"><?php echo $title; ?></h2>
    </div>

    <div class="panel-body">
        <div class="btn-group margin-bottom-10">
            <?php if($user_type!='sales'){?>
                <a href="<?php echo base_url_tr() ?>apartment/add_booking" class="btn green"><i class="icon-plus"></i> <?php echo lang('label_add_new') ?></a>
            <?php } ?>
        </div>
        <?php echo $this->session->flashdata('save_success') ? $this->session->flashdata('save_success') : ''; ?>
        
        <table class="table table-striped table-bordered table-hover display responsive nowrap" id="apartment_list1" width="100%">
            <thead>
                <tr>
                    <th style="text-align:center;"><?php echo 'Property'; ?></th>
                    <th><?php echo 'Room Number'; ?></th>
                    <th class="hidden-480"><?php echo 'Rent From'; ?></th>

                    <th><?php echo 'Rent To'; ?></th>
                    <th>Contract Sent</th>
                    <th>Signed by Occupant</th>
                    <th>Signed by PML</th>
                    <th>Has it Renewed?</th>
                    <th>Invoice</th>
                    <th><?php echo lang('action'); ?></th>
                </tr>
            </thead>

            <tbody>
                <?php
                if ($booking_list) {
                    $i = 0;
                    $sess_data = $this->session->userdata();
                    foreach ($booking_list as $key => $value) {
                        ?>
                        <tr class="odd gradeX">
                            <td style="text-align:center;">
                                <?php echo $value['apartment_id'].' ( ';?><?php echo get_single_table_data_by_id($value['apartment_id'], $field = "address", $table = "apartment_detail").' )'; ?>
                            </td>
                            <td>
                                <?php echo $value['room_id'].' ( ';?><?php echo get_single_table_data_by_id($value['room_id'], $field = "room_type", $table = "rooms") == "1"?"Single Type )":"Double Type".' )'; ?>
                            </td>
                            <td class="hidden-480">
                                <?php echo date('d-m-Y', strtotime($value['rent_from'])) ?>
                            </td>

                            <td >
                                <?php echo date('d-m-Y', strtotime($value['rent_to'])); ?>
                            </td>
							<td>
                                <?php echo $value['signed_by_pml'] == 1 ? 'Yes' : 'No'; ?>
                            </td>
                            <td>
                                <?php echo $value['signed_by_licensee'] == 1 ? 'Yes' : 'No'; ?>
                            </td>
                            <td>
                                <?php echo $value['signed_by_pml'] == 1 ? 'Yes' : 'No'; ?>
                            </td>
                            <td>
                                <?php echo $value['renewal_status'] == 1 ? 'Yes' : 'No'; ?>
                            </td>
                            <td>
                                <?php if($value['invoice_created']) { ?>
                                    <button type="button" class="btn btn-sm btn-danger">Sent</button>
                                <?php } else { ?>
                                    <a type="button" class="btn btn-sm btn-primary" href="<?php echo base_url('apartment/create_send_invoice/' . $value['booking_id']); ?>">Send</a>
                                <?php }?>
                            </td>
                            <td>
                    <center>
                        <?php if($user_type=='sales'){?>
                             <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">Action<span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="<?php echo base_url('apartment/booking_detail/' . $value['booking_id']); ?>">Show Detail</a>
                                    </li>  
                                    <li>
                                        <a href="#BookingFileModalSales" data-id ="<?php echo $value['booking_id']; ?>" data-toggle="modal" class="open-UploadDialogSales">Upload</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('apartment/download_booking/' . $value['booking_id']); ?>">Download Contract</a>
                                    </li>
                                </ul> 
                            </div> 
                        <?php } else {?>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">Action<span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="<?php echo base_url('apartment/booking_detail/' . $value['booking_id']); ?>">Show Detail</a>
                                    </li>  
                                    <li>
                                        <a href="<?php echo base_url('apartment/edit_booking/' . $value['booking_id']); ?>">Edit</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('apartment/download_booking/' . $value['booking_id']); ?>">Download Contract</a>
                                    </li>
                                    <li>
                                        <a href="#BookingFileModal" data-id ="<?php echo $value['booking_id']; ?>" data-toggle="modal" class="open-UploadDialog">Upload</a>
                                    </li> 
                                    <li>
                                        <a href="<?php echo base_url('apartment/delete_booking/' . $value['booking_id']); ?>" class="confirm">Delete</a>
                                    </li> 
                                    <li>
                                        <a href="<?php echo base_url('apartment/docusign_email_send/' . $value['booking_id']); ?>" class="confirm">Send ctr to sign</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('apartment/create_send_invoice/' . $value['booking_id']); ?>" class="">Create and Send first Invoices</a>
                                    </li>
                                </ul> 
                            </div> 
                        <?php } ?>
                        
                       
                    </center>
                    </td>
                    </tr>
                    <?php
                    $i++;
                }
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="BookingFileModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
                <div class="modal-body">
                    
                    <div class="controls">
                        <div id="booking_file_add" class="fileuploader">Upload</div>
                        <div id="booking_file_add_response"></div>
                    </div>
                    
                    <input type="hidden" name="ap_booked_list_id" id="ap_booked_list_id" value=""/>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
        </div>

    </div>
</div>

<!-- Booking File Modal By Sales Persons -->
<div id="BookingFileModalSales" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3>File Upload</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div id="booking_file_add_sales" class="fileuploader">Upload</div>
                    <div id="booking_file_add_sales_response"></div>
                </div>
                <div id="fileuploadSuccess" class="alert alert-success alert-dismissable fade in hidden">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success!</strong> File Has been uploaded successfully.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#apartment_list1').dataTable({
            responsive: true,
        });
        
        $(document).on("click", ".open-UploadDialog", function () {
            var id = $(this).data('id');
            $(".modal-body #ap_booked_list_id").val(id);
            // As pointed out in comments, 
            // it is superfluous to have to manually call the modal.
            // $('#addBookDialog').modal('show');
            $("#booking_file_add").uploadFile({
                url: baseUrl + "apartment/booking_file_upload/" + id,
                allowedTypes: "pdf",
                multiple: false,
                fileName: "myfile",
                autoSubmit: true,
                //maxFileSize: 10*1024*1024,
                showStatusAfterSuccess: true,
                sequential: true,
                sequentialCount: 1,
                onSuccess: function (files, data, xhr) {
                    $('#BookingFileModal').modal('hide');
                }
            });
        });

       
        $('body').on('focus',"#upload_date", function(){
            $(this).datetimepicker({
                format:"d-m-Y H:i"
            });
        });

        $(".open-UploadDialogSales").on('click',function(){
            var uploadObj=$("#booking_file_add_sales").uploadFile({
                url: baseUrl + "apartment/booking_file_upload_sales/" + $(this).attr('data-id'),
                allowedTypes: "pdf",
                multiple: false,
                fileName: "salesFile",
                autoSubmit: false,
                showStatusAfterSuccess: false,
                sequential: true,
                sequentialCount: 1,
                extraHTML:function(){
                        var html = '<div class="form-group"><label>Date</label><input type="text" name="upload_date" id="upload_date" class="form-control"></div>';
                        html += '<div class="form-group"><label>Description</label><textarea name="upload_description" id="upload_description" class="form-control"></textarea></div>';
                        html +='<div class="form-group"><button class="btn btn-success btn-sm" id="sales_file_upload">Upload</button></div>';
                        
                        return html;            
                },
                onSuccess: function (files, data, xhr){
                    $("#fileuploadSuccess").removeClass('hidden');
                }
               
            });

            $('body').on('click','#sales_file_upload',function(){
                uploadObj.startUpload();
            });
        });
    })
</script>