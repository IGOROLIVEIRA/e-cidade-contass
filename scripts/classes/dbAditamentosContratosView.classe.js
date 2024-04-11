function dbViewAditamentoContrato(iTipoAditamento, sNomeInstance, oNode, Assinatura) {

  var me = this,
      aItensPosicao = new Array();


  this.lLiberaDotacoes = true;
  this.lLiberaNovosItens = true;
  this.sLabelBotao = '';
  this.lDatas = false;
  this.lBloqueiaItem = false;
  this.lObrigaDescricao = false;
  this.lTipoAlteracao = false;
  this.lProvidencia = false;
  this.lReajuste = false;
  this.totalizador = false;


  switch (iTipoAditamento) {

      case 2:

          this.lLiberaDotacoes = true;
          this.lDatas = false;
          this.lLiberaNovosItens = false;
          this.sLabelBotao = "Reequilí­brio";
          this.lBloqueiaItem = false;
          this.lObrigaDescricao = false;
          this.lTipoAlteracao = false;
          this.lReajuste = false;
          break;

      case 4:

          this.lLiberaDotacoes = true;
          this.lDatas = false;
          this.lLiberaNovosItens = false;
          this.sLabelBotao = "Aditamento";
          this.lBloqueiaItem = false;
          this.lObrigaDescricao = false;
          this.lTipoAlteracao = false;
          this.lReajuste = false;
          break;

      case 5:

          this.lLiberaDotacoes = true;
          this.lDatas = true;
          this.lLiberaNovosItens = false;
          this.sLabelBotao = "Renovação";
          this.lBloqueiaItem = false;
          this.lObrigaDescricao = false;
          this.lTipoAlteracao = false;
          this.lReajuste = false;
          break;

      case 6:

          this.lLiberaDotacoes = false;
          this.lDatas = true;
          this.lLiberaNovosItens = false;
          this.sLabelBotao = "Prazo";
          this.lBloqueiaItem = true;
          this.lObrigaDescricao = false;
          this.lTipoAlteracao = false;
          this.lReajuste = false;
          break;

      case 7:
          this.lLiberaDotacoes = true;
          this.lDatas = true;
          this.lLiberaNovosItens = false;
          this.sLabelBotao = "Aditamento";
          this.lBloqueiaItem = false;
          this.lObrigaDescricao = true;
          this.lTipoAlteracao = true;
          this.lReajuste = true;
          break;

      case 8:
          this.lLiberaDotacoes = false;
          this.lDatas = false;
          this.lLiberaNovosItens = false;
          this.sLabelBotao = "Execução";
          this.lBloqueiaItem = false;
          this.lObrigaDescricao = false;
          this.lTipoAlteracao = false;
          this.lReajuste = false;
          break;
  }

  this.aPeriodoItensNovos = new Array()
  this.sInstance = sNomeInstance;
  this.iTipoAditamento = iTipoAditamento;
  this.sUrlRpc = 'con4_contratosaditamentos.RPC.php';

  oNode.style.display = 'none';

  sContent = " <table>";
  sContent += "   <tr>";
  sContent += "     <td> ";
  sContent += "       <fieldset> ";
  sContent += "         <legend>Dados dos Acordo</legend>";
  sContent += "         <table width='100%'> ";

  sContent += "           <tr> ";
  sContent += "             <td nowrap width=\"1%\"> ";
  sContent += "               <label class=\"bold\" for=\"oTxtCodigoAcordo\"> ";
  sContent += "                 <a href='javascript:;' onclick='" + me.sInstance + ".consultaAcordo(); return false;'>Acordo:</a>";
  sContent += "               </label> ";
  sContent += "             </td>";
  sContent += "             <td id=\"ctnCodigoAcordo\"></td>";
  sContent += "           </tr> ";

  if(iTipoAditamento == 7) {
      sContent += "           <tr> ";
      sContent += "             <td nowrap> ";
      sContent += "               <label class=\"bold\" for=\"oCboTipoAditivo\">Tipo do Aditivo:</label>";
      sContent += "             </td>";
      sContent += "             <td id=\"ctnTipoAditivo\"></td>";
      sContent += "           </tr> ";
  }

  sContent += "           <tr> ";
  sContent += "             <td nowrap> ";
  sContent += "               <label class=\"bold\" for=\"oTxtNumeroAditamento\">Número do Aditamento:</label>";
  sContent += "             </td>";
  sContent += "             <td id=\"ctnTxtNumeroAditamento\"></td>";
  sContent += "           </tr> ";

  sContent += "           <tr id='trcriterioreajuste' style='display:none;'> ";
  sContent += "             <td nowrap> ";
  sContent += "               <label class=\"bold\" for=\"oCboCriterioReajuste\">Critério de Reajuste:</label>";
  sContent += "             </td>";
  sContent += "             <td id=\"ctnCriterioReajuste\"></td>";
  sContent += "           </tr> ";

  sContent += "           <tr id='trdopercentual' style='display:none;'> ";

  sContent += "                      <td ><label class=\"bold\" for=\"oPercentualReajuste\">Percent. Reajuste: </td> ";
  sContent += "                      <td id=\"ctnPercentualReajuste\"></td> ";

  sContent += "           </tr> ";

  sContent += "           <tr id='trdoindice' style='display:none;'> ";


  sContent += "                      <td ><label class=\"bold\" for=\"oIndiceReajuste\"> Índice de Reajuste:<label></td> ";
  sContent += "                      <td id=\"ctnIndiceReajuste\"></td> ";

  sContent += "           </tr> ";

  sContent += "           <tr id='trdescricaoindice' style='display:none;'> ";
  sContent += "             <td nowrap> ";
  sContent += "               <label class=\"bold\" for=\"oTxtDescricaoIndice\">Descrição do Índice:</label>";
  sContent += "             </td>";
  sContent += "             <td id=\"ctnDescricaoIndice\"></td>";
  sContent += "           </tr> ";

  sContent += "           <tr id='trdescricaoreajuste' style='display:none;'> ";
  sContent += "             <td nowrap> ";
  sContent += "               <label class=\"bold\" for=\"oTxtDescricaoReajuste\">Descrição do Reajuste:</label>";
  sContent += "             </td>";
  sContent += "             <td id=\"ctnDescricaoReajuste\"></td>";
  sContent += "           </tr> ";

  if(!Assinatura){
      sContent += "           <tr style='display:none;'> ";
  }else{
      sContent += "           <tr> ";
  }
  sContent += "             <td nowrap> ";
  sContent += "               <label class=\"bold\" for=\"oTxtDataAssinatura\">Data de Assinatura:</label>";
  sContent += "             </td>";
  sContent += "             <td id=\"ctnDataAssinatura\"></td>";
  sContent += "           </tr> ";

  if(!Assinatura){
      sContent += "           <tr style='display:none;'> ";
  }else{
      sContent += "           <tr> ";
  }
  sContent += "             <td nowrap> ";
  sContent += "               <label class=\"bold\" for=\"oTxtDataPublicacao\">Data de Publicação:</label>";
  sContent += "             </td>";
  sContent += "             <td id=\"ctnDataPublicacao\"></td>";
  sContent += "           </tr> ";

  sContent += "             <tr id='trdatareferencia' style='display: none;'>"
  sContent += "             <td nowrap > ";
  sContent += "               <label class=\"bold\" for=\"oTxtDataReferencia\">Data de Referência:</label>";
  sContent += "             </td>";
  sContent += "             <td  id=\"ctnDataReferencia\"></td>";
  sContent += "           </tr> ";

  sContent += "           <tr id=\"descricaoaltera\"> ";
  sContent += "             <td nowrap> ";
  sContent += "               <label class=\"bold\" for=\"oTextAreaDescricaoAlteracao\">Descrição da Alteração:</label>";
  sContent += "             </td>";
  sContent += "             <td id=\"ctnDescricaoAlteracao\"></td>";
  sContent += "           </tr> ";

  if(!Assinatura){
      sContent += "           <tr style='display:none;'> ";
  }else{
      sContent += "           <tr> ";
  }
  sContent += "             <td nowrap> ";
  sContent += "               <label class=\"bold\" for=\"oTxtVeiculoDivulgacao\">Veí­culo de Divulgação:</label>";
  sContent += "             </td>";
  sContent += "             <td id=\"ctnVeiculoDivulgacao\"></td>";
  sContent += "           </tr> ";

  sContent += "           <tr> ";
  sContent += "             <td colspan='2'>";
  sContent += "               <fieldset class=\"separator\">";
  sContent += "                 <legend>Vigencia</legend> ";
  sContent += "                 <table border='0'> ";
  sContent += "                    <tr> ";
  sContent += "                      <td><label class=\"bold\" for=\"oTxtDataInicial\">Inicial:</td> ";
  sContent += "                      <td id=\"ctnVigenciaInicial\"></td> ";
  sContent += "                      <td class='datafinal'><label class='bold datafinal' for=\"oTxtDataFinal\">Final:<label></td> ";
  sContent += "                      <td class='datafinal' id=\"ctnVigenciaFinal\"></td> ";
  sContent += "                    </tr> ";
  sContent += "                  </table> ";
  sContent += "               </fieldset> ";
  sContent += "             </td> ";
  sContent += "           </tr> ";

  sContent += "           <tr id=\"justificativa\">";
  sContent += "             <td colspan='2'>";
  sContent += "               <fieldset class=\"separator\">";
  sContent += "                 <legend>Justificativa</legend> ";
  sContent += "                 <table border='0'> ";
  sContent += "                    <tr> ";


  sContent += "    <textarea id='oTxtJustificativa' name='w3review' rows='4' cols='50'></textarea>";

  sContent += "                    </tr> ";
  sContent += "                  </table> ";
  sContent += "               </fieldset> ";
  sContent += "             </td> ";
  sContent += "           </tr>";


  sContent += "           <tr style='display: none'> ";
  sContent += "             <td colspan='2'> ";
  sContent += "               <fieldset class=\"separator\"> ";
  sContent += "                 <legend>Valores</legend> ";
  sContent += "                 <table> ";
  sContent += "                   <tr> ";
  sContent += "                     <td><label class=\"bold\" for=\"oTxtValorOriginal\">Valor Original:</label></td> ";
  sContent += "                     <td id=\"ctnValorOriginal\"></td> ";
  sContent += "                     <td><label class=\"bold\" for=\"oTxtValorAtual\">Valor Atual:</label></td> ";
  sContent += "                     <td id=\"ctnValorAtual\"></td> ";
  sContent += "                   </tr> ";
  sContent += "                 </table> ";
  sContent += "               </fieldset> ";
  sContent += "             </td> ";
  sContent += "           </tr> ";

  sContent += "         </table> ";
  sContent += "       </fieldset> ";
  sContent += "     </td> ";
  sContent += "   </tr> ";
  sContent += "   <tr> ";
  sContent += "     <td> ";
  sContent += "       <fieldset> ";
  sContent += "         <legend>Itens</legend> ";
  sContent += "         <div id='ctnGridItens' style=\"width: 1150px\"></div> ";
  sContent += "       </fieldset> ";
  sContent += "     </td> ";
  sContent += "   </tr> ";
  sContent += " </table> ";
  sContent += " <input type='hidden' value='' id='vigenciaFinalCompara'>";
  sContent += " <input type='button' disabled value='Adicionar Itens' id='btnItens' style='display: none'>";
  sContent += " <input type='button' disabled id='btnAditar' value='Salvar " + me.sLabelBotao + "'> ";
  sContent += " <input type='button' value='Remover Item' id='btnRemoveItem' style='display: none'>";
  sContent += " <input type='button' id='btnPesquisarAcordo' value='Pesquisar Acordo' > ";

  oNode.innerHTML = sContent;
  oNode.style.display = '';

  document.getElementById('btnRemoveItem').addEventListener('click', ()=>{
    me.removeItens()
  })

  /**
   * Pesquisa acordos
   */
  this.pesquisaAcordo = function (lMostrar) {

      if (lMostrar == true) {

          var sUrl = 'func_acordo.php?funcao_js=parent.js_mostraacordo1|ac16_sequencial|ac16_resumoobjeto|ac16_datafim|ac16_licitacao&iTipoFiltro=4&ac16_acordosituacao=4';
          js_OpenJanelaIframe('top.corpo',
              'db_iframe_acordo',
              sUrl,
              'Pesquisa de Acordo',
              true);
              $('oCboTipoAditivo').value = 0;
      } else {

          if (me.oTxtCodigoAcordo.getValue() != '') {

              var sUrl = 'func_acordo.php?descricao=true&pesquisa_chave=' + me.oTxtCodigoAcordo.getValue() +
                  '&funcao_js=parent.js_mostraacordo&iTipoFiltro=4&ac16_acordosituacao=4';

              js_OpenJanelaIframe('top.corpo',
                  'db_iframe_acordo',
                  sUrl,
                  'Pesquisa de Acordo',
                  false);
          } else {
              me.oTxtCodigoAcordo.setValue('');
          }

      }
  }

  this.pesquisaAcordoByCodigo = function (acordo) {
      var sUrl = 'func_acordo.php?descricao=true&pesquisa_chave=' + acordo +
          '&funcao_js=parent.js_mostraacordo&iTipoFiltro=4&ac16_acordosituacao=4';

      js_OpenJanelaIframe('',
          'db_iframe_acordo',
          sUrl,
          'Pesquisa de Acordo',
          false,null,'0','780','430');

  }

  /**
   * Retorno da pesquisa acordos
   */
  js_mostraacordo = function (chave1, chave2, chave3, erro,chave4) {

      if (erro == true) {

          me.oTxtCodigoAcordo.setValue('');
          me.oTxtDescricaoAcordo.setValue('');
          $('oTxtDescricaoAcordo').focus();
      } else {

          var oParam = {
              exec: 'getleilicitacao',
              licitacao: chave4
          }

          new AjaxRequest(me.sUrlRpc, oParam, function (oRetorno, lErro) {
              if(oRetorno.lei==1){
                  $('justificativa').style.display = '';
              }else{
                  $('justificativa').style.display = 'none';
              }

          }).setMessage("Aguarde, pesquisando acordos.")
              .execute();

          me.oTxtCodigoAcordo.setValue(chave1);
          me.oTxtDescricaoAcordo.setValue(chave2);
          me.pesquisarDadosAcordo();
      }
  }

  /**
   * Retorno da pesquisa acordos
   */
  js_mostraacordo1 = function (chave1, chave2) {

      var oParam = {
          exec: 'getleilicitacao',
          licitacao: chave1
      }

      new AjaxRequest(me.sUrlRpc, oParam, function (oRetorno, lErro) {
          if(oRetorno.lei==1){
              $('justificativa').style.display = '';
          }else{
              $('justificativa').style.display = 'none';
          }
      }).setMessage("Aguarde, pesquisando acordos.")
          .execute();

      me.oTxtCodigoAcordo.setValue(chave1);
      me.oTxtDescricaoAcordo.setValue(chave2);

      db_iframe_acordo.hide();
      me.pesquisarDadosAcordo();

    validaAcordoDotacoesAnoOrigem(chave1);
  }

  function validaAcordoDotacoesAnoOrigem(codigoAcordo) {
    let oParametros = {};
    oParametros.anoOrigem = anoOrigem;
    oParametros.anoDestino = anoDestino;
    oParametros.codigoAcordo = codigoAcordo;
    oParametros.somenteConsulta = true;

    new Ajax.Request('ac04_alteradotacoescontratos.RPC.php', {
      method: 'post',
      parameters: 'json=' + Object.toJSON(oParametros),
      start_time: new Date().getTime(),
      onComplete: function(oResponse) {
        const oRetorno = eval("(" + oResponse.responseText + ")");
        let timeout = new Date().getTime() - this.start_time;
        if (oRetorno.materiaisSemDotacoes === true) {
          if (oRetorno.todosItensSemDotacoes === true) {
            setTimeout(function(){
              alert(`Todos os itens deste contrato estão sem dotações para o ano ${anoOrigem}. Acessar a rotina Módulo Contratos > Procedimentos - Acordo - Alteração de Dotação e realizar a alteração para prosseguir com o procedimento.`);
            }, timeout);
          } else {
            setTimeout(function(){
              alert(`Os itens ${oRetorno.itens} estão sem dotações para o ano ${anoOrigem}. Acessar a rotina Módulo Contratos > Procedimentos - Acordo - Alteração de Dotação e realizar a alteração para prosseguir com o procedimento.`);
            }, timeout);
          }
        }
      }
    });
  }

  function js_retornoGetLeilicitacao(oAjax){

  }

  this.consultaAcordo = function () {

      js_OpenJanelaIframe('top.corpo',
          'db_iframe_consultaacordo',
          'con4_consacordos003.php?ac16_sequencial=' + me.oTxtCodigoAcordo.getValue(),
          'Consulta de Acordo',
          true);
  }

  this.pesquisao47_coddot = function (mostra) {

      query = '';
      if (iElementoDotacao != '') {
          query = "elemento=" + iElementoDotacao + "&";
      }

      if (mostra == true) {
          js_OpenJanelaIframe('',
              'db_iframe_orcdotacao',
              'func_permorcdotacao.php?' + query + 'funcao_js=parent.' + me.sInstance + '.mostraorcdotacao1|o58_coddot',
              'Pesquisa de Dotacoes',
              true, 0);

          $('Jandb_iframe_orcdotacao').style.zIndex = '100000000';
      } else {
          js_OpenJanelaIframe('',
              'db_iframe_orcdotacao',
              'func_permorcdotacao.php?' + query + 'pesquisa_chave=' + document.form1.o47_coddot.value +
              '&funcao_js=parent.' + me.sInstance + '.mostraorcdotacao',
              'Pesquisa de Dotacoes',
              false
          );
      }
  }

  this.mostraorcdotacao = function (chave, erro) {

      if (erro) {
          document.form1.o47_coddot.focus();
          document.form1.o47_coddot.value = '';
      }
      me.getSaldoDotacao(chave);
  }

  this.mostraorcdotacao1 = function (chave1) {

      oTxtDotacao.setValue(chave1);
      db_iframe_orcdotacao.hide();
      $('Jandb_iframe_orcdotacao').style.zIndex = '0';
      $('oTxtValorDotacao').focus();
      me.getSaldoDotacao(chave1);
  }

  this.ocultacampos = function () {

      if(me.oCboTipoAditivo.getValue()== 7 || me.oCboTipoAditivo.getValue()== 14){
          $('descricaoaltera').style.display = '';
      }else{
          $('descricaoaltera').style.display = 'none';
      }

  }

  this.exibicaocamposreajuste = function () {

      if(me.oCboTipoAditivo.getValue()== 5 ){
          $('trdopercentual').style.display = '';
          $('trdoindice').style.display = '';
          $('trcriterioreajuste').style.display = '';
          return;
      }

      me.oPercentualReajuste.setValue('');
      $('oIndiceReajuste').options[0].selected = true;
      $('trdopercentual').style.display = 'none';
      $('trdoindice').style.display = 'none';
      $('trcriterioreajuste').style.display = 'none';

  }

  this.pesquisarDadosAcordo = function () {

      if (me.oTxtCodigoAcordo.getValue() == "") {

          alert('Informe um acordo!');
          return false;
      }

      var oParam = {
          exec: 'getItensAditar',
          renovacao: (me.iTipoAditamento == 5),
          iAcordo: me.oTxtCodigoAcordo.getValue()
      }

      if(me.oCboTipoAditivo.getValue()== 8 || me.oCboTipoAditivo.getValue()== 14){
          me.oGridItens.setCellWidth(["5%", "5%", "30%", "7%", "9%", "7%", "9%", "9%", "6%", "6%", "2%", "9%","9%"]);
          me.oGridItens.aHeaders[12].lDisplayed = true;
          me.oGridItens.aHeaders[13].lDisplayed = true;
          me.oGridItens.show($('ctnGridItens'));

      }else{
          me.oGridItens.aHeaders[12].lDisplayed = false;
          me.oGridItens.aHeaders[13].lDisplayed = false;
          me.oGridItens.show($('ctnGridItens'));

      }


      me.oGridItens.clearAll(true);

      document.getElementById("trdatareferencia").style.display = 'none';



      new AjaxRequest(me.sUrlRpc, oParam, function (oRetorno, lErro) {

          if (lErro) {
              return alert(oRetorno.message.urlDecode());
          }

          $('btnAditar').disabled = false;
          $('btnItens').disabled = false;

          me.oTxtValorOriginal.setValue(js_formatar(oRetorno.valores.valororiginal, "f"));
          me.oTxtValorAtual.setValue(js_formatar(oRetorno.valores.valoratual, "f"));

          var aDataInicial = oRetorno.datainicial.split("/");
          var aDataFinal = oRetorno.datafinal.split("/");

          if(oRetorno.vigenciaindeterminada == "t"){
              document.getElementsByClassName('datafinal')[0].style.display = 'none';
              document.getElementsByClassName('datafinal')[1].style.display = 'none';
              document.getElementsByClassName('datafinal')[2].style.display = 'none';
          }

          me.oTxtDataInicial.setData(aDataInicial[0], aDataInicial[1], aDataInicial[2]);
          me.oTxtDataFinal.setData(aDataFinal[0], aDataFinal[1], aDataFinal[2]);
          me.oTxtDataFinalCompara.setData(aDataFinal[0], aDataFinal[1], aDataFinal[2]);
          me.oTxtDataAssinatura.setValue('');
          me.oTxtDataPublicacao.setValue('');
          me.oTxtDataReferencia.setValue('');
          me.oTextAreaDescricaoAlteracao.setValue('');
          me.oTxtVeiculoDivulgacao.setValue('');
          $('oTxtJustificativa').setValue('');
          me.oTxtNumeroAditamento.setValue(oRetorno.seqaditivo);

          aItensPosicao = oRetorno.itens;
          me.preencheItens(aItensPosicao);

          aItensPosicao.each(function (oItem, iLinha) {
              me.salvarInfoDotacoes(iLinha);
          });

      }).setMessage("Aguarde, pesquisando acordos.")
          .execute();


  }
  /**
   * monta a tela principal do aditamento
   */
  this.main = function () {

      me.oTxtCodigoAcordo = new DBTextField('oTxtCodigoAcordo', me.sInstance + '.oTxtCodigoAcordo', '', 10);
      me.oTxtCodigoAcordo.addEvent("onChange", ";" + me.sInstance + ".pesquisaAcordo(false);");
      me.oTxtCodigoAcordo.show($('ctnCodigoAcordo'));
      me.oTxtCodigoAcordo.setReadOnly(true);

      var oTxtNode = document.createTextNode(" ");
      $('ctnCodigoAcordo').appendChild(oTxtNode);

      me.oTxtDescricaoAcordo = new DBTextField('oTxtDescricaoAcordo', me.sInstance + '.oTxtDescricaoAcordo', '', 50);
      me.oTxtDescricaoAcordo.show($('ctnCodigoAcordo'), true);
      me.oTxtDescricaoAcordo.setReadOnly(true);

      /**
       * Numero do aditamento
       */
      me.oTxtNumeroAditamento = new DBTextField('oTxtNumeroAditamento', me.sInstance + '.oTxtNumeroAditamento', '', 10);
      me.oTxtNumeroAditamento.setMaxLength(2);
      me.oTxtNumeroAditamento.addEvent("onInput", "this.value = this.value.replace(/[^0-9\.]/g, '')");
      me.oTxtNumeroAditamento.show($('ctnTxtNumeroAditamento'));

      /**
       * Percentual de Reajuste
       */
      me.oPercentualReajuste = new DBTextField('oPercentualReajuste', me.sInstance + '.oPercentualReajuste', '', 10);
      me.oPercentualReajuste.setMaxLength(6);
      me.oPercentualReajuste.addEvent("onInput", "this.value = this.value.replace(/[^0-9\.]/g, '')");
      me.oPercentualReajuste.show($('ctnPercentualReajuste'));


      /**
       * Data da assinaturao
       */
      me.oTxtDataAssinatura = new DBTextFieldData('oTxtDataAssinatura', me.sInstance + '.oTxtDataAssinatura', '');
      me.oTxtDataAssinatura.show($('ctnDataAssinatura'));



      /**
       * Data da Publicacao
       */
      me.oTxtDataPublicacao = new DBTextFieldData('oTxtDataPublicacao', me.sInstance + '.oTxtDataPublicacao', '');
      me.oTxtDataPublicacao.show($('ctnDataPublicacao'));

      /**
       * Data da referncia
       */
       me.oTxtDataReferencia = new DBTextFieldData('oTxtDataReferencia', me.sInstance + '.oTxtDataReferencia', '');
       me.oTxtDataReferencia.show($('ctnDataReferencia'));

      /**
       * Descricao da Alterao
       */
      me.oTextAreaDescricaoAlteracao = new DBTextField('oTextAreaDescricaoAlteracao', me.sInstance + '.oTextAreaDescricaoAlteracao', '', 63);
      me.oTextAreaDescricaoAlteracao.setReadOnly(true);
      me.oTextAreaDescricaoAlteracao.show($('ctnDescricaoAlteracao'));

      /**
       * Tipo do Aditivo
       */

      if(me.lTipoAlteracao) {
          me.oCboTipoAditivo = new DBComboBox('oCboTipoAditivo', me.sInstance + '.oCboTipoAditivo',null,'455px');
          me.oCboTipoAditivo.addItem('0', 'Selecione');
          me.oCboTipoAditivo.addItem('2', 'Reequilí­brio');
          me.oCboTipoAditivo.addItem('5', 'Reajuste');
          me.oCboTipoAditivo.addItem('7', 'Outros');
          me.oCboTipoAditivo.addItem('6', 'Alteração de Prazo de Vigência');
          me.oCboTipoAditivo.addItem('8', 'Alteração de Prazo de Execução');
          me.oCboTipoAditivo.addItem('9', 'Acréscimo de Item(ns)');
          me.oCboTipoAditivo.addItem('10', 'Decréscimo de Item(ns)');
          me.oCboTipoAditivo.addItem('11', 'Acréscimo e Decréscimo de Item(ns)');
          me.oCboTipoAditivo.addItem('12', 'Alteração de Projeto/Especificação');
          me.oCboTipoAditivo.addItem('13', 'Vigência/Execução');
          me.oCboTipoAditivo.addItem('14', 'Acréscimo/Decréscimo de item(ns) conjugado com outros tipos de termos aditivos');
          me.oCboTipoAditivo.addEvent("onChange", me.sInstance + ".pesquisarDadosAcordo();"+me.sInstance + ".js_changeTipoAditivo();"+me.sInstance + ".ocultacampos();"+me.sInstance + ".exibicaocamposreajuste();");
          me.oCboTipoAditivo.show($('ctnTipoAditivo'));
      }

       /**
       * Tipo de Reajuste
       */

              if(me.lReajuste) {
                  me.oIndiceReajuste = new DBComboBox('oIndiceReajuste', me.sInstance + '.oIndiceReajuste',null,'100px');
                  me.oIndiceReajuste.addItem('0', 'Selecione');
                  me.oIndiceReajuste.addItem('1', 'IPCA');
                  me.oIndiceReajuste.addItem('2', 'INPC');
                  me.oIndiceReajuste.addItem('3', 'INCC');
                  me.oIndiceReajuste.addItem('4', 'IGP-M');
                  me.oIndiceReajuste.addItem('5', 'IGP-DI');
                  me.oIndiceReajuste.addItem('6', 'Outro');
                  me.oIndiceReajuste.addEvent("onChange", me.sInstance + ".js_exibedescricao();");
                  me.oIndiceReajuste.show($('ctnIndiceReajuste'));
              }

      /**
       * Veiculo de Divulgao
       */
      me.oTxtVeiculoDivulgacao = new DBTextField('oTxtVeiculoDivulgacao', me.sInstance + '.oTxtVeiculoDivulgacao', '', 63);
      me.oTxtVeiculoDivulgacao.show($('ctnVeiculoDivulgacao'));

      /**
       * Descricao do Indice
       */
      me.oTxtDescricaoIndice = new DBTextField('oTxtDescricaoIndice', me.sInstance + '.oTxtDescricaoIndice', '', 63);
      me.oTxtDescricaoIndice.show($('ctnDescricaoIndice'));

       /**
       * Descricao do Reajuste
       */
       me.oTxtDescricaoReajuste = new DBTextField('oTxtDescricaoReajuste', me.sInstance + '.oTxtDescricaoReajuste', '', 63);
       me.oTxtDescricaoReajuste.show($('ctnDescricaoReajuste'));

      /**
       * Critério de Reajuste
       */
       me.oCboCriterioReajuste = new DBComboBox('oCboCriterioReajuste', me.sInstance + '.oCboCriterioReajuste',null,'100px');
       me.oCboCriterioReajuste.addItem('1', 'Índice Único');
       me.oCboCriterioReajuste.addItem('2', 'Cesta de Índices');
       me.oCboCriterioReajuste.addItem('3', 'Índice Específico');
       me.oCboCriterioReajuste.addEvent("onChange", me.sInstance + ".js_changeCriterioReajuste();");
       me.oCboCriterioReajuste.show($('ctnCriterioReajuste'));

      /**
       * Justificativa

       me.oTxtJustificativa = new DBTextField('oTxtJustificativa', me.sInstance + '.oTxtJustificativa', '', 81);
       me.oTxtJustificativa.show($('ctnJustificativa'));*/

      /**
       * Vigncia
       */
      me.oTxtDataInicial = new DBTextFieldData('oTxtDataInicial', me.sInstance + '.oTxtDataInicial', '');
      me.oTxtDataInicial.setReadOnly(true);
      me.oTxtDataInicial.show($('ctnVigenciaInicial'));

      me.oTxtDataFinal = new DBTextFieldData('oTxtDataFinal', me.sInstance + '.oTxtDataFinal', '');
      me.oTxtDataFinal.setReadOnly(true);
      me.oTxtDataFinal.show($('ctnVigenciaFinal'));

      me.oTxtDataFinalCompara = new DBTextFieldData('oTxtDataFinalCompara', '.oTxtDataFinalCompara', '');
      me.oTxtDataFinalCompara.show($('vigenciaFinalCompara'));
      //me.oTxtDataFinalCompara.setReadOnly(true);

      if (!me.lDatas) {

          me.oTxtDataFinal.setReadOnly(true);
          me.oTxtDataInicial.setReadOnly(true);
      }

      if (!me.lObrigaDescricao) {
          me.oTextAreaDescricaoAlteracao.setReadOnly(true);
      }

      //me.oTextAreaDescricaoAlteracao.setRequired(true);
      me.oTextAreaDescricaoAlteracao.setMaxLength(250);
      me.oTxtVeiculoDivulgacao.setMaxLength(50);
      me.oTxtDescricaoIndice.setMaxLength(300);
      me.oTxtDescricaoReajuste.setMaxLength(300);
      //me.oTxtJustificativa.setMaxLength(5120);


      /**
       * Valores
       */
      me.oTxtValorOriginal = new DBTextField('oTxtValorOriginal', me.sInstance + '.oTxtValorOriginal', '', 12);
      me.oTxtValorOriginal.setClassName("text-right");
      me.oTxtValorOriginal.show($('ctnValorOriginal'));
      me.oTxtValorOriginal.setReadOnly(true);

      me.oTxtValorAtual = new DBTextField('oTxtValorAtual', me.sInstance + '.oTxtValorAtual', '', 12);
      me.oTxtValorAtual.setClassName("text-right");
      me.oTxtValorAtual.show($('ctnValorAtual'));
      me.oTxtValorAtual.setReadOnly(true);

      /**
       * Itens
       */
      me.oGridItens = new DBGrid('oGridItens');
      me.oGridItens.nameInstance = me.sInstance + '.oGridItens';
      me.oGridItens.setCheckbox(0);
      me.oGridItens.setCellAlign(['center', 'center', "left", "right","right", "right", "center", "right", "center", "center", "center", "center", "center"]);
      me.oGridItens.setCellWidth(["5%", "5%", "28%", "7%", "9%", "7%", "9%", "9%", "6%", "8%", "2%", "9%","9%"]);
      me.oGridItens.setHeader(["Ordem", "Codigo", "Descricao", "Qtd Atual", "Valor Atual", "Qtd Final", "Valor Final", "Valor Total", "Qtd Aditada", "Valor Aditado", "Dotacoes", "Inicio Exec", "Fim Exec","Tipo"]);
      //me.oGridItens.aHeaders[11].lDisplayed = false;
      me.oGridItens.aHeaders[14].lDisplayed = false;
      me.oGridItens.aHeaders[11].lDisplayed = false;
      me.oGridItens.setHeight(300);
      me.oGridItens.hasTotalValue = true;
      me.oGridItens.show($('ctnGridItens'));
      me.oGridItens.hasTotalizador = true;
      this.totalizador = true;

      if(!me.lTipoAlteracao) {
          me.oGridItens.aHeaders[13].lDisplayed = false;
      }


      $('btnAditar').observe('click', me.aditar);
      $('btnPesquisarAcordo').observe('click', function () {
          me.pesquisaAcordo(true);
      });
  }

  /**
   * Controle das dotacoes do item.
   */
  this.ajusteDotacao = function (iLinha, iElemento) {

      let valorItem = me.oGridItens.aRows[iLinha].aCells[1].getValue();

      document.getElementById(`chkoGridItens${valorItem}`).checked = true;

      me.oGridItens.aRows[iLinha].removeClassName('normal');
      me.oGridItens.aRows[iLinha].addClassName('marcado');
      me.oGridItens.aRows[iLinha].isSelected = true;

      iElementoDotacao = iElemento;

      if ($('wndDotacoesItem')) {
          return false;
      }

      oItem = aItensPosicao[iLinha];

      if(oItem.novo) {
          sDisabled = '';
      } else {
          sDisabled = "disabled=\'disabled\'";
      }


      oDadosItem = me.oGridItens.aRows[iLinha];
      windowDotacaoItem = new windowAux('wndDotacoesItem', 'Dotacoes Item', 430, 380);

      var sContent = "<div class=\"subcontainer\">";
      sContent += "<fieldset><legend>Adicionar Dotação</legend>";
      sContent += "  <table>";
      sContent += "   <tr>";
      sContent += "     <td>";
      sContent += "     <a href='#' class='dbancora' style='text-decoration: underline;'";
      sContent += "       onclick='" + me.sInstance + ".pesquisao47_coddot(true);'><b>Dotação:</b></a>";
      sContent += "     </td>";
      sContent += "     <td id='inputdotacao'></td>";
      sContent += "     <td>";
      sContent += "      <b>Saldo Dotação:</b>";
      sContent += "     </td>";
      sContent += "     <td id='inputsaldodotacao'></td>";
      sContent += "   </tr>";
      sContent += "   <tr>";
      sContent += "     <td>";
      sContent += "      <b>Valor:</b>";
      sContent += "     </td>";
      sContent += "     <td id='inputvalordotacao'></td>";
      sContent += "     <td colspan='2'></td>";
      sContent += "    </tr>";
      sContent += "  </table>";
      sContent += "</fieldset>";
      sContent += "  <input type='button' "+sDisabled+" value='Adicionar' id='btnSalvarDotacao'>";
      sContent += "  <fieldset style=\"margin-top: 5px;\">";
      sContent += "    <div id='cntgridDotacoes'></div>";
      sContent += "  </fieldset>";
      sContent += "</div>";

      windowDotacaoItem.setContent(sContent);
      oMessageBoard = new DBMessageBoard('msgboard1',
          'Adicionar Dotacoes',
          'Dotacoes Item ' + oDadosItem.aCells[1].getValue() + ' - ' + oDadosItem.aCells[2].getValue() + " (valor: <b>" +
          oDadosItem.aCells[5].getValue() + "</b>)",
          $('windowwndDotacoesItem_content'));

      windowDotacaoItem.setShutDownFunction(function () {
          windowDotacaoItem.destroy();
      });

      $('btnSalvarDotacao').observe("click", function () {
          me.saveDotacao(iLinha)
      });

      oTxtDotacao = new DBTextField('oTxtDotacao', 'oTxtDotacao', '', 10);
      oTxtDotacao.show($('inputdotacao'));
      oTxtDotacao.setReadOnly(true);

      oTxtSaldoDotacao = new DBTextField('oTxtSaldoDotacao', 'oTxtSaldoDotacao', '', 10);
      oTxtSaldoDotacao.show($('inputsaldodotacao'));
      oTxtSaldoDotacao.setReadOnly(true);

      oTxtValorDotacao = new DBTextField('oTxtValorDotacao', 'oTxtValorDotacao', '0,00', 10);
      oTxtValorDotacao.setClassName("text-right");
      oTxtValorDotacao.addEvent("onFocus", "this.value = js_strToFloat(this.value)");
      oTxtValorDotacao.addEvent("onBlur", "this.value = js_formatar(this.value, 'f', 2)");
      oTxtValorDotacao.addEvent("onInput", "this.value = this.value.replace(/[^0-9\.]/g, '')");
      oTxtValorDotacao.show($('inputvalordotacao'));

      oMessageBoard.show();
      oGridDotacoes = new DBGrid('gridDotacoes');
      oGridDotacoes.nameInstance = 'oGridDotacoes';
      oGridDotacoes.setCellWidth(['20%', '60%', '20%']);
      oGridDotacoes.setHeader(["Dotação", "Valor", "&nbsp;"]);
      oGridDotacoes.setCellAlign(["center", "right", "Center"]);
      oGridDotacoes.setHeight(100);
      oGridDotacoes.hasTotalizador = true;

      windowDotacaoItem.show();

      oGridDotacoes.show($('cntgridDotacoes'));
      oGridDotacoes.clearAll(true);
      me.preencheGridDotacoes(iLinha);
  }

  this.preencheGridDotacoes = function (iLinha) {

      oGridDotacoes.clearAll(true);

      nValorTotal = 0;
      aItensPosicao[iLinha].dotacoes.each(function (oDotacao, iDot) {
          var oValorDotacao = new DBTextField("valordot" + iDot, "valordot" + iDot, js_formatar(oDotacao.valor, "f"));
          oValorDotacao.addStyle("width", "100%");
          oValorDotacao.setClassName("text-right");
          oValorDotacao.addEvent("onFocus", "this.value = js_strToFloat(this.value)");
          oValorDotacao.addEvent("onBlur", "this.value = js_formatar(this.value, 'f', 2)");
          oValorDotacao.addEvent("onInput", "this.value = this.value.replace(/[^0-9\.]/g, ''); " + me.sInstance + ".atualizarItemDotacao(" + iLinha + ", " + iDot + ", this); ");

          var oBotaoRemover = document.createElement("input");
          oBotaoRemover.type = "button";
          oBotaoRemover.id = "btnexcluidotacao" + iDot;
          oBotaoRemover.value = "E";
          oBotaoRemover.setAttribute("onclick", me.sInstance + ".removerDotacao(" + iLinha + ", " + iDot + ")");
          if(!oItem.novo) {
              oBotaoRemover.setAttribute("disabled", "disabled");
          }

          aLinha = new Array();
          aLinha[0] = "<a href='javascript:;' onclick='" + me.sInstance + ".mostraSaldo(" + oDotacao.dotacao + ");'>" + oDotacao.dotacao + "</a>";
          aLinha[1] = oValorDotacao.toInnerHtml();
          aLinha[2] = oBotaoRemover.outerHTML;

          oGridDotacoes.addRow(aLinha);
          nValorTotal += oDotacao.valor;
      });

      $('TotalForCol1').innerHTML = js_formatar(nValorTotal, 'f');

      oGridDotacoes.renderRows();
  }

  /**
   * Atualiza a informação das Dotacoes do item
   */
  this.atualizarItemDotacao = function (iLinha, iDotacao, oValor) {

      var oItem = aItensPosicao[iLinha];

      oItem.dotacoes[iDotacao].valor = oValor.value.getNumber();
      if (oItem.servico && (oItem.controlaquantidade == "f" || oItem.controlaquantidade == "")) {
          oItem.dotacoes[iDotacao].quantidade = 1;
      } else {
          oItem.dotacoes[iDotacao].quantidade = js_round((oValor.value.getNumber()/oItem.novounitario), 2);
      }
      nValorTotal = 0;
      var nQuantTotal = 0;
      oItem.dotacoes.each(function (oDotacao) {
          nValorTotal += oDotacao.valor;
          nQuantTotal += oDotacao.quantidade;
      });

      if (nQuantTotal > oItem.novaquantidade) {
          oItem.dotacoes[iDotacao].quantidade -= (nQuantTotal - oItem.novaquantidade) ;
      }

      $('TotalForCol1').innerHTML = js_formatar(nValorTotal, 'f');
  }

  /**
   * Remove a Dotacao
   */
  this.removerDotacao = function (iLinha, iDotacao) {

      if (confirm("Remover Dotação do item?")) {

          aItensPosicao[iLinha].dotacoes.splice(iDotacao, 1);
          me.preencheGridDotacoes(iLinha);
      }
  }

  this.saveDotacao = function (iLinha) {

      if (oTxtDotacao.getValue() == "") {

          alert("Campo dotação de preenchimento obrigatório.");
          js_pesquisao47_coddot(true);
          return false;
      }

      var nValor = oTxtValorDotacao.getValue().getNumber();
      var nQuantidade = oTxtQuantidade.getValue().getNumber();

      if (nValor == 0) {

          alert('Campo Valor de preenchimento obrigatório.');
          $('oTxtValorDotacao').focus();
          return false;
      }

      var oDotacao = {
          dotacao: oTxtDotacao.getValue(),
          quantidade: nQuantidade,
          valor: nValor,
          valororiginal: nValor
      };

      var lInserir = true;
      aItensPosicao[iLinha].dotacoes.forEach(function (oDotacaoItem) {

          if (oDotacaoItem.dotacao == oDotacao.dotacao) {
              lInserir = false;
              alert("Dotação já incluida para o item.");
          }
      });

      if (!lInserir) {
          return false;
      }

      aItensPosicao[iLinha].dotacoes.push(oDotacao);
      me.preencheGridDotacoes(iLinha);
      $('oTxtDotacao').value = '';
      $('oTxtValorDotacao').value = '';
      $('oTxtSaldoDotacao').value = '';

  }

  this.getSaldoDotacao = function (iDotacao) {

      var oParam = new Object();
      oParam.exec = "getSaldoDotacao";
      oParam.iDotacao = iDotacao;
      js_divCarregando('Aguarde, pesquisando saldo Dotacoes', 'msgBox');
      var oAjax = new Ajax.Request(
          "con4_contratos.RPC.php",
          {
              method: 'post',
              parameters: 'json=' + Object.toJSON(oParam),
              onComplete: me.retornoGetSaldotacao
          }
      );

  }

  this.retornoGetSaldotacao = function (oAjax) {

      js_removeObj('msgBox');
      var oRetorno = eval("(" + oAjax.responseText + ")");
      oTxtSaldoDotacao.setValue(js_formatar(oRetorno.saldofinal, "f"));
  }

  me.mostraSaldo = function (chave) {

      var arq = 'func_saldoorcdotacao.php?o58_coddot=' + chave
      js_OpenJanelaIframe('top.corpo', 'db_iframe_saldos', arq, 'Saldo da Dotação', true);
      $('Jandb_iframe_saldos').style.zIndex = '1500000';
  }

  /**
   * calcula os valores da Dotação conforme o valor modificado pelo usuario
   */
  this.salvarInfoDotacoes = function (iLinha) {

      var oItem = aItensPosicao[iLinha];
      /**
       * Caso for servico e nao controlar quantidade, nao precisa redistribuir dotacoes
       */
      /* Retirado a pedido da OC5304
      if (oItem.servico && (oItem.controlaquantidade == "f" || oItem.controlaquantidade == "")) {
          return;
        }*/

      var nQuantidade = oItem.novaquantidade || oItem.quantidade,
          nUnitario   = oItem.novounitario   || oItem.valorunitario,
          nValorTotal = (+nQuantidade) * (+nUnitario),
          nValorTotalItem = nValorTotal,
          nQuantTotalItem = nQuantidade,
          nValorTotalAnterior = 0;

      /**
       * Soma o valor original total
       */
      aItensPosicao[iLinha].dotacoes.each(function (oDotacao) {
          nValorTotalAnterior += +oDotacao.valororiginal;
      });

      aItensPosicao[iLinha].dotacoes.each(function (oDotacao, iDot) {

          var nPercentual = (nValorTotalAnterior == 0) ? 0 : (new Number(oDotacao.valororiginal) * 100) / nValorTotalAnterior;
          var nValorDotacao = js_round((nValorTotalItem * nPercentual) / 100, 2);
          var nQuantDotacao = js_round((nQuantTotalItem * nPercentual) / 100, 2);

          nValorTotal -= nValorDotacao;
          nQuantidade -= nQuantDotacao;
          if (iDot == aItensPosicao[iLinha].dotacoes.length - 1) {

              if (nValorTotal != nValorTotalItem) {
                  nValorDotacao += nValorTotal;
              }
              if (nQuantidade != nQuantTotalItem) {
                  nQuantDotacao += nQuantidade;
              }
          }

          if (nValorDotacao < 0) {
              nValorDotacao = 0;
          }
          if (nQuantDotacao < 0) {
              nQuantDotacao = 0;
          }

          aItensPosicao[iLinha].dotacoes[iDot].valor = js_round(nValorDotacao, 2);
          aItensPosicao[iLinha].dotacoes[iDot].quantidade = js_round(nQuantDotacao, 2);
      });
  }

  me.show = function (acordo = null) {

      me.main();

      /**
       *
       */
      if(acordo != null && acordo != ''){
          me.pesquisaAcordoByCodigo(acordo);
          me.lProvidencia = true;
      }else{
          me.pesquisaAcordo(true);
      }
  }

  this.aditar = function () {
      var oSelecionados = {};
      var iSelecionados = [];
      /**
       * @todo incluir aqui todas as validaes de campos obrigatrios para o SICOM contratos
       */


      if ($('oCboTipoAditivo').value == 0 && $('oCboTipoAditivo').value != 6) {
          return alert("obrigatório informar o tipo do aditamento.");
      }

      if (me.oTxtNumeroAditamento.getValue() == "") {
          return alert("obrigatório informar o número do aditamento.");
      }

      if ((me.oCboTipoAditivo.getValue() == 7 || me.oCboTipoAditivo.getValue() == 14) && me.oTextAreaDescricaoAlteracao.getValue() == "") {
          return alert("obrigatório informar a descrição da alteração.");
      }

      if (me.oTxtVeiculoDivulgacao.getValue() == "" && Assinatura == true) {
          return alert("obrigatório informar o veí­culo de divulgação do aditivo.");
      }

      if ($('oTxtJustificativa').getValue() == "" && Assinatura == true) {
          if($("justificativa").style.display != 'none'){
              return alert("Usuário: Este contrato decorrente de Licitação e está utilizando a lei n 14133/2021, sendo assim, necessário o preenchimento do campo Justificativa.");
          }
      }

      if (me.oTxtDataAssinatura.getValue() == "" && Assinatura == true) {
          return alert("obrigatório informar a data de assinatura do aditivo.");
      }

      if (me.oTxtDataPublicacao.getValue() == "" && Assinatura == true) {
          return alert("obrigatório informar a data de Publicacao do aditivo.");
      }

      if (me.oTxtDataReferencia.getValue() == "" && document.getElementById("trdatareferencia").style.display != 'none') {
          return alert("obrigatório informar a data de Referência.");
      }

      if (me.oTxtDataInicial.getValue() == "") {
        return alert("obrigatrio informar a data de vigencia inicial.");
      }

      if (me.oTxtDataFinal.getValue() == "") {
        return alert("obrigatrio informar a data de vigencia final.");
      }


      if (me.oCboTipoAditivo.getValue() == 5) {
          if(me.oPercentualReajuste.getValue()=="" || me.oPercentualReajuste.getValue()==null){
              return alert("obrigatório informar o Percentual de Reajuste.");
          }
          if(me.oIndiceReajuste.getValue()==0 && me.oCboCriterioReajuste.getValue()==1){
              return alert("obrigatório informar o Indice de Reajuste.");
          }
          if(me.oIndiceReajuste.getValue()==6){
              if(me.oTxtDescricaoReajuste.getValue()==""){
                  return alert("obrigatório informar a Descrição do Reajuste.");
              }
          }

          let criterios = ["2","3"];
          let criterioreajuste = me.oCboCriterioReajuste.getValue();
          let descricaoindice = me.oTxtDescricaoIndice.getValue().trim();

          if(criterios.includes(criterioreajuste) && descricaoindice == ""){
              return alert("obrigatório informar a Descrição do Índice.");
          }
      }

      var dataAssinatura = me.oTxtDataAssinatura.getValue().split("/");
      var dtAssinatura   =  dataAssinatura[2] + "-" + dataAssinatura[1] + "-" + dataAssinatura[0];
      var dataPublicacao = me.oTxtDataPublicacao.getValue().split("/");
      var dtPublicacao   = dataPublicacao[2] + "-" + dataPublicacao[1] + "-" + dataPublicacao[0];

      if(dtAssinatura > dtPublicacao ){
        return alert("Data de Assinatura deve ser menor ou igual a data de Publicação.")
      }

      me.oGridItens.getRows().forEach(function (oRow) {
          if (oRow.isSelected) {
              oSelecionados[oRow.aCells[1].getValue()-1] = oRow;
              iSelecionados.push(oRow.aCells[2].getValue());
          }
      });


      if (Object.keys(oSelecionados).length == 0 && $('oCboTipoAditivo').value != 6 && $('oCboTipoAditivo').value != 7) {
          return alert('Nenhum item selecionado para aditar.');
      }

      var lAditar = true;

      var dt1 = me.oTxtDataFinal.getValue().split("/");
      var dt2 = me.oTxtDataFinalCompara.getValue().split("/");

      var datafim1 = dt1[2] + "-" + dt1[1] + "-" + dt1[0];
      var datafim2 = dt2[2] + "-" + dt2[1] + "-" + dt2[0];

      var vigenciaalterada = 's';

      if (datafim1 == datafim2) {
          vigenciaalterada = 'n';
      }

      if (me.oCboTipoAditivo.getValue() == 6 && datafim1 == datafim2) {
        return alert('Vigencia final deve ser alterada');
      }

      var oParam = {
          exec: "processarAditamento",
          iAcordo: me.oTxtCodigoAcordo.getValue(),
          datainicial: me.oTxtDataInicial.getValue(),
          datafinal: me.oTxtDataFinal.getValue(),
          dataassinatura: me.oTxtDataAssinatura.getValue(),
          datapublicacao: me.oTxtDataPublicacao.getValue(),
          datareferencia: me.oTxtDataReferencia.getValue(),
          descricaoalteracao: me.oTextAreaDescricaoAlteracao.getValue(),
          veiculodivulgacao: me.oTxtVeiculoDivulgacao.getValue(),
          percentualreajuste: me.oPercentualReajuste.getValue(),
          indicereajuste: me.oIndiceReajuste.getValue(),
          descricaoindice:  me.oTxtDescricaoIndice.getValue().replace('"',""),
          descricaoreajuste:  me.oTxtDescricaoReajuste.getValue().replace('"',""),
          criterioreajuste:  me.oCboCriterioReajuste.getValue(),
          justificativa: $('oTxtJustificativa').getValue(),
          tipoaditamento: me.iTipoAditamento,
          sNumeroAditamento: me.oTxtNumeroAditamento.getValue(),
          aItens: [],
          aSelecionados: iSelecionados,
          sVigenciaalterada: vigenciaalterada,
          lProvidencia: me.lProvidencia
      }

      var dti     = me.oTxtDataInicial.getValue().split("/");
      var dataini =  dti[2] + "-" + dti[1] + "-" + dti[0];
      var dtf = me.oTxtDataFinal.getValue().split("/");
      var datafim = dtf[2] + "-" + dtf[1] + "-" + dtf[0];

      if (dataini > datafim) {
          lAditar = false;
          return alert("Data final da vigência do aditivo deve ser maior que a data iní­cio!");
      }

      if(iTipoAditamento == 7){
          oParam.tipoalteracaoaditivo = me.oCboTipoAditivo.getValue();
          if(oParam.tipoalteracaoaditivo == 0){
              lAditar = false;
              return alert("Selecione um tipo de aditivo.");
          }
      }

      aItensPosicao.forEach(function (oItem, iIndice) {
          if (!lAditar) {
              return false;
          }

          var oItemAdicionar = {};

          oItemAdicionar.codigo         = oItem.codigo;
          oItemAdicionar.codigoitem     = oItem.codigoitem;
          oItemAdicionar.resumo         = encodeURIComponent(tagString(oItem.resumo || ''));
          oItemAdicionar.codigoelemento = oItem.codigoelemento || '';
          oItemAdicionar.unidade        = oItem.unidade || '';
          oItemAdicionar.quantidade     = oItem.quantidade;
          oItemAdicionar.valorunitario  = oItem.valorunitario;
          oItemAdicionar.valoraditado   = 0;//OC5304
          oItemAdicionar.quantiaditada  = 0;//OC5304
          oItemAdicionar.qtdeanterior   = oItem.qtdeanterior;
          oItemAdicionar.valor          = oItem.valor;
          oItemAdicionar.dtexecucaoinicio = oItem.periodoini;
          oItemAdicionar.dtexecucaofim = oItem.periodofim;
          oItemAdicionar.controlaServico = oItem.ServicoQuantidade;

          if ($('oCboTipoAditivo').value == 14) {
              var dt1 = me.oTxtDataFinal.getValue().split("/");
              var dt2 = me.oTxtDataFinalCompara.getValue().split("/");
              var datafim1 = dt1[2] + "-" + dt1[1] + "-" + dt1[0];
              var datafim2 = dt2[2] + "-" + dt2[1] + "-" + dt2[0];

              if (datafim1 < datafim2) {
                  lAditar = false;
                  return alert("A nova data final do contrato deve ser maior que a data inserida!");
              }
          }

          if (oSelecionados[iIndice] != undefined) {
              document.getElementById('btnRemoveItem').style.disabled = false;
              oItemAdicionar.quantidade    = oSelecionados[iIndice].aCells[6].getValue().getNumber();
              oItemAdicionar.valorunitario = js_strToFloat(oSelecionados[iIndice].aCells[7].getValue());
              oItemAdicionar.valor = oItemAdicionar.quantidade * oItemAdicionar.valorunitario;
              var nQuantidadeA = js_strToFloat(oSelecionados[iIndice].aCells[4].getValue());
              var nUnitarioA   = js_strToFloat(oSelecionados[iIndice].aCells[5].getValue());
              var valorAditadoReal = oItemAdicionar.valor - (nQuantidadeA * nUnitarioA);
              oItemAdicionar.valoraditado = valorAditadoReal;//OC5304
              oItemAdicionar.quantiaditada = js_strToFloat(oSelecionados[iIndice].aCells[9].getValue());//OC5304
              oItemAdicionar.dtexecucaoinicio = oSelecionados[iIndice].aCells[12].getValue();
              oItemAdicionar.dtexecucaofim = oSelecionados[iIndice].aCells[13].getValue();
              oItemAdicionar.tipoalteracaoitem = oSelecionados[iIndice].aCells[14].getValue();
              oItemAdicionar.servico = oItem.servico;
              oItemAdicionar.controlaServico = oItem.servico;

              if(me.validaItensNaoAditados(oSelecionados[iIndice])){
                  lAditar = false;
                  return alert("Desmarque os itens que não foram aditados!");
              }
              var qtanter = oSelecionados[iIndice].aCells[4].getValue().getNumber();
              var vlranter = oSelecionados[iIndice].aCells[5].getValue().getNumber();

              if ($('oCboTipoAditivo').value == 9
                  && (oItemAdicionar.quantidade < qtanter || oItemAdicionar.valorunitario < vlranter)) {
                  lAditar = false;
                  return alert("Não é possí­vel realizar DECRÉSCIMOS de itens no tipo ACRÉSCIMO de itens!");
              }

              if ($('oCboTipoAditivo').value == 10
                  && (oItemAdicionar.quantidade > qtanter || oItemAdicionar.valorunitario > vlranter)) {
                  lAditar = false;
                  return alert("Não é possí­vel realizar ACREéeeSCIMOS de itens no tipo DECRÉSCIMO de itens!");

              }

              if ($('oCboTipoAditivo').value == 13) {

                  var dtE = oItemAdicionar.dtexecucaofim.split("/");
                  var datafimE = dtE[2] + "-" + dtE[1] + "-" + dtE[0];

                  var dtV = me.oTxtDataFinal.getValue().split("/");
                  var datafimV = dtV[2] + "-" + dtV[1] + "-" + dtV[0];

                  var data_1 = new Date(datafimE);
                  var data_2 = new Date(datafimV);
                  if (data_1 > data_2) {
                      lAditar = false;
                      return alert("Data final da execução de um item não pode ser maior que a data final da vigência do contrato!");
                  }

              }

              if (($('oCboTipoAditivo').value == 9
                  || $('oCboTipoAditivo').value == 10
                  || $('oCboTipoAditivo').value == 11
                  || $('oCboTipoAditivo').value == 14
              ) && valorAditadoReal == 0) {
                  lAditar = false;
                  return alert("Desmarque os itens que não foram aditados!");
              }


              if (iTipoAditamento == 2 && (+oItemAdicionar.quantidade) > (+oItem.quantidade)) {

                  lAditar = false;
                  return alert("A Quantidade informada para o item " + oItem.descricaoitem.urlDecode() + " deve ser menor ou igual a quantidade original do item.");
              }

              /**
               * Validamos o total do item com as dotacoes quando no for aditamento de prazo
               * ou for um servico nao controlado por quantidade
               */
              if (iTipoAditamento != 6 || (oItem.servico && (oItem.controlaquantidade == "f" || oItem.controlaquantidade == ""))) {

                  var nValorDotacao = 0;
                  oItem.dotacoes.forEach(function (oDotacao) {

                      /**
                       * Comentado para permitir dotacao com valor zero conforme solicitado por Danilo
                       */
                      /*if (oDotacao.valor == 0) {

                          lAditar = false;
                          return alert("Os Valores das Dotacoes para o item " + oItem.descricaoitem.urlDecode() + " no podem estar zeradas.");
                        }*/

                      nValorDotacao += oDotacao.valor;
                  });

/*                    if (lAditar && nValorDotacao.toFixed(2) != oItemAdicionar.valor.toFixed(2)) {

                      lAditar = false;
                      return alert("O valor da soma das Dotacoes do item " + oItem.descricaoitem.urlDecode() + " deve ser igual ao Valor Total do item.");
                  }
*/
                  oItemAdicionar.dotacoes = oItem.dotacoes;
              } else {
                  oItemAdicionar.dotacoes = oItem.dotacoesoriginal;
              }

          }

          else {

              if (oItem.novo) {

                  lAditar = false;
                  return alert("Novos itens adicionados devem ser marcados para aditamento.");
              }

              oItemAdicionar.dotacoes = oItem.dotacoesoriginal;
          }

          /**
           * Adiciona os perodos dos itens novos
           */
          oItemAdicionar.aPeriodos = new Array();

    if (oItem.aPeriodos != undefined) {
      oItemAdicionar.aPeriodos = oItem.aPeriodos;
    }

          /**
           * Limpa os valores para aditamento de prazo e renovao quando o item no  selecionado
           */
          if (iTipoAditamento == 6 || (iTipoAditamento == 5 && oSelecionados[iIndice] == undefined)) {

              oItemAdicionar.quantidade = 0;
              oItemAdicionar.valorunitario = 0;
              oItemAdicionar.valor = 0;
          }
          oParam.aItens.push(oItemAdicionar);
      });

      if (!lAditar) {
          return false;
      }

      new AjaxRequest(me.sUrlRpc, oParam, function (oRetorno, lErro) {

          if (lErro) {

              if (oRetorno.datareferencia) {
                  document.getElementById("trdatareferencia").style.display = 'contents';
              }

              return alert(oRetorno.message.urlDecode());
          }
          document.getElementById("trdatareferencia").style.display = 'none';

          alert("Aditamento realizado com sucesso.");
          if(confirm("Deseja Imprimir Relatório do Aditamento ?")){
              acordo = document.getElementById('oTxtCodigoAcordo').value;
              jan = window.open('aco4_aditaoutros002.php?ac16_acordo='+acordo,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
              jan.moveTo(0,0);
          }

          me.pesquisarDadosAcordo()
          $('oCboTipoAditivo').value = 0;
       }).setMessage("Aguarde, aditando contrato.")
          .execute();

      }

  this.validaItensNaoAditados = (oSelecionado) => {
      const tiposAditivo = ['12','13','6','8'];

      return (oSelecionado.aCells[9].getValue().getNumber() == 0
      && oSelecionado.aCells[10].getValue().getNumber() == 0
      && !tiposAditivo.includes($('oCboTipoAditivo').value)
      );
  }

  /**
   * Abre a window de novo Item
   */
  this.novoItem = function () {

      $('btnItens').disabled = true;

      me.aPeriodoItensNovos = new Array();

      windowNovoItem = new windowAux('wndNovoItem', 'Adicionar Novo Item ', 600, 600);

      var sContent = "<div class=\"subcontainer\">";
      sContent += "  <fieldset><legend>Adicionar Itens</legend>";
      sContent += "  <table>";
      sContent += "    <tr>";
      sContent += "      <td>";
      sContent += "        <a href='#' class='dbancora' style='text-decoration: underline;'";
      sContent += "        onclick='" + me.sInstance + ".pesquisaMaterial(true);'><b>Item:</b></a>";
      sContent += "      </td>";
      sContent += "      <td>";
      sContent += "        <span id='ctntxtCodigoMaterial'></span>";
      sContent += "        <span id='ctntxtDescricaoMaterial'></span>";
      sContent += "      </td>";
      sContent += "    </tr>";
      sContent += "    <tr>";
      sContent += "      <td>";
      sContent += "        <b>Quantidade:</b>";
      sContent += "      </td>";
      sContent += "      <td id='ctntxtQuantidade'>";
      sContent += "      </td>";
      sContent += "    </tr>";

      sContent += "    <tr>";
      sContent += "      <td>";
      sContent += "        <b>Valor Unitário:</b>";
      sContent += "      </td>";
      sContent += "      <td id='ctntxtVlrUnitario'>";
      sContent += "      </td>";
      sContent += "    </tr>";
      sContent += "    <tr id='servico-quantidade' style='display:none;'>";
      sContent += "      <td style='width:139px;'>";
      sContent += "         <b>Serviço Controlado por Quantidades:</b>";
      sContent += "      </td>";
      sContent += "      <td id='ctnCboServicoQuantidade'></td>";
      sContent += "    </tr>";

      sContent += "    <tr>";
      sContent += "      <td>";
      sContent += "        <b>Desdobramento:</b>";
      sContent += "      </td>";
      sContent += "      <td id='ctnCboDesdobramento'>";
      sContent += "      </td>";
      sContent += "    </tr>";
      sContent += "    <tr>";
      sContent += "      <td>";
      sContent += "        <b>Unidade:</b>";
      sContent += "      </td>";
      sContent += "      <td id='ctnCboUnidade'></td>";
      sContent += "    </tr>";
      sContent += "    <tr>";
      sContent += "      <td nowrap colspan='2' title='Observações'>";
      sContent += "        <fieldset><legend>Resumo do Item</legend>";
      sContent += "        <textarea rows='5' style='width:100%' id='oTxtResumo'></textarea>";
      sContent += "      </td>";
      sContent += "    </tr>";
      sContent += "    <tr>";
      sContent += "      <td colspan='2'>";
      sContent += "        <fieldset class=\"separator\">";
      sContent += "          <legend>Vigencia</legend>";
      sContent += "          <table>";
      sContent += "            <tr>";
      sContent += "              <td>";
      sContent += "                <b>De:</b>";
      sContent += "              </td>";
      sContent += "              <td id='ctnDataInicialItem' style=''></td>";
      sContent += "              <td>";
      sContent += "                <b>At:</b>";
      sContent += "              </td>";
      sContent += "              <td id='ctnDataFinalItem' align='right' style=''></td>";
      sContent += "              <td id='ctnBtnAdicionaPeriodoItem' align='right' style=''>";
      sContent += "                <input type='button' name='btnAdicionarPeriodoItem' id='btnAdicionarPeriodoItem' value='Adicionar' onclick='" + me.sInstance + ".adicionarPeriodo();' >";
      sContent += "              </td>";
      sContent += "            </tr>";
      sContent += "          </table>";
      sContent += "          <div id='ctnGridPeriodoNovoItem'></div>";
      sContent += "        </fieldset>";
      sContent += "      </td>";
      sContent += "    </tr>";
      sContent += "  </table>";
      sContent += "  </fieldset>";
      sContent += "  <input type='button' value='Salvar' id='btnSalvarItem' onclick='" + me.sInstance + ".adicionarNovoItem()'>";
      sContent += "</div>";

      windowNovoItem.setContent(sContent);
      windowNovoItem.setShutDownFunction(function () {

          $('btnItens').disabled = false;
          windowNovoItem.destroy();
      });

      oMessageBoardItens = new DBMessageBoard('msgboardItens', 'Adicionar Novo Item', "Informe os dados do novo Item.", $('windowwndNovoItem_content'));
      oMessageBoardItens.show();

      /**
       * Grid para os novos itens de um contrato que est sendo aditado.
       */
      oGridPeriodoItemNovo = new DBGrid('ctnGridPeriodoNovoItem');
      oGridPeriodoItemNovo.nameInstance = "oGridPeriodoItemNovo";

      oGridPeriodoItemNovo.setHeader(["Data Inicial", "Data Final", "Ao"]);
      oGridPeriodoItemNovo.setCellWidth(["45%", "45%", "10%"]);
      oGridPeriodoItemNovo.setCellAlign(["center", "center", "center"]);
      oGridPeriodoItemNovo.setHeight(100);
      oGridPeriodoItemNovo.show($('ctnGridPeriodoNovoItem'));
      oGridPeriodoItemNovo.clearAll(true);

      oTxtMaterial = new DBTextField('oTxtMaterial', 'oTxtMaterial', '', 10);
      oTxtMaterial.addEvent("onKeyPress", "return js_mask(event,\"0-9\")");
      oTxtMaterial.addEvent("onChange", ";" + me.sInstance + ".pesquisaMaterial(false); ");
      oTxtMaterial.show($('ctntxtCodigoMaterial'));

      oTxtDataInicialItem = new DBTextFieldData('oTxtDataInicialItem', 'oTxtDataInicialItem', '');
      oTxtDataInicialItem.show($('ctnDataInicialItem'));

      oTxtDataFinalItem = new DBTextFieldData('oTxtDataFinalItem', 'oTxtDataFinalItem', '');
      oTxtDataFinalItem.show($('ctnDataFinalItem'));

      oTxtDescrMaterial = new DBTextField('oTxtDescrMaterial', 'oTxtDescrMaterial', '', 40);
      oTxtDescrMaterial.show($('ctntxtDescricaoMaterial'));
      oTxtDescrMaterial.setReadOnly(true);

      oTxtQuantidade = new DBTextField('oTxtQuantidade', 'oTxtQuantidade', '', 10);
      oTxtQuantidade.addEvent("onFocus", "this.value = js_strToFloat(this.value)");
      oTxtQuantidade.addEvent("onBlur", "this.value = js_formatar(this.value, 'f', 4)");
      oTxtQuantidade.addEvent("onInput", "this.value = this.value.replace(/[^0-9\.]/g, '')");
      oTxtQuantidade.setValue("0,000");
      oTxtQuantidade.setClassName("text-right");
      oTxtQuantidade.show($('ctntxtQuantidade'));

      oTxtVlrUnitario = new DBTextField('oTxtVlrUnitario', 'oTxtVlrUnitario', '', 10);
      oTxtVlrUnitario.addEvent("onFocus", "this.value = js_strToFloat(this.value)");
      oTxtVlrUnitario.addEvent("onBlur", "this.value = js_formatar(this.value, 'f', 4)");
      oTxtVlrUnitario.addEvent("onInput", "this.value = this.value.replace(/[^0-9\.]/g, '')");
      oTxtVlrUnitario.setValue("0,000");
      oTxtVlrUnitario.setClassName("text-right");
      oTxtVlrUnitario.show($('ctntxtVlrUnitario'));


      oCboDesdobramento = new DBComboBox('oCboDesdobramento', 'oCboDesdobramento', new Array("Selecione"));
      oCboDesdobramento.show($('ctnCboDesdobramento'));

      oCboServicoQuantidade = new DBComboBox('oCboServicoQuantidade', 'oCboServicoQuantidade', new Array("No", "Sim"));
      oCboServicoQuantidade.show($('ctnCboServicoQuantidade'));

      oCboUnidade = new DBComboBox('oCboUnidade', 'oCboUnidade', new Array("Selecione"));
      oCboUnidade.show($('ctnCboUnidade'));

      /**
       * Busca as Unidades
       */
      new AjaxRequest(me.sUrlRpc, {exec: "getUnidades"}, function (oRetorno, lErro) {
          $('oCboUnidade').options.length = 1;
          oCboUnidade.aItens = new Array();

          if (!lErro) {
            oRetorno.itens.forEach(item => {
              if(item.m61_descr){
                oCboUnidade.addItem(item.m61_codmatunid, item.m61_descr.urlDecode());
              }
            });
          }

      }).setMessage("Aguarde, pesquisando unidades do material.")
          .execute();

      document.getElementById('oCboServicoQuantidade').addEventListener('change', (element) => {
        if(!Number(element.target.value)){
          oTxtQuantidade.setValue("1,000");
          oTxtQuantidade.setReadOnly(true);
        }else{
          oTxtQuantidade.setValue("0,000");
          oTxtQuantidade.setReadOnly(false);
        }
      })

      windowNovoItem.show();
  }

  /**
   * Adiciona um periodo ao item novo do acordo
   */
  this.adicionarPeriodo = function () {

      var dtDataInicial = oTxtDataInicialItem.getValue();
      var dtDataFinal = oTxtDataFinalItem.getValue();

      if (dtDataInicial == '' || dtDataFinal == '') {

          alert("Informe as datas de vigência do item.");
          return false;
      }

      if (js_comparadata(dtDataInicial, dtDataFinal, ">=") ||
          js_comparadata(dtDataInicial, me.oTxtDataInicial.getValue(), "<") ||
          js_comparadata(dtDataFinal, me.oTxtDataFinal.getValue(), ">")) {

          alert("Há conflito entre as datas informadas.\n\nO Conflito pode estar ocorrendo entre as datas de vigência e/ou entre os perí­odos");
          return false;
      }

      var oPeriodoNovo = {
          dtDataInicial: js_formatar(oTxtDataInicialItem.getValue(), "d"),
          dtDataFinal: js_formatar(oTxtDataFinalItem.getValue(), "d"),
          ac41_sequencial: ''
      };

      me.aPeriodoItensNovos.push(oPeriodoNovo);
      me.loadPeriodoItensNovos();
  }

  /**
   * Exclui o periodo de um item contido na grid: "oGridPeriodoItemNovo"
   */
  this.excluirPeriodoItemNovo = function (iLinha) {

      me.aPeriodoItensNovos.splice(iLinha, 1);
      me.loadPeriodoItensNovos();
  }

  /**
   * Funo que carrega os perodos de um item novo na grid "oGridPeriodoItemNovo"
   */
  this.loadPeriodoItensNovos = function () {

      oGridPeriodoItemNovo.clearAll(true);
      me.aPeriodoItensNovos.each(function (oPeriodo, iLinha) {

          var aLinha = new Array();
          aLinha[0] = js_formatar(oPeriodo.dtDataInicial, 'd');
          aLinha[1] = js_formatar(oPeriodo.dtDataFinal, 'd');
          aLinha[2] = "<input type='button' name='btnExcluiPeriodo' id='btnExcluirPeriodo' value='E' onclick='" + me.sInstance + ".excluirPeriodoItemNovo(" + iLinha + ");' />";
          oGridPeriodoItemNovo.addRow(aLinha);
      });
      oGridPeriodoItemNovo.renderRows();
  }

  this.getElementosMateriais = function (iValorDefault) {

      iValorElemento = '';
      if (iValorDefault != null) {
          iValorElemento = iValorDefault;
      }
      js_divCarregando('Aguarde, pesquisando elementos do material', 'msgBox');
      var oParam = new Object();
      oParam.iMaterial = oTxtMaterial.getValue();
      oParam.exec = "getElementosMateriais";
      var oAjax = new Ajax.Request('con4_contratos.RPC.php', {
          method: 'post',
          parameters: 'json=' + Object.toJSON(oParam),
          onComplete: me.retornoGetElementosMaterias
      });
  }

  this.retornoGetElementosMaterias = function (oAjax) {

      js_removeObj('msgBox');
      $('oCboDesdobramento').options.length = 1;
      oCboDesdobramento.aItens = new Array();
      var oRetorno = eval("(" + oAjax.responseText + ")");
      if (oRetorno.status == 1) {

          oRetorno.itens.each(function (oItem, id) {

              var oParametro = new Object();
              oParametro.nome = "elemento"
              oParametro.valor = oItem.elemento.substr(0, 7);
              oCboDesdobramento.addItem(oItem.codigoelemento, oItem.descricao.urlDecode(), null, new Array(oParametro));
          });
      }
  }

  /**
   * Adiciona o item novo
   */
  this.adicionarNovoItem = function () {

      var iCodigoMaterial = oTxtMaterial.getValue();
      var sResumo = $F('oTxtResumo');
      var nQuantidade = oTxtQuantidade.getValue();
      var nValorUnitario = oTxtVlrUnitario.getValue();
      var iUnidade = oCboUnidade.getValue();
      var iServico = oCboServicoQuantidade.getValue() == 0 ? false : true;
      var iElemento = oCboDesdobramento.getValue();
      var dtDataInicialItem = oTxtDataInicialItem.getValue();
      var dtDataFinalItem = oTxtDataFinalItem.getValue();

      if (iElemento == '0') {

          alert('Campo Desdobramento de preenchimento obrigatório.');
          return false;
      }

      if (iUnidade == '0') {

          alert('Campo Unidade de preenchimento obrigatório.');
          return false;
      }

      var oNovoMaterial = new Object();
      oNovoMaterial.codigo = (Number(aItensPosicao[aItensPosicao.length-1].codigo) + 1).toString();
      oNovoMaterial.codigoitem = oTxtMaterial.getValue();
      oNovoMaterial.descricaoitem = oTxtDescrMaterial.getValue();
      oNovoMaterial.resumo = sResumo;
      oNovoMaterial.unidade = iUnidade;
      oNovoMaterial.codigoelemento = iElemento;
      oNovoMaterial.elemento = $('oCboDesdobramento').options[$('oCboDesdobramento').selectedIndex].getAttribute('elemento');
      oNovoMaterial.quantidade = typeof(nQuantidade) == 'string' ? nQuantidade.replace('.', '').replace(/\,/, '.') : nQuantidade;
      oNovoMaterial.valorunitario = typeof(nValorUnitario) == 'string' ? nValorUnitario.replace('.', '').replace(/\,/, '.') : nValorUnitario;
      oNovoMaterial.qtdeanterior = oNovoMaterial.quantidade;
      oNovoMaterial.vlunitanterior = oNovoMaterial.valorunitario;
      oNovoMaterial.valor = new Number(nQuantidade.getNumber()) * new Number(nValorUnitario.getNumber());
      oNovoMaterial.aPeriodos = me.aPeriodoItensNovos;
      oNovoMaterial.dotacoes = new Array();
      oNovoMaterial.novo = true;
      oNovoMaterial.periodoini = dtDataInicialItem;
      oNovoMaterial.periodofim = dtDataFinalItem;
      oNovoMaterial.servico = iServico;

      let itemCadastrado = false;

      aItensPosicao.forEach((item, index) => {
        if(item.codigoitem == oNovoMaterial.codigoitem){
          itemCadastrado = true;
        }
      })

      if(itemCadastrado){
        alert('Item já está inserido na lista. Verifique.');
        return;
      }

      aItensPosicao.push(oNovoMaterial);
      me.preencheItens(aItensPosicao);

      $('btnItens').disabled = false;
      windowNovoItem.destroy();
      me.ajusteDotacao(aItensPosicao.length - 1, oNovoMaterial.elemento);
  }

  this.preencheItens = function (aItens) {



      var sizeLabelItens = 0;
      if (aItens.length < 12) {
          sizeLabelItens = (aItens.length / 2) * 50;
          sizeLabelItens = sizeLabelItens + "px";
          document.getElementById('body-container-oGridItens').style.height = sizeLabelItens;

      } else {
          document.getElementById('body-container-oGridItens').style.height = "340px";

      }

      me.oGridItens.clearAll(true);

      var aEventsIn  = ["onmouseover"];
      var aEventsOut = ["onmouseout"];
      aDadosHintGrid = new Array();

      aItens.each(function (oItem, iSeq) {
        var aLinha = new Array();
        valor1 = oItem.qtdeanterior.toString();
        valor = valor1.split('.');
          if(valor.length>1){
              casas = valor[1].length;
          }else{
              casas = 2;
          }
        aLinha[0] = parseInt(new String(iSeq)) + 1;
        aLinha[1] = oItem.codigoitem;
        aLinha[2] = oItem.descricaoitem.urlDecode();
        aLinha[3] = js_formatar(oItem.qtdeanterior, 'f', casas);
        aLinha[4] = js_formatar(oItem.vlunitanterior, 'f', 4);

          if (!oItem.novo) {
              if (iTipoAditamento == 2) {
                  oItem.valorunitario = 0;
                  oItem.valor = 0;
              }

              if (iTipoAditamento == 4) {

                  oItem.quantidade = 0;
                  oItem.valorunitario = 0;
                  oItem.valor = 0;
              }

              if (iTipoAditamento == 5 || iTipoAditamento == 6) {
                  oItem.valorunitario = oItem.valor / (oItem.quantidade != 0 ? oItem.quantidade : 1 );
              }
          }

          var nQuantidade  = oItem.novaquantidade   || oItem.quantidade,
              nUnitario    = oItem.novounitario     || oItem.valorunitario;


          oInputQuantidade = new DBTextField('quantidade' + iSeq, 'quantidade' + iSeq, js_formatar(nQuantidade, 'f', 4));
          oInputQuantidade.addStyle("width", "100%");
          oInputQuantidade.setClassName("text-right");
          oInputQuantidade.setReadOnly(iTipoAditamento == 6);

          if (iTipoAditamento != 6) {

              oInputQuantidade.addEvent("onFocus", "this.value = js_strToFloat(this.value);"+me.sInstance+".js_bloqueivalorunt(" + iSeq +","+$('oCboTipoAditivo').value + ")");
              oInputQuantidade.addEvent("onBlur", "this.value = js_formatar(this.value, 'f', 4); ");
              oInputQuantidade.addEvent("onInput", "this.value = this.value.replace(/[^0-9\.]/g, '');" + me.sInstance + ".calculaValorTotal(" + iSeq + ")");
          }



          oInputUnitario = new DBTextField('valorunitario' + iSeq, 'valorunitario' + iSeq, js_formatar(nUnitario, "f", 4)); //
          oInputUnitario.addStyle("width", "100%");
          oInputUnitario.setClassName("text-right");
          oInputUnitario.setReadOnly(iTipoAditamento == 6);

          if (iTipoAditamento != 6) {
              oInputUnitario.addEvent("onFocus", "this.value = js_strToFloat(this.value);"+me.sInstance+".js_bloqueiquantidade("+ iSeq +","+$('oCboTipoAditivo').value +")");
              oInputUnitario.addEvent("onBlur", "this.value = js_formatar(this.value, 'f', 4); ");
              oInputUnitario.addEvent("onInput", "this.value = this.value.replace(/[^0-9\.]/g, ''); " + me.sInstance + ".calculaValorTotal(" + iSeq + ")");
          }

          if(oItem.novo == true){
              aLinha[3] = js_formatar(0, 'f', casas);
              aLinha[4] = js_formatar(0, 'f', 4);
          }

          aLinha[5] = oInputQuantidade.toInnerHtml();
          aLinha[6] = oInputUnitario.toInnerHtml();
          aLinha[7] = js_formatar(nQuantidade * nUnitario, 'f', 2);


          /*OC5304*/
          oInputQtAditada = new DBTextField('quantiaditada' + iSeq, 'quantiaditada' + iSeq, js_formatar(0, 'f', 2));
          oInputQtAditada.addStyle("width", "100%");
          oInputQtAditada.setClassName("text-right");
          oInputQtAditada.setReadOnly(true);
          aLinha[8] = oInputQtAditada.toInnerHtml();

          if(oItem.novo == true){
              aLinha[8] =js_formatar(nQuantidade, 'f', 4);
          }


          oInputAditado = new DBTextField('valoraditado' + iSeq, 'valoraditado' + iSeq, js_formatar(0, 'f', 2));
          oInputAditado.addStyle("width", "100%");
          oInputAditado.setClassName("text-right");
          oInputAditado.setReadOnly(true);
          aLinha[9] = oInputAditado.toInnerHtml();

          /*FIM*/


          var oBotaoDotacao = document.createElement("input");
          oBotaoDotacao.type = "button";
          oBotaoDotacao.id = "dotacoes" + iSeq;
          oBotaoDotacao.value = "Dotacoes";
          oBotaoDotacao.disabled = !me.lLiberaDotacoes;
          oBotaoDotacao.setAttribute("onclick", me.sInstance + ".ajusteDotacao(" + iSeq + ", " + oItem.elemento + ")");


          aLinha[10]  = oBotaoDotacao.outerHTML;


          oInputPeriodoIni = new DBTextFieldData('periodoini' + iSeq, 'periodoini' + iSeq, js_formatar(oItem.periodoini, 'd'));
          oInputPeriodoFim = new DBTextFieldData('periodofim' + iSeq, 'periodofim' + iSeq, js_formatar(oItem.periodofim, 'd'));

          if(iTipoAditamento == 6 || iTipoAditamento == 7){
              aLinha[11] = oInputPeriodoIni.toInnerHtml().replace("size    = '10'","size    = '8'");
              aLinha[12] = oInputPeriodoFim.toInnerHtml().replace("size    = '10'","size    = '8'");
          } else {
              aLinha[11] = js_formatar(oItem.periodoini, 'd');
              aLinha[12] = js_formatar(oItem.periodofim, 'd');
          }

          if(iTipoAditamento == 7) {
              aLinha[13] = new DBComboBox('tipoalteracaoitem' + iSeq, 'tipoalteracaoitem' + iSeq,null,'100%');
              aLinha[13].addItem('0', 'Selecione');
              aLinha[13].addItem('1', 'Acrsc');
              aLinha[13].addItem('2', 'Decrsc');

              /*
               * Condicoes adicionadas para bloquear os campos conforme
               * tipo de Aditivo selecionado na tela
               */

              if ($('oCboTipoAditivo').value == 5 || $('oCboTipoAditivo').value == 2) {
                  oInputQuantidade.setReadOnly(true);
                  //oInputQuantidade.setValue( js_formatar(0, "f", 3));
                  aLinha[5] = oInputQuantidade.toInnerHtml();
                  aLinha[11] = js_formatar(oItem.periodoini, 'd');
                  aLinha[12] = js_formatar(oItem.periodofim, 'd');
                  aLinha[13].setDisable(true);
              } if ($('oCboTipoAditivo').value == 8 || $('oCboTipoAditivo').value == 13 || $('oCboTipoAditivo').value == 6 || $('oCboTipoAditivo').value == 7) {
                  if ($('oCboTipoAditivo').value != 6 && $('oCboTipoAditivo').value != 13 && $('oCboTipoAditivo').value != 8) {
                      oInputQuantidade.setReadOnly(true);
                      oInputUnitario.setReadOnly(true);

                  }
                  if ($('oCboTipoAditivo').value != 7) {
                      if (oItem.servico && (oItem.controlaquantidade == "f" || oItem.controlaquantidade == "")) {
                          oInputUnitario.setReadOnly(false);
                      } else {
                          oInputUnitario.setReadOnly(true);
                      }
                  }
                  aLinha[5] = oInputQuantidade.toInnerHtml();
                  aLinha[6] = oInputUnitario.toInnerHtml();
                  aLinha[13].setDisable(true);
                  if ($('oCboTipoAditivo').value == 6) {
                      aLinha[11] = js_formatar(oItem.periodoini, 'd');
                      aLinha[12] = js_formatar(oItem.periodofim, 'd');
                  }
                  if ($('oCboTipoAditivo').value == 7) {
                      aLinha[11] = js_formatar(oItem.periodoini, 'd');
                      aLinha[12] = js_formatar(oItem.periodofim, 'd');
                  }
              }

              else if ($('oCboTipoAditivo').value == 9) {

                  oInputQuantidade.setValue( js_formatar(0, "f", 4));
                  aLinha[5] = oInputQuantidade.toInnerHtml();

                  if (oItem.servico && (oItem.controlaquantidade == "f" || oItem.controlaquantidade == "")) {
                      oInputUnitario.setReadOnly(false);
                  } else {
                      oInputUnitario.setReadOnly(true);
                  }
                  aLinha[6] = oInputUnitario.toInnerHtml();
                  aLinha[11] = js_formatar(oItem.periodoini, 'd');
                  aLinha[12] = js_formatar(oItem.periodofim, 'd');
                  aLinha[13].setValue(1);
                  aLinha[13].setDisable(true);
              } else if ($('oCboTipoAditivo').value == 10) {

                  oInputQuantidade.setValue( js_formatar(0, "f", 4));
                  aLinha[5] = oInputQuantidade.toInnerHtml();

                  if (oItem.servico && (oItem.controlaquantidade == "f" || oItem.controlaquantidade == "")) {
                      oInputUnitario.setReadOnly(false);
                  } else {
                      oInputUnitario.setReadOnly(true);
                  }
                  aLinha[6] = oInputUnitario.toInnerHtml();
                  aLinha[11] = js_formatar(oItem.periodoini, 'd');
                  aLinha[12] = js_formatar(oItem.periodofim, 'd');
                  aLinha[13].setValue(2);
                  aLinha[13].setDisable(true);
              } else if ($('oCboTipoAditivo').value == 11) {

                  oInputQuantidade.setValue( js_formatar(0, "f", 3));
                  aLinha[5] = oInputQuantidade.toInnerHtml();

                  if (oItem.servico && (oItem.controlaquantidade == "f" || oItem.controlaquantidade == "")) {
                      oInputUnitario.setReadOnly(false);
                  } else {
                      oInputUnitario.setReadOnly(true);
                  }
                  aLinha[6] = oInputUnitario.toInnerHtml();
                  aLinha[11] = js_formatar(oItem.periodoini, 'd');
                  aLinha[12] = js_formatar(oItem.periodofim, 'd');
                  aLinha[13].setValue(0);
                  aLinha[13].setDisable(true);
              } else if ($('oCboTipoAditivo').value == 12) {
                  if(oItem.novo){
                      aLinha[11] = oItem.periodoini;
                      aLinha[12] = oItem.periodofim;
                  } else {
                      aLinha[11] = js_formatar(oItem.periodoini, 'd');
                      aLinha[12] = js_formatar(oItem.periodofim, 'd');
                  }
                  aLinha[13].setValue(0);
                  aLinha[13].setDisable(true);
              } else if ($('oCboTipoAditivo').value == 14) {

                  oInputQuantidade.setValue( js_formatar(0, "f", 3));
                  aLinha[5] = oInputQuantidade.toInnerHtml();

                  aLinha[13].setValue(0);
                  aLinha[13].setDisable(true);
              }
              else if ($('oCboTipoAditivo').value == 0) {
                  oInputQuantidade.setValue( js_formatar(0, "f", 3));
                  aLinha[5] = oInputQuantidade.toInnerHtml();
              }
          }

          /**
           * Caso seja servico e nao controlar quantidade, a quantidade padrao sera 1
           */
          if (oItem.servico && (oItem.controlaquantidade == "f" || oItem.controlaquantidade == "")) {
              aLinha[3] = js_formatar(1, 'f', 2);
              oInputQuantidade.setReadOnly(true);
              oInputQuantidade.setValue( js_formatar(1, "f", 3));
              aLinha[5] = oInputQuantidade.toInnerHtml();
              if ($('oCboTipoAditivo').value == 9 || $('oCboTipoAditivo').value == 10 || $('oCboTipoAditivo').value == 11 || $('oCboTipoAditivo').value == 14) {
                  oInputQtAditada.setValue(js_formatar(1, "f", 2));//OC5304
                  aLinha[8] = oInputQtAditada.toInnerHtml();//OC5304
              }

          }

          // if(!oItem.controlaquantidade){
          //   if(oItem.servico == 't'){
          //     oInputQuantidade.setReadOnly(false);
          //     aLinha[4] = oInputQuantidade.toInnerHtml();
          //     oInputUnitario.setReadOnly(true);
          //     aLinha[5] = oInputUnitario.toInnerHtml();
          //   }else{
          //     oInputQuantidade.setReadOnly(true);
          //     aLinha[4] = oInputQuantidade.toInnerHtml();
          //     oInputUnitario.setReadOnly(false);
          //     aLinha[5] = oInputUnitario.toInnerHtml();
          //   }
          // }

          if(!oItem.periodoini && !oItem.periodofim){
              let datainicio = $('oTxtDataInicial').value.replace('-', '');
              let datafim = $('oTxtDataFinal').value.replace('-', '');
              aLinha[11] = datainicio;
              aLinha[12] = datafim;
          }

          if(oItem.novo && oItem.novo !== undefined){
              oInputQuantidade.setReadOnly(true);
              aLinha[5] = oInputQuantidade.toInnerHtml();
              oInputUnitario.setReadOnly(true);
              aLinha[6] = oInputUnitario.toInnerHtml();
          }



          me.oGridItens.addRow(aLinha, false, me.lBloqueiaItem, (me.lBloqueiaItem || iTipoAditamento == 5 || oItem.novo));

          var sTextEvent  = " ";

          if (aLinha[2] !== '') {
              sTextEvent += "<b>Item: </b>"+aLinha[2];
          } else {
              sTextEvent += "<b>Nenhum dado  mostrar</b>";
          }

          var oDadosHint           = new Object();
          oDadosHint.idLinha   = me.oGridItens.aRows[iSeq].aCells[3].sId;
          oDadosHint.sText     = sTextEvent;
          aDadosHintGrid[iSeq] = oDadosHint;



          if (oItem.dotacoesoriginal == undefined) {

              oItem.dotacoesoriginal = new Array();

              oItem.dotacoes.forEach(function (oDotacaoOriginal) {
                  var oDotacao = new Object();
                  /* Comentado a pedido da OC5304
                  if (oItem.servico && (oItem.controlaquantidade == "f" || oItem.controlaquantidade == "")) {
                      oDotacao.dotacao = oDotacaoOriginal.dotacao;
                      oDotacaoOriginal.quantidade = 1;
                      oDotacaoOriginal.valor = 0;
                      oDotacaoOriginal.valororiginal = 0;
                    }*/

                  oItem.dotacoesoriginal.push({
                      dotacao: oDotacaoOriginal.dotacao,
                      quantidade: oDotacaoOriginal.quantidade,
                      valor: oDotacaoOriginal.valor,
                      valororiginal: oDotacaoOriginal.valororiginal
                  });
              });
          }

          me.salvarInfoDotacoes(iSeq);
      });

      me.oGridItens.renderRows();

      aDadosHintGrid.each(function(oHint, id) {
          var oDBHint    = eval("oDBHint_"+id+" = new DBHint('oDBHint_"+id+"')");
          oDBHint.setText(oHint.sText);
          oDBHint.setShowEvents(aEventsIn);
          oDBHint.setHideEvents(aEventsOut);
          oDBHint.setPosition('B', 'L');
          //oDBHint.setUseMouse(true);
          oDBHint.make($("oGridItensrow"+id+"cell2"), 3);
      });
  }

  /**
   * Calcula o valor da coluna Valor Total
   */
  this.calculaValorTotal = function (iLinha) {

      var aLinha = me.oGridItens.aRows[iLinha],
          nQuantidade  = aLinha.aCells[6].getValue().getNumber(),
          nUnitario    = aLinha.aCells[7].getValue().getNumber(),
          nQuantidadeA = aLinha.aCells[4].getValue().getNumber(),//OC5304
          nUnitarioA   = Number(aLinha.aCells[5].getValue().split('.').join("").replace(",","."));//OC5304
          valor1 = nQuantidade.toString();
          valor = valor1.split('.');
          if(valor.length>1){
              casas = valor[1].length;
          }else{
              casas = 2;
          }



      aItensPosicao[iLinha].novaquantidade  = nQuantidade;
      aItensPosicao[iLinha].novounitario    = nUnitario;

      nValorTotal = nQuantidade * nUnitario;
      valorTotal  = nQuantidadeA * nUnitarioA;


      aLinha.aCells[8].setContent(js_formatar(nQuantidade * nUnitario, 'f', 2));


      if (aItensPosicao[iLinha].servico == false && (aItensPosicao[iLinha].controlaquantidade == "t" || aItensPosicao[iLinha].controlaquantidade != "")) {
          aLinha.aCells[9].setContent(js_formatar((nQuantidade - nQuantidadeA), 'f', casas) );//Quantidade Aditada OC5304

      }
      else if (aItensPosicao[iLinha].servico == true && aItensPosicao[iLinha].controlaquantidade == "t") {
          aLinha.aCells[9].setContent(js_formatar((nQuantidade - nQuantidadeA), 'f', casas) );//Quantidade Aditada OC5304
      }

      aLinha.aCells[10].setContent( js_formatar((nValorTotal - valorTotal), 'f', 2));//Valor Aditado OC5304
      if (this.totalizador) {
          this.somaAditamentos();
      }

      me.salvarInfoDotacoes(iLinha);
  }

  this.pesquisaMaterial = function (mostra) {

      if (mostra) {

          js_OpenJanelaIframe('top.corpo',
              'db_iframe_pcmater',
              'func_pcmater.php?funcao_js=parent.' + me.sInstance + '.mostraMaterial|pc01_codmater|pc01_descrmater|pc01_servico',
              'Pesquisar Materiais',
              true
          );
          $('Jandb_iframe_pcmater').style.zIndex = 10000000;
      } else {

          if (oTxtMaterial.getValue() != '') {

              js_OpenJanelaIframe('top.corpo',
                  'db_iframe_pcmater',
                  'func_pcmater.php?pesquisa_chave=' + oTxtMaterial.getValue() +
                  '&funcao_js=parent.' + me.sInstance + '.mostrapcmater',
                  'Pesquisar materiais',
                  false);
          } else {
              oTxtDescrMaterial.setValue('');
          }
      }
  }

  this.mostrapcmater = function (chave1, chave2, erro) {

      me.mostraSelectServico(chave2);

      oTxtDescrMaterial.setValue(chave1);
      if (erro == true) {
          oTxtMaterial.setValue('');
      } else {
          me.getElementosMateriais();
      }
  }

  this.mostraMaterial = function (chave1, chave2, chave3) {

      me.mostraSelectServico(chave3);

      oTxtMaterial.setValue(chave1);
      oTxtDescrMaterial.setValue(chave2);
      db_iframe_pcmater.hide();
      me.getElementosMateriais();
  }

  this.mostraSelectServico = (servico) => {
    let mostra = servico == 't' ? '' : 'none';
    $('servico-quantidade').style.display = mostra;

    let controlaQuantidade = document.getElementById('oCboServicoQuantidade').value;

    if(!Number(controlaQuantidade) && servico == 't'){
      oTxtQuantidade.setValue("1,000");
      oTxtQuantidade.setReadOnly(true);
    }

  }

  /**
   * Libera para incluso de itens novos
   */
  if (this.lLiberaNovosItens) {

      $('btnItens').style.display = '';
      $('btnItens').observe('click', me.novoItem);
  }

  this.js_exibedescricao = function () {
      if($('oIndiceReajuste').value==6){
          $('trdescricaoreajuste').style.display = '';
      }else{
          $('trdescricaoreajuste').style.display = 'none';
          me.oTxtDescricaoReajuste.setValue('');
      }
  }

  this.js_changeTipoAditivo = function () {

      $('oTextAreaDescricaoAlteracao').addClassName('readonly');
      $('oTextAreaDescricaoAlteracao').readOnly = true;
      $('oTxtDataInicial').readOnly = true;
      $('oTxtDataInicial').style.backgroundColor= 'rgb(222, 184, 135)';
      $('oTxtDataFinal').readOnly = true;
      $('oTxtDataFinal').style.backgroundColor= 'rgb(222, 184, 135)';
      $('btnItens').style.display = 'none';

      if ($('oCboTipoAditivo').value == 7) {

          $('oTextAreaDescricaoAlteracao').removeClassName('readonly');
          $('oTextAreaDescricaoAlteracao').readOnly = false;

      }

      if($('oCboTipoAditivo').value == 12){
        $('btnRemoveItem').style.display = '';
      }else $('btnRemoveItem').style.display = 'none';

      if ($('oCboTipoAditivo').value == 14) {

          $('oTextAreaDescricaoAlteracao').removeClassName('readonly');
          $('oTextAreaDescricaoAlteracao').readOnly = false;
          $('oTxtDataInicial').readOnly = false;
          $('oTxtDataInicial').style.backgroundColor= 'white';
          $('oTxtDataFinal').readOnly = false;
          $('oTxtDataFinal').style.backgroundColor= 'white';

      } else if ($('oCboTipoAditivo').value == 6 || $('oCboTipoAditivo').value == 13 ) {
          $('oTxtDataInicial').readOnly = false;
          $('oTxtDataInicial').style.backgroundColor= 'white';
          $('oTxtDataFinal').readOnly = false;
          $('oTxtDataFinal').style.backgroundColor= 'white';
      } else if($('oCboTipoAditivo').value == 12) {
          $('btnItens').style.display = '';
          $('btnItens').observe('click', me.novoItem);
      }
  }

  this.lidaTiposAdimentos = () => {
      const tiposAditivo = ['9','10','11','14'];

      if (tiposAditivo.includes($('oCboTipoAditivo').value)) {
          this.aEstadoInputQtdFinal = new Array();
          let acordo = document.getElementById('oTxtCodigoAcordo').value;
          this.getAcordo(acordo);
          return;
      }
  }

  this.getAcordo = (iAcordo) => {
      var oParam = new Object();
      oParam.exec = "getItensAditamento";
      oParam.iAcordo = iAcordo;
      js_divCarregando('Aguarde, carregando', 'msgBox');
      var oAjax = new Ajax.Request(
          "con4_contratos.RPC.php",
          {
              method: 'post',
              parameters: 'json=' + Object.toJSON(oParam),
              onComplete: me.retornoGetAcordo
          }
      );

  }

  this.retornoGetAcordo =  (oAjax) => {
      js_removeObj('msgBox');
      const tipoAditivo = $('oCboTipoAditivo').value
      var oRetorno = eval("(" + oAjax.responseText + ")");

      let itensGrid = me.oGridItens.aRows;
      let iQuantidadeItens = itensGrid.length;
      let retornoItens = oRetorno.itens;
      let tamanhoRetornoItens = retornoItens.length;

      for (var i = 0; i < iQuantidadeItens; i++) {
          let aLinha = itensGrid[i];
          let codigoGrid = aLinha.aCells[2].getValue();
          let j = 0;

          while( j < tamanhoRetornoItens) {
              if (retornoItens[j].ac20_pcmater == codigoGrid) {
                  this.validaTipoAditivo(aLinha, retornoItens[j], tipoAditivo);
                  j = tamanhoRetornoItens + j;
              }
              j++;
          }
       }
  }

  this.validaTipoAditivo = (aLinha, retornoItem, tipoAditivo) => {

       if (retornoItem.ac20_servicoquantidade === 'f'
          && retornoItem.pc01_servico === 't') {
           this.desabilitaLinha(aLinha, tipoAditivo);
           return;
       }

      let iQuantidadeAtual = Number(aLinha.aCells[4].getValue().split('.').join("").replace(",","."));
      if (tipoAditivo === '14'
          && (retornoItem.ac20_servicoquantidade === 't'
          ||
          retornoItem.ac20_servicoquantidade === 'f'
          && retornoItem.pc01_servico === 'f'
          )
          && iQuantidadeAtual > 0) {
          this.desativaInput(aLinha,7);
          return;
      }
  }

  this.desabilitaLinha = (aLinha,tipoAditivo) => {
      let colunasTotal = aLinha.aCells.length;
      let colunasDesabilitadas = tipoAditivo === '14'
          ? [0,6,7,9,10,12,13]
          : [0,6,7,9,10];

      for (let i = 0; i < colunasTotal; i++) {
          if (colunasDesabilitadas.includes(i)) {
              const valorFinalInput = this.buscaInput(aLinha.aCells[i]);
              valorFinalInput.disabled = true;
          }

      }
  }

  this.desativaInput = (aLinha, coluna) => {
      let atributos = `
          background-color:#DEB887;
          pointer-events: none;
          touch-action: none;
          width:100%
      `;

      const valorFinalInput = this.buscaInput(aLinha.aCells[7]);
      valorFinalInput.style.cssText = atributos;
      return;
  }

  this.buscaInput = (itemGrid) => {
      let idCelula = itemGrid.getId();
      const valorFinalDom = document.getElementById(idCelula);
      const valorFinalInput = valorFinalDom.children;
      return valorFinalInput[0];
  }

  this.removeItens = () => {
    let listaItens = me.oGridItens.aRows;
    let listaCodigos = [];
    let numeroLinha = [];
    let listaInvalida = [];


    let marcados = document.getElementsByClassName('marcado');

    for (let cont = 0; cont < marcados.length; cont++) {
      numeroLinha.push(marcados[cont].id.substr(-1));
    }


    listaItens.forEach((item, index) => {
      if(item.isSelected){
        let sCodigo = item.aCells[0].content.replace(/ \s /g, '').split(' ');

        /* Regex para extrair somente os números da string */
        let regra = /\d+/g;

        sCodigo = sCodigo[2].substr(17, sCodigo.length - 1).replace("'", '');
        sCodigo = regra.exec(sCodigo);

        if(!listaCodigos.includes(sCodigo)){
          listaCodigos.push(sCodigo);
        }

      }
    });



    let itensConfirmados = [];
    for(let cont=0; cont<numeroLinha.length; cont++){
       itensConfirmados.push(aItensPosicao[numeroLinha[cont]].codigoitem);
    }

    if(numeroLinha.length){

      let resposta = confirm('Deseja remover item(ns) '+itensConfirmados.join(',')+'? ');

      if(resposta){
        let listaValida = [];
        let itensAceitos = [];

        if(numeroLinha.length > 1){
          for (var cont = 0; cont < numeroLinha.length; cont++) {

            if(aItensPosicao[numeroLinha[cont]].novo){
              listaValida.push(numeroLinha[cont]);
              itensAceitos.push(aItensPosicao[numeroLinha[cont]].codigoitem);
            }
            else{
              listaInvalida.push(aItensPosicao[numeroLinha[cont]].codigoitem);
            }
          }
        }else{
          if(aItensPosicao[numeroLinha[0]].novo){
            listaValida.push(numeroLinha[0]);
            itensAceitos.push(aItensPosicao[numeroLinha[0]].codigoitem);
            aItensPosicao.splice(numeroLinha[0], 1);
          }else{
            listaInvalida.push(aItensPosicao[numeroLinha[0]].codigoitem);
          }
        }

        itensAceitos.forEach((codigo, index) => {
          aItensPosicao.forEach((item, index) => {
            if(item.codigoitem == codigo){
              aItensPosicao.splice(index, 1);
            }
          })
        })

        if(listaInvalida.length){

          if(listaInvalida.length > 1){

            for(let cont=0;cont<numeroLinha.length;cont++){
              me.oGridItens.aRows[numeroLinha[cont]].isSelected = false;
            }

            let itensNaoRemovidos = listaInvalida.join(', ');
            alert('Os itens '+itensNaoRemovidos+' não podem ser removidos!');
          } else{
            me.oGridItens.aRows[numeroLinha[0]].isSelected = false;
            alert('O item '+listaInvalida[0]+' não pode ser excluí­do!');
          }
        }

        if(listaValida.length){

          if(itensAceitos.length > 1){
            alert('Os itens '+itensAceitos.join(', ')+' foram removidos!');
          }else{
            alert('O item '+itensAceitos[0]+' foi removido!');
          }
          me.oGridItens.removeRow(listaValida);
        }

        me.oGridItens.renderRows();

      }
    }else alert('Selecione algum item para ser removido.')


  }

  this.somaAditamentos = () => {
      const tdLista = document.body.querySelectorAll("#oGridItensbody tbody td:nth-child(11)");
      soma = 0.0;
      for (let count = 0; count < tdLista.length; count++) {
          let valorMonetario = tdLista[count].textContent;
          valorMonetario = valorMonetario.replace(".","");
          valorMonetario = valorMonetario.replace(",",".");
          let valorTd = parseFloat(valorMonetario);
          if (!tdLista[count].textContent) {
              valorTd = 0.0;
          }
          soma += valorTd;
      }
      this.atualizarLabelTotal(soma);
  }

  this.atualizarLabelTotal = (valorAditado) => {
      document.querySelector("#oGridItenstotalValue").innerHTML = js_formatar(valorAditado, 'f');
  }

  this.js_changeCriterioReajuste = function () {

      let criterioReajuste = $('oCboCriterioReajuste').value;

      if(criterioReajuste == "1"){
          document.getElementById('trdoindice').style.display = "";
          document.getElementById('trdescricaoindice').style.display = "none";
          document.getElementById('oTxtDescricaoIndice').value = "";
          return;
      }
      document.getElementById('trdoindice').style.display = "none";
      document.getElementById('trdescricaoreajuste').style.display = "none";
      document.getElementById('trdescricaoindice').style.display = "";
      document.getElementById('oIndiceReajuste').value = "0";
      document.getElementById('oTxtDescricaoReajuste').value = "";
  }
}
