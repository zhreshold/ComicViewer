<?php
/**
 * Created by PhpStorm.
 * User: Zhi
 * Date: 2/16/2015
 * Time: 4:22 PM
 */

include "excludes.php";     // load exclusion for bad renamed images
date_default_timezone_set('America/Chicago');
$exclude_files = $excludes;

function utf8_array_asort(&$array) {
    if(!isset($array) || !is_array($array)) {
        return false;
    }
    foreach($array as $k=>$v) {
        $array[$k] = iconv('UTF-8', 'GBK//IGNORE',$v);
    }
    asort($array);
    foreach($array as $k=>$v) {
        $array[$k] = iconv('GBK', 'UTF-8//IGNORE', $v);
    }
    return true;
}

function endsWith($haystack, $needle)
{
    return $needle === "" || substr(strtolower($haystack), -strlen($needle)) === strtolower($needle);
}

function getFilteredToc($archive)
{
    global $exclude_files;
    $toc = array();
    if (endsWith($archive, ".cbz") || endsWith($archive, ".zip"))
    {
        $zip = new ZipArchive();
        if ($zip->open($archive))
        {
            for ($i = 0; $i < $zip->numFiles; $i++)
            {
                $nameString = $zip->getNameIndex($i);
                if (endsWith($nameString, '.jpg')
                    || endsWith($nameString, '.gif')
                    || endsWith($nameString, '.png'))
                {
                    $excludeStrings = array_values($exclude_files);
                    $matched = 0;
                    foreach ($excludeStrings as $reg)
                    {
                        if (preg_match($reg, $nameString))
                        {
                            $matched = 1;
                            break;
                        }
                    }
                    if ($matched != 1)
                    {
                        $toc[] = $nameString;
                    }

                }
            }

            natcasesort($toc);
            $toc = array_values($toc);
            $zip->close();

        }
    }
    return $toc;
}

function sureRemoveDir($dir, $DeleteMe)
{
    if(!$dh = @opendir($dir)) return;
    while (false !== ($obj = readdir($dh)))
    {
        if($obj=='.' || $obj=='..') continue;
        if(!@unlink($dir.'/'.$obj)) SureRemoveDir($dir.'/'.$obj, true);
    }

    closedir($dh);
    if($DeleteMe)
    {
        @rmdir($dir);
    }
}

/**
 * @param $path
 * @return array($filenames, $filedates)
 */
function getSortedFilesByDate($path)
{
    $dir_handle = @opendir($path) or die("Unable to open $path");

    $files = array();
    $filesByDate = array();

    while ($file = readdir($dir_handle))
    {
        //if($file == '.' || $file == '.DS_Store') continue;
        if (!endsWith($file, ".cbz") && !endsWith($file, ".zip")) continue;
        array_push($files,$file);
        $filesByDate[$file] = filemtime($path."/".$file);
    }
    // sort by date

    //foreach($files as $file){
    //	$filesByDate[$file] = filemtime($file);
    //}
    arsort($filesByDate);
    $filenames = array_keys($filesByDate);
    $fileDates = array_values($filesByDate);

    closedir($dir_handle);
    return array('names' =>$filenames, 'dates' =>$fileDates);

}


