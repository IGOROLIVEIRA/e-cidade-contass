<?php

/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
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

$oGet = db_utils::postMemory($_GET);

$clliclicita->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("l20_nroedital");
$clrotulo->label("l20_numero");
$clrotulo->label("l20_codtipocom");
$db_botao = true;

?>
<style type="text/css">
  .fieldsetinterno {
    border:0px;
    border-top:2px groove white;
    margin-top:10px;

  }
  fieldset table tr > td {
    width: 180px;
    white-space: nowrap
  }
  .label-textarea{
    vertical-align: top;
  }
  #tr_inicio_depart table{
    width:100%;
  }
  select#depart{
    width:90%;
  }
  #obras{
    width: 100%;
  }
</style>
<form name="form1" method="post" action="" onsubmit="">
  <center>

    <table align=center style="margin-top:25px;">
      <tr><td>

          <fieldset>
            <legend><strong>Editais</strong></legend>

            <fieldset style="border:0px;">

              <table border="0">
                <tr>
                  <td title="Edital">
                    <b>Edital:</b>
                  </td>
                  <td>
                    <?
                    db_input('numero_edital',10,'',true,'text',3,"");
                    db_input('codigolicitacao',10,'',true,'hidden',3);
                    db_input('naturezaobjeto',10,'',true,'hidden',3);
                    ?>
                  </td>
                </tr>
                <tr>
                  <td nowrap title="Processo">
                    <b>Processo:</b>
                  </td>
                  <td>
                    <?
                    db_input('edital',10,'',true,'text',3,"onchange='';");
                    db_input('objeto',45,'',true,'text',3,"");
                    ?>
                  </td>
                </tr>
                <tr>
                  <td title="Modalidade">
                    <b>Modalidade:</b>
                  </td>
                  <td>
                    <?
                    db_input('tipo_tribunal',10,'',true,'text',3,"onchange='';");
                    db_input('descr_tribunal',45,'',true,'text',3,"");
                    ?>
                  </td>
                </tr>
               <tr>
                  <td class="label-textarea" nowrap title="Links da publica��o">
                    <b>Links da publica��o:</b>
                  </td>
                  <td>
                    <?
                    db_textarea('links',4,56,'',true,'text',1, '', '', '', 200);
                    ?>
                  </td>
                </tr>
                <tr>
                  <td nowrap title="Origem do recurso">
                    <b>Origem do recurso:</b>
                  </td>
                  <td>
                    <?
                    $arr_tipo = array("0"=>"Selecione","1"=>"1- Pr�prio","2"=>"2- Estadual","3"=>"3- Federal","4"=>"4- Pr�prio e Estadual", "5"=> "5- Pr�prio e Federal", "9"=> "9- Outros");
                    db_select("origem_recurso",$arr_tipo,true,1);
                    ?>
                  </td>
                </tr>
                <tr>
                  <td class="label-textarea" nowrap title="Descri��o do recurso">
                    <b>Descri��o do Recurso:</b>
                  </td>
                  <td>
                    <?
                    db_textarea('descricao_recurso',4,56,'',true,'text',1,"", '', '', 150);
                    ?>
                  </td>
                </tr>
                  <tr id="td_obras" style="display: <?= $natureza_objeto == 1 ? '' : 'none' ?>;">
                    <td colspan="3">
                      <fieldset>
                        <legend>Obras e Servi�os</legend>
                        <table id="obras">
                          <tr>
                            <td>
                              <?
                              db_ancora('Dados Complementares:', 'js_exibeDadosCompl();', 1, '', '');
                              ?>
                            </td>
                            <td>
                              <?php
                              db_input('dados_complementares', 45,'',true,'text',3,"onchange='';");
                              db_input ('idObra', 10, '', true, 'hidden', $db_opcao);
                              ?>
                              <input type="button" value="Lan�ar" id="btnLancarDados" onclick="js_lancaDadosObra();"/>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="3">
                              <div id="cntDBGrid">
                              </div>
                            </td>
                          </tr>
                        </table>
                      </fieldset>
                    </td>
                  </tr>
                <tr>
                  <td nowrap title="Data de Envio">
                    <b>Data de envio:</b>
                  </td>
                  <td>
                    <?= db_inputdata("data_referencia", '', '', '',true,'text',1);?>
                  </td>
                </tr>
              </table>
            </fieldset>
          </fieldset>
        </td>
      </tr>
    </table>
  </center>
  <input name="<?=($db_opcao==1?'incluir':($db_opcao==2||$db_opcao==22?'alterar':'excluir'))?>" type="submit" id="db_opcao"
         value="<?=($db_opcao==1?'Incluir':($db_opcao==2||$db_opcao==22?'Alterar':'Excluir'))?>"
    <?=($db_botao==false?'disabled':'') ?>  onClick="js_salvarEdital();">
  <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>

