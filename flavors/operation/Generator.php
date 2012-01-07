<?php
namespace operation;
use GenPHP\Flavor\BaseGenerator;

class Generator extends BaseGenerator 
{

    function brief()
    {
        return 'generate genphp operation class';
    }

    function generate($name) 
    {
        /* 
            do generate here:

            create dir
                $this->createDir( 'path/to/dir' );

            render code
                $this->render( 'templatePath.php.twig', 'path/to/file' , array( 'name' => $name )  );

            copy directory
                $this->copyDir( 'path/from' , 'path/to' );

            create file
                $this->create( 'path/to/file' , 'content' );

            touch file
                $this->touch( 'path/to/touch' );
         */
        $className = ucfirst($name) . 'Operation';
        $this->render( 'Operation.php.twig' , "src/GenPHP/Operation/$className.php" , array( 
            'className' => $className,
        ));
    }

}

