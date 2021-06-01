<?
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
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_saltes_classe.php");

// Carrega parametros
$sSQL = "SELECT k29_conciliacaobancaria FROM caiparametro WHERE k29_instit = " . db_getsession('DB_instit');
$rsResult = db_query($sSQL);
$conciliacaoBancaria = db_utils::fieldsMemory($rsResult, 0)->k29_conciliacaobancaria ? date("d/m/Y", strtotime(db_utils::fieldsMemory($rsResult, 0)->k29_conciliacaobancaria)) : "";
$sSQL = "SELECT c99_data FROM condataconf WHERE c99_instit = " . db_getsession('DB_instit') . " AND c99_anousu = " . db_getsession("DB_anousu");
$rsResult = db_query($sSQL);
$encerramentoContabil = db_utils::fieldsMemory($rsResult, 0)->c99_data ? date("d/m/Y", strtotime(db_utils::fieldsMemory($rsResult, 0)->c99_data)) : "";

db_postmemory($HTTP_GET_VARS);
db_postmemory($HTTP_POST_VARS);
$db_opcao = 1;
$db_botao = true;
if (isset($incluir)) {
    db_inicio_transacao();
    $pendencia = new cl_conciliacaobancariapendencia;
    $pendencia->k173_conta = $conta;
    $pendencia->k173_tipolancamento = $tipo_lancamento;
    $pendencia->k173_mov = $movimento == "E" ? 1 : 2;
    $pendencia->k173_tipomovimento = $tipo_movimento ? tipoDocumentoLancamento($tipo_movimento) : "";
    $pendencia->k173_numcgm = $z01_numcgm;
    $pendencia->k173_codigo = $codigo;
    $pendencia->k173_documento = $documento;
    $pendencia->k173_data = data($data_lancamento);
    $pendencia->k173_valor = $valor;
    $pendencia->k173_historico = $observacao;
    if ($pendencia->Incluir()) {
        echo "<script>alert('Pendência inserida com sucesso!')</script>";
    } else {
        echo "<script>alert('Erro ao inserir a pendência!')</script>";
    }
    db_fim_transacao();
}

function data($data)
{
    $data = explode("/", $data);
    return $data[2] . "-" . $data[1] . "-" . $data[0];
}

function tipoDocumentoLancamento($tipo_lancamento)
{
    switch ($tipo_lancamento) {
        case "PGTO. EMPENHO":
            return "30";
            break;
        case "EST. PGTO EMPENHO":
            return "31";
            break;
        case "REC. ORCAMENTARIA":
            return "100";
            break;
        case "EST. REC. ORCAMENTARIA":
            return "101";
            break;
        case "PGTO EXTRA ORCAMENTARIO":
            return "120";
            break;
        case "EST. PGTO EXTRA ORCAMENTARIO":
            return "121";
            break;
        case "EST. REC. EXTRA ORCAMENTARIA":
            return "131";
            break;
        case "REC. EXTRA ORCAMENTARIA":
            return "130";
            break;
        case "PERDAS":
            return "164";
            break;
        case "ESTORNO PERDAS":
            return "165";
            break;
        case "TRANSFERENCIA":
            return "140";
            break;
        case "EST. TRANSFERENCIA":
            return "141";
            break;
    }
}

