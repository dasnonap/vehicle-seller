import { observer } from "mobx-react"
import userStore from "../stores/userStore";
import { useNavigate } from "react-router-dom";
import commonStore from "../stores/commonStore";
import LikedVehicles from "../fragments/Users/LikedVehicles";
import CreateVehicleOffer from "../fragments/Users/CreateVehicleOffer";
import VehiclesListing from "../fragments/VehiclesListing";
import CreatedVehicles from "../fragments/Users/CreatedVehicles";

const Home = observer(() => {
    const navigate = useNavigate();
    const token = commonStore.getToken();

    if (!token) {
        return navigate('/login');
    }

    if(userStore.loadingUser){
        return 'loading...';
    } else {
        const user = userStore.getCurrentUser();
    
        return (
            <div >
                <h2 className="">
                    Hello again, {user.first_name}, {user.roles[0]}
                </h2> 

                { user.roles[0] == 'ROLE_VIEWER' ?
                    <>
                        <LikedVehicles 
                        vehicles={user.likedVehicles}
                        /> 

                    </>
                : ''}

                { user.roles[0] == 'ROLE_CREATOR' ?
                    <>
                        <CreateVehicleOffer />

                        <CreatedVehicles
                            vehicles={user.createdVehicles}
                        />
                    </>
                : ''}

                <VehiclesListing />
            </div>
        )
    }

});

export default Home;