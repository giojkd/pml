<!-- BEGIN PAGE CONTAINER-->
<div class="container-fluid">
    <!-- BEGIN PAGE HEADER-->
    <div class="row-fluid">
        <div class="span12">
            <h3 class="page-title">
                Currency
            </h3>
        </div>
    </div>
    <!-- END PAGE HEADER-->

    <!-- BEGIN PAGE CONTENT-->
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box light-grey">
                <div class="portlet-title">
                    <h4><i class="icon-globe"></i>Currency</h4>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                        <a href="#portlet-config" data-toggle="modal" class="config"></a>
                        <a href="javascript:;" class="reload"></a>
                        <a href="javascript:;" class="remove"></a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="clearfix">
                        <div class="btn-group">
                            <a href="<?=base_url()?>setting/currency/add" class="btn green"><i class="icon-plus"></i> <?=lang('label_add_new')?></a>
                        </div>
                        <div class="btn-group pull-right">

                        </div>
                    </div>
                    <?php echo $this->session->flashdata('save_success') ? $this->session->flashdata('save_success') : ''; ?>
                    <table class="table table-striped table-bordered table-hover" id="sample_1">
                        <thead>
                        <tr>
                            <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th>
                            <th>Name</th>
                            <th width="70"></th>
                            <th class="hidden-480">Code</th>
                            <th width="30"></th>
                            <th width="70"></th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        if($get_all) {
                            foreach($get_all as $value) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                                    <td><?=$value['currency_name']?></td>
                                    <td><a href="<?=site_url()?>setting/currency/delete/<?=$value['currency_id']?>" alt="<?=$value['currency_name']?>" class="btn mini black delete"><i class="icon-trash"></i> Delete</a></td>
                                    <td class="hidden-480"><?=$value['currency_code']?> (<?=$value['currency_symbol']?>)</td>
                                    <td ><span class="label label-<?=$value['currency_status'] == 1 ? 'success' : 'warning'?>"><?=$value['currency_status'] == 1 ? 'ON' : 'OFF'?></span></td>
                                    <td><a href="<?=site_url()?>setting/currency/edit/<?=$value['currency_id']?>" class="btn mini purple"><i class="icon-edit"></i> Edit</a></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
<!-- END PAGE CONTAINER-->