window.onload = initialize;

function initialize() {
    initializeMap();
}

async function initializeMap() {

    // initialize map
    const infoWindow = new google.maps.InfoWindow;
    const map = new google.maps.Map(document.querySelector('#map'), {
        center: {
            lat: -34.397,
            lng: 150.644
        },
        zoom: 12
    });
}