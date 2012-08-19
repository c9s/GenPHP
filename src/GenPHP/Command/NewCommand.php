<?php 
namespace GenPHP\Command;
use CLIFramework\Command;
use GetOptionKit\GetOptionKit;
use GetOptionKit\OptionParser;
use GetOptionKit\OptionResult;
use GetOptionKit\OptionSpecCollection;
use GenPHP\Flavor;
use GenPHP\GeneratorRunner;
use Exception;
use ReflectionObject;

class NewCommand extends Command
{

    function brief() { return 'generate from flavor'; }

    function execute($flavorName)
    {
        $logger = $this->getLogger();
        $formatter = $logger->getFormatter();
        $specs = new OptionSpecCollection;

        /* load flavor generator */
        $logger->info("Loading flavor $flavorName...");
        $loader = new Flavor\FlavorLoader;
        $flavor = $loader->load( $flavorName );
        $generator = $flavor->getGenerator();

        $logger->info2("Inializing option specs...");
        $generator->options( $specs );
        $generator->setLogger( $this->getLogger() );

        /* use GetOptionKit to parse options from $args */
        $args = func_get_args();
        array_shift($args);

        $runner = new \GenPHP\GeneratorRunner;
        $runner->logger = $logger;
        $runner->run($generator,$args);

        $logger->info("Done");
    }
}
