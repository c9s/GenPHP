GenPHP
======
GenPHP is a powerful, flexible PHP code/project generator,
which helps you to avoid repeating jobs.

GenPHP can generate anything you defined in the flavor, 
In generator class, you can use the simple generator API to generate your code.

By using GenPHP, you can also seperate your global generator (`~/.genphp/flavors`), project-scope generator (`./flavors`).

GenPHP is using Twig template engine from Symfony.

Installation
------------
Copy this line to install genphp:

    $ curl https://raw.github.com/c9s/GenPHP/master/scripts/install.sh | sh

Usage
-----
After installation, you can run `list` command to list your flavors, 
You can put your flavor (generator) in global flavor path (`~/.genphp/flavors`) or 
your current project flavor path (`./flavors` or `./.flavors`).

    $ genphp list


Command Usage
-------------

To generate a generic PHP project structure, GenPHP provides a built-in
template for this:

```bash
$ genphp new project Foo

    create
    create      src
    create      src/Foo.php
    create      src/Foo
    dependency ant
    create      build.xml
    dependency phpunit
    create      phpunit.xml.dist
    create      tests
```

genphp will look for flavor in `./flavors`, `./.flavors`, `~/.genphp/flavors`, you 
can define your generator in those paths.

to generate a new flavor:

```bash
$ genphp new flavor flavorName
```

To generate a new flavor from current existing code base:

```bash
$ genphp new flavor ProjectA ~/path/to/OneProject
```

To list schemas

```bash
$ genphp list
```

please check `./flavors` directory of this repository
for more details.

Flavors
--------


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
                $this->createDir( $base . DIRECTORY_SEPARATOR . "Resource");
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

// executes CopyDirOperation
$this->copyDir('from/path','to/path');  

// executes TouchOperation
$this->touch('path/to/touch');          

// executes TouchOperation
$this->create('path/to/file', 'file content' );         

// executes RenderOperation
$this->render('templateName.php.twig','path/to/file', array(
    'className' => $className
));

// executes WriteJsonOperation
$this->writeJson('file.json', array( ... ) );  // executes WriteJsonOperation
```

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
