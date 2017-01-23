<?php

class IndexModel implements \Steel\MVC\IModel {

    public $steel;
    public $context = [];

    public function __construct(\Steel\Steel $steel) {
        $this->steel = $steel;
    }

    public function get_context() {
        return $this->context;
    }

}
