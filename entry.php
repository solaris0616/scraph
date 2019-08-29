<?php
class Entry {
    private $id;
    private $url;
    private $body;

    public function __construct($id, $url, $body) {
        $this->id = $id;
        $this->url = $url;
        $this->body = $body;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getBody() {
        return $this->body;
    }
}
?>
