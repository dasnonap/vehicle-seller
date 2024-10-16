import { useForm } from "react-hook-form";
import Form from "../fragments/Form";
import TextControl from "../fragments/TextControl";
import authStore from "../stores/authStore";
import { observer } from "mobx-react";
import { useNavigate } from "react-router-dom";
import { useState } from "react";
import { Button } from "flowbite-react";
import RadioControl from "../fragments/RadioControl";

const Register = observer(() => {
    const {
        register,
        handleSubmit,
        formState: { errors },
    } = useForm();
    const navigate = useNavigate();
    const [formErrors, setFormErrors] = useState()
    const [role, setRole] = useState(null);

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

    const handleOnRoleChange = (event) => {
        setRole(event.target.value);
    }
    return (
        <div className="bg-red">
            <h1 className="text-3xl font-bold underline">Register</h1>
            
            {formErrors ? (
                <h3>
                    {formErrors}
                </h3>
            ) : ''}
            
            <Form handleFormSubmit={handleSubmit(handleRegisterFormSubmit)} className={'grid gap-3 mb-6'}>
                <TextControl 
                    label={"First Name"}
                    name={'first_name'} 
                    id={'first_name'} 
                    defaultValue={''} 
                    register={register('first_name', { required: true, })}
                    isFieldError={errors.first_name}
                    fieldError={"This field is required"}
                />

                <TextControl 
                    label={"Last Name"}
                    name={'last_name'} 
                    id={'last_name'} 
                    defaultValue={''} 
                    register={register('last_name', { required: true, })}
                    isFieldError={errors.last_name}
                    fieldError={"This field is required"}
                />

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

                <RadioControl
                    label="Register as a:"
                    name="role"
                    id="role"
                    register={register('role')}
                    selected={role}
                    values={
                        [
                            {
                                value: 'ROLE_VIEWER',
                                name: 'viewer',
                                label: 'Viewer'
                            },
                            {
                                value: 'ROLE_CREATOR',
                                name: 'creator',
                                label: 'Creator'
                            }
                        ]
                    }
                    onChange={handleOnRoleChange}
                />
                
                <Button type="submit" >
                    Create Account
                </Button>
            </Form>
        </div>
    )
})

export default Register;