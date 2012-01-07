<?php 
namespace GenPHP\Flavor;

abstract class BaseGenerator 
{
    public $options;
    public $logger;

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

