<?php

interface IView {

    const TEMPLATESDIR = '../templates';

    public function __construct(\BackBones\MVC\MVCBundle $bundle);

    public function render();
}
