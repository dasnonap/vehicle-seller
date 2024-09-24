import axios from "axios";

const request = {
    post: (endpoint, body) => {
        const url = import.meta.env.VITE_API_URL; 
        console.log(url);
        axios.post(url + endpoint, body);
    }
}
const Auth = {
    register(first_name, last_name, password, email){
        request.post('/register', { 
            first_name: first_name,
            last_name: last_name,
            password: password,
            email: email
        });
    }
}

export default {
    Auth
};