<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_processoaudit_classe.php");
include("classes/db_tipoquestaoaudit_classe.php");
include("classes/db_questaoaudit_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clprocessoaudit    = new cl_processoaudit;
$cltipoquestaoaudit = new cl_tipoquestaoaudit;
$clquestaoaudit     = new cl_questaoaudit;
$db_opcao = 22;
$db_botao = false;
$sqlerro = false;

if (isset($incluir) || isset($alterar)) {

    $sSqlVerifica = $clquestaoaudit->sql_query(null, "*", null, "ci02_codtipo = {$ci01_codtipo} AND ci02_instit = ".db_getsession('DB_instit'));
    $clquestaoaudit->sql_record($sSqlVerifica);

    if ($clquestaoaudit->numrows == 0) {

        $sqlerro = true;
        $clprocessoaudit->erro_msg 		= "Auditoria sem questões cadastradas.";
        $clprocessoaudit->erro_status 	= 0;
      
        $ci01_codtipo 	= "";
        $ci01_tipoaudit = "";

    }
    
    if ($sqlerro==false) {
    
        db_inicio_transacao();
        
        $clprocessoaudit->sql_record($clprocessoaudit->sql_query($ci03_codproc));
        $clprocessoaudit->ci03_codtipoquest = $ci01_codtipo;
        $clprocessoaudit->alterar($ci03_codproc);
        
        if ($clprocessoaudit->erro_status == 0) {
            $sqlerro=true;
        } else {
            $clprocessoaudit->erro_msg = "Questões associadas com sucesso.";
        }

        db_fim_transacao($sqlerro);
        $ci03_codtipoquest = $ci01_codtipo;

    }

} else if(isset($excluir)){
    
    db_inicio_transacao();
    
    $clprocessoaudit->sql_record($clprocessoaudit->sql_query($ci03_codproc));
    $clprocessoaudit->ci03_codtipoquest = 'null';
    $clprocessoaudit->alterar($ci03_codproc);
    
    if ($clprocessoaudit->erro_status == 0) {
        $sqlerro=true;
    } else {
        $clprocessoaudit->erro_msg = "Questões excluídas com sucesso.";
    }

    db_fim_transacao($sqlerro);
    $ci03_codtipoquest = null;
    $ci01_codtipo = "";
    $ci01_tipoaudit = "";

} else {
    
    $result = $clprocessoaudit->sql_record($clprocessoaudit->sql_query($ci03_codproc));
    db_fieldsmemory($result,0);

}

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="390" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
  <?
  include("forms/db_frmprocessoquestaoaudit.php");
  ?>
    </center>
  </td>
  </tr>
</table>
</body>
</html>
<?
if(isset($alterar) || isset($excluir) || isset($incluir)){
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
  }
}
?>
