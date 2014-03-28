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
$ver= 'log+dir ver.140315c1943'; //版本
//
date_default_timezone_set("Asia/Taipei");
$time=time();//UNIX時間時區設定
$time=(string)$time;
$chk_time_key='abc123';
$chk_time_enc=passport_encrypt($time,$chk_time_key);
//session_save_path(realpath('./session_save/'));
session_start(); //session
$_SESSION['session_on']="on";
$echo_body='';
ob_start();
if(isset($_SESSION['session_on'])){
	$session_pw=$_SESSION['session_pw'];
	echo "&#10004;session ok<br/>\n";
}else{
	$session_pw="";
	echo "&#10006;session no work<br/>\n";
}
$echo_body=ob_get_contents();//輸出擷取到的echo
ob_end_clean();//清空擷取到的內容
//

$host=$_SERVER["SERVER_NAME"]; //主機名稱
$echo_data='';
$echo_data.=$echo_body;
//
//<body bgcolor=\"#FFFFEE\" text=\"#800000\" link=\"#0000EE\" vlink=\"#0000EE\">
$chk_time_enc=passport_encrypt($time,$chk_time_key);
$uid2=uniqid(chr(rand(97,122)),true);//建立唯一ID



switch($mode){
	case 'reg':
	$chk_time_dec=passport_decrypt($chk_time,$chk_time_key);
	if(preg_match('/[^0-9]+/', $chk_time_dec)){die('xN');}//檢查值必須為數字
	if($time-$chk_time_dec>8*60*60){die("<a href='$phpself'>xtime out</a>");} //檢查發文時間
	//echo $_SESSION['uid'].' '.$uid.'<br/>';
	if($uid==$_SESSION['uid']){die("<a href='$phpself'>xSESSION</a>");}
	$_SESSION['uid']=$uid;
	//echo $_SESSION['uid'].' '.$uid.'<br/>';
	//unset($_SESSION['uid']);
	//
	//$cell = Chop($cell);//去除長空白
	if(strlen($cell)==0){die("<a href='$phpself'>內文不可為空</a>");}
	//$postbyte=100;
	//if(strlen($cell) > $postbyte){echo "內文太長".strlen($cell)."/".$postbyte;break;}
	if(get_magic_quotes_gpc()) {$cell = stripslashes($cell);} //去掉字串中的反斜線字元
	//if(get_magic_quotes_gpc()) {$cell = addslashes($cell);} //使用反斜線引用字符串
	$cell = htmlspecialchars($cell); //將特殊字元轉成 HTML 的字串格式 ( &....; )。

	//修正//必要的變色
	$cell = preg_replace("/\r\n/","\n",$cell);
	$cell = preg_replace("/http\:\/\//", "EttppZX", $cell);//
	$cell = preg_replace("/EttppZX/", "http://", $cell);//有些免空會擋過多的http字串
	$count_http=substr_count($cell,'http');//計算連結數量
	//連結加底線
	$cell = preg_replace("/(http|https)(:\/\/[\!-;\=\?-\~]+)/si", "<span class='link'>\\1\\2</span>", $cell);

	//$cell = preg_replace("/\//", "&#47;", $cell);//backslash 換成 HTML Characters 
	//$cell = preg_replace("/http/", "&#104;&#116;&#116;&#112;", $cell);//backslash 換成 HTML Characters 
	//$cell = preg_replace("/ /","&nbsp;",$cell);//將空白轉成HTML碼

	$cellarr=explode("\n",$cell);
	$title=$cellarr[1]; //取得文章標題
	//$descr=$cellarr[0].$cellarr[1].$cellarr[2];//meta標籤的描述
	//$descr=preg_replace('/\s(?=\s)/','',$descr); //除去meta標籤多餘空白
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
$htmlend2=<<<EOT
</body></html>
EOT;


	///
	//檔案名稱以時間來命名
	//$time = time();
	$ymdhis = date("ymd",$time).date("His",$time);
	$tim = $time.substr(microtime(),2,3);
	//$txtfile=$ymdhis."_".$tim."_txt.htm";

$dir_mth="_".date("ym",$time)."/"; //存放該月檔案
if(!is_writeable(realpath("./"))){ die("根目錄沒有寫入權限，請修改權限"); }
@mkdir($dir_mth, 0777); //建立資料夾 權限0777
@chmod($dir_mth, 0777); //權限0777
if(!is_dir(realpath($dir_mth))){die("月份資料夾不存在");}
if(!is_writeable(realpath($dir_mth))){die("月份資料夾無法寫入");}
if(!is_readable(realpath($dir_mth))){die("月份資料夾無法讀取");}
if(is_file("index.php")){//確認檔案存在
	if(is_file("index2.php")){//確認檔案存在
		unlink("index2.php");
	}
	rename("index.php","index2.php") or unlink("index.php");//index.php的優先權大於htm
}
if(!is_dir($dir_mth)){//子資料夾不存在
	//沒事
}else{//子資料夾存在.
	if(!file_exists("index2.php")){//如果根目錄沒有index檔案
		die('index檔案遺失');
	}else{//根目錄有index檔案
		if(!is_file($dir_mth."index.php")){//如果該月目錄沒有index檔案
			$chk=@copy("index2.php", $dir_mth."index.php");//複製檔案到該月目錄
			if(!$chk){
				//die('複製檔案失敗');
				$dir_mth="safemode=YES/";
			}
		}
	}
}
//

$txtfile=$dir_mth.$tim.".htm";
$url = "http://".$_SERVER["SERVER_NAME"]."".$_SERVER["PHP_SELF"]."";
$url2=substr($url,0,strrpos($url,"/")+1); //根目錄
$url2=$url2.$txtfile;

$counter2=<<<EOT
<script type="text/javascript" id="tc_9e4dbb3f8d">
var _tcq = _tcq || []; _tcq.push(['bblog', '9e4dbb3f8d']); 
(function() { var e = document.createElement('script'); e.type = 'text/javascript'; e.async = true; e.src = 'http://s.tcimg.com/w/v2/bblog.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(e, s); })();
</script>

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
<noscript><div class="statcounter"><a title="web statistics"
href="http://statcounter.com/free-web-stats/"
target="_blank"><img class="statcounter"
src="http://c.statcounter.com/8971899/0/a47f72e7/0/"
alt="web statistics"></a></div></noscript>
<!-- End of StatCounter Code for Default Guide -->
	
<script id="_wauxn2">var _wau = _wau || []; _wau.push(["small", "qpf4hmopruej", "xn2"]);
(function() {var s=document.createElement("script"); s.async=true;
s.src="http://widgets.amung.us/small.js";
document.getElementsByTagName("head")[0].appendChild(s);
})();</script>

<!-- Start 1FreeCounter.com code -->
  
  <script language="JavaScript">
  var data = '&r=' + escape(document.referrer)
	+ '&n=' + escape(navigator.userAgent)
	+ '&p=' + escape(navigator.userAgent)
	+ '&g=' + escape(document.location.href);

  if (navigator.userAgent.substring(0,1)>'3')
    data = data + '&sd=' + screen.colorDepth 
	+ '&sw=' + escape(screen.width+'x'+screen.height);

  document.write('<a href="http://www.1freecounter.com/stats.php?i=87779" target=\"_blank\" >');
  document.write('<img alt="Free Counter" border=0 hspace=0 '+'vspace=0 src="http://www.1freecounter.com/counter.php?i=87779' + data + '">');
  document.write('</a>');
  </script>

<!-- End 1FreeCounter.com code -->

<!-- Histats.com  START  (standard)-->
<script type="text/javascript">document.write(unescape("%3Cscript src=%27http://s10.histats.com/js15.js%27 type=%27text/javascript%27%3E%3C/script%3E"));</script>
<a href="http://www.histats.com" target="_blank" title="free web hit counter" ><script  type="text/javascript" >
try {Histats.start(1,2336811,4,511,95,18,"00000000");
Histats.track_hits();} catch(err){};
</script></a>
<noscript><a href="http://www.histats.com" target="_blank"><img  src="http://sstatic1.histats.com/0.gif?2336811&101" alt="free web hit counter" border="0"></a></noscript>
<!-- Histats.com  END  -->

EOT;
//***************
$dev_link2=<<<EOT
<a href="https://sites.google.com/site/ptttxtsave/">†</a><br>
<a href="../">../</a> <span style="color:rgb(0,137,250);">xlw</span><span style="color:rgb(255,0,43);">oha</span><span style="color:rgb(255,169,0);">etx</span><span style="color:rgb(0,167,83);">fpr</span>

$counter2
EOT;
	// 读写方式打开，将文件指针指向文件头并将文件大小截为零。如果文件不存在则尝试创建之。
	$cp = fopen($txtfile, "w+") or die('failed');
	flock($cp,2);//鎖定檔案準備寫入
	rewind($cp); //從頭讀取
	fwrite($cp, pack("CCC", 0xef,0xbb,0xbf));//UTF8檔頭
	fputs($cp, $htmlstart2);
	fputs($cp, "\n<pre>\n");
	fputs($cp, $cell);
	fputs($cp, "\n</pre>\n");
	fputs($cp, $dev_link2);
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
		$cc=$cc+1;
	}
	array_splice($cellarr,300);//移除陣列第300項之後的部份
	if(count($cellarr)<300){$log_arr_ct="◆◆".count($cellarr);}else{$log_arr_ct=count($cellarr);}
	$buf=implode("\n",$cellarr);
	fputs($cp, $buf); //寫回去
	fclose($cp);
	$echo_data.= "".filesize($tmp)."]";//log檔案大小


	////htm
	$output="";
	$cellarr2=array();
	$countline = count($cellarr);
	for($i = 0; $i < $countline; $i++){
		if($cellarr[$i] != ""){//
			$cellarr2[$i]=explode(",",$cellarr[$i]);
			$cc=$countline-$i;
			$tmp=str_pad($cc,3,"0",STR_PAD_LEFT);
			//$age=date("Y/m/d H:i:s",$cellarr2[$i][2]);
			$age=date("m/d",$cellarr2[$i][2]);//將UNIX時間轉成可讀時間
			$output.=$tmp." ".$age." <a href='".$cellarr2[$i][0]."'>".$cellarr2[$i][1]."_</a>";
			if($i<$countline-1){$output.="<br/>\n";}//最後一項不換行
		}
	}
	$tmp_link='';
	$tmp_link="<a href='$phpself'>w</a><a href='./index2.php'>x</a><a href='../'>r</a>";
$output=<<<EOT
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>$host</title>
<style>
body {
font-size:20px;
font-family:'細明體','MingLiU';
}
a:hover {color:#DD0000 !important;}
</style>
</head>
<body bgcolor="#FFFFEE" text="#800000" link="#0000EE" vlink="#0000EE">
$tmp_link
<br/>
$output
<br/>
$tmp_link
</body></html>
EOT;
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
	$echo_data.=$log_arr_ct;//log行數
	////htm//

	////--log ver

	//$url = "http://".$_SERVER["SERVER_NAME"]."".$_SERVER["PHP_SELF"]."";
	//$url2=substr($url,0,strrpos($url,"/")+1);

	$echo_data.= "<br/><a href=".$url2.">".$url2."</a> 
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
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<META NAME='ROBOTS' CONTENT='noINDEX, FOLLOW'/>
<title>$host</title>
<style>
body {background-color:#FFFFEE;color:#800000;}
a:hover {color:#DD0000;}
a:visited {color:#0000EE;}
a:link {color:#0000EE;}
.hide {display:none;}
body { font-family:'細明體','MingLiU';}
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
	tmp = tmp.replace(re,"EttppZX");//有些免空會擋過多的http字串
	document.getElementById("celltext").value =tmp;
	document.getElementById("form1").submit();
}
</script>
EOT;
//
$dev_link="<a href=\"https://sites.google.com/site/ptttxtsave/\">†</a><br>";
$htmlend="<a href='./'>./</a></body></html>\n";

echo $htmlstart;
echo $form;
echo $echo_data;
echo $dev_link;
echo $htmlend;
clearstatcache();
?>
	
