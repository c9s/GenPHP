<?php
namespace GenPHP\Operation;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use GenPHP\Operation\Helper;

class CopyDirOperation extends Operation
{

    /**
     * recursive directory copy operation
     *
     * @param string $from
     * @param string $to
     */
    public function run($from,$to) 
    {
        $from = realpath($from);
        $to   = realpath($to);
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($from),
            RecursiveIteratorIterator::SELF_FIRST);

        foreach ($iterator as $path) {
            $target = $to . substr($path,strlen($from));

            if ($path->isDir()) {
                $this->logAction( 'directory' , Helper::short_path($target) );
                Helper::mktree( $target );
            } else {
                $this->logAction( 'create' , Helper::short_path($target) );
                copy( $path , $target );
            }
        }
    }

}

