<?php 
namespace GenPHP\Operation;
use Exception;
use GenPHP\Operation\Helper;

/**
 * Deletator for operations 
 */
class OperationMixin 
{

    /**
     * @var BaseGenerator generator instance
     */
    public $self;

    /**
     * @var array registered operations
     */
    public $registered = array();

    public function __construct($self)
    {
        $this->self = $self;
    }

    public function unregisterOperation($methodName)
    {
        unset( $this->registered[ $methodName ];
    }

    public function registerOperation( $methodName, Operation $operation)
    {
        $operation->setGenerator( $this->self );
        $this->registered[ $methodName ] = $operation;
    }

    public function __call($method,$args)
    {
        /* check registered operations */
        if( isset( $this->registered[ $method ] ) ) {
            $operation = $this->registered[ $method ];
            return call_user_func_array( array($operation,'run') , $args );
        }

        $class = '\\GenPHP\\Operation\\' . ucfirst($method) . 'Operation';
        if( ! class_exists($class) )
            spl_autoload_call( $class );
        if( class_exists($class) ) {
            $operation = new $class( $this->self );
            return call_user_func_array( array($operation,'run') , $args );
        } else {
            throw new Exception("Operation class not found: $class");
        }
    }

}

