import { DATA } from './loadData.js';
import { LOGOUT } from '../logout.js';

document.addEventListener('DOMContentLoaded', async () => {

    // load users data and set into navbar
    const data = await DATA.loadUserData();
    DATA.setNavbarData(data, 'user-settings-name');
    

    // set logout event
    document.querySelector('#log-out-btn').addEventListener('click', LOGOUT);
});