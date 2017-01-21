<?php

class PostInstallController implements \Steel\MVC\IController {

    private $model;
    private $bundle;

    public function __construct(\Steel\MVC\MVCBundle $bundle) {
        $this->bundle = $bundle;
        $this->model = $this->bundle->get_model();
        $this->model->steel->config['steel']['version-metadata'] = explode('-', preg_replace("/[a-zA-Z]/", "", $this->model->steel->config['steel']['version']));
        $this->model->steel->config['steel']['typeNice'] = ucwords(str_replace('-', ' ', $this->model->steel->config['steel']['type']));
        $this->model->steel->config['steel']['typeNiceShorthand'] = "";
        switch ($this->model->steel->config['steel']['type']) {
            case 'release-candidate':
                $this->model->steel->config['steel']['typeNiceShorthand'] = 'RC';
                break;
            case 'canary':
                $this->model->steel->config['steel']['typeNiceShorthand'] = 'Beta';
                break;
        }
    }

    public function main($params) {
        $stringbuilder = 'Steel ' . $this->model->steel->config['steel']['version-metadata'][0] . ' ';
        $stringbuilder .= ($this->model->steel->config['steel']['type'] != 'release') ? $this->model->steel->config['steel']['typeNice'] . ' ' : '';
        $stringbuilder .= (isset($this->model->steel->config['steel']['version-metadata'][1])) ? $this->model->steel->config['steel']['version-metadata'][1] : '';
        $this->model->page_title = $stringbuilder;
        $stringbuilder = $this->model->steel->config['steel']['version-metadata'][0] . ' ';
        $stringbuilder .= (!empty($this->model->steel->config['steel']['typeNiceShorthand'])) ? $this->model->steel->config['steel']['typeNiceShorthand'] . ' ' : '';
        $stringbuilder .= (isset($this->model->steel->config['steel']['version-metadata'][1])) ? $this->model->steel->config['steel']['version-metadata'][1] : '';
        $this->model->navbar_title = $stringbuilder;
    }
}
