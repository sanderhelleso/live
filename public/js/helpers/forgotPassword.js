import { toast } from '../lib/toast';
import { VALIDATE } from '../helpers/validateForm';


export const FORGOTPASSWORD = {
    confirm
}

// modal input
let input;

function confirm() {

    // set inputs
    if (document.querySelector('.modal-forgot') !== null) {
        input = document.querySelector('.modal-forgot').querySelector('input');
    }

    // reset field error
    VALIDATE.clearForm(input);

    // check if field is empty
    if (!input.value) {

        // set status and message
        input.classList.add('is-danger');
        VALIDATE.setHelpMessage(input, 'empty');
        return;
    }

    else if (!VALIDATE.validate(input)) {;
        return;
    }

    // attempt to send reset password link
    sendForgotPassword(this);
}

async function sendForgotPassword(button) {

    // set loading status
    button.classList.add('is-loading');
    
    // send POST request update user password endpoint
    const response = await fetch('/api/forgotPassword/forgotPassword.php', {
        method: 'POST',
        mode: 'same-origin',
        credentials: 'same-origin',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            email: input.value
        })
    });

    // get response data
    let data = await response.json();


    // reset fields
    VALIDATE.clearForm(input);
    input.value = '';

    // dismiss modal
    document.querySelector('.hide-modal').click();

    // display response message
    toast(data.message, data.success, 6000, true);
    setTimeout(() => {
        button.classList.remove('is-loading');
    }, 1000);
}