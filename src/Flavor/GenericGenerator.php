<?php
namespace GenPHP\Flavor;

class GenericGenerator extends BaseGenerator
{
    public function brief() { return 'generic generator'; }

    public function generate()
    {
        // just recursively copy directory into current working directory.
        $rs = $this->getResourceDir();
        $this->copyDir( $rs , '.' );
    }
} 
