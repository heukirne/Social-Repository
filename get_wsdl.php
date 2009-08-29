<?php 
require_once('loadws.class.php');
require_once('db.class.php');

	if (empty($_GET['q'])) {
			print('<title>Need a WSDL File</title>');
	} else {
		if ($_GET['q']=="BDLOAD") {
			$db = new db_class();
			$ret = $db->db_query("SELECT url FROM webservice WHERE status IS NULL or status = '-1' ORDER BY id LIMIT 10;");
			foreach ($ret as $row) {
				$loadWS = new load_ws($row->url);
				echo "</br>" . $row->url . " :: " . $loadWS->status;
				flush();
			}
			echo "<title>Sucessful load!</title>";
		} else {		
			
			$loadWS = new load_ws($_GET['q']);

			if ($loadWS->status==1) {
				echo "<title>Sucessful load!</title>";
			}
			else {
				echo "<title>Some problem occur!</title>";
				echo "<br>" . $loadWS->status;
			}
			echo "\n <br> Affected Rows: " . $loadWS->db->affected_rows;
			echo "<script>document.write('<br>'+document.title);</script>";
		}
	}
?>