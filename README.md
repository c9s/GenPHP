GenPHP
======
GenPHP is a powerful, flexible PHP (project/code/library/unit test) generator, which helps you to
avoid do repeating jobs.



To generate a generic PHP project structure, GenPHP provides a built-in template for this:

    $ genphp.phar new project Foo

        create
        create      src
        create      src/Foo.php
        create      src/Foo
        dependency ant
        create      build.xml
        dependency phpunit
        create      phpunit.xml.dist
        create      tests

To list schemas

    $ genphp list

Operations
----------
By using built-in operations, you can create your code generator very easily,
for example, the built-in flavor code generator from GenPHP:

```php
    <?php 
    namespace flavor;
    use GenPHP\Flavor\BaseGenerator;
    use GenPHP\Path;

    class Generator extends BaseGenerator
    {
        public function brief() { 
            return "Default Flavor";
        }

        public function generate($name)
        {
            $paths = Path::get_flavor_paths();
            foreach( $paths as $path ) {
                if( file_exists($path) ) {
                    $base = $path . DIRECTORY_SEPARATOR . $name;
                    $this->createDir( $base . DIRECTORY_SEPARATOR . "Resources");
                    $this->render( 'Generator.php.twig',  
                        $base . DIRECTORY_SEPARATOR . 'Generator.php', 
                        array( 'name' => $name ) );
                }
            }
            
        }
    }
```

Operation name magic:

```php
<?php
$this->copyDir('from/path','to/path');  // executes CopyDirOperation
$this->touch('path/to/touch');          // executes TouchOperation
$this->create('path/to/file', 'file content' );          // executes TouchOperation
```

    // executes RenderOperation
    $this->render('templateName.php.twig','path/to/file', array(
        'className' => $className
    ));

    $this->writeJson('file.json', array( ... ) );  // executes WriteJsonOperation

GenPHP supports many operations:

- CopyDirOperation
- CopyOperation
- CreateDirOperation
- CreateOperation
- RenderOperation
- TouchOperation
- WriteJsonOperation
- WriteYamlOperation


Reference
---------
* newgem: http://newgem.rubyforge.org/
* Rails: http://guides.rubyonrails.org/command\_line.html
