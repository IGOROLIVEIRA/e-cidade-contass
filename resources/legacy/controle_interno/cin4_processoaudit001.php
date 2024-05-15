<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_processoaudit_classe.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
include("classes/db_processoauditdepart_classe.php");
db_postmemory($HTTP_POST_VARS);
$clprocessoaudit = new cl_processoaudit;
$db_opcao = 1;
$db_botao = true;
$sqlerro = false;
if(isset($incluir)){

	db_inicio_transacao();
  $clprocessoaudit->ci03_instit = db_getsession('DB_instit');
  
  if (isset($ci03_protprocesso_cod) && !empty($ci03_protprocesso_cod)) {
		
		$clprocessoaudit->ci03_protprocesso = $ci03_protprocesso_cod;
		unset($ci03_protprocesso_cod);

  } 
  
	$clprocessoaudit->incluir($ci03_codproc);

	if($clprocessoaudit->erro_status==0){
		$sqlerro=true;
	}

    db_fim_transacao($sqlerro);

    $ci03_codproc = $clprocessoaudit->ci03_codproc;
    $db_opcao = 1;
    $db_botao = true;

    // caso já exista a tentativa de inclusão do processo, mantém os departamentos salvos para adicionar ao select multiple
    if (isset($ci03_codproc) && isset($departamentos) && $departamentos != "") {

        $clprocessoauditdepart = new cl_processoauditdepart;
        $clprocessoauditdepart->excluir($ci03_codproc);

        $aDepts = explode(',', $departamentos);

        $sqlerro = false;
        db_inicio_transacao();

        foreach($aDepts as $iCodDept) {

            $clprocessoauditdepart = new cl_processoauditdepart;
            $clprocessoauditdepart->ci04_codproc = $ci03_codproc;
            $clprocessoauditdepart->ci04_depto = $iCodDept;

            $clprocessoauditdepart->incluir();

            if($clprocessoauditdepart->erro_status==0){
                $sqlerro=true;
                $clprocessoaudit->erro_msg = $clprocessoauditdepart->erro_msg;
                $clprocessoaudit->erro_status = 0;
            }

        }

        db_fim_transacao($sqlerro);
    }

}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script type="text/javascript" src="scripts/strings.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/AjaxRequest.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
	<td>&nbsp;</td>
  </tr>
  <tr> 
	<td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
	<center>
	<?
	include("forms/db_frmprocessoaudit.php");
	?>
	</center>
	</td>
  </tr>
</table>
</body>
</html>

<?
if(isset($incluir)){
  if($clprocessoaudit->erro_status=="0"){
    $clprocessoaudit->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clprocessoaudit->erro_campo!=""){
      echo "<script> document.form1.".$clprocessoaudit->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clprocessoaudit->erro_campo.".focus();</script>";
    }
  }else{
    db_msgbox($clprocessoaudit->erro_msg);
    db_redireciona("cin4_processoaudit002.php?liberaaba=true&chavepesquisa=$ci03_codproc");
  }
}
?>
