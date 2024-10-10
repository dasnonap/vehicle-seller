import {makeAutoObservable, action} from 'mobx';
import client from './client';
import User from '../data/User';

class UserStore{
    currentUser = null;

    constructor(){
        makeAutoObservable(this);
    }

    getCurrentUser(){
        return this.currentUser;
    }

    setCurrentUser(user){
        this.currentUser = user;
    }
    
    pullUser(){
        return client.Auth.current()
            .then(action(
                ({data}) => {
                    this.setCurrentUser(new User(data.user));
                }
            )
        )
    }

    forgetUser(){
        this.currentUser = undefined;
    }
}


export default new UserStore();