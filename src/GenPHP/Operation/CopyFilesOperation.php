<?php
namespace GenPHP\Operation;
use GenPHP\Operation\Helper;

class CopyFilesOperation extends Operation
{

    public function run($files)
    {
        foreach( $files as $file ) {
            $this->generator->copy( $file , $file);
        }
    }

}




