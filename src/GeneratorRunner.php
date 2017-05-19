<?php
namespace GenPHP;
use GetOptionKit\GetOptionKit;
use GetOptionKit\OptionParser;
use GetOptionKit\OptionResult;
use GetOptionKit\OptionCollection;
use GenPHP\Flavor;
use Exception;
use RuntimeException;
use ReflectionObject;

class GeneratorRunner
{
    public $logger;

    public function run($generator, array $args = array())
    {
        $deps = $generator->getDependencies();

        foreach ($deps as $depGenerator) {
            $depGenerator->logAction("dependency", get_class($depGenerator) , 1);
            $subargs = $depGenerator->getOption()->getArguments();
            $this->runGenerator($depGenerator , $subargs);
        }

        $specs = new OptionCollection;
        $generator->options($specs);

        $parser = new OptionParser($specs);

        array_unshift($args, 'genphp'); // option parser doesn't parse the first argument (program name)
        $result = $parser->parse($args);

        /* pass rest arguments for generation */
        $generator->setOption($result);

        $this->runGenerator($generator, $result->getArguments());
    }

    /**
     * Use ReflectionObject to check the generator parameters.
     *
     * @param Generator $generator
     * @param array $args
     */
    public function checkGeneratorParameters($generator,$args)
    {
        $gClass = get_class( $generator );
        $refl = new ReflectionObject($generator);
        $reflMethod = $refl->getMethod('generate');
        $requiredNumber = $reflMethod->getNumberOfRequiredParameters();
        if ( count($args) < $requiredNumber ) {
            $this->getLogger()->error( "Generator $gClass requires $requiredNumber arguments." );
            $params = $reflMethod->getParameters();
            foreach ( $params as $param ) {
                $this->getLogger()->error( 
                    $param->getPosition() . ' => $' . $param->getName() , 1 );
            }
            throw new RuntimeException("Invalid Generator Arguments.");
        }
    }

    public function runGenerator($generator, array $args = array()) 
    {
        $this->checkGeneratorParameters($generator, $args);
        return call_user_func_array([$generator,'generate'],$args);
    }

    public function getLogger()
    {
        return $this->logger;
    }

}


