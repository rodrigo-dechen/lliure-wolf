<?php
/**
*
* lliure WAP
*
* @Vers�o 6.0
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Entre em contato com o desenvolvedor <jomadee@lliure.com.br> http://www.lliure.com.br/
* @Licen�a http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

ll_historico('reinicia');

$botoes = array(
	array('href' => $backReal, 'img' => $_ll['tema']['icones'].'br_prev.png', 'title' => $backNome)
	);

echo app_bar('Painel de controle', $botoes);
?>

<div class="painelCtrl">
	<div class="bloco">
		<h2>Configura��es</h2>
		
		<?php
		if(ll_tsecuryt()) {
			?>
			<div class="listp">
				<div class="inter link_idioma">
					<a href="painel/idiomas.php"><img src="imagens/layout/language.png" alt="" /></a>
					<a href="painel/idiomas.php"><span>Idiomas</span></a>
				</div>
			</div>
			
			<div class="listp">
				<div class="inter link_idioma">
					<a href="" onclick="abrepopup();"><img src="imagens/layout/terminal.png" alt="" /></a>
					<a href="" onclick="abrepopup();"><span>Terminal</span></a>
				</div>
			</div>

			<script>
				function abrepopup(){
					var width = 725;
					var height = 500;

					var left = 99;
					var top = 99;
					window.open('opt/terminal/terminal.php','Console', 'width='+width+', height='+height+', top='+top+', left='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=yes');
					
					return false;
				}
			</script>
			<?php

		}
		?>
		<div class="listp">
			<div class="inter">
				<a href="paginas/sobre.php" class="llSobre"><img src="imagens/layout/info.png" alt="" /></a>
				<a href="paginas/sobre.php" class="llSobre"><span>Sobre</span></a>
			</div>
		</div>	
		
		<div class="listp">
			<div class="inter menu_rapido">
				<a href="opt/stirpanelo/menu-rapido.php"><img src="opt/stirpanelo/img/menu_rapido.png" alt="" /></a>
				<a href="painel/menu-rapido.php"><span>Acesso r�pido</span></a>
			</div>
		</div>
		
		<div class="listp">
			<div class="inter">
				<a href="?usuarios"><img src="imagens/layout/users.png" alt="" /></a>
				<a href="?usuarios"><span>Usu�rios</span></a>
			</div>
		</div>		
			
	</div>
	
	<div class="bloco">
		<h2>Aplicativos</h2>
		<?php
		$appFolder = array();
		$erroAbrirDir = false;
		$consulta = "select * from ".PREFIXO."lliure_apps";
		$query = mysql_query($consulta);
		
		if(mysql_num_rows($query) > 0)
			while($dados = mysql_fetch_array($query))
			$aplicativos[$dados['pasta']] = $dados['nome'];
				
		if ($handle=opendir("app")) {
			while (false !== ($file = readdir($handle))) 
				if (strstr($file, '.') == false) 
						$appFolder[] = $file;
			 
			closedir($handle);
		} else {
			$erroAbrirDir = true;
		}		
		
		natcasesort($appFolder);
		
		if($erroAbrirDir == false) {
			foreach($appFolder as $chave => $file){
				if(isset($aplicativos[$file])){
					$icon = 'opt/stirpanelo/icon_defaulto.png';
					if(file_exists('app/'.$file.'/sys/ico.png'))
						$icon = 'app/'.$file.'/sys/ico.png';
					?>
					<div class="listp">
						<div class="inter">
							<a href="?app=<?php echo $file?>"><img src="<?php echo $icon; ?>" alt="<?php echo $file?>" /></a>
							<a href="?app=<?php echo $file?>"><span><?php echo $aplicativos[$file]?></span></a>
						</div>
					</div>
					<?php
					unset($appFolder[$chave]);
				}
				
			}
			
			
			foreach($appFolder as $chave => $file)
				if(ll_tsecuryt()) {
					$config = 'app/'.$file.'/sys/config.ll';
					
					$app_nome = $file;
					if(file_exists($config) && $appConfig = simplexml_load_file($config))
						$app_nome = $appConfig->nome;

					?>
					<div class="listp">
						<div class="inter">
							<a href="painel/install.php?app=<?php echo $file?>" class="install"><img src="opt/instalilo/ico.png" alt="<?php echo $app_nome?>" /></a>
							<a href="painel/install.php?app=<?php echo $file?>" class="install"><span><?php echo $app_nome; ?></span></a>
						</div>
					</div>
					<?php
				}
		} else {
			echo '<script type="text/javascript"> jfAlert("Houve um erro ao tentar abrir o diret�rio de aplicativos") </script>';			
		}
		?>
	</div>
</div>

<script type="text/javascript">
	$('.menu_rapido a, .install').jfbox({width: 420, height: 440});
	
	$('.link_idioma a').jfbox({width: 420, height: 440, addClass: 'idiomaBox'});
	
	$('.llSobre').jfbox({width: 420, height: 200, addClass: 'llSobre_box'});
</script>
