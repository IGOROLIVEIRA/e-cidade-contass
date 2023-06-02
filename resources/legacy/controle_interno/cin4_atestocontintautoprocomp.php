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

/**
 *
 * @author I
 * @revision $Author: dbandrio.costa $
 * @version $Revision: 1.6 $
 */

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
require("libs/db_app.utils.php");
include("libs/db_utils.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_empparametro_classe.php");

$clempparametro = new cl_empparametro;
$clrotulo = new rotulocampo;
$clrotulo->label("pc80_codproc");
$clrotulo->label("pc80_data");

$dbopcao  = 1;
$bOpcao   = true;
$sDisable = "";
$sMesErro = "";

$result = $clempparametro->sql_record($clempparametro->sql_query(db_getsession("DB_anousu")));

if($result != false && $clempparametro->numrows > 0){
    $oParam = db_utils::fieldsMemory($result,0);
}

/*
 * Desabilita a pesquisa caso os parametros tiver como nao
 */

if ($oParam->e30_atestocontinterno != 't') {
    $dbopcao  = 3;
    $sDisable = "disabled";
    $sMesErro = "<b>* Está Instituição não utiliza Atesto do Controle Interno *</b> para processo de compras.";
}
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
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table>
    <tr>
        <td>&nbsp;</td>
    </tr>
</table>
<form name="form1" method="post">
    <table align="center" border="0">
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <fieldset>
                    <legend><b>Atesto do Controle Interno<b></legend>
                    <table  align="center" border="0">
                        <tr>
                            <td nowrap title="<?=@$Tpc80_codproc?>" align="left">
                                <? db_ancora(@$Lpc80_codproc,"js_pesquisasi01_processocompraIni();",$dbopcao); ?>
                            </td>
                            <td>
                                <? db_input('pc80_codproc',10,$Ipc80_codproc,$bOpcao,
                                    'text',$dbopcao,"","pc80_codproc_ini");  ?>
                                <strong>
                                    <? db_ancora('até',"js_pesquisasi01_processocompraFim();",$dbopcao); ?>
                                </strong>
                                <? db_input('pc80_codproc',10,$Ipc80_codproc,$bOpcao,
                                    'text',$dbopcao,"","pc80_codproc_fim");  ?>
                            </td>
                        </tr>
                        <tr>
                            <td nowrap align="left"><b>Data de Emissão:</b></td>
                            <td  align="left" nowrap>
                                <?
                                db_inputdata('dtemissaoini',@$dia,@$mes,@$ano,$bOpcao,'text',$dbopcao,"");
                                echo " <b>até:</b> ";
                                db_inputdata('dtemissaofim',@$dia2,@$mes2,@$ano2,$bOpcao,'text',$dbopcao,"");
                                ?>
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </td>
        </tr>
        <tr>
            <td align="center">
                <input  name="pesquisar" id="pesquisar" type="button" value="Pesquisar" onclick="js_pesquisaProcessoCompra();" <?=$sDisable;?>>
                <input  name="limpar" id="limpar" type="button" value="Limpar" onclick="js_limparcampos();" <?=$sDisable;?>>
            </td>
        </tr>
    </table>
</form>
<table align="center">
    <tr>
        <td>
            <?=$sMesErro;?>
        </td>
    </tr>
</table>
</body>
</html>
<div style='position:absolute;top: 200px; left:15px;
            border:1px solid black;
            width:300px;
            text-align: left;
            padding:3px;
            background-color: #FFFFCC;
            display:none;z-index: 100000'
     id='ajudaItem'>

