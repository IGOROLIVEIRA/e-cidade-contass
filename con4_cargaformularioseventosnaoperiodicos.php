<?php

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_utils.php");
require_once("dbforms/db_funcoes.php");


?>

<html>

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/AjaxRequest.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div style="width: 60%" class="container">
        <fieldset>
            <legend>
                Processamento da Carga do Formulário
            </legend>
            <table id="tblFormularios">
                <tr>
                    <td>
                        <input type="checkbox" value="4000102">
                    </td>
                    <td>
                        <label>S-2200 - Cadastramento Inicial do Vínculo e Admissão/Ingresso de Trabalhador</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" value="4000103">
                    </td>
                    <td>
                        <label>S-2205 - Alteração de Dados Cadastrais do Trabalhador</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" value="4000104">
                    </td>
                    <td>
                        <label>S-2206 - Alteração de Contrato de Trabalho/Relação Estatutária</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" value="4000113">
                    </td>
                    <td>
                        <label>S-2300 - Trabalhador Sem Vínculo de Emprego/Estatutário</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" value="4000114">
                    </td>
                    <td>
                        <label>S-2306 - Trabalhador Sem Vínculo de Emprego/Estatutário - Alteração Contratual</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" value="4000116">
                    </td>
                    <td>
                        <label>S-2400 - Cadastro de Beneficiário</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" value="4000118">
                    </td>
                    <td>
                        <label>S-2410 - Cadastro de benefício</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" value="4000112">
                    </td>
                    <td>
                        <label>S-2299 - Desligamento</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" value="4000108">
                    </td>
                    <td>
                        <label>S-2230 - Afastamento Temporario</label>
                    </td>
                </tr>
            </table>
        </fieldset>
        <input type="button" value="Processar" id="btnProcessar">
        <input type="button" value="Marcar Todos" id="btnMarcarTodos">
        <input type="button" value="Desmarcar Todos" id="btnDesmarcarTodos">
        <input type="button" value="Remover Carga" id="btnRemoverCarga">
    </div>
</body>

</html>
<?php
db_menu();
?>
<script>
    (function(exports) {
        const URL_RPC = 'con4_processarcargaformulario.RPC.php';

        var btnProcessar = $('btnProcessar');
        var btnMarcarTodos = $('btnMarcarTodos');
        var btnDesmarcarTodos = $('btnDesmarcarTodos');
        var btnRemoverCarga = $('btnRemoverCarga');

        function processar() {

            var arquivos = $$("input[type='checkbox']");

            if (arquivos.length == 0) {

                alert('Selecione ao menos um arquivo.');
                return false;
            }
            var listaArquivos = [];
            arquivos.forEach(function(arquivo, iSeq) {
                if (arquivo.checked == true) {
                    listaArquivos.push(arquivo.value);
                }
            })

            var request = {
                exec: 'processar',
                formularios: listaArquivos
            };

            new AjaxRequest(URL_RPC, request, function(response, erro) {

                alert(response.mensagem);
                if (erro) {
                    return false;
                }
            }).setMessage('Aguarde, processando Arquivos. Esse processamento pode demorar alguns minutos...').execute();
        }

        /**
         * Selecionar ou marca todos os checkboxes
         * @param marcar
         */
        function selecionarOuDesmarcarTodos(marcar) {

            var arquivos = $$("input[type='checkbox']");
            for (arquivo of arquivos) {
                arquivo.checked = marcar;
            }
        }

        function removerCarga() {

            if (!confirm('Confirma exclusão da carga dos eventos marcados para o ano e mês do sistema?')) {
                return;
            }
            
            var arquivos = $$("input[type='checkbox']");

            if (arquivos.length == 0) {

                alert('Selecione ao menos um arquivo.');
                return false;
            }
            var listaArquivos = [];
            arquivos.forEach(function(arquivo, iSeq) {
                if (arquivo.checked == true) {
                    listaArquivos.push(arquivo.value);
                }
            })

            var request = {
                exec: 'remover',
                formularios: listaArquivos
            };

            new AjaxRequest(URL_RPC, request, function(response, erro) {

                alert(response.mensagem);
                if (erro) {
                    return false;
                }
            }).setMessage('Aguarde, processando Arquivos. Esse processamento pode demorar alguns minutos...').execute();
        }

        btnProcessar.observe('click', function() {
            processar();
        }.bind(this));

        btnMarcarTodos.observe('click', function() {
            selecionarOuDesmarcarTodos(true);
        }.bind(this));

        btnDesmarcarTodos.observe('click', function() {
            selecionarOuDesmarcarTodos(false);
        }.bind(this));

        btnRemoverCarga.observe('click', function() {
            removerCarga();
        }.bind(this));
    })(window);
</script>