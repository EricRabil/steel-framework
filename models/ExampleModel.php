<?php

class ExampleModel implements IModel {
    
    public $steel;
    
    public $exampleTitle;
    public $exampleMessage;

    public function __construct(\BackBones\BackBones $steel) {
        $this->steel = $steel;
    }

}