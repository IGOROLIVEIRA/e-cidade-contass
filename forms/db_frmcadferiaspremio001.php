<?php
/**
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2014  DBseller Servicos de Informatica             
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

//MODULO: pessoal
require_once("libs/db_app.utils.php");
$clcadferiaspremio->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("z01_nome");

db_app::load("scripts.js");
db_app::load("prototype.js");

$db_opcao            = 1;

if (DBPessoal::verificarUtilizacaoEstruturaSuplementar()) {

  $lSalario            = FolhaPagamentoSalario::hasFolha();
  $lSalarioAberta      = FolhaPagamentoSalario::hasFolhaAberta();
  $lComplementarAberta = FolhaPagamentoComplementar::hasFolhaAberta();

  if (!$lSalario) {

    $db_opcao = 3;
    db_msgbox('Não é possível realizar o cadastro de férias, pois o ponto não encontra-se inicializado.');
  } else {

    if (!$lSalarioAberta && !$lComplementarAberta) {

      $db_opcao = 3;
      db_msgbox('Não é possível cadastrar férias, pois todas as folhas disponíveis estão fechadas.');
    }
  }
}

$result = $clcadferia->sql_record($clcadferia->sql_query_file(null, "*", null, "r30_regist = {$r95_regist} and (r30_proc1 = '{$anofolha}/{$mesfolha}' OR r30_proc2 = '{$anofolha}/{$mesfolha}')"));
if ($clcadferia->numrows > 0) {
  $sqlerro = true;
  db_msgbox("Já existem férias a serem pagas neste mês.");
}
  
?>

<form name="form1" id='form1' method="post" action="pes4_cadferiaspremio004.php">
<center>

<table border="0">
  <tr>
    <td align="center">
      <hr>
      <b><?=(!empty($r95_regist) ? ("Matrícula: $r95_regist - $z01_nome") : ("Seleção: $r44_selec - $r44_descr"))?></b>
      <hr>
    </td>
  </tr>
  <tr>
    <td>
      <fieldset>
        <table>
          <tr style="<?=( empty($r95_regist) ? 'display: none' : '' )?>">
            <td nowrap title="<?=@$Tr95_perai?>" align="right">
              <?
              db_ancora("<b>Período Aquisitivo:</b>", "", 3);
              ?>
            </td>
            <td colspan="3">
              <?
              db_inputdata('r95_perai', @$r95_perai_dia, @$r95_perai_mes, @$r95_perai_ano, true, 'text', ($dbopcao?3:1)==1?$db_opcao:3, "", "", "", "");
              ?>
              &nbsp;&nbsp;<b>a</b>&nbsp;&nbsp;
              <?
              db_inputdata('r95_peraf', @$r95_peraf_dia, @$r95_peraf_mes, @$r95_peraf_ano, true, 'text', ($dbopcao?3:1)==1?$db_opcao:3, "", "", "", "");
              db_input('r95_regist', 10, $Ir95_regist, true, 'hidden', 3);
              db_input('r44_selec', 10, $Ir95_regist, true, 'hidden', 3);
              ?>
            </td>
          </tr>
          <tr>
            <td nowrap title="Forma de pgto" align="right">
              <?
              db_ancora("<b>Forma de pgto:</b>", "", 3);
              ?>
            </td>
            <td colspan="3">
            <?
              $arr_fpagto = Array(
                                  1 =>"90 dias ferias",
                                  2 =>"Dias Livre"
                                 );
              db_select("mtipo", $arr_fpagto, true, $db_opcao,"onchange='js_validamtipo();'");
              ?>
            </td>
          </tr>
          <tr>
            <td nowrap title="Dias a gozar" align="right">
              <?
              db_ancora("<b>Dias a gozar:</b>", "", 3);
              ?>
            </td>
            <td> 
              <?
              $r95_ndias = 90;
              db_input('r95_ndias', 7, $Ir95_ndias, true, 'text', $db_opcao, "onchange='js_calculaPeriodo();'");
              ?>
            </td>
          </tr>
          <tr>
            <td nowrap title="Período de Gozo" align="right">
                <?
                db_ancora("<b>Período de Gozo:</b>", "", 3);
                ?>
            </td>
            <td colspan="3">
                <?
                db_inputdata('r95_per1i', @$r95_per1i_dia, @$r95_per1i_mes, @$r95_per1i_ano, true, 'text', $db_opcao, "onchange='js_calculaPeriodo();'","","","parent.js_calculaPeriodo();");
                ?>
                &nbsp;&nbsp;<b>a</b>&nbsp;&nbsp;
                <?
                db_inputdata('r95_per1f', @$r95_per1f_dia, @$r95_per1f_mes, @$r95_per1f_ano, true, 'text', $db_opcao);
                ?>
            </td>
        </tr>
        </table>
      </fieldset>
    </td>
  </tr>
</table>
</center>
<input name="incluir" type="submit" id="db_opcao" value="Processar" <?= ($dbopcao?3:1)== 1?($db_opcao == 3?'disabled':''):'disabled' ?> onclick="<?= ($db_opcao == 3)?'return false;':'return js_verificadados();' ?>">
<input name="voltar" type="button" id="voltar" value="Voltar" onclick="location.href = 'pes4_cadferiaspremio001.php';"> 
</form>

<script>
  function js_validamtipo() {

    if ( $F('mtipo') == 2 ) {
      $('r95_ndias').readOnly = false;
      $('r95_ndias').value = '';
      js_limparDatas();
    } else {
      $('r95_ndias').readOnly = true;
      $('r95_ndias').value = 90;
      js_calculaPeriodo();
    }
  }

  function js_verificadados() {
    
    let iPerIni  = document.form1.r95_per1i_ano.value+'/'+document.form1.r95_per1i_mes.value+'/'+document.form1.r95_per1i_dia.value;
    let iPerFim  = document.form1.r95_per1f_ano.value+'/'+document.form1.r95_per1f_mes.value+'/'+document.form1.r95_per1f_dia.value;
    let iMesFolha = <?=db_mesfolha()?>;
    let iAnoFolha = <?=db_anofolha()?>;

    if (document.form1.r95_perai.value == "" || document.form1.r95_peraf.value == "" || document.form1.r95_per1i.value == "" || document.form1.r95_per1f.value == "" || document.form1.r95_ndias.value == "") {
      alert("Todos os campos são de preenchimento obrigatório.");
      return false;
    }
    /*if (iAnoFolha != document.form1.r95_per1i_ano.value || iMesFolha != document.form1.r95_per1i_mes.value) {
      alert("Período de Gozo deve iniciar dentro do mês da folha.");
      document.form1.r95_per1i.focus();
      return false;
    }*/
    if (document.form1.r95_ndias.value > 90) {
      alert("Período de gozo deve ser até 90 dias");
      document.form1.r95_ndias.focus();
      return false
    }
  }

  function js_calculaPeriodo() {

    if ($('r95_ndias').value == '' || $('r95_ndias').value == 0) {
      js_limparDatas();
      return false;
    }
    if ($('r95_per1i').value == '') {
      return false;
    }
    let dias = new Number($('r95_ndias').value);
    let inicio = new Date($('r95_per1i_mes').value+"/"+$('r95_per1i_dia').value+"/"+$('r95_per1i_ano').value);
    let fim = new Date(inicio.getTime() + ((dias-1) * 24 * 60 * 60 * 1000));
    let mes = fim.getMonth() + 1;
    $('r95_per1f').value = fim.getDate() + "/" + mes.toString().padStart(2,"0") + "/" + fim.getFullYear();
    $('r95_per1f_dia').value = fim.getDate();
    $('r95_per1f_mes').value = fim.getMonth() + 1;
    $('r95_per1f_ano').value = fim.getFullYear();
  }

  function js_limparDatas() {

    $('r95_per1i').value = '';
    $('r95_per1i_dia').value = '';
    $('r95_per1i_mes').value = '';
    $('r95_per1i_ano').value = '';

    $('r95_per1f').value = '';
    $('r95_per1f_dia').value = '';
    $('r95_per1f_mes').value = '';
    $('r95_per1f_ano').value = '';
  }

  $('dtjs_r95_per1f').onclick = '';
  $('r95_per1f').readOnly = true;
  js_validamtipo();
</script>