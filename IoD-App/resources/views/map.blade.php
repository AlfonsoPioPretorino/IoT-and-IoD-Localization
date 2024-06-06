@extends('layouts.master')
@section('content')
<head>
    <title>Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
</head>
    <div class="container text-center text-white mt-5 mb-5" id="url" data-url="{{env('APP_URL')}}">
        <h1 class="display-3">Real-time Map Session {{ Session::get('ID-session') }}</h1>
    </div>
    <div class="row text-right mb-3">
        <div class="col text-center">
            <span id="icon_dang" data-tooltip="The position is computed by performin an approximation that we are not sure about. Please use it with responsability." data-tooltip-position="top" style="visibility: hidden; margin-top: 70px; font-size: 40px; color: white">
                &#9888;
            </span>
        </div>
    </div>
        <div id="map" style="height: 500px;"></div>
        <div class="text-center">
            <button id="hide" class="btn btn-warning mt-3 mb-5">Hide signal radius</button>
            <button id="update" class="btn btn-danger mt-3 mb-5">update</button>

        </div>
        
        <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xs-8">
                <div class="card o-bg-card" style="text-align: center;border-radius:1rem; box-shadow: 0 1rem 1rem 0 rgba(0, 0, 0, 0.1);">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row mt-2">
                            <div class="col">
                                <h1>Device Coordinates</h1>
                                
                            </div>
                        </div>
                        <div class="row mt-5 mb-3">
                            <div class="col">
                                <h4>Gateway 1</h4>
                            </div>
                        </div>
                        <div class="row justify-content-md-center">
                            <div class="col"></div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Latitude</span>
                                    <input class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{json_decode($session->g1)->g1la}}" disabled>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Longitude</span>
                                    <input class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{json_decode($session->g1)->g1lo}}" disabled>
                                </div>
                            </div>
                            <div class="col"></div>
                        </div>
                        
                        <div class="row mt-5 mb-3">
                            <div class="col">
                                <h4>Gateway 2</h4>
                            </div>
                        </div>
                        <div class="row justify-content-md-center">
                            <div class="col"></div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Latitude</span>
                                    <input type="text" name="g2la" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{json_decode($session->g2)->g2la}}" disabled>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Longitude</span>
                                    <input type="text" name="g2lo" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{json_decode($session->g2)->g2lo}}" disabled>
                                </div>
                            </div>
                            <div class="col"></div>
                        </div>

                        <div class="row mt-5 mb-3">
                            <div class="col">
                                <h4>Gateway 3</h4>
                            </div>
                        </div>
                        <div class="row justify-content-md-center">
                            <div class="col"></div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Latitude</span>
                                    <input type="text" name="g3la" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{json_decode($session->g3)->g3la}}" disabled>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Longitude</span>
                                    <input type="text" name="g3lo" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{json_decode($session->g3)->g3lo}}" disabled>
                                </div>
                            </div>
                            <div class="col"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/jquery.min.js" integrity="sha512-tWHlutFnuG0C6nQRlpvrEhE4QpkG1nn2MOUMWmUeRePl4e3Aki0VB6W1v3oLjFtd0hVOtRQ9PHpSfN6u6/QXkQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
