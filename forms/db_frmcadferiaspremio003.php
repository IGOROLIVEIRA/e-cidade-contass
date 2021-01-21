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

if (DBPessoal::verificarUtilizacaoEstruturaSuplementar()) {

  $lSalario            = FolhaPagamentoSalario::hasFolha();
  $lSalarioAberta      = FolhaPagamentoSalario::hasFolhaAberta();
  $lComplementarAberta = FolhaPagamentoComplementar::hasFolhaAberta();

  if (!$lSalario) {
    db_msgbox('Não é possível realizar o cadastro de férias, pois o ponto não encontra-se inicializado.');
  } else {

    if (!$lSalarioAberta && !$lComplementarAberta) {
      db_msgbox('Não é possível cadastrar férias, pois todas as folhas disponíveis estão fechadas.');
    }
  }
}
  
?>

<form name="form1" id='form1' method="post" action="">
<center>

<table border="0">
  <tr>
    <td>
      <fieldset>
        <table>
          <tr>
            <td colspan="2"> 
              <?
              db_input('r95_sequencial',8,$Ir95_sequencial,true,'hidden',3,"")
              ?>
            </td>
          </tr><tr>
            <td nowrap title="<?=@$Tr95_regist?>">
               <?=@$Lr95_regist?>
            </td>
            <td> 
              <?
              db_input('r95_regist',8,$Ir95_regist,true,'text',3,"")
              ?>
              <?
              db_input('z01_nome',35,$Iz01_nome,true,'text',3,'')
              ?>
            </td>
          </tr>
          <tr>
            <td nowrap title="<?=@$Tr95_perai?>" align="right">
              <?
              db_ancora("<b>Período Aquisitivo:</b>", "", 3);
              ?>
            </td>
            <td colspan="3">
              <?
              db_inputdata('r95_perai', @$r95_perai_dia, @$r95_perai_mes, @$r95_perai_ano, true, 'text', 3, "", "", "", "");
              ?>
              &nbsp;&nbsp;<b>a</b>&nbsp;&nbsp;
              <?
              db_inputdata('r95_peraf', @$r95_peraf_dia, @$r95_peraf_mes, @$r95_peraf_ano, true, 'text', 3, "", "", "", "");
              db_input('r95_regist', 10, $Ir95_regist, true, 'hidden', 3);
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
                db_inputdata('r95_per1i', @$r95_per1i_dia, @$r95_per1i_mes, @$r95_per1i_ano, true, 'text', 3);
                ?>
                &nbsp;&nbsp;<b>a</b>&nbsp;&nbsp;
                <?
                db_inputdata('r95_per1f', @$r95_per1f_dia, @$r95_per1f_mes, @$r95_per1f_ano, true, 'text', 3);
                ?>
            </td>
        </tr>
        </table>
      </fieldset>
    </td>
  </tr>
</table>
<input name="excluir" type="submit" id="excluir" value="Excluir" >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa()">
</center>
</form>
<script>
  function js_pesquisa() {
    js_OpenJanelaIframe('top.corpo','db_iframe_cadferiaspremio','func_cadferiaspremio.php?funcao_js=parent.js_preenchepesquisa|r95_sequencial','Pesquisa',true);
  }
  function js_preenchepesquisa(chave) {
    db_iframe_cadferiaspremio.hide();
    <?
      echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
    ?>
  }
</script>