<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Video;

class VideoModel extends Model {

    use HasFactory;

    /**
     * Fetch a list of videos from the YouTube API by passing the query, API key 
     * and the max number of results we want to get. The function creates an
     * array of Video objects that contain information such as the video ID,
     * the video URL, title, description and channel it came from.
     *
     * @param string - $query
     * @param string - $api_key
     * @param int - $max_results
     *
     * @return array
     */
    public static function get_videos_by_query(string $query, string $api_key, int $max_results): array {
        //Access YouTube videos from API by calling this reusable function
        $raw_video_list = self::fetch_videos_from_youtube_api("?order=date&part=snippet&q=$query&maxResults=$max_results&key=$api_key");

        //Check if we found any videos and prepare the data we will return to the client
        return self::handle_raw_video_list($raw_video_list, $max_results);
    }

    /**
     * Handles the video data from the API to create the return data for the client
     *
     * @param object - $raw_video_list
     * @param int - $max_results
     *
     * @return array - $response
     */
    public static function handle_raw_video_list(object $raw_video_list, int $max_results): array {
        $response = null;

        //Check if we found any videos
        if ($raw_video_list->pageInfo->totalResults === 0) {
            //Prepare response to send back to client
            $response = ['status' => 'error', 'data' => null, 'message' => 'No video results have been found that match your search query! Please enter a different query and try again.'];
        } else {
            $id_counter = 1;
            $data = [];
            $video_array = [];

            //Get all results matching the clients query and total number of pages we will have
            $data['total_results'] = $raw_video_list->pageInfo->totalResults;
            $data['total_pages'] = ceil($raw_video_list->pageInfo->totalResults / $max_results);

            //Set token values, if we reach last page, there won't be a 'nextPageToken' so we check for one
            if (isset($raw_video_list->nextPageToken)) {
                $data['next_page_token'] = $raw_video_list->nextPageToken;
            } else {
                $data['next_page_token'] = null;
            }

            //Set token values, if we reach the first page, there won't be a 'prevPageToken' so we check for one
            if (isset($raw_video_list->prevPageToken)) {
                $data['previous_page_token'] = $raw_video_list->prevPageToken;
            } else {
                $data['previous_page_token'] = null;
            }

            //Loop through all the items (videos) and create Video objects to send back to client
            foreach ($raw_video_list->items as $video) {
                $video_id = isset($video->id->videoId) ? $video->id->videoId : $video->id->playlistId;
                
                array_push($video_array, new Video($id_counter, 'https://www.youtube.com/embed/' . $video_id, $video->snippet->title, $video->snippet->description, 'https://youtube.com/channel/' . $video->snippet->channelId));

                $id_counter++;
            }

            //Add array of video objects to data array that we will send back to client
            $data['videos'] = $video_array;

            //Prepare response to send back to user
            $response = ['status' => 'success', 'data' => $data, 'message' => 'Videos successfully fetched'];
        }

        return $response;
    }

    /**
     * Fetch a list of videos from the YouTube API by passing the query, API key 
     * and the max number of results we want to get. The function uses another recursive
     * function to get the contents of the page the user clicked on
     *
     * @param string - $query
     * @param string - $api_key
     * @param int - $max_results
     * @param boolean - $next
     * @param int - $move_by
     * @param string - $token
     *
     * @return array
     */
    public static function get_videos_by_query_pagination(string $query, string $api_key, int $max_results, bool $next, int $move_by, string $token): array {
        //Recursively loop until the clients desired page is reached
        $raw_video_list = self::get_videos_by_query_pagination_recursively($api_key, $max_results, $token, $query, $move_by, $next, 0, (object) []);

        //Check if we found any videos
        return self::handle_raw_video_list($raw_video_list, $max_results);
    }
    
    /**
     * Loop recursively and query the YouTube API until we reach the page the user selected
     *
     * @param string - $api_key
     * @param int - $max_results
     * @param string - $token
     * @param string - $query
     * @param int - $move_by
     * @param boolean - $next
     * @param int - $limit_counter
     * @param object - $video_list
     * 
     * @return object
     */
    public static function get_videos_by_query_pagination_recursively(string $api_key, int $max_results, string $token, string $query, int $move_by, bool $next, int $limit_counter, object $video_list) {
        //If we reached our destination page, exit
        if ($limit_counter === $move_by) {
            return $video_list;
        } else {
            $video_list = self::fetch_videos_from_youtube_api("?part=snippet&key=$api_key&order=relevance&pageToken=$token&q=$query&maxResults=$max_results");
            $limit_counter++;

            if (!isset($video_list->nextPageToken)) {
                $limit_counter = $move_by;
            } else if (isset($video_list->nextPageToken)) {
                $token = $video_list->nextPageToken;
            }

            //Check if we need the next page or previous page
            if ($next) {
                //If there is no longer a 'nextPageToken', we have reached the last page thus we can exit
                if (!isset($video_list->nextPageToken)) {
                    $limit_counter = $move_by;
                } else if (isset($video_list->nextPageToken)) {
                    $token = $video_list->nextPageToken;
                }
            } else {
                //If there is no longer a 'prevPageToken', we have reached the first page thus we can exit
                if (!isset($video_list->prevPageToken)) {
                    $limit_counter = $move_by;
                } else if (isset($video_list->prevPageToken)) {
                    $token = $video_list->prevPageToken;
                }
            }

            return self::get_videos_by_query_pagination_recursively($api_key, $max_results, $token, $query, $move_by, $next, $limit_counter, $video_list);
        }
    }

    /**
     * Takes an array of Video objects and creates individual views for each video
     * that we will then show to the client.

     * @param array - $videos

     * @return array
     */
    public static function create_video_views(array $videos): array {
        $video_views = [];

        foreach ($videos as $video) {
            array_push($video_views, view('components.video', ['url' => $video->url, 'title' => $video->title, 'description' => $video->description, 'channel' => $video->channel_url])->render());
        }

        return ['status' => 'success', 'data' => $video_views, 'message' => "Video views created successfully"];
    }

    /**
     * Fetch videos from YouTube API. Function purposefully does not state whether
     * the search was successful as successful is ambiguous, a function might treat
     * 0 results differently, certain use cases might deem it to be a success, others
     * would see it as an error therefore I just return the contents.

     * @param string - $query

     * @return object - API response
     */
    public static function fetch_videos_from_youtube_api(string $query): object {
        return json_decode(file_get_contents("https://www.googleapis.com/youtube/v3/search$query"));
    }

}
