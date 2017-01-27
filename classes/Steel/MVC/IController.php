<?php

namespace Steel\MVC;

/**
 * Interface for the controller component (logic) of MVC
 * 
 * @since   1.0
 * @author  Eric Rabil <ericjrabil@gmail.com>
 */
interface IController {

    /**
     * Constructor for any controllers.
     * 
     * @param \Steel\MVC\MVCBundle $bundle Gives the controller the MVCBundle so it can assign its variables
     */
    public function __construct(\Steel\MVC\MVCBundle $bundle);

    /**
     * Runs the controller with optionally added parameters
     * 
     * @param array $params Any added instructions for the controller
     */
    public function main($params);
}
