<?php 
namespace GenPHP\Command;
use CLIFramework\Command;
use GetOptionKit\GetOptionKit;
use GetOptionKit\OptionParser;
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
        $generator->setLogger( $this->getLogger() );

        $deps = $generator->dependency();
        foreach( $deps as $dep => $options ) {
            /* swap for short dependency name */
            if( is_integer($dep) ) {
                $dep = $options;
                $options = array();
            }
            $info->info2( "dependency $dep", 1 );
            $depGenerator = $loader->load( $name );
            $this->runDepGenerator( $depGenerator , $options );
        }

        /* use GetOptionKit to parse options from $args */
        $parser = new OptionParser( $specs );
        $result = $parser->parse( $args );

        /* pass rest arguments for generation */
        $generator->setOptionResult( $result );

        $logger->info("Running generator...");
        $this->runGenerator( $generator , $result->getArguments() );
        $logger->info("Done");
    }

    public function checkGeneratorParameters($generator,$args)
    {
        $refl = new ReflectionObject($generator);
        $reflMethod = $refl->getMethod('generate');
        $requiredNumber = $reflMethod->getNumberOfRequiredParameters();
        if( count($args) < $requiredNumber ) {
            $this->getLogger()->error( "Generator requires $requiredNumber arguments." );
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
        $depOptions = $depGenerator->options( $depSpecs );
        $depOptionResult = OptionResult::create( 
                    $depOptions, @$options['options'] , @$options['arguments'] );
        $depGenerator->setOptionResult( $depOptionResult );
        $depGenerator->setLogger( $this->getLogger() );
        $this->runGenerator( $depGenerator , $depOptionResult->getArguments() );
    }

    public function runGenerator($generator,$args = array()) 
    {
        $this->checkGeneratorParameters($generator,$args);
        return call_user_func_array( array($generator,'generate'),$args);
    }

}
