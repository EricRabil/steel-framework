<?php

class IndexModel implements \Steel\MVC\IModel {

    public $steel;

    public function __construct(\Steel\Steel $steel) {
      $this->steel = $steel;
    }

}
