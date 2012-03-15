<?php
namespace doxygen;
use GenPHP\Flavor\BaseGenerator;

class Generator extends BaseGenerator 
{

    function brief()
    {
        return 'doxygen config file generator';
    }

    function generate() 
    {
        $this->render( 'Doxyfile', 'Doxyfile', array(
            // 'output_dirs' => 'src',
        ));
    }

}

