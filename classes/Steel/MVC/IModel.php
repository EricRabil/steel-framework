<?php

namespace Steel\MVC;

/**
 * Interface for the model component of the MVC
 * 
 * @since   1.0
 * @author  Eric Rabil <ericjrabil@gmail.com>
 */
interface IModel {

    /**
     * Constructor for any models.
     * 
     * @param \Steel\Steel $steel Gives the model the Steel variable, to be used by View/Controller
     */
    public function __construct(\Steel\Steel $steel);
    
    /**
     * Get the context (variables that the template will have access to.
     * 
     * @return array
     */
    public function get_context();
}
