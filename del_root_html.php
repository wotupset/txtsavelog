<?php
header('Content-type: text/html; charset=utf-8');
//跟txtsavelog.php放在一起
$time = (string)time();
$output=array();
$url='./';//要檢查的資料夾
$handle=opendir($url); 
$cc = 0;
while (($file = readdir($handle))!==false) { //遍歷該資料夾
	if($file != "." && $file != "..") { //這兩個不處理
		if(is_file($file)){//如果是檔案
			if(preg_match("/[0-9]+_txt\.htm$/",$file)){ //有符合的檔名
				array_push($output, $file); //抽出dir名稱到陣列2
			}
		}
	} 
	$cc = $cc + 1;
} 
closedir($handle); 

rsort($output);//新的在前 
ob_start();
echo "<pre>\n";
foreach($output as $k => $v){
	echo "$v";
	$chk=unlink($v);
	if($chk){echo "刪除成功\n";}else{echo "失敗\n";}
}
echo "</pre>\n";
$echo_body=ob_get_contents();//輸出擷取到的echo
ob_end_clean();//清空擷取到的內容
//**************
$htmlhead=<<<EOT
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>del_some_file</title>
<style>
body {font-family:'細明體','MingLiU';}
</style>
</head><body>
EOT;
//**************
$htmlend=<<<EOT
<a href="./">back</a>
</body></html>
EOT;

echo $htmlhead;
echo $echo_body;
echo $htmlend;
?>