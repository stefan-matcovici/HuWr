@section('assets')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" integrity="sha512-07I2e+7D8p6he1SIM+1twR5TIrhUQn9+I6yjqD53JQjFiMf8EtC93ty0/5vJTZGF8aAocvHYNEDJajGdNx1IsQ=="
    crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js" integrity="sha512-A7vV8IFfih/D732iSSKi20u/ooOfj/AGehOKq0f4vLT1Zr2Y+RX7C+w8A1gaSasGtRUZpF/NZgzSAu4/Gc41Lg=="
    crossorigin=""></script>
  <script src="{{asset('js/leaflet-arrows.js')}}"></script>
@endsection

@section('content')
<div class="container fill">
    <div id="demoMap"></div>
  </div>
  <div>
    <script>
      var mymap = L.map('demoMap').setView([47.151726, 27.587914], 13);

      L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        maxZoom: 18,
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
        '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
        'Imagery © <a href="http://mapbox.com">Mapbox</a>',
        id: 'mapbox.streets'
      }).addTo(mymap);

      var pointA = new L.LatLng(45.760696, 21.226788);
      var pointB = new L.LatLng(47.151726, 27.587914);
      var polylinePoints = [pointA, pointB];

      var polylineOptions = {
        color: 'blue',
        weight: 6,
        opacity: 0.9
      };

      var polyline = new L.Polyline(polylinePoints, polylineOptions);

      mymap.addLayer(polyline);

      var arrowOptions = {
        distanceUnit: 'km',
        isWindDegree: true,
        stretchFactor: 1,
        popupContent: function (data) {
          return '<strong>' + data.title + '</strong>';
        },
        arrowheadLength: 0.8,
        color: '#155799',
        opacity: 0.8
      };

      var arrowData = {
        
        latlng: L.latLng(46.95, 7.4),
        degree: 77,
        distance: 10,
        title: 'Demo'
      };

      var arrow = new L.Arrow(arrowData, arrowOptions);
      arrow.addTo(mymap);

      // zoom the map to the polyline
      mymap.fitBounds(polyline.getBounds());
    </script>
</div>