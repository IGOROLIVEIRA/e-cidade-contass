<?
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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("libs/JSON.php");
include("classes/db_lancamverifaudit_classe.php");

db_postmemory($HTTP_POST_VARS);

$cllancamverifaudit = new cl_lancamverifaudit;
$clrotulo = new rotulocampo;
$clrotulo->label('ci05_achados');

$oJson = new services_json();
$Tci05_achados = $oJson->encode(urlencode($Tci05_achados));

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/AjaxRequest.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/datagrid.widget.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/widgets/DBToogle.widget.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/widgets/windowAux.widget.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/widgets/dbtextField.widget.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">
.linhagrid.center {
  text-align: center;
}
.linhagrid input[type='text'] {
  width: 100%;
}
.normal:hover {
  background-color: #eee;
}
.DBGrid {
  width: 100%;
  border: 1px solid #888;
  margin: 20px 0;
}
</style>

</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
    <tr>
        <td width="360" height="18">&nbsp;</td>
        <td width="263">&nbsp;</td>
        <td width="25">&nbsp;</td>
        <td width="140">&nbsp;</td>
    </tr>
</table>

<form name="form1">
    <table align="center" cellspacing='0' border="0">
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <fieldset>
                    <legend>
                    <b>Lançamento de Verificações</b>
                    </legend>
                    <table align="center">
                        <td align="left">
                            <b>Questões: </b>
                        </td>
                        <td>
                            <select id="select" style="width: 300px;" onchange="js_buscaQuestoes(this.value)">
                                <option value="1">Pendentes</option>
                                <option value="2">Respondidas</option>
                                <option value="3">Todas</option>
                            </select>
                            <input type="hidden" name="iCodProc" id="iCodProc" value="<?= $ci03_codproc ?>">
                        </td>
                    </table>
                    <table class="DBGrid">
                        <thead>
                            <tr>
                                <th class="table_header" style="width: 23px; cursor: pointer;" onclick="marcarTodos();" id="marcarTodos">M</th>
                                <th class="table_header" style="width: 40px;">Nº Questão</th>
                                <th class="table_header" style="width: 160px;">Questões de Auditoria</th>
                                <th class="table_header" style="width: 160px;">Informações Requeridas</th>
                                <th class="table_header" style="width: 160px;">Fonte das Informações</th>
                                <th class="table_header" style="width: 160px;">Procedimento Detalhado</th>
                                <th class="table_header" style="width: 160px;">Objetos</th>
                                <th class="table_header" style="width: 160px;">Possíveis Achados Negativos</th>
                                <th class="table_header" style="width: 100px;">Início Análise</th>
                                <th class="table_header" style="width: 120px;">Atende à Questão de Auditoria</th>
                                <th class="table_header" style="width: 80px;">Achados</th></th>
                            </tr>
                        </thead>
                        <tbody id="gridQuestoesLancam">

                        </tbody>
                    </table>

                </fieldset>
            </td>
        </tr>
    </table>
<br>
<center>
    <input name="salvar" id="salvar" type="button" value="Salvar" onclick="js_salvarGeral()">
    <input name="limpar" id="limpar" type="button" value="Limpar" onclick="js_limpar()">
    <input name="imprimir" id="imprimir" type="button" value="Imprimir" onclick="js_imprimir()">
    <input name="iNumQuestoes" id="iNumQuestoes" type="hidden" value="0">
