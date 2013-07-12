<?php
header('Content-type: text/html; charset=utf-8');
error_reporting(E_ALL & ~E_NOTICE); //所有錯誤中排除NOTICE提示
//require 'de_en.php';
$cell = $_POST["celltext"];
$mode = $_POST["mode"];
$chk_time = $_POST["chk_time"];
$uid = $_POST["uid"];
$phpself=basename($_SERVER["SCRIPT_FILENAME"]);//被執行的文件檔名
//
date_default_timezone_set("Asia/Taipei");//時區設定
$time=(string)time();//UNIX時間時區設定
$chk_time_key='abc123';
$chk_time_enc=passport_encrypt($time,$chk_time_key);
session_start(); //session
//
$ver= 'log+dir#re ver.130626+1204'; //版本
$host=$_SERVER["SERVER_NAME"]; //主機名稱
//
$htmlstart=<<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
<meta http-equiv=\"content-language\" content=\"tw-zh\"/>
<META NAME='ROBOTS' CONTENT='INDEX, FOLLOW'>
<title>$host</title>
<style>
body {background-color:#FFFFEE;color:#800000;}
a:hover {color:#DD0000;}
a:visited {color:#0000EE;}
a:link {color:#0000EE;}
.hide {display:none;}
div {display:none;}
</style>
</head>
<body>\n
EOT;
//<body bgcolor=\"#FFFFEE\" text=\"#800000\" link=\"#0000EE\" vlink=\"#0000EE\">

$dev_link="<a href=\"https://sites.google.com/site/ptttxtsave/\">†</a><br>";
//$dev_link="";
$php_link= "<br>".$_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"]." <br>";

///////////////計數器
$counter=<<<EOT
<script language="javascript" type="text/javascript" src="http://js.users.51.la/15885849.js"></script>
<noscript><a href="http://www.51.la/?15885849" target="_blank"><img alt="&#x6211;&#x8981;&#x5566;&#x514D;&#x8D39;&#x7EDF;&#x8BA1;" src="http://img.users.51.la/15885849.asp" style="border:none" /></a></noscript>

<!-- Start of StatCounter Code for Default Guide -->
<script type="text/javascript">
var sc_project=8971899; 
var sc_invisible=0; 
var sc_security="a47f72e7"; 
var scJsHost = (("https:" == document.location.protocol) ?
"https://secure." : "http://www.");
document.write("<sc"+"ript type='text/javascript' src='" +
scJsHost+
"statcounter.com/counter/counter.js'></"+"script>");
</script>
<noscript><div class="statcounter"><a title="web analytics"
href="http://statcounter.com/" target="_blank"><img
class="statcounter"
src="http://c.statcounter.com/8971899/0/a47f72e7/0/"
alt="web analytics"></a></div></noscript>
<!-- End of StatCounter Code for Default Guide -->

<!-- Histats.com  START  (standard)-->
<script type="text/javascript">document.write(unescape("%3Cscript src=%27http://s10.histats.com/js15.js%27 type=%27text/javascript%27%3E%3C/script%3E"));</script>
<a href="http://www.histats.com" target="_blank" title="web tracker" ><script  type="text/javascript" >
try {Histats.start(1,2336811,4,511,95,18,"00000000");
Histats.track_hits();} catch(err){};
</script></a>
<noscript><a href="http://www.histats.com" target="_blank"><img  src="http://sstatic1.histats.com/0.gif?2336811&101" alt="web tracker" border="0"></a></noscript>
<!-- Histats.com  END  -->

EOT;
$counter="\n".$counter."\n";
$counter='';//不加計數器
///////////////

$htmlend="<a href=\"./?".$time."\">./</a> xlwohaetxfpr</body></html>\n";
////

$chk_time_enc=passport_encrypt($time,$chk_time_key);
$uid2=uniqid(chr(rand(97,122)),true);//建立唯一ID

echo $htmlstart;
//$_SESSION['uid']='';
//echo $_SESSION['uid'].' '.$uid.'<br/>';
$t_url=$phpself."?".$time;//網址
$form=<<<EOT
<form id='form1' action='$t_url' method="post" onsubmit="return check2();">
<input type="hidden" name="mode" value="reg">
<input type="text" name="uid" id="uid" size="20" value="??" class="hide">
<input type="text" name="chk_time" id="chk_time" size="20" value="??" class="hide">
<a href="$phpself">內文</a>
<textarea name="celltext" id="celltext" cols="48" rows="4" wrap="soft"></textarea><br>
<span style="display:block; width:120px; height:90px; BORDER:#000 1px solid;" id='send' name="send" onclick='if(click1){check();}'/>送出</span>
</form>
<script language="Javascript">
var click1=1;
function check(){
	click1=0;
	document.getElementById("send").innerHTML="稍後";
	document.getElementById("uid").value="$uid2";
	document.getElementById("chk_time").value="$chk_time_enc";
	document.getElementById("form1").onsubmit();
}
function check2(){
	//document.getElementById("send").disabled=true;
	document.getElementById("send").style.background="#ff0000";
	var tmp;
	var regStr = 'http://';
	var re = new RegExp(regStr,'gi');
	tmp = document.getElementById("celltext").value;
	//alert(regStr);
	tmp = tmp.replace(re,"ttpp//");//有些免空會擋過多的http字串
	document.getElementById("celltext").value =tmp;
	document.getElementById("form1").submit();
}
</script>
EOT;
echo $form;


switch($mode){
	case 'reg':
	$chk_time_dec=passport_decrypt($chk_time,$chk_time_key);
	if(preg_match('/[^0-9]+/', $chk_time_dec)){die('xN');}//檢查值必須為數字
	if($time-$chk_time_dec>8*60*60){die('xtime out');} //檢查發文時間
	//echo $_SESSION['uid'].' '.$uid.'<br/>';
	if($uid==$_SESSION['uid']){die('xSESSION');}
	$_SESSION['uid']=$uid;
	//echo $_SESSION['uid'].' '.$uid.'<br/>';
	//unset($_SESSION['uid']);
	//
	//$cell = Chop($cell);//去除長空白
	if(strlen($cell)==0){echo "內文不可為空<br>";break;}
	//$postbyte=100;
	//if(strlen($cell) > $postbyte){echo "內文太長".strlen($cell)."/".$postbyte;break;}
	if(get_magic_quotes_gpc()) {$cell = stripslashes($cell);} //去掉字串中的反斜線字元
	//if(get_magic_quotes_gpc()) {$cell = addslashes($cell);} //使用反斜線引用字符串
	$cell = htmlspecialchars($cell); //將特殊字元轉成 HTML 的字串格式 ( &....; )。

	//修正//必要的變色
	$cell = preg_replace("/\r\n/","\n",$cell);
	$cell = preg_replace("/http\:\/\//", "ttpp//", $cell);//
	$cell = preg_replace("/ttpp\/\//", "http://", $cell);//有些免空會擋過多的http字串
	$count_http=substr_count($cell,'http');//計算連結數量
	//連結加底線
	$cell = preg_replace("/(http|https)(:\/\/[\!-;\=\?-\~]+)/si", "<span class='link'>\\1\\2</span>", $cell);

	//$cell = preg_replace("/\//", "&#47;", $cell);//backslash 換成 HTML Characters 
	//$cell = preg_replace("/http/", "&#104;&#116;&#116;&#112;", $cell);//backslash 換成 HTML Characters 
	//$cell = preg_replace("/ /","&nbsp;",$cell);//將空白轉成HTML碼

	$cellarr=explode("\n",$cell);
	$title=$cellarr[1]; //取得文章標題
	$descr=$cellarr[0].$cellarr[1].$cellarr[2];//meta標籤的描述
	$descr=preg_replace('/\s(?=\s)/','',$descr); //除去meta標籤多餘空白
	//&nbsp;

	//引文的變色
	$countline = count($cellarr);
	$countline_out = $countline;
	for($i = 0; $i < $countline; $i++){
		if(preg_match("/^推 /",$cellarr[$i])){
			$pos = strpos($cellarr[$i], ":");
			$cellarr[$i] = substr_replace($cellarr[$i],":</span>",$pos,1);
			$cellarr[$i] = preg_replace("/^推 /","<span style='color:#00f;'>推 </span><span style=\"color:#ff0;\">",$cellarr[$i]);
		}
		if(preg_match("/^→ /",$cellarr[$i])){
			$pos = strpos($cellarr[$i], ":");
			$cellarr[$i] = substr_replace($cellarr[$i],":</span>",$pos,1);
			$cellarr[$i] = preg_replace("/^→ /","<span style='color:#0f0;'>→ </span><span style=\"color:#ff0;\">",$cellarr[$i]);
		}
		if(preg_match("/^噓 /",$cellarr[$i])){
			$pos = strpos($cellarr[$i], ":");
			$cellarr[$i] = substr_replace($cellarr[$i],":</span>",$pos,1);
			$cellarr[$i] = preg_replace("/^噓 /","<span style='color:#f00;'>噓 </span><span style=\"color:#ff0;\">",$cellarr[$i]);
		}
		if(preg_match("/^\: /",$cellarr[$i])){
			$cellarr[$i]="<span style=\"color:rgb(0,128,128);\">".$cellarr[$i]."</span>";
		}
		if(preg_match("/^\※ /",$cellarr[$i])){
			$cellarr[$i]="<span style=\"color:rgb(0,128,0);\">".$cellarr[$i]."</span>";
		}
		$cellarr[$i]="<span id='row".$i."'></span>".$cellarr[$i]." ";
	}

	$cell=implode("\n",$cellarr);

	//普通的變色
	$cell = preg_replace("/(───────────────────────────────────────)/","<span style='color:#ff00ff;'>\\1</span>",$cell);
	$cell = preg_replace("/(批踢踢實業坊)/","<span style='color:#ff00ff;'>\\1</span>",$cell);


	//$cell = ereg_replace("\n※ 發信站","\n<span style='color:rgb(0,128,0);'>※ 發信站</span>",$cell);
	//$cell = ereg_replace("\n※ 編輯","\n<span style='color:rgb(0,128,0);'>※ 編輯</span>",$cell);
	//$cell = ereg_replace("※ 引述","<span style='color:rgb(0,128,0);'>※ 引述</span>",$cell);

	//標題的變色
	$cell = preg_replace("/( 作者 )/","<span style='background-color:rgb(0,0,160);color:rgb(192,192,192);'>\\1</span>",$cell);
	$cell = preg_replace("/( 標題 )/","<span style='background-color:rgb(0,0,160);color:rgb(192,192,192);'>\\1</span>",$cell);
	$cell = preg_replace("/( 時間 )/","<span style='background-color:rgb(0,0,160);color:rgb(192,192,192);'>\\1</span>",$cell);
	$cell = preg_replace("/( 看板 )/","<span style='background-color:rgb(0,0,160);color:rgb(192,192,192);'>\\1</span>",$cell);


	//html的head
	$htmlstart2=<<<EOT
<html lang='zh'>\n
<head>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
<meta http-equiv='content-language' content='tw-zh'/>
<meta name="description" content="$descr">
<title>$title</title>
<style>
body {
font-size:20px;
color:rgb(192,192,192);
background-color:black;
}
a:hover {color:#DD0000 !important;}
a:visited {color:#0000EE;}
a:link {color:#0000EE;}
pre { font-family:'細明體','MingLiU';}
.link {border-bottom:1px solid rgb(248,96,0);}
div {display:none;}
</style>
</head><body>\n
EOT;
	///
	//檔案名稱以時間來命名
	//$time = time();
	$ymdhis = gmdate("ymd",$time).gmdate("His",$time);
	$tim = $time.substr(microtime(),2,3);
	//$txtfile=$ymdhis."_".$tim."_txt.htm";
	$dd=$dd;//使用資料夾收藏 0=不使用(安全模式)


	//$dd=='nodir'
	if(ini_get('safe_mode')){
		// Do it the safe mode way
		$tmp="_".gmdate("ym",$time)."t";
		die("safe_mode");
	}else{
		// Do it the regular way
		$tmp="_".gmdate("ym",$time)."/";
		if(!is_dir($tmp)){//子資料夾不存在
			mkdir($tmp, 0755); //建立資料夾 權限0755
		}
		if(is_file("txtsavelog_index_list.php")){//如果根目錄有此檔案
			copy("txtsavelog_index_list.php", $tmp."index.php");//在子資料夾放檔案列表index
		}
	}

	$txtfile=$tmp.$tim.".htm";
	$cp = fopen($txtfile, "a+") or die('failed');// 讀寫模式, 指標於最後, 找不到會嘗試建立檔案
	flock($cp,2);//鎖定檔案準備寫入
	rewind($cp); //從頭讀取
	fwrite($cp, pack("CCC", 0xef,0xbb,0xbf));//UTF8檔頭
	fputs($cp, $htmlstart2);
	fputs($cp, "\n<pre>\n");
	fputs($cp, $cell);
	fputs($cp, "\n</pre>\n");
	fputs($cp, $dev_link);
	fputs($cp, $counter);
	fputs($cp, $htmlend);
	fclose($cp);
	$htmsize=(filesize($txtfile)/1024);//htm檔案大小
	$htmsize=number_format($htmsize,2);//截到小數2位 //四捨五入 round($htmsize,2) 
	//$err=copy($txtfile,);
	//if($err){}else{}

	////log ver--
	$tmp="txtsavelist.log";
	echo is_writeable($tmp)?'w':'F';
	echo is_readable($tmp)?'r':'F';
	echo file_exists($tmp)?'x':'F';
	echo @chmod($tmp,0666)?'c':'F'; //index權限 //@=不顯示錯誤
	//if(chmod($tmp,0666)){echo 'c';}else{echo 'F';}
	$cp = fopen($tmp, "a+") or die('failed');// 讀寫模式, 指標於最後, 找不到會嘗試建立檔案
	flock($cp,2);//鎖定檔案準備寫入
	rewind($cp); //從頭讀取
	$buf=fread($cp,1000000);
	ftruncate($cp, 0);//砍到零
	$title = preg_replace("/,/","&#44;",$title);//log檔用的標題名稱 排除逗號
	$age = $time;
	$buf=$txtfile.",".$title.",".$age."\n".$buf;
	$cellarr=array();
	$cellarr=explode("\n",$buf); //分析log
		foreach($cellarr as $key => $value) {//逐項檢查
			if($cellarr[$key]==""){unset($cellarr[$key]);}//空白行去除
		}
		array_splice($cellarr,300);//移除陣列第300項之後的部份
	$buf=implode("\n",$cellarr);
	fputs($cp, $buf); //寫回去
	fclose($cp);
	echo "".filesize($tmp)."]";//log檔案大小


	////htm
	$output="";
	$cellarr2=array();
	$countline = count($cellarr);
	for($i = 0; $i < $countline; $i++){
		if($cellarr[$i] != ""){
			$cellarr2[$i]=explode(",",$cellarr[$i]);
			$tmp=str_pad($i+1,3,"0",STR_PAD_LEFT);
			//$age=date("Y/m/d H:i:s",$cellarr2[$i][2]);
			$age=date("m/d",$cellarr2[$i][2]);//將UNIX時間轉成可讀時間
			$output.=$tmp." ".$age." <a href='".$cellarr2[$i][0]."'>".$cellarr2[$i][1]."_</a>";
			if($i<$countline-1){$output.="<br/>\n";}//最後一項不換行
		}
	}
	$tmp='';
	$tmp="<title>".$host."</title>";
	$tmp_link='';
	$tmp_link="<a href='".$phpself."'>w</a>"."<a href='./txtsavelog_index_list.php'>x</a>";
	$output=$tmp_link.'<br/>'.$output.'<br/>'.$tmp_link;
	$output="<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">".
	'<meta http-equiv=\"content-language\" content=\"tw-zh\"/>'.$tmp.
	"</head><body bgcolor=\"#FFFFEE\" text=\"#800000\" link=\"#0000EE\" vlink=\"#0000EE\">\n".$output."\n<br>".
	"</body></html>";

	//$tmp="txtsavelist.htm";
	$tmp="index.htm";
	echo @chmod($tmp,0666)?'c':'F'; //index權限 //@=不顯示錯誤
	$cp = fopen($tmp, "a+") or die('failed');// 讀寫模式, 指標於最後, 找不到會嘗試建立檔案
	flock($cp,2);//鎖定檔案準備寫入
	ftruncate($cp,0);//清空檔案內容
	fwrite($cp, pack("CCC", 0xef,0xbb,0xbf));//UTF8檔頭
	fputs($cp, $output);//寫入檔案內容
	fclose($cp);
	echo "".filesize($tmp)."]";//index檔案大小
	////htm//
	if(is_file("index.php")){
		rename("index.php","index.php_") or unlink("index.php");//index.php的優先權大於htm
	}
	////--log ver

	$url = "http://".$_SERVER["SERVER_NAME"]."".$_SERVER["PHP_SELF"]."";
	$url2=substr($url,0,strrpos($url,"/")+1);

	echo "<br/><a href=".$url2.$txtfile.">".$url2.$txtfile."</a> 
	行數:".$countline_out." 連結:".$count_http." 大小:".$htmsize."k<br/>".$title."<br/>";

	//echo '<META http-equiv="refresh" content="1;URL='.$php_read.'">';
break;
default:
	echo $ver;
	echo $php_link;
break;
}

function passport_encrypt($txt, $key) {
	srand((double)microtime() * 1000000);
	$encrypt_key = md5(rand(0, 32000));
	$ctr = 0;
	$tmp = '';
	for($i = 0; $i < strlen($txt); $i++) {
		$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
		$tmp .= $encrypt_key[$ctr].($txt[$i] ^ $encrypt_key[$ctr++]);
	}
	return base64_encode(passport_key($tmp, $key));
}
function passport_decrypt($txt, $key) {
	$txt = passport_key(base64_decode($txt), $key);
	$tmp = '';
	for ($i = 0; $i < strlen($txt); $i++) {
		$tmp .= $txt[$i] ^ $txt[++$i];
	}
	return $tmp;
}
function passport_key($txt, $encrypt_key) {
	$encrypt_key = md5($encrypt_key);
	$ctr = 0;
	$tmp = '';
	for($i = 0; $i < strlen($txt); $i++) {
		$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
		$tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
	}
	return $tmp;
}
function passport_encode($array) {
	$arrayenc = array();
	foreach($array as $key => $val) {
		$arrayenc[] = $key.'='.urlencode($val);
	}
	return implode('&', $arrayenc);
}
/*
$chk_time_key='abc123';
$chk_time_enc=passport_encrypt($time,$chk_time_key);
$chk_time_dec=passport_decrypt($chk_time_enc,$chk_time_key);
echo $time.' '.$chk_time_enc.' '.$chk_time_dec;
*/
echo $dev_link;
echo $htmlend;
clearstatcache();
?>
	
