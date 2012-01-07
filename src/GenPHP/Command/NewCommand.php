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
        $logger = $this->getLogger();

        $flavorName = array_shift($args);
        if( ! $flavorName )
            die('flavor name is required.');

        $specs = new OptionSpecCollection;

        /* load flavor generator */
        $logger->info("Loading $flavorName...");
        $loader = new Flavor\FlavorLoader;
        $generator = $loader->load( $flavorName );

        $logger->info("Inializing option specs...");
        $generator->options( $specs );

        /* use GetOptionKit to parse options from $args */
        $parser = new OptionParser( $specs );
        $result = $parser->parse( $args );

        /* pass rest arguments for generation */
        $generator->setOptionResult( $result );
        call_user_func( array($generator,'generate') , $result->getArguments() );

        $logger->info("Done");
    }
}
