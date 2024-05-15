<?php

require_once 'libs/db_stdlib.php';
require_once 'libs/db_conecta.php';
require_once 'libs/db_sessoes.php';
require_once 'libs/db_usuariosonline.php';
require_once 'libs/db_utils.php';
require_once 'dbforms/db_funcoes.php';
require_once ("classes/db_protprocesso_classe.php");

db_postmemory($HTTP_SERVER_VARS);
db_postmemory($_POST);

$clprotprocesso = new cl_protprocesso;
$rotulo         = new rotulocampo();
$rotulo->label("p58_codproc");
$rotulo->label("p58_obs");

$anousu = db_getsession('DB_anousu');
$instit = db_getsession('DB_instit');

$sqlerro = false;

if($alterar == "Alterar"){

$rsprotprocesso = $clprotprocesso->sql_record($clprotprocesso->sql_query($p58_codproc,"p58_numeracao"));
db_fieldsmemory($rsprotprocesso, 0);

db_inicio_transacao();
		
$clprotprocesso->p58_codproc = $p58_codproc;
$clprotprocesso->p58_numeracao = $p58_numeracao;
$clprotprocesso->p58_obs = $p58_obs;
$clprotprocesso->alterar($p58_codproc);

if ($clprotprocesso->erro_status == '0') {
      db_msgbox($clprotprocesso->erro_msg);
      $sqlerro = true;
    }

if ($sqlerro == false) {
      db_msgbox('Alteração efetuada');
    }

db_fim_transacao();
}

?>

<html>
	<head>
		<title>DBSeller Informática Ltda - Página Inicial</title>
  		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  	   		<?php
  		 		db_app::load("scripts.js, prototype.js, datagrid.widget.js, messageboard.widget.js, dbtextField.widget.js");
  		 		db_app::load("windowAux.widget.js, strings.js,dbtextFieldData.widget.js");
  		 		db_app::load("grid.style.css, estilos.css");
       		?>
	  <style>
    	 .temdesconto
    	 {
      	 	background-color: #D6EDFF
    	 }
	  </style>
	</head>

	<body bgcolor="#CCCCCC">
		<?php
  			$sContass = explode(".", db_getsession("DB_login"));

  	    	if ($sContass[1] != 'contass'){
	    		echo "<br><center><br><H2>Essa rotina apenas pode ser usada por usuários da contass</h2></center>";
  			}
  			else
  			{
  	  	?>

	  <form name='form1' method="post" action="" onsubmit="return confirm('Deseja realmente alterar?');">
		<div class="container">
		<fieldset>
			<legend>
				<b>Manutenção Protocolo</b>
			</legend>
	  	<table>
			<tr>
				<td nowrap title="<?=@$Tp58_numero?>">
            		<?php
            			db_ancora("Protocolo: ","js_pesquisap58_codproc(true);",$db_opcao);
            		?>
				</td>
				<td> 
					<?php
						db_input('p58_codproc',10,$Ip58_codproc,true,'text',3);
						db_input('p58_requer',40,$Ip58_requer,true,'text',3,'');
					?>
				</td>
			<tr>
				<td nowrap title="Observação">
					<b>Observação: </b>
				</td>
				<td>
					<?php
						db_textarea('p58_obs',20,52,$Ip58_obs,true,'text',2,'');
					?>
				</td>
			</tr>
	  	</table>
		</fieldset>
		<input name="alterar" type="submit" id="alterar" value="Alterar">
	  </div>
	  </form>
	</body>

<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</html>

<script>
function js_pesquisap58_codproc(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_protprocesso','func_protprocesso.php?funcao_js=parent.js_mostraprotprocesso1|p58_codproc|p58_requer|p58_obs','Pesquisa',true);
  }
}
function js_mostraprotprocesso1(chave1,chave2,chave3){
  
  document.form1.p58_codproc.value = chave1;
  document.form1.p58_requer.value = chave2;
  document.form1.p58_obs.value = chave3;
  db_iframe_protprocesso.hide();
}
function js_pesquisa() {
  
  db_iframe.jan.location.href = 'func_procarquiv.php?funcao_js=parent.js_preenchepesquisa|0';
  db_iframe.mostraMsg();
  db_iframe.show();
  db_iframe.focus();
}

function js_preenchepesquisa(chave) {
  
  db_iframe.hide();
  location.href = '<?=basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])?>'+"?chavepesquisa="+chave;
}

onLoad=document.form1.p58_codproc.select();
onLoad=document.form1.p58_codproc.focus();
</script>

<?php
}