crossorigin=""></script>
<script>
    var url = document.getElementById("url").getAttribute('data-url');
    var icon_dang = document.getElementById("icon_dang");

    var coordG1 = [{{json_decode($session->g1)->g1la}}, {{json_decode($session->g1)->g1lo}}]
    var coordG2 = [{{json_decode($session->g2)->g2la}}, {{json_decode($session->g2)->g2lo}}]
    var coordG3 = [{{json_decode($session->g3)->g3la}}, {{json_decode($session->g3)->g3lo}}]
    var range = 1000; //In meters

    //Computing the middle of the given 3 gatways in order to center the map on them
    let zoom = [];
    zoom[0] = (coordG1[0] + coordG2[0] + coordG3[0])/3
    zoom[1] = (coordG1[1] + coordG2[1] + coordG3[1])/3

    var hidden = false;
    var gateawy_icon_path = "{{asset('/img/7021857.png')}}"
    var drone_icon_path = "{{asset('/img/drone_icon.png')}}"
    var pin_icon_path = "{{asset('/img/pin.png')}}"


    var map = L.map('map').setView(zoom, 14);
    
    var gatewayIcon = L.icon({
    iconUrl: gateawy_icon_path,
    iconSize: [38, 38],
    shadowSize: [68, 95],
    });

    var droneIcon = L.icon({
    iconUrl: drone_icon_path,
    iconSize: [50, 50],
    shadowSize: [68, 95],
    });

    var pinIcon = L.icon({
    iconUrl: pin_icon_path,
    iconSize: [50, 50],
    shadowSize: [68, 95],
    });

    var real_pos_icon = L.icon({
    iconUrl: pin_icon_path,
    iconSize: [50, 50],
    shadowSize: [68, 95],
    });


    
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);


    var markergroup = L.featureGroup();
    var gMark1 = L.marker(coordG1, {icon: gatewayIcon}).addTo(markergroup);
    var gMark2 = L.marker(coordG2, {icon: gatewayIcon}).addTo(markergroup);
    var gMark3 = L.marker(coordG3, {icon: gatewayIcon}).addTo(markergroup);
    var dron = L.marker(coordG3, {icon: droneIcon}).addTo(markergroup);
    map.addLayer(markergroup);

    var circlegroup = L.featureGroup();
    var circle1 = L.circle(coordG1, {radius: range, wieght: 1.5}).addTo(circlegroup);
    var circle2 = L.circle(coordG2, {radius: range, wieght: 1.5}).addTo(circlegroup);
    var circle2 = L.circle(coordG3, {radius: range, wieght: 1.5}).addTo(circlegroup);
    map.addLayer(circlegroup);


    var button = document.getElementById("hide");
    button.addEventListener("click", function(event){
        if(hidden){
            map.addLayer(circlegroup);
            button.innerHTML = "Hide signal radius"
            button.className = "btn btn-warning mt-3 mb-5"
            hidden = false;
        }else{
            map.removeLayer(circlegroup);
            button.innerHTML = "Show signal radius"
            button.className = "btn btn-primary mt-3 mb-5"
            hidden = true;
        }
    });

    var btnupdate = document.getElementById("update");
    btnupdate.addEventListener("click", function(event){
        dron.setLatLng(['41.115980', '16.873320']).update()
    });

    var test;
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = false;
    var pusher = new Pusher('3353b346c4d43987a0cb', {
      cluster: 'eu'
    });

    /* var channel = pusher.subscribe('packetchannel');
    channel.bind('lat', function(data) {
        dron.setLatLng([data.latitude, data.longitude]).update()
    }); */
    var count = 0;
    var packetslat = []
    var packetslong = []
    var distances = [] 
    
    var real_pos_marker;

    //!
    var channel = pusher.subscribe('packetchannel');
    channel.bind('lat', function(data) {
        console.log(data);
        real_pos_marker = L.marker(data.real_coord, {icon: real_pos_icon});
        count++;
        console.log('listen');
        switch(data.id) {
            case 111:
                distances[0] = data.distance;
                console.log('G1 '+data.distance);
                break;
            case 222:
                distances[1] = data.distance;
                console.log('G2 '+data.distance);
                break;
            case 333:
                distances[2] = data.distance;
                console.log('G3 '+data.distance);
            }
        //Perform a POST request to compute the triangulation
        if(count == 3){
            console.log('TRIANGOLO');
            const body = {
                coordG1: coordG1,
                coordG2: coordG2,
                coordG3: coordG3,
                dist1: distances[0],
                dist2: distances[1],
                dist3: distances[2],
            };
            distances[0] = 0;
            distances[1] = 0;
            distances[2] = 0;
            $.ajax({ 
                type: "POST",
                url: url+'/api/triangulation',
                data: body,
                success: function(data){
                    console.log(data);
                    let new_coord = data[0].split(" ");
                    real_pos_marker.addTo(markergroup);
                    dron.setLatLng([new_coord[0], new_coord[1]]).update()
                    map.setView([new_coord[0], new_coord[1]],16);
                    try{
                        var err = data[1];
                        icon_dang.style.visibility = 'visible';
                        console.log('negativo');
                    }catch(error){
                        icon_dang.style.visibility = 'hidden';
                    }
                },
                error: function(err){
                    console.log(err);
                }
            });
            count = 0;
        }

    });

    function test(d1, d2, d3){
        const body = {
                coordG1: [41.1093328, 16.8827114],
                coordG2: [41.1090086, 16.8803097],
                coordG3: [41.1083551, 16.8816768],
                dist1: d1,
                dist2: d2,
                dist3: d3,
            };

            $.ajax({ 
                type: "POST",
                url: url+'/api/triangulation',
                data: body,
                success: function(data){
                    let new_coord = data[0].split(" ");
                    console.log(new_coord);

                    dron.setLatLng([new_coord[0], new_coord[1]]).update()
                    map.setView([new_coord[0], new_coord[1]],16);
                    try{
                        var err = data[1];
                        icon_dang.style.visibility = 'visible';
                        console.log('negativo');
                    }catch(error){
                        icon_dang.style.visibility = 'hidden';
                    }
                },
                error: function(err){
                    console.log(err);
                }
            });
    }





</script>

@endsection