    var customIcons = {
    building: {
        icon: 'https://student-portal.co.uk/assets/img/university-map/building_icon.png'
    },
    student_centre: {
        icon: 'https://student-portal.co.uk/assets/img/university-map/student_centre_icon.png'
    },
    lecture_theatre: {
        icon: 'https://student-portal.co.uk/assets/img/university-map/lecture_theatre_icon.png'
    },
    computer_lab: {
        icon: 'https://student-portal.co.uk/assets/img/university-map/computer_lab_icon.png'
    },
    library: {
        icon: 'https://student-portal.co.uk/assets/img/university-map/library_icon.png'
    },
    cycle_hire: {
        icon: 'https://student-portal.co.uk/assets/img/university-map/cycle_hire_icon.png'
    },
    cycle_parking: {
        icon: 'https://student-portal.co.uk/assets/img/university-map/cycle_parking_icon.png'
    },
    atm: {
        icon: 'https://student-portal.co.uk/assets/img/university-map/atm_icon.png'
    }
    };


    var map;
    var markers = [];
    var infoWindow;
    var locationSelect;
    var type;

    function showCurrentLocation(currentLocationDiv, map) {

        currentLocationDiv.style.marginTop = '5px';
        var currentLocationUI = document.createElement('div');
        currentLocationUI.style.backgroundColor = '#4582EC';
        currentLocationUI.style.borderRadius = '3px';
        currentLocationUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
        currentLocationUI.style.cursor = 'pointer';
        currentLocationUI.style.marginBottom = '22px';
        currentLocationUI.style.textAlign = 'center';
        currentLocationUI.title = 'Click to show current location';
        currentLocationDiv.appendChild(currentLocationUI);

        var currentLocationText = document.createElement('div');
        currentLocationText.style.color = '#FFFFFF';
        currentLocationText.style.fontFamily = 'Open Sans,Arial,sans-serif';
        currentLocationText.style.fontSize = '15px';
        currentLocationText.style.lineHeight = '30px';
        currentLocationText.style.paddingLeft = '5px';
        currentLocationText.style.paddingRight = '5px';
        currentLocationText.innerHTML = 'Current location';
        currentLocationUI.appendChild(currentLocationText);

        var marker = null;

        google.maps.event.addDomListener(currentLocationUI, 'click', function () {

            if(navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = new google.maps.LatLng(position.coords.latitude,
                        position.coords.longitude);

                    if (marker == null) {
                        marker = new google.maps.Marker({
                            map: map,
                            position: pos,
                            title: 'You are here.',
                            animation: google.maps.Animation.DROP
                        });

                        var infowindow = new google.maps.InfoWindow({
                            content: 'You are here.'
                        });

                        google.maps.event.addListener(marker, 'click', function() {
                            infowindow.open(map,marker);
                        });

                        map.setCenter(pos);
                    } else {
                        map.setCenter(pos);
                        marker.setPosition(pos);
                    }

                }, function() {
                    handleNoGeolocation(true);
                });
            } else {
                handleNoGeolocation(false);
            }

        function handleNoGeolocation(errorFlag) {

            var content;

            if (errorFlag) {
                content = 'Error: The Geolocation service failed.';
            } else {
                content = 'Error: Your browser doesn\'t support geolocation.';
            }

            var options = {
                map: map,
                position: new google.maps.LatLng(51.527287, -0.103842),
                content: content
            };

            if (marker == null) {
                marker = new google.maps.Marker({
                    map: map,
                    position: options.position,
                    title: content,
                    animation: google.maps.Animation.DROP
                });

                var infowindow = new google.maps.InfoWindow({
                    content: content
                });

                google.maps.event.addListener(marker, 'click', function() {
                    infowindow.open(map,marker);
                });

                map.setCenter(options.position);
            } else {
                map.setCenter(options.position);
                marker.setPosition(options.position);
            }
        }

        });
    }

    function loadMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: new google.maps.LatLng(51.527287, -0.103842),
            zoom: 15,
            mapTypeId: 'roadmap',
            mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
        });

        var currentLocationDiv = document.createElement('div');
        var currentLocation = new showCurrentLocation(currentLocationDiv, map);
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(currentLocationDiv);

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
            $("label[for='addressInput']").empty().append("Please enter a location.");
            $("label[for='addressInput']").removeClass("feedback-happy");
            $("label[for='addressInput']").addClass("feedback-sad");
            $("#addressInput").css("cssText", "border-color: #D9534F");
            $("#addressInput").focus();
            return false;
        } else {
            $("label[for='addressInput']").empty().append("All good!");
            $("label[for='addressInput']").removeClass("feedback-sad");
            $("#addressInput").removeClass("input-sad");
            $("label[for='addressInput']").addClass("feedback-happy");
            $("#addressInput").addClass("input-happy");
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
                var notes = markerNodes[i].getAttribute("notes");
                var category = markerNodes[i].getAttribute("category");
                var distance = parseFloat(markerNodes[i].getAttribute("distance"));
                var latlng = new google.maps.LatLng(
                parseFloat(markerNodes[i].getAttribute("lat")),
                parseFloat(markerNodes[i].getAttribute("lng")));

                createOption(name, distance, i);
                createMarker(latlng, name, notes, category);
                bounds.extend(latlng);
            }

        map.fitBounds(bounds);
        locationSelect.style.display = "block";
        $("#locationSelect").select2({placeholder: "See all results:"});
        locationSelect.onchange = function() {
            var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
            google.maps.event.trigger(markers[markerNum], 'click');
        };
    });
    }

    function createMarker(latlng, name, notes, category) {
        var html = "<b>" + name + "</b> <br/>" + notes;
        var icon = customIcons[category] || {};
        var marker = new google.maps.Marker({
            map: map,
            position: latlng,
            icon: icon.icon,
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