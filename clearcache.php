<?php
/**
 * Created by PhpStorm.
 * User: Zhi
 * Date: 2/18/2015
 * Time: 2:31 PM
 */

include "utils.php";
include "config.php";

sureRemoveDir($CACHE_DIR, 0);

// jump to main page
header('Location: index.php');