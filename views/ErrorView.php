<?php

class ErrorView implements \Steel\MVC\IView {

    private $bundle;
    private $model;

    public function __construct(\Steel\MVC\MVCBundle $bundle) {
        $this->bundle = $bundle;
        $this->model = $this->bundle->get_model();
    }

    public function render() {
        $this->model->context['error_title'] = $this->model->get_error_title();
        $this->model->context['error_text'] = $this->model->get_error_text();
        $this->model->steel->render($this->model, 'error.phtml', new Steel\MVC\RenderConfiguration);
    }

}
