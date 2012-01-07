<?php
namespace GenPHP\Operation;

class Helper 
{
    static function mktree($path) {
        if( ! file_exists( $path ) )
            mkdir( $path , 0755 , true );
    }

    static function mkdirForFile($path) {
        $dir = dirname($path);
        self::mktree( $dir );
    }

    static function putFile($path,$content) {
        self::mkdirForFile( $path );
        file_put_contents( $path , $content );
    }

}
