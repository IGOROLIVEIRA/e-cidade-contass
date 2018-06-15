<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
$clcriaabas     = new cl_criaabas;
$db_opcao = 3;
?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
  <table width="790" height="18"  border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
    <tr>
      <td width="360">&nbsp;</td>
      <td width="263">&nbsp;</td>
      <td width="25">&nbsp;</td>
      <td width="140">&nbsp;</td>
    </tr>
  </table>
  <table valign="top" marginwidth="0" width="790" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
       <?
       $clcriaabas->identifica = array(

        "dadoscomplementares"=>"Dados Complementares à LRF",
        "operacoesdecredito"=>"Operações de Crédito",
        "publicacaoeperiodicidaderreo"=>"Publicação e Periodicidade RREO",
        "publicacaoeperiodicidadergf"=>"Publicação e Periodicidade RGF",

        );

       $clcriaabas->src = array(

        "dadoscomplementares"=>"sic1_dadoscomplementares001.php?db_opcao=3",
        "operacoesdecredito"=>"sic1_operacoesdecredito001.php?db_opcao=3",
        "publicacaoeperiodicidaderreo"=>"sic1_publicacaoeperiodicidaderreo001.php?db_opcao=3",
        "publicacaoeperiodicidadergf"=>"sic1_publicacaoeperiodicidadergf001.php?db_opcao=3",

        );

       $clcriaabas->sizecampo = array(

        "dadoscomplementares"=>"35",
        "operacoesdecredito"=>"20",
        "publicacaoeperiodicidaderreo"=>"40",
        "publicacaoeperiodicidadergf"=>"40",

        );
       if(db_getsession('DB_instit') == 1){
         $clcriaabas->disabled   =  array(
          "dadoscomplementares"=>"false",
          "operacoesdecredito"=>"false",
          "publicacaoeperiodicidaderreo"=>"false",
          "publicacaoeperiodicidadergf"=>"false"

          );
       }else{
         $clcriaabas->disabled   =  array(
          "dadoscomplementares"=>"false",
          "operacoesdecredito"=>"true",
          "publicacaoeperiodicidaderreo"=>"true",
          "publicacaoeperiodicidadergf"=>"false"
          );
       }
       $clcriaabas->cria_abas();
       ?>
     </td>
   </tr>
 </table>
 <form name="form1">
 </form>
 <?
 db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
 ?>
</body>
<script type="text/javascript">

  var dadoscomplementares = new Object();
  var operacoesdecredito = new Object();
  var publicacaoeperiodicidaderreo = new Object();
  var publicacaoeperiodicidadergf = new Object();


</script>
</html>
