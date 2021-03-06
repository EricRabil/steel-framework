<?php

namespace Steel\MVC;

/**
 * Interface for the view component of the MVC
 * 
 * @since   1.0
 * @author  Eric Rabil <ericjrabil@gmail.com>
 */
interface IView {

    /**
     * Constructor for any views.
     * 
     * @param \Steel\MVC\MVCBundle $bundle Gives the view the MVCBundle so it can assign its variables
     */
    public function __construct(\Steel\MVC\MVCBundle $bundle);

    /**
     * Wrapper for the Steel render function.
     * 
     * Performs any last-minute actions before rendering the page.
     */
    public function render();
}
