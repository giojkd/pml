<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title"><?php echo $title; ?></h2>
    </div>

    <div class="panel-body">
        <div class="btn-group margin-bottom-10">
            <a href="<?php echo base_url_tr() ?>reports/apartment_allotment_pdf?apartment_id=<?php echo $apartment_id; ?>&room_id=<?php echo $room_id; ?>&from_month=<?php echo $from_month; ?>&to_month=<?php echo $to_month; ?>" class="btn purple"><i class="fa fa-file-pdf-o"></i> PDF</a>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h4>Filter By</h4>
                <div class="alert alert-success">
                    <form method="get" action="<?php echo base_url_tr('reports/apartment_allotment'); ?>">
                        <div class="col-lg-3">
                            <div class="input">
                                <label>Property</label>
                                <select name="apartment_id" class="form-control" id="apartment" required>
                                    <option value="all">All</option>
                                    <?php foreach ($apartments as $value) { ?>
                                        <option <?php echo $apartment_id && $apartment_id == $value["id"] ? 'selected="selected"' : null; ?> value="<?php echo $value["id"]; ?>"><?php echo $value["id"] . " (" . $value["address"] . ")"; ?></option>
                                    <?php } ?>
                                </select>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->

                        <div class="col-lg-3">
                            <div class="input">
                                <label>Room</label>
                                <select name="room_id" id="room" class="form-control" required>
                                    <option value="all">All</option>
                                    <?php foreach ($rooms as $value) { ?>
                                        <option <?php echo $room_id && $room_id == $value["id"] ? 'selected="selected"' : null; ?> value="<?php echo $value["id"]; ?>"><?php echo $value["id"] . " - ";
                                    echo $value["room_type"] == 1 ? ' Single Type' : ' Double Type';
                                    echo " : " . $value['address']; ?></option>
<?php } ?>
                                </select>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->

                        <div class="col-lg-2">
                            <div class="input">
                                <label>From Date</label>
                                <input type="text" value="<?php echo $from_month ? $from_month : null; ?>" name="from_month" placeholder="" class="form-control filter-date" required />
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->

                        <div class="col-lg-2">
                            <div class="input">
                                <label>To Date</label>
                                <input type="text" value="<?php echo $to_month ? $to_month : null; ?>" name="to_month" placeholder="" class="form-control filter-date" required />
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->

                        <div class="col-lg-2">
                            <div class="input">
                                <label>&nbsp;</label>
                                <input class="form-control btn green" type="submit" value="Filter" />
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div><!-- /.alert alert-success -->
            </div>
        </div><!-- /.row -->

        <?php echo $this->session->flashdata('save_success') ? $this->session->flashdata('save_success') : ''; ?>
        <table class="table table-striped table-bordered table-hover display responsive nowrap datatable" width="100%">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Address</th>
                    <th>Room Type</th>
                    <th>Rent From</th>
                    <th>Rent To</th>
                    <th>Vacancy Periods</th>
                </tr>
            </thead>

            <tbody>
                <?php
                if ($filter_rooms) {
                    foreach ($filter_rooms as $allotment) {
                        ?>
                        <tr>
                            <td><?php echo $allotment['id']; ?></td>
                            <td>
                                <?php echo $allotment['address']; ?>
                                <!-- Modal -->
                                <div id="PeriodsModal<?php echo $allotment['id']; ?>" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title" style="text-align: left;">Vacancy Periods</h4>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-bordered table-striped">
                                                    <thead style="color: #000;font-weight: bold;">
                                                        <tr>
                                                            <td>Vacancy Periods</td>
                                                            <td>Days of Vacancy</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if ($allotment['period']) {
                                                            ?>
                                                            <?php
                                                            $first_diff = 0;
                                                            if(strtotime($allotment['first_from_date']) > strtotime($from_month))
                                                            {
                                                                $datetime1 = date_create($allotment['first_from_date']);
                                                                $datetime2 = date_create($from_month);
                                                                $interval = date_diff($datetime2, $datetime1);
                                                                $first_diff = $interval->format('%a');
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo date('d-m-Y', strtotime($from_month)).' to '.date('d-m-Y', strtotime($allotment['first_from_date']. ' -1 day')); ?></td>
                                                                    <td><?php echo $first_diff; ?></td>
                                                                </tr>
                                                                <?php
                                                            }
                                                            ?>

                                                            <?php
                                                            $days = 0; $final_diff = 0;
                                                            foreach ($allotment['period'] as $key => $value) {
                                                                $days += $value['period_day'];
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $value['period_date']; ?></td>
                                                                    <td><?php echo $value['period_day']; ?></td>
                                                                </tr>
                                                                <?php
                                                            }
                                                            ?>

                                                            <?php
                                                            if(strtotime($allotment['last_to_date']) < strtotime($to_month))
                                                            {
                                                                //this part is for calculating the total days from "rent to" to filter's "to date"
                                                                $datetime1 = date_create($to_month);
                                                                $datetime2 = date_create($allotment['last_to_date']);
                                                                $interval = date_diff($datetime2, $datetime1);
                                                                $final_diff = $interval->format('%a');
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo date('d-m-Y', strtotime($allotment['last_to_date']. ' +1 day')).' to '.date('d-m-Y', strtotime($to_month)); ?></td>
                                                                    <td><?php echo $final_diff; ?></td>
                                                                </tr>
                                                                <?php
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td align="right">Total Days: </td>
                                                                <td><?php echo $days+$final_diff+$first_diff; ?></td>
                                                            </tr>
                                                            <?php
                                                        } else {
                                                            $datetime1 = date_create($to_month);
                                                            $datetime2 = date_create($allotment['last_to_date']);
                                                            $interval = date_diff($datetime2, $datetime1);
                                                            $final_diff = $interval->format('%a');
                                                            ?>
                                                            <?php if(strtotime($allotment['last_to_date']) < strtotime($to_month)) { ?>
                                                                <tr>
                                                                    <td><?php echo date('d-m-Y', strtotime($allotment['last_to_date']. ' +1 day')).' to '.date('d-m-Y', strtotime($to_month)); ?></td>
                                                                    <td><?php echo $final_diff; ?></td>
                                                                </tr>

                                                                <tr>
                                                                    <td align="right">Total Days: </td>
                                                                    <td><?php echo $final_diff; ?></td>
                                                                </tr>
                                                            <?php
                                                            }
                                                            elseif(strtotime($allotment['first_from_date']) > strtotime($from_month))
                                                            {
                                                                $datetime1 = date_create($allotment['first_from_date']);
                                                                $datetime2 = date_create($from_month);
                                                                $interval = date_diff($datetime2, $datetime1);

                                                                /*$datetime1 = date_create($to_month);
                                                                $datetime2 = date_create($allotment['last_to_date']);
                                                                $interval = date_diff($datetime2, $datetime1);*/
                                                                $first_diff = $interval->format('%a');
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo date('d-m-Y', strtotime($from_month)).' to '.date('d-m-Y', strtotime($allotment['first_from_date']. ' -1 day')); ?></td>
                                                                    <td><?php echo $first_diff; ?></td>
                                                                </tr>

                                                                <tr>
                                                                    <td align="right">Total Days: </td>
                                                                    <td><?php echo $first_diff; ?></td>
                                                                </tr>
                                                            <?php
                                                            }
                                                            else
                                                            {
                                                                ?>
                                                                <tr>
                                                                    <td colspan="2"><em>No vacancy...</em></td>
                                                                </tr>
                                                            <?php
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.modal-body -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                        <!-- Modal content-->
                                    </div>
                                </div>
                                <!-- Modal -->

                                 <!--Booking  Modal -->
                                <div id="BookingsModal<?php echo $allotment['id']; ?>" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title" style="text-align: left;">Booking Periods</h4>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-bordered table-striped">
                                                    <thead style="color: #000;font-weight: bold;">
                                                        <tr>
                                                            <td>Booking Periods</td>
                                                            <td>Days of Booking</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="booking_date_details">

                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.modal-body -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                        <!-- Modal content-->
                                    </div>
                                </div>
                                <!-- Modal -->
                            </td>

                            <td align="center"><?php echo $allotment['room_id']." - "; ?> <?php echo $allotment['room_type'] == "1" ? "Single" : "Double" ?> </td>
                            <td align="center"><?php echo $allotment['last_from_date'] == "" ? "" : date('d-m-Y', strtotime($allotment['last_from_date'])); ?></td>
                            <td align="center"><?php echo $allotment['last_to_date'] == "" ? "" : date('d-m-Y', strtotime($allotment['last_to_date'])); ?></td>

                            <?php if ($allotment['period']){?>
                            <td align="center">
                                <a href="#PeriodsModal<?php echo $allotment['id']; ?>" data-toggle="modal" class="open-UploadDialogSales"><i class="fa fa-calendar"></i> Periods</a>
                                &nbsp;&nbsp;<a href="#BookingsModal<?php echo $allotment['id']; ?>" data-room-id = "<?php echo $allotment['id']; ?>" data-apartment-id = "<?php echo $allotment['apartment_id']; ?>" data-from-date = "<?php echo $from_month;?>"" data-to-date = "<?php echo $to_month ;?>" data- data-toggle="modal" class="open-UploadDialogSales booking_modal"><i class="fa fa-calendar"></i> Booking</a>
                            </td>
                            <?php } else if(strtotime($allotment['last_to_date']) < strtotime($to_month)) {?>
                            <td align="center">
                                <a href="#PeriodsModal<?php echo $allotment['id']; ?>" data-toggle="modal" class="open-UploadDialogSales"><i class="fa fa-calendar"></i> Periods</a>
                                &nbsp;&nbsp;<a href="#BookingsModal<?php echo $allotment['id']; ?>" data-room-id = "<?php echo $allotment['id']; ?>" data-apartment-id = "<?php echo $allotment['apartment_id']; ?>" data-from-date = "<?php echo $from_month;?>"" data-to-date = "<?php echo $to_month ;?>" data- data-toggle="modal" class="open-UploadDialogSales booking_modal"><i class="fa fa-calendar"></i> Booking</a>
                            </td>
                            <?php } else if(strtotime($allotment['first_from_date']) > strtotime($from_month)) {?>
                                <td align="center">
                                    <a href="#PeriodsModal<?php echo $allotment['id']; ?>" data-toggle="modal" class="open-UploadDialogSales"><i class="fa fa-calendar"></i> Periods</a>
                                    &nbsp;&nbsp;<a href="#BookingsModal<?php echo $allotment['id']; ?>" data-room-id = "<?php echo $allotment['id']; ?>" data-apartment-id = "<?php echo $allotment['apartment_id']; ?>" data-from-date = "<?php echo $from_month;?>"" data-to-date = "<?php echo $to_month ;?>" data- data-toggle="modal" class="open-UploadDialogSales booking_modal"><i class="fa fa-calendar"></i> Booking</a>
                                </td>
                            <?php } else {?>
                            <td align="center">
                                <em>No Vacancy</em>
                               &nbsp;&nbsp;<a href="#BookingsModal<?php echo $allotment['id']; ?>" data-room-id = "<?php echo $allotment['id']; ?>" data-apartment-id = "<?php echo $allotment['apartment_id']; ?>" data-from-date = "<?php echo $from_month;?>"" data-to-date = "<?php echo $to_month ;?>" data- data-toggle="modal" class="open-UploadDialogSales booking_modal"><i class="fa fa-calendar"></i> Booking</a>
                            </td>
                            <?php }?>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    $("#apartment").on("change", function () {
        var apartment_id = $(this).val();
        if (apartment_id) {
            $.ajax({
                url: "<?php echo base_url_tr('reports/get_room_dropdown'); ?>",
                type: "post",
                data: {apartment_id: apartment_id},
                success: function (result) {
                    $("#room").html(result);
                }
            })
        }
    });

    $(".filter-date").datetimepicker({
        datepicker: true,
        timepicker: false,
        format: 'd-m-Y',
        minDate: false,
        scrollMonth: false,
        scrollInput: false
    });

    $('.booking_modal').on('click', function(){
        var room_id = $(this).data('room-id');
        var apartment_id = $(this).data('apartment-id');
        var from_date = $(this).data('from-date');
        var to_date = $(this).data('to-date');
         $('.booking_date_details').html("");

        $.ajax({
                url: "<?php echo base_url_tr('reports/get_filtered_booking_date'); ?>",
                type: "post",
                data: {apartment_id: apartment_id, room_id: room_id, from_date: from_date, to_date: to_date},
                success: function (result) {
                    // $("#room").html(result);
                    var data = JSON.parse(result);
                    console.log(data);
                    var total_days = 0;
                    for( var i = 0; i < data.length; i++)
                    {
                        var rent_from = format(data[i].rent_from);
                        //console.log(rent_from);
                        //var rent_to = format(data[i].rent_to);
                        if(data[i].rent_to > to_date.split("-").reverse().join("-"))
                        {
                            var rent_to = to_date;
                            var test_to_date = to_date.split("-").reverse().join("-");
                        }
                        else{
                            var rent_to = format(data[i].rent_to);
                            var test_to_date = data[i].rent_to;
                        }


                        //var day_diff = date_diff_indays(data[i].rent_from,data[i].rent_to);
                        var day_diff = date_diff_indays(data[i].rent_from,test_to_date);
                        var total_days = total_days+day_diff;
                        console.log(day_diff);
                        $('.booking_date_details').append('<tr><td>'+rent_from+' to '+rent_to+'</td><td>'+day_diff+'</td></tr>');
                    }
                    $('.booking_date_details').append('<tr><td align="right"><srong>Total Days:</strong></td><td>'+total_days+'</td></tr>');
                }
            });

    });

    function format(inputDate) {
        var date = new Date(inputDate);
        if (!isNaN(date.getTime())) {
            // Months use 0 index.
            var day = date.getDate() < 10 ? '0' + date.getDate().toString() : date.getDate().toString();
            var month = parseFloat(date.getMonth() + 1) < 10 ? '0' + parseFloat(date.getMonth() + 1).toString() : parseFloat(date.getMonth() + 1).toString();
            var year = date.getFullYear().toString();
            return day + '-' + month + '-'  + year;
        }
    }

    function date_diff_indays(date1,date2)
    {
        var date2 = new Date(date2);
        var date1 = new Date(date1);
        var timeDiff = Math.abs(date2.getTime() - date1.getTime());
        dayDifference = Math.ceil(timeDiff / (1000 * 3600 * 24));
        return dayDifference;
    }
</script>

