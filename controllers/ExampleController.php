<?php

class ExampleController implements IController {

    private $model;
    private $bundle;

    public function __construct(\BackBones\MVC\MVCBundle $bundle) {
        $this->bundle = $bundle;
        $this->model = $this->bundle->get_model();
    }

    public function main($params) {
        $this->model->exampleTitle = "HEY GUYS!";
        $this->model->exampleMessage = "This is my example!";
    }
    
    public function ex($params){
        $this->model->exampleTitle = "This is my other example";
        $this->model->exampleMessage = "This shows how you can create sub-pages.";
    }

}

