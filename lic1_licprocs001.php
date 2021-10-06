<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
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

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_solicitem_classe.php");
require_once("classes/db_liclicita_classe.php");
require_once("classes/db_pcproc_classe.php");
require_once("classes/db_pcparam_classe.php");
require_once("classes/db_empparametro_classe.php");
require_once("classes/db_liclicitem_classe.php");
require_once("classes/db_pcprocliberado_classe.php");
db_postmemory($HTTP_GET_VARS);
db_postmemory($HTTP_POST_VARS);
$clsolicitem = new cl_solicitem;
$clpcproc= new cl_pcproc;
$clpcparam = new cl_pcparam;
$clliclicitem = new cl_liclicitem;
$clliclicita = new cl_liclicita;
$clrotulo = new rotulocampo;
$clrotulo->label("pc10_numero");
$clrotulo->label("pc10_data");
$clrotulo->label("pc10_resumo");
$clrotulo->label("pc80_codproc");
$clrotulo->label("pc80_resumo");
$clrotulo->label("descrdepto");
$clrotulo->label("nome");
$clrotulo->label("l20_codigo");
$lRegistroPreco = false;
$result = $clliclicita->sql_record($clliclicita->sql_query($licitacao,"l08_altera, l20_usaregistropreco,  l20_formacontroleregistropreco, l20_datacria , l20_dataaber, l20_criterioadjudicacao, l20_codtipocom"));

$oLicitacao = db_utils::fieldsMemory($result, 0);  

$criterio = $oLicitacao->l20_criterioadjudicacao;
$codTipoLicitacao = $oLicitacao->l20_codtipocom; 

if ($clliclicita->numrows > 0) {

  db_fieldsmemory($result,0);
  if ($l20_usaregistropreco == "t") {
    $lRegistroPreco = true;
  }
}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script>
function js_submit(codproc){
	parent.itens.js_submit_form();
	parent.itens.document.form1.codproc.value=codproc;

	parent.itens.document.form1.submit();
	document.form1.submit();

	document.form1.codprocanu.selectedIndex = 0;

}

