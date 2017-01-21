<?php

namespace Steel\MVC;

interface IModel {

    public function __construct(\Steel\Steel $steel);
    
    public function get_context();
}
