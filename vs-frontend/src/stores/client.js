import axios from "axios";
import commonStore from "./commonStore";

const authHeaders = () => {
    if (!commonStore.token) {
        return {}
    }

    return {
        'X-AUTH-TOKEN': commonStore.token
    };
}

const request = {
    post: (endpoint, body) => {
        const url = import.meta.env.VITE_API_URL; 
        return axios.post(url + endpoint, body, {
            headers:{
                ...authHeaders()
            }
        });
    }
}
const Auth = {
    register: (first_name, last_name, email, password) => {
        return request.post('/register', {
            first_name: first_name,
            last_name: last_name,
            email: email,
            password: password
        });
    },
    current: () => {
        return request.post('/user/index');
    }
}

export default {
    Auth
};