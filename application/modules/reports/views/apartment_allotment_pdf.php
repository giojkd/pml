                    
<h2 style="text-align: center"><?php echo $title; ?><br>
    <table class="table table-striped table-bordered table-hover display responsive nowrap datatable" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Address</th>
                <th>Floor</th>
                <th>Room Type</th>
                <th>Room Qty</th>
                <th>Rent From</th>
                <th>Rent To</th>
                <th>Vacancy Periods</th>
            </tr>
        </thead>

        <tbody>
            <?php 
            if($filter_rooms) {
                foreach ($filter_rooms as $allotment) { ?>
                <tr>
                    <td><?php echo $allotment['id']; ?></td>
                    <td align="center"><?php echo $allotment['address']; ?></td>
                    <td align="center"><?php echo $allotment['floor']; ?></td>
                    <td align="center"><?php echo $allotment['room_type'] == "1" ? "Single" : "Double" ?> </td>
                    <td align="center"><?php echo $allotment['qty']; ?></td>
                    <td align="center"><?php echo $allotment['last_from_date'] == "" ? "" : date('d/m/Y', strtotime($allotment['last_from_date'])); ?></td>
                    <td align="center"><?php echo $allotment['last_to_date'] == "" ? "" : date('d/m/Y', strtotime($allotment['last_to_date'])); ?></td>
                    <td align="center">
                        <table class="table table-bordered table-striped">
                            <thead style="color: #000;font-weight: bold;">
                                <tr>
                                    <td>Vacancy Periods</td>
                                    <td>Days of Vacancy</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if($allotment['period']) {
                                    $days = 0;
                                    foreach ($allotment['period'] as $key => $value) {
                                        $days += $value['period_day'];
                                        $datetime1 = date_create($to_month);
                                        $datetime2 = date_create($allotment['last_to_date']);
                                        $interval = date_diff($datetime2, $datetime1);
                                        $final_diff = $interval->format('%a');
                                        ?>
                                        <tr>
                                            <td><?php echo $value['period_date']; ?></td>
                                            <td><?php echo $value['period_day']; ?></td>
                                        </tr>
                                        
                                        <?php
                                    }
                                        ?>
                                        <?php if(strtotime($allotment['last_to_date']) < strtotime($to_month)) {?>
                                                                <tr>
                                                                    <td><?php echo date('d/m/Y', strtotime($allotment['last_to_date']. ' +1 day')).' to '.date('d/m/Y', strtotime($to_month)); ?></td>
                                                                    <td><?php echo $final_diff; ?></td>
                                                                </tr>
                                                                <?php }?>
                                        <tr>
                                            <td align="right">Total Days: </td>
                                            <td><?php echo $days+$final_diff; ?></td>
                                        </tr>
                                        <?php
                                } else {$datetime1 = date_create($to_month);
                                                                $datetime2 = date_create($allotment['last_to_date']);
                                                                $interval = date_diff($datetime2, $datetime1);
                                                                $final_diff = $interval->format('%a');
                                    ?>
                                        <?php if(strtotime($allotment['last_to_date']) < strtotime($to_month)) {?>
                                                            <tr>
                                                                    <td><?php echo date('d/m/Y', strtotime($allotment['last_to_date']. ' +1 day')).' to '.date('d/m/Y', strtotime($to_month)); ?></td>
                                                                    <td><?php echo $final_diff; ?></td>
                                                                </tr>
                                                                <tr>
                                                                <td align="right">Total Days: </td>
                                                                <td><?php echo $final_diff; ?></td>
                                                            </tr>
                                                            <?php } else {?>
                                                            <tr>
                                                                <td colspan="2"><em>No vacancy...</em></td>
                                                            </tr>
                                                            <?php }?>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <?php 
                    } 
                }
                ?>
        </tbody>
    </table>

    <style type="text/css">
        table {
            border-collapse: collapse;width: 100%;margin:auto;
        }

        table, th, td {
            border: 1px solid black;
        }
    </style>