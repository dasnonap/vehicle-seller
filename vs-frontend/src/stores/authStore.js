import { makeAutoObservable, action } from "mobx";
import client from "./client";
import UserStore from "./userStore";

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
        return client.Auth.register(this.values.first_name, this.values.last_name, this.values.email, this.values.password).then(({user}) => UserStore.pullUser()).catch(action((err)=>{
            this.errors = err.message;
        }))
    }
}

export default new AuthStore();