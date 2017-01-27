<?php

class IndexView implements \Steel\MVC\IView {

    private $bundle;
    private $model;

    public function __construct(\Steel\MVC\MVCBundle $bundle) {
        $this->bundle = $bundle;
        $this->model = $this->bundle->get_model();
    }

    public function render() {
        $this->model->steel->render($this->model, 'index.phtml', new Steel\MVC\RenderConfiguration);
    }

}
