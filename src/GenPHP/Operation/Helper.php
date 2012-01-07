<?php
namespace GenPHP\Operation;

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
        self::mkdir_for_file( $path );
        file_put_contents( $path , $content );
    }

    static function copy($from,$to) {
        Helper::mkdir_for_file($to);
        copy($from,$to);
    }

    static function short_path($path) {
        $curpath = getcwd();
        return substr($path,strlen($curpath));
    }

}
