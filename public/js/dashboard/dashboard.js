import { DATA } from './loadData';
import { RECENT_ACTION } from '../helpers/recentActionNotification';

window.onload = initialize;

async function initialize() {

    // check for recent actions
    RECENT_ACTION.deletedOffer();

    // set users name
    const data = await DATA.loadUserData();
    DATA.setName(data, 'dashboard-name');
}