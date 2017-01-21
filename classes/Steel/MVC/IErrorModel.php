<?php

namespace Steel\MVC;

interface IErrorModel extends \Steel\MVC\IModel {

    public function set_error_title($title);

    public function get_error_title();

    public function set_error_text($text);

    public function get_error_text();

    public function set_error_type($type);

    public function get_error_type();
    
    public function get_context();
}
