import { CHART } from './chart';

window.onload = initialize;

function initialize() {
    //CHART.initialize();

    // set user name in dashboard
    setTimeout(() => {
        const data = JSON.parse(localStorage.getItem('user_data'));
        if (data) {
            document.querySelector('#dashboard-name').innerHTML = `${data.first_name} ${data.last_name}`;
        }
    }, 100);
}