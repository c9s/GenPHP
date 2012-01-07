<?php
namespace operation;
use GenPHP\Flavor\BaseGenerator;
use Exception;

class Generator extends BaseGenerator 
{

    function brief()
    {
        return 'generate genphp operation class';
    }

    function generate($name) 
    {
        $className = ucfirst($name) . 'Operation';
        $this->render( 'Operation.php.twig' , "src/GenPHP/Operation/$className.php" , array( 
            'className' => $className,
        ));
    }

}

