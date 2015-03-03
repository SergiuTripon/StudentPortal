    //<![CDATA[
    var customIcons = {
    building: {
        icon: 'https://student-portal.co.uk/assets/img/university-map/university_map_black_icon.png'
    },
    student_centre: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png'
    },
    lecture_theatre: {
        icon: 'http://maps.gstatic.com/mapfiles/ridefinder-images/mm_20_green.png'
    },
    computer_lab: {
        icon: 'http://maps.gstatic.com/mapfiles/ridefinder-images/mm_20_yellow.png'
    },
    library: {
        icon: 'http://maps.gstatic.com/mapfiles/ridefinder-images/mm_20_black.png'
    }
    };

    function loadMap() {
        var mapOptions = {
            center: new google.maps.LatLng(51.527287, -0.103842),
            zoom: 15,
            mapTypeId: 'roadmap',
            styles: [{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}]
        };
        var mapElement = document.getElementById('map');
        var map = new google.maps.Map(mapElement, mapOptions);
        var infoWindow = new google.maps.InfoWindow({ maxWidth: 400 });

    // Change this depending on the name of your PHP file
    downloadUrl("../../includes/university-map/source/overview_source.php", function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
        var name = markers[i].getAttribute("name");
        var description = markers[i].getAttribute("description");
        var type = markers[i].getAttribute("type");
        var point = new google.maps.LatLng(
            parseFloat(markers[i].getAttribute("lat")),
            parseFloat(markers[i].getAttribute("lng")));
        var html = "<b>" + name + "</b> <br/>" + description;
        var icon = customIcons[type] || {};
        var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon,
            animation: google.maps.Animation.DROP
        });
        bindInfoWindow(marker, map, infoWindow, html);
        }
    });
    }

    function bindInfoWindow(marker, map, infoWindow, html) {
        google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
        });
    }

    function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
        new ActiveXObject('Microsoft.XMLHTTP') :
        new XMLHttpRequest;

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

    //]]>