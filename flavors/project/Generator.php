<?php
namespace project;
use GenPHP\Flavor\BaseGenerator;

class Generator extends BaseGenerator 
{

    function brief() { return 'generate generic PHP project'; }

    function dependency()
    {
        return array(
            'phpunit' => array( ),
        );
    }

    function generate($name) 
    {
        $className = str_replace( '_' , '\\', $name );
        $namespace = null;
        if( ($p = strrpos( $className , '\\' )) !== false ) {
            $namespace = substr( $className, 0 , $p );
            $className = substr( $className, $p + 1 );
        }

        $classFilePath = 'src' . DIRECTORY_SEPARATOR . str_replace( '_' , DIRECTORY_SEPARATOR, $name ) . '.php';
        $dirname = dirname( $classFilePath );

        $this->createDir( $dirname );
        $this->copyDir( 'tests' , 'tests' );
        $this->copy( 'phpunit.xml' , 'phpunit.xml' );
        $this->render( 'package.ini' , 'package.ini' , array(
            'packageName' => $name,
            'className' => $className,
            'classFilePath' => $classFilePath,
            'namespace' => $namespace,
        ) );

        $this->render( 'class.php.twig', $classFilePath ,array( 
            'packageName' => $name,
            'className' => $className,
            'classFilePath' => $classFilePath,
            'namespace' => $namespace,
        ));
    }
}
