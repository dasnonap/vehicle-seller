import { makeAutoObservable } from "mobx";

class CommonStore{
    token = null;

    constructor(){
        makeAutoObservable(this);
    }

    setToken(token){
        this.token = token;
    }
}

export default new CommonStore();