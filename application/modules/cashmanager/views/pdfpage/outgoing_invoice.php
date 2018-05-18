
<style type="text/css">
.table-border {
  border-collapse: collapse;
  width: 100%;
  margin:auto;
}

.table-border tr td, .table-border tr th{
  border: 1px solid black;
}
.text-right {
  text-align: right;
}
.left {
  float: left;
}
.right {
  float: right;
}
a {
  text-decoration: none !important;
  color: #004761;
}
footer {
  position: fixed;
  bottom: 0px;
  left: 0px;
  right: 0px;
}

</style>

<table width="100%">
  <tr>
    <td width="65%">
      <img src="<?php echo $_SERVER['DOCUMENT_ROOT']?>/ap4rent/backend/admin_assets/img/logo.png"/>
    </td>
    <td width="35%" >
      <h3 style="color: #004761;">PML Services Ltd</h3>
      <p style="color: #004761;">13 Southwick Mews,</p>
      <p style="color: #004761;">Tel : 02072624267 Fax :</p>
    </td>
  </tr>
</table><br>
<table width="100%">
  <tr>
    <td width="65%">


<span><b>Payment By: </b><?php echo $user['name'].' '.$user['family_name']?></span><br/>
<span><b>Email: </b><?php echo $user['email']?></span>




    </td>
    <td width="35%" >
      <span><b>Invoice: </b><?php echo $invoice['invoice_no']; ?></span><br>
      <span><b>Date: </b><?php echo $invoice['create_date'] == "0000-00-00"? date('d-m-Y'): date('d-m-Y',  strtotime($invoice['create_date'])); ?></span><br>
      <span><b>Due date: </b><?php echo $invoice['payment_due_date'] == "0000-00-00"? date('d-m-Y'): date('d-m-Y',  strtotime($invoice['payment_due_date'])); ?></span><br>
    </td>
  </tr>
</table><br>
<table class="table-border">
  <thead>
    <tr style="background-color: #DBDBDB;">
      <th style="padding: 8px;">DESCRIPTION</th>
      <th style="padding: 8px;">AMOUNT</th>
      <th style="padding: 8px;">VAT %</th>
      <th style="padding: 8px;">VAT</th>
    </tr>
  </thead>
  <tbody>
    <?php
    function invoice_cost_label($oc){

      $oc_type[1] = "Apartment cost";
      $oc_type[2] = "Installment";
      $oc_type[3] = "Apartment contract cost";
      $oc_type[4] = "General cost";
      $oc_type[5] = "Deposit fee";
      $oc_type[6] = "Booking fee";
      $oc_type[7] = "Admin fee";
      $oc_type[8] = "Bill";
      $return = $oc_type[$oc['cost_for']];
      if($oc['cost_for']==2 && $oc['first_two_months']==1){
        $return = "First two months";
      }
      return $return;
    }

    foreach($outgoing_costs as $oc) {?>

      <tr>
        <td style="border-top: none; border-bottom: none">
          <p><b>&nbsp;&nbsp;&nbsp;&nbsp;Property:</b> <?php echo $oc['apartment_id'] . ' - ' . get_single_table_data_by_id($oc['apartment_id'], $field = "address", $table = "apartment_detail"); ?></p><br>

        </td>
        <td style="border-top: none; border-bottom: none"></td><br>
        <td style="border-top: none; border-bottom: none"></td><br>
        <td style="border-top: none; border-bottom: none" class="text-right"></td><br>
      </tr>
      <tr class="">
        <td style="border-top: none; border-bottom: none">
          <p><b>&nbsp;&nbsp;&nbsp;&nbsp;Room:</b> <?php
          echo $oc['room_id'] . ' - ';
          echo get_single_table_data_by_id($oc['room_id'], $field = "room_type", $table = "rooms") == "1" ? "Single Type" : "Double Type";
          ?></p><br>
        </td>
        <td style="border-top: none; border-bottom: none"></td><br>
        <td style="border-top: none; border-bottom: none"></td><br>
        <td style="border-top: none; border-bottom: none" class="text-right"></td><br>
      </tr>
      <tr>
        <td style="border-top: none;">

          <p><b>&nbsp;&nbsp;&nbsp;&nbsp;Cost:</b> <?php echo invoice_cost_label($oc); ?></p><br>

        </td>
        <td style="border-top: none;" class="text-right"><?php echo $oc['revenue_amount'];?></td><br>
        <td style="border-top: none;"  class="text-right">0 %</td><br>
        <td style="border-top: none;" class="text-right"></td><br>
      </tr>


      <?php
      $total+=$oc['revenue_amount'];
    }?>
    <tr>
      <td style="border-top: none;border-left: none;border-bottom: none;border-right: none;padding: 8px;" class="text-right">
        <p><b>Total:</b></p>
      </td>
      <td style="border-top: none;border-left: none;border-bottom: none;border-right: none;padding: 8px;" class="text-right"></td>
      <td style="border-top: none;border-right: none;padding: 8px;"></td>
      <td style="border-top: none;border-left: none;padding: 8px;" class="text-right">&pound;<?php echo $total;?></td>
    </tr>
  </tbody>
</table><br>

<table width="100%">
  <tr>
    <td width="50%">
      <b>
        <span>Deposit Account:</span><br>
        <span>Bank Account Name: Client Deposit PML</span><br>
        <span>Sort Code: 20-69-15</span><br>
        <span>Account Number: 70145823</span><br>
        <span>Reference: Please add your name as a reference</span><br>
        <span>BIC: BARCGB22, IBAN: GB30BARC20691570145823</span><br>
      </b>
    </td>
    <td width="50%" >
      <b>
        <span>Licence Fee and other Fees:</span><br>
        <span>Bank Account Name: PML Services Ltd</span><br>
        <span>Sort Code: 20-69-15</span><br>
        <span>Account Number: 00266574</span><br>
        <span>Reference: Please add your name as a reference</span><br>
        <span>BIC: BARCGB22, IBAN: GB28BARC20691500266574</span><br>
      </b>
    </td>
  </tr>
</table><br>
<footer>
  <p align="center" style="font-size: 18px;"><a href="administration@pmlservices.co.uk">administration@pmlservices.co.uk</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="www.pmlservices.co.uk">www.pmlservices.co.uk</a></p>
  <p style="color: #004761; font-size: 14px;" align="center">Company Reg No : 08994009</p>
</footer>
