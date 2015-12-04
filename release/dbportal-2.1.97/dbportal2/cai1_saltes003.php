<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_saltes_classe.php");
include("dbforms/db_funcoes.php");
include("classes/db_corrente_classe.php");
include("classes/db_saltescontrapartida_classe.php");
include("classes/db_saltesextra_classe.php");

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$clsaltes              = new cl_saltes;
$clcorrente            = new cl_corrente;
$clsaltescontrapartida = new cl_saltescontrapartida;
$clsaltesextra         = new cl_saltesextra;
$db_botao              = false;
$db_opcao              = 33;

if(isset($HTTP_POST_VARS["db_opcao"]) && $HTTP_POST_VARS["db_opcao"]=="Excluir"){
     $erro = false;
     db_inicio_transacao();
       $db_opcao = 3;
       $res= $clcorrente->sql_record($clcorrente->sql_query_file(null,null,null,"*",null,"k12_conta=$k13_reduz"));
       if ($clcorrente->numrows > 0 ){
           $erro=true;
  	   db_msgbox("Não é possivel excluir uma conta com lançamentos");
       } else {
         $clsaltesextra->excluir(null,"k109_saltes = {$k13_reduz}");
         $clsaltescontrapartida->excluir(null,"k103_saltes = {$k13_reduz}");
         $clsaltes->excluir($k13_reduz);
         
       }	
     db_fim_transacao($erro);
}else if(isset($chavepesquisa)){
     $db_opcao = 3;
     $result = $clsaltes->sql_record($clsaltes->sql_query($chavepesquisa)); 
     db_fieldsmemory($result,0);
    $sSqlContrapartida = $clsaltescontrapartida->sql_query_contrapartida(null,
                                                                         "k103_contrapartida,k13_descr as k103_descr",
                                                                         null,
                                                                         "k103_saltes = {$chavepesquisa}");

   $rsContrapartida = $clsaltescontrapartida->sql_record($sSqlContrapartida);
   if ($clsaltescontrapartida->numrows > 0) {
     db_fieldsmemory($rsContrapartida, 0);                                                          
   }
   $sSqlContaextra = $clsaltesextra->sql_query_extra(null,
                                                          "k109_contaextra as k109_saltesextra,k13_descr as k103_descrextra",
                                                          null,
                                                          "k109_saltes = {$chavepesquisa}");

   $rsContaExtra = $clsaltesextra->sql_record($sSqlContaextra);
   if ($clsaltesextra->numrows > 0) {
     db_fieldsmemory($rsContaExtra, 0); 
   }
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
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr> 
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
 <center>
 <?
 include("forms/db_frmsaltes.php");
 ?>
 </center>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<?
if(isset($HTTP_POST_VARS["db_opcao"]) && $HTTP_POST_VARS["db_opcao"]=="Excluir"){
    if($clsaltes->erro_status=="0"){
        $clsaltes->erro(true,false);
    }else{
        $clsaltes->erro(true,true);
    }; 
};
if($db_opcao==33){
     echo "<script>document.form1.pesquisar.click();</script>";
}
?>
