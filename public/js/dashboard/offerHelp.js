import { DATA } from './loadData';
import { WORDS } from '../helpers/words';

window.onload = initialize;

function initialize() {
    setIntro();
    loadCalendar();
}

async function setIntro() {

    // set welcome intro word
    document.querySelector('#offer-help-word').innerHTML = WORDS.getRandomWord();

    // set welcome intro name
    const data = await DATA.loadUserData();
    DATA.setFirstName(data, 'offer-help-name');

    // display container
    document.querySelector('#offer-help-intro-cont').style.display = 'block';
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
    const calendars = bulmaCalendar.attach('[type="date"]', options);

    // Loop on each calendar initialized
    calendars.forEach(calendar => {
        // Add listener to date:selected event
        calendar.on('date:selected', date => {
            console.log(date);
        });
    });

    console.log(new Date());
}