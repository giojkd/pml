
<div class="panel panel-success">
  <div class="panel-heading clearfix">
    <h2 class="panel-title"><?php echo $title; ?></h2>
  </div>

  <div class="panel-body">
    <div class="btn-group margin-bottom-10">
      <!--<a href="<?php //echo base_url_tr('general_cost') ?>" class="btn green"><i class="icon-plus"></i> <?php //echo lang('label_add_new') ?></a>-->
    </div>
    <?php if ($this->session->flashdata('payment_status_update')): ?>
      <div class="alert alert-success alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <strong>Success!</strong> <?php echo $this->session->flashdata('payment_status_update'); ?>
      </div>
    <?php endif; ?>
    <?

    ?>
    <table class="table table-striped table-bordered table-hover display responsive nowrap" id="installment_lists" width="100%">
      <thead>
        <tr>
          <th>ID</th>
          <th>Invoice No</th>
          <th>Invoice Type</th>
          <th>Description</th>
          <th>Occupant Name</th>
          <!--<th>Room</th>-->
          <th>Amount</th>
          <th>Due Payment Date</th>
          <th>Payment Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>

        <?php

        foreach ($invoices as $value): ?>
          <tr>
            <td><?php echo $value['invoice_id']?></td>
            <td><?php echo $value['invoice_no']; ?></td>
            <td>
              <?php
              if($value["invoice_type"] == "0") {
                echo "PML Service";
              }
              else if($value["invoice_type"] == "1"){
                echo "PML Management";
              }
              ?>
            </td>
            <td>
              <?php
              if($value["invoice_of"] == "4") {
                echo "Admin fee + Booking fee";
              }
              else if($value["invoice_of"] == "2"){
                echo "2 months installment + deposit";
              }
              else if($value["invoice_of"] == "3"){
                echo "general cost";
              }
              else if($value["invoice_of"] == "5"){
                echo "maintenance cost";
              }
              else if($value["invoice_of"] == "6"){
                echo "general cost";
              }
              /*
              if($value["oc_id"])
              {
                $apartment_id = get_single_table_data_by_id("", "apartment_id", 'cost',"id",$value["oc_id"]);
                $room_id = get_single_table_data_by_id("", "room_id", 'cost',"id",$value["oc_id"]);
                $apartment_address = get_single_table_data_by_id("", "address", 'apartment_detail',"id",$apartment_id);
                echo $apartment_address.($room_id?' / <b>Room: </b>'.$room_id:"");
              }
              else if($value["gc_id"])
              {
                $apartment_id = get_single_table_data_by_id("", "apartment_id", 'cost',"id",$value["gc_id"]);
                $room_id = get_single_table_data_by_id("", "room_id", 'cost',"id",$value["gc_id"]);
                $apartment_address = get_single_table_data_by_id("", "address", 'apartment_detail',"id",$apartment_id);
                echo $apartment_address.($room_id?' / <b>Room: </b>'.$room_id:"");
              }
              else if($value["installment_id"])
              {
                $apartment_id = get_single_table_data_by_id("", "apartment_id", 'cost',"id",$value["installment_id"]);
                $room_id = get_single_table_data_by_id("", "room_id", 'cost',"id",$value["installment_id"]);
                $apartment_address = get_single_table_data_by_id("", "address", 'apartment_detail',"id",$apartment_id);
                echo $apartment_address.($room_id?' / <b>Room: </b>'.$room_id:"");

              }*/
              ?>
            </td>
            <td>
              <?php #echo get_tenant_name($value["invoice_of"],$value["oc_id"],$value["installment_id"]); ?>
              <?php echo $value["user_name"].' '. $value["user_surname"];; ?>
            </td>
            <!--<td><?php //echo $value['room_id'].' ( '.get_single_table_data_by_id($value['apartment_id'], $field = "address", $table = "apartment_detail").' )'; ?></td>-->
            <td>£ <?php echo $value["invoice_amount"]; ?></td>
            <!-- <td><?php echo mydate($value['create_date'],"-"); ?></td> -->
            <td>
              <?php
              echo $value['payment_due_date'];
              /*
              if($value["oc_id"])
              {
                $payment_status_update_date = get_single_table_data_by_id("", "payment_status_update_date", 'cost',"id",$value["oc_id"]);
                echo $payment_status_update_date != "0000-00-00"?"Paid":mydate(get_single_table_data_by_id("", "payment_date", 'cost',"id",$value["oc_id"]),'-');
              }
              else if($value["gc_id"])
              {
                $payment_status_update_date = get_single_table_data_by_id("", "payment_status_update_date", 'cost',"id",$value["gc_id"]);
                echo $payment_status_update_date != "0000-00-00"?"Paid":mydate(get_single_table_data_by_id("", "payment_date", 'cost',"id",$value["gc_id"]),'-');
              }
              else if($value["installment_id"])
              {
                $payment_status_update_date = get_single_table_data_by_id("", "payment_status_update_date", 'cost',"id",$value["installment_id"]);
                echo $payment_status_update_date != "0000-00-00"?"Paid":mydate(get_single_table_data_by_id("", "payment_date", 'cost',"id",$value["installment_id"]),'-');

              }*/
              ?>
            </td>
            <td>
              <?php

              if($value["oc_id"])
              {
                $payment_status_update_date = get_single_table_data_by_id("", "payment_status_update_date", 'cost',"id",$value["oc_id"]);
                echo $payment_status_update_date != "0000-00-00"?mydate($payment_status_update_date,'-'):"Unpaid";
              }
              else if($value["gc_id"])
              {
                $payment_status_update_date = get_single_table_data_by_id("", "payment_status_update_date", 'cost',"id",$value["gc_id"]);
                echo $payment_status_update_date != "0000-00-00"?mydate($payment_status_update_date,'-'):"Unpaid";
              }
              else if($value["installment_id"])
              {
                $payment_status_update_date = get_single_table_data_by_id("", "payment_status_update_date", 'cost',"id",$value["installment_id"]);
                echo $payment_status_update_date != "0000-00-00"?mydate($payment_status_update_date,'-'):"Unpaid";

              }
              ?>
            </td>
            <th class="text-right">
              <?php if($value["invoice_type"] == "1") {?>
                <a type="button" class="btn btn-sm btn-primary" href="<?php echo base_url('cashmanager/revenue/installment_invoice_pdf/' . $value['invoice_id']); ?>">Download Invoice</a>
              <?php } ?>

              <?php if($value["invoice_type"] == "0") {?>
                <a type="button" class="btn btn-sm btn-primary" href="<?php echo base_url('cashmanager/outgoing/outgoing_invoice_pdf/' . $value['invoice_id']); ?>">Download Invoice</a>
              <?php } ?>
            </th>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal -->
<div id="paymentDateModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Payment Date</h4>
      </div>
      <form method="post" action="<?php echo base_url('cashmanager/revenue/update_installment_payment_status')?>">
        <div class="modal-body">
          <p><b>Installment ID: <span id="cost_id"></span></b></p>
          <input type="text" name="payment_date" id="add_payment_date" class="form-control" required/>
          <input type="hidden" name="id" id="gc_id" value=""/>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>

  </div>
</div>

<script type="text/javascript">

$(document).ready(function () {
  $('#installment_lists').dataTable({
    responsive: true,
  });
});


$(document).ready(function () {

  $(document).on("click", ".open-AddDateDialog", function () {
    var mygcId = $(this).data('id');
    $(".modal-body #gc_id").val(mygcId);
    $(".modal-body #cost_id").html(mygcId);
    // As pointed out in comments,
    // it is superfluous to have to manually call the modal.
    // $('#addBookDialog').modal('show');
  });
  $("#add_payment_date").datetimepicker({
    format: 'd-m-Y',
    pickTime: false,
  });
});
</script>
