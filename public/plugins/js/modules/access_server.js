import {on_ajax_error} from './on_ajax_error.js';
import {show_loading, hide_loading} from './loading.js';

/**
 * Access a REST API given the method (GET, POST etc.), url and data to send
 *
 * @param string - method
 * @param string - url
 * @param object - data
 *
 * @return Promise
 */
async function access_server(method, url, data) {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: method,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'text'
            },
            dataType: 'json',
            url: url,
            data: data,
            beforeSend: function () {
                show_loading();
            },
            success: function (response) {
                hide_loading();

                resolve({status: 'success', data: response, message: 'AJAX query successfull'});
            },
            error: function (jqXHR, textStatus, errorThrown) {
                hide_loading();

                on_ajax_error(jqXHR, textStatus, errorThrown);

                resolve({status: 'error', data: null, message: 'AJAX query failed'});
            }
        });
    });
}

export {access_server}