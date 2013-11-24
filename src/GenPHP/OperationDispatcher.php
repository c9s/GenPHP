<?php 
namespace GenPHP;
use Exception;
use GenPHP\Operation\Helper;

/**
 * Deletator for operations 
 */
class OperationDispatcher
{

    /**
     * @var BaseGenerator generator instance
     */
    public $self;

    /**
     * @var array registered operations
     */
    public $registered = array();

    static $namespaces = array(
        '\\GenPHP\\Operation',
    );

    public function __construct($self)
    {
        $this->self = $self;
    }


    /**
     * push user-specified namespace to the lookup namespace array.
     *
     * @param string $ns namespace name
     */
    static function insertNamespace($ns) {
        // insert namespace at first place.
        array_splice(static::$namespaces,0, 0 ,$ns);
    }

    public function unregisterOperation($methodName)
    {
        unset( $this->registered[ $methodName ] );
    }

    public function registerOperation( $methodName, Operation $operation)
    {
        $operation->setGenerator( $this->self );
        $this->registered[ $methodName ] = $operation;
    }

    /**
     * Here does the magic to convert method name into operation class.
     */
    public function __call($method,$args)
    {
        /* check registered operations */
        if( isset( $this->registered[ $method ] ) ) {
            $operation = $this->registered[ $method ];
            return call_user_func_array( array($operation,'run') , $args );
        }

        // look up for built-in operations
        foreach ( static::$namespaces as $ns ) {
            $class = $ns . '\\' . ucfirst($method) . 'Operation';
            if ( ! class_exists($class) ) {
                spl_autoload_call( $class );
            }
            if ( class_exists($class) ) { 
                $operation = new $class( $this->self );
                return call_user_func_array( array($operation,'run') , $args );
            } else {
                throw new Exception("Operation class not found: $class");
            }
        }
    }

}

