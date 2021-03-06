<?php 
	require_once('db.class.php');
	$db = new db_class();

	echo "<pre>";
	for ($i=0;$i<=500;$i+=50) {
		$wsdl_list = "";
		
		//WSDL in Search Engines (Google, Bing, Yahoo, AltaVista, Ask)
		//WSDl URL Patterns: asmx?wsdl , php?wsdl, jws?wsdl, cfc?wsdl, .wsdl
		if (!empty($_GET['cr'])) $urlExtra = "&cr=country".$_GET['cr'];
		$query = 'allinurl:"asmx?wsdl"';
		$url = "http://www.google.com.br/search?q=$query&start=$i&filter=0&num=50$urlExtra"; //to 600 step 50 (with flood block =/)
		//$url = "http://www.bing.com/search?q=asmx?wsdl&first=$i"; // to 1000 step 10
		//$url = "http://search.yahoo.com/search?p=inurl:asmx&b=$i"; //to 1000 step 10
		//$url = "http://www.altavista.com/web/results?aqmode=s&aqa=wsdl&rc=url&lh=asmx&nbq=50&stq=$i"; //to 1000 step 50
		//$url = "http://www.ask.com/web?q=inurl:asmx?wsdl&page=$i"; //to 30 step 1
		
		//Get URL Contents
		$wsdl_list = file_get_contents($url);
		if (empty($wsdl_list)) die("ERROR!!");
		$wsdl_list = str_replace("<strong>","",$wsdl_list); //for Bing highlights
		$wsdl_list = str_replace("</strong>","",$wsdl_list);
		
		//Regex for wsdl and asmx
		preg_match_all("/(https?\:\/\/[^\?\'\"]*(\?|\.)wsdl)/", strtolower($wsdl_list), $matches);
		echo "</br>start=$i";
		//print_r($matches[1]); echo $wsdl_list; exit();
		
		
		//Save URL in Database
		foreach ($matches[1] as $iten) {
			$db->db_insert("webservice","url = '$iten'"); //add ?wsdl for only asmx search
		}
		echo "<script>document.title = 'New WSDL: {$db->affected_rows}';</script>";
		flush();
	}
	echo "</pre>";
	
?>