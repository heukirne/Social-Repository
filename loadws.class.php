<?php 
require_once('db.class.php');

define("BASE", 20);

class load_ws {

	var $debug=0;
	var $status=0;

	function load_ws ($url) {
		$this->status=0;
		$this->db = new db_class();
		$this->db->debug = $this->debug;
		$this->id = $this->db->db_insert("WebService","url = '$url'");	
		$sql = "UPDATE webservice SET status = '-1' WHERE id = {$this->id}";
		$this->db->db_execute($sql);
		try {
			$this->soap = new SoapClient($url);
			$this->loadType();
			$this->loadFunction();
			$this->status = 1;
		}	catch (Exception $e) {
			$this->status = 'Caught exception: ' .  $e->getMessage();
			$this->status = str_replace("'",'',$this->status);
		}
		$sql = "UPDATE webservice SET status = '{$this->status}' WHERE id = {$this->id}";
		$this->db->db_execute($sql);
	}

	function loadType() {
		$allType = $this->soap->__getTypes();
	
		//Adiciona todos os tipos definidos no descritor
		foreach ($allType as $type) {
			$pattern = '/(\w+\s)(\w+)/';
			preg_match_all($pattern, str_replace("\n",'',$type), $matches);
			//Adiciona novo tipo complexo
			$idType = $this->db->db_insert("Type","idWebService = {$this->id}, name = '{$matches[2][0]}'",", code = (SELECT t.code FROM Type t WHERE t.name = TRIM('{$matches[1][0]}') LIMIT 1)");
			//Adiciona tipos no tipo complexo
			for ($i=1; $i<count($matches[1]); $i++) {
				$this->db->db_insert("ComplexType","id = $idType, name = '{$matches[2][$i]}'",", idType = (SELECT t.id FROM type t WHERE t.name = TRIM('{$matches[1][$i]}') AND (idWebService = {$this->id} or idWebService = 0) LIMIT 1)");
			}
		}
		
		//Atualiza todos os tipos complexos com o identificador dos tipos correspondentes
		$sql = "UPDATE ComplexType c SET c.idType = (SELECT t.id FROM type t WHERE t.name = c.name AND (idWebService = {$this->id} or idWebService = 0) LIMIT 1) WHERE c.idType IS NULL;";
		//$this->db->db_execute($sql);
		
		//Atualiza code dos tipos complexos (recursivo)
		for ($i=0; $i<10; $i++) { //max 10 loops
			$aff = 0;
			$sql = "UPDATE ComplexType c SET code = (SELECT CONV(sum(CONV(code,".BASE.",10)*1),10,".BASE.") FROM Type t WHERE t.id = c.idType AND t.idWebService = {$this->id});";
			//$this->db->db_execute($sql);
			$sql = "UPDATE Type t SET code = (SELECT CONV(sum(CONV(code,".BASE.",10)*1),10,".BASE.") FROM ComplexType c WHERE t.id = c.id) WHERE t.id IN (SELECT id FROM ComplexType) AND t.idWebService = {$this->id};";
			//$aff = $this->db->db_execute($sql);
			if (!$aff) break;
		}
	
		return 1;
	}
	
	function loadFunction() {
		$allFunc = $this->soap->__getFunctions();
		
		foreach ($allFunc as $func) {
			$pattern = '/(\w+\s)(\$?\w+)/';
			preg_match_all($pattern, $func, $matches);
			//Adiciona nova função descrita no WebService
			$idFunc = $this->db->db_insert("Function","idWebService = {$this->id}, name = '{$matches[2][0]}'",", idReturnType = (SELECT t.id FROM Type t WHERE t.name = TRIM('{$matches[1][0]}') and (idWebService = {$this->id} or idWebService = 0) LIMIT 1)");
			//Adiciona tipos de parâmetros de entrada da função
			for ($i=1; $i<count($matches[1]); $i++) {
				$this->db->db_insert("Params","idFunction = $idFunc, idType = (SELECT t.id FROM Type t WHERE t.name = TRIM('{$matches[1][$i]}') and (idWebService = {$this->id} or idWebService = 0) LIMIT 1)");
			}
		}
		
		//Atualiza código de tipagem para cada tipo complexo
		$sql = "UPDATE Function f SET f.code = ( SELECT CONV(sum(CONV(code,".BASE.",10)*1),10,".BASE.") FROM Params p INNER JOIN Type t ON t.id = p.idType WHERE idFunction = f.id);";
		//$this->db->db_execute($sql);
		
		return 1;
	}
	
}
	
?>