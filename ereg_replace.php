<?php
header("content-Type: text/html; charset=utf-8"); //語言強制
error_reporting(E_ALL & ~E_NOTICE); //所有錯誤中排除NOTICE提示

$cell = '
※ 引述《Metallicat (金屬製貓)》之銘言：
: 都先報警，然後等警察到了以後再過去，我以為每屆說要把教官蓋布袋都是唬爛的
: 想不到教官也會怕?就算國軍再怎麼不濟，起碼也沒那麼差吧?
: 本貓仙卡琳大人想請問大家有教官的八卦嗎?
首先請找到下面這個資料夾並打開
X:\GarenaLoLTW\GameData\Apps\LoLTW\Game\DATA\CFG\defaults
                <Locales>
                        <Locale Locale="zh_cn" Type="FZLanTingHei-L-GBK"/>
                        <Locale Locale="th_th" Type="Garuda"/>
                        <Locale Locale="zh_my" Type="FZLanTingHei-L-GBK"/>
                        <Locale locale="zh_tw" Type="bitlow"/>
                </Locales>
推 rpmchaser:http://goo.gl/gqs2x 海陸軍便顏色就是海艦上衣加咖啡褲  02/28 16:51
→ rpmchaser:海軍海陸本一家 以前部隊全銜是海陸 但3/4海艦 1/4海陸   02/28 16:53
噓 jatj:說一堆 沒重點                                              02/28 16:53
';

echo '<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head><body>';

//echo $cell;
echo 'get_magic_quotes_gpc: ';
if(get_magic_quotes_gpc()) {
  echo 'ON';
  //$cell=stripslashes($cell);//去掉伺服器於GET、POST 和 COOKIE自動加的反斜線 //addslashes
 }else{
  echo 'OFF';
 }
echo '<br/>';

$cell = htmlspecialchars($cell); //將特殊字元轉成 HTML 的字串格式 ( &....; )。
$cell = preg_replace("/\r\n/","\n",$cell);//

$cellarr=explode("\n",$cell);
$countline = count($cellarr);
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
	//echo $cellarr[$i]."<br>";
}


$cell=implode("\n",$cellarr);
echo "\n<pre style=\"font-family:細明體;\">\n";
echo $cell;
echo "</pre>\n";
	

$url = "http://".$_SERVER["SERVER_NAME"]."".$_SERVER["PHP_SELF"]."";
$url2=substr($url,0,strrpos($url,"/")+1);
echo $url."<br>";
echo $url2."<br>";

echo '</body></html>';
?>