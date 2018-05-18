
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
            <div class="portlet-body portlet-chat-body">
                <div class="c-comment-list">
                    <!--Gallery Start -->
                    
                    <div class="text-center gallery-link">
                        <a type="button" class="btn btn-bg btn-primary" href="#"><i class="fa fa-picture-o" aria-hidden="true"></i> Open Gallery</a>
                    </div>
                    
                    <div class="gallery hidden">
                            <?php
                            foreach ($all_request_images as $key => $value) {
                                echo '<a href="' . base_url("uploads/feedback_file/" . $value['image_name']) . '"></a>';
                            }
                            ?>
                </div>
                    <!--Gallery End -->
                    
                        <?php
                    foreach ($all_messages as $key => $value) {
                        if ($value['user_id'] == $user_id) {
                            ?> 
                            <div class="media margin-top-bottom-30" data-last-id="<?php echo $value['id']; ?>">
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="javascript:void(0)"><?php echo $value['name'] . ' ' . $value['family_name']; ?></a>
                                        <span class="c-date"><?php echo $value['create_date']; ?></span>
                                    </h4>
                                    <?php echo $value['message']; ?>
                                </div>
                            </div>
                        <?php } else {
                            ?>
                            <div class="media margin-top-bottom-30" data-last-id="<?php echo $value['id']; ?>">
                                <div class="media-body text-right">
                                    <h4 class="media-heading ">
                                        <a href="javascript:void(0)"><?php echo $value['name'] . ' ' . $value['family_name']; ?></a>
                                        <span class="c-date"><?php echo $value['create_date']; ?></span>
                                    </h4>
                                    <?php echo $value['message']; ?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>

                </div>
                <div class="clearfix"></div>
            </div>
            <div class="message-send-area">
                <form class="message-send" action="<?php echo base_url_tr('employer/send_message'); ?>">
                    <div class="input-group">
                        <div class="input-icon">
                            <span class="input-group-addon"><i class="fa fa-keyboard-o"></i></span>
                            <input class="form-control" name="message" placeholder="Message" type="text"> 
                        </div>

                        <span class="input-group-btn">
                            <input type="hidden" name="request_id" value="<?php echo $request_id; ?>"/>
                            
                                <div class="controls">
                                    <div id="task_add_image" class="fileuploader">Upload</div>
                                    <div id="task_add_image_response"></div>
                                </div>
                            
                            <button class="btn btn-success" type="submit">
                                <i class="fa fa-arrow-left fa-send"></i> Send
                            </button>
                        </span>
                    </div>
                </form>
            </div>
        </div>

        <!---end form -->
    </div>
</div>
</div>
<!-- END PAGE CONTENT-->

<script>
    $(document).ready(function () {
        $('.message-send').submit(function () {
            if ($('input[name="message"]').val().trim()) {
                var $form = $(this);
                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serializeArray(),
                    success: function (response) {
                        var result = JSON.parse(response);
                        console.log(result);
                        if (result.status) {
                            for(var i = 0;i < result.images.length; i++)
                            {
                                var images = '<a href="' + baseUrl+'uploads/feedback_file/' + result.images[i] + '"></a>';
                                $('.gallery').append(images);
                            }
                            var html = '<div class="media margin-top-bottom-30" data-last-id="' + result.id + '">' +
                                    '<div class="media-body">' +
                                    '<h4 class="media-heading">' +
                                    '<a href="javascript:void(0)">' + result.name + ' ' + result.family_name + '</a> on ' +
                                    '<span class="c-date">' + result.create_date + '</span>' +
                                    '</h4>' +
                                    result.message
                            '</div>' +
                                    '</div>';
                            $('.c-comment-list').append(html);
                            $('input[name="message"]').val('');
                        }
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            }
            return false;
        });
        make_all_feedback_seen();
        window.setInterval(function () {
            $.ajax({
                url: '<?php echo base_url_tr('employer/refresh_feedback'); ?>',
                type: 'POST',
                data: {last_id: $('div[data-last-id]').last().data('last-id'), request_id: $('input[name="request_id"]').val()},
                success: function (response) {
                    var result = JSON.parse(response);
                    if (result.status) {
                        var total_message = result.messages.length;
                        var html = '';
                        var message_align = '';
                        for (var i = 0; i < total_message; i++) {
                            if (result.messages[i].user_id != result.userdata.user_id) {
                                message_align = 'text-right';
                            } else {
                                message_align = '';
                            }
                            html += '<div class="media margin-top-bottom-30 ' + message_align + '" data-last-id="' + result.messages[i].id + '">' +
                                    '<div class="media-body">' +
                                    '<h4 class="media-heading">' +
                                    '<a href="javascript:void(0)">' + result.messages[i].name + ' ' + result.messages[i].family_name + '</a> on ' +
                                    '<span class="c-date">' + result.messages[i].create_date + '</span>' +
                                    '</h4>' +
                                    result.messages[i].message
                            '</div>' +
                                    '</div>';
                        }
                        $('.c-comment-list').append(html);
                        make_all_feedback_seen();
                    }
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }, 5000);

        function make_all_feedback_seen() {
            $.ajax({
                url: '<?php echo base_url_tr('employer/make_all_feedback_seen'); ?>',
                type: 'POST',
                data: {request_id: $('input[name="request_id"]').val()},
                success: function (response) {

                },
                error: function (e) {
                    console.log(e);
                }
            });
        }

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