<?php 
namespace extension;
use GenPHP\Flavor\BaseGenerator;
use GenPHP\Flavor\FlavorDirectory;
use GenPHP\Path;
use Exception;

class Generator extends BaseGenerator
{

    public function brief() 
    {
        return "extension generator";
    }


    /**
     * generate new flavor 
     *
     * @param string $name flavor name, lower case, alphabets
     * @param string $path your code base path
     */
    public function generate($name)
    {
        if( preg_match('/\W/', $name ) ) {
            throw new Exception( "$name is not a valid flavor name" );
        }

        $name = strtolower($name);
        $args = array(
            'extname' => $name,
            'extname_uc' => strtoupper($name),
        );
        $this->render( 'config.m4',
            'config.m4', $args );

        $this->render( 'php_extname.h' , "php_$name.h" , $args );
        $this->render( 'php_extname.c' , "php_$name.c" , $args );
        $this->render( 'test.php' , 'test.php' , $args );
        $this->render( 'test-extension.sh' , 'test-extension.sh' , $args );
    }
}
