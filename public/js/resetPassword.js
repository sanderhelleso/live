import { toast } from './lib/toast.js';
import { VALIDATE } from './helpers/validateForm.js';

window.onload = initialize;

function initialize() {

    // focus first input on load
    document.querySelector('input').focus();

    // prepeare button for update password event
    document.querySelector('#reset-password-btn').addEventListener('click', validate);
}

function validate(e) {

    // prevent page from reloading
    e.preventDefault();

    // set inputs
    const inputs = document.querySelectorAll('input');

    let isValid = false;

    // itterate over all form fields
    inputs.forEach(input => {
        VALIDATE.clearForm(input);

        // check if any form fields are empty
        if (!input.value) {

            // set status and message
            input.classList.add('is-danger');
            VALIDATE.setHelpMessage(input, 'empty');
        }

        else {
            isValid = VALIDATE.validate(input);
        }
    });

    if (isValid) {

        // compare and make sure passwords are matching before attempting update
        if (VALIDATE.validate(document.querySelector('.confirmPassword-input'))) {
            updatePassword(this);
        }
    }
}

async function updatePassword(button) {

    // set loading status
    button.classList.add('is-loading');
    
    // send POST request update user password endpoint
    const response = await fetch('/api/reset-password/reset-password.php', {
        method: 'POST',
        mode: 'same-origin',
        credentials: 'same-origin',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            new_password: document.querySelector('input[type="password"]').value // password value
        })
    });

    // get response data
    let data = await response.json();

    // password successfully updated
    if (data.success) {

        // set localstorage to tell user that password was updated
        localStorage.setItem('password_successfully_updated', true);

        // redirect to login page
        window.location.replace('/login');
    }

    // something went wrong
    // display response message
    toast(data.message, data.success, 3000, true);
    setTimeout(() => {
        button.classList.remove('is-loading');
    }, 1000);
}