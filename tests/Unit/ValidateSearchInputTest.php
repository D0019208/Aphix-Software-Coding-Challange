<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\VideoController;

class ValidateSearchInputTest extends TestCase {

    /**
     * @test
     * 
     * Test to see if correct message is returned by validate_search_input function
     * if search term is empty
     *
     * @return void
     */
    public function search_term_missing() {
        $controller = new VideoController();

        $response = $controller->validate_search_input('', '1');
        $this->assertEquals($response["message"], 'The search query cannot be empty, please fill it in and try again.');
    }

    /**
     * @test
     * 
     * Test to see if correct message is returned by validate_search_input function
     * if number of videos value is missing
     *
     * @return void
     */
    public function number_of_videos_missing() {
        $controller = new VideoController();

        $response = $controller->validate_search_input('test', '');
        $this->assertEquals($response["message"], 'Please enter the number of videos you wish to display and try again.');
    }
    
    /**
     * @test
     * 
     * Test to see if correct message is returned by validate_search_input function
     * if the number of videos value is less than 1
     *
     * @return void
     */
    public function number_of_videos_less_than_one() {
        $controller = new VideoController();
        
        $response = $controller->validate_search_input('test', '0');
        $this->assertEquals($response["message"], 'You cannot display less than 1 video! Please enter a value greater than 0 and try again.');
    }
    
    /**
     * @test
     * 
     * Test to see if correct message is returned by validate_search_input function
     * if all correct parameters are sent
     *
     * @return void
     */
    public function validate_search_input() {
        $controller = new VideoController();
        
        $response = $controller->validate_search_input('test', '1');
        $this->assertEquals($response["message"], 'Input is valid.');
    }
}
