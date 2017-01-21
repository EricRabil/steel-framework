<?php

class PostInstallController implements \Steel\MVC\IController {

    private $model;
    private $bundle;

    public function __construct(\Steel\MVC\MVCBundle $bundle) {
        $this->bundle = $bundle;
        $this->model = $this->bundle->get_model();
    }

    public function main($params) {

    }

}
