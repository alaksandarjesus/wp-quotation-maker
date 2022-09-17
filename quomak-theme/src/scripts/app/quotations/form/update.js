import { isEmpty, get } from 'lodash';

jQuery(function () {
    const quotationForm = jQuery("form.quotation");

    if (!quotationForm.length) {
        return;
    }

    const quotationFormTable = jQuery("table.quotation-form");
    if (!quotationFormTable.length) {
        return;
    }

    const quotationUuid = quotationForm.attr('data-quotation-uuid');

    if (!isEmpty(quotationUuid)) {
        jQuery.ajax({
            action: 'quotations/quotation/get',
            method: 'POST',
            data: { uuid: quotationUuid },
            success: function (res) {
                setTableData(res.data);
            }
        })
    }

    function setTableData(data) {
        quotationForm.find('.quotation-number').val(get(data, 'quotation_number'));
        const quotationDate = get(data, 'quotation_date');
        if (quotationDate) {
            quotationForm.find('.quotation-date').val(moment(quotationDate, 'YYYY-MM-DD').format('DD-MM-YYYY'));
        }
        quotationForm.find('.select-project').val(get(data, 'project.uuid'));
        quotationFormTable.find('tfoot .subtotal').val(get(data, 'subtotal'));
        quotationFormTable.find('tfoot .taxtotal').val(get(data, 'taxtotal'));
        quotationFormTable.find('tfoot .discount').val(get(data, 'discount'));
        quotationFormTable.find('tfoot .total').val(get(data, 'total'));
        quotationFormTable.find('tfoot .notes').val(get(data, 'notes'));
        const items = get(data, 'items');
        if (isEmpty(items)) {
            return;
        }
        for (let i = 0; i <= items.length; i++) {
            createNewRow();
        }
        items.forEach((item, index) => {
            const tr = quotationFormTable.find('tbody tr:eq(' + index + ')');
            const product = get(item, 'product');
            if (product) {
                tr.find('.product').val(get(product, 'uuid'));
            }
            tr.find('.qty').val(get(item, 'qty'));
            tr.find('.price').val(get(item, 'price'));
            tr.find('.tax').val(get(item, 'tax'));
            tr.find('.total').val(get(item, 'total'));

            setTimeout(() => {
                const unit = tr.find('.product').find('option:selected').attr('data-unit');
                tr.find('.unit').text(unit);
                const code = tr.find('.product').find('option:selected').attr('data-code');
                tr.find('.code').text(code);
            })
        })
    }

    function createNewRow() {
        const template = jQuery("#table-quotation-form-row").html();
        const compiled = _.template(template)({});
        quotationFormTable.find('tbody').append(compiled);
        indexRows();
    }

    function indexRows() {
        let start = 1;
        quotationFormTable.find('tbody tr').each(function () {
            jQuery(this).find('.sno').text(start);
            start++;
        })
    }

});