<?php 
namespace GenPHP\Flavor;
use GenPHP\Operation\OperationMixin;
use Exception;
use ReflectionObject;
use SplFileInfo;


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

    protected $options;
    protected $logger;
    protected $mixins = array();
    protected $flavor;

    public function __construct( $flavor )
    {
        $this->mixins[] = new OperationMixin( $this );
        $this->flavor = $flavor;
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
        // $opts->add('v|verbose','show verbose message');
    }

    /**
     * xxx: refactor this, put this in a proper class.
     */
    public function logAction($action,$path,$indent = 1)
    {
        $logger = $this->getLogger();
        if( ! $logger )
            return;
        $formatter = $logger->getFormatter();
        $msg = sprintf( "%-24s %s" , 
            $formatter->format( $action , 'strong_white' ),
            $formatter->format( $path,   'white' )
        );
        $logger->info( $msg, $indent );
    }

    public function __call($method,$args)
    {
        if( method_exists( $this->flavor,$method) )
            return call_user_func_array( array($this->flavor, $method ), $args );

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

    /**
     * get logger object
     */
    public function getLogger()
    {
        return $this->logger;
    }

    public function getOption()
    {
        return $this->options;
    }

    // abstract function generate();


}

