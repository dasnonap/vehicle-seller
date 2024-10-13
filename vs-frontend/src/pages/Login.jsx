import { useForm } from "react-hook-form";
import Form from "../fragments/Form";
import TextControl from "../fragments/TextControl";
import authStore from "../stores/authStore";
import { useState } from "react";
import { useNavigate } from "react-router-dom";
import { Button } from "flowbite-react";

const Login = () => {
    const {
        register, 
        handleSubmit,
        formState: {errors}
    } = useForm();
    const [formErrors, setFormErrors] = useState();
    const navigate = useNavigate();

    const handleLoginFormSubmit = (data) =>{
        authStore.setEmail(data.email);
        authStore.setPassword(data.password);

        authStore.login()
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

    const handleLoginFormError = (error) => {
        console.error(error);
    }
    return (
       <div className="flex flex-col">
            <h1 className="text-3xl font-bold">Login</h1>
            
            {formErrors ? (
                <h3>
                    {formErrors}
                </h3>
            ) : ''}

            <Form handleFormSubmit={handleSubmit(handleLoginFormSubmit, handleLoginFormError)}>
                <TextControl 
                    label={"Email"}
                    name={'email'} 
                    id={'email'} 
                    defaultValue={''} 
                    register={register('email', { required: true, pattern: /^[\w.-]+@[a-zA-Z\d.-]+\.[a-zA-Z]{2,}$/i })}
                    isFieldError={errors.email}
                    fieldError={"An email needs to be provided"}
                />

                <TextControl 
                    label={"Password"}
                    name={'password'} 
                    id={'password'} 
                    defaultValue={''} 
                    register={register('password', { required: true, pattern: /(?=.*\w)(?=.*\W)(?=.*\d).+/gm })}
                    isFieldError={errors.password}
                    type="password"
                    fieldError={"The password must include atleast one special char and number"}
                />
                <Button type="submit">
                    Login
                </Button>
            </Form>
       </div> 
    )
}

export default Login;