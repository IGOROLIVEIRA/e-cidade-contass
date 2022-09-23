<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2016  DBSeller Servicos de Informatica
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
require_once("libs/db_app.utils.php");
require_once("libs/db_utils.php");
require_once("dbforms/db_funcoes.php");

$clrotulo = new rotulocampo;
$clrotulo->label("rh01_regist");
$clrotulo->label("z01_nome");

$db_opcao = 1;

$anofolha = DBPessoal::getAnoFolha();
$mesfolha = DBPessoal::getMesFolha();

?>
<html>

<head>
    <title>DBSeller Informática Ltda</title>
    <meta http-equiv="Expires" CONTENT="0">
    <?php
    db_app::load("scripts.js");
    db_app::load("prototype.js");
    db_app::load("windowAux.widget.js");
    db_app::load("strings.js");
    db_app::load("dbtextField.widget.js");
    db_app::load("dbViewAvaliacoes.classe.js");
    db_app::load("dbmessageBoard.widget.js");
    db_app::load("dbautocomplete.widget.js");
    db_app::load("dbcomboBox.widget.js");
    db_app::load("datagrid.widget.js");
    db_app::load("AjaxRequest.js");
    db_app::load("widgets/DBLookUp.widget.js");
    db_app::load("estilos.css,grid.style.css");
    ?>
</head>

