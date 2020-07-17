// JavaScript Document

var menu_ordem_geral = 10000;

// Array de Escopo Global para armazenar valores dos INPUTs
var aInputValues = new Array();

function js_cria_objeto_div(idobjeto,texto) {
  return true;
  var camada = top.corpo.document.createElement("DIV");
  camada.setAttribute("id",idobjeto);
  camada.setAttribute("align","center");
  camada.style.backgroundColor = "#5786B1";
  camada.style.layerBackgroundColor = "black";
  camada.style.position = "absolute";
  camada.style.left = "350px";
  camada.style.top = "20px";
  camada.style.zIndex = "1000";
  camada.style.visibility = 'visible';
  // camada.style.width = "420px";
   camada.style.width = (screen.availWidth-15)+'px';
  camada.style.height = "300px";
  camada.innerHTML = '<table border="1" width="100%" height="100%"><tr><td valign="top" align="left" >'+texto+'</td></tr></table>';
  top.corpo.document.body.appendChild(camada);
}
function js_remove_objeto_div(idobjeto) {
  return true;
  if(top.corpo.document.getElementById(idobjeto))
    top.corpo.document.body.removeChild(top.corpo.document.getElementById(idobjeto));
}

function js_seleciona_combo(campoform){
  for(var i=0; i<campoform.length; i++){
    campoform.options[i].selected = true;
  }
}

// js_diferenca_datas: função java script para comparação entre datas
// formato: YYYY-mm-dd
// verifica qual das datas é a maior
// opcao: 1 - retorna a data que maior
//        2 - retorna a data que menor
//        3 - retorna true ou false
//            true : diz que a data da esquerda é maior (data1)
//            false: diz que a data da direita é maior (data2)
//        a - retorna a quantidade de anos entre as datas
//        m - retorna a quantidade de meses entre as datas
//        d - retorna a quantidade de dias entre as datas
//      amd - retorna a quantidade de ano, meses e dias entre as datas separados por ' ' (um espaço em branco)
// OBS.: Se as datas forem iguais, retornará 'i'.
// teste = js_diferenca_datas('2006-03-05','2005-01-01',1);     ** teste = '2006-03-05';
// teste = js_diferenca_datas('2006-03-05','2005-01-01',2);     ** teste = '2005-01-01';
// teste = js_diferenca_datas('2006-03-05','2005-01-01',3);     ** teste = true; (primeira data parametro é maior)
// teste = js_diferenca_datas('2006-01-01','2006-01-01',2);     ** teste = 'i';  (iguais )
// PARA ESTAS COMPARAÇÕES, NÃO IMPORTA A ORDEM EM QUE AS DATAS SÃO PASSADAS
// teste = js_diferenca_datas('2006-03-05','2005-01-01','a');   ** teste = 1;
// teste = js_diferenca_datas('2006-03-05','2005-01-01','m');   ** teste = 14;
// teste = js_diferenca_datas('2006-03-05','2005-01-01','d');   ** teste = 429;
// teste = js_diferenca_datas('2006-03-05','2005-01-01','amd'); ** teste = '1 2 9'; ** 1 ano, 2 meses e 9 dias

function js_diferenca_datas(data1,data2,opcao){
  dataT1 = new Date(data1.substring(0,4),(data1.substring(5,7) - 1),data1.substring(8,10));
  dataT2 = new Date(data2.substring(0,4),(data2.substring(5,7) - 1),data2.substring(8,10));
  maior = dataT1;
  menor = dataT2;
  if(dataT1 > dataT2){
    if(opcao == 1){
      return data1;
    }else if(opcao == 2){
      return data2;
    }else if(opcao == 3){
      return true;
    }
  }else if(dataT2 > dataT1){
    maior = dataT2;
    menor = dataT1;
    if(opcao == 1){
      return data2;
    }else if(opcao == 2){
      return data1;
    }else if(opcao == 3){
      return false;
    }
  }else if(opcao == 1 || opcao == 2 || opcao == 3){
    return 'i';
  }
  dias = (((maior - menor) / 86400000) + 1);
  dias = js_round(dias,0);
  mess = (dias / 30);
  anos = (mess / 12);
  if(opcao == "d"){
    return parseInt(dias);
  }else if(opcao == "m"){
    return parseInt(mess);
  }else if(opcao == "a"){
    return parseInt(anos);
  }else if(opcao == "amd"){
    return anos+' '+mess+' '+dias;
    //return parseInt(anos)+' '+mmess+' '+mdias;
  }
}



// procura um valor em um array
function js_search_in_array(arr,valor){
  for(var ix=0; ix<arr.length; ix++){
    if(arr[ix] == valor){
      return true;
    }
  }
  return false;
}

// js_tabulacaoforms - Função para ordenar os TAB's nos formulários.
// form - formulário onde estão os campos
// foco - campo que receberá foco no início
// tfoco- true se programador quer que campo informado receba o foco e false se não quer
// inicio - índice inicial da tabulação. Caso passado 0 (zero), a função começará do 1 (um)
// campo  - campo que receberá o foco ao sair do último campo
// tcampo - true se programador quer usar a variável campo
function js_tabulacaoforms(form,foco,tfoco,inicio,campo,tcampo){
  eval("var xxi = document."+form+";");

  if(inicio <= 0){  // Seta índice inicial
    indx = 1;
  }else{
    indx = inicio;
  }
  mark = 0;
  for(var i=0; i<xxi.length; i++){
    if(xxi.elements[i].disabled == false){                // Se campo estiver desabilitado, não recebe tabIndex
      array_types = new Array('select-one','text','checkbox','radio','button','submit','reset','textarea','file');
      valor_types = js_search_in_array(array_types,xxi.elements[i].type);
      if(valor_types == true){
        campo_ok = true;
        if(xxi.elements[i].type == 'text'){
          if(xxi.elements[i].readOnly == true){
            campo_ok = false;
          }
        }else if(xxi.elements[i].type == 'button'){
          if(xxi.elements[i].value == "D"){
            campo_ok = false;
          }
        }
        if(campo_ok == true){
          xxi.elements[i].tabIndex = indx;
          indx ++;
          mark = i;
        }else{
          xxi.elements[i].tabIndex = 0;
        }
      }
    }else{
      xxi.elements[i].tabIndex = 0;
    }
  }
  if(tfoco == true){                                    // Se programador quer focar o campo informado, entrará
    camporecebe = eval("xxi."+foco);
    camporecebe.focus();
    if(camporecebe.value != "" && camporecebe.type == "text"){
      camporecebe.select();
    }
  }
  /*
  if(mark > 0 && 1 == 2){
    if(xxi.elements[mark]){
      if(xxi.elements[mark].blur){
        xxi.elements[mark].blur = "xxi."+campo+".focus();";
      }else{
        xxi.elements[mark].blur = "xxi."+campo+".focus();";
      }
      alert(xxi.elements[mark].blur);
    }
  }
  */
}

// Monta lista de arquivos para download
function js_montarlista(lista,form){
  if(lista != "" && form != ""){
    if(eval("document."+form+".query_arquivo")){
      eval("document."+form+".query_arquivo.value = lista");
    }else{
      obj=document.createElement('input');
      obj.setAttribute('name','query_arquivo');
      obj.setAttribute('type','hidden');
      obj.setAttribute('value',lista);
      eval("document."+form+".appendChild(obj)");
    }
    jan = window.open('db_listaarquivos.php?form='+form,'','width=400,height=400,scrollbars=1,location=0');
    jan.moveTo(0,0);
  }else{
    alert("Sem parâmetros para gerar lista de downloads.");
  }
}


// Função para completar com zeros à esquerda o código das rubricas
function js_completa_rubricas(campo){
  valor = campo.value;
  numval = new Number(valor);
  if(valor != "" && numval > 0){
    quantcaracteres = valor.length;
    for(i=quantcaracteres; i<4; i++){
      campo.value = '0' + campo.value;
    }
  }else{
    campo.value = '';
  }
}

// Forçar download de arquivos
function js_arquivo_abrir(selecionado){
  js_OpenJanelaIframe('top.corpo','db_iframe_download','db_download.php?arquivo='+selecionado,'Download de arquivos',false);
}



function db_mes(xmes) {

   var Mes = '';
   if ( xmes == '1' || xmes == '01') {
        Mes = 'Janeiro';
   }
   if ( xmes == '2' || xmes == '02') {
        Mes = 'Fevereiro';
   }
   if ( xmes == '3' || xmes == '03') {
        Mes = 'Março';
   }
   if ( xmes == '4' || xmes == '04') {
        Mes = 'Abril';
   }
   if ( xmes == '5' || xmes == '05') {
        Mes = 'Maio';
   }
   if ( xmes == '6' || xmes == '06') {
        Mes = 'Junho';
   }
   if ( xmes == '7' || xmes == '07') {
        Mes = 'Julho';
   }
   if ( xmes == '8' || xmes == '08') {
        Mes = 'Agosto';
   }
   if ( xmes == '9' || xmes == '09') {
        Mes = 'Setembro';
   }
   if ( xmes == '10') {
        Mes = 'Outubro';
   }
   if ( xmes == '11') {
        Mes = 'Novembro';
   }
   if ( xmes == '12') {
        Mes = 'Dezembro';
  }
  return Mes;
}

function js_verifica_objeto(nome){
  if(!document.getElementById(nome)){
    alert('Sem permissão de acesso.');
    return false;
  }else{
    return true;
  }
}

function buttonHelp(pagina,item,modulo,helpversao){
//#01#//buttonHelp
//#10#//Funcao para abrir o help do sistema
//#15#//buttonHelp(pagina,item,modulo);
//#20#//pagina  : Nome da pãgina que esta chamando o help
//#20#//item    : Número do ítem de menu que o sistema esta quando a funnção é chamada
//#20#//modulo  : Número do ítem do módulo que esta sendo executado
//#99#//Esta função chama o help do sistema e se o usuãrio esta em um programa que possua help,
//#99#//o sistema abre a pãgina do help e seleciona o menu da pãgina

  /**
   * Coleta de informações sobre utilizacao deste menu
   */
  if (this['Ajax']) {

      var oParametros = {
        exec: "logHelp"
      }

      var oRequisicao = {
        method       : 'POST',
        asynchronous : true,
        parameters   : 'json='+JSON.stringify(oParametros)
      }

      new Ajax.Request("con1_usuariosistema.RPC.php", oRequisicao);

  }

 // alvo e a variavel para indicar onde criar o iframe
  var qual_alvo = 'top.corpo';
  if(document.form_iframes){
     var divs = document.getElementsByTagName('IFRAME');
     for (var j = 0; j < divs.length; j++){
        qual_div = 'div_'+divs[j].id;
        if( eval(qual_div+'.style.visibility') == 'visible'){
          qual_alvo = divs[j].name;
        }
     }
     if(helpversao==true)
       js_OpenJanelaIframe(qual_alvo,'db_janelaHelp_OnLine','con1_help001.php?pagina='+pagina+'&item='+item+'&modulo='+modulo,'Help On Line do Sistema',true,0);
     else
       js_OpenJanelaIframe(qual_alvo,'db_janelaVersao_OnLine','con3_versao001.php?pagina='+pagina+'&item='+item+'&modulo='+modulo,'Atualização de Versão do Sistema',true,0);
  }else{
    if(helpversao==true)
      js_OpenJanelaIframe(qual_alvo,'db_janelaHelp_OnLine','con1_help001.php?pagina='+pagina+'&item='+item+'&modulo='+modulo,'Help On Line do Sistema');
    else
      js_OpenJanelaIframe(qual_alvo,'db_janelaVersao_OnLine','con3_versao001.php?pagina='+pagina+'&item='+item+'&modulo='+modulo,'Atualização de Versão do Sistema');

  }

}

function js_retornadata(dia,mes,ano){
//#01#//js_retornadata
//#10#//Funcao para retornar uma data
//#15#//js_retornadata(dia,mes,ano);
//#20#//dia     : Dia
//#20#//mes     : Mes
//#20#//ano     : Ano
  x = new Date(ano,mes,dia);
  m = x.getMonth()+1;
  if(m!=mes){
    while(m!=mes){
      dia=dia-1;
      x = new Date(ano,mes,dia);
      m = x.getMonth()+1;
    }
  }
  return  x;
}
// variavel com os nomes dos campos a serem testados no botao incluir/alterar/excluir e outros
var DB_valida_campos_numerico = "";
var DB_valida_campos_alfa = "";

function js_verifica_campos_digitados(){

  var campos = DB_valida_campos_numerico.split("#");
  if(DB_valida_campos_numerico != ""){
    for(x=0;x<campos.length;x++){
      if(eval('document.form1.'+campos[x]+'.type')!='hidden'){
        if(eval('document.form1.'+campos[x]+'.value')==''){
          eval('document.form1.'+campos[x]+'.value=0');
        }
        var campo = new Number(eval('document.form1.'+campos[x]+'.value'));
        if(isNaN(campo)){
          alert('Campo Inválido.');
          eval('document.form1.'+campos[x]+'.focus()');
          eval('document.form1.'+campos[x]+'.select()');
          return false;
        }
      }
    }
  }

  //alert(DB_valida_campos_alfa);
  var campos = DB_valida_campos_alfa.split("#");
  if(DB_valida_campos_alfa != ""){
    for(x=0;x<campos.length;x++){
      if(eval('document.form1.'+campos[x]+'.type')!='hidden'){
        var campo = eval('document.form1.'+campos[x]+'.value');
        var expr = new RegExp("[^A-Za-z0-9à-úÁ-ÚüÜ \.,;:@&%-\_]+");
        if(campo=="" || campo.match(expr)){
          alert('Campo Inválido.');
          eval('document.form1.'+campos[x]+'.focus()');
          eval('document.form1.'+campos[x]+'.select()');
          return false;
        }
      }
    }
  }
  return true;
}

function js_controla_tecla_enter(obj,evt){
//#01#//js_controla_tecla_enter
//#10#//Funcao para controlar quando a tecla enter é precionada
//#15#//js_controla_tecla_enter(obj,evt);
//#20#//obj : Objeto que esta com a função
//#20#//evt : Este parâmetro não deverá ser passado, pois é automático do javascript
//#30#//Retorna false quando a tecla presionada é igual a 13

  var evt = (evt) ? evt : (window.event) ? window.event : "";

  if(evt.keyCode==13){

    return false;

  }


}


/////////////////////////////////////////////////////////////////
// funcoes de consistencia de cgc e cpf
/////////////////////////////////////////////////////////////////
function js_LimpaCampo(sValor,iBase){

        var tam = sValor.length;
  var saida = new String;
  for (i=0;i<tam;i++)
    if (!isNaN(parseInt(sValor.substr(i,1),iBase)))
      saida = saida + String(sValor.substr(i,1));
  return (saida);
}
function js_TestaNI(cNI,iTipo){
  var NI;
  NI = js_LimpaCampo(cNI.value,10);
  switch (iTipo) {
    case 1:
      if (NI.length != 14){
        alert('O número do CNPJ informado está incorreto');
        cNI.select();
        cNI.focus();
        return(false);
        }

      if (NI.substr(12,2) != js_CalculaDV(NI.substr(0,12), 9)){
        alert('O número do CNPJ informado está incorreto');
        cNI.select();
        cNI.focus();
        return(false);
        }
      break;

    case 2:

        if (NI.length != 11){
        alert('O número do CPF informado está incorreto');
        cNI.select();
        cNI.focus();
        return(false);
        }

      if (NI.substr(9,2) != js_CalculaDV(NI.substr(0,9), 11)){
        alert('O número do CPF informado está incorreto');
        cNI.select();
        cNI.focus();
        return(false);
        }
      break;

    default:
      return(false);
    }
  return (true);
  }
/////////////////////////////////////////////////////////////////

function js_verificaCGCCPF(obcgc){
//#01#//js_verificaCGCCPF
//#10#//Funcao para verificar se o CNPJ ou CPF são válidos
//#15#//js_verificaCGCCPF(obcgc);
//#20#//objcgc : Objeto que esta utilizando a função
//#30#//Retorna false quando não esta no formato ou true se estiver correto
//#99#//A função verifica pelo tamanho da string passada, caso 14 testa cnpj ou 11 testa cpf senão mostra erro
 if (obcgc.value.length == 14){
    return js_TestaNI(obcgc,1);
 }else if (obcgc.value.length == 11){
    return js_TestaNI(obcgc,2);
 }
 if(obcgc.value!=""){
   alert('Valor Informado não é Válido para CNPJ ou CPF.');
   obcgc.select();
   obcgc.focus();
 }
 return false;
}

function js_CalculaDV(sCampo, iPeso){
//#01#//js_CalculaDV
//#10#//Funcao para calcular o digito verificador de uma sequencia de números
//#15#//js_CalculaDV(sCampo, iPeso);
//#20#//sCampo : Sequencia de Números sem o digito
//#20#//iPeso  : Qual o peso que utilizará para cálculo, 11, 10 ou outro
//#30#//Retorna o digito calculado

        var iTamCampo;
  var iPosicao, iDigito;
  var iSoma1 = 0;
  var iSoma2=0;
  var iDV1, iDV2;
  iTamCampo = sCampo.length;
  for (iPosicao=1; iPosicao<=iTamCampo; iPosicao++){
    iDigito = sCampo.substr(iPosicao-1, 1);
    iSoma1 = parseInt(iSoma1,10) + parseInt((iDigito * js_Calcular_Peso(iTamCampo - iPosicao, iPeso)),10);
    iSoma2 = parseInt(iSoma2,10) + parseInt((iDigito * js_Calcular_Peso(iTamCampo - iPosicao + 1, iPeso)),10);
  }
  iDV1 = 11 - (iSoma1 % 11);
  if (iDV1 > 9)
    iDV1 = 0;
  iSoma2 = iSoma2 + (iDV1 * 2);
  iDV2 = 11 - (iSoma2 % 11);
  if (iDV2 > 9)
    iDV2 = 0;
  Ret = (parseInt(iDV1 * 10,10) + parseInt(iDV2));
  Ret = "0" + Ret;
  Ret = Ret.substr(Ret.length - 2,Ret.length);
  return(Ret);
}
function js_Calcular_Peso(iPosicao, iPeso){
//Pesos
//CPF 11
//CNPJ 9
return (iPosicao % (iPeso - 1)) + 2;
}
/////////////////////////////////////////////////////////////////


controlaMenuModulos = 1;
function someFrame(evt) {

  evt = (evt) ? evt : (window.event) ? window.event : "";
  if(!document.getElementById('menuSomeTela')) {
    var menu = new Object();
  if(controlaMenuModulos) {
      menu.innerHTML = "Tela";
    controlaMenuModulos = 0;
  } else {
    menu.innerHTML = "Abre";
    controlaMenuModulos = 1;
  }
  } else
    var menu = document.getElementById('menuSomeTela');

  if(evt.keyCode == 113 || someFrame.arguments[1] == 1) {
    if(menu.innerHTML == "Tela") {

      oElement = top.frames.document.getElementById("quadroprincipal");

      oElement.setAttribute("original-size", oElement.rows);
      oElement.rows = "0,*,19";

      menu.innerHTML = "Abre";
    } else {

      oElement = top.frames.document.getElementById("quadroprincipal");

      oElement.rows = oElement.getAttribute("original-size");
      menu.innerHTML = "Tela";
    }
  }
  if(evt.keyCode >= 112 && evt.keyCode <= 123)
    return false;
}
if(top.corpo==null){
  location.href='index.php';
}else{
  if(top.corpo.document)
    top.corpo.document.onkeyup = function(event) { someFrame(event); };
}


///// funcoes pra cookies ////////
///para um help destas funcoes, olhe pagina 392 da biblia do javascript
function getCookieVal (offset) {
  var endstr = document.cookie.indexOf (";", offset);
  if (endstr == -1)
    endstr = document.cookie.length;
  return unescape(document.cookie.substring(offset, endstr));
}
function FixCookieDate (date) {
  var base = new Date(0);
  var skew = base.getTime(); // dawn of (Unix) time - should be 0
  if (skew > 0)  // Except on the Mac - ahead of its time
    date.setTime (date.getTime() - skew);
}
function GetCookie (name) {
  var arg = name + "=";
  var alen = arg.length;
  var clen = document.cookie.length;
  var i = 0;
  while (i < clen) {
    var j = i + alen;
    if (document.cookie.substring(i, j) == arg)
      return getCookieVal (j);
  i = document.cookie.indexOf(" ", i) + 1;
    if (i == 0) break;
  }
return null;
}
function SetCookie (name,value,expires,path,domain,secure) {
  document.cookie = name + "=" + escape (value) +
    ((expires) ? "; expires=" + expires.toGMTString() : "") +
    ((path) ? "; path=" + path : "") +
    ((domain) ? "; domain=" + domain : "") +
    ((secure) ? "; secure" : "");
}
function DeleteCookie (name,path,domain) {
  if (GetCookie(name)) {
    document.cookie = name + "=" +
      ((path) ? "; path=" + path : "") +
      ((domain) ? "; domain=" + domain : "") +
      "; expires=Thu, 01-Jan-70 00:00:01 GMT";
  }
}
function js_obj(obj) {
  if(typeof(obj) != "object") {
    alert("O parametro passado, não parece ser um objeto!");
  return false;
  }
  var args = js_obj.arguments;
  var F = (typeof(args[1])=="undefined" || args[1]=="")?5:args[1];
  var temp ="";
  var l = 0;
  var i;
  var x;
  for( i in obj) {
    temp += obj + "   " + i + "  ==> " + obj[i] + "\n";
    if(l++ == F) {
      x = confirm(temp);
    if(x == false)
      break;
    temp = "";
    l = 0;
  }
  }
  return true;
}




// FUNCAO DE VALIDACAOM USADO PELA FUNCAO db_text() do php
//variavel tipo:
// 1 só pode numeros
// 2 só pode letras
// 3 pode numeros, letras, espaço, virgula
// 4 só pode número do tipó ponto flutuante
function js_ValidaCamposText(obj,tipo) {
  // função descontinuada
  if(tipo == 4) {
    var expr = new RegExp("[^0-9\.]+");
    if(obj.value.match(expr)) {
    alert("Este campo deve ser preenchido somente com números decimais!");
    obj.select();
  }
  } else if(tipo == 1) {
    var expr = new RegExp("[^0-9]+");
    if(obj.value.match(expr)) {
    alert("Este campo deve ser preenchido somente com números!");
    obj.select();
  }
  } else if(tipo == 2) {
    var expr = new RegExp("%[^A-Za-zà-úÁ-ÚüÜ]+");
    if(obj.value.match(expr)) {
    alert("Este campo deve ser preenchido somente com Letras!");
    obj.select();
  }
  } else if(tipo == 3) {
    var expr = new RegExp("[^A-Za-z0-9à-úÁ-ÚüÜ \.,;:@&%-\_]+");
  if(obj.value.match(expr)) {
    alert("Este campo deve ser preenchido somente com Letras, números, espaço, virgula, ponto-e-virgula, hífen,2 pontos,arroba,sublinhado!");
    obj.select();
  }
  }
}

/**
 * Esta funlção coloca a letra digitado para maiúsculo e é executada no onkeypres e no onblur dos objetos
 *
 * obj       Element Objeto que será testado
 * maiusculo String  Se maiusculo ou não (t = verdadeiro e f = falso )
 * evt       Event
 */
