<?php
namespace GenPHP\Operation;
use GenPHP\Operation\Helper;

class CreateDirOperation extends Operation
{
    /**
     * create directories operation
     *
     * @param array|string directory path
     */
    function run($dirs)
    {
        foreach( (array) $dirs as $dir ) {
            $this->logAction('create', $dir);
            Helper::mktree($dir);
        }
    }
}
