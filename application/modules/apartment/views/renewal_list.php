<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title"><?php echo $title; ?></h2>
    </div>

    <div class="panel-body">
        <div class="btn-group margin-bottom-10">
            <?php //if($user_type!='sales'){?>
                <!--<a href="<?php //echo base_url_tr() ?>apartment/add_booking" class="btn green"><i class="icon-plus"></i> <?php //echo lang('label_add_new') ?></a>-->
            <?php //} ?>
        </div>
        <?php echo $this->session->flashdata('save_success') ? $this->session->flashdata('save_success') : ''; ?>
        
        <table class="table table-striped table-bordered table-hover display responsive nowrap" id="apartment_list1" width="100%">
            <thead>
                <tr>
                    <th>Contract Expiry Date</th>
                    <th>Occupant</th>
                    <th>Room and Address</th>
                    <th>Renewal Request</th>
                    <th>Renewing/Moving Out</th>
                    <th>Comments</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    foreach($renewal_list as $key => $value) {
                ?>
                        <tr class="odd gradeX">
                            <td><?php echo mydate($value['rent_to'],"-") ?></td>
                            <td><?php echo $value["name"]." ".$value["family_name"]; ?></td>
                            <td>Room No: <?php echo $value['room_id']."<br>(".$value['address'].")"; ?></td>
                            <td> 
                                <?php if($value["reminder_email_sent"] == "0") {?>
                                <button class="btn green renewal_reminder" data-booking-id="<?php echo $value["booking_id"]; ?>">Send Renewal Request Letter</button></td>
                                <?php } else {
                                    echo "Letter Sent";
                                } ?>
                            <td class="renewal_td_<?php echo $value["booking_id"]; ?>">
                                <button class="btn red renewal_id" id="renew_button_<?php echo $value["booking_id"]; ?>" data-booking-id="<?php echo $value["booking_id"]; ?>" data-licensee-fee="<?php echo $value["monthly_fee"]; ?>" data-booking-date2="<?php echo mydate(date('Y-m-d',date(strtotime("+0 day", strtotime($value["rent_to"])))),"-"); ?>">Renewing</button><br>
                                <button class="btn green moved_out_button" id="move_out_button_<?php echo $value["booking_id"]; ?>" data-booking-id="<?php echo $value["booking_id"]; ?>">Moving Out</button>
                            </td>
                            <td><input type="text" class="comments_text form-control" data-booking-id="<?php echo $value["booking_id"]; ?>" value="<?php echo $value["comments"]; ?>"></td>
                    </tr>
                    <?php
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
                <button type="button" class="close" data-dismiss="modal"></button>
                <h4 class="modal-title" id="bookingModalLabel">New Renewal Dates</h4>
            </div>
                <div class="modal-body">
                    
               <table class="table table-bordered" style="margin-bottom: 5px;">
                     <tr>
                        <td>Date From</td>
                        <td><input class="form-control" type="text" name="new_rent_from" id="new_rent_from" required /></td>
                     </tr>
                     <tr>
                        <td>Date To</td>
                        <td><input class="form-control" type="text" name="new_rent_to" id="new_rent_to" required /></td>
                     </tr>
                     <tr>
                        <td>Occupant Fee</td>
                        <td><input class="form-control" type="text" name="new_monthly_fee" id="new_monthly_fee" required /></td>
                     </tr>
               </table>
                    
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_booking_id" id="hidden_booking_id" value="">
                    <button type="submit" class="btn btn-default" id="xxx">Confirm</button>
                </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        
         $("#new_rent_to").datetimepicker({
                format:"d-m-Y"
         });
        
        $('#apartment_list1').dataTable({
            responsive: true,
            "aaSorting": []
        });
       
        $('body').on('focus',"#upload_date", function(){
            $(this).datetimepicker({
                format:"d-m-Y H:i"
            });
        });
        
        $(document).on('click', '.renewal_id', function () {
            $('#BookingFileModal').modal('show');
            
            $("#hidden_booking_id").val("");
            $("#new_rent_from").val("");
            $("#new_rent_to").val("");
            $("#xxx").html("Confirm");
            
            var booking_start_date = $(this).attr('data-booking-date2');
            $("#new_rent_from").val(booking_start_date);
            
            var licensee_fee = $(this).attr('data-licensee-fee');
            $("#new_monthly_fee").val(licensee_fee);
            
            var booking_id = $(this).attr('data-booking-id');
            $("#hidden_booking_id").val(booking_id);
        });
        
        
        $(document).on('click', '#xxx', function () {
            var booking_id = $("#hidden_booking_id").val();
            var new_rent_from = $("#new_rent_from").val();
            var new_rent_to = $("#new_rent_to").val();
            var new_monthly_fee = $("#new_monthly_fee").val();
            var that = $(this);
            
            $.ajax({
                url: "<?php echo base_url('apartment/booking_renewal'); ?>",
                type: "post",
                data: {booking_id: booking_id,new_rent_from: new_rent_from,new_rent_to: new_rent_to,new_monthly_fee: new_monthly_fee},
                beforeSend:function(){
                    that.html("Renewing...");
                },
                success: function (result) {
                    if(result == "success"){
                        //alert("Email has been sent");
                    }
                },
                complete:function(){
                    $(".renewal_td_"+booking_id).html('<button class="btn red send_contract_pdf" data-booking-id="'+booking_id+'">Send Contract for E-signing</button>');
                    
                    //$("#move_out_button_"+booking_id).hide();
                    //$("#renew_button_"+booking_id).html("Send Contract PDF");
                    //$("#renew_button_"+booking_id).prop("disabled",true);
                    $('#BookingFileModal').modal('hide');
                }
            });
            
            
        });
        
        //$(".send_contract_pdf").on("click", function () {
        $(document).on('click', '.send_contract_pdf', function () {
            var booking_id = $(this).attr('data-booking-id');
            var that = $(this);
            
            $.ajax({
                url: "<?php echo base_url('apartment/send_pdf_contract_email'); ?>",
                type: "post",
                data: {booking_id: booking_id},
                beforeSend:function(){
                    that.html("Sending...");
                },
                success: function (result) {
                    if(result == "success"){
                        //alert("Email has been sent");
                    }
                },
                complete:function(){
                    that.html("Contract Sent");
                    that.prop("disabled",true);
                }
            });
        });
        
        
        $(".renewal_reminder").on("click", function () {
            var booking_id = $(this).attr('data-booking-id');
            var that = $(this);
            
            $.ajax({
                url: "<?php echo base_url('apartment/send_renewal_reminder_email'); ?>",
                type: "post",
                data: {booking_id: booking_id},
                beforeSend:function(){
                    that.html("Sending...");
                },
                success: function (result) {
                    if(result == "success"){
                        //alert("Email has been sent");
                    }
                },
                complete:function(){
                    that.html("Letter Sent");
                    that.prop("disabled",true);
                }
            });
        });
        
        
        $(".moved_out_button").on("click", function () {
            var booking_id = $(this).attr('data-booking-id');
            var that = $(this);
            
            var x = confirm("Are you sure to move out?");
            
            if(x)
            {
                $.ajax({
                    url: "<?php echo base_url('apartment/booking_move_out'); ?>",
                    type: "post",
                    data: {booking_id: booking_id},
                    beforeSend:function(){
                        that.prop("disabled",true);
                        that.html("Moving Out...Wait");
                    },
                    success: function (result) {
                        if(result == "success"){
                            that.parents("tr").remove();
                            //alert("Email has been sent");
                        }
                    },
                    complete:function(){
                        that.html("Moved");
                        that.prop("disabled",true);
                    }
                });
            }

        });
        
        $(".comments_text").keyup(function () {
            var booking_id = $(this).attr('data-booking-id');
            var comments = $(this).val();

            $.ajax({
                url: "<?php echo base_url('apartment/update_booking_comments'); ?>",
                type: "post",
                data: {booking_id: booking_id, comments: comments},
                beforeSend:function(){
                    //that.prop("disabled",true);
                    //that.html("Moving Out...Wait");
                },
                success: function (result) {
                    if(result == "success"){
                        //alert("saved");
                    }
                }
            });
        });
        
        
    });
    
    

</script>