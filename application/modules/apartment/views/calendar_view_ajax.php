<br><br>
<h2><a href="#calendar_result">Property Calendar</a></h2>
<br><br>
<div class="hide22">
    <?php
    function date_sort($a, $b) {
        return strtotime($a) - strtotime($b);
    }

    //echo "<pre>";
    //print_r($booked[4][4]);
    //die;
    foreach ($apartments as $apartment) {
        $r = $rooms[$apartment["id"]];
        $apartment_id = $apartment["id"];
        ?>
        <h3 style="margin: -5px 0 10px 0;"><?php echo $apartment["id"] . " (" . $apartment['address'] . ")"; ?></h3>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <?php foreach ($r as $value) { ?>
                            <th>Room <?php echo $value["id"]; ?></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>


                    <?php
                    $months = array();
                    if (!empty($all_rent_from_date[$apartment["id"]]) && !empty($all_rent_to_date[$apartment["id"]])) {

                        @usort($all_rent_from_date[$apartment["id"]], "date_sort");
                        @usort($all_rent_to_date[$apartment["id"]], "date_sort");

                        $starting_date = $all_rent_from_date[$apartment["id"]][0];
                        $ending_date = $all_rent_to_date[$apartment["id"]][sizeof($all_rent_to_date[$apartment["id"]]) - 1];
                        $start = strtotime($starting_date);
                        $end = strtotime($ending_date);
                        $year1 = date('Y', $start);
                        $year2 = date('Y', $end);
                        $month1 = date('m', $start);
                        $month2 = date('m', $end);
                        $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
                        $initial = date('F Y', strtotime($starting_date));

                        for ($i = 0; $i <= $diff; $i++) {
                            $months[] = date('F Y', strtotime($i . " month", strtotime($initial)));
                        }


                        foreach ($months as $month) {
                            echo '<tr><td>' . $month . '</td>';

                            $m = return_first_date($month);

                            $first_date_of_the_month = date('Y-m-01', strtotime($month));
                            $last_date_of_the_month = date('Y-m-t', strtotime($month));

                            foreach ($r as $value) {
                                $class_name = "";
                                $show_date = "";
                                $room_id = $value["id"];
                                $bookings_of_room = $booked[$apartment_id][$room_id];

                                foreach ($bookings_of_room as $key=>$single_booking) {
                                    $rent_from = strtotime($single_booking["rent_from"]);
                                    $rent_to = strtotime($single_booking["rent_to"]);

                                    $rent_from1 = date('Y-m-01', strtotime($single_booking["rent_from"])); //first day date of "rent_from" date's month
                                    $rent_to1 = date('Y-m-t', strtotime($single_booking["rent_to"])); //last day date of "rent_to" date's month

                                    if ((strtotime($first_date_of_the_month) >= strtotime($rent_from1)) && (strtotime($last_date_of_the_month) <= strtotime($rent_to1)) ) {
                                        $class_name = "table-bg-green";
                                        
                                        if($month == (date("F Y", strtotime($rent_from1)))) {
                                            $show_date = "Start: ".mydate($rent_from1,"-");
                                        }
                                        
                                        if($month == (date("F Y", strtotime($rent_to1)))) {
                                            $show_date = "End: ".mydate($rent_to1,"-");
                                        }
                                        
                                        break;
                                    } else {
                                        $class_name = "";
                                        $show_date = "";
                                    }
                                }
                                
                                /*
                                if($cc==0 && $class_name=="table-bg-green") {
                                    $aa = $rent_from1;
                                }else if($cc==(count($bookings_of_room)-1) && $class_name=="table-bg-green") {
                                    $aa = $rent_to1;
                                } else {
                                    $aa = "";
                                }
                                 */
                                    
                                
                                echo "<td class='$class_name'>$show_date</td>";
                            }
                            echo "</tr>";
                        }
                    } else {
                        $row_span = count($r) + 1;
                        echo '<tr><td colspan="' . $row_span . '" class="text-center">All Rooms are <b>Free</b></td></tr>';
                    }
                    ?>




        <!--                    <td class="text-center table-bg-green">1</td>
                            <td class="text-center">2</td>
                            <td class="text-center">3</td>
                            <td class="text-center">4</td>
                            <td class="text-center">5</td>
                            <td class="text-center">6</td>-->
                    <!--                </tr>-->

                        <!--                <tr>
                            <td>February, 2017</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>-->
                </tbody>
            </table>
        </div>
        <br/><br/>
<?php } ?>


</div>
