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
include("dbforms/db_funcoes.php");
include("classes/db_bens_classe.php");
include("classes/db_bemfoto_classe.php");
include("classes/db_clabens_classe.php");
include("classes/db_bensmater_classe.php");
include("classes/db_bensimoveis_classe.php");
include("classes/db_bensbaix_classe.php");
include("dbforms/db_classesgenericas.php");
include("classes/db_bensplaca_classe.php");
include("classes/db_departdiv_classe.php");
include("classes/db_histbemdiv_classe.php");
include("classes/db_histbem_classe.php");
include("classes/db_histbemtrans_classe.php");
include("classes/db_bensdiv_classe.php");
include("classes/db_cfpatri_classe.php");
include("classes/db_cfpatriplaca_classe.php");
include("classes/db_benslote_classe.php");
include("classes/db_bensmarca_classe.php");
include("classes/db_bensmedida_classe.php");
include("classes/db_bensmodelo_classe.php");
include("classes/db_benscedente_classe.php");
include("classes/db_conlancambem_classe.php");
include("classes/db_bensdepreciacao_classe.php");
include("classes/db_bensmaterialempempenho_classe.php");
include("classes/db_bensempnotaitem_classe.php");


$clbensmaterialempempenho = new cl_bensmaterialempempenho;
$clhistbem                = new cl_histbem;
$clbensdepreciacao        = new cl_bensdepreciacao;
$clconlancambem           = new cl_conlancambem;
$clbenscedente            = new cl_benscedente;
$cldepartdiv              = new cl_departdiv;
$cldb_estrut              = new cl_db_estrut;
$clbens                   = new cl_bens;
$clbemfoto                = new cl_bemfoto;
$clbensmater              = new cl_bensmater;
$clbensimoveis            = new cl_bensimoveis;
$clclabens                = new cl_clabens;
$clbensbaix               = new cl_bensbaix;
$clbensplaca              = new cl_bensplaca;
$clhistbemdiv             = new cl_histbemdiv;
$clhistbemtrans           = new cl_histbemtrans;
$clbensdiv                = new cl_bensdiv;
$clcfpatri                = new cl_cfpatri;
$clcfpatriplaca           = new cl_cfpatriplaca;
$clbenslote               = new cl_benslote;
$clbensmarca              = new cl_bensmarca;
$clbensmedida             = new cl_bensmedida;
$clbensmodelo             = new cl_bensmodelo;
$clbensempnotaitem        = new cl_bensempnotaitem;
db_postmemory($HTTP_POST_VARS);
$db_opcao = 33;
$db_botao = false;
if(isset($excluir)){
  $sqlerro=false;
  db_inicio_transacao();

    $clbensplaca->excluir('',"t41_bem = $t52_bem");
    if ($clbensplaca->erro_status == 0) {
    	$sqlerro=true;
    	$erro_msg = $clbensplaca->erro_msg;
    }
    if ($sqlerro == false) {
      $clbensmaterialempempenho->excluir('',"t11_bensmaterial = $t52_bem");
      if ($clbensmaterialempempenho->erro_status == 0) {
    	  $sqlerro=true;
    	  $erro_msg = $clbensmaterialempempenho->erro_msg;
      }
    }
    if ($sqlerro == false) {
      $clbensdepreciacao->excluir('',"t44_bens = $t52_bem");
      if ($clbensdepreciacao->erro_status == 0) {
    	  $sqlerro=true;
    	  $erro_msg = $clbensdepreciacao->erro_msg;
      }
    }
    if ($sqlerro == false) {
      $clbensempnotaitem->excluir('',"e136_bens = $t52_bem");
      if ($clbensempnotaitem->erro_status == 0) {
    	  $sqlerro=true;
    	  $erro_msg = $clbensempnotaitem->erro_msg;
      }
    }
    if ($sqlerro == false) {
      $clbenslote->excluir('',"t43_bem = $t52_bem");
      if ($clbenslote->erro_status == 0) {
    	  $sqlerro=true;
    	  $erro_msg = $clbenslote->erro_msg;
      }
    }
    if ($sqlerro == false) {
      $clbensmater->excluir('',"t53_codbem = $t52_bem");
      if ($clbensmater->erro_status == 0) {
    	  $sqlerro=true;
    	  $erro_msg = $clbensmater->erro_msg;
      }
    }
    if ($sqlerro == false) {
      $clhistbem->excluir('',"t56_codbem = $t52_bem");
      if ($clhistbem->erro_status == 0) {
    	  $sqlerro=true;
    	  $erro_msg = $clhistbem->erro_msg;
      }
    }
    if ($sqlerro == false) {
      $clbenscedente->excluir('',"t09_bem = $t52_bem");
      if ($clbenscedente->erro_status == 0) {
    	  $sqlerro=true;
    	  $erro_msg = $clbenscedente->erro_msg;
      }
    }
    if ($sqlerro == false) {
      $clconlancambem->excluir('',"c110_bem = $t52_bem");
      if ($clconlancambem->erro_status == 0) {
    	  $sqlerro=true;
    	  $erro_msg = $clconlancambem->erro_msg;
      }
    }
    if ($sqlerro == false) {
      $clbens->excluir('',"t52_bem = $t52_bem");
      if ($clbens->erro_status == 0) {
    	  $sqlerro=true;
    	  $erro_msg = $clbens->erro_msg;
      }
    }
    if ($sqlerro == false) {
        $clbemfoto->excluir('', "t54_numbem = $t52_bem");
        if ($clbemfoto->erro_status == 0) {
            $sqlerro=true;
            $erro_msg = $clbemfoto->erro_msg;
        }
    }

  db_fim_transacao($sqlerro);

  if($sqlerro == true){
    $erro_msg = 'Erro ao excluir bem: '.$erro_msg;
  }else{
    $erro_msg = 'Bem excluido com sucesso';
  }

  $db_opcao = 3;
  $db_botao = true;

}else if(isset($chavepesquisa)){
   $db_opcao = 3;
   $db_botao = true;
   $result = $clbens->sql_record($clbens->sql_query($chavepesquisa));
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
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
    <center>
	<?
	include("forms/db_frmbens.php");
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
    if($clbens->erro_campo!=""){
      echo "<script> document.form1.".$clbens->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clbens->erro_campo.".focus();</script>";
    };
  }else{
   db_msgbox($erro_msg);
   db_redireciona('pat1_bens006.php');
  }
}
if(isset($chavepesquisa)){
 echo "
  <script>
      function js_db_libera(){
         parent.document.formaba.bensimoveis.disabled=false;
         CurrentWindow.corpo.iframe_bensimoveis.location.href='pat1_bensimoveis001.php?db_opcaoal=33&t54_codbem=".@$t52_bem."';
         parent.document.formaba.bensmater.disabled=false;
         CurrentWindow.corpo.iframe_bensmater.location.href='pat1_bensmater001.php?db_opcaoal=33&t53_codbem=".@$t52_bem."';
         parent.document.formaba.bensfotos.disabled=false;
         CurrentWindow.corpo.iframe_bensfotos.location.href='pat1_cadgeralfotos001.php?db_opcaoal=33&t52_codbem=".@$t52_bem."';
     ";
         if(isset($liberaaba)){
           echo "  parent.mo_camada('bensimoveis');";
         }
 echo"}\n
    js_db_libera();
  </script>\n
 ";
}
 if($db_opcao==22||$db_opcao==33){
    echo "<script>document.form1.pesquisar.click();</script>";
 }
?>
