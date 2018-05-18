<style type="text/css">
    .box-menu{
        padding: 40px
    }
    .box-menu:hover{
        text-decoration: none;
    }
    .loader {
      background-color: rgba(0,0,0,.8);
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      z-index: 999999;
    }
    .loader:before {
      content: "\f110";
      font-family: FontAwesome;
      font-size: 60px;
      position: absolute;
      top: 40%;
      left: 55%;
      color: #fff;
      animation: fa-spin 1s infinite steps(8);
  }

</style>
<!-- BEGIN DASHBOARD STATS -->
<div class="loader hidden" id="loader"></div>
<div class="row">
  <div class="col-md-12">
    <?php $user_type = getUserdata('user_type'); ?>
    <?php if($user_type=='backend_user'){?>
       <div id="map" style="width:100%;height: 450px; margin: 0 auto;"></div>
       
    <?php } ?>
  </div>
</div>

<script type="text/javascript">
	function initMap() {
        // Create a map object and specify the DOM element for display.
        var obj={
            'mapID'     :'map',
            'lat'       :51.5074,
            'lng'       :0.1278,
            'zoomLevel' :15,
        };
       var map=new GMPlugin(obj);
       var markers=[];
       var infoWindow = new google.maps.InfoWindow();
       var markerColor='';
       var tableHtml='';
       $.ajax({
       		url:"<?php echo base_url('dashboard/apartments_lat_lang');?>",
       		type:'post',
       		dataType:'json',
       		success:function(response){
            
       			for(var i=0;i<response.length;i++){
              if(response[i].requests>0){
                markerColor='red';
              }
              else{
                markerColor='green';
              }
    					marker=map.createMarkerOnLatLng(Number.parseFloat(response[i].latitude),Number.parseFloat(response[i].longitude),response[i].id,markerColor);
              markers.push(marker);
    					map.mapZoomLevel(10);
             
       			}

            // for info window to show apartment information
            for(var m=0;m<markers.length;m++){

              markers[m].addListener('click',function(){
                var apartment_id=$(this)[0].id;
                
                var m=$(this)[0];
                  $.ajax({
                      url:"<?php echo base_url('dashboard/tenant_requests');?>",
                      dataType:'json',
                      type:'post',
                      data:{apartment_id:apartment_id},
                      beforeSend:function(){
                        $("#loader").removeClass('hidden');
                      },
                      complete:function(){
                        $("#loader").addClass('hidden');
                      },
                      success:function(response){
                        //console.log(response);
                        tableHtml='<table class="table table-striped">';
                        tableHtml+='<tr><th colspan="2" class="text-center">Property Details</th></tr>';
                        tableHtml+='<tr><th>Property ID</th><td>'+response.apartment_id+'</td></tr>';
                        tableHtml+='<tr><th>Address</th><td>'+response.address+'</td></tr>';
                        tableHtml+='<tr><th>ZIP Code</th><td>'+response.zip_code+'</td></tr>';
                        tableHtml+='<tr><th>Floor</th><td>'+response.floor+'</td></tr>';
                        if(!response.tenant_req_id){
                            tableHtml+='<tr><th>Request</th><td></td></tr>';
                            tableHtml+='<tr><th>Room Id</th><td></td></tr>';
                            tableHtml+='<tr><th>Cost</th><td></td></tr>';
                        }
                        else{
                            tableHtml+='<tr><th>Request</th><td><a data-room="'+response.room_id+'" data-appid="'+response.apartment_id+'" href="#RequestModal" data-toggle="modal" class="open-RequestDialog"><i class="icon-list"></i> Request List</a></td></tr>';
                            tableHtml+='<tr><th>Room Id</th><td>'+response.room_id+'</td></tr>';
                            tableHtml+='<tr><th>Cost</th><td>'+response.cost+'</td></tr>';
                        }
                        tableHtml+='</table>';
                        infoWindow.setContent("<div>"+tableHtml+"</div>");
                        infoWindow.open(map,m);
                      }
                  });
              });
            }
       		}
       });
       
    }

    $(document).on('click', '.open-RequestDialog', function(event) {
      event.preventDefault();
      var room_id = $(this).attr('data-room');
      var apartment_id = $(this).attr('data-appid');

      //alert(apartment_id);

      $.ajax({
          url:"<?php echo base_url('dashboard/request_view');?>",
          dataType:'json',
          type:'post',
          data:{apartment_id:apartment_id, room_id:room_id},
          beforeSend:function(){
            $("#loader").removeClass('hidden');
          },
          complete:function(){
            $("#loader").addClass('hidden');
          },
          success:function(response){
              console.log(response);
              var html = '';
              if(response == 0) {
                html = '';
              } else {
                $.each(response, function(index, el) {
                    html += '<tr>';
                        html += '<td class="text-center">'+el['id']+'</td>';
                        html += '<td class="text-center">'+el['create_date']+'</td>';
                        <?php if ($user_type != 'tenant') { ?>
                          html += '<td>'+el['name'] + ' ' + el['family_name']+'</td>';
                        <?php } ?>
                        html += '<td class="text-center">'+el['description']+'</td>';
                        <?php if ($user_type == 'backend_user') { ?>
                          html += '<td class="text-center">'+el['apartment_id']+'-'+el['apartment_address']+' ( Floor : '+el['apartment_floor']+' ) '+el['apartment_zip_code']+'</td>';
                          html += '<td class="text-center">'+el['cost']+'</td>';
                          html += '<td class="text-center">'+el['charge_amount']+'</td>';
                        <?php } ?>
                    html += '</tr>';
                });
              }
              $('.my-request tbody').html(html);
          }
      });
    });
</script>

<!-- Modal -->
<div id="RequestModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="text-align: left;">Releted My Requests</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped my-request">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center"><?php echo lang('create_date'); ?></th>
                            <?php if ($user_type != 'tenant') { ?>
                              <th class="text-center">Occupant</th>
                            <?php } ?>
                            <th class="text-center"><?php echo lang('description'); ?></th>
                            <?php if ($user_type == 'backend_user') { ?>
                              <th class="text-center">Property</th>
                              <th class="text-center">Cost</th>
                              <th class="text-center">Charge Amount</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <!-- /.modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- Modal content-->
    </div>
</div>
<!-- Modal -->