<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2013  DBselller Servicos de Informatica
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

//MODULO: patrim
$clbens->rotulo->label();
$clrotulo = new rotulocampo;

$db_action="pat1_bensglobal003.php";
$sLegendaFieldset = "Excluir";

?>

<form name="form1" method="post" action="<?=$db_action?>" onsubmit="return js_processaFormulario();">
<fieldset>
  <legend>exclusão bens global</legend>
<center>
<table border="0">
  <tr><!-- Código do Bem -->
    <td title=""></td>
    <td>
      <b>Placa Inicial:</b>
      <?
        db_input('t52_placaini',8,$t52_placaini,true,"text",2,"");
      ?>
    </td>
    <td>
      <b>Placa Final: </b>
      <?
        db_input('t52_placafim',8,$t52_placaini,true,"text",2,"");
      ?>
    </td>
  </tr><!-- Placa -->
</table>


</fieldset>
<br/>

<?
  if ($db_opcao == 1) {
    $sLegendaBotao = "Incluir";
  } else if ($db_opcao == 2 || $db_opcao == 22) {
    $sLegendaBotao = "Alterar";
  } else {
    $sLegendaBotao = "Excluir";
  }
?>

<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> <?=((isset($tipo_inclui)&&$tipo_inclui=="true"))?"onclick=''":""?>>

<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" <?=($msg_erro==""?"":"disabled")?> >
<?if($db_opcao==2){?>
  <input name="novo" type="button" id="novo" value="Novo" onclick="parent.location.href='pat1_bens001.php';" <?=($msg_erro==""?"":"disabled")?> >
<?}

  if ( $db_opcao == 1 || $db_opcao == 11 ) {
?>
  <input name="importar" type="button" id="importar" value="Importação" onClick="js_importacao();">
<?
  }
?>
  </center>
</form>
<script>

function js_processaFormulario() {
  var campos = "";

  if ( $('t52_descr').value == '' ) {
    campos += 'Descrição - ';
  }
  if ( $('t52_numcgm').value == '' ) {
    campos += 'Fornecedor - ';
  }
  if ( $('t52_valaqu').value == '' ) {
    campos += 'Valor da Aquisição - ';
  }
  if ( $('t52_dtaqu').value == '' ) {
    campos += 'Data da Aquisição - ';
  }
  if ( $('t52_depart').value == '' ) {
    campos += 'Departamento - ';
  }
  if ( $('t56_situac').value == '' ) {
    campos += 'Situação - ';
  }
  if ( $('qtd').value == '' ) {
    campos += 'Quantidade - ';
  }
  if ( $('t42_descr').value == '' ) {
    campos += 'Descrição do Lote - ';
  }

  if ( campos != "" ) {
    alert ("Os seguintes campos não foram preenchidos corretamente: "+campos);
    return false;
  }
  if ( $('qtd').value < 2 ) {
    alert ("Para cadastrar um único bem, utilize o Cadastro de Bem Individual.");
    return false;
  }

  /**
   * Verifica que tipo de bem será cadastrado - Imóvel e Material
   */
  if ( $('tabelaImovel').style.display == 'block' ) {

    if ( $('t54_idbql').value == '' ) {
      alert('Preencha corretamente os dados do Imóvel!');
      return false;
    }
  } else if ( $('tabelaMaterial').style.display == 'block') {

    if ( $('t53_ntfisc').value == '' ) {
      alert ("Preenche o campo Nota Fiscal!");
      $('t53_ntfisc').focus();
      return false;
    }
    if ( $('emp_sistema').value == 's' ) {

      if ( $('t53_empen').value == '' ) {

        alert ("Informe o número do empenho!");
        $('t53_empen').focus();
        return false;
      }
    }
    if ( $('t53_garant') == '' ) {
      alert ("Informe a data de garantia");
      return false;
    }

  } else {

    alert('Preenchimendo dos dados do Imóvel ou Material obrigatório!');
    return false;
  }

  return true;
}

/*
 *  Função que valida se o empenho é do sistema ou nao
 *  se for SIM (opção padrao) disponibiliza o campo para pesquisa do empenho
 *  se for NAO disponibiliza apenas um campo varchar(20) -  (não obrigatório) para digitar o numero do empenho.
*/

function js_mudaProc(sTipoProc){
  $('t53_empen').value = '';
  $('z01_nome_empenho').value = '';
  if ( sTipoProc == 's') {
    $('procAdm1').style.display = 'none';
    $('procAdm').style.display  = '';
  } else {
    $('campoDescricao').style.display  = 'none';
    $('procAdm').style.display  = 'none';
    $('procAdm1').style.display = '';
  }
}

