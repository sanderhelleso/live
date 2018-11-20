export const HEADER = () => {

    // return authorization header containing auth token if present
    const authToken = localStorage.getItem('auth_token');
    if (authToken) {
        return { 'Authorization': `Bearer ${JSON.parse(authToken).token}` };
    } 
    
    else {
        return {};
    }
}
