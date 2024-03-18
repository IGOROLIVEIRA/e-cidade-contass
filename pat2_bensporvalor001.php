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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_bens_classe.php");
include("libs/db_utils.php");
include("dbforms/db_classesgenericas.php");
include("classes/db_cfpatri_classe.php");
include("classes/db_db_depart_classe.php");
include("classes/db_departdiv_classe.php");
include("libs/db_app.utils.php");
include("classes/db_empnota_classe.php");

$clrotulo       = new rotulocampo;
$cldb_depart    = new cl_db_depart;
$clcfpatric     = new cl_cfpatri;
$clbens         = new cl_bens;
$cldepartdiv    = new cl_departdiv;
$clsituabens    = new cl_situabens;

// ocorrência 2505
$clrotulo->label("e69_codnota");
$clrotulo->label("e69_numero");
$clrotulo->label("z01_nome");
$clrotulo->label("t53_empen");
$clrotulo->label("t04_sequencial");
$clbens->rotulo->label();
$cldb_depart->rotulo->label();

db_postmemory($HTTP_POST_VARS);

//Verifica se utiliza pesquisa por orgão sim ou não
$t06_pesqorgao = "f";
$resPesquisaOrgao = $clcfpatric->sql_record($clcfpatric->sql_query_file(null, 't06_pesqorgao'));
if ($clcfpatric->numrows > 0) {
    db_fieldsmemory($resPesquisaOrgao, 0);
}

$aSituacaoBens = array('Selecione');
$resultadoClsituabens = db_utils::getCollectionByRecord(db_query($clsituabens->sql_query()));

$indice = 1;
foreach ($resultadoClsituabens as $resSiBens) {
    $aSituacaoBens[$indice] .= $resSiBens->t70_descr;
    $indice++;
}
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <?php
    db_app::load('scripts.js');
    db_app::load('prototype.js');
    db_app::load('estilos.css');
    ?>
</head>
<body bgcolor=#CCCCCC>
<form class="container" name="form1" method="post" action="">
    <fieldset>
        <legend>Relatório - Bens Valor por Período</legend>
        <table class="form-container">
            <tr>
                <td>
                    <strong>Mês:</strong>
                </td>
                <td align="left" nowrap>
                    <?php
                    db_input("mes", 10, $iMes, true, "text", 4, "");
                    ?>
                    <strong>Ano:</strong>
                    <?php
                    db_input("ano", 10, $iAno, true, "text", 4, "");
                    ?>
                </td>
            </tr>
            <tr>
                <td align="right"  nowrap title="Classificação">
                    <?php db_ancora("Classificação:","pesquisaClassificacao(true);",$db_opcao); ?>
                </td>
                <td>
                    <?php db_input('t64_codcla',50,$It64_codcla,true,'hidden',3); ?>
                    <?php db_input('t64_class',10,$It64_class,true,'text',$db_opcao," onchange='pesquisaClassificacao(false);'") ?>
                    <?php db_input('t64_descr',50,$It64_descr,true,'text',3); ?>
                </td>
            </tr>
            <tr>
                <td align="right" nowrap title="<?= $Tcoddepto ?>">
                    <?php db_ancora(@$Lcoddepto, "js_pesquisa_depart(true);", $db_opcao); ?>
                </td>
                <td align="left" nowrap>
                    <?php
                    db_input("coddepto", 10, $Icoddepto, true, "text", 4, "onchange='js_pesquisa_depart(false);'");
                    db_input("descrdepto", 50, $Idescrdepto, true, "text", 3);
                    ?>
                </td>
            </tr>
            <tr>
                <td align="right"  nowrap title="Divisão">
                    <?php db_ancora("Divisão","pesquisaCodigoDivisao(true);",$db_opcao); ?>
                </td>
                <td>
                    <?php db_input('t30_codigo',10,$It30_codigo,true,'text',$db_opcao," onchange='pesquisaCodigoDivisao(false);'") ?>
                    <?php db_input('t30_descr',50,'',true,'text',3); ?>
                </td>
            </tr>
            <tr>
                <td><b>Tipo bens:</b></td>
                <td nowrap>
                    <?php
                    $aTipobens = ['1' => 'Móveis','2' => 'Imóveis','3' => 'Semoventes'];
                    db_select("iTipobens", $aTipobens, true, 1); ?>
                </td>
            </tr>
            <tr>
                <td><b>Ordenar por:</b></td>
                <td nowrap>
                    <?php
                    $aExibir = ['1' => 'Código do bem','2' => 'Placa do bem','3' => 'Descrição do bem'];
                    db_select("iOrdenar", $aExibir, true, 1); ?>
                </td>
            </tr>
            <tr>
                <td><b>Exibir bens:</b></td>
                <td nowrap>
                    <?php
                    $aExibir = ['1' => 'Ativos','2' => 'Todos','3' => 'Baixados'];
                    db_select("iExibir", $aExibir, true, 1); ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <input type="button" value="Emitir" onClick="js_emite();">
