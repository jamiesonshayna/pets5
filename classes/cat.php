<?php

class Cat extends Pet
{
    function scratch()
    {
    echo $this->getName() . " is scratching<br>";
    }

    function talk()
    {
    echo $this->getName() . " is meowing<br>";
    }
}