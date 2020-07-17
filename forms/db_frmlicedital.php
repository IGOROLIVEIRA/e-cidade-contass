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
  #obras, #origem_recurso{
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
                  <? if(!in_array($tipo_tribunal, array(100, 101, 102, 103, 106))): ?>
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
                  <?endif;?>
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
                      <td nowrap title="Origem do recurso">
                          <b>Origem do recurso:</b>
                      </td>
                      <td>
						  <?
						  $arr_tipo = array("0"=>"Selecione","1"=>"1- Próprio","2"=>"2- Estadual","3"=>"3- Federal","4"=>"4- Próprio e Estadual", "5"=> "5- Próprio e Federal", "9"=> "9- Outros");
						  db_select("origem_recurso",$arr_tipo,true,1);
						  ?>
                      </td>
                  </tr>
                  <tr id="tr_desc_recurso">
                      <td class="label-textarea" nowrap title="Descrição do recurso">
                          <b>Descrição do Recurso:</b>
                      </td>
                      <td>
						  <?
						  db_textarea('descricao_recurso',4,56,'',true,'text',1,"", '', '', 150);
						  ?>
                      </td>
                  </tr>
               <tr>
                  <td class="label-textarea" nowrap title="Links da publicação">
                    <b>Links da publicação:</b>
                  </td>
                  <td>
                    <?
                    db_textarea('links',4,56,'',true,'text',1, '', '', '', 200);
                    ?>
                  </td>
                </tr>

                  <tr id="td_obras" style="display: <?= $natureza_objeto == 1 || $natureza_objeto == 7 ? '' : 'none' ?>;">
                    <td colspan="3">
                      <fieldset>
                        <legend>Obras e Serviços</legend>
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
                              <input type="button" value="Lançar" id="btnLancarDados" onclick="js_lancaDadosObra();"/>
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
                  <?php if(!$dataenviosicom): ?>
                  <td nowrap title="Data de Envio">
                    <b>Data de Envio:</b>
                  </td>
                  <td>
                    <?= db_inputdata("data_referencia", '', '', '',true,'text',1);?>
                  </td>
                  <?php else:?>
                  <td nowrap title="Data de Reenvio">
                      <b>Data de Reenvio:</b>
                  </td>
                  <td>
                      <?= db_inputdata("data_reenvio", '', '', '',true,'text',1);?>
                  </td>
                  <?php endif;?>
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
  <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa(<?= $dataenviosicom ?>);" >
</form>

