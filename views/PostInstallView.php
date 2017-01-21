<?php

class PostInstallView implements \Steel\MVC\IView {

    private $bundle;
    private $model;

    public function __construct(\Steel\MVC\MVCBundle $bundle) {
        $this->bundle = $bundle;
        $this->model = $this->bundle->get_model();
    }

    public function render() {
        $page = 'postinst.phtml';
        require $this::TEMPLATESDIR . '/layout.phtml';
    }

}
