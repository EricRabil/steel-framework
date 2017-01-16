<?php

class ExampleModel implements IModel {
    
    public $steel;
    
    public $exampleTitle;
    public $exampleMessage;

    public function __construct(\Steel\Steel $steel) {
        $this->steel = $steel;
    }

}