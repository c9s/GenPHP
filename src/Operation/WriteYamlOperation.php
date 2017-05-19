<?php
namespace GenPHP\Operation;
use GenPHP\Operation\Helper;

/**
 * provide writeYaml method for generating YAML file
 */
class WriteYamlOperation
{

    /**
     * write yaml to file
     *
     * @param string $path
     * @param mixed $data
     */
    function run($path,$data)
    {
        if( extension_loaded( 'yaml' ) ) {
            $this->logAction( 'yaml' , $path );
            Helper::put( $path, yaml_emit($data) );
        } 
        else {
            $this->getLogger()->error( 'yaml extension not found.' );
        }
    }
} 
