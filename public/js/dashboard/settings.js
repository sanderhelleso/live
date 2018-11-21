import { toast } from '../lib/toast';
import { LOCATION } from '../lib/countriesAndStates/formLocation';
import { REGEX } from '../helpers/regex';

window.onload = initialize;

function initialize() {

    setFormData();
}

// fill in the users data into settings form
function setFormData() {

    // fetch country and state data for select options
    LOCATION.countryAndStates(true);

    // set settings data from users data
    const data = JSON.parse(localStorage.getItem('user_data'));
    Object.keys(data).forEach(key => {
        const field = document.querySelector(`input[name="${key}"]`);
        if (field) {
            field.value = data[key];
        }
    });

    // set user avatar
    const avatar = document.querySelector('#user-avatar-upload-img');
    avatar.src = data.avatar ? data.avatar : `${location.protocol}//${location.host}/public/img/dashboard/defaultAvatar.jpg`;
    avatar.alt = `${data.first_name} ${data.last_name}'s avatar`;

    
}