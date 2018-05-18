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
        <table class="table table-striped table-bordered table-hover display responsive nowrap" id="due_payment_lists" width="100%">
            <thead>
                <tr>
                    <!--<th width="30px">Apartment ID</th>-->
                    <th>Cost Type</th>
                    <th>Related to</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                    <th>Occupant</th>
                    <!--<th>Revenue Amount</th>-->
                    <th>Expired Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $value): ?>
                    <tr>
                        <!--<td><?php //echo $value["apartment_id"]=="0"?"All":$value["apartment_id"]; ?></td>-->
                        <td><?php //echo service_charges($value["cost_type"]); 
                        if($value["cost_for"] == "1") {
                            echo "Property Cost";
                        }
                        else if($value["cost_for"] == "2"){
                            echo "Installement";
                        }
                        else if($value["cost_for"] == "3"){
                            echo "Property Contract";
                        }
                        else if($value["cost_for"] == "4"){
                            echo "General Cost";
                        }
                        
                        ?></td>
                        <td><?php echo $value["related_to"]?related_to_for_list($value["related_to"]):''; ?></td>
                        <td style="text-align: right">£ <?php echo $value["oc_amount"]; ?></td>
                        <td><?php echo $value["payment_date"]?mydate($value["payment_date"],"-"):""; ?></td>
                        <td><?php echo $value["name"]." ".$value["family_name"]; ?></td>
                        <!--<td style="text-align: right">£ <?php //echo $value["revenue_amount"]; ?></td>-->
                        <td><?php echo $value["expired_date"]?mydate($value["expired_date"],"-"):""; ?></td>
                        <th class="text-right">
                            <a href="#paymentDateModal" data-toggle="modal" data-id ="<?php echo $value['id']; ?>" class="btn btn-info btn-sm open-AddDateDialog">Add Payment Date</a>
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
            <form method="post" action="<?php echo base_url('cashmanager/revenue/update_due_payment_status')?>">
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
        $('#due_payment_lists').dataTable({
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