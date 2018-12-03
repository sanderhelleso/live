import { GEO_LOCATION } from '../js/helpers/geoLocation';
import { toast } from './lib/toast';

// default location sat to San Francisco
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

    // prepeare search
    document.querySelector('#find-btn').addEventListener('click', findHelp);
}

async function findHelp(e) {

    // clear old markers
    clearMarkers();

    // prevent form from submitting 
    e.preventDefault();

    let data = createFindData();
    if (!data) {
        toast('Please select atleast one area', false, 3000);
        return;
    }

    // set loading status
    this.classList.add('is-loading');

    // send POST request login endpoint
    const response = await fetch('/api/find/find.php', {
        method: 'POST',
        mode: 'same-origin',
        credentials: 'same-origin',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({...data})
    });

    // get response data
    data = await response.json();

    if (data.success) {

        // itterate over payload and create markers
        data.payload.map(helper => {
            createMarker(helper);
        });
    }

    // if no matches were found, display message
    else {
        toast(data.message, data.success, 5000);
    }

    setTimeout(() => {
        this.classList.remove('is-loading');
    }, 500);

    console.log(data);
}

function clearMarkers() {

    // clear old markers
    for(let i = 0; i < markers.length; i++){
        markers[i].setMap(null);
    }

    markers = new Array();
}

function createMarker(helper) {

    // create a new lat / lng marker
    const latLng = {
        lat: parseFloat(helper.latitude),
        lng: parseFloat(helper.longitude)
    }

    // instantiate a new marker with pos of given lat / lng
    const marker = new google.maps.Marker({ 
        position: latLng,
        map: map,
        id: helper.user_id
    });

    // add event to marker
    google.maps.event.addDomListener(marker, 'click', () => {
        console.log(marker.id);
    });

    markers.push(marker);
}

let map;
let markers = new Array();
let coords;
async function initializeMap() {

    // fetch users geo location
    coords = await GEO_LOCATION.getLocation();
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

function createFindData() {

    // initialize empty data object
    const data = {}

    // find checked areas
    let selectedArea = false;
    Array.from(document.querySelectorAll('.is-checkradio')).forEach(area => {

        const areaName = area.id.split('-').join('_');
        if (area.checked) {
            data[areaName] = 1;
            selectedArea = true;
        }

        else {
            data[areaName] = 0;
        }
    });

    // if no areas is selected, display error message
    if (!selectedArea) {
        return false;
    }

    // set users location in lat / lng
    data.lat =  coords.latitude;
    data.lng = coords.longitude

    // set range in KM selected
    data.radius = document.querySelector('#range-input').value;

    // set date request was performed
    data.date = new Date().toLocaleDateString();

    // return data containing areas
    return data;
}