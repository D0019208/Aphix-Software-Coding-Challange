<?php

namespace App\Helpers;

class Video {

    /**
     * ID of the video
     *
     * @param string
     */
    public $id;

    /**
     * URL of the video
     *
     * @param string
     */
    public $url;

    /**
     * Title of the video
     *
     * @param string
     */
    public $title;

    /**
     * Description of the video
     *
     * @param string
     */
    public $description;

    /**
     * Link to the channel the video belongs to
     *
     * @param string
     */
    public $channel_url;

    /**
     * Video object constructor.
     *
     * @param string - $id
     * @param string - $url
     * @param string - $title
     * @param int - $description
     * @param string - $youtube_channel
     */
    public function __construct(int $id = 0, string $url = "", string $title = "", string $description = "", string $channel_url = "") { //Mayve add 
        $this->id = $id;
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
        $this->channel_url = $channel_url;
    }
    
    function getId(): string {
        return $this->id;
    }

    function getUrl(): string {
        return $this->url;
    }

    function getTitle(): string {
        return $this->title;
    }

    function getDescription(): string {
        return $this->description;
    }
    
    function getChannel_url() {
        return $this->channel_url;
    }

    function setId(string $id): void {
        $this->id = $id;
    }

    function setUrl(string $url): void {
        $this->url = $url;
    }

    function setTitle(string $title): void {
        $this->title = $title;
    }

    function setDescription(string $description): void {
        $this->description = $description;
    }
    
    function setChannel_url($channel_url): void {
        $this->channel_url = $channel_url;
    }

}
