const BACKOFFICE_URL = 'http://localhost:8000/';
var userData = null;

async function fetchUserData() {
    if(userData !== null) return true;

    let resp = await fetch(BACKOFFICE_URL + 'api/me', {
        credentials: 'include'
    });
    if(resp.status !== 200) return false;
    
    // get user data
    userData = await resp.json();
    return true;
}

function getUserData() {
    return userData;
}

$(document).ready(function() {
    $('.unauthenticated').show();
    $('.authenticated').hide();

    fetchUserData().then(ret => {
        if(userData !== null) {
            $('.unauthenticated').hide();
            $('.authenticated').show();
        }
    });
});