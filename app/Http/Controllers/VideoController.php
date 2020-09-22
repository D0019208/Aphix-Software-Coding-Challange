<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VideoModel;

class VideoController extends Controller {

    /**
     * API key to access the YouTube API
     *
     * @param string
     */
    private $api_key = 'AIzaSyDPzpBBlB8vLHiyQJHqrPRUB32VGyJCgBc';

    private function getApi_key(): string {
        return $this->api_key;
    }

    private function setApi_key(string $api_key): void {
        $this->api_key = $api_key;
    }

    /**
     * Validate the user input before accessing the YouTube API
     *
     * @param string - $search_term
     * @param string - $number_of_videos
     *
     * @return array - $response
     */
    public function validate_search_input($search_term, $number_of_videos): array {
        $response = [];

        if (empty($search_term)) {
            $response['status'] = 'error';
            $response['data'] = null;
            $response['message'] = 'The search query cannot be empty, please fill it in and try again.';
            $response['status_code'] = 400;
        } else if (strlen($number_of_videos) === 0) {
            $response['status'] = 'error';
            $response['data'] = null;
            $response['message'] = 'Please enter the number of videos you wish to display and try again.';
            $response['status_code'] = 400;
        } else if ((int) $number_of_videos < 1) {
            $response['status'] = 'error';
            $response['data'] = null;
            $response['message'] = 'You cannot display less than 1 video! Please enter a value greater than 0 and try again.';
            $response['status_code'] = 400;
        } else {
            $response['status'] = 'success';
            $response['data'] = null;
            $response['message'] = "Input is valid.";
            $response['status_code'] = null;
        }

        return $response;
    }

    /**
     * Validate the user input before accessing the user specified page via YouTube
     * API
     *
     * @param string - $search_term
     * @param string - $number_of_videos
     * @param bool - $next
     * @param int - $move_by
     * @param string - $token
     *
     * @return array - $response
     */
    public function validate_search_input_pagination($search_term, $number_of_videos, $next, $move_by, $token): array {
        $response = $this->validate_search_input($search_term, $number_of_videos);

        if ($response['status'] !== 'error') {
            if (empty($next)) {
                $response['status'] = 'error';
                $response['data'] = null;
                $response['message'] = 'The system does not know whether to search next or previous page. Please reload and try again.';
                $response['status_code'] = 400;
            } else if (strlen($move_by) === 0) {
                $response['status'] = 'error';
                $response['data'] = null;
                $response['message'] = 'The system does not know what page to access. Please reload and try again.';
                $response['status_code'] = 400;
            } else if (empty($token)) {
                $response['status'] = 'error';
                $response['data'] = null;
                $response['message'] = 'The page token is missing. Please reload and try again.';
                $response['status_code'] = 400;
            } else {
                $response['status'] = 'success';
                $response['data'] = null;
                $response['message'] = "Input is valid.";
                $response['status_code'] = null;
            }
        }

        return $response;
    }

    /**
     * Create a new controller instance to search for YouTube videos matching
     * the clients parameters
     *
     * @param Request - $request
     * 
     * @return json
     */
    public function video_search(Request $request) {
        //Validate the users input before proceeding
        $validation_response = $this->validate_search_input($request['search_term'], $request['number_of_videos']);
        
        //If we have an error, we return back to the client
        if ($validation_response['status'] === 'error') {
            return response()->json([
                        'status' => 'error',
                        'data' => $validation_response['data'],
                        'message' => $validation_response['message']
                            ], $validation_response['status_code'])->header('Content-Type', 'application/json');
        }
        
        //Setup the variables we will be needing
        $search_term = urlencode($request['search_term']);
        $number_of_videos = (int) $request['number_of_videos'];

        //Invoke function to get the videos based on the users query
        $videos_data = VideoModel::get_videos_by_query($search_term, $this->getApi_key(), $number_of_videos);

        //If the video search was successful, we create views from the Video objects
        //we received from the get_videos_by_query fuction
        if ($videos_data['status'] === 'success') {
            $video_views = VideoModel::create_video_views($videos_data["data"]["videos"]);
            
            //Add the video views to the response
            $videos_data["data"]["videos"] = $video_views["data"];

            return response()->json([
                        'status' => 'success',
                        'data' => $videos_data['data'],
                        'message' => $videos_data['message']
                            ], 200)->header('Content-Type', 'application/json');
        } else {
            return response()->json([
                        'status' => 'error',
                        'data' => null,
                        'message' => $videos_data['message']
                            ], 500)->header('Content-Type', 'application/json');
        }
    }

    public function video_search_pagination(Request $request) {
        //Validate the users input before proceeding
        $validation_response = $this->validate_search_input($request['search_term'], $request['number_of_videos']);
        
        //If we have an error, we return back to the client
        if ($validation_response['status'] === 'error') {
            return response()->json([
                        'status' => 'error',
                        'data' => $validation_response['data'],
                        'message' => $validation_response['message']
                            ], $validation_response['status_code'])->header('Content-Type', 'application/json');
        }
        
        //Setup the variables we will be needing
        $search_term = urlencode($request['search_term']);
        $number_of_videos = (int) $request['number_of_videos'];
        $next = (bool) $request['next'];
        $move_by = (int) $request['move_by'];
        $token = $request['token'];

        //Invoke function to get the videos of the next/previous page
        $videos_data = VideoModel::get_videos_by_query_pagination($search_term, $this->getApi_key(), $number_of_videos, $next, $move_by, $token);

        //If the video search was successful, we create views from the Video objects
        //we received from the get_videos_by_query fuction
        if ($videos_data['status'] === 'success') {
            $video_views = VideoModel::create_video_views($videos_data["data"]["videos"]);
            $videos_data["data"]["videos"] = $video_views["data"];

            return response()->json([
                        'status' => 'success',
                        'data' => $videos_data['data'],
                        'message' => $videos_data['message']
                            ], 200)->header('Content-Type', 'application/json');
        } else {
            return response()->json([
                        'status' => 'error',
                        'data' => null,
                        'message' => $videos_data['message']
                            ], 500)->header('Content-Type', 'application/json');
        }
    }

}
