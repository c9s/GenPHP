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

        $deps = $generator->dependency();
        foreach( $deps as $dep => $options ) {
            /* swap for short dependency name */
            if( is_integer($dep) )
                $dep = $options;

            $info->info2( "dependency $dep", 1 );
            $depGenerator = $loader->load( $dep );
            $depSpecs   = new OptionSpecCollection;
            $depOptions = $depGenerator->options( $depSpecs );
            $depOptionResult = OptionResult::create( 
                        $depOptions, @$options['options'] , @$options['arguments'] );
            $depGenerator->setOptionResult( $depOptionResult );
            $this->runGenerator( $depGenerator , $depOptionResult->getArguments() );
        }

        $logger->info("Inializing option specs...");
        $generator->options( $specs );

        /* use GetOptionKit to parse options from $args */
        $parser = new OptionParser( $specs );
        $result = $parser->parse( $args );

        /* pass rest arguments for generation */
        $generator->setOptionResult( $result );

        $this->runGenerator( $generator , $result->getArguments() );
        $logger->info("Done");
    }

    public function runGenerator($generator,$args = array()) 
    {
        return call_user_func_array( array($generator,'generate'),$args);
    }


}
