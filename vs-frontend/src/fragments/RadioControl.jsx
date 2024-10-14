import { Radio, Label } from "flowbite-react"

function RadioControl({label, name, register, values, onChange, selected, handleChange}) {
    const optionsList = values.map((item) =>{
        return (
            <div className="flex items-center gap-2" key={Math.random().toString()}>
                <Radio 
                    id={item.name} 
                    name={name} 
                    value={item.value}
                    {...register} 
                    onChange={onChange}
                    checked={item.value == selected}
                />
                <Label htmlFor={item.name}>
                    {item.label}
                </Label>
            </div>
        )
    })
    return(
        <fieldset className="flex max-w-md flex-col gap-4">
            <legend className="mb-4">
                {label}
            </legend>

            {values ? 
                optionsList
            : ''}
        </fieldset>
    )
}
export default RadioControl;