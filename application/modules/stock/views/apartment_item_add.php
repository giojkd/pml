
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
                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger" style="color: #b42020">
                            <button class="close" data-dismiss="alert" type="button">x</button>
                            <?php echo validation_errors(); ?>
                        </div>
                    <?php endif; ?>
                    <!-- BEGIN FORM-->
                    <form class="item_add_form" action="<?php echo site_url() ?>stock/apartment_item_add_save" method="post">
                        <div class="form-body col-xs-12">
                            <div class="form-group">
                                <label class="control-label">Apartment ID</label>
                                <select name="apartment_id" id="apartment_id" class="form-control" required>
                                    <option value="">..Select..</option>
                                    <?php foreach ($apartments as $value) { ?>
                                        <option value="<?php echo $value["id"]; ?>"><?php echo $value["id"] . " (" . $value["address"] . ")"; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <table class="table table-striped table-bordered table-hover apartment-stock-repeater">
                                <thead>
                                    <tr>
                                        <th>Room</th>
                                        <th>Add Item</th>
                                        <th>Quantity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <select name="room_id[]" class="room_id form-control" required>
                                                    <option value="0">Common Area</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="item_name[]" value="" class="form-control" required/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="item_quantity[]" value="" class="form-control" required/>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="btn btn-danger row-delete"><i class="fa fa-minus"></i></a>
                                            <a href="javascript:void(0)" class="btn btn-success row-add"><i class="fa fa-plus"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>


                            <div class="form-actions">
                                <button type="submit" class="btn blue"><i class="icon-ok"></i> <?php echo lang('btn_save'); ?></button>
                                <a href="<?php echo base_url_tr() ?>stock/apartment_item_list" class="btn btn-danger"><i class="icon-remove"></i> <?php echo lang('btn_cancel'); ?></a>
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
        $('#apartment_id').select2();

        $('.apartment-stock-repeater').on('click', '.row-add', function () {
            var row = $(this).parents('table').find('tbody tr:first').clone();

            $(row).find('input').each(function () {
                $(this).val('');
            });
            $(row).find('select').each(function () {
                $(this).val('0');
            });

            $(this).parents('table').find('tbody').append(row);
        });

        $('.apartment-stock-repeater').on('click', '.row-delete', function () {
            if ($(this).parents('tbody').find('tr').length > 1) {
                $(this).parents('tr').remove();
            }
        });

        $("#apartment_id").on("change", function () {
            var apartment_id = $(this).val();
            //alert(apartment_id);exit;

            $.ajax({
                url: "<?php echo base_url_tr('stock/get_room_dropdown'); ?>",
                type: "post",
                data: {apartment_id: apartment_id},
                success: function (result) {
                    console.log(result);
                    $(".room_id").html(result);
                    // updateHTMLselect("#city_id");
                }
            })

        });
    });
</script>
