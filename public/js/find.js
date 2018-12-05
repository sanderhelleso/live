import { GEO_LOCATION } from '../js/helpers/geoLocation.js';
import { DATA } from './dashboard/loadData.js';
import { MODAL } from './helpers/modal.js';
import { WORDS } from './helpers/words.js';
import { HEADER} from './helpers/authHeader.js';
import { toast } from './lib/toast.js';

// data recieved
let results = new Array();

// default location sat to Seaside, CA, USA (CSUMB Campus)
const SF_LAT = 	36.653747;
const SF_LNG = 	-121.798511;

// default zoom in km
const DEFAULT_ZOOM_KM = 20;

// helper contact chatacter limit
const CHARACTER_LIMIT = 2000;

window.onload = initialize;

function initialize() {

    // prepeare the map
    initializeMap();

    // prepeare range slider
    document.querySelector('#range-input').addEventListener('input', updateRange);

    // prepeare search
    document.querySelector('#find-btn').addEventListener('click', findHelp);

    // prepeare sort / order by
    document.querySelector('#order-by-select').addEventListener('change', orderBy);
}

async function findHelp(e) {

    // clear old markers
    clearMarkers();

    // clear old results
    const resultsCont = document.querySelector('#results-cont');
    resultsCont.style.opacity = '0';
    document.querySelector('#results').innerHTML = '';
    currentOptions = {};

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

        // itterate over payload and create markers and result cards
        results = Object.values(data.payload.data);
        orderBy(results);
        setStats(Object.values(data.payload.stats));

        // display results
        scrollTo(resultsCont);
        setTimeout(() => {
            resultsCont.style.opacity = '1';
        }, 300);
    }

    // if no matches were found, display message
    else {
        toast(data.message, data.success, 5000);
        results = new Array();
    }

    setTimeout(() => {
        this.classList.remove('is-loading');
    }, 500);
}

// set the stats of result
function setStats(stats) {

    let i = 0;
    const statsEles = Array.from(document.querySelector('#stats').querySelectorAll('h5'));
    statsEles.forEach(ele => {
        ele.innerHTML = parseInt(stats[i]);
        i++;
    });

}

// order results by order option
function orderBy() {

    // clear previous results
    document.querySelector('#results').innerHTML = '';

    const orderSetting = document.querySelector('#order-by-select').value;
    switch(parseInt(orderSetting)) {

        // price (low to high)
        case 1:
            results.sort((a, b) => parseInt(a.price) - parseInt(b.price));
            break;
        
        // price (high to low)
        case 2:
            results.sort((a, b) => parseInt(b.price) - parseInt(a.price));
            break;

        // name (A - Z)
        case 3:
            results.sort((a, b) => `${a.first_name} ${a.last_name}`.localeCompare(`${b.first_name} ${b.last_name}`));
            break;

        // name (Z - A)
        case 4:
            results.sort((a, b) => `${b.first_name} ${b.last_name}`.localeCompare(`${a.first_name} ${a.last_name}`));
            break;
    }

    // itterate over payload and create markers and result cards
    results.map(helper => {
        createMarker(helper);
        createResultCard(helper);
    });
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
        icon: mapsIcon('helper'),
        id: helper.user_id
    });

    // add event to marker
    google.maps.event.addDomListener(marker, 'click', () => {

        // on click on marker, scroll to releated helper
        const ele = document.querySelector(`#helper-${marker.id}`);
        scrollTo(ele);
        setTimeout(() => {
            ele.focus();
        }, 700);
    });

    markers.push(marker);
}

let map;
let coords;
let markers = new Array();
async function initializeMap() {

    // fetch users geo location
    coords = null;//await GEO_LOCATION.getLocation();
    if (!coords) {

        // if geo location fetched failed, set default coords to San Fransico
        coords = {
            latitude: SF_LAT,
            longitude: SF_LNG
        }
    }

    // initialize map
    map = new google.maps.Map(document.querySelector('#map'), {
        center: {
            lat: coords.latitude,
            lng: coords.longitude
        }
    });

    // initialize marker for user location
    new google.maps.Marker({ 
        position: { 
            lat: parseFloat(coords.latitude),
            lng: parseFloat(coords.longitude)
        },
        map: map,
        icon: mapsIcon('home')
    });
    
    // set initial zoom
    map.setZoom(calculateZoomLevel(DEFAULT_ZOOM_KM));
}