/////////////////////////////////////////////////////////////////////////////////
// Passes an image from the archive directly to the browser; sets content-type header
// based on file type
function passImage($archive, $page)
{
    // Local browser cache
    $lastModified=filemtime($archive);
    $etagFile = md5_file(__FILE__);
    $ifModifiedSince=(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false);
    $etagHeader=(isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim($_SERVER['HTTP_IF_NONE_MATCH']) : false);
    header("Last-Modified: ".gmdate("D, d M Y H:i:s", $lastModified)." GMT");
    header("Etag: $etagFile");
    header('Cache-Control: public');
    header("Expires: " . gmdate('D, d M Y H:i:s', strtotime("+1 year")) ." GMT");

    if (@strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'])==$lastModified || $etagHeader == $etagFile)
    {
        header("HTTP/1.1 304 Not Modified");
        exit;
    }

    if (endsWith($archive, ".cbz") || endsWith($archive, ".zip"))
    {
        $zip = new ZipArchive();
        if ($zip->open($archive))
        {

            //$cachePath = 'cache/';
            //$zip->extractTo($cachePath);
            //$saveName = "cache/test.jpg";
            if (endsWith($page, ".jpg"))
            {
                //file_put_contents($saveName,$zip->getFromIndex(0));
                //imagejpeg($zip->getStream($page), "cache/test.jpg", 75);
                header('Content-type: image/jpeg');
                fpassthru($zip->getStream($page));
            }
            else if (endsWith($page, ".png"))
            {
                //imagepng(($zip->getStream($page), $saveName);
                header('Content-type: image/png');
                fpassthru($zip->getStream($page));
            }
            else if (endsWith($page, ".gif"))
            {
                //imagegif($zip->getStream($page), $saveName);
                header('Content-type: image/gif');
                fpassthru($zip->getStream($page));
            }
            $zip->close();
        }
    }
    else if (endsWith($archive, ".cbr"))
    {
        $rar = RarArchive::open($archive);
        if ($rar !== false)
        {
            $rar_entries = $rar->getEntries();
            for ($i = 0; $i < count($rar_entries); $i++)
            {
                if ($rar_entries[$i]->getName() == $page)
                {
                    if (endsWith($page, ".jpg"))
                    {
                        header('Content-type: image/jpeg');
                        fpassthru($rar_entries[$i]->getStream());
                    }
                    else if (endsWith($page, ".png"))
                    {
                        header('Content-type: image/png');
                        fpassthru($rar_entries[$i]->getStream());
                    }
                    else if (endsWith($page, ".gif"))
                    {
                        header('Content-type: image/gif');
                        fpassthru($rar_entries[$i]->getStream());
                    }
                    $rar->close();
                    return;
                }
            }
        }
    }
}

/**
 * Resizes an image if width of image is bigger than the maximum width
 * @return array the imageinfo of the resized image
 * @param $filename String The path where the image is located
 * @param $maxwidth String[optional] The maximum width the image is allowed to be
 */
function resize($filename,$maxwidth="1024", $force=0)
{
    $inputfunctions = array('image/jpeg'=>'imagecreatefromjpeg',
        'image/png'=>'imagecreatefrompng',
        'image/gif'=>'imagecreatefromgif');
    $outputfunctions = array('image/jpeg'=>'imagejpeg','image/png'=>'imagepng','image/gif'=>'imagegif');
    $imageinfo = getimagesize($filename);
    $currentheight = $imageinfo[1];
    $currentwidth = $imageinfo[0];

    if (!$force)
    {
        if($imageinfo[0] < $maxwidth)
        {
            return;
        }
    }
    $img = $inputfunctions[$imageinfo['mime']]($filename);
    $newwidth = $maxwidth;
    $newheight = ($currentheight/$currentwidth)*$newwidth;
    $newimage = imagecreatetruecolor($newwidth,$newheight);
    imagecopyresampled($newimage,$img,0,0,0,0,$newwidth,$newheight,$currentwidth,$currentheight);
    $outputfunctions[$imageinfo['mime']]($newimage,$filename);
    //return getimagesize($filename);
}

function resizeExtern($filename,$maxwidth="1024", $force=0)
{

    $inputfunctions = array('image/jpeg'=>'imagecreatefromjpeg',
        'image/png'=>'imagecreatefrompng',
        'image/gif'=>'imagecreatefromgif');
    $outputfunctions = array('image/jpeg'=>'imagejpeg','image/png'=>'imagepng','image/gif'=>'imagegif');
    $pattern = array('image/jpeg'=>'.jpg','image/png'=>'.png','image/gif'=>'.gif');
    $imageinfo = getimagesize($filename);
    $currentheight = $imageinfo[1];
    $currentwidth = $imageinfo[0];

    if ($force==0)
    {
        if($imageinfo[0] < $maxwidth)
        {
            return;
        }
    }
    $img = $inputfunctions[$imageinfo['mime']]($filename);
    $newwidth = $maxwidth;
    $newheight = ($currentheight/$currentwidth)*$newwidth;
    //exec('convert "'.$filename.'" -resize 300x900 "'.$filename.'"');
    exec('convert '.$filename.' -resize '.$newwidth.'x'.$newheight.' '.$filename);
    //$newimage = imagecreatetruecolor($newwidth,$newheight);
    //imagecopyresampled($newimage,$img,0,0,0,0,$newwidth,$newheight,$currentwidth,$currentheight);
    //$outputfunctions[$imageinfo['mime']]($newimage,$filename);
    //return getimagesize($filename);
}

function getImageDim($archive, $page)
{
    if (endsWith($archive, ".cbz") || endsWith($archive, ".zip"))
    {
        $zip = new ZipArchive();
        if ($zip->open($archive))
        {
            if (endsWith($page, ".jpg") || endsWith($page, ".png") || endsWith($page, ".gif"))
            {
                $fp = $zip->getStream($page);
                $size = getimagesizefromstring(stream_get_contents($fp));
				$zip->close();
                return $size;
            }
        }
    }
    else
    {
        return array();
    }
}



