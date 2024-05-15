<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2012  DBselller Servicos de Informatica
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
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("model/CgmFactory.model.php");
//ini_set('display_errors','on');
$oGet = db_utils::postMemory($_GET, false);
//echo "<pre>"; print_r($oGet->cgm);die();
if (isset($oGet->cgm)) {

    $oCgm = CgmFactory::getInstance('', $oGet->cgm);
}

$oDaoCgm      = db_utils::getDao('cgmalt');
$sSqlBuscaCGMALT = $oDaoCgm->sql_query_file(null, "*", null, "z05_numcgm = $oGet->cgm");
$rsBuscaCGMALT   = $oDaoCgm->sql_record($sSqlBuscaCGMALT);
//echo $sSqlBuscaCGMALT; db_criatabela($rsBuscaCGMALT);die();
$aRegistroCgmAlt = array();
for ($iCont = 0; $iCont < pg_num_rows($rsBuscaCGMALT); $iCont++) {
    $oRegistroCgmAlt = db_utils::fieldsMemory($rsBuscaCGMALT, $iCont);
    $aRegistroCgmAlt[]       = $oRegistroCgmAlt;
}
//echo "<pre>"; print_r($aRegistroCgmAlt);die();
?>
<html>
<head>
    <title>Dados do Cadastro de Veículos</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<style>
    .DBGrid {
        border: 1px solid #888;
        margin: 20px 0;
        background: #EEEFF2;
        font-weight: normal;

    }
    .table_header  {
        text-align:center;
        padding:1px;
        border-bottom:2px outset white;
        border-right:1px outset white;
        background-color:#a6b0bd;

    }
</style>
<body style="margin-left: 110px">
<!--<form name="form1" target='relatoriocgmalt' id="form1"  method="get" action="con2_execucaodecontratos002.php">-->
<table>
    <tr class="">
        <th class="table_header" style="width: 560px;">Observação</th>
        <th class="table_header" style="width: 113px;">Data Alteração</th>
        <th class="table_header" style="width: 40px; cursor: pointer;" onclick="marcarTodos();">M</th>
    </tr>
</table>
<?
$arrayCgmAlt = array();
foreach ($aRegistroCgmAlt as $aRegCgmAlt):
    $iCgmAlt = $aRegCgmAlt->z05_sequencia;
    ?>
        <table>
            <tr>
                <th type="hidden" class ="DBGrid" style="width: 560px;" name="aCgmAlt[<?= $iCgmAlt ?>][obs]"><?= $aRegCgmAlt->z05_obs?></th>
                <th type="hidden" class ="DBGrid" style="width: 112px;" name="aCgmAlt[<?= $iCgmAlt ?>][dataalt]"><?= implode('/', array_reverse(explode('-', $aRegCgmAlt->z05_data_alt)));?></th>
                <th class ="DBGrid">
                    <input type="checkbox" style="width: 31px;" class="marca_itens" name="aItonsMarcados[]"  value="<?= $iCgmAlt ?>">
                </th>
            </tr>
        </table>
        <?
    $imprimircabecalho = false;
endforeach;?>
<table>
    <tr>
        <td>
            <input type="submit" style="margin-left: 350px" onclick="return js_emitir();" value="Emite Relatório">
        </td>
    </tr>

</table>
<!--</form>-->
</body>
</html>
<script>

    function aItens() {
        var itensNum = document.querySelectorAll('.marca_itens');

        return Array.prototype.map.call(itensNum, function (item) {
            return item;
        });
    }

    function getItensMarcados() {
        return aItens().filter(function (item) {
            return item.checked;
        });
    }


    function marcarTodos() {

        aItens().forEach(function (item) {

            var check = item.classList.contains('marcado');

            if (check) {
                item.classList.remove('marcado');
            } else {
                item.classList.add('marcado');
            }
            item.checked = !check;

        });

    }

    function js_emitir() {
        var oCgmAlt = getItensMarcados();
        var aCgmsAlt = new Array();

        oCgmAlt.forEach(function (cgm) {
            aCgmsAlt.push(cgm.value);
        });
        var sQuery = "";
        sQuery += "?aCgmsAlt="     + aCgmsAlt;
        var oJanela = window.open('prot3_relatoriocgmalt009.php' + sQuery, 'relatoriocgmalt',
            'width='+(screen.availWidth-5)+', height='+(screen.availHeight-40)+', scrollbars=1, location=0');
        oJanela.moveTo(0,0);
        return true;
    }
</script>