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
                    <form class="item_add_form" id="calendar_view" action="" method="post">
                        <div class="form-body col-xs-12">
                            <div class="form-group">
                                <label class="control-label">Property</label>
                                <select name="apartment_id" id="apartment_id" class="form-control" required>
                                    <option value="">..Select..</option>
                                    <option value="0">All</option>
                                    <?php foreach($apartments as $value) {?>
                                    <option value="<?php echo $value["id"]; ?>"><?php echo $value["id"]." (".$value["address"].")"; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label">Room</label>
                                <select name="room_id" id="room_id" class="form-control" required>
                                    <option value="">..Select..</option>
                                    <?php foreach($cost_types as $key=>$type) {?>
                                    <option value="<?php echo $key; ?>"><?php echo $type; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label">Date (From)</label>
                                <input type="text" name="date_from" id="date_from" class="form-control"/>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label">Date (To)</label>
                                <input type="text" name="date_to" id="date_to" class="form-control"/>
                            </div>
                            </div> <!-- end of tenant area -->
                            
                            <div class="form-actions">
                                <button type="submit" class="btn blue"><i class="icon-ok"></i> View</button>
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
    $("#apartment_id").on("change", function () {
    var app_id = $(this).val();
    if(app_id == "0")
    {
        $('#room_id').html('<option value="0">All</option>');
    }
    else{
    $('#room_id').prepend($('<option></option>').html('Loading...'));
        $.ajax({
            url: "<?php echo base_url('apartment/calendar/get_room_dropdown'); ?>",
            type: "post",
            data: {apartment_id: app_id},
            success: function (result) {
                $("#room_id").html(result);
            }
        });
        }
    });
    
    $('#date_from').datetimepicker({
        datepicker: true,
        timepicker: false,
        format: 'd-m-Y',
        mask: false
    });

    $('#date_to').datetimepicker({
        datepicker: true,
        timepicker: false,
        format: 'd-m-Y',
        mask: false
    });
    
    $('#calendar_view').on('submit', function (e) {
        e.preventDefault();
        var startDate = document.getElementById("date_from").value;
        var endDate = document.getElementById("date_to").value;

        if ((Date.parse(startDate) >= Date.parse(endDate))) {
            alert("End date should be greater than Start date");
        }
        else
        {
        $.ajax({
            type: "post",
            url: "<?php echo base_url('apartment/calendar/get_search_result'); ?>",
            data: $('#calendar_view').serialize(),
            success: function (result) {
              
              $("#search_result").html(result);
              //$('#calendar_result').gotoAnchor();
              location.href = "#search_result";
            }
        });
        }
    });
    
    
    
});
    
</script>