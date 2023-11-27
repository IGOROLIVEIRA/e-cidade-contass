<html>
<?php
require_once 'libs/db_stdlib.php';
require_once 'libs/db_conecta.php';
require_once 'libs/db_sessoes.php';
require_once 'libs/db_usuariosonline.php';
require_once 'libs/db_utils.php';
require_once 'dbforms/db_funcoes.php';
?>
<head>
    <title>Contass Contabilidade Ltda - P&aacute;gina Inicial</title>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <style>
    </style>
</head>

<body bgcolor="#CCCCCC">
    <center>
        <form name='form1' method="post" action="">
            <fieldset style="width: 600px; margin-top: 30px">
                <legend>Alteração de Observações:</legend>
                <table align="left">
                    <tr>
                        <td>
                            <strong>Tipo:</strong>
                        </td>
                        <td >
                            <?
                            $aTipos= array(
                                "0" => "Selecione",
                                "1" => "Solicitação",
                                "2" => "Abertura de Registro de Preço",
                                "3" => "Estimativa de Registro de Preço",
                                "4" => "Compilação de Registro de Preço",
                                "5" => "Processo de Compra",
                                "6" => "Autorização",
                                "7" => "Empenho",
                                "8" => "Ordem de Compra"
                                );
                                db_select("tipo", $aTipos, true, $db_opcao, "style='width: 100%;' onchange='js_alteracaoTipo(this);'");
                                ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?
                            db_ancora("Solicitação:", "js_pesquisaSolicitacao(true);",1,"display:none","ancoraSolicitacao");
                            db_ancora("Abertura:", "js_pesquisaAbertura(true);",1,"display:none","ancoraAbertura");
                            db_ancora("Estimativa: ", "js_pesquisaEstimativa(true);",1,"display:none","ancoraEstimativa");
                            db_ancora("Compilação: ", "js_pesquisaCompilacao(true);",1,"display:none","ancoraCompilacao");
                            db_ancora("Processo: ", "js_pesquisaProcesso(true);",1,"display:none","ancoraProcesso");
                            db_ancora("Autorização: ", "js_pesquisaAutorizacao(true);",1,"display:none","ancoraAutorizacao");
                            db_ancora("Empenho: ", "js_pesquisaEmpenho(true);",1,"display:none","ancoraEmpenho");
                            db_ancora("Ordem: ", "js_pesquisaOrdem(true);",1,"display:none","ancoraOrdem");
                            ?>
                        </td>
                        <td>
                            <?
                            db_input('solicitacao', 10, 1, true, 'text', 1, "style='display:none' onchange='js_pesquisaSolicitacao(false);'");
                            db_input('abertura', 10, 1, true, 'text', 1, "style='display:none' onchange='js_pesquisaAbertura(false);'");
                            db_input('estimativa', 10, 1, true, 'text', 1, "style='display:none' onchange='js_pesquisaEstimativa(false);'");
                            db_input('compilacao', 10, 1, true, 'text', 1, "style='display:none' onchange='js_pesquisaCompilacao(false);'");
                            db_input('processo', 10, 1, true, 'text', 1, "style='display:none' onchange='js_pesquisaProcesso(false);'");
                            db_input('autorizacao', 10, 1, true, 'text', 1, "style='display:none' onchange='js_pesquisaAutorizacao(false);'");
                            db_input('empenho', 10, 0, true, 'text', 1, "style='display:none' onchange='js_pesquisaEmpenho(false);'");
                            db_input('ordem', 10, 1, true, 'text', 1, "style='display:none' onchange='js_pesquisaOrdem(false);'");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <fieldset style="margin-top: 20px;">
                                <legend>
                                    <b>Observação</b>
                            </legend>
                                <?
                                db_textarea('observacao',5,70,0,true,'text',1,"");
                                ?>
                            </fieldset>
                        </td>
                    </tr>
                </table>
                <?
                db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
                ?>
            </fieldset>
            <input type="button" style="margin-top: 15px;" name="alterar" id="alterar" value="Alterar" onclick="js_alteraObservacao()">
        </form>
    </center>
</body>

<script>

var idCampo = {1: 'solicitacao',2: 'abertura',3: 'estimativa',4: 'compilacao',
                   5: 'processo',6: 'autorizacao', 7: 'empenho', 8: 'ordem'};

function js_alteracaoTipo(tipo){

    let idAncora = {1: 'ancoraSolicitacao',2: 'ancoraAbertura',3: 'ancoraEstimativa',4: 'ancoraCompilacao',
                    5: 'ancoraProcesso',6: 'ancoraAutorizacao', 7: 'ancoraEmpenho', 8: 'ancoraOrdem'};

    for (i = 1; i <= 8; i++) {
        document.getElementById(idCampo[i]).style.display = "none";
        document.getElementById(idAncora[i]).style.display = "none";
    }

    document.getElementById(idCampo[tipo.value]).style.display = '';
    document.getElementById(idAncora[tipo.value]).style.display = '';
    document.getElementById(idCampo[tipo.value]).value = "";
    document.getElementById('observacao').value = "";
    
}   

