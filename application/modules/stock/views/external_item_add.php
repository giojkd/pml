
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="tabbable tabbable-custom boxless">
            <!---start form -->
            <div class="portlet box blue ">

                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-user"></i><?php echo $title; ?>
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse">
                        </a>
                        <a href="#portlet-config" data-toggle="modal" class="config">
                        </a>
                        <a href="javascript:;" class="reload">
                        </a>
                        <a href="javascript:;" class="remove">
                        </a>
                    </div>
                </div>
                <div class="portlet-body form">
                <?php if (validation_errors()): ?>
                    <div class="alert alert-danger" style="color: #b42020">
                        <button class="close" data-dismiss="alert" type="button">x</button>
                        <?php echo validation_errors(); ?>
                    </div>
                <?php endif; ?>
                    <!-- BEGIN FORM-->
                    <form class="item_add_form" action="<?php echo site_url() ?>stock/external_item_add_save" method="post">
                        <div class="form-body col-xs-12">
                            <div class="form-group">
                                <label class="control-label">Add Item</label>
                                <input type="text" name="item_name" value="<?php echo set_value("item_name"); ?>" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label class="control-label">Quantity</label>
                                <input type="text" name="item_quantity" value="<?php echo set_value("item_quantity"); ?>" class="form-control" required/>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Note</label>
                                <textarea name="note"class="form-control"><?php echo set_value("note"); ?></textarea>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn blue"><i class="icon-ok"></i> <?php echo lang('btn_save'); ?></button>
                                <a href="<?php echo base_url_tr() ?>stock/external_item_list" class="btn btn-danger"><i class="icon-remove"></i> <?php echo lang('btn_cancel'); ?></a>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
                    <div class="clearfix"></div>
                </div>
            </div>
            <!---end form -->
        </div>
    </div>
</div>
<!-- END PAGE CONTENT-->

<script>
    $(document).ready(function() {
        $('#item_id').select2();
    });
</script>
