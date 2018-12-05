import { REGEX } from './regex.js';

export const VALIDATE = {
    setHelpMessage,
    validate,
    formData,
    clearForm
}

function formData(settings) {

    const form = {};

    // itterate over all form fields
    Array.from(document.querySelectorAll('input, select')).forEach(input => {

        // if checkbox, retireve checked value
        if (input.type === 'checkbox') {
            form[input.name] = input.checked ? 1 : 0;
        }

        // else we set properties to object
        else {
            form[input.name] = input.value;
        }
    });

    // if updating settings, also pass in users ID
    if (settings) {
        form.id = JSON.parse(localStorage.getItem('auth_token')).id;

        // check if user is attempting to update equal email
        if (form.email === JSON.parse(localStorage.getItem('user_data')).email) {
            delete form.email;
        }
    }

    // return form object containing the form data
    return JSON.stringify(form);
}

function clearForm(input) {

    // reset field and help message
    input.classList.remove('is-danger', 'is-primary');
    setHelpMessage(input, 'clear');
}

function validate(input) {

    // set form status to valid as default
    let valid = true;

    // validate first and last name
    if (input.classList.contains('firstName-input') || input.classList.contains('lastName-input')) {
        if (!validateName(input)) {
            valid = false;
        }
    }

    // validate email
    else if (input.classList.contains('email-input')) {
        if (!validateEmail(input)) {
            valid = false;
        }
    }

    // validate age
    else if (input.classList.contains('age-input')) {
        if (!validateAge(input)) {
            valid = false;
        }
    }

    // validate country and state
    else if (input.id === 'select-country' || input.id === 'select-state') {
        if (!validateCountryAndState(input)) {
            valid = false;
        }
    }

    // validate street address
    else if (input.classList.contains('address-input')) {
        if (!validateAddress(input)) {
            valid = false;
        }
    }

    // validate street address
    else if (input.classList.contains('phone-input')) {
        if (!validatePhone(input)) {
            valid = false;
        }
    }

    // validate password
    else if (input.classList.contains('password-input')) {
        if (!validatePassword(input)) {
            valid = false;
        }
    }

    // validate confirm password
    else if (input.classList.contains('confirmPassword-input')) {
        if (!validateConfirmPassword(input)) {
            valid = false;
        }
    }

    return valid;
}

function validateName(input) {

    // validate name value 
    if (REGEX.name().test(input.value)) {

        // set field status
        input.classList.add('is-primary');
        return true;
    }

    // set status and message
    input.classList.add('is-danger');
    setHelpMessage(input, 'invalid_name');
    return false;
}

function validateEmail(input) {

    // validate email value 
    if (REGEX.email().test(input.value)) {

        // set field status
        input.classList.add('is-primary');
        return true;
    }

    // set status and message
    input.classList.add('is-danger');
    setHelpMessage(input, 'invalid_email');
    return false;
}

function validateAge(input) {

    // validate age value, must be atleast of age 14 and no older than 100
    if (input.value < 14) {

        // set status and message
        input.classList.add('is-danger');
        setHelpMessage(input, 'invalid_age_young')
        return false;
    }

    else if (input.value > 100) {

        // set status and message
        input.classList.add('is-danger');
        setHelpMessage(input, 'invalid_age_old');
        return false;
    }

    // set field status
    input.classList.add('is-primary');
    return true;
}

function validateAddress(input) {

     // validate address value 
     if (REGEX.address().test(input.value)) {

        // set field status
        input.classList.add('is-primary');
        return true;
    }

    // set status and message
    input.classList.add('is-danger');
    setHelpMessage(input, 'invalid_address');
    return false;
}

function validatePhone(input) {

    // validate address value 
    if (REGEX.phone().test(input.value)) {

       // set field status
       input.classList.add('is-primary');
       return true;
   }

   // set status and message
   input.classList.add('is-danger');
   setHelpMessage(input, 'invalid_phone');
   return false;
}

function validatePassword(input) {

    // validate address value 
    if (REGEX.password().test(input.value)) {

       // set field status
       input.classList.add('is-primary');
       return true;
   }

   // set status and message
   input.classList.add('is-danger');
   setHelpMessage(input, 'invalid_password');
   return false;
}

function validateConfirmPassword(input) {

    // validate address value 
    if (input.value === document.querySelector('.password-input').value) {

       // set field status
       input.classList.add('is-primary');
       return true;
   }

   // set status and message
   input.classList.add('is-danger');
   setHelpMessage(input, 'invalid_password_mismatch');
   return false;
}

function validateCountryAndState(select) {

    // validate select option value 
    if (select.value) {

        // set field status
        select.parentElement.classList.add('is-primary');
        return true;
    }
 
    // set status and message
    select.parentElement.classList.add('is-danger');
    setHelpMessage(select, 'invalid_countryOrState');
    return false;
}

function setHelpMessage(element, status) {
    
    // helper element
    const help = element.parentElement.querySelector('p');

    // set helper message depending on status
    switch (status) {
        case 'clear':
            help.innerHTML = '';
            break;

        case 'empty':
            help.innerHTML = 'Field cant be empty';
            break;

        case 'invalid_name':
            help.innerHTML = 'Can only contain letters and must be between 2 - 50 characters';
            break;

        case 'invalid_email':
            help.innerHTML = 'Invalid E-Mail format';
            break;

        case 'invalid_age_young':
            help.innerHTML = 'You must be atleast of age 14 to use this service';
            break;
        
        case 'invalid_age_old':
            help.innerHTML = 'You can not be older than 100 years of age to use this service';
            break;

        case 'invalid_countryOrState':
            help.innerHTML = 'Selected option is invalid';
            break;

        case 'invalid_address':
            help.innerHTML = 'Invalid Street Address';
            break;

        case 'invalid_phone':
            help.innerHTML = 'Invalid Phone Number';
            break;

        case 'invalid_password':
            help.innerHTML = 'Password must include atleast 8 characters and contain 1 numeric, 1 lowercase and 1 uppercase character';
            break;

        case 'invalid_password_mismatch':
            help.innerHTML = 'Passwords do not match';
            break;
    }
}