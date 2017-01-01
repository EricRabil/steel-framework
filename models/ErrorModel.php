<?php

class ErrorModel implements IErrorModel {

    private $errorText;
    private $errorTitle;
    private $errorType = "error";
    public $backbones;

    public function __construct(\BackBones\BackBones $backbones) {
        $this->errorText = "Something went wrong!";
        $this->errorTitle = "Uh-oh.";
        $this->backbones = $backbones;
    }

    public function get_error_text() {
        return $this->errorText;
    }

    public function get_error_title() {
        return $this->errorTitle;
    }

    public function get_error_type() {
        return $this->errorType;
    }

    public function set_error_text($text) {
        $this->errorText = $text;
    }

    public function set_error_title($title) {
        $this->errorTitle = $title;
    }

    public function set_error_type($type) {
        $this->errorType = $type;
    }

}
