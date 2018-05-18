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
                    <form class="item_add_form" id="calendar_view" action="<?php echo base_url(); ?>bank/file_info" method="post">
                        <div class="form-body col-xs-12">
                            
                            <div class="form-group">
                                <label class="control-label">File Upload</label>
                                <div id="bank_file" class="fileuploader">Upload</div>

                                    <div class="clearfix"></div>

                                    <div id='bank_file_response'>

                                    </div>
                            </div>
                            
                         </div> 
                            
                            
                            <div class="form-actions">
                                <button type="submit" class="btn blue"><i class="icon-ok"></i> Save</button>
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
     $("#bank_file").uploadFile({
            url: baseUrl + "bank/file_upload",
            allowedTypes: "csv",
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
                var file_name =  info.upload_data.file_name;
                console.log(info);

                $("#bank_file_response").append("<div>" + info.upload_data.orig_name + "</div>"+"<input type='hidden' name='file_name' value='"+file_name+"'/>");
            }
        });
    
});
    
</script>