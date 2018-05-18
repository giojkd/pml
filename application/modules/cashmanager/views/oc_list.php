<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title"><?php echo $title; ?></h2>
    </div>

    <div class="panel-body">
        <div class="btn-group margin-bottom-10">
            <a href="<?php echo base_url_tr() ?>cashmanager/outgoing/oc_add" class="btn green"><i class="icon-plus"></i> <?php echo lang('label_add_new') ?></a>
        </div>
        <?php echo $this->session->flashdata('save_success') ? $this->session->flashdata('save_success') : ''; ?>
        <table class="maintenance-cost table table-striped table-bordered table-hover display responsive nowrap datatable" width="100%" id="abcd">
            <thead>
                <tr>
                  <th>#</th>
                    <th width="30px">Property ID</th>
                    <th>Property</th>
                    <th>Job Description</th>
                    <th>Reported Date</th>
                    <th>Comments</th>
                    <th>Reported by</th>
                    <th>Internal PML</th>
                    <th>Contractor's name </th>
                    <th>Who Pays</th>
                    <th>Contractor's Cost</th>
                    <th>Invoice Amount</th>
                    <th>Send Invoice</th>
                    <th>All Done?</th>
                    <th>Job Duration</th>
                    <th>Profit/Loss</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    foreach ($costs as $value) {
                        ?>
                        <tr class="odd gradeX">
                          <td><?php echo $value['id']?></td>
                            <td><?php echo $value["apartment_id"]=="0"?"All":$value["apartment_id"]; ?></td>
                            <td><?php echo $value["ap_name"]." ".$value["ap_family_name"]; ?></td>
                            <td><?php echo $value["job_description"]; ?></td>
                            <td><?php echo $value["reported_date"] != "" ? mydate($value["reported_date"],"-") : ""; ?></td>
                            <td>
                                <textarea class="cost-comment"><?php echo $value["comments"]; ?></textarea>
                            </td>
                            <td><?php echo $value["reported_by"]; ?></td>
                            <td><?php echo $value["internal_pml"]; ?></td>
                            <td><?php echo $value['supplier_id'] > 0 ? $value['company']." - ".$value['supplier_surname']." ".$value['supplier_name']:''; ?></td>
                            <td><?php
                                if($value["if_to_tenant"] == 1) {
                                    echo $value['name']." ".$value['family_name'];
                                }
                                else {
                                    echo $value['owner_name']." ".$value['owner_family_name'];
                                }
                                ?></td>
                            <td>
                                <input type="hidden" class="cost_id" value="<?php echo $value['id']; ?>"/>
                                <?php if($value['oc_amount'] == "" || $value['oc_amount'] == '0.00') { ?>
                                <input type="text" value="<?php echo $value['oc_amount']; ?>" class="oc_amount"/>
                                <button type="button" class="btn btn-primary btn-cost-save">Add Amount</button>
                                <?php } else { ?>
                                    <?php echo $value['oc_amount']; ?>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if($value['invoice_amount'] == "" || $value['invoice_amount'] == 0) { ?>
                                <input type="hidden" class="invoice_id" value="<?php echo $value['invoice_id']; ?>"/>
                                <input type="text" value="<?php echo $value['invoice_amount']; ?>" class="invoice_amount"/>
                                <button type="button" class="btn btn-primary btn-invoice-save">Add Amount</button>
                                <?php } else { ?>
                                    <?php echo $value['invoice_amount']; ?>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if($value['send_invoice_status'] == 0) { ?>
                                    <a href="<?php echo base_url_tr('cashmanager/outgoing/send_invoice/' . $value['id']); ?>"
                                       class="btn-invoice btn btn-primary">Send Invoice</a>
                                    <?php
                                } else {
                                    echo "<a href='#' class='btn btn-primary'>Sent</a>";
                                }
                                ?>
                            </td>
                            <td>
                                <button type="button" data-value="<?php echo $value['job_done_status'] == 0 ? 1 : 0; ?>" class="btn btn-primary job-done" data-reported-date="<?php echo $value['reported_date']; ?>" <?php echo $value['job_done_status']=="1"? "disabled" : ""; ?>><?php echo $value['job_done_status'] == 0 ? 'Job Done' : 'JOB DONE on '.mydate($value['job_done_date'],"-"); ?></button>

                                <?php if($value['job_done_status'] == "0") {?>
                                <input class="form-control job-done-date" id="job-done-date-<?php echo $value['id']; ?>" type="text" value="<?php echo $value['job_done_date']? mydate($value['job_done_date'],'-'):date("d-m-Y"); ?>">
                                <?php } ?>
                            </td>
                            <td><?php echo $value['job_duration']; ?></td>
                            <td><?php echo $value['oc_amount']-$value['invoice_amount']; ?></td>
                            <td>
                                <!--<a class="btn mini purple" href="<?php //echo base_url(); ?>cashmanager/outgoing/oc_edit/<?php //echo $value["id"]; ?>"><i class="icon-pencil"></i></a>-->
                                <!--<a class="btn mini red delete confirm btn-sm" href="<?php //echo base_url(); ?>cashmanager/outgoing/oc_delete/<?php //echo $value["id"]; ?>"><i class="icon-trash"></i></a>-->
                                <!-- <?php if($value['if_to_owner']==1 || $value['if_to_tenant']==1){?>
                                    <a type="button" class="btn btn-sm btn-primary" href="<?php //echo base_url('cashmanager/outgoing/outgoing_invoice_pdf/' . $value['id']); ?>">Invoice</a>
                                <?php } ?> -->
                            </td>
                        </tr>
                        <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(".maintenance-cost").on('click', '.btn-invoice-save', function (event) {
            var button = $(this);
            var invoice_id = button.parents('tr').find('.invoice_id').val();
            var invoice_amount = button.parents('tr').find('.invoice_amount').val();

            $.ajax({
                url: baseUrl + "cashmanager/outgoing/ajax_save_price",
                data: {
                    invoice_id : invoice_id,
                    invoice_amount : invoice_amount,
                },
                type: "POST",
                dataType: 'json',
                success: function(result){
                    if(result == 1) {
                        alert('Successfully Saved');
                    }
                }
            });
        });

        $(".maintenance-cost").on('click', '.btn-cost-save', function (event) {
            var button = $(this);
            var cost_id = button.parents('tr').find('.cost_id').val();
            var cost_amount = button.parents('tr').find('.oc_amount').val();

            $.ajax({
                url: baseUrl + "cashmanager/outgoing/ajax_save_price",
                data: {
                    cost_id : cost_id,
                    cost_amount : cost_amount,
                },
                type: "POST",
                dataType: 'json',
                success: function(result){
                    if(result == 1) {
                        alert('Successfully Saved');
                    }
                }
            });
        });

        $(".maintenance-cost").on('keyup', '.cost-comment', function (event) {
            var button = $(this);
            var cost_id = button.parents('tr').find('.cost_id').val();
            var cost_comment = button.val();

            $.ajax({
                url: baseUrl + "cashmanager/outgoing/ajax_save_price",
                data: {
                    cost_id : cost_id,
                    cost_comment : cost_comment,
                },
                type: "POST",
                dataType: 'json',
                success: function(result){
                    console.log(result);
                }
            });
        });

        $("#abcd").on("change",".job-done-date", function () {
            $(this).parents('td').find('.job-done').attr('data-date', $(this).val());
        });



        $(document).on('click', '.job-done', function(event){
            //var job_id = $(this).attr('data-reported-date');
            var job_done_date = $(this).data('date');
            var button = $(this);
            var reported_date = $(this).attr('data-reported-date');
            var cost_id = button.parents('tr').find('.cost_id').val();
            var status = button.attr('data-value');

            //alert(job_done_date);

            $.ajax({
                url: baseUrl + "cashmanager/outgoing/ajax_change_job_to_done",
                data: {
                    job_done_date : job_done_date,
                    cost_id : cost_id,
                    status : status,
                    reported_date : reported_date
                },
                type: "POST",
                dataType: 'json',
                success: function(result){
                    if(result['result'] == 1 && status == '1'){
                        button.parents('td').find('.job-done').html('JOB DONE - '+result['job_date']).attr('data-value', 0);
                        button.prop("disabled",true);
                    }
                    if(result['result'] == 1 && status == '0'){
                        button.parents('td').find('.job-done').html('Job Done').attr('data-value', 1);
                    }
                }
            });
        });

        $(".maintenance-cost").on('click', '.btn-invoice', function(event){
            event.preventDefault();
            var button = $(this);
            var cost_id = button.parents('tr').find('.cost_id').val();

            $.ajax({
                url: baseUrl + "cashmanager/outgoing/send_invoice/"+cost_id,
                data: {
                    cost_id : cost_id,
                    status : status,
                },
                type: "POST",
                dataType: 'json',
                beforeSend: function() {
                    button.html('Please wait...');
                },
                success: function(result){
                    if(result == 1) {
                        button.html('Sent');
                    }
                }
            });
        });
    });
</script>
