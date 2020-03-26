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
 *                                licenca/licenca_pt.txt
 */

require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_liborcamento.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_acordogrupo_classe.php");

$oRotulo = new rotulocampo;
$clacordogrupo = new cl_acordogrupo;
$clacordogrupo->rotulo->label();

$oRotulo->label("ac16_sequencial");
$oRotulo->label("ac16_resumoobjeto");
?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <?php
  db_app::load("scripts.js, strings.js, prototype.js,datagrid.widget.js, widgets/dbautocomplete.widget.js");
  db_app::load("widgets/windowAux.widget.js");
  ?>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <link href="estilos/grid.style.css" rel="stylesheet" type="text/css">
  <style>
    .fora {background-color: #d1f07c;}
    #iQuebra{
      width:100%;
    }
  </style>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
<center>
  <form name="form1" target='relatorioacordosavencer' id="form1"  method="get" action="con2_execucaodecontratos002.php">
    <table style="margin-top: 20px;">
    <tr>
      <td>
        <fieldset>
          <legend>
            <b>Execução de Contratos</b>
          </legend>
          <br/>

          <table border="0" width="100%">
            <tr id="trAcordos">
              <td nowrap title="<?php echo $Tac16_sequencial; ?>" width="130">
                <?php
                db_ancora($Lac16_sequencial, "js_acordo(true);",1);
                ?>
              </td>
              <td colspan="3">
                <?php
                db_input('ac16_sequencial', 10, $Iac16_sequencial, true, 'text', 1, "onchange='js_acordo(false);'");
                db_input('ac16_resumoobjeto', 40, $Iac16_resumoobjeto, true, 'text', 3);
                ?>
              </td>
            </tr>

            <tr>
              <td align="left" title="<?=@$Tac16_datainicio?>">
                <b>Data de Início:</b>
              </td>
              <td align="left">
                <?php
                db_inputdata('ac16_datainicio',@$ac16_datainicio_dia,@$ac16_datainicio_mes,@$ac16_datainicio_ano,true,
                  'text',1);
                ?>
              </td>
              <td align="right" title="<?=@$Tac16_datafim?>">
                <b>Data de Fim:</b>
              </td>
              <td align="right">
                <?
                db_inputdata('ac16_datafim',@$ac16_datafim_dia,@$ac16_datafim_mes,@$ac16_datafim_ano,true,
                  'text',1)
                ?>
              </td>
            </tr>

            <tr>
              <td>
                <b>Quebra:</b>
              </td>
              <td colspan="3">
                <?php
                $aFiltros = array( 2 => "Por empenho", 3 => "Por aditivo", 4 => "Por aditivo e empenho");
                db_select("iQuebra", $aFiltros, true, 1, "class='select'");
                ?>
              </td>
            </tr>
            <tr>
                <td>
					<?php db_ancora('Depto. de Inclusão:', "js_pesquisa_depart(true);", 1); ?>
                </td>
                <td>
                    <?php
					db_input("coddeptoinc", 10, $Icoddepto, true, "text", 4, "onchange='js_pesquisa_depart(false);'");
                    db_input("descrdeptoinc", 50, $Idescrdepto, true, "text", 3);
                    ?>
                </td>
            </tr>
              <tr>
                  <td>
					  <?php db_ancora('Depto. Responsável',"js_pesquisa_departamento(true);",1); ?>
                  </td>
                  <td>
					  <?php
					  db_input('coddeptoresp',10,'',true,'text',4," onchange='js_pesquisa_departamento(false);'","");
					  db_input('descrdeptoresp', 50, '', true, 'text', 3,"","");
					  ?>
                  </td>
              </tr>

          </table>
        </fieldset>
      </td>
    </tr>
    <tr>
      <td style="text-align: center;">
        <input type='submit' value='Gerar Relatório' onclick="return js_gerarRelatorio();">
      </td>
    </tr>
    </table>
  </form>
  <?php db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit")); ?>
