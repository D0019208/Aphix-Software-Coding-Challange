<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\VideoController;

class ValidateSearchInputPaginationTest extends TestCase {

    /**
     * @test
     * 
     * Test to see if correct message is returned by validate_search_input_pagination 
     * function if the string used to access the next/previous page is empty
     *
     * @return void
     */
    public function token_missing() {
        $controller = new VideoController();

        $response = $controller->validate_search_input_pagination('test', '1', true, '1', '');
        $this->assertEquals($response["message"], 'The page token is missing. Please reload and try again.');
    }

    /**
     * @test
     * 
     * Test to see if correct message is returned by validate_search_input_pagination 
     * function if the boolean indicating whether to get the next or previous page
     * is missing
     *
     * @return void
     */
    public function next_missing() {
        $controller = new VideoController();

        $response = $controller->validate_search_input_pagination('test', '1', null, '1', 'CAYQAA');
        $this->assertEquals($response["message"], 'The system does not know whether to search next or previous page. Please reload and try again.');
    }
    
    /**
     * @test
     * 
     * Test to see if correct message is returned by validate_search_input_pagination 
     * function if the page number is less than 1
     *
     * @return void
     */
    public function move_by_less_than_one() {
        $controller = new VideoController();
        
        $response = $controller->validate_search_input_pagination('test', '1', true, '', 'CAYQAA');
        $this->assertEquals($response["message"], 'The system does not know what page to access. Please reload and try again.');
    }
    
    /**
     * @test
     * 
     * Test to see if correct message is returned by validate_search_input_pagination function
     * if all correct parameters are sent
     *
     * @return void
     */
    public function validate_search_input_pagination() {
        $controller = new VideoController();
        
        $response = $controller->validate_search_input_pagination('test', '1', true, '1', 'CAYQAA');
        $this->assertEquals($response["message"], 'Input is valid.');
    }
}
