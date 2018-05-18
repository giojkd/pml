
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
                    <div class="validation_errors">
                        <?php if(validation_errors()!=""):?>
                            <div class="alert alert-danger alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                <?php echo validation_errors();?>
                            </div>
                        <?php endif;?>
                    </div>
                    
                    <!-- BEGIN FORM-->
                    <form class="apartment_add_form" id="apartment_add_form1" action="<?php echo site_url('general_cost/generalcost_update');?>" method="post" >
                        <input 
                                type="hidden" 
                                name="generalcost_id" 
                                value="<?php echo isset($generalcost_edit)?$generalcost_edit['gc_id']:set_value('generalcost_id');?>"/>
                        <div class="form-body col-xs-12">
                            
                        <div class="form-group">
                            <label class="control-label">
                                <input type="radio" name="general_cost_type" value="related_apartment" <?php echo $generalcost_edit['general_cost_type']=="related_apartment"?"checked":""?>> Related Property
                            </label>
                            
                            <label class="control-label">
                                <input type="radio" name="general_cost_type" value="general_cost" <?php echo $generalcost_edit['general_cost_type']=="general_cost"?"checked":""?>> General Cost
                            </label>
                        </div>
                            
                        <!--apartment list start-->
                            <div class="form-group" id="apartment_list">
                                <label class="control-label">Select Property</label>
                                <div class="controls">
                                    <div class="chosen-container">
                                        <select name="general_cost_apartment_id" class="form-control" data-placeholder="Choose apartment" tabindex="1">
                                            <option value="">Property List</option>
                                            <?php foreach ($apartments_list as $al): ?>
                                                <?php if(isset($generalcost_edit) && $generalcost_edit['apartment_id']==$al->id):?>
                                                    <option selected="selected" value="<?php echo $al->id;?>"><?php echo $al->id." (".$al->address.")"; ?></option>
                                                <?php else:?>
                                                    <option <?php echo set_select('general_cost_apartment_id',$al->id);?> value="<?php echo $al->id;?>"><?php echo $al->id." (".$al->address.")"; ?></option>
                                                <?php endif;?>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <!--//apartment list end-->

                        <!--cost type start-->
