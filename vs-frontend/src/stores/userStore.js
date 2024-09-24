import {makeAutoObservable, observable, action, flow} from 'mobx';
import client from './client';

class UserStore{
    values;

    constructor(values){
        makeAutoObservable(this, {
            values: observable,
            setValues: action,
            reset: action,
            login: flow,
            register: flow,
        });

        this.values = values;
    }

    setValues(values){
        this.values = values;
    }

    reset(){
        this.values = {};
    }

    login(){
        
    }

    register(){
        return client.Auth.register(this.values.first_name, this.values.last_name, this.values.password, this.values.email)
        .then(({user}) => );
    }
}


export default UserStore;