<?php
/*
 * This file is part of the GenPHP package.
 *
 * (c) Yo-An Lin <cornelius.howl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */
namespace GenPhp;

/* GenPHP base class for every genphp components.
 *
 */
class GenPhp
{
    /* return resources dir path from an object.
     */
    function getResourcesDir()
    {
        $ref = new ReflectionClass($this);
        $filename = $ref->getFileName();
        return dirname($filename);
    }

    /* Use relative file path to get the absolute path of resource file
     * from an GenPhp object.
     */
    function getResourceFile( $filepath )
    {
        return $this->getResourcesDir() . DIRECTORY_SEPARATOR . $filepath;
    }
}
