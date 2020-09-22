<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\VideoModel;

class GetVideosByQueryTest extends TestCase {

    /**
     * @test
     * 
     * Test to see if correct message is returned if NO videos have been found by
     * get_videos_by_query function
     *
     * @return void
     */
    public function get_videos_by_query_not_found() {
        $response = VideoModel::get_videos_by_query('qwhdh814834ythoewidfawelpgfk', 'AIzaSyDPzpBBlB8vLHiyQJHqrPRUB32VGyJCgBc', 6);
        $this->assertEquals($response["message"], 'No video results have been found that match your search query! Please enter a different query and try again.');
    }

    /**
     * @test
     * 
     * Test to see if correct message is returned if videos HAVE been found by
     * get_videos_by_query function
     *
     * @return void
     */
    public function get_videos_by_query_found() {
        $response = VideoModel::get_videos_by_query('test', 'AIzaSyDPzpBBlB8vLHiyQJHqrPRUB32VGyJCgBc', 6);
        $this->assertEquals($response["message"], 'Videos successfully fetched');
    }

}
