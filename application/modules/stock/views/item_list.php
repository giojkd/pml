<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title"><?php echo $title; ?></h2>
    </div>

    <div class="panel-body">
        <div class="btn-group margin-bottom-10">
            <a href="<?php echo base_url_tr() ?>stock/item_add" class="btn green"><i class="icon-plus"></i> <?php echo lang('label_add_new') ?></a>
        </div>
        <?php echo $this->session->flashdata('save_success') ? $this->session->flashdata('save_success') : ''; ?>
        <table class="table table-striped table-bordered table-hover display responsive nowrap" id="sample_1" width="100%">
            <thead>
                <tr>
                    <th>Item Name</th>
<!--                    <th>Quantity</th>-->
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    foreach ($items as $value) {
                        ?>
                        <tr class="odd gradeX">
                            <td><?php echo $value["item_name"]; ?></td>
<!--                            <td><?php //echo $value["quantity"]; ?></td>-->
                            <td>
                                <a class="btn mini red delete confirm" href="<?php echo base_url(); ?>stock/item_delete/<?php echo $value["item_id"]; ?>"><i class="icon-trash"></i></a>
                            </td>
                        </tr>
                        <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
