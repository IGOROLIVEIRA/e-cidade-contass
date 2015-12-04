<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_solicita_classe.php");
include("classes/db_solicitatipo_classe.php");
include("classes/db_solicitem_classe.php");
include("classes/db_solicitempcmater_classe.php");
include("classes/db_solicitemunid_classe.php");
include("classes/db_pcorcamitemsol_classe.php");

$clsolicita         = new cl_solicita;
$clsolicitatipo     = new cl_solicitatipo;
$clsolicitem        = new cl_solicitem;
$clsolicitempcmater = new cl_solicitempcmater;
$clsolicitemunid    = new cl_solicitemunid;
$clpcorcamitemsol   = new cl_pcorcamitemsol;

$clsolicita->rotulo->label();
$clsolicitatipo->rotulo->label();
$clsolicitem->rotulo->label();
$clsolicitempcmater->rotulo->label();
$clsolicitemunid->rotulo->label();

db_postmemory($HTTP_GET_VARS);
db_postmemory($HTTP_POST_VARS);

$sair = true;
if(isset($pc10_numero) && trim($pc10_numero)!=""){
  $result_solicita = $clsolicita->sql_record($clsolicita->sql_query_tipo($pc10_numero,"pc12_tipo,pc50_descr,coddepto,descrdepto,id_usuario,nome,pc10_data,pc12_vlrap"));
  if($clsolicita->numrows>0){
    db_fieldsmemory($result_solicita,0);
    $sair = false;
  }else{
    $sair = true;
  }
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
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="100%" align="left" valign="top" bgcolor="#CCCCCC">
      <br><br>
      <center>
      <?
      if($sair==true){      	 
	    echo "<strong> Solicitação não encontrada.</strong>";
      }else if($sair==false){
      	echo "<table width='750' height='70%' border='0'>";
        echo "  <tr>";
       	echo "    <td colspan='4'><strong><font color='#333333' size='2'>Dados da solicitação $pc10_numero</font></strong></td>";
      	echo "  </tr>";
        echo "  <tr>";
       	echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Código do departamento:</td>";
       	echo "    <td colspan='1' width='15%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>$coddepto</strong></font></td>";
       	echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Descrição do departamento:</td>";
       	echo "    <td colspan='1' width='35%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>$descrdepto</strong></font></td>";
        echo "  </tr>";
        echo "  <tr>";
       	echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Usuário solicitante:</td>";
       	echo "    <td colspan='1' width='15%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>$id_usuario</strong></font></td>";
       	echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Nome do usuário solicitante:</td>";
       	echo "    <td colspan='1' width='35%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>$nome</strong></font></td>";
      	echo "  </tr>";
        echo "  <tr>";
       	echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Data de requisição:</td>";
       	echo "    <td colspan='1' width='15%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>".db_formatar($pc10_data,"d")."</strong></font></td>";
       	echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Valor total aproximado:</td>";
       	echo "    <td colspan='1' width='35%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>".db_formatar($pc12_vlrap,"f")."</strong></font></td>";
        echo "  </tr>";
	if(isset($pc12_tipo) && trim($pc12_tipo)!=""){
        echo "  <tr>";
       	echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Código do tipo de compra:</td>";
       	echo "    <td colspan='1' width='15%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>$pc12_tipo</strong></font></td>";
       	echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Descrição do de compra:</td>";
       	echo "    <td colspan='1' width='35%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>$pc50_descr</strong></font></td>";
        echo "  </tr>";
	}
	echo "</table>";
      	$result_itens = $clsolicitem->sql_record($clsolicitem->sql_query_file(null,"pc11_codigo","","pc11_numero=$pc10_numero"));
      	$numrows_itens = $clsolicitem->numrows;
	$Tarray = Array();
	$Tarray[0] = "Itens e dotações da solicitação";
	$Tarray[1] = "Orçamentos em que itens da solicitação estão incluídos";
	$Tarray[2] = "Processos de compras em que itens da solicitação estão incluídos";
	$Tarray[3] = "Orçamentos em que itens dos processos de compras estão incluídos";
	$Tarray[4] = "Processos de compras em autorizações de empenho";
	$Tarray[5] = "Pesquisar outra solicitação";
	if($numrows_itens>0){
	  echo "<table width='750' height='300' border='0'>";
	  echo "  <tr>";
	  echo "    <td width='20%' height='100%' >";
	  echo "      <table width='100%' height='60%' border='0'>";
	  echo "        <tr><td title='".$Tarray[0]."' align='center' nowrap bgcolor='#CCCCCC' style='cursor:hand'><a href='com3_consultaitens001.php?solicitacao=1&numero=$pc10_numero' target='iframeDetalhes'>Itens/Dotações</a></td></tr>";
	  echo "        <tr><td title='".$Tarray[1]."' align='center' nowrap bgcolor='#CCCCCC' style='cursor:hand'><a href='com3_consultaitens001.php?solicitacao=2&numero=$pc10_numero' target='iframeDetalhes'>Orçamentos de solicitações</a></td></tr>";
	  echo "        <tr><td title='".$Tarray[2]."' align='center' nowrap bgcolor='#CCCCCC' style='cursor:hand'><a href='com3_consultaitens001.php?solicitacao=3&numero=$pc10_numero' target='iframeDetalhes'>Processos de compras</a></td></tr>";
	  echo "        <tr><td title='".$Tarray[3]."' align='center' nowrap bgcolor='#CCCCCC' style='cursor:hand'><a href='com3_consultaitens001.php?solicitacao=4&numero=$pc10_numero' target='iframeDetalhes'>Orçamentos de processos</a></td></tr>";
	  echo "        <tr><td title='".$Tarray[4]."' align='center' nowrap bgcolor='#CCCCCC' style='cursor:hand'><a href='com3_consultaitens001.php?solicitacao=5&numero=$pc10_numero' target='iframeDetalhes'>Autorizações de empenho</a></td></tr>";
	  echo "        <tr><td title='".$Tarray[5]."' align='center' nowrap bgcolor='#CCCCCC' style='cursor:hand'><a href='com3_conssolic001.php' >Pesquisar solicitação</a></td></tr>";
	  echo "      </table>";
	  echo "    </td>";
	  echo "    <td width='80%' height='100%' >";
	  echo "      <iframe align='middle' height='100%' frameborder='0' marginheight='0' marginwidth='0' name='iframeDetalhes' width='100%'></iframe>";
	  echo "    </td>";
	  echo "  </tr>";
	  echo "</table>";
	}else{
	  echo "<table width='750' height='100' border='0'>";
	  echo "  <tr>";
	  echo "    <td align='center'><strong><font color='#333333' size='3'><BR><BR><BR>Solicitação sem itens lançados.</font></strong></td>";
	  echo "  </tr>";
	  echo "  <tr>";
	  echo "    <td title='".$Tarray[5]."' align='center' nowrap bgcolor='#CCCCCC' style='cursor:hand'><a href='com3_conssolic001.php'>Pesquisar outra solicitação</a></td>";
	  echo "  </tr>";
	  echo "</table>";
	}
      }      
      ?>
      </center>
    </td>
  </tr>
</table>
</body>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</html>
