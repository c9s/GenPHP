<?php
namespace GenPHP;

if( ! defined('DS') ) {
    define('DS', DIRECTORY_SEPARATOR);
}

class Config
{
    public $home;
    public $config;

    function __construct()
    {
        $this->home = $this->getHomeDir();

        if( ! file_exists($this->home) ) 
            mkdir( $this->home, 0755, true ); // recursive mkdir

        if( $file = $this->getConfigFile() ) 
            $this->config = $this->_parseConfigFile( $file );
    }

    function getHomeDir()
    {
        return getenv('HOME') . DS . '.genphp';
    }

    function getConfigFile()
    {
        $file = $this->home . DS . 'config';
        if( file_exists( $file ) )
            return $file;
    }

    function _parseConfigFile($configFile)
    {
        return parse_ini_file( $configFile, true );
    }

}







