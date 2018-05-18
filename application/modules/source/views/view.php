<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title"><?php echo $title; ?></h2>
    </div>

    <div class="panel-body">
        <div class="btn-group margin-bottom-10">
            <a href="<?php echo base_url_tr() ?>source/add" class="btn green"><i class="icon-plus"></i> <?php echo lang('label_add_new') ?></a>
        </div>
        <?php echo $this->session->flashdata('save_success') ? $this->session->flashdata('save_success') : ''; ?>
        <table class="table table-striped table-bordered table-hover display responsive nowrap datatable" width="100%">
            <thead>
                <tr>
                    <!--<th>Apartment</th>-->
                    <th>ID</th>
                    <th>Source Name</th>
                    <th>Create Time</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    foreach ($sources as $value) {
                        ?>
                        <tr class="odd gradeX">
                            <!--<td><?php /*echo $value["name"]." ".$value["family_name"];*/ ?></td>-->
                            <td><?php echo $value["id"]; ?></td>
                            <td><?php echo $value["source_name"]; ?></td>
                            <td><?php echo $value["createDate"]; ?></td>
                            <td>
                                <a class="btn mini purple" href="<?php echo base_url(); ?>source/edit/<?php echo $value["id"]; ?>"><i class="icon-pencil"></i></a>
                                <a class="btn mini red delete confirm" href="<?php echo base_url(); ?>source/delete/<?php echo $value["id"]; ?>"><i class="icon-trash"></i></a>
                            </td>
                        </tr>
                        <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
