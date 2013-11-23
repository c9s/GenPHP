<?php
namespace GenPHP\Operation;
use GenPHP\Operation\Helper;

class CopyFilesOperation extends Operation
{

    public function run($files)
    {
        foreach( $files as $file ) {
            if ( file_exists($file) ) {
                $this->logger->notice("skip $file",1);
                continue;
            }
            $this->generator->copy( $file , $file);
        }
    }

}




