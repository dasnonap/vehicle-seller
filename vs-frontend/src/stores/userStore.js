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
    
    pullUser(){
        return client.Auth.current()
            .then(action(
                ({response}) => {
                    const user = response.user;
                    this.currentUser = new User(user.id, user.first_name, user.last_name, user.email, user.roles);
                }
            )
        )
    }
}


export default UserStore;