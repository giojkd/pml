<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title">Aert Lists</h2>
    </div>
    
    <div class="panel-body">
        <ul class="list-group">
        	<?php foreach($alert_list as $list){?>
            <?php 
                if($list->cost_for=='1'){
                    $base_url=base_url('cashmanager/outgoing/outgoing_invoice/'.$list->id);
                }
                else if($list->cost_for=='2'){
                    $base_url=base_url('cashmanager/revenue/installment_invoice/'.$list->id);
                }
            ?>
		    	<a href="<?php echo $base_url;?>">
                    <li class="list-group-item">A payment of <b><?php echo $list->revenue_amount;?>£</b> for <b><?php echo ($list->cost_type==0)?'Installment':service_charges($list->cost_type);?></b> has been dued for <b>apartment-<?php echo $list->apartment_id;?></b> </li>
                </a>
		   	<?php } ?>
		</ul>
    </div>
</div>
