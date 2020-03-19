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
$clrotulo->label("e54_autori");
$clrotulo->label("e54_numcgm");
$clrotulo->label("e54_emiss");

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
    $sMesErro = "<b>* Está Instituição não utiliza Atesto do Controle Interno *</b> para autorização de empenho.";
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
                            <td nowrap title="<?=@$Te54_autori?>" align="left">
                                <? db_ancora('Autorização de Empenho',"js_pesquisae54_autoriIni();",$dbopcao); ?>
                            </td>
                            <td>
                                <? db_input('e54_autori',10,$Ie54_autori,$bOpcao,
                                    'text',$dbopcao,"","e54_autori_ini");  ?>
                                <strong>
                                    <? db_ancora('até',"js_pesquisae54_autoriFim();",$dbopcao); ?>
                                </strong>
                                <? db_input('e54_autori',10,$Ie54_autori,$bOpcao,
                                    'text',$dbopcao,"","e54_autori_fim");  ?>
                            </td>
                        </tr>
                        <tr>
                            <td nowrap align="left">
                                <? db_ancora("<b>Razão Social:</b>","js_pesquisa_e54_numcgm(true);",$dbopcao); ?>
                            </td>
                            <td  align="left" nowrap>
                                <? db_input('e54_numcgm',10,@$Ie54_numcgm,$bOpcao,'text',
                                    $dbopcao," onchange='js_pesquisa_e54_numcgm(false);'","" );

                                db_input('z01_nome',40,@$Iz01_nome,$bOpcao,'text',3,"","" );  ?>
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
                <input  name="pesquisar" id="pesquisar" type="button" value="Pesquisar" onclick="js_pesquisaEmpenho();" <?=$sDisable;?>>
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
        $('e54_autori_ini').value = '';
        $('e54_autori_fim').value = '';
        $('e54_numcgm').value     = '';
        $('z01_nome').value       = '';
        $('dtemissaoini').value   = '';
        $('dtemissaofim').value   = '';
    }

    /*
     * Pesquisa os Empenhos para liberação
    */

    function js_pesquisaEmpenho() {

        var dtEmissini = $F('dtemissaoini');
        var dtEmissfim = $F('dtemissaofim');
        var codAutIni  = $F('e54_autori_ini');
        var codAutFim  = $F('e54_autori_fim');
        var numCgm     = $F('e54_numcgm');

        $('pesquisar').disabled = true;
        $('limpar').disabled    = true;

        js_divCarregando("Aguarde.. Pesquisando ","msgbox");
        var oParam        = new Object();
        oParam.exec       = "pesquisaAutorizacao";
        oParam.codautini  = codAutIni;
        oParam.codautfim  = codAutFim;
        oParam.numcgm     = numCgm;
        oParam.dtemissini = dtEmissini;
        oParam.dtemissfim = dtEmissfim;

        // consulta ajax retorna objeto json
        console.log(oParam); return false;
        var oAjax        = new Ajax.Request(
            "emp4_liberarempenhos.RPC.php",
            {
                method    : 'post',
                parameters: 'json='+js_objectToJson(oParam),
                onComplete: js_retornoPesquisa
            }
        );
    }

    /*
     * Preocessa o retono da pesquisa de empenhos para liberacao
    */

    function js_retornoPesquisa(oAjax) {

        js_removeObj("msgbox");
        var oRetorno = eval("("+oAjax.responseText+")");

        if (oRetorno.status == 1) {
            js_openPesquisaEmpenhos(oRetorno.aItens,oRetorno.aItens.length);
        }
    }

    /*
     * Mostra a GRID com os registros retornado da pesquisa de empenhos para a liberacao
    */

    function js_openPesquisaEmpenhos(aEmpenhos,iRetornoEmpenhos) {


        /**
         * Adiciona a grid na janela
         */

        oGridEmpenho              = new DBGrid('gridEmpenho');
        oGridEmpenho.nameInstance = "oGridEmpenho";
        oGridEmpenho.setHeight((document.body.scrollHeight/2)-50);
        oGridEmpenho.setCheckbox(0);
        oGridEmpenho.setHeader(new Array('Numero','Código','Valor','Valor Anulado','Saldo',
            'CNPJ/CPF','Credor','Data Emissao','Depto Origem'));
        oGridEmpenho.setCellWidth(new Array("7%","10%","7%",'10%',"7%","15%","16%","10%","14%"));
        oGridEmpenho.setCellAlign(new Array("center", "center", "right", "right", "right", "center", "left","center","left"));
        //oGridEmpenho.aHeaders[9].lDisplayed = false;

        windowEmpenhosLiberados = new windowAux('windowEmpenhosLiberados','Empenhos', document.body.getWidth() /1.3);
        windowEmpenhosLiberados.allowCloseWithEsc(false);
        var sContent  = "<div style='width:100%;'><fieldset>";
        sContent += "  <div id='ctnGridEmpenhosLiberados' style='width:99%;'>";
        sContent += "  </div>";
        sContent += "</fieldset>";
        sContent += "<br>";
        sContent += "<center>";
        sContent += "  <table id='frmLiberaEmpenho'>";
        sContent += "    <tr align='center'>";
        sContent += "      <td>";
        sContent += "        <input type='button' id='btnLiberarEmpenho' value='Liberar/Bloquear' onclick='js_liberarempenho();'>";
        sContent += "      </td>";
        sContent += "    </tr>";
        sContent += "  </table>";
        sContent += "</center></div>";
        windowEmpenhosLiberados.setContent(sContent);
        oGridEmpenho.show($('ctnGridEmpenhosLiberados'));
        windowEmpenhosLiberados.show();


        $('windowwindowEmpenhosLiberados_btnclose').onclick= function () {

            windowEmpenhosLiberados.destroy();
            $('pesquisar').disabled = false;
            $('limpar').disabled    = false;
        }

        oGridEmpenho.clearAll(true);

        if (iRetornoEmpenhos == 0) {
            oGridEmpenho.setStatus('Não foram encontrados Registros');
        } else {
            for (var i = 0; i < aEmpenhos.length; i++) {

                with(aEmpenhos[i]) {

                    var aLinha        = new Array();
                    aLinha[0]     = e60_numemp;
                    aLinha[1]     = "<a href='#' onclick='javascript: js_mostraDadosEmpenho("+e60_numemp+");'>"+e60_codemp+"/"+e60_anousu+"</a>";
                    aLinha[2]     = js_formatar(e60_vlremp,'f');
                    aLinha[3]     = js_formatar(e60_vlranu,'f');
                    aLinha[4]     = js_formatar(saldo,'f');
                    aLinha[5]     = js_formatar(z01_cgccpf,'cpfcnpj');
                    aLinha[6]     = z01_nome.urlDecode().substring(0,30);
                    aLinha[7]     = js_formatar(e60_emiss,'f');
                    aLinha[8]     = origem.urlDecode().substring(0,40);

                    var lMarca    = false;
                    var lBloquear = false;
                    if (e22_sequencial != "") {
                        lMarca = true;
                    }

                    if (temordemdecompra == 't') {

                        lBloquear = true;
                        lMarca    = true;

                    }
                    oGridEmpenho.addRow(aLinha, false, lBloquear, lMarca);
                    oGridEmpenho.aRows[i].aCells[7].sEvents += "onMouseOver='js_setAjuda(\""+z01_nome.urlDecode()+"\",true)'";
                    oGridEmpenho.aRows[i].aCells[7].sEvents += "onMouseOut='js_setAjuda(null, false)'";
                    oGridEmpenho.aRows[i].aCells[9].sEvents += "onMouseOver='js_setAjuda(\""+origem.urlDecode()+"\",true)'";
                    oGridEmpenho.aRows[i].aCells[9].sEvents += "onMouseOut='js_setAjuda(null, false)'";
                }
            }
        }

        oGridEmpenho.renderRows();
        $('pesquisar').disabled = false;
        $('limpar').disabled    = false;
        var oMessageBoard = new messageBoard('msg1',
            'Liberar Empenhos para Ordem de Compra e Liquidação',
            'Somente os empenhos selecionados serão liberados para geração de Ordem de Compra. Os Empenhos que estiverem desmarcados continuarão ou serão bloqueados',
            $('windowwindowEmpenhosLiberados_content')
        );
        oMessageBoard.show();
    }

    /*
     * Libera empenhos
    */

    function js_liberarempenho() {

        var aItens     = oGridEmpenho.aRows;

        if (!confirm('Está rotina irá Liberar os empenhos marcados e Bloquear os empenhos desmarcados contidos na lista . Deseja Continuar?')){
            return false;
        }

        js_divCarregando("Aguarde.. Processando ","msgbox");
        $('pesquisar').disabled         = true;
        $('limpar').disabled            = true;
        $('btnLiberarEmpenho').disabled = true;

        var oParam        = new Object();
        oParam.exec       = "processaEmpenhoLiberados";
        oParam.aEmpenhos  = new Array();

        for (var i = 0; i < aItens.length; i++) {

            var oEmpenho          = new Object();
            oEmpenho.iNumemp  = aItens[i].aCells[1].getValue();
            oEmpenho.lLiberar = aItens[i].isSelected;
            oParam.aEmpenhos.push(oEmpenho);

        }
        var oAjax        = new Ajax.Request(
            "emp4_liberarempenhos.RPC.php",
            {
                method    : 'post',
                parameters: 'json='+js_objectToJson(oParam),
                onComplete: js_retornoLiberarEmpenho
            }
        );
    }

    /*
     * Retorno dos empenhos liberados
    */

    function js_retornoLiberarEmpenho(oAjax) {

        js_removeObj("msgbox");
        $('btnLiberarEmpenho').disabled  = false;
        var oRetorno = eval("("+oAjax.responseText+")");

        if (oRetorno.status == 1) {

            alert('Processo efetuado com sucesso.');
            windowEmpenhosLiberados.destroy();
            js_pesquisaEmpenho();
        } else {
            alert(oRetorno.message.urlDecode());
        }
    }

    /*
     * Monta div com testo de ajuda
    */

    function js_setAjuda(sTexto,lShow) {

        if (lShow) {

            var el =  $('gridgridEmpenho');
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

    function js_pesquisae54_autoriIni(){
        js_OpenJanelaIframe('top.corpo.iframe_db_atestoautoemp', 'db_iframe_orcreservaaut', 'func_orcreservaautnota.php?funcao_js=parent.js_mostracodAutIni|e54_autori|e55_codele', 'Pesquisa', true, 0);
    }

    function js_mostracodAutIni(chave1,chave2){
        $('e54_autori_ini').value = chave1+'/'+chave2;
        db_iframe_orcreservaaut.hide();
    }

    function js_pesquisae54_autoriFim(){
        js_OpenJanelaIframe('top.corpo.iframe_db_atestoautoemp', 'db_iframe_orcreservaaut', 'func_orcreservaautnota.php?funcao_js=parent.js_mostracodAutFim|e54_autori|e55_codele', 'Pesquisa', true, 0);
    }
    function js_mostracodAutFim(chave1,chave2){
        $('e54_autori_fim').value = chave1+'/'+chave2;
        db_iframe_orcreservaaut.hide();
    }

    function js_pesquisa_e54_numcgm(mostra){
        var e54_numcgm  = $('e54_numcgm').value;
        var sUrl1       = 'func_nome.php?funcao_js=parent.js_mostrae54_numcgm1|z01_numcgm|z01_nome&ifrname=func_nome';
        var sUrl2       = 'func_nome.php?pesquisa_chave='+e54_numcgm+'&funcao_js=parent.js_mostrae54_numcgm';

        if(mostra == true){
            js_OpenJanelaIframe('top.corpo.iframe_db_atestoautoemp','func_nome',sUrl1,'Pesquisa',true,0);
        }else{
            if(e54_numcgm != ''){
                js_OpenJanelaIframe('top.corpo.iframe_db_atestoautoemp','func_nome',sUrl2,'Pesquisa',false);
            }else{
                $('e54_numcgm').value = '';
                $('z01_nome').value   = '';
            }
        }
    }
    function js_mostrae54_numcgm(erro,chave){
        if(erro == true){
            $('e54_numcgm').focus();
            $('e54_numcgm').value = '';
            $('z01_nome').value   = '';
        } else {
            $('z01_nome').value   = chave;
        }
    }
    function js_mostrae54_numcgm1(chave1,chave2){
        $('e54_numcgm').value = chave1;
        $('z01_nome').value   = chave2;
        func_nome.hide();
    }

    function js_mostraDadosEmpenho(empChave) {

        js_JanelaAutomatica('empempenho',empChave);
        $('Jandb_janelaReceita').style.zIndex = '10000';
    }
</script>