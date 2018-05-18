<div class="panel panel-success">
  <div class="panel-heading clearfix">
    <h2 class="panel-title"><?php echo $title; ?></h2>
  </div>

  <div class="panel-body">
    <div class="btn-group margin-bottom-10">
      <a href="<?php echo base_url_tr() ?>cashmanager/outgoing/oc_add" class="btn green"><i class="icon-plus"></i> <?php echo lang('label_add_new') ?></a>
    </div>
    <?php echo $this->session->flashdata('save_success') ? $this->session->flashdata('save_success') : ''; ?>
    <div class="table-responsive">
      <table class="maintenance-cost table table-striped table-bordered table-hover display responsive nowrap datatable" width="100%" id="abcd">
        <thead>
          <tr>
            <th width="30px">ID</th>
            <th>Apartment</th>
            <th>Area</th>
            <th>Description</th>
            <th>Reported date</th>
            <th>Reported by</th>
            <th>Comments</th>
            <th>Create date</th>
            <th>Status</th>
            <th>Revenue/Cost</th>
            <th>Actions</th>
          </tr>
        </thead>

        <tbody>
          <?php
          foreach ($maintenances as $m) {
            ?>
            <tr>
              <td><?php echo $m['maintenance_id']?></td>
              <td><?php echo $m['address']?></td>
              <td><?php echo ($m['room_id']>0) ? $m['room_description'] : 'All apartment'?></td>
              <td><?php echo $m['maintenance_description']?></td>
              <td><?php echo $m['maintenance_reported_date']?></td>
              <td><?php echo $m['maintenance_reported_by']?></td>
              <td><?php echo $m['maintenance_comments']?></td>
              <td><?php echo $m['maintenance_create_date']?></td>
              <td><?php echo ($m['maintenance_status']==0) ? 'Open' : 'Closed' ?></td>
              <td>
                <?php
                if($m['maintenance_supplier_cost']>0) {
                  echo $m['total_revenue'].'/'. $m['maintenance_supplier_cost'];
                }else{?>
                  <a class="class="btn btn-sm btn-primary"" href="/ap4rent/backend/cashmanager/outgoing/maintenance_manage/<?php echo $m['maintenance_id']?>">Set</a>
                  <?php
                }?>
              </td>
              <td><a class="class="btn btn-sm btn-primary"" href="/ap4rent/backend/cashmanager/outgoing/maintenance_manage/<?php echo $m['maintenance_id']?>">Manage maintenance</a></td>
            </tr>
            <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>

</script>
