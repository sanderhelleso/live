import { DATA } from './data';

export const LOCATION = {
    countryAndStates,
    setStates
}

let userSettings;
function countryAndStates(settings) {

    if (settings) {
        userSettings = true;
    }

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

        // set US to default if no Country is selected
        const selectedCountry = userSettings ? JSON.parse(localStorage.getItem('user_data')).country : 'United States';
        if (country === selectedCountry) {
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

                    // set selected state as selected option
                    if (userSettings) {
                        if (option.value === JSON.parse(localStorage.getItem('user_data')).state) {
                            option.selected = true;
                        }
                    }

                    //append to state select
                    states.appendChild(option);
                });
            }
        }
    });
}