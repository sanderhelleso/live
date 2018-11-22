import { toast } from '../lib/toast';
import { HEADER } from '../helpers/authHeader';
import { VALIDATE } from '../helpers/validateForm';


export const DELETE = {
    confirm
}

// modal input
let input = document.querySelector('.modal-delete').querySelector('input');

function confirm() {

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
        password: document.querySelector('.currentPassword-input').value
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
    //let data = await response.json();
}