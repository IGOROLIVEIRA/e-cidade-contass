<?php

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_utils.php");
require_once("dbforms/db_funcoes.php");

$clrotulo = new rotulocampo;
$clrotulo->label("rh27_rubric");
$clrotulo->label("rh27_descr");

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
    <form id="formPesquisarEsocial" method="POST" action="eso4_tabeladerubricasindividual001.php" class="container">
        <fieldset>
            <legend>Conferência dos dados informados pelo servidor:</legend>
            <table class="form-container">
                <tr>
                    <td nowrap title="<?php echo $Trh27_rubric; ?>">
                        <a id="lbl_rh27_rubric" for="matricula"><?= $Lrh27_rubric ?></a>
                    </td>
                    <td>
                        <?php db_input('rh27_rubric', 10, $Irh27_rubric, true, "text", 1, "", "", "", "width: 16%"); ?>
                        <?php db_input('rh27_descr', 50, $Irh27_descr, true, "text", 3, "", "", "", "width: 61%"); ?>
                        <input type="button" name="adicionar" value="Adicionar" onclick="js_adicionar_rubrica()" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Rubricas</strong>
                    </td>
                    <td>
                        <select multiple="multiple" name="Rubricas" id="Rubricas" style="width: 78%;"
                        ondblclick="js_remover_rubrica(this);">
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
                <tr style="display:none;">
                    <td align="right"><label for="evento">Evento:</label></td>
                    <td>
                        <select name="evento" id="evento" style="width: 78%;">
                            <option value="S1010">S1010</option>
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

            var iMatricula = $F('rh27_rubric');

            if (iMatricula.trim() == '' || iMatricula.trim().match(/[^\d]+/g)) {

                alert('Informe um número de Matrícula válido para pesquisar.');
                return;
            }

            this.form.submit();
        });

        var oLookUpCgm = new DBLookUp($('lbl_rh27_rubric'), $('rh27_rubric'), $('rh27_descr'), {
            'sArquivo': 'func_rhrubricas.php',
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

            var selectobject = document.getElementById("Rubricas");
            var aRubricas = [];
            for (var iCont = 0; iCont < selectobject.length; iCont++) {
                aRubricas.push(selectobject.options[iCont].value);
            }

            if (aRubricas.length == 0) {
                alert('Selecione pelo menos uma Rubrica.');
                return;
            }

            var parametros = {
                'exec': 'transmitirrubricas',
                'arquivos': aArquivosSelecionados,
                'empregador': $F('cboEmpregador'),
                'modo': $F('modo'),
                'tpAmb': $F('tpAmb'),
                'iAnoValidade': $F('anofolha'),
                'iMesValidade': $F('mesfolha'),
                'rubricas': aRubricas.join(',')
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
    function js_adicionar_rubrica() {
        var selectobject = document.getElementById("Rubricas");
        for (var iCont = 0; iCont < selectobject.length; iCont++) {
            if (selectobject.options[iCont].value == $F('rh27_rubric')) {
                js_limpar_matric();
                return;
            }
        }
        var select = document.getElementById('Rubricas');
        var opt = document.createElement('option');
        opt.value = $F('rh27_rubric');
        opt.innerHTML = $F('rh27_rubric')+' - '+$F('rh27_descr');
        select.appendChild(opt);
        js_limpar_matric();
    }

    function js_remover_rubrica(select) {
        var selectobject = document.getElementById("Rubricas");
        for (var iCont = 0; iCont < selectobject.length; iCont++) {
            if (selectobject.options[iCont].value == select.value) {
                selectobject.remove(iCont);
            }
        }
    }

    function js_limpar_matric() {
        $('rh27_rubric').value = '';
        $('rh27_descr').value = '';
    }
</script>
