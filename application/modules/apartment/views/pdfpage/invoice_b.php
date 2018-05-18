
<?php $total = $invoice_amount; ?>
<?php 
    $without_vat = $booking_details['booking_fee'] + $booking_details['admin_fee'];
    $vat = ((20 / 100) * $booking_details['admin_fee'])
?>
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
            <img src="<?php echo base_url('admin_assets/img/logo.png'); ?>"/>
        </td>
        <td width="35%" >
            <h3 style="color: #004761;">PML Services Ltd</h3>
            <p style="color: #004761;">13 Southwick Mews,</p>
            <p style="color: #004761;">London, W21JG</p>
            <p style="color: #004761;">Tel : 02072624267 Fax :</p>
        </td>
    </tr>
</table><br><br><br><br>
<table width="100%">
    <tr>
        <td width="65%">
        <span><b>Payment By: </b><?php echo getUser($booking_details['user_id'], "name").' '.getUser($booking_details['user_id'], "family_name"); ?></span><br>
        <span><b>Company: </b><?php echo getUser($booking_details['user_id'], "company_name"); ?></span><br>
        <span><b>Phone: </b><?php echo getUser($booking_details['user_id'], "phone_no"); ?></span><br>
        <span><b>Email: </b><?php echo getUser($booking_details['user_id'], "email"); ?></span><br><br>
        </td>
        <td width="35%" >
            <span><b>Invoice: </b><?php echo $invoice_no; ?></span><br>
            <span><b>Date: </b><?php echo date("d-m-Y"); ?></span><br>
        </td>
    </tr>
</table><br><br><br>
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
            <tr>          
                <td style="border-bottom: none; vertical-align: text-bottom">
                    <br>
                    Agent’s Introduction Fee for <?php echo $booking_details['apartment_id']."(".get_single_table_data_by_id($booking_details['apartment_id'], "address", "apartment_detail", "", "").")"; ?><br><br>
                    Initial Admin Fee for <?php echo $booking_details['apartment_id']."(".get_single_table_data_by_id($booking_details['apartment_id'], "address", "apartment_detail", "", "").")"; ?> <br><br><br>
                </td>
                <td style="vertical-align: bottom">
                    <?php echo $booking_details['booking_fee'];?>
                    <br><br>
                    <?php echo $booking_details['admin_fee'];?> <br><br><br>
                </td>
                <td>
                    <br><br><br><br>20<br><br><br>
                </td>
                <td class="text-right"><br><br><br><br><?php echo $vat;?><br><br><br></td>      
            </tr>

            <tr>          
                <td style="border-left: none;border-bottom: none;padding: 8px;" class="text-right">
                    <p><b>Sub Total:</b></p>
                </td>
                <td style="padding: 8px;" class="text-right"> <?php echo $without_vat; ?></td>
                <td style="border-top: none;border-right: none;padding: 8px;"></td>
                <td style="border-top: none;border-left: none;padding: 8px;" class="text-right"><?php echo $vat;?> </td>            
            </tr>
            <tr>          
                <td style="border-top: none;border-left: none;border-bottom: none;border-right: none;padding: 8px;" class="text-right">
                     <p><b>Total:</b></p> 
                </td>
                <td style="border-top: none;border-left: none;border-bottom: none;border-right: none;padding: 8px;" class="text-right"></td>
                <td style="border-top: none;border-right: none;padding: 8px;"></td>
                <td style="border-top: none;border-left: none;padding: 8px;" class="text-right">&pound;<?php echo $total;?></td>            
            </tr>
    </tbody>
</table><br><br><br><br><br>

<table width="100%">
    <tr>
        <td width="50%">
            <b>
                <span>Deposit Account:</span><br>
                <span>Bank Account Name: Client Deposit PML</span><br>
                <span>Sort Code: 20-69-15</span><br>
                <span>Account Number: 70145823</span><br>
                <span>Reference: Please add your name as a reference</span><br>
                <span>BIC: BARCGB22, IBAN: GB30BARC20691570145823</span><br><br>
            </b>
        </td>
        <td width="50%" >
            <b>
                <span>Licence Fee and other Fees:</span><br>
                <span>Bank Account Name: PML Services Ltd</span><br>
                <span>Sort Code: 20-69-15</span><br>
                <span>Account Number: 00266574</span><br>
                <span>Reference: Please add your name as a reference</span><br>
                <span>BIC: BARCGB22, IBAN: GB28BARC20691500266574</span><br><br>
            </b>
        </td>
    </tr>
</table><br><br><br><br><br>
<footer>
    <p align="center" style="font-size: 18px;"><a href="administration@pmlservices.co.uk">administration@pmlservices.co.uk</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="www.pmlservices.co.uk">www.pmlservices.co.uk</a></p>
    <p style="color: #004761; font-size: 14px;" align="center">Company Reg No : 08994009</p>
</footer>
