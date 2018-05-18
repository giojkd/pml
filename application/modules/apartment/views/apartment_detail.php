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
                    
                    <!-- BEGIN FORM-->
                    <?php //echo '<pre>'; print_r($apartment_common_area); echo '</pre>'; ?>
                    
                    <div class="row">
                        <div class="col-xs-12">
                            <h2>Information about apartment</h2>
                            <div class="table-responsive">
                              <table class="table table-bordered table-striped table-hover">
                                <tr>
                                    <td width="85%"><b>Owner</b></td>
                                    <td><?php echo getUser($apartment_info[0]['owner'],"family_name").' '.getUser($apartment_info[0]['owner'],"name"); ?><?php echo getUser($apartment_info[0]['owner'],"company_name")?" (".getUser($apartment_info[0]['owner'],"company_name").")":""?></td>
                                </tr>
                                <tr>
                                    <td><b>Address</b></td>
                                    <td><?php echo $apartment_info[0]['address']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>ZIP Code</b></td>
                                    <td><?php echo $apartment_info[0]['zip_code']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Floor</b></td>
                                    <td><?php echo $apartment_info[0]['floor']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Nr.</b></td>
                                    <td><?php echo $apartment_info[0]['nr']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Contract Cost</b></td>
                                    <td><?php echo $apartment_info[0]['contract_cost']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Contract From</b></td>
                                    <td><?php if($apartment_info[0]['contract_from'] != '0000-00-00'){echo date("d-m-Y", strtotime($apartment_info[0]['contract_from']));}else{echo '';} ?></td>
                                </tr>
                                <tr>
                                    <td><b>Contract To</b></td>
                                    <td><?php if($apartment_info[0]['contract_to'] != '0000-00-00'){echo date("d-m-Y", strtotime($apartment_info[0]['contract_to']));}else{echo '';} ?></td>
                                </tr>
                                <tr>
                                    <td><b>Payment to owner date</b></td>
                                    <td><?php if($apartment_info[0]['payment_date_to_owner'] != '0000-00-00'){echo date("d-m-Y", strtotime($apartment_info[0]['payment_date_to_owner']));}else{echo '';} ?></td>
                                </tr>
                                
                              </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <h2>Room Details</h2>
                            <div class="table-responsive">
                              <table class="table table-bordered table-striped table-hover">
                                <tr>
                                    <td width="85%"><b>Total single type room</b></td>
                                    <td><?php echo $single_room_in_apartment['total_room']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Total double type room</b></td>
                                    <td><?php echo $double_room_in_apartment['total_room']; ?></td>
                                </tr>
                                
                              </table>
                            </div>
                        </div>
                    </div>

                    <div class="row hidden">
                        <div class="col-xs-12">
                            <h2>Common Area Details</h2>
                            <?php if(count($apartment_common_area)){ ?>
                            <div class="table-responsive">
                              <table class="table table-bordered table-striped table-hover">
                                <?php foreach($apartment_common_area as $common_area){ ?>
                                <tr>
                                    <td width="85%"><b><?php echo $common_area['type']; ?></b></td>
                                    <td><?php echo $common_area['qty']; ?></td>
                                </tr>
                                
                                <?php } ?>

                              </table>
                            </div>
                            <?php } else{ ?>
                            <h4>No Common Area Available</h4>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="row hidden">
                        <div class="col-xs-12">
                            <h2>Private Area Details</h2>
                            <?php if(count($apartment_private_area)){ ?>
                            <div class="table-responsive">
                              <table class="table table-bordered table-striped table-hover">
                                <?php foreach($apartment_private_area as $private_area){ ?>
                                <tr>
                                    <td width="85%"><b><?php echo $private_area['type']; ?></b></td>
                                    <td><?php echo $private_area['qty']; ?></td>
                                </tr>
                                
                                <?php } ?>

                              </table>
                            </div>
                            <?php } else{ ?>
                            <h4>No Private Area Available</h4>
                            <?php } ?>
                        </div>
                    </div>
                    
                    <div class="row hidden">
                        <div class="col-xs-12">
                            <h2>Services for apartment</h2>
                            <div class="table-responsive">
                              <table class="table table-bordered table-striped table-hover">
                                <tr>
                                    <td width="85%"><b>Service charge for water(£)</b></td>
                                    <td><?php echo $apartment_info[0]['water']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Service charge for gas(£)</b></td>
                                    <td><?php echo $apartment_info[0]['gas']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Service charge for internet(£)</b></td>
                                    <td><?php echo $apartment_info[0]['internet']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Service charge for electricity(£)</b></td>
                                    <td><?php echo $apartment_info[0]['electricity']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Service charge for council tax(£)</b></td>
                                    <td><?php echo $apartment_info[0]['council_tax']; ?></td>
                                </tr>
                                
                              </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="clearfix"></div>
                </div>
            </div>
            <!---end form -->
        </div>
    </div>
</div>
<!-- END PAGE CONTENT-->
