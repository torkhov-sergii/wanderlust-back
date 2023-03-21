// Initialize and add the map
function initMap() {
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 6,
        // center: { lat: 48, lng: 10 },
        center: { lat: 34, lng: 9 },
    });

    for (let i = 0; i < window.markers.length; i++) {
        const marker = window.markers[i];

        let google_marker = new google.maps.Marker({
            position: marker.position,
            title: marker.title,
            url: marker.url,
            map: map,
        });

        google.maps.event.addListener(google_marker, 'click', function() {
            // window.location.href = google_marker.url;
            window.open(google_marker.url, '_blank');
        });
    }
}

window.initMap = initMap;
