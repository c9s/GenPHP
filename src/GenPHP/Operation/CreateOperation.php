<?php
namespace GenPHP\Operation;
use GenPHP\Operation\Helper;

class CreateOperation extends Operation
{

    function run($file,$content)
    {
        Helper::mkdirForFile( $file );
        file_put_contents( $file , $content );
    }

}

