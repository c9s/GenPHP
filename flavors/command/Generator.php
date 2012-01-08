<?php
namespace command;
use GenPHP\Flavor\BaseGenerator;

class Generator extends BaseGenerator 
{

    function brief()
    {
        return 'generate new genphp command';
    }

    function generate($name) 
    {
        $className = ucfirst($name) . 'Command';
        $this->render( 'Command.php.twig', "src/GenPHP/Command/$className.php" , array( 
            'className' => $className,
        ));
    }

}

