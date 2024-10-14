// import userStore from "../stores/userStore";
import vehicleStore from "../stores/vehicleStore";
import VehicleCard from "./VehicleCard";
import Vehicle from "../data/Vehicle";
import { observer } from "mobx-react";
import allVehiclesStore from "../stores/allVehiclesStore";
import { useEffect } from "react";
import userStore from "../stores/userStore";

const VehiclesListing = observer(() => {
    useEffect(() => {
        vehicleStore.filterVehicles();
    }, [])
    
    if (vehicleStore.loadingPosts || ! allVehiclesStore.getAllVehicles()) {
        return 'loading...'
    }

    const allVehicles = allVehiclesStore.getAllVehicles();
    const user = userStore.getCurrentUser()

    return (
        <div>
            <h1 className="mb-4">All Vehicles</h1>

            <div className="grid grid-cols-2 gap-6">
                {allVehicles.map((vehicleData) => {
                    const vehicle = new Vehicle(vehicleData.vehicle_specs);

                    vehicle.type_args = vehicleData.type_specs;
                    return (
                        <VehicleCard
                            vehicle={vehicle}
                            key={Math.random().toString()}
                            isLikeable={user.canLike()}
                        />
                    )
                })}
            </div>
        </div>
    );
});

export default VehiclesListing;