Mrs/Mr <?php echo $booking_details["name"]." ".$booking_details["family_name"]; ?><br><br>
Our Ref : <?php echo $booking_details["booking_id"] ?><br><br>
<?php echo date("d-m-Y"); ?>
<br><br>
Dear <?php echo $booking_details["name"]." ".$booking_details["family_name"]; ?>,<br><br>
Re : Contract Expiry Letter<br><br>

We note the contract ends on <?php echo mydate($booking_details["rent_to"],"-"); ?>. We should be grateful if you would vacate <br>
the Property in accordance with Clause 10 and adhering at all times to the contract.<br><br>

If however you would like to enter into a new contract commencing <?php echo mydate($booking_details["rent_to"],"-"); ?><br>
we would be delighted to provide you with the same.<br><br>
If you would like to enter into a new contract or serve notice we require your confirmation<br>
in writing as soon as possible before <?php echo mydate(date('Y-m-d',date(strtotime("+5 day", strtotime($booking_details["rent_to"])))),"-"); ?>.<br><br>
Please note that from <?php echo mydate($booking_details["rent_to"],"-"); ?> the monthly payment for the Property will<br>
increase to £_______.<br><br>

We want to inform you that if you decide to sign a renewal contract, the fees (other than<br>
the monthly Licence Fee) under the new contract will be subject to 20% VAT. The renewal<br>
admin fee payable upon signing the renewal contract will therefore be £50.00 + 20% VAT<br>
(totalling £60.00) and the Check Out Inventory Fee will be £75.00 + 20% VAT (totalling<br>
£90.00) etc. Again, this is not applicable on your Monthly Licence Fee.<br><br>

Yours sincerely,<br>
PML Services Ltd
