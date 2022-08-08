<div id="lista" style="position: absolute; width:100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
<div id="topo" style="width:100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

<span style=" float: left; margin-top: 5px; border: 0px solid red;">Contratos</span>
<div id="fechar" onclick="fechar()" style="background:url('imagens/jan_fechar_on.gif'); height: 20px;
    float: right;  width: 20px;"></div>
<div id="fechar" style="background:url('imagens/jan_max_off.gif'); height: 20px;
    float: right;  width: 20px;"></div>
<div id="fechar" onclick="fechar()" style="background:url('imagens/jan_mini_on.gif'); height: 20px;
    float: right;  width: 20px;"></div>

</div><!-- topo -->
<div id="campos" style="margin-bottom: 7px;">
<table>
<tr>
<td><strong>Código</strong></td>
<td> <input type="text" name="codigoSeq" id="codigoSeq" maxlength="13" onkeyup="js_ValidaCampos(this,1,'código','f','f',event);"></td>
</tr>
<tr>
<td><strong>Código Licitação:</strong></td>
<td>
 <input type="text" name="licitacao" id="licitacao" maxlength="13" onkeyup="js_ValidaCampos(this,1,'numCgm','f','f',event);">
</td>
</tr>
<tr>
<td></td>
<td><input type="button" name="bntPesquisarXml" value="Pesquisar" onclick="pesquisar_codigo()"></td>
</tr>
</table>
</div><!-- campos -->
</div><!-- lista -->


