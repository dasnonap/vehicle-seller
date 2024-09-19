function TextInput(
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
            {isFieldError && (
                <div>
                    {fieldError}
                </div>
            )}

            {label && (
                <label htmlFor={name}>
                    {label}
                </label>
            )}

            <input 
                type={type ? type : 'text'} 
                name={name} 
                id={id} 
                defaultValue={defaultValue} 
                {...register}
            />

        </div>
    )
}

export default TextInput;