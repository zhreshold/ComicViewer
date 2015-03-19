<?php
/**
 * Created by PhpStorm.
 * User: Zhi
 * Date: 2/18/2015
 * Time: 2:31 PM
 */

include "utils.php";
ini_set('default_charset', 'utf-8'); 

function deletePage($archive, $page)
{
	if (endsWith($archive, ".cbz") || endsWith($archive, ".zip"))
    {
        $zip = new ZipArchive();
        if ($zip->open($archive))
        {
            $s = $zip->deleteName($page);
			$zip->close();
			return 'yes';
        }
		else
		{
			return 'not open';
		}
    }
	else
	{
		return 'error extension';
	}
}

//echo "inside";
if ($file = rawurldecode($_GET['file']))
{
	//echo $file.'<br/>';
	if ($page = rawurldecode($_GET['page']))
	{
		
		//echo $page.'<br/>';
		$s = deletePage(rawurldecode($file), rawurldecode($page));
		//echo $s;
	}
}

// jump to main page
header('Location: ' . $_SERVER['HTTP_REFERER']);