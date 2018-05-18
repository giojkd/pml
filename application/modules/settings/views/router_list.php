<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title"><?php echo $title; ?></h2>
    </div>

    <div class="panel-body">
        <div class="btn-group margin-bottom-10">
            <a href="<?php echo base_url_tr() ?>settings/wifirouter/router_add" class="btn green"><i class="icon-plus"></i> <?php echo lang('label_add_new') ?></a>
        </div>
        <?php echo $this->session->flashdata('save_success') ? $this->session->flashdata('save_success') : ''; ?>
        <table class="table table-striped table-bordered table-hover display responsive nowrap datatable" width="100%">
            <thead>
                <tr>
                    <th>Actually router name and serial number</th>
                    <th>Router Location</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                foreach ($routers as $value) {
                ?>
                    <tr class="odd gradeX">
                        <td><?php echo $value["router_name"]; ?></td>
                        <td><?php echo $value["router_location"]; ?></td>
                        <td><?php echo mydate($value["insert_date"],"-"); ?></td>
                        <td>
                            <a class="btn mini purple" href="<?php echo base_url(); ?>settings/wifirouter/router_edit/<?php echo $value["id"]; ?>"><i class="icon-pencil"></i></a>
                            <a class="btn mini red delete confirm btn-sm" href="<?php echo base_url(); ?>settings/wifirouter/router_delete/<?php echo $value["id"]; ?>"><i class="icon-trash"></i></a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
