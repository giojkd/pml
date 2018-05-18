                    
<h2 style="text-align: center"><?php echo $title; ?><br>
    <table class="table table-striped table-bordered table-hover display responsive nowrap datatable" width="100%">
        <thead>
            <tr>
                <th>Occupant Name</th>
                <th>Month</th>
                <th>Cost Type</th>
                <th>Cash Out</th>
                <th>Cash In</th>
            </tr>
        </thead>

        <tbody>
            <?php 
            $total_cost = 0; $total_revenue = 0;
            if($per_tenant_inout_cash && count($per_tenant_inout_cash) > 0) {
                foreach($per_tenant_inout_cash as $cash){
                    $cost = $cash->total_cost;
                    $revenue = $cash->total_revenue;

                    $total_cost += $cost;
                    $total_revenue += $revenue;
                    ?>
                    <tr>
                        <td><?php echo $cash->name.' '.$cash->family_name;?></td>
                        <td><?php echo date('M Y', strtotime($cash->payment_status_update_date)); ?></td>
                        <td><?php echo get_cost_type_label($cash->cost_type); ?></td>
                        <td align="right"><?php echo $currency.$cost; ?></td>
                        <td align="right"><?php echo $currency.$revenue; ?></td>                       
                    </tr>
                    <?php 
                } 
            }
            ?>
        </tbody>

        <tfoot>
            <tr>
                <td colspan="3">Total:</td>
                <td align="right"><?php echo $currency.number_format($total_cost, 2, '.', ''); ?></td>
                <td align="right"><?php echo $currency.number_format($total_revenue, 2, '.', ''); ?></td>
            </tr>
            <tr>
                <td>Cash Balance:</td>
                <td colspan="4" align="right">
                    <?php
                        $cash_balance=$total_revenue-$total_cost;
                        if($cash_balance<0)
                        {
                            echo '<p style="color:red;">'.$currency.number_format($cash_balance,2).'</p>';
                        }
                        else
                        {
                            echo '<p style="color:green;">'.$currency.number_format($cash_balance,2).'</p>';
                        }
                    ?>
                </td>
            </tr>
        </tfoot>
    </table>

    <style type="text/css">
        table {
            border-collapse: collapse;width: 100%;margin:auto;
        }

        table, th, td {
            border: 1px solid black;
        }
    </style>