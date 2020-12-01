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
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("model/Dotacao.model.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_pcproc_classe.php");
require_once("classes/db_pcparam_classe.php");
require_once("classes/db_solicita_classe.php");
require_once("classes/db_pctipocompra_classe.php");
require_once("classes/db_emptipo_classe.php");
require_once("classes/db_empautoriza_classe.php");
require_once("classes/db_cflicita_classe.php");

$clpcproc = new cl_pcproc;
$clcflicita = new cl_cflicita;
$clpcparam = new cl_pcparam;
$clpctipocompra = new cl_pctipocompra;
$clsolicita = new cl_solicita;
$clemptipo = new cl_emptipo;
$clempautoriza = new cl_empautoriza;
$clempautoriza->rotulo->label();
$clpcproc->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("pc12_tipo");
$clrotulo->label("e54_codtipo");
$clrotulo->label("e54_autori");
$clrotulo->label("e54_destin");
$clrotulo->label("e54_numerl");
$clrotulo->label("e54_tipol");
$clrotulo->label("pc10_numero");
$clrotulo->label("pc10_resumo");
$clrotulo = new rotulocampo;
$clrotulo->label("ac16_sequencial");
$clrotulo->label("ac16_resumoobjeto");

// funcao do sql
function sql_query_file ( $c99_anousu=null,$c99_instit=null,$campos="*",$ordem=null,$dbwhere=""){
    $sql = "select ";
    if($campos != "*" ){
        $campos_sql = split("#",$campos);
        $virgula = "";
        for($i=0;$i<sizeof($campos_sql);$i++){
            $sql .= $virgula.$campos_sql[$i];
            $virgula = ",";
        }
    }else{
        $sql .= $campos;
    }
    $sql .= " from condataconf ";
    $sql2 = "";
    if($dbwhere==""){
        if($c99_anousu!=null ){
            $sql2 .= " where condataconf.c99_anousu = $c99_anousu ";
        }
        if($c99_instit!=null ){
            if($sql2!=""){
                $sql2 .= " and ";
            }else{
                $sql2 .= " where ";
            }
            $sql2 .= " condataconf.c99_instit = $c99_instit ";
        }
    }else if($dbwhere != ""){
        $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if($ordem != null ){
        $sql .= " order by ";
        $campos_sql = split("#",$ordem);
        $virgula = "";
        for($i=0;$i<sizeof($campos_sql);$i++){
            $sql .= $virgula.$campos_sql[$i];
            $virgula = ",";
        }
    }
    return $sql;
}

$result = db_query(sql_query_file(db_getsession('DB_anousu'),db_getsession('DB_instit')));
$c99_data = db_utils::fieldsMemory($result, 0)->c99_data;

$x = str_replace('\\','',$_POST);
$x = json_decode($x['json']);

if($x->consultarDataDoSistema == true){

    $dataDoSistema = date("Y-m-d", db_getsession('DB_datausu'));
    $lProcessar = isset($x->lProcessar) ? $x->lProcessar : false;

    //echo $oJson->encode($oRetorno);
    echo json_encode(array('dataDoSistema'=>$dataDoSistema, 'dataFechamentoContabil' => $c99_data, 'processar'=>$lProcessar));
    die();
}

?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <?
    db_app::load("scripts.js, strings.js, datagrid.widget.js, windowAux.widget.js,dbautocomplete.widget.js");
    db_app::load("dbmessageBoard.widget.js, prototype.js, dbtextField.widget.js, dbcomboBox.widget.js, widgets/DBHint.widget.js");
    db_app::load("estilos.css, grid.style.css");
    ?>
</head>
<style>
    /*#e54_numerl{*/
    /*width: 98px;*/
    /*}*/
    #e54_nummodalidade{
        width: 110px;
    }
</style>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
<input id="dataDoSistema" type="hidden" value="<?php echo date("Y-m-d", db_getsession('DB_datausu')); ?>">
<br>
<br>
<center>
    <fieldset style="width: 75%;">
        <legend><b>Gerar Autorizações</b></legend>
        <table style='width: 100%' border='0'>
            <tr>
                <td width="100%">
                    <table width="100%">
                        <tr style="text-align: center;">
                            <td title="<?php echo $Tac16_sequencial ; ?>">
                                <?php db_ancora($Lac16_sequencial, "js_pesquisaac16_sequencial(true);", 1); ?>
                                <span id='ctnTxtCodigoAcordo'></span>
                                <span id='ctnTxtDescricaoAcordo'></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: center">
                                <input type="button" value='Pesquisar' id='btnPesquisarPosicoes'>
                            </td>
                        </tr>
                        <tr>
                            <td colspan='3'>
                                <fieldset>
                                    <div id='ctnGridPosicoes'>
                                    </div>
                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <td colspan='3'>
                                <fieldset>
                                    <div id='ctnGridItens'>
                                    </div>
                                </fieldset>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align: center">
                </td>
            </tr>
        </table>
    </fieldset>
    <input type='button' value='Visualizar Autorizações' onclick="js_buscarInformacoesAutorizacao();" style="margin-top: 10px;">
</center>
<div id='frmDadosAutorizacao' style='display: none'>
    <form name='form1'>
        <center>
            <table>
                <tr>
                    <td>
                        <fieldset><legend><b>Dados Complementares</b></legend>
                            <table>
                                <tr>
                                    <td nowrap title="<?=@$Tpc12_tipo?>">
                                        <?=@$Lpc12_tipo?>
                                    </td>
                                    <td>
                                        <?
                                        $parampesquisa = true;
                                        if(isset($tipodecompra)){
                                            $e54_codcom = $tipodecompra;
                                        }
                                        $instit = db_getsession("DB_instit");
                                        if((isset($pc12_tipo) && $pc12_tipo=='' || !isset($pc12_tipo)) && !isset($tipodecompra)){
                                            $somadata = $clpcparam->sql_record($clpcparam->sql_query_file($instit,"pc30_tipcom as e54_codcom"));
                                            if($clpcparam->numrows>0){
                                                db_fieldsmemory($somadata,0);
                                            }
                                        }
                                        $result_tipocompra=$clpctipocompra->sql_record($clpctipocompra->sql_query_file(null,"pc50_codcom,pc50_descr"));
                                        db_selectrecord("e54_codcom",$result_tipocompra,true,1,"","","","","js_buscarTipoLicitacao(this.value)");

                                        ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td nowrap title="<?=@$Te54_tipol?>">
                                        <?=@$Le54_tipol?>
                                    </td>
                                    <td>
                                        <?
                                        if(isset($tipodecompra) || isset($e54_codcom)) {
                                            if(isset($e54_codcom) && empty($tipodecompra)) {
                                                $tipodecompra=$e54_codcom;
                                            }
                                            $result=$clcflicita->sql_record($clcflicita->sql_query_file(null,"l03_tipo,l03_descr",
                                                '',"l03_codcom=$tipodecompra"));
                                            if($clcflicita->numrows>0){
                                                db_selectrecord("e54_tipol",$result,true,1,"","","");
                                                $dop=1;
                                            }else{
                                                $e54_tipol='';
                                                $e54_numerl='';
                                                db_input('e54_tipol',8,$Ie54_tipol,true,'text',3);
                                                $dop=3;
                                            }
                                        }else{
                                            $dop=3;
                                            $e54_tipol='';
                                            $e54_numerl='';
                                            db_input('e54_tipol',8,$Ie54_tipol,true,'text',3);
                                        }
                                        ?>
                                        <?=@$Le54_numerl?>
                                        <?
                                        db_input('e54_numerl',16,$Ie54_numerl,true,'text',$dop, "", "", "","",16);
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td nowrap title="<?=@$Te54_codtipo?>">
                                        <?=$Le54_codtipo?>
                                    </td>
                                    <td>
                                        <?
                                        $result=$clemptipo->sql_record($clemptipo->sql_query_file(null,"e41_codtipo,e41_descr"));
                                        db_selectrecord("e54_codtipo",$result,true,1);
                                        ?>
                                        <strong>Modalidade:</strong>
                                        <?
                                        db_input('e54_nummodalidade',7,"",true,'text',1,"onkeyup='somenteNumeros(this)';");
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td nowrap title="Característica Peculiar">
                                        <?php
                                        db_ancora("<b>Característica Peculiar:</b>","js_pesquisaCaracteristicaPeculiar(true);", 1);
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        db_input('iSequenciaCaracteristica', 5, '', true, 'text', 2, "onchange='js_pesquisaCaracteristicaPeculiar(false);'");
                                        db_input('sDescricaoCaracteristica', 31, '', true, 'text', 3);
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td nowrap title="<?=@$Te54_destin?>">
                                        <?=$Le54_destin?>
                                    </td>
                                    <td>
                                        <?
                                        db_input("e54_destin",40,$Ie54_destin,true,"text",1);
                                        ?>
                                    </td>
                                </tr>
                                <?
                                $db_opcao=1;
                                ?>

                                <tr>
                                    <td nowrap title="<?=@$Te54_praent?>">
                                        <?=@$Le54_praent?>
                                    </td>
                                    <td>
                                        <?
                                        db_input('e54_praent',30,$Ie54_praent,true,'text',$db_opcao,"")
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td nowrap title="<?=@$Te54_conpag?>">
                                        <?=@$Le54_conpag?>
                                    </td>
                                    <td>
                                        <?
                                        db_input('e54_conpag',30,$Ie54_conpag,true,'text',$db_opcao,"")
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td nowrap title="<?=@$Te54_conpag?>" colspan="3">
                                        <fieldset>
                                            <legend><b>Observacoes</b></legend>

                                            <?
                                            db_textarea('e54_resumo', 3, 54, 'e54_resumo', true, 'text', $db_opcao,"")
                                            ?>
                                        </fieldset>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center">
                        <input type='button' value='Incluir Autorizações' onclick="js_consultarDataDoSistema(false)">
                    </td>
                </tr>
            </table>
        </center>
    </form>
