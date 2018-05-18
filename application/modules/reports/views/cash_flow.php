<pre>
  <?php #print_r($cash_flow);?>
</pre>
<div class="panel panel-success">
  <div class="panel-heading clearfix">
    <h2 class="panel-title"><?php echo $title; ?></h2>
  </div>

  <div class="panel-body">
    <div class="btn-group margin-bottom-10">
      <a href="<?php echo base_url_tr() ?>reports/cash_flow_pdf/<?php echo $year; ?>" class="btn purple"><i class="fa fa-file-pdf-o"></i> PDF</a>
    </div>
    <div class="btn-group margin-bottom-10">
      <a href="#cashFlowModal" class="btn purple" data-toggle="modal"><i class="fa fa-calendar"></i> Choice Date</a>
    </div>

    <?php echo $this->session->flashdata('save_success') ? $this->session->flashdata('save_success') : ''; ?>
    <table class="table table-striped table-bordered table-hover display responsive nowrap cashflow-table" width="100%">
      <thead>
        <tr>
          <th>Due Date</th>
          <th>Description</th>
          <th>Billing Number <br/> (if available)</th>
          <th>Supplier / Owner / Occupant</th>
          <th>Cost Code <br/> (if available)</th>
          <th width="40px">In</th>
          <th width="40px">Out</th>
          <th width="40px">Status</th>
        </tr>
      </thead>

      <tbody>
        <?php
        $total_cost = 0;
        $total_revenue = 0;
        $entrance = 0;
        $bank_balance = 0;
        $exit = 0;

        if (count($cash_flow) > 0) {
          ?>
          <tr>
            <!--Due Date-->
            <!--<td align="right" colspan="5"><?php echo $year ? mydate($year,'-') : '01-01- '. date('Y'). ' to ' . '31-12-' . date('Y'); ?></td>-->
            <td colspan="5"></td>
            <!--Description-->
            <td align="right" class="hidden"></td>
            <!--Billing Number-->
            <td align="right" class="hidden"></td>
            <!--Supplier / Owner / Tenant-->
            <td align="right" class="hidden"></td>
            <!--Code Payment-->
            <td align="right" class="hidden"></td>
            <!--Cash In-->

            <!--Cash Out-->
            <td align="right">Previous Year Initial Amount: <?php echo $currency; ?> <?php echo $previous_year_amount > 0 ? $previous_year_amount : 0; ?></td>
            <td align="right">Previous Year Initial Amount: <?php echo $currency; ?> <?php echo $previous_year_amount < 0 ? abs($previous_year_amount) : 0; ?></td>
            <td></td>
          </tr>
          <?php
          //echo "<pre>";

          foreach ($cash_flow as $cf) {

            //print_r($cf);

            if($cf->movement_type == "1")
            {
              $entrance =  $entrance +  $cf->movement_amount;
            }
            else if($cf->movement_type == "2")
            {
              $exit = $exit +  $cf->movement_amount;
            }


            $cost = $cf->total_cost;
            $revenue = $cf->total_revenue;

            $total_cost += $cost + $exit;
            $total_revenue += $revenue + $entrance;
            ?>
            <tr>
              <!--Due Date-->
              <td><?php echo mydate($cf->payment_date,'-'); ?></td>
              <!--Description-->
              <td>
                <?php
                /*
                1=oc (apartment cost),
                2=installment,
                3= oc(apartment contract cost),
                4=oc(general cost),
                5=cash in(deposit fee),
                6=cash in(booking fee amount),
                7=cash in(admin fee amount),
                8 = bill;
                */
                if ($cf->cost_for == 3) {
                  echo 'Rent:' . $cf->apt_address . '<br/>';
                }else if($cf->cost_for == 4){
                  echo $cf->description;
                }else if($cf->cost_for == 2){
                  echo 'Installment: '.$cf->room_description.' ('.$cf->apt_address.')';
                }else if($cf->cost_for == 5){
                  echo 'Deposit: '.$cf->room_description.' ( '.$cf->apt_address.') ';
                }else if($cf->cost_for == 6){
                  echo 'Booking fee: '.$cf->room_description.' ( '.$cf->apt_address.') ';
                }
                else if($cf->cost_for == 7){
                  echo 'Admin fee: '.$cf->room_description.' ( '.$cf->apt_address.') ';
                }
                else if($cf->cost_for == 1){
                  echo 'Maintenance';
                }else if($cf->cost_for == 8){
                  echo 'Bill: '.$cf->supplier_company.' ('.$cf->apt_address.')';
                }else if($cf->cost_for == 9){
                  echo 'Cleaning';
                }
                ?>
              </td>
              <!--Billing Number-->
              <td>
                <?php
                echo (!empty($cf->invoice_no)) ? $cf->invoice_no : 'N/A' ;
                ?>
              </td>
              <!--Supplier / Owner / Tenant-->
              <td>
                <?php
                if ($cf->cost_for == 1 && $cf->if_to_tenant && !$cf->if_to_owner) {
                  echo $cf->apt_tenant;
                }else if($cf->cost_for == 1 && !$cf->if_to_tenant && $cf->if_to_owner){
                  echo $cf->apt_owner;
                }else if($cf->cost_for == 2){
                  echo $cf->apt_tenant;
                }else if($cf->cost_for == 7){
                  echo $cf->apt_tenant;
                }else if($cf->cost_for == 3){
                  echo $cf->apt_owner;
                }else if($cf->cost_for == 4 && $cf->gc_type == 1){
                  echo $cf->supplier;
                }else if($cf->cost_for == 5 || $cf->cost_for == 6){
                  echo $cf->apt_owner;
                }else{
                  echo 'N/A';
                }
                ?>
              </td>
              <!--Code Payment-->
              <td>
                <?php
                if($cf->cost_code){
                  echo $cf->cost_code; //data is not available
                }else{
                  echo 'N/A';
                }
                ?>
              </td>
              <!--Cash In-->
              <td align="right"><?php echo (($revenue>0) ? $currency.$revenue: '') ; ?></td>
              <!--Cash Out-->
              <td align="right"><?php echo (($cost>0) ? $currency.$cost : ''); ?></td>
              <!--Payment Status-->
              <td>
                <?php

                if($cf->payment_status){
                  echo '<p class="label label-success">Paid</p>';
                }else{
                  echo '<p class="label label-danger">Not Paid</p>';
                }

                ?>
              </td>
            </tr>
            <?php
          }
          if ($previous_year_amount > 0) {
            #$total_revenue = $total_revenue + $previous_year_amount;
            $total_revenue = $total_revenue;
          }
          if ($previous_year_amount < 0) {
            #$total_cost = $total_cost + abs($previous_year_amount);
            $total_cost = $total_cost;
          }
        }
        ?>
      </tbody>

      <tfoot>
        <tr>
          <td colspan="5">Movement Amount:</td>
          <td align="right"><?php echo $currency . number_format($entrance, 2); ?></td>
          <td align="right"><?php echo $currency . number_format($exit, 2); ?></td>
          <td></td>
        </tr>
        <tr>
          <td colspan="5"><strong>Total:</strong></td>
          <td><?php echo $currency . $total_revenue; ?></td>
          <td><?php echo $currency . $total_cost; ?></td>
          <td></td>
        </tr>
        <tr>
          <td><strong>Cash Balance:</strong></td>
          <td colspan="6">
            <?php
            $cash_balance = $total_revenue - $total_cost;
            if ($cash_balance < 0) {
              echo '<p style="color:red;">' . $currency . number_format($cash_balance, 2) . '</p>';
            } else {
              echo '<p style="color:green;">' . $currency . number_format($cash_balance, 2) . '</p>';
            }
            ?>
          </td>
          <td></td>
        </tr>
        <tr>
          <td><strong>Bank Balance:</strong></td>
          <td colspan="6">
            <?php
            $bank_balance = $entrance - $exit;
            if ($bank_balance < 0) {
              echo '<p style="color:red;">' . $currency . number_format($bank_balance, 2) . '</p>';
            } else {
              echo '<p style="color:green;">' . $currency . number_format($bank_balance, 2) . '</p>';
            }
            ?>
          </td>
          <td></td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

<!-- Detail Costs Modal -->
<div id="cashFlowModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <form method="get" action="<?php echo base_url('reports/cash_flow') ?>">
        <div class="modal-body">
          <div class="form-group">
            <div class="controls">
              <input type="text" value="<?php echo $year ? $year : ''; ?>" name="cash_flow_year" placeholder="Year" class="form-control" required />
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>

  </div>
</div>

<script>
$(document).on('ready', function () {
  $('input[name="cash_flow_year"]').datetimepicker({
    timepicker: false,
    format: 'd-m-Y',
    mask: true,
    minDate: '<?php echo date('d-m-Y', strtotime('+1 day')); ?>', //or 1986/12/08,
    theme: 'dark'
  });

  $('.cashflow-table').dataTable({
    "aaSorting": [],
    "pageLength": 200
  });
});
</script>
