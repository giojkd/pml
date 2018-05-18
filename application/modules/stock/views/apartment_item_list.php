<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title"><?php echo $title; ?></h2>
    </div>

    <div class="panel-body">
        <div class="btn-group margin-bottom-10">
            <a href="<?php echo base_url_tr() ?>stock/apartment_item_add" class="btn green"><i class="icon-plus"></i> <?php echo lang('label_add_new') ?></a>
        </div>
        <?php echo $this->session->flashdata('save_success') ? $this->session->flashdata('save_success') : ''; ?>
        <table class="table table-striped table-bordered table-hover display responsive nowrap apartment-item-list" width="100%">
            <thead>
                <tr>
                    <!--<th>Apartment</th>-->
                    <th>Apartment Address</th>
                    <th>Room</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                foreach ($items as $value) {
                    ?>
                    <tr class="odd gradeX">
                        <!--<td><?php /* echo $value["name"]." ".$value["family_name"]; */ ?></td>-->
                        <td><?php echo $value["address"]; ?></td>
                        <td>
                            <?php
                            if ($value['room_id']) {
                                $room_type = $value['room_type'] == 1 ? ' (Single)' : ' (Double)';
                                echo $value['room_id'] . $room_type;
                            } else {
                                echo 'Common Area';
                            }
                            ?>
                        </td>
                        <td><?php echo $value["item_name"]; ?></td>
                        <td><?php echo $value["current_quantity"]; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($value['create_date'])); ?></td>
                        <td><?php echo date('d-m-Y', strtotime($value['update_date'])); ?></td>
                        <td>
                            <a class="btn mini purple" href="<?php echo base_url(); ?>stock/apartment_item_edit/<?php echo $value["id"]; ?>"><i class="icon-pencil"></i></a>
                            <a class="btn mini red delete confirm" href="<?php echo base_url(); ?>stock/apartment_item_delete/<?php echo $value["id"]; ?>"><i class="icon-trash"></i></a>
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
    $(document).ready(function () {
        $('.apartment-item-list').dataTable({
            'aaSorting': []
        }).yadcf([
            {column_number: 0},
            {column_number: 1},
        ]);
    });
</script>