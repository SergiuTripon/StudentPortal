
var infoWindow = new google.maps.InfoWindow();
var customIcons = {
    building: {
        icon: 'http://maps.google.com/mapfiles/ms/icons/blue.png'
    },
    library: {
        icon: 'http://maps.google.com/mapfiles/ms/icons/green.png'
    },
};

var markerGroups = {
    "building": [],
    "library": []
};

function load() {
    var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(51.527287, -0.103842),
        zoom: 12,
        mapTypeId: 'roadmap'
    });
    var infoWindow = new google.maps.InfoWindow();



    map.set('styles', [{
        zoomControl: false
    }, {
        featureType: "road.highway",
        elementType: "geometry.fill",
        stylers: [{
            color: "#ffd986"
        }]
    }, {
        featureType: "road.arterial",
        elementType: "geometry.fill",
        stylers: [{
            color: "#9e574f"
        }]
    }, {
        featureType: "road.local",
        elementType: "geometry.fill",
        stylers: [{
            color: "#d0cbc0"
        }, {
            weight: 1.1
        }

        ]
    }, {
        featureType: 'road',
        elementType: 'labels',
        stylers: [{
            saturation: -100
        }]
    }, {
        featureType: 'landscape',
        elementType: 'geometry',
        stylers: [{
            hue: '#ffff00'
        }, {
            gamma: 1.4
        }, {
            saturation: 82
        }, {
            lightness: 96
        }]
    }, {
        featureType: 'poi.school',
        elementType: 'geometry',
        stylers: [{
            hue: '#fff700'
        }, {
            lightness: -15
        }, {
            saturation: 99
        }]
    }]);

    downloadUrl("../../includes/university-map/source/overview_source.php", function(data) {
    var xml = data.responseXML;
    var markers = xml.documentElement.getElementsByTagName("marker");
    for (var i = 0; i < markers.length; i++) {
        var name = markers[i].getAttribute("name");
        var notes = markers[i].getAttribute("notes");
        var type = markers[i].getAttribute("type");

        var point = new google.maps.LatLng(
        parseFloat(markers[i].getAttribute("lat")),
        parseFloat(markers[i].getAttribute("lng")));
        var html = "<b>" + name + "</b> <br/>" + notes;
        // var icon = customIcons[type] || {};
        var marker = createMarker(point, name, notes, type, map);
        bindInfoWindow(marker, map, infoWindow, html);
    }
    });
}

function createMarker(point, name, notes, type, map) {
    var icon = customIcons[type] || {};
    var marker = new google.maps.Marker({
        map: map,
        position: point,
        icon: icon.icon,
        // shadow: icon.shadow,
        type: type
    });
    if (!markerGroups[type]) markerGroups[type] = [];
    markerGroups[type].push(marker);
    var html = "<b>" + name + "</b> <br/>" + notes;
    bindInfoWindow(marker, map, infoWindow, html);
    return marker;
}

function toggleGroup(type) {
    for (var i = 0; i < markerGroups[type].length; i++) {
        var marker = markerGroups[type][i];
        if (!marker.getVisible()) {
            marker.setVisible(true);
        } else {
            marker.setVisible(false);
        }
    }
}

function bindInfoWindow(marker, map, infoWindow, html) {
    google.maps.event.addListener(marker, 'click', function () {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);

    });
}

function downloadUrl(url, callback) {
    var request = window.ActiveXObject ? new ActiveXObject('Microsoft.XMLHTTP') : new XMLHttpRequest();

    request.onreadystatechange = function () {
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