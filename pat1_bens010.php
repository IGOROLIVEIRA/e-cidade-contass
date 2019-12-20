<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
require_once("libs/db_utils.php");

$lFormNovo          = false;
$sInicioDepreciacao = null;
$oDaoCfPatri        = db_utils::getDao("cfpatriinstituicao");
$sSqlPatri          = $oDaoCfPatri->sql_query_file(null,
                                                    "t59_dataimplanatacaodepreciacao",
                                                    null, "t59_instituicao = ".db_getsession("DB_instit")
                                                  );
$rsPatri            = $oDaoCfPatri->sql_record($sSqlPatri);
if ($oDaoCfPatri->numrows > 0) {
  $sInicioDepreciacao = db_utils::fieldsMemory($rsPatri, 0)->t59_dataimplanatacaodepreciacao;
}
if (!empty($sInicioDepreciacao)) {
  $lFormNovo      = true;
}
$clcriaabas     = new cl_criaabas;
$db_opcao       = 33;

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
	   $clcriaabas->identifica = array("bens"        => "Cadastro de bens",
	                                   "bensimoveis" => "Dados do imóvel",
	                                   "bensmater"   => "Dados do material",
                                     "bensfotos" => "Fotos"
	                                   );
	   if ($lFormNovo){
	     $clcriaabas->src = array("bens"=>"pat1_bens006.php");
	   } else {
	     $clcriaabas->src = array("bens"=>"pat1_bens006.php");
	   }
     $clcriaabas->title      =  array("bens"        => "Cadastrar bens",
                                      "bensimoveis" => "Ativar bem como imóvel",
                                      "bensmater"   => "Ativar bem como material",
                                      "bensfotos"   => "Fotos"
                                      );
     $clcriaabas->sizecampo  = array("bens"=>"20","bensimoveis"=>"20","bensmater"=>"20","bensfotos"=>"20");
	   $clcriaabas->disabled   =  array("bensimoveis"=>"true","bensmater"=>"true","bensfotos"=>"true");
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
  </html>
