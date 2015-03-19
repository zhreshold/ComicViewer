<?php
/**
 * Created by PhpStorm.
 * User: Zhi
 * Date: 2/18/2015
 * Time: 2:31 PM
 */

include "config.php";
ini_set('default_charset', 'utf-8'); 

function createDir($dir)
{
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
}

if ($file = $_GET['file'])
{
    createDir($RECYCLE_DIR);
    $src = rawurldecode($file);
    $dst = $RECYCLE_DIR."/".basename($src);
    rename($src, $dst);
}

// jump to main page
header('Location: index.php');