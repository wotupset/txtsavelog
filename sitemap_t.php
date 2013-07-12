<?php
header('Content-type: text/html; charset=utf-8');
echo pack("CCC", 0xef,0xbb,0xbf);
//跟txtsavelog.php放在一起
//這個程式會產生 robots.txt

$timex = time();
$tim = $timex.substr(microtime(),2,3);
/*
$tmp="
User-agent:*
Disallow:*.log$
Allow:/*?*
sitemap:http://".$_SERVER["SERVER_NAME"]."/sitemap_t.php
";
//!is_file("robots.txt")
if(filemtime("robots.txt")<1351882158){ //若robots.txt過舊
	$cp = fopen("robots.txt", "w+");// 讀寫模式, 指標於最後, 找不到會嘗試建立檔案
	ftruncate($cp,0);//清空檔案內容
	fputs($cp, $tmp);//寫入檔案內容
	fclose($cp);
}
//echo filemtime('robots.txt');
*/


$u = "http://".$_SERVER["SERVER_NAME"]."".$_SERVER["PHP_SELF"]."";
//echo $u."\n";
$url2=substr($u,0,strrpos($u,"/")+1);
//echo $url2."\n\n";

$output=array();
$reg_filename="/.*[0-9]{5}\.htm$/";
$reg_dirname="/.*/";//"/.*[0-9]{4}.*/"
$matches_unique[1] = array('.');

