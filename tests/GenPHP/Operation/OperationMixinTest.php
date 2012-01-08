<?php 
namespace GenPHP\Operation;
use PHPUnit_Framework_TestCase;
use Exception;

class OperationMixinTest extends PHPUnit_Framework_TestCase
{
    function testFunc()
    {
        // XXX: use testing flavors to test
        return;

        $mixin = new OperationMixin($this);
        ok( $mixin );
        if( ! file_exists('/var/tmp') )
            mkdir('/var/tmp',0755,true);

        touch('/var/tmp/copy_1');
        $mixin->copy('/var/tmp/copy_1','/var/tmp/copy_2');
        ok( file_exists('/var/tmp/copy_2') );
        unlink( '/var/tmp/copy_1' );
        unlink( '/var/tmp/copy_2' );
        unlink( '/var/tmp/copy_1' );
    }
}

