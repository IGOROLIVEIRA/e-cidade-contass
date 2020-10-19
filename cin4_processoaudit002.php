<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_processoaudit_classe.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
include("classes/db_processoauditdepart_classe.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clprocessoaudit = new cl_processoaudit;
$db_opcao = 22;
$db_botao = false;
$sqlerro = false;
if(isset($alterar)){

    db_inicio_transacao();
    $db_opcao = 2;
    $clprocessoaudit->alterar($ci03_codproc);

    if($clprocessoaudit->erro_status==0){
		  $sqlerro=true;
    }
    db_fim_transacao($sqlerro);

    //inicia uma nova transação para salvar o relacionamento dos departamentos independente
    db_inicio_transacao();
    $sqlerro = false;

    $clprocessoauditdepart = new cl_processoauditdepart;
    $clprocessoauditdepart->excluir($ci03_codproc);

    if($clprocessoauditdepart->erro_status==0){
        $sqlerro=true;
        $clprocessoaudit->erro_msg = $clprocessoaudit->erro_msg;
    }
    
    $aDepts = explode(',', $departamentos);

    foreach($aDepts as $iCodDept) {

        $clprocessoauditdepart = new cl_processoauditdepart;
        $clprocessoauditdepart->ci04_codproc = $clprocessoaudit->ci03_codproc;
        $clprocessoauditdepart->ci04_depto = $iCodDept;

        $clprocessoauditdepart->incluir();

        if($clprocessoauditdepart->erro_status==0){
            $sqlerro=true;
            $clprocessoaudit->erro_msg = $clprocessoauditdepart->erro_msg;
        }

    }    

    db_fim_transacao($sqlerro);

} else if (isset($chavepesquisa)) {
    
    $db_opcao = 2;
    $result = $clprocessoaudit->sql_record($clprocessoaudit->sql_query($chavepesquisa)); 
    db_fieldsmemory($result,0);
    $db_botao = true;   

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
if(isset($alterar)){
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
if($db_opcao==22){
  echo "<script>document.form1.pesquisar.click();</script>";
}

if(isset($chavepesquisa)){
  echo "
    <script>
        function js_db_libera(){
          parent.document.formaba.processoauditquestoes.disabled=false;
          top.corpo.iframe_processoauditquestoes.location.href='cin4_procaudit004.php?ci03_codproc=".@$ci03_codproc."';
      ";
          if(isset($liberaaba)){
            echo "  parent.mo_camada('processoauditquestoes');";
          }
  echo"}\n
      js_db_libera();
    </script>\n
  ";
}
?>