?>
<html>
    <head>
        <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
        <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
        <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
        <script language="JavaScript" type="text/javascript" src="scripts/AjaxRequest.js"></script>
        <link href="estilos.css" rel="stylesheet" type="text/css">
    </head>
    <body style="background-color: #CCCCCC;" >
        <div class="container">
            <form name="form1" method="post" action="" onsubmit="return js_valida_dados()">
                <input type="hidden" value="<?php echo $conta; ?>" name="conta" />
                <input type="hidden" value="incluir" name="incluir" />
                <fieldset style="margin-top: 20px; width: 750px;">
                    <legend><b>Lançamento de pendência</b></legend>
                    <table width="100%">
                        <tr>
                            <td  valign="top">
                                <fieldset >
                                    <table border="0" width="100%">
                                        <tr>
                                            <td><b>Tipo de Lançamento:</b></td>
                                            <td align="left" colspan="4">
                                            <?
                                                $tipo_lancamento = array("Selecione", "IMPLANTAÇÃO", "PENDÊNCIA");
                                                db_select("tipo_lancamento", $tipo_lancamento, true, 1, "onchange='js_seleciona_tipo_lancamento()' style='width:100%'");
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Movimento:</b></td>
                                            <td align="left">
                                            <?
                                                $tipo_movimento = array("0" => "Selecione", "E" => "Entrada", "S" => "Saída");
                                                db_select("movimento", $tipo_movimento, true, 1, "onchange='js_seleciona_tipo_movimento()' style='width:100%'");
                                            ?>
                                            </td>
                                            <td><b>Tipo de Movimento:</b></td>
                                            <td align="left" >
                                            <?
                                                $tipo_lancamento = array("Selecione");
                                                db_select("tipo_movimento", $tipo_lancamento, true, 1, "style='width:100%'");
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td nowrap title="<?=@$Tz01_numcgm?>">
                                            <?
                                                db_ancora("<b>Credor:</b>","js_pesquisaz01_numcgm(true);",$db_opcao);
                                            ?>
                                            </td>
                                            <td  nowrap>
                                            <?
                                                db_input('z01_numcgm',25,$Iz01_numcgm,true,'text',$db_opcao," onchange='js_pesquisaz01_numcgm(false);'");
                                                ?>
                                            </td>
                                            <td colspan="2">
                                                <?
                                                db_input('z01_nome',70,$Iz01_nome,true,'text',3,'');
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>OP/REC/SLIP:</b></td>
                                            <td nowrap>
                                                <? db_input('codigo', 25, "" ,true,'text',1,''); ?>
                                            </td>
                                            <td><b>Doc. Extrato:</b></td>
                                            <td nowrap align="">
                                                <? db_input('documento', 50, "" ,true,'text',1,''); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Data Lançamento:</b></td>
                                            <td nowrap>
                                                <? db_inputdata("data_lancamento", 25, null, null, true, "text", 1, "style='width:100%'"); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Valor:</b></td>
                                            <td align="left">
                                                <? db_input("valor", 25, 0, true, "text", 1, "onkeyup=\"js_ValidaCampos(this, 4, 'valor', false, null, event)\""); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                <fieldset>
                                                    <legend><strong>Histórico</strong></legend>
                                                    <textarea title="Histórico" name="observacao" type="text" id="observacao" rows="1" cols="40" onblur="js_ValidaMaiusculo(this,'f',event);" onkeyup="js_ValidaCampos(this, 0,'Observação','t','f',event);" oninput=""  style="background-color:#E6E4F1;width:100%" autocomplete="off"></textarea>
                                                </fieldset>
                                            </td>
                                        </tr>
                                    </table>
                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <td colspan='4' style='text-align: center'>
                                <input name="salvar" id='salvar' type="submit"  value="Salvar"/>
                                <input name="voltar" id='voltar' type="button"  value="Voltar" onclick="parent.db_iframe_extratobancariapendencia.hide();"/>
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </form>
        </div>
    </body>
