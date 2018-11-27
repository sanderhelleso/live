import { DATA } from './loadData';

window.onload = initialize;

async function initialize() {

    // set users name
    const data = await DATA.loadUserData();
    DATA.setName(data, 'dashboard-name');
}