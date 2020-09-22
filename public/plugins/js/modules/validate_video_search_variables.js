/**
 * Validate the user input before accessing the REST API
 *
 * @param string - search_term
 * @param string - number_of_videos
 *
 * @return array - response
 */
function validate_video_search_variables(search_term, number_of_videos) {
    let response;

    if (search_term === '') {
        response = {status: 'error', title: 'Search querry cannot be empty', message: 'The search query cannot be empty, please fill it in and try again.'};
    } else if (number_of_videos === '') {
        response = {status: 'error', title: 'Number of videos to be displayed is empty', message: 'Please enter the number of videos you wish to display and try again.'};
    } else if (parseInt(number_of_videos) < 1) {
        response = {status: 'error', title: 'Number of videos to be displayed is less than 1', message: 'You cannot display less than 1 video! Please enter a value greater than 0 and try again.'};
    } else {
        response = {status: 'success', title: null, message: null};
    }

    return response;
}

export {validate_video_search_variables}