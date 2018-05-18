<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title"><?php echo $title; ?></h2>
    </div>

    <div class="panel-body">
        <div class="btn-group margin-bottom-10">
            <span>
            <a href="<?php echo base_url_tr() ?>bank/bma" class="btn green"><i class="icon-plus"></i> <?php echo lang('label_add_new') ?></a></span>

                    <?php 
                        $entrance = 0;
                        $exit = 0;
                        foreach ($movements as $value) {?>
                    <?php 
                        
                        if($value['movement_type'] == "1")
                        {
                            $entrance = $entrance + $value["movement_amount"];
                        }
                        else if($value['movement_type'] == "2")
                        {
                            $exit = $exit + $value["movement_amount"];
                        }
                    ?>
                    <?php }?>
                    &nbsp;&nbsp;&nbsp;&nbsp;<span><strong>Bank Balance: </strong><?php echo $entrance - $exit;?></span>
        </div>
        <?php echo $this->session->flashdata('save_success') ? $this->session->flashdata('save_success') : ''; ?>
        <table class="table table-striped table-bordered table-hover display responsive nowrap" width="100%">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Occupant/Owner/Supplier</th>
                    <th>Others Information</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($movements as $value) {?>
                    <?php 
                        $entrance = 0;
                        $exit = 0;
                        if($value['movement_type'] == "1")
                        {
                            $entrance = $entrance + $value["movement_amount"];
                        }
                        else if($value['movement_type'] == "2")
                        {
                            $exit = $exit + $value["movement_amount"];
                        }
                    ?>
                        <tr class="odd gradeX">
                            <td><?php echo mydate($value["movement_date"],'-'); ?></td>
                            <td><?php echo $value["movement_description"]; ?></td>
                            <td>
                                <?php 
                                    if($value["movement_type"] == "1")
                                    {
                                        echo '+'.$value["movement_amount"];
                                    }
                                    else if($value["movement_type"] == "2")
                                    {
                                        echo '-'.$value["movement_amount"];
                                    }
                                ?>                                 
                            </td>
                            <td>
                                <?php if($value["tenant_id"])
                                        {
                                            echo "<strong>Occupant:</strong> ".getUser($value["tenant_id"],'name').' '.getUser($value["tenant_id"],'family_name');
                                        }
                                        else{
                                            echo '';
                                        }

                                        if($value["owner_id"])
                                        {
                                            echo "<strong>Owner:</strong> ".getUser($value["owner_id"],'name').' '.getUser($value["owner_id"],'family_name');
                                        }
                                        else{
                                            echo '';
                                        }

                                        if($value["bm_supplier_id"])
                                        {
                                            echo "<strong>Supplier:</strong> ".get_single_table_data_by_id($value["bm_supplier_id"], "name", "suppliers").' '.get_single_table_data_by_id($value["bm_supplier_id"], "surname", "suppliers");
                                        }
                                        else{
                                            echo '';
                                        }
                                
                                ?>
                            </td>

                            <td>
                                <?php if($value["supplier_id"])
                                    {
                                        echo '<strong>Supplier\'s Company: </strong>'.get_single_table_data_by_id($value["supplier_id"],'company','suppliers').', '.'<strong>Invoice No.: </strong>'.$value["supplier_invoice_number"].', '.'<strong>Invoice Date: </strong>'.$value["supplier_invoice_date"];
                                    }
                                ?>
                            </td>
                            <td>
                                <a class="btn mini purple" href="<?php echo base_url(); ?>bank/bma_edit/<?php echo $value["id"]; ?>"><i class="icon-pencil"></i></a>
                                <a class="btn mini red delete confirm" href="<?php echo base_url(); ?>bank/bma_delete/<?php echo $value["id"]; ?>"><i class="icon-trash"></i></a>
                            </td>
                        </tr>
                <?php }?>

            </tbody>
        </table>
    </div>
</div>