function js_ValidaMaiusculo(obj,maiusculo,evt) {

  var evt = evt || event || null;
  if (evt.keyCode < 37 || evt.keyCode > 40) {
    if (maiusculo =='t') {
      obj.value.toUpperCase();
    }
  }
}
////////////////////////////////////
function js_ValidaPaste(elemento, tipo, evt) {
  //#01#//js_ValidaPaste
  //#10#//Funcao para validar o conteúdo que está sendo colado no formulário
  //#15#//js_ValidaCampos(obj,tipo,nome,aceitanulo,maiusculo,evt);
  //#20#//objeto      : Nome do objeto do formulário
  //#20#//tipo        : Cõdigo do tipo de consistencia do objeto gerado
  //#20#//              0 - Não consistencia o campo
  //#20#//              1 - Números  = RegExp("[^0-9]+")
  //#20#//              2 - Letras   = RegExp("[^A-Za-zà-úÁ-ÚüÜ %]+")
  //#20#//              3 - Números, Letras, espaço e vírgula = RegExp("[^A-Za-z0-9à-úÁ-ÚüÜ \.,;:@&%-\_]+")
  //#20#//              4 - Números do tipo flutuante (valores monetário ou com casas decimais) = RegExp("[^0-9\.]+")
  //#20#//              5 - Campo deve ser somente falso ou verdadeiro = RegExp("fmFM")
  //#20#//evt         : este parâmetro não deve ser passado para a função, pois é automático do javascript

  evt        = (evt)?evt:(event)?event:'';
  var dados  = evt.clipboardData.getData('text/plain');

  if (tipo == 1) {
    return  /^[0-9]+$/.test(dados);
  } else if (tipo == 2) {
    return  /^[a-z,A-Z,à-ú,Á-ÚüÜ]+$/.test(dados);
  } else  if (tipo == 3) {
    return  /^[A-Z,a-z,0-9,à-ú,Á-ÚüÜ \.,;:@&%-\_]+$/.test(dados);
  } else  if (tipo == 4) {

    if (elemento.value.indexOf('.') !== -1) {
      return false;
    }

    return  /^[0-9\.,-]+/.test(dados);
  } else if (tipo == 5) {
    return  /^[f|F|m|M]+$/.test(dados);
  }

}
////////////////////////////////////
function js_ValidaCampos(obj, tipo, nome, aceitanulo, maiusculo, evt) {


  //#01#//js_ValidaCampos
  //#10#//Funcao para validar o conteúdo do campo quando digitado no formulário
  //#15#//js_ValidaCampos(obj,tipo,nome,aceitanulo,maiusculo,evt);
  //#20#//objeto      : Nome do objeto do formulário
  //#20#//tipo        : Cõdigo do tipo de consistencia do objeto gerado
  //#20#//              0 - Não consistencia o campo
  //#20#//              1 - Números  = RegExp("[^0-9]+")
  //#20#//              2 - Letras   = RegExp("[^A-Za-zà-úÁ-ÚüÜ %]+")
  //#20#//              3 - Números, Letras, espao e vírgula = RegExp("[^A-Za-z0-9à-úÁ-ÚüÜ \.,;:@&%-\_]+")
  //#20#//              4 - Números do tipo flutuante (valores monetário ou com casas decimais) = RegExp("[^0-9\.]+")
  //#20#//              5 - Campo deve ser somente falso ou verdadeiro = RegExp("fmFM")
  //#20#//Nome        : Descrição do campo para mensagem de erro
  //#20#//Aceitanuulo : Se aceita o campo nulo ou não true = aceita false = não aceita
  //#20#//Maiusculo   : Se campo deve ser maiusculo, quando digita a sistema troca para maiusculo
  //#20#//evt         : este parâmetro não deve ser passado para a função, pois é automático do javascript
  if ( typeof(evt) != 'undefined' ){
    evt = (evt) ? evt : (event) ? event : '';
  }

  if (maiusculo =='t') {

    var iPosicaoInicial = obj.selectionStart;
    var iPosicaoFim     = obj.selectionEnd;

    var maiusc = new String(obj.value);
    obj.value  = maiusc.toUpperCase();

    obj.selectionStart = iPosicaoInicial;
    obj.selectionEnd   = iPosicaoFim;
  }

  if (tipo == 1) {
    var expr = new RegExp("[^0-9]+");
    if (obj.value.match(expr)) {
      if (obj.value!= '') {
        obj.disabled = true;
        alert(nome+" deve ser preenchido somente com números!");
        obj.disabled = false;
        obj.value = '';
        obj.focus();
        return false;
      }
    }
  } else if (tipo == 2) {
    var expr = new RegExp("[^A-Za-zà-úÁ-ÚüÜ %]+");
    if (obj.value.match(expr)) {
      obj.disabled = true;
      alert(nome+" deve ser preenchido somente com letras!");
      obj.disabled = false;
      obj.value = '';
      //select();
      obj.focus();
      return false;

    }
  } else if (tipo == 3) {
    var expr = new RegExp("[^A-Za-z0-9à-úÁ-ÚüÜ \.,;:@&%-\_]+");
    if (obj.value.match(expr)) {
      obj.disabled = true;
      alert(nome+" deve ser preenchido somente com letras, números, espaço, vírgula, ponto-e-vírgula, hífen, 2 pontos, arroba, sublinhado!");
      obj.disabled = false;
      obj.value = '';
      //select();
      obj.focus();
      return false;

    }
  } else if (tipo == 4) {
    if( obj.value != '' ) {

      // Verifica ocorrencias de Virgula...

      //... para substituir por Ponto...
      obj.value = obj.value.replace(',', '.');


      // Se existir mais de um ponto...
      if( js_countOccurs(obj.value, '.') > 1 ) {
        // Erro e retorna valor anterior
        alert("Decimal já digitado!");
         obj.value = js_getInputValue(obj.name) || null;
        obj.focus();
        return false;
      }
      var expr = new RegExp("^(-|)([^0-9\.,])+$");


      //if (obj.value.match(expr)) {
      var regDecimal = /^(-|)(|[0-9]+)(|(\.|,)(|[0-9]+))$/;

       if ( !regDecimal.test(obj.value) ) {
        obj.disabled = true;
        alert( nome + " deve ser preenchido somente com números decimais!" );
        obj.disabled = false;
        obj.value = '';
        obj.focus();
        return false;
      }
    }
  } else if (tipo == 5) {
    var expr = new RegExp("fmFM");
    if (obj.value.match(expr)) {
      obj.disabled = true;
      alert(nome+" deve ser preenchido somente com falso ou verdadeiro!");
      obj.disabled = false;
      obj.value = '';
      obj.focus();
      return false;

    }
  }

  js_putInputValue(obj.name, obj.value);
  return true;
}

/*
 * Funções para controle do numero de caracteres permitidos para digitação nos textarea
 */
function js_maxlenghttextarea(elem, event, iLimite){

  var sValorCampo   = new String(elem.value);
  var iTamanhoCampo = sValorCampo.length;

  document.getElementById( elem.id + 'errobar').innerHTML = '';

  if (event.keyCode != 8 && event.keyCode != 16 && event.keyCode != 20 && event.keyCode != 18 && event.keyCode != 46){

    if ( iTamanhoCampo > iLimite ) {

      elem.value = sValorCampo.substr(0,iLimite);
      document.getElementById(elem.id+'errobar').innerHTML = 'Máximo '+iLimite+' caracteres!';
    }
  }

  document.getElementById( elem.id + 'obsdig').value = elem.value.length;
}

/********************************* FUNCOES PARA O NOVO DB_INPUTDATA **********************************/
  function js_validaDbData(obj) {

    var strValor = obj.value;
    if (strValor == '' || strValor == null){
      return false;
    }
    // 01/01/2007
    var Dia = strValor.substr(0,2);
    var Mes = strValor.substr(3,2);
    var Ano = strValor.substr(6,4);

    if ( strValor.substr(2,1) != '/' ) {

      alert("Dia Inválido!");
      obj.value = '';
      obj.select();
      return false;
    }

    var data = new Date(Ano,(Mes-1),Dia);

    if (checkleapyear(Ano)) {
      var fev = 29;
    }else{
      var fev = 28;
    }

    //                  01  02 03 04 05 06 07 08 09 10 11 12
    var dia = new Array(31,fev,31,30,31,30,31,31,30,31,30,31);
    //  var diaexpr = new RegExp("[0-"+(mes==1?2:3)+"][0-9]");
    var diaexpr = new RegExp("[0-3][0-9]");
    if(Dia.match(diaexpr) == null || Dia > dia[Mes-1] || Dia == "00") {
      alert("Dia Inválido!");
      obj.value = '';
//      obj.focus();
      obj.select();
      return false;
    }

    var mesexpr = new RegExp("[01][0-9]");
    if(Mes.match(mesexpr) == null ||  Mes > 12 || Mes == "00") {
      alert("Mês inválido!");
      obj.value = '';
//      obj.focus();
      obj.select();
      return false;
    }

    var anoexpr = new RegExp("[12][0-9][0-9][0-9]");
    if(Ano.match(anoexpr) == null) {
      alert("Ano inválido!");
      obj.value = '';
      obj.select();
      return false;
    }

    return true;

  }


  function js_mascaraData(campo,evt){

    var strAux           = '';
    var tecla            = evt.keyCode;
    var valor            = campo.value;
    var exprLiterais     = new RegExp("[^0-9]+");

    // constante array com o codigo das teclas a serem ignoradas
    const teclasNaoFormatadas = new Array(8,13,35,36,37,38,39,40,45,46);

    valor  = valor.replace(".", ""); // tira ponto "."
    valor  = valor.replace("-", ""); // tira traco "-"
    valor  = valor.replace("/", ""); //
    valor  = valor.replace("/", "");
    valor  = valor.replace("/", "");

    if(tecla == 8 || tecla == 46 ){
      var tmpstr = js_colocaBarras(campo,valor,true);
      return true;
    }

    if (!js_search_in_array(teclasNaoFormatadas,tecla)){
      // tira os caracteres literais
      for(i=0; i < valor.length; i++){
        if(!valor[i].match(exprLiterais)){
          strAux += valor[i];
        }else{
          strAux  = '';
        }
      }
      var dataFinal = js_colocaBarras(campo,strAux,false);

      campo.value = dataFinal;

      var matched = dataFinal.match(/(\d{2})\/(\d{2})\/(\d{4})/);
      if (matched) {
        js_setDiaMesAno(campo, matched[1], matched[2], matched[3]);
      }

      return true;
    }
  }

  /*--------------------------------------------------------------------------------------*/

  function js_colocaBarras(obj,strValor,apagando){

    var strRetorno      = '';
    var strNumDigitados = strValor.length;
    var strRetorno      = '';
    var aValorAnt       =  new String(obj.value).split('/');

    if ( aValorAnt.length > 1 ) {
      if ( aValorAnt.length == 3 ) {
        if ( aValorAnt[0].length < 2 || aValorAnt[1].length < 2 || aValorAnt[2].length < 4 ) {
          return obj.value;
        }
      } else {
        if ( aValorAnt[1].length == 1 ) {
         return obj.value;
        }
      }
    }

    if(!apagando){
      if(strNumDigitados >= 2 && strNumDigitados < 4){
        strRetorno = strValor.substr(0,2)+'/'+strValor.substr(2,strNumDigitados-1);
        js_setDiaMesAno(obj,strValor.substr(0,2),strValor.substr(2,strNumDigitados-1),'');
      }else if(strNumDigitados >= 4 && strNumDigitados < 8){
        var fev        = 29;
        var diaatual   = new Number(strValor.substr(0,2));
        var mesatual   = new Number(strValor.substr(2,2));
        mesatual--;
        //                  01  02 03 04 05 06 07 08 09 10 11 12
        var dia = new Array(31,fev,31,30,31,30,31,31,30,31,30,31);
        if(diaatual > dia[mesatual]) {
          strRetorno = dia[mesatual]+'/'+strValor.substr(2,2)+'/'+strValor.substr(4,strNumDigitados-1);
        }else {
          strRetorno = strValor.substr(0,2)+'/'+strValor.substr(2,2)+'/'+strValor.substr(4,strNumDigitados-1);
        }

        js_setDiaMesAno(obj,strValor.substr(0,2),strValor.substr(2,2),strValor.substr(4,strNumDigitados-1));

      }else if(strNumDigitados == 8){

        var diaatual = new Number(strValor.substr(0,2));
        var mesatual = new Number(strValor.substr(2,2));
        mesatual--;
        if (checkleapyear(strValor.substr(4,4))) {
          var fev = 29;
        }else{
          var fev = 28;
        }

        var dia = new Array(31,fev,31,30,31,30,31,31,30,31,30,31);
        var ano = new Array(31,fev,31,30,31,30,31,31,30,31,30,31);
        if(diaatual > dia[mesatual]) {
          strRetorno = dia[mesatual]+'/'+strValor.substr(2,2)+'/'+strValor.substr(4,4);
        }else {
          strRetorno = strValor.substr(0,2)+'/'+strValor.substr(2,2)+'/'+strValor.substr(4,4);
        }
        js_setDiaMesAno(obj,strValor.substr(0,2),strValor.substr(2,2),strValor.substr(4,4));

      }else{
        return strValor;
      }
      return strRetorno;
    }else{
      if(strNumDigitados <= 2){
        js_setDiaMesAno(obj,strValor.substr(0,strNumDigitados-1),'','');
      }else if(strNumDigitados >= 2 && strNumDigitados < 4){
        js_setDiaMesAno(obj,strValor.substr(0,2),strValor.substr(2,strNumDigitados-1),'');
      }else if(strNumDigitados >= 4 && strNumDigitados < 8){
        js_setDiaMesAno(obj,strValor.substr(0,2),strValor.substr(2,2),strValor.substr(4,strNumDigitados-1));
      }else if(strNumDigitados == 8){
        js_setDiaMesAno(obj,strValor.substr(0,2),strValor.substr(2,2),strValor.substr(4,4));
      }

      return '';
    }
  }

  function js_setDiaMesAutomatico(obj,Dia,Mes){
    var strRetorno = '';
    var fev        = 29;
    var diaatual   = new Number(Dia);
    var mesatual   = new Number(Mes);
    mesatual++;
    //                  01  02 03 04 05 06 07 08 09 10 11 12
    var dia = new Array(31,fev,31,30,31,30,31,31,30,31,30,31);
    if(diaatual > dia[mesatual]) {
      strRetorno = dia[mesatual];
    }
    return strRetorno;
  }

  function js_bloqueiaSelecionar(obj){
    obj.selectionStart = null;
    obj.selectionEnd   = null;
    return false;
  }

  function js_validaEntrada(obj){
  }

  function js_setDiaMesAno(obj,dia,mes,ano){
    // alimenta os hiddens para manter a compatibilidade
    document.getElementById(obj.name+'_dia').value = dia;
    document.getElementById(obj.name+'_mes').value = mes;
    document.getElementById(obj.name+'_ano').value = ano;
  }

/********************************************************************************************************/

////////////////////////////////////
///////////////////////////////////
//FUNCOES PARA A FUNCAO DB_DATA DO PHP. VALIDAM A DATA E PASSA O FOCO PRO OUTRO CAMPO
function js_VerDaTa(nome,Dia,Mes,Ano) {
//#01#//js_VerDaTa
//#10#//Funcões para validar o campo *db_inputdata* e trocar de campo
//#15#//js_VerDaTa(nome,Dia,Mes,Ano);
//#20#//nome   : Objeto que esta sendo testado
//#20#//Dia    : Objeto dia para testar a data
//#20#//Mes    : Objeto mes para testar a data
//#20#//Ano    : Objeto ano para testar a data
  var data        = new Date(Ano,Mes,Dia);
  var F           = document.form1;
  var str         = new String(F.elements[nome].value);
  var strPartTipo = nome.substr((nome.length-4),4);

  if(strPartTipo == "_dia") {
    var mes = data.getMonth();
    mes += 1;
    var expr = new RegExp("[0-"+(mes==1?2:3)+"][0-9]");
    //                  01 02 03 04 05 06 07 08 09 10 11 12
    var dia = new Array(31,28,31,30,31,30,31,31,30,31,30,31);

    if(str.match(expr) == null || str > 31 || str == "00") {
      alert("Dia Inválido!");
      F.elements[nome].select();
      return false;
    } else
      return true;
  } else if(strPartTipo == "_mes") {
    var expr = new RegExp("[01][0-9]");
    if(str.match(expr) == null || str > 12 || str == 00) {
      alert("Mes inválido");
      F.elements[nome].select();
      return false;
    } else
      return true;
  } else if(strPartTipo == "_ano")  {
    var expr = new RegExp("[12][0-9][0-9][0-9]");
    if(str.match(expr) == null) {
      alert("Ano inválido");
      F.elements[nome].select();
      return false;
    } else
      return true;
  } else
    alert("Erro fatal na função de verificação de datas!!!!");
}

ContrlDigitos = 0;
function js_getIndex(F,nome) {
  for(var i = 0;i < F.elements.length;i++)
    if(F.elements[i].name == nome) {
      var index = i;
      break;
    }
  return index;
}
function js_Passa(nome,Dia,Mes,Ano,evt) {
  var evt = (evt) ? evt : (window.event) ? window.event : "";
  var F = document.form1;
  var index = -1;
  if(evt.keyCode == 37) {
    index = js_getIndex(F,nome) - 1;

  } else if(evt.keyCode == 39) {
    index = js_getIndex(F,nome) + 1;
  } else if(++ContrlDigitos >= F.elements[nome].size && F.elements[nome].value.length == F.elements[nome].size && js_VerDaTa(nome,Dia,Mes,Ano) == true) {
    ContrlDigitos = 0;
    index = js_getIndex(F,nome) + 1;
  }

  if(index != -1) {
    try {
      F.elements[index].select();
    } catch(e) {
      F.elements[index].focus();
    }
  }
}
/////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////


//verifica se o elemento existe no array
function js_in_array(elem,vetor) {
  js_search_in_array(vetor,elem);
}

//tipo o parse int, só que pega o numero se tiver na final da straing tb!!
function js_parse_int(str) {
  var num = new Array("0","1","2","3","4","5","6","7","8","9");
  var tam = str.length;
  var aux = "";
  for(var i = 0;i < tam;i++) {
    if(js_search_in_array(num,str.substr(i,1)))
    aux += str.substr(i,1);
  }
  return aux;
}

//funcao para a funcao db_getfile() do php.
//pega o caminho na variavel nome e bota o seu basename no campo seguinte.
function js_preencheCampo(nome,campo) {
  var ind = (nome.lastIndexOf('\\') == -1?nome.lastIndexOf('/'):nome.lastIndexOf('\\'));
  ind += 1;
  var valor = "";
  var aux = new String(nome.substr(ind));
  for(var i = 0; i < aux.length;i++)
    if(aux.substr(i,1) == " ")
    valor += "_";
  else
    valor += aux.substr(i,1);
  document.form1.elements[campo].value = valor;
}

//Abre uma janela com valores, e retorna o selecionado
//Parametros:
//0 nome da lista(arquivo)
//1 algum parametro opcional
//2 posicao X da janela
//3 posicao Y da janela
//4 largura da janela
//5 altura da janela
function js_lista() {
  var args = js_lista.arguments;
  var X = (typeof(args[3])=="undefined" || args[3]=="")?100:args[3];
  var Y = (typeof(args[4])=="undefined" || args[4]=="")?100:args[4];
  var W = (typeof(args[5])=="undefined" || args[5]=="")?400:args[5];
  var E = (typeof(args[6])=="undefined" || args[6]=="")?420:args[6];
  jan = window.open(args[0] + '?arg=' + args[1] + '&campo=' + args[2],'','width='+W+',height='+E+',location=0,scrollbars=1,resizable=1');
  jan.moveTo(X,Y);
}
function js_lista_blur() {
  var args = js_lista_blur.arguments;
  if(document.form1.elements['db_' + args[2]].value != '' && document.form1.elements['db_' + args[8]].value != '' ){
    document.form1.elements['db_' + args[2]].value = '';
  document.form1.elements['db_' + args[8]].value = '';
  return false;
  }
  var X = (typeof(args[3])=="undefined" || args[3]=="")?100:args[3];
  var Y = (typeof(args[4])=="undefined" || args[4]=="")?100:args[4];
  var W = (typeof(args[5])=="undefined" || args[5]=="")?400:args[5];
  var E = (typeof(args[6])=="undefined" || args[6]=="")?420:args[6];
  var L = (typeof(args[9])=="undefined")?"":args[9];
  jan = window.open(args[0] + '?arg=' + document.form1.elements['db_' + args[2]].value + '&campo=' + args[2] +'&argaux=' + document.form1.elements['db_' + args[8]].value + '&campoaux=' + args[8] + '&lista=' + L ,'','width='+W+',height='+E+',location=0,scrollbars=1,resizable=1');
  jan.moveTo(X,Y);
}

///Pega o indice do campo e passa o foco pro campo seguinte
function js_Ipassacampo() {
  if(document.forms[0]) {
    for(var i = 0;i < document.forms[0].elements.length;i++)
      document.forms[0].elements[i].onkeyup = js_passacampo;
  }
}
function js_passacampo(evt) {
  evt = (evt) ? evt : (window.event) ? window.event : "";
  if(evt.keyCode == 13) {
    var campo = (evt.srcElement)?evt.srcElement.name:evt.target.name;
    for(var i = 0;i < document.forms[0].elements.length;i++) {
    if(document.forms[0].elements[i].name == campo) {
      var indice = i + 1;
    break;
    }
  }
  document.forms[0].elements[indice].focus();
  }
}
//window.onload=js_Ipassacampo;
///////////////////////////////////////////////

//Cria uma mensagem na barra de status.
function js_msg_status(msg) {
//#01#//js_msg_status
//#10#//Funcão para alterar a descrição da barra de status
//#15#//js_msg_status(msg);
//#20#//msg   : Mensagem para a barra de status
  parent.bstatus.document.getElementById('st').innerHTML = '&nbsp;&nbsp;' + msg;
}
//Limpa a barra de status.
function js_lmp_status() {
//#01#//js_lmp_status
//#10#//funcão para limpar a descrição da barra de status
//#15#//js_lmp_status();
  parent.bstatus.document.getElementById('st').innerHTML = '&nbsp;&nbsp;';
}

//Cria uma mensagem na barra de status.
function js_msg_status_data(msg) {
//#01#//js_msg_status_data
//#10#//Funcão para alterar a data da barra de status
//#15#//js_msg_status_data(msg);
//#20#//msg   : Mensagem para a  data da barra de status
  parent.bstatus.document.getElementById('dthr').innerHTML = '&nbsp;&nbsp;' + msg;
}
//Limpa a barra de status.
function js_lmp_status_data() {
//#01#//js_lmp_status_data
//#10#//Funcão para limpar a data da barra de status
//#15#//js_lmp_status_data();
  parent.bstatus.document.getElementById('dthr').innerHTML = '&nbsp;&nbsp;';
}

//pesquisa uma string dentro de um campo select
//para usar, use:
//<input name="procura" type="text" id="procura" onKeyUp="js_pesquisa(this.value.toLowerCase(),document.form1.itens)" size="35">
function js_pesquisa(arg,obj,evt) {
//#01#//js_pesquisa
//#10#//Funcão para pesquisar em um select uma determinada descrição
//#15#//js_pesquisa(arg,obj,evt);
//#20#//argumento : Texto do campo do select que será pesquisado
//#20#//objeto    : Objeto que será pesquisado
//#20#//evt       : Este parâmetro é automático no javascript e não deve ser passado para a função - Evento
//#30#//Posiciona o select no elemento que conter a descrição digitada
//#99#//Esta função deve ser utilizada na propriedade onkeyup do objeto input que esta a descricao
  evt = (evt) ? evt : (window.event) ? window.event : "";
  var tecla = evt.keyCode;
  var F = obj;
  if(tecla == 38 || tecla == 40)
    F.focus();
  else {
    var tamvet = F.length;
    var tamarg = arg.length;
    for(var i = 0;i < tamvet;i++) {
      var texto = F.options[i].text.toLowerCase();
      var ajuda = new String(F.options[i].value.substr(F.options[i].value.search('##') + 2));
    ///// gambiarra pra pegar uma substring, porque o search não acha o ||
    aux = "";
    for(var j = 0;j < ajuda.length;j++) {
      if(ajuda.substr(j,1) != '|')
      aux += ajuda.substr(j,1);
    else
      break;
    }
    ajuda = aux;
    /////
      if(arg.substr(0,tamarg) == texto.substr(0,tamarg)) {
      F.options[i].selected = true;
      js_msg_status(ajuda);
      break;
    }
    }
  }
}

