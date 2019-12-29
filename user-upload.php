<!DOCTYPE html>
<html>
<head>
    <title>Access Google Maps API in PHP</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/googlemap.js"></script>
    <style type="text/css">

        .list-group {
            max-height: 80vh;
            margin-bottom: 10px;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }

        .card {
            width: 100%;
        }

        .nopadding {
            padding: 0 !important;
            margin: 0 !important;
        }

        #map {
            width: 100%;
            height: 100%;
            border: 1px solid blue;
        }

        #data, #allData {
            display: none;
        }

    </style>


</head>
<body>




<div class="container-fluid">
    <div style="text-align: center;"><h1>Upload Accident data</h1></div>

    <div class="row">
        <form class="col-4" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="exampleInputEmail1">License No</label>
                <input type="text" class="form-control" name="licenseNo" required  aria-describedby="emailHelp" placeholder="License No">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Name of Place</label>
                <input type="text" name="place" required class="form-control"  placeholder="Name of Place">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Description</label>
                <textarea class="form-control" name="description" required  placeholder="Description"></textarea>
            </div>
            <div class="form-group">
                <input type="file" name="image">
            </div>
            <input type="hidden" id="lat" name="lat">
            <input type="hidden" id="lng" name="lng">
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>

        <div class="col-8">
            <div id="map"></div>
        </div>

    </div>
</div>

</body>
<script>

    function myMap() {
        var mapProp= {
            center:new google.maps.LatLng(7.8763691177503175, 80.6312089953883),
            zoom:7,
        };
        var map=new google.maps.Map(document.getElementById("map"),mapProp);

        var marker = new google.maps.Marker({
            map: map
        });

        var lat = document.getElementById("lat");
        var lng = document.getElementById("lng");

        google.maps.event.addListener(map, 'click', function(event) {
            alert(event.latLng.lat() + ", " + event.latLng.lng());
            lat.value = event.latLng.lat();
            lng.value = event.latLng.lng();
            marker.setPosition(new google.maps.LatLng(event.latLng.lat(), event.latLng.lng()));
        });

    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5mxGd95ZhKT0365IvmBGuY4QEQB3DF3s&callback=myMap"></script>
</html>


<?php

if (isset($_POST['submit'])) {
    if (getimagesize($_FILES['image']['tmp_name']) == FALSE) {
        echo 'failed';
    } else {
        $name = addslashes($_FILES['image']['name']);
        $image = base64_encode(file_get_contents(addslashes($_FILES['image']['tmp_name'])));
        $licenseno = $_POST['licenseNo'];
        $nameofplace = $_POST['place'];
        $description = $_POST['description'];
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];
//        echo $licenseno.$nameofplace.$description.$lat.$lng;
//        echo "<script>alert('".$nameofplace."');</script>";
        save_data($name, $image,$licenseno,$nameofplace,$description,$lat,$lng);
    }
}

function save_data($name, $image,$licenseno,$nameofplace,$description,$lat,$lng)
{
    $mysqli = new mysqli('localhost', 'root', '', 'accidentreporter');
    if ($mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
    }
    if (!$mysqli -> query("insert into reports(licenseno,nameofplace,description,lat,lng,time,imagename,image) values('$licenseno','$nameofplace','$description','$lat','$lng',NOW(),'$name','$image')")) {
        echo("Error description: " . $mysqli -> error);
    }
    $mysqli -> close();
}
