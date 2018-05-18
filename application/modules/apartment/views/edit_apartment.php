
<!-- BEGIN PAGE CONTENT-->
<?php
#print_r($apartment_info);
?>
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
                    <?php //echo '<pre>'; print_r($apartment_info[0]); echo '</pre>'; ?>
                    <form class="apartment_add_form" id="apartment_edit_form1" action="<?php echo site_url() ?>apartment/apartment_edit_save" method="post" >
                        <div class="form-body col-xs-12">
                            <div class="form-group">
                                <label class="control-label"><?php echo 'Select Owner'; ?></label>
                                <div class="controls">
                                    <div class="chosen-container">
                                        <input type="hidden" name="id" value="<?php echo $apartment_info[0]['apartment_id']; ?>"/>
                                        <select name="owner" class="form-control" data-placeholder="Choose an Owner" tabindex="1" required="">
                                            <option value="">Owner List</option>
                                            <?php
                                            foreach ($users as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value['id']; ?>"
                                                    <?php if($apartment_info[0]['owner'] == $value['id']) echo 'selected'; ?>>
                                                    <?php echo $value['name']." ".$value['family_name']; ?>

                                                    </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?php echo 'Address'; ?></label>
                                <textarea name="address" id="address" class="form-control" required><?php echo $apartment_info[0]['address']; ?></textarea>
                            </div>
                           <div class="form-group" style="display:none;">
                                <div id="map" style="width:100%;height: 450px;"></div>
                            </div>
                            <div class="form-group hidden">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label class="control-label">Latitude</label>
                                        <input class="form-control" type="text" name="map_lat" id="map_lat" placeholder="Latitude" value="<?php echo $apartment_info[0]['latitude'];?>">
                                    </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-5">
                                        <label class="control-label">Longitude</label>
                                        <input class="form-control" type="text" name="map_lang" id="map_lang" placeholder="Longitude" value="<?php echo $apartment_info[0]['longitude'];?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo 'Post Code'; ?></label>
                                <input type="text" name="zip_code" required placeholder="<?php echo 'Post Code'; ?>" class="form-control" value="<?php echo $apartment_info[0]['zip_code']; ?>"/>
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?php echo 'Floor'; ?></label>
                                <input type="text" name="floor" required placeholder="<?php echo 'Floor'; ?>" class="form-control" value="<?php echo $apartment_info[0]['floor']; ?>"/>
                            </div>

                            <!-- <div class="form-group">
                                <label class="control-label">Max couples allowed in flat</label>
                                <input type="number" name="max_couples_allowed" required placeholder="<?php //echo 'Max couples allowed in flat'; ?>" value="<?php //echo $apartment_info[0]['max_couples_allowed']; ?>" class="form-control"/>
                            </div> -->

                            <div class="form-group">
                                <label class="control-label"><?php echo 'Flat/House number'; ?></label>
                                <input type="text" name="nr" required placeholder="<?php echo 'Nr.'; ?>" class="form-control" value="<?php echo $apartment_info[0]['nr']; ?>"/>
                            </div>

                            <?php if($apartment_info[0]['contract_from'] == "0000-00-00"){ $contact_from = '';}else{$contact_from = mydate($apartment_info[0]['contract_from'],'-');}?>
                            <div class="form-group">
                                <label class="control-label"><?php echo 'Contract From'; ?></label>
                                <input type="text" name="contract_from" id="contract_from" required placeholder="<?php echo 'Contract From'; ?>" class="form-control" value="<?php echo $contact_from; ?>"/>
                            </div>
                            <?php if($apartment_info[0]['contract_to'] == "0000-00-00"){ $contact_to = '';}else{$contact_to = mydate($apartment_info[0]['contract_to'],'-');}?>
                            <div class="form-group">
                                <label class="control-label"><?php echo 'Contract To'; ?></label>
                                <input type="text" name="contract_to" id="contract_to" required placeholder="<?php echo 'Contract To'; ?>" class="form-control" value="<?php echo $contact_to; ?>"/>
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?php echo "PML's Rent"; ?></label>
                                <input type="text" name="contract_cost" required placeholder="<?php echo 'Contract Cost'; ?>" class="form-control" value="<?php echo $apartment_info[0]['contract_cost']; ?>"/>
                            </div>

                            <div class="form-group">
                            <label class="control-label"><?php echo 'Day of the Month'; ?></label>

                            <select class="form-control" id="day_of_month" name="day_of_month" required>
                                <option value="">Select Day</option>
                                <option value="1" <?php echo $apartment_info[0]['day_of_month'] == "1"?"selected":"";?>>1</option>
                                <option value="2" <?php echo $apartment_info[0]['day_of_month'] == "2"?"selected":"";?>>2</option>
                                <option value="3" <?php echo $apartment_info[0]['day_of_month'] == "3"?"selected":"";?>>3</option>
                                <option value="4" <?php echo $apartment_info[0]['day_of_month'] == "4"?"selected":"";?>>4</option>
                                <option value="5" <?php echo $apartment_info[0]['day_of_month'] == "5"?"selected":"";?>>5</option>
                                <option value="6" <?php echo $apartment_info[0]['day_of_month'] == "6"?"selected":"";?>>6</option>
                                <option value="7" <?php echo $apartment_info[0]['day_of_month'] == "7"?"selected":"";?>>7</option>
                                <option value="8" <?php echo $apartment_info[0]['day_of_month'] == "8"?"selected":"";?>>8</option>
                                <option value="9" <?php echo $apartment_info[0]['day_of_month'] == "9"?"selected":"";?>>9</option>
                                <option value="10" <?php echo $apartment_info[0]['day_of_month'] == "10"?"selected":"";?>>10</option>
                                <option value="11" <?php echo $apartment_info[0]['day_of_month'] == "11"?"selected":"";?>>11</option>
                                <option value="12" <?php echo $apartment_info[0]['day_of_month'] == "1"?"selected":"";?>>12</option>
                                <option value="13" <?php echo $apartment_info[0]['day_of_month'] == "13"?"selected":"";?>>13</option>
                                <option value="14" <?php echo $apartment_info[0]['day_of_month'] == "14"?"selected":"";?>>14</option>
                                <option value="15" <?php echo $apartment_info[0]['day_of_month'] == "15"?"selected":"";?>>15</option>
                                <option value="16" <?php echo $apartment_info[0]['day_of_month'] == "16"?"selected":"";?>>16</option>
                                <option value="17" <?php echo $apartment_info[0]['day_of_month'] == "17"?"selected":"";?>>17</option>
                                <option value="18" <?php echo $apartment_info[0]['day_of_month'] == "18"?"selected":"";?>>18</option>
                                <option value="19" <?php echo $apartment_info[0]['day_of_month'] == "19"?"selected":"";?>>19</option>
                                <option value="20" <?php echo $apartment_info[0]['day_of_month'] == "20"?"selected":"";?>>20</option>
                                <option value="21" <?php echo $apartment_info[0]['day_of_month'] == "21"?"selected":"";?>>21</option>
                                <option value="22" <?php echo $apartment_info[0]['day_of_month'] == "22"?"selected":"";?>>22</option>
                                <option value="23" <?php echo $apartment_info[0]['day_of_month'] == "23"?"selected":"";?>>23</option>
                                <option value="24" <?php echo $apartment_info[0]['day_of_month'] == "24"?"selected":"";?>>24</option>
                                <option value="25" <?php echo $apartment_info[0]['day_of_month'] == "25"?"selected":"";?>>25</option>
                                <option value="26" <?php echo $apartment_info[0]['day_of_month'] == "26"?"selected":"";?>>26</option>
                                <option value="27" <?php echo $apartment_info[0]['day_of_month'] == "27"?"selected":"";?>>27</option>
                                <option value="28" <?php echo $apartment_info[0]['day_of_month'] == "28"?"selected":"";?>>28</option>
                                <option value="29" <?php echo $apartment_info[0]['day_of_month'] == "29"?"selected":"";?>>29</option>
                                <option value="30" <?php echo $apartment_info[0]['day_of_month'] == "30"?"selected":"";?>>30</option>
                                <option value="31" <?php echo $apartment_info[0]['day_of_month'] == "31"?"selected":"";?>>31</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo 'Months in advance'; ?></label>

                            <select class="form-control" id="month_in_advance" name="month_in_advance" required>
                                <option value="">Select month in advance</option>
                                <option value="1" <?php echo $apartment_info[0]['month_in_advance'] == "1"?"selected":"";?>>1</option>
                                <option value="2" <?php echo $apartment_info[0]['month_in_advance'] == "2"?"selected":"";?>>2</option>
                                <option value="3" <?php echo $apartment_info[0]['month_in_advance'] == "3"?"selected":"";?>>3</option>
                                <option value="4" <?php echo $apartment_info[0]['month_in_advance'] == "4"?"selected":"";?>>4</option>
                                <option value="5" <?php echo $apartment_info[0]['month_in_advance'] == "5"?"selected":"";?>>5</option>
                                <option value="6" <?php echo $apartment_info[0]['month_in_advance'] == "6"?"selected":"";?>>6</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo 'Standard Payment'; ?></label>

                            <select class="form-control" id="standard_payment" name="standard_payment" required>
                                <option value="">Select standard payment</option>
                                <option value="1" <?php echo $apartment_info[0]['standard_payment'] == "1"?"selected":"";?>>1</option>
                                <option value="3" <?php echo $apartment_info[0]['standard_payment'] == "3"?"selected":"";?>>3</option>
                                <option value="6" <?php echo $apartment_info[0]['standard_payment'] == "6"?"selected":"";?>>6</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo "Deposit"; ?></label>
                            <input type="number" name="deposit" required placeholder="<?php echo 'Deposit'; ?>" value="<?php echo $apartment_info[0]['deposit'];?>" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo 'Note'; ?></label>
                            <textarea name="note" id="note" placeholder="<?php echo 'Note'; ?>" class="form-control"><?php echo $apartment_info[0]['note'];?></textarea>
                        </div>

                            <!-- <?php //if($apartment_info[0]['payment_date_to_owner'] == "0000-00-00"){ $payment_date_to_owner = '';}else{$payment_date_to_owner = //mydate($apartment_info[0]['payment_date_to_owner'],'-');}?>
                            <div class="form-group">
                                <label class="control-label"><?php //echo 'Payment to owner date'; ?></label>
                                <input type="text" name="payment_date_to_owner" id="payment_date_to_owner" required placeholder="<?php //echo 'Payment to owner date'; ?>" class="form-control" value="<?php //echo $payment_date_to_owner; ?>"/>
                            </div> -->

                            <div class="form-group hidden">
                                <label class="control-label"><?php echo 'Service charge for Water'; ?></label>
                                <input type="number" name="water" required placeholder="<?php echo 'Service charge for Water'; ?>" class="form-control" value="<?php echo $apartment_info[0]['water']; ?>"/>
                            </div>

                            <div class="form-group hidden">
                                <label class="control-label"><?php echo 'Service charge for Gas'; ?></label>
                                <input type="number" name="gas" required placeholder="<?php echo 'Service charge for Gas'; ?>" class="form-control" value="<?php echo $apartment_info[0]['gas']; ?>"/>
                            </div>

                            <div class="form-group hidden">
                                <label class="control-label"><?php echo 'Service charge for Electricity'; ?></label>
                                <input type="number hidden" name="electricity" required placeholder="<?php echo 'Service charge for Electricity'; ?>" class="form-control" value="<?php echo $apartment_info[0]['electricity']; ?>"/>
                            </div>

                            <div class="form-group hidden">
                                <label class="control-label"><?php echo 'Service charge for Internet'; ?></label>
                                <input type="number" name="internet" required placeholder="<?php echo 'Service charge for Internet'; ?>" class="form-control" value="<?php echo $apartment_info[0]['internet']; ?>"/>
                            </div>

                            <div class="form-group hidden">
                                <label class="control-label"><?php echo 'Service charge for Council Tax'; ?></label>
                                <input type="number" name="council_tax" required placeholder="<?php echo 'Service charge for Council Tax'; ?>" class="form-control" value="<?php echo $apartment_info[0]['council_tax']; ?>"/>
                            </div>

                            <!--
                            <h3>Common Area</h3>
                            <?php //foreach($apartment_common_area as $key => $common_area){ ?>

                            <div class="row group common_area1">

                                    <div class="col-sm-5">
                                    <label class="control-label"><?php //echo 'Name'; ?></label>
                                    <div class="form-group">
                                        <input name="common_area_type[]" type="text" class="form-control" value="<?php //cho $common_area['type']; ?>">
                                    </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label"><?php //echo 'Quantity'; ?></label>
                                            <input name="common_area_qty[]" type="text" class="form-control" value="<?php //echo $common_area['qty']; ?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="control-label"><?php //echo '&nbsp'; ?></label><br/>
                                            <button type="button"  class="btn btn-primary btn-remove-common btn-danger"><span class="glyphicon glyphicon-minus"></span></button>

                                        </div>
                                    </div>
                                </div>
                            -->
                                <?php //} ?>


                            <!--
                            <div class="row group common_area1">
                                <div class="col-sm-5">
                                    <label class="control-label"><?php //echo 'Name'; ?></label>
                                    <div class="form-group">
                                        <input name="common_area_type[]" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label"><?php //echo 'Quantity'; ?></label>
                                        <input name="common_area_qty[]" type="text" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                    <label class="control-label"><?php //echo '&nbsp'; ?></label><br/>
                                    <button type="button" class="btn btn-primary btn-add btn-add-common"><i class="fa fa-plus"></i></button>

                                    </div>
                                </div>
                            </div>

                            <h3>Private Area</h3>

                            <?php //foreach($apartment_private_area as $key => $private_area){ ?>
                            <div class="row group private_area1">
                                <div class="col-sm-5">
                                    <label class="control-label"><?php //echo 'Name'; ?></label>
                                    <div class="form-group">
                                        <input name="private_area_type[]" type="text" class="form-control" value="<?php //echo $private_area['type']; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label"><?php //echo 'Quantity'; ?></label>
                                        <input name="private_area_qty[]" type="text" class="form-control" value="<?php //echo $private_area['qty']; ?>">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                    <label class="control-label"><?php //echo '&nbsp'; ?></label><br/>
                                    <button type="button"  class="btn btn-primary btn-remove-private btn-danger"><span class="glyphicon glyphicon-minus"></span></button>

                                    </div>
                                </div>
                            </div>
                            <?php //} ?>
                            -->

                            <h3>Rooms</h3>

                            <div class="form-group">
                                <label class="control-label">Max couples allowed in flat</label>
                                <!--                                 <input type="number" name="max_couples_allowed" required placeholder="<?php //echo 'Max couples allowed in flat'; ?>" value="1" class="form-control"/> -->
                                <select class="form-control" name="max_couples_allowed" required>
                                    <option value="">Select</option>
                                    <option value="0" <?php echo $apartment_info[0]['max_couples_allowed'] == "0"?"selected":"";?>>0</option>
                                    <option value="1" <?php echo $apartment_info[0]['max_couples_allowed'] == "1"?"selected":"";?>>1</option>
                                    <option value="2" <?php echo $apartment_info[0]['max_couples_allowed'] == "2"?"selected":"";?>>2</option>
                                    <option value="3" <?php echo $apartment_info[0]['max_couples_allowed'] == "3"?"selected":"";?>>3</option>
                                    <option value="4" <?php echo $apartment_info[0]['max_couples_allowed'] == "4"?"selected":"";?>>4</option>
                                    <option value="5" <?php echo $apartment_info[0]['max_couples_allowed'] == "5"?"selected":"";?>>5</option>
                                    <option value="6" <?php echo $apartment_info[0]['max_couples_allowed'] == "6"?"selected":"";?>>6</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <button type="button" class="btn btn-sm btn-success add_room"><i class="fa fa-plus"> Add Room</i></button>
                            </div>
                            <input type="hidden" name="room_repeater" value="no">

                            <table class="table table-striped table-bordered table-hover apartment-stock-repeater">
                            <thead>
                                    <tr>
                                        <th>Room Name</th>
                                        <th>EnSuite</th>
                                        <th>Market Price</th>
                                        <th>Room Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($apartment_rooms as $room) {?>
                                    <tr class="table_row<?php echo $room['id'];?>">
                                        <td>
                                            <input type="hidden" name="edit_room_id[]" value="<?php echo $room['id'];?>">
                                            <div class="form-group">
                                                <input type="text" name="edit_room_name[]" value="<?php echo $room['room_name']; ?>" class="form-control room_name" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="checkbox" name="edit_check_box[]" class="check_box form-control" <?php echo $room['ensuite'] == "1"?"checked":"";?> value="<?php echo $room['ensuite'];?>" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="edit_market_price[]" value="<?php echo $room['market_price']; ?>" class="form-control"/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="edit_room_description[]" value="<?php echo $room['room_description'];?>" class="form-control"/>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="btn btn-sm btn-danger" onclick="deleteRoom(<?php echo $room['id'];?>)"><i class="fa fa-trash" aria-hidden="true"></i></a>
<!--                                             <a href="javascript:void(0)" class="btn btn-success row-add"><i class="fa fa-plus"></i></a> -->
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                                <tfoot class="room_table_foot">
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="room_name[]" class="form-control room_name" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="checkbox" name="check_box[]" class="check_box form-control"  value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="market_price[]"  class="form-control"/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="room_description[]"  class="form-control"/>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="btn btn-danger row-delete"><i class="fa fa-minus"></i></a>
                                            <a href="javascript:void(0)" class="btn btn-success row-add"><i class="fa fa-plus"></i></a>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>

                             <div class="form-group">
                                <div id="attachmentFileUpload">Upload</div>
                                <div id="uploadedContractFiles"></div>
                            </div>
                            <?php if($apartment_info[0]['file_name']!=''){?>
                            <div class="form-group">
                              <h4><?php echo $apartment_info[0]['attachment_title']?></h4>
                              <img width="200" src="/ap4rent/backend/uploads/temp/<?php echo $apartment_info[0]['file_name']?>">
                            </div>
                          <?php }?>
                            <!-- <div class="row group private_area1">
                                <div class="col-sm-5">
                                    <label class="control-label"><?php //echo 'Name'; ?></label>
                                    <div class="form-group">
                                        <input name="private_area_type[]" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label"><?php //echo 'Quantity'; ?></label>
                                        <input name="private_area_qty[]" type="text" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                    <label class="control-label"><?php //echo '&nbsp'; ?></label><br/>
                                    <button type="button" id="btnAdd-1" class="btn btn-primary btn-add-private"><i class="fa fa-plus"></i></button>

                                    </div>
                                </div>
                            </div> -->

                            <!--<h3>Rooms</h3>

                            <div class="form-group">
                                <label class="control-label"><?php //echo 'Single Room Quantity'; ?></label>
                                <input type="text" name="room1_qty" required placeholder="<?php //echo 'Room Quantity'; ?>" class="form-control" value="<?php //echo $apartment_rooms[0]['room_type'] == 1 ? $apartment_rooms[0]['qty'] : $apartment_rooms[1]['qty'];?>"/>
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?php //echo 'Double Room Quantity'; ?></label>
                                <input type="text" name="room2_qty" required placeholder="<?php //echo 'Room Quantity'; ?>" class="form-control" value="<?php //echo $apartment_rooms[0]['room_type'] == 2 ? $apartment_rooms[0]['qty'] : $apartment_rooms[1]['qty'];?>"/>
                            </div>-->

                            <div class="form-actions text-center">
                                <button type="submit" class="btn blue"><i class="icon-ok"></i> <?php echo lang('btn_save') ?></button>
                                <a href="<?php echo base_url_tr() ?>apartment" class="btn btn-danger"><i class="icon-remove"></i> <?php echo lang('btn_cancel') ?></a>
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
    function deleteRoom(room_id)
    {
        $.ajax({
            url: baseUrl + "apartment/deleteRoom/" + room_id,
            type: "GET",
            success: function(results){
                console.log(results);
                if(results)
                {
                    $(".table_row"+room_id).remove();
                }

            }
        });
    }
    $(document).ready(function () {
        $("#attachmentFileUpload").uploadFile({
            url: baseUrl + "apartment/apartment_photo_upload/",
            allowedTypes: "gif,jpg,png,jpeg",
            fileName: "myfile",
            // autoSubmit: true,
            // showStatusAfterSuccess: false,
            // sequential: true,
            // sequentialCount: 1,
            showPreview: true,
            dragDrop: true,
            previewHeight: "100px",
            previewWidth: "100px",
            showDelete: true,
            extraHTML:function()
        {
            var html = "<div><b>Attachment Title:</b><input type='text' name='attachment_title' class='form-control'/> <br/>";
            html += "</div>";
            return html;
        },
            onSuccess: function (files, data, xhr) {
                //$("#complaint").val("1");
                console.log(data);
                var info = JSON.parse(data);
                // var orig_name = info.upload_data.orig_name;
                // console.log(orig_name);

                $("#uploadedContractFiles").append('<input type="hidden" name="file_name" value="'+info.upload_data.file_name+'">');
                // var image = '<a href="' + baseUrl + "uploads/feedback_file/" + info.upload_data.file_name + '"></a>';
                // $(".gallery").append(image);
            },
            deleteCallback: function(files, data, xhr){
            var file_info = JSON.parse(files);
            $('input[value="'+file_info['fileName']+'"').remove();
        }
        });

        $('.room_table_foot').hide();

        $('.add_room').on('click', function(){
            $('input[name=room_repeater]').val('yes');
            $('.room_table_foot').show();
            $(this).parent('div').css('display','none');
        });

        $(document).on('click','.check_box', function(){
            if($(this).attr('checked'))
            {
                $(this).val("1");
            }
            else{
                $(this).val("0");
            }
        });

        $('.apartment-stock-repeater').on('click', '.row-add', function () {
            var row = $(this).parents('table').find('tfoot tr:first').clone();
            //$(row).find('input[type=checkbox]').uniform();
            $(row).find('input').each(function () {
                $(this).val('');
            });
            $(row).find('input[type=checkbox]').val("0");

            var html = $(row).find('input[type=checkbox]').parents('span').html();
            $(row).find('input[type=checkbox]').parents('div').html(html);

            $(this).parents('table').find('tfoot').append(row);
            $('input[type=checkbox]').uniform();
        });

        $('.apartment-stock-repeater').on('click', '.row-delete', function () {
            if ($(this).parents('tfoot').find('tr').length < 2)
            {
                $('.room_table_foot').hide();
                $('.add_room').parent('div').removeAttr('style');
                $('input[name=room_repeater]').val("no");
            }
            if ($(this).parents('tfoot').find('tr').length > 1) {

                $(this).parents('tr').remove();
            }
        });

        // $(document).on('click', '.btn-add-common', function (e)
        // {
        //     e.preventDefault();

        //     var controlForm = $('#apartment_edit_form1'),
        //     currentEntry = $(this).parents('.common_area1:first'),
        //     //newEntry = $(currentEntry.clone()).appendTo(controlForm);
        //     newEntry = $(currentEntry.clone()).insertAfter(currentEntry);
        //     console.log(currentEntry);

        //     newEntry.find('input').val('');
        //     controlForm.find('.common_area1:not(:last) .btn-add-common')
        //             .removeClass('btn-add-common').addClass('btn-remove-common')
        //             .removeClass('btn-success').addClass('btn-danger')
        //             .html('<span class="glyphicon glyphicon-minus"></span>');
        // }).on('click', '.btn-remove-common', function (e)
        // {
        //     $(this).parents('.common_area1:first').remove();
        //     e.preventDefault();
        //     return false;
        // });

        $(document).on('click', '.btn-add-private', function (e)
        {
            e.preventDefault();

            var controlForm = $('#apartment_edit_form1'),
            currentEntry = $(this).parents('.private_area1:first'),
            //newEntry = $(currentEntry.clone()).appendTo(controlForm);
            newEntry = $(currentEntry.clone()).insertAfter(currentEntry);
            console.log(currentEntry);

            newEntry.find('input').val('');
            controlForm.find('.private_area1:not(:last) .btn-add-private')
                    .removeClass('btn-add-private').addClass('btn-remove-private')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="glyphicon glyphicon-minus"></span>');
        }).on('click', '.btn-remove-private', function (e)
        {

            $(this).parents('.private_area1:first').remove();
            e.preventDefault();
            return false;
        });


        $('#apartment_edit_form1').submit(function (e) {
            e.preventDefault();
            if($('input[name=room_repeater]').val() == "yes")
                    {
                        if($('.room_name').val() == "")
                        {
                            $('.validation_errors').html('<div class="alert alert-danger">Room Name is required</div>');
                            $('html, body').animate({ scrollTop: 0 }, 'slow')
                            return false;
                        }
                    }
            var $form = $(this);
            // var action = $(this).find('form').clone();
            $(this).find('form').remove();
            if ($form.valid()) {
                // $(".ajax-file-upload").html(action);
                console.log('submitted');
                var formData = $form.serializeArray();
                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        console.log(response);
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

    function initMap() {
        // Create a map object and specify the DOM element for display.
        var obj={
            'mapID'     :'map',
            'lat'       :23.8103,
            'lng'       :90.4125,
            'zoomLevel' :15,
        };
       var map=new GMPlugin(obj);
       // map.centerCurrentLocationWithMarker('Drag marker to get latitude langitude','',true,'map_lat','map_lang');

        $("#address").on('change',function(){
            map.makeSingleMarkerTextAddress($(this).val(),'','map_lat','map_lang');
        });

    }

    $('#contract_from').datetimepicker({
        datepicker: true,
        timepicker: false,
        format: 'd-m-Y',
        mask: false
    });

    $('#contract_to').datetimepicker({
        datepicker: true,
        timepicker: false,
        format: 'd-m-Y',
        mask: false
    });

    $('#payment_date_to_owner').datetimepicker({
        datepicker: true,
        timepicker: false,
        format: 'd-m-Y',
        mask: false
    });
</script>
