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
        $this->config['steel']['version'] = 2.0;
        $this->config['steel'] = [];
        $this->config['steel']['type'] = "canary";
        /*
         * Enabled by default
         * Automatically include files in the 'include' directory. If disabled, make sure you inject
         * code to require your files.
         */
        $this->config['steel']['autoinclude'] = true;

        $this->config['general'] = [];
        $this->config['general']['host'] = 'http://localhost';
        $this->config['database'] = [];
    }

    public function getConfig() {
        return $this->config;
    }

}
