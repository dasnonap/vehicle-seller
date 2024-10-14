import { Button, Card } from "flowbite-react"
import client from "../stores/client";
import { useState } from "react";

const VehicleCard = ({vehicle, isLikeable}) => {
    const [likeError, setLikeError] = useState();
    const [likeSuccess, setLikeSuccess] = useState(false);

    const handleOnLikeClicked = (event) => {
        event.preventDefault();

        client.Vehicles.like(vehicle.id)
        .then((response) => {
            setLikeSuccess(response.data.response);
        })
        .catch((error) => {
            if (error.response) {
                setLikeError(error.response.data.message);
            } else if (error.request) {
                setLikeError(error.request);
            } else {
                setLikeError('Error', error.message);
            }
        })
    }
    
    return (
        <Card key={Math.random().toString()}>
            {likeError ?
                <p className="color-red">
                    {likeError}
                </p> 
            : ''}

            {likeSuccess ?
                <p>Vehicle Saved</p> 
            : ''}
            <div>
                <h2>
                    {`${vehicle.type_args.type} - ${vehicle.brand} | ${vehicle.model} `}<br />

                    <sub>{`VIN: ${vehicle.vin}`}</sub>
                </h2>

                <h3>{vehicle.user}</h3>

                <h4>{`Price: ${vehicle.price} | Quantity: ${vehicle.quantity}`}</h4>
            </div>

            <div className="grid">
                {Object.keys(vehicle.type_args).map((key) => {
                    return (
                        <span key={Math.random().toString()}>{`${key}: ${vehicle.type_args[key]}`}</span>
                    ) 
                })}
            </div>

            {isLikeable ? 
                <Button onClick={handleOnLikeClicked}>
                    Like
                </Button>
            : ''}
        </Card>
    )
}

export default VehicleCard;