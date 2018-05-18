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
                    <form class="item_add_form" action="<?php echo site_url() ?>settings/mobilepackage/edit_save" method="post">
                        <div class="form-body col-xs-12">

                            <div class="form-group">
                                <label class="control-label">Assigned To</label>
                                <input type="text" name="assigned_to" value="<?php echo $package_info["assigned_to"]; ?>" class="form-control" required/>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Phone Number</label>
                                <input type="text" name="phone_number" value="<?php echo $package_info["phone_number"]; ?>" class="form-control" required/>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Mobile Company</label>
                                <input type="text" name="mobile_company" value="<?php echo $package_info["mobile_company"]; ?>" class="form-control" required/>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Plan Name</label>
                                <input type="text" name="plan_name" value="<?php echo $package_info["plan_name"]; ?>" class="form-control" required/>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Plan Description</label>
                                <input type="text" name="plan_description" value="<?php echo $package_info["plan_description"]; ?>" class="form-control" required/>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Cost</label>
                                <input type="text" name="plan_cost" value="<?php echo $package_info["plan_cost"]; ?>" class="form-control" required/>
                            </div>


                            <div class="form-actions">
                                <input type="hidden" name="id" value="<?php echo $package_info["id"]; ?>" />
                                <button type="submit" class="btn blue"><i class="icon-ok"></i> <?php echo lang('btn_save'); ?></button>
                                <a href="<?php echo base_url_tr() ?>settings/mobilepackage/all" class="btn btn-danger"><i class="icon-remove"></i> <?php echo lang('btn_cancel'); ?></a>
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
