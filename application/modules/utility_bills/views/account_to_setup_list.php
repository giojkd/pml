
<div class="panel panel-success">
  <div class="panel-heading clearfix">
    <h2 class="panel-title"><?php echo $title; ?></h2>
  </div>

  <div class="panel-body">
    <table class="account-table table table-striped table-bordered table-hover display responsive nowrap" width="100%">
      <thead>
        <tr>
          <th>Apartment</th>
          <th>Internet</th>
          <th>Council Tax</th>
          <th>Water</th>
          <th>Electricity</th>
          <th>Gas</th>
        </tr>
      </thead>

      <tbody>
        <?php

        if($apartments) {
          foreach ($apartments as $key => $value) {
            if($value['internet_account_no'] != "" && $value['internet_address'] != "" && $value['internet_debit'] != "") {
              $btn_internet = 'ok';
            } else {
              $btn_internet = 'to be setup';
            }

            if($value['council_account_no'] != "" && $value['council_address'] != "" && $value['council_debit'] != "") {
              $btn_council = 'ok';
            } else {
              $btn_council = 'to be setup';
            }

            if($value['water_account_no'] != "" && $value['water_address'] != "" && $value['water_debit'] != "") {
              $btn_water = 'ok';
            } else {
              $btn_water = 'to be setup';
            }

            if($value['electricity_account_no'] != "" && $value['electricity_address'] != "" && $value['electricity_debit'] != ""  && $value['electricity_tariff'] != ""  && $value['electricity_tariff_expiry_date'] != ""  && $value['electricity_unit_price'] != "") {
              $btn_electricity = 'ok';
            } else {
              $btn_electricity = 'to be setup';
            }

            if($value['gas_account_no'] != "" && $value['gas_address'] != "" && $value['gas_debit'] != "") {
              $btn_gas = 'ok';
            } else {
              $btn_gas = 'to be setup';
            }
            ?>
            <tr class="row<?php echo $value['apid']; ?>">
              <td>
                <input type="hidden" value="<?php echo $value['apid']; ?>" class="apid">
                <?php echo $value['name']." ".$value['family_name'];  ?>
              </td>
              <td><button type="button" class="internet to-setup-model btn-xs btn btn-primary" data-toggle="modal" data-target="#to-be-setupModel"><?php echo $btn_internet; ?></button></td>
              <td><button type="button" class="council to-setup-model btn-xs btn btn-primary" data-toggle="modal" data-target="#to-be-setupModel"><?php echo $btn_council; ?></button></td>
              <td><button type="button" class="water to-setup-model btn-xs btn btn-primary" data-toggle="modal" data-target="#to-be-setupModel"><?php echo $btn_water; ?></button></td>
              <td><button type="button" class="electricity to-setup-model btn-xs btn btn-primary" data-toggle="modal" data-target="#to-be-setupModel"><?php echo $btn_electricity; ?></button></td>
              <td><button type="button" class="gas to-setup-model btn-xs btn btn-primary" data-toggle="modal" data-target="#to-be-setupModel"><?php echo $btn_gas; ?></button></td>
            </tr>
            <?php
          }
        }
        ?>
      </tbody>
    </table>

  </div>
