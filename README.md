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

To generate a generic php class with PHPUnit 

    $ genphp.phar new class Foo\Bar

        create src
        create src/Foo/Bar.php
        create tests
        create tests/Foo/BarTest.php

To list schemas

    $ genphp list

Reference
---------
* newgem: http://newgem.rubyforge.org/
* Rails: http://guides.rubyonrails.org/command\_line.html
