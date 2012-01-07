<?php 
namespace GenPHP;
use CLIFramework\Application as CLIApp;
class Application extends CLIApp
{

    function brief()
    {
        return 'GenPHP - PHP Code Generator.';
    }

    function init()
    {
        $this->registerCommand('new');
        $this->registerCommand('list');
        $this->registerCommand('init');
        parent::init();
    }

    function options($opts)
    {
        parent::options( $opts );
    }

}
