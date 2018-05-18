<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title"><?php echo $title; ?></h2>
    </div>

    <div class="panel-body">
        <?php echo $this->session->flashdata('save_success') ? $this->session->flashdata('save_success') : ''; ?>
        <table class="table table-striped table-bordered table-hover display responsive nowrap" id="installment_table" width="100%">
            <thead>
                <tr>
                    <th class="text-center">Payment Date</th>
                    <th class="text-center">Amount</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>

            <tbody>
                <?php
                if ($installments) {
                    foreach ($installments as $key => $value) {
                        ?>
                        <tr class="odd gradeX text-center" data-request-id="<?php echo $value['id']; ?>">
                            <td><?php echo $value['payment_status_update_date'] != "0000-00-00"?mydate($value['payment_status_update_date'],"-"):""; ?></td>
                            <td>
                                £ <?php echo $value['revenue_amount'] ?>
                            </td>
                            <td>
                                <?php if ($value['payment_status'] == 1) { ?>
                                    <span class="label label-success">Paid</span>
                                <?php } else { ?>
                                    <span class="label label-danger">Pending</span>
                                <?php } ?>
                            </td>

                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<script type="text/javascript">

    $(document).ready(function () {

        $('#installment_table').dataTable({
            responsive: true,
        });
    });
</script>