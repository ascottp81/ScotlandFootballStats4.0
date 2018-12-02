<!DOCTYPE html>
<html lang="en"><head><style type="text/css">.gm-style .gm-style-mtc label,.gm-style .gm-style-mtc div{font-weight:400}
</style><link type="text/css" rel="stylesheet" href="christmas_files/css.css"><style type="text/css">.gm-style .gm-style-cc span,.gm-style .gm-style-cc a,.gm-style .gm-style-mtc div{font-size:10px}
</style><style type="text/css">@media print {  .gm-style .gmnoprint, .gmnoprint {    display:none  }}@media screen {  .gm-style .gmnoscreen, .gmnoscreen {    display:none  }}</style><style type="text/css">.gm-style-pbc{transition:opacity ease-in-out;background-color:rgba(0,0,0,0.45);text-align:center}.gm-style-pbt{font-size:22px;color:white;font-family:Roboto,Arial,sans-serif;position:relative;margin:0;top:50%;-webkit-transform:translateY(-50%);-ms-transform:translateY(-50%);transform:translateY(-50%)}
</style>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">

            <style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 500px;
            width: 1000px;
            border: solid 2px #000000;
            float: left;
        }
        .info, .rules {
            float: left;
            padding-left: 20px;
            font: normal bold normal 18px Arial;
            width: calc(50% - 40px);
        }
        h1 {
            font: normal bold normal 24px Arial;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
            height: calc(100% - 40px);
            margin: 0;
            padding: 20px;
        }
    </style>

<h1>12 Pubs of Christmas 2018</h1>
<div id="map"></div>
<div class="info">
    <h2>Pubs</h2>
    <p>1. Shark Bar - 5:30 pm</p>
    <p>2. The Bodega - 6:30 pm</p>
    <p>3. Tilleys - 7:30 pm</p>
    <p>4. Rafferty's - 8:00 pm</p>
    <p>5. The Forth - 8:30 pm</p>
    <p>6. The Town Wall - 9:00 pm</p>
    <p>7. The Victoria Comet - 9:30 pm</p>
    <p>8. The Centurion - 10:00 pm</p>
    <p>9. Science Bar - 10:30 pm</p>
    <p>10. Newcastle Tap - 11:00 pm</p>
    <p>11. Head of Steam - 11:30 pm</p>
    <p>12. The Union Rooms - 12:00 am</p>
</div>
<div class="rules">
    <h2>Rules</h2>
    <p>1. A strict time limit will be enforced of 30 mins per establishment.</p>
    <p>2. At least ONE alcoholic beverage per venue.</p>
    <p>3. Festive attire must be worn at all times.</p>
    <p>4. Any rule can be made up, which the party must adhere to.</p>
    <p>5. If an Xmas song is played in any venue, dancing is mandatory.</p>
    <p>6. There must be at least one quality photo taken of the entire group.</p>
    <p>7. A penalty shot will be enforced if movement between pubs is too slow.</p>
    <p>8. Have fun.</p>
    <p>9. Be loud.</p>
    <p>10. Get a festive bake.</p>
    <p>11. Request Xmas songs and sing.</p>
</div>




    <script>
    var map;
    var markers;

    // data obtained from backend
    var locations = [];

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            center: {lat: 54.971097, lng: -1.617053 }
        });

        // obtain data from back end
        loadData();

        // draw markers
        drawMarkers();
    }


    function drawMarkers() {

        // Add in predetermined locations
        markers = locations.map(function(location, i) {
            var marker = new google.maps.Marker({
                id: location.id,
                position: location.location,
                map: map,
                icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=' + location.id + '|FF0000|FFFFFF'
            });

            var infowindow = new google.maps.InfoWindow({
                content: locations[i].details
            });

            marker.addListener('click', function() {
                infowindow.open(map, marker);
            });
        });

        return markers;
    }


    function loadData() {

        // obtain the incident markers
        locations = [
            {
                "id": 1,
                "location": {
                    "lat": 54.973618,
                    "lng": -1.622000
                },
                "details": "<h3>1. Shark Bar<\/h3><p>5:30 pm<\/p>Gallowgate, Newcastle upon Tyne NE1 4BT"
            },
    {
        "id": 2,
        "location": {
            "lat": 54.970611,
            "lng": -1.62135
        },
        "details": "<h3>2. The Bodega<\/h3><p>6:00 pm<\/p>125 Westgate Rd, Newcastle upon Tyne NE1 4AG"
    },
    {
        "id": 3,
        "location": {
            "lat": 54.970488,
            "lng": -1.620567
        },
        "details": "<h3>3. Tilleys<\/h3><p>7:00 pm<\/p>105 Westgate Rd, Newcastle upon Tyne NE1 4AF"
    },
    {
        "id": 4,
        "location": {
            "lat": 54.96972,
            "lng": -1.618837
        },
        "details": "<h3>4. Rafferty's<\/h3><p>7:30 pm<\/p>29-31 Pink Ln, Newcastle upon Tyne NE1 5DW"
    },
    {
        "id": 5,
        "location": {
            "lat": 54.969595,
            "lng": -1.618384
        },
        "details": "<h3>5. The Forth<\/h3><p>8:00 pm<\/p>Pink Ln, Newcastle upon Tyne NE1 5DW"
    },
    {
        "id": 6,
        "location": {
            "lat": 54.969418,
            "lng": -1.618438
        },
        "details": "<h3>6. The Town Wall<\/h3><p>8:30 pm<\/p>Pink Ln, Newcastle upon Tyne NE1 5HX"
    },
    {
        "id": 7,
        "location": {
            "lat": 54.969356,
            "lng": -1.617448
        },
        "details": "<h3>7. The Victoria Comet<\/h3><p>9:00 pm<\/p>38 Neville St, Newcastle upon Tyne NE1 5DF"
    },
    {
        "id": 8,
        "location": {
            "lat": 54.969035,
            "lng": -1.61639
        },
        "details": "<h3>8. The Centurion<\/h3><p>9:30 pm<\/p>Central Station, Neville Street, Newcastle upon Tyne NE1 5DG"
    },
    {
        "id": 9,
        "location": {
            "lat": 54.969166,
            "lng": -1.615813
        },
        "details": "<h3>9. Science Bar<\/h3><p>10:00 pm<\/p>Neville St, Newcastle upon Tyne NE1 5DH"
    },
    {
        "id": 10,
        "location": {
            "lat": 54.969506,
            "lng": -1.615714
        },
        "details": "<h3>10. Newcastle Tap<\/h3><p>10:30 pm<\/p>8 Neville St, Newcastle upon Tyne NE1 5EN"
    },
    {
        "id": 11,
        "location": {
            "lat": 54.969521,
            "lng": -1.615553
        },
        "details": "<h3>11. Head of Steam<\/h3><p>11:00 pm<\/p>2 Neville St, Newcastle upon Tyne NE1 5EN"
    },
    {
        "id": 12,
        "location": {
            "lat": 54.969906,
            "lng": -1.61493
        },
        "details": "<h3>12. The Union Rooms<\/h3><p>11:30 pm<\/p>48 Westgate Rd, Newcastle upon Tyne NE1 1TT"
    }
];

    }

    </script>

    <!-- Test Key -->
    <script src="https://maps.googleapis.com/maps/api/js?key=&libraries=drawing,places&callback=initMap"></script>


</body></html>