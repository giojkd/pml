                    
<h2 style="text-align: center"><?php echo $title; ?><br>
    <table>
        <thead>
            <tr>
                <th width="100">Year</th>
                <th>Description</th>
                <th>Cash Out</th>
                <th>Cash In</th>
            </tr>
        </thead>

        <tbody>
            <?php 
            $total_cost = 0; $total_revenue = 0;
            if(count($cash_flow) > 0) {
                ?>
                <tr>
                    <td align="right"><?php echo $year-1; ?></td>
                    <td></td>
                    <td align="right">Previous Year Initial Amount: <?php echo $currency; ?> <?php echo $previous_year_amount <0 ? abs($previous_year_amount) : 0; ?></td>
                    <td align="right">Previous Year Initial Amount: <?php echo $currency; ?> <?php echo $previous_year_amount >0 ? $previous_year_amount : 0; ?></td>
                </tr>
                <?php
                foreach ($cash_flow as $cf) { 
                    $cost = $cf->total_cost;
                    $revenue = $cf->total_revenue;

                    $total_cost += $cost;
                    $total_revenue += $revenue;
                    ?>
                    <tr>
                        <td align="right"><?php echo mydate($cf->payment_date,'-'); ?></td>
                        <td>
                        	<?php 
                        		if($cf->owner_user_id)
                        		{
                        			$name = $cf->apt_owner;
                        			$company = get_single_table_data_by_id($cf->owner_user_id, "company_name", "user","","");
                        		}
                        		else if($cf->tenant_user_id)
                        		{
                        			$name = $cf->apt_tenant;
                        			$company = get_single_table_data_by_id($cf->tenant_user_id, "company_name", "user","","");
                        		}
                        		else if($cf->supplier_id)
                        		{
                        			$name = $cf->supplier;
                        			$company = get_single_table_data_by_id($cf->supplier_id, "company", "suppliers","","");
                        		}
                        		echo $name.($company?' ('.$company.')':"").($cf->apartment_id?' - '.get_single_table_data_by_id($cf->apartment_id, "address", "apartment_detail","",""):'').($cf->room_id?' / '.$cf->room_id:'').($cf->payment_date?' - '.$cf->payment_date:'');
                        		
                        	?>
                        </td>
                        <td align="right"><?php echo $currency.$cost; ?></td>
                        <td align="right"><?php echo $currency.$revenue; ?></td>
                    </tr>
                    <?php 
                }
                if($previous_year_amount>0) {
                    $total_revenue = $total_revenue+$previous_year_amount;
                }
                if($previous_year_amount<0) {
                    $total_cost = $total_cost+abs($previous_year_amount);
                }
            }
            ?>
        </tbody>

        <tfoot>
            <tr>
                <td>Total:</td>
                <td><?php echo $currency.$total_cost; ?></td>
                <td><?php echo $currency.$total_revenue; ?></td>
            </tr>
            <tr>
                <td>Cash Balance:</td>
                <td colspan="2">
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