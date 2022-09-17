import { get, isEmpty, split, trim, remove, isEqual } from 'lodash';
import { AjaxOverlayMessages } from './ajax-overlay-messages';

jQuery(document).ajaxSend(function (event, jqxhr, settings) {
    const loader = get(settings, 'loader', true);
    const url = get(settings, 'url', null);
    let action = get(settings, 'action', null);
    if(action){
        const urlQuery = split(settings.url, '?');

        const baseurl = trim(_.get(window, 'quomak_ajax_object.ajax_url'), '/');
        action = trim(action, '/');
        const nonce = get(window, 'quomak_ajax_object.ajax_nonce')
        settings.url = baseurl+'?action='+action+'&nonce='+nonce;

        if(urlQuery[1] && !isEmpty(urlQuery[1])){
            const urlQueryTrimmed = trim(urlQuery[1], '#');
            settings.url += '&'+urlQueryTrimmed;
        }
        if(!loader){
            return settings;
        }
        ajaxLoader(settings);
        return settings;
    }else  if(url){
        if (!loader) {
            return settings;
        }
        ajaxLoader(settings);
        return settings;

    }
    
   
});

jQuery(document).ajaxSuccess(function(event,jqxhr, settings){
    if(isEmpty(settings.action)){
        return;
    }
    const res = get(jqxhr, 'responseJSON', {})
    if(isEmpty(res)){
        return;
    }
    const success = get(res, 'success', true);
    const message = get(res, 'data.message', null);
    const errors = get(res, 'data.errors', null);
    const redirect = get(res, 'data.redirect', null);
    const reload = get(res, 'data.reload', false);
    
    const toastEle = jQuery(".toast-container.ajax-toast").find('.toast');
    const toast = new bootstrap.Toast(toastEle[0]);

    if(redirect){
        window.location.href = redirect;
    }
    if(reload){
        window.location.reload();
    }

    if(success){
        if(message){
            toastEle.addClass('text-bg-success');
            toastEle.removeClass('text-bg-danger');
            toastEle.find('.toast-body').html(message);
            toast.show();
        }

        return;
    }
    if(!isEmpty(errors)){
        toastEle.addClass('text-bg-danger');
        toastEle.removeClass('text-bg-success');
        let errorsJoined = '<div>'+errors.join('</div><div>')+'</div>';
        toastEle.find('.toast-body').html(errorsJoined);
        toast.show();
    }

})

jQuery(document).ajaxComplete(function (event, jqxhr, settings) {
    let loaders = jQuery('body').attr('data-loaders');
    if(isEmpty(loaders)){
        return;
    }
    const loadersJson = JSON.parse(loaders);
    remove(loadersJson,(loader) => isEqual(loader.timestamp, settings.timestamp));    
    jQuery('body').attr('data-loaders', JSON.stringify(loadersJson));
    toggleAjaxOverlay();

});
function ajaxLoader(settings){
    const timestamp = moment().valueOf();
    settings.timestamp=timestamp;
    let loaders = jQuery('body').attr('data-loaders');
    if(isEmpty(loaders)){
        loaders = '[]';
    }
    const loadersJson = JSON.parse(loaders);
    loadersJson.push({timestamp:timestamp, action:settings.action});
    jQuery('body').attr('data-loaders', JSON.stringify(loadersJson));
    toggleAjaxOverlay();
}


function toggleAjaxOverlay(){
    
    let loaders = jQuery('body').attr('data-loaders');
    if(isEmpty(loaders)){
        jQuery('body').removeAttr('data-loaders');
        jQuery('body').removeAttr('data-action');
        jQuery('body').removeAttr('data-timestamp');
        jQuery('body').removeClass('has-ajax-overlay');
        jQuery(".ajax-overlay").hide();
        return;
    }
    const loadersJson = JSON.parse(loaders);
    if(isEmpty(loadersJson)){
        jQuery('body').removeAttr('data-loaders');
        jQuery('body').removeAttr('data-action');
        jQuery('body').removeAttr('data-timestamp');
        jQuery('body').removeClass('has-ajax-overlay');
        jQuery(".ajax-overlay").hide();
        return;
    }
    const message = get(AjaxOverlayMessages, get(loadersJson, '0.action', 'default'), get(AjaxOverlayMessages, 'default'));
    jQuery(".ajax-overlay").attr('data-timestamp', get(loadersJson, '0.timestamp'));
    jQuery(".ajax-overlay").attr('data-action', get(loadersJson, '0.action'));
    jQuery(".ajax-overlay").find('.message').html(message);
    jQuery(".ajax-overlay").show();
    jQuery('body').addClass('has-ajax-overlay');

}