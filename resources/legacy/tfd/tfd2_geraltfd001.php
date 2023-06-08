<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2009  DBselller Servicos de Informatica             
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

require_once('libs/db_stdlib.php');
require_once('libs/db_conecta.php');
require_once('libs/db_sessoes.php');
require_once('libs/db_usuariosonline.php');
require_once('dbforms/db_funcoes.php');
require_once("libs/db_app.utils.php");
require_once("libs/db_utils.php");

db_postmemory($HTTP_POST_VARS);

$oDaotfd_agendamentoprestadora = db_utils::getdao('tfd_agendamentoprestadora');
$oDaotfd_agendamentoprestadora->rotulo->label();

$oRotulo = new rotulocampo;
$oDaoTfdPedidoTfd = new cl_tfd_pedidotfd();
$oDaoTfdTipoTratamento = new cl_tfd_tipotratamento();
$oDaoTfdPedidoTfd->rotulo->label();
$oRotulo->label('tf10_i_prestadora');
$oRotulo->label('rh70_estrutural');
$oRotulo->label('tf23_i_procedimento');
$oRotulo->label('tf12_faturabpa');
?>

<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<?
db_app::load("scripts.js, strings.js, prototype.js, datagrid.widget.js, webseller.js, /widgets/dbautocomplete.widget.js");
db_app::load("grid.style.css");
?>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">

<br><br><br>
<center>
  <form name="form1" method="post" action="">
    <table width="70%">
      <tr>
        <td align="center">
          <fieldset style="width:80%"><legend><b>Consultas / Exames Solicitados</b></legend>
            <table width='100%' border='0'>
            <tr>
    <td nowrap title="<?=@$Ttf10_i_prestadora?>">
      <?
      db_ancora(@$Ltf10_i_prestadora,"js_pesquisatf10_i_prestadora(true);",$db_opcao);
      ?>
    </td>
    <td nowrap colspan="3"> 
      <?
      db_input('tf10_i_prestadora',10,$Itf10_i_prestadora,true,'text',$db_opcao," onchange='js_pesquisatf10_i_prestadora(false);'");
      db_input('z01_nome2',50,$Iz01_nome,true,'text',3,'');
      db_input('tf16_i_prestcentralagend',2,$Itf16_i_prestcentralagend,true,'hidden',3,'');
      db_input('tf09_i_numcgm',2,'',true,'hidden',3,'');
      ?>
    </td>
  </tr>
  <tr>
          <td nowrap title="<?=@$Ttf01_i_rhcbo?>">
            <?
            db_ancora(@$Ltf01_i_rhcbo, "js_pesquisatf01_i_rhcbo(true);", $db_opcao);
            ?>
          </td>
          <td colspan="3"> 
            <?
            db_input('rh70_estrutural', 10, $Irh70_estrutural, true, 'text', $db_opcao, 
                     " onchange='js_pesquisatf01_i_rhcbo(false);'"
                    );
            db_input('tf01_i_rhcbo', 10, $Itf01_i_rhcbo, true, 'hidden', 3);
            db_input('rh70_descr', 58, $Irh70_descr, true, 'text', 3, '');
            ?>
          </td>
        </tr>
        
        <tr>
          <td nowrap title="<?php echo $Ttf01_i_cgsund;?>">
          <?php db_ancora(@$Ltf01_i_cgsund, "js_pesquisatf01_i_cgsund(true);", $db_opcao); ?>
        </td>
        <td nowrap="nowrap">
          <?php
            db_input('tf01_i_cgsund', 15, $Itf01_i_cgsund, true, 'text', $db_opcao,
                   ' onchange="js_pesquisatf01_i_cgsund(false); "');
            db_input('z01_v_nome', 72, $Iz01_v_nome, true, 'text', 3, '');
          ?>
        </td>
       </tr>
        
        <tr>
             <td nowrap title="<?=@$Ttf01_i_tipotratamento?>" style="padding-bottom: 8px;">
               <?=@$Ltf01_i_tipotratamento?>
             </td>
             <td style="padding-bottom: 8px;"> 
               <?              
               $aX                   = array("0" => "");
               $sSql                 = $oDaoTfdTipoTratamento->sql_query_file(null, '* ');
               $rsTfd_tipotratamento = $oDaoTfdTipoTratamento->sql_record($sSql);

               for ($iCont = 0; $iCont < $oDaoTfdTipoTratamento->numrows; $iCont++) {
                 
                 $oDados                     = db_utils::fieldsmemory($rsTfd_tipotratamento, $iCont);
                 $aX[$oDados->tf04_i_codigo] = $oDados->tf04_c_descr;

               }
               db_select('tf01_i_tipotratamento', $aX, true,1,'');
               ?>
             </td>
          </tr>
          
          <tr>
            <td nowrap title="<?=@$Ttf23_i_procedimento?>">
              <?
              db_ancora($Ltf23_i_procedimento, "js_pesquisatf23_i_procedimento(true);", 1);
              ?>
            </td>
            <td nowrap colspan="2"> 
              <?
              db_input('sd63_c_procedimento', 10, '', true, 'text', 1, 
                       " onchange='js_pesquisatf23_i_procedimento(false);'"
                      );
              db_input('tf23_i_procedimento', 1, '', true, 'hidden', 3);
              db_input('sd63_c_nome', 51, $Isd63_c_nome, true, 'text', 3, '');
              if (!isset($lSucesso) || $lSucesso == 'true' || !isset($lProcedimentosAlterados)) {
                $lProcedimentosAlterados = 'false';
              }
              db_input('lProcedimentosAlterados', 1, '', true, 'hidden', 3, "");
              ?>
              <input name="lancar_procedimento" type="button" id="lancar_procedimento" value="Incluir" 
                onclick="js_lanca_procedimento();">
              <select multiple  name='select_procedimento[]' id='select_procedimento' style="display: none;">
            </td>
          </tr>
          <tr>
            <td colspan="3">
              <div id='grid_procedimentos' style='width:595px;'></div>
            </td>
          </tr>
          
              <tr>
                <td><b>Período:</b></td>
                <td align="left" style="padding-bottom: 2px;" nowrap>
                  <?
                  db_inputdata('dataini', @$dataini_dia, @$dataini_mes, @$dataini_ano, true, 'text', 1, '');
                  ?>
                  <b>a</b>
                  <?
                  db_inputdata('datafim', @$datafim_dia, @$datafim_mes, @$datafim_ano, true, 'text', 1, '');
                  ?>
                </td>
              </tr>
              
              <tr>
                <td nowrap="nowrap" title="<?=@$Ttf12_faturabpa?>" ><?=@$Ltf12_faturabpa?></td>
                <td nowrap="nowrap" > 
                <?
                $aX = array('' => 'TODOS','t'=>'SIM', 'f'=>'NÃO');
                db_select('tf12_faturabpa', $aX, true, $db_opcao, '');
                ?>
                </td>
              </tr>
              
              <tr>
                <td nowrap="nowrap" title="" ><b>Imprimir Valores Zerados:</b></td>
                <td nowrap="nowrap" > 
                <?
                $aX = array('' => 'TODOS','t'=>'Somente Zerados', 'f'=>'Somente Não Zerados');
                db_select('imprimir_zerados', $aX, true, $db_opcao, '');
                ?>
                </td>
              </tr>
              
              <tr>
                <td align="center">
                  <br>
                  <input name="gerar" id="gerar" type="button" value="Gerar Relatório" onclick="js_gerarRelatorio();">
                </td>
              </tr>
            </table>
          </fieldset>
        </td>
      </tr>
    </table>

  </form>
