import { DATA} from '../dashboard/loadData.js';

export const PREVIEW = {
    initAnimateCover,
    animateCover,
    setCover,
    setPrice,
    setTime
}

let AREAS;

// add scroll event to card cover
function initAnimateCover(areas) {

    document.querySelector('#preview-body')
    .addEventListener('scroll', animateCover);

    AREAS = areas;
}

// animate preview card
function animateCover() {

    const HEIGHT = 450;
    const MAX_HEIGHT = AREAS.length * 175;
    const COVER = document.querySelector('#preview-cover');
    document.querySelector('#preview-body').style.maxHeight = `${MAX_HEIGHT}px`;
    if (this.scrollTop < MAX_HEIGHT * 1.6) {
        COVER.style.height = `${HEIGHT - this.scrollTop}px`;
    }
}

let img;
let cover;
function setCover() {

    // set preview cover image
    const data = JSON.parse(localStorage.getItem("user_data"));
    cover = document.querySelector('#preview-cover');
    img = data.avatar ? `url('data:image/png;base64,${data.avatar}')` : `url(${DATA.setAvatar(cover, data)})`

    // set name
    DATA.setName(data, 'preview-name');
    
    cover.style.background = `
        linear-gradient(
        rgba(255, 255, 255, 0.3), 
        rgba(255, 255, 255, 1)),
        ${img}
    `; 
    cover.style.backgroundPosition = '0% 30%';
    cover.style.backgroundSize = 'cover';
}

function setPrice(data) {

    // set price
    let price = data.price;
    if (price) {
       price = parseInt(price).toFixed(2);
    }

    else {
       price = 'FREE';
    }
    document.querySelector('#preview-amount').innerHTML = price;
}

function setTime(data) {

    // set time
    document.querySelector('#preview-date').innerHTML = 
    `<span>From</span>
    <br>
    ${data.start_date}
    <br>
    <span>To</span>
    <br>
    ${data.end_date}
     `;
}