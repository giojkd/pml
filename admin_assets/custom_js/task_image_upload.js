
$(document).ready(function ()
{
    $('.open-ImageDialog').on("click", function () {
       var req_id = $(this).data('request-id');
        $("#request_add_image").uploadFile({
            url: baseUrl + "employer/feedback_image_upload/" + req_id,
            allowedTypes: "gif,jpg,png,jpeg",
            multiple: true,
            fileName: "myfile",
            autoSubmit: true,
            maxFileSize: 10 * 1024 * 1024,
            showStatusAfterSuccess: false,
            sequential: true,
            sequentialCount: 1,
            onSuccess: function (files, data, xhr) {
                //$("#complaint").val("1");
                //console.log(data);
                var info = JSON.parse(data);
                var orig_name = info.upload_data.orig_name;
                console.log(orig_name);

                $("#request_add_image_response").append("<div>" + info.upload_data.orig_name + "  " + "<span style='color:green'>Uploaded</span> </div>");
                var image = '<a href="' + baseUrl + "uploads/feedback_file/" + info.upload_data.file_name + '"></a>';
                $(".gallery").append(image);
                //$("#file_name_<?php echo $rand; ?>").val(info.upload_data.file_name);
            }
        });
    });


    $(document).on("click", ".delete_file_temp_file", function (e) {
        e.preventDefault();
        var parent_div = $(this).parent("div");
        var file_name = $(this).data('file_name');
        $.ajax({
            url: baseUrl + "employer/delete_temp_file",
            type: "post",
            data: {file_name: file_name},
            success: function (result) {
                parent_div.hide(500);
            }
        });
    });

    $(document).on("click", ".delete_main_file", function (e) {
        e.preventDefault();
        var parent_div = $(this).closest("div");
        var file_name = $(this).data('file_name');
        $.ajax({
            url: baseUrl + "task_manager/delete_task_main_file",
            type: "post",
            data: {file_name: file_name},
            success: function (result) {
                parent_div.hide(500);
            }
        });
    });

    $("#document_type").on("change",function(){
        var doc_type = $(this).val();
        $(".open-UploadDialog").on("click", function () {
        var booking_id = $(this).data('id');
        $("#booking_file_add").uploadFile({
            url: baseUrl + "apartment/booking_file_upload/" + booking_id,
            allowedTypes: doc_type,
            multiple: false,
            fileName: "myfile",
            autoSubmit: true,
//            maxFileSize: 10*1024*1024,
            showStatusAfterSuccess: true,
            sequential: true,
            sequentialCount: 1,
            onSuccess: function (files, data, xhr) {
                //$("#complaint").val("1");
                //console.log(data);
                $('#BookingFileModal').modal('hide');
//                var info = JSON.parse(data);
//                var orig_name = info.upload_data.orig_name;
//                console.log(orig_name);
//
//                $("#booking_file_add_response").append("<div>" + info.upload_data.orig_name + "<input type='hidden' name='file_name' value='" + info.upload_data.file_name + "' /><input type='hidden' name='orig_name' value='" + info.upload_data.orig_name + "' /> </div>");
                //$("#file_name_<?php echo $rand; ?>").val(info.upload_data.file_name);
            }
        });
    });
    })
    
    
    


});