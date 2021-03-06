<?php

class PostInstallModel implements \Steel\MVC\IModel {

    public $background;
    public $steel;
    public $page_title = "Steel";
    public $navbar_title = "";
    public $context = [];

    public function __construct(\Steel\Steel $steel) {
        $this->steel = $steel;
    }

    public function get_context() {
        return $this->context;
    }

}
