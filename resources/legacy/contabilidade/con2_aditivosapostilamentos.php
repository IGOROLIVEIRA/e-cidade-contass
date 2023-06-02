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

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_acordo_classe.php");

$oPost = db_utils::postMemory($_POST);
$oGet  = db_utils::postMemory($_GET);

$clacordo             = new cl_acordo;


$clacordo->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("ac16_sequencial");
$clrotulo->label("ac16_resumoobjeto");
?>

<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <?php
  db_app::load("scripts.js, strings.js, prototype.js, datagrid.widget.js");
  db_app::load("widgets/messageboard.widget.js, widgets/windowAux.widget.js");
  db_app::load("estilos.css, grid.style.css");
  ?>
  <style>

    #gerar{
      margin-top: 10px;
    }

    fieldset table td:first-child {
      width: 80px;
      white-space: nowrap;
    }

    #iModelo {

      width: 93px;
    }
    #iModelodescr {
      width: 300px;
    }
    .data{
     width: 113px;
   }

   #ac02_datainicial, #ac02_datafinal{
    width: 80px;
  }

</style>
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

  <form>
    <center>
      <fieldset style="margin-top: 30px; width: 400px; ">
        <legend><strong>Aditivos e Apostilamentos</strong></legend>
        <table align="left">
          <tr>
            <td title="<?=@$Tac16_sequencial?>" align="left">
              <?php db_ancora($Lac16_sequencial, "js_acordo(true);",$db_opcao); ?>
            </td>
            <td align="left" colspan="3">
              <?php
              db_input('ac16_sequencial',6,$Iac16_sequencial,true,'text',
               $db_opcao," onchange='js_acordo(false);'");

              db_input('ac16_resumoobjeto',26,$Iac16_resumoobjeto,true,'text',3);
              ?>
            </td>
          </tr>
          <tr>
            <td>
              <strong>Listar:</strong>
            </td>
            <td align="left" colspan="3">
              <?php
              $aLista = array(0 => 'Aditivos e Apostilamentos',
                1 => 'Somente Aditivos',
                2 => 'Somente Apostilamentos');
                db_select('listagem_tipo',$aLista,true,$db_opcao," onchange='js_desabilitaselecionar();' style='width:100%;'");?>
              </td>
            </tr>
            <tr>
              <td align="left">
                <strong>Data de Assinatura:</strong>
              </td>
              <td align="left" class="data">
                <?
                db_inputdata('ac02_datainicial',@$ac02_datainicial_dia,@$ac02_datainicial_mes,@$ac02_datainicial_ano,true,
                 'text',$db_opcao,"");
                 ?>
               </td>
               <td align="center" width="20px">à</td>
               <td align="left" class='data'>
                <?
                db_inputdata('ac02_datafinal',@$ac02_datafinal_dia,@$ac02_datafinal_mes,@$ac02_datafinal_ano,true,
                 'text',$db_opcao,"")
                 ?>
               </td>
               <td></td>
             </tr>
           </table>
         </fieldset>
         <input type="button" id="gerar" value="Gerar Relatório" onclick="js_geraRelatorio();">
       </center>
     </form>
     <?php db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit")); ?>
   </body>

   <script>
  /**
 * Pesquisa acordos
 */
 function js_acordo(mostra){
    if(mostra==true){
      js_OpenJanelaIframe('','db_iframe_acordo',
        'func_acordo.php?lDepartamento=true&funcao_js=parent.js_mostraAcordo1|ac16_sequencial|ac16_resumoobjeto',
        'Pesquisa',true,0);
    } else {
      if($F('ac16_sequencial').trim() != ''){
        js_OpenJanelaIframe('','db_iframe_depart',
          'func_acordo.php?lDepartamento=true&pesquisa_chave='+$F('ac16_sequencial')+'&funcao_js=parent.js_mostraAcordo'+
          '&descricao=true',
          'Pesquisa',false,0);
      } else {
        $('ac16_resumoobjeto').value = '';
      }
    }
  }

  function js_mostraAcordo(chave,erro){

    $('ac16_resumoobjeto').value = erro
    if(erro==true){
      $('ac16_sequencial').focus();
      $('ac16_sequencial').value = '';
    }
  }

  function js_mostraAcordo1(chave1,chave2){
    $('ac16_sequencial').value = chave1;
    $('ac16_resumoobjeto').value = chave2;
    db_iframe_acordo.hide();
  }

function checaFiltros(){
  let dataInicial = document.getElementById('ac02_datainicial').value;
  let dataFinal = document.getElementById('ac02_datafinal').value;

  if(dataInicial && !dataFinal || !dataInicial && dataFinal){
    alert('Complete o período de assinatura.');
    return false;
  }

  if(dataInicial > dataFinal){
    alert('Data inicial menor que a data final. Verifique.');
    return false;
  }

  if(!document.getElementById('ac16_sequencial').value && !dataInicial && !dataFinal){
    alert('Selecione uma opção de filtro (Acordo ou data).');
    return false;
  }

  return true;
}

function js_geraRelatorio(){

  if(!checaFiltros()){
    return;
  }

  var sLocation  = 'aco2_impraditivosapostilamentos.php?';
  sLocation     += 'iAcordo='+document.getElementById('ac16_sequencial').value;

  if(document.getElementById('ac02_datainicial').value)
    sLocation     += '&data_inicial='+document.getElementById('ac02_datainicial').value;

  if(document.getElementById('ac02_datafinal').value)
    sLocation     += '&data_final='+document.getElementById('ac02_datafinal').value;
  sLocation     += '&listagem='+document.getElementById('listagem_tipo').value;

  jan = window.open(sLocation, '', 'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0');
  jan.moveTo(0,0);

}
</script>
</html>