</center>
</form>
<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>

    const sRPC = 'cin4_lancamverifaudit.RPC.php';

    js_buscaQuestoes();

    function js_buscaQuestoes(iOpcao = 1) {

        try{

            js_divCarregando("Aguarde, buscando questões...", "msgBox");

            var oParametro    = new Object();
            oParametro.exec   = 'getQuestoes';
            oParametro.iOpcao = iOpcao;
            oParametro.iCodProc = document.form1.iCodProc.value;

            new Ajax.Request(sRPC,
                            {
                                method: 'post',
                                parameters: 'json='+Object.toJSON(oParametro),
                                onComplete: js_completaGetQuestoes
                            });

        } catch (e) {
            alert(e.toString());
        }

    }

    function js_completaGetQuestoes(oAjax) {

        js_removeObj('msgBox');
        var oRetorno = eval("("+oAjax.responseText+")");

        if (oRetorno.status == 1) {

            document.getElementById("gridQuestoesLancam").innerHTML = '';
            document.form1.iNumQuestoes.value = oRetorno.aQuestoes.length;

            oRetorno.aQuestoes.each(function (oQuestao, iLinha) {

                js_adicionaLinhaQuestao(oQuestao, iLinha);

            });

        }

    }

    function js_adicionaLinhaQuestao(oQuestao = null, iLinha = null) {

        var sLinhaTabela = '';

        sLinhaTabela += "<tr id='"+iLinha+"' class='normal'>";
        sLinhaTabela += "   <th class='table_header'>";
        sLinhaTabela += "       <input type='checkbox' class='marca_itens' name='aItensMarcados[]' value='"+ iLinha +"' >";
        sLinhaTabela += "       <input type='hidden' name='aQuestoes["+ iLinha +"][ci02_codquestao]' value='"+ oQuestao.ci02_codquestao +"'>";
        sLinhaTabela += "       <input type='hidden' name='aQuestoes["+ iLinha +"][ci03_codproc]' value='"+ oQuestao.ci03_codproc +"'>";
        sLinhaTabela += "       <input type='hidden' name='aQuestoes["+ iLinha +"][ci05_codlan]' value='"+ oQuestao.ci05_codlan +"'>";
        sLinhaTabela += "   </th>";
        sLinhaTabela += "   <td class='linhagrid center'>";
        sLinhaTabela +=         oQuestao.ci02_numquestao +"<input type='hidden' name='aQuestoes["+ iLinha +"][ci02_numquestao]' value='"+ oQuestao.ci02_numquestao +"'>";
        sLinhaTabela += "   </td>";
        sLinhaTabela += "   <td class='linhagrid center'>";
        sLinhaTabela +=         oQuestao.ci02_questao.urlDecode();
        sLinhaTabela += "   </td>";
        sLinhaTabela += "   <td class='linhagrid center'>";
        sLinhaTabela +=         oQuestao.ci02_inforeq.urlDecode();
        sLinhaTabela += "   </td>";
        sLinhaTabela += "   <td class='linhagrid center'>";
        sLinhaTabela +=         oQuestao.ci02_fonteinfo.urlDecode();
        sLinhaTabela += "   </td>";
        sLinhaTabela += "   <td class='linhagrid center'>";
        sLinhaTabela +=         oQuestao.ci02_procdetal.urlDecode();
        sLinhaTabela += "   </td>";
        sLinhaTabela += "   <td class='linhagrid center'>";
        sLinhaTabela +=         oQuestao.ci02_objeto.urlDecode();
        sLinhaTabela += "   </td>";
        sLinhaTabela += "   <td class='linhagrid center'>";
        sLinhaTabela +=         oQuestao.ci02_possivachadneg.urlDecode();
        sLinhaTabela += "   </td>";
        sLinhaTabela += "   <td class='linhagrid center'>";
        sLinhaTabela +=         js_inputdata("aQuestoes"+ iLinha +"ci05_inianalise", oQuestao.ci05_inianalise, iLinha);
        sLinhaTabela += "   </td>";
        sLinhaTabela += "   <td class='linhagrid center'>";
        sLinhaTabela += "       <select name='aQuestoes["+ iLinha +"][ci05_atendquestaudit]' id='aQuestoes["+ iLinha +"][ci05_atendquestaudit]' value = '"+ oQuestao.ci05_atendquestaudit +"' style='width: 120px;' onchange='js_liberaAchados("+ iLinha +", this.value, true);' disabled='true'>";
        sLinhaTabela += "           <option>Selecione</option>";
        sLinhaTabela += "           <option value='t'>Sim</option>";
        sLinhaTabela += "           <option value='f'>Não</option>";        
        sLinhaTabela += "       </select>";
        sLinhaTabela += "   </td>";
        sLinhaTabela += "   <td class='linhagrid center'>";
        sLinhaTabela +=         "<input type='button' name='aQuestoes["+ iLinha +"][ci05_achados_btn]' class='btnAddAchado' value ='Achados' disabled='true' onclick='js_mostraJanelaAchado("+iLinha+");' >";
        sLinhaTabela +=         "<input type='hidden' name='aQuestoes["+ iLinha +"][ci05_achados_input]' value ='"+oQuestao.ci05_achados+"' >";
        sLinhaTabela += "   </td>";
        sLinhaTabela += "</tr>";

        document.getElementById("gridQuestoesLancam").innerHTML += sLinhaTabela;

        if (oQuestao.ci05_codlan != '') {
            
            iOpcao = oQuestao.ci05_atendquestaudit == 'f' ? 2 : 1;
            js_liberaQuestao(iLinha, document.getElementById("aQuestoes"+iLinha+"ci05_inianalise"), iOpcao);
            js_liberaAchados(iLinha, oQuestao.ci05_atendquestaudit, false);

        }

    }

    function aItens() {
      
        var itensNum = document.querySelectorAll('.marca_itens');

        return Array.prototype.map.call(itensNum, function (item) {
            return item;
        });

    }

    function marcarTodos() {

        aItens().forEach(function (item) {

            var check = item.classList.contains('marcado');

            if (check) {
                item.classList.remove('marcado');
            } else {
                item.classList.add('marcado');
            }
            item.checked = !check;

        });

    }


    function js_inputdata(sNomeInput, strData = null, iLinha){

        var sValue = '';
        
        if (strData != null) {
            
            var aData = strData.split('-');
            if(aData.length > 1) {
                sValue = aData[2]+'/'+aData[1]+'/'+aData[0];
            }

        }

	    var	strData  = '<input type="text" id="'+sNomeInput+'" value="'+sValue+'" name="'+sNomeInput+'" maxlength="10" size="10" autocomplete="off" onKeyUp="return js_mascaraData(this,event);" onBlur="js_validaDbData(this);" onFocus="js_validaEntrada(this);" onChange="js_liberaQuestao('+iLinha+', this);" style="width: 70px;" >';
            strData += '<input value="D" type="button" name="dtjs_'+sNomeInput+'" onclick="pegaPosMouse(event);show_calendar(\''+sNomeInput+'\',\'none\');" >';
	        strData += '<input name="'+sNomeInput+'_dia" type="hidden" title="" id="'+sNomeInput+'_dia" value="'+aData[2]+'" size="2"  maxlength="2" >';
			strData += '<input name="'+sNomeInput+'_mes" type="hidden" title="" id="'+sNomeInput+'_mes" value="'+aData[1]+'" size="2"  maxlength="2" >'; 
            strData += '<input name="'+sNomeInput+'_ano" type="hidden" title="" id="'+sNomeInput+'_ano" value="'+aData[0]+'" size="4"  maxlength="4" >';
            
        var sStringFunction  = "js_comparaDatas"+sNomeInput+" = function(dia,mes,ano){ \n";
 			sStringFunction += "  var objData        = document.getElementById('"+sNomeInput+"'); \n";
            sStringFunction += "  objData.value      = dia+'/'+mes+'/'+ano; \n";
            sStringFunction += "  js_liberaQuestao("+iLinha+", null); \n";
  		    sStringFunction += "} \n";  
        
        var script = document.createElement("SCRIPT");        
        script.innerHTML = sStringFunction;
        
        document.body.appendChild(script);        
            
        return strData;

    }

    function js_liberaQuestao(iLinha, oObj = null, iOpcao = 0) {

        var bDataValida = (oObj != null) ? js_validaDbData(oObj) : true;

        if (bDataValida) {
            
            document.form1['aQuestoes['+iLinha+'][ci05_atendquestaudit]'].disabled = false;
            document.form1['aQuestoes['+iLinha+'][ci05_atendquestaudit]'].options[iOpcao].selected = 'selected';

        } else {
            
            document.form1['aQuestoes['+iLinha+'][ci05_atendquestaudit]'].options[0].selected = true;
            document.form1['aQuestoes['+iLinha+'][ci05_atendquestaudit]'].disabled = true;

        }

    }

    function js_liberaAchados(iLinha, iValue, bMostra) {

        if (iValue == 'f') {
            
            document.form1['aQuestoes['+iLinha+'][ci05_achados_btn]'].disabled = false;
            
            if (bMostra) {
                js_mostraJanelaAchado(iLinha);
            }

        } else {
            document.form1['aQuestoes['+iLinha+'][ci05_achados_btn]'].disabled = true;
        }

    }

    function js_mostraJanelaAchado(iLinha) {

        windowDotacaoItem = new windowAux('wndAchadosItem', 'Achados', 530, 280);

        sDisabled = '';

        var sLegenda = <?= $Tci05_achados ?>;        

        var sContent = "<div class=\"subcontainer\">";
        sContent += "   <br>";
        sContent += "   <fieldset><legend>Descreva aqui os achados da auditoria</legend>";
        sContent += "       <table>";
        sContent += "           <tr>";
        sContent += "               <td>";
        sContent += "                   <textarea title='"+sLegenda.urlDecode()+"' id='aQuestoes"+iLinha+"ci05_achados' value='' name='aQuestoes"+iLinha+"ci05_achados' rows='6' cols='60' autocomplete='off' onkeyup='js_maxlenghttextarea(this,event,500);' oninput='js_maxlenghttextarea(this,event,500);' ></textarea>";
        sContent += "               </td>";
        sContent += "               <br>";
        sContent += "               <tr>";
        sContent += "                   <td>";
        sContent += "                       <div align='right'>";
        sContent += "                           <span style='float:left;color:red;font-weight:bold' id='aQuestoes"+iLinha+"ci05_achadoserrobar'></span>";
        sContent += "                           <b> Caracteres Digitados : </b> ";
        sContent += "                           <input type='text' name='aQuestoes"+iLinha+"ci05_achadosobsdig' id='aQuestoes"+iLinha+"ci05_achadosobsdig' size='3' value='' style='color: #000;' disabled> ";
        sContent += "                           <b> - Limite 500 </b> ";
        sContent += "                       </div> ";
        sContent += "                   </td>";
        sContent += "               </tr>";
        sContent += "           </tr>";
        sContent += "           <tr>";
        sContent += "               <td id='inputvalordotacao'></td>";
        sContent += "           </tr>";
        sContent += "       </table>";
        sContent += "   </fieldset>";
        sContent += "   <input type='button' "+sDisabled+" value='Salvar' id='btnSalvarAchado' >";
        sContent += "</div>";

        windowDotacaoItem.setContent(sContent);

        windowDotacaoItem.setShutDownFunction(function () {
            windowDotacaoItem.destroy();
            js_ativaDesativaBotoes(false);
        });

        $('btnSalvarAchado').observe("click", function () {
            js_salvarLancamento(iLinha);
        });

        js_ativaDesativaBotoes(true);
        windowDotacaoItem.show();        

        sAchado = document.form1['aQuestoes['+iLinha+'][ci05_achados_input]'].value != '' ? document.form1['aQuestoes['+iLinha+'][ci05_achados_input]'].value : '';
        document.getElementById('aQuestoes'+ iLinha +'ci05_achados').value      = sAchado;
        document.getElementById('aQuestoes'+iLinha+'ci05_achadosobsdig').value  = sAchado.length;        

    }

    function js_salvarLancamento(iLinha) {
        
        sAchado = document.getElementById('aQuestoes'+ iLinha +'ci05_achados').value;

        if (sAchado == '') {
            alert('Informe os achados da auditoria!');
            return false;
        }

        document.form1['aQuestoes['+iLinha+'][ci05_achados_input]'].value = sAchado;

        try{

            js_divCarregando("Aguarde, salvando lançamento...", "msgBox");

            var oParametro  = new Object();
            oParametro.exec = 'salvaLancamento';
            
            
            oParametro.iCodProc     = document.form1['aQuestoes['+iLinha+'][ci03_codproc]'].value; 
            oParametro.iCodQuestao  = document.form1['aQuestoes['+iLinha+'][ci02_codquestao]'].value;            
            oParametro.dtDataIniDia = document.form1['aQuestoes'+iLinha+'ci05_inianalise_dia'].value;
            oParametro.dtDataIniMes = document.form1['aQuestoes'+iLinha+'ci05_inianalise_mes'].value;
            oParametro.dtDataIniAno = document.form1['aQuestoes'+iLinha+'ci05_inianalise_ano'].value;
            oParametro.bAtendeQuest = document.form1['aQuestoes['+iLinha+'][ci05_atendquestaudit]'].value;            
            oParametro.sAchado      = sAchado;
            oParametro.iLinha       = iLinha;

            new Ajax.Request(sRPC,
                            {
                                method: 'post',
                                parameters: 'json='+Object.toJSON(oParametro),
                                onComplete: js_completaSalvarLancamento
                            });

            } catch (e) {
                alert(e.toString());
        }
        
        windowDotacaoItem.destroy();
        js_ativaDesativaBotoes(false);

    }

    function js_completaSalvarLancamento(oAjax) {

        js_removeObj('msgBox');
        var oRetorno = eval("("+oAjax.responseText+")");

        if (oRetorno.status == 1) {

            alert(oRetorno.sMensagem.urlDecode());
            document.form1['aQuestoes['+oRetorno.iLinha+'][ci05_codlan]'].value = oRetorno.iCodLan;

        }

    }

    function js_salvarGeral() {
        alert('salvar geral');
    }

    function js_limpar() {
        alert('limpar');
    }

    function js_imprimir() {
        alert('imprimir');
    }
    
    function js_ativaDesativaBotoes(bStatus = true) {

        var iNumQuestoes = parseInt(document.form1.iNumQuestoes.value);

        for (var iLinha = 0; iLinha <= iNumQuestoes-1; iLinha++) {
            
            if (document.form1['aQuestoes['+iLinha+'][ci05_atendquestaudit]'].value == 'f') {
                document.form1['aQuestoes['+iLinha+'][ci05_achados_btn]'].disabled = bStatus;
            }

            if ( js_validaDbData(document.form1['aQuestoes'+iLinha+'ci05_inianalise']) ) {
                document.form1['aQuestoes['+iLinha+'][ci05_atendquestaudit]'].disabled = bStatus;
            }
            
        }

        document.form1.salvar.disabled      = bStatus;
        document.form1.limpar.disabled      = bStatus;
        document.form1.imprimir.disabled    = bStatus;

    }


</script>