function js_trocacordeselect() {
//#01#//js_trocacordeselect
//#10#//Funcão para trocar a cor dos select do formulário para as cores padrões do sistema
//#15#//js_trocacordeselect();
//#99#//Esta função deve ser utilizada na propriedade onload do objeto body do formulário
  if(document.form1) {
    var CorF1 = "#F8EC07";
    for(i = 0;i < document.form1.elements.length;i++) {
    var str = new String(document.form1.elements[i].type);
      if(str.indexOf("select-") != -1) {
      for(j = 0;j < document.form1.elements[i].length;j++) {
        document.form1.elements[i].options[j].style.backgroundColor = CorF1 = (CorF1=="#D7CC06"?"#F8EC07":"#D7CC06");
        }
    }
    }
  }
}

/*
function js_Calcular_Peso(iPosicao, iPeso) {
  return (iPosicao % (iPeso - 1)) + 2;
}


function js_CalculaDV(sCampo, iPeso){

  var iTamCampo;
  var iPosicao, iDigito;
  var iSoma1 = 0;
  var iSoma2=0;
  var iDV1, iDV2;

  iTamCampo = sCampo.length;

  for (iPosicao=1; iPosicao<=iTamCampo; iPosicao++){
    iDigito = sCampo.substr(iPosicao-1, 1);
    iSoma1 = parseInt(iSoma1,10) + parseInt((iDigito * js_Calcular_Peso(iTamCampo - iPosicao, iPeso)),10);
    iSoma2 = parseInt(iSoma2,10) + parseInt((iDigito * js_Calcular_Peso(iTamCampo - iPosicao + 1, iPeso)),10);
    }

  iDV1 = 11 - (iSoma1 % 11);
  if (iDV1 > 9)
    iDV1 = 0;

  iSoma2 = iSoma2 + (iDV1 * 2);
  iDV2 = 11 - (iSoma2 % 11);
  if (iDV2 > 9)
    iDV2 = 0;

  Ret = (parseInt(iDV1 * 10,10) + parseInt(iDV2));

  Ret = "0" + Ret;
  Ret = Ret.substr(Ret.length - 2,Ret.length);

  return(Ret);
}
*/
// funcao de data
// onclick="show_calendar('form1.calend1')"
var weekend = [0,6];
var weekendColor = "#e0e0e0";
var fontface = "Verdana";
var fontsize = 1;


var img_esq = "/workflow/images/seta_esq.gif";
var img_dir = "/workflow/images/seta_dir.gif";

var gNow = new Date();
var ggWinCal;
isNav = (navigator.appName.indexOf("Netscape") != -1) ? true : false;
isIE = (navigator.appName.indexOf("Microsoft") != -1) ? true : false;

Calendar.Months = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
"Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];

//dias finais de cada mes
Calendar.DOMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
// anos bissestos
Calendar.lDOMonth = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

function Calendar(p_item, p_WinCal, p_month, p_year, p_format) {

  if ((p_month == null) && (p_year == null))  return;

  if (p_WinCal == null)
    this.gWinCal = ggWinCal;
  else
    this.gWinCal = p_WinCal;

  if (p_month == null) {
    this.gMonthName = null;
    this.gMonth = null;
    this.gYearly = true;
  } else {
    this.gMonthName = Calendar.get_month(p_month);
    this.gMonth = new Number(p_month);
    this.gYearly = false;
  }

  this.gYear = p_year;
  this.gFormat = p_format;
  this.gBGColor = "white";
  this.gFGColor = "black";
  this.gTextColor = "black";
  this.gHeaderColor = "black";
  this.gReturnItem = p_item;
}

Calendar.get_month = Calendar_get_month;
Calendar.get_daysofmonth = Calendar_get_daysofmonth;
Calendar.calc_month_year = Calendar_calc_month_year;
Calendar.print = Calendar_print;

function Calendar_get_month(monthNo) {
    return Calendar.Months[monthNo];
}

function Calendar_get_daysofmonth(monthNo, p_year) {
  if ((p_year % 4) == 0) {
    if ((p_year % 100) == 0 && (p_year % 400) != 0)
      return Calendar.DOMonth[monthNo];

    return Calendar.lDOMonth[monthNo];
  } else
    return Calendar.DOMonth[monthNo];
}

function Calendar_calc_month_year(p_Month, p_Year, incr) {
  var ret_arr = new Array();

  if (incr == -1) {
    // B A C K W A R D
    if (p_Month == 0) {
      ret_arr[0] = 11;
      ret_arr[1] = parseInt(p_Year) - 1;
    }
    else {
      ret_arr[0] = parseInt(p_Month) - 1;
      ret_arr[1] = parseInt(p_Year);
    }
  } else if (incr == 1) {
    // F O R W A R D
    if (p_Month == 11) {
      ret_arr[0] = 0;
      ret_arr[1] = parseInt(p_Year) + 1;
    }
    else {
      ret_arr[0] = parseInt(p_Month) + 1;
      ret_arr[1] = parseInt(p_Year);
    }
  }

  return ret_arr;
}

function Calendar_print() {
  ggWinCal.print();
}

function Calendar_calc_month_year(p_Month, p_Year, incr) {
  var ret_arr = new Array();

  if (incr == -1) {
    // B A C K W A R D
    if (p_Month == 0) {
      ret_arr[0] = 11;
      ret_arr[1] = parseInt(p_Year) - 1;
    }
    else {
      ret_arr[0] = parseInt(p_Month) - 1;
      ret_arr[1] = parseInt(p_Year);
    }
  } else if (incr == 1) {
    // F O R W A R D
    if (p_Month == 11) {
      ret_arr[0] = 0;
      ret_arr[1] = parseInt(p_Year) + 1;
    }
    else {
      ret_arr[0] = parseInt(p_Month) + 1;
      ret_arr[1] = parseInt(p_Year);
    }
  }

  return ret_arr;
}

new Calendar();

Calendar.prototype.getMonthlyCalendarCode = function() {
  var vCode = "";
  var vHeader_Code = "";
  var vData_Code = "";

  // Begin Table Drawing code here..
  vCode = vCode + "<TABLE BORDER=0 BGCOLOR=\"" + this.gBGColor + "\">";

  vHeader_Code = this.cal_header();
  vData_Code = this.cal_data();
  vCode = vCode + vHeader_Code + vData_Code;

  vCode = vCode + "</TABLE>";

  return vCode;
}

Calendar.prototype.show = function() {
  var vCode = "";

  this.gWinCal.document.open();



  this.wwrite("<html>");
  this.wwrite("<head><title>Calendar</title>");
  this.wwrite("</head>");

  this.wwrite("<body marginwidth=0 marginheight=0 topmargin=0 leftmargin=0 " +
    "link=\"" + this.gLinkColor + "\" " +
    "vlink=\"" + this.gLinkColor + "\" " +
    "alink=\"" + this.gLinkColor + "\" " +
    "text=\"" + this.gTextColor + "\">");
  this.wwriteA("<FONT FACE='" + fontface + "' size=1><B>");
  //this.wwriteA(this.gMonthName + " " + this.gYear);
  this.wwriteA("</B>");

  // Show navigation buttons
  var prevMMYYYY = Calendar.calc_month_year(this.gMonth, this.gYear, -1);
  var prevMM = prevMMYYYY[0];
  var prevYYYY = prevMMYYYY[1];

  var nextMMYYYY = Calendar.calc_month_year(this.gMonth, this.gYear, 1);
  var nextMM = nextMMYYYY[0];
  var nextYYYY = nextMMYYYY[1];

  this.wwrite("<TABLE WIDTH='100%' BORDER=0 CELLSPACING=2 CELLPADDING=0 ><TR><TD ALIGN=center>");

  this.wwrite("<A HREF=\"" +
    "javascript:parent.Build(" +
    "'" + this.gReturnItem + "', '" + this.gMonth + "', '" + (parseInt(this.gYear)-1) + "', '" + this.gFormat + "'" +
    ");" +
    "\"> &lt;&lt; ");
  this.wwrite("<FONT FACE='" + fontface + "' size=1><B>" + this.gYear);
  this.wwrite("<A HREF=\"" +
    "javascript:parent.Build(" +
    "'" + this.gReturnItem + "', '" + this.gMonth + "', '" + (parseInt(this.gYear)+1) + "', '" + this.gFormat + "'" +
    ");" +
    "\"> &gt;&gt; <\/A></TD></TR><tr><td align=center>");

  this.wwrite("<A HREF=\"" +
    "javascript:parent.Build(" +
    "'" + this.gReturnItem + "', '" + prevMM + "', '" + prevYYYY + "', '" + this.gFormat + "'" +
    ");" +
    "\"> &lt;&lt; <\/A>");
  this.wwrite("<FONT FACE='" + fontface + "' size=1><B>" +this.gMonthName);
  this.wwrite("<A HREF=\"" +
    "javascript:parent.Build(" +
    "'" + this.gReturnItem + "', '" + nextMM + "', '" + nextYYYY + "', '" + this.gFormat + "'" +
    ");" +
    "\"> &gt;&gt; <\/A></TD></tr><table>");


  // Get the complete calendar code for the month..
  vCode = this.getMonthlyCalendarCode();
  this.wwrite(vCode);

  this.wwrite("</font>");

  this.wwrite("</body></html>");

  this.gWinCal.document.close();
}

Calendar.prototype.showY = function() {
  var vCode = "";
  var i;
  var vr, vc, vx, vy;   // Row, Column, X-coord, Y-coord
  var vxf = 285;      // X-Factor
  var vyf = 200;      // Y-Factor
  var vxm = 10;     // X-margin
  var vym;        // Y-margin
  if (isIE) vym = 75;
  else if (isNav) vym = 25;

  this.gWinCal.document.open();

  this.wwrite("<html>");
  this.wwrite("<head><title>Calendar</title>");
  this.wwrite("<style type='text/css'>\n<!--");
  for (i=0; i<12; i++) {
    vc = i % 3;
    if (i>=0 && i<= 2)  vr = 0;
    if (i>=3 && i<= 5)  vr = 1;
    if (i>=6 && i<= 8)  vr = 2;
    if (i>=9 && i<= 11) vr = 3;

    vx = parseInt(vxf * vc) + vxm;
    vy = parseInt(vyf * vr) + vym;

    this.wwrite(".lclass" + i + " {position:absolute;top:" + vy + ";left:" + vx + ";}");
  }
  this.wwrite("-->\n</style>");
  this.wwrite("</head>");

  this.wwrite("<body " +
    "link=\"" + this.gLinkColor + "\" " +
    "vlink=\"" + this.gLinkColor + "\" " +
    "alink=\"" + this.gLinkColor + "\" " +
    "text=\"" + this.gTextColor + "\">");
  this.wwrite("<FONT FACE='" + fontface + "' SIZE=2><B>");
  this.wwrite("Year : " + this.gYear);
  this.wwrite("</B><BR>");

  // Show navigation buttons
  var prevYYYY = parseInt(this.gYear) - 1;
  var nextYYYY = parseInt(this.gYear) + 1;

  this.wwrite("<TABLE WIDTH='100%' BORDER=1 CELLSPACING=0 CELLPADDING=0 BGCOLOR='#e0e0e0'><TR><TD ALIGN=center>");
  this.wwrite("[<A HREF=\"" +
    "javascript:parent.Build(" +
    "'" + this.gReturnItem + "', null, '" + prevYYYY + "', '" + this.gFormat + "'" +
    ");" +
    "\" alt='Prev Year'><<<\/A>]</TD><TD ALIGN=center>");
  this.wwrite("[<A HREF=\"javascript:window.print();\">Print</A>]</TD><TD ALIGN=center>");
  this.wwrite("[<A HREF=\"" +
    "javascript:parent.Build(" +
    "'" + this.gReturnItem + "', null, '" + nextYYYY + "', '" + this.gFormat + "'" +
    ");" +
    "\">>><\/A>]</TD></TR></TABLE><BR>");

  // Get the complete calendar code for each month..
  var j;
  for (i=11; i>=0; i--) {
    if (isIE)
      this.wwrite("<DIV ID=\"layer" + i + "\" CLASS=\"lclass" + i + "\">");
    else if (isNav)
      this.wwrite("<LAYER ID=\"layer" + i + "\" CLASS=\"lclass" + i + "\">");

    this.gMonth = i;
    this.gMonthName = Calendar.get_month(this.gMonth);
    vCode = this.getMonthlyCalendarCode();
    this.wwrite(this.gMonthName + "/" + this.gYear + "<BR>");
    this.wwrite(vCode);

    if (isIE)
      this.wwrite("</DIV>");
    else if (isNav)
      this.wwrite("</LAYER>");
  }

  this.wwrite("</font><BR></body></html>");
  this.gWinCal.document.close();
}

Calendar.prototype.wwrite = function(wtext) {
  this.gWinCal.document.writeln(wtext);
}

Calendar.prototype.wwriteA = function(wtext) {
  this.gWinCal.document.write(wtext);
}

Calendar.prototype.cal_header = function() {
  var vCode = "";

  vCode = vCode + "<TR><CENTER>";

    vCode = vCode +
              "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<FONT SIZE='1' FACE='" + fontface + "'>" +
        "<A HREF='#' " +
          "onClick=\"parent.document." +
          this.gReturnItem +
          "_dia.value='';parent.document." +
          this.gReturnItem +
          "_mes.value='';parent.document." +
          this.gReturnItem +
          "_ano.value='';parent.DataJavaScript.hide();return false\">" +'Zera Data' +
        "</A>" +
        "</FONT>";

  vCode = vCode + "</CENTER></TR>";

  vCode = vCode + "<TR>";
  vCode = vCode + "<TD WIDTH='14%'><FONT SIZE='1' FACE='" + fontface + "' COLOR='" + this.gHeaderColor + "'><B>D</B></FONT></TD>";
  vCode = vCode + "<TD WIDTH='14%'><FONT SIZE='1' FACE='" + fontface + "' COLOR='" + this.gHeaderColor + "'><B>S</B></FONT></TD>";
  vCode = vCode + "<TD WIDTH='14%'><FONT SIZE='1' FACE='" + fontface + "' COLOR='" + this.gHeaderColor + "'><B>T</B></FONT></TD>";
  vCode = vCode + "<TD WIDTH='14%'><FONT SIZE='1' FACE='" + fontface + "' COLOR='" + this.gHeaderColor + "'><B>Q</B></FONT></TD>";
  vCode = vCode + "<TD WIDTH='14%'><FONT SIZE='1' FACE='" + fontface + "' COLOR='" + this.gHeaderColor + "'><B>Q</B></FONT></TD>";
  vCode = vCode + "<TD WIDTH='14%'><FONT SIZE='1' FACE='" + fontface + "' COLOR='" + this.gHeaderColor + "'><B>S</B></FONT></TD>";
  vCode = vCode + "<TD WIDTH='16%'><FONT SIZE='1' FACE='" + fontface + "' COLOR='" + this.gHeaderColor + "'><B>S</B></FONT></TD>";
  vCode = vCode + "</TR>";

  return vCode;
}

Calendar.prototype.cal_data = function() {
  var vDate = new Date();
  vDate.setDate(1);
  vDate.setMonth(this.gMonth);
  vDate.setFullYear(this.gYear);

  var vFirstDay=vDate.getDay();
  var vDay=1;
  var vLastDay=Calendar.get_daysofmonth(this.gMonth, this.gYear);
  var vOnLastDay=0;
  var vCode = "";

  /*
  Get day for the 1st of the requested month/year..
  Place as many blank cells before the 1st day of the month as necessary.
  */

  vCode = vCode + "<TR>";
  for (i=0; i<vFirstDay; i++) {
    vCode = vCode + "<TD WIDTH='14%'" + this.write_weekend_string(i) + "><FONT SIZE='1' FACE='" + fontface + "'> </FONT></TD>";
  }

  // Write rest of the 1st week
  for (j=vFirstDay; j<7; j++) {
    vCode = vCode + "<TD WIDTH='14%'" + this.write_weekend_string(j) + "><FONT SIZE='1' FACE='" + fontface + "'>" +
      "<A HREF='#' " +
          "onClick=\"parent.document." + this.gReturnItem + "_dia.value='" +  this.format_data(vDay,'d') +          "';parent.document." + this.gReturnItem + "_mes.value='" + this.format_data(vDay,'m') +         "';parent.document." + this.gReturnItem + "_ano.value='" +  this.format_data(vDay,'y') +          "';parent.DataJavaScript.hide();return false\">" +        this.format_day(vDay) +
      "</A>" +
      "</FONT></TD>";
    vDay=vDay + 1;
  }
  vCode = vCode + "</TR>";

  // Write the rest of the weeks
  for (k=2; k<7; k++) {
    vCode = vCode + "<TR>";

    for (j=0; j<7; j++) {
      vCode = vCode + "<TD WIDTH='14%'" + this.write_weekend_string(j) + "><FONT SIZE='1' FACE='" + fontface + "'>" +
        "<A HREF='#' " +
          "onClick=\"parent.document." + this.gReturnItem + "_dia.value='" +  this.format_data(vDay,'d') +          "';parent.document." + this.gReturnItem + "_mes.value='" + this.format_data(vDay,'m') +         "';parent.document." + this.gReturnItem + "_ano.value='" +  this.format_data(vDay,'y') +          "';parent.DataJavaScript.hide();return false\">" +        this.format_day(vDay) +
        "</A>" +
        "</FONT></TD>";
      vDay=vDay + 1;

      if (vDay > vLastDay) {
        vOnLastDay = 1;
        break;
      }
    }

    if (j == 6)
      vCode = vCode + "</TR>";
    if (vOnLastDay == 1)
      break;
  }

  // Fill up the rest of last week with proper blanks, so that we get proper square blocks
  for (m=1; m<(7-j); m++) {
    if (this.gYearly)
      vCode = vCode + "<TD WIDTH='14%'" + this.write_weekend_string(j+m) +
      "><FONT SIZE='1' FACE='" + fontface + "' COLOR='gray'> </FONT></TD>";
    else
      vCode = vCode + "<TD WIDTH='14%'" + this.write_weekend_string(j+m) +
      "><FONT SIZE='1' FACE='" + fontface + "' COLOR='gray'>" + m + "</FONT></TD>";
  }


  return vCode;
}

Calendar.prototype.format_day = function(vday) {
  var vNowDay = gNow.getDate();
  var vNowMonth = gNow.getMonth();
  var vNowYear = gNow.getFullYear();

  if (vday == vNowDay && this.gMonth == vNowMonth && this.gYear == vNowYear)
    return ("<FONT COLOR=\"RED\"><B>" + vday + "</B></FONT>");
  else
    return (vday);
}

Calendar.prototype.write_weekend_string = function(vday) {
  var i;

  // Return special formatting for the weekend day.
  for (i=0; i<weekend.length; i++) {
    if (vday == weekend[i])
      return (" BGCOLOR=\"" + weekendColor + "\"");
  }

  return "";
}

Calendar.prototype.format_data = function(p_day,qual) {
  var vData;
  var vMonth = 1 + this.gMonth;
  vMonth = (vMonth.toString().length < 2) ? "0" + vMonth : vMonth;
  var vMon = Calendar.get_month(this.gMonth).substr(0,3).toUpperCase();
  var vFMon = Calendar.get_month(this.gMonth).toUpperCase();
  var vY4 = new String(this.gYear);
  var vY2 = new String(this.gYear.substr(2,2));
  var vDD = (p_day.toString().length < 2) ? "0" + p_day : p_day;

    if(qual =='d'){
    return vDD;
  }else if(qual == 'm'){
    return vMonth ;
  }else if(qual == 'y'){
    return vY4;
  }else{
  switch (this.gFormat) {
    case "MM\/DD\/YYYY" :
      vData = vMonth + "\/" + vDD + "\/" + vY4;
      break;
    case "MM\/DD\/YY" :
      vData = vMonth + "\/" + vDD + "\/" + vY2;
      break;
    case "MM-DD-YYYY" :
      vData = vMonth + "-" + vDD + "-" + vY4;
      break;
    case "MM-DD-YY" :
      vData = vMonth + "-" + vDD + "-" + vY2;
      break;

    case "DD\/MON\/YYYY" :
      vData = vDD + "\/" + vMon + "\/" + vY4;
      break;
    case "DD\/MON\/YY" :
      vData = vDD + "\/" + vMon + "\/" + vY2;
      break;
    case "DD-MON-YYYY" :
      vData = vDD + "-" + vMon + "-" + vY4;
      break;
    case "DD-MON-YY" :
      vData = vDD + "-" + vMon + "-" + vY2;
      break;

    case "DD\/MONTH\/YYYY" :
      vData = vDD + "\/" + vFMon + "\/" + vY4;
      break;
    case "DD\/MONTH\/YY" :
      vData = vDD + "\/" + vFMon + "\/" + vY2;
      break;
    case "DD-MONTH-YYYY" :
      vData = vDD + "-" + vFMon + "-" + vY4;
      break;
    case "DD-MONTH-YY" :
      vData = vDD + "-" + vFMon + "-" + vY2;
      break;

    case "DD\/MM\/YYYY" :
      vData = vDD + "\/" + vMonth + "\/" + vY4;
      break;
    case "DD\/MM\/YY" :
      vData = vDD + "\/" + vMonth + "\/" + vY2;
      break;
    case "DD-MM-YYYY" :
      vData = vDD + "-" + vMonth + "-" + vY4;
      break;
    case "YYYY-MM-DD" :
      vData = vY4 + "-" + vMonth + "-" + vDD;
      break;
    case "DD-MM-YY" :
      vData = vDD + "-" + vMonth + "-" + vY2;
      break;

    default :
      vData = vMonth + "\/" + vDD + "\/" + vY4;
   }
    }

  return vData;
}

function Build(p_item, p_month, p_year, p_format) {
  var p_WinCal = ggWinCal;
  gCal = new Calendar(p_item, p_WinCal, p_month, p_year, p_format);

  // Customize your Calendar here..
  gCal.gBGColor="white";
  gCal.gLinkColor="black";
  gCal.gTextColor="black";
  gCal.gHeaderColor="darkgreen";

  // Choose appropriate show function
  if (gCal.gYearly) gCal.showY();
  else  gCal.show();
}

function js_JanelaAutomatica(qjanela,qchave,anousu){
//#01#//js_JanelaAutomatica
//#10#//Funcão para gerar uma janela de iframe automática, quando o usuário executa uma consulta pela função *db_lovrot*
//#15#//js_JanelaAutomatica(qjanela,qchave);
//#20#//qjanela : Nome da janela a ser criada
//#20#//          cgm       prot3_conscgm002.php
//#20#//          iptubase  cad3_conscadastro_002.ph
//#20#//          issbase   iss3_consinscr003.php
//#20#//qchave  : Chave de acesso para passar ao programa para ele executar a função e mostrar os dados
//#99#//Esta função deve ser utilizada na propriedade onload do objeto body do formulário
 if (qchave != ''){
  if(qjanela=='cgm'){
    js_OpenJanelaIframe('top.corpo','db_janelaCgm','prot3_conscgm002.php?fechar=top.corpo.db_janelaCgm&numcgm='+qchave,'Dados Cadastrais');
  }
  if(qjanela=='iptubase'){
    js_OpenJanelaIframe('top.corpo','db_janelaIptubase','cad3_conscadastro_002.php?fechar=top.corpo.db_janelaIptubase&cod_matricula='+qchave,'Dados Cadastrais do Imóvel');
  }
  if(qjanela=='issbase'){
    js_OpenJanelaIframe('top.corpo','db_janelaIssbase','iss3_consinscr003.php?fechar=top.corpo.db_janelaIssbase&numeroDaInscricao='+qchave,'Dados Cadastrais do Issqn');
  }
  if(qjanela=='orcdotacao'){
    js_OpenJanelaIframe('top.corpo','db_janelaDotacao','func_saldoorcdotacao.php?fechar=top.corpo.db_janelaDotacao&coddot='+qchave+'&anousu='+anousu,'Dados Cadastrais da Dotação');
  }
  if(qjanela=='orcreceita'){
    js_OpenJanelaIframe('top.corpo','db_janelaReceita','func_saldoorcreceita.php?fechar=top.corpo.db_janelaReceita&codrec='+qchave+'&anousu='+anousu,'Dados Cadastrais da Receita');
  }
  if(qjanela=='empempenho'){
    js_OpenJanelaIframe('top.corpo','db_janelaReceita','func_empempenho001.php?fechar=top.corpo.db_janelaReceita&e60_numemp='+qchave,'Dados Cadastrais do Empenho');
  }
  if(qjanela=='empautoriza'){
    js_OpenJanelaIframe('top.corpo','db_janelaReceita','func_empempenhoaut001.php?fechar=top.corpo.db_janelaReceita&e54_autori='+qchave,'Dados Cadastrais da Autorização');
  }
  if(qjanela=='bem'){
    js_OpenJanelaIframe('top.corpo','db_janelaBem','func_consbens001.php?fechar=top.corpo.db_janelaReceita&t52_bem='+qchave,'Dados Cadastrais do Bem');
  }
  if(qjanela=='matestoquedev'){
     js_OpenJanelaIframe('top.corpo','db_janelamatestoquedev','mat3_consultadevolucao001.php?fechar=top.corpo.db_janelamatestoquedev&codigo='+qchave,'Consulta Devolução',true);
  }
  if(qjanela=='atendrequi'){
     js_OpenJanelaIframe('top.corpo','db_janelaatendrequi','mat3_consultaatendrequi001.php?fechar=top.corpo.db_janelaatendrequi&codigo='+qchave,'Consulta Atendimento',true);
  }
  if(qjanela=='matrequi'){
     js_OpenJanelaIframe('top.corpo','db_janelamatrequi','mat3_consultarequi001.php?fechar=top.corpo.db_janelamatrequi&codigo='+qchave,'Consulta Requisição',true);
  }
  if(qjanela=='matestoqueini'){
     js_OpenJanelaIframe('top.corpo','db_janelamatestoqueni','mat3_matconsultaiframe003.php?fechar=top.corpo.db_janelamatestoqueini&codigo='+qchave,'Consulta Lançamento',true);
  }
  if(qjanela=='empsolicita'){
     js_OpenJanelaIframe('top.corpo','db_janelaempsolicita','com3_conssolic002.php?cons=item&fechar=top.corpo.db_janelaempsolicitai&pc10_numero='+qchave,'Consulta Solicitações',true);
  }

}



}

