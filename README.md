GenPHP
======
GenPHP is a powerful, flexible PHP code/project generator,
which helps you avoid repeating jobs.

GenPHP can generate anything you defined in the flavor, 
In the generator class, you can use the simple generator API to generate your code.

By using GenPHP, you can also seperate your global generator (`~/.genphp/flavors`), project-scope generator (`./flavors`).

GenPHP is using Twig template engine from Symfony.


[![Build Status](https://secure.travis-ci.org/c9s/GenPHP.png)](http://travis-ci.org/c9s/GenPHP)

![](https://github.com/c9s/GenPHP/raw/master/screenshots/screenshot01.png)

Requirements
------------
- PHP5.3

Installation
------------
Copy this line to install genphp:

    $ curl https://raw.github.com/c9s/GenPHP/master/scripts/install.sh | bash

Install built-in flavors
------------------------

    $ git clone https://github.com/c9s/GenPHP-Flavors ~/.genphp/flavors

## Usage

After installation, you can run `list` command to list your flavors, 
You can put your flavor (generator) in global flavor path (`~/.genphp/flavors`) or 
your current project flavor path (`./flavors` or `./.flavors`), for example:

    ~GenPHP $ genphp list

    Available flavors:
        command     flavors
        flavor      flavors
        operation   flavors
        phpunit     flavors
        project     flavors
        flavor      /Users/c9s/.genphp/flavors
        phpunit     /Users/c9s/.genphp/flavors



### Creating New Flavors

The concept of GenPHP is pretty simple, when you run `genphp new`, it first initialize a flavor loader,
then use the flavor loader to look up matched flavor from several locations.

The loaded flavor instance initializes a generator (which can be GenericGenerator, or BaseGenerator) to generate the stuff
from the flavor resource directory to the destination directory. your
generator class works between the flavor resource directory and the destination
directory.


#### Creating Flavor

To create your flavor from your codebase in your project, type:

    $ cd your_project
    $ mkdir flavors
    $ genphp new flavor foo ~/path/to/codebase

    Loading flavor...
    Inializing option specs...
    Running generator...
        create        flavors/foo/Resource
        create        flavors/foo/Resource/file1
        create        flavors/foo/Resource/file2
        create        flavors/foo/Resource/file3
    Done

You can see those created files files here, it's using GenericGenerator to copy
`flavors/foo/Resource` to current directory.

Now you can put your own files (used by generator) into the `Resource` directory.


#### Customizing Your Flavor and Generator

For more complex usage, to create your own generator, just run:

    $ genphp new flavor foo

    Loading flavor...
    Inializing option specs...
    Running generator...
        create        flavors/foo/Resource
        render        flavors/foo/Generator.php
    Done

Create new flavor without codebase path, then open the `Generator.php` file, write your
generator actions in the `generate` function.

```php
class Generator {

    public function brief() { return 'your generator brief'; }

    public function generate($argument1,$argument2) 
    {
        // do your operations here
        $this->copyDir('etc','etc');  
    }
}
```

Put your favorite files into `flavors/foo/Resource`, then you can write operation code in PHP.

#### Testing Your Flavor

Once you have done, You can run `new` command to generate your flavor:

    $ genphp new foo argument1 argument2

And your code is generated.

If you want your flavor be global (system-wide), you can run install command:

    $ genphp install flavors/foo

This installs flavor to your global flavor path.


### Using Operation

GenPHP provides a lot of useful operations for you to write generation tasks very easily.

#### CopyOperation

To copy directory recursively from flavors/foo/Resource/from/path to to/path

```php
$this->copyDir('from/path','to/path');  
```

#### TouchOperation

To touch a file

```php
$this->touch('path/to/touch');          
```

#### CreateOperation

To create a new file with content

```php
$this->create('path/to/file', 'file content' );         
```

#### CopyOperation

To copy a file, copy path/file1 from Resource dir to file2

```php
$this->copy( 'path/file1' , 'file2' );
```

#### CreateDirOperation

To create a directory:

```php
$this->createDir( 'path/to/directory' );
```

#### RenderOperation

To load templateName.php.twig template from flavors/foo/Resource 
and render the code template with variables to a file:

```php
$this->render('templateName.php.twig','path/to/file', array(
    'className' => $className
));
```

#### WriteJsonOperation

To write a json file

```php
$this->writeJson('file.json', array( 'name' => 'John' ) );  // executes WriteJsonOperation
```

#### WriteYamlOperation

To write a yaml file

```php
$this->writeYaml('file.yaml', array( 'name' => 'John' ) );  // executes WriteJsonOperation
```

#### GitCloneOperation

To clone/pull a git repository:
```php
$this->gitClone( 'git@github.com:.....git' , 'path/to/repo' );
```

#### HgCloneOperation

To clone/pull a hg repository:
```php
$this->hgClone( 'hg uri' , 'path/to/repo' );
```


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

genphp looks for flavor in `./flavors`, `./.flavors`, `~/.genphp/flavors`, you 
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

## Flavor API

```php
$path = $flavor->path( 'license' );

```


## Generator Runner

```php
$loader = new \Flavor\FlavorLoader;
$flavor = $loader->load( $flavorName );
$generator = $flavor->getGenerator();
$generator->setLogger( $this->getLogger() );

$args = func_get_args();
array_shift($args);

$runner = new \GenPHP\GeneratorRunner;
$runner->logger = $logger;
$runner->run($generator,$args);
```


## Generator API

```php
public fucntion generate($argument1,$argument2, ... ) 
{
    $file = $this->flavorLoader->load('license')->path('LICENSE.GPL2');
    $this->copy($file, 'LICENSE' );
    $this->copyDir( );
}
```

### Operations
By using built-in operations, you can create your code generator very easily,
for example, the built-in flavor code generator from GenPHP:

```php
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

## Development

- Fork this probject on GitHub
- Git clone it:

    $ git clone git@github.com:{{ your Id }}/GenPHP.git

- Install onion <http://github.com/c9s/Onion>
- run `onion bundle` to install PEAR dependencies.
- run `scripts/genphp` to test your genphp script.
- run `phpunit` to run the test suites.
- run `scripts/compile.sh` to compile whole library into a executable phar file.

### Create New Opeartion

There is a flavor for creating new opeartion already, just run:

    $ ./scripts/genphp new operation DoSomething

### Create New Flavor

    $ ./scripts/genphp new flavor flavor_name


### IRC

Join us on irc channel: #genphp on irc.freenode.net

## Reference
* newgem: http://newgem.rubyforge.org/
* Rails: http://guides.rubyonrails.org/command\_line.html
