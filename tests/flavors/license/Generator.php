<?php
namespace license;
use GenPHP\Flavor\BaseGenerator;
use GenPHP\Config;

class Generator extends BaseGenerator 
{

    function brief() { return 'license flavor';  }

    function generate($licenseType = null) 
    {
        if( null == $licenseType ) {
            $chooser = new \CLIFramework\Chooser;
            $licenseType = $chooser->choose("Please select license type",array( 
                'MIT License' => 'MIT',
                'PHP License' => 'PHP',
                'Zend License' => 'ZEND',
                'GPL2 License' => 'GPL2',
                'BSD License' => 'BSD',
            ));
        }

        $licenseFile = 'LICENSE.' . $licenseType;

        $config = new Config;
        $this->render( $licenseFile , 'LICENSE' , array( 'config' => $config ) );
    }

}

