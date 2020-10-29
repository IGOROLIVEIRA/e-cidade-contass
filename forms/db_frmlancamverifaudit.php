<?
//MODULO: Controle Interno
?>

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
                            <select id="iFiltroQuestoes" style="width: 300px;" onchange="js_buscaQuestoes(this.value)">
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
    <input name="salvar" id="salvar" type="button" value="Salvar" onclick="js_verificaQuestaoMatrizSalva()">
    <input name="limpar" id="limpar" type="button" value="Limpar" onclick="js_verificaQuestaoMatrizLimpa()">
    <input name="imprimir" id="imprimir" type="button" value="Imprimir" onclick="js_imprimir()">
    <input name="iNumQuestoes" id="iNumQuestoes" type="hidden" value="0">
</center>
</form>
<script>

    const sRPC = 'cin4_lancamverifaudit.RPC.php';
    const sMensagemExisteAchado = 'A(s) questão(ões) que deseja alterar já possui(em) informação(ões) lançada(s) na Matriz de Achados, as modificações aqui realizadas também serão atualizadas na Matriz, tem certeza que deseja prosseguir com a alteração?';

    js_buscaQuestoes();

    function js_buscaQuestoes(iOpcao = 1) {

        try{

            js_divCarregando("Aguarde, buscando questões...", "msgBox");

            var oParametro    = new Object();
            oParametro.exec   = 'buscaQuestoes';
            oParametro.iOpcao = iOpcao;
            oParametro.iCodProc = document.form1.iCodProc.value;

            new Ajax.Request(sRPC,
                            {
                                method: 'post',
                                parameters: 'json='+Object.toJSON(oParametro),
                                onComplete: js_completaBuscaQuestoes
                            });

        } catch (e) {
            alert(e.toString());
        }

    }

    function js_completaBuscaQuestoes(oAjax) {

        js_removeObj('msgBox');
        var oRetorno = eval("("+oAjax.responseText+")");

        if (oRetorno.status == 1) {

            document.getElementById("gridQuestoesLancam").innerHTML = '';
            document.form1.iNumQuestoes.value = oRetorno.aQuestoes.length;
            
            if (oRetorno.aQuestoes.length == 0) {
                
                js_ativaDesativaBotoes(true);
                js_adicionaLinhaVazia();

            } else {
                
                oRetorno.aQuestoes.each(function (oQuestao, iLinha) {

                    js_adicionaLinhaQuestao(oQuestao, iLinha);

                });

                js_ativaDesativaBotoes(false);

            }            

        } else {
            alert("Erro ao buscar questões.");
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
        sLinhaTabela += "           <option value=''>Selecione</option>";
        sLinhaTabela += "           <option value='t'>Sim</option>";
        sLinhaTabela += "           <option value='f'>Não</option>";        
        sLinhaTabela += "       </select>";
        sLinhaTabela += "   </td>";
        sLinhaTabela += "   <td class='linhagrid center'>";
        sLinhaTabela +=         "<input type='button' name='aQuestoes["+ iLinha +"][ci05_achados_btn]' class='btnAddAchado' value ='Achados' disabled='true' onclick='js_mostraJanelaAchado("+iLinha+");' >";
        sLinhaTabela +=         "<input type='hidden' name='aQuestoes["+ iLinha +"][ci05_achados_input]' value ='"+oQuestao.ci05_achados.urlDecode()+"' >";
        sLinhaTabela += "   </td>";
        sLinhaTabela += "</tr>";

        document.getElementById("gridQuestoesLancam").innerHTML += sLinhaTabela;

        if (oQuestao.ci05_codlan != '') {
            
            iOpcao = oQuestao.ci05_atendquestaudit == 'f' ? 2 : 1;
            js_liberaQuestao(iLinha, null, iOpcao);
            js_liberaAchados(iLinha, oQuestao.ci05_atendquestaudit, false);

        }

    }

    function js_adicionaLinhaVazia() {

        var sLinhaTabela = '';

        sLinhaTabela += "<tr class='normal'>";
        sLinhaTabela += "   <td colspan='11' class='table_header'>Nenhuma questão encontrada.</th>";
        sLinhaTabela += "   </th>";
        sLinhaTabela += "</tr>";

        document.getElementById("gridQuestoesLancam").innerHTML += sLinhaTabela;

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
            document.form1['aQuestoes['+iLinha+'][ci05_atendquestaudit]'].options[iOpcao].setAttribute('selected', false);

        } else {
            
            document.form1['aQuestoes['+iLinha+'][ci05_atendquestaudit]'].options[0].selected = true;
            document.form1['aQuestoes['+iLinha+'][ci05_atendquestaudit]'].setAttribute('value', '');
            document.form1['aQuestoes['+iLinha+'][ci05_atendquestaudit]'].disabled = true;

        }

    }

    function js_liberaAchados(iLinha, iValue, bMostra) {
        
        document.form1['aQuestoes['+iLinha+'][ci05_atendquestaudit]'].setAttribute('value', iValue);

        if (iValue == 'f') {
            
            document.form1['aQuestoes['+iLinha+'][ci05_achados_btn]'].disabled = false;
            
            if (bMostra) {
                js_mostraJanelaAchado(iLinha);
            }

        } else {

            document.form1['aQuestoes['+iLinha+'][ci05_achados_btn]'].disabled = true;
            document.form1['aQuestoes['+iLinha+'][ci05_achados_input]'].value = '';

        }

    }

    function js_mostraJanelaAchado(iLinha) {

        windowDotacaoItem = new windowAux('wndAchadosItem', 'Achados', 530, 280);

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
        sContent += "   <input type='button' value='Salvar' id='btnSalvarAchado' >";
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
        
        var sAchados = document.getElementById('aQuestoes'+ iLinha +'ci05_achados').value;
        
        var iCodLan = null;

        if (sAchados == '') {
            alert('Para item que não atende à questão de auditoria é obrigatório informar os achados.');
            return false;
        }

        document.form1['aQuestoes['+iLinha+'][ci05_achados_input]'].value = sAchados;

        try{

            js_divCarregando("Aguarde, salvando lançamento...", "msgBox");

            var oParametro  = new Object();

            if (document.form1['aQuestoes['+iLinha+'][ci05_codlan]'].value != '') {
            
                oParametro.exec = 'atualizaLancamento';
                oParametro.iCodLan = document.form1['aQuestoes['+iLinha+'][ci05_codlan]'].value;

            } else {
                oParametro.exec = 'salvaLancamento';
            }
            
            oParametro.iCodProc     = document.form1['aQuestoes['+iLinha+'][ci03_codproc]'].value; 
            oParametro.iCodQuestao  = document.form1['aQuestoes['+iLinha+'][ci02_codquestao]'].value;            
            oParametro.dtDataIniDia = document.form1['aQuestoes'+iLinha+'ci05_inianalise_dia'].value;
            oParametro.dtDataIniMes = document.form1['aQuestoes'+iLinha+'ci05_inianalise_mes'].value;
            oParametro.dtDataIniAno = document.form1['aQuestoes'+iLinha+'ci05_inianalise_ano'].value;
            oParametro.bAtendeQuest = document.form1['aQuestoes['+iLinha+'][ci05_atendquestaudit]'].value;            
            oParametro.sAchados     = encodeURIComponent(sAchados.replace(/\\/g,  "<contrabarra>"));            
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

        } else {
            alert(oRetorno.sMensagem.urlDecode());
        }

    }

    function js_verificaQuestaoMatrizSalva() {

        var iNumQuestoes = parseInt(document.form1.iNumQuestoes.value);

        try {
            var aItensVerifica = [];

            for (i = 0; i <= iNumQuestoes-1; i++) {
            
                bAtendeQuest = document.form1['aQuestoes['+i+'][ci05_atendquestaudit]'].getAttribute('value');

                if (bAtendeQuest == "t") {            
                    aItensVerifica.push(document.form1['aQuestoes['+i+'][ci05_codlan]'].value);
                }

            }
            
            var oParam    = new Object();
            oParam.exec   = 'verificaQuestaoMatriz';
            oParam.aItens = aItensVerifica;

            js_divCarregando('Aguarde', 'div_aguarde');

            var oAjax = new Ajax.Request(sRPC, {

                method:'post',
                parameters:'json='+Object.toJSON(oParam),
                onComplete: js_salvaGeral

            });

        } catch(e) {
            alert(e.toString());
        }

    }


    function js_salvaGeral(oAjax) {

        js_removeObj('div_aguarde');
        var oRetorno = eval("("+oAjax.responseText+")");

        if (oRetorno.status == 1) {

            if (oRetorno.bExisteMatriz) {
                if (!confirm(sMensagemExisteAchado)) {
                    return false;
                }
            }
        }

        var iNumQuestoes = parseInt(document.form1.iNumQuestoes.value);

        var questoesEnviar = [];

        try {

            for (i = 0; i <= iNumQuestoes-1; i++) {

                dtIniAnalise = document.form1['aQuestoes'+i+'ci05_inianalise'].value;
                bAtendeQuest = document.form1['aQuestoes['+i+'][ci05_atendquestaudit]'].getAttribute('value');
                sAchados     = document.form1['aQuestoes['+i+'][ci05_achados_input]'].getAttribute('value');   
                
                if (dtIniAnalise != "" && bAtendeQuest == "") {
                    alert('Para salvar é obrigatório informar se atende ou não à questão de auditoria.');
                    return false;
                }

                if (dtIniAnalise != "" && bAtendeQuest == "f" && sAchados == "") {
                    alert("Para item que não atende à questão de auditoria é obrigatório informar os achados.");
                    return false;
                }

                if (dtIniAnalise != "" && bAtendeQuest != "") {
                
                    var novoLancamento = {
                        iCodLan:      document.form1['aQuestoes['+i+'][ci05_codlan]'].value,
                        iCodProc:     document.form1['aQuestoes['+i+'][ci03_codproc]'].value, 
                        iCodQuestao:  document.form1['aQuestoes['+i+'][ci02_codquestao]'].value,            
                        dtDataIniDia: document.form1['aQuestoes'+i+'ci05_inianalise_dia'].value,
                        dtDataIniMes: document.form1['aQuestoes'+i+'ci05_inianalise_mes'].value,
                        dtDataIniAno: document.form1['aQuestoes'+i+'ci05_inianalise_ano'].value,
                        bAtendeQuest: bAtendeQuest,            
                        sAchado:      sAchados,
                    };

                    questoesEnviar.push(novoLancamento);

                }

            }

            if (questoesEnviar.length == 0) {

                alert("Informe a data de início da Análise.");
                return false;

            }

            var oParam = new Object();
            oParam.exec = 'salvaGeral';
            oParam.questoesEnviar   = questoesEnviar;
            oParam.iFiltroQuestoes  = document.form1.iFiltroQuestoes.value;
            oParam.sCodLanExcluir   = oRetorno.sCodsLan;            
            oParam.bExcluiMatriz    = oRetorno.bExisteMatriz;
            
            js_divCarregando("Aguarde, salvando lançamentos...", "msgBox");

            new Ajax.Request(sRPC, 
                            {
                                method: 'post',
                                parameters: 'json='+Object.toJSON(oParam),
                                onComplete: js_completaSalvaGeral
                            });

        } catch(e) {

            alert(e.toString());

        }
        
    }

    function js_completaSalvaGeral(oAjax) {

        js_removeObj('msgBox');
        var oRetorno = eval("("+oAjax.responseText+")");
        
        if (oRetorno.status == 1) {

            alert(oRetorno.sMensagem.urlDecode());
            document.form1['iFiltroQuestoes'].options[oRetorno.iFiltroQuestoes-1].setAttribute('selected', false);
            js_buscaQuestoes(oRetorno.iFiltroQuestoes);

        } else {
            alert(oRetorno.sMensagem.urlDecode());
        }

    }

    function js_verificaQuestaoMatrizLimpa() {
        
        var itens = getItensMarcados();

        if (itens.length < 1) {

            alert('Selecione pelo menos um item da lista.');
            return;

        }

        itens = itens.map(function (iItem) {
            return Number(iItem.value);
        });

        try {

            var aItensExcluir = [];
            
            itens.forEach(function (iItem) {
                aItensExcluir.push(document.form1['aQuestoes['+iItem+'][ci05_codlan]'].value);
            });

            var oParam    = new Object();
            oParam.exec   = 'verificaQuestaoMatriz';
            oParam.aItens = aItensExcluir;
            
            js_divCarregando('Aguarde', 'div_aguarde');

            var oAjax = new Ajax.Request(sRPC, {

                method:'post',
                parameters:'json='+Object.toJSON(oParam),
                onComplete: js_exclui

            });

        } catch(e) {
            alert(e.toString());
        }

    }

    function js_exclui(oAjax) {

        js_removeObj('div_aguarde');
        var oRetorno = eval("("+oAjax.responseText+")");

        if (oRetorno.status == 1) {

            if (oRetorno.bExisteMatriz) {
                if (!confirm(sMensagemExisteAchado)) {
                    return false;
                }
            }

            var oParam    = new Object();
            oParam.exec   = 'excluiLancamento';
            oParam.sItens = oRetorno.sCodsLan;            
            oParam.bExcluiMatriz   = oRetorno.bExisteMatriz;            
            oParam.iFiltroQuestoes = document.form1.iFiltroQuestoes.value;

            js_divCarregando('Aguarde', 'div_aguarde');

            var oAjax = new Ajax.Request(sRPC, {
                
                method:'post',
                parameters:'json='+Object.toJSON(oParam),
                onComplete: js_retornoExclui

            });

        } else {
            alert('Erro ao verificar se há matriz de achados para a questão.');
        }

    }

    function js_retornoExclui(oAjax) {
      
        js_removeObj('div_aguarde');
        var oRetorno = eval("("+oAjax.responseText+")");

        if (oRetorno.status == 1) {
            alert(oRetorno.sMensagem.urlDecode());
            js_buscaQuestoes(oRetorno.iFiltroQuestoes);
        } else {
            alert(oRetorno.sMensagem.urlDecode());
        }

    }


    function getItensMarcados() {

        return aItens().filter(function (item) {
        return item.checked;
        });

    }


    function js_imprimir() {
        
        var sUrl    = 'cin2_rellancamverifaudit002.php';
        var sQuery  =  '?iCodProc='+document.form1.iCodProc.value;
        sQuery      += '&iFiltroQuestoes='+document.form1.iFiltroQuestoes.value;

        jan = window.open(sUrl+sQuery,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0');

        jan.moveTo(0,0);
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