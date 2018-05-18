<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title"><?php echo $title; ?></h2>
    </div>

    <div class="panel-body">
        <div class="btn-group margin-bottom-10">
            <!--<a href="<?php //echo base_url_tr('general_cost') ?>" class="btn green"><i class="icon-plus"></i> <?php //echo lang('label_add_new') ?></a>-->
        </div>
 <div class="portlet-body form">
                <?php if (validation_errors()): ?>
                    <div class="alert alert-danger" style="color: #b42020">
                        <button class="close" data-dismiss="alert" type="button">x</button>
                        <?php echo validation_errors(); ?>
                    </div>
                <?php endif; ?>
                    <!-- BEGIN FORM-->
                    <form class="item_add_form" id="calendar_view" action="<?php echo base_url(); ?>bank/bma_save" method="post">
                        <div class="form-body col-xs-12">

                            <div class="form-group">
                                <label class="control-label">Movement Date</label>
                                <input type="text" name="movement_date" value="<?php echo mydate($bank_temp['payment_date'],"-");?>" id="movement_date" class="form-control"/>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <textarea name="movement_description" id="movement_description" class="form-control"><?php echo $bank_temp['description'];?></textarea>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Amount</label>
                                <input type="text" name="movement_amount" value="<?php echo $bank_temp['amount'];?>" id="movement_amount" class="form-control"/>
                            </div>

                             <div class="form-group">
                                <label class="control-label">Type</label>
                                <select name="movement_type" id="movement_type" class="form-control" required>
                                    <option value="1" <?php echo $bank_temp['amount'] >= 0 ? "selected" : "" ?>>Entrance</option>
                                    <option value="2" <?php echo $bank_temp['amount'] < 0 ? "selected" : "" ?>>Exit</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label">
                                    <input type="radio" name="tenant_or_owner" value="1" checked> To Occupant
                                </label>
                                
                                <label class="control-label">
                                    <input type="radio" name="tenant_or_owner" value="2"> To Owner
                                </label>
                                
                                <label class="control-label">
                                    <input type="radio" name="tenant_or_owner" value="3"> To Supplier
                                </label>
                            </div>
                            
                            <div class="form-group" id="tenant_area">
                                <label class="control-label">Occupant</label>
                                <select name="tenant_user_id" id="tenant_user_id" class="form-control">
                                    <?php foreach($tenants as $value) {?>
                                    <option value="<?php echo $value["id"]; ?>"><?php echo $value["name"]." ".$value["family_name"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                            <div class="form-group" id="owner_area">
                                <label class="control-label">Owner</label>
                                <select name="owner_user_id" id="owner_user_id" class="form-control">
                                    <?php foreach($owners as $value) {?>
                                    <option value="<?php echo $value["id"]; ?>"><?php echo $value["name"]." ".$value["family_name"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                            <div class="form-group" id="supplier_area">
                                <label class="control-label">Supplier</label>
                                <select name="supplier_user_id" id="supplier_user_id" class="form-control">
                                    <option value="">---Select---</option>
                                    <?php foreach($suppliers as $value) {?>
                                    <option value="<?php echo $value["id"]; ?>"><?php echo $value["name"]." ".$value["surname"].' ('.$value["company"].') '; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                            <div class="form-group" id="unpaid_cost_div">
                                <label class="control-label">Unpaid Cost</label>
                                <select name="unpaid_cost_id" id="unpaid_cost" class="form-control">
                                    <option value="">--Select--</option>
                                </select>
                            </div>
                            
                            </div> <!-- end of tenant area -->
                            
                            
                            <div class="form-actions">
                                <button type="submit" class="btn blue"><i class="icon-ok"></i> Save</button>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
                    <div class="clearfix"></div>
                </div>
    
        <div id="search_result">

        </div>

    </div>



<script type="text/javascript">

$(document).ready(function () {
    $("#tenant_area").show();
    $("#supplier_area").hide();
    $("#owner_area").hide();
    $("#unpaid_cost_div").hide();

    $("#tenant_user_id").select2();
    $("#owner_user_id").select2();
    $("#supplier_user_id").select2();
    $("#unpaid_cost").select2();

    $('#movement_date').datetimepicker({
        datepicker: true,
        timepicker: false,
        format: 'd-m-Y',
        mask: false
    });

    $('input[type=radio][name=tenant_or_owner]').change(function() {
            if (this.value == '1') {
                //alert("realtedai");
                $("#unpaid_cost").empty();
                $("#unpaid_cost").select2("val", "");
                $("#tenant_area").show();
                $("#supplier_area").hide();
                $("#owner_area").hide();
                $("#unpaid_cost_div").hide();

                $("#tenant_user_id").select2("val", "");
                $("#owner_user_id").select2("val", "");
                $("#supplier_user_id").select2("val", "");
                
                $("#movement_description").val("");
                $("#movement_amount").val("");

            }
            else if (this.value == '2') {
                //alert("general");
               $("#unpaid_cost").empty();
              $("#unpaid_cost").select2("val", "");
               $("#owner_area").show();
               $("#supplier_area").hide();
               $("#tenant_area").hide();
               $("#unpaid_cost_div").hide();

               $("#tenant_user_id").select2("val", "");
                $("#owner_user_id").select2("val", "");
                $("#supplier_user_id").select2("val", "");
                
                $("#movement_description").val("");
                $("#movement_amount").val("");
                
            }
            else if (this.value == '3') {
                //alert("general");
                $("#unpaid_cost").empty();
                $("#unpaid_cost").select2("val", "");
               $("#owner_area").hide();
               $("#tenant_area").hide();
               $("#supplier_area").show();
               $("#unpaid_cost_div").hide();

               $("#tenant_user_id").select2("val", "");
                $("#owner_user_id").select2("val", "");
                $("#supplier_user_id").select2("val", "");

            }
        });

    $("#tenant_user_id").on("change", function(){
         $("#unpaid_cost_div").show();
         $("#unpaid_cost").empty();
                $("#unpaid_cost").select2("val", "");
          
        var id = $(this).val();
        if(id)
        {
            getUnpaidCost(id, "1");
        }
    });

    $("#owner_user_id").on("change", function(){
         $("#unpaid_cost_div").show();
         $("#unpaid_cost").empty();
                $("#unpaid_cost").select2("val", "");

        var id = $(this).val();
        if(id)
        {
            getUnpaidCost(id, "2");
        }
    });

    $("#supplier_user_id").on("change", function(){
         $("#unpaid_cost_div").show();
         $("#unpaid_cost").empty();
                $("#unpaid_cost").select2("val", "");

        var id = $(this).val();
        if(id)
        {
            getUnpaidCost(id, "3");
        }
    });

    function getUnpaidCost(id, user_type)
    {
        $("#unpaid_cost").html("");
        $.ajax({
                type: "POST",
                url: "<?php echo base_url_tr('bank/unpaid_cost_by_id'); ?>",
                data: {"id" : id, "user_type" : user_type},
                beforeSend:function(){

                },
                success: function (result) {
                    var data = JSON.parse(result);
                    console.log(data);
                    $("#unpaid_cost").append('<option value="">---Select---</option>');
                    for(var i = 0; i < data.length; i++)
                    {
                        var html = '<option data-desc="'+data[i].description+'" data-amount="'+data[i].amount+'" value="'+(user_type == "3"?data[i].gc_id:data[i].id)+'">'+'<strong>ID: </strong>'+(user_type == "3"?data[i].gc_id:data[i].id)+' - '+(user_type == "3"? '<strong>Description: </strong>'+data[i].description:'<strong>Revenue: </strong>'+data[i].revenue_amount)+(user_type == "3"?'<strong> - Amount: </strong>'+data[i].amount:"")+'</option>';
                        $("#unpaid_cost").append(html);
                    }

                },
                complete:function(){

                }
            });
    }
    
    
    $("#unpaid_cost").on("change", function(){
        //alert($(this).find(':selected').data('desc'));
        if($("input[name='tenant_or_owner']:checked").val() == "3"){
            $("#movement_description").val($(this).find(':selected').data('desc'));
            $("#movement_amount").val($(this).find(':selected').data('amount'));
        }
    });
    
});
    
</script>