function js_OpenJanelaIframe(aondeJanela,nomeJanela,arquivoJanela,tituloJanela,mostraJanela,topoJanela,leftJanela,widthJanela,heigthJanela){
//#01#//js_OpenJanelaIframe
//#10#//Funcão para gerar uma janela de iframe automática
//#15#//js_OpenJanelaIframe(aondeJanela,nomeJanela,arquivoJanela,tituloJanela,mostraJanela,topoJanela,leftJanela,widthJanela,heigthJanela);
//#20#//aondeJanela   : Objeto (local) onde será gerada a janela, normalmente "top.corpo"
//#20#//nomeJanela    : Nome do Objeto gerado, objeto que será utilizado para manipulação da janela e dados da janela
//#20#//arquivoJanela : Nome do arquivo com os parâmetros necessários para apresentar no iframe
//#20#//tituloJanela  : Título que será mostrado na janela
//#20#//mostraJanela  : True se janela será apresentada ou false se não for mostrada
//#20#//topoJanela    : Valor da posição em px do topo da janela no formulário que está sendo criada
//#20#//leftJanela    : Valor da posição em px do lado esquerdo da janela iframe
//#20#//widthJanela   : Valor da largura da janela a ser apresentada
//#20#//heigthJanela  : Valor da altura da janela a ser apresentada
//#99#//Os parâmetros obrigatórios são até titulo da janela, ficando os demais com os seguintes valores:
//#99#//mostraJanela = true - se mostra
//#99#//topoJanela   = 20   - posição em relação ao topo do formulário
//#99#//leftJanela   = 1    - posição em relação ao lado esquerdo do formulário
//#99#//widthJanela  = 780  - Largura da janela
//#99#//heigthJanela = 430  - Altera da janela
//#99#//Exemplo:
//#99#//js_OpenJanelaIframe('top.corpo','db_janelaCgm','prot3_conscgm002.php?fechar=top.corpo.db_janelaCgm&numcgm='+qchave,'Dados Cadastrais');
//#99#//
//#99#//Para manipular dados de retorno de uma janela, deverá ser criada função para receber os dados no formulário onde
//#99#//a janela será criada e criado uma variável junto com o parâmetro arquivoJanela indicando qual a função a ser
//#99#//executada, colocando os devidos parâmetros que forem necessários
//#99#//
//#99#//No formulário onde a janela vai ser criada:
//#99#// <script>
//#99#// js_OpenJanelaIframe('top.corpo','db_janelaCgm','[programa].php?js_funcao=parent.js_MINHA_FUNCAO&fechar=top.corpo.db_janelaCgm&numcgm='+qchave,'Dados Cadastrais');
//#99#// function js_MINHA_FUNCAO (codigo) { // Note que foi passado para o programa uma variável js_funcao que será executada dentro do iframe
//#99#//   alert(codigo);
//#99#// }
//#99#// </script>
//#99#//
//#99#//No programa que será executado dentro do iframe:
//#99#// <script>
//#99#// <? // tag php
//#99#// echo $js_funcao."('1')";
//#99#// ?>
//#99#// </script>
//#99#//
//#99#//O resultado deste programa deverá ser um alert na tela com o número 1
//#99#//
//#99#//Funções de manipulação de uma janela iframe:
//#99#// [nome da janela].hide();     - Esconde a janela no formulário
//#99#// [nome da janela].show();     - Mostra a janela no formulário e da foco para ela
//#99#// [nome da janela].mostraMsg() - Mostra a mensagem de processando no centro da janela iframe
//#99#// [nome da janela].focus()     - Passa o foco para esta janela
//#99#// [nome da janela].jan.location.href = 'pagina de programa' - Executa a página dentro do iframe
//#99#// [nome da janela].setTitulo('descricao do titulo') - Troca o título da janela
//#99#// [nome da janela].setAltura('valor') - Altera da janela
//#99#// [nome da janela].setLargura('valor') - Largura da janela
//#99#// [nome da janela].liberarJanBTMinimizar('valor') - True para liberar e false para bloquear o botão minimizar
//#99#// [nome da janela].liberarJanBTMaximizar('valor') - True para liberar e false para bloquear o botão maximizar
//#99#// [nome da janela].liberarJanBTFechar('valor') - True para liberar e false para bloquear o botão fechar

if(mostraJanela==undefined)
    mostraJanela = true;
  if(topoJanela==undefined)
    topoJanela = '20';
  if(leftJanela==undefined)
    leftJanela = '1';
  if(widthJanela==undefined)
    //   widthJanela = '780';
    widthJanela =  screen.availWidth-25;
  if(heigthJanela==undefined)
     heigthJanela = screen.availHeight-150;
    //    heigthJanela = '430';

 // if(eval((aondeJanela!=""?aondeJanela+".":"document.")+nomeJanela)){
  if( document.getElementById('Jan'+nomeJanela) != null ){

    var executa = (aondeJanela!=""?aondeJanela+".":"")+nomeJanela+".jan.location.href = '"+arquivoJanela+"'";
        executa = eval(executa);

  }else{

    var executa = (aondeJanela!=""?aondeJanela+".":"")+"criaJanela('"+nomeJanela+"','"+arquivoJanela+"','"+tituloJanela+"',"+mostraJanela+","+topoJanela+","+leftJanela+","+widthJanela+","+heigthJanela+")";
        executa = eval(executa);

  }

  var oJanela = executa;
  if(mostraJanela==true){

    var executa  = (aondeJanela!=""?aondeJanela+".":"")+nomeJanela+".mostraMsg(0,'white',"+widthJanela+","+heigthJanela+",0,0);";
        executa += (aondeJanela!=""?aondeJanela+".":"")+nomeJanela+".show();";
        executa += (aondeJanela!=""?aondeJanela+".":"")+nomeJanela+".focus();";
        executa  = eval(executa);

  }


  return oJanela;
}


function pegaPosMouse(evt) {
//  evt = (evt) ? evt : (window.event) ? window.event : "NAO DEU CERTO O EVENTO";
  if( typeof(event) != "object" ) {
    PosMouseX = evt.layerX;
    PosMouseY = evt.layerY;
  } else {
    PosMouseX = event.x;
    PosMouseY = event.y;
  }
}


function show_calendar(obj,shutdown_function) {
//#01#//show_calendar
//#10#//Funcão para mostrar o calendário do sistema
//#20#// shutdown_function: função ao ser executada no final da execução do calendário
//#15#//show_calendar()

  if(PosMouseY >= 270)
    PosMouseY = 270;
  if(PosMouseX >= 600)
    PosMouseX = 600;

    js_OpenJanelaIframe('','iframe_data_'+obj,'func_calendario.php?nome_objeto_data='+obj+'&shutdown_function='+shutdown_function,'Calendário',true,PosMouseY,PosMouseX,200,230);

}

function show_calendar_position(obj,shutdown_function,position='') {
//#01#//show_calendar
//#10#//Funcão para mostrar o calendário do sistema
//#20#// shutdown_function: função ao ser executada no final da execução do calendário
//#15#//show_calendar()

  if(PosMouseY >= 270)
    PosMouseY = 270;
  if(PosMouseX >= 600)
    PosMouseX = 600;

  js_OpenJanelaIframe(position,'iframe_data_'+obj,'func_calendario_position.php?nome_objeto_data='+obj+'&shutdown_function='+shutdown_function,'Calendário',true,PosMouseY,PosMouseX+600,200,230);

}

function showCalendarioSaudeTodosDias(obj,shutdown_function, especmed) {

  if(PosMouseY >= 270) {
    PosMouseY = 270;
  }
  if(PosMouseX >= 600){
    PosMouseX = 600;
  }

  js_OpenJanelaIframe('','iframe_data_'+obj,'func_agendamedica.php?nome_objeto_data='+obj+'&shutdown_function='+shutdown_function+'&sd27_i_codigo='+especmed+'&fechar=true','Calendário Agendamento',true,PosMouseY,PosMouseX,400,270);

}


function show_calendar_javascript() {
//#01#//show_calendar
//#10#//Funcão para mostrar o calendário do sistema
//#15#//show_calendar()
  if(PosMouseY >= 270)
    PosMouseY = 270;
  if(PosMouseX >= 600)
    PosMouseX = 600;
  DataJavaScript.setPosX(PosMouseX + 20);
  DataJavaScript.setPosY(PosMouseY - 30);

    DataJavaScript.show();
  p_item = arguments[0];
  if (arguments[1] == null)
    p_month = new String(gNow.getMonth());
  else
    p_month = arguments[1];
  if (arguments[2] == "" || arguments[2] == null)
    p_year = new String(gNow.getFullYear().toString());
  else
    p_year = arguments[2];
  if (arguments[3] == null)
    p_format = "DD/MM/YYYY";
  else
    p_format = arguments[3];

    DataJavaScript.jan.target = "DataJavaScript";

    ggWinCal = DataJavaScript.jan;

  Build(p_item, p_month, p_year, p_format);
}
/*
Yearly Calendar Code Starts here
*/
function show_yearly_calendar(p_item, p_year, p_format) {
  // Load the defaults..
  if (p_year == null || p_year == "")
    p_year = new String(gNow.getFullYear().toString());
  if (p_format == null || p_format == "")
    p_format = "DD/MM/YYYY";

  var vWinCal = window.open("", "Calendar", "scrollbars=yes");
  vWinCal.opener = self;
  ggWinCal = vWinCal;

  Build(p_item, null, p_year, p_format);
}

//*****************************************************************************
// INI Do not remove this notice.
//
// Copyright 2000 by Mike Hall.
// See http://www.brainjar.com for terms of use.
//*****************************************************************************

//----------------------------------------------------------------------------
// Code to determine the browser and version.
//----------------------------------------------------------------------------
function js_hideshowselect(v) {
  if(document.forms.length > 0) {
    for(var i = 0;i < document.forms.length;i++) {
      var tam = document.forms[i].elements.length;
      for(var j = 0;j < tam;j++) {
        try {
          var str = new String(document.forms[i].elements[j].type);
        } catch(e) {
          var str = "";
        }
    if(str.indexOf("select") != -1) {
          document.forms[i].elements[j].style.visibility = v;
      }
    }
    }
  }
  var fram = (frames.length==0)?1:frames.length;
  for(var x = 0;x < fram;x++) {
    var F = (frames.length > 0)?(frames[x].document.forms):(document.forms);
    var qf = F.length;
    for(var i = 0;i < qf;i++) {
      var tam = F[i].elements.length;
      for(var j = 0;j < tam;j++) {
        try {
          var str = new String(F[i].elements[j].type);
        } catch(e) {
          var str = "";
        }
    if(str.indexOf("select") != -1) {
          F[i].elements[j].style.visibility = v;
      }
    }
    }
  }
}

function Browser() {

  var ua, s, i;

  this.isIE    = false;  // Internet Explorer
  this.isNS    = false;  // Netscape
  this.version = null;
  this.name    = null;
  this.system  = null;

  ua = navigator.userAgent;

  s = "MSIE";
  if ((i = ua.indexOf(s)) >= 0) {
    this.system = 'Windows';
  }
  s = "Linux";
  if ((i = ua.indexOf(s)) >= 0) {
    this.system = 'Linux';
  }

  s = "MSIE";
  if ((i = ua.indexOf(s)) >= 0) {
    this.isIE = true;
    this.name = 'Internet Explorer';
    this.version = parseFloat(ua.substr(i + s.length));
    return;
  }

  s = "Netscape/";
  if ((i = ua.indexOf(s)) >= 0) {
    this.isNS = true;
    this.name = 'Netscape';
    this.version = parseFloat(ua.substr(i + s.length));
    return;
  }

  // Treat any other "Gecko" browser as NS 6.1.

  s = "Gecko";
  if ((i = ua.indexOf(s)) >= 0) {
    this.isNS = true;
    this.name = 'Netscape';
    this.version = 6.1;
    return;
  }
}

var browser = new Browser();

//----------------------------------------------------------------------------
// Code for handling the menu bar and active button.
//----------------------------------------------------------------------------

var activeButton = null;

// Capture mouse clicks on the page so any active button can be
// deactivated.

if (browser.isIE)
  document.onmousedown = pageMousedown;
else {
  document.addEventListener("mousedown", pageMousedown, true);
     document.addEventListener("mousedown", function(event) {
      top.corpo.pageMousedown(event);
     }, false);
}

function pageMousedown(event) {

  var el;

  // If there is no active button, exit.

  if (activeButton == null)
    return;

  // Find the element that was clicked on.

  if (browser.isIE)
    el = window.event.srcElement;
  else
    el = (event.target.tagName ? event.target : event.target.parentNode);

  // If the active button was clicked on, exit.

  if (el == activeButton)
    return;

  // If the element is not part of a menu, reset and clear the active
  // button.

  if (getContainerWith(el, "DIV", "menu") == null) {
    resetButton(activeButton,event);
    activeButton = null;
  }
}

function buttonClick(event, menuId) {
  if(!document.getElementById(menuId))
    return false;
  var button;
  js_hideshowselect('hidden');
  // Get the target button element.

  if (browser.isIE)
    button = window.event.srcElement;
  else
    button = event.currentTarget;

  // Blur focus from the link to remove that annoying outline.

  button.blur();

  // Associate the named menu to this button if not already done.
  // Additionally, initialize menu display.

  if (button.menu == null) {
    button.menu = document.getElementById(menuId);
    if (button.menu.isInitialized == null)
      menuInit(button.menu);
  }

  // Reset the currently active button, if any.

  if (activeButton != null)
    resetButton(activeButton,event);

  // Activate this button, unless it was the currently active one.

  if (button != activeButton) {
    depressButton(button);
    activeButton = button;
  }
  else
    activeButton = null;

  return false;
}

function buttonMouseover(event, menuId) {
  var button;

  // Find the target button element.

  if (browser.isIE)
    button = window.event.srcElement;
  else
    button = event.currentTarget;

  // If any other button menu is active, make this one active instead.

  if (activeButton != null && activeButton != button)
    buttonClick(event, menuId);
}

function depressButton(button) {

  var x, y;

  // Update the button's style class to make it look like it's
  // depressed.

  button.className += " menuButtonActive";

  // Position the associated drop down menu under the button and
  // show it.

  x = getPageOffsetLeft(button);
  y = getPageOffsetTop(button) + button.offsetHeight;

  // For IE, adjust position.

  if (browser.isIE) {
    x += button.offsetParent.clientLeft;
    y += button.offsetParent.clientTop;
  }

  button.menu.style.left = x + "px";
  button.menu.style.top  = y + "px";
  button.menu.style.visibility = "visible";
}

function resetButton(button,evt) {
  var evt = (evt) ? evt : (window.event) ? window.event : "sem evento";

  // Restore the button's style class.

  removeClassName(button, "menuButtonActive");

  // Hide the button's menu, first closing any sub menus.

  if (button.menu != null) {
    closeSubMenu(button.menu);
    button.menu.style.visibility = "hidden";
  if(evt.type != "mouseover")
      js_hideshowselect('visible');
  }
}

//----------------------------------------------------------------------------
// Code to handle the menus and sub menus.
//----------------------------------------------------------------------------

function menuMouseover(event) {
  var menu;
  // Find the target menu element.

  if (browser.isIE)
    menu = getContainerWith(window.event.srcElement, "DIV", "menu");
  else
    menu = event.currentTarget;

  // Close any active sub menu.

  if (menu.activeItem != null)
    closeSubMenu(menu);
}

function menuItemMouseover(event, menuId) {
  var item, menu, x, y;

  // Find the target item element and its parent menu element.

  if (browser.isIE)
    item = getContainerWith(window.event.srcElement, "A", "menuItem");
  else
    item = event.currentTarget;
  menu = getContainerWith(item, "DIV", "menu");

  // Close any active sub menu and mark this one as active.

  if (menu.activeItem != null)
    closeSubMenu(menu);
  menu.activeItem = item;

  // Highlight the item element.

  item.className += " menuItemHighlight";

  // Initialize the sub menu, if not already done.

  if (item.subMenu == null) {
    item.subMenu = document.getElementById(menuId);
    if (item.subMenu.isInitialized == null)
      menuInit(item.subMenu);
  }

  // Get position for submenu based on the menu item.

  x = getPageOffsetLeft(item) + item.offsetWidth;
  y = getPageOffsetTop(item);

  // Adjust position to fit in view.

  var maxX, maxY;

  if (browser.isNS) {
    maxX = window.scrollX + window.innerWidth;
    maxY = window.scrollY + window.innerHeight;
  }
  if (browser.isIE) {
    maxX = (document.documentElement.scrollLeft   != 0 ? document.documentElement.scrollLeft    : document.body.scrollLeft)
         + (document.documentElement.clientWidth  != 0 ? document.documentElement.clientWidth   : document.body.clientWidth);
    maxY = (document.documentElement.scrollTop    != 0 ? document.documentElement.scrollTop    : document.body.scrollTop)
         + (document.documentElement.clientHeight != 0 ? document.documentElement.clientHeight : document.body.clientHeight);
  }
  maxX -= item.subMenu.offsetWidth;
  maxY -= item.subMenu.offsetHeight;

  if (x > maxX)
    x = Math.max(0, x - item.offsetWidth - item.subMenu.offsetWidth
      + (menu.offsetWidth - item.offsetWidth));
  y = Math.max(0, Math.min(y, maxY));

  // Position and show it.

  item.subMenu.style.left = x + "px";
  item.subMenu.style.top  = y + "px";
//  item.subMenu.style.zIndex  = 10000;
  menu_ordem_geral = menu_ordem_geral + 1;
  item.subMenu.style.zIndex  = menu_ordem_geral;
  item.subMenu.style.visibility = "visible";

  // Stop the event from bubbling.

  if (browser.isIE)
    window.event.cancelBubble = true;
  else
    event.stopPropagation();
}

function closeSubMenu(menu) {

  if (menu == null || menu.activeItem == null)
    return;

  // Recursively close any sub menus.

  if (menu.activeItem.subMenu != null) {
    closeSubMenu(menu.activeItem.subMenu);
    menu.activeItem.subMenu.style.visibility = "hidden";
    menu.activeItem.subMenu = null;
  }
  removeClassName(menu.activeItem, "menuItemHighlight");
  menu.activeItem = null;
}

//----------------------------------------------------------------------------
// Code to initialize menus.
//----------------------------------------------------------------------------

function menuInit(menu) {

  var itemList, spanList;
  var textEl, arrowEl;
  var itemWidth;
  var w, dw;
  var i, j;

  // For IE, replace arrow characters.

  if (browser.isIE) {
    menu.style.lineHeight = "2.5ex";
    spanList = menu.getElementsByTagName("SPAN");
    for (i = 0; i < spanList.length; i++)
      if (hasClassName(spanList[i], "menuItemArrow")) {
        spanList[i].style.fontFamily = "Webdings";
        spanList[i].firstChild.nodeValue = "4";
      }
  }

  // Find the width of a menu item.

  itemList = menu.getElementsByTagName("A");
  if (itemList.length > 0)
    itemWidth = itemList[0].offsetWidth;
  else
    return;

  // For items with arrows, add padding to item text to make the
  // arrows flush right.

  for (i = 0; i < itemList.length; i++) {
    spanList = itemList[i].getElementsByTagName("SPAN");
    textEl  = null;
    arrowEl = null;
    for (j = 0; j < spanList.length; j++) {
      if (hasClassName(spanList[j], "menuItemText"))
        textEl = spanList[j];
      if (hasClassName(spanList[j], "menuItemArrow"))
        arrowEl = spanList[j];
    }
    if (textEl != null && arrowEl != null)
      textEl.style.paddingRight = (itemWidth
        - (textEl.offsetWidth + arrowEl.offsetWidth)) + "px";
  }

  // Fix IE hover problem by setting an explicit width on first item of
  // the menu.

  if (browser.isIE) {
    w = itemList[0].offsetWidth;
    itemList[0].style.width = w + "px";
    dw = itemList[0].offsetWidth - w;
    w -= dw;
    itemList[0].style.width = w + "px";
  }

  // Mark menu as initialized.

  menu.isInitialized = true;
}

//----------------------------------------------------------------------------
// General utility functions.
//----------------------------------------------------------------------------

function getContainerWith(node, tagName, className) {

  // Starting with the given node, find the nearest containing element
  // with the specified tag name and style class.

  while (node != null) {
    if (node.tagName != null && node.tagName == tagName &&
        hasClassName(node, className))
      return node;
    node = node.parentNode;
  }

  return node;
}

function hasClassName(el, name) {

  var i, list;

  // Return true if the given element currently has the given class
  // name.

  list = el.className.split(" ");
  for (i = 0; i < list.length; i++)
    if (list[i] == name)
      return true;

  return false;
}

function removeClassName(el, name) {

  var i, curList, newList;

  if (el.className == null)
    return;

  // Remove the given class name from the element's className property.

  newList = new Array();
  curList = el.className.split(" ");
  for (i = 0; i < curList.length; i++)
    if (curList[i] != name)
      newList.push(curList[i]);
  el.className = newList.join(" ");
}

function getPageOffsetLeft(el) {

  var x;

  // Return the x coordinate of an element relative to the page.

  x = el.offsetLeft;
  if (el.offsetParent != null)
    x += getPageOffsetLeft(el.offsetParent);

  return x;
}

function getPageOffsetTop(el) {

  var y;

  // Return the x coordinate of an element relative to the page.

  y = el.offsetTop;
  if (el.offsetParent != null)
    y += getPageOffsetTop(el.offsetParent);

  return y;
}

// testa se página aceita cookies

