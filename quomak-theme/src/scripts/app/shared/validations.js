export const Validation = {
    firstname: {
        rules: {
            required: true,
            minlength: 3,
            maxlength: 30,
            pattern: '^[a-zA-Z\\s]*$'
        },
        messages: {
            required: "Firstname is required",
            minlength: "Firstname must be minimum 3 characters",
            maxlength: "Firstname cannot exceed 30 characters",
            pattern: "Firstname can contain only alphabets with spaces"
        }
    },
    lastname: {
        rules: {
            required: true,
            minlength: 3,
            maxlength: 30,
            pattern: '^[a-zA-Z\\s]*$'
        },
        messages: {
            required: "Lastname is required",
            minlength: "Lastname must be minimum 3 characters",
            maxlength: "Lastname cannot exceed 30 characters",
            pattern: "Lastname can contain only alphabets with spaces"

        }
    },
    username: {
        rules: {
            required: true,
            minlength: 3,
            maxlength: 30,
            pattern: '^[a-z0-9]*$'
        },
        messages: {
            required: "Username is required",
            minlength: "Username must be minimum 3 characters",
            maxlength: "Username cannot exceed 30 characters",
            pattern: "Username can contain only alphabets and numbers"
        }
    },
    password: {
        rules: {
            required: true,
            minlength: 8,
            maxlength: 20
        },
        messages: {
            required: "Password is required",
            minlength: "Password must be minimum 3 characters",
            maxlength: "Password cannot exceed 20 characters"
        }
    },
    cpassword: {
        rules: {
            required: true,
            equalTo: '#password'
        },
        messages: {
            required: "Confirm Password is required",
            equalTo: "Confirm Password should match password"
        }
    },
    email: {
        rules: {
            required: true,
            email: true
        },
        messages: {
            required: "Password is required",
            email: 'Email is not in valid format'
        }
    }
}