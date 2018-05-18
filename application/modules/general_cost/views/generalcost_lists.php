<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title"><?php echo $title; ?></h2>
    </div>

    <div class="panel-body">
        <div class="btn-group margin-bottom-10">
            <a href="<?php echo base_url_tr('general_cost') ?>" class="btn green"><i class="icon-plus"></i> <?php echo lang('label_add_new') ?></a>
        </div>
        <?php if ($this->session->flashdata('general_cost_update')): ?>
            <div class="alert alert-success alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                <strong>Success!</strong> <?php echo $this->session->flashdata('general_cost_update'); ?>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error_message')): ?>
            <div class="alert alert-danger alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                <strong>Error!</strong> <?php echo $this->session->flashdata('error_message'); ?>
            </div>
        <?php endif; ?>
        <table class="table table-striped table-bordered table-hover display responsive nowrap" id="generalcost_lists" width="100%">
            <thead>
                <tr>
                    <th>Supplier Co. name</th>
                    <th>Supplier Invoice date</th>
                    <th>Supplier Invoice no</th>
                    
                    <th>Due payment date</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php if (isset($generalcosts)): ?>
                    <?php foreach ($generalcosts as $gc): ?>
                        <tr>
                            <td><?php echo $gc['company']; ?></td>
                            <td class="invoice_date">
                                <?php 
                                if($gc['supplier_invoice_date']=="0000-00-00")
                                    {
                                        echo "N/A";
                                    }else{
                                        echo formatted_date($gc['supplier_invoice_date'], "d-m-Y");
                                    } 
                                ?>
                            </td>
                            <td class="invoice_number"><?php echo $gc['supplier_invoice_number']; ?></td>
                            
                            <td><?php echo ($gc['expire_date'] == "0000-00-00 00:00:00") ? '' : formatted_date($gc['expire_date'], "d-m-Y"); ?></td>
                            <td class="description"><?php echo $gc['description']; ?></td>
                            <td class="amount">£ <?php echo $gc['amount']; ?></td>
                            <td>
                                <?php 
                                    if($gc['payment_status'] == 0)
                                    {
                                        echo "Due";
                                        if($gc['amount_paid'])
                                        {
                                            echo '('.$gc['amount_paid'].'/'.$gc['amount'].')';
                                        }
                                    }
                                    else
                                    {
                                        echo "Paid";
                                    }
                                ?>
                            </td>
                            <td class="text-right">
                                <a href="<?php echo site_url('general_cost/generalcost_edit/' . $gc['gc_id']); ?>" class="btn btn-success btn-sm icon-pencil"></a>
                                <form method="post" class="generalcost_delete_form" action="<?php echo site_url('general_cost/generalcost_delete'); ?>" style="display: inline-block;">
                                    <input type="hidden" name="generalcost_id" value="<?php echo $gc['gc_id']; ?>">
                                    <button type="submit" class="generalcost_delete_button btn btn-danger btn-sm"><i class="icon-trash"></i></button>
                                </form>
                                <?php if($gc['payment_status'] == 1) {?>
                                <button class="btn btn-info btn-sm">Paid</button>
                                <?php }else{?>
                                 <a href="#paymentDateModal" data-toggle="modal" data-id="<?php echo $gc['gc_id']; ?>" data-amount="<?php echo $gc['amount']; ?>" data-amount-paid="<?php echo $gc['amount_paid']; ?>" class="btn btn-info btn-sm open-AddDateDialog">Add Payment Date</a>
                                <?php }?>
                                <?php if($gc['file_name']){ ?>
                                 <a href="<?php echo site_url('general_cost/download_file/' . $gc['gc_id']); ?>" class="btn purple btn-sm fa fa-download"></a>
                                <?php } ?>
                            </td>
                            
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
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
            <form method="post" action="<?php echo base_url('general_cost/update_general_paymentDate')?>">
                <div class="modal-body">
                    <p><b>Cost ID: <span id="cost_id"></span></b></p>
                     <div class="form-group">
                        <label class="control-label">Movement Date</label>
                        <input type="text" name="movement_date" id="movement_date" class="form-control"/>
                        <input type="hidden" name="gc_id" id="gc_id" value=""/>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Description</label>
                        <textarea name="movement_description" id="movement_description" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Amount</label>
                        <input id="movement_amount" name="movement_amount" class="form-control"/>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label">Invoice No.</label>
                        <p class="well well-sm" id="invoice_no"></p>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label">Invoice Date.</label>
                        <p class="well well-sm" id="invoice_date"></p>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Type</label>
                        <select name="movement_type" id="movement_type" class="form-control" required>
                            <option value="1">Bank in</option>
                            <option value="2" selected>Bank Out</option>
                        </select>
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

<script type="text/javascript">

    $(document).ready(function () {
        $('#generalcost_lists').dataTable({
               responsive: true,
           });
    });


    $(document).ready(function () {
        $('.generalcost_delete_button').on('click', function (e) {
            e.preventDefault();
            var form = $(this).parents('form.generalcost_delete_form');
            bootbox.confirm('Are you sure to delete?', function (confirm) {
                if(confirm){
                    form.submit();
                }
            });
        });

        $(document).on("click", ".open-AddDateDialog", function () {
            var mygcId = $(this).data('id');
            $(".modal-body #gc_id").val(mygcId);
            $(".modal-body #cost_id").html(mygcId);
            
            $(".modal-body #movement_description").val($(this).parents('tr').children('td.description').html());
            if($(this).data('amount-paid'))
            {
                $(".modal-body #movement_amount").val($(this).data('amount')-$(this).data('amount-paid'));
            }
            else{
                $(".modal-body #movement_amount").val($(this).data('amount'));
            }
            $(".modal-body #invoice_no").html($(this).parents('tr').children('td.invoice_number').html());
            $(".modal-body #invoice_date").html($(this).parents('tr').children('td.invoice_date').html());
            // As pointed out in comments, 
            // it is superfluous to have to manually call the modal.
            // $('#addBookDialog').modal('show');
        });
        $("#movement_date").datetimepicker({
            format: 'd-m-Y',
            pickTime: false,
        });

    });
</script>