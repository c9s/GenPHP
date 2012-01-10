<?php 
namespace GenPHP\Command;
use CLIFramework\Command;
use GetOptionKit\GetOptionKit;
use GetOptionKit\OptionParser;
use GetOptionKit\OptionResult;
use GetOptionKit\OptionSpecCollection;
use GenPHP\Flavor;
use Exception;
use ReflectionObject;

class NewCommand extends Command
{

    function brief()
    {
        return 'generate from flavor';
    }


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
        $deps = $generator->dependency();

        if( count($deps) ) {
            $logger->info("Dependencies: " . join(' ',array_keys($deps)) );
        }

        foreach( $deps as $dep => $options ) {
            /* swap for short dependency name */
            if( is_integer($dep) ) {
                $dep = $options;
                $options = array();
            }
            $depFlavor = $loader->load( $dep );
            if( ! $depFlavor->exists() )
                throw new Exception( "Dependency flavor $dep not found." );
            $depGenerator = $depFlavor->getGenerator();
            $depGenerator->setLogger( $logger );
            $depGenerator->logAction( "dependency", $dep , 1 );
            $this->runDepGenerator( $depGenerator , $options );
        }

        /* use GetOptionKit to parse options from $args */
        $args = func_get_args();
        array_shift($args);
        $parser = new OptionParser( $specs );
        $result = $parser->parse( $args );

        /* pass rest arguments for generation */
        $generator->setOptionResult( $result );

        $logger->info("Running main generator...");
        $this->runGenerator( $generator , $result->getArguments() );
        $logger->info("Done");
    }

    public function checkGeneratorParameters($generator,$args)
    {
        $gClass = get_class( $generator );
        $refl = new ReflectionObject($generator);
        $reflMethod = $refl->getMethod('generate');
        $requiredNumber = $reflMethod->getNumberOfRequiredParameters();
        if( count($args) < $requiredNumber ) {
            $this->getLogger()->error( "Generator $gClass requires $requiredNumber arguments." );
            $params = $reflMethod->getParameters();
            foreach( $params as $param ) {
                $this->getLogger()->error( 
                    $param->getPosition() . ' => $' . $param->getName() , 1 );
            }
            throw new Exception;
        }
    }

    public function runDepGenerator($depGenerator,$options)
    {
        $depSpecs   = new OptionSpecCollection;
        $depGenerator->options( $depSpecs );

        $depOptionResult = OptionResult::create( 
            $depSpecs, 
            @$options['options'] ?: array(),
            @$options['arguments'] ?: array()
        );
        $depGenerator->setOptionResult( $depOptionResult );
        $this->runGenerator( $depGenerator , $depOptionResult->getArguments() );
    }

    public function runGenerator($generator,$args = array()) 
    {
        $this->checkGeneratorParameters($generator,$args);
        return call_user_func_array( array($generator,'generate'),$args);
    }

}
