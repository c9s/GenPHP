<?php
namespace GenPHP;
use ArrayAccess;

if( ! defined('DS') ) {
    define('DS', DIRECTORY_SEPARATOR);
}

class Config
    implements ArrayAccess
{


    public $home;

    /**
     * author.name
     * author.email
     * author.copyright
     */
    public $config = array( 
        'author' => array( 
            'name' => 'Unknown',
            'email' => '<unknown@email>',
            'copyright' => '<copyright string>',
        )
    );

    function __construct()
    {
        $this->home = $this->getHomeDir();

        if( ! file_exists($this->home) ) 
            mkdir( $this->home, 0755, true ); // recursive mkdir

        $file = null;
        if( $file = $this->getConfigFile() ) {
            if( file_exists( $file ) )  {
                $this->config = array_merge( $this->config , $this->_parseConfigFile( $file ) );
            }
        }
    }

    function getHomeDir()
    {
        return getenv('HOME') . DS . '.genphp';
    }

    function getConfigFile()
    {
        return $this->home . DS . 'config';
    }

    function _parseConfigFile($configFile)
    {
        return parse_ini_file( $configFile, true );
    }


    
    public function offsetSet($n,$v)
    {
        $this->config[ $n ] = $v;
    }

    public function offsetExists($n)
    {
        return isset($this->config[$n]);
    }

    public function offsetGet($n)
    {
        if( isset($this->config[$n]) )
            return $this->config[ $n ];
    }

    public function offsetUnset($n)
    {
        unset($this->config[$n]);
    }


    public function __get($n)
    {
        if( isset($this->config[$n]) )
            return $this->config[ $n ];
    }




}







