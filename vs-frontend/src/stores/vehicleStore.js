import { makeAutoObservable } from "mobx";
import client from "./client";

class VehicleStore{
    vehicle = null;

    constructor(){
        makeAutoObservable(this);
    }

    setVehicle(vehicle){
        this.vehicle = vehicle;
    }

    create(){
        return client.Vehicles.create(this.vehicle)
        .then((response) => {
          console.log(response);  
        })
        .catch((error) => {
            return Promise.reject(error);
        })
    }
}

export default new VehicleStore();