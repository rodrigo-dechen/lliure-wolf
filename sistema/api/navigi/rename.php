<?php
/**
*
* API navigi - lliure
*
* @Vers�o 6.0
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Entre em contato com o desenvolvedor <jomadee@glliure.com.br> http://www.lliure.com.br/
* @Licen�a http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
header("Content-Type: text/html; charset=ISO-8859-1", true);
require_once("../../etc/bdconf.php"); 
require_once("../../includes/jf.funcoes.php"); 

$navigi = unserialize(jf_decode($_SESSION['logado']['token'], $_POST['token']));

	$seletor = 0;
	if($navigi['configSel'] != false)
		$seletor = $_POST['seletor'];

if($navigi['rename'] || (isset($navigi['config'][$seletor]['rename']) && $navigi['config'][$seletor]['rename'])){
	$_POST = jf_iconv2($_POST);
			
	$tabela = $navigi['config'][$seletor]['tabela'];
	$texto[$navigi['config'][$seletor]['coluna']] = mysql_real_escape_string($_POST['texto']);
	$id = mysql_real_escape_string($_POST['id']);


	jf_update($tabela, $texto, array('id' => $id));
} else{
	echo 403;
}
?>