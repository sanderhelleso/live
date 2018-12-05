import { toast } from '../lib/toast.js';
import { HEADER } from '../helpers/authHeader.js';
import { VALIDATE } from '../helpers/validateForm.js';


export const DELETE = {
    confirm
}

// modal input
let input;

function confirm() {

    // set inputs
    if (document.querySelector('.modal-delete') !== null) {
        input = document.querySelector('.modal-delete').querySelector('input');
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

    // attempt to delete account
    deleteAccount(this);
}

async function deleteAccount(button) {

    // set loading status
    button.classList.add('is-loading');
    
    // create post body
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

    // account successfully deleted
    if (data.success) {

        // clear localstorage
        localStorage.clear();

        // set deleted account message
        localStorage.setItem('account_deleted_successfully', true);

        // redirect to login page
        window.location.replace('/login');
    }  

    // delete account failed
    else {

        // display response message
        toast(data.message, data.success, 3000, true);
        setTimeout(() => {
            button.classList.remove('is-loading');
        }, 1000);
    }
}