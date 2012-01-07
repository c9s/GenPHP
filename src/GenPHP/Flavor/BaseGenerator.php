<?php 
namespace GenPHP\Flavor;
use GenPHP\Operation\OperationMixin;

abstract class BaseGenerator 
{
    public $options;
    public $logger;

    public $mixins = array();

    public function __construct()
    {
        $this->mixins[] = new OperationMixin( $this );
    }

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
            if( method_exists( array($mixin, $method) ) ) {
                return call_user_func_array( array($mixin,$method),$args);
            }
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

    public function generate()
    {

    }


}

