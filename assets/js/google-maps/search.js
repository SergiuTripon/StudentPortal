    //<![CDATA[
    var map;
    var markers = [];
    var infoWindow;
    var locationSelect;
    var type;

    function loadMap() {
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
    }

    function searchLocations() {

        var address = document.getElementById("addressInput").value;

        if(address === '') {
            $("label[for='addressInput']").empty().append("Please enter a address.");
            $("label[for='addressInput']").removeClass("feedback-happy");
            $("label[for='addressInput']").addClass("feedback-sad");
            $("#addressInput").css("cssText", "border-color: #D9534F");
            $("#addressInput").focus();
            return false;
        } else {
            $("label[for='addressInput']").empty().append("All good!");
            $("label[for='addressInput']").removeClass("feedback-sad");
            $("label[for='addressInput']").addClass("feedback-happy");
        }

        var geocoder = new google.maps.Geocoder();

        geocoder.geocode({address: address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                searchLocationsNear(results[0].geometry.location);
            } else {
            $("#error").empty().append(address + ' was not found. Please try again.');
         }
        });
    }

    function clearLocations() {
        infoWindow.close();
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }
        markers.length = 0;

        locationSelect.innerHTML = "";
        var option = document.createElement("option");
        option.value = "none";
        option.innerHTML = "See all results:";
        locationSelect.appendChild(option);
    }

    function searchLocationsNear(center) {
        clearLocations();

        var radius = document.getElementById('radiusSelect').value;
        var searchUrl = '../../includes/university-map/source/search_source.php?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius;

        downloadUrl(searchUrl, function(data) {
            var xml = parseXml(data);
            var markerNodes = xml.documentElement.getElementsByTagName("marker");
            var bounds = new google.maps.LatLngBounds();

            for (var i = 0; i < markerNodes.length; i++) {
                var name = markerNodes[i].getAttribute("name");
                var description = markerNodes[i].getAttribute("description");
                var distance = parseFloat(markerNodes[i].getAttribute("distance"));
                var latlng = new google.maps.LatLng(
                parseFloat(markerNodes[i].getAttribute("lat")),
                parseFloat(markerNodes[i].getAttribute("lng")));

                createOption(name, distance, i);
                createMarker(latlng, name, description);
                bounds.extend(latlng);
            }

        map.fitBounds(bounds);
        locationSelect.style.display = "block";
        locationSelect.onchange = function() {
            var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
            google.maps.event.trigger(markers[markerNum], 'click');
        };
    });
    }

    function createMarker(latlng, name, address) {
        var html = "<b>" + name + "</b> <br/>" + address;

        var marker = new google.maps.Marker({
            map: map,
            position: latlng,
            animation: google.maps.Animation.DROP
        });

        google.maps.event.addListener(marker, 'click', function() {
            infoWindow.setContent(html);
            infoWindow.open(map, marker);
        });

        markers.push(marker);
    }

    function createOption(name, distance, num) {
        var option = document.createElement("option");
        option.value = num;
        option.innerHTML = name + " " + "(" + distance.toFixed(1) + ")";
        locationSelect.appendChild(option);
    }

    function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                request.onreadystatechange = doNothing;
                callback(request.responseText, request.status);
            }
        };

        request.open('GET', url, true);
        request.send(null);
    }

    function parseXml(str) {
        if (window.ActiveXObject) {
            var doc = new ActiveXObject('Microsoft.XMLDOM');
            doc.loadXML(str);
            return doc;
        } else if (window.DOMParser) {
            return (new DOMParser).parseFromString(str, 'text/xml');
        }
    }

    function doNothing() {}
    //]]>