<?php

class IndexView implements IView {

    private $bundle;
    private $model;
    private $context = array();

    public function __construct(\BackBones\MVC\MVCBundle $bundle) {
        $this->bundle = $bundle;
        $this->model = $this->bundle->get_model();
    }

    public function render() {
        $page = 'index.phtml';
        $this->context['title'] = $this->model->pageTitle;
        $this->context['body'] = $this->model->bodyText;
        extract($this->context);
        require $this::TEMPLATESDIR . '/layout.phtml';
    }

}
