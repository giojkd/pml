<div class="panel panel-success">
  <div class="panel-heading clearfix">
    <h2 class="panel-title"><?php echo $title; ?></h2>
  </div>

  <div class="panel-body">
    <div class="btn-group margin-bottom-10">
      <a href="<?php echo base_url_tr() ?>user/add" class="btn green"><i class="icon-plus"></i> <?php echo lang('label_add_new') ?></a>
    </div>
    <?php echo $this->session->flashdata('save_success') ? $this->session->flashdata('save_success') : ''; ?>
    <table class="table table-striped table-bordered table-hover display responsive nowrap" id="user_1" width="100%">
      <thead>
        <tr>
          <th style="width:8px;">#</th>
          <th><?php echo lang('name'); ?></th>
          <th class="hidden-480"><?php echo lang('email'); ?></th>
          <th class="hidden-480">Telephone</th>
          <th>Agent</th>
          <th>Agent email</th>
          <th>Properties</th>
          <th><?php echo lang('action'); ?></th>
        </tr>
      </thead>

      <tbody>
        <?php
        if ($users) {
          $i = 0;
          $sess_data = $this->session->userdata();
          foreach ($users as $key => $value) {
            ?>
            <tr class="odd gradeX">
              <td><input type="checkbox" class="checkboxes" value="1" /></td>
              <td>
                <?php echo $value['name'] . ' ' . $value['family_name'] ?>
              </td>
              <td class="hidden-480">
                <?php echo $value['email'] ?>
              </td>
              <td class="hidden-480">
                <?php echo $value['phone_no']?>
              </td>
              <td>
                <?php echo $value['owner_agent_name']?>
              </td>
              <td>
                <?php echo $value['owner_agent_email']?>
              </td>
              <td>
                <?php echo $value['owner_properties_list']?>
              </td>
              <td>
                <a href="<?php echo base_url_tr() ?>user/edit/<?php echo $value['id'] ?>" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-pencil"></i></a>
                <?php if ($sess_data['userdata']['user_id'] != $value['id']) { ?>
                  <a href="<?php echo base_url_tr() ?>user/delete/<?php echo $value['id'] ?>" alt="<?php echo $value['name'] ?>" class="btn mini red delete confirm btn-sm"><i class="glyphicon glyphicon-trash"></i></a>
                <?php } ?>
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
  $('#user_1').dataTable({
    responsive: true,
  });
})
</script>
