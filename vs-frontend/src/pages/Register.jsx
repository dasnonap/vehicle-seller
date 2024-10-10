import { useForm } from "react-hook-form";
import Form from "../fragments/Form";
import TextInput from "../fragments/TextInput";
import authStore from "../stores/authStore";
import { observer } from "mobx-react";
import { useNavigate } from "react-router-dom";
import { useState } from "react";

const Register = observer(() => {
    const {
        register,
        handleSubmit,
        formState: { errors },
    } = useForm();
    const navigate = useNavigate();
    const [formErrors, setFormErrors] = useState()

    const handleRegisterFormSubmit = (data) => {
        authStore.setValues(data);

        authStore.register()
        .then(() => navigate("/home", {replace: true}))
        .catch((error) => {
            if (error.response) {
                setFormErrors(error.response.data.message);
            } else if (error.request) {
                setFormErrors(error.request);
            } else {
                setFormErrors('Error', error.message);
            }
        })
    }

    return (
        <div className="bg-red">
            <h1 className="text-3xl font-bold underline">Register</h1>
            
            {formErrors ? (
                <h3>
                    {formErrors}
                </h3>
            ) : ''}
            
            <Form handleFormSubmit={handleSubmit(handleRegisterFormSubmit)}>
                <TextInput 
                    label={"First Name"}
                    name={'first_name'} 
                    id={'first_name'} 
                    defaultValue={''} 
                    register={register('first_name', { required: true, })}
                    isFieldError={errors.first_name}
                    fieldError={"This field is required"}
                />

                <TextInput 
                    label={"Last Name"}
                    name={'last_name'} 
                    id={'last_name'} 
                    defaultValue={''} 
                    register={register('last_name', { required: true, })}
                    isFieldError={errors.last_name}
                    fieldError={"This field is required"}
                />

                <TextInput 
                    label={"Email"}
                    name={'email'} 
                    id={'email'} 
                    defaultValue={''} 
                    register={register('email', { required: true, pattern: /^[\w.-]+@[a-zA-Z\d.-]+\.[a-zA-Z]{2,}$/i })}
                    isFieldError={errors.email}
                    fieldError={"An email needs to be provided"}
                />

                <TextInput 
                    label={"Password"}
                    name={'password'} 
                    id={'password'} 
                    defaultValue={''} 
                    register={register('password', { required: true, pattern: /(?=.*\w)(?=.*\W)(?=.*\d).+/gm })}
                    isFieldError={errors.password}
                    type="password"
                    fieldError={"The password must include atleast one special char and number"}
                />
                <input type="submit" value={'Create'}/>
            </Form>
        </div>
    )
})

export default Register;