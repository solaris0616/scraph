<?php
class Entry {
    private $id;
    private $url;
    private $title;
    private $body;

    public function __construct($id, $url, $title, $body) {
        $this->id = $id;
        $this->url = $url;
        $this->title = $title;
        $this->body = $body;
    }

    public function getId() {
        return $this->id;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getBody() {
        return $this->body;
    }
}
?>
