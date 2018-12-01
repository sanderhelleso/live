import { MODAL } from '../helpers/modal';
import { DATA } from '../dashboard/loadData';
import { PREVIEW } from '../helpers/preview';

window.onload = initialize;

let data;
async function initialize() {

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

    console.log(data);

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

    // open offer modal
    MODAL.open('offer');
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