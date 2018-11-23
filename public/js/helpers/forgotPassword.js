import { toast } from '../lib/toast';
import { HEADER } from '../helpers/authHeader';
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
    
    /*// create post body
    const body = {
        id: JSON.parse(localStorage.getItem('auth_token')).id,
        password: input.value
    }

    // send POST request update user password endpoint
    const response = await fetch('/api/user/deleteAccount.php', {
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

    // email successfully sendt
    if (data.success) {

        console.log(123);
    }  

    // email sending failed
    else {

        // display response message
        toast(data.message, data.success, 3000, true);
        setTimeout(() => {
            button.classList.remove('is-loading');
        }, 1000);
    }*/
}