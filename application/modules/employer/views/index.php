<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title"><?php echo $title; ?></h2>
    </div>

    <div class="panel-body">
        <?php echo $this->session->flashdata('save_success') ? $this->session->flashdata('save_success') : ''; ?>
        <table class="table table-striped table-bordered table-hover display responsive nowrap" id="sample_1" width="100%">
            <thead>
                <tr>
                    <th style="width:8px;">#</th>
                    <th><?php echo lang('create_date'); ?></th>
                    <th>Occupant</th>
                    <th><?php echo lang('apartment'); ?></th>
                    <th><?php echo lang('description'); ?></th>
                    <th class="text-center"><?php echo lang('label_status'); ?></th>
                    <th><?php echo lang('action'); ?></th>
                </tr>
            </thead>

            <tbody>
                <?php
                if ($requests) {
                    foreach ($requests as $key => $value) {
                        ?>
                        <tr class="odd gradeX">
                            <td><?php echo $value['id']; ?></td>
                            <td>
                                <?php echo date('d-m-Y H:i:s', strtotime($value['create_date'])); ?>
                            </td>

                            <td><?php echo getUser($value['user_id'], 'name') . ' ' . getUser($value['user_id'], 'family_name'); ?></td>
                            <td>
                                <?php echo $value['apartment_id'] . "-" . get_single_table_data_by_id($value['apartment_id'], $field = "address", $table = "apartment_detail") . ' (' . ' Floor : ' . get_single_table_data_by_id($value['apartment_id'], $field = "floor", $table = "apartment_detail") . ')' ?>
                            </td>
                            <td>
                                <?php echo $value['description'] ?>
                            </td>
                            <td>
                                <a href="<?php echo base_url_tr('employer/change_request_status/' . $value['id']); ?>" class="btn btn-sm btn-<?php echo $value['status'] == 1 ? 'danger' : 'success' ?>"><?php echo $value['status'] == 1 ? 'Closed' : 'Open' ?></a>
                            </td>
                            <td>
                                <a data-request-id="<?php echo $value['id']; ?>" href="<?php echo base_url_tr('employer/request_feedback/' . $value['id']); ?>" class="btn btn-primary btn-sm"><i class="fa fa-comments"> <span class="badge_area"></span></i></a>
                                <a data-request-id="<?php echo $value['id']; ?>" href="#UploadModal" data-toggle="modal" class="btn btn-primary btn-sm open-ImageDialog"><i class="fa fa-upload"></i> Upload</a>
                                    <a type="button" data-request-id="<?php echo $value['id']; ?>" class="btn btn-sm btn-primary gallery-link" href="#"><i class="fa fa-picture-o"></i> Open Gallery</a>
                                <div class="gallery hidden">
                                    <?php
                                    foreach ($value['image'] as $key => $img) {
                                        echo '<a href="' . base_url("uploads/feedback_file/" . $img['image_name']) . '"></a>';
                                    }
                                    ?>
                                </div>

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

<div id="UploadModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>            
            <div class="modal-body">

                <div class="controls">
                    <div id="request_add_image" class="fileuploader">Upload</div>
                    <div id="request_add_image_response"></div>
                </div>

                <input type="hidden" name="request_id" id="request_id" value=""/>

            </div>
            <div class="modal-footer">                   
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
//        $(document).ready(function(){
//            $('#sample_1').dataTable({
//                responsive: true,
//            });
//        })
    $(document).ready(function () {
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

        $(document).on("click", ".open-ImageDialog", function () {
            var id = $(this).data('request-id');
            $(".modal-body #request_id").val(id);
            // As pointed out in comments, 
            // it is superfluous to have to manually call the modal.
            // $('#addBookDialog').modal('show');
        });

        // Bind Click Handler to Link, then Open Gallery
        $('.gallery-link').on('click', function () {
            $(this).next().magnificPopup('open');
        });

// Initialize Magnific Popup Gallery + Options
        $('.gallery').each(function () {
            $(this).magnificPopup({
                delegate: 'a',
                gallery: {
                    enabled: true
                },
                type: 'image'
            });
        });

    });
</script>