////////根目錄(1)////////
$matches_unique[2] = array();
foreach($matches_unique[1] as $val){
	$tmparr = array();//清空暫存陣列
	$url=''.$val.'/';//要檢查的資料夾
	//echo "檢查".$url."\n";
	$handle=opendir($url); 
	$cc = 0;
	while (($file = readdir($handle))!==false) { //遍歷該資料夾
		//echo $file."\n";
		if($file != "." && $file != "..") { 
			$tmparr[$cc] = $url.$file; 
			//echo $tmparr[$cc]."\n";
			if(is_dir($tmparr[$cc])){//如果是資料夾
				if(preg_match($reg_dirname,$tmparr[$cc])){ //
					if(!in_array($tmparr[$cc], $matches_unique[2])) {
						array_push($matches_unique[2], $tmparr[$cc]); //抽出dir名稱到陣列2
						//echo "根".$tmparr[$cc]."\n";
						//echo "陣列2\n";
					}
					//echo $tmparr[$cc];
				}
				//echo $tmparr[$cc];
			}
			if(is_file($tmparr[$cc])){//如果是檔案
				//echo $tmparr[$cc]."\n";
				if(preg_match($reg_filename,$tmparr[$cc])){ //同目錄底下的網頁
					$tmp=$url2.$tmparr[$cc];
					$tmp=str_replace('/./','/',$tmp);
					array_push($output, "<url><loc>".$tmp."</loc></url>\n");
					//echo "根".$tmparr[$cc]."\n";
					//echo "檔案\n";
				}
			}
		} 
		$cc = $cc + 1;
	} 
	closedir($handle); 
}
////////根目錄(1)////////*
//echo "wwww";
////////根目錄(2)////////
$matches_unique[3] = array();
foreach($matches_unique[2] as $val){
	$tmparr = array();//清空暫存陣列
	$url=''.$val.'/';//要檢查的資料夾
	//echo "檢查".$url."\n";
	$handle=opendir($url); 
	$cc = 0;
	while (($file = readdir($handle))!==false) { //遍歷該資料夾
		//echo $file."\n";
		if($file != "." && $file != "..") { 
			$tmparr[$cc] = $url.$file; 
			//echo $tmparr[$cc]."\n";
			if(is_dir($tmparr[$cc])){//如果是資料夾
				if(preg_match($reg_dirname,$tmparr[$cc])){ //
					if(!in_array($tmparr[$cc], $matches_unique[3])) {
						array_push($matches_unique[3], $tmparr[$cc]); //抽出dir名稱到陣列3
						//echo "根".$tmparr[$cc]."\n";
						//echo "陣列3\n";
					}
					//echo $tmparr[$cc];
				}
				//echo $tmparr[$cc];
			}
			if(is_file($tmparr[$cc])){//如果是檔案
				//echo $tmparr[$cc]."\n";
				if(preg_match($reg_filename,$tmparr[$cc])){ //同目錄底下的網頁
					$tmp=$url2.$tmparr[$cc];
					$tmp=str_replace('/./','/',$tmp);
					array_push($output, "<url><loc>".$tmp."</loc></url>\n");
					//echo "根".$tmparr[$cc]."\n";
					//echo "檔案\n";
				}
			}
		} 
		$cc = $cc + 1;
	} 
	closedir($handle); 
}
////////根目錄(2)////////*
//echo "wwww";
////////根目錄(3)////////
$matches_unique[4] = array();
foreach($matches_unique[3] as $val){
	$tmparr = array();//清空暫存陣列
	$url=''.$val.'/';//要檢查的資料夾
	//echo "檢查".$url."\n";
	$handle=opendir($url); 
	$cc = 0;
	while (($file = readdir($handle))!==false) { //遍歷該資料夾
		//echo $file."\n";
		if($file != "." && $file != "..") { 
			$tmparr[$cc] = $url.$file; 
			//echo $tmparr[$cc]."\n";
			if(is_dir($tmparr[$cc])){//如果是資料夾
				if(preg_match($reg_dirname,$tmparr[$cc])){ //
					if(!in_array($tmparr[$cc], $matches_unique[4])) {
						array_push($matches_unique[4], $tmparr[$cc]); //抽出dir名稱到陣列4
						//echo "根".$tmparr[$cc]."\n";
						//echo "陣列3\n";
					}
					//echo $tmparr[$cc];
				}
				//echo $tmparr[$cc];
			}
			if(is_file($tmparr[$cc])){//如果是檔案
				//echo $tmparr[$cc]."\n";
				if(preg_match($reg_filename,$tmparr[$cc])){ //同目錄底下的網頁
					$tmp=$url2.$tmparr[$cc];
					$tmp=str_replace('/./','/',$tmp);
					array_push($output, "<url><loc>".$tmp."</loc></url>\n");
					//echo "根".$tmparr[$cc]."\n";
					//echo "檔案\n";
				}
			}
		} 
		$cc = $cc + 1;
	} 
	closedir($handle); 
}
////////根目錄(3)////////*
//echo "wwww";
////////根目錄(4)////////
$matches_unique[5] = array();
foreach($matches_unique[4] as $val){
	$tmparr = array();//清空暫存陣列
	$url=''.$val.'/';//要檢查的資料夾
	//echo "檢查".$url."\n";
	$handle=opendir($url); 
	$cc = 0;
	while (($file = readdir($handle))!==false) { //遍歷該資料夾
		//echo $file."\n";
		if($file != "." && $file != "..") { 
			$tmparr[$cc] = $url.$file; 
			//echo $tmparr[$cc]."\n";
			if(is_dir($tmparr[$cc])){//如果是資料夾
				if(preg_match($reg_dirname,$tmparr[$cc])){ //
					if(!in_array($tmparr[$cc], $matches_unique[5])) {
						array_push($matches_unique[5], $tmparr[$cc]); //抽出dir名稱到陣列5
						//echo "根".$tmparr[$cc]."\n";
						//echo "陣列3\n";
					}
					//echo $tmparr[$cc];
				}
				//echo $tmparr[$cc];
			}
			if(is_file($tmparr[$cc])){//如果是檔案
				//echo $tmparr[$cc]."\n";
				if(preg_match($reg_filename,$tmparr[$cc])){ //同目錄底下的網頁
					$tmp=$url2.$tmparr[$cc];
					$tmp=str_replace('/./','/',$tmp);
					array_push($output, "<url><loc>".$tmp."</loc></url>\n");
					//echo "根".$tmparr[$cc]."\n";
					//echo "檔案\n";
				}
			}
		} 
		$cc = $cc + 1;
	} 
	closedir($handle); 
}
////////根目錄(3)////////*
//echo "wwww";
rsort($output);//新的在前
array_splice($output,5000);//移除陣列第12項之後的部份


mb_internal_encoding("UTF-8");

echo '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
foreach($output as $key => $value){
	echo $value;
}
echo '</urlset>';
?>