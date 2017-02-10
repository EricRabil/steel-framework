<?php

namespace Steel\MVC;

/**
 * Wrapper for the individual Model, View and Controller classes of the MVC.
 * 
 * Used to run the normal MVC and errors if needed.
 * 
 * @since   1.0
 * @author  Eric Rabil <ericjrabil@gmail.com>
 */
class MVCBundle {

    /**
     * The data source used to assemble the bundle.
     * 
     * The bundle fetches the file names of the model, view, controller and any dependencies and includes them.
     * 
     * @var MVCIdentifier
     */
    private $mvcID;

    /**
     * The model attached to this MVC.
     * 
     * @var IModel
     */
    private $model;

    /**
     * The view attached to this MVC.
     * 
     * @var IView
     */
    private $view;

    /**
     * The controller attached to this MVC.
     * 
     * @var IController
     */
    private $controller;

    /**
     * The URL parameters
     * 
     * @var array
     */
    private $params = [];

    /**
     * Determines if the bundle has already been initialized (used as a safeguard for poorly made code)
     * 
     * @var boolean
     */
    private $initialized = false;

    /**
     * The components
     *
     * @var array
     */
    private $components;

    /**
     * @var \Steel\Steel
     */
    private $steel;

    /**
     * Constructor for the MVCBundle
     * 
     * Includes all necessary files. Sets the MVC Identifier. Sets the Steel variable.
     * 
     * @param \Steel\Steel $steel Used to access the main framework.
     * @param \Steel\MVC\MVCIdentifier $mvcidentifier Used to access any MVC metadata.
     */
    public function __construct(\Steel\Steel $steel, \Steel\MVC\MVCIdentifier $mvcidentifier) {
        $this->steel = $steel;
        $this->mvcID = $mvcidentifier;
        foreach ($this->mvcID->get_dependencies() as $path) {
            require_once $path;
        }
        $modeldir = (!$mvcidentifier->get_custom_path() ? $steel->directories['models'] : $mvcidentifier->get_custom_path().'/models/');
        $controllerdir = (!$mvcidentifier->get_custom_path() ? $steel->directories['controllers'] : $mvcidentifier->get_custom_path().'/controllers/');
        $viewdir = (!$mvcidentifier->get_custom_path() ? $steel->directories['views'] : $mvcidentifier->get_custom_path().'/views/');
        require_once $modeldir . $mvcidentifier->get_model_name() . '.php';
        require_once $controllerdir . $mvcidentifier->get_controller_name() . '.php';
        require_once $viewdir . $mvcidentifier->get_view_name() . '.php';
    }

    /**
     * Initializes the model, view and controller.
     * 
     * Gets the model, view and controller class names and instantiates them. Flags the bundle as initialized.
     */
    public function init() {
        if (!$this->initialized) {
            $modelName = $this->mvcID->get_model_name();
            $viewName = $this->mvcID->get_view_name();
            $controllerName = $this->mvcID->get_controller_name();
            $this->model = new $modelName($this->steel);
            $this->controller = new $controllerName($this);
            $this->view = new $viewName($this);
            $this->initialized = true;
        }
    }

    /*
     * Code Interpretation:
     * 1 = Success
     * 2 = Not found
     */

    /**
     * Runs the controller, then the view.
     * 
     * @return int The response code
     */
    public function runMVC() {
        if (!$this->initialized) {
            $this->init();
        }
        $this->handle_params();
        if (array_key_exists(1, $this->components)) {
            if (in_array($this->components[1], $this->mvcID->get_forbidden_paths())) {
                return 2;
            }
            if (method_exists($this->controller, $this->components[1])) {
                $this->controller->{$this->components[1]}($this->params);
                $this->view->render();
                return 1;
            } else {
                return 2;
            }
        } else {
            $this->controller->main($this->params);
            $this->view->render();
            return 1;
        }
    }

    /**
     * Get the MVC Identifier
     * 
     * @return \Steel\MVC\MVCIdentifier
     */
    public function get_mvc_identifier() {
        return $this->mvcID;
    }

    /**
     * 
     * @param \Steel\MVC\MVCIdentifier $mvcidentifier The MVC Identifier to update.
     * @return boolean Returns false if this is being called post-initialization. Nothing will happen if returned false.
     */
    public function set_mvc_identifier($mvcidentifier) {
        if (!$this->initialized) {
            $this->mvcID = $mvcidentifier;
            require_once $this->steel->directories['models'] . $mvcidentifier->get_model_name() . '.php';
            require_once $this->steel->directories['controllers'] . $mvcidentifier->get_controller_name() . '.php';
            require_once $this->steel->directories['views'] . $mvcidentifier->get_view_name() . '.php';
            return true;
        } else {
            return false;
        }
    }

    /**
     * Gets the initialized variable.
     * 
     * @return boolean Returns the initialization status of the bundle.
     */
    public function is_initialized() {
        return $this->initialized;
    }

    /**
     * Gets the assigned model.
     * 
     * @return \Steel\MVC\IModel|boolean Returns the model if set or false if unset.
     */
    public function get_model() {
        if (!isset($this->model)) {
            return false;
        }
        return $this->model;
    }

    /**
     * Gets the assigned view.
     * 
     * @return \Steel\MVC\IView|boolean Returns the view if set or false if unset.
     */
    public function get_view() {
        if (!isset($this->view)) {
            return false;
        }
        return $this->view;
    }

    /**
     * Gets the assigned controller.
     * 
     * @return \Steel\MVC\IController|boolean Returns the controller if set or false if unset.
     */
    public function get_controller() {
        if (!isset($this->controller)) {
            return false;
        }
        return $this->controller;
    }

    private function handle_params() {
        if (empty($this->steel->get_components())) {
            $this->components = [];
            return;
        }
        $this->components = $this->steel->get_components();
        if (count($this->components) <= 3) {
            foreach ($this->components as $key => $val) {
                if ($key < 2) {
                    continue;
                }
                array_push($this->params, $val);
            }
        }
    }

}
