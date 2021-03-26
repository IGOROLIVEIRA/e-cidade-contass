<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_rhlota_classe.php");
include("classes/db_orcorgao_classe.php");
include("classes/db_orcunidade_classe.php");
include("classes/db_rhlotaexe_classe.php");
include("classes/db_lotacao_classe.php");
include("classes/db_cfpess_classe.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
db_postmemory($HTTP_POST_VARS);
$clrhlota = new cl_rhlota;
$clrhlotaexe = new cl_rhlotaexe;
$clcfpess = new cl_cfpess;
$cllotacao = new cl_lotacao;
$cldb_estrut = new cl_db_estrut;
$clorcorgao = new cl_orcorgao;
$clorcunidade = new cl_orcunidade;
if(isset($r70_codigo)){
  $db_opcao = 3;
  $db_botao = true;
}else{
  $db_opcao = 33;
  $db_botao = false;
}

if(isset($excluir)){
  $sqlerro=false;
  //rotina para verificar a estrutura

//    $cldb_estrut->db_estrut_exclusao($r70_estrut,$mascara,"rhlota","r70_estrut");
//    if($cldb_estrut->erro_status==0){
//      $erro_msg = $cldb_estrut->erro_msg;
//      $sqlerro=true;
//    }
  if($sqlerro==false){
    $anofolha = db_anofolha();
    $mesfolha = db_mesfolha();
    db_inicio_transacao();

    //rotina que pega o campo estrut da tabela cfpess
      $result = $clcfpess->sql_record($clcfpess->sql_query_file($anofolha,$mesfolha,"r11_codestrut"));
      if($clcfpess->numrows>0){
	db_fieldsmemory($result,0);
      }else{
	echo 'Não existem registros na tabela cfpess para o ano '.$anofolha.' e mês '.$mesfolha.' ...';
	exit;
      }
    //final

    //rotina de inclusao na tabela rhlota
      $clrhlota->r70_codigo = $r70_codigo;
      $clrhlota->excluir($r70_codigo);
      if($clrhlota->erro_status==0){
	$sqlerro=true;
	$erro_msg = $clrhlota->erro_msg;
      }else{
	$ok_msg = $clrhlota->erro_msg;
      }
    //final
  }
  if($sqlerro==false){

      $result_excluir = $clrhlotaexe->sql_record($clrhlotaexe->sql_query_file(db_getsession("DB_anousu"),$r70_codigo));
      if($clrhlotaexe->numrows>0){
        $clrhlotaexe->excluir(db_getsession("DB_anousu"),$r70_codigo);
        $erro_msg = $clrhlotaexe->erro_msg;
        if($clrhlotaexe->erro_status==0){
          $sqlerro=true;
        }
      }

    /*
      $result = $cllotacao->sql_record($cllotacao->sql_query_file(null,null,$r70_codigo));
      if($cllotacao->numrows>0){
        $cllotacao->r13_codigo = $r70_codigo;
        $cllotacao->excluir(null,null,$r70_codigo);
        $erro_msg = $cllotacao->erro_msg;
        if($cllotacao->erro_status==0){
  	  $sqlerro=true;
        }

      }
      */
    //final
  }
  db_fim_transacao($sqlerro);
}else if(isset($chavepesquisa)){
   $db_opcao = 3;
   $result = $clrhlota->sql_record($clrhlota->sql_query($chavepesquisa));
   db_fieldsmemory($result,0);

   if($r70_analitica=="t"){
     $result_rhlotaexe = $clrhlotaexe->sql_record($clrhlotaexe->sql_query(null,$chavepesquisa));
     if($clrhlotaexe->numrows>0){
       db_fieldsmemory($result_rhlotaexe,0);
     }
   }
   /*
   $result = $cllotacao->sql_record($cllotacao->sql_query_file(null,null,$r70_codigo));
   if($cllotacao->numrows>0){
      db_fieldsmemory($result,0);
   }
   */
/*
   if($r70_analitica=="t"){
     $result = $cllotacao->sql_record($cllotacao->sql_query_file(null,null,$r70_codigo));
     if($cllotacao->numrows>0){
        db_fieldsmemory($result,0);
     }
   }
*/
   $db_botao = true;
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
    <center>
	<?
	include("forms/db_frmrhlota.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<?
if(isset($excluir)){
  if($sqlerro==true){
    db_msgbox($erro_msg);
    if($clrhlota->erro_campo!=""){
      echo "<script> document.form1.".$clrhlota->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clrhlota->erro_campo.".focus();</script>";
    };
  }else{
     db_redireciona("pes1_rhlota006.php");
  };
};
if(isset($chavepesquisa)){
  echo "<script>
          parent.document.formaba.rhlotavinc.disabled = false;
	  CurrentWindow.corpo.iframe_rhlotavinc.location.href = 'pes1_rhlotavinc001.php?chavepesquisa=$r70_codigo&db_opcaoal=false';
	</script>";
}
if($db_opcao==33){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
