<?php 
namespace GenPHP\Command;
use CLIFramework\Command;
use GetOptionKit\GetOptionKit;
use GetOptionKit\OptionParser;
use GetOptionKit\OptionSpecCollection;
use GenPHP\Flavor;

class NewCommand extends Command
{
    function execute($args)
    {
        $flavorName = array_shift($args);
        if( ! $flavorName )
            die('flavor name is required.');


        $specs = new OptionSpecCollection;

        /* load flavor generator */
        $loader = new Flavor\FlavorLoader;
        $flavor = $loader->load( $flavorName );

        $flavor->options( $specs );

        /* use GetOptionKit to parse options from $args */
        $parser = new OptionParser( $specs );
        $result = $parser->parse( $args );

        /* pass rest arguments for generation */
        $flavor->setOptionResult( $result );
        call_user_func( array($flavor,'generate') , $result->getArguments() );
    }
}
