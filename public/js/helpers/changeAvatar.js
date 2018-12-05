import { toast } from '../lib/toast.js';
import { HEADER } from './authHeader.js';
import { DATA } from '../dashboard/loadData.js';

export const AVATAR = {
    selectAvatar
}

// prepeare input for file upload
const fileUpload = document.querySelector('#avatar-upload');
fileUpload.addEventListener('change', uploadAvatar);


const maxFileCapacity = 1048576; // max file capacity is set to 1MB
const minFileCapacity = 10240; // min file capacity is set to 10KB

function selectAvatar() {

    // open file input
    fileUpload.click();
}

function validFile() {

    // get file from input
    const file = fileUpload.files[0];

    console.log(file);

    // only allow png and jpeg
    if (file.type.split('/')[0] !== 'image') {
        toast('Wrong file format. Only images are allowed', false, 3000);
        return false;
    }

    // only allow files less than capacity (1MB)
    if (file.size < minFileCapacity) {
        toast('Image is to small. Image must be atleast 10KB to ensure quality', false, 3000);
        return false;
    }

    // only allow files less than capacity (1MB)
    if (file.size > maxFileCapacity) {
        toast('Image is to large. Only images up to 1MB allowed', false, 3000);
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

