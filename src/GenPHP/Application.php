<?php 
namespace GenPHP;
use CLIFramework\Application as CLIApp;
class Application extends CLIApp
{

    function init()
    {
        $this->registerCommand('new');
        parent::init();
    }

    function options($opts)
    {
        parent::options( $opts );
    }

}
