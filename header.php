<?php 

$file_name='txtsavelog.7z';
if(!is_file($file_name)){die('x!exists');}
$tmp=filesize($file_name);
$tmp=$tmp.'_'.substr(md5_file($file_name),0,5);
header('Content-type: application/zip');
header('Content-Transfer-Encoding: Binary'); //½s½X¤è¦¡
$tmp="Content-Disposition: attachment; filename=\"build-$tmp.zip\"";
header($tmp);
readfile($file_name);

?> 
