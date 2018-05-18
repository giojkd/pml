<?php error_reporting(0); ?>
<div class="container-fluid">
    <div class="clearfix"></div>
<!--    <br/>-->
<!--    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="<?php //echo base_url_tr('settings'); ?>">Settings</a> 
            <i class="icon-angle-right"></i>
        </li>
    </ul>-->
    <div class="row">		
        <div class="box">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <h4><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo lang('email_setting')?></h4>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                        <a href="javascript:;" class="remove"></a>
                    </div>
                </div>
                <div class="portlet-body clearfix">
                    <div class="clearfix">
                   <div class="col-xs-12">
                    <?php
                    foreach ($settings->result() as $row) {
                        ${$row->set_name} = $row->set_value;
                    }
                    echo form_open("settings/update/email_settings");
                    ?>

                    <!--                            <div class="form-group">
                                                                              <label class="control-label"  for="ini_language">System Language</label>
                                                                              <div class="controls">
                                                    <select name="ini_language">
                                                            <option value="english" <?php if ($ini_language == "english") { ?>selected="selected"<?php } ?>>English</option>
                                                        <option value="swedish" <?php if ($ini_language == "swedish") { ?>selected="selected"<?php } ?>>Swedish</option>
                                                    </select>
                                                                            </div>
                                                                    </div>  
                                                                
                                                                    <div class="form-group">
                                                                              <label class="control-label" for="ini_maintenance">Maintenance Mode</label>
                                                                              <div class="controls">
                                                    <select name="ini_maintenance">
                                                            <option value="1" <?php if ($ini_maintenance == "1") { ?>selected="selected"<?php } ?>>Yes, Activate</option>
                                                        <option value="0" <?php if ($ini_maintenance == "0") { ?>selected="selected"<?php } ?>>No</option>
                                                    </select>
                                                                            </div>
                                                                    </div>                      -->
                    <div class="form-group">
                        <label class="control-label" for="ini_mail_protocol"><?php echo lang('email_protocol');?></label>
                        <div class="controls">
                            <select class="form-control" name="ini_mail_protocol">
                                <option value="mail" <?php if ($ini_mail_protocol == "mail") { ?>selected="selected"<?php } ?>>Mail</option>
                                <option value="smtp" <?php if ($ini_mail_protocol == "smtp") { ?>selected="selected"<?php } ?>>SMTP</option>
                            </select>
                        </div>
                    </div>    
                    
                    <!--
                    <div class="form-group">
                        <label class="control-label" for="ini_notification"><?php //echo lang('notification_email');?></label>
                        <div class="controls">
                            <div class="success-toggle-button">
                                <input data-no-uniform="true" type="checkbox" class="make-switch" checked="checked" name="ini_notification" id="ini_notification" value="1" <?php //if ($ini_notification) echo "checked"; ?>/>   
                            </div>
                        </div>   
                    </div>
                    


                    <div class="form-group">
                        <label class="control-label" for="ini_email_noti"><?php echo lang('notification_email_all');?></label>
                        <div class="controls">
                            <input type="text" name="ini_email_noti" id="ini_email_noti" class="form-control" value="<?= $ini_email_noti ?>" /> 
                        </div>
                    </div>    
                    -->
                    
                    <div class="form-group">
                        <label class="control-label" for="ini_site_name"><?php echo lang('website_name');?></label>
                        <div class="controls">
                            <input type="text" name="ini_site_name" id="ini_site_name" class="form-control" value="<?= $ini_site_name ?>" />    
                        </div>
                    </div>                                                           
                    <div class="form-group">
                        <label class="control-label" for="ini_email_from"><?php echo lang('email_address');?></label>
                        <div class="controls">
                            <input type="text" name="ini_email_from" id="ini_email_from" class="form-control" value="<?= $ini_email_from ?>" /> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="ini_smtp_port"><?php echo lang('smtp_port');?></label>
                        <div class="controls">
                            <input type="text" name="ini_smtp_port" id="ini_smtp_port" class="form-control" value="<?= $ini_smtp_port ?>" />    
                        </div>
                    </div>                                              
                    <div class="form-group">
                        <label class="control-label" for="ini_smtp_host"><?php echo lang('smtp_host');?></label>
                        <div class="controls">
                            <input type="text" name="ini_smtp_host" id="ini_smtp_host" class="form-control" value="<?= $ini_smtp_host ?>" />    
                        </div>
                    </div>  
                    <div class="form-group">
                        <label class="control-label" for="ini_smtp_user"><?php echo lang('smtp_user');?></label>
                        <div class="controls">
                            <input type="text" name="ini_smtp_user" id="ini_smtp_user" class="form-control" value="<?= $ini_smtp_user ?>" />
                        </div>
                    </div>  
                    <div class="form-group">
                        <label class="control-label" for="ini_smtp_pass"><?php echo lang('smtp_password');?></label>
                        <div class="controls">
                            <input type="text" name="ini_smtp_pass" id="ini_smtp_pass" class="form-control" value="<?= $ini_smtp_pass ?>" />
                        </div>
                    </div>      

                    <!--                        <div class="form-group">
                                                                            <label class="control-label" for="richeditor">Languages ({short_name:language pair} with comma delimited (json format))</label>
                                                                            <div class="controls">
                                                                                    <textarea name="ini_language" id="ini_language" rows="5" class="form-control"><?= $ini_language ?></textarea>
                                                                            </div>
                                                                    </div>
                    
                                                                    <div class="form-group">
                                                                            <label class="control-label" for="richeditor">Additional javascript (eg. google analytics)</label>
                                                                            <div class="controls">
                                                                                    <textarea name="ini_script" id="ini_script" rows="5" class="form-control"><?= $ini_script ?></textarea>
                                                                            </div>
                                                                    </div>  -->

                    <input type="submit" value="save" class="btn btn-primary"/>
                    </form>

                        </div>
                    </div>

                   </div> 
                
                </div>
            </div><!--/span-->

        </div><!--/row-->

    </div>
</div>