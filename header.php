<?php 
header("content-Type: text/html; charset=utf-8"); //語言強制
$phphost=$_SERVER["SERVER_NAME"];
$query_string=$_SERVER['QUERY_STRING'];
$phpself=basename($_SERVER["SCRIPT_FILENAME"]);//執行檔案名稱
//****************
$htmlhead = <<<EOT
<html><head>
<title>dlphp</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Script-Type" content="text/javascript">
<META http-equiv="Content-Style-Type" content="text/css">
<meta name="Robots" content="noindex,follow">
<STYLE TYPE="text/css"><!--
body { font-family:"細明體",'MingLiU'; }
--></STYLE>
</head>
<body bgcolor="#FFFFEE" text="#800000" link="#0000EE" vlink="#0000EE">
EOT;
//****************
$htmlend = <<<EOT
</body></html>
EOT;
//****************
$htmlbody='';
$htmlbody=<<<EOT
<a href="./$phpself?txtsavelog.php">txtsavelog.php</a><br/>
<a href="./$phpself?index2.php">index2.php</a><br/>
<a href="../">../</a><br/>

EOT;
$pp=0;
if($query_string){
	switch($query_string){
		case "txtsavelog.php":
			$file_name=$query_string;//檔案名稱
			$pp=1;
		break;
		case "index2.php":
			$file_name=$query_string;//檔案名稱
			$pp=1;
		break;
		case "sitemap_t.php":
			$file_name=$query_string;//檔案名稱
			$pp=1;
		break;
		default:
			$pp=0;
		break;
	}
	if($pp){
		if(is_file($file_name)){}else{//確認檔案是否存在
			die('the file is no found');
		}
		//$tmp=$tmp.'_'.substr(md5_file($file_name),0,5);//?
		$file_size=filesize($file_name);//檔案大小
		header("Content-Length:".$file_size);
		$tmp="Content-Disposition: attachment; filename=".$file_name."";
		header($tmp);
		header('Content-Transfer-Encoding: Binary'); //
		$file_type = mime_content_type($file_name);
		header('Content-type:'.$file_type); //強制下載 = octet-stream
		readfile($file_name);
		exit;
	}else{
		header("location: $phpself"); //把浏览器重定向
	}
}
echo $htmlhead;
echo $htmlbody;
echo $htmlend;
?> 
