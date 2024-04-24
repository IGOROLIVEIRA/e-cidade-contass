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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_liclicitemlote_classe.php");
include("classes/db_liclicita_classe.php");
require_once("classes/db_liclicitaportalcompras_classe.php");
require_once("model/licitacao/PortalCompras/Provedor/LigadorClasses.model.php");

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$clliclicitemlote = new cl_liclicitemlote;
$clliclicita      = new cl_liclicita;
$clliccomissaocgm     = new cl_liccomissaocgm;
$cl_liclicitaportalcompras = new cl_liclicitaportalcompras;

$listaModalidades = LigadorClasses::listaBindModalidades();

if ($licitacao == "") {
    $licitacao = -1;
}
$result = $clliclicita->sql_record($clliclicita->sql_query($licitacao, "l08_altera, l20_usaregistropreco,  l20_formacontroleregistropreco, l20_datacria , l20_dataaber, l20_criterioadjudicacao, l20_codtipocom,l20_linkedital,l20_linkpncp, l20_dtpulicacaoedital,l20_dtpublic,l20_dtpulicacaopncp,l20_datapublicacao1,l20_datapublicacao2,l20_nomeveiculo1,l20_nomeveiculo2,l20_diariooficialdivulgacao,l20_naturezaobjeto "));
$oLicitacao = db_utils::fieldsMemory($result, 0);
$result = $clliccomissaocgm->sql_record($clliccomissaocgm->sql_query_file(null, 'l31_codigo,l31_liccomissao,l31_numcgm, (select cgm.z01_nome from cgm where z01_numcgm = l31_numcgm) as z01_nome, l31_tipo', null, "l31_licitacao=$licitacao and l31_tipo = '8'"));
$comissao = db_utils::fieldsMemory($result, 0);
$tribunal = db_query("SELECT pctipocompratribunal.l44_sequencial
FROM cflicita
INNER JOIN db_config ON db_config.codigo = cflicita.l03_instit
INNER JOIN pctipocompra ON pctipocompra.pc50_codcom = cflicita.l03_codcom
INNER JOIN pctipocompratribunal ON pctipocompratribunal.l44_sequencial = cflicita.l03_pctipocompratribunal
INNER JOIN cgm ON cgm.z01_numcgm = db_config.numcgm
INNER JOIN db_tipoinstit ON db_tipoinstit.db21_codtipo = db_config.db21_tipoinstit
INNER JOIN pctipocompratribunal AS a ON a.l44_sequencial = pctipocompra.pc50_pctipocompratribunal
WHERE cflicita.l03_codigo = $oLicitacao->l20_codtipocom");
$tribunal = db_utils::fieldsMemory($tribunal, 0);
$tribunal = $tribunal->l44_sequencial;

$acessoPcpResource = db_query("
select lic.l12_acessoapipcp as acessopcp
from licitacao.licitaparam as lic
where l12_instit =".db_getsession("DB_instit")
);

$acessoPcp = (db_utils::fieldsMemory($acessoPcpResource, 0))->acessopcp;

$ocultar_box_publicacoes = false;
if ($tribunal == 100 || $tribunal == 101 || $tribunal == 102 || $tribunal == 103) {
    $ocultar_box_publicacoes = true;
}

$resource = $cl_liclicitaportalcompras->buscaCodigoModalidade($licitacao);
$codigoModalidade = (db_utils::fieldsMemory($resource, 0))->codigomodalidade;

?>
<html>

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <?
    db_app::load("scripts.js, strings.js, prototype.js, datagrid.widget.js");
    db_app::load("widgets/messageboard.widget.js, widgets/windowAux.widget.js");
    db_app::load("estilos.css, grid.style.css");
    ?>
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body>
    <center>

        <div style="margin-top: 20px">

            <form name="form1" style="display: <?php if ($ocultar_box_publicacoes == true) {
                                                    echo "none";
                                                } ?>;">
                <fieldset style="width: 550;">
                    <legend><strong>Publicações</strong></legend>
                    <table>
                        <tr style="margin-left:-50px;" id="dtpubedital">
                            <td nowrap title="Data Publicação Edital" id="dtpublic">
                                <b>Data Publicação Edital: </b>
                            </td>
                            <td>
                                <?
                                db_inputdata('l20_dtpulicacaoedital', @$l20_dtpulicacaoedital_dia, @$l20_dtpulicacaoedital_mes, @$l20_dtpulicacaoedital_ano, true, 'text', $db_opcao);
                                ?>
                            </td>
                        </tr>
                        <tr id="linkedital">
                            <td nowrap title="Link de Publicação Edital">
                                <b>Link de Publicação Edital:</b>
                            </td>
                            <td>
                                <?
                                db_input('l20_linkedital', 100, $Il20_linkedital, true, 'text', $db_opcao, "");
                                ?>
                            </td>
                        </tr>
                        <tr id="diario">
                            <td nowrap title="Diário Oficial da Divulgação">
                                <b>Diário Oficial da Divulgação: </b>
                            </td>
                            <td>
                                <?
                                $aDiarios = array(
                                    "0" => "Selecione",
                                    "1" => "Município",
                                    "2" => "Estado",
                                    "3" => "União"
                                );
                                db_select("l20_diariooficialdivulgacao", $aDiarios, true, '');
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td nowrap title="Data Publicação DO" id="dtpublic">
                                <b>Data Publicação DO : <?php echo $l20_linkedital; ?></b>
                            </td>
                            <td>
                                <?
                                db_inputdata('l20_dtpublic', @$l20_dtpublic_dia, @$l20_dtpublic_mes, @$l20_dtpublic_ano, true, 'text', $db_opcao, "", "", "#ffffff");
                                ?>
                            </td>
                        </tr>
                        <tr id="datenpc">
                            <td nowrap title="Data de Publicação PNCP">
                                <b>Data de Publicação PNCP: </b>
                            </td>
                            <td>
                                <?
                                db_inputdata("l20_dtpulicacaopncp", @$l20_dtpulicacaopncp_dia, @$l20_dtpulicacaopncp_mes, @$l20_dtpulicacaopncp_ano, true, 'text', $db_opcao);
                                ?>
                            </td>
                        </tr>
                        <tr id="linkpnpc">
                            <td nowrap title="Link no PNCP">
                                <b>Link no PNCP: </b>
                            </td>
                            <td>
                                <?
                                db_input('l20_linkpncp', 100, $Il20_linkpncp, true, 'text', $db_opcao, "");
                                ?>
                            </td>
                        </tr>
                        <tr id="respPublic">
                            <td nowrap title="respPubliccodigo">
                                <?
                                db_ancora("Resp. pela Publicação:", "js_pesquisal31_numcgm(true,'respPubliccodigo','respPublicnome');", $db_opcao)

                                ?>
                            </td>
                            <td>
                                <?
                                db_input('respPubliccodigo', 10, $respPubliccodigo, true, 'text', $db_opcao, "onchange=js_pesquisal31_numcgm(false,'respPubliccodigo','respPublicnome');");
                                db_input('respPublicnome', 45, $respPublicnome, true, 'text', 3, "");
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td nowrap title="<?= @$Tl20_datapublicacao1 ?>" id="datapublicacao1">
                                <? //=@$Ll20_datapublicacao1
                                ?>
                                <strong>Publicação Veículo 1:</strong>
                            </td>
                            <td>
                                <?
                                db_inputdata('l20_datapublicacao1', @$l20_datapublicacao1_dia, @$l20_datapublicacao1_mes, @$l20_datapublicacao1_ano, true, 'text', $db_opcao, "");
                                ?>
                                <strong id="nomeveiculo1">Veículo Divulgação 1:</strong>
                                <?
                                db_input('l20_nomeveiculo1', 40, $Il20_nomeveiculo1, true, 'text', $db_opcao, "");
                                ?>
                            </td>

                        </tr>
                        <tr>
                            <td nowrap title="<?= @$Tl20_datapublicacao2 ?>" id="datapublicacao2">
                                <? //=@$Ll20_datapublicacao2
                                ?>
                                <strong>Publicação Veículo 2:</strong>
                            </td>
                            <td>
                                <?
                                db_inputdata('l20_datapublicacao2', @$l20_datapublicacao2_dia, @$l20_datapublicacao2_mes, @$l20_datapublicacao2_ano, true, 'text', $db_opcao, "");
                                ?>
                                <strong id="nomeveiculo2">Veículo Divulgação 2:</strong>
                                <?
                                db_input('l20_nomeveiculo2', 40, $Il20_nomeveiculo2, true, 'text', $db_opcao, "");
                                ?>
                            </td>
                        </tr>

                        <tr style="display: none;">
                            <td nowrap title="Data Abertura Proc. Adm.">
                                <b>Data Abertura Proc. Adm. :</b>
                            </td>
                            <td>
                                <?

                                db_inputdata("l20_datacria", @$l20_datacria_dia, @$l20_datacria_mes, @$l20_datacria_ano, true, 'text', $db_opcao);
                                ?>
                                <?= @$Ll20_horacria ?>
                                <?

                                ?>
                            </td>
                        </tr>

                        <tr style="display: none;">
                            <td nowrap title="Data Emis/Alt Edital/Convite" id="dataaber">
                                <b> Data Emis/Alt Edital/Convite : </b>
                            </td>
                            <td>
                                <?
                                db_inputdata("l20_dataaber", @$l20_dataaber_dia, @$l20_dataaber_mes, @$l20_dataaber_ano, true, 'text', $db_opcao);
                                ?>
                                <?= @$Ll20_horaaber ?>
                                <?

                                ?>
                            </td>
                        </tr>

                    </table>
                </fieldset>
                <input name="<?= ($db_opcao == 1 ? 'incluir' : ($db_opcao == 2 || $db_opcao == 22 ? 'alterar' : 'excluir')) ?>" type="button" id="db_opcao" value="<?= ($db_opcao == 1 ? 'Incluir' : ($db_opcao == 2 || $db_opcao == 22 ? 'Alterar' : 'Excluir')) ?>" onClick="return js_confirmadatas()">

            </form>
            <form name="form1">
                <fieldset style="width: 550;">
                    <legend><strong>Extrato de publicações: </strong></legend>
                    <table>

                        <tr id="respPublic">
                            <td nowrap title="respPubliccodigo">
                                <?
                                db_ancora("Texto Padrão:", "js_pesquisa(true);", $db_opcao)

                                ?>
                            </td>
                            <td>
                                <?
                                db_input('l214_sequencial', 10, $l214_sequencial, true, 'text', $db_opcao, "onchange=js_pesquisa(false);");
                                db_input('l214_tipo', 45, $l214_tipo, true, 'text', 3, "");
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td nowrap title="<?= @$Te54_conpag ?>" colspan="3">
                                <fieldset>
                                    <legend><b>Texto: </b></legend>

                                    <?
                                    db_textarea('l214_texto', 3, 119, 'l214_tipo', true, 'text', $db_opcao, "")
                                    ?>
                                </fieldset>
                            </td>
                        </tr>


                    </table>
                </fieldset>
                <input name="emite2" type="button" id="emite2" value="Imprimir" onclick="js_emite();">

            </form>
            <?php

            if ($acessoPcp == 't' &&
                array_key_exists($codigoModalidade, $listaModalidades)):
            ?>
                <form name="form2">
                    <fieldset style="width: 550;">
                        <legend><strong>Enviar Publicações para Plataforma: </strong></legend>
                        <table>
                            <tr id="PortalCompras">
                                <td nowrap title="enviarPortalCompras">
                                    Portal de Compras:
                                </td>
                                <td>
                                    <input name="enviarPortalCompras" type="button" id="enviarPortalCompras" value="Enviar" onclick="js_EnviarPortalDeCompras();">
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </form>
            <?php endif; ?>
        </div>
    </center>


