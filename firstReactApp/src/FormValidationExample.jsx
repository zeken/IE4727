import { useState } from 'react'

import './FormValidationExample.css'

// starting a form validation example using React's useState hook to manage form data
const FormValidationExample = () => {

    const [formData, setFormData] = useState({
        username: '',
        email: '',
        password: '',
        confirmPassword: ''
    })

    //setting up a state variable errors to manage form validation errors.
    //This is a common approach in React to track and display errors related to form fields.
    //You can update the errors state based on your validation logic to show error messages to users.
    const [errors, setErrors] = useState({})

    //This handleChange function is designed to update the formData state based on user input in form fields.
    //It uses destructuring to extract the name and value from the event target
    //and then uses the spread operator ( ... ) to copy the existing formData and update the specified field ([name]) with the new value.
    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData({
            ...formData, [name]: value
        })
    }

    //This handleSubmit function is designed to validate the form data when the form is submitted.
    //It prevents the default form submission behavior (e.preventDefault())
    //and then checks each form field for validation errors based on the defined criteria.
    const handleSubmit = (e) => {
        e.preventDefault()
        const validationErrors = {}
        if (!formData.username.trim()) {
            validationErrors.username = "username is required"
        }

        if (!formData.email.trim()) {
            validationErrors.email = "email is required"
        } else if (!/\S+@\S+\.\S+/.test(formData.email)) {
            validationErrors.email = "email is not valid"
        }

        if (!formData.password.trim()) {
            validationErrors.password = "password is required"
        } else if (formData.password.length < 6) {
            validationErrors.password = "password should be at least 6 char"
        }

        if (formData.confirmPassword !== formData.password) {
            validationErrors.confirmPassword = "passwords do not match"
        }

        setErrors(validationErrors)

        //This part of the handleSubmit function checks if there are no validation errors (validationErrors is an empty object) before submitting the form.
        //If there are no errors, it displays an alert indicating that the form was submitted successfully.
        if (Object.keys(validationErrors).length === 0) {
            alert("Form Submitted successfully")
        }
    }

    return (
        //create form and validate form in React
        //novalidate is so that chrome does not do its own validation
        <form onSubmit={handleSubmit} novalidate="novalidate">
            <div>
                <label>Username:</label>
                <input
                    type="text"
                    name="username"
                    placeholder='username'
                    autoComplete='off'
                    onChange={handleChange}
                />
                {errors.username && <span>{errors.username}</span>}
            </div>
            <div>
                <label>Email:</label>
                <input
                    type="email"
                    name="email"
                    placeholder='example@email.com'
                    autoComplete='off'
                    onChange={handleChange}
                />
                {errors.email && <span>{errors.email}</span>}
            </div>
            <div>
                <label>Password:</label>
                <input
                    type="password"
                    name="password"
                    placeholder='*******'
                    onChange={handleChange}
                />
                {errors.password && <span>{errors.password}</span>}
            </div>
            <div>
                <label>Confirm Password:</label>
                <input
                    type="password"
                    name="confirmPassword"
                    placeholder='*******'
                    onChange={handleChange}
                />
                {errors.confirmPassword && <span>{errors.confirmPassword}</span>}
            </div>
            <button type="submit">Submit</button>
        </form>
    );
};
//FormValidationExample component is now complete and can be exported for use in other parts of your application.
export default FormValidationExample;
// }

//export default App