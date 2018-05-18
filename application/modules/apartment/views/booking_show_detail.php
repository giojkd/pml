<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title"><?php echo $title; ?></h2>
    </div>

    <div class="panel-body">
        <div class="validation_errors"></div>
        <table class="table table-striped table-bordered table-hover display responsive nowrap" id="apartment_list1" width="100%">
            <thead>
                
            </thead>
             
            <tbody
                <?php foreach ($booking_detail as $key => $value) {?>
                <tr>
                    <th>
                        Booking ID
                    </th>
                    <td>
                        <?php echo $value['id']; ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        Property
                    </th>
                    <td>
                        <?php echo $value['apartment_id'].' - '.get_single_table_data_by_id($value['apartment_id'], $field = "address", $table = "apartment_detail");?>
                    </td>
                </tr>
                <tr>
                    <th>
                        Room
                    </th>
                    <td>
                        <?php echo $value['room_id'].' - ';echo get_single_table_data_by_id($value['room_id'], $field = "room_type", $table = "rooms")== "1"?"Single Type":"Double Type";?>
                    </td>
                </tr>
                <tr>
                    <th>
                        Occupants
                    </th>
                    <td>
                         <?php foreach ($tenants as $key => $tenant) {?>
                         <?php echo in_array($tenant['id'], $booked_tenants) ? $tenant['name']." ".$tenant['family_name']."<br>":" "; ?>
                        
                         <?php }?>
                    </td>
                </tr>
                <tr>
                    <th>
                        Rent From
                    </th>
                    <td>
                        <?php echo date('d-m-Y',  strtotime($value['rent_from'])); ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        Rent To
                    </th>
                    <td>
                       <?php echo date('d-m-Y',  strtotime($value['rent_to'])); ?>
                    </td>
                </tr>
                <tr>
                    <th>
                       Date for monthly payment
                    </th>
                    <td>
                        <?php echo $value['payment_date'];?>
                    </td>
                </tr>
                <tr>
                    <th>
                       Monthly Fee (£)
                    </th>
                    <td>
                        <?php echo $value['monthly_fee'];?>
                    </td>
                </tr>
                <tr>
                    <th>
                       Deposit Fee (£)
                    </th>
                    <td>
                        <?php echo $value['deposit_fee'];?>
                    </td>
                </tr>
                <tr>
                    <th>
                       Booking Fee Amount (£)
                    </th>
                    <td>
                        <?php echo $value['booking_fee'];?>
                    </td>
                </tr>
                <tr>
                    <th>
                       Agreement File
                    </th>
                    <td>
                        <?php if($value['agreement_file'] != ""){?>
                        <a href="<?php echo base_url('uploads/agreement_file/'.$value['agreement_file']);?>" target="_blank"> <?php echo $value['orig_file_name'];?></a>
                        <?php } else{?>
                        No File Found
                        <?php }?>
                    </td>
                </tr>
                <?php }?>
                <tr>
                    <th>Other Files</th>
                    <td>
                        <table class="table table-striped">
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>File Name</th>
                                <th>Uploaded By</th>
                                <th>Download</th>
                                <th>Delete</th>
                            </tr>
                            <?php foreach($other_files as $file){?>
                                <tr>
                                    <td><?php echo date_format(date_create($file->date),"d-m-Y H:i");?></td>
                                    <td><?php echo $file->description;?></td>
                                    <td><?php echo $file->original_file_name;?></td>
                                    <td><?php echo $file->name.' '.$file->family_name;?></td>
                                    <td><a href="<?php echo base_url('uploads/agreement_file/'.$file->file_name);?>" target="_blank"><i class="glyphicon glyphicon-download-alt"></i></a></td>
                                    <td><a class="delete-file" href="javascript::" data-href="<?php echo base_url('apartment/booking_detail_delete/'.$file->uploaded_file_id.'/'.$value['id']);?>"><i class="glyphicon glyphicon-trash"></i></a></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
            </tbody>
             
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {        
        $('.delete-file').click(function () {
            if(confirm('Are you sure delete this file?')) {

                $.ajax({
                    url: $(this).attr('data-href'),
                    type: 'POST',
                    data: {test:5},
                    success: function (response) {
                        try {
                            var result = JSON.parse(response);
                            if (result.status) {
                                $('.validation_errors').html('<div class="alert alert-success">' + result.message + '</div>');
                                $("html, body").animate({scrollTop: 0}, 500, 'swing', function () {
                                    if (result.redirectto) {
                                        window.location.replace(result.redirectto);
                                    }
                                });

                            } else {
                                $('.validation_errors').html('<div class="alert alert-danger">' + result.message + '</div>');
                                $("html, body").animate({scrollTop: 0}, 500, 'swing', function () {
                                    if (result.redirectto) {
                                        window.location.replace(result.redirectto);
                                    }
                                });
                            }
                        } catch (e) {
                            console.log(e.message);
                        }
                    },
                    error: function (e) {
                        console.log(e);
                    },
                });
            }
            return false;
        });
    });
</script>