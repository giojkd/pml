<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title"><?php echo $title; ?></h2>
    </div>

    <div class="panel-body">
        <div class="btn-group margin-bottom-10">
            <a href="<?php echo base_url_tr() ?>apartment/add" class="btn green"><i class="icon-plus"></i> <?php echo lang('label_add_new') ?></a>
        </div>
        <?php echo $this->session->flashdata('save_success') ? $this->session->flashdata('save_success') : ''; ?>
        <table class="table table-striped table-bordered table-hover display responsive nowrap" id="apartment_list1" width="100%">
            <thead>
                <tr>
                    <th width="20px" style="text-align:center;"><?php echo 'ID'; ?></th>
                    <th><?php echo 'Owner'; ?></th>
                    <th class="hidden-480"><?php echo 'Address'; ?></th>
                    
                    <th><?php echo 'Floor'; ?></th>
                    <th><?php echo 'NR.'; ?></th>
                    <th><?php echo lang('action'); ?></th>
                </tr>
            </thead>

            <tbody>
                <?php
                if ($apartments) {
                    $i = 0;
                    $sess_data = $this->session->userdata();
                    foreach ($apartments as $key => $value) {
                        ?>
                        <tr class="odd gradeX">

                            <td style="text-align:center;">
                                <?php echo $value['id']  ?>
                            </td>
                            <td>
                                <?php echo $value['name']." ".$value['family_name'];  ?>
                            </td>
                            <td class="hidden-480">
                                <?php echo $value['address'] ?>
                            </td>
                            
                            <td >
                                <?php echo  $value['floor']?>
                            </td>
                            <td>
                                <?php echo  $value['nr']?>
                            </td>
                            <td>
                                <center>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">Action<span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                          <li>
                                            <a href="<?php echo base_url('apartment/apartment_detail/'.$value['id']);?>">Show Detail</a>
                                          </li>  
                                          <li>
                                            <a href="<?php echo base_url('apartment/apartment_edit/'.$value['id']);?>">Edit</a>
                                          </li> 
                                          <li>
                                            <a href="<?php echo base_url('apartment/apartment_delete/'.$value['id']);?>" class="confirm">Delete</a>
                                          </li> 
                                        </ul> 
                                    </div> 
                                </center>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
        $(document).ready(function(){
           $('#apartment_list1').dataTable({
                responsive: true,
          });
        })
</script>