<script>
    let iSequencial = '';

    function js_pesquisa(){
        js_OpenJanelaIframe('','db_iframe_liclicita','func_liclicita.php?edital=1&funcao_js=parent.js_preenchepesquisa|l20_nroedital|l20_codigo','Pesquisa',true,"0");
    }
    function js_preenchepesquisa(nroedital, codigo){
        js_buscaDadosLicitacao(nroedital);
        db_iframe_liclicita.hide();
    }

    function js_buscaDadosLicitacao(valor){
        var oParam = new Object();
        oParam.exec = 'findDadosLicitacao';
        oParam.iCodigoEdital = valor;
        var oAjax = new Ajax.Request(
            'lic4_licitacao.RPC.php',
            { parameters: 'json='+Object.toJSON(oParam),
                method: 'post',
                onComplete : js_retornoDadosLicitacao
            }

        );
    }

    function js_retornoDadosLicitacao(oAjax){
        var oRetorno = eval('('+oAjax.responseText+')');
        let dadoslicitacao = oRetorno.dadosLicitacao;

        if(dadoslicitacao.l20_cadinicial == '1'){
            document.location.href="lic4_editalinclusao.php?numero_edital="+dadoslicitacao.l20_nroedital;
            return;
        }else{
            document.location.href="lic4_editalalteracao.php?numero_edital="+dadoslicitacao.l20_nroedital;
            return;
        }

        if(dadoslicitacao.l20_naturezaobjeto == 1){
            document.getElementById('td_obras').style.display = '';
        }else{
            document.getElementById('td_obras').style.display = 'none';
        }
    }

    function js_salvarEdital(){
        let descricao = document.getElementById('descricao_recurso').value;
        let origem_recurso = document.getElementById('origem_recurso').value;

    }

    function js_exibeDadosCompl(idObra = null){
        oDadosComplementares = new DBViewCadDadosComplementares('pri', 'oDadosComplementares', '');
        oDadosComplementares.setObjetoRetorno($('idObra'));
        oDadosComplementares.setLicitacao($('codigolicitacao').value);
        if(idObra){
            oDadosComplementares.preencheCampos(idObra);
        }else{
          oDadosComplementares.setCallBackFunction(() => {
              js_lancaDadosCompCallBack();
          });
        }
        oDadosComplementares.show();
    }

    function js_lancaDadosCompCallBack(){
        var oEndereco = new Object();
        oEndereco.exec = 'findDadosObra';
        oEndereco.iCodigoObra = $F('idObra');
        js_AjaxCgm(oEndereco, js_retornoDadosObra);

        function js_retornoDadosObra(oAjax) {
            js_removeObj('msgBox');
            var oRetorno = eval('('+oAjax.responseText+')');

            var sExpReg  = new RegExp('\\\\n','g');

            if (oRetorno.dadoscomplementares == false) {

                var strMessageUsuario = "Falha ao ler os dados complementares cadastrado! ";
                js_messageBox(strMessageUsuario,'');
                return false;
            } else {
                js_PreencheObra(oRetorno.dadoscomplementares);
            }
        }
    }

    function js_AjaxCgm(oSend,jsRetorno) {
        var msgDiv = "Aguarde ...";
        js_divCarregando(msgDiv,'msgBox');

        var sUrlRpc = "con4_endereco.RPC.php";

        var oAjax = new Ajax.Request(
            sUrlRpc,
            { parameters: 'json='+Object.toJSON(oSend),
                method: 'post',
                onComplete : jsRetorno
            }

        );
    }

    function js_PreencheObra(aDados) {
        var iNumDados = aDados.length;
        for (var iInd=0; iInd < iNumDados; iInd++) {
            let sEndereco = "";
            sEndereco += "Obra: "+aDados[iInd].codigoobra.urlDecode();
            sEndereco += ", Distrito: "+aDados[iInd].distrito.urlDecode();
            sEndereco += ", Bairro: "+aDados[iInd].bairro.urlDecode();

            $('dados_complementares').value = sEndereco;
        }
    }

    function js_init() {
        oDBGrid              = new DBGrid("gridDocumentos");
        oDBGrid.nameInstance = "oDBGrid";
        oDBGrid.aWidths      = new Array("20%","65%","15%");
        oDBGrid.setCellAlign(new Array("center", "left", "center"));
        oDBGrid.setHeader(new Array("C�digo", "Descri��o", "Op��es"));
        oDBGrid.show($('cntDBGrid'));
        oDBGrid.clearAll(true);
    }

    function js_lancaDadosObra(){

        let dadoscomplementares = $('dados_complementares').value;

        if(dadoscomplementares != ''){
            let linhas = oDBGrid.aRows.length;

            let aLinha = new Array();
            aLinha[0] = linhas+1;
            aLinha[1] = dadoscomplementares;
            let valores = dadoscomplementares.split(',');
            let dadosObra = valores[0].split(':');

            aLinha[2] = "<input type='button' value='A' onclick='js_lancaDadosAlt("+'"'+dadosObra[1].trim()+'"'+");'>"+
                "<input type='button' value='E' onclick='js_excluiDados("+'"'+dadosObra[1].trim()+'"'+");'>";

            oDBGrid.addRow(aLinha);
            oDBGrid.renderRows();
            $('dados_complementares').value = '';
            $('idObra').value = '';
        }else{
            alert('Informe algum endere�o');
        }
    }

    js_init();


    function js_buscaDadosComplementares() {
        var sUrlRpc = "con4_endereco.RPC.php";
        let oParam = new Object();
        oParam.exec = 'findDadosObraEdital';
        oParam.codLicitacao = $('codigolicitacao').value;

        var oAjax = new Ajax.Request(
            sUrlRpc,
            { parameters: 'json='+Object.toJSON(oParam),
                asynchronous:false,
                method: 'post',
                onComplete : js_retornoDados
            }
        );
    }

    function js_retornoDados(oAjax){
        var oRetorno    = eval("("+oAjax.responseText+")");
        oRetorno.dadoscomplementares.forEach((dado) => {
            let linhas = oDBGrid.aRows.length;
            let descricaoLinha = `Obra: ${dado.codigoobra}, Distrito: ${dado.distrito}, Bairro: ${dado.bairro}`;
            let aLinha = new Array();
            aLinha[0] = linhas+1;
            aLinha[1] = descricaoLinha;
            aLinha[2] = "<input type='button' value='A' onclick='js_lancaDadosAlt("+'"'+dado.codigoobra+'"'+");'>"+
                "<input type='button' value='E' onclick='js_excluiDados("+'"'+dado.codigoobra+'"'+");'>";

            oDBGrid.addRow(aLinha);
        });
        oDBGrid.renderRows();
        $('dados_complementares').value = '';
        $('idObra').value = '';
    }

    function js_lancaDadosAlt(valor){
        $('idObra').value = valor;
        js_exibeDadosCompl(valor);
    }

    function js_excluiDados(valor){
        let resposta = window.confirm('Deseja excluir o endere�o do c�digo da obra '+valor+'?');

        if(resposta){
            var sUrlRpc = "con4_endereco.RPC.php";
            let oParam = new Object();
            oParam.exec = 'excluiDadosObra';
            oParam.codObra = valor;

            var oAjax = new Ajax.Request(
                sUrlRpc,
                { parameters: 'json='+Object.toJSON(oParam),
                    method: 'post',
                    onComplete : js_retornoExclusao
                }
            );
        }
    }

    function js_retornoExclusao(oAjax){
        let codigoRequisitado = JSON.parse(oAjax.request.parameters.json);
        let resposta = eval("("+oAjax.responseText+")");

        alert(resposta.message);

        for(let cont = 0; cont < oDBGrid.aRows.length; cont++){
            let conteudo = oDBGrid.aRows[cont].aCells[1].content.split(',');
            let obra = conteudo[0].split(':');
            let codigoObra = obra[1].trim();

            if(codigoObra == codigoRequisitado.codObra){
                let valores = [];
                valores.push(cont);
                oDBGrid.removeRow(valores);
            }
        }

        oDBGrid.renderRows();

    }


</script>
