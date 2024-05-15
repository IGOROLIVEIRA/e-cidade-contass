<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBseller Servicos de Informatica
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

use App\Services\Tributario\Itbi\InscricaoDividaAtivaItbiService;

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("classes/db_tabrec_classe.php");
require_once("classes/db_proced_classe.php");
require_once("classes/db_arrecad_classe.php");
require_once("classes/db_arrematric_classe.php");
require_once("classes/db_arreinscr_classe.php");
require_once("classes/db_arreold_classe.php");
require_once("classes/db_divida_classe.php");
require_once("classes/db_divold_classe.php");
require_once("classes/db_divmatric_classe.php");
require_once("classes/db_divimporta_classe.php");
require_once("classes/db_divimportareg_classe.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_utils.php");
require_once("classes/db_arrecadcompos_classe.php");
require_once("classes/db_arreckey_classe.php");
require_once("classes/db_dividaprotprocesso_classe.php");
require_once "app/Services/Tributario/Itbi/InscricaoDividaAtivaItbiService.php";

db_postmemory($_POST);
db_postmemory($_GET);

$oPost            = db_utils::postMemory($_POST);
$oGet             = db_utils::postMemory($_GET);
$oProcesso        = db_getsession("oDadosProcesso");

$lProcessoSistema = (int)$oProcesso->lProcessoSistema;
$iProcesso        = $oProcesso->iProcesso;
$sTitular         = $oProcesso->sTitular;
$dDataProcesso    = $oProcesso->dDataProcesso;

$cltabrec               = new cl_tabrec;
$clarrecad              = new cl_arrecad;
$clarrematric           = new cl_arrematric;
$clarreinscr            = new cl_arreinscr;
$clarreold              = new cl_arreold;
$clproced               = new cl_proced;
$cldivida               = new cl_divida;
$cldivold               = new cl_divold;
$cldivmatric            = new cl_divmatric;
$cldivimporta           = new cl_divimporta;
$cldivimportareg        = new cl_divimportareg;
$clarrecadcompos        = new cl_arrecadcompos;
$clarreckey             = new cl_arreckey;
$oDaoDividaprotprocesso = new cl_dividaprotprocesso;

$teste                  = false;
$where                  = "";
$where2                 = "";
$subselect              = "";
$and                    = "";
$xnumpre                = "";
$xnumpre2               = "";
$vir                    = "";
$order_k00_numpar       = "";
$hoje                   = $datavenc;
?>
<html lang="">
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body class="body-default">
<table width="100%" height="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="100%" width="100%" align="center" valign="top">
      <center>
      <form name="form1" method="post" action="">
      <table height="100%" width="100%"  border="0" cellspacing="5" cellpadding="0">
	    </td>
	    <td align="center">
            <?php


if (isset ($procreg) && $procreg != "") {
	db_criatermometro('termometro', 'Concluido...', 'blue', 1);
}
?>
	    </td>
          <?php


$wherereceita = "";

