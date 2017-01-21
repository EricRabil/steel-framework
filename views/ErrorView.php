<?php

class ErrorView implements \Steel\MVC\IView {

    private $bundle;
    private $model;

    public function __construct(\Steel\MVC\MVCBundle $bundle) {
        $this->bundle = $bundle;
        $this->model = $this->bundle->get_model();
    }

    public function render() {
        $this->context['error_title'] = $this->model->get_error_title();
        $this->context['error_text'] = $this->model->get_error_text();
        $page = "error.phtml";
        require $this::TEMPLATESDIR . '/layout.phtml';
    }

}
