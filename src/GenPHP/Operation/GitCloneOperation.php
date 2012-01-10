<?php 
namespace GenPHP\Operation;
use GenPHP\Operation\Helper;

class GitCloneOperation extends Operation
{
    function run( $repoUri , $target )
    {
        $this->logAction('git:clone',$repoUri);
        if( file_exists($target) ) {
            Helper::system('git','--git-dir',$target . DIRECTORY_SEPARATOR . '.git','remote','update','--prune');
            Helper::system('git','--git-dir',$target . DIRECTORY_SEPARATOR . '.git','pull');
        }
        else {
            Helper::system('git','clone',$repoUri,$target);
        }
    }
}

