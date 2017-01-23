<?php

class PostInstallView implements \Steel\MVC\IView {

    private $bundle;
    private $model;

    public function __construct(\Steel\MVC\MVCBundle $bundle) {
        $this->bundle = $bundle;
        $this->model = $this->bundle->get_model();
    }

    public function render() {
        $b = array(
            array(
                'url' => 'https://ericrabil.github.io/steel-framework/postinst.css',
                'sri' => 'sha384-bOESNL1zRpQ98XPocxzUWHrKxup+5QXOPRSb/LciKC0moQHpKrEJ2VU+Mj0+9Yvl'
            ),
            array(
                'url' => 'https://ericrabil.github.io/steel-framework/jumbotron-narrow.css',
                'sri' => 'sha384-pf2gnQFGpyBR3PTyKIcf++2RFQOFSMjvDX8gXKzsxX5PE57DhDvx42idHuOtmSuD'
            )
        );
        $this->model->steel->render($this->model, 'postinst.phtml', $b, $a = []);
    }

}
