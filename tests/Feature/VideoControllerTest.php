<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VideoControllerTest extends TestCase {

    /**
     * Test response of Video Controller video_search function if correct input is
     * given
     *
     * @return void
     */
    public function test_video_search_success() {
        $this->json('GET', 'api/video-search', ['search_term' => 'test', 'number_of_videos' => '1'])->assertStatus(200);
    }

    /**
     * Test response of Video Controller video_search function if an error occurs (0 search results)
     *
     * @return void
     */
    public function test_video_search_error() {
        $this->json('GET', 'api/video-search', ['search_term' => 'qwhdh814834ythoewidfawelpgfk', 'number_of_videos' => '1'])->assertStatus(500);
    }

    /**
     * Test response of Video Controller video_search function if correct input is
     * given 
     *
     * @return void
     */
    public function test_video_search_pagination_success() {
        $this->json('GET', 'api/video-search-pagination', ['search_term' => 'test', 'number_of_videos' => '1', 'next' => true, 'move_by' => 1, 'token' => 'CAYQAA'])->assertStatus(200);
    }

    /**
     * Test response of Video Controller video_search_pagination function if an error occurs (0 search results)
     *
     * @return void
     */
    public function test_video_search_pagination_error() {
        $this->json('GET', 'api/video-search-pagination', ['search_term' => 'qwhdh814834ythoewidfawelpgfk', 'number_of_videos' => '1', 'next' => true, 'move_by' => 1, 'token' => 'CAYQAA'])->assertStatus(500);
    }

}
