<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title"><?php echo $title; ?></h2>
    </div>
    
    <div class="panel-body">
        <div class="btn-group margin-bottom-10">
            <span><a href="<?php echo base_url_tr() ?>cashmanager/outgoing/oc_add" class="btn green"><i class="icon-plus"></i> <?php echo lang('label_add_new') ?></a></span>
            <span><a href="<?php echo base_url_tr() ?>reports/per_tenant_pdf?tenant_user_id=<?php echo $tenant_user_id; ?>&from_month=<?php echo $from_month; ?>&to_month=<?php echo $to_month; ?>" class="btn purple"><i class="fa fa-file-pdf-o"></i> PDF</a></span>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h4>Filter By</h4>
                <div class="alert alert-success">
                    <form method="get" action="<?php echo base_url_tr('reports/per_tenant'); ?>">
                        <div class="col-lg-3">
                            <div class="input">
                                <label>Occupant</label>
                                <select name="tenant_user_id" id="tenant_user_id" class="form-control">
                                    <option value="all">All</option>
                                    <?php foreach($tenants as $value) {?>
                                    <option <?php echo $tenant_user_id && $tenant_user_id == $value["id"] ? 'selected="selected"' : null; ?> value="<?php echo $value["id"]; ?>"><?php echo $value["name"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->

                        <div class="col-lg-3">
                            <div class="input">
                                <label>From Month</label>
                                <input type="text" value="<?php echo $from_month ? $from_month : null; ?>" name="from_month" placeholder="" class="form-control date-month" required />
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->

                        <div class="col-lg-3">
                            <div class="input">
                                <label>To Month</label>
                                <input type="text" value="<?php echo $to_month ? $to_month : null; ?>" name="to_month" placeholder="" class="form-control date-month" required />
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->

                        <div class="col-lg-3">
                            <div class="input">
                                <label>&nbsp;</label>
                                <input class="form-control btn green" type="submit" value="Filter" />
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div><!-- /.alert alert-success -->
            </div>
        </div><!-- /.row -->

        <?php echo $this->session->flashdata('save_success') ? $this->session->flashdata('save_success') : ''; ?>
        <table class="table table-striped table-bordered table-hover display responsive nowrap datatable" width="100%">
            <thead>
                <tr>
                    <th>Occupant Name</th>
                    <th>Month</th>
                    <th>Cost Type</th>
                    <th>Cash Out</th>
                    <th>Cash In</th>
                </tr>
            </thead>

            <tbody>
                <?php 
                $total_cost = 0; $total_revenue = 0;
                if($per_tenant_inout_cash && count($per_tenant_inout_cash) > 0) {
                    foreach($per_tenant_inout_cash as $cash){
                        $cost = $cash->total_cost;
                        $revenue = $cash->total_revenue;

                        $total_cost += $cost;
                        $total_revenue += $revenue;
                        ?>
                        <tr>
                            <td><?php echo $cash->name.' '.$cash->family_name;?></td>
                            <td><?php echo date('M Y', strtotime($cash->payment_status_update_date)); ?></td>
                            <td><?php echo get_cost_type_label($cash->cost_type); ?></td>
                            <td align="right"><?php echo $currency.$cost; ?></td>
                            <td align="right"><?php echo $currency.$revenue; ?></td>                       
                        </tr>
                        <?php 
                    } 
                }
                ?>
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="3">Total:</td>
                    <td align="right"><?php echo $currency.number_format($total_cost, 2, '.', ''); ?></td>
                    <td align="right"><?php echo $currency.number_format($total_revenue, 2, '.', ''); ?></td>
                </tr>
                <tr>
                    <td>Cash Balance:</td>
                    <td colspan="4" align="right">
                        <?php
                            $cash_balance=$total_revenue-$total_cost;
                            if($cash_balance<0)
                            {
                                echo '<p style="color:red;">'.$currency.number_format($cash_balance,2).'</p>';
                            }
                            else
                            {
                                echo '<p style="color:green;">'.$currency.number_format($cash_balance,2).'</p>';
                            }
                        ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- Detail Costs Modal -->
<div id="costDetailModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <table id="per_apartment_cost_details" class="table table-striped">
            <thead>
                <tr>
                    <th width="75%">Cost Details</th>
                    <th align="right">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <!--will be loaded from ajax call-->
            </tbody>
            <tfoot>
                <tr>
                    <td align="right">Total Cost</td>
                    <td align="right" id="total_amount"></td>
                </tr>
                <tr>
                    <td colspan="2" id="loader" align="center"></td>
                </tr>
            </tfoot>
        </table>
        <table id="per_apartment_revenue_details" class="table table-striped">
            <thead>
                <tr>
                    <th width="75%">Revenue Details</th>
                    <th align="right">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <!--will be loaded from ajax call-->
            </tbody>
            <tfoot>
                <tr>
                    <td align="right">Total Revenue</td>
                    <td align="right" id="total_revenue"></td>
                </tr>
                <tr>
                    <td colspan="2" id="" align="center"></td>
                </tr>
            </tfoot>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
    function costDetails(tenantId){
        $("#per_apartment_cost_details tbody").empty();
        $("#total_amount").empty();
        var cost_rows='';
        var revenue_rows='';
        var cost_type='';
        var revenue_type='';
        var total_amount=0;
        var total_revenue=0;
        $(".modal-title").html("Cost & Revenue Details Occupant ID-"+tenantId);
        $.ajax({
            url: '<?php echo base_url('reports/inout_cash_details');?>',
            type: 'post',
            dataType: 'json',
            data: {tenant_id:tenantId},
            beforeSend:function(){
                $("#loader").html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
            },
            complete:function(){
                $("#loader").html('');
            }
        })
        .done(function(response) {

            var costs=response.cost_details;
            var revenues=response.revenue_details;
            //for cost details
            for(var i=0;i<costs.length;i++){
                switch(costs[i].cost_type) {
                case '1':
                    cost_type='Water';
                    break;
                case '2':
                    cost_type='Gas';
                    break;
                case '3':
                    cost_type='Electricity';
                    break;
                case '4':
                     cost_type='Internet';
                    break;
                case '5':
                     cost_type='Council Tax';
                    break;
                default:
                     cost_type='';
                }

                total_amount+=Number.parseInt(costs[i].total_cost);
                cost_rows+='<tr><td>'+cost_type+'</td><td align="right">£'+costs[i].total_cost+'</td></tr>';
            }
            $("#per_apartment_cost_details tbody").html(cost_rows);
            $("#total_amount").html('£'+total_amount.toFixed(2));
            //for revenue details
            for(var j=0;j<revenues.length;j++){
                switch(revenues[j].cost_type) {
                case '1':
                    revenue_type='Water';
                    break;
                case '2':
                    revenue_type='Gas';
                    break;
                case '3':
                    revenue_type='Electricity';
                    break;
                case '4':
                     revenue_type='Internet';
                    break;
                case '5':
                     revenue_type='Council Tax';
                    break;
                default:
                     revenue_type='Installment';
                }

                total_revenue+=Number.parseInt(revenues[j].total_revenue);
                revenue_rows+='<tr><td>'+revenue_type+'</td><td align="right">£'+revenues[j].total_revenue+'</td></tr>';
            }
            $("#per_apartment_revenue_details tbody").html(revenue_rows);
            $("#total_revenue").html('£'+total_revenue.toFixed(2));
        })
        .fail(function(err) {
            console.log(err);
        })
        .always(function() {
            console.log("complete");
        });
        
    }
</script>