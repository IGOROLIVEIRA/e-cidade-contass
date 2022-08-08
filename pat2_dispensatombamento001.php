<?php
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
 *

                              licenca/licenca_pt.txt
 */

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_empnota_classe.php");
require_once("classes/db_pcmater_classe.php");
require_once("classes/db_cgm_classe.php");
require_once("libs/db_app.utils.php");

$clempnota  = new cl_empnota();
$clcgm = new cl_cgm;
$clpcmater = new cl_pcmater;
$clrotulo = new rotulocampo;

$clrotulo->label("pc01_codmater");
$clrotulo->label("pc01_descrmater");
$clrotulo->label("e69_numero");
//$clempnota->rotulo->label();
$clcgm->rotulo->label();
db_postmemory($HTTP_POST_VARS);

?>

<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <?
  db_app::load("scripts.js, strings.js, prototype.js, datagrid.widget.js, widgets/windowAux.widget.js");
  db_app::load("estilos.css, grid.style.css");
  ?>
  <script>

    function js_emite(){
     var sQuery = '';
     sQuery += 'pc01_codmater='+$F('pc01_codmater');
     sQuery += '&z01_numcgm='+$F('z01_numcgm');
     sQuery += '&e69_numero='+$F('e69_numero');

     var dtFim = '';
     var dtIni = '';

     if($F('dt_inicial') != ''){
      var aDtInicio = $F('dt_inicial').split('/');
      var dtIni = aDtInicio[2]+'-'+aDtInicio[1]+'-'+aDtInicio[0];
    }
    if($F('dt_final')){
      var aDtFim    = $F('dt_final').split('/');
      var dtFim = aDtFim[2]+'-'+aDtFim[1]+'-'+aDtFim[0];
    }

    sQuery += '&dtini='+dtIni;
    sQuery += '&dtfim='+dtFim;

    if(dtIni == "" || dtFim == ""){
      if(confirm('Deseja realmente emitir o relatório sem filtros selecionados? \n\nEste procedimento pode demandar um tempo maior.')){

        jan  = window.open('pat2_dispensatombamento002.php?'+sQuery,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
        jan.moveTo(0,0);

      }
    }else{

     jan  = window.open('pat2_dispensatombamento002.php?'+sQuery,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
     jan.moveTo(0,0);

    }


  }


</script>

<script>
  function js_mascara(evt){
    var evt = (evt) ? evt : (window.event) ? window.event : "";

  if( (evt.charCode >46 && evt.charCode <58) || evt.charCode ==0 ){//8:backspace|46:delete|190:.
    return true;
  }else{
    return false;
  }
}
</script>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
  <center>
    <form name="form1" method="post">
      <table width="790" style="margin-top: 20px;" align="center">
        <tr>
          <td>
            <fieldset><legend><b>Dispensa de Tombamento de Bens</b></legend>
              <table>
                <tr>
                  <td nowrap title="<?=@$Tpc01_codmater?>" align="left">
                   <?
                   db_ancora(@$Lpc01_codmater,"js_pesquisapc01_codmater(true);",1);
                   ?>
                 </td>
                 <td>
                  <?
                  db_input('pc01_codmater',8,$Ipc01_codmater,true,'text',1," onchange='js_pesquisapc01_codmater(false);'")
                  ?>
                  <?
                  db_input('pc01_descrmater',50,@$Ipc01_descrmater,true,'text',3,'')
                  ?>
                </td>
              </tr>
              <tr>
                <td  align="left" nowrap title="<?=$Tz01_numcgm?>">
                  <?
                 //Clicando na ancora para buscar o cgm atraves do formulario de pesquisa.
                  db_ancora($Lz01_numcgm,"js_pesquisaz01_numcgm(true);",1);
                  ?>
                </td>
                <td align="left" nowrap>
                  <?
                 //Digitando um numero de cgm para buscar
                  db_input("z01_numcgm",10,$Iz01_numcgm,true,"text",1,"onchange='js_pesquisaz01_numcgm(false);'");
                  db_input("z01_nome",45,$Iz01_nome,true,"text",3);
                  ?>
                </td>
              </tr>
            </tr>
            <tr>
              <td  align="left" nowrap title="<?=$Te69_numero?>">
                <? db_ancora(@$Le69_numero,"js_pesquisae69_numero(true);",1);  ?>
              </td>
              <td>
                <?db_input("e69_numero",10,$Ie69_numero,true,"text",4,"onchange=''");?>
              </td>
            </tr>



            <tr>
              <td align='left'><b>Data Inicial:</b>

              </td>
              <td align='left'>
                <?
                db_inputdata('dt_inicial',"","","",false,'text',1,"","","");
                ?>
                <b>Data Final:</b>
                <?
                db_inputdata('dt_final',"","","",false,'text',1,"","","");
                ?>
              </td>
            </tr>


          </table>
        </fieldset>
      </td>
    </tr>
    <tr>
      <td align="center">
        <input name="pesquisa" type="button" onclick='js_emite();'  value="Pesquisa">
        <input name="limpa"    type="button" onclick='js_limpaCampos();' value="Limpar campos">
      </td>
    </tr>
  </table>
</form>
</center>

<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
<script>
//-------------------------------------------------
//------------------------------------------------
//---------------------------------------------------
function js_pesquisae69_numero(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_empnota',
      'func_empnota.php?funcao_js=parent.js_mostrae69_numero1|e69_numero',
      'Pesquisa',true);
  }else{
   if($F('e69_numero') != ''){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_cgm',
      'func_cgm_empenho.php?pesquisa_chave='+$F('e69_numero')+'&funcao_js=parent.js_mostrae69_numero',
      'Pesquisa',true);
  }else{
   $('e69_numero').value = '';
 }
}
}
function js_mostrae69_numero(chave,erro){
  //$('e69_numero').value = chave;
  if(erro==true){
    alert("\n\nusuário:\n\n Código informado não é válido !!!\n\nAdministrador:\n\n");
    $('e69_numero').value = '';
    $('e69_numero').focus();
  }
}
function js_mostrae69_numero1(chave1,chave2){
 $('e69_numero').value = chave1;
 db_iframe_empnota.hide();
}

