import { DATA } from './loadData';
import { LOGOUT } from '../logout';

document.addEventListener('DOMContentLoaded', async () => {

    // load users data and set into navbar
    const data = await DATA.loadUserData();
    DATA.setNavbarData(data);
    

    // set logout event
    document.querySelector('#log-out-btn').addEventListener('click', LOGOUT);
});