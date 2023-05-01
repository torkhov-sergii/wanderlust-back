$(function(){
    // Initialize and add the map
    function initMap() {
        let bounds = new google.maps.LatLngBounds();

        const map = new google.maps.Map(document.getElementById("map_circles"), {
            zoom: 2,
            // center: { lat: 48, lng: 10 },
            center: { lat: 34, lng: 9 },
        });

        let colors = {
            '0': "#FF0000",
            '1': "#00FF00",
            '2': "#0000FF",
        }

        for (let i = 0; i < window.markers.length; i++) {
            const marker = window.markers[i];

            const circle = new google.maps.Circle({
                strokeColor: "#FF0000",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: colors[marker.depth],
                fillOpacity: 0.35,
                map,
                center: marker.position,
                radius: marker.radius,
            });

            bounds.extend(marker.position);
        }

        map.fitBounds(bounds);

        // // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
        // var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
        //     this.setZoom(8);
        //     google.maps.event.removeListener(boundsListener);
        // });
    }



    if($('#map_circles').length) {
        window.initMap = initMap;
    }
});
