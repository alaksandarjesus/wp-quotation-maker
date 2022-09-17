import { get } from 'lodash';

export const Autocomplete = (element, action, fields,onSelect)=>{
    element.autocomplete({
        classes: {
            'ui-autocomplete': 'list-group',
            'ui-menu-item': 'list-group-item'
        },
        select:(event, ui)=>{

            if(onSelect){
                onSelect(event, ui)
            }
        },
        source: function (request, response) {
            jQuery.ajax({
                action: action,
                method: 'POST',
                data: { query: request.term },
                success: function (res) {
                    const success = get(res, 'success', false);
                    const result = get(res, 'data.result', false);
                    if (!success) {
                        response([]);
                        return;
                    }
                    const transformed = result.map((item) => {
                        return {
                            label: item[get(fields, 'label')],
                            id: item[get(fields, 'id')],
                        }
                    })
                    response(transformed);
                },
                error: function () {
                    response([])
                },
                complete: function () {

                }
            })
        }

    })
}