function js_pesquisat54_idbql(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_lote','func_lote.php?funcao_js=parent.js_mostralote1|j34_idbql','Pesquisa',true);
  }else{
     if(document.form1.t54_idbql.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_lote','func_lote.php?pesquisa_chave='+document.form1.t54_idbql.value+'&funcao_js=parent.js_mostralote','Pesquisa',false);
     }
  }
}
function js_mostralote(chave,erro){
  if(erro==true){
    document.form1.t54_idbql.focus();
    document.form1.t54_idbql.value = '';
  }
}
function js_mostralote1(chave1){
  document.form1.t54_idbql.value = chave1;
  db_iframe_lote.hide();
}

function js_importacao(){
<?
   if(isset($tipo_inclui)&&$tipo_inclui==true){
       $funcao = "func_benslotealt.php";
   } else {
       $funcao = "func_bens.php";
   }
?>
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_bens','<?=$funcao?>?funcao_js=parent.js_mostrarbem|t52_bem&opcao=todos','Pesquisa',true);
}
function js_mostrarbem(chave){
  db_iframe_bens.hide();
<?
    if(isset($tipo_inclui)&&$tipo_inclui==true){
        $global = "&tipo_inclui=$tipo_inclui";
    } else {
        $global = "";
    }
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?codbem='+chave+'&importar=true<?=$global?>'";
?>
}
function js_pesquisa_texto(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_bensplaca','func_bensplacatext.php?funcao_js=parent.js_mostratext|t41_placa','Pesquisa',true);
}
function js_mostratext(placa){
  db_iframe_bensplaca.hide();
  js_buscplaca(placa);
}
function js_retplaca(placa,seq){
  //alert(placa);
  //alert(seq);
  <?if ($t07_confplaca==2){?>
    document.form1.t52_ident.value = placa+seq;
  <?}else if ($t07_confplaca==3){?>
    document.form1.t52_ident.value = placa;
    document.form1.t52_ident_seq.value = seq;
  <?}?>
}
function js_buscplaca(classif){
      js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_bp','pat1_retseqplaca.php?classif='+classif,'',false);
}
function js_isnumber(campo,nome){
  campo = campo.replace(".",",");
  campo1=new Number(campo);
  if(isNaN(campo1)){
    alert("Campo "+nome+" deve ser preenchido somente com valores inteiros.");
    eval("document.form1."+nome+".focus()");
  }
}
function js_pesquisa_bens(){

  x = document.form1;
  erro = 0;
  for(i = 0;i < x.length;i++){
    if(x.elements[i].type == "text"){
      nome=x.elements[i].name;
      if((nome.search("nome")==-1 && nome.search("descr")==-1 || nome=="t52_descr") && nome != "t52_ident" && nome != "t52_bem" && nome != "t04_sequencial"){
        x.elements[i].style.backgroundColor='';
        if(x.elements[i].value == ""){
          erro++;
          break;
        }
      }
    }
  }
  if(erro != 0) {
    alert("Usuário: \n\n Campo: "+nome+" não informado\n\n Administrador.");
    eval("document.form1."+nome+".style.backgroundColor='#99A9AE'");
    eval("document.form1."+nome+".focus()");
    return false;
  }

  if ($('t54_idbql').value == "" && $('t53_ntfisc').value == ""){
    alert ("Preencha o campo referente aos dados do Imóvel ou Material.");
    return false;
  } else {

    if ($('t53_ntfisc').value != "") {

      if ($('emp_sistema').value == 's' && $('t53_empen') == "") {
        alert ("Preencha o número do empenho.");
        return false;
      }

      if ($('t53_garant').value == "") {
        alert ("Informe a garantia deste material.");
        return false;
      }
    }
  }


//  //verificar se foram inseridos valores nos forms bensmater ou bensimoveis
//  document.form1.dadimovlot.value="";
//  document.form1.dadimovobs.value="";
//  document.form1.dadmat.value="";
//  erro_abasimov=0;
//  erro_abasmat=0;
//  if(CurrentWindow.corpo.iframe_bensimoveis.document.form1.t54_idbql.value==""){
//    erro_abasimov++;
//  }
//  x = CurrentWindow.corpo.iframe_bensmater.document.form1;
//  for(i = 0;i < x.length;i++){
//    if(x.elements[i].type == "text"){
//      nome=x.elements[i].name;
//      if(nome != "t53_codbem" && nome != "z01_nome"){
//  if(x.elements[i].value == "" ){
//    erro_abasmat++;
//  }
//      }
//    }
//  }

//  if(erro_abasimov==0 && erro_abasmat==0){
//    alert("Erro, bem não pode ser cadastrado como material e imóvel. \n\n Escolha apenas uma das abas para preencher.");
//    return false;
//  }else if(erro_abasimov!=0 && erro_abasmat!=0){
//    if (!confirm("Não há informação, ou as informações estão incompletas nas abas Dados do Imóvel e Dados do Material. \n Confirma processo?")){
//      return false;
//    }
//  }else{
//    if(erro_abasmat!=0){
//      document.form1.dadimovlot.value = CurrentWindow.corpo.iframe_bensimoveis.document.form1.t54_idbql.value;
//      document.form1.dadimovobs.value = CurrentWindow.corpo.iframe_bensimoveis.document.form1.t54_obs.value;
//    }else if(erro_abasimov!=0){
//      t53_garant_dia = CurrentWindow.corpo.iframe_bensmater.document.form1.t53_garant_dia.value;
//      t53_garant_mes = CurrentWindow.corpo.iframe_bensmater.document.form1.t53_garant_mes.value;
//      t53_garant_ano = CurrentWindow.corpo.iframe_bensmater.document.form1.t53_garant_ano.value;
//      t53_garant = t53_garant_ano+'-'+t53_garant_mes+'-'+t53_garant_dia;
//      document.form1.dadmat.value = CurrentWindow.corpo.iframe_bensmater.document.form1.t53_ntfisc.value;
//      document.form1.dadmat.value += ","+CurrentWindow.corpo.iframe_bensmater.document.form1.t53_empen.value;
//      document.form1.dadmat.value += ","+CurrentWindow.corpo.iframe_bensmater.document.form1.t53_ordem.value;
//      document.form1.dadmat.value += ","+t53_garant;
//    }
//  }
}

