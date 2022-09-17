jQuery(function(){
    jQuery.validator.setDefaults({
        errorElement: 'div',
        errorClass: 'text-danger',
        highlight: function (element, errorClass) {
            jQuery(element).closest('.form-group').find('.form-control').addClass('is-invalid');
            jQuery(element).closest('.form-group').find('.form-label').addClass('text-danger');
        },
        unhighlight: function (element, errorClass) {
            jQuery(element).closest('.form-group').find('.form-control').removeClass('is-invalid');
            jQuery(element).closest('.form-group').find('.form-label').removeClass('text-danger');

        },
        errorPlacement: function (error, element) {
            const formGroup = jQuery(element).closest('.form-group');
            const inputGroup = formGroup.find('.input-group');
            if(inputGroup.length){
            error.insertAfter(jQuery(element).closest('.input-group'));
            return;
            }
            error.insertAfter(element);
        }

    });
});

