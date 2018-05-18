
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
                    <form class="item_add_form" action="<?php echo site_url() ?>stock/item_add_save" method="post" >
                        <div class="form-body col-xs-12">
                            <div class="form-group">
                                <label class="control-label">Name</label>
                                <input type="text" name="item_name" required class="form-control" />
                            </div>
<!--                            <div class="form-group">
                                <label class="control-label">Current Quantity</label>
                                <input type="text" name="quantity" value="" class="form-control " />
                            </div>-->
                            <div class="form-actions">
                                <button type="submit" class="btn blue"><i class="icon-ok"></i> <?php echo lang('btn_save') ?></button>
                                <a href="<?php echo base_url_tr() ?>stock/item_list" class="btn btn-danger"><i class="icon-remove"></i> <?php echo lang('btn_cancel') ?></a>
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
        $('select[name="type"]').change(function () {
            $('.user_type_prop').hide('500');
            var user_type = $(this).val();
            if (user_type) {
                $('.user_type_' + user_type + '_prop').show(500);
            }
        });
        $('.birthday').datetimepicker({
            datepicker: true,
            timepicker: false,
            format: 'Y-m-d',
            mask: false
        });
        $('.user_add_form').validate({
            rules: {
                password_confirm: {
                    equalTo: "#password"
                }
            }
        });
        $('.user_add_form').submit(function () {
            var $form = $(this);
            if ($form.valid()) {
                console.log('submitted');
                var formData = $form.serializeArray();
                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: formData,
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