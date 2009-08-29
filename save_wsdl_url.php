<?php 
	require_once('db.class.php');
	$db = new db_class();

	echo "<pre>";
	for ($i=0;$i<=600;$i+=50) {
		$urlExtra = "";
		$query = "filetype:wsdl";
		$wsdl_list = file_get_contents("http://www.google.com/search?q=$query&start=$i&filter=0&num=50$urlExtra");
		if (empty($wsdl_list)) die("ERROR!!");
		preg_match_all("/\shref\=\"(http\:\/\/[^\"]*\.wsdl)\"\s/", $wsdl_list, $matches);
		echo "</br>start=$i";
		//print_r($matches[1]);
		foreach ($matches[1] as $iten) {
			$db->db_insert("webservice","url = '$iten'");
		}
		echo "<script>document.title = 'New WSDL: {$db->affected_rows}';</script>";
		flush();
	}
	echo "</pre>";
?>