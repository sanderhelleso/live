import { MODAL } from '../helpers/modal';
import { DATA } from '../dashboard/loadData';
import { PREVIEW } from '../helpers/preview';
import { HEADER } from '../helpers/authHeader';
import { toast } from '../lib/toast';
import { RECENT_ACTION } from '../helpers/recentActionNotification';

window.onload = initialize;

let data;
async function initialize() {

    // check for new offer
    RECENT_ACTION.newOffer();

    // load users current offer stats
    await DATA.loadOfferData();

    data = JSON.parse(localStorage.getItem('offer_data'));
    setStats(data);
    
    // add event listener to open offer modal
    document.querySelector('#offer-btn').addEventListener('click', openOffer);
}

function setStats(data) {

    // set stats
    document.querySelector('#total-views').innerHTML = data.total_views;
    document.querySelector('#last-viewed-at').innerHTML = data.last_viewed ? data.last_viewed : 'Unknown';
}

function openOffer() {

    // set offer areas
    const AREAS = setAreas(data);
    createAreas(AREAS);

    // animate cover
    PREVIEW.initAnimateCover(AREAS);

    // set preview cover image and name
    PREVIEW.setCover();

    // set price
    PREVIEW.setPrice(data);

    // set time
    PREVIEW.setTime(data);

    // set description
    document.querySelector('#preview-description').innerHTML = data.description;

    // prepeare modal for removal
    document.querySelector('#remove-offer').addEventListener('click', removeOffer);

    // open offer modal
    MODAL.open('offer');
}

async function removeOffer() {

    // send POST request offer data endpoint
    const response = await fetch('/api/offerHelp/removeOfferHelp.php', {
        method: 'POST',
        mode: 'same-origin',
        credentials: 'same-origin',
        headers: {
            ...HEADER(),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id: JSON.parse(localStorage.getItem('user_data')).user_id
        })
    });

    // get response data
    let data = await response.json();

    if (data.success) {

        // set success message
        localStorage.setItem('offer_deleted_successfully', true);
        window.location.replace('/dashboard');
    }

    else {
        
        // display response message
        toast(data.message, data.success, 3000);
    }
}

function setAreas(data) {
    const AREAS = [];

    if (parseInt(data.child_care)) {
        AREAS.push('child-care');
    }

    if (parseInt(data.elder_care)) {
        AREAS.push('elder-care');
    }

    if (parseInt(data.animal_care)) {
        AREAS.push('animal-care');
    }

    return AREAS;
}

function createAreas(AREAS) {
    const areaCont = document.querySelector('#preview-areas');
    areaCont.innerHTML = '';
    AREAS.forEach(area => {
        const ele = document.createElement('div');
        const title = document.createElement('span');
        title.innerHTML = area.split('-').join(' ');
        ele.appendChild(title);

        ele.className = `column preview-area ${area}`;
        areaCont.appendChild(ele);
    });
}