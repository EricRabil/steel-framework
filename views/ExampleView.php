<?php

class ExampleView implements IView {

    private $bundle;
    private $model;
    private $context = array();

    public function __construct(\BackBones\MVC\MVCBundle $bundle) {
        $this->bundle = $bundle;
        $this->model = $this->bundle->get_model();
    }

    public function render() {
        $page = 'example.phtml';
        $this->context['title'] = $this->model->exampleTitle;
        $this->context['body'] = $this->model->exampleMessage;
        extract($this->context);
        require $this::TEMPLATESDIR . '/layout.phtml';
    }

}
