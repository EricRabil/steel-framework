<?php

class IndexModel implements IModel {

    public $pageTitle;
    public $bodyText;
    public $background;
    public $backbones;

    public function __construct(\BackBones\BackBones $backbones) {
        $this->backbones = $backbones;
    }

}
