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

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("dbforms/db_classesgenericas.php");

$cliframe_seleciona = new cl_iframe_seleciona;
$oRotuloFornemensalemp = new rotulo('fornemensalemp');
$oRotuloFornemensalemp->label();

?>
<html>
<head>
    <title>DBSeller Informática Ltda - Página Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/datagrid.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/DBToogle.widget.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <style>
        #ctnFornecedoresMensaisEmpenhos select {
            width: 150px;

        }

        #fieldset_credor {
            width: 500px;
            text-align: center;
        }

        #fieldset_credor table {
            margin: 0 auto;
        }

    </style>
</head>
<body style="margin-top: 25px; background-color: #cccccc;z-index: 99">
<div id="ctnFornecedoresMensaisEmpenhos">
    <form name="form1" id="form1" method="POST">
        <center>
            <fieldset style="margin:25px auto 0 auto; width: 500px;">
                <legend><b>Fornecedores Mensais</b></legend>
                <table>
                    <tr id="trFieldsetCredor">
                        <td >
                            <?php
                            /*
                             * Seleção de Credor
                             */
                            $oFiltroCredor                 = new cl_arquivo_auxiliar();
                            $oFiltroCredor->cabecalho      = "<strong>Credor</strong>";
                            $oFiltroCredor->codigo         = "z01_numcgm"; //chave de retorno da func
                            $oFiltroCredor->descr          = "z01_nome";   //chave de retorno
                            $oFiltroCredor->nomeobjeto     = 'credor';
                            $oFiltroCredor->funcao_js      = 'js_mostra';
                            $oFiltroCredor->funcao_js_hide = 'js_mostra1';
                            $oFiltroCredor->sql_exec       = "";
                            $oFiltroCredor->func_arquivo   = "func_fornemensalemp.php";  //func a executar
                            $oFiltroCredor->nomeiframe     = "db_iframe_fornemensalemp";
                            $oFiltroCredor->localjan       = "";
                            $oFiltroCredor->db_opcao       = 2;
                            $oFiltroCredor->tipo           = 2;
                            $oFiltroCredor->top            = 1;
                            $oFiltroCredor->linhas         = 5;
                            $oFiltroCredor->vwidth         = 400;
                            $oFiltroCredor->nome_botao     = 'db_lanca';
                            $oFiltroCredor->fieldset       = false;
                            $oFiltroCredor->Labelancora    = "Credor:";
                            $oFiltroCredor->funcao_gera_formulario();
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <fieldset style="margin:0 auto 0 auto; width: 500px;">
                                <legend><b>Filtros</b></legend>
                                <table>
                                    <tr>
                                        <td>
                                            <?php
                                            $aPeriodoDatas = explode('-', date('Y-m-d', db_getsession('DB_datausu')));
                                            list($iAnoInicial, $iMesInicial, $iDiaInicial) = $aPeriodoDatas;
                                            ?>
                                            <table>
                                                <td nowrap align="right" title="<?=$TDBtxt21?>">
                                                    <b>Data Inicial:</b>
                                                </td>
                                            <td>
                                            <?php
                                            db_inputdata("dtDataInicial", $iDiaInicial, $iMesInicial, $iAnoInicial, true, 'text', 1);
                                            ?>
                                            </td>
                                                <td nowrap align="right" title="<?=$TDBtxt22?>">
                                                    <b>Data Final:</b>
                                                </td>
                                            <td>
                                            <?php
                                            db_inputdata("dtDataFinal", $iDiaInicial, $iMesInicial, $iAnoInicial, true, 'text', 1);
                                            ?>
                                            </td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Tipo:</b></td>
                                        <td>
                                            <?php
                                            $aOrdem = array(0 => "Selecione...", 1 => "Sintético", 2 => "Analítico");
                                            db_select("sTipoImpressao", $aOrdem, true, 1);
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <br />
            <center>
                <input type="button" id="btnEmitir" value="Emitir" />
            </center>
        </center>
    </form>
</div>
<?php
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>

<script>
    oDBToogleCredores = new DBToogle('fieldset_credor', true);

    $('btnEmitir').observe('click', function() {

        var iTotalCredores        = $('credor').length;
        var aCredoresSelecionados = $('credor');
        var sCredoresSelecionados = "";
        var sVirgula              = "";


        for (var iRowCredor = 0; iRowCredor < iTotalCredores; iRowCredor++) {
            var oDadosCredor = aCredoresSelecionados[iRowCredor];
            sCredoresSelecionados += sVirgula+oDadosCredor.value;
            sVirgula               = ", ";
        }

        var sDataInicialBanco = js_formatar($F('dtDataInicial'), 'd');
        var sDataFinalBanco   = js_formatar($F('dtDataFinal'), 'd');


        if (sDataInicialBanco > sDataFinalBanco) {
            alert("A data inicial é maior que a data final. Verifique!");
            return false;
        }
        if (sDataInicialBanco == '') {
            alert("Informe a data inicial!");
            return false;
        }
        if (sDataFinalBanco == '') {
            alert("Informe a data final!");
            return false;
        }

        function OpenWithPost(dados, name){

            let tipoImpressao = $F('sTipoImpressao');

            if (tipoImpressao == 0){
                alert("Selecione um Tipo de Impressão!")
                return false
            }

            var mapForm = document.createElement("form");
            mapForm.target = name;
            mapForm.method = "POST";
            if (tipoImpressao == 1) {
                mapForm.action = "emp2_fornemensalemp002.php";
            }else {
                mapForm.action = "emp2_fornemensalemp003.php";
            }
            document.body.appendChild(mapForm);

            for(var key in dados){
                var input   = document.createElement("input");
                input.type  = 'hidden';
                input.name  = key;
                input.value = dados[key];
                mapForm.appendChild(input);
            }

            windowfeature = 'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0';
            var map = window.open("", name, windowfeature);
            if (map) {
                mapForm.submit();
            }
        }

        var dados = [];
        dados['sCredoresSelecionados']       = sCredoresSelecionados;
        dados['dtDataInicial']               = $F('dtDataInicial');
        dados['dtDataFinal']                 = $F('dtDataFinal');
        dados['sTipoImpressao']              = $F('sTipoImpressao');

        var name = new Date().getTime();
        OpenWithPost(dados, name);

    });


</script>
</html>
