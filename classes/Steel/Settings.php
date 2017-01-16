<?php

/*
 * Settings API
 * 
 * Settings uses multi-dimensional arrays; this is for settings structure and organization.
 * An example of this is as follows
 * 
 * Category: General
 * Setting: Host
 * Variable: $config['general']['host']
 * 
 * Category: General
 * Sub-Category: JS Links
 * Setting: Local
 * Variable: $config['general']['js_links']['local']
 * 
 * Naming conventions are all lower case, alpha-numeric, and underscores for spaces.
 * 
 * Testing Testing 123 would become testing_testing_123
 */

namespace Steel;

class Settings {

    private $config = [];

    public function setup() {
        $this->config['steel'] = [];
        $this->config['steel']['version'] = "v1.0-rc2";
        $this->config['steel']['type'] = "release-candidate";
        /*
         * Enabled by default
         * Automatically include files in the 'include' directory. If disabled, make sure you inject
         * code to require your files.
         */
        $this->config['steel']['autoinclude'] = true;
        $this->config['steel']['useApplication'] = false;
        $this->config['steel']['application'] = array('filepath' => dirname(__FILE__).'/../../app/Application.php', 'fully_qualified_name' => '\MyCoolApplicationNamespace\MyCoolApplication');
        
        $this->config['steel']['useSessions'] = true;
        
        $this->config['steel']['useLang'] = false;
        
        $this->config['resources'] = array();
        
        //SRI IS required. It is not hard to do.
        
        $this->config['resources']['css'] = [];
        $this->config['resources']['css-sri'] = [];
        
        $this->config['resources']['js'] = [
        	'jquery' => "https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"
        ];
        $this->config['resources']['js-sri'] = [
        	'jquery' => "sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ"
        ];

        $this->config['general'] = [];
        $this->config['general']['host'] = 'http://localhost';
        
        $this->config['database'] = [];
        //Set to false if you want to use your own database connection methods
        $this->config['database']['enabled'] = false;
        $this->config['database']['username'] = 'steel';
        $this->config['database']['password'] = 'steel';
        $this->config['database']['ip'] = '127.0.0.1';
        $this->config['database']['port'] = '3306';
        $this->config['database']['dbname'] = 'steel';
    }

    public function getConfig() {
        return $this->config;
    }

}
