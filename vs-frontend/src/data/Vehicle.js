class Vehicle{
    id = null;
    brand = '';
    vin = '';
    model = '';
    price = 0;
    quantity = 0;
    type_args = [];

    constructor({id, brand, vin, model, price, quantity}){
        this.id = id;
        this.brand = brand;
        this.vin = vin;
        this.model = model;
        this.price = price;
        this.quantity = quantity;
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