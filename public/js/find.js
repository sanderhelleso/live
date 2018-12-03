import { GEO_LOCATION } from '../js/helpers/geoLocation';

// default location
const SF_LAT = 37.773972;
const SF_LNG = -122.431297;

// default zoom in km
const DEFAULT_ZOOM_KM = 20;

window.onload = initialize;

function initialize() {

    // prepeare the map
    initializeMap();

    // prepeare range slider
    document.querySelector('#range-input').addEventListener('input', updateRange);
}

let map;
async function initializeMap() {

    // fetch users geo location
    let coords = await GEO_LOCATION.getLocation();
    if (!coords) {

        // if geo location fetched failed, set default coords to San Fransico
        coords = {
            latitude: SF_LAT,
            longitude: SF_LNG
        }
    }

    // initialize map
    const infoWindow = new google.maps.InfoWindow;
    map = new google.maps.Map(document.querySelector('#map'), {
        center: {
            lat: coords.latitude,
            lng: coords.longitude
        }
    });
    
    // set initial zoom
    map.setZoom(calculateZoomLevel(DEFAULT_ZOOM_KM));
}

// default zoom
function updateRange(e) {

    const output = document.querySelector('#range-value');
    const value = e.target.value;
    output.innerHTML = `${value}<span>km</span>`;

    map.setZoom(calculateZoomLevel(value));
}

/** 
    Algorithm to calculate zoom level depeniding on KM
**/

function calculateZoomLevel(km) {

    const equatorLength = 40075004; // in meters
    const widthInPixels = parseInt(document.querySelector('#map').offsetWidth);
    let metersPerPixel = equatorLength / widthInPixels;
    let zoomLevel = 1;

    while ((metersPerPixel * widthInPixels) > (1000 * km)) {
        metersPerPixel /= 2;
        ++zoomLevel;
    }

    return zoomLevel;
}