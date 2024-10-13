import { Select, Label } from "flowbite-react";

const SelectControl = ({name, id, label, options, isFieldError, fieldError, register}) => {

    const optionsList = options.map(((option)=>{
        return (
            <option value={option.value} key={Math.random().toString()}>
                {option.name}
            </option>
        )
    }));
    return(
         <div className="max-w-md">
            {isFieldError && 
                <div>
                    {fieldError}
                </div>
            }

            {label && (
                <Label htmlFor={name} value={label}/>
            )}

            {optionsList ? 
                <Select id={id} name={name} {...register}>
                    {optionsList}
                </Select>
            : ''}
        </div>
    );
}

export default SelectControl;