<?php

class PetController
{
    private $_f3;
    private $_val;

    public function __construct($f3)
    {
        $this->_f3 = $f3;
        $this->_val = new Validation();
    }

    public function defaultRoute()
    {
        echo "<h1>My Pets</h1>";
        echo "<a href='order'>Order a Pet</a>";
    }

    public function home()
    {
        $_SESSION=array();//clear the session
        if(isset($_POST['animal']))
        {
            $animal = $_POST['animal'];
            $this->_f3->set('stickyAnimal', $animal);
            if($this->_val->validAnimal($animal))
            {
                if (trim(strtoupper($animal)) == 'CAT'){
                    $_SESSION['myAnimal'] = new Cat();
                    $_SESSION['myAnimal']->setType('Cat');
                }
                else if (trim(strtoupper($animal)) == 'DOG'){
                    $_SESSION['myAnimal'] = new Dog();
                    $_SESSION['myAnimal']->setType('Dog');
                }
                else if (trim(strtoupper($animal)) == 'DODO'){
                    $_SESSION['myAnimal'] = new Dodo();
                    $_SESSION['myAnimal']->setType('Dodo');
                }
                else {
                    $_SESSION['myAnimal'] = new Pet();
                    $_SESSION['myAnimal']->setType('Pet');
                }

                //$_SESSION['animal']=$animal;
                $this->_f3->reroute('/order2');
            }
            else{
                $this->_f3->set("errors['animal']","Please enter an animal.");
            }
        }
        $view = new Template();
        echo $view->render('views/form1.html');
    }

    public function form2()
    {
        if(isset($_POST['color']))
        {
            //for keeping form sticky
            $colorIsValid = false;
            $nameIsValid = false;

            $color = $_POST['color'];
            $name = $_POST['petName'];
            $this->_f3->set('displayColor', $color);
            $this->_f3->set('displayName', $name);
            if($this->_val->validColor($color))
            {
                $_SESSION['myAnimal']->setColor($color);
                $colorIsValid = true;
            }
            else {
                $this->_f3->set("errors['color']","Please enter an color.");
            }

            if ($this->_val->validName($name)){
                $_SESSION['myAnimal']->setName($name);
                $nameIsValid = true;
            }
            else {
                $this->_f3->set("errors['pName']","Please enter a pet name.");
            }

            if ($colorIsValid && $nameIsValid){
                // if the last two fields are valid then we want to save results to database
                $GLOBALS['db']->addNewPet($_SESSION['myAnimal']);

                // route to summary/results page
                $this->_f3->reroute('/results');
            }

        }

        $view = new Template();
        echo $view->render('views/form2.html');
    }

    public function results()
    {
        $view = new Template();
        echo $view->render('views/results.html');
    }

    public function show()
    {
        // query the database for all pets
        $allPets = $GLOBALS['db']->getAllPets();

        // save all pets to fat free hive
        $this->_f3->set('queryAllPets', $allPets);

        // render page that displays all pets from query
        $view = new Template();
        echo $view->render('views/show.html');
    }
}
