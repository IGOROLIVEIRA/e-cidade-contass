<?php
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
require_once("libs/db_stdlib.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_solicita_classe.php");
$clsolicita = new cl_solicita;
$clsolicita->rotulo->label();
?>
<html>

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <?php
    db_app::load("scripts.js,
                  prototype.js,
                  strings.js,
                  arrays.js,
                  windowAux.widget.js,
                  datagrid.widget.js,
                  dbmessageBoard.widget.js,
                  dbcomboBox.widget.js,
                  dbtextField.widget.js,
                  dbtextFieldData.widget.js,
                  DBInputHora.widget.js,
                  datagrid/plugins/DBOrderRows.plugin.js,
                  datagrid/plugins/DBHint.plugin.js");

    db_app::load(
        "estilos.css,
    grid.style.css"
    );
    ?>
</head>

<body bgcolor="#cccccc">
<form name="form1" id='frmMaterialServico' method="post" style='margin-top: 25px'>
    <center>
        <div style='display:table;'>
            <fieldset>
                <legend style="font-weight: bold">Material / Serviço </legend>
                <table border='0'>
                    <tr>
                        <td>
                            <?php db_ancora("Solicitação:","js_pesquisapc10_numero(true);",1); ?>
                        </td>
                        <td>
                            <?php
                            db_input("pc10_numero",10,$Ipc10_numero,true,"text",1,"onchange='js_pesquisapc10_numero(false);'");
                            db_input("pc10_resumo",60,$Ipc10_resumo,true,"text",3,"");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap="nowrap" title="<?=$Tl20_codigo?>">
                            <?db_ancora("Licitação:","js_pesquisa_liclicita(true);",1);?>
                        </td>
                        <td>
                            <?php
                            db_input("l20_codigo",10,$Il20_codigo,true,"text",1,"onchange='js_pesquisa_liclicita(false);'");
                            db_input("l20_objeto",60,$Il20_objeto,true,"text",3,"");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?php echo $Tac16_sequencial; ?>" width="130">
                            <?php db_ancora("Contrato:", "js_acordo(true);",1); ?>
                        </td>
                        <td>
                            <?php
                            db_input('ac16_sequencial', 10, $Iac16_sequencial, true, 'text', 1, "onchange='js_acordo(false);'");
                            db_input('ac16_resumoobjeto', 60, $Iac16_resumoobjeto, true, 'text', 3);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="À partir de qual data">
                            <?php db_ancora("Código de: ", "pesquisaCodigoMaterialServico(true, `inicial`);",1); ?>
                        </td>
                        <td>
                            <?php db_input('iCodigoMaterialInicial',10, true, 1, 'text', 1, "onchange='pesquisaCodigoMaterialServico(false, `inicial`);'"); ?>
                            <b><?php db_ancora('a', "pesquisaCodigoMaterialServico(true, `final`);",1); ?></b>
                            <?php db_input('iCodigoMaterialFinal', 10, true, 1, 'text', 1, "onchange='pesquisaCodigoMaterialServico(false, `final`);'"); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Codigo Sicom:</strong></td>
                        <td>
                            <?php db_input('db150_coditem', 10, $Idb150_coditem, true, 'text', 1, "");?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="Atualizar para">
                            <strong>Atualizar para:</strong>
                        </td>
                        <td>
                            <?php
                            db_inputdata('iAtualizarDataPara', "", "", "", true, 'text', 1)
                            ?>
                            <b></b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input name="btnAplicar" id="btnAplicar" type="button" value="Aplicar"  onclick='atualizarDataPara();' >
                            <input name="btnProcessar" id="btnProcessar" type="button" value="Processar"  onclick='consultaCodigoMaterial();' >
                            <input name="btnAplicarSicom" id="btnAplicarSicom" type="button" value="Aplicar Sicom"  onclick='atualizarDataParaSicom();' >
                        </td>
                    </tr>
                </table>
                <fieldset style='width:1000px;'>
                    <div id='ctnGridMaterialServico'></div>
                </fieldset>
            </fieldset>
        </div>
        <input name="btnAtualizar" id="btnAtualizar" type="button" value="Atualizar"  onclick='atualizarMateriaisSelecionados();' >
    </center>
</form>
</body>
<script>
    const sUrlRpc = 'm4_controledatas.RPC.php';
    let oGridMaterialServico = new DBGrid('gridMaterialServico');
    oGridMaterialServico.nameInstance = 'oGridMaterialServico';
    oGridMaterialServico.setCheckbox(0);
    oGridMaterialServico.setCellWidth( [ '0%', '10%', '15%','5%','10%', '45%', '15%', '15%','10%' ] );
    oGridMaterialServico.setHeader( [ 'codigo', 'Código','Código Sicom','Tipo','Unidade', 'Descrição', 'Data', 'Data Sicom', 'Cód. Anterior'] );
    oGridMaterialServico.setCellAlign( [ 'center', 'center', 'center', 'left','left','left', 'center', 'center', 'center' ] );
    oGridMaterialServico.setHeight(260);
    oGridMaterialServico.aHeaders[1].lDisplayed = false;
    oGridMaterialServico.show($('ctnGridMaterialServico'));
    let aMateriaisCadastrados = [];
    let sInicialFinal = '';

    function consultaCodigoMaterial() {
        let oParametros = {};
        let iSolicitacao = $F('pc10_numero');
        let iLicitacao = $F('l20_codigo');
        let iContrato = $F('ac16_sequencial');
        let iCodigoSicom = $F('db150_coditem');

        oParametros.exec = 'consultaCodigoMaterial';
        oParametros.codigoMaterialIinicial = $F('iCodigoMaterialInicial');
        oParametros.codigoMaterialFinal = $F('iCodigoMaterialFinal');

        if(iSolicitacao){
            oParametros.exec = 'consultaCodigoMaterialSolicitacao';
            oParametros.codigoMaterialIinicial = $F('iCodigoMaterialInicial');
            oParametros.codigoMaterialFinal = $F('iCodigoMaterialFinal');
            oParametros.iSolicitacao = iSolicitacao;
        }

        if(iLicitacao){
            oParametros.exec = 'consultaCodigoMaterialLicitacao';
            oParametros.codigoMaterialIinicial = $F('iCodigoMaterialInicial');
            oParametros.codigoMaterialFinal = $F('iCodigoMaterialFinal');
            oParametros.iLicitacao = iLicitacao;
        }

        if(iContrato){
            oParametros.exec = 'consultaCodigoMaterialContrato';
            oParametros.codigoMaterialIinicial = $F('iCodigoMaterialInicial');
            oParametros.codigoMaterialFinal = $F('iCodigoMaterialFinal');
            oParametros.iContrato = iContrato;
        }

        if(iCodigoSicom){
            oParametros.exec = 'consultaCodigoSicom';
            oParametros.codigoMaterialSicom = iCodigoSicom;
        }

        js_divCarregando('Aguarde, Atualizando leituras...<br>Esse procedimento pode levar algum tempo.', 'msgBox');
        new Ajax.Request(sUrlRpc, {
            method: 'post',
            parameters: 'json=' + Object.toJSON(oParametros),
            onComplete: function(oResponse) {
                const oRetorno = eval("(" + oResponse.responseText + ")");
                aMateriaisCadastrados = oRetorno.materiais;
                js_removeObj('msgBox');
                renderizaMateriais();
                if (oRetorno.status === 2) {
                    alert(oRetorno.message.urlDecode());
                }
            }
        });
    }

    function validaCodigoMaterial(codigo) {
        if (typeof codigo === 'string' && codigo.trim() === '') {
           alert('O intervalo código do material não pode ser vazio!');
           oGridMaterialServico.clearAll(true);
           return;
        }

        return true;
    }

    function pesquisaCodigoMaterialServico(mostra, inicial_final) {
        sInicialFinal = inicial_final;
        const sAbreUrl =
            'func_pcmater_controledatas.php?funcao_js=parent.preencheEscondeCodigoMaterialServico|pc01_codmater';
        const deveAparecer = !!mostra;

        js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_pcmater', sAbreUrl, 'Pesquisa', deveAparecer);
    }

    function preencheEscondeCodigoMaterialServico(codigoMaterial) {
        if (codigoMaterial === '') {
            return;
        }

        const codigoMaterialCompara = $F('iCodigoMaterialInicial');

        if ((typeof sInicialFinal === 'string' && sInicialFinal === 'final')
            && Number(codigoMaterialCompara) > Number(codigoMaterial)
        ) {
            alert('Informe um material final maior que o material inicial ' + codigoMaterialCompara);
            return;
        }

        if (typeof sInicialFinal === 'string' && sInicialFinal === 'inicial') {
            document.querySelector(
                'form[name="form1"] input[name="iCodigoMaterialInicial"]'
            ).value = codigoMaterial;
        }

        if (typeof sInicialFinal === 'string' && sInicialFinal === 'final') {
            document.querySelector(
                'form[name="form1"] input[name="iCodigoMaterialFinal"]'
            ).value = codigoMaterial;
        }

        db_iframe_pcmater.hide();
    }

    function renderizaMateriais() {
        oGridMaterialServico.clearAll(true);
        aMateriaisCadastrados.each (function ( oMaterial, iMaterial ) {
            let aLinha = [];
            aLinha.push(oMaterial.codigo);
            aLinha.push(oMaterial.codigo);
            aLinha.push(oMaterial.db150_coditem);
            aLinha.push(oMaterial.db150_tipocadastro);
            aLinha.push(oMaterial.db150_unidademedida);
            aLinha.push(oMaterial.descricao.urlDecode());
            const sDBDataFormatada = oMaterial.data.split('-').reverse().join('/');
            const sDBData = oMaterial.data.length ? sDBDataFormatada : "";
            const iData = new DBTextFieldData(
                'oDBTextFieldData' + iMaterial,
                'oDBTextFieldData' + iMaterial,
                sDBData,
                10
            ).toInnerHtml();
            aLinha.push(iData);
            const sDBDataAlteracaoFormatada = oMaterial.dataalteracao.split('-').reverse().join('/');
            const sDBDataAlteracao = oMaterial.dataalteracao.length ?  sDBDataAlteracaoFormatada : "";
            const iDataAlteracao = new DBTextFieldData(
                'oDBTextFieldDataAlteracao' + iMaterial,
                'oDBTextFieldDataAlteracao' + iMaterial,
                sDBDataAlteracao,
                10
            ).toInnerHtml();
            aLinha.push(iDataAlteracao);
            aLinha.push(oMaterial.pc01_codmaterant);
            oGridMaterialServico.addRow(aLinha);
        });
        oGridMaterialServico.renderRows();

        aMateriaisCadastrados.each (function ( oMaterial, iMaterial ) {
            oGridMaterialServico.setHint(iMaterial, 6, oMaterial.descricao.urlDecode());
        });
    }

    function atualizarDataPara() {
        if (Array.isArray(aMateriaisCadastrados) && !aMateriaisCadastrados.length) {
            alert('Nenhum material/serviço listado para atualizar data!');
            return;
        }

        const iAtualizarDataPara = $F('iAtualizarDataPara');

        if (iAtualizarDataPara.length === 0) {
            alert('Insira uma data para atualizar o(s) material(iais)/serviço(s) listado(s)!');
            return;
        }

        if (!oGridMaterialServico.getSelection('array').length) {
            alert('Nenhum material/serviço selecionado para atualizar data!');
            return;
        }

        const iLinhas = oGridMaterialServico.aRows.length;

        for (let i = 0; i < iLinhas; i++) {
            if (oGridMaterialServico.aRows[i].isSelected) {
                let oCheckGrid = document.getElementById(
                    oGridMaterialServico.aRows[i].aCells[7].getId()
                ).firstChild;
                oCheckGrid.value = iAtualizarDataPara;
            }
        }
    }

    function atualizarDataParaSicom (){
        if (Array.isArray(aMateriaisCadastrados) && !aMateriaisCadastrados.length) {
            alert('Nenhum material/serviço listado para atualizar data!');
            return;
        }

        const iAtualizarDataPara = $F('iAtualizarDataPara');

        if (iAtualizarDataPara.length === 0) {
            alert('Insira uma data para atualizar o(s) material(iais)/serviço(s) listado(s)!');
            return;
        }

        if (!oGridMaterialServico.getSelection('array').length) {
            alert('Nenhum material/serviço selecionado para atualizar data!');
            return;
        }

        const iLinhas = oGridMaterialServico.aRows.length;

        for (let i = 0; i < iLinhas; i++) {
            if (oGridMaterialServico.aRows[i].isSelected) {
                let oCheckGrid = document.getElementById(
                    oGridMaterialServico.aRows[i].aCells[8].getId()
                ).firstChild;
                oCheckGrid.value = iAtualizarDataPara;
            }
        }
    }

    function atualizarMateriaisSelecionados() {
        const aMateriaisSelecionados = oGridMaterialServico.getSelection('array');

        if (Array.isArray(aMateriaisSelecionados) && !aMateriaisSelecionados.length) {
            alert('Selecione um material/serviço para atualizar!');
            return;
        }

        let aMateriaisParaAtualizacao = new Array(aMateriaisSelecionados.length)
            .fill(null)
            .map(() => ({
                codigo: 0,
                data: '',
                data_alteracao: '',
            }));

        aMateriaisSelecionados.each(
            function (oMaterialSelecionado, iMaterialSeleciona) {
                aMateriaisParaAtualizacao[iMaterialSeleciona].codigo =
                    oMaterialSelecionado[1];
                aMateriaisParaAtualizacao[iMaterialSeleciona].data =
                    oMaterialSelecionado[7];
                aMateriaisParaAtualizacao[iMaterialSeleciona].data_alteracao =
                    oMaterialSelecionado[8];
                aMateriaisParaAtualizacao[iMaterialSeleciona].codigo_sicom =
                    oMaterialSelecionado[3];
                aMateriaisParaAtualizacao[iMaterialSeleciona].tipo =
                    oMaterialSelecionado[4];
            }
        );

        const verificaDatasVaziasNoGrid = aMateriaisParaAtualizacao.some(
            (item) => typeof item === 'object' && item.data === '');

        if (verificaDatasVaziasNoGrid) {
            alert('Insira uma data para atualizar o(s) material(ais)!');
            return;
        }

        js_divCarregando('Aguarde, atualizando os dados!', 'msgBox');
        let oParametros = {};
        oParametros.exec = 'atualizarDatasMateriais';
        oParametros.materiaisParaAtualizacao = aMateriaisParaAtualizacao;
        new Ajax.Request(sUrlRpc, {
            method: 'post',
            parameters: 'json=' + Object.toJSON(oParametros),
            onComplete: function (oResponse) {
                js_removeObj('msgBox');
                const oRetorno = eval("(" + oResponse.responseText + ")");
                if (oRetorno.status === 1) {
                    alert('Atualizado(s) com sucesso.');
                } else {
                    alert(oRetorno.message.urlDecode());
                }
            }
        });
    }

    function js_pesquisapc10_numero(mostra){
        if(mostra===true){
            js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_solicita','func_solicita.php?funcao_js=parent.js_mostrapcorcamitem1|pc10_numero|pc10_resumo','Pesquisa',true);
        }else{
            document.form1.pc10_resumo.value = "";
        }
    }

    function js_mostrapcorcamitem1(pc10_numero,pc10_resumo){
        document.form1.pc10_numero.value = pc10_numero;
        document.form1.pc10_resumo.value = pc10_resumo;
        document.form1.l20_codigo.value = '';
        document.form1.l20_objeto.value = '';
        document.form1.ac16_sequencial.value = '';
        document.form1.ac16_resumoobjeto.value = '';
        db_iframe_solicita.hide();
    }

    function js_pesquisa_liclicita(mostra) {
        if(mostra===true){
            js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_liclicita','func_liclicita.php?funcao_js=parent.js_mostraliclicita|l20_codigo|l20_objeto','Pesquisa',true);
        }else{
            document.form1.l20_objeto.value = "";
        }
    }

    function js_mostraliclicita(l20_codigo,l20_objeto,erro) {
        document.form1.l20_codigo.value = l20_codigo;
        document.form1.l20_objeto.value = l20_objeto;
        document.form1.pc10_numero.value = '';
        document.form1.pc10_resumo.value = '';
        document.form1.ac16_sequencial.value = '';
        document.form1.ac16_resumoobjeto.value = '';
        db_iframe_liclicita.hide();
    }

    function js_acordo(mostra){
        if(mostra===true){
            js_OpenJanelaIframe('','db_iframe_acordo', 'func_acordoinstit.php?funcao_js=parent.js_mostraAcordo1|ac16_sequencial|ac16_resumoobjeto', 'Pesquisa',true);
        }else{
            document.form1.ac16_resumoobjeto.value = "";
        }
    }

    function js_mostraAcordo1(ac16_sequencial,ac16_resumoobjeto, erro){
        document.form1.ac16_sequencial.value = ac16_sequencial;
        document.form1.ac16_resumoobjeto.value = ac16_resumoobjeto;
        document.form1.pc10_numero.value = '';
        document.form1.pc10_resumo.value = '';
        document.form1.l20_codigo.value = '';
        document.form1.l20_objeto.value = '';
        db_iframe_acordo.hide();
    }

</script>
</html>
<?php
db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
?>
