<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_dividaconsolidada_classe.php");
require_once ("classes/db_cgm_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$cldividaconsolidada = new cl_dividaconsolidada;
$clcgm               = new cl_cgm;
$db_opcao = 1;
$db_botao = true;
$sqlerro==false;
if(isset($incluir)) {
  db_inicio_transacao();

  $result_dtcadcgm = db_query("select z09_datacadastro from historicocgm where z09_numcgm = {$z01_numcgm}");
  db_fieldsmemory($result_dtcadcgm, 0)->z09_datacadastro;
    $z09_datacadastro = (implode("/",(array_reverse(explode("-",$z09_datacadastro)))));
    if($sqlerro==false){
      if($si167_dtassinatura < $z09_datacadastro){
        db_msgbox("Usuário: A data de cadastro do CGM informado é superior a data do procedimento que está sendo realizado. Corrija a data de cadastro do CGM e tente novamente!");
        $sqlerro = true;
      }
    }
  if($sqlerro==false){
    $cldividaconsolidada->si167_numcgm = $z01_numcgm;
    $cldividaconsolidada->si167_justificativacancelamento = $si167_justificativacancelamento;
    $cldividaconsolidada->incluir(null);
  }
  db_fim_transacao();

} else if (isset($chavepesquisaimporta)) {

  $campos = "si167_nroleiautorizacao,si167_dtleiautorizacao,si167_dtpublicacaoleiautorizacao,si167_nrocontratodivida,si167_dtassinatura,si167_tipodocumentocredor,
  si167_nrodocumentocredor,si167_vlsaldoatual as si167_vlsaldoanterior,0 as si167_vlcontratacao,0 as si167_vlamortizacao,0 as si167_vlcancelamento,0 as si167_vlencampacao,
  0 as si167_vlatualizacao,0 as si167_vlsaldoatual,si167_contratodeclei,si167_objetocontratodivida,si167_especificacaocontratodivida,si167_tipolancamento,si167_subtipo,
  si167_numcgm as z01_numcgm,(select z01_nome from cgm where z01_numcgm = si167_numcgm) as z01_nome";
  $where = "si167_nroleiautorizacao = '" . $chavepesquisaimporta["si167_nroleiautorizacao"] . "'";
  $where .= " and si167_nrocontratodivida = '" . $chavepesquisaimporta["si167_nrocontratodivida"] . "'";
  $where .= " and si167_anoreferencia = " . $chavepesquisaimporta["si167_anoreferencia"];
  $where .= " and si167_mesreferencia = " . $chavepesquisaimporta["si167_mesreferencia"];
  $result = $cldividaconsolidada->sql_record($cldividaconsolidada->sql_query(null, $campos, null, $where));
  db_fieldsmemory($result, 0);

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
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr> 
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
	<?
	include("forms/db_frmdividaconsolidada.php");
	?>
    </center>
	</td>
  </tr>
</table>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
js_tabulacaoforms("form1","si167_nroleiautorizacao",true,1,"si167_nroleiautorizacao",true);
</script>
<?
if(isset($incluir)){
  if($cldividaconsolidada->erro_status=="0"){
    $cldividaconsolidada->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($cldividaconsolidada->erro_campo!=""){
      echo "<script> document.form1.".$cldividaconsolidada->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$cldividaconsolidada->erro_campo.".focus();</script>";
    }
  }else{
    $cldividaconsolidada->erro(true,true);
  }
}
?>
