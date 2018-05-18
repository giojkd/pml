<h2>Invoice of General Cost No. <?php echo $gc_id;?></h2>
<table>
    <thead>
        <tr>
            <th>
                General Cost ID
            </th>
            <th>
                Property
            </th>
            <th>
                Cost Type
            </th>
            <th>
                Amount
            </th>
            <th>
                Expire Date
            </th>
            <th>
                Payment Date
            </th>
            <th>
                Status
            </th>
        </tr>
    </thead>
    <tbody>

        <tr>          
            <td><?php echo $generalcost['gc_id']?></td>
            <td><?php echo $generalcost['apartment_id'].' - '.get_single_table_data_by_id($generalcost['apartment_id'], $field = "address", $table = "apartment_detail");?></td>
            <td><?php echo service_charges($generalcost['cost_type']);?></td>
            <td><?php echo $generalcost['amount'];?></td>
            <td><?php echo date('d-m-Y H:i:s',  strtotime($generalcost['expire_date'])); ?></td>
            <td><?php echo date('d-m-Y H:i:s',  strtotime($generalcost['payment_date'])); ?></td>
            <td><?php echo $generalcost['payment_status'] == "1"?"Paid":"Due";?></td>
        </tr>

    </tbody>
</table>

<style type="text/css">
                        table {
    border-collapse: collapse;width: 100%;margin:auto;
}

table, th, td {
    border: 1px solid black;
    text-align: center;
}
                    </style>