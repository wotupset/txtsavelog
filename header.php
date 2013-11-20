<?php 

$file_name='txtsavelog.7z';//要呼叫的檔案
if(!is_file($file_name)){die('x!exists');}//檢查檔案是否存在
$tmp=filesize($file_name);//檔案大小
$tmp=$tmp.'_'.substr(md5_file($file_name),0,5);//檔名
header('Content-type: application/zip');
header('Content-Transfer-Encoding: Binary'); //編碼方式
$tmp="Content-Disposition: attachment; filename=\"build-$tmp.zip\"";
header($tmp);
readfile($file_name);

?> 