</body>

<script>
    function js_emite() {

        var query = 'l214_tipo=' + document.getElementById('l214_tipo').value;
        query += '&l214_texto=' + document.getElementById('l214_texto').value.replace(/\r\n|\r|\n/g, "<br />");
        query += '&l214_sequencial=' + document.getElementById('l214_sequencial').value;
        query += '&licitacao=' + "<?php echo $licitacao; ?>";


        jan = window.open('lic1_liclicpublicacaorelatorio.php?' + query, '', 'width=' + (screen.availWidth - 5) + ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0 ');
        jan.moveTo(0, 0);
    }

    function js_pesquisal31_numcgm(mostra, numCampo, nomeCampo) {
        varNumCampo = numCampo;
        varNomeCampo = nomeCampo;

        if (mostra == true) {
            js_OpenJanelaIframe('', 'db_iframe_cgm', 'func_nome.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome&filtro=1', 'Pesquisa', true, '0', '1');
        } else {
            numcgm = document.getElementById(numCampo).value;
            if (numcgm != '') {
                js_OpenJanelaIframe('', 'db_iframe_cgm', 'func_nome.php?pesquisa_chave=' + numcgm + '&funcao_js=parent.js_mostracgm&filtro=1', 'Pesquisa', false);
            } else {
                document.getElementById(numCampo).value = "";
                document.getElementById(varNomeCampo).value = "";

            }
        }
    }

    function js_mostracgm(erro, chave) {
        document.getElementById(varNomeCampo).value = chave;
        if (erro == true) {
            //  document.form1.l31_numcgm.focus();
            document.getElementById(varNumCampo).value = "";
            document.getElementById(varNomeCampo).value = "";
            alert("Responsável não encontrado!");
        }
    }

    function js_mostracgm1(chave1, chave2) {

        document.getElementById(varNumCampo).value = chave1;
        document.getElementById(varNomeCampo).value = chave2;
        db_iframe_cgm.hide();
    }

    function js_pesquisa(mostra) {

        tribunal = "<?php echo $tribunal; ?>";
        texto2 = false;

        if (texto2 == 102 || texto2 == 103) {
            texto2 = true;

        }

        if (mostra == true) {
            js_OpenJanelaIframe('', 'db_iframe_liclicpublicacoes', 'func_lictextopublicacao.php?texto2=' + texto2 + '&funcao_js=parent.js_preenchepesquisa|0|1|2', 'Pesquisa', true);
        } else {
            sequencial = document.getElementById('l214_sequencial').value
            js_OpenJanelaIframe('', 'db_iframe_liclicpublicacoes', 'func_lictextopublicacao.php?texto2=' + texto2 + '&publicacao=true&pesquisa_chave=' + sequencial + '&funcao_js=parent.js_preenchepesquisa2', 'Pesquisa', false);

        }
    }



    function js_preenchepesquisa(chave, chave2, chave3) {
        db_iframe_liclicpublicacoes.hide();
        document.getElementById('l214_sequencial').value = chave;
        document.getElementById('l214_tipo').value = chave2;
        document.getElementById('l214_texto').value = chave3;

    }

    function js_preenchepesquisa2(chave, chave2, chave3) {
        db_iframe_liclicpublicacoes.hide();

        if (chave3 == undefined) {
            document.getElementById('l214_sequencial').value = "";
            document.getElementById('l214_tipo').value = "";
            document.getElementById('l214_texto').value = "";
        } else {
            document.getElementById('l214_sequencial').value = chave;
            document.getElementById('l214_tipo').value = chave2;
            document.getElementById('l214_texto').value = chave3;
        }

    }

    function js_confirmadatas() {

        var dataCriacao = document.getElementById('l20_datacria').value;
        var dataPublicacao = document.getElementById('l20_dtpublic').value;
        var dataAbertura = document.getElementById('l20_dataaber').value;

        if (js_CompararDatas(dataCriacao, dataPublicacao, '<=')) {
            if (js_CompararDatas(dataPublicacao, dataAbertura, '<')) {
                alert("A Data de Publicação deve ser maior ou igual a Data Edital/Convite");
                document.form1.l20_dataaber.style.backgroundColor = '#99A9AE';
                document.form1.l20_dataaber.focus();
                return false;
            } else {




            }
        } else {
            alert("A Data de Publicação deve ser maior ou igual a Data de Criação.");
            return false;
        }

        var oParam = new Object();
        oParam.licitacao = "<?php echo $licitacao; ?>";
        oParam.l20_linkedital = encodeURIComponent(tagString(document.getElementById('l20_linkedital').value));
        oParam.l20_linkpncp = encodeURIComponent(tagString(document.getElementById('l20_linkpncp').value));
        oParam.l20_dtpulicacaoedital = document.getElementById('l20_dtpulicacaoedital').value;
        oParam.l20_dtpublic = document.getElementById('l20_dtpublic').value;
        oParam.l20_dtpulicacaopncp = document.getElementById('l20_dtpulicacaopncp').value;
        oParam.respPubliccodigo = document.getElementById('respPubliccodigo').value;
        oParam.respPublicnome = document.getElementById('respPublicnome').value;
        oParam.l20_datapublicacao1 = document.getElementById('l20_datapublicacao1').value;
        oParam.l20_datapublicacao2 = document.getElementById('l20_datapublicacao2').value;
        oParam.l20_nomeveiculo1 = document.getElementById('l20_nomeveiculo1').value;
        oParam.l20_nomeveiculo2 = document.getElementById('l20_nomeveiculo2').value;
        oParam.l20_diariooficialdivulgacao = document.getElementById('l20_diariooficialdivulgacao').value;
        oParam.l20_datacria = document.getElementById('l20_datacria').value;
        oParam.l20_dataaber = document.getElementById('l20_dataaber').value;

        if (oParam.licitacao == -1) {
            alert("É necessário realizar a inclusão da licitação para cadastrar as datas referentes a publicação");
            return false;
        }

        var sUrl = 'lic1_licpublicacao.php';


        var oAjax = new Ajax.Request(sUrl, {
            method: 'post',
            parameters: 'json=' + Object.toJSON(oParam),
            onComplete: js_retornopublicacao
        });

    }

    function js_retornopublicacao(oAjax) {

        var oRetorno = eval("(" + oAjax.responseText + ")");
        var sMensagem = oRetorno.erro.urlDecode();
        var licitacao = "<?php echo $licitacao ?>";
        var naturezaObjeto = "<?php echo $oLicitacao->l20_naturezaobjeto; ?>";

        if (oRetorno.status == 1) {
            alert("Publicações alteradas com sucesso");
            parent.window.location.href = `lic4_editalabas.php?licitacao=${licitacao}`;
        } else {
            alert('ERRO: O link informado na Publicação Veículo possui mais de 50 caracteres.');
        }
    }

    function js_CompararDatas(data1, data2, comparar) {

        if (data1.indexOf('/') != -1) {
            datepart = data1.split('/');
            pYear = datepart[2];
            pMonth = datepart[1];
            pDay = datepart[0];
        }
        data1 = pYear + pMonth + pDay;

        if (data2.indexOf('/') != -1) {
            datepart = data2.split('/');
            pYear = datepart[2];
            pMonth = datepart[1];
            pDay = datepart[0];
        }
        data2 = pYear + pMonth + pDay;
        if (eval(data1 + " " + comparar + " " + data2)) {

            return true;

        } else {
            return false;
        }
    }

    function js_EnviarPortalDeCompras() {
        var sUrl = 'lic1_enviointegracaocompraspublicas.RPC.php';
        var oParam = new Object();
        oParam.codigo = "<?= $licitacao?>";
        oParam.exec = "EnviarPregao";

        js_divCarregando('Aguarde...', 'msgbox');

        var oAjax = new Ajax.Request(sUrl, {
            method: 'post',
            parameters: 'json=' + Object.toJSON(oParam),
            onComplete: js_retornoportaldecompras
        });

    }

    function js_retornoportaldecompras(oAjax) {
        js_removeObj('msgbox');
        var oRetorno = eval("(" + oAjax.responseText + ")");

        alert(oRetorno.message);
    }

    document.getElementById('l20_linkedital').value = "<?php echo $oLicitacao->l20_linkedital ?>";
    document.getElementById('l20_linkpncp').value = "<?php echo $oLicitacao->l20_linkpncp ?>";
    document.getElementById('l20_dtpulicacaoedital').value = "<?php echo implode('/', array_reverse(explode('-', $oLicitacao->l20_dtpulicacaoedital))); ?>";
    document.getElementById('l20_dtpublic').value = "<?php echo implode('/', array_reverse(explode('-', $oLicitacao->l20_dtpublic))); ?>";
    document.getElementById('l20_dtpulicacaopncp').value = "<?php echo implode('/', array_reverse(explode('-', $oLicitacao->l20_dtpulicacaopncp))); ?>";
    document.getElementById('respPubliccodigo').value = "<?php echo $comissao->l31_numcgm; ?>";
    document.getElementById('respPublicnome').value = "<?php echo implode('/', array_reverse(explode('-', $comissao->z01_nome))); ?>";
    document.getElementById('l20_datapublicacao1').value = "<?php echo implode('/', array_reverse(explode('-', $oLicitacao->l20_datapublicacao1))); ?>";
    document.getElementById('l20_datapublicacao2').value = "<?php echo implode('/', array_reverse(explode('-', $oLicitacao->l20_datapublicacao2))); ?>";
    document.getElementById('l20_nomeveiculo1').value = "<?php echo $oLicitacao->l20_nomeveiculo1; ?>";
    document.getElementById('l20_nomeveiculo2').value = "<?php echo $oLicitacao->l20_nomeveiculo2; ?>";
    document.getElementById('l20_diariooficialdivulgacao').value = "<?php echo $oLicitacao->l20_diariooficialdivulgacao; ?>";
    document.getElementById('l20_datacria').value = "<?php $date = new DateTime($oLicitacao->l20_datacria);
                                                        echo $date->format('d/m/Y');  ?>";
    document.getElementById('l20_dataaber').value = "<?php $date = new DateTime($oLicitacao->l20_dataaber);
                                                        echo $date->format('d/m/Y');  ?>";
</script>

</html>