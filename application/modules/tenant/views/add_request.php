
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
                    <!-- BEGIN FORM-->
                    <form class="tenant_add_request_form" action="<?php echo site_url() ?>tenant/add_requestsave" method="post" >
                        <div class="form-body col-xs-12">
                            <div class="form-group">
                                <label class="control-label">Request For</label>
                                <select name="request_for" id="request_for" class="form-control" required>
                                    <option value="1">Maintenance</option>
                                    <option value="2">Cleaning</option>
                                    <option value="3">Other</option>
                                </select>
                            </div>
                            <?php if($user_type == "backend_user" || $user_type == "admin") {?>
                                <div class="form-group">
                                    <label class="control-label">Select Occupant</label>
                                    <select name="tenant_id" id="tenant_id" class="form-control">
                                        <option value="">Select Occupant</option>
                                        <?php foreach ($tenants as $key => $value) { ?>
                                            <option value="<?php echo $value['id']; ?>"><?php echo $value['name'] . ' ' . $value['family_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('description') ?></label>
                                <textarea class="form-control" name="description"></textarea>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn blue"><i class="icon-ok"></i> <?php echo lang('btn_save') ?></button>
                                <a href="<?php echo base_url_tr() ?>tenant" class="btn btn-danger"><i class="icon-remove"></i> <?php echo lang('btn_cancel') ?></a>
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
        $('#tenant_id').select2();

        $('.tenant_add_request_form').validate({
        });
        $('.tenant_add_request_form').submit(function () {
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