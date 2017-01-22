<?php

namespace Steel\MVC;

interface IView {

    public function __construct(\Steel\MVC\MVCBundle $bundle);

    public function render();
}
