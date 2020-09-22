<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\VideoModel;
use App\Helpers\Video;

class VideoModelTest extends TestCase {
    /**
     * @test
     * 
     * Test to see if correct message is returned after function creates all views
     * from the provided Video objects
     *
     * @return void
     */
    public function create_video_views() {
        $response = VideoModel::create_video_views([new Video(1, "testurl.com 1", "test title 1", "test description 1", "test youtube channel 1"), new Video(2, "testurl.com 2", "test title 2", "test description 2", "test youtube channel 2"), new Video(3, "testurl.com 3", "test title 3", "test description 3", "test youtube channel 3")]);
        $this->assertEquals($response["message"], 'Video views created successfully');
    }

}
