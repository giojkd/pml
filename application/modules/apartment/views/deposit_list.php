<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title"><?php echo $title; ?></h2>
    </div>

    <div class="panel-body">

        <table class="table table-striped table-bordered table-hover display responsive nowrap" id="apartment_list1" width="100%">
            <thead>
                <tr>
                    <th>Deposit Refund Deadline</th>
                    <th>Occupant</th>
                    <th>Room and Address</th>
                    <th>Deposit Amount</th>
                    <th>Outstanding Invoices</th>
                    <th>CheckOut Report</th>
                    <th>Notify Account Department</th>
                    <th>Credit Note</th>
                </tr>
            </thead>

            <tbody>
                <?php
                foreach ($deposit_list as $value) {
                ?>
                    <tr class="odd gradeX">
                        <td><?php echo mydate(date('Y-m-d',date(strtotime("+10 day", strtotime($value["rent_to"])))),"-"); ?> <span id="alert_icon_<?php echo $value['booking_id']; ?>"></span></td>
                        <td><?php echo $value['family_name']." ".$value['name'] ?></td>
                        <td>
                            Room No: <?php echo $value['room_id'] ?><br>
                            Property: <?php echo $value['apartment_id']." (".$value['address'].")" ?>
                        </td>
                        <td><?php echo $value['deposit_fee'] ?></td>
                        <td><?php echo number_format((float)$outstanding_total[$value["user_id"]], 2, '.', '');  ?></td>
                        <td>
                            <?php if($value["checkout_report_file"] == "") {?>
                            <div class="controls">
                                <a href="#" class="btn btn-default red upload_checkout_report" data-booking-id="<?php echo $value['booking_id'] ?>">Upload</a>
                            </div>
                            <div class="form-group pass_hidden_file_info"></div>
                            <?php } else {?>
                                <a href="<?php echo base_url('apartment/checkout_report_download/'.$value['booking_id']); ?>" class="btn btn-default green">Download</a>
                            <?php } ?>
                        </td>
                        <td>
                                <?php if($value["accounting_notify_status"] == "0") {?>
                                <button class="btn green notify_account" data-booking-id="<?php echo $value["booking_id"]; ?>">Notify Account Department</button></td>
                                <?php } else {
                                    echo "Letter Sent";
                                } ?>
                        </td>
                        <td><a href="<?php echo base_url('apartment/create_credit_note/'.$value['booking_id']); ?>" class="btn btn-default green">Create</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        
        
        <!-- Modal: Passport File Upload -->
        <div id="checkoutReportFileUpload" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                       <label class="control-label">Checkout Report</label>
                        <div class="controls">
                            <div id="checkoutReport_file" class="fileuploader">Upload</div>
                            <div id="checkoutReport_file_response"></div>
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
$(document).ready(function(){
    $(".upload_checkout_report").on("click", function(){
        var that = $(this);
        
        $("#checkoutReportFileUpload").modal('show');
        var booking_id = $(this).attr('data-booking-id');
            
        $("#checkoutReport_file").uploadFile({
                url: baseUrl + "apartment/checkout_report_upload",
                formData: { booking_id: booking_id},
                allowedTypes: 'gif,jpg,png,jpeg,pdf,doc,docx',
                multiple: false,
                fileName: "myfile",
                autoSubmit: true,
                maxFileSize: 10 * 1024 * 1024,
                showStatusAfterSuccess: false,
                sequential: true,
                sequentialCount: 1,
                beforeSend:function(){
                    that.prop("disabled",true);
                    //that.html("Moving Out...Wait");
                },
                onSuccess: function (files, data, xhr) {
                   $("#checkoutReport_file_response").append("<span style='color:green'>File has been uploaded</span>");
                }
            });
        });
        
        $('#checkoutReportFileUpload').on('hidden.bs.modal', function () {
            location.reload();
        });
        
        $(".notify_account").on("click", function () {
            var booking_id = $(this).attr('data-booking-id');
            var that = $(this);
            
            $.ajax({
                url: "<?php echo base_url('apartment/send_notification_to_accounting_department'); ?>",
                type: "post",
                data: {booking_id: booking_id},
                beforeSend:function(){
                    that.html("Sending...");
                    that.prop("disabled",true);
                },
                success: function (result) {
                    if(result == "success"){
                        //alert("Email has been sent");
                    }
                },
                complete:function(){
                    $("#alert_icon_"+booking_id).html('<i class="fa fa-exclamation-triangle" style="color: red;"></i>');
                    that.html("Sent");
                    that.prop("disabled",true);
                }
            });
        });
});
</script>

