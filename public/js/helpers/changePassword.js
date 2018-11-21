import { toast } from '../lib/toast';
import { HEADER } from '../helpers/authHeader';
import { VALIDATE } from '../helpers/validateForm';

export const PASSWORD = {
    open,
    validate
}

// modal
const modal = document.querySelector('.modal');

// input fields
const inputs = Array.from(document.querySelector('.modal').querySelectorAll('input'));

// open modal and ask user to enter current password
function open() {

    // opem modal
    modal.classList.add('is-active');

    // focus first input to allow user to "tab" inputs immediatly
    inputs[0].focus();

    // allow user to dismiss modal by clicking on "cancel" or background
    Array.from(document.querySelectorAll('.hide-modal')).forEach(dismiss => {
        dismiss.addEventListener('click', () => {
            dismissModal();
        });
    });

    // add event to handle password on "confirm password" click
    document.querySelector('#confirm-update-password').addEventListener('click', validate);

    // allow user to send form by pressing enter key
    modal.addEventListener('keydown', sendFormOnEnter)
}

function sendFormOnEnter(e) {
    if (e.keyCode === 13) {
        document.querySelector('#confirm-update-password').click();
    }
}

function validate() {

    let isValid = false;
    let isEmpty = false;

    // itterate over all form fields
    inputs.forEach(input => {

        // get all fields except checkbox
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

function dismissModal() {

    // unbind prss enter event
    modal.removeEventListener('click', sendFormOnEnter, false);

    // clear fields
    inputs.forEach(input => {
        VALIDATE.clearForm(input);
        input.value = '';
    });

    // modal bg
    const bg = document.querySelector('.modal-background');
    bg.className = 'modal-background animated fadeOut';

    const modalCard = document.querySelector('.modal-card');
    modalCard.className = 'modal-card animated fadeOut';

    setTimeout(() => {
        bg.className = 'modal-background animated fadeIn hide-modal';
        modalCard.className = 'modal-card animated fadeIn';

        // remove modal
        modal.classList.remove('is-active');
    }, 1000);
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