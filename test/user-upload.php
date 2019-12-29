

<!DOCTYPE html>
<html>
<body>
<div id="googleMap" style="width:100%;height:400px;"></div>

<script>
function myMap() {
    var mapProp= {
        center:new google.maps.LatLng(51.508742,-0.120850),
    zoom:5,
};
var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

    var marker = new google.maps.Marker({
        map: map
    });
google.maps.event.addListener(map, 'click', function(event) {
    alert(event.latLng.lat() + ", " + event.latLng.lng());
   marker.setPosition(new google.maps.LatLng(event.latLng.lat(), event.latLng.lng()));
});

}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5mxGd95ZhKT0365IvmBGuY4QEQB3DF3s&callback=myMap"></script>
</body>
</html>