function js_alteraObservacao(){

    if(document.getElementById('tipo').value == 0){
        return alert("Usuário: selecione o tipo para alteração.")
    }

    let tipo = idCampo[document.form1.tipo.value];
    let sequencial = document.getElementById(tipo).value;

    if(sequencial == ""){
        return alert("Usuário: sequencial não informado.")
    }

    let observacao = document.getElementById('observacao').value;
    let tabelaConsultada = {
        1: "solicita",
        2: "solicita",
        3: "solicita",
        4: "solicita",
        5: "pcproc",
        6: "empautoriza",
        7: "empempenho",
        8: "matordem"
    }; 

    let tabela = tabelaConsultada[document.form1.tipo.value];

    let oParametros = new Object();
    oParametros.tipo = tipo;
    oParametros.sequencial = sequencial;
    oParametros.tabela = tabela;
    oParametros.observacao = encodeURIComponent(tagString(observacao));
    let oAjax = new Ajax.Request('m4_alteraobservacao.RPC.php', {
        method: 'post',
        parameters: 'json=' + Object.toJSON(oParametros),
        onComplete: js_retornoAlteraObservacao

    });
}

function js_retornoAlteraObservacao(oAjax){

    let oRetorno = eval("(" + oAjax.responseText + ")");
    if (oRetorno.status == 1){
        return alert("Alteração Efetuada");
    }
    alert(erro);

}

function js_pesquisaObservacao(){

    let tipo = idCampo[document.form1.tipo.value];
    let sequencial = document.getElementById(tipo).value;
    let tabelaConsultada = {
        1: "solicita",
        2: "solicita",
        3: "solicita",
        4: "solicita",
        5: "pcproc",
        6: "empautoriza",
        7: "empempenho",
        8: "matordem"
    }; 

    let tabela = tabelaConsultada[document.form1.tipo.value];

    let oParametros = new Object();
    oParametros.tipo = tipo;
    oParametros.sequencial = sequencial;
    oParametros.tabela = tabela;
    let oAjax = new Ajax.Request('m4_pesquisaobservacao.RPC.php', {
        method: 'post',
        parameters: 'json=' + Object.toJSON(oParametros),
        onComplete: js_retornoPesquisaObservacao

    });
}

function js_retornoPesquisaObservacao(oAjax){

    let oRetorno = eval("(" + oAjax.responseText + ")");
    document.getElementById('observacao').value =  oRetorno.observacao.urlDecode();

}

function js_pesquisaSolicitacao(mostra){

  if(mostra){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_solicita','func_solicita.php?funcao_js=parent.js_retornoPesquisaSolicitacao|pc10_numero'+'&nada=true&tiposolicitacao=1','Pesquisa',true);
    return;
  }
    
  if(document.form1.solicitacao.value!=""){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_solicita','func_solicita.php?funcao_js=parent.js_retornoPesquisaSolicitacao&pesquisa_chave='+document.form1.solicitacao.value+'&nada=true&tiposolicitacao=1','Pesquisa',false);
    return;
  }

  document.form1.solicitacao.value = "";
  document.form1.observacao.value = "";
    
}

function js_retornoPesquisaSolicitacao(chave,erro){
  if(erro){
    document.form1.solicitacao.value = "";
    document.form1.observacao.value = "";
    return;
  }
  document.form1.solicitacao.value = chave;
  db_iframe_solicita.hide();
  js_pesquisaObservacao();
}

function js_pesquisaAbertura(mostra){

    if(mostra){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_abertura','func_solicitaregistropreco.php?formacontrole=1,2&funcao_js=parent.js_retornoPesquisaAbertura|pc54_solicita&departamento=false','Abertura Registro de Preço',true);
        return;
    }
    
    if(document.form1.abertura.value!=""){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_abertura','func_solicitaregistropreco.php?formacontrole=1,2&funcao_js=parent.js_retornoPesquisaAbertura&departamento=false&pesquisa_chave='+document.form1.abertura.value,'Pesquisa',false);
        return;
    }

    document.form1.abertura.value = "";
    document.form1.observacao.value = "";

}

function js_retornoPesquisaAbertura(chave,erro){

    if(erro){
        document.form1.abertura.value = "";
        document.form1.observacao.value = "";
        return;
    }

    document.form1.abertura.value = chave;
    db_iframe_abertura.hide();
    js_pesquisaObservacao();
}

function js_pesquisaEstimativa(mostra){

    if(mostra){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_estimativa', 'func_solicitaestimativa.php?funcao_js=parent.js_retornoPesquisaEstimativa|pc10_numero','Estimativas de Registro de Preço',true);
        return;
    }
    
    if(document.form1.estimativa.value!=""){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_estimativa','func_solicitaestimativa.php?funcao_js=parent.js_retornoPesquisaEstimativa&pesquisa_chave='+document.form1.estimativa.value,'Pesquisa',false);
        return;
    }

    document.form1.estimativa.value = "";
    document.form1.observacao.value = "";

}