function js_liberaexclusao(value){
    parent.document.form1.excluir.disabled = (value ? false : true);
    parent.document.form1.codprocesso.value = value;

    document.form1.codproc.selectedIndex = 0;

    parent.itens.document.form1.codproc.value = '';
    parent.itens.document.form1.submit();

}
</script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="form1">
<center>
<table border="0" cellspacing="1" cellpadding="0" height='10%'>
<tr>
    <td align="right" nowrap title="<?=@$Tl20_codigo?>">
      <strong>Licitação : </strong>
    </td>
    <td nowrap>
    <?
           db_input('licitacao',10,$Il20_codigo,true,'text',3);
    ?>
    <input type="hidden" id="l20_criterioadjudicacao" name="l20_criterioadjudicacao" value="<?echo $criterio;?>">
    <input type="hidden" id="codTipoLicitacao" name="codTipoLicitacao" value="<?echo $codTipoLicitacao;?>">

    </td>
    <td><b>Processos de Compras:</b></td>
    <td>
    <?

        $result_liclicitem = $clliclicitem->sql_record($clliclicitem->sql_query(
                                           null,"distinct pc80_codproc",null,"l21_codliclicita = $licitacao"));
        if ($clliclicitem->numrows>0){
			echo"<select name='codprocanu' id='codprocanu' onchange='js_liberaexclusao(this.value)' ".($clliclicitem->numrows == 1 ? 'disabled' : '').">";
            for($count=0; $count < $clliclicitem->numrows; $count++){
                db_fieldsmemory($result_liclicitem, $count);
				echo " <option value = $pc80_codproc ".(($clliclicitem->numrows == 1 || $clliclicitem->numrows && !$count) ? "selected" : "")." >$pc80_codproc</option>\n";
				$ultimoProc = $pc80_codproc;
            }
            echo " </select>";

            echo "<script>";
            echo "parent.document.form1.excluir.disabled = false;";
            echo "parent.document.form1.codprocesso.value = document.getElementById('codprocanu').value;";
			echo "parent.document.form1.exportarcsv.disabled = false; ";
            echo "</script>";

        }else{
            echo "<script>";
			echo "parent.document.form1.exportarcsv.disabled = true; ";
			echo "</script>";

            echo "Nenhum Processo de Compra incluído.";
        }
    ?>
    </td>
  </tr>
  <tr>
     <td><b>Processo de Compra:</b></td>
    <td>

    <?

    $rsPcparam = $clpcparam->sql_record($clpcparam->sql_query_file(db_getsession("DB_instit"), "pc30_contrandsol"));
    db_fieldsmemory($rsPcparam, 0);
    $sWhere = "";
    if ($lRegistroPreco) {
      $sWhere  = " and pc10_solicitacaotipo = 6";
      $sWhere .= " and pc54_formacontrole   = {$l20_formacontroleregistropreco}";
    } else {
      $sWhere .= " and pc10_solicitacaotipo in(1,2)";
    }
    $sWhere .= " and pc80_situacao = 2";
    $sWhere .= " and not exists (select 1 ";
    $sWhere .= "                   from acordopcprocitem ";
    $sWhere .= "                        inner join acordoitem    on ac23_acordoitem    = ac20_sequencial";
    $sWhere .= "                        inner join acordoposicao on ac20_acordoposicao = ac26_sequencial";
    $sWhere .= "                        inner join acordo        on ac26_acordo        = ac16_sequencial";
    $sWhere .= "                  where ac23_pcprocitem = pc81_codprocitem ";
    $sWhere .= "                    and (ac16_acordosituacao  not in (2,3)))";
    $sWhere .= " and pc80_codproc in (select si01_processocompra from precoreferencia)";


    $clliclicita->sql_record($clliclicita->sql_query('', '*', '', "l20_codigo = $licitacao and pc50_pctipocompratribunal in (100,101,102,103)"));

    if ($clliclicita->numrows > 0) {

        $sWhere .= " and pc80_data <= '$l20_datacria' ";

    }else{
        $sWhere .= " and pc80_data <= '$l20_dataaber' ";
    }

    /**
     * Validação inserida no sql que retorna processos de compras no modulo licitação
     * @OC11589
     */
    $sWhere .= "and not EXISTS (SELECT *
         FROM liclicitem
         INNER JOIN pcprocitem ON pc81_codprocitem = l21_codpcprocitem
         WHERE pc81_codproc = pc80_codproc)";

    //aqui e removido processos com autorização de empenho geradas no compras.
    $sWhere .= "and not EXISTS (select 1 from empautitempcprocitem where e73_pcprocitem = pc81_codprocitem)";

    $sWhere .= " AND pc80_codproc not in (select si06_processocompra from adesaoregprecos) ";


	if (isset ($pc30_contrandsol) && $pc30_contrandsol == 't') {

	    $sSqlProc = $clpcproc->sql_query_soland(null, "distinct pc80_codproc",
	                                           "pc80_codproc",
	                                           "(e55_sequen is null or (e55_sequen is not null and e54_anulad is not null))
	                                             and pc43_depto = ".db_getsession('DB_coddepto')." {$sWhere}");

    } else {
      $sSqlProc = $clpcproc->sql_query_aut(null,
                                           "distinct pc80_codproc",
                                           "pc80_codproc",
                                           "(e55_sequen is null or (e55_sequen is not null and e54_anulad is not null))
                                             and pc10_instit = ".db_getsession("DB_instit")." {$sWhere}");
    }
    // echo $sSqlProc;
    $result_pcproc=$clpcproc->sql_record($sSqlProc);
    if (isset($codproc)&&$codproc!=""){
      $couni="codproc";
	  $$couni=$codproc;
    }else{
    	$nome="";
    	$descrdepto="";
    	$pc80_resumo="";
    	$pc80_data_dia="";
        $pc80_data_mes="";
        $pc80_data_ano="";
    }

	echo"<select name='codproc' id='codproc' onchange='js_submit(this.value);'>";
	echo "<option value=''></option>\n";
	for($y=0;$y<$clpcproc->numrows;$y++){
 	  db_fieldsmemory($result_pcproc,$y);
	  echo "<option value=$pc80_codproc ".(isset($couni)?($$couni==$pc80_codproc?"selected":""):"")." >$pc80_codproc</option>\n";
   	}
    echo " </select>";

    ?>
    </td>
    <?
    if (isset($codproc)&&$codproc!=""){

        /* Ocorrência 11933
         * Valida se o parâmetro Atesto de Controle Interno está marcado como SIM
         * e valida se o processo de compra está desbloqueada na rotina Controle Interno - Procedimentos - Atesto de Controle Interno
         */
        $clempparametro	    = new cl_empparametro;
        $bAtestoContInt     = db_utils::fieldsMemory($clempparametro->sql_record($clempparametro->sql_query(db_getsession("DB_anousu"), "e30_atestocontinterno", null, "")), 0)->e30_atestocontinterno;
        $clpcprocliberado = new cl_pcprocliberado();
        $clpcprocliberado->sql_record($clpcprocliberado->sql_query(null, "*", "", "e233_codproc = $codproc"));

        if ( $bAtestoContInt == 't' && $clpcprocliberado->numrows == 0 ) {

            echo "<script>";
            echo "  parent.itens.document.form1.codproc.value = '';";
            echo "  parent.itens.document.form1.submit();";
            echo "</script>";

            db_msgbox('Usuário: Este processo de compras ainda não recebeu o Atesto do Controle Interno. Aguarde a liberação para continuar com o processo!');

        } else {

            $result_pcproc = $clpcproc->sql_record($clpcproc->sql_query($codproc));
            db_fieldsmemory($result_pcproc, 0);

        }
    }
    ?>
    <td align="right" nowrap title="<?=@$Tnome?>">
      <strong>Usuário:</strong>
    </td>
    <td align="left" nowrap>
    <?
      db_input('nome',41,$Inome,true,'text',3);
    ?>
    </td>

  </tr>
  <tr>
    <td align="right" nowrap title="<?=@$Tpc80_data?>">
      <strong>Data: </strong>
    </td>
    <td align="left" nowrap>
    <?
      db_input('pc80_data_dia',2,0,true,'text',3);
      db_input('pc80_data_mes',2,0,true,'text',3);
      db_input('pc80_data_ano',4,0,true,'text',3);
    ?>
    </td>
    <td align="right" nowrap title="<?=@$Tdescrdepto?>">
      <strong>Departamento: </strong>
    </td>
    <td align="left" nowrap>
    <?
      db_input('descrdepto',41,$Idescrdepto,true,'text',3);
      db_input('pc80_criterioadjudicacao',41,$pc80_criterioadjudicacao,true,'hidden',3);
      echo "<script>";
            echo "parent.document.form1.criterioadj_item.value = document.getElementById('pc80_criterioadjudicacao').value;";
            echo "parent.document.form1.criterioadj_contrato.value = document.getElementById('l20_criterioadjudicacao').value;";
            echo "parent.document.form1.codTipoLicitacao.value = document.getElementById('codTipoLicitacao').value;";
      echo "</script>";

    ?>
    </td>
  </tr>
  <tr>
    <td align="right" nowrap title="<?=@$Tpc80_resumo?>">
      <strong>Resumo: </strong>
    </td>
    <td colspan="3" nowrap>
    <?
      db_textarea('pc80_resumo',2,73,$Ipc80_resumo,true,'text',3,"")
    ?>
    </td>
  </tr>
</table>
</center>
</form>
</body>
</html>
