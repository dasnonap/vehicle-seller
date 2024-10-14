import { makeAutoObservable } from "mobx";

class AllVehiclesStore{
    vehicles = null;

    constructor(){
        makeAutoObservable(this);
    }

    setAllVehicles(vehicles){
        this.vehicles = vehicles;
    }

    getAllVehicles(){
        return this.vehicles;
    }
}

export default new AllVehiclesStore();