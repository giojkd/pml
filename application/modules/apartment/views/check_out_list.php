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
                    <th>Check-out Date</th>
                    <th>Occupant</th>
                    <th>Room and Address</th>
                    <th>Check out formalities</th>
                    <th>Occupant key return time and location</th>
                    <th>Comments</th>
                </tr>
            </thead>

            <tbody>
                <?php
                foreach ($check_out_list as $value) {
                ?>
                    <tr class="odd gradeX">
                        <td><?php echo mydate($value['rent_to'],"-"); ?></td>
                        <td><?php echo $value['family_name']." ".$value['name'] ?></td>
                        <td>
                            Room No: <?php echo $value['room_id'] ?><br>
                            Property: <?php echo $value['apartment_id']." (".$value['address'].")" ?>
                        </td>
                        <td>
                            <?php if($value["formality_email_sent"] == "0") {?>
                                <button class="btn green check_out_formality" data-booking-id="<?php echo $value["booking_id"]; ?>">Send Check Out Formalities</button></td>
                                <?php } else {
                                    echo "Sent";
                                } ?>
                        </td>
                        <td>
                            <div class="input-group">
                              <input class="form-control licensee_key_return_time_location" type="text" value="<?php echo $value['licensee_key_return_time_location'];?>" name="licensee_key_return_time_location" placeholder="">
                              <span class="input-group-btn">
                                <a data-id ="<?php echo $value['booking_id']; ?>" class="btn btn-success btn-sm licensee_key_return_time_location_submit" style="padding: 7px 10px; margin: 0;"><i class="glyphicon glyphicon-plus"></i></a>
                              </span>
                            </div>
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


<script type="text/javascript">
    $("#check_in_list_success").hide();
     
    $(document).ready(function () {
        $(".licensee_key_return_time_location_submit").on("click", function(){
            var licensee_key_return_time_location = $(this).parent().prev('input').val();
            var booking_id = $(this).data("id");
            $.ajax({
                url: "<?php echo base_url('apartment/check_out_time_location'); ?>",
                type: "post",
                data: {licensee_key_return_time_location: licensee_key_return_time_location, booking_id: booking_id},
                success: function (result) {
                    //alert(result);

                    $("#check_in_list_success").show();
                    
                }
            });

        });
        
        
        $(".check_out_formality").on("click", function () {
            var booking_id = $(this).attr('data-booking-id');
            var that = $(this);
            
            $.ajax({
                url: "<?php echo base_url('apartment/send_check_out_formality_email'); ?>",
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
                    that.html("SENT");
                    that.prop("disabled",true);
                }
            });
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