function testa_cookie(){
//#01#//testa_cookie
//#10#//Funcão para testar se o browse esta habilitado para receber cookie, caso não esteja, mostra help
//#15#//testa_cookie();

  var resposta;
  // Esta funcao testa se os cookies sao aceitos
  // Tenta escrever um cookie.
  document.cookie = 'aceita_cookie=sim;path=/;';
  // Checa se conseguiu
  if(document.cookie == '') {
    document.write ('<CENTER>');
    document.write ('<p><font face="Arial" size="4" color="#000080">Certidão Negativa de Débitos de Tributos e Contribuições Federais</font></p>');
    document.write ('<TABLE cellSpacing=2 cellPadding=0 width=590 border=0>');
    document.write ('<TBODY>');
    document.write ('<TR>');
    document.write ('<TD style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; PADDING-TOP: 3px" bgColor=#93bee2>');
    document.write ('<FONT face="verdana"><B>Erro: Navegador não suporta Cookie</B></FONT></TD>');
    document.write ('<TD vAlign=top></TD>');
    document.write ('</TR>');
    document.write ('<TR><TD height=6></TD></TR>');
    document.write ('<TR vAlign=top><TD>');
    document.write ('<TABLE borderColor=#000080 cellSpacing=0 cellPadding=3 border=1>');
    document.write ('<TBODY>');
    document.write ('<TR><TD><FONT face="verdana" size=2 color=#000080><B>O navegador que você está usando não dá suporte a Cookie ou talvez você o tenha desativado.</B></FONT></TD></TR>');
    document.write ('</TBODY>');
    document.write ('</TABLE>');
    document.write ('</TD>');
    document.write ('</TR>');
    document.write ('</TBODY>');
    document.write ('</TABLE>');
    document.write ('<P>');
    document.write ('<TABLE width=590>');
    document.write ('<TBODY>');
    document.write ('<TR><TD>');
    document.write ('<FONT face="verdana" size=2>');
    document.write ('<B>Você está usando um navegador que não dá suporte a Cookie?</B>');
    document.write ('<UL>Se o seu navegador não der suporte a Cookie, você poderá atualizar para um navegador mais recente.</UL>');
    document.write ('<B>O Cookie está desativado?</B>');
    document.write ('<DL><DD>Se o Cookie estiver desativado, você deverá ativá-lo para entrar na rede. As instruções estão a seguir.');
    document.write ('<P><B>Como ativar o Cookie</B></P>');
    document.write ('<P>Internet Explorer 5 ou superior</P>');
    document.write ('<OLi');
    document.write ('<LI>Clique em <B>Ferramentas</B> e em <B>Opções da Internet</B>.</LI>');
    document.write ('<LI>Clique na guia <B>Segurança</B>.</LI>');
    document.write ('<LI>Clique no botão <B>Nível personalizado</B>.</LI>');
    document.write ('<LI>Role para a seção <B>Cookie</B>. Sob <B>Permitir cookies por sessão(não armazenados)</B> e <B>Permitir cookies que estão armazenados no computador</B>, selecione <B>Ativar</B>.</LI>');
    document.write ('<LI>Clique no botão <B>OK</B>. </LI>');
    document.write ('<OL>');
    document.write ('<P>Internet Explorer 4.x</P>');
    document.write ('<OL>');
    document.write ('<LI>Clique em <B>Exibir</B> e em <B>Opções da Internet</B>.</LI>');
    document.write ('<LI>Clique na guia <B>Segurança</B>.</LI>');
    document.write ('<LI>Clique no botão <B>Configurações</B>.</LI>');
    document.write ('<LI>Role para a seção <B>Cookies</B>.</LI>');
    document.write ('<LI>Selecione <B>Permitir cookies por sessão</B> e <B>Permitir cookies que estão armazenados no computador</B>.</LI>');
    document.write ('<LI>Clique no botão <B>OK</B>.</LI>');
    document.write ('</OL>');
    document.write ('<P>Netscape 6</P>');
    document.write ('<OL>');
    document.write ('<LI>Clique em <B>Editar</B> e em <B>Preferências</B>.</LI>');
    document.write ('<LI>Clique em <B>Avançado</B>.</LI>');
    document.write ('<LI>Clique em <B>Cookies</B>.</LI>');
    document.write ('<LI>Habilite a opção <B>Permitir todos os cookies</B>.</LI>');
    document.write ('<LI>Clique no botão <B>OK</B>. </LI></OL>');
    document.write ('<LI>Clique no botão <B>OK</B>. </LI></OL>');
    document.write ('<UL>Para saber se o seu navegador dá suporte a Cookie e obter instruções detalhadas sobre como ativar este recurso, consulte a Ajuda on-line para seu navegador.</UL>');
    document.write ('</DD></DL>');
    document.write ('<P></FONT>&nbsp;</P>');
    document.write ('</TD>');
    document.write ('</TR>');
    document.write ('</TBODY>');
    document.write ('</TABLE>');
    document.write ('</CENTER>');
    return (false);
  } else {
    // Apaga o cookie.
    document.cookie = 'aceita_cookie=sim; expires=Fri, 13-Apr-1970 00:00:00 GMT';
    return (true);
  }
}


function js_ajax_msg(mensagem){
   tipo_msg = 0; // alerta siples
   if (mensagem.substr(0,1)!=0) {
       tipo_msg = 1; // mensagem de erro
   }
   mensagem = mensagem.substr(2);

   var expReg = /\\n\\n/gm;
   mensagem = mensagem.replace(expReg,'<br>');

   var camada = document.createElement("DIV");
   camada.setAttribute("id",'id_ajax_msg');
   camada.setAttribute("align","center");
   camada.style.backgroundColor = "#c0c0c0";
   camada.style.layerBackgroundColor = "black";
   camada.style.position = "absolute";
   if (tipo_msg == 0) {
        // mensagem no canto esquerdo
        camada.style.left = 20+'px';
        camada.style.top =  ((screen.availHeight-100)/4)+'px';
   } else {
        // mensagem no meio da tela
        camada.style.left = ((screen.availWidth-400)/2)+'px';
        camada.style.top =  ((screen.availHeight-100)/2)+'px';
   }
   camada.style.zIndex = "1000";
   camada.style.visibility = 'visible';
   camada.style.width = "400px";
   camada.style.height = "100px";
   if (tipo_msg==0) {
           camada.innerHTML= ''+
           '<table border=0 style="border:1px solid" width=100% height=100%>'+
           ' <tr> '+
           '   <td width=35px align=center valign=top><img src="imagens/ok.png" width=40px></td>'+
           '   <td valign="top" align="left" >'+mensagem+'</td> '+
           ' </tr> '+
           '</table>';
           document.body.appendChild(camada);
           setTimeout(js_remove_ajax_msg,1500);
   }else{
           camada.innerHTML= ''+
           '<table border=0 style="border:1px solid" width=100% height=100%>'+
           ' <tr> '+
           '   <td width=35px align=center valign=top></td>'+
           '   <td valign="top" align="left" >'+mensagem+'</td> '+
     ' </tr><tr>'+
     '    <td colspan=2 align=center><input type=button value=Ok style="border:2px solid" onclick="js_remove_ajax_msg();"></td> '+
           ' </tr> '+
           '</table>';
           document.body.appendChild(camada);
   }
}
function js_remove_ajax_msg(){
  obj = document.getElementById("id_ajax_msg");
  document.body.removeChild(obj);
}
function js_round(valor, casas) {
  return Number(valor).toFixed(casas);
}

function checkleapyear(datea){
  datea = parseInt(datea);
  if(datea%4 == 0){
    if(datea%100 != 0){
      return true;
    }else{
      if(datea%400 == 0){
        return true;
      }else{
        return false;
      }
    }
  }
  return false;
}

function js_teclas(event){

  var sMask = '';

  var obj   = event.srcElement ? event.srcElement : event.currentTarget;
  var t     = document.all ? event.keyCode : event.which;
  if (t == 44) {
    if ( obj.value.indexOf(".") == -1) {
     obj.value += ".";
    }
  }
  if (obj != null) {

    if (obj.value.indexOf(".") != -1 && t == 46) {
      return false;
    }
  }
  sMask = "0-9|.";
  return js_mask(event, sMask);
}
function js_getElementbyClass(rootobj, classname, sParam){

  var temparray = new Array();
  var inc       = 0;
  var rootlength=rootobj.length;
  for (i=0; i<rootlength; i++){
    //$('debug').innerHTML += rootobj.elements[i].className;
    if (rootobj[i].className == classname) {
      if (typeof(sParam) != 'undefined') {
        with (rootobj[i]) {
           if (eval(sParam)){
             temparray[inc++]=rootobj[i];
          }
        }
      } else {
        temparray[inc++]=rootobj[i];
      }
    }
  }
  return temparray;
}

function js_ChecaPIS(pis){

  ftap="3298765432";
  total=0;
  i= 0;
  resto=0;
  numPIS=0;
  total=0;
  resto=0;
  numPIS=0;
  strResto="";

  numPIS=pis;
  if (numPIS=="" || numPIS==null) {

      return false;

  }
  for (i=0;i<=9;i++){
    resultado = (numPIS.slice(i,i+1))*(ftap.slice(i,i+1));
    total=total+resultado;
  }

  resto = (total % 11);
  if (resto != 0){
      resto=11-resto;
  }
  if (resto==10 || resto==11){
     strResto=resto+"";
     resto = strResto.slice(1,2);
  }
  if (resto!=(numPIS.slice(10,11))){
      return false;
  }
  return true;
}

function js_validaPis(pis){

    if (pis != ''){
      if (!js_ChecaPIS(pis)){
        alert("Pis inválido.Verifique.");
        document.getElementById('db_opcao').disabled=true;
        return false;
      } else {
          document.getElementById('db_opcao').disabled=false;
         return true;
      }
   }
}

function js_divCarregando(mensagem,id, lBloqueia){

   if (lBloqueia == null) {
     lBloqueia = true;
   }
   var expReg = /\\n\\n/gm;
   mensagem = mensagem.replace(expReg,'<br>');

   var camada = document.createElement("DIV");
   camada.setAttribute("id",id);
   camada.setAttribute("align","center");
   camada.style.position        = "fixed";
   // mensagem no meio da tela
   camada.style.left       = ((document.body.clientWidth / 2 ) - 100 )+'px';
   camada.style.top        = ((screen.availHeight-450)/2)+'px';
   camada.style.zIndex     = "1000";
   camada.style.visibility = 'visible';
   camada.style.width      = "200px";
   camada.className        = "DivCarregando";
   camada.style.height     = "60px";
   camada.style.fontFamily = 'Verdana, Arial, Helvetica, sans-serif';
   camada.style.fontSize   = '15px';
   camada.style.border     = '1px solid';

   if (lBloqueia) {

     /**
      *  Criamos uma camada para bloquear o acesso aos componentes da página
      */
     var oDisableBody = top.corpo.document.createElement("DIV");
     oDisableBody.style.backgroundColor = "transparent";
     oDisableBody.id                    = id+"modal";
     oDisableBody.style.top             = "25px";
     oDisableBody.style.left            = "0";
     oDisableBody.style.width           = "99%";
     oDisableBody.style.height          = "100%";
     oDisableBody.style.position        = 'fixed';
     oDisableBody.style.zIndex          = '99999999';
     oDisableBody.style.opacity         = '0.0';
     top.corpo.document.body.appendChild(oDisableBody);

     /*
      * Bloqueamos  acesso ao menu
      */

      oDbMenu = top.corpo.document.getElementById('db-menu');
      oDisableMenu = top.corpo.document.createElement("DIV");
      oDisableMenu.style.backgroundColor = "transparent";
      oDisableMenu.id                    = id+"disabledmenu";

      if  (oDbMenu != null) {

          oDisableMenu.style.top=oDbMenu.style.top;
          oDisableMenu.style.left=oDbMenu.style.left;
          oDisableMenu.style.width=oDbMenu.offsetWidth;

      } else {

          oDisableMenu.style.top="0px";
          oDisableMenu.style.left="0px";
          oDisableMenu.style.width="99%";

      }

      oDisableMenu.style.height          = "20px";
      oDisableMenu.style.position        = 'absolute';
      oDisableMenu.style.zIndex          = '99999999';
      top.corpo.document.body.appendChild(oDisableMenu);
      oDisableMenu.onclick=function () {

        var sMsg  = "Há Operações sendo Executadas.\nSaindo da rotina, as informações correntes serão perdidas.\n";
        if (confirm(sMsg)) {

          top.corpo.document.body.removeChild(oDisableMenu);
          return true;
        }
      }
     /**
      * Bloqueamos o topo
      */
     var oDivModalTopo                   = top.topo.document.createElement("div");
     oDivModalTopo.id                    = id+'modalTop';
     oDivModalTopo.style.height          = '100%';
     oDivModalTopo.style.position        = 'absolute';
     oDivModalTopo.style.top             = '0px';
     oDivModalTopo.style.left            = '0px';
     oDivModalTopo.style.width           = '100%';
     oDivModalTopo.style.backgroundColor = 'transparent';
     oDivModalTopo.style.zIndex          = '1900000';
     oTopoMenu = top.topo.document.getElementById('menuTopo');
     oTopoMenu.appendChild(oDivModalTopo);
   }
//   camada.style.solid      = '#000000';

// style = "font-size: 5px; solid #000000; visibility:visible">

   camada.innerHTML = ' <table border="0" width= "100%" height="100%" style="background-color: #FFFFCC; border-collapse: collapse;"> '
                     +'    <tr> '
                     +'      <td class="DivCarregandoMensagem" align= "center" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #000000; font-weight: bold;"> '
                     +'        '+mensagem+''
                     +'      </td> '
                     +'      <td > '
                     +'        <img src="imagens/files/loading.gif" /> '
                     +'      </td> '
                     +'    </tr> '
                     +' </table> ';
  document.body.appendChild(camada);
}

function js_fadeModal(element) {

   if (iFadeStep == 'undefined') {
    iFadeStep = 1;
   }
   iOpacity = js_round(iFadeStep/5,0);
   element.style.opacity = '0.'+iFadeStep;
   if (iFadeStep == 7) {

     clearTimeout(oTimerModal);
     return false;
   }

   iFadeStep ++;
   oTimerModal = setTimeout("js_fadeModal(top.corpo.document.getElementById('"+element.id+"'))", 10);
}

function js_removeObj(idObj) {

  var obj = document.getElementById(idObj);
  document.body.removeChild(obj);
  if (top.corpo.document.getElementById(idObj+"modal")) {

    var objModal = top.corpo.document.getElementById(idObj+"modal");
    top.corpo.document.body.removeChild(objModal);

  }

  if (top.topo.document.getElementById(idObj+"modalTop")) {

    var objModal = top.topo.document.getElementById(idObj+"modalTop");
    objParent = objModal.parentNode;
    objParent.removeChild(objModal);

  }
  if (top.corpo.document.getElementById(idObj+"disabledmenu")) {

    var objModal = top.corpo.document.getElementById(idObj+"disabledmenu");
    top.corpo.document.body.removeChild(objModal);

  }
}

Number.prototype.toFixed = function(casas){
  if(typeof(casas) =='undefined'){
    casas = 0;
  }
   var valor    = new Number( this );
   var base     = new Number( Math.pow(10,casas) );
   var valorArr = (Math.round(valor * base) / base );
   return valorArr;
};



function js_comparadata(data1,data2,comparar){


  if (data1 == '' || data2 == '') {
    return false;
  }

  if (data1.indexOf('/') != -1){

    datepart = data1.split('/');
    pYear    = datepart[2];
    pMonth   = datepart[1];
    pDay     = datepart[0];
  }
  data1 = new Date(pYear, pMonth-1, pDay);
  data1 = data1.getTime();
  if (data2.indexOf('/') != -1) {
    datepart = data2.split('/');
    pYear    = datepart[2];
    pMonth   = datepart[1];
    pDay     = datepart[0];
  }
  nDay   = new String(pDay);
  nMonth = new String(pMonth);
  nYear  = new String(pYear);
  data2  = new Date(pYear,pMonth-1,pDay);
  data2  = data2.getTime();
  if (eval(data1+" "+comparar+" "+data2)) {
    return true;
  } else {
    return false;
  }
}
/**
 * Funcao para bloquear menus.
 * @param boolean lBloqueia se bloqueia, ou libera os Menus
 * @param string  sCallBack nome da Função de callbacl para executar no
 *                          no evento onclick do menu.
 * @todo alterar aqui os impactos
 */
function js_bloqueiaMenus(lBloqueia, sCallBack) {

  if (lBloqueia) {

    //bloqueamos o menu do sistema
    if (!top.corpo.document.getElementById("divdbmenu")) {

      oDbMenu = top.corpo.document.getElementById('db-menu');
      disableMenu = top.corpo.document.createElement("DIV");
      disableMenu.style.backgroundColor = "transparent";
      disableMenu.id                    = "divdbmenu";

      if  (oDbMenu != null) {

         disableMenu.style.top   = oDbMenu.style.top;
         disableMenu.style.left  = oDbMenu.style.left;
         disableMenu.style.width = oDbMenu.offsetWidth;

      } else {

         disableMenu.style.top   = "0px";
         disableMenu.style.left  = "0px";
         disableMenu.style.width = "99%";

      }

      disableMenu.style.height   = "20px";
      disableMenu.style.position = 'absolute';
      disableMenu.style.zIndex   = '100';
      if (sCallBack != null) {
        disableMenu.onclick = sCallBack;
      }
      top.corpo.document.body.appendChild(disableMenu);

    }
    //Bloqueamos os menus do topo.
    if (!top.topo.document.getElementById("divdbmenu")) {

      oTopoMenu = top.topo.document.getElementById('menuTopo');
      oDisabledTopoMenu = top.topo.document.createElement("DIV");
      oDisabledTopoMenu.style.backgroundColor = "transparent";
      oDisabledTopoMenu.id                    = "divmenuTopo";

      if  (oDbMenu != null) {

         disableMenu.style.top   = oDbMenu.style.top;
         disableMenu.style.left  = oDbMenu.style.left;
         disableMenu.style.width = oDbMenu.style.width;

      } else {

         disableMenu.style.top   = "0px";
         disableMenu.style.left  = "0px";
         disableMenu.style.width = "99%";

      }

      oDisabledTopoMenu.style.height ="100%";
      oDisabledTopoMenu.style.width  ="100%";
      oDisabledTopoMenu.style.position='absolute';
      oDisabledTopoMenu.style.zIndex='100';
      oTopoMenu.appendChild(oDisabledTopoMenu);
    }
  } else {

    if (disableMenu != "undefined") {
      top.corpo.document.body.removeChild(disableMenu);
    }
    if (oDisabledTopoMenu != "undefined") {
      oTopoMenu.removeChild(oDisabledTopoMenu);
    }

  }
}


/**
 * Funcao para contar numero de ocorrencias de um caracter numa string
 * @param string sString    String a ser pesquisada
 * @param string cCharacter Caracter a ser pesquisado na String
 *
 * @return integer Quantidade de Ocorrencias
 */
function js_countOccurs(sString, cCharacter) {
  var iOccurs = 0;
  var iLength = sString.length;
  var indx = 0;

  for(indx = 0; indx < iLength; indx++) {
    if(sString[indx] == cCharacter) {
      iOccurs++;
    }
  }
  return iOccurs;
}

/**
 * Funcao para adicionar um Valor a HashTable aInputValues
 * @param string sIndex  Nome do Indice
 * @param string xValue  Valor a ser adicionado
 *
 * @return void
 */
function js_putInputValue(sIndex, xValue) {
  aInputValues[sIndex] = xValue;
  return;
}

/**
 * Funcao para retornar um Valor da HashTable aInputValues
 * @param string sIndex  Nome do Indice para Pesquisar
 *
 * @return string Valor Encontrado na HashTable
 */
function js_getInputValue(sIndex) {
  return aInputValues[sIndex];
}
function js_objectToJson(oObject) {

   var sJson = oObject.toSource();
   sJson     = sJson.replace("(","");
   sJson     = sJson.replace(")","");
   return sJson;

}

function js_mask(e,teclas) {

  var ini  ='';
  var fim  = '';
  var aval = '';
  var or   ='';
  var and  = '';
  var t    = document.all ? event.keyCode : e.which;

  var ta   = teclas.split("|");
   for (var i = 0;i < ta.length;i++){

        if (ta[i].indexOf("-") != "-1" && ta[i].length == 1) {

          and = i > 0?' ||  ':'';
          aval += and+' t == '+ta[i].charCodeAt();
          and = ' ||';

        } else  if (ta[i].indexOf("-") != "-1"){

           vchars = ta[i].split("-");
            or = i > 0?'|| ':'';

           if (vchars.length > 1){

              ini = vchars[0].charCodeAt();
              fim = vchars[1].charCodeAt();

              aval += or+' (t >='+ini+' && t <='+fim+')';
              or = " ||";

           }else{
              aval += ' && t ='+vchars[0];
           }

        }else{

          if (ta[i].indexOf("\-")) {
           ta[i] = ta[i].replace("\\","");
          }
          and = i > 0?' ||  ':'';
          aval += and+' t == '+ta[i].charCodeAt();
          and = ' ||';

        }

    }

    if (eval(aval)){
      return true;
    } else {
      if (t != 8 && t != 0 && t != 13 && t != 9) { // backspace
       return false;
    } else{
      return true;
    }
  }
}

window.document.captureEvents(Event.KEYDOWN);
window.document.onkeydown  = function (event) {
  if (event.which == 116) {
    return false;
  };
}
getElementsByClass = function ( searchClass, domNode, tagName) {

    if (domNode == null) {
      domNode = document;
    }

    if (tagName == null) {
      tagName = '*';
    }

    var el = new Array();
    var tags = domNode.getElementsByTagName(tagName);
    var tcl = " "+searchClass+" ";
    for (i=0,j=0; i<tags.length; i++) {

      var test = " " + tags[i].className + " ";
      if (test.indexOf(tcl) != -1) {
         el[j++] = tags[i];
       }
    }
    return el;
}

/**
 * Funcao para retornar os dias de vigência entre um período de datas.
 * @param string sDataInicio Data inicial da vigência.
 * @param string sDataFim Data final da vigência.
 *
 * @return integer dias de vigência.
 */
function js_somarDiasVigencia(sDataInicio, sDataFim) {

  var lRetorno = false;
  if (sDataInicio != '' && sDataFim != '') {

    if (js_comparadata(sDataInicio, sDataFim, "<=")) {

      if (sDataInicio.indexOf('/') != -1 && sDataFim.indexOf('/') != -1) {

        /**
         * Data de inicio da vigência.
         **/
        var aDataInicio  = sDataInicio.split('/');
        var iDiaInicio   = aDataInicio[0];
        var iMesInicio   = new Number(aDataInicio[1]);
            iMesInicio  -= 1;
        var iAnoInicio   = aDataInicio[2];

        /**
         * Data de fim da vigência.
         **/
        var aDataFim     = sDataFim.split('/');
        var iDiaFim      = aDataFim[0];
        var iMesFim      = new Number(aDataFim[1]);
            iMesFim     -= 1;
        var iAnoFim      = aDataFim[2];

        var dtDataInicio = new Date(iAnoInicio, iMesInicio, iDiaInicio);
        var dtDataFim    = new Date(iAnoFim, iMesFim, iDiaFim);
        if (dtDataFim >= dtDataInicio) {

          /**
           * Somas os dias de vigência do contrato.
           **/
          var iSomaDias  = dtDataFim - dtDataInicio;
              iSomaDias  = iSomaDias / 86400000;
          var iSomaDias  = new Number(iSomaDias);
              iSomaDias += 1;
          var iSomaDias  = iSomaDias.toFixed(0);
          var lRetorno   = true;
        }
      }
    }
  }

  /**
   * Flag de retorno da função.
   **/
  if (lRetorno == true) {
    return iSomaDias;
  } else {
    return false;
  }
}
/*
 * Calcula a altura do utils do documento(ViewPort)
 * @return float
 */

function getDocHeight() {
  var D = document;
  return Math.max(
      Math.max(D.body.scrollHeight, D.documentElement.scrollHeight),
      Math.max(D.body.offsetHeight, D.documentElement.offsetHeight),
      Math.max(D.body.clientHeight, D.documentElement.clientHeight)
  );
}

/**
 * Remove valores duplicados no array
 * @param Array inputArr
 */

