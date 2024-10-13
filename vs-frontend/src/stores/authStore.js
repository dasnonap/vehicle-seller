import { makeAutoObservable } from "mobx";
import client from "./client";
import userStore from "./userStore";
import commonStore from "./commonStore";

class AuthStore{
    values = {
        first_name: '',
        last_name: '',
        email : '',
        password : '',
        role: ''
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
        this.logout();

        return client.Auth.register(
            this.values.first_name, this.values.last_name, this.values.email, this.values.password, this.values.role
        )
        .then((response) => {
            commonStore.setToken(response.data.token);
        })
        .catch((error) => {
           return Promise.reject(error);
        });
    }

    login(){
        this.logout();
        
        return client.Auth.login(
            this.values.email,
            this.values.password 
        )
        .then((response) => {
            commonStore.setToken(response.data.token);
        })
        .catch((error) => {
            return Promise.reject(error);
        });
    }

    logout(){
        commonStore.setToken(undefined);
        userStore.forgetUser();
    }
}

export default new AuthStore();