function Form({children, className, handleFormSubmit}) {
    return (
        <form className={"" + className} onSubmit={handleFormSubmit} >
            {children}
        </form>
    )
}

export default Form;