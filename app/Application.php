<?php
namespace MyCoolApplicationNamespace;

class MyCoolApplication implements Steel\IApplication{
    
    private $steel;
    private $bundle;
    private $args;
    
    private $intercept = array(
        'mycoolinterceptedpage'
    );
    
    public function __constructor(\Steel\Steel $steel) {
        $this->steel = $steel;
    }

    public function call(\Steel\MVC\MVCBundle $bundle, $arguments) {
        if(in_array($arguments[0], $this->intercept)){
            $this->bundle = $bundle;
            $this->args = $arguments;
            return true;
        }else{
            return false;
        }
    }

}