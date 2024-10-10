import { makeAutoObservable } from "mobx";
import client from "./client";
import userStore from "./userStore";
import commonStore from "./commonStore";

class AuthStore{
    values = {
        first_name: '',
        last_name: '',
        email : '',
        password : ''
    };
    errors = null;

    constructor(){
        makeAutoObservable(this);
    }

    setValues(values){
        this.values = values;
    }

    setFirstName(first_name){
        this.values.first_name = first_name;
    }

    setLastName(last_name){
        this.values.last_name = last_name;
    }

    setEmail(email){
        this.values.email = email;
    }

    setPassword(password){
        this.values.password = password;
    }

    register(){
        return client.Auth.register(
            this.values.first_name, this.values.last_name, this.values.email, this.values.password
        ).then((response) => {
            commonStore.setToken(response.data.token);
        }).then(() => {
            userStore.pullUser()
        }).catch((error) => {
            if (error.response) {
                console.log(error.response.data.message);
            } else if (error.request) {
                console.log(error.request);
            } else {
                console.log('Error', error.message);
            }
        });
    }

    logout(){
        commonStore.setToken(undefined);
        userStore.forgetUser();
    }
}

export default new AuthStore();