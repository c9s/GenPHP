<?php
namespace GenPHP\Operation;
use Exception;

class Helper 
{
    static function mktree($path) {
        if( ! file_exists( $path ) )
            mkdir( $path , 0755 , true );
    }

    static function mkdir_for_file($path) {
        $dir = dirname($path);
        self::mktree( $dir );
    }

    static function put($path,$content) {
        if( file_exists($path) ) {
            throw new Exception( "$path is already there" );
        }

        self::mkdir_for_file( $path );
        file_put_contents( $path , $content );
    }

    static function copy($from,$to) {
        if( file_exists($to) ) {
            throw new Exception( "$to is already there" );
        }

        Helper::mkdir_for_file($to);
        copy($from,$to);
    }

    static function short_path($path) {
        $curpath = getcwd();
        return substr($path,strlen($curpath));
    }

}
