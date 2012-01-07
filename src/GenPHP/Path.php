<?php

namespace GenPHP;

class Path
{
    static function get_flavor_paths()
    {
        return array( 
            'flavors',
            '.flavors',
            getenv('HOME') . DIRECTORY_SEPARATOR . '.genphp' . DIRECTORY_SEPARATOR . 'flavors'
        );
    }
}