</div>

<script src="scripts/math.min.js">
</script>

</body>
</html>
<script>

    var sUrlRpc = 'con4_contratosmovimentacoesfinanceiras.RPC.php';
    /**
     * Pesquisa acordos
     */
    var iPosicaoAtual = 0;

    /**
     * Quantidade de casas decimais para tratar
     */
    var iCasasDecimais = 2;

    /**
     * verificar se o contrato vem de licitacao
     */
    var VerificaLicitacao = false;

    var tipocompratribunal = '';

    function js_pesquisaCaracteristicaPeculiar(lMostra) {

        if (lMostra == true) {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_concarpeculiar', 'func_concarpeculiar.php?funcao_js=parent.js_preencheCaracteristicaPeculiar|c58_sequencial|c58_descr&filtro=receita', 'Pesquisa Característica Peculiar', true);
            $('Jandb_iframe_concarpeculiar').style.zIndex = 100;
        } else {
            if ($("iSequenciaCaracteristica").value != '') {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_concarpeculiar', 'func_concarpeculiar.php?pesquisa_chave=' + $("iSequenciaCaracteristica").value + '&funcao_js=parent.js_mostraCaracteristicaPeculiar&filtro=receita', 'Pesquisa Característica Peculiar', false);
            } else {
                document.form1.sDescricaoCaracteristica.value = '';
            }
        }
    }

    function js_preencheCaracteristicaPeculiar(iCodigoCaracteristica, sDescricaoCaracteristica) {

        $("iSequenciaCaracteristica").value = iCodigoCaracteristica;
        $("sDescricaoCaracteristica").value = sDescricaoCaracteristica;
        db_iframe_concarpeculiar.hide();
    }

    function js_mostraCaracteristicaPeculiar(sDescricao, lErro) {

        if (lErro) {

            $("iSequenciaCaracteristica").value = "";
            $("sDescricaoCaracteristica").value = sDescricao;
            return false;
        }

        $("iSequenciaCaracteristica").focus();
        $("sDescricaoCaracteristica").value = sDescricao;
    }

    function js_pesquisaac16_sequencial(lMostrar) {

        if (lMostrar == true) {

            var sUrl = 'func_acordo.php?lDepartamento=1&funcao_js=parent.js_mostraacordo1|ac16_sequencial|ac16_resumoobjeto&iTipoFiltro=4&lGeraAutorizacao=true';
            js_OpenJanelaIframe('top.corpo',
                'db_iframe_acordo',
                sUrl,
                'Pesquisar Acordo',
                true);
        } else {

            if (oTxtCodigoAcordo.getValue() != '') {

                var sUrl = 'func_acordo.php?lDepartamento=1&descricao=true&pesquisa_chave='+oTxtCodigoAcordo.getValue()+
                    '&funcao_js=parent.js_mostraacordo&iTipoFiltro=4&lGeraAutorizacao=true';

                js_OpenJanelaIframe('top.corpo',
                    'db_iframe_acordo',
                    sUrl,
                    'Pesquisar Acordo',
                    false);
            } else {
                oTxtCodigoAcordo.setValue('');
            }
        }
        document.getElementById('oGridItenstotalValue').innerText = '0,00';
    }

    /**
     * Retorno da pesquisa acordos
     */
    function js_mostraacordo(chave1,chave2,erro) {

        if (erro == true) {

            oTxtCodigoAcordo.setValue('');
            oTxtDescricaoAcordo.setValue('');
            $('oTxtDescricaoAcordo').focus();
        } else {

            oTxtCodigoAcordo.setValue(chave1);
            oTxtDescricaoAcordo.setValue(chave2);
        }
    }

    /**
     * Retorno da pesquisa acordos
     */
    function js_mostraacordo1(chave1,chave2) {

        oTxtCodigoAcordo.setValue(chave1);
        oTxtDescricaoAcordo.setValue(chave2);
        db_iframe_acordo.hide();
    }

    function js_main() {

        oTxtCodigoAcordo = new DBTextField('oTxtCodigoAcordo', 'oTxtCodigoAcordo','', 10);
        oTxtCodigoAcordo.addEvent("onChange",";js_pesquisaac16_sequencial(false);");
        oTxtCodigoAcordo.show($('ctnTxtCodigoAcordo'));
        oTxtCodigoAcordo.setReadOnly(true);

        oTxtDescricaoAcordo = new DBTextField('oTxtDescricaoAcordo', 'oTxtDescricaoAcordo','', 50);
        oTxtDescricaoAcordo.show($('ctnTxtDescricaoAcordo'));
        oTxtDescricaoAcordo.setReadOnly(true);

        oGridPosicoes = new DBGrid('oGridPosicoes');
        oGridPosicoes.setHeader(new Array('Código', 'Número', 'Tipo', "Data", "Emergencial"));
        oGridPosicoes.setHeight(100);
        oGridPosicoes.show($('ctnGridPosicoes'));

        oGridItens = new DBGrid('oGridItens');
        oGridItens.nameInstance = "oGridItens";
        oGridItens.hasTotalValue = true;
        oGridItens.setCheckbox(0);
        //oGridItens.allowSelectColumns(true);
        oGridItens.setCellWidth(new Array('10%', '40%',  "15%", "15%","15%", "15%", "15%","15%"));
        oGridItens.setHeader(new Array("Código", "Material", "Quantidade", "Vlr. Unit.",
            "Valor Total", "Qtde Autorizar", "Valor Autorizar", "Dotacoes", "iSeq"));
        // oGridItens.aHeaders[4].lDisplayed = false;
        oGridItens.aHeaders[9].lDisplayed = false;
        //oGridItens.aHeaders[8].lDisplayed = false;
        oGridItens.setHeight(160);
        oGridItens.show($('ctnGridItens'));
        $('btnPesquisarPosicoes').onclick = js_pesquisarPosicoesContrato;
        iTipoAcordo = 0;
    }

    function js_pesquisarPosicoesContrato() {

        document.getElementById('oGridItenstotalValue').innerText = '0,00';

        if (oTxtCodigoAcordo.getValue() == "") {

            alert('Informe um acordo!');
            return false;
        }
        js_divCarregando('Aguarde, pesquisando dados do acordo', 'msgbox');
        oGridItens.clearAll(true);
        oGridPosicoes.clearAll(true);
        var oParam                 = new Object();
        oParam.exec                = 'getPosicoesAcordo';
        oParam.lGeracaoAutorizacao = true;
        oParam.iAcordo = oTxtCodigoAcordo.getValue();
        var oAjax      = new Ajax.Request(sUrlRpc,
            {method:'post',
                parameters:'json='+Object.toJSON(oParam),
                onComplete: js_retornoGetPosicoesAcordo
            }
        )
    }

    function js_retornoGetPosicoesAcordo(oAjax) {

        js_removeObj('msgbox');
        var oRetorno = eval("("+oAjax.responseText+")");
        oGridPosicoes.clearAll(true);
        iTipoAcordo = oRetorno.tipocontrato;
        if (oRetorno.status == 1) {

            oRetorno.posicoes.each(function (oPosicao, iLinha) {
                let z01_cgccpf = oPosicao.cgccpf;

                if(z01_cgccpf.length = 11){
                    if(z01_cgccpf == '00000000000'){
                        alert("ERRO: Número do CPF está zerado. Corrija o CGM do fornecedor e tente novamente");
                        return false
                    }
                }

                if(z01_cgccpf.length = 14){
                    if(z01_cgccpf == '00000000000000'){
                        alert("ERRO: Número do CNPJ está zerado. Corrija o CGM do fornecedor e tente novamente");
                        return false
                    }
                }

                var aLinha = new Array();
                aLinha[0]  = oPosicao.codigo;
                aLinha[1]  = oPosicao.numero;
                aLinha[2]  = oPosicao.tipo+' - '+oPosicao.descricaotipo.urlDecode();
                aLinha[3]  = oPosicao.data;
                aLinha[4]  = oPosicao.emergencial.urlDecode();
                oGridPosicoes.addRow(aLinha);
                if (iLinha == oRetorno.posicoes.length-1) {
                    oGridPosicoes.aRows[iLinha].sEvents='ondblclick="js_getItensPosicao('+oPosicao.codigo+','+iLinha+');js_verificavirgencia('+oPosicao.codigo+','+iLinha+')"';
                    oGridPosicoes.aRows[iLinha].setClassName('marcado');
                }
            });
            oGridPosicoes.renderRows();
        }
    }

    function js_verificavirgencia(iCodigo, iLinha) {
        oGridPosicoes.aRows.each(function(oLinha, id) {
            oLinha.select(false);
        });
        oGridPosicoes.aRows[iLinha].select(true);
        js_divCarregando('Aguarde, pesquisando itens do acordo', 'msgbox');
        var oParam      = new Object();
        oParam.exec     = 'getVigencia';
        oParam.iPosicao = iCodigo;
        iPosicaoAtual   = iCodigo;
        var oAjax       = new Ajax.Request(sUrlRpc,
            {method:'post',
                parameters:'json='+Object.toJSON(oParam),
                onComplete: js_validavigencia
            }
        )
    }

    function js_validavigencia(oAjax){
        var oRetorno = JSON.parse(oAjax.responseText);
        let erro = oRetorno[0];
        let tipoerro = oRetorno[2];

        if(tipoerro==true){
            if (erro == false){
                alert("Contrato com vigência até "+ oRetorno[1] +", não será possível gerar autorização de empenho.");
                location.reload();
            }else{
                js_removeObj("msgbox");
            }
        }else{

            if (erro == false) {
                alert("Contrato assinado em "+oRetorno[3]+", gerar autorização após essa data");
                location.reload();
            }else{
                js_removeObj("msgbox");
            }
        }
    }

    function js_getItensPosicao(iCodigo, iLinha) {

        document.getElementById('oGridItenstotalValue').innerText = '0,00';

        oGridPosicoes.aRows.each(function(oLinha, id) {
            oLinha.select(false);
        });
        oGridPosicoes.aRows[iLinha].select(true);
        js_divCarregando('Aguarde, pesquisando itens do acordo', 'msgbox');
        var oParam      = new Object();
        oParam.exec     = 'getPosicaoItens';
        oParam.iPosicao = iCodigo;
        iPosicaoAtual   = iCodigo;
        var oAjax       = new Ajax.Request(sUrlRpc,
            {method:'post',
                parameters:'json='+Object.toJSON(oParam),
                onComplete: js_retornoGetItensPosicao
            }
        )
    }

    function js_roundDecimal(x,qtdCasasDecimais) {

        x = x.toString().replace(',','.');
        x = parseFloat(x);

        if(Number.isInteger(x)){
            return x;
        }

        var radixPos = String(x).indexOf('.');

        // now we can use slice, on a String, to get '.15'
        var value = String(x).slice(radixPos+1);

        var k = Array.from(value.toString()).map(Number);
        var temp = 0;

        for (var i = k.length - 1; i >= 0; i--) {
            k[i] += temp;
            temp = 0;
            if(k[i] >= 5 && i >= qtdCasasDecimais){
                temp = 1;
            }

            if(k[i] > 9){
                if(i <= (qtdCasasDecimais-1)){
                    temp = 1;
                }
                k[i] = 0;
            }

        }

        // Renderizar resultado final
        var render = "";
        for(var i = 0; i < qtdCasasDecimais; i++){
            if(k[i] != undefined){
                render += k[i];
            }
        }

        render = String(Math.floor(x)+temp)+"."+render;

        return render;
    }

    function js_retornoGetItensPosicao(oAjax) {

        js_removeObj("msgbox");
        var oRetorno = JSON.parse(oAjax.responseText);

        if (oRetorno.iOrigemContrato == 2) {
            verificaLicitacao = true;
            $('e54_codcom').value      = oRetorno.pc50_codcom;
            $('e54_codcomdescr').value = oRetorno.pc50_codcom;
            tipoLic  = oRetorno.l03_tipo;
            $('e54_numerl').value = oRetorno.iEdital+'/'+oRetorno.iAnoLicitacao;
            $('e54_nummodalidade').value = oRetorno.iNumModalidade;
            $('iSequenciaCaracteristica').value = '000';
            $('sDescricaoCaracteristica').value = 'NÃO SE APLICA';
            js_buscarTipoLicitacao(oRetorno.pc50_codcom);
            js_desabilitaCamposLicitacao();

        }else if (oRetorno.iOrigemContrato == 3 && oRetorno.iCodigoLicitacao == '') {
            verificaLicitacao = false;
            $('e54_codcom').value      = '';
            $('e54_codcomdescr').value = '';
            $('e54_numerl').value = '';
            $('e54_nummodalidade').value = '';
            $('e54_tipol').value = '';
            js_habilitaCamposLicitacao();
        }else if (oRetorno.iOrigemContrato == 3 && oRetorno.iCodigoLicitacao != '') {

            verificaLicitacao = true;
            $('e54_codcom').value      = oRetorno.pc50_codcom;
            $('e54_codcomdescr').value = oRetorno.pc50_codcom;
            tipoLic  = oRetorno.l03_tipo;
            $('e54_numerl').value = oRetorno.iEdital+'/'+oRetorno.iAnoLicitacao;
            $('e54_nummodalidade').value = oRetorno.iNumModalidade;
            $('iSequenciaCaracteristica').value = '000';
            $('sDescricaoCaracteristica').value = 'NÃO SE APLICA'
            js_buscarTipoLicitacao(oRetorno.pc50_codcom);
            js_desabilitaCamposLicitacao();
        }else if (oRetorno.iOrigemContrato == 6) {
            $('e54_codcom').value      = '';
            $('e54_codcomdescr').value = '';
            $('e54_numerl').value = '';
            $('e54_nummodalidade').value = '';
            $('e54_tipol').value = '';
            js_habilitaCamposLicitacao();
        }
        iCasasDecimais = oRetorno.iCasasDecimais;

        aItensPosicao = oRetorno.itens;
        oGridItens.clearAll(true);
        var aEventsIn  = ["onmouseover"];
        var aEventsOut = ["onmouseout"];
        aDadosHintGrid = new Array();

        aItensPosicao.each(function (oItem, iSeq) {

            oItem.dotacoes.each( function (oDotItem) {

                if (oItem.dotacoes.length == 1) {

                    oDotItem.quantidade -= js_round(oDotItem.executado/oItem.valorunitario,iCasasDecimais);
                    oDotItem.quantdot = oDotItem.quantidade;

                } else {
                    oDotItem.quantdot = oDotItem.quantidade = 0;
                }

            });

            var nQtdeAut  = oItem.saldos.quantidadeautorizar;
            var vTotal = oItem.valorunitario * oItem.quantidade;
            var vTotalAut = oItem.valorunitario * nQtdeAut;

            //var nValorAut = js_formatar(js_roundDecimal(vTotal, 2), "f",2);
            // var nValorAut = js_formatar(js_roundDecimal(vTotalAut, 2), "f",2);
            var nValorAut = js_formatar(vTotalAut.toFixed(2), "f",2);

            aLinha    = new Array();
            aLinha[0] = oItem.codigomaterial;
            // Descrição
            aLinha[1] = oItem.material.urlDecode();

            // Quantidade
            aLinha[2] = js_formatar(oItem.quantidade, 'f',iCasasDecimais);

            // Valor unitário
            aLinha[3] = js_formatar(oItem.valorunitario.replace(',', '.'), 'f', 4);

            // Valor total
            //aLinha[4] = js_formatar(oItem.valortotal, 'f',4);
            // aLinha[4] = js_roundDecimal(vTotal,2);
            aLinha[4] = vTotal.toFixed(2);

            /**
             * Caso for serviço e o mesmo não for controlado por quantidade, setamos a sua quantidade para 1
             */
            if (oItem.servico && (oItem.lControlaQuantidade == "" || oItem.lControlaQuantidade == "f")) {
                nQtdeAut = 1;
                oItem.saldos.quantidadeautorizar = 1;
                nValorAut = js_formatar(js_roundDecimal(oItem.saldos.valorautorizar, 2), 'f',2);
            }

            aLinha[5] = eval("qtditem"+iSeq+" = new DBTextField('qtditem"+iSeq+"','qtditem"+iSeq+"','"+nQtdeAut+"')");
            aLinha[5].addStyle("text-align","right");
            aLinha[5].addStyle("height","100%");
            aLinha[5].addStyle("width","100px");
            aLinha[5].addStyle("border","1px solid transparent;");
            aLinha[5].addEvent("onBlur","js_bloqueiaDigitacao(this, false);");
            aLinha[5].addEvent("onBlur","qtditem"+iSeq+".sValue=this.value;");
            aLinha[5].addEvent("onBlur","js_calculaValor(this,"+iSeq+", true);");
            aLinha[5].addEvent("onFocus","js_liberaDigitacao(this, false);");
            //aLinha[5].addEvent("onKeyPress","return js_mask(event,\"0-9|.|-\")");
            aLinha[5].addEvent("onKeyPress","return js_teclas(event,this);");
            aLinha[5].addEvent("onKeyDown","return js_verifica(this,event,false)")
            if (oItem.servico && (oItem.lControlaQuantidade == "" || oItem.lControlaQuantidade == "f")) {
                aLinha[5].setReadOnly(true);
                aLinha[5].addEvent("onFocus","js_bloqueiaDigitacao(this, true);");
            }
            aLinha[6] = eval("valoritem"+iSeq+" = new DBTextField('valoritem"+iSeq+"','valoritem"+iSeq+"','"+nValorAut+"')");
            aLinha[6].addStyle("text-align","right");
            aLinha[6].addStyle("height","100%");
            aLinha[6].addStyle("width","100px");
            aLinha[6].addStyle("border","1px solid transparent;");
            aLinha[6].addEvent("onBlur","js_bloqueiaDigitacao(this, true);");
            aLinha[6].addEvent("onBlur","valoritem"+iSeq+".sValue=this.value;");
            aLinha[6].addEvent("onFocus","js_liberaDigitacao(this, false);");
            //aLinha[6].addEvent("onKeyPress","return js_mask(event,\"0-9|.|-\");");
            aLinha[6].addEvent("onKeyPress","return js_teclas(event,this);");
            //aLinha[6].addEvent("onBlur","js_salvarInfoDotacoes("+iSeq+", true);");
            aLinha[6].addEvent("onKeyDown","return js_verifica(this,event,true);");

            if (oItem.servico && (oItem.lControlaQuantidade == "" || oItem.lControlaQuantidade == "f")) {

                aLinha[6].addEvent("onFocus","js_tempOldValue("+iSeq+",this.value);");
                aLinha[6].addEvent("onBlur","js_verificaValorTotal("+js_arrangeDotAndComma(nValorAut)+","+iSeq+");");

            }

            if (!oItem.servico || (oItem.servico && oItem.lControlaQuantidade == "t")) {

                aLinha[6].setReadOnly(true);
                aLinha[6].addEvent("onFocus","js_bloqueiaDigitacao(this, true);");

                aLinha[7] = "<input type='button' id='dotacoes"+iSeq+"'  onclick='js_ajusteDotacao("+iSeq+",1)' value='Dotações'>";

            }else{
                aLinha[7] = "<input type='button' id='dotacoes"+iSeq+"'  onclick='js_ajusteDotacao("+iSeq+",2)' value='Dotações'>";
            }

            aLinha[8] = new String(iSeq).valueOf();


            lDesativaLinha = false;
            if (nQtdeAut == 0 || nValorAut == '0,00') {
                lDesativaLinha = true;
            }

            var sTextEvent  = " ";

            if (aLinha[1] !== '') {
                sTextEvent += "<b>Material: </b>"+aLinha[1];
            } else {
                sTextEvent += "<b>Nenhum dado à mostrar</b>";
            }

            var oDadosHint           = new Object();
            oDadosHint.idLinha   = `oGridItensrowoGridItens${iSeq}`;
            oDadosHint.sText     = sTextEvent;
            aDadosHintGrid.push(oDadosHint);
            oGridItens.addRow(aLinha, null, lDesativaLinha);

        });

        oGridItens.renderRows();

        js_changeTotal();

        aDadosHintGrid.each(function(oHint, id) {
            var oDBHint    = eval("oDBHint_"+id+" = new DBHint('oDBHint_"+id+"')");
            oDBHint.setText(oHint.sText);
            oDBHint.setShowEvents(aEventsIn);
            oDBHint.setHideEvents(aEventsOut);
            oDBHint.setPosition('B', 'L');
            oDBHint.setUseMouse(true);
            oDBHint.make($(oHint.idLinha), 2);
        });

        aItensPosicao.each(function (oItem, iLinha){
            js_salvarInfoDotacoes(iLinha, false);
        });

    }


    function somenteNumeros(num) {
        var er = /[^0-9.]/;
        er.lastIndex = 0;
        var campo = num;
        if (er.test(campo.value)) {
            campo.value = "";
        }
    }

    /**
     * bloqueia  o input passado como parametro para a digitacao.
     * É colocado  a mascara do valor e bloqueado para Edição
     */
    function js_bloqueiaDigitacao(object, lFormata) {
        object.readOnly         = true;
        object.style.border     ='1px';
        object.style.fontWeight = "normal";
        if (lFormata) {
            object.value            = js_formatar(object.value,'f',iCasasDecimais);
        }

    }
    /**
     * Libera  o input passado como parametro para a digitacao.
     * é Retirado a mascara do valor e liberado para Edição
     * é Colocado a Variavel nValorObjeto no escopo GLOBAL
     */
    function js_liberaDigitacao(object, lFormata) {

        nValorObjeto        = object.value;
        object.value        = object.value;
        // if (lFormata) {
        //   object.value        = js_strToFloat(object.value).valueOf();
        // }
        object.style.border = '1px solid black';
        object.readOnly     = false;
        object.style.fontWeight = "bold";
        object.select();

    }

    function js_tempOldValue(iSeq, oldValue){

        oldValue = js_arrangeDotAndComma(oldValue);

        // Buscar elemento pai
        var elemento_pai = document.body;

        if(!document.getElementById("oldValue"+iSeq)){

            // Criar elemento
            eval("var oldValue"+iSeq+" = document.createElement('input');");
        }

        // Inserir (anexar) o elemento filho (oldValue) ao elemento pai (body)
        eval("elemento_pai.appendChild(oldValue"+iSeq+");");

        eval("oldValue"+iSeq+".value = "+oldValue+";");
        eval("oldValue"+iSeq+".type = 'hidden';");
        eval("oldValue"+iSeq+".id = 'oldValue"+iSeq+"';");
    }

    function js_arrangeDotAndComma(value){

        if (value.toString().indexOf(",") >= 0){

            while(value.toString().indexOf(".") >= 0){
                value = value.toString().replace('.','');
            }
            value = value.toString().replace(',','.');
            return parseFloat(value);

        }
        return value;

    }

    function js_verificaValorTotal(nValueAut, iSeq) {
        var aLinha = oGridItens.aRows[iSeq];

        var value = js_arrangeDotAndComma($("valoritem"+iSeq).value);
        var oldValue = js_arrangeDotAndComma($("oldValue"+iSeq).value);
        nValueAut = js_arrangeDotAndComma(nValueAut);

        if (value > nValueAut) {
            //oGridDotacoes.aRows[iDot].aCells[3].content.setValue(oldValue);
            $("valoritem"+iSeq).value = js_formatar(oldValue,'f',2);
            aLinha.aCells[7].content.setValue(js_formatar(js_roundDecimal(oldValue,2), "f",2));
            return;
        }

        // $("valoritem"+iSeq).value = js_formatar(js_roundDecimal(value, 2),'f',2);
        $("valoritem"+iSeq).value = js_formatar(value.toFixed(2),'f',2);
        //oDotacao.valorexecutar = $("valoritem"+iSeq).value;
        js_somaItens();
    }

    /**
     * Verifica se  o usuário cancelou a digitação dos valores.
     * Caso foi cancelado, voltamos ao valor do objeto, e
     * bloqueamos a digitação
     */
    function js_verifica(object,event,lFormata) {

        var teclaPressionada = event.which;
        if (teclaPressionada == 27) {
            object.value = nValorObjeto;
            js_bloqueiaDigitacao(object, lFormata);
        }
    }

    function js_calculaValor(obj, iLinha, lVerificaDot) {

        var aLinha = oGridItens.aRows[iLinha];
        if (aLinha.aCells[6].getValue() > aItensPosicao[iLinha].saldos.quantidadeautorizar || aLinha.aCells[6].getValue() == 0) {

            aLinha.aCells[6].content.setValue(aItensPosicao[iLinha].saldos.quantidadeautorizar);
            obj.value = aItensPosicao[iLinha].saldos.quantidadeautorizar;
            aLinha.aCells[7].content.setValue(aLinha.aCells[5].getValue());
        } else {

            var nValorTotal = new Number(aLinha.aCells[6].getValue() * aLinha.aCells[4].getValue().replace('.', '').replace(',', '.'));
            aLinha.aCells[7].content.setValue(js_formatar(nValorTotal.toFixed(2), "f",2));
            //$("valoritem" + iLinha).value = js_formatar(new String(nValorTotal), "f",iCasasDecimais);
            $("valoritem" + iLinha).value = js_formatar(nValorTotal.toFixed(2), "f",2);
        }
        js_somaItens();
        //js_salvarInfoDotacoes(iLinha, lVerificaDot);
    }


    // Abertura de dotações
    function js_ajusteDotacao(iLinha,tipo) {

        if ($('wndDotacoesItem')) {
            return false;
        }
        oDadosItem  =  oGridItens.aRows[iLinha];
        var iHeight = js_round((screen.availHeight/1.3), 0);
        var iWidth  = screen.availWidth/2;
        windowDotacaoItem = new windowAux('wndDotacoesItem',
            'Dotações Item '+oDadosItem.aCells[2].getValue().substr(0,50),
            iWidth,
            iHeight
        );
        var sContent  = "<div>";
        sContent     += "<fieldset>";
        sContent     += "  <div id='cntgridDotacoes'>";
        sContent     += "  </div>";
        sContent     += "</fieldset>";
        sContent     += "<center>";
        sContent     += "<input type='button' id='btnSalvarInfoDot' value='Salvar' onclick=''>";
        sContent     += "</center>";
        windowDotacaoItem.setContent(sContent);
        oMessageBoard = new DBMessageBoard('msgboard1',
            'Adicionar Dotacoes',
            'Dotações Item '+oDadosItem.aCells[1].getValue()+" (valor A Autorizar: <b>"+
            js_formatar(oDadosItem.aCells[7].getValue(), "f",2)+"</b>)",
            $('windowwndDotacoesItem_content')
        );
        windowDotacaoItem.setShutDownFunction(function() {
            windowDotacaoItem.destroy();
        });

        $('btnSalvarInfoDot').observe("click", function() {

            var nTotalDotacoes = oGridDotacoes.sum(3, false);

//     if (js_round(nTotalDotacoes, iCasasDecimais) != js_round(js_strToFloat(oDadosItem.aCells[7].getValue(), iCasasDecimais)) ) {
//       alert('o Valor Total das Dotações não conferem com o total que está sendo autorizado no item!');
//       return false;
//     }

            if(tipo == 1){
                // if (js_round(nTotalDotacoes, iCasasDecimais) != js_strToFloat(oDadosItem.aCells[7].getValue(), iCasasDecimais) ) {
                //   alert('o Valor Total das Dotações não confere com o total que está sendo autorizado no item!');
                //   return false;
                // }
                if (js_formatar(js_roundDecimal(nTotalDotacoes, 2), "f",2) != oDadosItem.aCells[7].getValue()) {
                    alert('o Valor Total das Dotações não confere com o total que está sendo autorizado no item!');
                    return false;
                }
            }else{
                if (isNaN(+oDadosItem.aCells[7].getValue())){
                    if (js_round(nTotalDotacoes, iCasasDecimais) != js_strToFloat(oDadosItem.aCells[7].getValue(), iCasasDecimais) ) {
                        alert('o Valor Total das Dotações não confere com o total que está sendo autorizado no item!');
                        return false;
                    }
                }else{
                    if (js_round(nTotalDotacoes, iCasasDecimais) != oDadosItem.aCells[7].getValue() ) {
                        alert('o Valor Total das Dotações não confere com o total que está sendo autorizado no item!');
                        return false;
                    }
                }
            }

            // debug
            aItensPosicao[iLinha].dotacoes.each(function (oDotacao, iDot) {

                var nValue = js_strToFloat(js_formatar(oGridDotacoes.aRows[iDot].aCells[3].getValue(),"f",iCasasDecimais));

                oDotacao.valorexecutar = nValue;
                var nQuant = js_strToFloat(js_formatar(oGridDotacoes.aRows[iDot].aCells[2].getValue(),"f",iCasasDecimais));
                oDotacao.quantidade = nQuant;
            });
            oGridItens.aRows[iLinha].select(true);
            windowDotacaoItem.destroy();
        });
        oMessageBoard.show();
        oGridDotacoes              = new DBGrid('gridDotacoes');
        oGridDotacoes.nameInstance = 'oGridDotacoes';
        oGridDotacoes.setCellWidth(new Array('5%', '15%', '15%', '15%'));
        oGridDotacoes.setHeader(new Array("Dotação", "Saldo", "Quant. Aut.", "valor"));
        oGridDotacoes.setHeight(iHeight/3);
        oGridDotacoes.setCellAlign(new Array("center", "right", "right", "Center"));
        oGridDotacoes.show($('cntgridDotacoes'));
        oGridDotacoes.clearAll(true);
        var nValor          =  js_strToFloat(oDadosItem.aCells[7].getValue());
        var nValorTotalItem = js_strToFloat(oDadosItem.aCells[5].getValue());
        var nValorTotal     = nValor;

        aItensPosicao[iLinha].dotacoes.each(function (oDotacao, iDot) {

            //nValorDotacao = js_formatar(oDotacao.valorexecutar, "f", iCasasDecimais);
            // Valor da dotação
            // nValorDotacao = js_formatar(js_roundDecimal(oDotacao.valorexecutar, 2), "f",2);
            nValorDotacao = js_formatar(oDotacao.valorexecutar.toFixed(2), "f",2);


            aLinha    = new Array();
            aLinha[0] = "<a href='#' onclick='js_mostraSaldo("+oDotacao.dotacao+");return false'>"+oDotacao.dotacao+"</a>";
            aLinha[1] = js_formatar(oDotacao.saldodotacao, "f",iCasasDecimais);
            if(tipo == 2) {
                aLinha[2] = eval("quantdot" + iDot + " = new DBTextField('quantdot" + iDot + "','quantdot" + iDot + "',1)");
            }else{
                aLinha[2] = eval("quantdot" + iDot + " = new DBTextField('quantdot" + iDot + "','quantdot" + iDot + "','" + oDotacao.quantidade + "')");
            }
            aLinha[2].addStyle("text-align","right");
            aLinha[2].addStyle("height","100%");
            aLinha[2].addStyle("width","100px");
            aLinha[2].addStyle("border","1px solid transparent;");
            aLinha[2].addEvent("onBlur","quantdot"+iDot+".sValue=this.value;");
            if(tipo != 2) {
                aLinha[2].addEvent("onBlur", "js_ajustaQuantDot(this," + iDot + "," + iLinha + ");");
                aLinha[2].addEvent("onFocus","js_liberaDigitacao(this, true);");
            }else{
                aLinha[2].addEvent("onFocus","js_bloqueiaDigitacao(this, true);");
            }
            aLinha[2].addEvent("onKeyPress","return js_mask(event,\"0-9|.|-\")");
            aLinha[2].addEvent("onKeyDown","return js_verifica(this,event,true)");

            aLinha[3] = eval("valordot"+iDot+" = new DBTextField('valordot"+iDot+"','valordot"+iDot+"','"+nValorDotacao+"')");
            aLinha[3].addStyle("text-align","right");
            aLinha[3].addStyle("height","100%");
            aLinha[3].addStyle("width","100px");
            aLinha[3].addStyle("border","1px solid transparent;");
            aLinha[3].addEvent("onBlur","valordot"+iDot+".sValue=this.value;");
            aLinha[3].addEvent("onBlur","js_ajustaValorDot(this,"+iDot+","+tipo+");");
            aLinha[3].addEvent("onBlur","js_bloqueiaDigitacao(this, true);");
            aLinha[3].addEvent("onFocus","js_liberaDigitacao(this, true);");
            aLinha[3].addEvent("onKeyPress","return js_mask(event,\"0-9|.|-\")");
            aLinha[3].addEvent("onKeyDown","return js_verifica(this,event,true)");
            oGridDotacoes.addRow(aLinha);
        });
        windowDotacaoItem.show();
        oGridDotacoes.renderRows();

    }

    /**
     *   @todo
     em futuras melhorias que houver no fonte, verificar os calculos e aplicação das funções js_strToFloat desnecessariamente
     por hora para resolver erro, colocamos o parametro lReplace como flag para aplicar ou nao a js_strToFloat e alguns replces
     de virgula por ponto.
     */

    function js_salvarInfoDotacoes(iLinha, lAjustaDot) {

        var oDadosItem      =  oGridItens.aRows[iLinha];
        if (aItensPosicao[iLinha].dotacoes.length >= 1 && lAjustaDot) {
            js_ajusteDotacao(iLinha);
            return;
        }

        var nValor = oDadosItem.aCells[7].getValue();

        var nValorTotalItem = js_strToFloat(oDadosItem.aCells[5].getValue());
        var nValorTotal     = nValor;
        var nQuantAutorizar = Number(oDadosItem.aCells[6].getValue());
        var nValorUnit = Number(oDadosItem.aCells[4].getValue().replace('.', '').replace(',','.'));

        aItensPosicao[iLinha].dotacoes.each(function (oDotacao, iDot) {

            if (aItensPosicao[iLinha].dotacoes.length >= 1 && lAjustaDot==false) {

                var nQuantDot  = aItensPosicao[iLinha].dotacoes[iDot].quantidade;
                aItensPosicao[iLinha].dotacoes[iDot].valorexecutar = js_round(nValorUnit*nQuantDot,iCasasDecimais);
                return;

            }

            var nPercentual    = (new Number(oDotacao.quantidade) * 100)/nValorTotalItem;
            var nValorDotacao  = js_round((nValor * nPercentual)/100,iCasasDecimais);

            nValorTotal        -= nValorDotacao;
            if (iDot == aItensPosicao[iLinha].dotacoes.length -1) {

                if (nValorTotal != nValor) {
                    nValorDotacao += nValorTotal;
                }
            }
            aItensPosicao[iLinha].dotacoes[iDot].valorexecutar = js_round(nValorDotacao,iCasasDecimais);

            if (aItensPosicao[iLinha].dotacoes.length == 1) {
                oDotacao.quantidade = nQuantAutorizar;
            }
        });

    }

    function js_ajustaValorDot(Obj, iDot, tipo) {

        var nValor         = new js_strToFloat(Obj.value);
        var nTotalDotacoes = oGridDotacoes.sum(3, false);
        var nValorAut      = js_strToFloat(oDadosItem.aCells[7].getValue());

        if (nValor > nValorAut) {
            oGridDotacoes.aRows[iDot].aCells[3].content.setValue(nValorObjeto);
            Obj.value = nValorObjeto;
        } else if (nTotalDotacoes > nValorAut) {
            oGridDotacoes.aRows[iDot].aCells[3].content.setValue(nValorObjeto);
            Obj.value = nValorObjeto;
        } else {
            if(tipo != 2) {
                var nNovaQuantDot = (nValor * Number(oDadosItem.aCells[6].getValue())) / js_strToFloat(oDadosItem.aCells[7].getValue());
            }else{
                var nNovaQuantDot = 1;
            }
            oGridDotacoes.aRows[iDot].aCells[2].content.setValue(js_round(nNovaQuantDot,iCasasDecimais));
            $("quantdot"+iDot).value = oGridDotacoes.aRows[iDot].aCells[2].getValue();
        }
    }

    function js_ajustaQuantDot(Obj, iDot, iLinha) {

        var nQuant         = Number(Obj.value);
        var nTotalDotacoes = oGridDotacoes.sum(2, false);
        var nQuantAut      = js_strToFloat(oDadosItem.aCells[6].getValue());

        if (nQuant > nQuantAut || nTotalDotacoes > nQuantAut) {
            oGridDotacoes.aRows[iDot].aCells[2].content.setValue(nValorObjeto);
            Obj.value = nValorObjeto;
        } else {
            oGridDotacoes.aRows[iDot].aCells[3].content.setValue((nQuant*Number(oDadosItem.aCells[4].getValue().replace('.', '').replace(',','.'))).toFixed(2));
            $("valordot"+iDot).value = js_formatar(Number(oGridDotacoes.aRows[iDot].aCells[3].getValue()).toFixed(2), "f",2);
        }
    }
    /**
     * Abre uma loopkup com a pesquisa dos saldos da Dotacao do Ano corrente
     */
    function js_mostraSaldo(chave){

        arq = 'func_saldoorcdotacao.php?o58_coddot='+chave
        js_OpenJanelaIframe('top.corpo','db_iframe_saldos',arq,'Saldo da dotação',true);
        $('Jandb_iframe_saldos').style.zIndex='1500000';
    }

    function js_retornoProcessarAutorizacoes (oAjax) {

        js_removeObj('msgbox');
        var oRetorno = eval("("+oAjax.responseText+")");

        if (oRetorno.status == 1) {

            var sListaAutori = '';
            var sVirgula     = "";
            var iAutIni      = '0';
            var iAutFim      = '0';
            oRetorno.itens.each(function(iAutori, id) {

                if (id == 0) {
                    iAutIni = iAutori;
                }
                iAutFim       = iAutori;
                sListaAutori += sVirgula+" "+iAutori;
                sVirgula = ", ";
            });
            if (confirm("Foram geradas as autorizacoes "+sListaAutori+".\nclique [ok] para Deseja Visualiza-las.")) {

                var sUrl = 'emp2_emiteautori002.php?e54_autori_ini='+iAutIni+'&e54_autori_fim='+iAutFim;
                window.open(sUrl,'', 'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0');
                location.href = 'ac04_geraautorizacao001.php';

            } else {
                location.href = 'ac04_geraautorizacao001.php';
            }
        } else {
            alert(oRetorno.message.urlDecode());
        }
    }


    function js_visualizarAutorizacoes(oAjax) {

        var oRetorno = eval("("+oAjax.responseText+")");
        js_removeObj('msgbox');

        if (oRetorno.status == '2') {

            alert(oRetorno.message.urlDecode());
            return false;
        }


        if ($('wndDotacoesItem')) {
            return false;
        }
        if ($('wndAutorizacoes')) {
            return false;
        }
        var iHeight = js_round((screen.availHeight/1.8), 0);
        var iWidth  = screen.availWidth/2;
        windowAutorizacaoItem = new windowAux('wndAutorizacoes',
            'Autorizações De Empenho',
            iWidth,
            iHeight
        );
        var sContent  = "<div>";
        sContent     += "<fieldset>";
        sContent     += "  <div id='cntgridAutorizacoes'>";
        sContent     += "  </div>";
        sContent     += "</fieldset>";
        sContent     += "<center>";
        sContent     += "<input type='button' id='btnSalvarAutorizacoes' value='Gerar Autorizações' onclick='js_consultarDataDoSistema(true)'>";
        sContent     += "</center>";
        windowAutorizacaoItem.setContent(sContent);
        oMessageBoardAut = new DBMessageBoard('msgboard1',
            'Gerar Autorizacões ',
            'Prévia de autorizações que serão geradas conforme seleção de itens/dotações',
            $('windowwndAutorizacoes_content')
        );
        windowAutorizacaoItem.setShutDownFunction(function() {
            windowAutorizacaoItem.destroy();
        });

        oMessageBoardAut.show();
        oGridAutorizacoes              = new DBGrid('gridAutorizacoes');
        oGridAutorizacoes.nameInstance = 'oGridAutorizacoes';
        oGridAutorizacoes.setCellWidth(new Array('10%', '70%', '10%', '10%', "10%"));
        oGridAutorizacoes.setHeader(new Array("Codigo", "Item", "Qtde", "Valor Unit", "Valor Total"));
        oGridAutorizacoes.setCellAlign(new Array("center", "left", "right", "right", "right"));
        oGridAutorizacoes.aHeaders[0].lDisplayed=false;
        oGridAutorizacoes.show($('cntgridAutorizacoes'));
        oGridAutorizacoes.clearAll(true);
        var iLinha = 0;
        var iAut   = 1;
        for (oDot in oRetorno.itens) {

            with (oRetorno.itens[oDot]) {

                aLinha     = new Array();
                aLinha[0]  = '';
                aLinha[1]  = iAut+'ª Autorização - Dotação (<a href="#" ';
                aLinha[1] += "onclick='js_mostraSaldo("+dotacao+");return false'>"+dotacao+"</a>)";
                aLinha[2]  = '';
                aLinha[3]  = '';
                aLinha[4]  = '';
                oGridAutorizacoes.addRow(aLinha);
                oGridAutorizacoes.aRows[iLinha].sStyle ='background-color:#eeeee2;';
                oGridAutorizacoes.aRows[iLinha].aCells.each(function(oCell, id) {
                    oCell.sStyle +=';border-right: 1px solid #eeeee2;';
                });
                oGridAutorizacoes.aRows[iLinha].aCells[1].sStyle  = 'border-right: 1px solid #eeeee2;1px solid #eeeee2;';
                oGridAutorizacoes.aRows[iLinha].aCells[1].sStyle += 'text-align:left;font-weight:bold';
                iLinha++;
                aItens.each(function(oItem, id) {

                    if (id == aItens.length-1) {
                        var sImg  = "<img src='imagens/tree/join2.gif'>";
                    } else {
                        var sImg   = "<img src='imagens/tree/joinbottom2.gif'>";
                    }
                    aLinha    = new Array();
                    aLinha[0] = oItem.codigo;
                    aLinha[1] = sImg+oItem.descricao.urlDecode();
                    aLinha[2] = js_formatar(oItem.quantidade, "f",iCasasDecimais);
                    aLinha[3] = js_formatar(oItem.valorunitario, "f", 4);
                    aLinha[4] = js_formatar(oItem.valor, "f",iCasasDecimais);
                    oGridAutorizacoes.addRow(aLinha);
                    iLinha++;
                });
                iAut++;
            }

        }

        windowAutorizacaoItem.show();
        oGridAutorizacoes.renderRows();
        oGridAutorizacoes.setNumRows(iAut - 1);
    }

    function js_consultarDataDoSistema(lProcessar){

        var oParam = new Object();
        oParam.consultarDataDoSistema = true;
        oParam.lProcessar = lProcessar;

        var oAjax  = new Ajax.Request(
            'ac04_geraautorizacao001.php',
            {
                method:'post',
                parameters:'json='+Object.toJSON(oParam),
                onComplete: js_processarAutorizacoes
            }
        );

    }

    function js_processarAutorizacoes(oAjax) {

        var x = JSON.parse(oAjax.responseText);

        if(Date.parse(x['dataDoSistema']) <= Date.parse(x.dataFechamentoContabil)){

            alert("O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.");
            return

        }

        var aItens = oGridItens.getSelection("object");
        if (aItens.length == 0) {

            alert('Nenhum item Selecionado');
            return false;

        }

        var funcaoRetorno = js_retornoProcessarAutorizacoes;

        if (!x['processar']) {
            funcaoRetorno = js_visualizarAutorizacoes;
        }

        js_divCarregando('Aguarde, processando.....', 'msgbox');
        var oParam        = new Object();
        oParam.exec       = "processarAutorizacoes";
        oParam.lProcessar = x['processar'];
        oParam.aItens     = new Array();
        oParam.dados      = new Object();

        if($('e54_codcom').value.length != 0){

            if(tipocompratribunal != 13 && $('e54_numerl').value.length == 0) {
                alert('Campo Numero da licitação e obrigatório');
                js_removeObj('msgbox');
                return false;
            }

        }else{

            alert('Escolha um tipo');
            js_removeObj('msgbox');
            return false;
        }

        if (x['processar']) {

            oParam.dados.destino                 = encodeURIComponent(tagString( $F('e54_destin')));
            oParam.dados.tipolicitacao           = $F('e54_tipol');
            oParam.dados.tipocompra              = $F('e54_codcom');
            oParam.dados.licitacao               = $F('e54_numerl');
            oParam.dados.iNumModalidade          = $F('e54_nummodalidade');
            oParam.dados.pagamento               = encodeURIComponent(tagString($F('e54_conpag')));
            oParam.dados.resumo                  = encodeURIComponent(tagString($F('e54_resumo')));
            oParam.dados.iCaracteristicaPeculiar = $F("iSequenciaCaracteristica");
            oParam.dados.tipoempenho             = $F('e54_codtipo');
        }

        for (var i = 0; i < aItens.length; i++) {

            with (aItens[i]) {

                var oItem        = new Object();
                var oDadosItem   = aItensPosicao[aCells[9].getValue()];
                oItem.codigo     = oDadosItem.codigo;
                oItem.quantidade = aCells[6].getValue();
                oItem.valor      = aCells[7].getValue();
                var nTotal       = oItem.valor;
                oItem.posicao    = iPosicaoAtual;
                /**
                 * Validamos o total do item com as dotacoes.
                 * caso o valor seja diferetntes , devemos cancelar a operação e avisar o usuário
                 */
                var nValorDotacao = 0;

                oDadosItem.dotacoes.each(function(oDotacao, id) {
                    nValorDotacao += oDotacao.valorexecutar;
                });

                oItem.valor   =  js_formatar(oItem.valor , 'f',iCasasDecimais);
                nValorDotacao =  js_formatar(nValorDotacao, 'f',2);
                nTotal        =  js_formatar(nTotal, 'f',2);

                if (nTotal.valueOf() != nValorDotacao.valueOf()) {
                    /**
                     @todo
                     caso deseje-se que seja exibida uma mensagem informativa de uma dotação específica em caso de valores não
                     correspondentes, segue abaixo um exemplo
                     alert(nTotal.valueOf() +" <===> "+ nValorDotacao.valueOf()); */
                    alert('Valor da (s) dotação(ões) diferente do valor do item.\nCorrija o valor das dotações.');
                    js_removeObj('msgbox');
                    return false;
                }
                //alert(nTotal.valueOf() +" <===> "+ nValorDotacao.valueOf());

                oItem.valor    = js_strToFloat(oItem.valor);
                oItem.dotacoes = oDadosItem.dotacoes;
                oParam.aItens.push(oItem);
            }
        }

        var oAjax  = new Ajax.Request(sUrlRpc,
            {method:'post',
                parameters:'json='+Object.toJSON(oParam),
                onComplete: funcaoRetorno
            }
        )
    }

    function js_buscarInformacoesAutorizacao() {

        js_divCarregando('Aguarde, pesquisando dados do acordo', 'msgbox');
        var oParam           = new Object();
        oParam.exec          = 'getDadosAcordo';
        oParam.iCodigoAcordo = oTxtCodigoAcordo.getValue();

        var oAjax  = new Ajax.Request(sUrlRpc,
            {method:'post',
                parameters:'json='+Object.toJSON(oParam),
                onComplete: js_retornoBuscarInformacoesAutorizacao
            });

    }

    function js_retornoBuscarInformacoesAutorizacao(oAjax) {
        js_removeObj('msgbox');
        var oRetorno = JSON.parse(oAjax.responseText);
        var sMensagem = oRetorno.message;

        if ( oRetorno.status > 1 ) {

            alert(sMensagem);
            return false;
        }

        $('e54_resumo').value = oRetorno.sResumoAcordo.urlDecode();
        $('e54_numerl').value = oRetorno.iProcesso;
        $('e54_codcom').value = oRetorno.sTipo;
        $('e54_codcomdescr').value = oRetorno.sTipo;
        $('e54_nummodalidade').value = oRetorno.iNumModalidade;
        $('iSequenciaCaracteristica').value = '000';
        $('sDescricaoCaracteristica').value = 'NÃO SE APLICA';

        setInformacoesAutorizacao();

        if(oRetorno.sTipoorigem == '2'){
            $('e54_numerl').setAttribute('readOnly',true);
            $('e54_numerl').setAttribute('disabled',true);
            $('e54_numerl').setAttribute('style','background-color: rgb(222, 184, 135); color: rgb(0, 0, 0);');
            $('e54_nummodalidade').setAttribute('readOnly',true);
            $('e54_nummodalidade').setAttribute('disabled',true);
            $('e54_nummodalidade').setAttribute('style','background-color: rgb(222, 184, 135); color: rgb(0, 0, 0);');
        }

    }

    function setInformacoesAutorizacao() {

        if ($('wndDadosAutorizacoes')) {
            windowDadosAutorizacao.show();
        } else {

            var iWidth  = screen.availWidth/2;
            var iHeight = js_round( screen.availHeight/1.8, 0);
            windowDadosAutorizacao = new windowAux('wndDadosAutorizacoes',
                'Dados da(s) Autorização(ões) de Empenho',
                iWidth,
                iHeight
            );
            windowDadosAutorizacao.setObjectForContent($('frmDadosAutorizacao'));
            oMessageBoardDadosAut = new DBMessageBoard('msgboardDados',
                'Gerar Autorizacões ',
                'Informe dos dados complementares da Autorização',
                $('frmDadosAutorizacao')
            );
            //windowDadosAutorizacao.setChildOf(windowAutorizacaoItem);
            windowDadosAutorizacao.show();
            // windowDadosAutorizacao.toFront();
            windowDadosAutorizacao.setShutDownFunction(function() {
                windowDadosAutorizacao.hide();
            });
        }
    }
    /**
     * Busca o tipo de licitação para o tipo de compra escolhido
     * @param {integer} Código do tipo de compra
     */
    function js_buscarTipoLicitacao(iTipoCompra) {

        if (iTipoCompra != "" && iTipoCompra != "undefined") {

            var oParamTipoCompra         = new Object();
            oParamTipoCompra.iTipoCompra = iTipoCompra;
            oParamTipoCompra.exec        = "getTipoLicitacao";
            var oAjaxTipoCompra          = new Ajax.Request('lic4_geraAutorizacoes.RPC.php',
                {
                    method: 'post',
                    parameters:'json='+Object.toJSON(oParamTipoCompra),
                    onComplete:js_preencheTipoLicitacao
                }
            );
        }
    }

    /**
     * Preenche os tipos de licitação encontrados
     */
    function js_preencheTipoLicitacao(oAjax) {

        var oRetorno = eval("("+oAjax.responseText+")");
        $('e54_tipol').innerHTML = "";

        tipocompratribunal = oRetorno.tipocompratribunal;

        if( oRetorno.tipocompratribunal != 13 ) {

            $('e54_numerl').removeAttribute('readOnly',true);
            $('e54_numerl').removeAttribute('disabled', true);
            $('e54_numerl').removeAttribute('style', 'background-color: rgb(222, 184, 135); color: rgb(0, 0, 0);');

        }else {
            $('e54_numerl').setAttribute('readOnly',true);
            $('e54_numerl').setAttribute('disabled', true);
            $('e54_numerl').setAttribute('style', 'background-color: rgb(222, 184, 135); color: rgb(0, 0, 0);');

        }

        if (oRetorno.aTiposLicitacao.length > 0) {
            oRetorno.aTiposLicitacao.each(function (oItem) {
                $('e54_tipol').value = oItem.l03_tipo;
                $('e54_tipoldescr').value = oItem.l03_descr;
            });
        }
    }

    function js_desabilitaCamposLicitacao() {

        $('e54_numerl').setAttribute('readOnly',true);
        $('e54_tipol').setAttribute('disabled',true);
        $('e54_codcom').setAttribute('disabled',true);
        $('e54_codcomdescr').setAttribute('disabled',true);
        $('e54_numerl').setAttribute('style','background-color: rgb(222, 184, 135); color: rgb(0, 0, 0);');
        $('e54_tipol').setAttribute('style','background-color: rgb(222, 184, 135); color: rgb(0, 0, 0);');
        $('e54_codcom').setAttribute('style','background-color: rgb(222, 184, 135); color: rgb(0, 0, 0);');
        $('e54_codcomdescr').setAttribute('style','background-color: rgb(222, 184, 135); color: rgb(0, 0, 0);');

    }

    function js_habilitaCamposLicitacao() {

        $('e54_numerl').removeAttribute('readOnly',true);
        $('e54_tipol').removeAttribute('readOnly',true);
        $('e54_tipol').removeAttribute('disabled',true);
        $('e54_codcom').removeAttribute('disabled',true);
        $('e54_codcomdescr').removeAttribute('disabled',true);
        $('e54_numerl').removeAttribute('style','background-color: rgb(222, 184, 135); color: rgb(0, 0, 0);');
        $('e54_tipol').removeAttribute('style','background-color: rgb(222, 184, 135); color: rgb(0, 0, 0);');
        $('e54_codcom').removeAttribute('style','background-color: rgb(222, 184, 135); color: rgb(0, 0, 0);');
        $('e54_codcomdescr').removeAttribute('style','background-color: rgb(222, 184, 135); color: rgb(0, 0, 0);');

    }

    js_main();
    $('e54_resumo').style.width='100%';

    /**
     * Lança evento em todos os selects
     */

    function js_changeTotal(){
        let listItens = document.getElementsByClassName('linhagrid checkbox');
        for(let count = 0; count < listItens.length; count++){
            listItens[count].addEventListener('change', event => {
                js_somaItens();
            });
        }
    }

    function js_somaItens(){
        document.getElementById('oGridItenstotalValue').innerText = js_formatar(oGridItens.sum(7), 'f');
    }

    /* Soma todos os itens da lista */
    document.getElementById('oGridItensSelectAll').addEventListener('click', event => {
        js_somaItens();
    })

</script>
<?php
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));

// arquivo revertido
?>
