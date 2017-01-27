<?php

/*
 * After this require, all Steel classes, instances, objects are loaded. Steel has not been run yet.
 */
require '../classes/Steel/Steel.php';

$steel = new Steel\Steel;

$steel->map(new \Steel\MVC\MVCIdentifier('MVC-INDEX', 'index', 'IndexModel', 'IndexView', 'IndexController', [], []));

$steel->init();
