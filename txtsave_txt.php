<?php
$cell = $_POST["cell"];
$mode = $_POST["mode"];
$phpself=basename($_SERVER["SCRIPT_FILENAME"]);//被執行的文件檔名
////
$htmlstart="<html>\n
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
<title>讀寫檔案練習</title>
<style>
body { 
background-color:#FFFFEE;
color:#800000;
}
a:hover {color:#DD0000;}
a:visited {color:#0000EE;}
a:link {color:#0000EE;}
</style>
</head><body>\n
";

$dev_link="<a href=\"https://sites.google.com/site/ptttxtsave/\">bbs2html simply txtsave sample</a><br>";
$htmlend="<a href=\"./\">./</a></body></html>\n";
////

echo $htmlstart;
echo '
<form enctype="multipart/form-data" action="'.$phpself.'" method=post>
<input type=hidden name=mode value=reg>
內文
<textarea name="cell" cols="48" rows="4" wrap=soft></textarea>
<br>
<input type=submit value=Send>
</form>';



switch($mode){
case 'reg':
//$cell = Chop($cell);//去除長空白
if(strlen($cell)==0){echo "內文不可為空";break;}
$postbyte=100;
//if(strlen($cell) > $postbyte){echo "內文太長".strlen($cell)."/".$postbyte;break;}
//if(get_magic_quotes_gpc()) {$cellA = stripslashes($cell);} //去掉字串中的反斜線字元
$cell = htmlspecialchars($cell); //將特殊字元轉成 HTML 的字串格式 ( &....; )。


//修正//必要的變色
$cell = preg_replace("/\r\n/","\n",$cell);
$cell = preg_replace("/ /", "&nbsp;", $cell);//

$cell=stripslashes($cell);
$cellarr=explode("\n",$cell);
$title=$cellarr[1]; //取得文章標題




$htmlstart2="<html>\n
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
<title>".$title."</title>
<style>
body { font-size:13px;color:black;}
</style>
</head><body>\n
";
///
//檔案名稱以時間來命名
$time = time();
$ymdhis = date("ymd",$time+8*60*60).date("His",$time+8*60*60);
$tim = $time.substr(microtime(),2,3);
$txtfile=$ymdhis."_".$tim."_txt.htm";
//body { font-family:'MingLiU','NSimSun','MS Gothic','DotumChe'; font-size: small;}
$cp = fopen($txtfile, "a+") or die("建立檔案失敗");// 讀寫模式, 指標於最後, 找不到會嘗試建立檔案
rewind($cp); //從頭讀取
fwrite($cp, pack("CCC", 0xef,0xbb,0xbf));//UTF8檔頭
//fputs($cp, $htmlstart2);
fputs($cp, "\n<pre style=\"font-family:'MingLiU','NSimSun','MS Gothic','DotumChe';\">\n");
fputs($cp, $cell);
fputs($cp, "</pre>\n");
//fputs($cp, $htmlend);
fclose($cp);
///
$url = "http://".$_SERVER["SERVER_NAME"]."".$_SERVER["PHP_SELF"]."";
$url2=substr($url,0,strrpos($url,"/")+1);

echo "<a href=".$url2.$txtfile.">".$url2.$txtfile."</a><br>".$title."<br>";
//echo '<META http-equiv="refresh" content="1;URL='.$php_read.'">';

default:
echo $dev_link;
echo $htmlend;
}


  
?>
	
