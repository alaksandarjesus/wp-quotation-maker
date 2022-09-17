
jQuery(function () {
    const guestFormElements = jQuery(".guest-forms");
    if (!guestFormElements.length) {
        return;
    }

    guestFormElements.on('click', '.open-form', function () {
        const form = jQuery(this).attr('data-form');
        showForm(form);
    });

    function showForm(formName) {
        guestFormElements.find('input').val('');
        guestFormElements.find('form').each(function () {
            const validator = jQuery(this).validate();
            validator.resetForm();
        });
        guestFormElements.find('form:visible').fadeOut(function () {
            guestFormElements.find('form.' + formName).fadeIn();
        });

    }
});