<body>
    <form id="formPesquisarEsocial" method="POST" action="eso4_preenchimento001.php" class="container">
        <fieldset>
            <legend>Conferência dos dados informados pelo servidor:</legend>
            <table class="form-container">
                <tr>
                    <td nowrap title="<?php echo $Trh01_regist; ?>">
                        <a id="lbl_rh01_regist" for="matricula"><?= $Lrh01_regist ?></a>
                    </td>
                    <td>
                        <?php db_input('rh01_regist', 10, $Irh01_regist, true, "text", 1, "", "", "", "width: 16%"); ?>
                        <?php db_input('z01_nome', 50, $Iz01_nome, true, "text", 3, "", "", "", "width: 61%"); ?>
                        <input type="button" name="adicionar" value="Adicionar" onclick="js_adicionar_matric()" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Matrículas</strong>
                    </td>
                    <td>
                        <select multiple="multiple" name="matriculas" id="matriculas" style="width: 78%;" ondblclick="js_remover_matric(this);">
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="left"><label for="cboEmpregador">Empregador:</label></td>
                    <td>
                        <select name="empregador" id="cboEmpregador" style="width: 78%;">
                            <option value="">selecione</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right"><label for="tpAmb">Ambiente:</label></td>
                    <td>
                        <select name="tpAmb" id="tpAmb" style="width: 78%;">
                            <option value="">selecione</option>
                            <option value="1">Produção</option>
                            <option value="2">Produção restrita - dados reais</option>
                            <option value="3">Produção restrita - dados fictícios</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right"><label for="modo">Tipo:</label></td>
                    <td>
                        <select name="modo" id="modo" style="width: 78%;">
                            <option value="">selecione</option>
                            <option value="INC">Inclusão</option>
                            <option value="ALT">Alteração</option>
                            <option value="EXC">Exclusão</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="left"><label>Início de Validade:</label></td>
                    <td>
                        <?php
                        db_input('anofolha', 4, 1, true, 'text', 2, "class='field-size1'");
                        db_input('mesfolha', 2, 1, true, 'text', 2, "class='field-size1'");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><label for="evento">Evento:</label></td>
                    <td>
                        <select name="evento" id="evento" style="width: 78%;" onchange="js_alt_evento()">
                            <option value="">selecione</option>
                            <option value="S2200">S-2200 - Cadastramento Inicial do Vínculo e Admissão/Ingresso de Trabalhador</option>
                            <option value="S2300">S-2300 - Trabalhador Sem Vínculo de Emprego/Estatutário - Início</option>
                            <option value="S2230">S-2230 - Afastamento Temporário</option>
                            <option value="S2306">S-2306 - Trabalhador Sem Vínculo de Emprego/Estatutário - Alteração Contratual</option>
                            <option value="S2400">S-2400 - Cadastro de Beneficiário - Entes Públicos - Início</option>
                            <option value="S2410">S-2410 - Cadastro de Benefício - Entes Públicos - Início</option>
                            <option value="S2299">S-2299 - Desligamento</option>
                            <option value="S1200">S-1200 - Remuneração de Trabalhador vinculado ao Regime Geral de Previd. Social</option>
                            <option value="S1202">S-1202 - Remuneração de Servidor vinculado ao Regime Próprio de Previd</option>
                            <option value="S1207">S-1207 - Benefícios - Entes Públicos</option>
                            <option value="S1210">S-1210 - Pagamentos de Rendimentos do Trabalho</option>
                        </select>
                    </td>
                </tr>
                <tr id="indapuracao_col" style="display: none;">
                    <td align="right"><label for="indapuracao">Apuração:</label></td>
                    <td>
                        <select name="indapuracao" id="indapuracao" style="width: 78%;">
                            <option value="1">Mensal</option>
                            <option value="2">Anual</option>
                        </select>
                    </td>
                </tr>
                <tr id="dtalteracao" style="display:none">
                    <td align="left"><label>Data Alteração:</label>

                        <input name="dt_alteracao" type="text" id="dt_alteracao" value="" size="10" maxlength="10" autocomplete="off" onblur="js_validaDbData(this);" onkeyup="return js_mascaraData(this,event)" onfocus="js_validaEntrada(this);" onpaste="return false" ondrop="return false">
                        <input name="dt_alteracao_dia" type="hidden" title="" id="dt_alteracao_dia" value="" size="2" maxlength="2">
                        <input name="dt_alteracao_mes" type="hidden" title="" id="dt_alteracao_mes" value="" size="2" maxlength="2">
                        <input name="dt_alteracao_ano" type="hidden" title="" id="dt_alteracao_ano" value="" size="4" maxlength="4">
                        <script>
                            var PosMouseY, PosMoudeX;

                            function js_comparaDatasdt_alteracao(dia, mes, ano) {
                                var objData = document.getElementById('dt_alteracao');
                                objData.value = dia + "/" + mes + '/' + ano;
                            }
                        </script>

                        <input value="D" type="button" id="dtjs_dt_alteracao" name="dtjs_dt_alteracao" onclick="pegaPosMouse(event);show_calendar('dt_alteracao','none')">
                    </td>
                </tr>
                <tr id="tppgto_col" style="display:none">
                    <td><label>Tipo de Pagamento:</label></td>
                    <td><select name="tppgto" id="tppgto" style="width: 50%;">
                            <option value="1">Pagamento de remuneração, conforme apurado em
                                ideDmDev do S-1200
                            </option>
                            <option value="2">Pagamento de verbas rescisórias conforme apurado
                                em ideDmDev do S-2299
                            </option>
                            <option value="3">Pagamento de verbas rescisórias conforme apurado
                                em ideDmDev do S-2399
                            </option>
                            <option value="4">Pagamento de remuneração conforme apurado em
                                ideDmDev do S-1202
                            </option>
                            <option value="5">Pagamento de benefícios previdenciários, conforme
                                apurado em ideDmDev do S-1207
                            </option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="left" id="tipo_col" style="display:none"><label>Tipo de evento:</label>
                        <select name="tpevento" id="tpevento" style="width: 25%;">
                            <option value="1">RH</option>
                            <option value="2">Contabilidade</option>
                        </select>
                    </td>
                </tr>
            </table>
        </fieldset>
        <input type="button" id="pesquisar" name="pesquisar" value="Pesquisar" />

        <br>
        <br>
        <input type="button" id="envioESocial" name="envioESocial" value="Enviar para eSocial" />
        <input type="button" id="btnConsultar" value="Consultar Envio" onclick="js_consultar();" />
    </form>

    <div id="questionario"></div>
    <?php db_menu(); ?>
</body>

</html>

