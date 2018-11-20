import { DATA } from './loadData';

document.addEventListener('DOMContentLoaded', async () => {

    // load users data and set into navbar
    const data = await DATA.loadUserData();
    DATA.setNavbarData(data);
    
});