function array_unique (inputArr) {
 /**
  * @version: 1107.2516
  * @discuss at: http:*phpjs.org/functions/array_unique    * +   original by: Carlos R. L. Rodrigues (http:*www.jsfromhell.com)
  * +      @input by: duncan
  * +   @bugfixed by: Kevin van Zonneveld (http:*kevin.vanzonneveld.net)
  * +   @bugfixed by: Nate
  * +      @input by: Brett Zamir (http:*brett-zamir.me)    * +   bugfixed by: Kevin van Zonneveld (http:*kevin.vanzonneveld.net)
  * +   @improved by: Michael Grier
  * +   @bugfixed by: Brett Zamir (http:*brett-zamir.me)
  * %          note 1: The second argument, sort_flags is not implemented;
  * %          note 1: also should be sorted (asort?) first according to docs    * *     example 1: array_unique(['Kevin','Kevin','van','Zonneveld','Kevin']);
  * *     returns 1: {0: 'Kevin', 2: 'van', 3: 'Zonneveld'}
  * *     example 2: array_unique({'a': 'green', 0: 'red', 'b': 'green', 1: 'blue', 2: 'red'});
  * *     returns 2: {a: 'green', 0: 'red', 1: 'blue'}
  */
  var key = '',        tmp_arr2 = {},
      val = '';

  var __array_search = function (needle, haystack) {

    var fkey = '';        for (fkey in haystack) {

      if (haystack.hasOwnProperty(fkey)) {

        if ((haystack[fkey] + '') === (needle + '')) {
            return fkey;
        }
      }
    }
    return false;
  }
  for (key in inputArr) {
    if (inputArr.hasOwnProperty(key)) {
      val = inputArr[key];
      if (false === __array_search(val, tmp_arr2)) {
       tmp_arr2[key] = val;
      }
    }
  }

  return tmp_arr2;
}

/**
 * Seta todos os elementos dentro de um formulario como readOnly
 * @param oElemento Formulario onde se encontram os elementos que serao desabilitados
 * @param lBloquear Recebe um boolean utilizado como parametro para o readOnly e disabled
 */
function setFormReadOnly(oElemento, lBloquear) {

  var iTamanho                  = oElemento.length;
  var aElementosCorFixa         = new Array("submit", "button", "fieldset");
  var aElementosParaDesabilitar = new Array("select-one", "select_multiple", "submit", "button" ,"checkbox");

  for (var iContador = 0; iContador < iTamanho; iContador++) {

    if (!js_search_in_array(aElementosCorFixa, oElemento.elements[iContador].type)) {

      var sCor = '#DEB887';

      if (oElemento.elements[iContador].type == 'fieldset') {
        sCor = '#CCCCCC';
      } else if (lBloquear == false) {
        sCor = '#FFFFFF';
      }
      oElemento.elements[iContador].style.backgroundColor = sCor;
    }


    oElemento.elements[iContador].readOnly = lBloquear;

    if (js_search_in_array(aElementosParaDesabilitar, oElemento.elements[iContador].type)) {
      oElemento.elements[iContador].disabled = lBloquear;
    }
  }
  /**
   * Remove as ancoras
   */
  $$('.dbancora').each( function (oElement) {

    var sValor = oElement.textContent;
    oElement.parentNode.innerHTML = sValor;

  });
}
if (typeof F2 == 'undefined') {
	var F2        = 113;
	var F3        = 114;
	var F4        = 115;
	var F5        = 116;
	var F6        = 117;
	var F7        = 118;
	var F8        = 119;
	var F9        = 120;
	var F10       = 121;
	var F11       = 122;
	var F13       = 123;
	var ESC       = 27;
	var KEY_S     = 83;
	var KEY_R     = 82;
	var KEY_LEFT  = 37;
	var KEY_UP    = 38;
	var KEY_DOWN  = 40;
	var KEY_RIGTH = 39;
	var KEY_ENTER = 13; // Tecla ENTER
}
window.addEventListener('keydown', function(Event) {

  var iTeclaPressionada = Event.which;
  switch(iTeclaPressionada) {

    case F5:

      Event.preventDefault();
      Event.stopPropagation();
      return false;
      break;
  }
  if (Event.ctrlKey) {

    switch (iTeclaPressionada) {

      case KEY_S:
      case KEY_R:

        Event.preventDefault();
        Event.stopPropagation();
        return false;
        break;

      default:
        break;
    }
  }

}, true);

/**
 * Objeto que vai armazenar os arquivos requiridos
 */
var __Requisicoes__ = {};

/**
 * Carrega um arquivo JavaScript
 * @param sArquivo - caminho do arquivo relativo a raiz do e-Cidade
 * @returns {Boolean}
 */
function require( sArquivo ) {
  "use strict";

  if ( __Requisicoes__[sArquivo] ) {
    throw "Arquivo não pode ser sobrecarregado.";
  }

  var oRequisicao = new XMLHttpRequest();
  oRequisicao.open('GET',
      sArquivo,
      false);

  var sContentType = "application/x-www-form-urlencoded; charset=ISO-8859-1";
  oRequisicao.setRequestHeader("Content-type", sContentType);
  oRequisicao.overrideMimeType(sContentType);
  oRequisicao.send(null);


  if ( oRequisicao.status === 200 ) {

    var aDadosArquivo = sArquivo.split(".");
    var iUltimoIndice = aDadosArquivo.length - 1;
    var sExtensao     = aDadosArquivo[ iUltimoIndice ];
    var oHead         = document.getElementsByTagName("head")[0]
      switch (sExtensao) {

        case "js":

          var oScript  = document.createElement("script");
          oScript.type = "text/javascript";
          oScript.innerHTML = oRequisicao.responseText;
          oHead.appendChild( oScript );
        break;
        case "css":

          var oScript       = document.createElement("style");
          oScript.innerHTML = oRequisicao.responseText;
          oHead.appendChild( oScript );
        break;
      }
    __Requisicoes__[sArquivo] = sArquivo;
    return true;
  }
  throw "Arquivo não pode ser carregado.";
}

/**
 * Carrega uma vez um arquivo JavaScript
 * @param sArquivo- caminho do arquivo relativo a raiz do e-Cidade
 * @returns
 */
function require_once(sArquivo) {

  if ( __Requisicoes__[sArquivo] ) {
    return;
  }
  return require( sArquivo );
}
/**
 * Retorna o numero de dias, no mes e ano passados como parametros
 * @param integer iMes Mes para verificação
 * @param integer iAno Ano para verificação
 * @returns integer total de dias
 */
