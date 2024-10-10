class User{
    // User Data
    id = null;
    first_name = '';
    last_name = '';
    email = '';
    roles = [];
    likedVehicles = [];
    createdVehicles = []

    constructor({id, first_name, last_name, email, roles}){
        this.id = id;
        this.first_name = first_name;
        this.last_name = last_name;
        this.email = email;
        this.roles = roles;        
    }

    get asJson(){
        return {
            id: this.id,
            first_name: this.first_name,
            last_name: this.last_name,
            email: this.email,
            roles: this.roles
        }
    }  
}

export default User;