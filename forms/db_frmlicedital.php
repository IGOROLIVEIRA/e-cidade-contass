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
$db_opcao = 1;
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
                  <td nowrap title="<?=@$Tl20_nroedital?>">
                    <b>Edital:</b>
                  </td>
                  <td>
                    <?
                    db_input('l20_nroedital',10,$Il20_nroedital,true,'text',3,"");
                    db_input('l20_codigo',10,$Il20_codigo,true,'hidden',3);
                    ?>
                  </td>
                </tr>
                <tr>
                  <td nowrap>
                    <b>Processo:</b>
                  </td>
                  <td>
                    <?
                    db_input('l20_edital',10,$Il20_edital,true,'text',3,"onchange='';");
                    db_input('l20_objeto',45,$Il20_objeto,true,'text',3,"");
                    ?>
                  </td>
                </tr>
                <tr>
                  <td>
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
                  <td class="label-textarea" nowrap title="Links da publicação">
                    <b>Links da publicação:</b>
                  </td>
                  <td>
                    <?
                    db_textarea('links',4,56,'',true,'text',1, '', '', '', 200);
                    ?>
                  </td>
                </tr>
                <tr>
                  <td nowrap title="Links da publicação">
                    <b>Origem do recurso:</b>
                  </td>
                  <td>
                    <?
                    $arr_tipo = array("0"=>"Selecione","1"=>"1- Próprio","2"=>"2- Estadual","3"=>"3- Federal","4"=>"4- Próprio e Estadual", "5"=> "5- Próprio e Federal", "9"=> "9- Outros");
                    db_select("origem_recurso",$arr_tipo,true,1);
                    ?>
                  </td>
                </tr>
                <tr>
                  <td class="label-textarea" nowrap title="Descrição do recurso">
                    <b>Descrição do Recurso:</b>
                  </td>
                  <td>
                    <?
                    db_textarea('descricao_recurso',4,56,'',true,'text',1,"", '', '', 150);
                    ?>
                  </td>
                </tr>
                <?php if($natureza_objeto): ?>
                  <tr>
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
                              db_input('dados_complementares', 45,$Il20_edital,true,'text',3,"onchange='';");
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
                <?php endif; ?>
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
    if(!document.getElementById('l20_edital').value){
        js_pesquisa();
    }
    function js_pesquisa(){
        js_OpenJanelaIframe('','db_iframe_liclicita','func_liclicita.php?edital=1&aguardando_envio=1&funcao_js=parent.js_preenchepesquisa|l20_codigo|l20_edital|pc50_descr|dl_Data_Referencia|l20_objeto|pc50_pctipocompratribunal','Pesquisa',true,"0");
    }
    function js_preenchepesquisa(codigo, edital, descricao, data, objeto, tipo){

        let dataFormatada = js_formatar(data, 'd');
        document.getElementById('l20_codigo').value = codigo;
        document.getElementById('l20_edital').value = edital;
        document.getElementById('descr_tribunal').value = descricao;
        document.getElementById('data_referencia').value = dataFormatada;
        document.getElementById('l20_objeto').value = objeto;
        document.getElementById('tipo_tribunal').value = tipo;

        db_iframe_liclicita.hide();
    }

    function js_salvarEdital(){
        let descricao = document.getElementById('descricao_recurso').value;
        let origem_recurso = document.getElementById('origem_recurso').value;

        if(origem_recurso == 9 && !descricao){
            alert('Campo descrição da origem do recurso é obrigatório!');
            return false;
        }

        if(origem_recurso == 0){
            alert('Campo Origem do Recurso é obrigatório!');
            return false;
        }

        datareferencia = document.getElementById('data_referencia').value;

    }
    //
    // function limpaCampos(){
    // 	document.getElementById('l20_edital').value = '';
    // document.getElementById('l20_numero').value = '';
    // 	document.getElementById('l20_nroedital').value = '';
    // 	document.getElementById('descricao_recurso').value = '';
    // 	document.getElementById('data_referencia').value = '';
    // 	document.getElementById('l20_objeto').value = '';
    // }

    function js_exibeDadosCompl(){
        var idObra = '';
        if ($F('idObra') != ""){
            idObra = $F('idObra');
        }
        oDadosComplementares = new DBViewCadDadosComplementares('pri', 'oDadosComplementares', idObra);
        oDadosComplementares.setObjetoRetorno($('idObra'));
        oDadosComplementares.setLicitacao("<?=$l20_codigo;?>");
        oDadosComplementares.setCallBackFunction(() => {
            if(idObra)
                js_retorno_dadosComplementares();
            else js_lancaDadosCompCallBack();
        });
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
            sEndereco += aDados[iInd].codigoobra.urlDecode();
            sEndereco += ",  "+aDados[iInd].municipio.urlDecode();
            sEndereco += ",  "+aDados[iInd].distrito.urlDecode();

            $('dados_complementares').value = sEndereco;
        }
    }

    function js_init() {
        oDBGrid              = new DBGrid("gridDocumentos");
        oDBGrid.nameInstance = "oDBGrid";
        oDBGrid.aWidths      = new Array("20%","65%","15%");
        oDBGrid.setCellAlign(new Array("center", "left", "center"));
        oDBGrid.setHeader(new Array("Código", "Descrição", "Opções"));
        oDBGrid.show($('cntDBGrid'));
    }

    function js_lancaDadosObra(){

        let dadoscomplementares = $('dados_complementares').value;

        if(dadoscomplementares != ''){
            let linhas = oDBGrid.aRows.length;

            let aLinha = new Array();
            aLinha[0] = linhas+1;
            aLinha[1] = dadoscomplementares;
            aLinha[2] = "<input type='button' value='A' onclick='js_lancaDadosAlt("+'"'+aLinha[1]+'"'+");'>"+
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
    oDBGrid.clearAll(true);

    function js_retorno_dadosComplementares() {
        // js_removeObj("msgBox");
        //
        var oRetorno    = eval("("+oAjax.responseText+")");
        // var aDocumentos = oRetorno.aDocumentos;

        // oDBGrid.clearAll(true);

        // if ( aDocumentos.length > 0 ) {
        //     oDBGrid.setStatus("");

        // aDocumentos.each(function (oDoc) {
        //     var aLinha = new Array();
        //     aLinha[0] = '1';
        //     aLinha[1] = 'Teste';
        //
        //     aLinha[2] = "<input type='button' value='A' onclick='js_lancaDadosAlt("+'1'+");'>"+
        //             "<input type='button' value='E' onclick='js_excluiDados("+aLinha+")'>";
        //
        //
        //     oDBGrid.addRow(aLinha);
        //
        // oDBGrid.renderRows();

        // } else {
        //     oDBGrid.setStatus("Nenhum Registro Encontrado");
        // }

    }

    function js_lancaDadosAlt(valor){
        let valorTratado = valor.split(',');
        $('idObra').value = valorTratado[0];

        js_exibeDadosCompl();
    }

    function js_excluiDados(valor){
        let valorTratado = valor.split(',');
        let resposta = window.confirm('Deseja excluir o endereço do código da obra '+valorTratado[0]+'?');

        if(resposta){
            var sUrlRpc = "con4_endereco.RPC.php";
            let oParam = new Object();
            oParam.exec = 'excluiDadosObra';

            oParam.codObra = valorTratado[0];

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
            if(conteudo[0] == codigoRequisitado.codObra){
                let valores = [];
                valores.push(cont);
                oDBGrid.removeRow(valores);
            }
        }

        oDBGrid.renderRows();

    }


</script>