<form name="form1" method="post" action="" >
<table>
<tr>
<td>
<fieldset style="width: 500px; height: 470px;"><legend><b>Contratos</b></legend>

  <table cellspacing="5px">
  <tr>
  <td><strong>Código</strong></td>
  <td> <input type="text" name="codigo" id="codigo" readonly="readonly" style="background-color: rgb(222, 184, 135);"
  onchange="passar_codigo();" ></td>
  </tr>

  <tr>
  <td><strong>Número Contrato</strong></td>
  <td> <input type="text" name="nroContrato" id="nroContrato" maxlength="15" onkeyup="js_ValidaCampos(this,1,'nroContrato','f','f',event);" /></td>
  </tr>

  <tr>
  <td><strong>Data Assinatura</strong></td>
  <td>
  <input type="text" name="dataAssinatura" id="dataAssinatura" onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)"
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10">
  <input id="dataAssinatura_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataAssinatura_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataAssinatura_ano" type="hidden" maxlength="4" size="4" value="" title="" >
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparaDatasodataAssinatura(dia,mes,ano){
      var objData = document.getElementById('dataAssinatura');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>

  </td>
  </tr>

  <tr>
  <td><strong>Nome Contratado</strong></td>
  <td> <input type="text" name="nomContratadoParcPublico" id="nomContratadoParcPublico" maxlength="120"  /></td>
  </tr>

  <tr>
  <td><strong>Cpf/Cnpj</strong></td>
  <td> <input type="text" name="nroDocumento" id="nroDocumento" maxlength="14" onkeyup="js_ValidaCampos(this,1,'Cpf/Cnpj','f','f',event);" /></td>
  </tr>

  <tr>
  <td><strong>Nome Representante Legal</strong></td>
  <td> <input type="text" name="representanteLegalContratado" id="representanteLegalContratado" maxlength="50" /></td>
  </tr>

  <tr>
  <td><strong>Cpf Representante Legal</strong></td>
  <td> <input type="text" name="cpfrepresentanteLegal" id="cpfrepresentanteLegal" maxlength="11" onkeyup="js_ValidaCampos(this,1,'Cpf','f','f',event);"/></td>
  </tr>

  <tr>
    <td  nowrap title="<?=$Tl20_codigo?>">
    <b>
    <?db_ancora('Licitação:',"js_pesquisa_liclicita(true);",1);?>
    </b>
    </td>
    <td>
    <input name="nroProcessoLicitatorio" id="nroProcessoLicitatorio" onchange="js_pesquisa_liclicita(false);"
     readonly="readonly" style="background-color: rgb(222, 184, 135);"  />
    </td>
  </tr>

  <tr>
  <td><strong>Natureza do Objeto do Contrato:</strong></td>
  <td>
  <select name="naturezaObjeto" id="naturezaObjeto">
   <option value="1" id="01">Obras e Serviços de Engenharia</option>
   <option value="2" id="02">Compras e serviços</option>
   <option value="3" id="03">Locação</option>
   <option value="4" id="04">Concessão</option>
   <option value="5" id="05">Permissão</option>
  </select>
  </td>
  </tr>

  <tr>
  <td><strong>Objeto do Contrato:</strong></td>
  <td><textarea name="objetoContrato" id="objetoContrato" value="" cols="30" rows="5"
  onKeyDown="textCounter(this.form.objetoContrato,this.form.remLen,500)" onKeyUp="textCounter(this.form.objetoContrato,this.form.remLen,500)">
  </textarea></td>
  </tr>

  <tr>
  <td><strong>Tipo de Instrumento</strong></td>
  <td>
  <select name="tipoInstrumento" id="tipoInstrumento">
   <option value="1" id="01">Contrato</option>
   <option value="2" id="02">Termos de parceria/OSCIP</option>
   <option value="3" id="03">Contratos de gestão</option>
   <option value="4" id="04">Outros termos de parceria</option>
  </select>
  </td>
  </tr>

  <tr>
  <td><strong>Data Inicial da Vigência</strong></td>
  <td>
  <input type="text" name="dataInicioVigencia" id="dataInicioVigencia" onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)"
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10">
  <input id="dataInicioVigencia_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataInicioVigencia_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataInicioVigencia_ano" type="hidden" maxlength="4" size="4" value="" title="" >
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparaDatasdataInicioVigencia(dia,mes,ano){
      var objData = document.getElementById('dataInicioVigencia');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>

  </td>
  </tr>

  <tr>
  <td><strong>Data Final da Vigência</strong></td>
  <td>
  <input type="text" name="dataFinalVigencia" id="dataFinalVigencia" onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)"
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10">
  <input id="dataFinalVigencia_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataFinalVigencia_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataFinalVigencia_ano" type="hidden" maxlength="4" size="4" value="" title="" >
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparaDatasdataFinalVigencia(dia,mes,ano){
      var objData = document.getElementById('dataFinalVigencia');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>

  </td>
  </tr>

  <tr>
  <td><strong>Valor do Contrato</strong></td>
  <td> <input type="text" name="vlContrato" id="vlContrato" onkeyup="js_ValidaCampos(this,4,'Valor','f','f',event);"/></td>
  </tr>

  <tr>
  <td><strong>Forma de fornecimento ou
regime de execução:</strong></td>
  <td>
  <textarea name="formaFornecimento" id="formaFornecimento" value="" cols="30" rows="2"
  onKeyDown="textCounter(this.form.formaFornecimento,this.form.remLen,50)" onKeyUp="textCounter(this.form.formaFornecimento,this.form.remLen,50)">
  </textarea>
  </td>
  </tr>
 </table>
 </fieldset>
</td>

<td>
 <fieldset style="width: 500px; height: 459px;">
 <table>
  <tr>
  <td><strong>Forma de Pagamento:</strong></td>
  <td>
  <textarea name="formaPagamento" id="formaPagamento" value="" cols="30" rows="2"
  onKeyDown="textCounter(this.form.formaPagamento,this.form.remLen,100)" onKeyUp="textCounter(this.form.formaPagamento,this.form.remLen,100)">
  </textarea>
  </td>
  </tr>

  <tr>
  <td><strong>Prazo de Execução:</strong></td>
  <td>
  <textarea name="prazoExecucao" id="prazoExecucao" value="" cols="30" rows="2"
  onKeyDown="textCounter(this.form.prazoExecucao,this.form.remLen,100)" onKeyUp="textCounter(this.form.prazoExecucao,this.form.remLen,100)">
  </textarea>
  </td>
  </tr>

  <tr>
  <td><strong>Multa Rescisória:</strong></td>
  <td>
  <textarea name="multaRescisoria" id="multaRescisoria" value="" cols="30" rows="2"
  onKeyDown="textCounter(this.form.multaRescisoria,this.form.remLen,100)" onKeyUp="textCounter(this.form.multaRescisoria,this.form.remLen,100)">
  </textarea>
  </td>
  </tr>

  <tr>
  <td><strong>Multa Inadimplemento:</strong></td>
  <td>
  <textarea name="multaInadimplemento" id="multaInadimplemento" value="" cols="30" rows="2"
  onKeyDown="textCounter(this.form.multaInadimplemento,this.form.remLen,100)" onKeyUp="textCounter(this.form.multaInadimplemento,this.form.remLen,100)">
  </textarea>
  </td>
  </tr>

  <tr>
  <td><strong>Garantia</strong></td>
  <td>
  <select name="garantia" id="garantia">
   <option value="1" id="01">Caução em dinheiro</option>
   <option value="2" id="02">Título da dívida pública</option>
   <option value="3" id="03">Seguro garantia</option>
   <option value="4" id="04">Fiança bancária</option>
   <option value="5" id="05">Sem garantia</option>
  </select>
  </td>
  </tr>

  <tr>
  <td><strong>Nome do Signatário da Contratante</strong></td>
  <td> <input type="text" name="signatarioContratante" id="signatarioContratante" maxlength="50" /></td>
  </tr>

  <tr>
  <td><strong>Cpf Siganatário</strong></td>
  <td> <input type="text" name="cpfsignatarioContratante" id="cpfsignatarioContratante" maxlength="11" onkeyup="js_ValidaCampos(this,1,'Cpf','f','f',event);"/></td>
  </tr>

  <tr>
  <td><strong>Data da Publicação do Contrato</strong></td>
  <td>
  <input type="text" name="dataPublicacao" id="dataPublicacao" onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)"
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10">
  <input id="dataPublicacao_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataPublicacao_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataPublicacao_ano" type="hidden" maxlength="4" size="4" value="" title="" >
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparaDatasdataPublicacao(dia,mes,ano){
      var objData = document.getElementById('dataPublicacao');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>

  </td>
  </tr>

  <tr>
  <td><strong>Veículo de Divulgação</strong></td>
  <td> <input type="text" name="veiculoDivulgacao" id="veiculoDivulgacao" maxlength="50" /></td>
  </tr>

</table>
</fieldset>
</td>
</tr>

<tr>
<td align="center" colspan="2">
<div>
  <input type="submit" value="Salvar" name="btnSalvar" />
  <input type="submit" value="Excluir" name="btnExcluir" />
  <input type="button" value="Pesquisar" name="btnPesquisar" onclick="pesquisar()" />
  <input type="reset" value="Novo" name="btnNovo" onclick="codigo_dotacao('')"; />
</div>
</td>
<td>
</td>
</tr>

</table>

</form>

<script type="text/javascript">
/**
 * passar o codigo do contrato para o form da dotacao
 */
function codigo_dotacao(cod) {

  CurrentWindow.corpo.iframe_db_dotacao.location.href='con4_sicomdotacao.php?codigo='+cod;
  if (cod == '') {
    parent.document.formaba.db_dotacao.disabled=true;
  }

}

/**
 * limitar caracteres de textarea
 */
function textCounter(field, countfield, maxlimit) {

  if (field.value.length > maxlimit){
    field.value = field.value.substring(0, maxlimit);
  }else{
    countfield.value = maxlimit - field.value.length;
  }
  }

/*
 * Pesquisar dados da licitação
 */
 function js_pesquisa_liclicita(mostra) {
    if(mostra==true){
      js_OpenJanelaIframe('','db_iframe_liclicita','func_liclicita.php?funcao_js=parent.js_mostraliclicita1|l20_codigo','Pesquisa',true);
    }else{
       if(document.form1.nroProcessoLicitatorio.value != ''){
          js_OpenJanelaIframe('','db_iframe_liclicita','func_liclicita.php?pesquisa_chave='+document.form1.nroProcessoLicitatorio.value+'&funcao_js=parent.js_mostraliclicita','Pesquisa',false);
       }else{
         document.form1.nroProcessoLicitatorio.value = '';
       }
    }
  }
  function js_mostraliclicita(chave,erro){
    document.form1.nroProcessoLicitatorio.value = chave;
    if(erro==true){
      document.form1.nroProcessoLicitatorio.value = '';
      document.form1.nroProcessoLicitatorio.focus();
    }
  }
  function js_mostraliclicita1(chave1){
     document.form1.nroProcessoLicitatorio.value = chave1;
     db_iframe_liclicita.hide();
  }

  /**
   * buscar dados do xml para criar a tabela
   */
  function pesquisar() {

    var oAjax = new Ajax.Request("con4_pesquisarxmlcontratos.php",
        {
      method:"post",
      onComplete:cria_tabela
        }
    );

  }

  /**
   * pesquisar dados no xml pelo codigo digitado
   */
  function pesquisar_codigo() {

    var campo = document.getElementById('TabDbLov');
    document.getElementById('lista').removeChild(campo);

    var oAjax = new Ajax.Request("con4_pesquisarxmlcontratos.php",
        {
      method:"post",
      parameters:{codigo1: $("codigoSeq").value, codigo2: $("licitacao").value},
      onComplete:cria_tabela
        }
    );

  }

  /**
   *
   */
  function pegar_valor(param1, param2, param3, param4, param5, param6, param7, param8, param9, param10, param11,
      param12, param13, param14, param15, param16, param17, param18, param19, param20, param21, param22, param23, param24){

    $('codigo').value                       = param1;
    $('nroContrato').value                  = param2;
    $('dataAssinatura').value               = param3;
    $('nomContratadoParcPublico').value     = param4;
    $('nroDocumento').value                 = param5;
    $('representanteLegalContratado').value = param6;
    $('cpfrepresentanteLegal').value        = param7;
    $('nroProcessoLicitatorio').value       = param8;
    document.getElementById("naturezaObjeto").options['0'+param9].selected = "true";
    $('objetoContrato').value               = param10;
    document.getElementById("tipoInstrumento").options['0'+param11].selected = "true";
    $('dataInicioVigencia').value           = param12;
    $('dataFinalVigencia').value            = param13;
    $('vlContrato').value                   = param14;
    $('formaFornecimento').value            = param15;
    $('formaPagamento').value               = param16;
    $('prazoExecucao').value                = param17;
    $('multaRescisoria').value              = param18;
    $('multaInadimplemento').value          = param19;
    document.getElementById("garantia").options['0'+param20].selected = "true";
    $('signatarioContratante').value        = param21;
    $('cpfsignatarioContratante').value     = param22;
    $('dataPublicacao').value               = param23;
    $('veiculoDivulgacao').value            = param24;

    CurrentWindow.corpo.iframe_db_dotacao.location.href='con4_sicomdotacao.php?codigo='+param1;
    parent.document.formaba.db_dotacao.disabled=false;

    document.getElementById('lista').style.visibility = "hidden";
    var campo = document.getElementById('TabDbLov');
    document.getElementById('lista').removeChild(campo);

  }

  function fechar() {

    var campo = document.getElementById('TabDbLov');
    document.getElementById('lista').removeChild(campo);
    document.getElementById('lista').style.visibility = "hidden";

  }

  function cria_tabela(json) {

    var jsonObj = eval("("+json.responseText+")");
    var tabela;
    var color = "#e796a4";
    tabela  = "<table id=\"TabDbLov\" cellspacing=\"1\" cellpadding=\"2\" border=\"1\">";
    tabela += "<tr style=\"text-decoration: underline;\"><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
    tabela += "Código";

    tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
    tabela += "Número Contrato";

    tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
    tabela += "Nome Contrato";

    tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
    tabela += "Nome Representante Legal";

    tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
    tabela += "Licitação";

    tabela += "</td></tr>";
    try {

      for (var i = 0; i < jsonObj.length; i++){

        if(i % 2 != 0){
            color = "#97b5e6";
        }else{
          color = "#e796a4";
        }
        tabela += "<tr>";

        tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
        tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].nroContrato+"','"+jsonObj[i].dataAssinatura+"','"
        +jsonObj[i].nomContratadoParcPublico+"','"+jsonObj[i].nroDocumento+"','"+jsonObj[i].representanteLegalContratado+"','"
        +jsonObj[i].cpfrepresentanteLegal+"','"+jsonObj[i].nroProcessoLicitatorio+"','"+jsonObj[i].naturezaObjeto+"','"
        +jsonObj[i].objetoContrato+"','"+jsonObj[i].tipoInstrumento+"','"
        +jsonObj[i].dataInicioVigencia+"','"+jsonObj[i].dataFinalVigencia+"','"+jsonObj[i].vlContrato+"','"
        +jsonObj[i].formaFornecimento+"','"+jsonObj[i].formaPagamento+"','"+jsonObj[i].prazoExecucao+"','"
        +jsonObj[i].multaRescisoria+"','"+jsonObj[i].multaInadimplemento+"','"+jsonObj[i].garantia+"','"
        +jsonObj[i].signatarioContratante+"','"+jsonObj[i].cpfsignatarioContratante+"','"
        +jsonObj[i].dataPublicacao+"','"+jsonObj[i].veiculoDivulgacao+"')\">"+jsonObj[i].codigo+"</a>";

        tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
        tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].nroContrato+"','"+jsonObj[i].dataAssinatura+"','"
        +jsonObj[i].nomContratadoParcPublico+"','"+jsonObj[i].nroDocumento+"','"+jsonObj[i].representanteLegalContratado+"','"
        +jsonObj[i].cpfrepresentanteLegal+"','"+jsonObj[i].nroProcessoLicitatorio+"','"+jsonObj[i].naturezaObjeto+"','"
        +jsonObj[i].objetoContrato+"','"+jsonObj[i].tipoInstrumento+"','"
        +jsonObj[i].dataInicioVigencia+"','"+jsonObj[i].dataFinalVigencia+"','"+jsonObj[i].vlContrato+"','"
        +jsonObj[i].formaFornecimento+"','"+jsonObj[i].formaPagamento+"','"+jsonObj[i].prazoExecucao+"','"
        +jsonObj[i].multaRescisoria+"','"+jsonObj[i].multaInadimplemento+"','"+jsonObj[i].garantia+"','"
        +jsonObj[i].signatarioContratante+"','"+jsonObj[i].cpfsignatarioContratante+"','"
        +jsonObj[i].dataPublicacao+"','"+jsonObj[i].veiculoDivulgacao+"')\">"+jsonObj[i].nroContrato+"</a>";


        tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
        tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].nroContrato+"','"+jsonObj[i].dataAssinatura+"','"
        +jsonObj[i].nomContratadoParcPublico+"','"+jsonObj[i].nroDocumento+"','"+jsonObj[i].representanteLegalContratado+"','"
        +jsonObj[i].cpfrepresentanteLegal+"','"+jsonObj[i].nroProcessoLicitatorio+"','"+jsonObj[i].naturezaObjeto+"','"
        +jsonObj[i].objetoContrato+"','"+jsonObj[i].tipoInstrumento+"','"
        +jsonObj[i].dataInicioVigencia+"','"+jsonObj[i].dataFinalVigencia+"','"+jsonObj[i].vlContrato+"','"
        +jsonObj[i].formaFornecimento+"','"+jsonObj[i].formaPagamento+"','"+jsonObj[i].prazoExecucao+"','"
        +jsonObj[i].multaRescisoria+"','"+jsonObj[i].multaInadimplemento+"','"+jsonObj[i].garantia+"','"
        +jsonObj[i].signatarioContratante+"','"+jsonObj[i].cpfsignatarioContratante+"','"
        +jsonObj[i].dataPublicacao+"','"+jsonObj[i].veiculoDivulgacao+"')\">"+jsonObj[i].nomContratadoParcPublico+"</a>";

        tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
        tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].nroContrato+"','"+jsonObj[i].dataAssinatura+"','"
        +jsonObj[i].nomContratadoParcPublico+"','"+jsonObj[i].nroDocumento+"','"+jsonObj[i].representanteLegalContratado+"','"
        +jsonObj[i].cpfrepresentanteLegal+"','"+jsonObj[i].nroProcessoLicitatorio+"','"+jsonObj[i].naturezaObjeto+"','"
        +jsonObj[i].objetoContrato+"','"+jsonObj[i].tipoInstrumento+"','"
        +jsonObj[i].dataInicioVigencia+"','"+jsonObj[i].dataFinalVigencia+"','"+jsonObj[i].vlContrato+"','"
        +jsonObj[i].formaFornecimento+"','"+jsonObj[i].formaPagamento+"','"+jsonObj[i].prazoExecucao+"','"
        +jsonObj[i].multaRescisoria+"','"+jsonObj[i].multaInadimplemento+"','"+jsonObj[i].garantia+"','"
        +jsonObj[i].signatarioContratante+"','"+jsonObj[i].cpfsignatarioContratante+"','"
        +jsonObj[i].dataPublicacao+"','"+jsonObj[i].veiculoDivulgacao+"')\">"+jsonObj[i].representanteLegalContratado+"</a>";

        tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
        tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].nroContrato+"','"+jsonObj[i].dataAssinatura+"','"
        +jsonObj[i].nomContratadoParcPublico+"','"+jsonObj[i].nroDocumento+"','"+jsonObj[i].representanteLegalContratado+"','"
        +jsonObj[i].cpfrepresentanteLegal+"','"+jsonObj[i].nroProcessoLicitatorio+"','"+jsonObj[i].naturezaObjeto+"','"
        +jsonObj[i].objetoContrato+"','"+jsonObj[i].tipoInstrumento+"','"
        +jsonObj[i].dataInicioVigencia+"','"+jsonObj[i].dataFinalVigencia+"','"+jsonObj[i].vlContrato+"','"
        +jsonObj[i].formaFornecimento+"','"+jsonObj[i].formaPagamento+"','"+jsonObj[i].prazoExecucao+"','"
        +jsonObj[i].multaRescisoria+"','"+jsonObj[i].multaInadimplemento+"','"+jsonObj[i].garantia+"','"
        +jsonObj[i].signatarioContratante+"','"+jsonObj[i].cpfsignatarioContratante+"','"
        +jsonObj[i].dataPublicacao+"','"+jsonObj[i].veiculoDivulgacao+"')\">"+jsonObj[i].nroProcessoLicitatorio+"</a>";

        tabela += "</td></tr>";
      }

    } catch (e) {
    }
    tabela += "</table>";
    var conteudo = document.getElementById('lista');
    conteudo.innerHTML += tabela;
    conteudo.style.visibility = "visible";

  }

