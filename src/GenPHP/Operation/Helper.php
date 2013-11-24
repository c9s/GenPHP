<?php
namespace GenPHP\Operation;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Exception;

class Helper 
{
    static function mktree($path) {
        if( ! file_exists( $path ) ) {
            if( false === mkdir( $path , 0755 , true ) )
                die("Failed to create path $path");
        }
    }

    static function prevent_overwrite($path) 
    {
        if( file_exists($path) ) {
            throw new Exception( "$path is already there" );
        }
    }

    static function mkdir_for_file($path) {
        $dir = dirname($path);
        self::mktree( $dir );
    }

    static function put($path,$content,$force = false) {

        self::mkdir_for_file( $path );
        file_put_contents( $path , $content );
    }

    static function copy($from,$to,$force = false) {
        Helper::mkdir_for_file($to);
        copy($from,$to);
    }

    static function copy_dir($from,$to,$cb = null)
    {
        $from = realpath($from) ?: $from;
        $to   = realpath($to) ?: $to;

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($from),
            RecursiveIteratorIterator::SELF_FIRST);

        foreach ($iterator as $path) {
            $target = $to . DIRECTORY_SEPARATOR . $iterator->getSubPathname();
            if ($path->isDir()) {
                self::mktree( $target );
                if ( $cb ) {
                    $cb($target);
                }
            } else {
                self::copy( $path , $target );
                if ( $cb ) {
                    $cb($target);
                }
            }
        }
    }

    static function short_path($path) {
        $rpath = realpath($path) ?: $path;
        $curpath = getcwd();

        if( 0 === strpos( $rpath,$curpath ) )
            return substr($rpath,strlen($curpath) + 1);
        return $path;
    }

    /**
     * a system function wrapper, with escapeshellarg
     */
    static function system()
    {
        $args = func_get_args();
        $args = array_map( 'escapeshellarg' , $args );
        system(join( ' ' , $args ));
    }

}
