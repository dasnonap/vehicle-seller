import {makeAutoObservable, action} from 'mobx';
import client from './client';
import User from '../data/User';
import commonStore from './commonStore'; 
import { redirect } from 'react-router-dom';
class UserStore{
    currentUser = null;
    loadingUser;

    constructor(){
        makeAutoObservable(this);

        this.loadUserFromServer();
    }

    getCurrentUser(){
        return this.currentUser;
    }

    setCurrentUser(user){
        this.currentUser = user;
    }
    
    pullUser(){
        this.loadingUser = true;
        return client.Auth.current()
            .then(action(
                ({data}) => {
                    this.setCurrentUser(new User(data.user));
                }
            ))
            .finally(action(() => this.loadingUser = false))
        
    }

    forgetUser(){
        this.currentUser = undefined;
    }

    async loadUserFromServer(){
        const token = commonStore.getToken();

        if (token) {
            console.log(token);
            await this.pullUser()
        } else {
            redirect('/login');
        }
    }
}


export default new UserStore();