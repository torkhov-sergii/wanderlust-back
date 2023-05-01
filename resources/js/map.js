$(function(){
    // Initialize and add the map
    function initMap() {
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 2,
            // center: { lat: 48, lng: 10 },
            center: { lat: 34, lng: 9 },
        });

        for (let i = 0; i < window.markers.length; i++) {
            const marker = window.markers[i];

            let color = '#eee';
            if (marker.user_rating == 5) color = '#f00';
            if (marker.user_rating == 4) color = '#0f0';
            if (marker.user_rating == 3) color = '#ccc';

            const svgMarker = {
                path: "M-1.547 12l6.563-6.609-1.406-1.406-5.156 5.203-2.063-2.109-1.406 1.406zM0 0q2.906 0 4.945 2.039t2.039 4.945q0 1.453-0.727 3.328t-1.758 3.516-2.039 3.070-1.711 2.273l-0.75 0.797q-0.281-0.328-0.75-0.867t-1.688-2.156-2.133-3.141-1.664-3.445-0.75-3.375q0-2.906 2.039-4.945t4.945-2.039z",
                fillColor: color,
                fillOpacity: 0.9,
                strokeWeight: 0.5,
                rotation: 0,
                scale: 1.5,
                anchor: new google.maps.Point(0, 20),
            };

            let google_marker = new google.maps.Marker({
                position: marker.position,
                title: marker.title,
                url: marker.url,
                map: map,
                icon: svgMarker,
                optimized: false,
                zIndex: marker.user_rating ? 1 : 0,
            });

            google.maps.event.addListener(google_marker, 'click', function() {
                // window.location.href = google_marker.url;
                window.open(google_marker.url, '_blank');
            });
        }
    }

    if($('#map').length) {
        window.initMap = initMap;
    }
});
