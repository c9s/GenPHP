<?php
namespace licenses;
use GenPHP\Flavor\BaseGenerator;

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
            ));
        }

        $licenseFile = 'LICENSE.' . $licenseType;
        $this->render( $licenseFile , 'LICENSE.txt' , array( ));

        /* 
            do generate here:

            create dir
                $this->createDir( 'path/to/dir' );

            render code
                $this->render( 'templatePath.php.twig', 'path/to/file' , array( 'name' => $name )  );

            copy directory
                $this->copyDir( 'path/from' , 'path/to' );

            create file
                $this->create( 'path/to/file' , 'content' );

            touch file
                $this->touch( 'path/to/touch' );
         */
    }

}

