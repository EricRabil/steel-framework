<?php
namespace Steel;

require_once 'autoload.php';

use Steel\Database\Connection;

class Steel {

    private $mvcMap = [];
    private $components;
    private $path;
    public $config;

    private $initialized = false;

    private $dir;

    private $sreheader = "<!-- Steel Runtime Error: ";

    public $application;

    public $database;

    public function map(\Steel\MVC\MVCIdentifier ...$identifiers) {
        foreach ($identifiers as $identifier) {
            $this->mvcMap[$identifier->get_path()] = $identifier;
        }
    }

    public function init() {
        if (!$this->initialized) {
            $this->dir = dirname(__FILE__);
            $this->path = trim(preg_replace("/[^a-z0-9_\\/]+/i", "", (isset($_GET['method'])) ? $_GET['method'] : 'index'), '/');
            $conf = new \Steel\Settings();
            $conf->setup();
            $this->config = $conf->getConfig();
            if ($this->config['steel']['useSessions']) {
                session_start();
            }
            if ($this->config['database']['enabled']) {
                $this->database = new Connection($this);
            } else {
                $this->database = false;
            }
            if ($this->config['steel']['autoinclude']) {
                $this->require_includes();
            }
            if ($this->config['steel']['useApplication']) {
                $this->use_app_controller();
            } else {
                $this->application = null;
            }
            $this->process_request();
            $this->initialized = true;
        }
    }

    private function use_app_controller() {
        if ($this->config['steel']['useApplication']) {
            require_once $this->config['steel']['application']['filepath'];
            $this->application = new $this->config['steel']['application']['fully_qualified_name']($this);
            if (!ReflectionClass::implementsInterface($this->application, '\Steel\IApplication')) {
                echo get_class($this->application) . " must be implement \Steel\IApplication";
                exit();
            }
        }else {
            return false;
        }
    }

    public function get_config() {
        return $this->config;
    }

    private function require_include_folder() {
        $files = scandir($this->dir . "/../../include");
        $include = [];
        foreach ($files as $file) {
            $extension = explode('.', $file);
            if (isset($extension[1]) && !empty($extension[1]) && $extension[1] === "php") {
                array_push($include, $file);
            }
        }
        foreach ($include as $file) {
            require $this->dir . "/../../include/" . $file;
        }
    }

    private function require_includes() {
        if (!file_exists($this->dir . '/../../include')) {
            if (!is_writable($this->dir . '/../..')) {
                echo $this->sreheader . 'Failed to create missing \'include\' directory. Check that PHP has the proper execution permissions. -->' . PHP_EOL;
            } else {
                mkdir($this->dir . '/../../include', 0755, true);
                $this->require_include_folder();
            }
        } else {
            $this->require_include_folder();
        }
    }

    public function get_mvc_map() {
        return $this->mvcMap;
    }

    private function postinst() {
        $mvcID = new \Steel\MVC\MVCIdentifier('MVC-POSTINST', 'postinstall', 'PostInstallModel', 'PostInstallView', 'PostInstallController', [], []);
        $mvc = new \Steel\MVC\MVCBundle($this, $mvcID);
        $mvc->runMVC();
    }

    private function process_request() {
        if ($this->config['steel']['postinst']) {
            $this->postinst();
            return;
        }
        $this->components = explode('/', $this->path);
        $class = $this->components[0];
        if (!array_key_exists($class, $this->mvcMap)) {
            $this->display_error(2, array('path' => $this->path));
            return;
        }
        $mvcID = $this->mvcMap[$class];
        $mvc = new \Steel\MVC\MVCBundle($this, $mvcID);
        $intercepted = ($this->config['steel']['useApplication']) ? $this->application->call($mvc, $this->components) : false;
        if (!$intercepted) {
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
        }else {
            return;
        }
    }

    public function get_components() {
        return $this->components;
    }

    public function display_error($int, $args) {
        $errorID = new \Steel\MVC\MVCIdentifier('MVC-ERR', 'error', 'ErrorModel', 'ErrorView', 'ErrorController', array('__construct', 'main'), array($this->dir . '/MVC/IErrorModel.php', $this->dir . '/MVC/IErrorController.php'));
        $mvc = new \Steel\MVC\MVCBundle($this, $errorID);
        $mvc->init();
        $mvc->get_controller()->parse_error($int, $args);
        $mvc->get_view()->render();
    }

    public function get_path() {
        return $this->path;
    }
    
    public function render(\Steel\MVC\IModel $model, $page, $styles = [], $scripts = []) {
        $context = $model->get_context();
        extract($context);
        require_once $this->dir . '/../../templates/layout.phtml';
    }

}
