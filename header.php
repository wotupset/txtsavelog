<?php 

$file_name='txtsavelog.7z';//�n�I�s���ɮ�
if(!is_file($file_name)){die('x!exists');}//�ˬd�ɮ׬O�_�s�b
$tmp=filesize($file_name);//�ɮפj�p
$tmp=$tmp.'_'.substr(md5_file($file_name),0,5);//�ɦW
header('Content-type: application/zip');
header('Content-Transfer-Encoding: Binary'); //�s�X�覡
$tmp="Content-Disposition: attachment; filename=\"build-$tmp.zip\"";
header($tmp);
readfile($file_name);

?> 
