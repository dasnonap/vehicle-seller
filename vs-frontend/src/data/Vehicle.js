class Vehicle{
    id = null;
    brand = '';
    vin = '';
    model = '';
    price = 0;
    quantity = 0;
    user = '';
    type_args = [];

    constructor({id, brand, vin, model, price, quantity, user}){
        this.id = id;
        this.brand = brand;
        this.vin = vin;
        this.model = model;
        this.price = price;
        this.quantity = quantity;
        this.user = user;
    }

    setTypeArgs(args){
        this.type_args = args;
    }

    asJson(){
        return {
            vehicle_args: {
                id: this.id,
                brand: this.brand,
                vin: this.vin,
                model: this.model,
                price: this.price,
                quantity: this.quantity
            },
            type_specs: {...this.type_args},
        }

    }  
}

export default Vehicle;