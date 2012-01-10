<?php
namespace project;
use GenPHP\Flavor\BaseGenerator;

class Generator extends BaseGenerator 
{

    function brief()
    {
        return 'generate generic PHP project';
    }

    function generate($name) 
    {
        $className = str_replace( '_' , '\\', $name );
        $namespace = strstr( '\\' , $className );

        $classFilePath = 'src' . DIRECTORY_SEPARATOR . str_replace( '_' , DIRECTORY_SEPARATOR, $name ) . '.php';
        $dirname = dirname( $classFilePath );

        $this->createDir( $dirname );
        $this->copyDir( 'tests' , 'tests' );
        $this->copy( 'phpunit.xml' , 'phpunit.xml' );
        $this->render( 'package.ini' , 'package.ini' , array(
            'name' => $name,
            'className' => $className,
            'classFilePath' => $classFilePath,
            'namespace' => $namespace,
        ) );

        $this->render( 'class.php.twig', $classFilePath ,array( 
            'name' => $name,
            'className' => $className,
            'classFilePath' => $classFilePath,
            'namespace' => $namespace,
        ));
    }
}
