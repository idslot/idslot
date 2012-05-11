function initialize() {
  map_colors = new Array('green', 'purple', 'yellow', 'blue', 'orange', 'red');
  map_colors_index = 5;
  map_link = document.getElementById('contact[map]').value;
  
  var latlng = new google.maps.LatLng(32.324276, 55.107422);
  var myOptions = {
    zoom: 5,
    center: latlng,
    mapTypeControl: false,
    streetViewControl: false,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  
  map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);
  marker = new google.maps.Marker({
          position: latlng, 
          map: map, 
          draggable: true
  });
  
  google.maps.event.addListener(marker, 'dragend', map_get_pos);
  google.maps.event.addListener(marker, 'click', map_change_color_up);
  google.maps.event.addListener(marker, 'rightclick', map_change_color_down);
  google.maps.event.addListener(map, 'zoom_changed', map_get_pos);
  google.maps.event.addListener(map, 'dragend', map_get_pos);
  google.maps.event.addListener(map, 'click', function(e) { marker.setPosition(e.latLng); map_get_pos(); });
  
  map_set_pos(map_link);
  map_change_color();
  map_get_pos();
}

function map_get_pos() {
  var pos = marker.getPosition();
  var lat = pos.lat();
  var lng = pos.lng();
  
  var map = marker.getMap();
  var center = map.getCenter();
  var mzoom = map.getZoom();
  var mlat = center.lat();
  var mlng = center.lng();
  
  var color = map_colors[map_colors_index];
  
  document.getElementById("contact[map]").value =
  'http://maps.google.com/maps/api/staticmap?center=' + mlat + ',' + mlng + '&zoom=' + mzoom + '&size=400x300&maptype=roadmap&sensor=false&language=' + map_language + '&markers=color:' + color + '|' + lat + ',' + lng;
}

function map_set_pos(url) {
  var needle=/http:\/\/maps.google.com\/maps\/api\/staticmap\?center=([\d.-]+),([\d.-]+)&zoom=(\d+)&size=\d+x\d+&maptype=roadmap&sensor=false&language=..&markers=color:(\w+)\|([\d.-]+),([\d.-]+)/;
  
  url.match(needle);
  if(RegExp.$1, RegExp.$2, RegExp.$3){
    var mlatlng = new google.maps.LatLng(RegExp.$1, RegExp.$2);
    var mzoom   = RegExp.$3;
    map.setCenter(mlatlng);
    map.setZoom(parseInt(mzoom));
  }
  
  if(RegExp.$4){
    map_colors_index = map_colors.indexOf(RegExp.$4);
  }
  
  if(RegExp.$5, RegExp.$6){
    var latlng = new google.maps.LatLng(RegExp.$5, RegExp.$6);
    marker.setPosition(latlng);
  }
}

function map_change_color(){
  if(map_colors_index < 0) map_colors_index = 5;
  if(map_colors_index > 5) map_colors_index = 0;
  marker.setIcon('http://www.google.com/mapfiles/ms/micons/' + map_colors[map_colors_index] + '-dot.png');
  map_get_pos();
}

function map_change_color_up(){
  map_colors_index = map_colors_index + 1;
  map_change_color();
}

function map_change_color_down(){
  map_colors_index = map_colors_index - 1;
  map_change_color();
}

function reset_map(){
  map_set_pos(map_link);
}

window.onload = initialize;