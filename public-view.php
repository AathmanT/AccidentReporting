<!DOCTYPE html>
<html>
<head>
    <title>Access Google Maps API in PHP</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/googlemap.js"></script>
    <style type="text/css">

        .list-group {
            max-height: 90vh;
            margin-bottom: 10px;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }

        .card {
            width: 100%;
            border-width: thin;
            border-color: #1b1e21;
        }
        .row{
            padding: 15px;
            padding-bottom: 10px;
            text-align: center;
        }

        .image-custom{

        }

        .nopadding {
            padding: 0 !important;
            margin: 0 !important;
        }

        #map {
            width: 100%;
            height: 90vh;
            border: 1px solid blue;
        }

        #allData {
            display: none;
        }

    </style>
</head>
<body>
<div class="container-fluid">
    <div style="text-align: center;"><h1>Public view</h1></div>
    <?php
    require 'education.php';
    $edu = new education;

    $allData = $edu->getAllPublicView();
    if(count($allData)){
        $allData = json_encode($allData, true);
        echo '<div id="allData">' . $allData . '</div>
        <div class="row">
        <ul class="list-group col-4">'.

           $edu->publicDisplay()

        .'</ul>
        <div class="col-8">
            <div id="map"></div>
        </div>

    </div>';
    }else{
        echo "No pending requests";
    }

    ?>

</div>

</body>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5mxGd95ZhKT0365IvmBGuY4QEQB3DF3s&callback=loadMap">
</script>
</html>







