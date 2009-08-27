<?php 
// http://www.w3.org/TR/2004/WD-wsdl20-20040803/#simpletypes

/*  Select Any Base
      wsdls:string 	1
      wsdls:Token 	10
      wsdls:NCName 	100
      wsdls:anyURI 	1000
      wsdls:QName 	10000
      wsdls:boolean 100000
      wsdls:int 	1000000
*/

	require_once('db.class.php');
    
	$db = new db_class();
	
    echo '<pre>';
	/*LISTA DE TESTE
		- GoogleSearch.wsdl OK
		- UltraXML.wsdl OK
		- foxcentral.wsdl OK
		- symgate.wsdl OK
	*/
	
	$url = 'http://localhost:8080/symgate.wsdl';
	$client = new SoapClient($url);
	
	$allType = $client->__getTypes();
	$allFunc = $client->__getFunctions();
	
	//Adiciona novo WebService
	$idWS = $db->db_insert("WebService","url = '$url'");
	
	//Adiciona todos os tipos definidos no descritor
	foreach ($allType as $type) {
		$pattern = '/(\w+\s)(\w+)/';
		preg_match_all($pattern, str_replace("\n",'',$type), $matches);
		//Adiciona novo tipo complexo
		$idType = $db->db_insert("Type","idWebService = $idWS, name = '{$matches[2][0]}', code = (SELECT t.code FROM Type t WHERE t.name = TRIM('{$matches[1][0]}'))");
		//Adiciona tipos no tipo complexo
		for ($i=1; $i<count($matches[1]); $i++) {
			$db->db_insert("ComplexType","id = $idType, name = '{$matches[2][$i]}', idType = (SELECT t.id FROM type t WHERE t.name = TRIM('{$matches[1][$i]}') and (idWebService = $idWS or idWebService = 0))");
		}
	}
	//Atualiza todos os tipos complexos com o identificador dos tipos correspondentes
	echo "<br>" . $sql = "UPDATE ComplexType c SET c.idType = (SELECT t.id FROM type t WHERE t.name = c.name and (idWebService = $idWS or idWebService = 0)) WHERE c.idType IS NULL;";
	$db->db_execute($sql);
	
	//Atualiza código de tipagem para cada tipo complexo
	echo "<br>" . $sql = "UPDATE Type t SET t.code = (	SELECT sum(t2.code) FROM ComplexType c
INNER JOIN Type t2 ON t2.id = c.idType
WHERE c.id = t.id) WHERE idwebservice = $idWS";
/*

UPDATE ComplexType c SET code = (SELECT sum(code) FROM Type t WHERE t.id = c.idType);
UPDATE Type t SET code = (SELECT sum(code) FROM ComplexType c WHERE t.id = c.id) WHERE t.id IN (SELECT id FROM ComplexType);

*/

	foreach ($allFunc as $func) {
		$pattern = '/(\w+\s)(\$?\w+)/';
		preg_match_all($pattern, $func, $matches);
		//Adiciona nova função descrita no WebService
		$idFunc = $db->db_insert("Function","idWebService = $idWS, name = '{$matches[2][0]}', idReturnType = (SELECT t.id FROM Type t WHERE t.name = TRIM('{$matches[1][0]}') and (idWebService = $idWS or idWebService = 0))");
		//Adiciona tipos de parâmetros de entrada da função
		for ($i=1; $i<count($matches[1]); $i++) {
			$db->db_insert("Params","idFunction = $idFunc, idType = (SELECT t.id FROM Type t WHERE t.name = TRIM('{$matches[1][$i]}') and (idWebService = $idWS or idWebService = 0))");
		}
		//break;
	}
	
	//Atualiza código de tipagem para cada tipo complexo
	echo "<br>" . $sql = "UPDATE Function f SET f.code = (	SELECT SUM(t2.code) 
															FROM Params c  
															NATURAL JOIN Type t2 
															WHERE idFunction = f.idFunction);";
	
	echo '</pre>';
	
?>