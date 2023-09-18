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
                <legend><b>Retenções Pessoa Jurídica</b></legend>
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
                            $oFiltroCredor->func_arquivo   = "func_movimentacaoempenhopago.php";  //func a executar
                            $oFiltroCredor->nomeiframe     = "db_iframe_cgm";
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
                                        <td  nowrap><b>&nbsp;&nbsp; Opção de Seleção :</b>
                                            <?php
                                            $aSelecao = array(2 => "Menos os Selecionados", 1 => "Somente Selecionados");
                                            db_select("sTipoSelecao", $aSelecao, true, 1);
                                            ?>
                                        </td>
           
                    </tr>
                    <tr>
                        <td>
                            <fieldset style="margin:0 auto 0 auto; width: 500px;">
                                <legend><b>Período</b></legend>
                                <table>
                                
                                    <tr>    
                                        
                                            <?php
                                            $aPeriodoDatas = explode('-', date('Y-m-d', db_getsession('DB_datausu')));
                                            list($iAnoInicial, $iMesInicial, $iDiaInicial) = $aPeriodoDatas;
                                            ?>
                                           
                                                <td nowrap title="<?=$TDBtxt21?>">
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
                                        <td><b>Referência:</b></td>
                                        <td>
                                            <?php
                                            $aReferencia = array(0 => "Selecione...", 1 => "Liquidação", 2 => "Nota Fiscal");
                                            db_select("sReferencia", $aReferencia, true, 1);
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Quebra:</b></td>
                                        <td>
                                            <?php
                                            $aQuebra = array(1 => "Não", 2 => "Sim");
                                            db_select("sQuebra", $aQuebra, true, 1);
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Tipo:</b></td>
                                        <td>
                                            <?php
                                            $aTipo = [
                                                1 => "Com Retenções",
                                                2 => "Sem Retenções",
                                                3 => "Somente Retenções IR",
                                                4 => "Somente Retenções INSS",
                                                5 => "Todos"
                                            ];
                                            db_select("sTipo", $aTipo, true, 1);
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Tipo Impressão:</b></td>
                                        <td>
                                            <?php
                                            $aOrdem = array(1 => "PDF");
                                            // $aOrdem = array(0 => "Selecione...", 1 => "PDF", 2 => "CSV");
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

        function OpenWithPost(dados, name){

            let referencia = $F('sReferencia');

            if (referencia == 0){
                alert("Selecione Uma Referencia de Data!")
                return false
            }

            let tipoImpressao = $F('sTipoImpressao');

            if (tipoImpressao == 0){
                alert("Selecione um Tipo de Impressão!")
                return false
            }

            let tipo = $F('sTipo');
            
            if (tipo == 0){
                alert("Selecione um Tipo!")
                return false
            }

            var mapForm = document.createElement("form");
            mapForm.target = name;
            mapForm.method = "POST";
            if (tipoImpressao == 1) {
                mapForm.action = "emp2_reinf002.php";
            }else {
                mapForm.action = "emp2_reinf002.php";
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
        dados['sTipo']                       = $F('sTipo');
        dados['sQuebra']                     = $F('sQuebra');
        dados['sTipoSelecao']                = $F('sTipoSelecao');
        dados['sReferencia']                 = $F('sReferencia');

        var name = new Date().getTime();
        OpenWithPost(dados, name);

    });
    $('sReferencia').style.width =' 100%';
    $('sReferencia').value = 2;

</script>
</html>