function passar_valores(cod) {

          var oAjax = new Ajax.Request("con4_pesquisarxmlcontratos.php",
              {
             method:"post",
             parameters:{codigo1: cod},
             onComplete: function(data) {

               var jsonObj = eval("("+data.responseText+")");
               var i = 0;
               pegar_valor(jsonObj[i].codigo,jsonObj[i].nroContrato,jsonObj[i].dataAssinatura,
               jsonObj[i].nomContratadoParcPublico,jsonObj[i].nroDocumento,jsonObj[i].representanteLegalContratado,
               jsonObj[i].cpfrepresentanteLegal,jsonObj[i].nroProcessoLicitatorio,jsonObj[i].naturezaObjeto,
               jsonObj[i].objetoContrato,jsonObj[i].tipoInstrumento,
               jsonObj[i].dataInicioVigencia,jsonObj[i].dataFinalVigencia,jsonObj[i].vlContrato,
               jsonObj[i].formaFornecimento,jsonObj[i].formaPagamento,jsonObj[i].prazoExecucao,
               jsonObj[i].multaRescisoria,jsonObj[i].multaInadimplemento,jsonObj[i].garantia,
               jsonObj[i].signatarioContratante,jsonObj[i].cpfsignatarioContratante,
               jsonObj[i].dataPublicacao,jsonObj[i].veiculoDivulgacao);

              }
            }
          );
      }

</script>

<?
if (isset($iUltimoCodigo)) {
  echo "<script>
    passar_valores(".$iUltimoCodigo.");
     parent.mo_camada('db_dotacao');
  </script>";
}

?>
