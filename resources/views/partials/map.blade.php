@section('assets')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" integrity="sha512-07I2e+7D8p6he1SIM+1twR5TIrhUQn9+I6yjqD53JQjFiMf8EtC93ty0/5vJTZGF8aAocvHYNEDJajGdNx1IsQ=="
          crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js" integrity="sha512-A7vV8IFfih/D732iSSKi20u/ooOfj/AGehOKq0f4vLT1Zr2Y+RX7C+w8A1gaSasGtRUZpF/NZgzSAu4/Gc41Lg=="
            crossorigin=""></script>
    <script src="{{asset('js/leaflet-arrows.js')}}"></script>
    <script src='//unpkg.com/leaflet-arc/bin/leaflet-arc.min.js'></script>
    <script src="file:://../../node_modules/leaflet-toolbar/dist/leaflet.toolbar.js"></script>
    <link rel="stylesheet" href="file:://../../node_modules/leaflet-toolbar/dist/leaflet.toolbar.css"/>
    <script src="{{asset('js/L.Control.Sidebar.js')}}"></script>
    <script src="{{asset('js/Leaflet.CountrySelect.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/L.Control.Sidebar.css')}}">
@endsection

@section('content')
    <div class="container fill">
        <div id="demoMap">
            <div id="sidebar">
                <h1>leaflet-sidebar</h1>
            </div>
        </div>
    </div>
    <div>
        <script
                src="https://code.jquery.com/jquery-3.2.1.min.js"
                integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
                crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-polylinedecorator/1.1.0/leaflet.polylineDecorator.js">
        </script>
        <script>
            var mymap = L.map('demoMap', {zoomControl : false}).setView([0,0], 2);
            mymap.options.minZoom = 2;
