<?php
namespace GenPHP\Operation;
use GenPHP\Operation\Helper;

class CreateDirOperation extends Operation
{

    function run($dir)
    {
        $this->getLogger()->info("create $dir",1);
        Helper::mktree($dir);
    }

}
