GenPHP
======
GenPHP is a PHP project generator.

To generate a generic php project structure, GenPHP provides a built-in template for this:

    $ genphp new project Foo

        create lib
        create lib/Foo.php
        create lib/Foo
        create build.xml
        dependency phpunit
            create phpunit.xml.dist
            create tests

To generate a generic php class with PHPUnit 

    $ genphp new class Foo\Bar

        create lib
        create lib/Foo/Bar.php
        create tests
        create tests/Foo/BarTest.php



