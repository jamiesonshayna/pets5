<?php

class Dodo extends Pet
{
    private $_extinct;

    function __construct($name="unknown", $color="white", $type="?", $extinct="yes")
    {
        parent::__construct($name, $color, $type);

        $this->_extinct = $extinct;
    }

    function talk()
    {
        echo $this->getName() . " says \"DOOM ON YOU\"<br>";
    }
}