<?php

namespace Steel\MVC;

interface IController {

    public function __construct(\Steel\MVC\MVCBundle $bundle);

    public function main($params);
}
