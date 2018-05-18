<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title"><?php echo $title; ?></h2>
    </div>

    <div class="panel-body">
        <div class="pull-left btn-group margin-bottom-10">
            <label>Select Appartment</label>
            <select name="apartment_id" class="apartment_id form-control" data-placeholder="Choose an Apartment">
                <option value="">Select</option>
                <?php
                if($apartments) {
                    foreach ($apartments as $key => $value) {
                        ?>
                        <option value="<?php echo $value['id']  ?>" data-contract="<?php echo $value['contract_to']; ?>"><?php echo "Property: ".$value['apartment_id'].", Address: ".$value['address'];  ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>

        <div class="pull-left">
            <label>&nbsp;</label>
            <button type="button" class="add-apartment btn blue" style="margin-top: 25px;"> Add Apartment</button>
        </div>

        <?php echo $this->session->flashdata('save_success') ? $this->session->flashdata('save_success') : ''; ?>
        <table class="account-table table table-striped table-bordered table-hover display responsive nowrap" width="100%">
            <thead>
                <tr>
                    <th>Apartment</th>
                    <th>Date</th>
                    <th>Internet</th>
                    <th>Council Tax</th>
                    <th>Water</th>
                    <th>Electricity</th>
                    <th>Gas</th>
                </tr>
            </thead>

            <tbody>
            <?php
            if($apartments_list) {
                foreach($apartments_list as $list) {
                    $apartment_contract_date = $list['contract_from'];
                    $apartment_name = "Property: ".$list['apartment_id']."<br> Address: ".$list['address'];;

                    $internet_close_status  = $list['internet_close_status'];
                    $council_tax_close_status = $list['council_tax_close_status'];
                    $water_close_status = $list['water_close_status'];
                    $electricity_close_status = $list['electricity_close_status'];
                    $gas_close_status = $list['gas_close_status'];

                    $txt_internet = $internet_close_status == 0 ? '<button data-value="1" type="button" name="internet" class="to-close btn-xs btn blue"> to close</button>':'<a data-value="0" name="internet" class="to-close label label-success">CLOSED</a>';
                    $txt_council = $council_tax_close_status == 0 ? '<button data-value="1" type="button" name="council" class="to-close btn-xs btn blue"> to close</button>':'<a data-value="0" name="council" class="to-close label label-success">CLOSED</a>';
                    $txt_water = $water_close_status == 0 ? '<button data-value="1" type="button" name="water" class="to-close btn-xs btn blue"> to close</button>':'<a data-value="0" name="water" class="to-close label label-success">CLOSED</a>';
                    $txt_electricity = $electricity_close_status == 0 ? '<button data-value="1" type="button" name="el" class="to-close btn-xs btn blue"> to close</button>':'<a data-value="0" name="el" class="to-close label label-success">CLOSED</a>';
                    $txt_gas = $gas_close_status == 0 ? '<button data-value="1" type="button" name="gas" class="to-close btn-xs btn blue"> to close</button>':'<a data-value="0" name="gas" class="to-close label label-success">CLOSED</a>';

                    ?>
                    <tr class="row<?php echo $list['id']; ?>">
                        <td><input type="hidden" value="<?php echo $list['id']; ?>" class="apartment_id"><?php echo $apartment_name; ?></td>
                        <td><?php echo mydate($apartment_contract_date,'-'); ?></td>
                        <td><?php echo $txt_internet; ?></td>
                        <td><?php echo $txt_council; ?></td>
                        <td><?php echo $txt_water; ?></td>
                        <td><?php echo $txt_electricity; ?></td>
                        <td><?php echo $txt_gas; ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    jQuery(document).ready(function() {
        $(".add-apartment").on('click', function(event){
            var apartment_id = $('.apartment_id').val();
            $.ajax({
                url: baseUrl + "utility_bills/utilitybills/ajax_get_apartment_info",
                data: {
                    apartment_id : apartment_id
                },
                type: "POST",
                dataType: 'json',
                beforeSend: function() {
                    console.log('please wait...');
                },
                success: function(result){
                    if(apartment_id != "") {
                        var apartment_contract_date = result['contract_from'];
                        var apartment_name = result['name']+" "+result['family_name'];

                        var internet_close_status  = result['internet_close_status'];
                        var council_tax_close_status = result['council_tax_close_status'];
                        var water_close_status = result['water_close_status'];
                        var electricity_close_status = result['electricity_close_status'];
                        var gas_close_status = result['gas_close_status'];

                        var txt_internet = internet_close_status == 0 ? '<button data-value="1" type="button" name="internet" class="to-close btn-xs btn blue"> to close</button>':'<a data-value="0" name="internet" class="to-close label label-success">CLOSED</a>';
                        var txt_council = council_tax_close_status == 0 ? '<button data-value="1" type="button" name="council" class="to-close btn-xs btn blue"> to close</button>':'<a data-value="0" name="council" class="to-close label label-success">CLOSED</a>';
                        var txt_water = water_close_status == 0 ? '<button data-value="1" type="button" name="water" class="to-close btn-xs btn blue"> to close</button>':'<a data-value="0" name="water" class="to-close label label-success">CLOSED</a>';
                        var txt_electricity = electricity_close_status == 0 ? '<button data-value="1" type="button" name="el" class="to-close btn-xs btn blue"> to close</button>':'<a data-value="0" name="el" class="to-close label label-success">CLOSED</a>';
                        var txt_gas = gas_close_status == 0 ? '<button data-value="1" type="button" name="gas" class="to-close btn-xs btn blue"> to close</button>':'<a data-value="0" name="gas" class="to-close label label-success">CLOSED</a>';

                        var html = '';
                        html += '<tr class="row'+apartment_id+'">';
                        html += '<td><input type="hidden" value="'+apartment_id+'" class="apartment_id">'+apartment_name+'</td>';
                        html += '<td>'+apartment_contract_date+'</td>';
                        html += '<td>'+txt_internet+'</td>';
                        html += '<td>'+txt_council+'</td>';
                        html += '<td>'+txt_water+'</td>';
                        html += '<td>'+txt_electricity+'</td>';
                        html += '<td>'+txt_gas+'</td>';
                        html += '</tr>';

                        if (!$(".account-table").find('.row'+apartment_id).length) {
                            $('.account-table tbody').append(html);
                        }
                    }
                }
            });
        });

        $(".account-table").on('click', '.to-close', function(event){
            var button = $(this);
            var type = button.attr('name');
            var apartment_id = button.parents('tr').find('.apartment_id').val();
            var status = button.attr('data-value');

            $.ajax({
                url: baseUrl + "utility_bills/utilitybills/ajax_status_change_to_close",
                data: {
                    apartment_id : apartment_id,
                    type : type,
                    status : status,
                },
                type: "POST",
                dataType: 'json',
                success: function(result){
                    if(result == 1 && status == '1'){
                        button.parents('td').html('<a data-value="0" name="'+type+'" class="to-close label label-success">CLOSED</a>');
                    }
                    if(result == 1 && status == '0'){
                        button.parents('td').html('<button data-value="1" type="button" name="'+type+'" class="to-close btn-xs btn blue"> to close</button>');
                    }
                }
            });
        });
    });
</script>