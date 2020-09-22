/**
 * Display appropriate error message if AJAX request fails
 *
 * @param object - jqXHR
 * @param string - textStatus
 * @param string - errorThrown
 *
 * @return void
 */
function on_ajax_error(jqXHR, textStatus, errorThrown)
{
    if (textStatus === 'parsererror') {
        Swal.fire({
            type: 'error',
            title: 'Requested JSON parse failed.',
            text: 'An error has occured when parsing your JSON content, please wait a bit and refresh the page to try again.',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Refresh Page'
        }).then(function (result) {
            if (result.value) {
                location.reload();
            }
        });
    } else if (textStatus === 'timeout') {
        Swal.fire({
            type: 'error',
            title: 'Time out error.',
            text: 'The system has timed out while processing your request, please wait a bit and refresh the page to try again.',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Refresh Page'
        }).then(function (result) {
            if (result.value) {
                location.reload();
            }
        });
    } else if (textStatus === 'abort') {

        Swal.fire({
            type: 'error',
            title: 'Ajax request aborted.',
            text: 'Something went wrong and the AJAX request has been aborted, please wait a bit, check your network connection and refresh the page to try again.',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Refresh Page'
        }).then(function (result) {
            if (result.value) {
                location.reload();
            }
        });
    } else {
        if (jqXHR.status === 0) {
            Swal.fire({
                type: 'error',
                title: 'Error ' + jqXHR.status + ': ' + errorThrown,
                text: 'There seems to be a problem with your connection, please check your network connection and refresh the page to try again.',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Refresh Page'
            }).then(function (result) {
                if (result.value) {
                    location.reload();
                }
            });
        } else {
            Swal.fire({
                type: 'error',
                title: 'Error ' + jqXHR.status + ': ' + errorThrown,
                text: jqXHR.responseJSON.message,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Refresh Page'
            }).then(function (result) {
                if (result.value) {
                    location.reload();
                }
            });
        }
    }
}

export {on_ajax_error}