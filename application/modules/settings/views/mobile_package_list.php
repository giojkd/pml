<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title"><?php echo $title; ?></h2>
    </div>

    <div class="panel-body">
        <div class="btn-group margin-bottom-10">
            <a href="<?php echo base_url_tr() ?>settings/mobilepackage/add" class="btn green"><i class="icon-plus"></i> <?php echo lang('label_add_new') ?></a>
        </div>
        <?php echo $this->session->flashdata('save_success') ? $this->session->flashdata('save_success') : ''; ?>
        <table class="table table-striped table-bordered table-hover display responsive nowrap datatable" width="100%">
            <thead>
                <tr>
                    <th>Assigned To</th>
                    <th>Phone Number</th>
                    <th>Mobile Company</th>
                    <th>Plan Name</th>
                    <th>Plan Description</th>
                    <th>Cost</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                foreach ($packages as $value) {
                ?>
                    <tr class="odd gradeX">
                        <td><?php echo $value["assigned_to"]; ?></td>
                        <td><?php echo $value["phone_number"]; ?></td>
                        <td><?php echo $value["mobile_company"]; ?></td>
                        <td><?php echo $value["plan_name"]; ?></td>
                        <td><?php echo $value["plan_description"]; ?></td>
                        <td><?php echo $value["plan_cost"]; ?></td>

                        <td>
                            <a class="btn mini purple" href="<?php echo base_url(); ?>settings/mobilepackage/edit/<?php echo $value["id"]; ?>"><i class="icon-pencil"></i></a>
                            <a class="btn mini red delete confirm btn-sm" href="<?php echo base_url(); ?>settings/mobilepackage/delete/<?php echo $value["id"]; ?>"><i class="icon-trash"></i></a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