</center>
<?
db_menu(db_getsession('DB_id_usuario'), db_getsession('DB_modulo'), 
        db_getsession('DB_anousu'), db_getsession('DB_instit')
       );
?>

<script>

function js_validaEnvio() {

  aIni = document.form1.dataini.value.split('/');
  aFim = document.form1.datafim.value.split('/');
  dIni = new Date(aIni[2], aIni[1], aIni[0]);
  dFim = new Date(aFim[2], aFim[1], aFim[0]);

  if (dFim < dIni) {
  			
    alert('Data final não pode ser menor que a data inicial.');
    document.form1.datafim.value = '';
    document.form1.datafim.focus();
    return false;
  
  }

  return true;						

}

function js_gerarRelatorio() {
 
  if (js_validaEnvio()) {

    var sGet = '&dIni='+$F('dataini')+'&dFim='+$F('datafim');
    sGet += '&iPrestadora='+$F('tf10_i_prestadora');
    sGet += '&iEspecialidade='+$F('tf01_i_rhcbo');
    sGet += '&iTipo='+$F('tf01_i_tipotratamento');
    sGet += '&aProcedimento='+$F('select_procedimento');
    sGet += '&sFaturaBPA='+$F('tf12_faturabpa');
    sGet += '&iPaciente='+$F('tf01_i_cgsund');
    sGet += '&iZerados='+$F('imprimir_zerados');

    oJan = window.open('tfd2_geraltfd002.php?'+sGet, '',
                       'width='+(screen.availWidth - 5)+',height='+(screen.availHeight - 40)+
                       ',scrollbars=1,location=0 '
                      );
    oJan.moveTo(0, 0);

  }

}

