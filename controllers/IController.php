<?php

interface IController {

    public function __construct(\BackBones\MVC\MVCBundle $bundle);

    public function main($params);
}
