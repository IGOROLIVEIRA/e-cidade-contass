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
/**
 * var oAjaxRequest = new AjaxRequest('con1_departamentos.RPC.php', {exec: 'listarDepartamentos', codusuario : 1}, callBackRetorno);
 * oAjaxRequest.setMessage('Buscando departamentos...');
 * oAjaxRequest.execute();
 *
 * @param {string} sPathFile
 * @param {object} oParameters
 * @param {function} fnCallback
 * @constructor
 */
AjaxRequest = function(sPathFile, oParameters, fnCallback) {

    /**
     * Código da requisição
     * @type {number}
     */
    this.id = 0;

    /**
     * Caminho do arquivo que receberá a requisição
     * @type {string}
     */
    this.sPathFile = sPathFile;

    /**
     * Função de callback que será executada após a conclusão da requisição
     * - Ela será devolvida com dois parâmetros fnCallback(oObject, lErro)
     * @type {Function}
     */
    this.fnCallback = fnCallback;

    /**
     * Parâmetros da requisição
     * @type {object}
     */
    this.oParameters = oParameters;

    /**
     * Asynchronous
     * @type {boolean}
     */
    this.lAsynchronous = true;

    /**
     * Mensagem padrão
     * @type {string}
     */
    this.sMessage = "Aguarde...";

    /**
     * Arquivos
     * @type {Array}
     */
    this.aFiles = [];

    /**
     * @param {boolean} lAsynchronous
     */
    this.asynchronous = function (lAsynchronous) {
        this.lAsynchronous = lAsynchronous;
        return this;
    };

    /**
     * @param sMessage
     */
    this.setMessage = function(sMessage) {

        this.sMessage = sMessage;
        return this;
    };


    this.setParameters = function(oParameters) {
        this.oParameters = oParameters;
    };

    this.setCallBack   = function(fnCallBack) {
        this.fnCallback = fnCallBack;
    }

    /**
     * Adiciona um arquivo a ser carregado
     * @param {object} oInput
     */
    this.addFileInput = function(oInput) {

        this.aFiles.push(oInput);
        return this;
    }
};

/**
 * ID unico da requisicao
 * @type {number}
 */
AjaxRequest._uid = 0;

/**
 * Construtor estátitco
 */
AjaxRequest.create = function(sPathFile, oParameters, fnCallback) {
    return new AjaxRequest(sPathFile, oParameters, fnCallback);
};

/**
 * Executa uma requisição ajax
 */
AjaxRequest.prototype.execute = function() {
    console.log('here');
    js_divCarregando(this.sMessage, 'msgBox' + (++this.id));
    console.log('here2');
    var oRequest = {
        method : 'post',
        asynchronous : this.lAsynchronous,
        onComplete : function(oAjax) {
            console.log('veio aqki');
            js_removeObj('msgBox' + this.id);
            console.log('veio aqki2');
            console.log('ajax',oAjax );
            console.log('sem json parse',oAjax.responseText);
            console.log('json parse',JSON.parse(oAjax.responseText));
            var oReturn = JSON.parse(oAjax.responseText);
            console.log('veio aqki3');
            if (oReturn.erro == undefined) {
                oReturn.erro = true;
                console.log("Variável para controle de erro não localizada. Crie uma variavel no RPC chamada 'erro'.");
            }
            console.log('here3');
            this.fnCallback(oReturn, oReturn.erro);
        }.bind(this)
    };

    /**
     * Verifica se deve fazer upload de algum arquivo e muda os cabeçalhos da requisição
     */
    if (this.aFiles.length > 0) {

        /**
         * Cria o formulario de upload com os campos de arquivos
         */
        var oForm = new FormData();

        oForm.append("json", Object.toJSON(this.oParameters));

        this.aFiles.each(function(oFile) {
            oForm.append(oFile.name, oFile.files.item(0));
        });

        oRequest.contentType = '';
        oRequest.encoding    = false;
        oRequest.postBody    = oForm;

        /**
         * Altera a função setRequestHeader do XMLHttpRequest quando for utilizar o FormData
         *
         * No Chrome esta setando a propriedade Content-Type vazio devido a uma limitação
         * do Prototype.js, o que acaba ocasionando um erro na requisição
         */
        if (window.XMLHttpRequest) {

            var bkpSetRequestHeader = XMLHttpRequest.prototype.setRequestHeader;

            XMLHttpRequest.prototype.setRequestHeader = function(header, value) {

                if (value != '') {
                    bkpSetRequestHeader.call(this, header, value);
                }
            }
        }

    } else {
        oRequest.parameters = 'json=' + Object.toJSON(this.oParameters);
    }

    new Ajax.Request(this.sPathFile, oRequest);

    /**
     * Restaura a função setRequestHeader do XMLHttpRequest
     */
    if (this.aFiles.length > 0 && window.XMLHttpRequest) {
        XMLHttpRequest.prototype.setRequestHeader = bkpSetRequestHeader;
    }
};
