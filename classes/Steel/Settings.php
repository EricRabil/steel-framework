<?php

/*
 * Settings API
 *
 * Settings uses multi-dimensional arrays; this is for settings structure and organization.
 * An example of this is as follows
 *
 * Category: General
 * Setting: Host
 * Variable: $this->config['general']['host']
 *
 * Category: General
 * Sub-Category: JS Links
 * Setting: Local
 * Variable: $this->config['general']['js_links']['local']
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
        $this->config['steel']['postinst'] = true;
        $this->config['steel']['version'] = "v1.0";
        $this->config['steel']['type'] = "release";

        $this->config['steel']['autoinclude'] = false;
        $this->config['steel']['useApplication'] = false;
        $this->config['steel']['application'] = ['filepath' => dirname(__FILE__) . '/../../app/Application.php', 'fully_qualified_name' => '\MyCoolApplicationNamespace\MyCoolApplication'];

        $this->config['steel']['useSessions'] = false;

        $this->config['steel']['useLang'] = false;

        $this->config['resources'] = [];

        /*
         * This is an example of a bootstrap setup. The `url` and `sri` keys ARE required; SRI is subresource integrity - its purpose is to prevent unauthorized tampering of files.
         * The SRI of a url can be calculated at http://srihash.org
         */
        $this->config['resources']['css'] = [
            /*
            [
                //The `name` key is not required and is used for organizational purposes.
                'name' => 'bootstrap-css',
                'url' => 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
                'sri' => 'sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u'
            ]
             */
        ];
        
        $this->config['resources']['js'] = [
            /*
            [
                //The `name` key is not required and is used for organizational purposes.
                'name' => 'jquery',
                'url' => 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js',
                'sri' => 'sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ'
            ],
            [
                //The `name` key is not required and is used for organizational purposes.
                'name' => 'bootstrap-js',
                'url' => 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
                'sri' => 'sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa'
            ]
             */
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
