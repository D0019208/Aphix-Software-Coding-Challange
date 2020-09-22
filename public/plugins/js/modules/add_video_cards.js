/**
 * Add the video card views to the DOM
 *
 * @param array - videos
 *
 * @return void
 */
async function add_video_cards(videos) {
    $('#video_container').html('');
    videos.forEach((video) => {
        $('#video_container').append(video);
    });
}

export {add_video_cards}