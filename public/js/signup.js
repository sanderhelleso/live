import { toast } from './lib/toast.js';
import { LOCATION } from './lib/countriesAndStates/formLocation.js';
import { VALIDATE } from './helpers/validateForm.js';

window.onload = initialize;

function initialize() {

    // focus first input on load
    document.querySelector('#signup').querySelector('input').focus();

    // fetch country and state data for select options
    LOCATION.countryAndStates();

    // prepeare form validation when attempting to submit form
    document.querySelector('#signup-btn').addEventListener('click', validateForm);
   
}

function validateForm(e) {

    // set form status to invalid
    let isValid = false;

    // prevent page from reloading
    e.preventDefault();

    // itterate over all form fields
    Array.from(document.querySelectorAll('input, select')).forEach(input => {

        // get all fields except checkbox
        if (input.type !== 'checkbox') {
            VALIDATE.clearForm(input);

            // check if any form fields are empty
            if (!input.value) {

                // set status and message
                input.classList.add('is-danger');
                VALIDATE.setHelpMessage(input, 'empty');
                isValid = false;
            }

            // attempt to validate fields, if any field fails required test, form is set to invalid
            else {
                
                isValid = VALIDATE.validate(input);
            }
        }
    });

    // form is valid
    if (isValid) {

        //attempt to create account
        createAccount(this);
    }
}

async function createAccount(button) {

    // set loading status
    button.classList.add('is-loading');
    const body = VALIDATE.formData();

    // send POST request signup endpoint
    const response = await fetch('/api/signup/signup.php', {
        method: 'POST',
        mode: 'same-origin',
        credentials: 'same-origin',
        headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
        },
        body: body
    });

    // get response data
    let data = await response.json();

    // account successfully created
    if (data.success) {

        // set localstorage to dislay message on page redirect
        localStorage.setItem('account_created_successfully', JSON.parse(body).firstName);

        // redirect user if account was successfully created
        window.location.replace('/login');
        return;
    }

    else {

        // display response message
        toast(data.message, data.success, 3000);
        setTimeout(() => {
            button.classList.remove('is-loading');
        }, 1000);
    }
}