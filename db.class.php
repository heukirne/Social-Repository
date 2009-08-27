<?php 

class db_class {
	
	var $debug=0;

	function db_class () {
		 $this->link = mysql_connect("localhost","root","mysql")
			 or die("Não pude conectar: " . mysql_error());
		 mysql_select_db("services") or print("(conecta_mysql)Não pude selecionar o banco de dados");	  
	}

	function db_query ($sql,$uni=0) {
		if ($this->debug) {echo($sql);}
		$result = mysql_query($sql) or die("(db_query)A query falhou: " . mysql_error());
	    $rResult = array();
		$dResult = array();
		while ($row = mysql_fetch_object($result)) {
			$rResult[] = $row;
		}
		mysql_free_result($result);
		if ($this->debug) {print_r($rResult);}
		if ($uni && count($rResult)>0) {
		  return $rResult[0];
		}
		if (!is_array($rResult)) $rResult = array();
		return $rResult;
	}
	
	function db_execute ($sql) {
		if ($this->debug) {echo($sql);}
		mysql_query($sql,$this->link) or die("(db_execute)A query falhou: " . mysql_error());
		return mysql_insert_id($this->link);
	}

	function db_insert ($table, $terms) {
		$ret = $this->db_query("SELECT id FROM $table WHERE " . str_replace(',',' and ',$terms) . ";",1);
		if ($ret) {
			echo "<br> $table id = {$ret->id} ($terms)";
			return $ret->id;
		} else {
			echo "<br>" . $sql = "INSERT INTO $table SET $terms;";
			return $this->db_execute($sql);
		}
	}
	
}

?>
