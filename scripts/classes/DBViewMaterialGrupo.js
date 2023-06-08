function criaRowConta(info) {

  var oLabelLink = document.createElement("a");
  oLabelLink.classList.add('dbancora');
  oLabelLink.href                 = '#';
  oLabelLink.innerHTML            = '<b>' + info.titulo + ':</b>';
  oLabelLink.style.textDecoration = 'underline';
  oLabelLink.addEventListener('click', info.pesquisa.bind(null, {
      mostra: true,
      vpd: info.vpd,
    }, info.onComplete, {
      codigo: info.codigo,
      descricao: info.descricao
    }
  ));

  var oCelulaLabel = document.createElement("td");
  oCelulaLabel.appendChild(oLabelLink);


  var oSpanCodigo = document.createElement("span");
  oSpanCodigo.appendChild(info.codigo);
  info.codigo.onchange = info.pesquisa.bind(null, {
      mostra: false,
      vpd: info.vpd,
    }, info.onComplete, {
      codigo: info.codigo,
      descricao: info.descricao
    }
  );

  var oSpanDescricao = document.createElement("span");
  oSpanDescricao.appendChild(info.descricao);
  info.descricao.setReadOnly();

  var oCelulaInput = document.createElement("td");
  oCelulaInput.noWrap = 'noWrap';
  oCelulaInput.appendChild(oSpanCodigo);
  oCelulaInput.appendChild(oSpanDescricao);


  var oNovaRow = document.createElement("tr");
  oNovaRow.appendChild(oCelulaLabel);
  oNovaRow.appendChild(oCelulaInput);

  return oNovaRow;

}

function criaRowTitulo(titulo) {

  var oLinha = document.createElement('tr');
  oLinha.innerHTML = '<td colspan="2"><hr><strong>' + titulo + '</strong></td>';

  return oLinha;

}

function criaInput(name, value, size) {
  var input = document.createElement('input');
  input.id  = name;
  input.name  = name;
  input.size  = size;
  input.type  = 'text';
  input.value = value;

  input.setReadOnly = function () {

    input.classList.add('readonly');
    input.readonly = true;

  };

  return input;
}


