import { toast } from '../lib/toast';
import { LOCATION } from '../lib/countriesAndStates/formLocation';
import { REGEX } from '../helpers/regex';

window.onload = initialize;

function initialize() {

    // fetch country and state data for select options
    LOCATION.countryAndStates(true);
}