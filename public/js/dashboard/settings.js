import { toast } from '../lib/toast';
import { LOCATION } from '../lib/countriesAndStates/formLocation';
import { VALIDATE } from '../helpers/validateForm';
import { HEADER } from '../helpers/authHeader';
import { DATA } from './loadData';

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

    // set newsletter
    const checked = parseInt(data.newsletter) ? true : false; // 0 or 1
    document.querySelector('input[name="newsletter"]').checked = checked;

    // set user avatar
    const avatar = document.querySelector('#user-avatar-upload-img');
    avatar.src = data.avatar ? data.avatar : `${location.protocol}//${location.host}/public/img/dashboard/defaultAvatar.jpg`;
    avatar.alt = `${data.first_name} ${data.last_name}'s avatar`;

    // set users full name
    document.querySelector('#user-settings-name').innerHTML = `${data.first_name} ${data.last_name}`;

    // prepeare form validation when attempting to submit form
    document.querySelector('#settings-btn').addEventListener('click', validateForm);
}

function validateForm(e) {

    // set form status to invalid
    let isValid = false;
    let isEmpty = false;

    // prevent page from reloading
    e.preventDefault();

    // itterate over all form fields
    Array.from(document.querySelectorAll('input, select')).forEach(input => {

        // get all fields except checkbox
        if (input.type !== 'checkbox') {
            VALIDATE.clearForm(input);

            // check if any form fields are empty
            if (!input.value) {

                if (input.type !== 'password' || (document.querySelector('.password-input').value && input.type === 'password')) {
                if (input.type !== 'password') {

                    input.classList.add('is-danger');
                    VALIDATE.setHelpMessage(input, 'empty');
                    isValid = false;
                    isEmpty = true;
                }

                else {

                    // validate password attempt
                    if ((document.querySelector('.password-input').value && input.type === 'password')) {

                        // set status and message
                        input.classList.add('is-danger');
                        VALIDATE.setHelpMessage(input, 'empty');
                        isValid = false;
                        isEmpty = true;
                    }
                    
                }

            }
            

            // attempt to validate fields, if any field fails required test, form is set to invalid
            else  {

                isValid = VALIDATE.validate(input);
                if (!isValid) {
                    isEmpty = true;
                }
            }
        }
    });

    if (isValid && !isEmpty) {
        updateUserData(this);
    }
}

async function updateUserData(button) {

    // set loading status
    button.classList.add('is-loading');
    const body = VALIDATE.formData(true);

    console.log(body);

    // send POST request update user endpoint
    const response = await fetch('/api/user/updateUserData.php', {
        method: 'POST',
        mode: 'same-origin',
        credentials: 'same-origin',
        headers: {
            ...HEADER(),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: body
    });

    // get response data
    let data = await response.json();

    // settings successfully updated
    if (data.success) {

        // remove old data
        localStorage.removeItem('user_data');

        // set the updated data
        const data = await DATA.loadUserData();
        DATA.setNavbarData(data);     
    }

    // clear form
    Array.from(document.querySelectorAll('input, select, .select')).forEach(input => {

        // get all fields except checkbox
        if (input.type !== 'checkbox') {
            VALIDATE.clearForm(input);
        }
    });

    // display response message
    toast(data.message, data.success, 3000);
    setTimeout(() => {
        button.classList.remove('is-loading');
    }, 1000);
}