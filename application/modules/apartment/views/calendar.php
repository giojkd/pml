<style>
    .table-bg-red {
        background-color: red;
        color: #fff;
    }
</style>
<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title"><?php echo $title; ?></h2>
    </div>

    <div class="panel-body">
        <div class="btn-group margin-bottom-10">
            <!--<a href="<?php //echo base_url_tr('general_cost') ?>" class="btn green"><i class="icon-plus"></i> <?php //echo lang('label_add_new') ?></a>-->
        </div>
 <div class="portlet-body form">
        <?php if (validation_errors()): ?>
            <div class="alert alert-danger" style="color: #b42020">
                <button class="close" data-dismiss="alert" type="button">x</button>
                <?php echo validation_errors(); ?>
            </div>
        <?php endif; ?>
            <!-- BEGIN FORM-->
            <form class="item_add_form" id="calendar_view" action="" method="post">
                <div class="form-body col-xs-12">
                    <div class="form-group">
                        <label class="control-label">Property</label>
                        <select name="apartment_id" id="apartment_id" class="form-control" required>
                            <!--<option value="">..Select..</option>-->
                            <option value="0">All</option>
                            <?php foreach($apartments as $value) {?>
                            <option value="<?php echo $value["id"]; ?>"><?php echo $value["id"]." (".$value["address"].")"; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Room</label>
                        <select name="room_id" id="room_id" class="form-control" required>
                            <option value="0">All</option>
                            <?php foreach($cost_types as $key=>$type) {?>
                            <option value="<?php echo $key; ?>"><?php echo $type; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                   <!--
                    <div class="form-group">
                        <label class="control-label">Date (From)</label>
                        <input type="text" name="date_from" id="date_from" class="form-control"/>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Date (To)</label>
                        <input type="text" name="date_to" id="date_to" class="form-control"/>
                    </div>
                    -->
                    </div> <!-- end of tenant area -->

                    <div class="form-actions">
                        <button type="submit" class="btn blue"><i class="icon-ok"></i> View Calendar</button>
                    </div>
                </div>
            </form>
            <!-- END FORM-->
            <div class="clearfix"></div>
        
    
            <div style="margin-bottom: 8px">
                <button id="previous_month" class="btn blue">Previous</button>
                <button id="next_month" class="btn blue pull-right">Next</button>
            </div>
        
           
            <div id="search_result" style="position: relative; ">
                <span style="position: absolute; top: 50%; left: 45%;" id="ajaxloader">
                    <i class="fa fa-spinner fa-spin" style="font-size:100px; text-align: center;"></i>
                    <p style="text-align: center">Loading....</p>
                </span>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td colspan="2"></td>
                            <!--<td></td>-->
                            <td colspan="<?php echo $month_days; ?>" style="text-align: center; background: #272727; color: #fff;"><?php echo $month_name." ".$year; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                            <!--<td>&nbsp;</td>-->
                            
                        <?php for($i=1;$i<=$month_days;$i++) {
                            echo "<td style='width:40px;text-align:center;'>$i</td>";
                         } ?>

                        </tr>
                        
                        <?php 
                            foreach($apartments as $value)
                            {
                                $room_no = 1;
                                $apartment_id = $value["id"];
                                $rooms = $this->cm->select_all_where("rooms", "apartment_id", $apartment_id);
                                
                                foreach($rooms as $room) {
                                    $bookings = $this->calendar_model->select_booked_list_by_room_id($apartment_id, $room["id"]);
                                    
                                    echo "<tr>";
                                    echo "<td>Property: $apartment_id</td>";
                                    echo "<td>Room: ".$room['id']."</td>";
                                    
                                    $month = str_pad($month_number,2,"0",STR_PAD_LEFT);
                                    
                                    for($i=1;$i<=$month_days;$i++) {
                                        $day = str_pad($i,2,"0",STR_PAD_LEFT);
                                        $date_now = $year."-".$month."-".$day;
                                        $td_class_name = "";
                                       
                                        foreach($bookings as $booking){
                                             
                                            if((strtotime($date_now) >= strtotime($booking["rent_from"])) && (strtotime($date_now) <= strtotime($booking["rent_to"]))) 
                                            {
                                                $td_class_name = 'table-bg-red';
                                                break;
                                            }
                                            else{
                                                $td_class_name = "";
                                            }
                                        }
                                        
                                        echo "<td class='".$td_class_name."'>&nbsp;</td>";
                                    }
                                    
                                    echo "<tr>";
                                    $room_no++;
                                }
                            }
                        ?>
                    </table>
                </div>
            </div>
        
        </div>
    </div>



<script type="text/javascript">

$(document).ready(function () {
    $("#ajaxloader").hide();
    
    $("#apartment_id").on("change", function () {
    var app_id = $(this).val();
    if(app_id == "0")
    {
        $('#room_id').html('<option value="0">All</option>');
    }
    else{
    $('#room_id').prepend($('<option></option>').html('Loading...'));
        $.ajax({
            url: "<?php echo base_url('apartment/calendar/get_room_dropdown2'); ?>",
            type: "post",
            data: {apartment_id: app_id},
            success: function (result) {
                $("#room_id").html(result);
            }
        });
        }
    });
    
    $('#date_from').datetimepicker({
        datepicker: true,
        timepicker: false,
        format: 'd-m-Y',
        mask: false
    });

    $('#date_to').datetimepicker({
        datepicker: true,
        timepicker: false,
        format: 'd-m-Y',
        mask: false
    });
    
    $('#calendar_view').on('submit', function (e) {
        e.preventDefault();
        //var startDate = document.getElementById("date_from").value;
        //var endDate = document.getElementById("date_to").value;

        //if ((Date.parse(startDate) >= Date.parse(endDate))) {
            //alert("End date should be greater than Start date");
        //}
        //else
        //{
        $.ajax({
            type: "post",
            url: "<?php echo base_url('apartment/calendar/next_previous'); ?>",
            data: $('#calendar_view').serialize(),
            beforeSend: function() {
                $("#ajaxloader").show();
            },
            success: function (result) {
              $("#search_result").html(result);
              $("#ajaxloader").hide();
            }
        });
        //}
    });
    
    
    $('#previous_month').on('click', function () {
        var apartment_id = $("#apartment_id").val();
        var room_id = $("#room_id").val();
        
        $.ajax({
            type: "post",
            url: "<?php echo base_url('apartment/calendar/next_previous'); ?>",
            data: {next_or_previous: "previous", apartment_id: apartment_id, room_id: room_id},
            beforeSend: function() {
                $("#ajaxloader").show();
            },
            success: function (result) {
              $("#search_result").html(result);
              $("#ajaxloader").hide();
            }
        });
    });
    
    $('#next_month').on('click', function () {
    
        var apartment_id = $("#apartment_id").val();
        var room_id = $("#room_id").val();
        
        $.ajax({
            type: "post",
            url: "<?php echo base_url('apartment/calendar/next_previous'); ?>",
            data: {next_or_previous: "next", apartment_id: apartment_id, room_id: room_id},
            beforeSend: function() {
                $("#ajaxloader").show();
            },
            success: function (result) {
              $("#search_result").html(result);
              $("#ajaxloader").hide();
            }
        });
    });
    
    
    
});
    
</script>