</div>
<script>

    /*
     * Limpa os campos
    */

    function js_limparcampos(){
        $('pc80_codproc_ini').value = '';
        $('pc80_codproc_fim').value = '';
        $('dtemissaoini').value     = '';
        $('dtemissaofim').value     = '';
    }

    /*
     * Pesquisa os Processos de Compra para liberação
    */

    function js_pesquisaProcessoCompra() {

        var dtEmissini   = $F('dtemissaoini');
        var dtEmissfim   = $F('dtemissaofim');
        var codProcIni   = $F('pc80_codproc_ini');
        var codProcFim   = $F('pc80_codproc_fim');

        $('pesquisar').disabled = true;
        $('limpar').disabled    = true;

        js_divCarregando("Aguarde.. Pesquisando ","msgbox");
        var oParam          = new Object();
        oParam.exec         = "pesquisaProcessoCompra";
        oParam.codprocini   = codProcIni;
        oParam.codprocfim   = codProcFim;
        oParam.dtemissini   = dtEmissini;
        oParam.dtemissfim   = dtEmissfim;

        // consulta ajax retorna objeto json

        var oAjax        = new Ajax.Request(
            "cin4_atestocontint.RPC.php",
            {
                method    : 'post',
                parameters: 'json='+js_objectToJson(oParam),
                onComplete: js_retornoPesquisa
            }
        );
    }

    /*
     * Preocessa o retono da pesquisa de processos de compra para liberacao
    */

    function js_retornoPesquisa(oAjax) {

        js_removeObj("msgbox");
        var oRetorno = eval("("+oAjax.responseText+")");

        if (oRetorno.status == 1) {
            js_openPesquisaProcessoCompra(oRetorno.aItens,oRetorno.aItens.length);
        }
    }

    /*
     * Mostra a GRID com os registros retornado da pesquisa de processos de compras para a liberacao
    */

    function js_openPesquisaProcessoCompra(aProcCompras,iRetornoProcCompras) {


        /**
         * Adiciona a grid na janela
         */

        oGridProcessoCompra              = new DBGrid('processoCompra');
        oGridProcessoCompra.nameInstance = "oGridProcessoCompra";
        oGridProcessoCompra.setHeight((document.body.scrollHeight/2)-50);
        oGridProcessoCompra.setCheckbox(0);
        oGridProcessoCompra.setHeader(new Array('Data de Emissão','Processo de Compras','Departamento','Data da Última Cotação','Resumo'));
        oGridProcessoCompra.setCellWidth(new Array("15%","16%","24%",'20%',"24%"));
        oGridProcessoCompra.setCellAlign(new Array("center", "center", "center", "center", "center"))

        windowProcCompraLiberados = new windowAux('windowProcCompraLiberados','Empenhos', document.body.getWidth() /1.3);
        windowProcCompraLiberados.allowCloseWithEsc(false);
        var sContent  = "<div style='width:100%;'><fieldset>";
        sContent += "  <div id='ctnGridProcCompraLiberados' style='width:99%;'>";
        sContent += "  </div>";
        sContent += "</fieldset>";
        sContent += "<br>";
        sContent += "<center>";
        sContent += "  <table id='frmLiberaEmpenho'>";
        sContent += "    <tr align='center'>";
        sContent += "      <td>";
        sContent += "        <input type='button' id='btnLiberarProcCompra' value='Liberar/Bloquear' onclick='js_liberarproccompra();'>";
        sContent += "      </td>";
        sContent += "    </tr>";
        sContent += "  </table>";
        sContent += "</center></div>";
        windowProcCompraLiberados.setContent(sContent);
        oGridProcessoCompra.show($('ctnGridProcCompraLiberados'));
        windowProcCompraLiberados.show();


        $('windowwindowProcCompraLiberados_btnclose').onclick= function () {

            windowProcCompraLiberados.destroy();
            $('pesquisar').disabled = false;
            $('limpar').disabled    = false;
        }

        oGridProcessoCompra.clearAll(true);

        if (iRetornoProcCompras == 0) {
            oGridProcessoCompra.setStatus('Não foram encontrados Registros');
        } else {
            for (var i = 0; i < aProcCompras.length; i++) {

                with(aProcCompras[i]) {

                    var aLinha        = new Array();
                    aLinha[0]     = pc80_data;
                    aLinha[1]     = "<a href='#' onclick='javascript: js_mostraDadosProcCompra("+pc80_codproc+");'>"+pc80_codproc+"</a>";
                    aLinha[2]     = descrdepto.urlDecode().substring(0,40);
                    aLinha[3]     = si01_datacotacao;
                    aLinha[4]     = pc80_resumo.urlDecode().substring(0,70);

                    var lMarca    = false;
                    var lBloquear = false;

                    if (e233_sequencial != "") {
                        lMarca = true;
                    }

                    oGridProcessoCompra.addRow(aLinha, false, lBloquear, lMarca);
                    oGridProcessoCompra.aRows[i].aCells[3].sEvents += "onMouseOver='js_setAjuda(\""+descrdepto.urlDecode()+"\",true)'";
                    oGridProcessoCompra.aRows[i].aCells[3].sEvents += "onMouseOut='js_setAjuda(null, false)'";
                    oGridProcessoCompra.aRows[i].aCells[5].sEvents += "onMouseOver='js_setAjuda(\""+pc80_resumo.urlDecode()+"\",true)'";
                    oGridProcessoCompra.aRows[i].aCells[5].sEvents += "onMouseOut='js_setAjuda(null, false)'";
                }
            }
        }

        oGridProcessoCompra.renderRows();
        $('pesquisar').disabled = false;
        $('limpar').disabled    = false;
        var oMessageBoard = new messageBoard('msg1',
            'Liberação de Processos de Compras para Licitações',
            'Somente os processos de compras selecionados serão liberados para vinculação à licitação, os demais permanecerão bloqueados.',
            $('windowwindowProcCompraLiberados_content')
        );
        oMessageBoard.show();
    }

    /*
     * Libera processos de compra
    */

    function js_liberarproccompra() {

        var aItens     = oGridProcessoCompra.aRows;

        if (!confirm('Está rotina irá Liberar os Processos de Compras marcados e Bloquear os empenhos desmarcados contidos na lista. Deseja Continuar?')){
            return false;
        }

        js_divCarregando("Aguarde.. Processando ","msgbox");
        $('pesquisar').disabled         = true;
        $('limpar').disabled            = true;
        $('btnLiberarProcCompra').disabled = true;

        var oParam        = new Object();
        oParam.exec       = "processaProcessoCompraLiberados";
        oParam.aProcCompras  = new Array();

        for (var i = 0; i < aItens.length; i++) {

            var oProcCompra          = new Object();
            oProcCompra.iNumProc  = aItens[i].aCells[2].getValue();
            oProcCompra.lLiberar = aItens[i].isSelected;
            oParam.aProcCompras.push(oProcCompra);

        }
        var oAjax        = new Ajax.Request(
            "cin4_atestocontint.RPC.php",
            {
                method    : 'post',
                parameters: 'json='+js_objectToJson(oParam),
                onComplete: js_retornoLiberarProcCompra
            }
        );
    }

    /*
     * Retorno dos empenhos liberados
    */

    function js_retornoLiberarProcCompra(oAjax) {

        js_removeObj("msgbox");
        $('btnLiberarProcCompra').disabled  = false;
        var oRetorno = eval("("+oAjax.responseText+")");

        if (oRetorno.status == 1) {

            alert('Processo efetuado com sucesso.');
            windowProcCompraLiberados.destroy();
            js_pesquisaProcessoCompra();
        } else {
            alert(oRetorno.message.urlDecode());
        }
    }

    /*
     * Monta div com testo de ajuda
    */

    function js_setAjuda(sTexto,lShow) {

        if (lShow) {

            var el =  $('gridprocessoCompra');
            var x  = 0;
            var y  = el.offsetHeight;

            //Walk up the DOM and add up all of the offset positions.
            while (el.offsetParent && el.tagName.toUpperCase() != 'BODY')
            {
                // if (el.className != "windowAux12") {

                x += el.offsetLeft;
                y += el.offsetTop;

                // }
                el = el.offsetParent;
            }
            x += el.offsetLeft
            y += el.offsetTop;
            $('ajudaItem').innerHTML     = sTexto;
            $('ajudaItem').style.display = '';
            $('ajudaItem').style.top     = y+"px";
            $('ajudaItem').style.left    = x+"px";

        } else {
            $('ajudaItem').style.display = 'none';
        }
    }

    function js_pesquisasi01_processocompraIni(){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_db_atestoautoprocomp', 'db_iframe_pcproc', 'func_pcprocnovo.php?funcao_js=parent.js_mostrapcprocIni|pc80_codproc', 'Pesquisa', true, 0);
    }

    function js_mostrapcprocIni(chave1){
        $('pc80_codproc_ini').value = chave1;
        db_iframe_pcproc.hide();
    }

    function js_pesquisasi01_processocompraFim(){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_db_atestoautoprocomp', 'db_iframe_pcproc', 'func_pcprocnovo.php?funcao_js=parent.js_mostrapcprocFim|pc80_codproc', 'Pesquisa', true, 0);
    }

    function js_mostrapcprocFim(chave1){
        $('pc80_codproc_fim').value = chave1;
        db_iframe_pcproc.hide();
    }

    function js_mostraDadosEmpenho(empChave) {

        js_JanelaAutomatica('empempenho',empChave);
        $('Jandb_iframe_processos_filtrados').style.zIndex = '10000';
    }

    function js_mostraDadosProcCompra(pcompraChave) {

        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_db_atestoautoprocomp',
            'db_iframe_pesquisa_processo',
            'com3_pesquisaprocessocompras003.php?pc80_codproc=' + pcompraChave,
            'Consulta Processo de Compras',
            true,
            0
        );

        $('Jandb_iframe_pesquisa_processo').style.zIndex = '10000';

    }

</script>
