import { TextInput, Label } from "flowbite-react";

function TextControl(
    {
        type,
        className, 
        label,
        name, 
        id, 
        defaultValue, 
        register,
        isFieldError,
        fieldError
    }
){
    return(
        <div className={'form-group ' + className}>
            {isFieldError && 
                <div>
                    {fieldError}
                </div>
            }

            {label && (
                <Label htmlFor={name} value={label}/>
            )}

            <TextInput 
                type={type ? type : 'text'} 
                name={name} 
                id={id} 
                defaultValue={defaultValue} 
                {...register}
            />

        </div>
    )
}

export default TextControl;