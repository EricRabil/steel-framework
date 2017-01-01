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

namespace BackBones;

class Settings {

    private $config = array();

    public function setup() {
        $this->config['backbones'] = array();
        $this->config['backbones']['version'] = 2.0;
        $this->config['backbones']['type'] = "canary";
        /*
         * Enabled by default
         * Automatically include files in the 'include' directory. If disabled, make sure you inject
         * code to require your files.
         */
        $this->config['backbones']['autoinclude'] = true;

        $this->config['general'] = array();
        $this->config['general']['host'] = 'http://localhost';
    }

    public function getConfig() {
        return $this->config;
    }

}
