<?php
namespace Steel;

/**
 * Interface for Steel Applications
 * 
 * @since   1.0
 * @author  Eric Rabil <ericjrabil@gmail.com>
 */
interface IApplication {
    public function __constructor(\Steel\Steel $steel);
    public function on_load();
    public function call(\Steel\MVC\MVCBundle $bundle, $arguments);
    public function intercepts($classname);
}