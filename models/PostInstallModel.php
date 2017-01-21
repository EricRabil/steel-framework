<?php

class PostInstallModel implements \Steel\MVC\IModel {

    public $background;
    public $steel;

    public $page_title = "Steel %s";

    public function __construct(\Steel\Steel $steel) {
        $this->steel = $steel;
        $this->page_title = sprintf($this->page_title, $this->steel->config['steel']['version']);
    }

}