function js_pesquisapc01_codmater(mostra){
  if (mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pcmater','func_pcmater.php?funcao_js=parent.js_mostrapc01_codmater1|pc01_codmater|pc01_descrmater','Pesquisa',true);
  }else{
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pcmater','func_pcmater.php?pesquisa_chave='+document.form1.pc01_codmater.value+'&funcao_js=parent.js_mostrapc01_codmater','Pesquisa',false);
  }
  if(document.form1.pc01_codmater.value==""){
    document.form1.pc01_descrmater.value="";
  }
}
function js_mostrapc01_codmater(nome,erro){
  document.form1.pc01_descrmater.value=nome;
  if (erro==true){
    document.form1.pc01_codmater.value="";
    document.form1.pc01_codmater.focus();
  }
}
function js_mostrapc01_codmater1(cod,nome){
  document.form1.pc01_codmater.value=cod;
  document.form1.pc01_descrmater.value=nome;
  db_iframe_pcmater.hide();
}
//Função que pesquisa caso seja TRUE a pesquisa foi feita atraves da ancora caso seja FALSE a pesquisa foi digitada um numero de CGM
function js_pesquisaz01_numcgm(mostra)
{
  if(mostra==true)
  {
    js_OpenJanelaIframe('CurrentWindow.corpo','func_nome','func_nome.php?funcao_js=parent.js_mostranumcgm1|z01_numcgm|z01_nome','Pesquisa',true);
  }
  else
  {
   if(document.form1.z01_numcgm.value != '')
   {
    js_OpenJanelaIframe('CurrentWindow.corpo','func_nome','func_nome.php?pesquisa_chave='+document.form1.z01_numcgm.value+'&funcao_js=parent.js_mostranumcgm','Pesquisa',false);
  }
  else
  {
   document.form1.z01_nome.value = "";
 }
}
}

//Função que retorna a pesquisa para o formulario com os dois campos NUMCGM e NOME.
//Caso a função js_pesquisaz01_numcgm tenha sido FALSE.
//Se a função não encontrar um NUMCGM digitado retorna um erro para o formulario.
function js_mostranumcgm(erro,chave)
{
  document.form1.z01_nome.value = chave;
  if(erro==true)
  {
    document.form1.z01_numcgm.value = '';
    document.form1.z01_numcgm.focus();
  }
}

//Função que retorna a pesquisa para o formulario com os dois campos NUMCGM e NOME
//Caso a função js_pesquisaz01_numcgm tenha sido TRUE.
function js_mostranumcgm1(chave1,chave2)
{
  document.form1.z01_numcgm.value = chave1;
  document.form1.z01_nome.value   = chave2;
  func_nome.hide();
}
//--------------------------------



function js_limpaCampos(){

  $('e69_numero').value = '';

  $('dt_inicial').value = '';
  $('dt_final').value = '';

}
</script>
</body>
</html>
