    //<![CDATA[

    var customIcons = [];
    customIcons["building"] = 'https://student-portal.co.uk/assets/img/university-map/university_map_black_icon.png';
    customIcons["student_centre"] = 'http://labs.google.com/ridefinder/images/mm_20_red.png';
    var markerGroups = { "building": [], "student_centre": []};

    function loadMap() {
        var mapOptions = {
            center: new google.maps.LatLng(51.527287, -0.103842),
            zoom: 15,
            mapTypeId: 'roadmap',
            styles: [{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"on"},{"lightness":33}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2e5d4"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#c5dac6"}]},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},{"featureType":"road","elementType":"all","stylers":[{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#c5c6c6"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#e4d7c6"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#fbfaf7"}]},{"featureType":"water","elementType":"all","stylers":[{"visibility":"on"},{"color":"#acbcc9"}]}]
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
            type: type,
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

    function toggleGroup(type) {
        for (var i = 0; i < markerGroups[type].length; i++) {
            var marker = markerGroups[type][i];
            if (marker.isHidden()) {
                marker.show();
            } else {
                marker.hide();
            }
        }
    }

    function doNothing() {}

    //]]>