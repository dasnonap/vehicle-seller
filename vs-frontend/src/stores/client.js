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
    },
    get: (endpoint) => {
        const url = import.meta.env.VITE_API_URL;
        return axios.get(url + endpoint, {
            headers:{
                ...authHeaders()
            }
        })
    }
}
const Auth = {
    register: (first_name, last_name, email, password, role) => {
        return request.post('/register', {
            first_name: first_name,
            last_name: last_name,
            email: email,
            password: password,
            role: role
        });
    },
    current: () => {
        return request.post('/user/index');
    },
    login: (email, password) => {
        return request.post('/login',{
            email: email,
            password: password
        });
    }
}

const Vehicles = {
    create: (vehicle) => {
        return request.post('/vehicles/create', {
            ...vehicle.asJson()
        });
    },
    filter: () => {
        return request.get('/vehicles');
    },
    like: (vehicle_id) =>{
        return request.get(`/vehicles/${vehicle_id}/like`);
    }
}

export default {
    Auth,
    Vehicles
};