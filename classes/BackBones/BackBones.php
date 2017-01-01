<?php

namespace BackBones;

class BackBones {

    private $mvcMap = array();
    private $components;
    private $path;
    public $config;
    
    private $initialized = false;

    private function set_mvc_map() {
        $this->mvcMap['index'] = new \BackBones\MVC\MVCIdentifier('MVC-INDEX', 'index', 'IndexModel', 'IndexView', 'IndexController', array(), array());
        $this->mvcMap['example'] = new \BackBones\MVC\MVCIdentifier('MVC-EXAMPLE', 'example', 'ExampleModel', 'ExampleView', 'ExampleController', array(), array());
    }

    public function init() {
        if(!$this->initialized){
            $this->path = trim(preg_replace("/[^a-z0-9_\\/]+/i", "", (isset($_GET['method'])) ? $_GET['method'] : 'index'), '/');
            require dirname(__FILE__) . '/Settings.php';
            $conf = new \BackBones\Settings();
            $conf->setup();
            $this->config = $conf->getConfig();
            $this->require_interfaces();
            if ($this->config['backbones']['autoinclude']) {
                $this->require_includes();
            }
            $this->set_mvc_map();
            $this->process_request();
            $this->initialized = true;
        }
    }

    private function require_interfaces() {
        require dirname(__FILE__) . '/../../models/IModel.php';
        require dirname(__FILE__) . '/../../controllers/IController.php';
        require dirname(__FILE__) . '/../../views/IView.php';
        return true;
    }

    public function get_config() {
        return $this->config;
    }

    private function require_includes() {
        $files = scandir(dirname(__FILE__) . "/../../include");
        $include = array();
        foreach ($files as $file) {
            $extension = explode('.', $file);
            if (isset($extension[1]) && !empty($extension[1]) && $extension[1] === "php") {
                array_push($include, $file);
            }
        }
        foreach ($include as $file) {
            require dirname(__FILE__) . "/../../include/" . $file;
        }
        require dirname(__FILE__) . '/MVC/MVCBundle.php';
        require dirname(__FILE__) . '/MVC/MVCIdentifier.php';
    }

    public function get_mvc_map() {
        return $this->mvcMap;
    }

    private function process_request() {
        $this->components = explode('/', $this->path);
        $class = $this->components[0];
        if (!array_key_exists($class, $this->mvcMap)) {
            $this->display_error(2, array('path' => $this->path));
        }
        $mvcID = $this->mvcMap[$class];
        $mvc = new \BackBones\MVC\MVCBundle($this, $mvcID);
        $status = $mvc->runMVC();
        if ($status != 1) {
            switch ($status) {
                case 2:
                    $this->display_error(2, array('path' => $this->path));
                    break;
                case 3:
                    $this->display_error(3, array('message' => "MVC " + $mvcID->get_uid + " has already been executed."));
                    break;
            }
        }
    }

    public function get_components() {
        return $this->components;
    }

    public function display_error($int, $args) {
        $errorID = new \BackBones\MVC\MVCIdentifier('MVC-ERR', 'error', 'ErrorModel', 'ErrorView', 'ErrorController', array('__construct', 'main'), array(dirname(__FILE__) . '/../../models/IErrorModel.php', dirname(__FILE__) . '/../../controllers/IErrorController.php'));
        $mvc = new \BackBones\MVC\MVCBundle($this, $errorID);
        $mvc->init();
        $mvc->get_controller()->parse_error($int, $args);
        $mvc->get_view()->render();
        exit();
    }
    
    public function get_path(){
        return $this->path;
    }

}