DBViewMaterialGrupo = function(iMaterialGrupo, sInstance, oNode) {

  var me              = this;
  this.sRPC           = 'mat4_materialgrupo.RPC.php';
  me.instance         = sInstance;
  me.iCodigoEstrutura = 0;
  me.iCodigoGrupo     = iMaterialGrupo;

  me.onSaveComplete = function (oRetorno) {

  }

  me.onBeforeSave = function() {
    return true;
  }

  me.campos = {
    txtCodigoConta: criaInput('txtCodigoConta', '', 10),
    txtDescricaoConta: criaInput('txtDescricaoConta', '', 35),

    txtCodigoContaVPD: criaInput('txtCodigoContaVPD', '', 10),
    txtDescricaoContaVPD: criaInput('txtDescricaoContaVPD', '', 35),

    txtCodigoTransferencia: criaInput('txtCodigoTransferencia', '', 10),
    txtDescricaoTransferencia: criaInput('txtDescricaoTransferencia', '', 35),

    txtCodigoTransferenciaVPD: criaInput('txtCodigoTransferenciaVPD', '', 10),
    txtDescricaoTransferenciaVPD: criaInput('txtDescricaoTransferenciaVPD', '', 35),

    txtCodigoDoacao: criaInput('txtCodigoDoacao', '', 10),
    txtDescricaoDoacao: criaInput('txtDescricaoDoacao', '', 35),

    txtCodigoDoacaoVPD: criaInput('txtCodigoDoacaoVPD', '', 10),
    txtDescricaoDoacaoVPD: criaInput('txtDescricaoDoacaoVPD', '', 35),

    txtCodigoPerdaAtivo: criaInput('txtCodigoPerdaAtivo', '', 10),
    txtDescricaoPerdaAtivo: criaInput('txtDescricaoPerdaAtivo', '', 35),

    txtCodigoPerdaAtivoVPD: criaInput('txtCodigoPerdaAtivoVPD', '', 10),
    txtDescricaoPerdaAtivoVPD: criaInput('txtDescricaoPerdaAtivoVPD', '', 35),

    txtCodigoContaCredito: criaInput('txtCodigoContaCredito', '', 10),
    txtDescricaoCredito: criaInput('txtDescricaoCredito', '', 35),

    txtCodigoContaDebito: criaInput('txtCodigoContaDebito', '', 10),
    txtDescricaoDebito: criaInput('txtDescricaoDebito', '', 35)
  };


  me.mostraPesquisaConta = function (onComplete, vpd) {

    var executar  = me.instance + '.' + onComplete;
    var destino   = 'func_conplano.php?funcao_js=parent.' + executar + '|c60_codcon|c60_descr';
    var titulo    = 'Escolha uma Conta Contbil';

    if (!!vpd) {
      destino += '&lEstrutural=1';
      titulo   = ' VPD';
    }

    js_OpenJanelaIframe(
      '',
      'db_iframe_conplano',
      destino,
      titulo,
      true
    );

  }


  me.naoMostraPesquisaConta = function (campos, onComplete, vpd) {

    var chave = campos.codigo.getValue();

    if (chave == '') {

      campos.descricao.setValue('');
      return;

    }

    var executar  = me.instance + '.' + onComplete;
    var destino   = 'func_conplano.php?&pesquisa_chave=' + chave + '&funcao_js=parent.' + executar;

    if (!!vpd) {
      destino  += '&lEstrutural=1';
    }

    js_OpenJanelaIframe(
      '',
      'db_iframe_conplano' + chave,
      destino,
      '',
      false
    );

  }


  me.pesquisaConta = function (pesquisa, onComplete, campos) {

    if (pesquisa.mostra) {
      me.mostraPesquisaConta(onComplete, pesquisa.vpd);
    } else {
      me.naoMostraPesquisaConta(campos, onComplete, pesquisa.vpd);
    }

  }


  me.preencheCampos = function (campos, valores) {

    if (valores[1] === true) {

      campos.codigo.value = '';
      campos.descricao.value = valores[0];

    } else if (valores[1] === false) {

      campos.descricao.value = valores[0];

    } else {

      campos.codigo.value = valores[0];
      campos.descricao.value = valores[1];

      if (db_iframe_conplano) {
        db_iframe_conplano.hide();
      }

    }

  }

  me.completaConta = function() {
    me.preencheCampos({
      codigo: me.campos.txtCodigoConta,
      descricao: me.campos.txtDescricaoConta
    }, arguments);
  }

  me.completaContaVPD = function() {
    me.preencheCampos({
      codigo: me.campos.txtCodigoContaVPD,
      descricao: me.campos.txtDescricaoContaVPD
    }, arguments);
  }

  me.completaContaTransf = function() {
    me.preencheCampos({
      codigo: me.campos.txtCodigoTransferencia,
      descricao: me.campos.txtDescricaoTransferencia
    }, arguments);
  }

  me.completaContaTransfVPD = function() {
    me.preencheCampos({
      codigo: me.campos.txtCodigoTransferenciaVPD,
      descricao: me.campos.txtDescricaoTransferenciaVPD
    }, arguments);
  }

  me.completaContaDoacao = function() {
    me.preencheCampos({
      codigo: me.campos.txtCodigoDoacao,
      descricao: me.campos.txtDescricaoDoacao
    }, arguments);
  }

  me.completaContaDoacaoVPD = function() {
    me.preencheCampos({
      codigo: me.campos.txtCodigoDoacaoVPD,
      descricao: me.campos.txtDescricaoDoacaoVPD
    }, arguments);
  }

  me.completaContaPerda = function() {
    me.preencheCampos({
      codigo: me.campos.txtCodigoPerdaAtivo,
      descricao: me.campos.txtDescricaoPerdaAtivo
    }, arguments);
  }

  me.completaContaPerdaVPD = function() {
    me.preencheCampos({
      codigo: me.campos.txtCodigoPerdaAtivoVPD,
      descricao: me.campos.txtDescricaoPerdaAtivoVPD
    }, arguments);
  }

  me.completaContaCredito = function() {
    me.preencheCampos({
      codigo: me.campos.txtCodigoContaCredito,
      descricao: me.campos.txtDescricaoCredito
    }, arguments);
  }

  me.completaContaDebito = function() {
    me.preencheCampos({
      codigo: me.campos.txtCodigoContaDebito,
      descricao: me.campos.txtDescricaoDebito
    }, arguments);
  }

  me.atualizaValoresContas = function() {

    me.campos.txtCodigoTransferencia.onchange();
    me.campos.txtCodigoTransferenciaVPD.onchange();
    me.campos.txtCodigoDoacao.onchange();
    me.campos.txtCodigoDoacaoVPD.onchange();
    me.campos.txtCodigoPerdaAtivo.onchange();
    me.campos.txtCodigoPerdaAtivoVPD.onchange();
    me.campos.txtCodigoContaCredito.onchange();
    me.campos.txtCodigoContaDebito.onchange();

  }

  /**
   * Pesquisamos os dados da estrutura que est configurado para ser utilizado no material
   */
  var oParam  = new Object();
  oParam.exec = 'getCodigoEstrutural';
  var oAjax  = new Ajax.Request(this.sRPC,
                               {method: 'post',
                                asynchronous: false,
                                parameters: 'json='+Object.toJSON(oParam),
                                onComplete: function(oAjax) {

                                  var oRetorno = JSON.parse(oAjax.responseText);
                                  me.iCodigoEstrutura = oRetorno.iCodigoEstrutura;
                                }
                               }) ;

  this.dbViewEstrutural = new DBViewEstruturaValor(me.iCodigoEstrutura,
                                               "Grupo/Subgrupo Material", me.instance+".dbViewEstrutural", oNode);
  this.dbViewEstrutural.setAjuda("Informe os dados para composio do grupo/Subgrupo");


  var oTabelaEstrutura = $('tblDados');

  var divCampos = [
    {
      campos: [
        {
          vpd: false,
          titulo: 'Conta Contbil',
          codigo: me.campos.txtCodigoConta,
          descricao: me.campos.txtDescricaoConta,
          pesquisa: me.pesquisaConta,
          onComplete: 'completaConta'
        },
        {
          vpd: true,
          titulo: 'Conta Contbil VPD',
          codigo: me.campos.txtCodigoContaVPD,
          descricao: me.campos.txtDescricaoContaVPD,
          pesquisa: me.pesquisaConta,
          onComplete: 'completaContaVPD'
        }
      ]
    },
    {
      tituloRow: "Conta Transferncia",
      campos: [
        {
          vpd: false,
          titulo: 'Conta Contbil',
          codigo: me.campos.txtCodigoTransferencia,
          descricao: me.campos.txtDescricaoTransferencia,
          pesquisa: me.pesquisaConta,
          onComplete: 'completaContaTransf'
        },
        {
          vpd: true,
          titulo: 'Conta Contbil VPD',
          codigo: me.campos.txtCodigoTransferenciaVPD,
          descricao: me.campos.txtDescricaoTransferenciaVPD,
          pesquisa: me.pesquisaConta,
          onComplete: 'completaContaTransfVPD'
        }
      ]
    },
    {
      tituloRow: "Conta Doao",
      campos: [
        {
          vpd: false,
          titulo: 'Conta Contbil',
          codigo: me.campos.txtCodigoDoacao,
          descricao: me.campos.txtDescricaoDoacao,
          pesquisa: me.pesquisaConta,
          onComplete: 'completaContaDoacao'
        },
        {
          vpd: true,
          titulo: 'Conta Contbil VPD',
          codigo: me.campos.txtCodigoDoacaoVPD,
          descricao: me.campos.txtDescricaoDoacaoVPD,
          pesquisa: me.pesquisaConta,
          onComplete: 'completaContaDoacaoVPD'
        }
      ]
    },
    {
      tituloRow: "Conta Perda de Ativo",
      campos: [
        {
          vpd: false,
          titulo: 'Conta Contbil',
          codigo: me.campos.txtCodigoPerdaAtivo,
          descricao: me.campos.txtDescricaoPerdaAtivo,
          pesquisa: me.pesquisaConta,
          onComplete: 'completaContaPerda'
        },
        {
          vpd: true,
          titulo: 'Conta Contbil VPD',
          codigo: me.campos.txtCodigoPerdaAtivoVPD,
          descricao: me.campos.txtDescricaoPerdaAtivoVPD,
          pesquisa: me.pesquisaConta,
          onComplete: 'completaContaPerdaVPD'
        }
      ]
    },
    {
      tituloRow: "Conta Obra em andamento",
      campos: [
        {
          vpd: false,
          titulo: 'Conta Contbil Crdito',
          codigo: me.campos.txtCodigoContaCredito,
          descricao: me.campos.txtDescricaoCredito,
          pesquisa: me.pesquisaConta,
          onComplete: 'completaContaCredito'
        },
        {
          vpd: false,
          titulo: 'Conta Contbil Dbito',
          codigo: me.campos.txtCodigoContaDebito,
          descricao: me.campos.txtDescricaoDebito,
          pesquisa: me.pesquisaConta,
          onComplete: 'completaContaDebito'
        }
      ]
    }
  ];


  divCampos.forEach(function(div) {

    if (div.tituloRow) {
      oTabelaEstrutura.appendChild(criaRowTitulo(div.tituloRow));
    }

    div.campos.forEach(function(campo) {
      oTabelaEstrutura.appendChild(criaRowConta(campo));
    });

  });

  oTabelaEstrutura.appendChild(criaRowTitulo(''));


  var oRowAtivo             = document.createElement("TR");
  var oCelulaLblAtivo       = document.createElement("TD");
  oCelulaLblAtivo.innerHTML = '<b>Grupo/Subgrupo Ativo:</b>';
  var oCelulaCtnAtivo       = document.createElement("TD");
  oCelulaCtnAtivo.id        = 'ctnCboAtivo';

  oRowAtivo.appendChild(oCelulaLblAtivo);
  oRowAtivo.appendChild(oCelulaCtnAtivo);

  oTabelaEstrutura.appendChild(oRowAtivo);


  /**
   * Criamos os compenentes para os campos especificos
   */
  var aTipos  = new Array();
  aTipos[1]   = 'Sim';
  aTipos[2]   = 'Nao';
  me.cboAtivo = new DBComboBox('cboAtivo',
                                           me.instance+".cboAtivo",
                                           aTipos,
                                           '100%');
  me.cboAtivo.show($('ctnCboAtivo'));


  this.dbViewEstrutural.show();


  me.salvar = function () {

    var oParam    = new Object();
    oParam.exec   = 'salvarGrupo';
    oParam.oGrupo = new Object();

    oParam.oGrupo.iCodigoEstrutura = me.iCodigoEstrutura;
    oParam.oGrupo.sDescricao       = encodeURIComponent(tagString(me.dbViewEstrutural.txtDescricao.getValue()));
    oParam.oGrupo.sEstrutural      = encodeURIComponent(tagString(me.dbViewEstrutural.txtEstrutural.getValue()));
    oParam.oGrupo.iTipo            = me.dbViewEstrutural.cboTipoEstrutural.getValue();
    oParam.oGrupo.lAtivo           = me.cboAtivo.getValue();
    oParam.oGrupo.iConta           = me.campos.txtCodigoConta.getValue();
    oParam.oGrupo.iContaVPD        = me.campos.txtCodigoContaVPD.getValue();
    oParam.oGrupo.iContaTransferencia     = me.campos.txtCodigoTransferencia.value;
    oParam.oGrupo.iContaTransferenciaVPD  = me.campos.txtCodigoTransferenciaVPD.value;
    oParam.oGrupo.iContaDoacao            = me.campos.txtCodigoDoacao.value;
    oParam.oGrupo.iContaDoacaoVPD         = me.campos.txtCodigoDoacaoVPD.value;
    oParam.oGrupo.iContaPerdaAtivo        = me.campos.txtCodigoPerdaAtivo.value;
    oParam.oGrupo.iContaPerdaAtivoVPD     = me.campos.txtCodigoPerdaAtivoVPD.value;
    oParam.oGrupo.iCodigoContaCredito     = me.campos.txtCodigoContaCredito.value;
    oParam.oGrupo.iCodigoContaDebito     = me.campos.txtCodigoContaDebito.value;

    oParam.iCodigoGrupo            = me.iCodigoGrupo;
    if( !me.onBeforeSave(oParam.oGrupo)) {
      return false;
    }
    js_divCarregando('Aguarde, salvando informaes do grupo/subgrupo', 'msgBox');
    var oAjax  = new Ajax.Request(me.sRPC,
                                {method: 'post',
                                parameters: 'json='+Object.toJSON(oParam),
                                onComplete: function(oAjax) {

                                  js_removeObj('msgBox');
                                  var oRetorno = JSON.parse(oAjax.responseText);
                                  if (oRetorno.status == 2) {
                                    alert(oRetorno.message.urlDecode());
                                  } else {
                                    me.onSaveComplete(oRetorno);
                                  }
                                }
                               });
    return false;
  }
  $('btnSalvar').observe("click", me.salvar);
  $('btnCancelar').style.display='none';

  me.getDados = function (iGrupo) {

    js_divCarregando('Aguarde, pesquisando dados grupo/subgrupo', 'msgBox');
    var oParam          = new Object();
    oParam.exec         = 'getDadosGrupo';
    oParam.iCodigoGrupo = iGrupo;
    var oAjax  = new Ajax.Request(me.sRPC,
                                {method: 'post',
                                parameters: 'json='+Object.toJSON(oParam),
                                onComplete: function(oAjax) {

                                  js_removeObj('msgBox');
                                  var oRetorno = eval('(' + oAjax.responseText + ')');
                                  if (oRetorno.status == 2) {
                                    alert(oRetorno.message.urlDecode());
                                  } else {

                                    me.dbViewEstrutural.txtDescricao.setValue(oRetorno.descricao.urlDecode());
                                    me.dbViewEstrutural.txtEstrutural.setValue(oRetorno.estrutural.urlDecode());
                                    me.dbViewEstrutural.cboTipoEstrutural.setValue(oRetorno.tipoconta);
                                    me.cboAtivo.setValue(oRetorno.ativo);
                                    me.campos.txtCodigoConta.setValue(oRetorno.codigoconta);
                                    me.campos.txtCodigoContaVPD.setValue(oRetorno.codigocontaVPD);
                                    me.campos.txtDescricaoConta.setValue(oRetorno.descricaoconta.urlDecode());
                                    me.campos.txtDescricaoContaVPD.setValue(oRetorno.descricaocontaVPD.urlDecode());
                                    me.iCodigoGrupo = oRetorno.codigogrupo;

                                    me.campos.txtCodigoTransferencia.value    = oRetorno.codigocontatransf;
                                    me.campos.txtCodigoTransferenciaVPD.value = oRetorno.codigocontatransfVPD;

                                    me.campos.txtCodigoDoacao.value     = oRetorno.codigocontadoacao;
                                    me.campos.txtCodigoDoacaoVPD.value  = oRetorno.codigocontadoacaoVPD;

                                    me.campos.txtCodigoPerdaAtivo.value     = oRetorno.codigocontaperdaativo;
                                    me.campos.txtCodigoPerdaAtivoVPD.value  = oRetorno.codigocontaperdaativoVPD;

                                    me.campos.txtCodigoContaCredito.value     = oRetorno.codigocontacredito;
                                    me.campos.txtCodigoContaDebito.value  = oRetorno.codigocontadebito;

                                    console.log(oRetorno.sDescricaoTransferencia);
                                    console.log(oRetorno.sDescricaoTransferenciaVPD);

                                    document.getElementById('txtDescricaoTransferencia').value = oRetorno.sDescricaoTransferencia;
                                    document.getElementById('txtDescricaoTransferenciaVPD').value = oRetorno.sDescricaoTransferenciaVPD;
                                    document.getElementById('txtDescricaoDoacao').value = oRetorno.sDescricaoDoacao;
                                    document.getElementById('txtDescricaoDoacaoVPD').value = oRetorno.sDescricaoDoacaoVPD;
                                    document.getElementById('txtDescricaoPerdaAtivo').value = oRetorno.sDescricaoPerdaAtivo;
                                    document.getElementById('txtDescricaoPerdaAtivoVPD').value = oRetorno.sDescricaoPerdaAtivoVPD;
                                    document.getElementById('txtDescricaoCredito').value = oRetorno.sDescricaoCredito;
                                    document.getElementById('txtDescricaoDebito').value = oRetorno.sDescricaoDebito;

                                    //me.atualizaValoresContas();

                                  }
                                }
                               }) ;
  }
}