function js_getNumeroDeDiaNoMes(iMes, iAno) {

  var iDiasFevereiro = 28;
  if (checkleapyear(iAno)) {
    iDiasFevereiro = 29;
  }

  /**
   * Total de Dias em cada mês
   */
  //                        01    02             03  04  05  06  07  08  09  10  11  12
  var aDiasNoMes = new Array(31, iDiasFevereiro, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
  return aDiasNoMes[iMes - 1];
}

/**
 * Retorna um objeto com os dados da idade,
 * a Idade é calculada com base no dia atual.
 * @param iDia dia do nascimento
 * @param iMes mes do Nascimento
 * @param iAno ano do nascimento
 * @returns Object {ano, mes, dia, string}
 */
function js_idade(iDia, iMes, iAno) {

  var iMesNascimento = new Number(iMes);
  var iDiaNascimento = new Number(iDia);
  var iAnoNascimento = new Number(iAno);

  /**
   * Dados referente a data atual
   */
  var oDataDia  = new Date();
  var iAnoAtual = oDataDia.getFullYear();
  var iMesAtual = oDataDia.getMonth() + 1;
  var iDiaAtual = oDataDia.getDate();

  var iAnos = iAnoAtual - iAnoNascimento;


  /**
   * Por padrão, iMes subtrai o mês atual pelo mês de nascimento.
   * Caso o mês de nascimento seja maior que o mês atual, verifica-se a diferença entre o mês de um ano e do outros,
   * calculando o (total de meses no ano subtraindo - mês de nascimento) + mês atual. Em seguida, diminuimos 1 ano.
   * Ex.: Nascimento - 02/02/2012
   *      Atual      - 02/01/2013
   *      Cálculo    - (12 - 2) + 1
   *      Diferença  - 11 meses
   */
  var iMes = 0;
      iMes = (iMesAtual - iMesNascimento);
  if (iMesNascimento > iMesAtual) {

    iMes = ((12 - iMesNascimento) + iMesAtual);
    iAnos--;
  }

  /**
   * Por padrão iDias subtrai o dia atual pelo dia de nascimento.
   * Caso o dia da data de nascimento seja maior que o dia da data atual, faz-se o seguinte cálculo:
   * 1º Busca o número de dias de um mês em determinado ano, chamando a função js_getNumeroDeDiaNoMes
   * 2º (Total de dias de um mês retornado da função - Dia da data de nascimento) + Dia da Data Atual
   * 3º Diminui-se 1 mês
   * 4º Caso ao diminuir, o mês fique menor que zero, fixamos como mês 11 e diminui-se 1 ano
   * Ex.: Nascimento - 30/04/2013
   *      Atual      - 29/04/2013
   *      Cálculo    - (30 - 30) + 29
   *      Diferença  - 29 dias
   *      iMes       - 04 - 04 = 0 (diminuindo 1 mês pelo cálculo do dia, ficaria iMes = -1)
   *      iMes       - 11
   *      iAno       - iAno - 1
   */
  var iDias = iDiaAtual - iDiaNascimento;
  if (iDiaNascimento > iDiaAtual) {

    iDia  = js_getNumeroDeDiaNoMes(iMesAtual, iAnoAtual);
    iDias = (iDia - iDiaNascimento) + iDiaAtual;
    iMes--;
    if (iMes < 0) {

      iMes = 11;
      iAnos--;
    }
  }

  /**
   * String para retornar uma idade com ano e/ou mês e/ou dia
   */
  var sStringIdade = '';
  if (iAnos > 0) {
    sStringIdade += iAnos+' ano'+(iAnos > 1 ? 's':'');
  }
  if (iMes > 0) {

    if (sStringIdade !='') {
      sStringIdade +=", ";
    }
    sStringIdade += iMes+(iMes > 1 ? ' meses':' mês');
  }
  if (iDias > 0) {

    if (sStringIdade !='') {
      sStringIdade +=", ";
    }
    sStringIdade += iDias+' dia'+(iDias > 1 ? 's':'');
  }

  /**
   * Objeto com os dados a serem retornados
   */
  var oIdade = {ano: iAnos,
                mes: iMes,
                dia: iDias,
                string: sStringIdade
               };
  return oIdade;
};

/**
 * Recebe uma string como parametro e verifica se ela
 * é diferente de vazia e de null
 * @deprecated
 * @see empty
 * @param sTarget
 * @returns Boolean
 */
function js_empty (sTarget) {

  if ( sTarget == '' || sTarget == null) {
    return true;
  }
  return false;
}

/**
 * Retorna a mensagem solicitada
 * @param {String} sCaminhoMensagem caminho de mensagem
 * @param {Object} oVariaveis objeto literal com as variaveis que devem ser substituidas
 * @example DBMensagem.getMensagem('configuracao.mensagem.con4_mensagem001.mensagem_nao_informada');
 *          Aonde: DBPortal. <-area
 *                 configuracao <- modulo
 *                 con4_mensagem001<- Programa
 *                 mensagem_nao_informada <- mensagem que deve ser exibida
 * @returns {string} texto da mensagem
 */
function _M(sCaminhoMensagem, oVariaveis) {

  require_once("scripts/DBMensagem.js");

  try {

    var oDBMensagem = new DBMensagem();
    var sMensagem   = oDBMensagem.getMensagem(sCaminhoMensagem);
    sMensagem       = oDBMensagem.aplicarVariaveis(sMensagem, oVariaveis);

  } catch ( oErro ) {
    alert('Ocorreu um erro Inesperado.\nContate suporte.');
  }

  return sMensagem;
}

/**
 * Checks if the argument variable is empty undefined, null, false, number 0, empty string,
 * string "0", objects without properties and empty arrays are considered empty
 * http://kevin.vanzonneveld.net
 * original by: Philippe Baumann
 *  input by: Onno Marsman
 *  bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
 *     input by: LH
 *  improved by: Onno Marsman
 *  improved by: Francesco
 *  improved by: Marc Jansen
 *     input by: Stoyan Kyosev (http://www.svest.org/)
 *  improved by: Rafal Kukawski
 * @exemple
 *    example 1: empty(null);
 *    returns 1: true
 *    example 2: empty(undefined);
 *    returns 2: true
 *    example 3: empty([]);
 *    returns 3: true
 *    example 4: empty({});
 *    returns 4: true
 *    example 5: empty({'aFunc' : function () { alert('humpty'); } });
 *    returns 5: false
 * @param mixed_var
 * @returns {Boolean}
 */
function empty (mixed_var) {

  var undef, key, i, len;
  var emptyValues = [undef, null, false, 0, "", "0"];

  for (i = 0, len = emptyValues.length; i < len; i++) {
    if (mixed_var === emptyValues[i]) {
      return true;
    }
  }

  if (typeof mixed_var === "object") {

    for (key in mixed_var) {

      if (mixed_var.hasOwnProperty(key)) {
        return false;
      }
    }
    return true;
  }

  return false;
}

/**
 * Valida um CPF
 * @param Object oCpf - Objeto do input do CPF
 * @returns {Boolean}
 */
function validaCPF(oCpf) {

  expr = new  RegExp("0{11}|1{11}|2{11}|3{11}|4{11}|5{11}|6{11}|7{11}|8{11}|9{11}");
  if (oCpf.value.match(expr)){

    oCpf.value = "";
    oCpf.focus();
    return false;
  }
  if (isNaN(oCpf.value) || oCpf.value.length != 11){
     return false;
  }

  for (var vdigpos = 10; vdigpos < 12; vdigpos++ ){

    var vdig = 0;
    var vpos = 0;
    for (var vfator = vdigpos;vfator >= 2; vfator-- ){

      vdig = eval(vdig + oCpf.value.substr(vpos,1) * vfator);
      vpos++;

    }
    vdig  = eval(11 -(vdig % 11)) < 10 ? eval(11 - vdig % 11) : 0;
    if (vdig != eval(oCpf.value.substr(vdigpos-1,1))) {

      oCpf.value = "";
      oCpf.focus();
      return false;
    }
  }
  return true;
}

/**
 * Valida um CNPJ
 * @param Objetc oCnpj - Objeto do input do CNPJ
 * @returns {Boolean}
 */
function validaCNPJ(oCnpj) {

  if (isNaN(oCnpj.value) || oCnpj.value.length != 14){
      return false;
  }
  for (var vdigpos = 13; vdigpos < 15; vdigpos++ ){

    var vdig = 0;
    var vpos = 0;
    for (var vfator = vdigpos - 8 ;vfator >= 2; vfator-- ){

      vdig = eval(vdig + oCnpj.value.substr(vpos,1) * vfator);
      vpos++;

    }
    for (var vfator = 9 ;vfator >= 2; vfator-- ){

      vdig = eval(vdig + oCnpj.value.substr(vpos,1) * vfator);
      vpos++;

    }
    vdig  = eval(11 -(vdig % 11)) < 10 ? eval(11 - vdig % 11) : 0;
    if (vdig != eval(oCnpj.value.substr(vdigpos-1,1))) {
      return false;
    }
  }
  return true;
}

/**
 * Valida o campo passado como CPF ou CNPJ
 *
 * @param Object oObjeto - Objeto do Input
 * @returns {Boolean}
 */
function validaCpfCnpj(oObjeto) {

  var iTamanhoObjeto = oObjeto.value.length;

  if (iTamanhoObjeto == 11) {
    return validaCPF(oObjeto);
  } else if (iTamanhoObjeto == 14) {
    return validaCNPJ(oObjeto);
  }

  return false;
}

/**
 * Verificao se o email é um email válido. Caso não seja, exibe uma mensagem
 *
 * @param string sEmail
 * @returns {Boolean}
 */
function validaEmail(sEmail){

  var expReg0 = new RegExp("[A-Za-z0-9_.-]+@([A-Za-z0-9_]+\.)+[A-Za-z]{2,4}");
  var expReg1 = new RegExp("[!#$%*<>,:;?°ºª~/|]");

  if (sEmail.match(expReg1) != null || sEmail.indexOf('\\') != -1 || sEmail.indexOf(' ') != -1) {

    var sMensagem = 'Email informado não é válido ou esta vazio!\n\n Exemplo de email: xxx@xx.xx\n\n Email ';
        sMensagem += 'pode conter:\n  letras, números, hifen(-), sublinhado _\n\n Email não pode conter:\n  caracteres ';
        sMensagem += 'especiais, virgula(,), ponto e virgula (;), dois pontos (:)';
    alert(sMensagem) ;
    return false;
  }

  if (sEmail.match(expReg0) == null) {

    var sMensagem  = 'Email informado não é válido ou esta vazio!\n\n Exemplo de email: xxx@xx.xx\n\n Email pode conter:';
        sMensagem += '\n  letras, números, hifen(-), sublinhado _\n\n Email não pode conter:\n   caracteres especiais,';
        sMensagem += ' virgula(,), ponto e virgula (;), dois pontos (:)';

    alert(sMensagem) ;
    return false;
  }
  return true;
}

function autoCompleteMenu(){

  require_once("scripts/strings.js");
  require_once("scripts/widgets/dbautocomplete.widget.js");
  require_once("scripts/json2.js");

  var oAutoComplete = new dbAutoComplete(autoCompleteMenus,'sys4_itensmenus.RPC.php');
  oAutoComplete.setTxtFieldId(autoCompleteMenus.id);
  oAutoComplete.show();
  oAutoComplete.setLoader(true);

  autoComplete.style.display = 'block';
  autoCompleteMenus.focus();

      oAutoComplete.setQueryStringFunction(

        function () {

          var oParametros = {}
              oParametros.sConteudo = autoCompleteMenus.value;
              oParametros.sExecucao = 'getItens';

          var sQuery  = 'json='+JSON.stringify(oParametros);
          return sQuery;
        }
      );

      oAutoComplete.setCallBackFunction(


        function(id,label) {

          aId           = id.urlDecode().split(':');
          location.href = aId;
        }
      );

}

/**
 * Menu functions
 * @todo Alterar isso aqui depois
 */

top.topo.document.addEventListener("mousedown", Menu_events)
top.bstatus.document.addEventListener("mousedown", Menu_events)
this.document.addEventListener("mousedown", Menu_events);

function Menu_events(evt) {
  var target = top.corpo.document.getElementById('db-menu');

  if (!target) {
    return;
  }
  var aChildrens = target.querySelectorAll('*');

  for (i = 0; i < aChildrens.length; i++) {
    if (aChildrens[i] == evt.target) {
      return;
    }
  }

  Menu_removeChildrensClass(target, 'active', true);
}

function Menu_toggle(obj, evt) {

  if (obj != evt.target && obj != evt.target.parentNode) {
    return;
  }

  obj.classList.toggle('active')
}

function Menu_mouseOver(obj, evt) {
  evt.stopImmediatePropagation();

  Menu_removeChildrensClass(obj.parentNode, ['hover', 'active'], true, obj);
  Menu_removeChildrensClass(obj, ['hover', 'active'], true, obj);

  if (!obj.classList.contains('hover')) {
    obj.classList.add('hover')
  }

  if (!obj.classList.contains('active')) {
    obj.classList.add('active')
    Menu_verifySize(obj);
  }

}

function Menu_parentOver(obj, evt) {
  var oMenu = document.getElementById('db-menu');

  var aActive = oMenu.querySelectorAll('li.active');

  if (aActive.length != 0 && aActive[0] != obj) {

    if (obj.classList.contains('sub-menu')) {

      Menu_removeChildrensClass(aActive[0].parentNode, ['hover', 'active'], true)
      obj.click();
    }
  }
}

function Menu_verifySize(parent) {

  if (!parent.classList.contains("sub-menu")) {
    return;
  }

  var ulChildren = parent.querySelectorAll('ul')[0];
  var ulSize     = ulChildren.getBoundingClientRect().width;
  var windowSize = document.body.getBoundingClientRect().width

  var ulPos = parent.getBoundingClientRect().right + ulSize + 10;

  ulChildren.classList.remove("inverse")
  if (ulPos >= windowSize) {
    ulChildren.classList.add("inverse")
  }
}

function Menu_removeChildrensClass(parent, sClass, lRecursive, caller) {

  if (!parent) {
    return
  }

  var aChildrens = parent.children;

  for (i = 0; i < aChildrens.length; i++) {

    if (caller != null && aChildrens[i] == caller) {
      continue;
    }

    if (typeof sClass == "string") {
      sClass = [sClass];
    }

    for (x = 0; x < sClass.length; x++) {
      aChildrens[i].classList.remove(sClass[x])
    }

    if (lRecursive) {

      var aNetos = aChildrens[i].querySelectorAll("." + sClass.join(", ."));

      for (a = 0; a < aNetos.length; a++) {
        for (x = 0; x < sClass.length; x++) {
          aNetos[a].classList.remove(sClass[x])
        }
      }

    }
  }

  return;
}



/**
 * INICIO FUNCOES PARA JANELA
 */


function janela(janP,cFt,Iframe) {

  this.moldura    = janP;
  this.jan        = Iframe;
  this.janFrame   = Iframe.frameElement;
  this.nomeJanela = janP.id.substr(3);
  this.titulo     = new String(cFt.firstChild.innerHTML);
  this.onJanHide  = null;                  //@TODO onHide
  document.cookie = "modulo=" + janP.id;
  netscape        = navigator.appName == "Netscape" ? 1 : 0; //@TODO Remove THIS

  if( typeof(JANS)=="undefined" ) {

    JANS         = new Array();
    JANS.isModal = 0;

  } else {

    for(var i = 0;i < JANS.length;i++) {
      JANS[i].guardaCorFundoTitulo = JANS[i].corFundoTitulo;
      JANS[i].setCorFundoTitulo("#A6A6A6");
    }
  }
  JANS[this.nomeJanela] = this;
  JANS.push(this);

  /**
   * Atributos
   */
  this.posX                   = janP.style.left;
  this.posY                   = janP.style.top;
  this.largura                = janP.style.width;
  this.altura                 = janP.style.height;
  this.corFundoTitulo         = cFt.style.backgroundColor;
  this.corTitulo              = cFt.firstChild.style.color;
  this.fonteTitulo            = cFt.firstChild.style.fontFamily;
  this.tamTitulo              = cFt.firstChild.style.fontSize;
  this.titulo                 = new String(cFt.firstChild.innerHTML);

  /**
   * Métodos
   *
   * Adicionado Prototype, para que seja possivel ser feita sobrecarga dos mesmos
   */
 janela.prototype.setTarget             = this.setTarget             = setTarget;
 janela.prototype.setTitulo             = this.setTitulo             = setTitulo;
 janela.prototype.setCorFundoTitulo     = this.setCorFundoTitulo     = setCorFundoTitulo;
 janela.prototype.setCorTitulo          = this.setCorTitulo          = setCorTitulo;
 janela.prototype.setFonteTitulo        = this.setFonteTitulo        = setFonteTitulo;
 janela.prototype.setTamTitulo          = this.setTamTitulo          = setTamTitulo;
 janela.prototype.setPosX               = this.setPosX               = setPosX;
 janela.prototype.setLargura            = this.setLargura            = setLargura;
 janela.prototype.setAltura             = this.setAltura             = setAltura;
 janela.prototype.setPosY               = this.setPosY               = setPosY;
 janela.prototype.setModal              = this.setModal              = setModal;
 janela.prototype.setNoModal            = this.setNoModal            = setNoModal;
 janela.prototype.show                  = this.show                  = show;
 janela.prototype.focus                 = this.focus                 = focus;
 janela.prototype.hide                  = this.hide                  = hide;
 janela.prototype.limpaTela             = this.limpaTela             = limpaTela;
 janela.prototype.mostraMsg             = this.mostraMsg             = mostraMsg;
 janela.prototype.setJanBotoes          = this.setJanBotoes          = setJanBotoes;
 janela.prototype.liberarJanBTMaximizar = this.liberarJanBTMaximizar = liberarJanBTMaximizar;
 janela.prototype.liberarJanBTFechar    = this.liberarJanBTFechar    = liberarJanBTFechar;

  /**
   * setTarget
   *
   * @access public
   * @return void
   */
  function setTarget() {
    var args = setTarget.arguments;
    var F = (typeof(args[0])=="undefined" || args[0]=="")?"form1":args[0];
    document.forms[F].target = Iframe.name;
  }

  /**
   * Define o Título da Janela
   *
   * @param t Titulo
   * @access public
   * @return void
   */
  function setTitulo(t) {

    cFt.firstChild.innerHTML = '&nbsp;' + t;
    this.titulo = new String('&nbsp;' + t);
  }

  /**
   * Define a cor de fundo do Título
   *
   * @param cor cor
   * @access public
   * @return void
   */
  function setCorFundoTitulo(cor) {

    cFt.style.backgroundColor = cor;
    this.corFundoTitulo = cor;
  }

  /**
   * Define a cor do Texto do Título
   *
   * @param cor $cor
   * @access public
   * @return void
   */
  function setCorTitulo(cor) {

    cFt.firstChild.style.color = cor;
    this.corTitulo = cor;
  }

  /**
   * Define o  "FontFamily" do titulo da Janela
   *
   * @param f $f
   * @access public
   * @return void
   */
  function setFonteTitulo(f) {
    cFt.firstChild.style.fontFamily = f;
    this.fonteTitulo = f;
  }

  /**
   * Define o Tamanho do Texto do Título da Janela
   *
   * @param t $t
   * @access public
   * @return void
   */
  function setTamTitulo(t) {
    cFt.firstChild.style.fontSize = t;
    this.tamTitulo = t;
  }

  /**
   * Define o posicionamento Horizontal da Janela
   *
   * @param pos $pos
   * @access public
   * @return void
   */
  function setPosX(pos) {
    janP.style.left = pos;
    this.posX = pos;
  }

  /**
   * Define o Posicionamento Vertical da Janela
   *
   * @param pos $pos
   * @access public
   * @return void
   */
  function setPosY(pos) {
    if(typeof(pos)!='undefined' && pos<20){
      pos = 20;
    }
    janP.style.top = pos;
    this.posY = pos;
  }

  /*
   * Define a largura (CSS) da janela
   *
   * @param l $l
   * @access public
   * @return void
   */
  function setLargura(l) {
    janP.style.width = l;
    this.largura = l;
  }

  /**
   * Define a Altura da Janela
   *
   * @param a $a
   * @access public
   * @return void
   */
  function setAltura(a) {
    janP.style.height = a;
    this.altura = a;
  }

  /**
   * Colocar  a Janela na Frente
   *
   * @access public
   * @return void
   */
  function focus() {
    janP.style.zIndex = Zindex++;
  }

  /**
   * Mostra a Janela na Tela
   *
   * @access public
   * @return void
   */
  function show() {

    empilhaJanelas(this.nomeJanela);

    if(JANS.length > 1)
      JANS[JANS.length-2].setCorFundoTitulo("#A6A6A6");
    if(JANS[this.nomeJanela].GuardaAlt) {
      setAltura(JANS[this.nomeJanela].GuardaAlt);
      setLargura(JANS[this.nomeJanela].GuardaLar);
      setPosX(JANS[this.nomeJanela].GuardaPoX);
      setPosY(JANS[this.nomeJanela].GuardaPoY);
    }
    janP.style.visibility = 'visible';
  }

  /**
   * Esconde a Janela
   *
   * @access public
   * @return void
   */
  function hide() {

    var aux = JANS[JANS.length-1];
    for(var i = JANS.length-1;i > 0;i--) {
      JANS[i] = JANS[i - 1];
    }
    JANS[0] = aux;
    JANS[JANS.length-1].setCorFundoTitulo("#326094");
    janP.style.visibility = 'hidden';
    JANS[this.nomeJanela].GuardaAlt = this.altura;
    JANS[this.nomeJanela].GuardaLar = this.largura;
    JANS[this.nomeJanela].GuardaPoX = this.posX;
    JANS[this.nomeJanela].GuardaPoY = this.posY;
  }

  function procuraNo(obj,nome) {
    nome = nome.toUpperCase();

    if(obj.childNodes.length > 0) {

      for(var i = 0;i < obj.childNodes.length;i++) {

        if(obj.childNodes[i].nodeName == nome) {

          try {
            ObjRet = obj.childNodes[i];
          } catch(e) {}
          return true;
        }
        procuraNo(obj.childNodes[i],nome);
      }
    }
  }

  /**
   * Limpa o Conteudo da Janela
   *
   * @access public
   * @return void
   */
  function limpaTela() {
    procuraNo(Iframe.document,"body");
    corpo = ObjRet;//vem da funcao procuraNo
    var documento = corpo.childNodes;
    do {
      for(var i = 0;i < documento.length;i++) {
        corpo.removeChild(documento[i]);
      }
    } while(documento.length != 0);
  }

  /**
   * Mostra mensagem na Janela
   *
   * @access public
   * @return void
   */
  function mostraMsg() {

    var args = mostraMsg.arguments;
    var msg  = (typeof(args[0])=="undefined" || args[0]=="")?"Processando...":args[0];
    var cor  = (typeof(args[1])=="undefined" || args[1]=="")?"white":args[1];
    var Larg = (typeof(args[2])=="undefined" || args[2]=="")?this.moldura.style.width:args[2];
    var Alt  = (typeof(args[3])=="undefined" || args[3]=="")?this.moldura.style.height:args[3];
    var PosX = (typeof(args[4])=="undefined" || args[4]=="")?"0":args[4];
    var PosY = (typeof(args[5])=="undefined" || args[5]=="")?"0":args[5];

    if(elem = document.getElementById("mensagem") )
      elem.parentNode.removeChild(elem);
    var camada = Iframe.document.createElement("DIV");
    camada.setAttribute("id","mensagem");

    procuraNo(Iframe.document,"body");
    try {
      ObjRet.appendChild(camada);
      var elem = Iframe.document.getElementById("mensagem");
      elem.innerHTML = "<table border='0' cellpadding='0' cellspacing='0'><tr><td width='" + Larg + "' height='" + Alt + "' align='center' valign='middle'><strong>" + msg + "</strong></td></tr></table>";
      elem.style.backgroundColor = cor;
      elem.style.layerBackgroundColor = cor;
      elem.style.position = "absolute";
      elem.style.left = "0px";
      elem.style.top = "0px";
      elem.style.zIndex = "100";
      elem.style.visibility = 'visible';
      elem.style.width = Larg;
      elem.style.height = Alt;
    } catch(e) {
    }
  }


  /**
   * Define os Botões da Janela
   *
   * @param str $str
   * @access public
   * @return void
   */
  function setJanBotoes(str) {

    var s          = new String(str);
    var img1       = cFt.childNodes[1].childNodes[0];
    var img2       = cFt.childNodes[1].childNodes[1];
    var img3       = cFt.childNodes[1].childNodes[2];
    this.btnFechar = img3;

    kp       = 0x4;
    m        = kp & s;
    kp     >>= 1;
    img1.src = m ? "skins/img.php?file=Controles/jan_mini_on.png":"skins/img.php?file=Controles/jan_mini_off.png";

    m        = kp & s;
    kp     >>= 1;
    img2.src = m ? "skins/img.php?file=Controles/jan_max_on.png":"skins/img.php?file=Controles/jan_max_off.png";

    m        = kp & s;
    kp     >>= 1;
    img3.src = m ? "skins/img.php?file=Controles/jan_fechar_on.png":"skins/img.php?file=Controles/jan_fechar_off.png";
  }


  function liberarJanBTMinimizar(liberar){

    var img1 = cFt.childNodes[1].childNodes[0];
    if(liberar == true){

      img1.src   = "skins/img.php?file=Controles/jan_mini_on.png";
      img1.title = "Minimizar";
    }else{

      img1.src   = "skins/img.php?file=Controles/jan_mini_off.png";
      img1.title = "Minimizar desabilitado";
    }
  }

  this.liberarJanBTMinimizar = liberarJanBTMinimizar;

  function liberarJanBTMaximizar(liberar){
    var img2 = cFt.childNodes[1].childNodes[1];
    if(liberar == true){
      img2.src   = "skins/img.php?file=Controles/jan_max_on.png";
      img2.title = "Maximizar";
    }else{
      img2.src   = "skins/img.php?file=Controles/jan_max_off.png";
      img2.title = "Maximizar desabilitado";
    }
  }


  function liberarJanBTFechar(liberar){
    var img3 = cFt.childNodes[1].childNodes[2];
    if(liberar == true){
      img3.src   = "skins/img.php?file=Controles/jan_fechar_on.png";
      img3.title = "Fechar";
    }else{
      img3.src   = "skins/img.php?file=Controles/jan_fechar_off.png";
      img3.title = "Fechar desabilitado";
    }
  }



  function setModal() {
    JANS.isModal = 1;
  }
  function setNoModal() {
    JANS.isModal = 0;
  }
}//fim da classe janela

var engaged = false;
var offsetX = 0;
var offsetY = 0;
var Zindex = 5;

function js_dragIt(obj,evt) {
  evt = (evt) ? evt : (window.event) ? window.event : "";
  if(engaged) {
    var jAn = eval(obj);
    if (evt.pageX) {
      jAn.setPosX(evt.pageX - offsetX + "px");
      jAn.setPosY(evt.pageY - offsetY + "px");
    } else {
      jAn.setPosX(evt.clientX - offsetX + "px");
      jAn.setPosY(evt.clientY - offsetY + "px");
    }
    return false;
  }
}
function js_engage(obj,evt) {

  //evt = (evt) ? evt : (window.event) ? window.event : "SEM EVENTO";
  evt = evt || window.event || "SEM EVENTO";

  if(JANS.isModal == 1) {
    return false;
  }

  SetCookie("modulo", obj.id);

  engaged = true;

  obj.style.zIndex = Zindex++;

  empilhaJanelas(obj.id.substr(3));

  for(var i = 0;i < JANS.length - 1;i++) {
    JANS[i].guardaCorFundoTitulo = JANS[i].corFundoTitulo;
    JANS[i].setCorFundoTitulo("#A6A6A6");
  }

  JANS[obj.id.substr(3)].setCorFundoTitulo("#326094");

  if (evt.pageX) {

    offsetX = evt.pageX - obj.offsetLeft;
    offsetY = evt.pageY - obj.offsetTop;
  } else {

    offsetX = evt.offsetX - document.body.scrollLeft;
    offsetY = evt.offsetY - document.body.scrollTop;

    if (navigator.userAgent.indexOf("Win") == -1) {

      offsetX += document.body.scrollLeft;
      offsetY += document.body.scrollTop;
    }
  }
  return false;
}
function js_release(obj,evt) {
  evt = (evt) ? evt : (window.event) ? window.event : "";
  engaged = false;
}
function empilhaJanelas(nomeJan) {
  for(var i = 0;i < JANS.length;i++)
    if(JANS[i].nomeJanela == nomeJan) {
      var indice = i;
      aux = JANS[i];
      break;
    }
  for(i = indice;i < JANS.length - 1;i++)
    JANS[i] = JANS[i+1];
  JANS[i] = aux;
  if(typeof(pos)!='undefined' && pos<20){
    pos = 20;
  };
}
function js_MaximizarJan(img,cod) {
  if(JANS.isModal == 1)
    return false;
  var str = new String(img.src);
  if(str.indexOf("on") == -1)
    return false;
}

function js_MinimizarJan(img,JanElA) {
  var janela = eval(JanElA);
  if(JANS.isModal == 1)
    return false;

  var str = new String(img.src);
  if(str.indexOf("on") == -1)
    return false;
  else {
    if(janela.nomeJanela == JANS[JANS.length-1].nomeJanela) {
      JANS[JANS.length-1].guardaCorFundoTitulo = JANS[JANS.length-1].corFundoTitulo;
      JANS[JANS.length-1].setCorFundoTitulo("#A6A6A6");
      var aux = JANS[JANS.length-1];
      for(var i = JANS.length-1;i > 0;i--) {
        JANS[i] = JANS[i - 1];
      }
      JANS[0] = aux;
      JANS[JANS.length-1].setCorFundoTitulo("#326094");

    }
    str = new String(img.src);
    if(str.indexOf("max") == -1) {
      JanPosX = (typeof(JanPosX)=="undefined" || JanPosX=="")?1:JanPosX;
      JanPosY = (typeof(JanPosY)=="undefined" || JanPosY=="")?400:JanPosY;
      if(JanPosX >= 600) {
        JanPosX = 1;
        JanPosY = JanPosY - 27;
      }
      if(typeof(janela.px) == "undefined" && typeof(janela.py) == "undefined") {
        janela.px = JanPosX;
        janela.py = JanPosY;
        janela.Wi = janela.moldura.style.width;
        janela.Hi = janela.moldura.style.height;
        janela.Pl = janela.moldura.style.left;
        janela.Pt = janela.moldura.style.top;
        JanPosX += (janela.titulo.length * 5) + 52;
      }
      janela.setAltura(1);
      janela.setLargura(1);
      janela.setPosX(janela.px);
      janela.setPosY(janela.py);
      img.src = 'skins/img.php?file=Controles/jan_max_on.png';
    } else {
      img.src = 'skins/img.php?file=Controles/jan_mini_on.png';
      janela.setAltura(janela.Hi);
      janela.setLargura(janela.Wi);
      janela.setPosX(janela.Pl);
      janela.setPosY(janela.Pt);
      janela.focus();
      SetCookie("modulo",janela.nomeJanela);

      var aux = JANS[janela.nomeJanela];
      var j = 0;
      for(var i = 0;i < JANS.length;i++) {
        if(aux.nomeJanela != JANS[i].nomeJanela)
          JANS[j++] = JANS[i];
      }
      JANS[JANS.length-2].guardaCorFundoTitulo = JANS[JANS.length-2].corFundoTitulo;
      JANS[JANS.length-2].setCorFundoTitulo("#A6A6A6");
      JANS[JANS.length-1] = aux;
      JANS[JANS.length-1].setCorFundoTitulo("#326094");
    }
  }
}

function js_FecharJan(iMgsSs,JanElAaX) {
  var StRrINNgs = new String(iMgsSs.src);
  if(StRrINNgs.indexOf("on") == -1)
    return false;
  else {
    if(JANS.isModal == 1) {
      if(JANS[JANS.length-1].nomeJanela != this.nomeJanela)
        return false;
    }
    var jAaneEllAa = eval(JanElAaX);
    if(jAaneEllAa.onJanHide != null) {
      eval(jAaneEllAa.onJanHide);
      return false;
    }
    jAaneEllAa.hide();
    return true;
  }
}

function criaJanela(nomeJan,arquivo,cabecalho,visivel,topo,esquerda,altura,largura) {

  var camada  = document.createElement("DIV");
  var tabela1 = document.createElement("TABLE");
  var tabela2 = document.createElement("TABLE");
  var quadro  = document.createElement("IFRAME");
  var img1    = document.createElement("IMG");
  this.img3   = document.createElement("IMG");

  img3.setAttribute("src","skins/img.php?file=Controles/jan_fechar_on.png");
  img3.setAttribute("title","Fechar");
  img3.setAttribute("id","fechar"+nomeJan);
  img3.setAttribute("style", "margin-left: 2px; margin-right: 2px;");
  img3.setAttribute("border","0");

  img3.onclick = function() { js_FecharJan(this,nomeJan); };
  this.btnFechar = img3;

  img1.setAttribute("src","skins/img.php?file=Controles/jan_mini_on.png");
  img1.setAttribute("title","Minimizar");
  img1.setAttribute("border","0");
  img1.setAttribute("id","minimizar"+nomeJan);

  img1.onclick = function() { js_MinimizarJan(this,nomeJan); };

  camada.setAttribute("id","Jan" + nomeJan);
  camada.setAttribute("class","DBJanelaIframe");
  camada.setAttribute("framename", "IF"+nomeJan);
  tabela1.setAttribute("cellSpacing",0);
  tabela1.setAttribute("cellPadding",2);
  tabela1.setAttribute("border",0);
  tabela1.setAttribute("width","100%");
  tabela1.setAttribute("height","100%");

  tabela1.style.borderColor = "#f0f0f0 #606060 #404040 #d0d0d0";
  tabela1.style.borderStyle = "solid";
  tabela1.style.borderWidth = "2px";

  tabela2.setAttribute("cellSpacing",0);
  tabela2.setAttribute("cellPadding",0);
  tabela2.setAttribute("border",0);
  tabela2.setAttribute("width","100%");

  quadro.setAttribute("frameBorder","1");
  quadro.setAttribute("height","100%");
  quadro.setAttribute("width","100%");
  quadro.setAttribute("id","IF" + nomeJan);
  quadro.setAttribute("name","IF" + nomeJan);
  quadro.setAttribute("scrolling","auto");

  var tab1Linha1 = tabela1.insertRow(0);
  var tab1Linha2 = tabela1.insertRow(1);
  var tab2Linha1 = tabela2.insertRow(0);

  var tab1Coluna1 = tab1Linha1.insertCell(0);
  var tab1Coluna2 = tab1Linha2.insertCell(0);
  var tab2Coluna1 = tab2Linha1.insertCell(0);
  var tab2Coluna2 = tab2Linha1.insertCell(1);

  tab2Linha1.setAttribute("id","CF" + nomeJan);
  tab2Linha1.style.backgroundColor = '#326094';
  tab1Linha1.style.backgroundColor = '#c0c0c0';
  tab2Coluna1.style.whiteSpace = "nowrap";
  tab2Coluna1.onmousedown = function(event) { js_engage(document.getElementById('Jan' + nomeJan),event);};
  tab2Coluna1.onmouseup = function(event) { js_release(document.getElementById('Jan' + nomeJan),event);};
  tab2Coluna1.onmousemove = function(event) { js_dragIt(nomeJan,event);};
  tab2Coluna1.onmouseout = function(event) { js_release(document.getElementById('Jan' + nomeJan),event);};
  tab2Coluna1.setAttribute("width","80%");

  tab2Coluna1.style.fontWeight = 'bold';
  tab2Coluna1.style.color = 'white';
  tab2Coluna1.className  = 'DBJanelaIframeTitulo';
  tab2Coluna1.style.fontFamily = 'Arial, Helvetica, sans-serif';
  tab2Coluna1.style.fontSize = '11px';
  tab2Coluna1.innerHTML =  (typeof(cabecalho)=="undefined" || cabecalho=="")?'&nbsp; DBSeller Informática Ltda':('&nbsp;' + cabecalho);

  tab2Coluna1.setAttribute("nowrap","1");
  tab2Coluna2.setAttribute("nowrap","1");
  tab2Coluna2.setAttribute("width","20%");
  tab2Coluna2.setAttribute("align","right");
  tab2Coluna2.setAttribute("valign","middle");

  tab1Coluna2.setAttribute("width","100%");
  tab1Coluna2.setAttribute("height","100%");
  camada.style.backgroundColor      = "#c0c0c0";
  camada.style.layerBackgroundColor = "#c0c0c0";
  camada.style.border               = "0px outset #666666";
  camada.style.position             = "absolute";
  camada.style.left                 = esquerda;
  camada.style.top                  = topo;
  camada.style.zIndex               = "1";
  camada.style.visibility           = 'hidden';
  camada.style.width                = altura;
  camada.style.height               = largura;
  tab2Coluna2.appendChild(img1);
  tab2Coluna2.appendChild(img3);
  tab1Coluna1.appendChild(tabela2);
  tab1Coluna2.appendChild(quadro);
  camada.appendChild(tabela1);
  document.body.appendChild(camada);

  eval(nomeJan + " = new janela(document.getElementById('Jan" + nomeJan + "'),document.getElementById('CF" + nomeJan + "'),IF" + nomeJan + ")");
  document.getElementById('IF' + nomeJan).src = arquivo;

  eval(nomeJan + ".focus()");
  return eval(nomeJan);
}


/**
 * FIM DAS FUNÇÔES PARA JANELA
 */

document.addEventListener('DOMContentLoaded', function() {

  if (!this['Ajax']) {
    return;
  }

  var oParametros = {
    screen: {
      width: top.screen.width,
      height: top.screen.height,
      availWidth: top.screen.availWidth,
      availHeight: top.screen.availHeight
    },
    userAgent: top.navigator.userAgent,
    exec: "coletaInfoCliente"
  }

  if (top.performance && top.performance.timing) {
    oParametros.timing = top.performance.timing;
  }

  var oRequisicao = {
    method       : 'POST',
    asynchronous : true,
    parameters   : 'json='+JSON.stringify(oParametros)
  }

  new Ajax.Request("con1_usuariosistema.RPC.php", oRequisicao);

});

/**
 * Carrega a resposta da url informada por parâmetro no respectivo elemento.
 *
 * @exemple document.body.load('teste.php', function(lRetorno){ alert(lRetorno)});
 * @param  {Strind} sUrl      URL a ser carregada
 * @param  {Function} fCallback Função para callback
 * @return - false: erros status de requisicao >= 400, envia false para o callback
 *         - true: seta o retorno no elemento, e envia true para o callback
 *
 */
Element.prototype.load = function (sUrl, fCallback) {

  "use strict";
  fCallback = fCallback || function(){};
  var oElemento = this;

  var oRequisicao = new XMLHttpRequest();
      oRequisicao.open('GET', sUrl, false);
      oRequisicao.setRequestHeader("Content-type", "application/x-www-form-urlencoded; charset=ISO-8859-1");
      oRequisicao.overrideMimeType("application/x-www-form-urlencoded; charset=ISO-8859-1");
      oRequisicao.send(null);

  if ( oRequisicao.status >= 400 ) {

    console.error('Não foi possível carregar o conteúdo solicitado.');

    if (fCallback !== null) {
      fCallback(false);
    }

    return false;
  }

  var sHtml                = oRequisicao.responseText;
  oElemento.innerHTML += sHtml;

  if (fCallback !== null) {
    fCallback(true);
  }

  return true;
}

var loaded = false;
window.onload= function () {
  loaded = true;
}

function tratamentoMascaraTelefone( mValor,  isOnBlur ) {

  if ( mValor != '' ) {
    mValor = mValor.replace(/\D/g,"");
    mValor = mValor.replace(/^(\d{2})(\d)/g,"($1) $2");

    if( isOnBlur ) {
      mValor = mValor.replace(/(\d)(\d{4})$/,"$1-$2");
    } else {
      mValor = mValor.replace(/(\d)(\d{3})$/,"$1-$2");
    }
  }

  return mValor;
}

/**
 * Função para adicionar uma mascara padrão ao telefone
 * Formato: (xx)xxxx-xxxx | (xx)xxxxx-xxxx
 * @param oElemento - Elemento HTML que contem o telefone a ser digitado
 */
function mascaraTelefone( oElemento ) {

  oElemento.onkeypress = function (evt) {

    var code  = (window.event)? window.event.keyCode : evt.which;
    var valor = this.value;

    if(code > 57 || (code < 48 && code != 8 && code != 9))  {
      return false;
    } else {
      this.value = tratamentoMascaraTelefone(valor, false);
    }
  };

  oElemento.onblur = function() {
    this.value = tratamentoMascaraTelefone( this.value, true );
  };

  oElemento.maxLength = 15;
}

/**
 * Função que aplica máscara de valor monetário no textfield
 * formato [999999999.99]
 *
 * @param  {object} obj
 * @param  {event} e
 *
 * @return boolean
 */
function validaMonetario(obj, e) {

  if (!js_mask(e, '0-9|.|,|-')) {
    obj.value = '';
    return false;
  }

  setTimeout(function() {

    mValor = obj.value;
    mValor = mValor.replace(/\D/g,"");
    mValor = mValor.replace(/(\d)(\d{2})$/,"$1.$2");
    obj.value = mValor;
    return true;
  }, 1);

  var regDecimal = /^(|[0-9]+)(|(\.|,)(|[0-9]+))$/;

   if ( !regDecimal.test(obj.value) ) {
    obj.disabled = true;
    alert("Este campo deve ser preenchido somente com números decimais!" );
    obj.disabled = false;
    obj.value = '';
    obj.focus();
    return false;
  }
}


//Polyfill
if (typeof Object.toSource == "undefined") { // only if necessary
    
    // a valid JavaScript ID RegExp
    // https://github.com/mathiasbynens/mothereff.in/tree/master/js-variables
    var js_id = /^(?!(?:do|if|in|for|let|new|try|var|case|else|enum|eval|null|this|true|void|with|break|catch|class|const|false|super|throw|while|yield|delete|export|import|public|return|static|switch|typeof|default|extends|finally|package|private|continue|debugger|function|arguments|interface|protected|implements|instanceof)$)[\x24A-Z\x5Fa-z\xAA\xB5\xBA\xC0-\xD6\xD8-\xF6\xF8-\u02C1\u02C6-\u02D1\u02E0-\u02E4\u02EC\u02EE\u0370-\u0374\u0376\u0377\u037A-\u037D\u0386\u0388-\u038A\u038C\u038E-\u03A1\u03A3-\u03F5\u03F7-\u0481\u048A-\u0527\u0531-\u0556\u0559\u0561-\u0587\u05D0-\u05EA\u05F0-\u05F2\u0620-\u064A\u066E\u066F\u0671-\u06D3\u06D5\u06E5\u06E6\u06EE\u06EF\u06FA-\u06FC\u06FF\u0710\u0712-\u072F\u074D-\u07A5\u07B1\u07CA-\u07EA\u07F4\u07F5\u07FA\u0800-\u0815\u081A\u0824\u0828\u0840-\u0858\u08A0\u08A2-\u08AC\u0904-\u0939\u093D\u0950\u0958-\u0961\u0971-\u0977\u0979-\u097F\u0985-\u098C\u098F\u0990\u0993-\u09A8\u09AA-\u09B0\u09B2\u09B6-\u09B9\u09BD\u09CE\u09DC\u09DD\u09DF-\u09E1\u09F0\u09F1\u0A05-\u0A0A\u0A0F\u0A10\u0A13-\u0A28\u0A2A-\u0A30\u0A32\u0A33\u0A35\u0A36\u0A38\u0A39\u0A59-\u0A5C\u0A5E\u0A72-\u0A74\u0A85-\u0A8D\u0A8F-\u0A91\u0A93-\u0AA8\u0AAA-\u0AB0\u0AB2\u0AB3\u0AB5-\u0AB9\u0ABD\u0AD0\u0AE0\u0AE1\u0B05-\u0B0C\u0B0F\u0B10\u0B13-\u0B28\u0B2A-\u0B30\u0B32\u0B33\u0B35-\u0B39\u0B3D\u0B5C\u0B5D\u0B5F-\u0B61\u0B71\u0B83\u0B85-\u0B8A\u0B8E-\u0B90\u0B92-\u0B95\u0B99\u0B9A\u0B9C\u0B9E\u0B9F\u0BA3\u0BA4\u0BA8-\u0BAA\u0BAE-\u0BB9\u0BD0\u0C05-\u0C0C\u0C0E-\u0C10\u0C12-\u0C28\u0C2A-\u0C33\u0C35-\u0C39\u0C3D\u0C58\u0C59\u0C60\u0C61\u0C85-\u0C8C\u0C8E-\u0C90\u0C92-\u0CA8\u0CAA-\u0CB3\u0CB5-\u0CB9\u0CBD\u0CDE\u0CE0\u0CE1\u0CF1\u0CF2\u0D05-\u0D0C\u0D0E-\u0D10\u0D12-\u0D3A\u0D3D\u0D4E\u0D60\u0D61\u0D7A-\u0D7F\u0D85-\u0D96\u0D9A-\u0DB1\u0DB3-\u0DBB\u0DBD\u0DC0-\u0DC6\u0E01-\u0E30\u0E32\u0E33\u0E40-\u0E46\u0E81\u0E82\u0E84\u0E87\u0E88\u0E8A\u0E8D\u0E94-\u0E97\u0E99-\u0E9F\u0EA1-\u0EA3\u0EA5\u0EA7\u0EAA\u0EAB\u0EAD-\u0EB0\u0EB2\u0EB3\u0EBD\u0EC0-\u0EC4\u0EC6\u0EDC-\u0EDF\u0F00\u0F40-\u0F47\u0F49-\u0F6C\u0F88-\u0F8C\u1000-\u102A\u103F\u1050-\u1055\u105A-\u105D\u1061\u1065\u1066\u106E-\u1070\u1075-\u1081\u108E\u10A0-\u10C5\u10C7\u10CD\u10D0-\u10FA\u10FC-\u1248\u124A-\u124D\u1250-\u1256\u1258\u125A-\u125D\u1260-\u1288\u128A-\u128D\u1290-\u12B0\u12B2-\u12B5\u12B8-\u12BE\u12C0\u12C2-\u12C5\u12C8-\u12D6\u12D8-\u1310\u1312-\u1315\u1318-\u135A\u1380-\u138F\u13A0-\u13F4\u1401-\u166C\u166F-\u167F\u1681-\u169A\u16A0-\u16EA\u16EE-\u16F0\u1700-\u170C\u170E-\u1711\u1720-\u1731\u1740-\u1751\u1760-\u176C\u176E-\u1770\u1780-\u17B3\u17D7\u17DC\u1820-\u1877\u1880-\u18A8\u18AA\u18B0-\u18F5\u1900-\u191C\u1950-\u196D\u1970-\u1974\u1980-\u19AB\u19C1-\u19C7\u1A00-\u1A16\u1A20-\u1A54\u1AA7\u1B05-\u1B33\u1B45-\u1B4B\u1B83-\u1BA0\u1BAE\u1BAF\u1BBA-\u1BE5\u1C00-\u1C23\u1C4D-\u1C4F\u1C5A-\u1C7D\u1CE9-\u1CEC\u1CEE-\u1CF1\u1CF5\u1CF6\u1D00-\u1DBF\u1E00-\u1F15\u1F18-\u1F1D\u1F20-\u1F45\u1F48-\u1F4D\u1F50-\u1F57\u1F59\u1F5B\u1F5D\u1F5F-\u1F7D\u1F80-\u1FB4\u1FB6-\u1FBC\u1FBE\u1FC2-\u1FC4\u1FC6-\u1FCC\u1FD0-\u1FD3\u1FD6-\u1FDB\u1FE0-\u1FEC\u1FF2-\u1FF4\u1FF6-\u1FFC\u2071\u207F\u2090-\u209C\u2102\u2107\u210A-\u2113\u2115\u2119-\u211D\u2124\u2126\u2128\u212A-\u212D\u212F-\u2139\u213C-\u213F\u2145-\u2149\u214E\u2160-\u2188\u2C00-\u2C2E\u2C30-\u2C5E\u2C60-\u2CE4\u2CEB-\u2CEE\u2CF2\u2CF3\u2D00-\u2D25\u2D27\u2D2D\u2D30-\u2D67\u2D6F\u2D80-\u2D96\u2DA0-\u2DA6\u2DA8-\u2DAE\u2DB0-\u2DB6\u2DB8-\u2DBE\u2DC0-\u2DC6\u2DC8-\u2DCE\u2DD0-\u2DD6\u2DD8-\u2DDE\u2E2F\u3005-\u3007\u3021-\u3029\u3031-\u3035\u3038-\u303C\u3041-\u3096\u309D-\u309F\u30A1-\u30FA\u30FC-\u30FF\u3105-\u312D\u3131-\u318E\u31A0-\u31BA\u31F0-\u31FF\u3400-\u4DB5\u4E00-\u9FCC\uA000-\uA48C\uA4D0-\uA4FD\uA500-\uA60C\uA610-\uA61F\uA62A\uA62B\uA640-\uA66E\uA67F-\uA697\uA6A0-\uA6EF\uA717-\uA71F\uA722-\uA788\uA78B-\uA78E\uA790-\uA793\uA7A0-\uA7AA\uA7F8-\uA801\uA803-\uA805\uA807-\uA80A\uA80C-\uA822\uA840-\uA873\uA882-\uA8B3\uA8F2-\uA8F7\uA8FB\uA90A-\uA925\uA930-\uA946\uA960-\uA97C\uA984-\uA9B2\uA9CF\uAA00-\uAA28\uAA40-\uAA42\uAA44-\uAA4B\uAA60-\uAA76\uAA7A\uAA80-\uAAAF\uAAB1\uAAB5\uAAB6\uAAB9-\uAABD\uAAC0\uAAC2\uAADB-\uAADD\uAAE0-\uAAEA\uAAF2-\uAAF4\uAB01-\uAB06\uAB09-\uAB0E\uAB11-\uAB16\uAB20-\uAB26\uAB28-\uAB2E\uABC0-\uABE2\uAC00-\uD7A3\uD7B0-\uD7C6\uD7CB-\uD7FB\uF900-\uFA6D\uFA70-\uFAD9\uFB00-\uFB06\uFB13-\uFB17\uFB1D\uFB1F-\uFB28\uFB2A-\uFB36\uFB38-\uFB3C\uFB3E\uFB40\uFB41\uFB43\uFB44\uFB46-\uFBB1\uFBD3-\uFD3D\uFD50-\uFD8F\uFD92-\uFDC7\uFDF0-\uFDFB\uFE70-\uFE74\uFE76-\uFEFC\uFF21-\uFF3A\uFF41-\uFF5A\uFF66-\uFFBE\uFFC2-\uFFC7\uFFCA-\uFFCF\uFFD2-\uFFD7\uFFDA-\uFFDC][\x240-9A-Z\x5Fa-z\xAA\xB5\xBA\xC0-\xD6\xD8-\xF6\xF8-\u02C1\u02C6-\u02D1\u02E0-\u02E4\u02EC\u02EE\u0300-\u0374\u0376\u0377\u037A-\u037D\u0386\u0388-\u038A\u038C\u038E-\u03A1\u03A3-\u03F5\u03F7-\u0481\u0483-\u0487\u048A-\u0527\u0531-\u0556\u0559\u0561-\u0587\u0591-\u05BD\u05BF\u05C1\u05C2\u05C4\u05C5\u05C7\u05D0-\u05EA\u05F0-\u05F2\u0610-\u061A\u0620-\u0669\u066E-\u06D3\u06D5-\u06DC\u06DF-\u06E8\u06EA-\u06FC\u06FF\u0710-\u074A\u074D-\u07B1\u07C0-\u07F5\u07FA\u0800-\u082D\u0840-\u085B\u08A0\u08A2-\u08AC\u08E4-\u08FE\u0900-\u0963\u0966-\u096F\u0971-\u0977\u0979-\u097F\u0981-\u0983\u0985-\u098C\u098F\u0990\u0993-\u09A8\u09AA-\u09B0\u09B2\u09B6-\u09B9\u09BC-\u09C4\u09C7\u09C8\u09CB-\u09CE\u09D7\u09DC\u09DD\u09DF-\u09E3\u09E6-\u09F1\u0A01-\u0A03\u0A05-\u0A0A\u0A0F\u0A10\u0A13-\u0A28\u0A2A-\u0A30\u0A32\u0A33\u0A35\u0A36\u0A38\u0A39\u0A3C\u0A3E-\u0A42\u0A47\u0A48\u0A4B-\u0A4D\u0A51\u0A59-\u0A5C\u0A5E\u0A66-\u0A75\u0A81-\u0A83\u0A85-\u0A8D\u0A8F-\u0A91\u0A93-\u0AA8\u0AAA-\u0AB0\u0AB2\u0AB3\u0AB5-\u0AB9\u0ABC-\u0AC5\u0AC7-\u0AC9\u0ACB-\u0ACD\u0AD0\u0AE0-\u0AE3\u0AE6-\u0AEF\u0B01-\u0B03\u0B05-\u0B0C\u0B0F\u0B10\u0B13-\u0B28\u0B2A-\u0B30\u0B32\u0B33\u0B35-\u0B39\u0B3C-\u0B44\u0B47\u0B48\u0B4B-\u0B4D\u0B56\u0B57\u0B5C\u0B5D\u0B5F-\u0B63\u0B66-\u0B6F\u0B71\u0B82\u0B83\u0B85-\u0B8A\u0B8E-\u0B90\u0B92-\u0B95\u0B99\u0B9A\u0B9C\u0B9E\u0B9F\u0BA3\u0BA4\u0BA8-\u0BAA\u0BAE-\u0BB9\u0BBE-\u0BC2\u0BC6-\u0BC8\u0BCA-\u0BCD\u0BD0\u0BD7\u0BE6-\u0BEF\u0C01-\u0C03\u0C05-\u0C0C\u0C0E-\u0C10\u0C12-\u0C28\u0C2A-\u0C33\u0C35-\u0C39\u0C3D-\u0C44\u0C46-\u0C48\u0C4A-\u0C4D\u0C55\u0C56\u0C58\u0C59\u0C60-\u0C63\u0C66-\u0C6F\u0C82\u0C83\u0C85-\u0C8C\u0C8E-\u0C90\u0C92-\u0CA8\u0CAA-\u0CB3\u0CB5-\u0CB9\u0CBC-\u0CC4\u0CC6-\u0CC8\u0CCA-\u0CCD\u0CD5\u0CD6\u0CDE\u0CE0-\u0CE3\u0CE6-\u0CEF\u0CF1\u0CF2\u0D02\u0D03\u0D05-\u0D0C\u0D0E-\u0D10\u0D12-\u0D3A\u0D3D-\u0D44\u0D46-\u0D48\u0D4A-\u0D4E\u0D57\u0D60-\u0D63\u0D66-\u0D6F\u0D7A-\u0D7F\u0D82\u0D83\u0D85-\u0D96\u0D9A-\u0DB1\u0DB3-\u0DBB\u0DBD\u0DC0-\u0DC6\u0DCA\u0DCF-\u0DD4\u0DD6\u0DD8-\u0DDF\u0DF2\u0DF3\u0E01-\u0E3A\u0E40-\u0E4E\u0E50-\u0E59\u0E81\u0E82\u0E84\u0E87\u0E88\u0E8A\u0E8D\u0E94-\u0E97\u0E99-\u0E9F\u0EA1-\u0EA3\u0EA5\u0EA7\u0EAA\u0EAB\u0EAD-\u0EB9\u0EBB-\u0EBD\u0EC0-\u0EC4\u0EC6\u0EC8-\u0ECD\u0ED0-\u0ED9\u0EDC-\u0EDF\u0F00\u0F18\u0F19\u0F20-\u0F29\u0F35\u0F37\u0F39\u0F3E-\u0F47\u0F49-\u0F6C\u0F71-\u0F84\u0F86-\u0F97\u0F99-\u0FBC\u0FC6\u1000-\u1049\u1050-\u109D\u10A0-\u10C5\u10C7\u10CD\u10D0-\u10FA\u10FC-\u1248\u124A-\u124D\u1250-\u1256\u1258\u125A-\u125D\u1260-\u1288\u128A-\u128D\u1290-\u12B0\u12B2-\u12B5\u12B8-\u12BE\u12C0\u12C2-\u12C5\u12C8-\u12D6\u12D8-\u1310\u1312-\u1315\u1318-\u135A\u135D-\u135F\u1380-\u138F\u13A0-\u13F4\u1401-\u166C\u166F-\u167F\u1681-\u169A\u16A0-\u16EA\u16EE-\u16F0\u1700-\u170C\u170E-\u1714\u1720-\u1734\u1740-\u1753\u1760-\u176C\u176E-\u1770\u1772\u1773\u1780-\u17D3\u17D7\u17DC\u17DD\u17E0-\u17E9\u180B-\u180D\u1810-\u1819\u1820-\u1877\u1880-\u18AA\u18B0-\u18F5\u1900-\u191C\u1920-\u192B\u1930-\u193B\u1946-\u196D\u1970-\u1974\u1980-\u19AB\u19B0-\u19C9\u19D0-\u19D9\u1A00-\u1A1B\u1A20-\u1A5E\u1A60-\u1A7C\u1A7F-\u1A89\u1A90-\u1A99\u1AA7\u1B00-\u1B4B\u1B50-\u1B59\u1B6B-\u1B73\u1B80-\u1BF3\u1C00-\u1C37\u1C40-\u1C49\u1C4D-\u1C7D\u1CD0-\u1CD2\u1CD4-\u1CF6\u1D00-\u1DE6\u1DFC-\u1F15\u1F18-\u1F1D\u1F20-\u1F45\u1F48-\u1F4D\u1F50-\u1F57\u1F59\u1F5B\u1F5D\u1F5F-\u1F7D\u1F80-\u1FB4\u1FB6-\u1FBC\u1FBE\u1FC2-\u1FC4\u1FC6-\u1FCC\u1FD0-\u1FD3\u1FD6-\u1FDB\u1FE0-\u1FEC\u1FF2-\u1FF4\u1FF6-\u1FFC\u200C\u200D\u203F\u2040\u2054\u2071\u207F\u2090-\u209C\u20D0-\u20DC\u20E1\u20E5-\u20F0\u2102\u2107\u210A-\u2113\u2115\u2119-\u211D\u2124\u2126\u2128\u212A-\u212D\u212F-\u2139\u213C-\u213F\u2145-\u2149\u214E\u2160-\u2188\u2C00-\u2C2E\u2C30-\u2C5E\u2C60-\u2CE4\u2CEB-\u2CF3\u2D00-\u2D25\u2D27\u2D2D\u2D30-\u2D67\u2D6F\u2D7F-\u2D96\u2DA0-\u2DA6\u2DA8-\u2DAE\u2DB0-\u2DB6\u2DB8-\u2DBE\u2DC0-\u2DC6\u2DC8-\u2DCE\u2DD0-\u2DD6\u2DD8-\u2DDE\u2DE0-\u2DFF\u2E2F\u3005-\u3007\u3021-\u302F\u3031-\u3035\u3038-\u303C\u3041-\u3096\u3099\u309A\u309D-\u309F\u30A1-\u30FA\u30FC-\u30FF\u3105-\u312D\u3131-\u318E\u31A0-\u31BA\u31F0-\u31FF\u3400-\u4DB5\u4E00-\u9FCC\uA000-\uA48C\uA4D0-\uA4FD\uA500-\uA60C\uA610-\uA62B\uA640-\uA66F\uA674-\uA67D\uA67F-\uA697\uA69F-\uA6F1\uA717-\uA71F\uA722-\uA788\uA78B-\uA78E\uA790-\uA793\uA7A0-\uA7AA\uA7F8-\uA827\uA840-\uA873\uA880-\uA8C4\uA8D0-\uA8D9\uA8E0-\uA8F7\uA8FB\uA900-\uA92D\uA930-\uA953\uA960-\uA97C\uA980-\uA9C0\uA9CF-\uA9D9\uAA00-\uAA36\uAA40-\uAA4D\uAA50-\uAA59\uAA60-\uAA76\uAA7A\uAA7B\uAA80-\uAAC2\uAADB-\uAADD\uAAE0-\uAAEF\uAAF2-\uAAF6\uAB01-\uAB06\uAB09-\uAB0E\uAB11-\uAB16\uAB20-\uAB26\uAB28-\uAB2E\uABC0-\uABEA\uABEC\uABED\uABF0-\uABF9\uAC00-\uD7A3\uD7B0-\uD7C6\uD7CB-\uD7FB\uF900-\uFA6D\uFA70-\uFAD9\uFB00-\uFB06\uFB13-\uFB17\uFB1D-\uFB28\uFB2A-\uFB36\uFB38-\uFB3C\uFB3E\uFB40\uFB41\uFB43\uFB44\uFB46-\uFBB1\uFBD3-\uFD3D\uFD50-\uFD8F\uFD92-\uFDC7\uFDF0-\uFDFB\uFE00-\uFE0F\uFE20-\uFE26\uFE33\uFE34\uFE4D-\uFE4F\uFE70-\uFE74\uFE76-\uFEFC\uFF10-\uFF19\uFF21-\uFF3A\uFF3F\uFF41-\uFF5A\uFF66-\uFFBE\uFFC2-\uFFC7\uFFCA-\uFFCF\uFFD2-\uFFD7\uFFDA-\uFFDC]*$/;
    
    
    /**
     * Escapes quotes and line breaks in a string
     */
    function escape2(str){
        str = str.replace(/"/g, "\\\"");
        str = str.replace(/\n/g, "\\n");
        str = str.replace(/\r/g, "\\r");
        return str;
    }
    
    /**
     * Returns the source of this Number
     */
    Number.prototype.toSource = function () {
        return "(new Number(" + this.toString() + "))";
    }

    /**
     * Returns the source of this Boolean
     */
    Boolean.prototype.toSource = function () {
        return "(new Boolean(" + this.toString() + "))";
    }

    /**
     * Returns the source of this String
     */
    String.prototype.toSource = function () {
        var source = escape2(this);
        return "(new String(\"" + source + "\"))";
    }

    /**
     * Returns the source of a this Function
     */
    Function.prototype.toSource = function () {
        return this.toString();
    }

    /**
     * Returns the source of this Array
     */
    Array.prototype.toSource = function () {
        return _arrayToSource(this, []);
    };
    
    function _arrayToSource(arr, visited) {
        visited.push(arr);
        var source = "[";

        arr.forEach(function (el, i, arr) {
            switch (typeof el) {
                case "number":
                case "boolean":
                    source += el.toString();
                    break;
                case "string":
                    var str = escape2(el);
                    source += "\"" + str + "\"";
                    break;
                case "function":
                case "object":
                    if (el instanceof Function
                            || el instanceof Date
                            || el instanceof RegExp
                            || el instanceof Error) {
                        source += el.toSource();
                    } else if (el instanceof Array) {
                        source += (visited.indexOf(el) == -1)
                            ? _arrayToSource(el, visited)
                            : "[]";
                    } else if (el instanceof Object) {
                        source += (visited.indexOf(el) == -1)
                            ? _objectToSource(el, visited)
                            : "{}";
                    } else {
                        source += "null";
                    }
                    break;
                default:
                    source += "null";
            }

            if (i < arr.length - 1) source += ", ";
        });

        source += "]";

        return source;
    }

    /**
     * Returns the source of this Object
     */
    Object.prototype.toSource = function () {
        return "(" + _objectToSource(this, []) + ")";
    };
    
    function _objectToSource(obj, visited){
        visited.push(obj);
        var source = "{";

        var props = Object.getOwnPropertyNames(obj);
        props.forEach(function(prop, i, arr) {
            
            var prop2 = prop;
            if (!js_id.test(prop2)) {
                // to account for property names that are invalid JS IDs
                prop2 = "'" + prop2.replace(/'/g, "\'") + "'";
            }
            
            switch (typeof obj[prop]) {
                case "number":
                case "boolean":
                    source += prop2 + ":" + obj[prop].toString();
                    break;
                case "string":
                    var str = escape2(obj[prop]);
                    source += prop2 + ":" + "\"" + str + "\"";
                    break;
                case "function":
                case "object":
                    if (obj[prop] instanceof Function
                            || obj[prop] instanceof Date
                            || obj[prop] instanceof RegExp
                            || obj[prop] instanceof Error) {
                        source += prop2 + ":" + obj[prop].toSource();
                    } else if (obj[prop] instanceof Array) {
                        source += (visited.indexOf(obj[prop]) == -1)
                            ? prop2 + ":" + _arrayToSource(obj[prop], visited)
                            : prop2 + ":[]";
                    } else if (obj[prop] instanceof Object) {
                        source += (visited.indexOf(obj[prop]) == -1)
                            ? prop2 + ":" + _objectToSource(obj[prop], visited)
                            : prop2 + ":{}";
                    } else {
                        source += prop2 + ": null";
                    }
                    break;
                default:
                    source += prop2 + ": " + "null";
            }

            if (i < arr.length - 1) source += ", ";
        });

        source += "}";

        return source;
    }

    /**
     * Returns the source of this Date
     */
    Date.prototype.toSource = function () {
        return "(new Date(" + this.valueOf() + "))";
    }
    
    /**
     * Returns the source of this RegExp
     */
    RegExp.prototype.toSource = function () {
        return this.toString();
    }
    
    /**
     * Returns the source of this Error
     */
    Error.prototype.toSource = function () {
        var source = "(new " + this.name + "(\""+ escape2(this.message) +"\"";
        if (typeof this.fileName == "string") {
            source += ", \"" + escape2(this.fileName) + "\"";
            if (typeof err.lineNumber == "number") {
                source += ", " + err.lineNumber;
            }
        }
        source += '))';
        return source;
    }


    // Use Object.defineProperty to get same property descriptor as Mozilla
    // https://github.com/oliver-moran/toSource.js/issues/1
    if (Object.defineProperty) {
        var objects = [Number, Boolean, String, Function, Array, Object, Date, RegExp, Error];
        objects.forEach(function (obj) {
            Object.defineProperty(obj.prototype, "toSource", {
                writable: true,
                enumerable: false,
                value: obj.prototype.toSource
            });
        });
    }

}