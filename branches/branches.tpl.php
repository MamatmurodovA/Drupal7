<form class="form-group" action="/">
    <input type="text" class="search_icon" id="search_branch" name="branch_name" onkeyup="search_branches(this.value)" placeholder="<?php print t('Type branch name');?>" />
</form>
<div>
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <a href="#branches" aria-controls="branches" role="tab" data-toggle="tab">
            <?php print t('List');?>            
        </a>
    </li>
    <li role="presentation" id="map_tab">
        <a href="#in_map" aria-controls="in_map" role="tab" data-toggle="tab" id="map_tab_href">
            <?php print t('On the map');?>
        </a>
    </li>
  </ul>
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="branches">
            <table class="branches_table" id="branch_table">
                <thead>
                    <th><?php print t('Name');?></th>
                    <th><?php print t('Address');?></th>
                    <th><?php print t('Transports');?></th>
                    <th><?php print t('Work time');?></th>
                </thead>
                <tbody id="branch_table_body">
                    <?php foreach($branches as $branch): ?>
                        <tr>
                            <td class="branches_table_title" lat="<?php print (isset($branch->field_gmap_lat['und'][0]['value']))? $branch->field_gmap_lat['und'][0]['value'] :''; ?>" long="<?php print (isset($branch->field_gmap_long['und'][0]['value']))? $branch->field_gmap_long['und'][0]['value'] : ''; ?>">
                                <?php print l($branch->title,'branch/'.pathauto_cleanstring($branch->title).'/'.$branch->nid);?>
                            </td>
                            <td class="branches_table_address">
                                <br/>
                                <?php print (!empty($branch->body))? $branch->body['und'][0]['value'] : '';?></div>
                                <?php print (!empty($branch->field_helpline))? $branch->field_helpline['und'][0]['value'] : '';?></div>
                            </td>
                            <td class="branches_transport">
                                <?php if(!empty($branch->field_transport_bus)):?>
                                    <div class="transport_bus">
                                        <?php $b = 0; foreach($branch->field_transport_bus['und'] as $bus):?>
                                            <span class="bus">
                                                <?php print $bus['value']; $b++;?>
                                                <?php print (count($branch->field_transport_bus['und']) != $b)? ',' : ''; ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if(!empty($branch->field_transport_subway)):?>
                                    <div class="transport_subway">
                                        <?php $s = 0; foreach($branch->field_transport_subway['und'] as $subway):?>
                                            <span class="subway">
                                                <?php print $subway['value']; $s++;?>
                                                <?php print (count($branch->field_transport_subway['und']) != $s)? ',' : ''; ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if(!empty($branch->field_shuttle_bus)):?>
                                    <div class="transport_shuttle_bus">
                                        <?php $shb = 0; foreach($branch->field_shuttle_bus['und'] as $shuttle_bus):?>
                                            <span class="shuttle_bus">
                                                <?php print $shuttle_bus['value']; $shb++; ?>
                                                <?php print (count($branch->field_shuttle_bus['und']) != $shb)? ',' : ''; ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="branches_table_worktime">
                                <div class="work_time">
                                    <?php print (!empty($branch->field_work_time))? $branch->field_work_time['und'][0]['value'] : ''; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
    </div>
    <div role="tabpanel" class="tab-pane" id="in_map">
       
        <div id="map" style="width:100%; height:500px"></div>
        <script>
            var map;
            var locations = [];
            var tbody = document.getElementById('branch_table_body');
            var tr = tbody.getElementsByTagName('tr');
            var markers = [];
            document.addEventListener('DOMContentLoaded', function(){
                Array.prototype.forEach.call(tr, function(item, index){
                    td = item.getElementsByTagName('td')[0];
                    address = item.getElementsByTagName('td')[1];
                    locations.push ({
                        lat: td.getAttribute('lat'),
                        long: td.getAttribute('long'),
                        content: item.outerHTML
                    });
                });
                 markers = set_markers(map, locations);
            })
            
            function initMap() {
                center = {lat: 41.3538677, lng: 69.2159133};
                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 12,
                    center: center
                });
            }

            function search_branches(query_string){
                locations = [];

                Array.prototype.forEach.call(tr, function(item, index){
                td_name    = item.getElementsByTagName('td')[0];
                td_address = item.getElementsByTagName('td')[1];
                td_subway  = item.getElementsByTagName('td')[2];
                console.log(td_address.textContent);
                var boolean = td_name.textContent.toLowerCase().search(query_string.toLowerCase()) > -1 || td_address.textContent.toLowerCase().search(query_string.toLowerCase()) > -1 || td_subway.textContent.toLowerCase().search(query_string.toLowerCase()) > -1;
                    if(boolean){
                        tr[index].style.display = '';
                        locations.push ({
                            lat: td_name.getAttribute('lat'),
                            long: td_name.getAttribute('long'), 
                            content: item.outerHTML
                        });
                    }else{
                        tr[index].style.display = 'none';
                    }
                })
                var markers = set_markers(map, locations);
            }
            function set_markers(map, locations){
                if(markers){
                    while(markers.length){
                        markers.pop().setMap(null);
                    }
                }
                Array.prototype.forEach.call(locations, function(item, index){
                    var latLng = new google.maps.LatLng(item.lat, item.long);
                    var infowindow = new google.maps.InfoWindow();
                    var marker = new google.maps.Marker({
                        position: latLng,
                        map: map
                    });
                    infowindow.setContent(item.content);
                    infowindow.open(map, marker);
                    marker.addListener('click', () => {
                        infowindow.setContent(item.content);
                        infowindow.open(map, marker);
                    });
                    markers.push(marker);
                });
                return markers;
            }
            $("a[href='#in_map']").on('shown.bs.tab', function(){
                google.maps.event.trigger(map, 'resize');
            });
        </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqi_WoWI2M3xKco9KQWbkO96nS6aSw_Eo&callback=initMap"></script>
    </div>
  </div>

</div>