function mapsIcon(iconType) {

    return {
        url: `${location.protocol}//${location.host}/public/img/maps/${iconType}Icon.png`, // url
        scaledSize: new google.maps.Size(50, 50), // scaled size
        origin: new google.maps.Point(0,0), // origin
        anchor: new google.maps.Point(0, 0) // anchor
    }
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

    while ((metersPerPixel * widthInPixels) > (2500 * km)) {
        metersPerPixel /= 2;
        zoomLevel++;
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

    // if logged in user performs request, pass along ID
    data.id = localStorage.getItem('auth_token') 
    ? 
    JSON.parse(localStorage.getItem('auth_token')).id 
    : 
    null;

    // return data containing areas
    return data;
}

function createResultCard(helper) {

    // create card cont
    const card = document.createElement('div');
    card.id = `helper-${helper.user_id}`;
    card.className = 'card animated fadeIn column result-card';
    card.tabIndex = '0';

    /****
     * 
     * CARD HEADER
     * 
    ****/

    // create card image cont
    const cardImageCont = document.createElement('div');
    cardImageCont.classList = 'card-image';

    // get img data
    const img = helper.avatar ? `url('data:image/png;base64,${helper.avatar}')` : `url(${DATA.setAvatar(cardImageCont, helper)})`
    
    // set bg
    cardImageCont.style.background = `
        linear-gradient(
        rgba(255, 255, 255, 0.3), 
        rgba(255, 255, 255, 1)),
        ${img}
    `; 
    cardImageCont.style.backgroundPosition = 'center 20%';
    cardImageCont.style.backgroundSize = 'cover';

    // create card name
    const name = document.createElement('h3');
    name.className = 'card-name';
    name.innerHTML = `${helper.first_name} ${helper.last_name}`;

    // append header to card
    cardImageCont.appendChild(name);
    card.appendChild(cardImageCont);

    /****
     * 
     * CARD BODY
     * 
    ****/

    // card body cont
    const cardBody = document.createElement('div');
    cardBody.className = 'card-content';

    // create media cont
    const mediaCont = document.createElement('div');
    mediaCont.className = 'media';

    // create media content cont
    const mediaContent = document.createElement('div');
    mediaContent.className = 'media-content';

    // create descriptipn
    const description = document.createElement('p');
    description.className = 'description';
    description.innerHTML = helper.description;
    
    // append media to card body
    mediaContent.appendChild(description);
    mediaCont.appendChild(mediaContent);
    cardBody.appendChild(mediaCont);

    // create main content cont
    const contentCont = document.createElement('div');
    contentCont.className = 'content columns';

    // create time cont
    const timeCont = document.createElement('div');
    timeCont.className = 'time-cont card-cont column';

    // create date tag
    const date = document.createElement('h5');
    date.className = 'date';

    // create from tag
    const fromLabel = document.createElement('span');
    fromLabel.innerHTML = 'From';

    // create from time tag
    const fromTime = document.createElement('p');
    fromTime.innerHTML = helper.start_date;

    // create to tag
    const toLabel = document.createElement('span');
    toLabel.innerHTML = 'To';

    // create to time tag
    const toTime = document.createElement('p');
    toTime.innerHTML = helper.end_date;

    // append from time and from date to date tag
    date.appendChild(fromLabel);
    date.appendChild(fromTime);
    date.appendChild(toLabel);
    date.appendChild(toTime);

    // append date to time cont
    timeCont.appendChild(date);

    // append time cont to content cont
    contentCont.appendChild(timeCont);

    // create price cont
    const priceCont = document.createElement('div');
    priceCont.className = 'price-cont card-cont column';

    // create amount tag
    const amount = document.createElement('h5');
    amount.className = 'amount';
    amount.innerHTML = `<span>$</span>${helper.price}`;

    // create amount label
    const amountLabel = document.createElement('p');
    amountLabel.innerHTML = 'Per Hour';

    // append amount and label to price cont
    priceCont.appendChild(amount);
    priceCont.appendChild(amountLabel);

    // append price cont to content cont
    contentCont.appendChild(priceCont);

    /****
     * 
     * CARD FOOTER
     * 
    ****/

    // create button
    const cardBtn = document.createElement('button');
    cardBtn.className = 'button card-btn';

    // modify text and event depending if user is logged in
    if (localStorage.getItem('auth_token')) {
        cardBtn.innerHTML = `Get In Touch With ${helper.first_name}`;
        cardBtn.addEventListener('click', openContact);
    }

    else {
        cardBtn.innerHTML = `Log In to Get In Touch With ${helper.first_name}`;
        cardBtn.addEventListener('click', () => {
            window.location.replace('/login');
        });
    }

    // append content to card
    cardBody.appendChild(contentCont);
    cardBody.appendChild(cardBtn);
    card.appendChild(cardBody);

    // append card to parent cont
    document.querySelector('#results').appendChild(card);

}

let currentHelper; // current open helper
let currentOptions = {}; // current selected options
function openContact() {

    // set contact info data
    currentHelper = findHelper(this);
    setContactInfo(currentHelper);

    // increment view counter for heler
    updateViewCounter();

    // set random word and name
    const heading = document.querySelector('#contact-heading');
    heading.innerHTML = `${WORDS.getRandomWord() } !`;

    // enable / disable options
    toogleOptions();

    // prepeare for sending og contact
    document.querySelector('#confirm-contact').addEventListener('click', sendContact);

    MODAL.open('contact');
}

// smooth scroll to given element
function scrollTo(element) {
    element.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}

function findHelper(that) {

    // find helper
    return results.find((helper) => {
        return helper.user_id === that.parentElement.parentElement.id.split('-')[1];
    });
}

function setContactInfo(data) {

    // contact body elements
    const textArea = document.querySelector('textarea');
    const helperLabel = document.querySelector('#character-counter');

    // reset text
    helperLabel.innerHTML = 'Characters remaining: 2000';
    textArea.value = '';

    // prepeare for event
    textArea.addEventListener('input', () => {
        helperLabel.innerHTML = `Characters remaining: ${CHARACTER_LIMIT - textArea.value.length}`;
    });

    // set helpers avatar
    const img = document.querySelector('#contact-img');
    DATA.setAvatar(img, data);

    // get and format helpers name
    const name = `
    ${data.first_name.split('')[0].toUpperCase()}${data.first_name.substring(1, data.first_name.length)}`;

    // set intro
    const intro = document.querySelector('#contact-intro');
    intro.innerHTML = `
    You are only a few steps away from finding your new 
    helper! Let ${name} know what it is you require aid 
    in and if ${name} accepts your request, you will recieve
    ${name}'s E-Mail and Phone Number to further communicate!`;

    // set button text
    document.querySelector('#confirm-contact').innerHTML = `Request ${name}`;
}

function toogleOptions() {

    // set disabled / enabled depending on sat options by user
    Array.from(
        document.querySelector('#find-options')
        .querySelectorAll('input'))
        .map(option => {
            const ele = document.querySelector(`#${option.id}-contact`);
            if (option.checked) {
                ele.checked = true;
                currentOptions[option.id.split('-').join('_')] = 1;
            }

            else {
                ele.checked = false;
                currentOptions[option.id.split('-').join('_')] = 0;
            }
        }
    );
}

// attempt to send contact to helper
async function sendContact() {

    // validate textarea value
    const textArea = document.querySelector('textarea');
    if (textArea.value.length < 200) {
        toast('To short request message! Please write atleast 200 characters', false, 3000, true);
        textArea.focus();
        return;
    }

    else if (textArea.value.length > CHARACTER_LIMIT) {
        toast('To long request message! Please write a maximum of 2000 characters', false, 3000, true);
        textArea.focus();
        return;
    }

    // create POST body
    const body = {
        helper_id: currentHelper.user_id,
        id: JSON.parse(localStorage.getItem('auth_token')).id,
        message: textArea.value,
        karma: Math.floor(Math.random() * Math.floor((500 + parseInt(currentHelper.total_views) / 10))) + 200,
        ...currentOptions
    }

    // send POST request request helper endpoint
    const response = await fetch('/api/request-helper/request-helper.php', {
        method: 'POST',
        mode: 'same-origin',
        credentials: 'same-origin',
        headers: {
            ...HEADER(),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(body)
    });

    // get response data
    let data = await response.json();

    // if request was succesfully listed,
    // clear data and close modal
    if (data.success) {
        textArea.value = '';
        document.querySelector('.delete').click();
    }

    // display message
    toast(data.message, data.success, 5000, true);
}

// update helpers total view counter and set last seen timestamp
function updateViewCounter() {

    // send POST request update views endpoint
    fetch('/api/update-view/update-view.php', {
        method: 'POST',
        mode: 'same-origin',
        credentials: 'same-origin',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id: currentHelper.user_id
        })
    });
}