function js_pesquisat64_class(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_clabens','func_clabens.php?funcao_js=parent.js_mostraclabens1|t64_class|t64_descr&analitica=true','Pesquisa',true);
  }else{
     testa = new String(document.form1.t64_class.value);
     if(testa != '' && testa != 0){
       i = 0;
       for(i = 0;i < document.form1.t64_class.value.length;i++){
         testa = testa.replace('.','');
       }
       js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_clabens','func_clabens.php?pesquisa_chave='+testa+'&funcao_js=parent.js_mostraclabens&analitica=true','Pesquisa',false);
     }else{
      <?if ($t07_confplaca==2&&$db_opcao==1){?>
    document.form1.t52_ident.value ="";
  <?}?>
       document.form1.t64_descr.value = '';
     }
  }
}
function js_mostraclabens(chave,erro){
  document.form1.t64_descr.value = chave;
  if(erro==true){
    document.form1.t64_class.value = '';
    document.form1.t64_class.focus();
      <?if ($t07_confplaca==2&&$db_opcao==1){?>
    document.form1.t52_ident.value ="";
  <?}?>
  }else{
    <?if ($t07_confplaca==2&&$db_opcao==1){?>
  js_buscplaca(document.form1.t64_class.value);
  <?}?>
  }
}
function js_mostraclabens1(chave1,chave2){
  document.form1.t64_class.value = chave1;
  document.form1.t64_descr.value = chave2;
  <?if ($t07_confplaca==2&&$db_opcao==1){?>
  js_buscplaca(document.form1.t64_class.value);
  <?}?>
  db_iframe_clabens.hide();
}
function js_pesquisat52_codmat(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pcmater','func_pcmater.php?funcao_js=parent.js_mostrapcmater1|pc01_codmater|pc01_descrmater<?=$db_opcao==1?"&opcao_bloq=3&opcao=f":"&opcao_bloq=1&opcao=i"?>','Pesquisa',true);
  }else{
     if(document.form1.t52_codmat.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pcmater','func_pcmater.php?pesquisa_chave='+document.form1.t52_codmat.value+'&funcao_js=parent.js_mostrapcmater<?=$db_opcao==1?"&opcao_bloq=3&opcao=f":"&opcao_bloq=1&opcao=i"?>','Pesquisa',false);
     }else{
       document.form1.pc01_descrmater.value = '';
     }
  }
}
function js_mostrapcmater(chave,erro){
  document.form1.pc01_descrmater.value = chave;
  if(erro==true){
    document.form1.t52_codmat.focus();
    document.form1.t52_codmat.value = '';
  }
}
function js_mostrapcmater1(chave1,chave2){
  document.form1.t52_codmat.value = chave1;
  document.form1.pc01_descrmater.value = chave2;
  db_iframe_pcmater.hide();
}
function js_pesquisat52_numcgm(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_forne','func_nome.php?funcao_js=parent.js_mostraforne1|z01_numcgm|z01_nome','Pesquisa',true);
  }else{
     if(document.form1.t52_numcgm.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_forne','func_nome.php?pesquisa_chave='+document.form1.t52_numcgm.value+'&funcao_js=parent.js_mostraforne','Pesquisa',false);
     }else{
       document.form1.z01_nome.value = '';
     }
  }
}
function js_mostraforne(erro,chave){
  document.form1.z01_nome.value = chave;
  if(erro == true){
    document.form1.t52_numcgm.focus();
    document.form1.t52_numcgm.value = '';
  }
}
function js_mostraforne1(chave1,chave2){
  document.form1.t52_numcgm.value = chave1;
  document.form1.z01_nome.value = chave2;
  db_iframe_forne.hide();
}
function js_pesquisat56_situac(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_situabens','func_situabens.php?funcao_js=parent.js_mostrasituabens1|t70_situac|t70_descr','Pesquisa',true);
  }else{
     if(document.form1.t56_situac.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_situabens','func_situabens.php?pesquisa_chave='+document.form1.t56_situac.value+'&funcao_js=parent.js_mostrasituabens','Pesquisa',false);
     }else{
       document.form1.t70_descr.value = '';
     }
  }
}
function js_mostrasituabens(chave,erro){
  document.form1.t70_descr.value = chave;
  if(erro==true){
    document.form1.t56_situac.focus();
    document.form1.t56_situac.value = '';
  }
}
function js_mostrasituabens1(chave1,chave2){
  document.form1.t56_situac.value = chave1;
  document.form1.t70_descr.value = chave2;
  db_iframe_situabens.hide();
}
function js_pesquisat52_depart(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_db_depart','func_db_depart.php?funcao_js=parent.js_mostradb_depart1|coddepto|descrdepto','Pesquisa',true);
  }else{
     if(document.form1.t52_depart.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_db_depart','func_db_depart.php?pesquisa_chave='+document.form1.t52_depart.value+'&funcao_js=parent.js_mostradb_depart','Pesquisa',false);
     }else{
       document.form1.descrdepto.value = '';
     }
  }
}
function js_mostradb_depart(chave,erro){
  document.form1.descrdepto.value = chave;
  if(erro==true){
    document.form1.t52_depart.focus();
    document.form1.t52_depart.value = '';
  }else{
  document.form1.submit();
  }
}
function js_mostradb_depart1(chave1,chave2){
  document.form1.t52_depart.value = chave1;
  document.form1.descrdepto.value = chave2;
  db_iframe_db_depart.hide();
  document.form1.submit();
}
function js_pesquisa(){
  <?
     if(isset($tipo_inclui)&&$tipo_inclui==true){
         $url = "func_benslotealt.php?funcao_js=parent.js_preenchepesquisa|t42_codigo";
     } else {
         $url = "func_bens.php?funcao_js=parent.js_preenchepesquisa|t52_bem&opcao=todos";
     }
  ?>
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_bens','<?=$url?>','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_bens.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
<?
if(isset($chavepesquisa)){
      echo "\njs_mascara03_t64_class(document.form1.t64_class.value);\n";
}

if (isset($importar)&&trim($importar)!=""){
  echo "\njs_pesquisat64_class(false);\n";
}

?>
function js_pesquisat04_sequencial(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_benscadcedente','func_benscadcedente.php?funcao_js=parent.js_mostraconvenio1|t04_sequencial|z01_nome','Pesquisa',true);
  }else{
     if(document.form1.t04_sequencial.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_benscadcedente','func_benscadcedente.php?pesquisa_chave='+document.form1.t04_sequencial.value+'&funcao_js=parent.js_mostraconvenio','Pesquisa',false);
     }else{
       document.form1.z01_nome_convenio.value = '';
     }
  }
}
function js_mostraconvenio(chave,erro){
  //alert(chave);
  //document.getElementById('z01_nome').value = 'teste';
  document.form1.z01_nome_convenio.value = chave;
  if(erro==true){
    document.form1.t04_sequencial.focus();
    document.form1.t04_sequencial.value = '';
  }
}
function js_mostraconvenio1(chave1,chave2){
  document.form1.t04_sequencial.value = chave1;
  document.form1.z01_nome_convenio.value = chave2;
  db_iframe_benscadcedente.hide();
}


function js_pesquisat53_empen(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_empempenho','func_empempenho.php?funcao_js=parent.js_mostraempempenho1|e60_numemp|z01_nome','Pesquisa',true);
  }else{
     if(document.form1.t53_empen.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_empempenho','func_empempenho.php?pesquisa_chave='+document.form1.t53_empen.value+'&funcao_js=parent.js_mostraempempenho','Pesquisa',false);
     }else{
       document.form1.t53_empen.value = '';
     }
  }
}

function js_mostraempempenho(chave,erro){

  document.form1.z01_nome_empenho.value = chave;
  if(erro==true){
    document.form1.t53_empen.focus();
    document.form1.t53_empen.value = '';
  }
}
function js_mostraempempenho1(chave1,chave2){
  document.form1.t53_empen.value = chave1;
  document.form1.z01_nome_empenho.value = chave2;
  db_iframe_empempenho.hide();
}
</script>
