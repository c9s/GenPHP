<?php 
namespace GenPHP\Flavor;
use GenPHP\Operation\OperationMixin;
use Exception;
use ReflectionObject;


/**
 * Generator base class
 *
 * in generator, you can do this:
 *
 *
 * function generate() 
 * {
 *      $this->renderTo( 'from_file.php' , 'path/to/file.php' );
 *      $this->copy( 'from_file.php' , 'path/to/file.php' );
 *      $this->rename( 'from_file.php' , 'new_name.php' );
 *      $this->delete( 'old/file.php' );
 *      $this->writeYaml( 'yaml' , array( .... ) );
 *      $this->writeJson( 'json' , array( .... ) );
 *      $this->create( 'file.php' , $content );
 * }
 *
 */
abstract class BaseGenerator 
{
    public $options;
    public $logger;

    public $mixins = array();

    public function __construct()
    {
        $this->mixins[] = new OperationMixin( $this );
    }

    /* subclass must implements this */
    abstract function brief();

    /**
     * return flavor dependencies
     */
    public function dependency()
    {
        return array(
            /**
             * flavor name => array( ... default options ) 
             *
             * 'name' => array( 'options' => array(  .... ), 'arguments' => ... ),
             * 'name',
             */
        );
    }


    /**
     * initialize options
     */
    public function options($opts)  
    {

    }


    public function __call($method,$args)
    {
        /* call mixins */
        foreach( $this->mixins as $mixin ) {
            return call_user_func_array( array($mixin,$method),$args);
#              if( method_exists( $mixin, $method ) ) {
#                  return call_user_func_array( array($mixin,$method),$args);
#              }
        }
    }

    public function setOptionResult($result) 
    {
        $this->options = $result;
    }

    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    public function getLogger()
    {
        return $this->logger;
    }

    public function getOption()
    {
        return $this->options;
    }

    // abstract function generate();


    public function getResourceDir()
    {
        $refl = new ReflectionObject($this);
        return $refl->getFilename() . DIRECTORY_SEPARATOR . 'Resources';
    }

}

