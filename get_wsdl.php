<?php 

	require_once('loadws.class.php');
	$loadWS = new load_ws($_GET['q']);
	
	if ($loadWS->status) {echo "Sucessful load!";}
	else {echo "Some problem occur!";}
	echo "\n <br> Affected Rows: " . $loadWS->db->affected_rows;
	
?>