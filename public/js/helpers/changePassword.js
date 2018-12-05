import { toast } from '../lib/toast.js';
import { HEADER } from '../helpers/authHeader.js';
import { VALIDATE } from '../helpers/validateForm.js';

export const PASSWORD = {
    validate
}

// modal inputs
let inputs;

function validate() {

    // set inputs
    if (document.querySelector('.modal-password') !== null) {
        inputs = document.querySelector('.modal-password').querySelectorAll('input');
    }

    let isValid = false;
    let isEmpty = false;

    // itterate over all form fields
    inputs.forEach(input => {
        VALIDATE.clearForm(input);

        // check if any form fields are empty
        if (!input.value) {

            // set status and message
            input.classList.add('is-danger');
            VALIDATE.setHelpMessage(input, 'empty');
            isValid = false;
            isEmpty = true;
        }

        else {
            isValid = VALIDATE.validate(input);
            if (!isValid) {
                isEmpty = true;
            }
        }
    });

    if (isValid && !isEmpty) {
        changePassword(this);
    }
}

async function changePassword(button) {

    // set loading status
    button.classList.add('is-loading');
    
    // create post body
    const body = {
        id: JSON.parse(localStorage.getItem('auth_token')).id,
        new_password: document.querySelector('.password-input').value,
        password: document.querySelector('.currentPassword-input').value
    }

    // send POST request update user password endpoint
    const response = await fetch('/api/user/updatePassword.php', {
        method: 'POST',
        mode: 'same-origin',
        credentials: 'same-origin',
        headers: {
            ...HEADER(),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(body)
    });

    // get response data
    let data = await response.json();

    // password successfully updated
    if (data.success) {

        // clear form
        inputs.forEach(input => {

            // reset fields
            VALIDATE.clearForm(input);
            input.value = '';
        });

        // dismiss modal
        document.querySelector('.hide-modal').click();
    }

    // display response message
    toast(data.message, data.success, 3000, true);
    setTimeout(() => {
        button.classList.remove('is-loading');
    }, 1000);
}