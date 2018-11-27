import { DATA } from './loadData';
import { WORDS } from '../helpers/words';

window.onload = initialize;

function initialize() {
    loadCalendar();
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