<!--                            <div class="form-group">
                                <label class="control-label">Select Cost Type</label>
                                <div class="controls">
                                    <div class="chosen-container">
                                        <select name="general_cost_type" class="form-control" data-placeholder="Choose cost type" tabindex="1">
                                            <option value="">Cost Type</option>
                                            <?php foreach(service_charges() as $k=>$v):?>
                                                <?php if(isset($generalcost_edit) && $generalcost_edit['cost_type']==$k):?>
                                                    <option selected="selected" value="<?php echo $k;?>"><?php echo $v; ?></option>
                                                <?php else:?>
                                                    <option <?php echo set_select('general_cost_type',$k);?> value="<?php echo $k;?>"><?php echo $v; ?></option>
                                                <?php endif;?>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>-->
                        <!--//cost type end-->
                        
                        <!--Description start-->
                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <textarea name="gc_description" placeholder="Description" class="form-control"><?php echo isset($generalcost_edit)?$generalcost_edit['description']:set_value('gc_description');?></textarea>
                            </div>
                        <!--//Description end-->
    
                        <!--general cost amount start-->
                            <div class="form-group">
                                <label class="control-label">Amount (£)</label>
                                <input 
                                        type="text" 
                                        name="general_cost_amount" 
                                        required placeholder="General cost amount" 
                                        value="<?php echo isset($generalcost_edit)?$generalcost_edit['amount']:set_value('general_cost_amount');?>" 
                                        class="form-control"/>
                            </div>
                        <!--//general cost amount start-->
                        
                        <!--general cost amopunt start-->
                            <div class="form-group general_cost_form_element">
                                <label class="control-label">Supplier Invoice date</label>
                                <input type="text" name="supplier_invoice_date" id="supplier_invoice_date" value="<?php echo set_value('supplier_invoice_date',mydate($generalcost_edit['supplier_invoice_date'],"-")); ?>" class="form-control"/>
                            </div>

                             <!--general cost amopunt start-->
                            <div class="form-group general_cost_form_element">
                                <label class="control-label">Supplier Invoice number</label>
                                <input type="text" name="supplier_invoice_number" value="<?php echo set_value('supplier_invoice_number',$generalcost_edit['supplier_invoice_number']);?>" class="form-control"/>
                            </div>
                        
                        <!--//general cost amopunt start-->
                            
                            <div class="form-group general_cost_form_element">
                                <div class="form-group">
                                    <label class="control-label">Upload</label>
                                    <div id="gc_file" class="fileuploader">Upload</div>

                                        <div class="clearfix"></div>

                                        <div id='gc_file_response'>

                                        </div>
                                    </div>
                            </div>
                        
                            <div class="form-group general_cost_form_element">
                                <label class="control-label">Supplier</label>
                                <div class="controls">
                                    <div class="chosen-container">
                                        <select name="supplier_id" id="supplier_id" class="form-control">
                                            <option value="">... Select ...</option>
                                            <?php foreach ($suppliers as $value): ?>
                                                <option value="<?php echo $value["id"]; ?>" <?php echo $generalcost_edit['supplier_id'] == $value["id"]?"selected":"" ?>><?php echo $value["name"]." ".$value["surname"]; ?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="form-group general_cost_form_element">
                                <label class="control-label">Cost Code</label>
                                <div class="controls">
                                    <div class="chosen-container">
                                        <select name="nominal_code" id="supplier_id" class="form-control">
                                            <option value="">... Select ...</option>
                                            <?php foreach ($cost_codes as $value): ?>
                                                <option value="<?php echo $value["nominal_code"]; ?>" <?php echo $generalcost_edit['nominal_code'] == $value["nominal_code"]?"selected":"" ?>><?php echo $value["ledger_name"]; ?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        <!--general cost amopunt start-->
                            <div class="form-group">
                                <label class="control-label">Expiration Date</label>
                                <input 
                                        type="text" 
                                        name="general_cost_expiration_date" 
                                        id="general_cost_expiration_date" 
                                        required placeholder="General cost expiration date" 
                                        value="<?php echo isset($generalcost_edit)?formatted_date($generalcost_edit['expire_date'],"d-m-Y"):set_value('general_cost_expiration_date');?>" 
                                        class="form-control"/>
                            </div>
                        <!--//general cost amopunt start-->
                            <div class="form-actions">
                                <?php if($generalcost_edit['file_name']) {?>
                                <input type="hidden" name="old_file_name" value="<?php echo $generalcost_edit['file_name']?>">
                                <?php }?>
                                <button type="submit" class="btn blue"><i class="icon-ok"></i> Update</button>
                                <a href="<?php echo base_url_tr() ?>general_cost/general_cost_lists" class="btn btn-danger"><i class="icon-remove"></i> <?php echo lang('btn_cancel') ?></a>
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

<script type="text/javascript">
    $(document).ready(function() {
        
        <?php if($generalcost_edit['general_cost_type'] == "general_cost"){?>
                $("#apartment_list").hide();
                $(".general_cost_form_element").show();
        <?php } else {?>
                $("#apartment_list").show();
                $(".general_cost_form_element").hide();
        <?php }?>
            
        //to apply date time picker 
        $("#general_cost_expiration_date").datetimepicker({
            datepicker: true,
            timepicker: false,
            format: 'd-m-Y',
        });
        
                $("#supplier_invoice_date").datetimepicker({
            datepicker: true,
            timepicker: false,
            format: 'd-m-Y',
        });
        
        
        $('input[type=radio][name=general_cost_type]').change(function() {
            if (this.value == 'related_apartment') {
                //alert("realtedai");
                $("#apartment_list").show();
                $(".general_cost_form_element").hide();
            }
            else if (this.value == 'general_cost') {
                //alert("general");
                $("#apartment_list").hide();
                $(".general_cost_form_element").show();
            }
        });

        $("#gc_file").uploadFile({
            url: baseUrl + "general_cost/gc_file_upload",
            allowedTypes: "pdf,jpg,jpeg,png",
            multiple: false,
            fileName: "myfile",
            autoSubmit: true,
            maxFileSize: 10 * 1024 * 1024,
            showStatusAfterSuccess: false,
            sequential: true,
            sequentialCount: 1,
            onSuccess: function (files, data, xhr) {
                //$("#complaint").val("1");
                //console.log(data);
                var info = JSON.parse(data);
                var orig_name = info.upload_data.orig_name;
                var file_name =  info.upload_data.file_name;
                console.log(info);

                $("#gc_file_response").append("<div>" + info.upload_data.orig_name + "</div>"+"<input type='hidden' name='file_name' value='"+file_name+"'/>");
            }
        });

    });
</script>