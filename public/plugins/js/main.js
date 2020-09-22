import {access_server} from './modules/access_server.js';
import {on_ajax_error} from './modules/on_ajax_error.js';
import {validate_video_search_variables} from './modules/validate_video_search_variables.js';
import {add_video_cards} from './modules/add_video_cards.js';
import {Pagination} from './classes/Pagination.js';

let pagination_controller = new Pagination('CAYQAA', null, 'Full HD Test 1080p', 6, 1, 1, 10000, 5, false);

$('.page').click(pagination_controller.page_click);

$('#previous').click((e) => {
    let previous_element;
    let target = $(e.currentTarget);

    if (pagination_controller.active_page !== 1) {
        //Any time we click on the "Previous" button, by default the "Next"
        //button becomes enabled
        $('#next').removeClass('disabled');
        $('.page').removeClass('active');

        pagination_controller.last_active_page = pagination_controller.active_page;
        ``
        //Get PREVIOUS page
        previous_element = $(`.page > a:contains('${pagination_controller.active_page - 1}')`).filter(function () {
            return $(this).text() == pagination_controller.active_page - 1 ? true : false;
        });

        //Add active class to PREVIOUS page
        previous_element.parent().addClass('active')

        pagination_controller.active_page -= 1;

        //Check if we reached first page
        if (pagination_controller.active_page === 1) {
            target.addClass('disabled');
        }

        pagination_controller.get_videos();

        pagination_controller.check_pagination_pages();
    }
});

$('#next').click((e) => {
    let next_element;
    let target = $(e.currentTarget);

    if (pagination_controller.active_page !== pagination_controller.total_pages) {
        //Any time we click on the "Next" button, by default the "Next"
        //button becomes enabled
        $('#previous').removeClass('disabled');
        $('.page').removeClass('active');

        pagination_controller.last_active_page = pagination_controller.active_page;

        //Get NEXT page
        next_element = $(`.page > a:contains('${pagination_controller.active_page + 1}')`).filter(function () {
            return $(this).text() == pagination_controller.active_page + 1 ? true : false;
        });

        //Add active class to NEXT page
        next_element.parent().addClass('active');

        pagination_controller.active_page += 1;

        //Check if we reached last page
        if (pagination_controller.active_page === pagination_controller.total_pages) {
            target.addClass('disabled');
        }

        pagination_controller.get_videos();

        pagination_controller.check_pagination_pages();
    }
});

//If user presses enter while focusing on the search bar, we begin video search process
$('input[name=search_term]').keypress((event) => {
    if (event.which === 13) {
        $('#search_button').click();
    }
});

//If user clicks the "Search" button, we begin video search process
$('#search_button').click(async (event) => {
    event.preventDefault();

    let search_term = $('input[name=search_term]').val();

    //Client side validation, we check if the users data is valid
    let validation_response = validate_video_search_variables(search_term, pagination_controller.number_of_videos);

    //If the data is not valid, we display the appropriate error, otherwise, continue
    if (validation_response.status === 'error') {
        Swal.fire({
            type: 'error',
            title: validation_response.title,
            text: validation_response.message,
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Okay'
        });
    } else {
        //Wait for the AJAX request to complete
        let response = await access_server('GET', "api/video-search", {search_term: search_term, number_of_videos: pagination_controller.number_of_videos});

        //Current search term we will use to load more videos for pagination
        pagination_controller.update_pagination_data(response.data.data.next_page_token, response.data.data.previous_page_token, response.data.data.total_pages);
        //Current search term we will use to load more videos for pagination
        pagination_controller.search_term = search_term;
        pagination_controller.active_page = 1;
        pagination_controller.last_active_page = 1;
        
        //Display the rendered video card components received from the REST API
        add_video_cards(response.data.data.videos);

        Swal.fire({
            type: 'success',
            title: 'Search successful!',
            html: 'Displaying <strong>' + pagination_controller.number_of_videos + '/' + response.data.data.total_results + '</strong> videos.',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Okay'
        });
    }
});