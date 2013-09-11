<?php
header('Content-type: text/html; charset=utf-8');
//跟txtsavelog.php放在一起
$time = time();
$tim = $timex.substr(microtime(),2,3);

$u = "http://".$_SERVER["SERVER_NAME"]."".$_SERVER["PHP_SELF"]."";
//echo $u."\n";
$url2=substr($u,0,strrpos($u,"/")+1);
//echo $url2."\n\n";

$output=array();
$reg_filename="/.*[0-9]{5}\.htm$/";
$reg_dirname="/.*/";//"/.*[0-9]{4}.*/"
$matches_unique[1] = array('.');

////////根目錄(1)////////於根目錄理論上只會收錄資料夾名稱
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
					array_push($output, $tmp);//將網址存進陣列
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
////////根目錄(2)////////向下一層
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
					array_push($output, $tmp);//將網址存進陣列
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
////////根目錄(3)////////向下兩層
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
					array_push($output, $tmp);//將網址存進陣列
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
////////根目錄(4)////////向下三層
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
					array_push($output, $tmp); //將網址存進陣列
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
array_splice($output,9000);//移除陣列第?項之後的部份
$count_line = count($output);
$echo_data='';
$op_max=100; //輸出的url數量
$op_max_head=30; //前段最新的url數量
$op_max_end=$op_max-$op_max_head; //後段隨機的url數量
if($count_line>$op_max){
	$output_head=array_splice($output, 0, $op_max_head);//抽出陣列的一部份 //第0個開始 到第10個
	foreach($output_head as $key => $value){
		$echo_data.= "<url><loc>".$value."</loc></url>\n"; //前面固定的xml內容
	}
	array_splice($output, 0, $op_max_head);//移除陣列的一部份 //第0個開始 到第10個
	//print_r($output);
	$rand_keys=array_rand($output,$op_max_end);//函数从数组中随机选出一个或多个元素，并返回。
	//print_r($rand_keys);
	foreach($rand_keys as $key => $value){
		$echo_data.= "<url><loc>".$output[$value]."</loc></url>\n";//後面隨機的xml內容
	}
}else{//檔案少於60個直接列出
	foreach($output as $key => $value){
		$echo_data.= "<url><loc>".$value."</loc></url>\n"; //全部的xml內容
	}
}
mb_internal_encoding("UTF-8");
$utf8_pack=pack("CCC", 0xef,0xbb,0xbf);//UTF8檔頭
$xml_head='<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
$xml_end='</urlset>';

echo $utf8_pack;
echo $xml_head;
echo $echo_data;
echo $xml_end;
?>