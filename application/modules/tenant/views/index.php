<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title"><?php echo $title; ?></h2>
    </div>

    <div class="panel-body">
        <div class="btn-group margin-bottom-10">
            <a href="<?php echo base_url_tr() ?>tenant/add_request" class="btn green"><i class="icon-plus"></i> <?php echo lang('label_add_new') ?></a>
        </div>
        <?php echo $this->session->flashdata('save_success') ? $this->session->flashdata('save_success') : ''; ?>
        <table class="table table-striped table-bordered table-hover display responsive nowrap" id="tenant_datatable" width="100%">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center"><?php echo lang('create_date'); ?></th>
                    <?php if ($user['user_type'] != 'tenant') { ?>
                        <th class="text-center">Occupant</th>
                    <?php } ?>
                    <th class="text-center"><?php echo lang('description'); ?></th>
                    <?php if ($user['user_type'] == 'backend_user') { ?>
                        <th class="text-center">Apartment</th>
                        <th class="text-center">Assigned To</th>
                        <th class="text-center">Cost</th>
                        <th class="text-center">Charge Amount</th>
                    <?php } ?>
                    <th class="text-center"><?php echo lang('label_status'); ?></th>
                    <th class="text-center"><?php echo lang('action'); ?></th>
                </tr>
            </thead>

            <tbody>
                <?php
                if ($requests) {
                    foreach ($requests as $key => $value) {
                        ?>
                    <tr class="odd gradeX" data-request-id="<?php echo $value['id']; ?>">
                        <td><?php echo $value['id']; ?></td>
                        <td>
                            <?php echo date('d-m-Y H:i:s',  strtotime($value['create_date'])); ?>
                        </td>
                        <?php if ($user['user_type'] != 'tenant') { ?>
                            <td><?php echo $value['name'] . ' ' . $value['family_name']; ?></td>
                        <?php } ?>
                        <td>
                            <?php echo $value['description'] ?>
                        </td>
                        <?php if ($user['user_type'] == 'backend_user') { ?>
                        <td>
                            <?php echo $value['apartment_id'].'-'.$value['apartment_address'].' ( Floor : '.$value['apartment_floor'].' ) '.$value['apartment_zip_code']; ?>
                        </td>
                            <td class="assigned-to-col">
                                <?php
                                if (!empty($employer_external_maintainer[$value['assigned_to']])) {
                                    echo $employer_external_maintainer[$value['assigned_to']]['name'] . ' ' . $employer_external_maintainer[$value['assigned_to']]['family_name'];
                                } else {
                                    echo 'Not Assigned';
                                }
                                ?>
                            </td>
                            <td class="cost-col">
                                £ <?php echo $value['cost']; ?>
                            </td>
                            <td class="charge-amount-col">
                                £ <?php echo $value['charge_amount']; ?>
                            </td>
                            <td>
                                <a href="<?php echo base_url_tr('tenant/change_request_status/' . $value['id']); ?>" class="btn btn-sm btn-<?php echo $value['status'] == 1 ? 'danger' : 'success' ?>"><?php echo $value['status'] == 1 ? 'Closed' : 'Open' ?></a>
                            </td>
                        <?php } else { ?>
                            <td>
                                <?php if ($value['status'] == 1) { ?>
                                    <span class="label label-danger">Closed</span>
                                <?php } else { ?>
                                    <span class="label label-success">Open</span>
                                <?php } ?>
                            </td>
                        <?php } ?>
                        <td>
                            <a data-request-id="<?php echo $value['id']; ?>" href="<?php echo base_url_tr('tenant/request_feedback/' . $value['id']); ?>" class="btn btn-primary btn-sm badge_btn"><i class="fa fa-comments"></i> <span class="badge_area"></span></a>
                            <?php if (!$value['assigned_to']) { ?>
                                <a href="<?php echo base_url_tr('tenant/edit_request/' . $value['id']); ?>" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-pencil"></i></a>
                            <?php } ?>
                            <?php if ($user['user_type'] == 'backend_user') { ?>
                                <a data-request-id="<?php echo $value['id']; ?>" href="javascript:void(0);" class="update-button btn btn-info btn-sm">Update</a>
                            <?php } ?>

                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<?php if ($user['user_type'] == 'backend_user') { ?>
    <div id="update-request-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Request Info</h4>
                </div>
                <div class="modal-body">
                    <form id="update-request-form" action="<?php echo base_url_tr('tenant/update_request'); ?>">
                        <div class="validation_errros"></div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="checkbox" name="to_external" value="1" class="to_external">Assign to External Maintainer ?</label>
                            </div>
                        </div>
                        <div class="form-group employer_prop">
                            <label class="control-label">Select Employer</label>
                            <select name="employer" class="form-control select2-init">
                                <option value="">Select Employer</option>
                                <?php
                                foreach ($employer_external_maintainer as $key => $value) {
                                    if (user_type_text($value['type']) == 'employer') {
                                        ?>
                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['name'] . ' ' . $value['family_name']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group external_maintainer_prop" style="display: none; ">
                            <label class="control-label">Select External Maintainer</label>
                            <select name="external_maintainer" class="form-control select2-init">
                                <option value="">Select External Maintainer</option>
                                <?php
                                foreach ($employer_external_maintainer as $key => $value) {
                                    if (user_type_text($value['type']) == 'external_maintainer') {
                                        ?>
                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['name'] . ' ' . $value['family_name']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Cost</label>
                            <input class="form-control" name="cost" type="number"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Charge Amount</label>
                            <input class="form-control" name="charge_amount" type="number"/>
                        </div>
                        <div class="form-actions text-center">
                            <input type="hidden" name="request_id" value=""/>
                            <button type="submit" class="btn blue"><i class="icon-ok"></i> <?php echo lang('btn_save') ?></button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
<?php } ?>

<script type="text/javascript">

    $(document).ready(function () {

        $('.select2-init').select2();

        $('#tenant_datatable').dataTable({
            responsive: true,
        });

        refresh_feedback_request_list();
        window.setInterval(function () {
            refresh_feedback_request_list();
        }, 5000);
        refresh_feedback_request_list();
        function refresh_feedback_request_list() {
            $.ajax({
                url: '<?php echo base_url_tr('tenant/refresh_feedback_request_list'); ?>',
                type: 'POST',
                data: {request_ids: '<?php echo json_encode($request_ids) ?>'},
                success: function (response) {
                    var result = JSON.parse(response);
                    var total_message = result.length;
                    if (result) {
                        for (var i = 0; i < total_message; i++) {
                            console.log(result[i]);
                            $('a[data-request-id="' + result[i].request_id + '"] .badge_area').addClass('badge').html('New');
                        }
                    }
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }


        $('#update-request-form').submit(function () {
            var $form = $(this);
            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serializeArray(),
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.status) {
                        $('tr[data-request-id="' + response.request_id + '"] td.assigned-to-col').html(response.assigned_to);
                        $('tr[data-request-id="' + response.request_id + '"] td.cost-col').html('£ ' + parseFloat(response.cost).toFixed(2));
                        $('tr[data-request-id="' + response.request_id + '"] td.charge-amount-col').html('£ ' + parseFloat(response.charge_amount).toFixed(2));
                        $('#update-request-modal').modal('hide');
                    } else {
                        $('.validation_errros').html(response.message);
                    }
                },
                error: function () {

                }
            });
            return false;
        });

        $('.to_external').change(function () {
            if ($(this).is(':checked')) {
                $('.external_maintainer_prop').show();
                $('.employer_prop').hide();
            } else {
                $('.employer_prop').show();
                $('.external_maintainer_prop').hide();
            }
        });

        $('.update-button').click(function () {
            var request_id = $(this).data('request-id');
            $('#update-request-modal input[name="request_id"]').val(request_id);
            $('#update-request-modal').modal('toggle');
        });

        $('#update-request-modal').on('show.bs.modal', function (e) {
            $(this).find('input[type="number"]').val('');
            $(this).find('input[type="checkbox"]').prop('checked', false).parents('span.checked').removeClass('checked');
            $(this).find('.employer_prop').show();
            $(this).find('.external_maintainer_prop').hide();
            $(this).find('select').val('').change();
        })
    });
</script>