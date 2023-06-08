<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2009  DBselller Servicos de Informatica             
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa e software livre; voce pode redistribui-lo e/ou     
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versao 2 da      
 *  Licenca como (a seu criterio) qualquer versao mais nova.          
 *                                                                    
 *  Este programa e distribuido na expectativa de ser util, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de              
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM           
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU     
 *  junto com este programa; se nao, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Copia da licenca no diretorio licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_orcreserva_classe.php");
include("dbforms/db_funcoes.php");
require("classes/db_orcdotacao_classe.php"); //classe da dotação
require("libs/db_liborcamento.php");      // funções do orçamento

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$clorcreserva = new cl_orcreserva;
$clorcdotacao = new cl_orcdotacao;  //instancia dotação

$db_botao = false;
$db_opcao = 33;
$op = 3;
$anular = true;

if((isset($HTTP_POST_VARS["db_opcao"]) && $HTTP_POST_VARS["db_opcao"])=="Anular"){
  if (strpos($o80_valor, ',') > 0) {
    $o80_valor = str_replace(',', '.', str_replace('.', '', $o80_valor));
  }
  if (strpos($o80_vlranu, ',') > 0) {
    $o80_vlranu = str_replace(',', '.', str_replace('.', '', $o80_vlranu));
  }

  $clorcreserva->o80_valor = $o80_valor-$o80_vlranu;
  $clorcreserva->o80_vlranu = $o80_vlranu;
  db_inicio_transacao();
  $db_opcao = 3;
  $clorcreserva->alterar($o80_codres);
  db_fim_transacao();
}else if(isset($chavepesquisa)){
   $db_opcao = 3;
   $result = $clorcreserva->sql_record($clorcreserva->sql_query_reservas($chavepesquisa)); 
   db_fieldsmemory($result,0);
   $db_botao = true;
}

$iMes = date("m",db_getsession("DB_datausu"));
$iAno = date("Y",db_getsession("DB_datausu"));
$iDia = date("d",db_getsession("DB_datausu"));
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<script>
  function dot() {
   //  document.form1.submit(); botao pesquisar dotação
  }
  function critica_form(){

    var obj = document.form1;

    var valor     = new Number(obj.o80_valor.value);
    var vlranu     = new Number(obj.o80_vlranu.value);
    var objData = new Date(<?=$iAno;?>,<?=$iMes-1?>,<?=$iDia?>);
    var dataini = new Date(obj.o80_dtini_ano.value,(obj.o80_dtini_mes.value - 1),obj.o80_dtini_dia.value);
    var dataanu = new Date(obj.o80_dtanu_ano.value,(obj.o80_dtanu_mes.value - 1),obj.o80_dtanu_dia.value);
    if ( vlranu > valor) {
      alert('Valor da Anulação não pode ser maior que o valor da Reserva. ');
    } else if ( document.form1.o80_vlranu.value > document.form1.o80_valor.value) {
      alert('Valor da Anulação não pode ser maior que o valor da Reserva. ');
    } else if ( dataanu.getTime() > objData.getTime()) {
      alert("Data Anulação maior que data do sistema. ");
    } else if ( dataanu.getTime() < dataini.getTime()) {
      alert("Data Anulação menor que data de início. ");
    } else {
      // cria imput com dados do botão 'inclui,altera,exclui
      var opcao = document.createElement("input");
      opcao.setAttribute("type","hidden");
      opcao.setAttribute("name","db_opcao");
      opcao.setAttribute("value",document.form1.db_opcao.value);
      document.form1.appendChild(opcao);
      document.form1.submit();
    }  
      
   }  
</script>
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
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
	<?
	include("forms/db_frmorcreserva.php");
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
<?
if((isset($HTTP_POST_VARS["db_opcao"]) && $HTTP_POST_VARS["db_opcao"])=="Excluir"){
  if($clorcreserva->erro_status=="0"){
    $clorcreserva->erro(true,false);
  }else{
    $clorcreserva->erro(true,true);
  };
};
if($db_opcao==33){
  echo "<script>document.form1.pesquisar.click();</script>";
}
echo "<script>document.form1.db_opcao.value='Anular'</script>";
?>