function js_pesquisatf10_i_prestadora(mostra) {

	  if(mostra==true) {

	    js_OpenJanelaIframe('','db_iframe_tfd_prestadoracentralagend','func_tfd_prestadoracentralagend.php?funcao_js=parent.js_mostratfd_prestadora|tf10_i_prestadora|z01_nome|tf10_i_codigo|z01_numcgm',
	                        'Pesquisa',true);

	  } else {

	     if(document.form1.tf10_i_prestadora.value != '') {

	        js_OpenJanelaIframe('','db_iframe_tfd_prestadoracentralagend','func_tfd_prestadoracentralagend.php?'+sChave+
	                            '&funcao_js=parent.js_mostratfd_prestadora|tf10_i_prestadora|z01_nome|tf10_i_codigo|z01_numcgm'+
	                            '&chave_tf10_i_prestadora='+document.form1.tf10_i_prestadora.value+'&nao_mostra=true', 
	                            'Pesquisa',false);

	     } else {
	       js_limpaInfoCgm();
	     }

	  }

	}
function js_mostratfd_prestadora(chave1, chave2, chave3, chave4) {

	  document.form1.tf10_i_prestadora.value = chave1;
	  document.form1.z01_nome2.value = chave2;
	  document.form1.tf16_i_prestcentralagend.value = chave3;
	  document.form1.tf09_i_numcgm.value = chave4;

	  db_iframe_tfd_prestadoracentralagend.hide();

	}


