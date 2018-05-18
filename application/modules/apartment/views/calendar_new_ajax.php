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

                <?php 
                //this loop is creating the second row which are days of the month (i.e. 1 to 30)
                for($i=1;$i<=$month_days;$i++) {
                    echo "<td style='width:40px;text-align:center;'>$i</td>";
                } ?>
            </tr>
            
            <?php 
            foreach($apartments as $value)
            {
                $room_no = 1;
                $apartment_id = $value["id"];
                
                if($form_room_id) {
                    $rooms = $this->cm->select_all_with_2_where("rooms", "apartment_id", $apartment_id,"id",$form_room_id);
                } else {
                    $rooms = $this->cm->select_all_where("rooms", "apartment_id", $apartment_id);
                }

                //in the loop below, for each room, availability has been checked per day wise
                foreach($rooms as $room) {
                    $bookings = $this->calendar_model->select_booked_list_by_room_id($apartment_id, $room["id"]);

                    echo "<tr>";
                    echo "<td>Property: $apartment_id</td>";
                    echo "<td>Room: ".$room['id']."</td>";

                    $month = str_pad($month_number,2,"0",STR_PAD_LEFT);

                    //this loop is creating the <td> for each day of the current month, for the current room
                    for($i=1;$i<=$month_days;$i++) {
                        $day = str_pad($i,2,"0",STR_PAD_LEFT);
                        $date_now = $year."-".$month."-".$day;
                        $td_class_name = "";

                        //this loop is checking the availability of the room on each day
                        foreach($bookings as $booking){

                            if((strtotime($date_now) >= strtotime($booking["rent_from"])) && (strtotime($date_now) <= strtotime($booking["rent_to"]))) 
                            {
                                $td_class_name = 'table-bg-green';
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