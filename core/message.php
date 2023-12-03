<?php

namespace Tamm\Core;

class HttpResponseMessage {
    private $type;
    private $message;

    public function __construct($type, $message) {
        $this->type = $type;
        $this->message = $message;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setMessage($message) {
        $this->message = $message;
    }
}