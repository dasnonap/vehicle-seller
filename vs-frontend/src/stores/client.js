import axios from "axios";

const request = {
    post: (endpoint, body) => {
        const url = import.meta.env.VITE_API_URL; 
        axios.post(url + endpoint, body);
    }
}
const Auth = {
    register: (first_name, last_name, email, password) => {
        request.post('/register', {
            first_name: first_name,
            last_name: last_name,
            email: email,
            password: password
        });
    },
    current: () => {
        request.post('/user/index');
    }
}

export default {
    Auth
};