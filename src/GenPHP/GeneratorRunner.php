<?php
namespace GenPHP;
use GetOptionKit\GetOptionKit;
use GetOptionKit\OptionParser;
use GetOptionKit\OptionResult;
use GetOptionKit\OptionSpecCollection;
use GenPHP\Flavor;
use ReflectionObject;

class GeneratorRunner
{
    public $logger;

    public function run($generator,$args = array() ) {

        $deps = $generator->getDependencies();
        foreach( $deps as $depGenerator ) {
            $depGenerator->logAction( "dependency", get_class($depGenerator) , 1 );
            $subargs = $depGenerator->getOption()->getArguments();
            $this->runGenerator( $depGenerator , $subargs );
        }

        $specs = new OptionSpecCollection;
        $generator->options( $specs );
        $parser = new OptionParser( $specs );
        $result = $parser->parse( $args );

        /* pass rest arguments for generation */
        $generator->setOption( $result );

        $this->runGenerator( $generator , $result->getArguments() );
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

    public function runGenerator($generator,$args = array()) 
    {
        $this->checkGeneratorParameters($generator,$args);
        return call_user_func_array( array($generator,'generate'),$args);
    }

}


