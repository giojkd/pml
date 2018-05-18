<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title"><?php echo $title; ?></h2>
    </div>

    <div class="panel-body">
        <div class="btn-group margin-bottom-10">
            <a href="<?php echo base_url_tr() ?>supplier/create" class="btn green"><i class="icon-plus"></i> <?php echo lang('label_add_new') ?></a>
        </div>
        <?php echo $this->session->flashdata('save_success') ? $this->session->flashdata('save_success') : ''; ?>
        <table class="table table-striped table-bordered table-hover display responsive nowrap" id="sample_1" width="100%">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Company</th>
                    <th>Name</th>
                    <th>Vat No.</th>
                    <th>Address</th>
                    <th>Notes</th>
                    <th>Telephone</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                if(count($suppliers))
                {
                    foreach ($suppliers as $value) {
                        ?>
                        <tr class="odd gradeX">
                            <td><?php echo $value["id"]; ?></td>
                            <td><?php echo $value["company"]; ?></td>
                            <td><?php echo $value["name"].' '.$value["surname"]; ?></td>
                            <td><?php echo $value["vat_no"]; ?></td>
                            <td><?php echo $value["address"]; ?></td>
                            <td><?php echo $value["notes"]; ?></td>
                            <td><?php echo $value["supplier_telephone"]; ?></td>
                            <td><?php echo $value["supplier_email"]; ?></td>
                            <td><?php echo $value["supplier_type"]; ?></td>
                            <td>
                                <a class="btn mini red delete confirm" href="<?php echo base_url(); ?>supplier/delete/<?php echo $value["id"]; ?>"><i class="icon-trash"></i></a>
                                 <a class="btn mini btn-success" href="<?php echo base_url(); ?>supplier/edit/<?php echo $value["id"]; ?>"><i class="glyphicon glyphicon-pencil"></i></a>
                            </td>
                        </tr>
                        <?php
                    }
                }
                else{
                    echo '<tr class="odd gradeX"><td colspan="9"><p class="text-center">No records found</p></td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
