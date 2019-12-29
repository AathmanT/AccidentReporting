var map;

function loadMap() {

	var pune = {lat: 7.8763691177503175, lng: 80.6312089953883};
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 7,
      center: pune
    });

    // var marker = new google.maps.Marker({
    //   position: pune,
    //   map: map
    // });

    // var cdata = JSON.parse(document.getElementById('data').innerHTML);
    // geocoder = new google.maps.Geocoder();
    // codeAddress(cdata);

    var allData = JSON.parse(document.getElementById('allData').innerHTML);
    showAllColleges(allData)
}

function showAllColleges(allData) {
	var infoWind = new google.maps.InfoWindow;
	Array.prototype.forEach.call(allData, function(data){
		var content = document.createElement('div');
		var strong = document.createElement('h1');
		var description = document.createElement('strong');
		description.textContent = data.Description;

		strong.textContent = data.nameOfPlace;
		content.appendChild(strong);
        content.appendChild(description);

		var img = document.createElement('img');
		img.src = 'data:image/png;base64,' + data.image;
		img.style.width = '100px';
		content.appendChild(img);


		var marker = new google.maps.Marker({
	      position: new google.maps.LatLng(data.lat, data.lng),
	      map: map
	    });

	    marker.addListener('mouseover', function(){
	    	infoWind.setContent(content);
	    	infoWind.open(map, marker);
	    })
	})
}

