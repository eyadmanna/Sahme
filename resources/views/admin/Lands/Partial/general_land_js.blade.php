<script>
    let myMap;
    let myMarker;

    function initMap() {
        const initialLat = parseFloat(document.getElementById('lat').value) || 31.5012;
        const initialLng = parseFloat(document.getElementById('long').value) || 34.4663;
        const initialLocation = { lat: initialLat, lng: initialLng };

        myMap = new google.maps.Map(document.getElementById("map"), {
            zoom: 13,
            center: initialLocation,
        });

        myMarker = new google.maps.Marker({
            position: initialLocation,
            map: myMap,  // ✅ هذا التصحيح
            draggable: true
        });

        // When marker is dragged update input fields
        myMarker.addListener('dragend', function (event) {
            document.getElementById('lat').value = event.latLng.lat().toFixed(6);
            document.getElementById('long').value = event.latLng.lng().toFixed(6);
        });
    }

    // When input fields change update the map
    document.getElementById('lat').addEventListener('input', updateMap);
    document.getElementById('long').addEventListener('input', updateMap);

    function updateMap() {
        const lat = parseFloat(document.getElementById('lat').value);
        const lng = parseFloat(document.getElementById('long').value);

        if (!isNaN(lat) && !isNaN(lng)) {
            const newPosition = { lat: lat, lng: lng };
            myMarker.setPosition(newPosition);
            myMap.setCenter(newPosition);
        }
    }
</script>


<!-- Google Maps API -->
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSNQLhR2yEuFkYAoU_q4sXlvsd_8lOMBA&callback=initMap">
</script>
