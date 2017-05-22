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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-polylinedecorator/1.1.0/leaflet.polylineDecorator.js">
        </script>
        <script>
            var mymap = L.map('demoMap').setView([0,0], 2);
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
                pointA = new L.LatLng(migration.departure_latitude, migration.departure_longitude);
                pointB = new L.LatLng(migration.arrival_latitude, migration.arrival_longitude);

                polylinePoints = [pointA,pointB];

                var polylineOptions = {
                    color: 'blue',
                    weight: 1,
                    opacity: 0.3
                };

                var polyline = new L.Polyline(polylinePoints, polylineOptions);
                mymap.addLayer(polyline);

                L.polylineDecorator(polyline,{
                    patterns: [
                        // define a pattern of 10px-wide dashes, repeated every 20px on the line
                        {
                            offset: '100%', repeat:0, symbol: new L.Symbol.arrowHead({pixelSize: 8,pathOptions: {fillOpacity:
                            0.5,weight: 0.5}})}
                    ]}).addTo(mymap);
            })


        </script>
    </div>