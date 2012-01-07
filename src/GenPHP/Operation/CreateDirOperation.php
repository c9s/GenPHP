<?php
namespace GenPHP\Operation;
use GenPHP\Operation\Helper;

class CreateDirOperation extends Operation
{

    function run($dir)
    {
        $this->logAction('create', $dir);
        Helper::mktree($dir);
    }

}
