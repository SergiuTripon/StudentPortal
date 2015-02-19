	var timeOut;
	function reset() {
    window.clearTimeout(timeOut);
    timeOut = window.setTimeout( "redir()" , 900000 );
	}
	function redir() {
    window.location = "../../../sign-out-inactive.php";
	}
	window.onload = function() {
        setTimeout("redir()" , 900000)
        map = new google.maps.Map(document.getElementById("map"), {
            center: new google.maps.LatLng(51.527287, -0.103842),
            zoom: 15,
            navigationControl: false,
            mapTypeControl: false,
            scaleControl: false,
            draggable: false,
            mapTypeId: 'roadmap',
            mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
        });

        infoWindow = new google.maps.InfoWindow({
            maxWidth: 400
        });

        locationSelect = document.getElementById("locationSelect");
        locationSelect.onchange = function() {
            var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
            if (markerNum != "none") {
                google.maps.event.trigger(markers[markerNum], 'click');
            }
        };
    };
	window.onmousemove = reset;
	window.onkeypress = reset;
