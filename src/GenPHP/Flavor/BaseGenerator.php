<?php 
namespace GenPHP\Flavor;

class Generator 
{
    public $options;
    public $logger;

    function setOptionResult($result) 
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

    public function options($opts)  
    {
        // init option specs
    
    }

    public function generate()
    {
        // do generation



    }
}

