import { Button, Card } from "flowbite-react"

const VehicleCard = ({vehicle, isLikeable}) => {
    return (
        <Card key={Math.random().toString()}>
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
                <Button>
                    Like
                </Button>
            : ''}
        </Card>
    )
}

export default VehicleCard;