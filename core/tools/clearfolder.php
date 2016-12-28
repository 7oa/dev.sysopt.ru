<?php
$dir=$_SERVER["DOCUMENT_ROOT"];
$folder="/test/";
$path=$dir.$folder;
if ($handle = opendir($path)) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
            unlink("$path/$file");
        }
    }
    closedir($handle);
}