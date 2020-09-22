<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Video extends Component
{
    public $url;
    public $title;
    public $description;
    public $channel;
    
    /**
     * Create a new Video component instance
     *
     * @return void
     */
    public function __construct(string $url, string $title, string $description, string $channel)
    {
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
        $this->channel = $channel;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.video');
    }
}
