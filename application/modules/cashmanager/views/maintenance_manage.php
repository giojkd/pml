
<div class="panel panel-success">
  <div class="panel-heading clearfix">
    <h2 class="panel-title"><?php echo $title; ?></h2>
  </div>

  <div class="panel-body">
    <form class="item_add_form" action="<?php echo site_url() ?>cashmanager/outgoing/maintenance_edit" method="post">
      <input type="hidden" name="maintenance_id" value="<?php echo $maintenance['maintenance_id']?>">
      <div class="form-body">
        <div class="form-group">
          <label>Supplier:</label>
          <select <?php echo ($maintenance['supplier_id']>0) ? 'disabled' : ''?> name="supplier_id" class="form-control" class="form-control" required>
            <option value="">Choose a supplier...</option>
            <?php foreach($suppliers as $supplier){
              ?>
              <option <?php echo ($maintenance['supplier_id'] == $supplier['id']) ? 'selected' : ''?> value="<?php echo $supplier['id']?>"><?php echo $supplier['company']?></option>
              <?php
            }?>
          </select>
        </div>
        <div class="form-group">
          <label>Supplier cost</label>
          <input <?php echo ($maintenance['supplier_id']>0) ? 'disabled' : ''?> value="<?php echo $maintenance['maintenance_supplier_cost']?>" type="text" class="form-control" required name="maintenance_supplier_cost">
        </div>
        <div class="form-group">
          <label>Supplier invoice number</label>
          <input <?php echo ($maintenance['supplier_id']>0) ? 'disabled' : ''?> value="<?php echo $maintenance['maintenance_supplier_invoice_number']?>" type="text" class="form-control" required name="maintenance_supplier_invoice_number">
        </div>
      </div>
      <?php if($maintenance['supplier_id']==0){
        ?>
        <div class="form-actions">
          <button type="submit" class="btn blue"><i class="icon-ok"></i> <?php echo lang('btn_save'); ?></button>
          <a href="<?php echo base_url_tr() ?>cashmanager/outgoing/oc_list" class="btn btn-danger"><i class="icon-remove"></i> <?php echo lang('btn_cancel'); ?></a>
        </div>
        <?php
      }else{
        ?>
        <div class="alert alert-info">
          Once you have set the supplier for the maintenance you can no longer edit.
        </div>
        <?php
      }?>

    </form>
  </div>
</div>
<div class="panel panel-success">
  <!-- Add maintenance costs -->
  <div class="panel-heading clearfix">
    <h2 class="panel-title">Maintenance costs</h2>
  </div>
  <div class="panel-body">
    <form class="form-inline" action="<?php echo site_url()?>cashmanager/outgoing/maintenance_add_cost" method="POST">
      <input type="hidden" name="maintenance_id" value="<?php echo $maintenance['maintenance_id']?>">
      <input type="hidden" name="apartment_id" value="<?php echo $maintenance['apartment_id']?>">
      <div class="form-body col-xs-12">
        <div class="form-group">
          <label>Bill to:</label>
          <select name="tenant_user_id" class="form-control" class="form-control" required>
            <option value="">Choose...</option>
            <optgroup label="Owner">
              <option value="<?php echo $owner['id']?>"><?php echo $owner['name']?> <?php echo $owner['family_name']?></option>
            </optgroup>
            <optgroup label="Tenants">
              <?php foreach($users as $user){
                ?>
                <option value="<?php echo $user['id']?>"><?php echo $user['name']?> <?php echo $user['family_name']?></option>
                <?php
              }?>
            </optgroup>
          </select>
        </div>
        <div class="form-group">
          <label>How much</label>
          <input type="text" class="form-control" required name="revenue_amount">
        </div>
        <div class="form-group">
          <label class="control-label">Due date</label>
          <input type="text" name="payment_date" id="due_date" class="form-control" required />
        </div>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn blue">
          <i class="icon-ok"></i>
          <?php echo lang('btn_save'); ?>
        </button>
        <a href="<?php echo base_url_tr() ?>cashmanager/outgoing/oc_list" class="btn btn-danger">
          <i class="icon-remove"></i> <?php echo lang('btn_cancel'); ?>
        </a>
      </div>
    </form>
    <?php if(count($maintenance_costs)>0){?>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Revenue amount</th>
            <th>User</th>
            <th>Due date</th><
            <th>Actions</th>
          </tr>
        </thead>
        <?php foreach($maintenance_costs as $mc){?>
          <tbody>
            <tr>
              <td><?php echo $mc['revenue_amount']?></td>
              <td><?php echo $mc['name'].' '.$mc['family_name']?></td>
              <td><?php echo date('d/m/Y',strtotime($mc['payment_date']))?></td>
              <td>
                <?php if($mc['invoice_id']==0){?>
                  <a href="<?php echo base_url_tr()?>cashmanager/outgoing/maintenance_cost_create_send_invoice/<?php echo $mc['cost_id']?>" class="btn btn-sm btn-primary">Create and send invoice</a>
                <?php }?>
                <?php if($mc['invoice_id']>0){?>
                  <a href="<?php echo base_url_tr()?>cashmanager/outgoing/outgoing_invoice_pdf/<?php echo $mc['invoice_id']?>" class="btn btn-sm btn-primary">Download invoice</a>
                <?php }?>
              </td>
            </tr>
            <?php
          } ?>
        </tbody>
      </table>
      <?php
    } ?>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
  $('#due_date ').datetimepicker({
    datepicker: true,
    timepicker: false,
    format: 'd-m-Y',
    mask: false,
    scrollMonth : false,
    scrollInput : false
  });
})
</script>
