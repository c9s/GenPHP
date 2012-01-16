<?php
namespace GenPHP\Operation;
use GenPHP\Operation\Helper;
use Twig_Loader_Filesystem;
use Twig_Environment;

class RenderOperation extends Operation
{

    /**
     * render code template to file
     *
     * $this->render('template.php.twig','target.php', array( 
     *    ...
     * ));
     *
     * @param string $templateFile template file path (related from ResourceDir)
     * @param string $target       path to target file.
     */
    function run($templateFile,$target,$args = array() )
    {
        $rsDir = $this->getResourceDir();
        $loader = new Twig_Loader_Filesystem(array($rsDir));
        $twig   = new Twig_Environment($loader, array(  ));

        // XXX: register some built-in template for php doc or code.

        $template = $twig->loadTemplate($templateFile);
        $output = $template->render($args);

        $this->logAction('render',$target);
        Helper::put( $target, $output );
    }
}
