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
    <script src="{{asset('js/getCountryCode.js')}}"></script>
    <script src="{{asset('js/Leaflet.CountrySelect.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/L.Control.Sidebar.css')}}">
    <link rel="stylesheet" href="{{asset('css/easy-button.css')}}">
    <script src="{{asset('js/easy-button.js')}}"></script>
@endsection

@section('content')
    <script type="text/javascript">
        var recentURI = "{{ route('recent')}}";
        var allURI = "{{ route('all')}}";
        var importantURI = "{{ route('important')}}";
    </script>
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
            var markers = [];

            var sidebar = L.control.sidebar('sidebar', {
                position: 'left',
                closeButton: 'true',
            });

            var select = L.countrySelect().addTo(mymap);
            select.on('change', function(e){
                if(e.feature === undefined || e.feature === 'Country'){ //No action when the first item ("Country") is selected
                    loadMigration(recentURI);
                    return;
                }
                var country = L.geoJson(e.feature);
                if (this.previousCountry != null){
                    mymap.removeLayer(this.previousCountry);
                }
                this.previousCountry = country;
                countryCode = getCountryCode(e.feature.properties.name);

                request = null;
                if (window.XMLHttpRequest) {
                    request = new XMLHttpRequest ();
                } else
                if (window.ActiveXObject) {
                    request = new ActiveXObject ("Microsoft.XMLHTTP");
                }
                if (request) {
                    request.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            migrations =  JSON.parse(this.responseText);
                            polylines.forEach(function (p1) {
                                mymap.removeLayer(p1);
                            });
                            markers.forEach(function (m1) {
                                mymap.removeLayer(m1);
                            });
                            addMigrationsToMap(migrations);
                        }
                    };
                }

                var countryURI = "{{ route('country')}}";
                countryURI += "-migrations/" + countryCode;
                console.log(countryCode);
                request.open ("GET", countryURI, true);
                request.send (null);

                mymap.fitBounds(country.getBounds());
//                sidebar.show();
            });


            mymap.addControl(sidebar);


            var migrations = {!! json_encode($migrations->toArray()) !!};
            var polylineOptions;

            addMigrationsToMap(migrations);


            L.easyButton('fa-globe', function(btn, map){
                polylines.forEach(function (p1) {
                    mymap.removeLayer(p1);
                });
                markers.forEach(function (m1) {
                    mymap.removeLayer(m1);
                });
                mymap.removeLayer(btn);
                loadMigration(allURI);
            }).addTo( mymap );

            L.easyButton('fa-newspaper-o', function(btn, map){
                polylines.forEach(function (p1) {
                    mymap.removeLayer(p1);
                });
                markers.forEach(function (m1) {
                    mymap.removeLayer(m1);
                });
                mymap.removeLayer(btn);
                loadMigration(recentURI);
            }).addTo( mymap );

            L.easyButton('fa-exclamation-circle', function(btn, map) {
                polylines.forEach(function (p1) {
                    mymap.removeLayer(p1);
                });
                markers.forEach(function (m1) {
                    mymap.removeLayer(m1);
                });
                mymap.removeLayer(btn);
                loadMigration(importantURI);
            }).addTo( mymap );




            HTMLButton1 = document.getElementsByClassName("fa-newspaper-o");
            HTMLButton1[0].setAttribute("title", "See most recent migrations.");
            HTMLButton2 = document.getElementsByClassName("fa-globe");
            HTMLButton2[0].setAttribute("title", "See all migrations.");
            HTMLButton3 = document.getElementsByClassName("fa-exclamation-circle");
            HTMLButton3[0].setAttribute("title", "See most important migrations.");


        function addMigrationsToMap(migrations) {
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

                markers.push(marker1);
                markers.push(marker2);

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


                L.polylineDecorator(polyline,{patterns: []}).addTo(mymap);
                sidebar.on('hidden', function () {
                    polylines.forEach(function (polyline2) {
                        polyline2.setStyle(polylineOptions);
                    });
                });

            });

        }

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
                        "<li class = \"list-group-item list-group-item-warning\"> Author: <b>" + username + "</b> </li>" +
                        "<li class = \"list-group-item list-group-item-warning\"> Date: <b>" + migration2.created_at + "</b> </li>" +
                        "<li class = \"list-group-item list-group-item-warning\"> Number of adults: <b>" + migration2.adults + "</b></li>" +
                        "<li class = \"list-group-item list-group-item-warning\"> Number of children: <b>" + migration2.children + "</b></li>" +
                        "<li class = \"list-group-item list-group-item-warning\"> Reason: <b>" + migration2.reason + "</b></li>";
                    content += "</ul><br>";

                    if (reasons.indexOf(migration2.reason) < 0) {
                        reasons.push(migration2.reason);
                    }
                }
            });
            content += "<hr><h4> Reasons: <ol class=\"list-group\">";

            reasons.forEach(function (reason) {
                content += "<li class=\"list-group-item list-group-item-danger\"> <h5>" + reason + " </h5></li>";
            });
            content += "</ol></h4>";

            content += "<hr><h4> Total: <ol class=\"list-group\">";


            content += "<li class = \"list-group-item list-group-item-info\"> " +numberOfMigrations + " migrations </li><br>";
            content += "<li class = \"list-group-item list-group-item-info\"> " +numberOfAdults + " adults </li><br>";
            content += "<li class = \"list-group-item list-group-item-info\"> " + numberOfChildren + " children </li><br>";
            content += "</ol></h4>";

            return content;
        }

        function loadMigration(migrationURI) {
            request = null;
            if (window.XMLHttpRequest) {
                request = new XMLHttpRequest ();
            } else
            if (window.ActiveXObject) {
                request = new ActiveXObject ("Microsoft.XMLHTTP");
            }
            if (request) {
                request.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        migrations =  JSON.parse(this.responseText);
                        addMigrationsToMap(migrations);
                    }
                };
            }
            request.open ("GET", migrationURI, true);
            request.send (null);
        }

        function getMarkerPopupContent(city, country, latitude, longitude) {
            reasons = [];
            fromMigrations = 0;
            toMigrations = 0;
            migrations.forEach(function (migration2) {
                if (migration2.departure_latitude ===latitude &&
                    migration2.departure_longitude === longitude) {
                    if (reasons.indexOf(migration2.reason) < 0) {
                        reasons.push(migration2.reason);
                    }
                    fromMigrations ++;
                }

                if (migration2.arrival_latitude === latitude &&
                    migration2.arrival_longitude === longitude) {
                    if (reasons.indexOf(migration2.reason) < 0) {
                        reasons.push(migration2.reason);
                    }
                    toMigrations ++;
                }
            });
            content1 = "<b> " + city + ", " + country + "</b> <br>";
            content1 += "<b>" + fromMigrations +" migrations started from here. </b><br>";
            content1 += "<b>" + toMigrations +" migrations finished here. </b>";

            content1 += "<hr><b> Reasons: <ol class=\"list-group\">";

            reasons.forEach(function (reason) {
                content1 += "<li> <h5>" + reason + " </h5></li>";
            });
            content1 += "</ol></b>";
            return content1;
        }

        </script>
    </div>
@endsection