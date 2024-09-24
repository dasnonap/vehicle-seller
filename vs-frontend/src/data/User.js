import { reaction, makeAutoObservable } from "mobx";

class User{
    // User Data
    id = null;
    first_name = '';
    last_name = '';
    password = '';
    email = '';

    // Store 
    store = null;
    saveHandler = null;

    constructor(store){
        this.store = store;

        makeAutoObservable(this, {
            this.
        });

        this.saveHandler = reaction(
            () => this.asJson,
            json => {
                if (this.autoSave) {
                    this.store.updateUser(json)
                }
            }
        );
    }

    get asJson(){
        return {
            id: this.id,
            first_name: this.first_name,
            last_name: this.last_name,
            password: this.password,
            email: this.email
        }
    }

    fromJson(userJsonData){
        this.autoSave = false;

        this.id = userJsonData.id;
        this.first_name = userJsonData.first_name;
        this.last_name = userJsonData.last_name;
        this.password = userJsonData.password;
        this.email = userJsonData.email;

        this.autoSave = true;
    }


}