GenPHP
======
GenPHP is a PHP (project/code/library/unit test) generator, which helps you to
avoid do repeating jobs.

To generate a generic PHP project structure, GenPHP provides a built-in template for this:

    $ genphp new project Foo

        create
        create  lib
        create  lib/Foo.php
        create  lib/Foo
        create  build.xml
        dependency phpunit
        create      phpunit.xml.dist
        create      tests

To generate a generic php class with PHPUnit 

    $ genphp new class Foo\Bar

        create lib
        create lib/Foo/Bar.php
        create tests
        create tests/Foo/BarTest.php

To list schemas

    $ genphp list


Customizable
------------
You can easily define your template with GenPHP baseclass.

    <?php
    use GenPHP\GenPHP;
    class Foo extends GenPHP 
    {
        // ...
    }

