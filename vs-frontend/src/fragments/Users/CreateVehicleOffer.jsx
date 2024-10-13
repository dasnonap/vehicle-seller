import { useState } from "react";
import { useForm } from "react-hook-form";
import Form from "../Form";
import TextControl from "../TextControl";
import RadioControl from "../RadioControl";
import SelectControl from "../SelectControl";
import { Button } from "flowbite-react";
import Vehicle from "../../data/Vehicle";
import vehicleStore from "../../stores/vehicleStore";

const CreateVehicleOffer = () => {
    const {
        register,
        handleSubmit,
        formState: {errors},
        reset,
    } = useForm();
    const [formErrors, setFormErrors] = useState();
    const [vehicleType, setVehicleType] = useState(null);

    const handleCreateOfferSubmit = (data) => {
        const vehicleArgs = {};
        const typeArgs = {};

        Object.keys(data).forEach(key => {
            if(key.includes('specs_')){
                let clearedKey = key;
                clearedKey = clearedKey.replaceAll('specs_', '');

                typeArgs[clearedKey] = data[key];
            } else {
                vehicleArgs[key] = data[key];
            }
        });

        const vehicle = new Vehicle(vehicleArgs);
        vehicle.type_args = typeArgs;
        
        vehicleStore.setVehicle(vehicle);

        vehicleStore.create()
        .then(() => reset())
        .catch((error) => {
            if (error.response) {
                setFormErrors(error.response.data.message);
            } else if (error.request) {
                setFormErrors(error.request);
            } else {
                setFormErrors('Error', error.message);
            }
        });
    }

    const handleOnTypeChange = (event) => {
        setVehicleType(event.target.value);
    }

    return (
        <div className="flex flex-col">
            <h1 className="text-3xl font-bold">
                Create Vehicle
            </h1>

            {formErrors ? (
                <h3>
                    {formErrors}
                </h3>
            ) : ''}

            <Form handleFormSubmit={handleSubmit(handleCreateOfferSubmit)}>
                <TextControl 
                    label={"Brand"}
                    name={'brand'} 
                    id={'brand'} 
                    defaultValue={''} 
                    register={register('brand', { required: true})}
                    isFieldError={errors.brand}
                    fieldError={"Specify the Vehicle brand."}
                />

                <TextControl 
                    label={"VIN"}
                    name={'vin'} 
                    id={'vin'} 
                    defaultValue={''} 
                    register={register('vin', { required: true})}
                    isFieldError={errors.vin}
                    fieldError={"Specify the Vehicle brand."}
                />

                <TextControl 
                    label={"Model"}
                    name={'model'} 
                    id={'model'} 
                    defaultValue={''} 
                    register={register('model', { required: true})}
                    isFieldError={errors.model}
                    fieldError={"Specify the Vehicle model."}
                />

                <TextControl 
                    label={"Price"}
                    name={'price'} 
                    id={'price'}
                    type={'number'}
                    defaultValue={''} 
                    register={register('price', { required: true})}
                    isFieldError={errors.model}
                    fieldError={"Specify the price."}
                />

                <TextControl 
                    label={"Quantity"}
                    name={'quantity'} 
                    id={'quantity'}
                    type={'number'}
                    defaultValue={''} 
                    register={register('quantity', { required: true})}
                    isFieldError={errors.quantity}
                    fieldError={"Specify the quantity."}
                />

                <RadioControl
                    label="Choose Vehicle type:"
                    name="specs_type"
                    id="specs_type"
                    register={register('specs_type', {required: true})}
                    selected={vehicleType}
                    values={
                        [
                            {
                                value: 'motorcycle',
                                name: 'motorcycle',
                                label: 'Motorcycle'
                            },
                            {
                                value: 'car',
                                name: 'car',
                                label: 'Car'
                            },
                            {
                                value: 'truck',
                                name: 'truck',
                                label: 'Truck'
                            },
                            {
                                value: 'trailer',
                                name: 'trailer',
                                label: 'Trailer'
                            },
                        ]
                    }
                    onChange={handleOnTypeChange}
                />

                <fieldset className="flex max-w-md flex-col gap-4">
                    <legend className="mb-4">
                        Vehicle Type Options
                    </legend>

                    { 
                        vehicleType == 'motorcycle' || 
                        vehicleType == 'car' || 
                        vehicleType == 'truck' 
                        ? 
                        <TextControl 
                        label={"Engine capacity"}
                        name={'specs_engine_capacity'} 
                        id={'specs_engine_capacity'}
                        type={'number'}
                        defaultValue={''} 
                        register={register('specs_engine_capacity', { required: true})}
                        isFieldError={errors.specs_capacity}
                        fieldError={"Specify the engine capacity."}
                        />
                        : ''}

                    { 
                        vehicleType == 'motorcycle' || 
                        vehicleType == 'car' ||
                        vehicleType == 'truck' 
                        ? 
                        <TextControl 
                        label={"Colour"}
                        name={'specs_colour'} 
                        id={'specs_colour'}
                        type={'string'}
                        defaultValue={''} 
                        register={register('specs_colour', { required: true})}
                        isFieldError={errors.specs_colour}
                        fieldError={"Specify the colour."}
                        />
                        : ''}

                    { 
                        vehicleType == 'car' 
                        ?
                        <TextControl 
                        label={"Doors"}
                        name={'specs_doors'} 
                        id={'specs_doors'}
                        type={'number'}
                        defaultValue={''} 
                        register={register('specs_doors', { required: true})}
                        isFieldError={errors.specs_doors}
                        fieldError={"Specify the car doors."}
                        />
                        : ''}

                    { 
                        vehicleType == 'car' 
                        ?
                        <SelectControl 
                        label={"Select car Category"}
                        name={'specs_category'} 
                        id={'specs_category'}
                        register={register('specs_category', { required: true})}
                        isFieldError={errors.specs_category}
                        fieldError={"Specify the car category."}
                        options={
                            [
                                {
                                    name: 'Hatchback',
                                    value: 'hatchback',
                                },
                                {
                                    name: 'SUV',
                                    value: 'suv'
                                },
                                {
                                    name: 'Sedan',
                                    value: 'sedan'
                                }
                            ]
                        }
                        />
                        : ''}

                    { 
                        vehicleType == 'truck' 
                        ?
                        <TextControl 
                        label={"Number of Beds"}
                        name={'specs_number_of_beds'} 
                        id={'specs_number_of_beds'}
                        type={'number'}
                        defaultValue={''} 
                        register={register('specs_number_of_beds', { required: true})}
                        isFieldError={errors.specs_number_of_beds}
                        fieldError={"Specify the truck number of beds."}
                        />
                        : ''}

                    { 
                        vehicleType == 'trailer' 
                        ?
                        <TextControl 
                        label={"Load Capacity"}
                        name={'specs_load_capacity'} 
                        id={'specs_load_capacity'}
                        type={'number'}
                        defaultValue={''} 
                        register={register('specs_load_capacity', { required: true})}
                        isFieldError={errors.specs_load_capacity}
                        fieldError={"Specify the trailer load capacity"}
                        />
                        : ''}

                    { 
                        vehicleType == 'trailer' 
                        ?
                        <TextControl 
                        label={"Number of Axels"}
                        name={'specs_number_of_axels'} 
                        id={'specs_number_of_axels'}
                        type={'number'}
                        defaultValue={''} 
                        register={register('specs_number_of_axels', { required: true})}
                        isFieldError={errors.specs_number_of_axels}
                        fieldError={"Specify the trailer number of axels"}
                        />
                    : ''}
                </fieldset>

                <Button type="submit" >
                   Create 
                </Button>
            </Form>
        </div>
    );
}

export default CreateVehicleOffer;