if (isset ($chave_origem) && trim($chave_origem) != "") {

    $oItbiDivida = db_utils::getDao('itbi_divida');
    $sql = $oItbiDivida->sql_query_vencidos($hoje);

	$result0  = $cltabrec->sql_record($sql);
	$numrows0 = $cltabrec->numrows;
	if ($numrows0 == 0) {

		echo "<script>parent.document.getElementById('process').style.visibility='hidden';</script>";
		echo "<script>
		            parent.document.form1.gerar.disabled=true;
                alert('Nenhum tipo de débito encontrado com este código!');
		          </script>";
    echo "<script>top.corpo.db_iframe.hide();</script>";
		echo "<script>top.corpo.location.href='itb1_inscrdivida001.php'</script>";

	}
	$sql1     = " select v03_codigo, v03_descr, tabrec.k02_codigo, tabrec.k02_drecei ";
	$sql1    .= "   from proced ";
	$sql1    .= "       inner join tabrec on k02_codigo = v03_receit ";
	$sql1    .= "       inner join paritbi on it24_proced = v03_codigo ";
	$sql1    .= "    and v03_instit = ".db_getsession('DB_instit');
	$sql1    .= "    and it24_anousu = ".db_getsession('DB_anousu');

	$result1  = $clproced->sql_record($sql1);
	$numrows1 = $clproced->numrows;
    if (!isset ($procreg)) {

        echo "<div id='filtro' style='visibility:visible'>";

        echo "<tr>
		  	    <td nowrap align='center' valign='top'><strong> Receita </strong>     </td>
	          <td nowrap align='center' valign='top'><strong> Descrição </strong>   </td>
	          <td nowrap align='center' valign='top'><strong> Procedência </strong> </td>
			      <td nowrap align='center' valign='top'><strong> Regist </strong>      </td>
		      </tr> ";

        db_fieldsmemory($result1, 0);

        echo "
			    <tr>
			      <td nowrap align='left' valign='top'>";
        db_input("$k02_codigo", "8", "", true, "text", 3, "", "k02_codigo");
        echo "</td>
		                <td nowrap> ";
        db_input("$k02_drecei", 40, "", true, "text", 3, "", "k02_drecei");
        echo " </td> ";
        echo " <td>
			           <select name=\"v03_descr\" onchange=\"js_troca();\" id=\"v03_descr\">
	               <option value=\"0\" >Escolha uma procedência</option>
			         ";
        echo " <option value=\"$v03_codigo\" >$v03_codigo - $v03_descr</option>";
        echo " </select>
			      </td>
			      <td nowrap align='left' valign='top'>";
        $contrec = $numrows0;
        db_input("$contrec", "10", "", true, "text", 3, "", "contrec");

        echo "<tr>
		          <td nowrap align='center' valign='top'><strong>  </strong>                    </td>
		          <td nowrap align='center' valign='top'><strong>  </strong>                    </td>
		          <td nowrap align='right'  valign='top'><strong>Total de registros : </strong> </td>
		          <td nowrap align='left'   valign='top'><strong>$numrows0 </strong>          </td>
		        </tr> ";
        echo "</div>";
    }

	db_input("chave_origem", 40, "0", true, "hidden", 3);
	db_input("cod_k02_codigo", 40, "0", true, "hidden", 3);
	db_input("cod_v03_codigo", 40, "0", true, "hidden", 3);
	db_input("procreg", 40, "0", true, "hidden", 3);
	db_input("codreceita", 40, "0", true, "hidden", 3);
	db_input("tipodata", 40, "0", true, "hidden", 3);

	echo "<script>parent.document.getElementById('process').style.visibility='hidden';</script>";
}
?>
      </table>
      </form>
      </center>
    </td>
  </tr>
</table>
</body>
</html>
<script type="text/javascript">
function js_controladata(val){

   if(val !== 3){
      document.getElementById('divdataoper').style.visibility='hidden';
   }else{
      document.getElementById('divdataoper').style.visibility='visible';
   }
}
function js_troca(){

  let vir       = '';
  let pass      = 'f';
  let codigo    = '';
  let codreceit = '';
  let cont      = 0;
  for (i = 0; i < document.form1.length; i++) {

    if (document.form1.elements[i].type === "select-one") {

      if (document.form1.elements[i].value !==0 && document.form1.elements[i].name !== 'dtop') {

        codigo    += vir+document.form1.elements[i].value;
        codreceit += vir+document.form1.elements[i-2].value;
        vir        =',';
        pass       = 't';
      } else {
	      cont++;
      }
    }
  }
  parent.document.form1.gerar.disabled = pass !== 't';
  document.form1.cod_v03_codigo.value = codigo;
  document.form1.codreceita.value     = codreceit;
}
</script>
<?php
$erro_msg = "";
if (isset ($procreg) && $procreg == 't') {
    db_inicio_transacao();
    $sqlerro = false;
    $oService = new InscricaoDividaAtivaItbiService();

    try {
        db_atutermometro(50,100,'termometro');
        $oDateTime = new DateTime($hoje);
        $oService->execute($oDateTime);
        $erro_msg = "Procedimento executado com sucesso!";
    } catch (Exception $ex) {
        $sqlerro = true;
        $erro_msg = $ex->getMessage();
    }
    db_atutermometro(100,100,'termometro');

    echo "<script>document.getElementById('filtro').style.visibility='hidden';</script>";

    $chave_origem = "";

    db_fim_transacao($sqlerro);
}


if ($erro_msg != "") {

    echo "<script>parent.document.getElementById('process').style.visibility='hidden';</script>";
    db_msgbox($erro_msg);
    echo "<script>top.corpo.db_iframe.hide();</script>";
    echo "<script>top.corpo.location.href='itb1_inscrdivida001.php'</script>";
}
