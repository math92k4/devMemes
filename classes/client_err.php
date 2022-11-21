<?php
class ClientErr extends Exception {
    protected $message;
    protected $response_code;

    public function __construct($message, $response_code = 400) {
        $this->message = $message;
        $this->response_code = $response_code;
    }

    public function text() {
        return $this->message;
    }
    public function code() {
        return $this->response_code;
    }
}