	var marker;
	function placeMarker(location) {
	  if ( marker ) {
	  		document.getElementById('lat').value = location.lat();
	  		document.getElementById('long').value = location.lng();
    		marker.setPosition(location);
  		} else {
  			document.getElementById('lat').value = location.lat();
  			document.getElementById('long').value = location.lng();
		    marker = new google.maps.Marker({
		      position: location,
		      map: map,
		      icon: '../img/icon.png'

		    });
  		}
  	infowindow.open(map,marker);
	}

	google.maps.event.addDomListener(window, 'load', initialize);
	window.onload = function() {

  new dgCidadesEstados({
    estado: document.getElementById('estado'),
    cidade: document.getElementById('cidade'),
     estadoVal: '<%=Request("estado") %>',
     cidadeVal: '<%=Request("cidade") %>'
  	});
	};
	