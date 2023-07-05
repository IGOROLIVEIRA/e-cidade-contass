<?PHP
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

require_once(__DIR__ . "/../libs/db_stdlib.php");
require_once(__DIR__ . "/../libs/db_utils.php");
require_once(__DIR__ . "/../libs/db_conecta.php");
include_once(__DIR__ . "/../libs/db_sessoes.php");
require_once(__DIR__ . "/../std/label/rotulocampo.php");
require_once(__DIR__ . "/../std/label/RotuloCampoDB.php");
require_once(__DIR__ . "/../std/label/RotuloDB.php");
require_once(__DIR__ . "/../std/label/rotulo.php");
include_once(__DIR__ . "/../libs/db_usuariosonline.php");
include_once(__DIR__ . "/../classes/db_matordem_classe.php");
include_once(__DIR__ . "/../classes/db_matordemitem_classe.php");
include_once(__DIR__ . "/../classes/db_matestoqueitemoc_classe.php");
include_once(__DIR__ . "/../classes/db_empempitem_classe.php");
include_once(__DIR__ . "../classes/db_empordemtabela_classe.php");
include_once(__DIR__ . "/../dbforms/db_funcoes.php");

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$clmatordemitem = new cl_matordemitem;
$clempordemtabela = new cl_empordemtabela;
$clmatestoqueitemoc = new cl_matestoqueitemoc;
$clmatordem = new cl_matordem;
$clempempitem = new cl_empempitem;
$clrotulo = new rotulocampo;

$clmatordemitem->rotulo->label();
$clmatordem->rotulo->label();

$clrotulo->label("e62_item");
$clrotulo->label("e60_numemp");
$clrotulo->label("e60_codemp");
$clrotulo->label("pc01_descrmater");
$clrotulo->label("e62_descr");

?>