</form>
<?php
db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
?>
</body>
</html>
<script>

    function js_emite() {
        let query = "";

        $F('coddepto').trim() === ''
            ? query += "codigoDepartamento=" + 0 + '&'
            : query += "codigoDepartamento=" + document.form1.coddepto.value + '&'
                + "descricaoDepartamento=" + document.form1.descrdepto.value + '&';

        $F('t30_codigo').trim() === ''
            ? query += ''
            : query += "codigoDivisao=" + document.form1.t30_codigo.value + '&'
                + "descricaoDivisao=" + document.form1.t30_descr.value + '&';

        $F('t64_class').trim() === ''
            ? query += ''
            : query += "codigoClassificacao=" + document.form1.t64_codcla.value + '&'
                +  "classificacao=" + document.form1.t64_class.value + '&'
                + "descricaoClassificacao=" + document.form1.t64_descr.value + '&';

        const inputMes = document.getElementById('mes');

        inputMes.value !== '0' ? query += 'mes=' + inputMes.value + '&' : query += '';

        const inputAno = document.getElementById('ano');

        inputAno.value !== '0' ? query += 'ano=' + inputAno.value + '&' : query += '';

        const inputExibir = document.getElementById('iExibir');

        inputExibir.value !== '0' ? query += 'exibir=' + inputExibir.value + '&' : query += '';

        const inputOrdenarPor = document.getElementById('iOrdenar');

        inputOrdenarPor.value !== '0' ? query += 'ordenar=' + inputOrdenarPor.value + '&' : query += '';

        const inputTipoBens = document.getElementById('iTipobens');

        inputTipoBens.value !== '0' ? query += 'itipobens=' + inputTipoBens.value + '&' : query += '';

        const inputDepartamento = document.getElementById('coddepto').value;

        const inputClassificacao = document.getElementById('t64_class').value;

        const inputDivisao = document.getElementById('t30_codigo').value;

        if(inputClassificacao){
            var arquivoRelatorio = 'pat2_bensporvalorclassificacao002.php?';
        }

        if(inputDepartamento){
            var arquivoRelatorio = 'pat2_bensporvalorDepartamento002.php?';
        }

        if(inputDivisao){
            var arquivoRelatorio = 'pat2_bensporvalorDivisao002.php?';
        }

        jan = window.open( arquivoRelatorio + query, '', 'width=' + (screen.availWidth - 5) + ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0 ');
        jan.moveTo(0, 0);
    }

    function js_pesquisa_depart(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_db_depart', 'func_db_depart.php?funcao_js=parent.js_mostradepart1|coddepto|descrdepto', 'Pesquisa', true);
        } else {
            if (document.form1.coddepto.value != '') {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_db_depart', 'func_db_depart.php?pesquisa_chave=' + document.form1.coddepto.value + '&funcao_js=parent.js_mostradepart', 'Pesquisa', false);
            } else {
                document.form1.descrdepto.value = '';
                document.form1.submit();
            }
        }
    }

    function js_mostradepart(chave, erro) {
        document.form1.descrdepto.value = chave;
        document.form1.t64_descr.value = '';
        document.form1.t64_class.value = '';
        document.form1.t30_codigo.value = '';
        document.form1.t30_descr.value = '';
        if (erro == true) {
            document.form1.coddepto.focus();
            document.form1.coddepto.value = '';
        } else {
            document.form1.submit();
        }
    }

    function js_mostradepart1(chave1, chave2) {
        document.form1.coddepto.value = chave1;
        document.form1.descrdepto.value = chave2;
        document.form1.t64_descr.value = '';
        document.form1.t64_class.value = '';
        document.form1.t30_codigo.value = '';
        document.form1.t30_descr.value = '';
        db_iframe_db_depart.hide();
        document.form1.submit();
    }

    function pesquisaCodigoDivisao(mostra) {
        if (typeof mostra === 'boolean' && mostra === true) {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_departdiv', 'func_departdiv.php?funcao_js=parent.escondeIframePesquisaDivisao|t30_codigo|t30_descr', 'Pesquisa', true);
        } else {
            if (document.form1.t04_sequencial.value !== '') {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_departdiv', 'func_departdiv.php?pesquisa_chave=' + document.form1.t30_codigo.value + '&funcao_js=parent.mostraIframePesquisaDivisao', 'Pesquisa', false);
            } else {
                document.form1.t30_descr.value = '';
                document.form1.submit();
            }
        }
    }

    function mostraIframePesquisaDivisao(chave, erro) {
        document.form1.t30_descr.value = chave;
        document.form1.t64_descr.value = '';
        document.form1.t64_class.value = '';
        document.form1.coddepto.value = '';
        document.form1.descrdepto.value = '';
        if (typeof erro === 'boolean' && erro === true) {
            document.form1.t30_codigo.focus();
            document.form1.t30_codigo.value = '';
        } else {
            document.form1.submit();
        }
    }

    function escondeIframePesquisaDivisao(chave1, chave2) {
        document.form1.t30_codigo.value = chave1;
        document.form1.t30_descr.value = chave2;
        document.form1.t64_descr.value = '';
        document.form1.t64_class.value = '';
        document.form1.coddepto.value = '';
        document.form1.descrdepto.value = '';
        db_iframe_departdiv.hide();
        document.form1.submit();
    }

    function pesquisaClassificacao(mostra) {
        if (typeof mostra === 'boolean' && mostra === true) {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_clabens', 'func_clabens.php?funcao_js=parent.escondeIframePesquisaClassificacao|t64_class|t64_descr|t64_codcla', 'Pesquisa', true);
        } else {
            if (document.form1.t64_class.value !== '') {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_clabens', 'func_clabens.php?pesquisa_chave=' + document.form1.t64_class.value + '&funcao_js=parent.mostraIframePesquisaClassificacao', 'Pesquisa', false);
            } else {
                document.form1.t64_descr.value = '';
                document.form1.submit();
            }
        }
    }

    function mostraIframePesquisaClassificacao(chave, erro) {
        document.form1.t64_descr.value = chave;
        document.form1.t30_codigo.value = '';
        document.form1.t30_descr.value = '';
        document.form1.coddepto.value = '';
        document.form1.descrdepto.value = '';
        if (typeof erro === 'boolean' && erro === true) {
            document.form1.t64_class.focus();
            document.form1.t64_class.value = '';
        } else {
            document.form1.submit();
        }
    }

    function escondeIframePesquisaClassificacao(chave1, chave2, chave3) {
        document.form1.t64_class.value = chave1;
        document.form1.t64_descr.value = chave2;
        document.form1.t64_codcla.value = chave3;
        document.form1.t30_codigo.value = '';
        document.form1.t30_descr.value = '';
        document.form1.coddepto.value = '';
        document.form1.descrdepto.value = '';
        db_iframe_clabens.hide();
        document.form1.submit();
    }
</script>
