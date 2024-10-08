class User{
    // User Data
    id = null;
    first_name = '';
    last_name = '';
    email = '';
    role = [];
    likedVehicles = [];
    createdVehicles = []

    constructor({id, first_name, last_name, email, role}){
        this.id = id;
        this.first_name = first_name;
        this.last_name = last_name;
        this.email = email;
        this.role = role;        
    }

    get asJson(){
        return {
            id: this.id,
            first_name: this.first_name,
            last_name: this.last_name,
            email: this.email,
            role: this.role
        }
    }  
}

export default User;