<?php
namespace GenPHP\Flavor;

class GenericGenerator extends BaseGenerator
{
    public function __construct(string $resourceDir)
    {
        $this->setResourceDir( $resourceDir );
    }

    public function generate()
    {
        // just recursively copy directory into current working directory.
        $rs = $this->getResourceDir();
        $this->copyDir( $rs , '.' );
    }
} 
