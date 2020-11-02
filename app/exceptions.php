<?php namespace App;

class HttpErrorCodeException extends \Exception {
    public $httpError;

    public function __construct($httpError, $code = 0, Exception $previous = null) {
        $this->httpError = $httpError;

        // make sure everything is assigned properly
        parent::__construct("HTTP error code: " . $httpError, $code, $previous);
    }

    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}