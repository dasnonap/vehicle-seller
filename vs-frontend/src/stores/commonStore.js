import { makeAutoObservable, reaction } from "mobx";

class CommonStore{
    token = window.localStorage.getItem('token');

    constructor(){
        makeAutoObservable(this);

        reaction(
            () => this.token,
            token => {
                if (token) {
                    window.localStorage.setItem('token', this.token);
                } else {
                    window.localStorage.removeItem('token');
                }
            }
        )
    }

    setToken(token){
        this.token = token;
    }

    getToken(){
        return this.token;
    }
}

export default new CommonStore();