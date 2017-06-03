@section('assets')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" integrity="sha512-07I2e+7D8p6he1SIM+1twR5TIrhUQn9+I6yjqD53JQjFiMf8EtC93ty0/5vJTZGF8aAocvHYNEDJajGdNx1IsQ=="
          crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js" integrity="sha512-A7vV8IFfih/D732iSSKi20u/ooOfj/AGehOKq0f4vLT1Zr2Y+RX7C+w8A1gaSasGtRUZpF/NZgzSAu4/Gc41Lg=="
            crossorigin=""></script>
    <script src="{{asset('js/leaflet-arrows.js')}}"></script>
    <script src='//unpkg.com/leaflet-arc/bin/leaflet-arc.min.js'></script>

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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-polylinedecorator/1.1.0/leaflet.polylineDecorator.js">
        </script>
        <script>
            var mymap = L.map('demoMap').setView([0,0], 2);
            mymap.options.minZoom = 2;
//            map.options.maxZoom = 14;
            {{--mymap.on("click",function(event)--}}
                {{--{--}}
                    {{--window.location.replace('{!!  route('country') ,['lat' => 12, 'lng' => 13] !!}');--}}
                {{--}--}}
            {{--)--}}

            L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                maxZoom: 18,
                attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
                '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="http://mapbox.com">Mapbox</a>',
                id: 'mapbox.streets'
            }).addTo(mymap);

            var migrations = {!! json_encode($migrations->toArray()) !!};

            migrations.forEach(function(migration)
            {
                var blueMarker = L.icon({
                    iconUrl: 'https://camo.githubusercontent.com/1c5e8242c57d3b712ed654e3bc9fe2f0717a7200/68747470733a2f2f7261772e6769746875622e636f6d2f706f696e7468692f6c6561666c65742d636f6c6f722d6d61726b6572732f6d61737465722f696d672f6d61726b65722d69636f6e2d32782d626c75652e706e673f7261773d74727565',

                    iconSize:     [10, 18], // size of the icon
                    iconAnchor:   [5, 14], // point of the icon which will correspond to marker's location
                    popupAnchor:  [1, -15] // point from which the popup should open relative to the iconAnchor
                });
                marker1 = L.marker([migration.departure_latitude, migration.departure_longitude], {icon: blueMarker}).addTo(mymap);
                var redMarker = L.icon({
                    iconUrl: 'https://camo.githubusercontent.com/70c53b19fb9ec32c09ff59b4aebe6bb8058dfb8b/68747470733a2f2f7261772e6769746875622e636f6d2f706f696e7468692f6c6561666c65742d636f6c6f722d6d61726b6572732f6d61737465722f696d672f6d61726b65722d69636f6e2d7265642e706e673f7261773d74727565',

                    iconSize:     [10, 18], // size of the icon
                    iconAnchor:   [5, 14], // point of the icon which will correspond to marker's location
                    popupAnchor:  [1, -15] // point from which the popup should open relative to the iconAnchor
                });
                marker2 = L.marker([migration.arrival_latitude, migration.arrival_longitude], {icon: redMarker}).addTo(mymap);
                marker1.bindPopup("<b> Hello I'm a popup.</b>");
                marker2.bindPopup("<b> Hello I'm a popup.</b>")

                pointA = new L.LatLng(migration.departure_latitude, migration.departure_longitude);
                pointB = new L.LatLng(migration.arrival_latitude, migration.arrival_longitude);
                polylinePoints = [pointA,pointB];

                var polylineOptions = {
                    color: '#4d4d4d',
                    weight: 3.5,
                    opacity: 0.5,
                    noClip: true
                };

                var polyline = new L.Polyline(polylinePoints, polylineOptions);
                polyline.on('mouseover', function() {
                    if (this.options["color"] !== 'black') {
                        this.setStyle({
                            color: 'gray',
                            weight: 8
                        });
                    }
                });

                polyline.on('mouseout', function() {
                    if (this.options["color"] === 'gray') {
                        this.setStyle(polylineOptions);
                    }
                });


                polyline.on('click', function() {
                    if (this.options["color"] === 'black') {
                        this.setStyle(polylineOptions);
                    } else {
                        this.setStyle({
                            color: 'black',
                            weight: 10
                        });
                    }
                });

                mymap.addLayer(polyline);


                L.polylineDecorator(polyline,{
                    patterns: [
                        // define a pattern of 10px-wide dashes, repeated every 20px on the line
                        {
                            offset: '100%',
                            repeat:0,
                            symbol: new L.Symbol.arrowHead({
                                pixelSize: 8,
                                pathOptions: {fillOpacity: 0.5,
                                    weight: 0.5
                                }
                            })
                        }
                    ]}).addTo(mymap);
            })


        </script>
    </div>