import { DATA } from './lib/countriesAndStates/data';
import { REGEX } from './helpers/regex';

window.onload = initialize;

function initialize() {

    // fetch country and state data for select options
    countryAndStates();

    // prepeare form validation when attempting to submit form
    document.querySelector('#signup-btn').addEventListener('click', validateForm);
   
}

function countryAndStates() {

    // select country element
    const countries = document.querySelector('#select-country');

    // add event to set corresponding country states
    countries.addEventListener('change', setStates);

    // itterate over country and state data
    Object.keys(DATA).forEach((key) => { 

        // get country
        const country = DATA[key].country; 

        // create country option and set data
        const option = document.createElement('option');
        option.innerHTML = country
        option.value = country

        // set US to default
        if (country === 'United States') {
            option.selected = true;

            setTimeout(() => {
                // create a new 'change' event
                const event = new Event('change');

                // dispatch event to trigger country states change
                countries.dispatchEvent(event);

            }, 1); // wait until all options are created and inserted into select
        }

        //append to country select
        countries.appendChild(option);
    });
}

function setStates() {
    
    // select state element
    const states = document.querySelector('#select-state');

    // clear previous sat options
    while (states.firstChild) {
        states.removeChild(states.firstChild);
    }

    // itterate over country and state data
    Object.keys(DATA).forEach(key => { 

        // find matching states to country selected
        if (this.value === DATA[key].country) {

            // if country dont have any states (small countries like Monaco etc..)
            // set state to the country itself
            if (DATA[key].states.length === 0) {

                // create state option and set data
                const option = document.createElement('option');
                option.innerHTML = this.value;
                option.value = this.value;

                //append to state select
                states.appendChild(option);
            }

            else {

                // itterate over countries states
                DATA[key].states.forEach(state => {

                    // create state option and set data
                    const option = document.createElement('option');
                    option.innerHTML = state;
                    option.value = state;

                    //append to state select
                    states.appendChild(option);
                });
            }
        }
    });
}

function validateForm(e) {

    // set form status to valid as default
    let valid = true;

    // prevent page from reloading
    e.preventDefault();

    // itterate over all form fields
    Array.from(document.querySelectorAll('input, select')).forEach(input => {

        // get all fields except checkbox
        if (input.type !== 'checkbox') {
            clearForm(input);

            // check if any form fields are empty
            if (!input.value) {

                // set status and message
                input.classList.add('is-danger');
                setHelpMessage(input, 'empty')
                valid = false;

            }

            // attempt to validate fields, if any field fails required test, form is set to invalid
            else {
                
                // validat first and last name
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
            }
        }
    });

    // form is valid, post request here
    console.log(valid);
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
            help.innerHTML = 'Can only contain letters and must be between 2 - 30 characters';
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

function clearForm(input) {

    // reset field and help message
    input.classList.remove('is-danger', 'is-primary');
    setHelpMessage(input, 'clear');
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
    if (input.value < 13) {

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