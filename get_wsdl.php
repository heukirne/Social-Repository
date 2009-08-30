<script>
	parent.init();
</script>
<?php 
require_once('loadws.class.php');
require_once('db.class.php');

	if (empty($_GET['q'])) {
			print('<title>Need a WSDL File</title>');
			echo "<script>document.write('<br>'+document.title);</script>";
			die();
	} else {
		if ($_GET['q']=="BDLOAD") {
			$db = new db_class();
			$ret = $db->db_query("SELECT url FROM webservice WHERE status IS NULL ORDER BY id LIMIT 10;");
			$retOK = $db->db_query("SELECT count(*) as cont FROM webservice WHERE status = '1';",1);
			$retNot = $db->db_query("SELECT count(*) as cont FROM webservice WHERE status IS NOT NULL;",1);
			$contOK = $retOK->cont;
			echo "<script>parent.document.title = 'Sucess Load: $contOK/{$retNot->cont}';</script>"; 
			flush();
			foreach ($ret as $row) {
				echo "</br>" . $row->url;
				flush();
				$loadWS = new load_ws($row->url);
				echo " Affect::" . $loadWS->db->affected_rows . " Status:: " . $loadWS->status;
				if ($loadWS->status==1) {
					$contOK++;
					echo "<script>parent.document.title = 'Success Load: $contOK/{$retNot->cont}';</script>"; 
				}
				flush();
			}
			echo "<script>parent.document.title = parent.document.title + ' Done!';</script>"; 
		} else {		
			
			$loadWS = new load_ws($_GET['q']);

			if ($loadWS->status==1) {
				echo "<title>Successful load!</title>";
			}
			else {
				echo "<title>Some problem occur!</title>";
				echo "<br>" . $loadWS->status;
			}
			echo "\n <br> Affected Rows: " . $loadWS->db->affected_rows;
			echo "<script>document.write('<br>'+document.title);</script>";
			die();
		}
	}
?>
<script>
	parent.clearTimeout(parent.hdTime);
	setTimeout("location.reload(true)",2000);
</script>