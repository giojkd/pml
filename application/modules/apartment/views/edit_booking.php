
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

                    </div>
                    <?php //echo '<pre>'; print_r($booked_tenants); echo '</pre>';?>
                    <!-- BEGIN FORM -->
                    <form class="apartment_add_form" id="booking_edit_form1" action="<?php echo site_url() ?>apartment/save_edit_booking" method="post" >
                        <div class="form-body col-xs-12">
                            <div class="form-group">
                                <label class="control-label"><?php echo 'Select Property'; ?></label>
                                <div class="controls">
                                    <div class="chosen-container">
                                        <input type="hidden" name="id" value="<?php echo $booking_detail[0]['id']; ?>">

                                        <select name="apartment_id" class="form-control" data-placeholder="Choose an Owner" tabindex="1" required="" id="apartment">
                                            <option value="">Select Property</option>
                                            <?php
                                            foreach ($apartments as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value['id']; ?>"
                                                    <?php if($value['id'] == $booking_detail[0]['apartment_id']) echo 'selected'; ?>>

                                                    <?php echo $value['id']." - ".$value['address']; ?>

                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <input type="hidden" name="old_apartment_id" value="<?php echo $booking_detail[0]['apartment_id']; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?php echo 'Select Room'; ?></label>
                                <div class="controls">
                                    <div class="chosen-container">

                                        <select name="room_id" class="form-control" data-placeholder="Select Room" tabindex="1" required="" id="room">
                                            <?php echo $room_drop_down; ?>

                                        </select>
                                        <input type="hidden" name="old_room_id" value="<?php echo $booking_detail[0]['room_id']; ?>">
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="control-label"><?php echo 'Select Occupants'; ?></label>
                                <div class="controls">
                                    <div class="chosen-container">

                                        <select name="user_id[]" class="form-control" data-placeholder="Choose an Occupants" tabindex="1" required="" id="tenant_user_id" multiple>
                                            <option value="">Select Occupants</option>
                                            <?php
                                            foreach ($tenants as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value['id']; ?>"
                                                    <?php echo in_array($value['id'], $booked_tenants) ? 'selected':""; ?>
                                                    >
                                                    <?php echo $value['name']." ".$value['family_name']; ?>

                                                    </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?php echo 'From'; ?></label>
                                <input type="hidden" name="cur_rent_from" value="<?php echo $booking_detail[0]['rent_from']; ?>">
                                <input type="text" readonly="" name="rent_from" required placeholder="<?php echo 'From'; ?>" class="form-control" id="rent_from" value="<?php echo mydate($booking_detail[0]['rent_from'],"-"); ?>"/>
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?php echo 'To'; ?></label>
                                <input type="hidden" name="cur_rent_to" value="<?php echo $booking_detail[0]['rent_to']; ?>">
                                <input type="text" readonly="" name="rent_to" required placeholder="<?php echo 'To'; ?>" class="form-control" id="rent_to" value="<?php echo mydate($booking_detail[0]['rent_to'],"-"); ?>"/>
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?php echo 'Date for monthly payment'; ?></label>

                                <select class="form-control" id="payment_date1" name="payment_date" required>
                                    <option value="">Select Date</option>
                                    <option value="1"
                                    <?php echo $booking_detail[0]['payment_date'] == 1 ? 'selected': "" ?>>
                                    1</option>
                                    <option value="2"  <?php echo $booking_detail[0]['payment_date'] == 2 ? 'selected': "" ?>>
                                    2</option>
                                    <option value="3" <?php echo $booking_detail[0]['payment_date'] == 3 ? 'selected': "" ?>>
                                    3</option>
                                    <option value="4" <?php echo $booking_detail[0]['payment_date'] == 4 ? 'selected': "" ?>>
                                    4</option>
                                    <option value="5" <?php echo $booking_detail[0]['payment_date'] == 5 ? 'selected': "" ?>>
                                    5</option>
                                    <option value="6" <?php echo $booking_detail[0]['payment_date'] == 6 ? 'selected': "" ?>>
                                    6</option>
                                    <option value="7" <?php echo $booking_detail[0]['payment_date'] == 7 ? 'selected': "" ?>>
                                    7</option>
                                    <option value="8" <?php echo $booking_detail[0]['payment_date'] == 8 ? 'selected': "" ?>>
                                    8</option>
                                    <option value="9" <?php echo $booking_detail[0]['payment_date'] == 9 ? 'selected': "" ?>>
                                    9</option>
                                    <option value="10" <?php echo $booking_detail[0]['payment_date'] == 10 ? 'selected': "" ?>>
                                    10</option>
                                    <option value="11" <?php echo $booking_detail[0]['payment_date'] == 11 ? 'selected': "" ?>>
                                    11</option>
                                    <option value="12" <?php echo $booking_detail[0]['payment_date'] == 12 ? 'selected': "" ?>>
                                    12</option>
                                    <option value="13" <?php echo $booking_detail[0]['payment_date'] == 13 ? 'selected': "" ?>>
                                    13</option>
                                    <option value="14" <?php echo $booking_detail[0]['payment_date'] == 14 ? 'selected': "" ?>>
                                    14</option>
                                    <option value="15" <?php echo $booking_detail[0]['payment_date'] == 15 ? 'selected': "" ?>>
                                    15</option>
                                    <option value="16" <?php echo $booking_detail[0]['payment_date'] == 16 ? 'selected': "" ?>>
                                    16</option>
                                    <option value="17" <?php echo $booking_detail[0]['payment_date'] == 17 ? 'selected': "" ?>>
                                    17</option>
                                    <option value="18" <?php echo $booking_detail[0]['payment_date'] == 18 ? 'selected': "" ?>>
                                    18</option>
                                    <option value="19" <?php echo $booking_detail[0]['payment_date'] == 19 ? 'selected': "" ?>>
                                    19</option>
                                    <option value="20" <?php echo $booking_detail[0]['payment_date'] == 20 ? 'selected': "" ?>>
                                    20</option>
                                    <option value="21" <?php echo $booking_detail[0]['payment_date'] == 21 ? 'selected': "" ?>>
                                    21</option>
                                    <option value="22" <?php echo $booking_detail[0]['payment_date'] == 22 ? 'selected': "" ?>>
                                    22</option>
                                    <option value="23" <?php echo $booking_detail[0]['payment_date'] == 23 ? 'selected': "" ?>>
                                    23</option>
                                    <option value="24" <?php echo $booking_detail[0]['payment_date'] == 24 ? 'selected': "" ?>>
                                    24</option>
                                    <option value="25" <?php echo $booking_detail[0]['payment_date'] == 25 ? 'selected': "" ?>>
                                    25</option>
                                    <option value="26" <?php echo $booking_detail[0]['payment_date'] == 26 ? 'selected': "" ?>>
                                    26</option>
                                    <option value="27" <?php echo $booking_detail[0]['payment_date'] == 27 ? 'selected': "" ?>>
                                    27</option>
                                    <option value="28" <?php echo $booking_detail[0]['payment_date'] == 28 ? 'selected': "" ?>>
                                    28</option>
                                    <option value="29" <?php echo $booking_detail[0]['payment_date'] == 29 ? 'selected': "" ?>>
                                    29</option>
                                    <option value="30" <?php echo $booking_detail[0]['payment_date'] == 30 ? 'selected': "" ?>>
                                    30</option>
                                    <option value="31" <?php echo $booking_detail[0]['payment_date'] == 31 ? 'selected': "" ?>>
                                    31</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?php echo 'Licence Fee'; ?></label>
                                <input type="number" name="monthly_fee" required placeholder="<?php echo ''; ?>" class="form-control" value="<?php echo number_format($booking_detail[0]['monthly_fee'], 2, '.', ''); ?>"/>
                            </div>


                            <div class="form-group">
                                <label class="control-label"><?php echo 'Deposit'; ?></label>
                                <input type="number" name="deposit_fee" required placeholder="<?php echo ''; ?>" class="form-control" value="<?php echo number_format($booking_detail[0]['deposit_fee'], 2, '.', ''); ?>"/>
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?php echo 'Total Agency Fee (£)'; ?></label>
                                <input type="number" name="booking_fee" required placeholder="<?php echo ''; ?>" class="form-control" value="<?php echo number_format($booking_detail[0]['booking_fee'], 2, '.', ''); ?>"/>
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?php echo 'Initial Admin Fee'; ?></label>
                                <input type="number" name="admin_fee" required placeholder="<?php echo ''; ?>" class="form-control" value="<?php echo number_format($booking_detail[0]['admin_fee'], 2, '.', ''); ?>"/>
                            </div>

                            <input type="hidden" name="check_internal_external" value="<?php echo $booking_detail[0]['internal_external'];?>" id="check_internal_external">

                            <div class="form-group">
                                <label class="control-label">
                                    <input type="radio" name="internal_external" value="internal" <?php echo $booking_detail[0]['internal_external']=="internal"?"checked":""?>> Internal
                                </label>

                                <label class="control-label">
                                    <input type="radio" name="internal_external" value="external" <?php echo $booking_detail[0]['internal_external']=="external"?"checked":""?>> External
                                </label>
                            </div>

                            <div class="form-group internal_div">
                                <label class="control-label">Agents</label>
                                <select class="form-control" id="agent_id" name="agent_id">
                                    <option value="">Select Agent</option>
                                    <?php
                                    foreach ($agents as $key => $value) {?>
                                        <option value="<?php echo $value['id']; ?>" <?php echo $booking_detail[0]['agent_id']==$value['id']?"selected":""?>><?php echo $value['name'] . " " . $value['family_name']; ?></option>
                                    <?php }?>
                                </select>
                            </div>

                            <div class="form-group external_div">
                                <label class="control-label"><?php echo 'External'; ?></label>
                                <input type="text" name="external" placeholder="<?php echo ''; ?>" class="form-control" value="<?php echo $booking_detail[0]['external'];?>" />
                            </div>

                            <div class="form-group external_div">
                                <label class="control-label">Sorces</label>
                                <select class="form-control" id="source_id" name="source_id">
                                    <option value="">Select Source</option>
                                    <?php
                                    foreach ($sorces as $key => $value) {?>
                                        <option value="<?php echo $value['id']; ?>" <?php echo $booking_detail[0]['source_id']==$value['id']?"selected":""?>><?php echo $value['source_name']; ?></option>
                                    <?php }?>
                                </select>
                            </div>


                            <div class="form-actions text-center">
                                <button type="submit" class="btn blue"><i class="icon-ok"></i> <?php echo lang('btn_save') ?></button>
                                <a href="<?php echo base_url_tr() ?>apartment/booking_list" class="btn btn-danger"><i class="icon-remove"></i> <?php echo lang('btn_cancel') ?></a>
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


<script>
    $(document).ready(function () {
        if($('#check_internal_external').val() == "")
        {
            $(".internal_div").hide();
            $(".external_div").hide();
        }
        else if($('#check_internal_external').val() == "internal")
        {
            $(".internal_div").show();
            $(".external_div").hide();
        }
        else if($('#check_internal_external').val() == "external")
        {
            $(".internal_div").hide();
            $(".external_div").show();
        }

        $('input[type=radio][name=internal_external]').change(function() {
            if (this.value == 'internal') {
                //alert("realtedai");
                $(".internal_div").show();
                $(".external_div").hide();
            }
            else if (this.value == 'external') {
                //alert("general");
                $(".internal_div").hide();
                $(".external_div").show();
            }
        });

        $('#booking_edit_form1').submit(function () {
            var $form = $(this);
            if ($form.valid()) {
                console.log('submitted');
                var formData = $form.serializeArray();
                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        //console.log(response);exit;
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

        $("#apartment").on("change", function () {
            var apartment_id = $(this).val();
            //alert(apartment_id);exit;
            if (apartment_id) {
                $.ajax({
                    url: "<?php echo base_url_tr('apartment/get_room_dropdown'); ?>",
                    type: "post",
                    data: {apartment_id: apartment_id},
                    success: function (result) {
                        console.log(result);
                        $("#room").html(result);
                        // updateHTMLselect("#city_id");
                    }
                })
            }
        });

        $("#rent_from").datetimepicker({
            datepicker: true,
            timepicker: false,
            format: 'd-m-Y',
            minDate:0,
            mask:true,
            scrollMonth : false,
            scrollInput : false
        });

        $("#rent_to").datetimepicker({
            datepicker: true,
            timepicker: false,
            format: 'd-m-Y',
            minDate:0,
            mask:true,
            scrollMonth : false,
            scrollInput : false
        });

        $('.scroll-false').scroll(function(event) {
            return false;
        });

        $("#payment_date1").select2();

        $('#apartment').select2();
        $('#room').select2();
        $('#tenant_user_id').select2();
        $('#agent_id').select2();
        $('#source_id').select2();

    });
</script>
