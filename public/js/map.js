var map, mapMobile;
var mapLoaded = false, mapMobileLoaded = false;
var mapVisible = false, mapMobileVisible = false;
var markers = [];
var bound;

function initMap() {
	if (!mapLoaded) {
		calculateBound();
		map = new google.maps.Map(document.getElementById('map'), {
			center: bound.getCenter(),
		    zoom: 16
		});
	}
  mapLoaded = true;
}

function initMapMobile(){
	if (!mapMobileLoaded) {
		calculateBound();
		mapMobile = new google.maps.Map(document.getElementById('mapMobile'), {
		    center: bound.getCenter(),
		    zoom: 16
		  });

	}
	mapMobileLoaded = true;
}

function getDomain() {
    var url = window.location.href;
    var arr = url.split("/");
    var result = arr[0] + "//" + arr[2];
    return result;
}

function toggleMap(){
	if (mapVisible){
		$("#map").fadeOut();
		$("#businesses").fadeIn();
		$("#toggleMap").val("Show on Map");
		mapVisible = false;
	} else{
		$("#businesses").fadeOut();
		$("#map").fadeIn();
		initMap();
		$("#toggleMap").val("Show on List");
		mapVisible = true;
		refreshMap();
	}
}

function toggleMapMobile(){
	if (mapMobileVisible){
		$("#mapMobile").fadeOut();
		$("#businessesMobile").fadeIn();
		$("#toggleMapMobile").text("Show on Map");
		mapMobileVisible = false;
	} else{
		$("#businessesMobile").fadeOut();
		$("#mapMobile").fadeIn();
		initMapMobile();
		$("#toggleMapMobile").text("Show on List");
		mapMobileVisible = true;
		refreshMap();
	}
}

function refreshMap(){
	calculateBound();
	deleteMarkers();
	loadMarkers();
	if (mapVisible)
		showMarkersOnMap(map);
	else if (mapMobileVisible)
		showMarkersOnMap(mapMobile);
}

function loadMarkers(){
	businesses.forEach(function(b){
		addMarker(b);
	});
}

// Adds a marker to the map and push to the array.
function addMarker(business) {
	var image = getDomain() + '/Images/marker.png';
	var marker = new google.maps.Marker({
		position: business,
		icon: image
	});
	marker.addListener('click', function(){
		iw = createInfoWindow(business);
		if (mapVisible)
			iw.open(map, marker);
		else if (mapMobileVisible)
			iw.open(mapMobile, marker);
	});
	markers.push(marker);
}

// Sets the map on all markers in the array.
function showMarkersOnMap(m) {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(m);
  }

  if (m == null)
  	return;
  m.setCenter(bound.getCenter());
  m.fitBounds(bound);

}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
  showMarkersOnMap(null);
}


// Deletes all markers in the array by removing references to them.
function deleteMarkers() {
  clearMarkers();
  markers = [];
}

function createInfoWindow(business){
	var contentString = '<div class="infoContent">'+
      '<div class="siteNotice">'+
      '</div>'+
      '<h3 class="firstHeading">' + business.name + '</h3>'+
      '<div id="bodyContent">'+
      '<h4>' + business.address + '&nbsp;' + business.city + '&nbsp;' + business.state + '</h4>'+
      '<a href="tel: ' + business.phone + '">Call ' + business.phone + '</a>'+ '<br/>' + 
      '<a href="http://www.google.com/maps/dir/' + zip + '/' + business.address + ' ' + business.city + ',' + business.state + ' ' + business.zipcode + '" target="blank">Show direction to : ' + business.name + '</a>'+ '<br/>' + 
      '</div>'+
      '</div>';
    var infoWindows = new google.maps.InfoWindow({
    	content: contentString,
    	maxWidth: 300
    });
    return infoWindows;
}

function calculateBound(){
	if (businesses.length == 0)
		return;
	bound = new google.maps.LatLngBounds();

	businesses.forEach(function(b){
		loc = new google.maps.LatLng(b.lat, b.lng);
		bound.extend(loc);
	});

}