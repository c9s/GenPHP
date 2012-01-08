<?php
namespace GenPHP\Operation;
use GenPHP\Operation\Helper;
use Twig_Loader_Filesystem;
use Twig_Environment;

class RenderOperation extends Operation
{

    /**
     * $this->render('template.php.twig','target.php', array( 
     *    ...
     * ));
     */
    function run($templateFile,$target,$args = array() )
    {
        $rsDir = $this->getResourceDir();
        $loader = new Twig_Loader_Filesystem(array($rsDir));
        $twig = new Twig_Environment($loader, array(  ));

        $template = $twig->loadTemplate($templateFile);
        $output = $template->render($args);

        $this->logAction('render',$target);
        Helper::put( $target, $output );
    }
}
