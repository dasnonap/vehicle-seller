import { makeAutoObservable } from "mobx";
import client from "./client";
import allVehiclesStore from "./allVehiclesStore";
class VehicleStore{
    vehicle = null;
    loadingPosts = false;

    constructor(){
        makeAutoObservable(this);
        console.log(this.loadingPosts);
    }

    setVehicle(vehicle){
        this.vehicle = vehicle;
    }
    
    getVehicles(){
        return this.allVehicles;
    }

    getLoadingPosts(){
        return this.loadingPosts;
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

    filterVehicles(){
        this.loadingPosts = true;

        return client.Vehicles.filter()
        .then(({data}) => {
            return allVehiclesStore.setAllVehicles(data.vehicles);
        })
        .catch((error) => {
            return Promise.reject(error);
        })
        .finally(() => this.loadingPosts = false);
    }
}

export default new VehicleStore();