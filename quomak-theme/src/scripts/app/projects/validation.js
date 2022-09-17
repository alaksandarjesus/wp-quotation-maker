export const Rules = {
    uuid: {

    },
    project_category_uuid: {
        required: true
    },
    project_customer_uuid: {
        required: true
    },
    name: {
        required: true,
        minlength: 3,
        maxlength: 200
    },
    notes: {
        required: false,
        maxlength: 200
    }
}

export const Messages = {}