<?php

require_once 'libs/db_stdlib.php';
require_once 'libs/db_conecta.php';
require_once 'libs/db_sessoes.php';
require_once 'libs/db_usuariosonline.php';
require_once 'libs/db_utils.php';
require_once 'dbforms/db_funcoes.php';
require_once('classes/db_acordoitem_classe.php');

db_postmemory($HTTP_SERVER_VARS);
db_postmemory($_POST);
//echo '<pre>';
//print_r($_POST);

$clrotulo = new rotulocampo();
$clrotulo->label("ac16_sequencial");
$clrotulo->label("ac16_resumoobjeto");

$anousu = db_getsession('DB_anousu');
$instit = db_getsession('DB_instit');

$sqlerro = false;

$clAcordoItem = new cl_acordoitem;

if (isset($alterar)) {
    db_inicio_transacao();

    foreach ($itensAcordo as $ac20_sequencial) {

        $result = db_query("update acordoitem set ac20_elemento = $pc07_codele where ac20_sequencial = $ac20_sequencial");

        if ($result == false) {
            $sqlerro = true;
            db_msgbox("Alteração não realizada. Verifique");
            break;
        }

        $result1 = db_query("update empautitem set e55_codele = $pc07_codele where e55_autori in (select ac19_autori from acordoitemexecutadoempautitem where ac19_acordoitemexecutado in (select ac29_sequencial from acordoitemexecutado where ac29_acordoitem = $ac20_sequencial)) and e55_item = (select ac20_pcmater from acordoitem where ac20_sequencial = $ac20_sequencial)");

        if ($result1 == false) {
            $sqlerro = true;
            db_msgbox("Alteração não realizada. Verifique");
            break;
        }
    }
    if ($sqlerro == false) {
        db_msgbox("Alteração realizada com sucesso");
    }
    db_fim_transacao($sqlerro);
}

?>

<html>

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <?
    db_app::load("scripts.js, strings.js, prototype.js, datagrid.widget.js");
    db_app::load("widgets/dbmessageBoard.widget.js, widgets/windowAux.widget.js, datagrid.widget.js");
    db_app::load("classes/DBViewAcordoDotacaoItens.classe.js");
    db_app::load("estilos.css, grid.style.css");
    ?>
</head>

<body bgcolor="#CCCCCC">


        <form name="form1" method="post" action="">
            <div class="container">
                <fieldset>
                    <legend>
                        <b>Alteração de Desdobramento</b>
                    </legend>
                    <table>
                        <tr>
                            <td nowrap title="<?php echo $Tac16_sequencial; ?>" width="130">
                                <?php
                                db_ancora($Lac16_sequencial, "js_acordo(true);", 1);
                                ?>
                            </td>
                            <td>
                                <?php
                                db_input('ac16_sequencial', 10, $Iac16_sequencial, true, 'text', 1, "onchange='js_acordo(false);'");
                                db_input('ac16_resumoobjeto', 40, $Iac16_resumoobjeto, true, 'text', 3);
                                ?>
                            </td>
                        </tr>
                        <?
                        $sSql = "select distinct pc07_codele,o56_elemento||'-'||o56_descr desdobraitem from pcmaterele inner join orcelemento on o56_codele = pc07_codele and o56_anousu = " . db_getsession("DB_anousu") . " where pc07_codmater in (select ac20_pcmater from acordoitem where ac20_acordoposicao in (select max(ac26_sequencial) from acordoposicao where ac26_acordo = $ac16_sequencial)) order by desdobraitem";
                        $resultSql = pg_query($sSql);
                        ?>
                        <tr>
                            <td nowrap title="">
                                <b>Desdobramento</b>
                            </td>
                            <td>
                                <?
                                db_selectrecord('pc07_codele', $resultSql, true, 1);
                                ?>
                            </td>
                        </tr>
                    </table>
                    <tr>
                        <input type="submit" id="pesquisar" value="Pesquisar">
                    </tr>
                </fieldset>
            </div>
            <div>
                <?
                $sSqlItens = "select ac20_ordem,ac20_pcmater,pc01_descrmater,ac20_elemento||' - '||o56_elemento||' - '||o56_descr desdobramentoitem,ac20_sequencial from acordoitem inner join pcmater on pc01_codmater = ac20_pcmater inner join orcelemento on o56_codele = ac20_elemento and o56_anousu = " . db_getsession("DB_anousu") . " where ac20_acordoposicao in (select max(ac26_sequencial) from acordoposicao where ac26_acordo = $ac16_sequencial) order by ac20_ordem";

                $resultSqlItens = pg_query($sSqlItens);

                if (pg_numrows($resultSqlItens) > 0) {
                    echo " <br> ";
                    echo " <br> ";
                    echo " <center> ";
                    echo " <table style='border:2px inset white' width='80%' cellspacing='0'> ";
                    echo " <tr> ";
                    echo " <td class='table_header' title='marcadesmarca' align='center' width='1%'> ";
                ?>
                    <input type='checkbox' style='display:none' id='mtodos' onclick='js_marca()'>
                    <a onclick='js_marca()' style='cursor:pointer'>M</a></b>
                    <?
                    echo " </td> ";
                    echo " <td class='table_header' width='4%'><b>Ordem</b></td> ";
                    echo " <td class='table_header' width='7%'><b>Item</b></td> ";
                    echo " <td class='table_header' width='43%'><b>Material</b></td> ";
                    echo " <td class='table_header' width='55%'><b>Desdobramento</b></td> ";
                    echo " <td class='table_header' width='6%'><b>Seq.</b></td> ";
                    echo " <tbody id='dados' style='height:30%;width:80%;overflow:scroll;overflow-x:hidden;background-color:white'> ";

                    for ($i = 0; $i < pg_numrows($resultSqlItens); $i++) {
                        $oResult = db_utils::fieldsmemory($resultSqlItens, $i);

                        echo " <tr id='trchk{$oResult->ac20_sequencial}' class='{$sClassName}' style='height:1em'> ";
                        echo " <td class='linhagrid' title='Inverte a marcação' style='border:2px inset white' align='center' width='1%'> ";
                        echo " <input type='checkbox' {$sChecked} {$disabled} id='chk{$oResult->ac20_sequencial}' class='itemAcordo' ";
                        echo " name='itensAcordo[]' value='{$oResult->ac20_sequencial}' onclick='js_marcaLinha(this)'></td> ";
                        echo " <td class='linhagrid' style='border:2px inset white' align='center' width='4%'>$oResult->ac20_ordem</td> ";
                        echo " <td class='linhagrid' style='border:2px inset white' align='center' width='7%'>$oResult->ac20_pcmater</td> ";
                        echo " <td class='linhagrid' style='border:2px inset white' align='center' width='43%'>$oResult->pc01_descrmater</td> ";
                        echo " <td class='linhagrid' style='border:2px inset white' align='left' width='55%'>$oResult->desdobramentoitem</td> ";
                        echo " <td class='linhagrid' style='border:2px inset white' align='center' width='6%'>$oResult->ac20_sequencial</td> ";
                        echo " </tr> ";
                    }
                    echo " </table> ";
                    echo " </center> ";
                    echo " <br> ";
                    echo " <br> ";
                    echo " </div> ";
                    echo " <div> ";
                    echo " <center> ";
                    echo " <tr> ";
                    echo " <td> ";
                    ?>
                    <input name="alterar" type="submit" id="alterar" value="Alterar" onclick="return js_valida()">
                <?
                    echo " </td> ";
                    echo " </tr> ";
                    echo " </center> ";
                    echo " </div> ";
                } ?>
        </form>
