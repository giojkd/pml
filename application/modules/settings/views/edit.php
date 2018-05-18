<!-- BEGIN PAGE CONTAINER-->
<div class="container-fluid">
    <!-- BEGIN PAGE HEADER-->
    <div class="row-fluid">
        <div class="span12">
            <h3 class="page-title">
                Currency
            </h3>
            <ul class="breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="<?=base_url()?>"><?=lang('label_home')?></a>
                    <span class="icon-angle-right"></span>
                </li>
                <li>
                    <a href="<?=base_url()?>currency">Currency</a>
                    <span class="icon-angle-right"></span>
                </li>
                <li><a href="#">Modify Currency</a></li>
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
                        <h4><i class="icon-reorder"></i>Modify Currency</h4>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"></a>
                            <a href="#portlet-config" data-toggle="modal" class="config"></a>
                            <a href="javascript:;" class="reload"></a>
                            <a href="javascript:;" class="remove"></a>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <?php echo validation_errors('<p style="color: red">', '</p>'); ?>
                        <!-- BEGIN FORM-->
                        <form action="<?=site_url()?>setting/currency/editsave" method="post" class="form-horizontal form-bordered form-row-stripped">
                            <div class="control-group">
                                <label class="control-label">Currency Name</label>
                                <div class="controls">
                                    <input type="hidden" name="eid" value="<?=$edit['currency_id']?>">
                                    <input type="text" name="currency_name" value="<?=set_value('currency_name', $edit['currency_name'])?>" placeholder="Currency Name" class="m-wrap span12" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Currency Code</label>
                                <div class="controls">
                                    <input type="text" name="currency_code" value="<?=set_value('currency_code', $edit['currency_code'])?>" placeholder="Currency Code" class="m-wrap span12" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Currency Symbol</label>
                                <div class="controls">
                                    <input type="text" name="currency_symbol" value="<?=set_value('currency_symbol', $edit['currency_symbol'])?>" placeholder="Currency Symbol" class="m-wrap span12" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Ordering</label>
                                <div class="controls">
                                    <input type="text" name="currency_order" value="<?=set_value('currency_order', $edit['currency_order'])?>" placeholder="Ordering" class="m-wrap span12" />
                                </div>
                            </div>


                            <div class="control-group">
                                <label class="control-label"><?=lang('label_status')?></label>
                                <div class="controls">
                                    <div class="success-toggle-button">
                                        <input name="status" type="checkbox" <?=$edit['currency_status'] == 1 ? 'checked="checked"' : null?> class="toggle" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn blue"><i class="icon-ok"></i> <?=lang('btn_save')?></button>
                                <a href="<?=base_url()?>setting/currency" class="btn"><i class="icon-remove"></i> <?=lang('btn_cancel')?></a>
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