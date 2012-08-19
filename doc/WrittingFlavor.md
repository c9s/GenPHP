Writting Flavor
================

The generic structure of a flavor:

    flavors/foo_flavor                 # your flavor directory
    flavors/foo_flavor/Generator.php   # your generator logics
    flavors/foo_flavor/Resource/       # your resource files (templates, assets or anything)
    flavors/foo_flavor/Resource/some_files/bar1
    flavors/foo_flavor/Resource/some_files/bar2

A basic generator class, you can write the generator logic in the
generate method, the arguments are passed from command-line.

    <?php
    namespace foo_flavor;
    use GenPHP\Flavor\BaseGenerator;

    class Generator extends BaseGenerator
    {
        public function brief() { return "foo generator"; }
        public function generate($arg1,$arg2,$arg3)
        {
            // .. logics here
        }
    }

Then you just write your operations in the generate method to generate files:

    public function generate($arg1,$arg2,$arg3) 
    {
        $this->copyDir( 'your_path' , 'some_files' );
        $this->render( 'template_file', 'target_file', array( 'name' => $name ) );
    }

To get flavor object from generator, simple get from `flavor` class member.

    public function generate() 
    {
        $flavorName = $this->flavor->getName()
        $resDir     = $this->flavor->getResourceDir();
        $content    = $this->flavor->getResourceContent( 'some_files/bar1' );
    }