<script>
    var arrEvts = ['EvtIniciaisTabelas', 'EvtNaoPeriodicos', 'EvtPeriodicos'];
    var empregador = Object();
    (function() {

        new AjaxRequest('eso4_esocialapi.RPC.php', {
            exec: 'getEmpregadores'
        }, function(retorno, lErro) {

            if (lErro) {
                alert(retorno.sMessage);
                return false;
            }
            empregador = retorno.empregador;

            $('cboEmpregador').length = 0;
            $('cboEmpregador').add(new Option(empregador.nome, empregador.cgm));
        }).setMessage('Buscando servidores.').execute();
    })();


    (function() {

        $('pesquisar').observe("click", function pesquisar() {

            var iMatricula = $F('rh01_regist');

            if (iMatricula.trim() == '' || iMatricula.trim().match(/[^\d]+/g)) {

                alert('Informe um número de Matrícula válido para pesquisar.');
                return;
            }

            this.form.submit();
        });

        var oLookUpCgm = new DBLookUp($('lbl_rh01_regist'), $('rh01_regist'), $('z01_nome'), {
            'sArquivo': 'func_rhpessoal.php',
            'oObjetoLookUp': 'func_nome'
        });

        $('envioESocial').addEventListener('click', function() {

            if ($F('tpAmb') == '') {
                alert('Selecione o ambiente de envio.');
                return;
            }

            if ($F('modo') == '') {
                alert('Selecione o tipo de envio.');
                return;
            }

            if ($F('evento') == '') {
                alert('Selecione um evento.');
                return;
            }

            let aArquivosSelecionados = new Array();
            aArquivosSelecionados.push($F('evento'));

            var selectobject = document.getElementById("matriculas");
            var aMatriculas = [];
            for (var iCont = 0; iCont < selectobject.length; iCont++) {
                aMatriculas.push(selectobject.options[iCont].value);
            }

            if (aMatriculas.length == 0) {
                alert('Selecione pelo menos uma matrícula.');
                return;
            }

            var parametros = {
                'exec': 'transmitir',
                'arquivos': aArquivosSelecionados,
                'empregador': $F('cboEmpregador'),
                'modo': $F('modo'),
                'tpAmb': $F('tpAmb'),
                'iAnoValidade': $F('anofolha'),
                'iMesValidade': $F('mesfolha'),
                'indapuracao': $F('indapuracao'),
                'tppgto': $F('tppgto'),
                'tpevento': $F("tpevento"),
                'matricula': aMatriculas.join(',')
            }; //Codigo Tipo::CADASTRAMENTO_INICIAL
            new AjaxRequest('eso4_esocialapi.RPC.php', parametros, function(retorno) {

                alert(retorno.sMessage);
                if (retorno.erro) {
                    return false;
                }
            }).setMessage('Agendando envio para o eSocial').execute();
        });
    })();

    function js_consultar() {

        js_OpenJanelaIframe('top.corpo', 'iframe_consulta_envio', 'func_consultaenvioesocial.php', 'Pesquisa', true);
    }

    function js_adicionar_matric() {
        var selectobject = document.getElementById("matriculas");
        for (var iCont = 0; iCont < selectobject.length; iCont++) {
            if (selectobject.options[iCont].value == $F('rh01_regist')) {
                js_limpar_matric();
                return;
            }
        }
        var select = document.getElementById('matriculas');
        var opt = document.createElement('option');
        opt.value = $F('rh01_regist');
        opt.innerHTML = $F('rh01_regist') + ' - ' + $F('z01_nome');
        select.appendChild(opt);
        js_limpar_matric();
    }

    function js_remover_matric(select) {
        var selectobject = document.getElementById("matriculas");
        for (var iCont = 0; iCont < selectobject.length; iCont++) {
            if (selectobject.options[iCont].value == select.value) {
                selectobject.remove(iCont);
            }
        }
    }

    function js_limpar_matric() {
        $('rh01_regist').value = '';
        $('z01_nome').value = '';
    }

    function js_alt_evento() {
        if ((document.getElementById('evento').value == 'S1200' || document.getElementById('evento').value == 'S1202')) {
            if (document.getElementById('indapuracao_col').style.display == 'none') {
                document.getElementById('indapuracao_col').style.display = 'inline';
            }
            if (document.getElementById('tipo_col').style.display == 'none') {
                document.getElementById('tipo_col').style.display = 'inline';
            }
        } else if ((document.getElementById('evento').value == 'S1210')) {
            if (document.getElementById('tppgto_col').style.display == 'none') {
                document.getElementById('tppgto_col').style.display = 'inline';
            }
        } else {
            document.getElementById('indapuracao_col').style.display = 'none';
            document.getElementById('tppgto_col').style.display = 'none'
            document.getElementById('tipo_col').style.display = 'none';
        }
    }

    function js_dataalt() {
        if (document.getElementById('dtalteracao').style.display == 'none') {
            document.getElementById('dtalteracao').style.display = 'inline';
            return true;
        }
        document.getElementById('dtalteracao').style.display = 'none';
    }
</script>
