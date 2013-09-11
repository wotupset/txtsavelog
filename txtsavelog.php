<?php
header('Content-type: text/html; charset=utf-8');
error_reporting(E_ALL & ~E_NOTICE); //所有錯誤中排除NOTICE提示
//require 'de_en.php';
$cell = $_POST["celltext"];
$mode = $_POST["mode"];
$chk_time = $_POST["chk_time"];
$uid = $_POST["uid"];
$phpself=basename($_SERVER["SCRIPT_FILENAME"]);//被執行的文件檔名
$php_link="http://".$_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"]."";

//
date_default_timezone_set("Asia/Taipei");//時區設定
$time=(string)time();//UNIX時間時區設定
$chk_time_key='abc123';
$chk_time_enc=passport_encrypt($time,$chk_time_key);
session_start(); //session
//
$ver= 'log+dir ver.130828+0942'; //版本
$host=$_SERVER["SERVER_NAME"]; //主機名稱
$echo_data='';
//
//<body bgcolor=\"#FFFFEE\" text=\"#800000\" link=\"#0000EE\" vlink=\"#0000EE\">
$chk_time_enc=passport_encrypt($time,$chk_time_key);
$uid2=uniqid(chr(rand(97,122)),true);//建立唯一ID



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
	if(strlen($cell)==0){die("內文不可為空");}
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
		if(preg_match("/^推 [a-zA-Z]/",$cellarr[$i])){
			$pos = strpos($cellarr[$i], ":");
			$cellarr[$i] = substr_replace($cellarr[$i],":</span>",$pos,1);
			$cellarr[$i] = preg_replace("/^推 /","<span style='color:#00f;'>推 </span><span style=\"color:#ff0;\">",$cellarr[$i]);
		}
		if(preg_match("/^→ [a-zA-Z]/",$cellarr[$i])){
			$pos = strpos($cellarr[$i], ":");
			$cellarr[$i] = substr_replace($cellarr[$i],":</span>",$pos,1);
			$cellarr[$i] = preg_replace("/^→ /","<span style='color:#0f0;'>→ </span><span style=\"color:#ff0;\">",$cellarr[$i]);
		}
		if(preg_match("/^噓 [a-zA-Z]/",$cellarr[$i])){
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
		//$cellarr[$i]="<span id='row".$i."'></span>".$cellarr[$i]." ";
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


	//輸出網頁的html的head
	$htmlstart2=<<<EOT
<html lang='zh'>\n
<head>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
<META NAME='ROBOTS' CONTENT='NOINDEX, FOLLOW'>
<meta http-equiv='content-language' content='tw-zh'/>
<meta name="description" content="$descr">
<title>$title</title>
<link href='http://fonts.googleapis.com/css?family=Cousine' rel='stylesheet' type='text/css'>
<style>
body {
font-size:20px;
color:rgb(192,192,192);
background-color:black;
}
a:hover {color:#DD0000 !important;}
a:visited {color:#0000EE;}
a:link {color:#0000EE;}
pre { font-family:'細明體','MingLiU','DejaVu Sans Mono','Cousine';}
.link {border-bottom:1px solid rgb(248,96,0);}
div {display:none;}
</style>
</head><body>\n
EOT;
$htmlend2="<a href=\"../\">../</a> xlwohaetxfpr</body></html>\n";
	///
	//檔案名稱以時間來命名
	//$time = time();
	$ymdhis = gmdate("ymd",$time).gmdate("His",$time);
	$tim = $time.substr(microtime(),2,3);
	//$txtfile=$ymdhis."_".$tim."_txt.htm";

$dir_mth="_".gmdate("ym",$time)."/"; //存放該月檔案
if(!is_writeable(realpath("./"))){ die("根目錄沒有寫入權限，請修改權限"); }
@mkdir($dir_mth, 0777); //建立資料夾 權限0777
@chmod($dir_mth, 0777); //權限0777
if(!is_dir(realpath($dir_mth))){die("月份資料夾不存在");}
if(!is_writeable(realpath($dir_mth))){die("月份資料夾無法寫入");}
if(!is_readable(realpath($dir_mth))){die("月份資料夾無法讀取");}

if(!is_dir($dir_mth)){//子資料夾不存在
	//
}else{//子資料夾存在.
	if(!is_file("txtsavelog_index_list.php")){//如果根目錄沒有index檔案
		die('index檔案遺失');
	}else{//根目錄有index檔案
		if(!is_file($dir_mth."index.php")){//如果該月目錄沒有index檔案
			$chk=@copy("txtsavelog_index_list.php", $dir_mth."index.php");//複製檔案到該月目錄
			if(!$chk){die('複製檔案失敗');}
		}
	}
}
//

	$txtfile=$dir_mth.$tim.".htm";
	// 读写方式打开，将文件指针指向文件头并将文件大小截为零。如果文件不存在则尝试创建之。
	$cp = fopen($txtfile, "w+") or die('failed');
	flock($cp,2);//鎖定檔案準備寫入
	rewind($cp); //從頭讀取
	fwrite($cp, pack("CCC", 0xef,0xbb,0xbf));//UTF8檔頭
	fputs($cp, $htmlstart2);
	fputs($cp, "\n<pre>\n");
	fputs($cp, $cell);
	fputs($cp, "\n</pre>\n");
	fputs($cp, $dev_link);
	fputs($cp, $htmlend2);
	fclose($cp);
	$htmsize=(filesize($txtfile)/1024);//htm檔案大小
	$htmsize=number_format($htmsize,2);//截到小數2位 //四捨五入 round($htmsize,2) 
	//$err=copy($txtfile,);
	//if($err){}else{}

	////log ver--
	$tmp="txtsavelist.log";
	$echo_data.= is_writeable($tmp)?'w':'F';
	$echo_data.= is_readable($tmp)?'r':'F';
	$echo_data.= file_exists($tmp)?'x':'F';
	$echo_data.= @chmod($tmp,0666)?'c':'F'; //index權限 //@=不顯示錯誤
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
	$echo_data.= "".filesize($tmp)."]";//log檔案大小


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
	$echo_data.= @chmod($tmp,0666)?'c':'F'; //index權限 //@=不顯示錯誤
	$cp = fopen($tmp, "a+") or die('failed');// 讀寫模式, 指標於最後, 找不到會嘗試建立檔案
	flock($cp,2);//鎖定檔案準備寫入
	ftruncate($cp,0);//清空檔案內容
	fwrite($cp, pack("CCC", 0xef,0xbb,0xbf));//UTF8檔頭
	fputs($cp, $output);//寫入檔案內容
	fclose($cp);
	$echo_data.= "".filesize($tmp)."]";//index檔案大小
	////htm//
	if(is_file("index.php")){
		rename("index.php","index.php_") or unlink("index.php");//index.php的優先權大於htm
	}
	////--log ver

	$url = "http://".$_SERVER["SERVER_NAME"]."".$_SERVER["PHP_SELF"]."";
	$url2=substr($url,0,strrpos($url,"/")+1);

	$echo_data.= "<br/><a href=".$url2.$txtfile.">".$url2.$txtfile."</a> 
	行數:".$countline_out." 連結:".$count_http." 大小:".$htmsize."k<br/>".$title."<br/>";

	//echo '<META http-equiv="refresh" content="1;URL='.$php_read.'">';
break;
default:
	$echo_data.= $ver;
	$echo_data.= "<br>\n".$php_link."<br>\n";
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


//
$htmlstart=<<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
<meta http-equiv=\"content-language\" content=\"tw-zh\"/>
<META NAME='ROBOTS' CONTENT='noINDEX, FOLLOW'>
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
//
$form=<<<EOT
<form id='form1' action='$phpself' method="post" onsubmit="return check2();">
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
//
$dev_link="<a href=\"https://sites.google.com/site/ptttxtsave/\">†</a><br>";
//
$htmlend="<a href=\"./?".$time."\">./</a> xlwohaetxfpr</body></html>\n";

echo $htmlstart;
echo $form;
echo $echo_data;
echo $dev_link;
echo $htmlend;
clearstatcache();
?>
	
