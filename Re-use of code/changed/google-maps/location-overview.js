    var customIcons = {
        'building': {
            icon: 'https://student-portal.co.uk/assets/img/university-map/building_icon.png'
        },
        'student centre': {
            icon: 'https://student-portal.co.uk/assets/img/university-map/student_centre_icon.png'
        },
        'lecture theatre': {
            icon: 'https://student-portal.co.uk/assets/img/university-map/lecture_theatre_icon.png'
        },
        'computer lab': {
            icon: 'https://student-portal.co.uk/assets/img/university-map/computer_lab_icon.png'
        },
        'library': {
            icon: 'https://student-portal.co.uk/assets/img/university-map/library_icon.png'
        },
        'cycle hire': {
            icon: 'https://student-portal.co.uk/assets/img/university-map/cycle_hire_icon.png'
        },
        'cycle parking': {
            icon: 'https://student-portal.co.uk/assets/img/university-map/cycle_parking_icon.png'
        },
        'atm': {
            icon: 'https://student-portal.co.uk/assets/img/university-map/atm_icon.png'
        }
    };

    var markerGroups = {
        "building": [],
        "student centre": [],
        "lecture theatre": [],
        "computer lab": [],
        "library": [],
        "cycle hire": [],
        "cycle parking": [],
        "atm": []
    };

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
    var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(51.527287, -0.103842),
        zoom: 15,
        mapTypeId: 'roadmap',
        mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
    });

    var currentLocationDiv = document.createElement('div');
    var currentLocation = new showCurrentLocation(currentLocationDiv, map);
    map.controls[google.maps.ControlPosition.TOP_CENTER].push(currentLocationDiv);

    downloadUrl("../../includes/university-map/source/location_overview_source.php", function(data) {
    var xml = data.responseXML;
    var markers = xml.documentElement.getElementsByTagName("marker");
    for (var i = 0; i < markers.length; i++) {
        var name = markers[i].getAttribute("name");
        var notes = markers[i].getAttribute("notes");
        var category = markers[i].getAttribute("category");
        var point = new google.maps.LatLng(
            parseFloat(markers[i].getAttribute("lat")),
            parseFloat(markers[i].getAttribute("lng")));
        var marker = createMarker(point, name, notes, category, map);
    }
    });
    }

    var infoWindow = new google.maps.InfoWindow({
        maxWidth: 400
    });

    function createMarker(point, name, notes, category, map) {
        var icon = customIcons[category] || {};
        var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon,
            type: category,
            animation: google.maps.Animation.DROP
        });
        if (!markerGroups[category]) markerGroups[category] = [];
        markerGroups[category].push(marker);
        var html = "<b>" + name + "</b> <br/>" + notes;
        bindInfoWindow(marker, map, infoWindow, html);
        return marker;
    }

    function toggleGroup(category) {
        for (var i = 0; i < markerGroups[category].length; i++) {
            var marker = markerGroups[category][i];
            if (!marker.getVisible()) {
                marker.setVisible(true);
            } else {
                marker.setVisible(false);
            }
        }
    }

    function bindInfoWindow(marker, map, infoWindow, html) {
        google.maps.event.addListener(marker, 'click', function() {
            infoWindow.setContent(html);
            infoWindow.open(map, marker);

        });
    }

    function downloadUrl(url, callback) {
        var request = window.ActiveXObject ? new ActiveXObject('Microsoft.XMLHTTP') : new XMLHttpRequest();

        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                request.onreadystatechange = doNothing;
                callback(request, request.status);
            }
        };

        request.open('GET', url, true);
        request.send(null);
    }

    function doNothing() {}
