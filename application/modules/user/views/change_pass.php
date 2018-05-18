<!-- BEGIN PAGE CONTAINER-->
<div class="container-fluid">
    <!-- BEGIN PAGE HEADER-->
    <div class="row-fluid">
        <div class="span12">
            <h3 class="page-title">
                Change Password
            </h3>
            <ul class="breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="<?=base_url()?>"><?=lang('label_home')?></a>
                    <span class="icon-angle-right"></span>
                </li>
                <li>
                    <a href="<?=base_url()?>user"><?=lang('m_admin_user')?></a>
                    <span class="icon-angle-right"></span>
                </li>
                <li><a href="#">Change password</a></li>
            </ul>
        </div>
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row-fluid">
        <div class="span12">
            <div class="tabbable tabbable-custom boxless">
                <!---start form -->
                <div class="portlet box blue ">
                    <div class="portlet-title">
                        <h4><i class="icon-reorder"></i>Change Password</h4>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"></a>
                            <a href="#portlet-config" data-toggle="modal" class="config"></a>
                            <a href="javascript:;" class="reload"></a>
                            <a href="javascript:;" class="remove"></a>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <?php echo validation_errors('<p style="color: red">', '</p>'); ?>
                        <?php echo $this->session->flashdata('save_error') ? $this->session->flashdata('save_error') : ''; ?>
                        <!-- BEGIN FORM-->
                        <form action="<?=site_url()?>user/savepassword" method="post" class="form-horizontal form-bordered form-row-stripped">
                            <div class="control-group">
                                <label class="control-label">Old Password</label>
                                <div class="controls">
                                    <input type="password" name="old_pass" placeholder="Old Password" class="m-wrap span12" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">New Password</label>
                                <div class="controls">
                                    <input type="password" name="password" placeholder="New Password" class="m-wrap span12" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Password Confirmation</label>
                                <div class="controls">
                                    <input type="password" name="re_password" placeholder="Re-New Password" class="m-wrap span12" />
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn blue"><i class="icon-ok"></i> <?=lang('btn_save')?></button>
                                <a href="<?=base_url()?>user" class="btn"><i class="icon-remove"></i> <?=lang('btn_cancel')?></a>
                            </div>
                        </form>
                        <!-- END FORM-->
                    </div>
                </div>
                <!---end form -->
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
<!-- END PAGE CONTAINER-->