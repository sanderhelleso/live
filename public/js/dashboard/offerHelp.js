import { DATA } from './loadData';
import { WORDS } from '../helpers/words';
import { MODAL } from '../helpers/modal';
import { toast } from '../lib/toast';

// store areas selected
const AREAS = {};

window.onload = initialize;

function initialize() {

    // prepeare areas to select
    initializeAreas();

    // load calendar
    loadCalendar();

    // initialize preview
    document.querySelector('#offer-btn').addEventListener('click', validate);

}

function initializeAreas() {

    const areas =  Array.from(document.querySelector('#areas').querySelectorAll('.column'));
    areas.forEach(area => {
        area.addEventListener('click', () => {
            area.className = 'selected-area';
            setSelectedArea(area);
            setTimeout(() => {
                area.style.display = 'none';
            }, 500);
        });
    });
}

function fadeAreas() {
    document.querySelector('#areas').className = 'columns animated fadeIn';
    setTimeout(() => {
        document.querySelector('#areas').className = 'columns';
    }, 600);
}

function setSelectedArea(area) {

    // parent cont and status ele
    const selectedStatus = document.querySelector('#selected-status');
    const selectedCont = document.querySelector('#selected');

    // create selected area 
    const selected = document.createElement('h5');
    selected.innerHTML = area.querySelector('span').innerHTML;

    // add event to element
    selected.addEventListener('click', () => {

        fadeAreas();

        // display area
        area.className = `column ${selected.innerHTML.toLowerCase().split(' ').join('-')} animated fadeInUp`;
        area.style.display = 'block';
        
        // remove selected element
        selected.remove();
        selectedCont.className = 'column';

        // check if empty cont
        if (Array.from(selectedCont.querySelectorAll('h5')).length === 0) {
            selectedStatus.innerHTML = 'No Areas Selected';
        }
    });

    // append to parent
    selectedCont.appendChild(selected);

    // change status to selected
    selectedStatus.innerHTML = 'Areas Selected';

    // if all options selected, move cont upwards
    if (Array.from(selectedCont.querySelectorAll('h5')).length === 3) {
        selectedCont.className = 'all-selected';
    }
}

function loadCalendar() {

    // get todays date
    const today = new Date().toLocaleDateString();

    // initialize calendar into type date input
    const options = {
        displayMode: 'inline',
        labelFrom: 'Available From',
        labelTo: 'Available To',
        isRange: true,
        startDate: new Date(today),
        minDate: today
    };

    // attatch calendar to input
    bulmaCalendar.attach('[type="date"]', options);

}

function validate() {

    // check bio
    const bio = document.querySelector('textarea');
    if (bio.value.length < 150) {
        bio.scrollIntoView(false);
        window.scrollBy(0, 150);
        bio.focus();
        toast('To short description! Please write atleast 150 characters.', false, 4000);
    }

    //openPreview();
}

function openPreview() {

    // set preview cover image
    const data = JSON.parse(localStorage.getItem("user_data"));
    const img = `url('data:image/png;base64,${data.avatar}')`;
    const cover = document.querySelector('#preview-cover');
    
    cover.style.background = `
        linear-gradient(
        rgba(255, 255, 255, 0.3), 
        rgba(255, 255, 255, 1)),
        ${img}
    `; 
    cover.style.backgroundPosition = '0% 50%';
    cover.style.backgroundSize = 'cover';

    // set name
    DATA.setName(data, 'preview-name');


    MODAL.open('offer');
}