<html>

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="../scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="../scripts/strings.js"></script>
    <script language="JavaScript" type="text/javascript" src="../scripts/prototype.js"></script>
    <link href="../estilos.css" rel="stylesheet" type="text/css">
    <link href="../estilos/grid.style.css" rel="stylesheet" type="text/css">

    <style>
        <? $cor = "#999999" ?>.bordas {
            border: 2px solid #cccccc;
            border-top-color: <?= $cor ?>;
            border-right-color: <?= $cor ?>;
            border-bottom-color: <?= $cor ?>;
            background-color: #999999;
        }

        <? $cor = "999999" ?>.bordas_corp {
            border: 1px solid #cccccc;
            border-right-color: <?= $cor ?>;
            border-bottom-color: <?= $cor ?>;
        }

        .input__static {
            text-align: center;
            background: none;
            border: none;
            color: #000;
            width: 55px;
        }
    </style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <table border="0" cellspacing="0" cellpadding="0" width='100%'>
        <tr>
            <td align="left" valign="top" bgcolor="#CCCCCC">
                <form name='form1'>
                    <center>
                        <fieldset>
                            <legend>
                                <b>Itens</b>
                            </legend>
                            <table style='border:2px inset white' width='100%' cellspacing='0'>
                            <tr id='tabela'>
                 
                    <b>Para detalhamento dos itens da tabela clique sobre a descrição do item.</b>
                 
                </tr>
                                <?

                                if (isset($m51_codordem) && $m51_codordem != "") {

                                    $resultItem = $clmatordemitem->sql_record($clmatordemitem->sql_query(null, "*", "", "m52_codordem=$m51_codordem"));

                                    $iNumEmpenho = db_utils::fieldsMemory($resultItem, 0)->m52_numemp;
                                    $sSql = $clempempitem->sql_query('', '', '*', '', 'e62_numemp = ' . $iNumEmpenho);
                                    $rsSql = $clempempitem->sql_record($sSql);
                                    $numrows = $clempempitem->numrows;
                                    
                                    if ($numrows > 0) {

                                        echo "   <tr class='bordas'>";
                                        echo "     <td class='table_header' title='Marca/desmarca todos' align='center'>";
                                        echo "        <input type='checkbox'  style='display:none' id='mtodos' onclick='js_marca(false)'>";
                                        echo "            <a onclick='js_marca(true)' style='cursor:pointer'><b>M</b></a>";
                                        echo "     </td>";
                                        echo "     <td class='table_header' align='center'><small><b>Seq.</b></small></td>";
                                        echo "     <td class='table_header' align='center'><small><b>N. Empenho</b></small></td>";
                                        echo "     <td class='table_header' align='center'><small><b>Seq. Empenho</b></small></td>";
                                        echo "     <td class='table_header' align='center'><small><b>Cod. Item</b></small></td>";
                                        echo "     <td class='table_header' align='center'><small><b>Item</b></small></td>";
                                        echo "     <td class='table_header' align='center'><small><b>Unid.</b></small></td>";
                                        echo "     <td class='table_header' align='center'><small><b>Quantidade</b></small></td>";
                                        echo "     <td class='table_header' align='center'><small><b>Vlr. Uni.</b></small></td>";
                                        echo "     <td class='table_header' align='center'><small><b>Valor Total</b></small></td>";
                                        echo "     <td class='table_header' align='center'><small><b>Quantidade</b></small></td>";
                                        echo "     <td class='table_header' align='center'><small><b>Valor</b></small></td>";
                                        echo "   </tr>";
                                        echo " <tbody id='dados' style='height:150px;width:95%;overflow:scroll;overflow-x:hidden;background-color:white'>";
                                    } else {

                                        echo " <tr>";
                                        echo "	<b>Nenhum registro encontrado...</b>";
                                        echo " </tr>";
                                    }

                                    for ($i = 0; $i < $numrows; $i++) {

                                        db_fieldsmemory($rsSql, $i);

                                        $sqlItem = $clmatordemitem->sql_query_anulado(
                                            '',
                                            'm52_codordem, m52_quant, m52_valor, m53_codordem',
                                            '',
                                            'm52_numemp = ' . $e62_numemp . ' and m52_sequen = ' . $e62_sequen
                                        );
                                        $rsItem = $clmatordemitem->sql_record($sqlItem);
                                        $valorLancado = $quantLancada = 0;

                                        $libera_registro = false;
                                        $ordemPrincipal  = '';
                                        for ($count = 0; $count < pg_num_rows($rsItem); $count++) {
                                            $oItem = db_utils::fieldsMemory($rsItem, $count);

                                            $valorLancado += floatval($oItem->m52_valor);
                                            $quantLancada += floatval($oItem->m52_quant);

                                            if ($oItem->m53_codordem) {
                                                $valorLancado -= floatval($oItem->m52_valor);
                                                $quantLancada -= floatval($oItem->m52_quant);
                                            }

                                            if ($oItem->m52_codordem == $m51_codordem) {
                                                $libera_registro = true;
                                            }
                                        }

                                        $marcaLinha = $opcao == 1 ? '' : 'marcado';

                                        $sqlItem = $clmatordemitem->sql_query_anulado(
                                            '',
                                            'm52_codordem, m52_quant, m52_valor',
                                            '',
                                            'm52_numemp = ' . $e62_numemp . ' and m52_sequen = ' . $e62_sequen .
                                                ' and m52_codordem = ' . $m51_codordem
                                        );
                                        $rsItem = $clmatordemitem->sql_record($sqlItem);
                                        $oItemValores = db_utils::fieldsMemory($rsItem, 0);

                                        if (($quantLancada == $e62_quant && $valorLancado == $e62_vltot) && !$libera_registro) {
                                            $disabled = 'disabled';
                                            $marcaLinha = 'marcado';
                                            $opcao = 3;
                                        } else {
                                            $disabled = '';
                                            $marcaLinha = '';
                                            $opcao = 1;
                                        }

                                        if ($pc01_servico == 't' && $e62_servicoquantidade == 'f' && floatval($oItemValores->m52_valor) == floatval($e62_vltot)) {
                                            $disabled = '';
                                            $marcaLinha = '';
                                            $opcao = 1;
                                        } elseif ((floatval($e62_vltot) - floatval($valorLancado)) == 0 && !$oItemValores->m52_valor) {
                                            $disabled = 'disabled';
                                            $marcaLinha = 'marcado';
                                            $opcao = 3;
                                        }

                                        $sSqlEntrada = $clmatestoqueitemoc->sql_query(
                                            null,
                                            null,
                                            "*",
                                            null,
                                            'm52_numemp = ' . $e62_numemp . ' and m52_codordem = ' . $m51_codordem . 'and m73_cancelado is false'
                                        );

                                        $result2 = $clmatestoqueitemoc->sql_record($sSqlEntrada);

                                        $ordemAutomatica = false;
                                        $obsOrdem = db_utils::fieldsMemory($resultItem, 0)->m51_obs;
                                        $compareObs = strcmp(strtolower(trim($obsOrdem)), strtolower('ordem de compra automatica'));
                                        if (!$compareObs || pg_num_rows($result2)) {
                                            $sChecked = 'checked';
                                            $disabled = 'disabled';
                                            $marcaLinha = 'marcado';
                                            $opcao = 3;
                                            $ordemAutomatica = true;
                                        }

                                        $sqlItem = $clmatordemitem->sql_query(
                                            '',
                                            '*',
                                            '',
                                            'm52_numemp = ' . $e62_numemp . ' and m52_sequen = ' . $e62_sequen .
                                                ' and m52_codordem = ' . $m51_codordem
                                        );
                                        $rsItem = $clmatordemitem->sql_record($sqlItem);

                                        $oItemOrdem = db_utils::fieldsMemory($rsItem, 0);

                                        $sSQLacordo = "select
                                            distinct ac26_acordo
                                        from
                                            acordoposicao
                                        inner join acordoitem on
                                            ac20_acordoposicao = ac26_sequencial
                                        inner join acordoitemexecutado on
                                            ac20_sequencial = ac29_acordoitem
                                        inner join acordoitemexecutadoempautitem on
                                            ac29_sequencial = ac19_acordoitemexecutado
                                        inner join empautitem on
                                            e55_sequen = ac19_sequen
                                            and ac19_autori = e55_autori
                                        inner join empautoriza on
                                            e54_autori = e55_autori
                                        left join empempaut on
                                            e61_autori = e54_autori
                                        left join empempenho on
                                            e61_numemp = e60_numemp
                                        where
                                            e60_numemp = {$e60_numemp}";
                                            $resultAcordo   = db_query($sSQLacordo);

                                            $numrowAcordo  = pg_num_rows($resultAcordo);

                                            db_fieldsmemory($resultAcordo, 0);
                                            $pc01_tabela = 0;
                                            
                                                $sSQLtabela = "select case when pc01_tabela = false then 0 else 1 end as pc01_tabela from pcmater where pc01_codmater = {$e62_item}";
                                                $resultTabela   = db_query($sSQLtabela);
                                                db_fieldsmemory($resultTabela, 0);
                                              

                                        if ($clmatestoqueitemoc->numrows == 0) {

                                            echo "<tr id='tr_$e62_sequencial' class='$marcaLinha'>
                                                    <td class='linhagrid' title='Inverte a marcação' align='center'>
                                                        <input type='checkbox' {$sChecked} {$disabled} id='chk{$e62_sequencial}' class='itensEmpenho'
                                                            name='itensOrdem[]' value='{$e62_sequencial}' onclick='js_marcaLinha(this, $i)'>
                                                    </td>
                                                    <td	class='linhagrid' align='center'>
                                                        <small>
                                                            <input id ='sequen_" . $i . "' class ='input__static' value='" . $e62_sequen . "' disabled></input>
                                                        </small>
                                                    </td>
													<td	class='linhagrid' align='center'>
													    <small>";
                                            db_ancora($e60_codemp, "js_pesquisaEmpenho($e60_numemp);", $opcao, '', "codemp_$i");
                                            echo "</small>
                                                    </td>
													<td	class='linhagrid' align='center'>
													    <small>
													        <input id ='numemp_" . $i . "' class='input__static' value='" . $e62_numemp . "' disabled></input>
													    </small>
                                                    </td>
													<td	class='linhagrid' nowrap align='left' title='$pc01_descrmater'>
													    <small>
													        <input id ='coditem_" . $i . "' class ='input__static' value='" . $e62_item . "' disabled></input>
													    </small>
                                                    </td>";
                                                    if($pc01_tabela == 1){
                                                        echo "<td	class='linhagrid' align='center' title='$pc01_descrmater - $pc01_complmater' onclick='js_verificatabela(this,$e62_sequencial,$e60_numemp,$e62_item, $pc01_tabela,$i)' style='color: rgb(0, 102, 204);'>
													    <small>$pc01_descrmater</small>
                                                    </td>";
                                                      }else{
                                                        echo "<td	class='linhagrid' align='center' title='$pc01_descrmater - $pc01_complmater' onclick='js_verificatabela(this,$e62_sequencial,$e60_numemp,$e62_item, $pc01_tabela,$i)'>
													    <small>$pc01_descrmater</small>
                                                    </td>";
                                                      }
													
                                                    
												echo"	<td	class='linhagrid' nowrap align='left' title='$m61_abrev'>
													    <small>" . (isset($m61_abrev) ? $m61_abrev : '-') . "</small>
                                                    </td>";

                                            /**
                                             * Caso for um material
                                             * Caso for um serviço e este serviço ser controlado por quantidade
                                             *
                                             *
                                             * Alterados todos inputs dentro do for dos itens
                                             * que tratam valores para db_opcao = 3, não mais permitindo alterações
                                             * de valores, dendo que para altera devera ser anulado na rotina de anulação
                                             * e incluidos os itens novamente.
                                             *
                                             */

                                            if ($pc01_servico == 'f' || ($pc01_servico == "t" && $e62_servicoquantidade == "t")) {

                                                $quantidade = "quant_" . "$i";

                                                $$quantidade = $e62_quant - $quantLancada + $oItemOrdem->m52_quant;

                                                if (!$$quantidade) {
                                                    $$quantidade = $quantLancada;
                                                }

                                                if ($ordemAutomatica) {
                                                    $$quantidade = $e62_quant;
                                                }

                                                $qtde = "qtde_$i";

                                                if ($oItemOrdem->m52_quant) {
                                                    $$qtde = $oItemOrdem->m52_quant;
                                                } else {
                                                    if (!($e62_quant - $quantLancada)) {
                                                        $$qtde = $e62_quant;
                                                    } else {
                                                        $$qtde = $oItemOrdem->m52_quant;
                                                    }
                                                }

                                                $$qtde = !$$qtde ? 0 : $$qtde;

                                                $valor = "valor_$i";
                                                $$valor = trim(db_formatar($e62_vlrun, 'f'));

                                                $valor_total = "vltotalemp_" . "$i";
                                                $valor_restante = $e62_vlrun * $$quantidade;

                                                $$valor_total = trim(db_formatar($valor_restante, 'f'));

                                                $vltotal = "vltotal_" . "$i";
                                                $$vltotal = trim(db_formatar($e62_vlrun * $$qtde, 'f'));

                                                /**
                                                 * Caso for um material
                                                 * Caso for um serviço e este serviço ser controlado por quantidade
                                                 *
                                                 *
                                                 * Alterados todos inputs dentro do for dos itens
                                                 * que tratam valores para db_opcao = 3, não mais permitindo alterações
                                                 * de valores, dendo que para altera devera ser anulado na rotina de anulação
                                                 * e incluidos os itens novamente.
                                                 *
                                                 */

                                                echo " 	 <td class='linhagrid' align='center'>";
                                                echo "		 <small>";
                                                echo "          <input id='$quantidade' class='input__static' value=' " . $$quantidade . "' disabled />";
                                                echo "		 </small>";
                                                echo "	 </td>";
                                                echo "	 <td class='linhagrid' align='center'>";
                                                echo "		 <small>";
                                                db_input("valor_$i", 10, 0, true, 'text', 3);
                                                echo "		 </small>";
                                                echo "	 </td>";
                                                echo "	 <td class='linhagrid' align='center'>";
                                                echo "		 <small>";
                                                echo "          <input id='$valor_total' class='input__static' value='" . trim($$valor_total) . "' disabled />";
                                                echo "		 </small>";
                                                echo "	 </td>";
                                                echo "	 <td class='linhagrid' align='center'>";
                                                echo "		 <small>";
                                                db_input("qtde_$i", 10, 0, true, 'text', $opcao, "onchange='js_validaValor(this, \"q\");'onkeyup='js_limitaCaracteres(this)';");
                                                echo "		 </small>";
                                                echo "	 </td>";
                                                echo "	 <td class='linhagrid' align='center'>";
                                                echo "		 <small>";
                                                db_input("vltotal_$i", 15, 0, true, 'text', 3);
                                                echo "		 </small>";
                                                echo "	 </td>";
                                                echo " </tr>";
                                            } else if ($pc01_servico == 't') {

                                                $quantidade = "quant_" . "$i";

                                                $$quantidade = $e62_quant;

                                                if ($ordemAutomatica) {
                                                    $$quantidade = $e62_quant;
                                                }

                                                $qtde = "qtde_$i";

                                                $$qtde = $e62_quant;

                                                $valor = "valor_$i";
                                                $$valor = trim(db_formatar($e62_vlrun, 'f'));

                                                $valor_total = "vltotalemp_" . "$i";

                                                if (!($e62_vltot - $valorLancado)) {
                                                    $valor_restante = $oItemValores->m52_valor;
                                                } else {
                                                    $valor_restante = $e62_vltot - $valorLancado + $oItemValores->m52_valor;
                                                }

                                                if (!$valor_restante) {
                                                    $valor_restante = $e62_vltot;
                                                }

                                                $$valor_total = trim(db_formatar($valor_restante, 'f'));

                                                $vltotal = "vltotal_" . "$i";
                                                if ($oItemValores->m52_valor) {
                                                    $$vltotal = trim(db_formatar($oItemValores->m52_valor, 'f'));
                                                } else {
                                                    $$vltotal = trim(db_formatar(0, 'f'));
                                                }

                                                echo "   <td class='linhagrid' align='center'>";
                                                echo "      <input id='$quantidade' class='input__static' value='" . $$quantidade . "' disabled />";
                                                echo "	 </td>";
                                                echo "   <td class='linhagrid' align='center'>";
                                                echo "		 <small>" . db_input("valor_$i", 10, 0, true, 'text', 3) . "</small>";
                                                echo "	 </td>";
                                                echo "	 <td class='linhagrid' align='center'>";
                                                echo "          <input id='$valor_total' class='input__static' value='" . $$valor_total . "' disabled />";
                                                echo "	 </td>";
                                                echo "	 <td class='linhagrid' align='center'>";
                                                db_input("qtde_$i", 10, 0, true, 'text', 3);
                                                echo "	 </td>";
                                                echo "	 <td class='linhagrid' align='center'>";
                                                db_input("vltotal_$i", 15, 0, true, 'text', $opcao, "onchange='js_validaValor(this, \"v\");'onkeyup='js_limitaCaracteres(this)';");
                                                echo "   </td>";
                                                echo " </tr>";
                                            }
                                        } else {
                                            echo "<tr id='tr_$e62_sequencial' class='$marcaLinha'>";
                                            echo "
										        <td class='linhagrid' title='Inverte a marcação' align='center'>
                                                    <input type='checkbox' {$sChecked} {$disabled} id='chk{$e62_sequencial}' class='itensEmpenho'
                                                        name='itensOrdem[]' value='{$e62_sequencial}' onclick='js_marcaLinha(this, $i)'>
                                                </td>";

                                            echo "    <td class='linhagrid' align='center'>
 	                                                <small>$e62_sequen</small>
                                                  </td>";
                                            echo " 	 <td class='linhagrid' align='center' $disabled>
 	                                                <small>";
                                            db_ancora($e60_codemp, "js_pesquisaEmpenho($e60_numemp);", 1);
                                            echo "       </small>
                                                 </td>";
                                            echo "   <td class='linhagrid' align='center'>
                                                    <small>$e60_numemp</small>
                                                 </td>";
                                            echo "   <td class='linhagrid' nowrap align='left' title='$e62_item'>
                                                    <small>$e62_item</small>
                                                 </td>";
                                                 if($pc01_tabela == 1){
                                                    echo "   <td class='linhagrid' align='center' title='$pc01_descrmater' ondblclick='js_verificatabela(this,$e62_sequencial,$e60_numemp,$e62_item, $pc01_tabela)' style='color:blue'>
                                                    <small>$pc01_descrmater</small>
                                                 </td>";
                                                  }else{
                                                    echo "   <td class='linhagrid' align='center' title='$pc01_descrmater' ondblclick='js_verificatabela(this,$e62_sequencial,$e60_numemp,$e62_item, $pc01_tabela)'>
                                                    <small>$pc01_descrmater</small>
                                                 </td>";
                                                  }
                                            echo "   <td class='linhagrid' align='center' title='$pc01_descrmater' ondblclick='js_verificatabela(this,$e62_sequencial,$e60_numemp,$e62_item, $pc01_tabela)'>
                                                    <small>$pc01_descrmater</small>
                                                 </td>";
                                            echo "   <td class='linhagrid' nowrap align='left' title='$m61_abrev'>
                                                    <small>" . (isset($m61_abrev) != '' ? $m61_abrev : '-') . "&nbsp;</small>
                                                 </td>";

                                            /**
                                             * Caso for um material
                                             * Caso for um serviço e este serviço ser controlado por quantidade
                                             */

                                            db_fieldsmemory($result2, 0);

                                            if ($pc01_servico == 'f' || ($pc01_servico == "t" && $e62_servicoquantidade == "t")) {

                                                $quantidade = "quant_" . "$i";

                                                $$quantidade = $e62_quant - $quantLancada + $oItemOrdem->m52_quant;

                                                if (!$$quantidade) {
                                                    $$quantidade = $quantLancada;
                                                }

                                                if ($ordemAutomatica) {
                                                    $$quantidade = $e62_quant;
                                                }

                                                $qtde = "qtde_$i";

                                                if ($oItemOrdem->m52_quant) {
                                                    $$qtde = $oItemOrdem->m52_quant;
                                                } else {
                                                    $$qtde = $oItemOrdem->m52_quant;
                                                }

                                                $$qtde = !$$qtde ? 0 : $$qtde;
                                                $$qtde = trim(db_formatar($$qtde, 'f'));

                                                $valor = "valor_$i";
                                                $$valor = trim(db_formatar($e62_vlrun, 'f'));

                                                $valor_total = "vltotalemp_" . "$i";
                                                $valor_restante = $e62_vlrun * $$quantidade;

                                                $$valor_total = trim(db_formatar($valor_restante, 'f'));

                                                $vltotal = "vltotal_" . "$i";
                                                $$vltotal = trim(db_formatar($e62_vlrun * $$qtde, 'f'));

                                                echo "   <td class='linhagrid' align='center'>";
                                                echo "		 <small>";
                                                echo "          <input id='$quantidade' class='input__static' value=' " . $$quantidade . "' disabled />";
                                                echo "		 </small>";
                                                echo "	 </td>";
                                                echo "   <td class='linhagrid' align='center'>";
                                                echo "		 <small>";
                                                db_input("valor_$i", 10, 0, true, 'text', 3);
                                                echo "		 </small>";
                                                echo "	 <td class='linhagrid' align='center'>";
                                                echo "		 <small>";
                                                echo "          <input id='$valor_total' class='input__static' value='" . $$valor_total . "' disabled />";
                                                echo "		 </small>";
                                                echo "	 </td>";
                                                echo "	 <td class='linhagrid' align='center'>";
                                                echo "		 <small>";
                                                db_input("qtde_$i", 10, 0, true, 'text', $opcao, "onchange='js_validaValor(this, \"q\");'onkeyup='js_limitaCaracteres(this)';");
                                                echo "		 </small>";
                                                echo "	 </td>";
                                                echo "	 <td class='linhagrid' align='center'>";
                                                echo "		 <small>";
                                                db_input("vltotal_$i", 15, 0, true, 'text', 3);
                                                echo "		 </small>";
                                                echo "   </td>";
                                                echo " </tr>";
                                            } else if ($pc01_servico == 't') {

                                                $quantidade = "quant_" . "$i";

                                                $$quantidade = $e62_quant - $quantLancada + $oItemOrdem->m52_quant;

                                                if (!$$quantidade) {
                                                    $$quantidade = $quantLancada;
                                                }

                                                if ($ordemAutomatica) {
                                                    $$quantidade = $e62_quant;
                                                }

                                                $qtde = "qtde_$i";
                                                $$qtde = !$$quantidade ? 0 : $$quantidade;
                                                $$qtde = trim(db_formatar($$qtde, 'f'));

                                                $valor = "valor_$i";
                                                $$valor = trim(db_formatar($e62_vlrun, 'f'));

                                                $valor_total = "vltotalemp_" . "$i";

                                                if (!($e62_vltot - $valorLancado)) {
                                                    $valor_restante = $oItemValores->m52_valor;
                                                } else {
                                                    $valor_restante = $e62_vltot - $valorLancado + $oItemValores->m52_valor;
                                                }

                                                if (!$valor_restante) {
                                                    $valor_restante = $e62_vltot;
                                                }

                                                if (!$valor_restante) {
                                                    $valor_restante = db_formatar(0, 'f');
                                                }

                                                $$valor_total = trim(db_formatar($valor_restante, 'f'));

                                                $vltotal = "vltotal_" . "$i";
                                                if ($oItemValores->m52_valor) {
                                                    $$vltotal = trim(db_formatar($oItemValores->m52_valor, 'f'));
                                                } else {
                                                    $$vltotal = trim(db_formatar(0, 'f'));
                                                }

                                                echo "	 <td class='linhagrid' align='center'>";
                                                echo "		 <small>";
                                                echo "          <input id='$quantidade' class='input__static' value=' " . $$quantidade . "' disabled />";
                                                echo "		 </small>";
                                                echo "	 </td>";
                                                echo "	 <td class='linhagrid' align='center'>
														<small>";
                                                db_input("valor_$i", 10, 0, true, 'text', 3);
                                                echo "		</small>";
                                                echo "	 </td>";
                                                echo "	 <td class='linhagrid' align='center'>";
                                                echo "		 <small>";
                                                echo "          <input id='$valor_total' class='input__static' value='" . $$valor_total . "' disabled />";
                                                echo "		 </small>";
                                                echo "	 </td>";
                                                echo "	 <td class='linhagrid' align='center'>";
                                                echo "		 <small>";
                                                db_input("qtde_$i", 10, 0, true, 'text', 3);
                                                echo "		 </small>";
                                                echo "	 </td>";
                                                echo "	 <td class='linhagrid' align='center'>";
                                                echo "		 <small>";
                                                db_input("vltotal_$i", 15, 0, true, 'text', $opcao, "onchange='js_validaValor(this, \"v\");'onkeyup='js_limitaCaracteres(this)';");
                                                echo "		 </small>";
                                                echo "   </td>";
                                                echo " </tr>";
                                            }
                                        }
                                    
                                
                                        echo " <tr id='itenstabela{$e62_item}' style='display:none;'>";
                                        if (isset($m51_codordem) && $m51_codordem != "") {

                                            $resultItem = $clempordemtabela->sql_record($clempordemtabela->sql_query(null, "*", "l223_pcmatertabela", "l223_codordem=$m51_codordem and l223_pcmaterordem=$e62_item"));

                                            $numrowstabela = $clempordemtabela->numrows;
                                            $sequencia = $numrowstabela +1;
                                        }
                                        ?>
                                            <td colspan="12">
                                                <div >
                                                    <fieldset>
                                                    <legend><b>Alterar Item Tabela</b></legend>
                                                    
                                                    <table width='100%'>
                                                    <tr>
                                                        <td colspan="7">
                                                            <?
                                                            db_ancora("Cód. material", "js_pesquisapc16_codmater(true);", 1);
                                                            ?>
                                                        
                                                            <?
                                                            db_input('codmatertabela', 8, $Ipc16_codmater, true, 'text', 1, "");
                                                            db_input('descrmater', 50, $Ipc01_descrmater, true, 'text', 1, '');
                                                            echo "<b>Quantidade<b>";
                                                            db_input('l223_quant', 5, 0, true, 'text', 1, "onchange='js_calculatotal();'");
                                                            echo "<b>Unitário<b>";
                                                            db_input('l223_vlrn', 5, 0, true, 'text', 1, "onchange='js_calculatotal();'");
                                                            echo "<b>Total<b>";
                                                            db_input('l223_total', 5, 0, true, 'text', 3, '');
                                                            db_input('codempenho', 5, 0, true, 'text', 3, '');
                                                            db_input('sequencia', 5, 0, true, 'text', 3, '');
                                                            db_input('sequencia_nova', 5, 0, true, 'text', 3, '');
                                                            db_input('m51_codordem', 5, 0, true, 'text', 3, '');
                                                            db_input('coditemordemtabela', 5, 0, true, 'text', 3, '');
                                                            ?>
                                                        </td>
                                                        </tr>
                                                        <tr>
                                                        <td colspan="7" style="text-align: center;">
                                                            <input type="button" value='Adicionar Item' id='btnAddItem'>
                                                            <input type="button" value='Alterar Item' id='btnAlterarItem' style="display:none;">
                                                            <input type="button" value='Novo Item' id='btnNovoItem' style="display:none;">
                                                            <input type="button" value='Excluir Item' id='btnExcluirItem' style="display:none;">
                                                        </td>
                                                    </tr>  
                                                        <tr>
                                                            <td>
                                                                
                                                                
                                                                <?
                                                                    if (isset($m51_codordem) && $m51_codordem != "") {

                                                                        if ($numrowstabela > 0) {

                                                                            echo "   <tr class='bordas'>";
                                                                            echo "     <td class='table_header' title='Marca/desmarca todos' align='center'>";
                                                                            echo "        <input type='checkbox'  style='display:none' id='mtodostabela' onclick='js_marca(false)'>";
                                                                            echo "            <a onclick='js_marcatabela(true,$e62_sequencial,$e62_item)' style='cursor:pointer'><b>M</b></a>";
                                                                            echo "     </td>";
                                                                            echo "     <td class='table_header' align='center'><small><b>Seq.</b></small></td>";
                                                                            echo "     <td class='table_header' align='center'><small><b>Descrição</b></small></td>";
                                                                            echo "     <td class='table_header' align='center'><small><b>Quantidade</b></small></td>";
                                                                            echo "     <td class='table_header' align='center'><small><b>Valor Unitário</b></small></td>";
                                                                            echo "     <td class='table_header' align='center'><small><b>Valor Total</b></small></td>";
                                                                            echo "     <td class='table_header' align='center'><small><b>Ação</b></small></td>";
                                                                            echo "   </tr>";
                                                                            echo " <tbody id='dadostabela' style='height:150px;width:95%;overflow:scroll;overflow-x:hidden;background-color:white'>";
                                                                        } else {

                                                                            echo " <tr>";
                                                                            echo "	<b>Nenhum registro encontrado...</b>";
                                                                            echo " </tr>";
                                                                        }
                                                                        for ($x = 0; $x < $numrowstabela; $x++) {

                                                                            db_fieldsmemory($resultItem, $x);

                                                                            $$valoquantidadetrt = $l223_quant;
                                                                            $l223_quant = "l223_quant_$e62_item"."$x";
                                                                            $$l223_quant = $$quantidadet;
                                                                            
                                                                            $$vlrnt = $l223_vlrn;
                                                                            $l223_vlrn = "l223_vlrn_$e62_item"."$x";
                                                                            $$l223_vlrn = $$vlrnt;

                                                                            $$totalt = $l223_total;
                                                                            $l223_total = "l223_total_$e62_item"."$x";
                                                                            $$l223_total = $$totalt;

                                                                            
                                                                                $seq = $x + 1;
                                                                                echo "<tr id='tr_tabela_$e62_sequencial$x' class='$marcaLinha'>";
                                                                                echo "
                                                                                    <td class='linhagrid' title='Inverte a marcação' align='center'>
                                                                                        <input type='checkbox' {$sChecked} {$disabled} id='tabela{$e62_sequencial}' class='itensEmpenhoTabela{$e62_sequencial}'
                                                                                            name='itensOrdem[]' value='{$e62_sequencial}' onclick='js_marcaLinhatabela(this, $x,$e62_item)'>
                                                                                    </td>";

                                                                                echo "    <td class='linhagrid' align='center'>
                                                                                        <small>$seq</small>
                                                                                    </td>";
                                                                                echo "   <td class='linhagrid' align='center' title='$l223_descr' id='l223_descr_$e62_item$x'>
                                                                                        <small>$l223_descr</small>
                                                                                    </td>";

                                                                                    echo "   <td class='linhagrid' align='center'>";
                                                                                    echo "		 <small>";
                                                                                    db_input("l223_quant_$e62_item".$x, 10, 0, true, 'text', 1,"onchange='js_validaValorTabela(this, $x,$e62_item,$e62_sequencial);'");
                                                                                    echo "		 </small>";
                                                                                    echo "	 </td>";
                                                                                    echo "   <td class='linhagrid' align='center'>";
                                                                                    echo "		 <small>";
                                                                                    db_input("l223_vlrn_$e62_item"."$x", 10, 0, true, 'text', 1,"onchange='js_validaValorTabela(this, $x,$e62_item,$e62_sequencial);'");
                                                                                    echo "		 </small>";
                                                                                    echo "	 </td>";
                                                                                    echo "	 <td class='linhagrid' align='center'>";
                                                                                    echo "		 <small>";
                                                                                    db_input("l223_total_$e62_item"."$x", 10, 0, true, 'text', 3);
                                                                                    echo "		 </small>";
                                                                                    echo "	 </td>";
                                                                                    echo "	 <td class='linhagrid' align='center'>";
                                                                                    echo "		 <small>";
                                                                                    echo " <input type='button' value='A' onclick='js_alterarLinha($x,$e62_item)'>";
                                                                                    echo " <input type='button' value='E' onclick='js_excluirLinha($x,$e62_item)'>";
                                                                                    echo "		 </small>";
                                                                                    echo "	 </td>";
                                                                                    echo " </tr>";
                                                                        
                                                                            
                                                                        }
                                                                        
                                                                    }
                                                                ?>
                                                                
                                                                <tr>
                                                                    <td colspan="12" style="text-align: center;">
                                                                        <input type="button" value='Alterar Item' <? echo "onclick='js_alteraritenstabela($e62_sequencial,$e62_item,$m51_codordem)'"?>>
                                                                    </td>
                                                                </tr> 
                                                                <tr>
                                                                    <td colspan="12" style="text-align: right;">
                                                                    <b>Valor total: </b><span <? echo "id='valor_total_tabela{$e62_sequencial}'" ?>>0.00</span>
                                                                    </td>
                                                                </tr> 
                                                                
                                                                    
                                                                
                                                            </td>
                                                        </tr>
                                                    </table>   
                                                </div>
                                            </td>
                                        </tr>
                                        
                                <? 
                                    }
                                }
                                if ($numrows > 0) : ?>

                                    <tr>
                                        <td colspan="12">
                                            <div style="display: block;height: auto; background-color:#EEEFF2; border-top:1px solid #444444; padding: 6px 42px 19px 10px;+">
                                                <div style="float: left; width: 50%; text-align: left">
                                                    <b>Total de Registros: </b><span id="total_de_itens">0</span>
                                                </div>
                                                <div style="float: left; width: 50%; text-align: right">
                                                    <b>Valor total: </b><span id="valor_total">0.00</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <? endif; ?>
                            </table>
                        </fieldset>
                </form>
                </center>
            </td>
        </tr>
    </table>
    <script>
        var sUrlRC = '../com4_ordemdecompra001.RPC.php';
        function js_pesquisaEmpenho(iNumEmp) {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_empempenho', 'func_empempenho001.php?e60_numemp=' + iNumEmp, 'Pesquisa', true);
        }

        function js_verifica(max, quan, nome, valoruni) {

            if (max < quan) {
                alert("Informe uma quantidade valida!!");
                eval("document.form1." + nome + ".value='';");
                eval("document.form1." + nome + ".focus();");
            } else {
                i = nome.split("_");
                pos = i[3];
                quant = new Number(quan);
                valor = new Number(valoruni);
                valortot = quant * valor;

                eval("document.form1.valor_" + pos + ".value=valortot.toFixed(2)");

            }

        }

        function js_marcaLinha(obj, sequencia) {

            let vlr_anterior = document.getElementById(`valor_${sequencia}`).value;
            let qtd_anterior = 0;

            let iQuantidade = document.getElementById(`quant_${sequencia}`).value;

            if (iQuantidade) {
                qtd_anterior = iQuantidade.replace(/\,/g, '.');
            }

            let idTr = document.getElementById(`tr_${obj.value}`);
            let valor_total = document.getElementById('valor_total');
            let total_itens = document.getElementById('total_de_itens');

            if (obj.checked) {

                if (idTr.className === 'marcado') {
                    return;
                }

                total_itens.innerText = parseInt(total_itens.innerText, 10) + 1;
                idTr.className = 'marcado';

            } else {

                if (idTr.className === 'marcado') {
                    idTr.className = 'normal';

                    total_de_itens.innerText = parseInt(total_de_itens.innerText, 10) >= 1 ?
                        parseInt(total_de_itens.innerText, 10) - 1 : 0;

                    let total_rodape = valor_total.innerText.replace(/\./g, '').replace(/\,/g, '.');
                    let temp = parseFloat(total_rodape) - Number(vlr_anterior.replace(',', '.')) * parseFloat(qtd_anterior);

                }
            }
            js_somaItens();
        }

        function js_marcaLinhatabela(obj, sequencia,item) {

            

            let idTr = document.getElementById(`tr_tabela_${obj.value+sequencia}`);

            if (obj.checked) {

                if (idTr.className === 'marcado') {
                    return;
                }
                idTr.className = 'marcado';
                document.getElementById('l223_quant_'+item+sequencia).disabled = false;
                document.getElementById('l223_vlrn_'+item+sequencia).disabled = false;

            } else {

                if (idTr.className === 'marcado') {
                    idTr.className = 'normal';
                    document.getElementById('l223_quant_'+item+sequencia).disabled = true;
                    document.getElementById('l223_vlrn_'+item+sequencia).disabled = true;
                }
            }
            js_somaItensTabela(obj.value,item);
        }

        function js_marca(val) {
            obj = document.getElementById('mtodos');

            if (obj.checked) {
                obj.checked = false;
            } else {
                obj.checked = true;
            }
            itens = js_getElementbyClass(form1, 'itensEmpenho');

            for (let i = 0; i < itens.length; i++) {
                if (itens[i].disabled == false) {
                    if (obj.checked == true) {
                        itens[i].checked = true;
                        js_marcaLinha(itens[i], i);
                    } else {
                        itens[i].checked = false;
                        js_marcaLinha(itens[i], i);
                    }
                }
            }
        }

        function js_marcatabela(val,tabela,item) {
            obj = document.getElementById('mtodostabela');

            if (obj.checked) {
                obj.checked = false;
            } else {
                obj.checked = true;
            }
            itens = js_getElementbyClass(form1, 'itensEmpenhoTabela'+tabela);

            for (let i = 0; i < itens.length; i++) {
                if (itens[i].disabled == false) {
                    if (obj.checked == true) {
                        itens[i].checked = true;
                        js_marcaLinhatabela(itens[i], i,item);
                    } else {
                        itens[i].checked = false;
                        js_marcaLinhatabela(itens[i], i,item);
                    }
                }
            }
        }

        function js_validaValor(item, tipo = 'v') {

            let indexLinha = item.id.split('_')[1];

            if (Number(item.value) < 0) {
                alert('Não é permitido a inserção de números negativos');
                document.getElementById(item.id).value = 0;
            }

            let message = '';
            let fieldTotal = document.getElementById(`vltotal_${indexLinha}`);
            let total_rodape = valor_total.innerText.replace(/\./g, '').replace(/\,/g, '.');

            if (tipo == 'v') {
                let valor_total = document.getElementById(`vltotalemp_${indexLinha}`).value;
                let novo_valor = 0;

                if (valor_total.includes(',') && valor_total.includes('.')) {
                    valor_total = valor_total.replace(/\./g, '').replace(/\,/g, '.');
                } else {
                    valor_total = valor_total.replace(/\,/g, '.');
                }

                valor_total = valor_total.replace(/\s/g, '');

                if (item.value.includes(',')) {
                    novo_valor = item.value.replace(/\./g, '').replace(/\,/g, '.');
                } else {
                    novo_valor = item.value.replace(/\,/g, '.');
                }

                novo_valor = novo_valor.replace(/\s/g, '');

                if (Number(novo_valor) > Number(valor_total)) {
                    message = 'Valor inserido maior que o valor do item no Empenho!';
                    item.value = js_formatar(valor_total, 'f');
                } else {
                    // nova_quantidade = !Number.isNaN(Number(nova_quantidade)) ? nova_quantidade : document.getElementById(`quant_${indexLinha}`).value;
                    document.getElementById(`vltotal_${indexLinha}`).innerText = js_formatar(Number(novo_valor), 'f');

                    let valor_unitario = document.getElementById(`valor_${indexLinha}`).value;
                    fieldTotal.value = js_formatar(Number(novo_valor), 'f');
                }

            } else {
                let qtde_total = document.getElementById(`quant_${indexLinha}`).value;
                let nova_quantidade = 0;

                if (item.value.includes(',')) {
                    nova_quantidade = item.value.replace(/\.\s/g, '').replace(/\,/g, '.');
                } else {
                    nova_quantidade = item.value.replace(/\,/g, '.');
                }

                if (parseFloat(nova_quantidade) > parseFloat(qtde_total)) {
                    message = 'Quantidade inserida maior que o valor do item no Empenho!';

                    let valor_unitario = document.getElementById(`valor_${indexLinha}`).value;
                    fieldTotal.value = js_formatar((parseFloat(qtde_total.replace(',', '.')) * parseFloat(valor_unitario.replace(',', '.'))), 'f');
                    item.value = js_formatar(qtde_total, 'f');
                } else {

                    //let valor_unitario = Number(document.getElementById(`valor_${indexLinha}`).value.replace(/\,/g, '.'));
                    let valor_unitario = document.getElementById(`valor_${indexLinha}`).value.split('.').join('').split(',').join('.');
                    fieldTotal.value = js_formatar((parseFloat(nova_quantidade) * valor_unitario), 'f');
                    temp = parseFloat(total_rodape) - valor_unitario * parseFloat(nova_quantidade);

                }

            }

            if (message) {
                alert(message);
            }

            js_somaItens();
        }

        function js_validaValorTabela(item, seq,coditem,tabela) {

            let indexLinha = item.id.split('_')[1];

            if (Number(item.value) < 0) {
                alert('Não é permitido a inserção de números negativos');
                document.getElementById(item.id).value = 0;
            }

            
            var novo_valor = 0;
            let nova_quantidade = 0;
            
                var valor = document.getElementById('l223_vlrn_'+coditem+seq).value;

                let qtde_total = document.getElementById('l223_quant_'+coditem+seq).value;

                if (qtde_total.includes(',')) {
                    nova_quantidade = qtde_total.replace(/\.\s/g, '').replace(/\,/g, '.');
                } else {
                    nova_quantidade = qtde_total.replace(/\,/g, '.');
                }

                if (valor.includes(',')) {
                    novo_valor = valor.replace(/\.\s/g, '').replace(/\,/g, '.');
                } else {
                    novo_valor = valor.replace(/\,/g, '.');
                }

                document.getElementById('l223_vlrn_'+coditem+seq).value = js_formatar(novo_valor,'f');

                document.getElementById('l223_quant_'+coditem+seq).value = nova_quantidade;

                document.getElementById('l223_total_'+coditem+seq).value = js_formatar((parseFloat(nova_quantidade) * novo_valor), 'f');

            js_somaItensTabela(tabela,coditem);
        }

        function js_limitaCaracteres(obj) {
            let novo_valor = 0;

            if (obj.value.includes(',')) {
                let aValores = obj.value.split(',');

                if (aValores[1].length > 4) {
                    aValores[1] = aValores[1].slice(0, -1);
                }

                let valor_final = aValores.join(',');

                document.getElementById(obj.id).value = js_formatar(valor_final, 'f');
                return;

            }

            if (obj.value.includes(',') && obj.value.includes('.')) {
                novo_valor = obj.value.replace('.', '').replace(',', '.');
            }

            let regex = /[0-9\.\,]+$/;

            if (!obj.value.match(regex)) {
                novo_valor = obj.value.slice(0, -1);
                document.getElementById(obj.id).value = novo_valor;
            }

        }

        function js_somaItens() {
            let aItens = js_getElementbyClass(form1, 'itensEmpenho');
            let valor_total = 0;

            for (let i = 0; i < aItens.length; i++) {

                let valorLinha = document.getElementById(`vltotal_${i}`).value;
                if (valorLinha.includes(',') && valorLinha.includes('.')) {
                    valorLinha = valorLinha.replace('.', '').replace(',', '.');
                } else if (valorLinha.includes(',')) {
                    valorLinha = valorLinha.replace(',', '.');
                }

                if (aItens[i].checked) {
                    valor_total += Number(valorLinha);
                }

                document.getElementById('valor_total').innerText = js_formatar(valor_total, 'f');
            }
        }

        function js_somaItensTabela(tabela,item) {
            
            let aItens = js_getElementbyClass(form1, 'itensEmpenhoTabela'+tabela);
            let valor_total = 0;
            
            for (let i = 0; i < aItens.length; i++) {

                let valorLinha = document.getElementById('l223_total_'+item+i).value;
                if (valorLinha.includes(',') && valorLinha.includes('.')) {
                    valorLinha = valorLinha.replace('.', '').replace(',', '.');
                } else if (valorLinha.includes(',')) {
                    valorLinha = valorLinha.replace(',', '.');
                }

                if (aItens[i].checked) {
                    valor_total += Number(valorLinha);
                }
                
                document.getElementById('valor_total_tabela'+tabela).innerText = js_formatar(valor_total, 'f');
            }
        }

        function js_verificatabela(obj,sequencia,empenho,item,tabela,seq){
        if( document.getElementById('itenstabela'+item).style.display == 'none'){
            if(tabela == 1){
                document.getElementById('itenstabela'+item).style.display = '';
                document.getElementById('vltotal_'+seq).disabled = true;

                let aItens = js_getElementbyClass(form1, 'itensEmpenhoTabela'+sequencia);
                
                for (let i = 0; i < aItens.length; i++) {

                            document.getElementById('l223_quant_'+item+i).disabled = true;
                            document.getElementById('l223_vlrn_'+item+i).disabled = true;
 
                }
                
                $('descrmater').value = "";
                $('codempenho').value = empenho;
                $('coditemordemtabela').value = item;
                $('btnAddItem').observe("click", js_adicionarItem);
                $('btnAlterarItem').observe("click", js_alterarItem);
                $('btnNovoItem').observe("click", js_novoItem);
                $('btnExcluirItem').observe("click", js_excluirItem);    
                $('codempenho').style.display = 'none';
                $('sequencia').style.display = 'none';
                $('sequencia_nova').style.display = 'none';
                $('m51_codordem').style.display = 'none';
                $('coditemordemtabela').style.display = 'none';         

            }
        }else{
            if(tabela == 1){
                let aItens = js_getElementbyClass(form1, 'itensEmpenhoTabela'+sequencia);
                
                for (let i = 0; i < aItens.length; i++) {
                    
                    let idTr = document.getElementById('tr_tabela_'+sequencia+""+i);


                        if (idTr.className === 'marcado') {
                            idTr.className = 'normal';
                            document.getElementById('l223_quant_'+item+seq).disabled = true;
                            document.getElementById('l223_vlrn_'+item+seq).disabled = true;
                            
                            aItens[i].checked = false;
                        }

                    
                    
                }
                document.getElementById('valor_total_tabela'+sequencia).innerText = js_formatar(0, 'f');
                document.getElementById('itenstabela'+item).style.display = 'none';
                document.getElementById('vltotal_'+seq).disabled = false;
                
                
        
            }
        }
        

        

        }

        function js_alteraritenstabela(tabela,item,ordem){
            //buscamos todos os itens marcados pelo usuário, e validos ele.
            var itemprincipal = js_getElementbyClass(form1, "itensEmpenho");
            itemMarcados = new Number(0);
            var valorordem = Number(0);
            var valortabela = 0;
            for (x = 0; x < itemprincipal.length; x++) {
                if (itemprincipal[x].checked && itemprincipal[x].value==tabela) {
                    axiliar = js_formatar(document.getElementById('vltotal_'+x).value, 'f');
                    valorordem = parseFloat(axiliar.replace(',', '.'));
                    
                    
                    
                        itemMarcados++;
                        //buscamos todos os itens marcados pelo usuário, e validos ele.
                        var itensTabela = js_getElementbyClass(form1, "itensEmpenhoTabela"+tabela);
                        itensMarcados = new Number(0);
                      
                        var aItenss = [];
                        for (i = 0; i < itensTabela.length; i++) {

                            if (itensTabela[i].checked) {
                                var objitem = {};
                                //codigo do item
                                iItem = itensTabela[i].value;
                                //valor do item (identificamos pela string "valor" seguido do sequencial do empenho.
                                var nQuantidade = new Number(document.getElementById('l223_quant_' + item + i).value);
                                var nVlrn = document.getElementById('l223_vlrn_' + item + i).value;
                                var nValortotal = document.getElementById('l223_total_' + item + i).value;
                                var descricao = js_stripTags(document.getElementById('l223_descr_' + item + i).innerHTML);
                                
                                objitem.ordem = ordem;
                                objitem.item = item;
                                objitem.sequencia = i + 1;
                                objitem.quantidade = nQuantidade;
                                objitem.vlrn = nVlrn.replace(/\,/g, '.');
                                objitem.total = nValortotal.replace(/\,/g, '.');

                                
                                    
                                aItenss.push(objitem);
                            
                                itensMarcados++;
                                
                                
                            }
                            axiliar = document.getElementById('l223_total_' + item + i).value;
                            valortabela += parseFloat(axiliar.replace(',', '.'));
                        }
                        if(valorordem != valortabela && itensMarcados > 0){  
                            alert("Usuário: A soma dos itens da tabela está divergente do valor total do item Tabela.");
                            return false; 
                        }
                    x = itemprincipal.length;
                }
            }
            if(itemMarcados == 0){
                alert("Selecione o item principal código " + item + ".");
                return false; 
            }
            if (itensMarcados == 0) {
                alert("Não há itens da Tabela Selecionados.");
                return false;
            }
            
            js_divCarregando('Aguarde, adicionando item', "msgBox");
                            var oParam = new Object();
                            oParam.itens = aItenss;
                            oParam.exec = "alterarItensOrdemTabela";
                            var oAjax = new Ajax.Request(sUrlRC, {
                            method: "post",
                            parameters: 'json=' + Object.toJSON(oParam),
                            onComplete: js_retornoalterarItem
                            });
            
        }

        function js_pesquisapc16_codmater(mostra) {

            if (mostra == true) {
            js_OpenJanelaIframe('',
                'db_iframe_pcmater',
                '../func_pcmatersolicita.php?funcao_js=parent.js_mostrapcmater1|pc01_codmater|pc01_descrmater',
                'Pesquisar Materias/Serviços',
                true,
                '0'
            );
            } else {

            if ($F('codmatertabela') != '') {

                js_OpenJanelaIframe('',
                'db_iframe_pcmater',
                '../func_pcmatersolicita.php?pesquisa_chave=' +
                $F('codmatertabela') +
                '&funcao_js=parent.js_mostrapcmater',
                'Pesquisar Materiais/Serviços',
                false, '0'
                );
            } else {
                $('codmatertabela').value = '';
            }
            }
        }

        function js_mostrapcmater(sDescricaoMaterial, Erro) {
            $('descrmater').value = sDescricaoMaterial;
            if (Erro == true) {
                $('codmatertabela').value = "";
            }
        }

        function js_mostrapcmater1(iCodigoMaterial, sDescricaoMaterial) {
            $('codmatertabela').value = iCodigoMaterial;
            $('descrmater').value = sDescricaoMaterial;
            db_iframe_pcmater.hide();
        }
        
        
        function js_alterarLinha(linha,coditemtabela){
            $('sequencia_nova').value= $('sequencia').value;
            $('sequencia').value= linha+1;
            $('coditemordemtabela').value = coditemtabela;
            $('codmatertabela').value = linha+1;
            $('descrmater').value = js_stripTags(document.getElementById('l223_descr_'+coditemtabela+''+linha).innerHTML).trim();
            $('l223_quant').value = new Number($('l223_quant_'+coditemtabela+''+linha).value);
            $('l223_vlrn').value = new Number($('l223_vlrn_'+coditemtabela+''+linha).value);
            $('l223_total').value = new Number($('l223_total_'+coditemtabela+''+linha).value);
            $('btnAddItem').style.display = "none";
            $('btnExcluirItem').style.display = "none";
            $('btnAlterarItem').style.display = "";
            $('btnNovoItem').style.display = "";
        }
        function js_novoItem(){
            $('coditemordemtabela').value = "";
            $('sequencia').value = $('sequencia_nova').value;
            $('codmatertabela').value = "";
            $('descrmater').value = "";
            $('l223_quant').value = "";
            $('l223_vlrn').value = "";
            $('l223_total').value = "";
            $('descrmater').disabled = false;
            $('l223_quant').disabled = false;
            $('l223_vlrn').disabled = false;
            $('l223_total').disabled = false;
            $('btnAddItem').style.display = "";
            $('btnAlterarItem').style.display = "none";
            $('btnNovoItem').style.display = "none";
            $('btnExcluirItem').style.display = "none";
        }
        
        
        function js_adicionarItem() {

            if ($F('descrmater') == "") {

            alert('Informe a descrição!');
            return false;

            }
            if ($F('l223_quant') == "") {

            alert('Informe a quantidade!');
            return false;

            }
            if ($F('l223_vlrn') == "") {

            alert('Informe o valor unitário!');
            return false;

            }
            if ($F('l223_total') == 0) {

            alert('Valor total zerado!');
            return false;

            }

            var aItenss = [];
            var objitem = {};
            
            objitem.ordem = $F('m51_codordem');
            objitem.descricao = encodeURIComponent(tagString($F('descrmater')));
            objitem.empenho = $F('codempenho');
            objitem.item = $F('coditemordemtabela');
            objitem.sequencia = $F('sequencia');;
            objitem.quantidade = $F('l223_quant');
            objitem.vlrn = $F('l223_vlrn');
            objitem.total = $F('l223_total');             
            aItenss.push(objitem);
            
            
            
            
            js_divCarregando('Aguarde, adicionando item', "msgBox");
            var oParam = new Object();
            oParam.itens = aItenss;
            oParam.exec = "adicionarItensOrdemTabela";
            var oAjax = new Ajax.Request(sUrlRC, {
            method: "post",
            parameters: 'json=' + Object.toJSON(oParam),
            onComplete: js_retornoadicionarItem
            });
        }
        function js_retornoadicionarItem(oAjax) {

            js_removeObj('msgBox');
            var oRetorno = eval("(" + oAjax.responseText + ")");
            if (oRetorno.iStatus == 1) {
                
                alert("Usuário: Adicionado(s) item(ns) da Tabela.");
                window.location ='db_frmmatordemitemaltera.php?m51_codordem='+oRetorno.ordem+'';
            } else {
                alert("Usuário: Não concluido as Alterações.");
            }
        }

        
        function js_alterarItem(){

            if ($F('descrmater') == "") {

            alert('Informe o material!');
            return false;

            }
            if ($F('l223_quant') == "") {

            alert('Informe a quantidade!');
            return false;

            }
            if ($F('l223_vlrn') == "") {

            alert('Informe o valor unitário!');
            return false;

            }
            if ($F('l223_total') == 0) {

            alert('Valor total zerado!');
            return false;

            }
            
            var aItenss = [];
            var objitem = {};
                                
            objitem.ordem = $F('m51_codordem');
            objitem.descricao = encodeURIComponent(tagString($F('descrmater')));
            objitem.item = $F('coditemordemtabela');
            objitem.sequencia = $F('sequencia');;
            objitem.quantidade = $F('l223_quant');
            objitem.vlrn = $F('l223_vlrn');
            objitem.total = $F('l223_total');             
            aItenss.push(objitem);
            js_divCarregando('Aguarde, alterando item', "msgBox");
            var oParam = new Object();
            oParam.itens = aItenss;
            oParam.exec = "alterarItensOrdemTabela";
            var oAjax = new Ajax.Request(sUrlRC, {
            method: "post",
            parameters: 'json=' + Object.toJSON(oParam),
            onComplete: js_retornoalterarItem
            });

        }
        function js_retornoalterarItem(oAjax) {

            js_removeObj('msgBox');
            var oRetorno = eval("(" + oAjax.responseText + ")");
            if (oRetorno.iStatus == 1) {
                
                alert("Usuário: Alterado(s) item(ns) da Tabela.");
                window.location ='db_frmmatordemitemaltera.php?m51_codordem='+oRetorno.ordem+'';
            } else {
                alert("Usuário: Não concluido as Alterações.");
            }
        }

        function js_excluirItem(){
            if ($F('codmatertabela') == "") {

            alert('Informe o material!');
            return false;

            }

            
            var aItenss = [];
            var objitem = {};
                                
            objitem.ordem = $F('m51_codordem');
            objitem.item = $F('coditemordemtabela');
            objitem.sequencia = $F('sequencia');          
            aItenss.push(objitem);
            js_divCarregando('Aguarde, excluindo item', "msgBox");
            var oParam = new Object();
            oParam.itens = aItenss;
            oParam.exec = "excluirItensOrdemTabela";
            var oAjax = new Ajax.Request(sUrlRC, {
            method: "post",
            parameters: 'json=' + Object.toJSON(oParam),
            onComplete: js_retornoexcluirItem
            });

        }
        function js_retornoexcluirItem(oAjax) {

            js_removeObj('msgBox');
            var oRetorno = eval("(" + oAjax.responseText + ")");
            if (oRetorno.iStatus == 1) {
                
                alert("Usuário: Excluido(s) item(ns) da Tabela.");
                window.location ='db_frmmatordemitemaltera.php?m51_codordem='+oRetorno.ordem+'';
            } else {
                alert("Usuário: Não concluido as Alterações.");
            }
        }
        function js_calculatotal(){
        quan = $('l223_quant').value;
        unit =  $('l223_vlrn').value;
        quan = quan.replace(/,/g, '.');
        unit = unit.replace(/,/g, '.');
        let contDot = 0;
        let novaQuantidade = '';
        for (cont = 0; cont < quan.length; cont++) {

        if (quan[cont] != '.') {
            novaQuantidade += quan[cont];
        } else {
            contDot += 1;
            if (contDot > 1) {
            novaQuantidade += '';
            } else {
            novaQuantidade += quan[cont];
            }
        }
        }
        if (contDot > 1) {
        alert('Valor Decimal já inserido');
        }
        contDot = 0;
        let novoValorunit = '';
        for (cont = 0; cont < unit.length; cont++) {

        if (unit[cont] != '.') {
            novoValorunit += unit[cont];
        } else {
            contDot += 1;
            if (contDot > 1) {
            novoValorunit += '';
            } else {
            novoValorunit += unit[cont];
            }
        }
        }

        if (contDot > 1) {
        alert('Valor Decimal já inserido');
        }

        
        quan = novaQuantidade;
        unit = novoValorunit;
        $('l223_quant').value = quan;
        $('l223_vlrn').value = unit;
        $('l223_total').value = quan * unit;
        
    }

    function js_excluirLinha(linha,coditemtabela){
        $('sequencia').value= linha+1;
        $('coditemordemtabela').value = coditemtabela;
        $('codmatertabela').value = linha+1;
        $('descrmater').value = js_stripTags($('l223_descr_'+coditemtabela+''+linha).innerHTML).trim();
        $('l223_quant').value = new Number($('l223_quant_'+coditemtabela+''+linha).value);
        $('l223_vlrn').value = new Number($('l223_vlrn_'+coditemtabela+''+linha).value);
        $('l223_total').value = new Number($('l223_total_'+coditemtabela+''+linha).value);
        $('codmatertabela').disabled = true;
        $('descrmater').disabled = true;
        $('l223_quant').disabled = true;
        $('l223_vlrn').disabled = true;
        $('l223_total').disabled = true;
        $('btnAddItem').style.display = "none";
        $('btnAlterarItem').style.display = "none";
        $('btnNovoItem').style.display = "";
        $('btnExcluirItem').style.display = "";
    } 
    </script>
</body>

</html>