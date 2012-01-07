<?php

namespace GenPHP;

class Path
{

    static function get_current_flavor_path()
    {
        foreach( self::get_flavor_paths() as $path ) {
            if( file_exists($path) )
                return $path;
        }
    }

    static function get_flavor_paths()
    {
        return array( 
            'flavors',
            '.flavors',
            getenv('HOME') . DIRECTORY_SEPARATOR . '.genphp' . DIRECTORY_SEPARATOR . 'flavors'
        );
    }
}

