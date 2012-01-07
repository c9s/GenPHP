<?php 

namespace GenPHP\Operation;

class CopyOperation extends Operation
{


    function run($generator,$from,$to)
    {
        copy($from,$to);
    }

}

