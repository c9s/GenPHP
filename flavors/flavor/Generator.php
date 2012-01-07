<?php 
namespace flavor;
use GenPHP\Flavor\BaseGenerator;

class Generator extends BaseGenerator
{
    public function brief() { 
        return "Default Flavor";
    }

    public function generate($name)
    {
        $this->createDir("flavors/$name/resources");
    }
}