</html>
<script>
    var dataConciliacaoBancaria = "<?= $conciliacaoBancaria ?>";
    var dataInicial = "<?= $data_inicial ?>";
    var encerramentoContabil = "<?=$encerramentoContabil?>";
    js_bloquear_campos(true);
    js_reset();

    function js_reset() {
        document.form1.tipo_lancamento.selectedIndex = 0;
        document.form1.movimento.selectedIndex = 0;
        document.form1.tipo_movimento.selectedIndex = 0;
        document.form1.z01_numcgm.value = "";
        document.form1.z01_nome.value = "";
        document.form1.codigo.value = "";
        document.form1.documento.value = "";
        document.form1.data_lancamento.value = "";
        document.form1.valor.value = "";
        document.form1.observacao.value = "";
    }

    function js_bloquear_campos(liberar)
    {
        $('movimento').disabled = liberar;
        $('z01_numcgm').disabled = liberar;
        $('codigo').disabled = liberar;
        $('documento').disabled = liberar;
        $('data_lancamento').disabled = liberar;
        $('valor').disabled = liberar;
        js_bloquear_tipo_movimento();
    }

    function js_seleciona_tipo_lancamento()
    {
        if ($F('tipo_lancamento') != "0")
            js_bloquear_campos(false);
        else
            js_bloquear_campos(true);
    }

    function js_seleciona_tipo_movimento()
    {
        js_tipo_movimento_options();
    }

    function js_bloquear_tipo_movimento()
    {
        if ($F('tipo_lancamento') == "1")
            $('tipo_movimento').disabled = false;
        else
            $('tipo_movimento').disabled = true;
    }

    function js_tipo_movimento_options()
    {
        var entrada = ["Selecione", "REC. ORCAMENTARIA", "REC. EXTRA ORCAMENTARIA", "EST. PGTO EMPENHO", "EST. PGTO EXTRA ORCAMENTARIA", "ESTORNO PERDAS", "TRANSFERENCIA", "EST. TRANSFERENCIA."];
        var saida = ["Selecione", "EST. REC. ORCAMENTARIA", "EST. REC. EXTRA ORCAMENTARIA", "PGTO EMPENHO", "PGTO EXTRA ORCAMENTARIA", "PERDAS", "TRANSFERENCIA", "EST. TRANSFERENCIA"];

        if ($F("movimento") == "E") {
            js_preenche_option(document.form1.tipo_movimento, entrada);
        } else if ($F("movimento") == "S") {
            js_preenche_option(document.form1.tipo_movimento, saida);
        }
    }

    function js_preenche_option(select, options)
    {
        var i, option;
        js_remove_all_select(select);
        for (i = 0; i < options.length; i++) {
            option = document.createElement("option");
            option.value = option.text = options[i];
            select.add(option);
        }
    }

    function js_remove_all_select(select) {
        while (select.options.length > 0) {
            select.remove(0);
        }
    }

    function js_pesquisaz01_numcgm(mostra){
        if (mostra == true) {
            js_OpenJanelaIframe('', 'func_nome', 'func_nome.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome', 'Pesquisar CGM', true, 22, 0, document.body.getWidth() - 12, document.body.scrollHeight - 30);
        } else {
            if (document.form1.z01_numcgm.value != '') {
                js_OpenJanelaIframe('', 'func_nome', 'func_nome.php?pesquisa_chave='+document.form1.z01_numcgm.value + '&funcao_js=parent.js_mostracgm', 'Pesquisar CGM', false, 22, 0, document.width-12, document.body.scrollHeight-30);
            } else {
                document.form1.z01_nome.value = '';
            }
        }
    }

    function js_mostracgm(erro,chave) {
        document.form1.z01_nome.value = chave;
        if (erro == true) {
            document.form1.z01_numcgm.focus();
            document.form1.z01_numcgm.value = '';
        }
    }

    function js_mostracgm1(chave1,chave2) {
        document.form1.z01_numcgm.value = chave1;
        document.form1.z01_nome.value   = chave2;
        func_nome.hide();
    }

    function js_valida_dados()
    {
        if ($F("tipo_lancamento") == "0") {
            alert("Tipo de Lançamento não informado.");
            return false;
        }

        if ($F("movimento") == "0") {
            alert("Movimento não informado.");
            return false;
        }

        if ($F("tipo_lancamento") == "1" && $F("tipo_movimento") == "Selecione") {
            alert("Tipo de Movimento não informado.");
            return false;
        }

        if ($F("data_lancamento") == "") {
            alert("Data de Lançamento não informada.");
            return false;
        }

        if ($F("valor") == "") {
            alert("Valor não informado.");
            return false;
        }

        if (document.form1.observacao.value.trim() == "") {
            alert("Histórico não informado.");
            return false;
        }

        if ($F("tipo_lancamento") == "1" && js_comparadata($F("data_lancamento"), dataConciliacaoBancaria, ">")) {
            alert("Não é possível incluir movimento de implantação após a data de implantação da conciliação bancária.");
            return false;
        }

        if ($F("tipo_lancamento") == "2" && js_comparadata($F("data_lancamento"), dataInicial, "<")) {
            if (!confirm("A inclusão da pendência fora do período de conciliação afetará as conciliações realizadas anteriormente, tem certeza que deseja incluir a pendência nesta data?"))
                return false;
        }

        if (encerramentoContabil != "") {
            if (js_comparadata($F("tipo_lancamento"), encerramentoContabil, ">")) {
                alert("Não foi possível processar a conciliação pois já existe encerramento de período contábil para esta data.");
                return false;
            }
        }

        return true;
    }
</script>
