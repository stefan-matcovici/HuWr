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
        <script
                src="https://code.jquery.com/jquery-3.2.1.min.js"
                integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
                crossorigin="anonymous"></script>
        <script>
            var mymap = L.map('demoMap').setView([0,0], 2);

            L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                maxZoom: 18,
                attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
                '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="http://mapbox.com">Mapbox</a>',
                id: 'mapbox.streets'
            }).addTo(mymap);

            var pointA;
            var address1 = 'Iasi Romania';
            $.get('https://www.mapquestapi.com/geocoding/v1/address?key=WyaRTL1asD9OT4aDXlfoxOhs5DFeH6Ya&location='+address1, function(data){
                pointA = new L.LatLng(data.results[0].locations[0].latLng.lat, data.results[0].locations[0].latLng.lng);
            });


            var migrations = {!! json_encode($migrations->toArray()) !!};

//            migrations.forEach(function(migration)
//            {
//                var polylinePoints=[];
//                //console.log(migration);
//                var address1 = migration.departure_city;
//                $.get('https://www.mapquestapi.com/geocoding/v1/address?key=WyaRTL1asD9OT4aDXlfoxOhs5DFeH6Ya&location='+address1, function(data){
//                    pointA = new L.LatLng(data.results[0].locations[0].latLng.lat, data.results[0].locations[0].latLng.lng);
//                });
//
//                var pointB;
//                var address2 = migration.arrival_city;
//                $.get('https://www.mapquestapi.com/geocoding/v1/address?key=WyaRTL1asD9OT4aDXlfoxOhs5DFeH6Ya&location='+address2, function(data){
//                    pointB = new L.LatLng(data.results[0].locations[0].latLng.lat, data.results[0].locations[0].latLng.lng);
//                });
//
//                console.log(pointA);
//
//                var polylineOptions = {
//                    color: 'blue',
//                    weight: 6,
//                    opacity: 0.9
//                };
//
//                var polyline = new L.Polyline(polylinePoints, polylineOptions);
//
//                mymap.addLayer(polyline);
//
//                var arrowOptions = {
//                    distanceUnit: 'km',
//                    isWindDegree: true,
//                    stretchFactor: 1,
//                    popupContent: function (data) {
//                        return '<strong>' + data.title + '</strong>';
//                    },
//                    arrowheadLength: 0.8,
//                    color: '#155799',
//                    opacity: 0.8
//                };
//
//                var arrowData = {
//
//                    latlng: L.latLng(46.95, 7.4),
//                    degree: 77,
//                    distance: 10,
//                    title: 'Demo'
//                };
//
//                var arrow = new L.Arrow(arrowData, arrowOptions);
//                arrow.addTo(mymap);
            })


        </script>
    </div>