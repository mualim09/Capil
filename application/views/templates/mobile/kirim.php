<html>

  <head>
    <link data-require="leaflet@0.7.7" data-semver="0.7.7" rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/leaflet.css" />
    <script data-require="leaflet@0.7.7" data-semver="0.7.7" src="//cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/leaflet.js"></script>
    <script src="https://npmcdn.com/leaflet-geometryutil"></script>
  </head>

  <body>
    
    <p>
To test, just click two times to draw a line. Distance and length will be calculate between the two points.
</p>

<div id="map" style="height: 300px"></div>
  
<p>
    Distance (in pixel): <span id="distance"></span>
</p>

<p>
    Length (in meters): <span id="length"></span>
</p>
    <script src="script.js"></script>
  </body>
<script>
  var
  _firstLatLng,
  _firstPoint,
  _secondLatLng,
  _secondPoint,
  _distance,
  _length,
  _polyline
_map = L.map('map').setView([3.3053807,117.5866475], 13);

L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
  attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
}).addTo(_map);

// add listeners to click, for recording two points
_map.on('click', function(e) {

  if (!_firstLatLng) {
    _firstLatLng = e.latlng;
    _firstPoint = e.layerPoint;
    L.marker(_firstLatLng).addTo(_map).bindPopup('Point A<br/>' + e.latlng + '<br/>' + e.layerPoint).openPopup();
  } else {
    _secondLatLng = e.latlng;
    _secondPoint = e.layerPoint;
    L.marker(_secondLatLng).addTo(_map).bindPopup('Point B<br/>' + e.latlng + '<br/>' + e.layerPoint).openPopup();
  }

  if (_firstLatLng && _secondLatLng) {
    // draw the line between points
    L.polyline([_firstLatLng, _secondLatLng], {
      color: 'red'
    }).addTo(_map);

    refreshDistanceAndLength();
  }
})

_map.on('zoomend', function(e) {
  refreshDistanceAndLength();
})

function refreshDistanceAndLength() {
  _distance = L.GeometryUtil.distance(_map, _firstLatLng, _secondLatLng);
  _length = L.GeometryUtil.length([_firstPoint, _secondPoint]);
  document.getElementById('distance').innerHTML = _distance;
  document.getElementById('length').innerHTML = _length;
}
</script>
</html>