<script>
    let iSequencial = '<?= $sequencial; ?>';
    let codigoLicitacao = "<?= $codigolicitacao;?>";
    let origem_rec = "<?= $origem_recurso?>";

    function js_mostraDescricao(valor){
        if(valor != 9){
            document.getElementById('tr_desc_recurso').style.display = 'none';
        }else document.getElementById('tr_desc_recurso').style.display = '';
    }

    js_mostraDescricao(origem_rec);

    document.getElementById('origem_recurso').addEventListener('change', (e)=> {
        js_mostraDescricao(e.target.value);
    });

    function js_pesquisa(dataenviosicom=false){
        if(!dataenviosicom){
            js_OpenJanelaIframe('','db_iframe_liclicita','func_edital.php?aguardando_envio=true&funcao_js=parent.js_preenchepesquisa|l20_nroedital|l20_codigo|Status','Pesquisa',true,"0");
        }
        // else{
        //     js_OpenJanelaIframe('','db_iframe_liclicita','func_edital.php?dataenviosicom=true&funcao_js=parent.js_preenchepesquisa|l20_nroedital|l20_codigo|Status','Pesquisa',true,"0");
        // }
    }
    function js_preenchepesquisa(nroedital, codigo, status){
        if(status.trim() != 'AGUARDANDO ENVIO' && status.trim() != 'AGUARDANDO REENVIO'){
            js_buscaDadosLicitacao(codigo);
            db_iframe_liclicita.hide();
        }
    }

    function js_buscaDadosLicitacao(valor){
        var oParam = new Object();
        oParam.exec = 'findDadosLicitacao';
        oParam.iCodigoLicitacao = parseInt(valor);
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

        switch (dadoslicitacao.l20_cadinicial) {
            case '1':
                document.location.href="lic4_editalinclusao.php?licitacao="+dadoslicitacao.l20_codigo;
                break;
            case '2':
                document.location.href="lic4_editalalteracao.php?licitacao="+dadoslicitacao.l20_codigo;
                break;
            case '3':
            case '4':
                document.location.href="lic4_editalretificacao001.php?licitacao="+dadoslicitacao.l20_codigo+"&dataenviosicom=true";
                break;
        }
    }

    function js_salvarEdital(){
        let descricao = document.getElementById('descricao_recurso').value;
        let origem_recurso = document.getElementById('origem_recurso').value;

    }

    function js_exibeDadosCompl(idObra = null, incluir = true){
        oDadosComplementares = new DBViewCadDadosComplementares('pri', 'oDadosComplementares', '', incluir, codigoLicitacao);
        oDadosComplementares.setObjetoRetorno($('idObra'));
        oDadosComplementares.setLicitacao(codigoLicitacao);
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
        oEndereco.licitacao = codigoLicitacao;
        // oEndereco.sequencial = $F('idObra');
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
            sEndereco += "Sequencial: "+aDados[iInd].sequencial.urlDecode()+", ";
            sEndereco += "Obra: "+aDados[iInd].codigoobra.urlDecode()+", ";
            sEndereco += aDados[iInd].descrmunicipio.urlDecode()+", ";
            sEndereco += aDados[iInd].bairro != '' ? aDados[iInd].bairro.urlDecode() : '';

            $('dados_complementares').value = sEndereco;
        }
    }

    function js_init() {
        oDBGrid              = new DBGrid("gridDocumentos");
        oDBGrid.nameInstance = "oDBGrid";
        oDBGrid.aWidths      = new Array("10%","15%","59%","16%");
        oDBGrid.setCellAlign(new Array("center", "center", "left", "center"));
        oDBGrid.setHeader(new Array("Código", "Sequencial","Descrição", "Opções"));
        oDBGrid.show($('cntDBGrid'));
        oDBGrid.clearAll(true);
    }

    function js_lancaDadosObra(){

        let dadoscomplementares = $('dados_complementares').value;
        let valores = dadoscomplementares.split(',');

        if(dadoscomplementares != ''){
            let linhas = oDBGrid.aRows.length;

            let aLinha = new Array();
            aLinha[0] = linhas+1;
            aLinha[1] = valores[0].split(':')[1].trim();
            valores[0] = '';
            let novosValores = valores.filter( e => {
                let valor = e.trim().replace(',','');
                return valor;
            });

            aLinha[2] = novosValores.join(',');

            aLinha[3] = "<input type='button' value='A' onclick='js_lancaDadosAlt("+'"'+aLinha[1]+'"'+");'>"+
                "<input type='button' value='E' onclick='js_excluiDados("+'"'+aLinha[1]+'"'+");'>";

            oDBGrid.addRow(aLinha);
            oDBGrid.renderRows();
            $('dados_complementares').value = '';
            $('idObra').value = '';
        }else{
            alert('Informe algum endereço');
        }

    }

    js_init();

    function js_buscaDadosComplementares() {
        oDBGrid.clearAll(true);
        var sUrlRpc = "con4_endereco.RPC.php";
        let oParam = new Object();
        oParam.exec = 'findDadosObraLicitacao';
        oParam.codLicitacao = codigoLicitacao;

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
            let descMunicipio = unescape(dado.descrmunicipio).replace(/\+/g, ' ');
            let linhas = oDBGrid.aRows.length;
            let descricaoLinha = `Obra: ${dado.codigoobra},`;
            descricaoLinha += `${descMunicipio},`;
            descricaoLinha += dado.bairro ? ` ${dado.bairro.replace(/\+/g, ' ')}` : '';

            let aLinha = new Array();
            aLinha[0] = linhas+1;
            aLinha[1] = dado.sequencial;
            aLinha[2] = descricaoLinha;
            aLinha[3] = "<input type='button' value='A' onclick='js_lancaDadosAlt("+'"'+aLinha[1]+'"'+");'>"+
                "<input type='button' value='E' onclick='js_excluiDados("+'"'+aLinha[1]+'"'+");'>";
            oDBGrid.addRow(aLinha);
        });
        oDBGrid.renderRows();
        $('dados_complementares').value = '';
        $('idObra').value = '';
    }

    function js_lancaDadosAlt(valor){
        $('idObra').value = valor;
        js_exibeDadosCompl(valor, false);
    }

    function js_excluiDados(valor){
        let resposta = window.confirm('Deseja excluir o endereço do código da obra '+valor+'?');

        if(resposta){
            var sUrlRpc = "con4_endereco.RPC.php";
            let oParam = new Object();
            oParam.exec = 'excluiDadosObra';
            oParam.sequencial = valor;
            oParam.licitacao = codigoLicitacao;

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
        let obra = JSON.parse(oAjax.request.parameters.json);
        let resposta = eval("("+oAjax.responseText+")");

        alert(resposta.message.urlDecode());

        if(resposta.status == 1){
            for(let cont = 0; cont < oDBGrid.aRows.length; cont++){
                let codigoobra = oDBGrid.aRows[cont].aCells[1].content;

                if(codigoobra == obra.sequencial){
                    let valores = [];
                    valores.push(cont);
                    oDBGrid.removeRow(valores);
                }
            }
            oDBGrid.renderRows();
        }

    }

    let elemento = document.getElementById('links');
    elemento.addEventListener('keyup', (e) => {
        let valor = e.target.value;

        if(valor.includes(';')){
            document.getElementById('links').value = valor.replace(/;/g, ',');
            alert('Caractere ponto e vírugla não é permitido e será substituído por vírgula.');
        }
    });
</script>