</body>

</html>

<script>
    function js_acordo(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('', 'db_iframe_acordo',
                'func_acordoinstit.php?funcao_js=parent.js_mostraAcordo1|ac16_sequencial|z01_nome',
                'Pesquisa', true);
        } else {
            if ($F('ac16_sequencial').trim() != '') {
                js_OpenJanelaIframe('', 'db_iframe_depart',
                    'func_acordoinstit.php?pesquisa_chave=' + $F('ac16_sequencial') + '&funcao_js=parent.js_mostraAcordo' +
                    '&descricao=true',
                    'Pesquisa', false);
            } else {
                $('ac16_resumoobjeto').value = '';
            }
        }
    }

    function js_preenchepesquisa(chave) {

        db_iframe_acordo.hide();
        <?
        if ($db_opcao != 1) {
            echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave";
        }
        ?>
    }

    function js_mostraAcordo(chave, descricao, erro) {

        $('ac16_resumoobjeto').value = descricao;
        if (erro == true) {
            $('ac16_sequencial').focus();
            $('ac16_sequencial').value = '';
        }
    }

    function js_mostraAcordo1(chave1, chave2) {
        $('ac16_sequencial').value = chave1;
        $('ac16_resumoobjeto').value = chave2;
        db_iframe_acordo.hide();
    }

    function js_marca() {

        obj = document.getElementById('mtodos');
        if (obj.checked) {
            obj.checked = false;
        } else {
            obj.checked = true;
        }
        itens = js_getElementbyClass(form1, 'itemAcordo');
        for (i = 0; i < itens.length; i++) {
            if (itens[i].disabled == false) {
                if (obj.checked == true) {
                    itens[i].checked = true;
                    js_marcaLinha(itens[i]);
                } else {
                    itens[i].checked = false;
                    js_marcaLinha(itens[i]);
                }
            }
        }
    }

    function js_marcaLinha(obj) {

        if (obj.checked) {
            $('tr' + obj.id).className = 'marcado';
        } else {
            $('tr' + obj.id).className = 'normal';
        }

    }

    function js_valida() {
        var aArquivosSelecionados = new Array();
        var aArquivos = $$("input[type='checkbox']");

        aArquivos.each(function(oElemento, iIndice) {

            if (oElemento.checked) {
                aArquivosSelecionados.push(oElemento.value);
            }
        });
        if (aArquivosSelecionados.length == 0) {

            alert("Nenhum item selecionado");
            return false;
        }
    }
</script>


