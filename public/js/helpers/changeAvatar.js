import { toast } from '../lib/toast';
import { HEADER } from './authHeader';
import { DATA } from '../dashboard/loadData';

export const AVATAR = {
    selectAvatar
}

// prepeare input for file upload
const fileUpload = document.querySelector('#avatar-upload');
fileUpload.addEventListener('change', uploadAvatar);

// max file capacity is set to 2MB
const fileCapacity = 2097152;

function selectAvatar() {

    // open file input
    fileUpload.click();
}

function validFile() {

    // get file from input
    const file = fileUpload.files[0];

    // only allow png and jpeg
    if (file.type.split('/')[0] !== 'image') {
        toast('Wrong file format. Only images are allowed', false, 3000);
        return false;
    }

    // only allow files less than capacity (2MB)
    if (file.size > fileCapacity) {
        toast('Image is to large. Only images up to 2MB allowed', false, 3000);
        return false;
    }

    return true;
}

async function uploadAvatar() {

    if (validFile()) {

        // create new form data
        const body = new FormData();
        body.append('file', fileUpload.files[0]); // file blob
        body.append('id', JSON.parse(localStorage.getItem('auth_token')).id); // user id

        // send POST request update user endpoint
        const response = await fetch('/api/user/updateAvatar.php', {
            method: 'POST',
            mode: 'same-origin',
            credentials: 'same-origin',
            headers: {
                ...HEADER(),
                'Accept': 'application/json',
                'Content-Type': 'multipart/form-data' // set type to handle file
            },
            body: body
        });

        // get response data
        let data = await response.json();

        // settings successfully updated
        if (data.success) {

            // remove old data
            localStorage.removeItem('user_data');

            // set the updated data
            const data = await DATA.loadUserData();
            DATA.setNavbarData(data);
            
            // update main avatar
            DATA.setAvatar(document.querySelector('#user-avatar-upload-img'), data);
        }

        // display response message
        toast(data.message, data.success, 3000);
    }

}