function js_pesquisatf01_i_rhcbo(mostra) {

	  if (mostra == true) {

	    js_OpenJanelaIframe('', 'db_iframe_rhcbo', 'func_rhcbosaude.php?funcao_js=parent.js_mostrarhcbo1|'+
	                        'rh70_estrutural|rh70_descr|rh70_sequencial', 'Pesquisa', true
	                       );

	  } else {

	    if (document.form1.rh70_estrutural.value != '') {

	      js_OpenJanelaIframe('', 'db_iframe_rhcbo', 'func_rhcbosaude.php?pesquisa_chave='+
	                          document.form1.rh70_estrutural.value+'&funcao_js=parent.js_mostrarhcbo', 
	                          'Pesquisa', false
	                         );

	    } else {

	       document.form1.tf01_i_rhcbo.value = ''; 
	       document.form1.rh70_descr.value   = '';

	     }

	  }

	}
	function js_mostrarhcbo(chave1, chave2, chave3, erro) {

	  document.form1.rh70_estrutural.value = chave1; 
	  document.form1.rh70_descr.value      = chave2;
	  document.form1.tf01_i_rhcbo.value    = chave3;

	  if (erro == true) {
	    document.form1.rh70_estrutural.focus(); 
	  }

	}
	function js_mostrarhcbo1(chave1, chave2, chave3) {

	  document.form1.rh70_estrutural.value = chave1;
	  document.form1.rh70_descr.value      = chave2;
	  document.form1.tf01_i_rhcbo.value    = chave3;

	  db_iframe_rhcbo.hide();

	}

	function js_pesquisatf23_i_procedimento(mostra) {
		  
		  if (mostra == true) {

		      js_OpenJanelaIframe('', 'db_iframe_tfd_tipotratamentoproced', 'func_tfd_tipotratamentoproced.php?funcao_js=parent.js_mostrasau_procedimento|sd63_c_procedimento|sd63_c_nome|'+
		                          'tf05_i_procedimento', 'Pesquisa Procedimento', true
		                         );

		  } else {

		    if ( $F('sd63_c_procedimento') != '') {
		 
		      js_OpenJanelaIframe('', 'db_iframe_tfd_tipotratamentoproced', 'func_tfd_tipotratamentoproced.php?chave_sd63_c_procedimento='+$F('sd63_c_procedimento')+
		                          '&funcao_js=parent.js_mostrasau_procedimento|sd63_c_procedimento|sd63_c_nome|'+
		                          'tf05_i_procedimento&nao_mostra=true', 'Pesquisa Procedimento', false
		                         );


				} else {

					$('sd63_c_nome').value         = '';
		      $('tf23_i_procedimento').value = '';

				}

			}
		 
		}

		function js_mostrasau_procedimento(chave1, chave2, chave3) {

		  if (chave3 == undefined) {
		    chave3 = '';
		  }
		  $('sd63_c_procedimento').value = chave1;
		  $('sd63_c_nome').value         = chave2;
		  $('tf23_i_procedimento').value = chave3;

		  db_iframe_tfd_tipotratamentoproced.hide();
		}

		/**** Bloco de Funções que tratam do grid / select dos procedimentos (início) */
		function js_renderizaGrid() {

		  var oF = $('select_procedimento');
		  oDBGridProcedimentos.clearAll(true);

		  var aLinha = new Array();
		  for (i = 0; i < oF.length; i++) {

		    aInfo     = oF.options[i].innerHTML.split(' ## ');

		    aLinha[0] = aInfo[0];
		    aLinha[1] = aInfo[1].substr(0, 54);
		    aLinha[2]  = "<span onclick=\"js_excluir_item_procedimento("+oF.options[i].value+");\""+
		                   " style=\"color: blue; text-decoration: underline; cursor: pointer;\"><b>E</b></span>";
		    oDBGridProcedimentos.addRow(aLinha);

		  }
		  oDBGridProcedimentos.renderRows();

		}

		function js_excluir_item_procedimento(iVal) {
		 
		  var oF = $("select_procedimento");
		  for (i = 0; i < oF.length; i++) {
		    
		    if (oF.options[i].value == iVal) {

		      oF.options[i]                      = null;
		      $('lProcedimentosAlterados').value = 'true';
		      break;

		    }

		  }
		  js_renderizaGrid();

		}

		function js_lanca_procedimento() {

		  valor = $F('tf23_i_procedimento');
		  texto = $F('sd63_c_procedimento')+' ## '+$F('sd63_c_nome');
		  if (valor != '' && $F('sd63_c_procedimento').trim() != '') {

		    var oF                        = $('select_procedimento');
		    var valor_default_novo_option = oF.length;
		    var testa                     = false;
		    /*
		    * testa se o elemento ja foi inserido no select
		    */
		    for (var x = 0; x < oF.length; x++) {

		      if (oF.options[x].value == valor) {

		        testa = true;
		        break;

		      }

		    }

		    if (testa == false) {
		      /*
		      * Cria o novo option no select hidden que armazena os procedimentos
		      */
		      $('lProcedimentosAlterados').value             = 'true';
		      var aLinha                                     = new Array();
		      oF.options[valor_default_novo_option]          = new Option(texto, valor);
		      oF.options[valor_default_novo_option].selected = true;
		      js_renderizaGrid();

		    }

		  }
		  texto = $('tf23_i_procedimento').value = '';
		  valor = $('sd63_c_nome').value         = '';
		  $('sd63_c_procedimento').value         = '';

		}

		function js_cria_datagrid() {

		  oDBGridProcedimentos              = new DBGrid('grid_procedimentos');
		  oDBGridProcedimentos.nameInstance = 'oDBGridProcedimentos';
		  oDBGridProcedimentos.setCellWidth(new Array('10%', '80%', '10%'));
		  oDBGridProcedimentos.setHeight(38);

		  //oDBGridProcedimentos.setCheckbox(0);
		  var aHeader = new Array();
		  aHeader[0]  = 'Procedimento';
		  aHeader[1]  = 'Descri&ccedil;&atilde;o';
		  aHeader[2]  = 'Excluir';
		  oDBGridProcedimentos.setHeader(aHeader);
		  //oDBGridProcedimentos.aHeader[11].lDisplayed = false;
		  oDBGridProcedimentos.allowSelectColumns(true);
		  var aAligns = new Array();
		  aAligns[0]  = 'center';
		  aAligns[1]  = 'center';
		  aAligns[2]  = 'center';
		  
		  oDBGridProcedimentos.setCellAlign(aAligns);
		  oDBGridProcedimentos.allowSelectColumns(false);
		  oDBGridProcedimentos.show($('grid_procedimentos'));
		  oDBGridProcedimentos.clearAll(true);

		  return oDBGridProcedimentos;

		}

		function js_esvaziaProcedimentos() {

		  sel = $('select_procedimento');
		  while(sel.length > 0) {
		    sel.options[0] = null;
		  }

		}
		oDBGridProcedimentos         = js_cria_datagrid();
		/* Bloco de Funções que tratam do grid / select dos procedimentos (fim) *****/
		
		function js_pesquisatf01_i_cgsund( mostra ) {

      if ( mostra == true ) {

        js_OpenJanelaIframe('', 'db_iframe_cgs_und', 'func_cgs_und.php?funcao_js=parent.js_mostracgs1|'+
                        'z01_i_cgsund|z01_v_nome', 'Pesquisa', true
                       );
      } else {

        if ( document.form1.tf01_i_cgsund.value != '' ) {

          js_OpenJanelaIframe('', 'db_iframe_cgs_und', 'func_cgs_und.php?pesquisa_chave='+
                          document.form1.tf01_i_cgsund.value+
                          '&funcao_js=parent.js_mostracgs', 'Pesquisa', false
                         );
        } else {
          document.form1.z01_v_nome.value = '';
        }
      }
    }

  function js_mostracgs( chave, erro ){

    iCgs = $F('tf01_i_cgsund');
    document.form1.tf01_i_cgsund.value = iCgs;
    document.form1.z01_v_nome.value    = chave;

    if ( erro == true ) {

      document.form1.tf01_i_cgsund.focus();
      document.form1.tf01_i_cgsund.value = '';
    }
  }

  function js_mostracgs1( chave1, chave2 ) {

    document.form1.tf01_i_cgsund.value = chave1;
    document.form1.z01_v_nome.value    = chave2;
    db_iframe_cgs_und.hide();
  }
</script>
</body>
</html>