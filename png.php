<?php 
$query_string=$_SERVER['QUERY_STRING'];
if(!preg_match('/^[0-9]+$/', $query_string )){die('x');}
$log='txtsavelist.log';
$content = file_get_contents($log);
//$yn = file_put_contents($filesave_tmp,$content);
$content=explode("\n",$content);
$line=count($content); //行數
//
Header("Content-type: image/png");//指定文件類型為PNG
$moji=$line;
//$moji=printf("%s",$moji);
$xx=27;
$yy=15;
$img = imageCreate($xx,$yy);
$color = imageColorAllocate($img, 255, 255, 255);
imageFill($img, 0, 0, $color);
$color = imageColorAllocate($img, 0, 0, 0);
imagestring($img,5,0,0, $moji, $color);
imagePng($img);
imageDestroy($img);
//

?> 
