<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title"><?php echo $title; ?></h2>
    </div>

    <div class="panel-body">
        <div class="btn-group margin-bottom-10">
        </div>

        <table class="table table-striped table-bordered table-hover display responsive nowrap" id="cleaning_list" width="100%">
            <thead>
                <tr>
                    <th><?php echo lang('date');?></th>
                    <th>Photo</th>
                    <th><?php echo lang('cleaner');?></th>
                    <th><?php echo lang('cleaning_property');?></th>
                    <th><?php echo lang('cleaning_area');?></th>
                    <th>Who is responsible?</th>
                    <th><?php echo lang('cleaning_cost').' £';?></th>
                    <th>Supplier</th>
                    <th><?php echo lang('invoice');?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cleaning as $value): ?>
                    <tr>
                       <td><?php echo date('d-m-Y', strtotime($value['cleaning_createDate'])); ?></td>
                       <td><?php echo ($value['file_name']) ? '<img width="100" src="/ap4rent/backend/uploads/temp/'.$value['file_name'].'">' : 'N/A' ?>
                       <td><?php echo $value['cleaner_name']; ?></td>
                       <td><?php echo $value['apartment_id'].($value['address']?' - '.$value['address']:""); ?></td>
                       <td><?php echo $value['room_id'] ? "Room ".$value['room_description']:"Communal areas";?></td>
                       <td>
                        <?php
                          if($value['who_pay'] == "pml")
                          {
                            echo "PML";
                          }
                          else if($value['who_pay'] == "all_licensee")
                          {
                            echo "All Occupants";
                          }
                          else if($value['who_pay'] == "apartment_owner")
                          {
                            echo "Property Owner";
                          }
                          else
                          {
                            $licensee = explode('/', $value['who_pay']);
                            echo getUser($licensee[0], $field = "family_name").' '.getUser($licensee[0], $field = "name").', Room '.$value['room_id'].' ('.$licensee[1].')';
                          }
                        ?>
                        </td>
                       <td><?php echo $value['cleaning_cost'];?></td>
                       <?php if($value['who_pay'] == "pml")
                            {
                                $invoice = 'n/a';
                            }
                            else{
                              if($value['cleaning_invoice_create'] == 0)
                              {
                                $invoice = '<a class="create_invoice" data-cleaning-id = "'.$value["id"].'">Create Invoice</a>';
                              }
                              else if($value['cleaning_invoice_create'] == 1)
                              {
                                $invoice = '<a class="send_invoice" data-cleaning-id = "'.$value["id"].'">Send Invoice</a>';
                              }

                              if($value['cleaning_invoice_sent'] == 1)
                              {
                                $invoice = 'Sent';
                              }


                            }
                       ?>
                       <td><?php echo $value['supplier_company']?> (<?php echo $value['supplier_cost']?>)</td>
                       <td><?php echo $invoice;?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<script type="text/javascript">

    $(document).ready(function () {
        $('#cleaning_list').dataTable({
               responsive: true,
           });
    });

    $(document).on('click', '.create_invoice', function(){
        var cleaning_id = $(this).data('cleaning-id');
        var that = $(this);
         $.ajax({
            url: "<?php echo base_url_tr('cleaning/create_invoice'); ?>",
            type: "post",
            data: {cleaning_id: cleaning_id},
            beforeSend:function(){
                    that.html("Creating...");
                },
            success: function (result) {
              console.log(result);
              if(result == "success")
              {
                that.parent("td").html('<a class="send_invoice" data-cleaning-id = "'+cleaning_id+'">Send Invoice</a>');

              }
            }
        });

    });

    $(document).on('click', '.send_invoice', function(){
        var cleaning_id = $(this).data('cleaning-id');
        var that = $(this);
         $.ajax({
            url: "<?php echo base_url_tr('cleaning/send_invoice'); ?>",
            type: "post",
            data: {cleaning_id: cleaning_id},
            beforeSend:function(){
                    that.html("Sending...");
                },
            success: function (result) {
              console.log(result);
              if(result == "success")
              {
                that.parent("td").html("Sent");
              }
            }
        });

    });

</script>
