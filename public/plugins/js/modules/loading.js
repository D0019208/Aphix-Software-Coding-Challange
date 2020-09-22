/**
 * Created and adds the loading overlay to the DOM along with preventing scrolling
 * 
 * @return void
 */
function show_loading() {
    $('body').prepend(`<div id="loading_container">
            <div class='loading-overlay'></div>
            <div class="loading-wrapper sc-ion-loading-md">
                <div class="loading-spinner sc-ion-loading-md">
                    <div class="spinner-border text-primary">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="loading-content sc-ion-loading-md">Please wait...</div>
            </div>
        </div>`);

    $('html').addClass('hide_overflow');
}

/**
 * Hide the loading overlay by removing it and permitting scrolling again
 * 
 * @return void
 */
function hide_loading() {
    $('html').removeClass('hide_overflow');
    $('#loading_container').remove();
}

export {show_loading, hide_loading}