function js_retornoPesquisaEstimativa(chave,erro){
    if(erro){
        document.form1.estimativa.value = "";
        document.form1.observacao.value = "";
        return;
    }
    document.form1.estimativa.value = chave;
    db_iframe_estimativa.hide();
    js_pesquisaObservacao();
}

function js_pesquisaCompilacao(mostra){

    if(mostra){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_compilacao', 'func_solicitacompilacao.php?funcao_js=parent.js_retornoPesquisaCompilacao|pc10_numero','Compilações de Registro de Preço',true);
        return;
    }

    if(document.form1.compilacao.value!=""){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_compilacao','func_solicitacompilacao.php?funcao_js=parent.js_retornoPesquisaCompilacao&tipobusca=1&pesquisa_chave='+document.form1.compilacao.value,'Pesquisa',false);
        return;
    }

    document.form1.compilacao.value = "";
    document.form1.observacao.value = "";

}

function js_retornoPesquisaCompilacao(chave,erro){
    if(erro){
        document.form1.compilacao.value = "";
        document.form1.observacao.value = "";
        return;
    }
    document.form1.compilacao.value = chave;
    db_iframe_compilacao.hide();
    js_pesquisaObservacao();
}

function js_pesquisaProcesso(mostra){

    if(mostra){
        js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_pcproc','func_proccompras.php?funcao_js=parent.js_retornoPesquisaProcesso|pc80_codproc', 'Pesquisa', true);
        return;
    }

    if(document.form1.processo.value!=""){
        js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_pcproc','func_proccompras.php?funcao_js=parent.js_retornoPesquisaProcesso&pesquisa_chave='+document.form1.processo.value, 'Pesquisa', false);
        return;
    }

    document.form1.processo.value = "";
    document.form1.observacao.value = "";

}

function js_retornoPesquisaProcesso(chave,erro){
    if(erro){
        document.form1.processo.value = "";
        document.form1.observacao.value = "";
        return;
    }
    document.form1.processo.value = chave;
    db_iframe_pcproc.hide();
    js_pesquisaObservacao();
}

function js_pesquisaAutorizacao(mostra){

    if(mostra){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_empautoriza','func_empautoriza.php?funcao_js=parent.js_retornoPesquisaAutorizacao|e54_autori','Pesquisa',true);
        return;
    }

    if(document.form1.autorizacao.value!=""){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_empautoriza','func_empautoriza.php?funcao_js=parent.js_retornoPesquisaAutorizacao&pesquisa_chave='+document.form1.autorizacao.value,'Pesquisa',false);
        return;
    }

    document.form1.autorizacao.value = "";
    document.form1.observacao.value = "";

}

function js_retornoPesquisaAutorizacao(chave,erro){
    if(erro){
        document.form1.autorizacao.value = "";
        document.form1.observacao.value = "";
        return;
    }
    if(erro == false){
        db_iframe_empautoriza.hide();
        js_pesquisaObservacao();
        return;
    }
    document.form1.autorizacao.value = chave;
    db_iframe_empautoriza.hide();
    js_pesquisaObservacao();
}

function js_pesquisaEmpenho(mostra){

    if(mostra){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_empempenho','func_empempenho.php?funcao_js=parent.js_retornoPesquisaEmpenho|e60_codemp|e60_anousu','Pesquisa',true);
        return;
    }

    if(document.form1.empenho.value!=""){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_empempenho','func_empempenho.php?lPesquisaPorCodigoEmpenho=1&funcao_js=parent.js_retornoPesquisaEmpenho1&pesquisa_chave='+document.form1.empenho.value,'Pesquisa',false);
        return;
    }

    document.form1.empenho.value = "";
    document.form1.observacao.value = "";

}

function js_retornoPesquisaEmpenho(chave1,chave2){

    document.form1.empenho.value = chave1 + "/" + chave2;
    db_iframe_empempenho.hide();
    js_pesquisaObservacao();

}

function js_retornoPesquisaEmpenho1(chave,erro){
    
    if(erro === true){
        document.form1.empenho.value = "";
        document.form1.observacao.value = "";
        return;
    }

    document.form1.empenho.value = chave;
    js_pesquisaObservacao();
}

function js_pesquisaOrdem(mostra){

    if(mostra){
        js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_ordem', 'func_matordemanulada.php?funcao_js=parent.js_retornoPesquisaOrdem|m51_codordem', 'Pesquisa', true);
        return;
    }

    if(document.form1.ordem.value!=""){
        js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_ordem','func_matordemanulada.php?funcao_js=parent.js_retornoPesquisaOrdem&pesquisa_chave='+document.form1.ordem.value, 'Pesquisa', false);
        return;
    }

    document.form1.ordem.value = "";
    document.form1.observacao.value = "";

}

function js_retornoPesquisaOrdem(chave,erro){
    if(erro){
        document.form1.ordem.value = "";
        document.form1.observacao.value = "";
        return;
    }
    document.form1.ordem.value = chave;
    db_iframe_ordem.hide();
    js_pesquisaObservacao();
}

</script>