</center>
</body>
</html>
<script type="text/javascript">
  function js_pesquisaac02_acordonatureza(mostra){
    if(mostra==true){
      var sUrl1 = 'func_acordonatureza.php?funcao_js=parent.js_mostraacordonatureza1|ac01_sequencial|ac01_descricao';
      js_OpenJanelaIframe('','db_iframe_acordonatureza',sUrl1,'Pesquisa',true,'0');
    }else{
      if($('ac02_acordonatureza').value != ''){
        var sUrl2 = 'func_acordonatureza.php?pesquisa_chave='+$('ac02_acordonatureza').value
          +'&funcao_js=parent.js_mostraacordonatureza';
        js_OpenJanelaIframe('','db_iframe_acordonatureza',sUrl2,'Pesquisa',false,'0');
      }else{
        $('ac01_descricao').value = '';
      }
    }
  }
  function js_mostraacordonatureza(chave1,chave2,erro){
    $('ac01_descricao').value = chave2;
    if(erro==true){
      $('ac02_acordonatureza').focus();
      $('ac02_acordonatureza').value = '';
      $('ac01_descricao').value      = chave1;
    }
  }
  function js_mostraacordonatureza1(chave1,chave2) {
    $('ac02_acordonatureza').value = chave1;
    $('ac01_descricao').value      = chave2;
    db_iframe_acordonatureza.hide();
  }
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

    function js_pesquisa_depart(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_db_depart', 'func_db_depart.php?funcao_js=parent.js_mostradepart1|coddepto|descrdepto', 'Pesquisa', true);
        } else {
        if (document.form1.coddeptoinc.value != '') {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_db_depart', 'func_db_depart.php?pesquisa_chave=' + document.form1.coddeptoinc.value + '&funcao_js=parent.js_mostradepart', 'Pesquisa', false);
        } else {
                document.form1.descrdeptoinc.value = '';
            }
        }
    }
    function js_mostradepart(chave, erro) {
        document.form1.descrdeptoinc.value = chave;
        if (erro == true) {
            document.form1.coddeptoinc.focus();
            document.form1.coddeptoinc.value = '';
        }
    }
    function js_mostradepart1(chave1, chave2) {
        document.form1.coddeptoinc.value = chave1;
        document.form1.descrdeptoinc.value = chave2;
        db_iframe_db_depart.hide();
    }

    function js_pesquisa_departamento(mostra){
        if (mostra==true) {
            js_OpenJanelaIframe('top.corpo','db_iframe_departamento','func_departamento.php?funcao_js=parent.js_mostradepartamento1|coddepto|descrdepto','Pesquisa',true);
        } else {
            if (document.form1.coddeptoresp.value != '') {
                js_OpenJanelaIframe('','db_iframe_departamento','func_departamento.php?pesquisa_chave='+document.form1.coddeptoresp.value+'&funcao_js=parent.js_mostradepartamento','Pesquisa',false);
            } else {
                document.form1.descrdeptoresp.value = '';
            }
        }
    }

    function js_mostradepartamento1(chave1, chave2, erro) {
        document.form1.coddeptoresp.value = chave1;
        document.form1.descrdeptoresp.value = chave2;
        db_iframe_departamento.hide();
    }

    function js_mostradepartamento(chave1,erro) {
        if(!erro){
            document.form1.descrdeptoresp.value = chave1;
        }
        db_iframe_departamento.hide();
    }

  function js_gerarRelatorio(){

    var iAcordo    = $F("ac16_sequencial");
    var sResumoObjeto = $('ac16_resumoobjeto').value;

    rel = 'relatorioacordosavencer'+Math.floor((Math.random() * 10) + 1);
    document.form1.setAttribute('target',rel);
    window.open('', rel,
      'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, copyhistory=yes, width=1080, height=720');
    document.form1.submit();
    //jan.moveTo(0,0);
    return true;
  }

  var aDepartamentos     = new Array();
  var oGridDepartamentos = js_montaGrid();

  /**
   * Monta grid
   */
  function js_montaGrid() {

    var aAlinhamentos = new Array();
    var aHeader       = new Array();
    var aWidth        = new Array();

    aHeader[0]       = 'Código';
    aHeader[1]       = 'Departamento';
    aHeader[2]       = 'Remover';

    aWidth[0]        = '10%';
    aWidth[1]        = '75%';
    aWidth[2]        = '15%';

    aAlinhamentos[0] = 'left';
    aAlinhamentos[1] = 'left';
    aAlinhamentos[2] = 'center';

    oGridDepartamentos              = new DBGrid('datagridDepartamentos');
    oGridDepartamentos.sName        = 'datagridDepartamentos';
    oGridDepartamentos.nameInstance = 'oGridDepartamentos';
    oGridDepartamentos.setCellWidth( aWidth );
    oGridDepartamentos.setCellAlign( aAlinhamentos );
    oGridDepartamentos.setHeader( aHeader );
    oGridDepartamentos.allowSelectColumns(true);
    oGridDepartamentos.show( $('ctnDepartamentos') );
    oGridDepartamentos.clearAll(true);
    return oGridDepartamentos;
  }

  function js_lancarDepartamento() {

    var sDescricaoDepartamento = $F('sDescricaoDepartamento');

    if ( sDescricaoDepartamento == '' ) {
      return false;
    }

    oDepartamento = new Object();
    oDepartamento.iDepartamento          = $F('iCodigoDepartamento');
    oDepartamento.sDescricaoDepartamento = sDescricaoDepartamento;
    oDepartamento.iIndice                = aDepartamentos.length;

    //Limpa os campos
    $('sDescricaoDepartamento').value = "";
    $('iCodigoDepartamento').value    = "";

    aDepartamentos.push(oDepartamento);
    renderizarGrid(aDepartamentos);
    console.log(aDepartamentos);
  }

  function js_removeDepartamentoLancado(iIndice) {

    aDepartamentos.splice(iIndice, 1);
    renderizarGrid (aDepartamentos);
  }

  function renderizarGrid (aDepartamentos) {

    oGridDepartamentos.clearAll(true);

    for ( var iIndice = 0; iIndice < aDepartamentos.length; iIndice++ ) {

      oDepartamento = aDepartamentos[iIndice];

      var aLinha = new Array();

      aLinha[0] = oDepartamento.iDepartamento;
      aLinha[1] = oDepartamento.sDescricaoDepartamento;

      sDisabled = '';

      aLinha[2] = '<input type="button" value="Remover" onclick="js_removeDepartamentoLancado(' + iIndice + ')" ' + sDisabled + ' />';

      oGridDepartamentos.addRow(aLinha, null, null, true);
    }

    oGridDepartamentos.renderRows();
  }

</script>
