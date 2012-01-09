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
    private $resourceDir;

    protected $options;
    protected $logger;
    protected $mixins = array();


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

    /**
     * set resource directory
     *
     * @param string $dir 
     */
    public function setResourceDir($dir)
    {
        $this->resourceDir = $dir;
    }

    /**
     * get Flavor Directory from Generator class
     */
    public function getResourceDir()
    {
        if( $this->resourceDir )
            return $this->resourceDir;
        $refl = new ReflectionObject($this);
        $flavor = new FlavorDirectory( dirname($refl->getFilename()) );
        return $flavor->getResourceDir();
    }


    /*
     * return resource file path
     */
    public function getResourceFile( $path )
    {
        $file = $this->getResourceDir() . DIRECTORY_SEPARATOR . $path;
        if( file_exists($file) )
            return new SplFileInfo( $file );
        throw new Exception( "$file does not exist." );
    }


    /**
     * return resource file content 
     */
    public function getResourceContent($path)
    {
        return file_get_contents( $this->getResourceFile( $path ) );
    }

}

