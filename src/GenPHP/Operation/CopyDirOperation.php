<?php
namespace GenPHP\Operation;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use GenPHP\Operation\Helper;

/**
 * The CopyDirOperation uses (source path, destination path) to copy your dir
 */
class CopyDirOperation extends Operation
{

    /**
     * Recursive directory copy operation
     *
     * @param string $from related path from Resource Dir
     * @param string $to related path of target
     */
    public function run($from,$to) 
    {
        $resDir = $this->getResourceDir();
        $from = realpath($from) ?: $resDir . DIRECTORY_SEPARATOR . $from;
        $to   = realpath($to) ?: $to;

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($from, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST);

        foreach ($iterator as $path) {
            $target = $to . DIRECTORY_SEPARATOR . $iterator->getSubPathname();
            if ( $path->isDir() ) {
                $this->logAction( 'copy' , Helper::short_path($target) );
                futil_mkdir_if_not_exists($target, 0755, true);
            } else {
                if ( file_exists($target) ) {
                    $this->logAction( 'skip' , Helper::short_path($target) );
                } else {
                    $this->logAction( 'copy' , Helper::short_path($target) );
                    Helper::copy( $path , $target );
                }
            }
        }
    }

}

