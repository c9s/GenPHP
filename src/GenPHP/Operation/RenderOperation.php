<?php
namespace GenPHP\Operation;

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

        Helper::mkdirForFile( $target );
        file_put_contents( $target , $output );
    }

}
