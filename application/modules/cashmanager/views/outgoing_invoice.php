
<h2>Invoice of oc No. <?php echo $outgoing_cost_id;?></h2>
<div>
  <?php foreach($outgoing_costs as $oc) {?>
    <?php if($oc['if_to_tenant']==1){?>
      <span><b>Payment By: </b><?php echo get_single_table_data_by_id($oc['tenant_user_id'], $field = "name", $table = "user").' '.get_single_table_data_by_id($oc['tenant_user_id'], $field = "family_name", $table = "user");?></span><br>
      <span><b>Company: </b><?php echo get_single_table_data_by_id($oc['tenant_user_id'], $field = "company_name", $table = "user");?></span><br>
      <span><b>Phone: </b><?php echo get_single_table_data_by_id($oc['tenant_user_id'], $field = "phone_no", $table = "user");?></span><br>
      <span><b>Email: </b><?php echo get_single_table_data_by_id($oc['tenant_user_id'], $field = "email", $table = "user");?></span><br><br>
    <?php } else if($oc['if_to_owner']==1){ ?>
      <span><b>Payment By: </b><?php echo get_single_table_data_by_id($oc['owner_user_id'], $field = "name", $table = "user").' '.get_single_table_data_by_id($oc['owner_user_id'], $field = "family_name", $table = "user");?></span><br>
      <span><b>Company: </b><?php echo get_single_table_data_by_id($oc['owner_user_id'], $field = "company_name", $table = "user");?></span><br>
      <span><b>Phone: </b><?php echo get_single_table_data_by_id($oc['owner_user_id'], $field = "phone_no", $table = "user");?></span><br>
      <span><b>Email: </b><?php echo get_single_table_data_by_id($oc['owner_user_id'], $field = "email", $table = "user");?></span><br><br>

    <?php } ?>
  <?php }?>
</div>
<table>
  <thead>
    <tr>
      <th>
        oc ID
      </th>
      <th>
        Property
      </th>
      <th>
        Room
      </th>
      <th>
        Cost
      </th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($outgoing_costs as $oc) {?>
      <tr>          
        <td><?php echo $oc['id']?></td>
        <td><?php echo $oc['apartment_id'].' - '.get_single_table_data_by_id($oc['apartment_id'], $field = "address", $table = "apartment_detail");?></td>
        <td><?php echo $oc['room_id'].' - ';echo get_single_table_data_by_id($oc['room_id'], $field = "room_type", $table = "rooms")== "1"?"Single Type":"Double Type";?></td>
        <td><?php echo $oc['oc_amount']?></td>
      </tr>
    <?php }?>
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
