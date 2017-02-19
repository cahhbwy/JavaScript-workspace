<?php
//	header('Access-Control-Allow-Origin: http://home.ustc.edu.cn');
	header('Access-Control-Allow-Methods:POST');
	header('Access-Control-Allow-Headers:X-UA-Compatible,content-type');
//	header("Content-type: text/html; charset=utf-8");
//	echo "<!DOCTYPE html>";
	function isCrawler() { 
		$agent= strtolower($_SERVER['HTTP_USER_AGENT']); 
		if (!empty($agent)) { 
			$spiderSite= array( 
				"TencentTraveler", 
				"Baiduspider+", 
				"BaiduGame", 
				"Googlebot", 
				"msnbot", 
				"Sosospider+", 
				"Sogou web spider", 
				"ia_archiver", 
				"Yahoo! Slurp", 
				"YoudaoBot", 
				"Yahoo Slurp", 
				"MSNBot",
				"Java (Often spam bot)", 
				"BaiDuSpider", 
				"Voila", 
				"Yandex bot", 
				"BSpider", 
				"twiceler", 
				"Sogou Spider", 
				"Speedy Spider", 
				"Google AdSense", 
				"Heritrix", 
				"Python-urllib", 
				"Alexa (IA Archiver)", 
				"Ask", 
				"Exabot", 
				"Custo", 
				"OutfoxBot/YodaoBot", 
				"yacy", 
				"SurveyBot", 
				"legs", 
				"lwp-trivial", 
				"Nutch", 
				"StackRambler", 
				"The web archive (IA Archiver)", 
				"Perl tool", 
				"MJ12bot", 
				"Netcraft", 
				"MSIECrawler", 
				"WGet tools", 
				"larbin", 
				"Fish search", 
				); 
			foreach($spiderSite as $val) { 
				$str = strtolower($val); 
				if (strpos($agent, $str) !== false) { 
					return true; 
				} 
			} 
		}
		return false; 
	}
	if(isCrawler()){
		exit(1);
	}
	function getIP(){
        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            } else {
                $realip = $_SERVER['REMOTE_ADDR'];
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")) {
                $realip = getenv( "HTTP_X_FORWARDED_FOR");
            } elseif (getenv("HTTP_CLIENT_IP")) {
                $realip = getenv("HTTP_CLIENT_IP");
            } else {
                $realip = getenv("REMOTE_ADDR");
            }
        }
        return $realip;
    }
	function getCity($ip) {
		$ipfile = fopen("http://whois.pconline.com.cn/ip.jsp?ip=" . $ip, "r");
		$contents = "";
		if($ipfile){
			while (!feof($ipfile)){
				$contents .= fgets($ipfile);
			}
		}
		fclose($ipfile);
		return trim(mb_convert_encoding($contents, "UTF-8", "GBK"));
	}
//	$file=fopen("recordIP.log","a");
	$ip = getIP();
	$canLocation = $_POST['postCanLocation'];
	$longitude = $_POST['postLongitude'];
	$latitude = $_POST['postLatitude'];
	$accuracy = $_POST['postAccuracy'];
	$locPosition = $_POST['postLocPosition'];
	$ipPositon = getCity($ip);
//	fwrite($file,$ip . ", " . $canLocation . ", " . $longitude . ", " . $latitude . ", " . $accuracy . ", " . $locPosition . ", " . $ipPositon . "\n");
	
	$host = "localhost";
	$user = "user";
	$pass = "password";
	$db = "database";
	
	$dbc=mysqli_connect($host,$user,$pass,$db);
	if (!$dbc){
		return;
	}
	
	mysqli_query($dbc, "set character set 'utf8'");//读库 
	mysqli_query($dbc, "set names 'utf8'");//写库

	$query="call ipRecordInsert('$ip','$canLocation',$longitude,$latitude,$accuracy,'$locPosition','$ipPositon')";
	
	
	$result=mysqli_query($dbc, $query);
	mysqli_close($dbc);
//	fclose($file);
?>