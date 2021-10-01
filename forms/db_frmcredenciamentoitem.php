<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2013  DBselller Servicos de Informatica
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

//MODULO: empenho
require_once("classes/db_empparametro_classe.php");
require_once("dbforms/db_classesgenericas.php");
require_once("classes/db_pcmaterele_classe.php");
require_once("classes/db_empautitem_classe.php");
require_once("classes/db_credenciamentotermo_classe.php");

$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clempparametro         = new cl_empparametro;
$clpctabelaitem         = new cl_pctabelaitem;
$clpcmaterele           = new cl_pcmaterele;
$clempautitem           = new cl_empautitem;
$clcredenciamentotermo  = new cl_credenciamentotermo;

$clempautitem->rotulo->label();
$clrotulo = new rotulocampo;
//solicitemunid
$clrotulo->label("pc17_unid");
$clrotulo->label("e54_anousu");
$clrotulo->label("o56_elemento");
$clrotulo->label("pc01_descrmater");


if(!empty($e55_autori)) {

    $sCampos  = " distinct l21_ordem, l21_codigo, pc81_codprocitem, pc11_seq, pc11_codigo, pc11_quant, si02_vlprecoreferencia, ";

    $sWhere   = "l21_codliclicita = {$l20_codigo} ";
    $sSqlItemLicitacao = $clliclicitem->sql_query_inf(null, $sCampos, $sOrdem, $sWhere);
    $sResultitens = $clliclicitem->sql_record($sSqlItemLicitacao);
    $aItensLicitacao = db_utils::getCollectionByRecord($sResultitens);
    $numrows = $clliclicitem->numrows;
    if ($numrows > 0) {
        $sWhere   = "l21_codliclicita = {$l20_codigo} and l205_fornecedor = {$l205_fornecedor} and l205_licitacao = {$l20_codigo}";
        $sql     = $clcredenciamento->itensCredenciados(null, $sCampos, $sOrdem, $sWhere);
        $result  = $clcredenciamento->sql_record($sql);
        $numrows = $clcredenciamento->numrows;
    }
}
?>


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.css" />
<script type="text/javascript" src="scripts/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.js"></script>
<form name="form1" method="post" action="">
    <center>
        <table class="DBgrid">
            <tr>
                <th class="table_header">M</th>
                <th class="table_header">Ordem</th>
                <th class="table_header">Item</th>
                <th class="table_header">Descrição item</th>
                <th class="table_header">Unidade</th>
                <th class="table_header">Quantidade Disponivel</th>
                <th class="table_header">Vl. Unitaário</th>
                <th class="table_header">Quantidade Solicitada</th>
                <th class="table_header">Vl. Total</th>
            </tr>
        </table>
        <br />
        <input name="e54_desconto" type="hidden" id="e54_desconto" value="<?php echo $e54_desconto ?>">
        <input name="Salvar" type="button" id="salvar" value="Salvar" onclick="js_salvar();">
        <input name="Excluir" type="button" id="excluir" value="Excluir" onclick="js_excluir();">
    </center>
</form>
<script>


</script>
