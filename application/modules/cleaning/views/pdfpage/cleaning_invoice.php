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
    .no-top-border {
        border-top: 1px solid white;
    }
    .left, .bottom td {
        background: #fff !important;
    }

    .right, .left {
        border-right: 3px solid #d6d6d6 !important; 
    }

    .top td {
        border-top :none; 
    }

    .bottom td {
        border-top: none;
    }

    .bottom .left {
        border-top: none;
        border-right: none !important
    }

    .top .left {
        border-top: none;
    }

    .bottom .right {
        border-right: none !important;
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
            <p style="color: #004761;">Tel : 02072624267 Fax :</p>
        </td>
    </tr>
</table><br><br><br><br>
<table width="100%">
    <tr>
        <td width="65%">
                <span><b>Payment By: </b><?php echo get_single_table_data_by_id($user_id, $field = "name", $table = "user") . ' ' . get_single_table_data_by_id($user_id, $field = "family_name", $table = "user"); ?></span><br>
                <span><b>Company: </b><?php echo get_single_table_data_by_id($user_id, $field = "company_name", $table = "user"); ?></span><br>
                <span><b>Phone: </b><?php echo get_single_table_data_by_id($user_id, $field = "phone_no", $table = "user"); ?></span><br>
                <span><b>Email: </b><?php echo get_single_table_data_by_id($user_id, $field = "email", $table = "user"); ?></span><br><br>
        </td>
        <td width="35%" >
                <span><b>Invoice: </b><?php echo $invoice_no; ?></span><br>
                <span><b>Date: </b><?php echo date('d-m-Y',  strtotime($invoice_date));?></span><br>
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
                <td style="border-bottom: none;">
                    <br><br><p><b>&nbsp;&nbsp;&nbsp;&nbsp;OC ID:</b> <?php echo $oc_id; ?></p><br>
                </td>
                 <br><br><td style="border-bottom: none;"></td><br>
                <br><br><td style="border-bottom: none;"></td><br><br>
                <br><br><td style="border-bottom: none;" class="text-right"></td><br>       
            </tr>
            <tr>          
                <td style="border-top: none; border-bottom: none">
                    <p><b>&nbsp;&nbsp;&nbsp;&nbsp;Property:</b> <?php echo $apartment_id . ' - ' . get_single_table_data_by_id($apartment_id, $field = "address", $table = "apartment_detail"); ?></p><br><br>

                </td>
                <td style="border-top: none; border-bottom: none"></td><br><br>
                <td style="border-top: none; border-bottom: none"></td><br><br>
                <td style="border-top: none; border-bottom: none" class="text-right"></td><br><br>            
            </tr>
            <tr class="">          
                <td style="border-top: none; border-bottom: none">
                    <p><b>&nbsp;&nbsp;&nbsp;&nbsp;Room:</b> <?php
                    if($room_id)
                    {
                        echo $room_id . ' - ';
                        echo get_single_table_data_by_id($room_id, $field = "room_type", $table = "rooms") == "1" ? "Single Type" : "Double Type";
                        
                    }
                    else{
                        echo "Communal areas";
                    }
                    ?></p><br><br><br>
                        
                </td>
                <td style="border-top: none; border-bottom: none"></td><br><br><br>
                <td style="border-top: none; border-bottom: none"></td><br><br><br>
                <td style="border-top: none; border-bottom: none" class="text-right"></td><br><br><br>            
            </tr>
            <tr>          
                <td style="border-top: none;">
                    <p><b>&nbsp;&nbsp;&nbsp;&nbsp;Cost:</b> </p><br><br><br>

                </td>
                <td style="border-top: none;" class="text-right"><?php echo $cost;?></td><br><br><br>
                <td style="border-top: none;"  class="text-right">0 %</td><br><br><br>
                <td style="border-top: none;" class="text-right"></td><br><br><br>            
            </tr>
            <tr>          
                <td style="border-top: none;border-left: none;border-bottom: none;padding: 8px;" class="text-right">
                    <p><b>Sub Total:</b></p>
                </td>
                <td style="border-top: none;padding: 8px;" class="text-right"><?php echo $cost;?></td>
                <td style="border-top: none;border-right: none;padding: 8px;"></td>
                <td style="border-top: none;border-left: none;padding: 8px;" class="text-right">0.00</td>            
            </tr>
            <tr>          
                <td style="border-top: none;border-left: none;border-bottom: none;border-right: none;padding: 8px;" class="text-right">
                     <p><b>Total:</b></p>
                </td>
                <td style="border-top: none;border-left: none;border-bottom: none;border-right: none;padding: 8px;" class="text-right"></td>
                <td style="border-top: none;border-right: none;padding: 8px;"></td>
                <td style="border-top: none;border-left: none;padding: 8px;" class="text-right">&pound;<?php echo $cost;?> </td>            
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
