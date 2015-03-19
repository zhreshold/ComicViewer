<?php
/**
 * Created by PhpStorm.
 * User: Zhi
 * Date: 2/17/2015
 * Time: 11:56 AM
 */

header("pragma: no-store,no-cache");
header("cache-control: no-cache, no-store,must-revalidate, max-age=-1");
header("expires: Sat, 26 Jul 1997 05:00:00 GMT");

include "config.php";
include "utils.php";


date_default_timezone_set('America/Chicago');
ini_set('default_charset', 'utf-8'); 

function createDir($dir)
{
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
}

function genCacheName($cacheDir, $comic, $page, $width, $ext)
{
    createDir($cacheDir);
    $hashStr = $comic.$page.$width;
    $hashValue = hash("sha256", $hashStr);
    return $cacheDir."/".$hashValue.".".$ext;
}

// main
$comicName = "";
$page = "";
$setWidth = 0;
$force = 0;

if ($_GET['comic'])
{
    $comicName = rawurldecode(stripslashes($_GET['comic']));
}
else
{
    return;
}

if ($_GET['page'])
{
    $page = rawurldecode(stripslashes($_GET['page']));
}
else
{
    return;
}

if ($_GET['maxwidth'])
{
    $setWidth = rawurldecode(stripslashes($_GET['maxwidth']));
}

if ($_GET['f'])
{
    $force = 1;
}


if ($setWidth <= 0)
{
    // directly pass through image from archive
    passImage($comicName, $page);
    return;
}

// resize image, or load cache if existed
if ((preg_match('/cbz$/i',$comicName))||(preg_match('/zip$/i',$comicName))) {
    //$index = $_GET['index'];
    //$page = $_GET['page'];
    $zip = new ZipArchive();
    if ($zip->open($comicName) === TRUE) {
        $tmpfilename = basename($page);
        $file_extension = strtolower(substr(strrchr($tmpfilename,"."),1));
        $cachepathname = genCacheName($CACHE_DIR, $comicName, $page, $setWidth, $file_extension);
        $headertype = "";

        switch( $file_extension ) {
            case "gif": $headertype="image/gif"; break;
            case "png": $headertype="image/png"; break;
            case "jpeg":
            case "jpg": $headertype="image/jpg"; break;
            default:
        }

        if (file_exists($cachepathname))
        {
            $fp = fopen($cachepathname, "rb");
            header('Content-type:'.$headertype);
            fpassthru($fp);
            fclose($fp);
            $zip->close();
            return;
        }

        //$imageHandler = $zip->getFromIndex($index);
        $imageHandler = $zip->getFromName($page);
        file_put_contents($cachepathname, $imageHandler);
        $zip->close();

		exec('convert '.realpath($cachepathname).' -resize '.$setWidth.' '.realpath($cachepathname));
        //resizeExtern(realpath($cachepathname),$setWidth, $force);
        //resize(realpath($cachepathname),$setWidth, $force);
        $fp = fopen($cachepathname, "rb");
        header('Content-type:'.$headertype);
        fpassthru($fp);
        fclose($fp);
    } else {
        echo 'failed to extract page from zip.';
    }

}