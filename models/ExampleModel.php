<?php

class ExampleModel implements IModel {
    
    public $backbones;
    
    public $exampleTitle;
    public $exampleMessage;

    public function __construct(\BackBones\BackBones $backbones) {
        $this->backbones = $backbones;
    }

}