<?php 
namespace GenPHP\Operation;
use GenPHP\Operation\Helper;

class HgCloneOperation extends Operation
{
    function run($repoUri,$target)
    {
        if( file_exists($target) ) {
            $this->logAction('hg:pull',$repoUri);
            Helper::system('hg','-R',$target,'pull','-u');
        }
        else {
            $this->logAction('hg:clone',$repoUri);
            Helper::system('hg','clone',$repoUri,$target);
        }
    }
}

