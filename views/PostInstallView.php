<?php

class PostInstallView implements \Steel\MVC\IView {

    private $bundle;
    private $model;

    public function __construct(\Steel\MVC\MVCBundle $bundle) {
        $this->bundle = $bundle;
        $this->model = $this->bundle->get_model();
    }

    public function render() {
        $a = [
            [
                //The `name` key is not required and is used for organizational purposes.
                'name' => 'jquery',
                'url' => 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js',
                'sri' => 'sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ'
            ],
            [
                //The `name` key is not required and is used for organizational purposes.
                'name' => 'bootstrap-js',
                'url' => 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
                'sri' => 'sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa'
            ]
        ];
        $b = [
            [
                'url' => 'https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/simplex/bootstrap.min.css',
                'sri' => 'sha384-C0X5qw1DlkeV0RDunhmi4cUBUkPDTvUqzElcNWm1NI2T4k8tKMZ+wRPQOhZfSJ9N'
            ],
            [
                'url' => 'https://ericrabil.github.io/steel-framework/postinst.css',
                'sri' => 'sha384-bOESNL1zRpQ98XPocxzUWHrKxup+5QXOPRSb/LciKC0moQHpKrEJ2VU+Mj0+9Yvl'
            ],
            [
                'url' => 'https://ericrabil.github.io/steel-framework/jumbotron-narrow.css',
                'sri' => 'sha384-pf2gnQFGpyBR3PTyKIcf++2RFQOFSMjvDX8gXKzsxX5PE57DhDvx42idHuOtmSuD'
            ]
        ];
        $this->model->steel->render($this->model, 'postinst.phtml', $renderconfig = new Steel\MVC\RenderConfiguration, $b, $a);
    }

}
