import { VALIDATE } from '../helpers/validateForm.js';
import { PASSWORD } from '../helpers/changePassword.js';
import { DELETE } from './deleteAccount.js';
import { FORGOTPASSWORD } from './forgotPassword.js';

export const MODAL = {
    open,
    dismiss
}

// modal
let modal;

// input fields
let inputs;

// open modal and ask user to enter current password
function open(modalType) {

    // set modal type
    modal = document.querySelector(`.modal-${modalType}`);

    // set modal inputs
    inputs = Array.from(modal.querySelectorAll('input[type="text"], input[type="password"], textarea'));

    // opem modal
    modal.classList.add('is-active');

    // focus first input to allow user to "tab" inputs immediatly
    if (inputs.length > 0) {
        inputs[0].focus();
    }

    // allow user to dismiss modal by clicking on "cancel" or background
    Array.from(modal.querySelectorAll('.hide-modal')).forEach(ele => {
        ele.addEventListener('click', () => {
            dismiss();
        });
    });

    // add event to handle confirmation
    let event;
    if (modalType === 'password') {
        event = PASSWORD.validate;
    }

    else if (modalType === 'delete') {
        event = DELETE.confirm;
    }

    else if (modalType === 'forgot') { 
        event = FORGOTPASSWORD.confirm;
    }

    modal.querySelector('.confirm').addEventListener('click', event);

    // allow user to send form by pressing enter key
    modal.addEventListener('keydown', sendFormOnEnter);
}

function sendFormOnEnter(e) {
    if (e.keyCode === 13) {
        modal.querySelector('.confirm').click();
    }
}

function dismiss() {

    // unbind press enter event
    modal.removeEventListener('click', sendFormOnEnter, false);

    // modal bg
    const bg = modal.querySelector('.modal-background');
    bg.className = 'modal-background animated fadeOut';

    const modalCard = modal.querySelector('.modal-card');
    modalCard.className = 'modal-card animated fadeOut';

    setTimeout(() => {
        bg.className = 'modal-background animated fadeIn hide-modal';
        modalCard.className = 'modal-card animated fadeIn';

        // remove modal
        modal.classList.remove('is-active');

        // clear fields
        inputs.forEach(input => {
            VALIDATE.clearForm(input);
            input.value = '';
        });
    }, 1000);
}