    var infoWindow = new google.maps.InfoWindow();

    var customIcons = {
        building: {
            icon: 'http://maps.google.com/mapfiles/ms/icons/blue.png'
        },
        student_centre: {
            icon: 'http://maps.google.com/mapfiles/ms/icons/green.png'
        },
        lecture_theatre: {
            icon: 'http://maps.google.com/mapfiles/ms/icons/yellow.png'
        },
        computer_lab: {
            icon: 'http://maps.google.com/mapfiles/ms/icons/purple.png'
        }
    };

    var markerGroups = {
        "building": [],
        "student_centre": [],
        "lecture_theatre": [],
        "computer_lab": [],
        "library": [],
        "cycle_hire": [],
        "cycle_parking": [],
        "ATM": []
    };

    function load() {
    var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(38.639104, -8.210413),
        zoom: 12,
        mapTypeId: 'roadmap'
    });

    downloadUrl("../../includes/university-map/source/overview_source.php", function(data) {
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

    function createMarker(point, name, notes, category, map) {
        var icon = customIcons[category] || {};
        var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon,
            type: category
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
    google.maps.event.addDomListener(window, 'load', load);