</div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="to-be-setupModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Account to be Setup Model</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" value="" class="apartment_id">
        <table class="popup-account-table table table-striped table-bordered table-hover display responsive nowrap" width="100%">
          <thead>
            <tr>
              <th></th>
              <th>Internet</th>
              <th>Council Tax</th>
              <th>Water</th>
              <th>Electricity</th>
              <th>Gas</th>
            </tr>
          </thead>

          <tbody>
            <tr>

              <td>Account No#</td>
              <td><input type="text" name="internet_account_no" class="form-control form-control-sm to-be-setup"></td>
              <td><input type="text" name="council_account_no" class="form-control form-control-sm to-be-setup"></td>
              <td><input type="text" name="water_account_no" class="form-control form-control-sm to-be-setup"></td>
              <td><input type="text" name="electricity_account_no" class="form-control form-control-sm to-be-setup"></td>
              <td><input type="text" name="gas_account_no" class="form-control form-control-sm to-be-setup"></td>
            </tr>
            <tr>
              <td>Supplier</td>
              <td>
                <select bill_type="internet" name="internet_supplier_id" class="form-control form-control-sm to-be-setup supplier_id_select" required>
                  <?php
                  echo '<option value="">Choose...</option>';
                  if($suppliers) {
                    foreach ($suppliers as $key => $value) {
                      echo '<option value="'.$value['id'].'">'.$value["company"].'</option>';
                    }
                  }?>
                </select>
              </td>
              <td>
                <select bill_type="council" name="council_supplier_id" class="form-control form-control-sm to-be-setup supplier_id_select" required>
                  <?php
                  echo '<option value="">Choose...</option>';
                  if($suppliers) {
                    foreach ($suppliers as $key => $value) {
                      echo '<option value="'.$value['id'].'">'.$value["company"].'</option>';
                    }
                  }?>
                </select>
              </td>
              <td>
                <select bill_type="water" name="water_supplier_id" class="form-control form-control-sm to-be-setup supplier_id_select" required>
                  <?php
                  echo '<option value="">Choose...</option>';
                  if($suppliers) {
                    foreach ($suppliers as $key => $value) {
                      echo '<option value="'.$value['id'].'">'.$value["company"].'</option>';
                    }
                  }?>
                </select>
              </td>
              <td>
                <select bill_type="electricity" name="electricity_supplier_id" class="form-control form-control-sm to-be-setup supplier_id_select" required>
                  <?php
                  echo '<option value="">Choose...</option>';
                  if($suppliers) {
                    foreach ($suppliers as $key => $value) {
                      echo '<option value="'.$value['id'].'">'.$value["company"].'</option>';
                    }
                  }?>
                </select>
              </td>

              <td>
                <select bill_type="gas" name="gas_supplier_id" class="form-control form-control-sm to-be-setup supplier_id_select" required>
                  <?php
                  echo '<option value="">Choose...</option>';
                  if($suppliers) {
                    foreach ($suppliers as $key => $value) {
                      echo '<option value="'.$value['id'].'">'.$value["company"].'</option>';
                    }
                  }?>
                </select>
              </td>

            </tr>
            <tr>
              <td>Monthly cost</td>
              <td><input bill_type="internet" type="text" name="internet_monthly_cost" class="form-control form-control-sm to-be-setup monthly_cost"></td>
              <td><input bill_type="council" type="text" name="council_monthly_cost" class="form-control form-control-sm to-be-setup monthly_cost"></td>
              <td><input bill_type="water" type="text" name="water_monthly_cost" class="form-control form-control-sm to-be-setup monthly_cost"></td>
              <td><input bill_type="electricity" type="text" name="electricity_monthly_cost" class="form-control form-control-sm to-be-setup monthly_cost"></td>
              <td><input bill_type="gas" type="text" name="gas_monthly_cost" class="form-control form-control-sm to-be-setup monthly_cost"></td>
            </tr>

            <tr>
              <td>Total cost</td>
              <td>
                <input type="text" name="internet_monthly_cost_total" class="form-control form-control-sm" disabled>
              </td>
              <td>
                <input type="text" name="council_monthly_cost_total" class="form-control form-control-sm" disabled>
              </td>
              <td>
                <input type="text" name="water_monthly_cost_total" class="form-control form-control-sm" disabled>
              </td>
              <td>
                <input type="text" name="electricity_monthly_cost_total" class="form-control form-control-sm" disabled>
              </td>
              <td>
                <input type="text" name="gas_monthly_cost_total" class="form-control form-control-sm" disabled>
              </td>
            </tr>


            <tr>
              <td>Monthly cost included</td>
              <td>
                <select name="internet_monthly_cost_included" class="form-control form-control-sm to-be-setup" required>
                  <option value="0">Non included</option>
                  <option value="1">Included</option>
                </select>
              </td>
              <td>
                <select name="council_monthly_cost_included" class="form-control form-control-sm to-be-setup" required>
                  <option value="0">Non included</option>
                  <option value="1">Included</option>
                </select>
              </td>
              <td>
                <select name="water_monthly_cost_included" class="form-control form-control-sm to-be-setup" required>
                  <option value="0">Non included</option>
                  <option value="1">Included</option>
                </select>
              </td>
              <td>
                <select name="electricity_monthly_cost_included" class="form-control form-control-sm to-be-setup" required>
                  <option value="0">Non included</option>
                  <option value="1">Included</option>
                </select>
              </td>
              <td>
                <select name="gas_monthly_cost_included" class="form-control form-control-sm to-be-setup" required>
                  <option value="0">Non included</option>
                  <option value="1">Included</option>
                </select>
              </td>


            </tr>

            <tr>
              <td>Correspondence Address</td>
              <td><input type="text" name="internet_address" class="form-control form-control-sm to-be-setup"></td>
              <td><input type="text" name="council_address" class="form-control form-control-sm to-be-setup"></td>
              <td><input type="text" name="water_address" class="form-control form-control-sm to-be-setup"></td>
              <td><input type="text" name="electricity_address" class="form-control form-control-sm to-be-setup"></td>
              <td><input type="text" name="gas_address" class="form-control form-control-sm to-be-setup"></td>
            </tr>

            <tr>
              <td>Direct Debit</td>
              <td><input type="text" name="internet_debit" class="form-control form-control-sm to-be-setup"></td>
              <td><input type="text" name="council_debit" class="form-control form-control-sm to-be-setup"></td>
              <td><input type="text" name="water_debit" class="form-control form-control-sm to-be-setup"></td>
              <td><input type="text" name="electricity_debit" class="form-control form-control-sm to-be-setup"></td>
              <td><input type="text" name="gas_debit" class="form-control form-control-sm to-be-setup"></td>
            </tr>

            <tr>
              <td>Tariff Name</td>
              <td>N/A</td>
              <td>N/A</td>
              <td>N/A</td>
              <td><input type="text" name="electricity_tariff" class="form-control form-control-sm to-be-setup"></td>
              <td>N/A</td>
            </tr>

            <tr>
              <td>Tariff Expiry Date</td>
              <td>N/A</td>
              <td>N/A</td>
              <td>N/A</td>
              <td><input type="text" name="electricity_tariff_expiry_date" class="form-control form-control-sm to-be-setup"></td>
              <td>N/A</td>
            </tr>

            <tr>
              <td>Unit Price</td>
              <td>N/A</td>
              <td>N/A</td>
              <td>N/A</td>
              <td><input type="text" name="electricity_unit_price" class="form-control form-control-sm to-be-setup"></td>
              <td>N/A</td>
            </tr>

            <tr>
              <td>Last Payment Date</td>
              <td>N/A</td>
              <td>N/A</td>
              <td>N/A</td>
              <td>N/A</td>
              <td>N/A</td>
            </tr>
          </tbody>
        </table>
      </div>
      <!--<div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary">Save changes</button>
    </div>-->
  </div>
