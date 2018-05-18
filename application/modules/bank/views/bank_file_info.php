<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title"><?php echo $title; ?></h2>
    </div>

    <div class="panel-body">
        <?php echo $this->session->flashdata('save_success') ? $this->session->flashdata('save_success') : ''; ?>
        <table class="table table-striped table-bordered table-hover display responsive nowrap" width="100%">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Description</th>
                    <th>Payment date</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php 
                    foreach ($bank_info as $value) {
                ?>
                        <tr class="odd gradeX">
                            <td><?php echo $value["id"]; ?></td>
                            <td><?php echo $value["description"]; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($value["payment_date"])); ?></td>
                            <td><?php echo $value["amount"]; ?></td>
                            <td>
                                <a class="btn mini btn-success" href="<?php echo base_url('bank/bma_from_file/'.$value["id"])?>"><i class="glyphicon glyphicon-plus"></i></a>
                            </td>
                        </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
