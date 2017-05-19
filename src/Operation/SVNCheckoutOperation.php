<?php 
namespace GenPHP\Operation;
use GenPHP\Operation\Helper;

class SVNCheckoutOperation extends Operation
{
    /**
     * Git clone to target path
     */
    public function run( $repoUri , $target )
    {
        if( file_exists($target) ) {
            $this->logAction('svn:update',$repoUri);
            $pdir = getcwd();
            chdir($target);
            Helper::system('svn', 'update');
            chdir($pdir);
        }
        else {
            $this->logAction('svn:checkout',$repoUri);
            Helper::system('svn','checkout',$repoUri,$target);
        }
    }
}

