<div class="container-fluid">
    <div class="clearfix"></div>
<!--    <br/>-->
<!--    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="<?php echo base_url_tr('settings'); ?>">Settings</a> 
            <i class="icon-angle-right"></i>
        </li>
    </ul>-->
    <div class="row">		
        <div class="box">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <h4><i class="icon-edit"></i><?php echo lang('site_setting')?></h4>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                        <a href="javascript:;" class="remove"></a>
                    </div>
                </div>
                <div class="portlet-body clearfix">
                    <?php
                    foreach ($settings->result() as $row) {
                        ${$row->set_name} = $row->set_value;
                    }
                    echo form_open("settings/update/site_settings", "enctype='multipart/form-data'");
                    ?>
                        <div class="clearfix">
                           
                            <div class="col-xs-12">
                                <div class="page-header">
                                    <h4><b><i class="icon-map-marker"></i> <?php echo lang('address_location');?></b></h4>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="company_name"><?php echo lang('company_name');?></label>
                                    <div class="controls">
                                        <input type="text" name="company_name" id="company_name" class="form-control" value="<?php echo @$company_name ?>" />  
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="contact_address"><?php echo lang('contact_address');?></label>
                                    <div class="controls">
                                        <input type="text" name="contact_address" id="contact_address" class="form-control" value="<?php echo @$contact_address ?>" />  
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="contact_address_2"><?php echo lang('contact_address_2');?></label>
                                    <div class="controls">
                                        <input type="text" name="contact_address_2" id="contact_address_2" class="form-control" value="<?php echo @$contact_address_2 ?>" />	
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="contact_phone_1"><?php echo lang('phone1');?></label>
                                    <div class="controls">
                                        <input type="text" name="contact_phone_1" id="contact_phone_1" class="form-control" value="<?php echo @$contact_phone_1 ?>" />	
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="contact_phone_2"><?php echo lang('phone2');?></label>
                                    <div class="controls">
                                        <input type="text" name="contact_phone_2" id="contact_phone_2" class="form-control" value="<?php echo @$contact_phone_2 ?>" />	
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="contact_email"><?php echo lang('contact_email');?></label>
                                    <div class="controls">
                                        <input type="text" name="contact_email" id="contact_email" class="form-control" value="<?php echo @$contact_email ?>" />    
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="tax_number"><?php echo lang('tax_number');?></label>
                                    <div class="controls">
                                        <input type="text" name="tax_number" id="tax_number" class="form-control" value="<?php echo @$tax_number ?>" />	
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="contact_page_text"><?php echo lang('contact_page');?></label>
                                    <div class="controls">
                                        <textarea name="contact_page_text" id="contact_page_text" class="form-control"><?php echo @$contact_page_text ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="contact_page_map"><?php echo lang('google_map_code');?></label>
                                    <div class="controls">
                                        <textarea name="contact_page_map" rows="4" id="contact_page_map" class="form-control"><?php echo @$contact_page_map ?></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-12">
                                <div class="page-header">
                                    <h4><b><i class="icon-link"></i> <?php echo lang('social_media');?></b></h4>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="rss_link"><?php echo lang('rss_link');?></label>
                                    <div class="controls">
                                        <input type="text" name="rss_link" id="rss_link" class="form-control" value="<?php echo @$rss_link ?>" />	
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="twitter_link"><?php echo lang('twitter_link');?></label>
                                    <div class="controls">
                                        <input type="text" name="twitter_link" id="twitter_link" class="form-control" value="<?php echo @$twitter_link ?>" />	
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="facebook_link"><?php echo lang('facebook_link');?></label>
                                    <div class="controls">
                                        <input type="text" name="facebook_link" id="facebook_link" class="form-control" value="<?php echo @$facebook_link ?>" />	
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="youtube_link"><?php echo lang('youtube_link');?></label>
                                    <div class="controls">
                                        <input type="text" name="youtube_link" id="youtube_link" class="form-control" value="<?php echo @$youtube_link ?>" />	
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="googleplus_link"><?php echo lang('google_plus');?></label>
                                    <div class="controls">
                                        <input type="text" name="googleplus_link" id="googleplus_link" class="form-control" value="<?php echo @$googleplus_link ?>" />	
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="linkedin_link"><?php echo lang('linkedin');?></label>
                                    <div class="controls">
                                        <input type="text" name="linkedin_link" id="linkedin_link" class="form-control" value="<?php echo @$linkedin_link ?>" />	
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="clearfix">
                            

                            <div class="col-xs-12">
                                <div class="page-header">
                                    <h4><b><i class="icon-info-sign"></i> <?php echo lang('custom_information');?></b></h4>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="slogan"><?php echo lang('site_slogan');?></label>
                                    <div class="controls">
                                        <input type="text" name="slogan" id="home_banner_url" class="form-control" value="<?php echo @$slogan ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="copywrite_text"><?php echo lang('copy_right');?></label>
                                    <div class="controls">
                                        <input type="text" name="copywrite_text" id="copywrite_text" class="form-control" value="<?php echo @$copywrite_text ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="developed_by_text"><?php echo lang('develop_by');?></label>
                                    <div class="controls">
                                        <input type="text" name="developed_by_text" id="developed_by_text" class="form-control" value="<?php echo @$developed_by_text ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="custom_js"><?php echo lang('custom_js');?></label>
                                    <div class="controls">
                                        <textarea name="custom_js" rows="6" id="custom_js" class="form-control"><?php echo @$custom_js ?></textarea>
                                    </div>
                                </div>

                                <div class="page-header">
                                    <h4><b><i class="icon-info-sign"></i> <?php echo lang('home_banner');?></b></h4>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="home_banner_url"><?php echo lang('url');?></label>
                                    <div class="controls">
                                        <input type="text" name="home_banner_url" id="home_banner_url" class="form-control" value="<?php echo @$home_banner_url ?>" />
                                    </div>
                                </div>
<!--                                <div class="form-group">
                                    <label class="control-label" for="MyFile">Images</label>
                                    <div class="controls">
                                        <input type="file" name="home_banner" id="MyFile" class="form-control-file"/>
                                        <img src="uploads/slideshow/" width="200">
                                    </div>
                                </div>-->
                                <input type="submit" value="save" class="btn btn-success"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!--/span-->

        </div><!--/row-->

    </div>
</div>