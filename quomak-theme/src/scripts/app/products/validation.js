export const Rules = {
    uuid: {

    },
    product_category_uuid: {
        required: true
    },
    product_unit_uuid: {
        required: true
    },
    code: {
        required: true,
        minlength: 3,
        maxlength: 10
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