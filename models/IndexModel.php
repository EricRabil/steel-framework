<?php

class IndexModel implements IModel {

    public $pageTitle;
    public $bodyText;
    public $background;
    public $steel;

    public function __construct(\BackBones\BackBones $steel) {
        $this->steel = $steel;
    }

}
