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

    var markerGroups = {
        "building": [],
        "student_centre": [],
        "lecture_theatre": [],
        "computer_lab": [],
        "library": [],
        "cycle_hire": [],
        "cycle_parking": [],
        "atm": []
    };

    // Add a Home control that returns the user to London
    function HomeControl(controlDiv, map) {
        controlDiv.style.padding = '5px';
        var controlUI = document.createElement('div');
        controlUI.style.backgroundColor = 'yellow';
        controlUI.style.border = '1px solid';
        controlUI.style.cursor = 'pointer';
        controlUI.style.textAlign = 'center';
        controlUI.title = 'Set map to London';
        controlDiv.appendChild(controlUI);
        var controlText = document.createElement('div');
        controlText.style.fontFamily = 'Arial,sans-serif';
        controlText.style.fontSize = '12px';
        controlText.style.paddingLeft = '4px';
        controlText.style.paddingRight = '4px';
        controlText.innerHTML = '<b>Home<b>'
        controlUI.appendChild(controlText);

        // Setup click-event listener: simply set the map to London
        google.maps.event.addDomListener(controlUI, 'click', function () {
            map.setCenter(london)
        });
    }

    function loadMap() {
    var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(51.527287, -0.103842),
        zoom: 15,
        mapTypeId: 'roadmap'
    });

        // Create a DIV to hold the control and call HomeControl()
    var homeControlDiv = document.createElement('div');
    var homeControl = new HomeControl(homeControlDiv, map);
    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(homeControlDiv);

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

    var infoWindow = new google.maps.InfoWindow({
        maxWidth: 400
    });

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