//            map.options.maxZoom = 14;

            L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                maxZoom: 18,
                attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
                '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="http://mapbox.com">Mapbox</a>',
                id: 'mapbox.streets'
            }).addTo(mymap);
            var polylines = [];

            var sidebar = L.control.sidebar('sidebar', {
                position: 'left',
                closeButton: 'true',
            });

            var select = L.countrySelect().addTo(mymap);
            select.on('change', function(e){
                if(e.feature === undefined){ //No action when the first item ("Country") is selected
                    return;
                }
                var country = L.geoJson(e.feature);
                if (this.previousCountry != null){
                    mymap.removeLayer(this.previousCountry);
                }
                this.previousCountry = country;

                mymap.addLayer(country);
                mymap.fitBounds(country.getBounds());
                sidebar.show();
            });


            mymap.addControl(sidebar);


            var migrations = {!! json_encode($migrations->toArray()) !!};
            var polylineOptions;
            migrations.forEach(function(migration)
            {
                var blueMarker = L.icon({
                    iconUrl: 'https://camo.githubusercontent.com/1c5e8242c57d3b712ed654e3bc9fe2f0717a7200/68747470733a2f2f7261772e6769746875622e636f6d2f706f696e7468692f6c6561666c65742d636f6c6f722d6d61726b6572732f6d61737465722f696d672f6d61726b65722d69636f6e2d32782d626c75652e706e673f7261773d74727565',

                    iconSize:     [20, 35], // size of the icon
                    iconAnchor:   [8, 34], // point of the icon which will correspond to marker's location
                    popupAnchor:  [1, -25] // point from which the popup should open relative to the iconAnchor
                });
                marker1 = L.marker([migration.departure_latitude, migration.departure_longitude], {icon: blueMarker}).addTo(mymap);

                var redMarker = L.icon({
                    iconUrl: 'https://camo.githubusercontent.com/70c53b19fb9ec32c09ff59b4aebe6bb8058dfb8b/68747470733a2f2f7261772e6769746875622e636f6d2f706f696e7468692f6c6561666c65742d636f6c6f722d6d61726b6572732f6d61737465722f696d672f6d61726b65722d69636f6e2d7265642e706e673f7261773d74727565',

                    iconSize:     [20, 35], // size of the icon
                    iconAnchor:   [8, 34], // point of the icon which will correspond to marker's location
                    popupAnchor:  [1, -25] // point from which the popup should open relative to the iconAnchor
                });
                marker2 = L.marker([migration.arrival_latitude, migration.arrival_longitude], {icon: redMarker}).addTo(mymap);
                content = getMarkerPopupContent(migration.departure_city, migration.departure_country, migration.departure_latitude, migration.departure_longitude);
                marker1.bindPopup(content);
                content = getMarkerPopupContent(migration.arrival_city, migration.arrival_country, migration.arrival_latitude, migration.arrival_longitude);
                marker2.bindPopup(content);

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
                            weight: 17
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
                        polylines.forEach(function (polyline2) {
                           polyline2.setStyle(polylineOptions);
                        });
                        sidebar.show();

                        content = getSideBarHTML(migration);

                        sidebar.setContent(content);
                        this.setStyle({
                            color: 'black',
                            weight: 10
                        });
                    }
                });

                mymap.addLayer(polyline);
                polylines.push(polyline);


                L.polylineDecorator(polyline,{
                    patterns: [
                        {
                            offset: '100%',
                            repeat:0,
                            symbol: new L.Symbol.arrowHead({
                                pixelSize: 10,
                                pathOptions: {
                                    fillOpacity: 0.5,
                                    weight: 2,
                                    color: 'gray'
                                }
                            })
                        }
                    ]}).addTo(mymap);
                sidebar.on('hidden', function () {
                    polylines.forEach(function (polyline2) {
                        polyline2.setStyle(polylineOptions);
                    });
                });

            });

        function getSideBarHTML(migration) {
            numberOfMigrations = 0;
            numberOfAdults = 0;
            numberOfChildren = 0;
            content = "";

            content = "<h1> Migration from " + migration.departure_city + ", " + migration.departure_country + " to " + migration.arrival_city + ", " + migration.arrival_country + " </h1><hr>";


            reasons = [];
            migrations.forEach(function (migration2) {
                if (migration2.departure_latitude === migration.departure_latitude &&
                    migration2.departure_longitude === migration.departure_longitude &&
                    migration2.arrival_latitude === migration.arrival_latitude &&
                    migration2.arrival_latitude === migration.arrival_latitude) {
                    content += "<ul class = \"list-group\">";
                    numberOfMigrations++;
                    numberOfAdults += migration2.adults;
                    numberOfChildren += migration2.children;

                    var users = {!! json_encode($users->toArray()) !!};
                    var username = "";
                    users.forEach(function (user) {
                        if (user.id === migration.user_id) {
                            username = user.first_name + " " + user.last_name;
                        }
                    } );

                    content +=
                        "<li class = \"list-group-item\"> Author: <b>" + username + "</b> </li>" +
                        "<li class = \"list-group-item\"> Date: <b>" + migration2.created_at + "</b> </li>" +
                        "<li class = \"list-group-item\"> Number of adults: <b>" + migration2.adults + "</b></li>" +
                        "<li class = \"list-group-item\"> Number of children: <b>" + migration2.children + "</b></li>" +
                        "<li class = \"list-group-item\"> Reason: <b>" + migration2.reason + "</b></li>";
                    content += "</ul><br>";

                    if (reasons.indexOf(migration2.reason) < 0) {
                        reasons.push(migration2.reason);
                    }
                }
            });
            content += "<hr><b> Reasons: <ol>";

            reasons.forEach(function (reason) {
                content += "<li> <h5>" + reason + " </h5></li>";
            });
            content += "</ol></b>";
            content += "<h4> Total:  " + numberOfMigrations + " migrations </h4><br>";
            content += "<h4> Total:  " + numberOfAdults + " adults </h4><br>";
            content += "<h4> Total:  " + numberOfChildren + " children </h4><br>";

            return content;
        }

        function getMarkerPopupContent(city, country, latitude, longitude) {
            reasons = [];
            fromMigrations = 0;
            toMigrations = 0;
            migrations.forEach(function (migration2) {
                if (migration2.departure_latitude ===latitude &&
                    migration2.departure_longitude === longitude) {
                    fromMigrations ++;
                }

                if (migration2.arrival_latitude === latitude &&
                    migration2.arrival_longitude === longitude) {
                    toMigrations ++;
                }

                if (reasons.indexOf(migration2.reason) < 0) {
                    reasons.push(migration2.reason);
                }

            });
            content1 = "<b> " + city + ", " + country + "</b> <br>";
            content1 += "<b>" + fromMigrations +" migrations started from here. </b><br>";
            content1 += "<b>" + toMigrations +" migrations finished here. </b>";

            content1 += "<br><b> Reasons: <ol>";

            reasons.forEach(function (reason) {
                content1 += "<li> <h6>" + reason + " </h6></li>";
            });

            content1 += "</ol></b>";
            return content1;
        }

        </script>
    </div>
@endsection