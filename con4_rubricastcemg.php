<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");


/**
 * Carregamos um objeto com as informações passadas por GET.
 * Após isso analisamos se foi passado uma flag de erro e em caso positivo informamos isso ao usuário. 
 */
$oGet = db_utils::postMemory($_GET);
if (isset($oGet->lErro)) {
	db_msgbox($oGet->sErrorMessage);
} else if (isset($oGet->sMessage)) {
	db_msgbox($oGet->sMessage);
}

?>
<html>	
  <head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
  </head>
  <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#cccccc">
  <center>
   	<form name="form1" action="con4_rubricastcemg002.php" method="post" 
   	      enctype="multipart/form-data" onsubmit="return js_validaFormulario();">
      <fieldset style="margin-top:25px;margin-bottom:10px;width:580px;padding-top:10px;padding-bottom:15px;">
      	<legend><strong>Importar Contas TCE-MG:</strong></legend>
      		<?
		        db_input("arquivoContasTCEMG",50,'',true,"file",4);
          ?>
          <br>
          <br>
          <select name="opcao" >
          <option value="0">Importar</option>
          <option value="1">Acertar Rubricas</option>
          </select>
      </fieldset>
      <input type="submit" value="Importar Contas TCE-MG" id="btnImportarContas">
    </form>
  </center>
</body>
</html>
<? db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit")); ?>
<script>

/**
 * Função que chama ao fonte que importa as transações
 */
function js_validaFormulario() {

  if ($F('arquivotcemg') == "") {

    alert("Deve ser informado o arquivo que contém as informações para importação.");
    return false;
  }

  if (!confirm("A importação do arquivo poderá deixar o sistema um pouco lento. Tem certeza que deseja executar esta importação agora?")) {
    return false;
  }
  $('btnImportarContas').disabled = true;
  
  return true;
}


</script>