</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
<script>
jQuery(document).ready(function() {

  $('.supplier_id_select').change(function(){
    console.log($(this).val());
    var bill_type = $(this).attr('bill_type');
    $('input.monthly_cost[bill_type="'+bill_type+'"]').attr('supplier_id',$(this).val());
  });

  $(".account-table").on('click', '.to-setup-model', function(event) {
    var button = $(this);
    var apartment_id = button.parents('tr').find('.apid').val();
    $('.apartment_id').val(apartment_id);

    $.ajax({
      url: baseUrl + "utility_bills/utilitybills/ajax_get_apartment_setup_info",
      data: {
        apartment_id : apartment_id
      },
      type: "POST",
      dataType: 'json',
      beforeSend: function() {
        console.log('please wait...');
      },
      success: function(result){
        console.log(result);
        if(result) {
          $.each(result, function(key, value){
            if(key != 'id' && key != 'apartment_id') {
              $("input[name='"+key+"'], select[name='"+key+"']").val(value);
            }
          });
          calculate_total_costs();
          assign_supplier_id_to_monthly_cost();
        } else {
          $(".popup-account-table input").val('');
        }
      }
    });
  });

  var apartments = <?php echo json_encode($apartments);?>


  function assign_supplier_id_to_monthly_cost(){
    $('.supplier_id_select').each(function(){
      var bill_type = $(this).attr('bill_type');
      $('input.monthly_cost[bill_type="'+bill_type+'"]').attr('supplier_id',$(this).val());
    });

  }

  function calculate_total_costs(){

    var apartment_id = $('.apartment_id').val();
    var now = moment();
    var contract_from = moment(apartments['ap_'+apartment_id]['contract_from']);
    var months = now.diff(contract_from, 'months')
    console.log(months)
    $('.monthly_cost').each(function(){
      var cost = $(this);
      $('input[name="'+$(this).attr('name')+'_total"]').val(months*cost.val());
    })
  }


  $(".popup-account-table").on('change', '.to-be-setup', function(event){

    calculate_total_costs();

    var text = $(this);
    console.log('change triggered');
    var type = text.attr('name');
    var apartment_id = $('.apartment_id').val();
    var value = text.val();

    $.ajax({
      url: baseUrl + "utility_bills/utilitybills/ajax_status_change_to_setup",
      data: {
        apartment_id : apartment_id,
        type : type,
        value : value,
        supplier_id: text.attr('supplier_id')
      },
      type: "POST",
      dataType: 'json',
      success: function(result){
        if(result == 1) {
          if($("input[name='internet_account_no']").val() != "" && $("input[name='internet_address']").val() != "" && $("input[name='internet_debit']").val() != "") {
            $('.row'+apartment_id).find(".internet").html('ok');
          }
          if($("input[name='council_account_no']").val() != "" && $("input[name='council_address']").val() != "" && $("input[name='council_debit']").val() != "") {
            $('.row'+apartment_id).find(".council").html('ok');
          }
          if($("input[name='water_account_no']").val() != "" && $("input[name='water_address']").val() != "" && $("input[name='water_debit']").val() != "") {
            $('.row'+apartment_id).find(".water").html('ok');
          }
          if($("input[name='electricity_account_no']").val() != "" && $("input[name='electricity_address']").val() != "" && $("input[name='electricity_debit']").val() != ""
          && $("input[name='electricity_tariff']").val() != "" && $("input[name='electricity_tariff_expiry_date']").val() != "" && $("input[name='electricity_unit_price']").val() != "") {
            $('.row'+apartment_id).find(".electricity").html('ok');
          }
          if($("input[name='gas_account_no']").val() != "" && $("input[name='gas_address']").val() != "" && $("input[name='gas_debit']").val() != "") {
            $('.row'+apartment_id).find(".gas").html('ok');
          }
        }
      }
    });
  });

  $(".popup-account-table").on('keyup', '.to-be-setup', function(event){
    console.log('keyup triggered');
    var text = $(this);


    var type = text.attr('name');
    var apartment_id = $('.apartment_id').val();
    var value = text.val();

    $.ajax({
      url: baseUrl + "utility_bills/utilitybills/ajax_status_change_to_setup",
      data: {
        apartment_id : apartment_id,
        type : type,
        value : value,
        supplier_id : text.attr('supplier_id')
      },
      type: "POST",
      dataType: 'json',
      success: function(result){
        if(result == 1) {
          if($("input[name='internet_account_no']").val() != "" && $("input[name='internet_address']").val() != "" && $("input[name='internet_debit']").val() != "") {
            $('.row'+apartment_id).find(".internet").html('ok');
          }
          if($("input[name='council_account_no']").val() != "" && $("input[name='council_address']").val() != "" && $("input[name='council_debit']").val() != "") {
            $('.row'+apartment_id).find(".council").html('ok');
          }
          if($("input[name='water_account_no']").val() != "" && $("input[name='water_address']").val() != "" && $("input[name='water_debit']").val() != "") {
            $('.row'+apartment_id).find(".water").html('ok');
          }
          if($("input[name='electricity_account_no']").val() != "" && $("input[name='electricity_address']").val() != "" && $("input[name='electricity_debit']").val() != ""
          && $("input[name='electricity_tariff']").val() != "" && $("input[name='electricity_tariff_expiry_date']").val() != "" && $("input[name='electricity_unit_price']").val() != "") {
            $('.row'+apartment_id).find(".electricity").html('ok');
          }
          if($("input[name='gas_account_no']").val() != "" && $("input[name='gas_address']").val() != "" && $("input[name='gas_debit']").val() != "") {
            $('.row'+apartment_id).find(".gas").html('ok');
          }
        }
      }
    });
  });

  $('#to-be-setupModel').on('hidden.bs.modal', function () {
    $('.apartment_id').val(0);
  })
});
</script>
