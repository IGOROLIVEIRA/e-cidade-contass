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

//MODULO: orcamento
$clppalei->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("nomeinst");

$clppaleidadocomplementar->rotulo->label();
?>
<form name="form1" method="post" action="">
<table>
<tr>
<td>
 <fieldset><legend><b>Período Referência LDO/LOA</b></legend>
<table border="0">
  <tr >
    <td nowrap title="<?=@$To01_sequencial?>">
       <?=@$Lo01_sequencial?>
    </td>
    <td>
<?
db_input('o01_sequencial',10,$Io01_sequencial,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$To01_anoinicio?>">
       <?=@$Lo01_anoinicio?>
    </td>
    <td>
<?
db_input('o01_anoinicio',10,$Io01_anoinicio,true,'text',$db_opcao,"onchange='js_adicionaAno()'");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$To01_anofinal?>">
       <?=@$Lo01_anofinal?>
    </td>
    <td>
<?
db_input('o01_anofinal',10,$Io01_anofinal,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </table>
  </fieldset>
  </td>
  </tr>
<tr>
  <td>
    <fieldset><legend><b>Lei do PPA</b></legend>
      <table>
        <tr>
          <td>
            <?=$Lo142_anoinicialppa ?>
          </td>
          <td>
            <?
            db_input('o142_anoinicialppa', 10, $Io142_anoinicialppa, true, 'text', $db_opcao, "" )
             ?>
          </td>
          <td>
            <?=$Lo142_anofinalppa ?>
          </td>
          <td>
            <?
            db_input('o142_anofinalppa', 10, $Io142_anofinalppa, true, 'text', $db_opcao, "" )
             ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?=@$To01_descricao?>">
             <?=@$Lo01_descricao?>
          </td>
          <td>
            <?
              db_input('o01_descricao',50,$Io01_descricao,true,'text',$db_opcao,"")
            ?>
          </td>
        </tr>
        <tr>
          <td>
             <?=@$Lo142_numeroleippa ?>
          </td>
          <td>
            <?
              db_input('o142_numeroleippa', 10, $Io142_numeroleippa, true, 'text', $db_opcao, "","","","",6)
            ?>
          </td>
          <td>
             <?=@$Lo142_dataleippa ?>
          </td>
          <td>
            <?
              db_inputdata('o142_dataleippa', @$o142_dataleippa_dia, @$o142_dataleippa_mes, @$o142_dataleippa_ano,true,
              'text',$db_opcao,"")
            ?>
          </td>
        </tr>
        <tr>
        <td>
             <?=@$Lo142_datapublicacaoppa ?>
          </td>
          <td>
            <?
              db_inputdata('o142_datapublicacaoppa', @$o142_datapublicacaoppa_dia, @$o142_datapublicacaoppa_mes, @$o142_datapublicacaoppa_ano,
              true,'text',$db_opcao,"")
            ?>
          </td>
        </tr>
        </table>
  </fieldset>
        <tr>
<td>
 <fieldset id="LegendfieldsetLegendFirstYearPpa"><legend onclick="toggleFieldset('fieldsetLegendFirstYearPpa')" class="legend-arrow"><b><div id="firstYearPpa"></div> </b></legend>
<table border="0" id="fieldsetLegendFirstYearPpa" style="display: none;">
  <tr>
        <td>
             <?=@$Lo142_leialteracaoppa ?>
          </td>
          <td>
            <?
              db_input('o142_leialteracaoppa', 10, $Io142_leialteracaoppa ,true, 'text', $db_opcao, "","","","",6)
            ?>
          </td>
        </tr>
        <tr>
        <td>
             <?=@$Lo142_dataalteracaoppa ?>
          </td>
          <td>
            <?
              db_inputdata('o142_dataalteracaoppa', @$o142_dataalteracaoppa_dia, @$o142_dataalteracaoppa_mes,
              @$o142_dataalteracaoppa_ano, true,'text',$db_opcao,"")
            ?>
          </td>
        </tr>
        <tr>
        <td>
             <?=@$Lo142_datapubalteracao ?>
          </td>
          <td>
            <?
              db_inputdata('o142_datapubalteracao', @$o142_datapubalteracao_dia, @$o142_datapubalteracao_mes, @$o142_datapubalteracao_ano,
              true,'text',$db_opcao,"")
            ?>
          </td>
        </tr>
</table>
</fieldset>
</td>
</tr>
<tr>
<td>
 <fieldset id="LegendfieldsetLegendSecondYearPpa"><legend onclick="toggleFieldset('fieldsetLegendSecondYearPpa')" class="legend-arrow"><b><div id="secondYearPpa"></div> </b></legend>
<table border="0" id="fieldsetLegendSecondYearPpa" style="display: none;">
  <tr>
        <td> 
             <?=@$Lo142_leialteracaoppa ?>
          </td>
          <td>
            <?
              db_input('o142_leialteracaoppaano2', 10, $Io142_leialteracaoppaano2 ,true, 'text', $db_opcao, "style='background-color: #E6E4F1;'","","","",6)
            ?>
          </td>
        </tr>
        <tr>
        <td>
             <?=@$Lo142_dataalteracaoppa ?>
          </td>
          <td>
            <?
              db_inputdata('o142_dataalteracaoppaano2', @$o142_dataalteracaoppaano2_dia, @$o142_dataalteracaoppaano2_mes,
              @$o142_dataalteracaoppaano2_ano, true,'text',$db_opcao,"style='background-color: #E6E4F1;'")
            ?>
          </td>
        </tr>
        <tr>
        <td>
             <?=@$Lo142_datapubalteracao ?>
          </td>
          <td>
            <?
              db_inputdata('o142_datapubalteracaoano2', @$o142_datapubalteracaoano2_dia, @$o142_datapubalteracaoano2_mes, @$o142_datapubalteracaoano2_ano,
              true,'text',$db_opcao,"style='background-color: #E6E4F1;'")
            ?>
          </td>
        </tr>
</table>
</fieldset>
</td>
</tr>
<tr>
<td>
 <fieldset id="LegendfieldsetLegendThirdYearPpa"><legend onclick="toggleFieldset('fieldsetLegendThirdYearPpa')" class="legend-arrow"><b><div id="thirdYearPpa"></div> </b></legend>
<table border="0" id="fieldsetLegendThirdYearPpa" style="display: none;">
  <tr>
        <td>
             <?=@$Lo142_leialteracaoppa ?>
          </td>
          <td>
            <?
              db_input('o142_leialteracaoppaano3', 10, $Io142_leialteracaoppaano3 ,true, 'text', $db_opcao, "style='background-color: #E6E4F1;'","","","",6)
            ?>
          </td>
        </tr>
        <tr>
        <td>
             <?=@$Lo142_dataalteracaoppa ?>
          </td>
          <td>
            <?
              db_inputdata('o142_dataalteracaoppaano3', @$o142_dataalteracaoppaano3_dia, @$o142_dataalteracaoppaano3_mes,
              @$o142_dataalteracaoppaano3_ano, true,'text',$db_opcao,"style='background-color: #E6E4F1;'")
            ?>
          </td>
        </tr>
        <tr>
        <td>
             <?=@$Lo142_datapubalteracao ?>
          </td>
          <td>
            <?
              db_inputdata('o142_datapubalteracaoano3', @$o142_datapubalteracaoano3_dia, @$o142_datapubalteracaoano3_mes, @$o142_datapubalteracaoano3_ano,
              true,'text',$db_opcao,"style='background-color: #E6E4F1;'")
            ?>
          </td>
        </tr>
</table>
</fieldset>
</td>
</tr>
<tr>
<td>
 <fieldset id="LegendfieldsetLegendForthYearPpa"><legend onclick="toggleFieldset('fieldsetLegendForthYearPpa')" class="legend-arrow"><b><div id="forthYearPpa"></div> </b></legend>
<table border="0" id="fieldsetLegendForthYearPpa" style="display: none;">
  <tr>
        <td>
             <?=@$Lo142_leialteracaoppa ?>
          </td>
          <td>
            <?
              db_input('o142_leialteracaoppaano4', 10, $Io142_leialteracaoppaano4 ,true, 'text', $db_opcao, "style='background-color: #E6E4F1;'","","","",6)
            ?>
          </td>
        </tr>
        <tr>
        <td>
             <?=@$Lo142_dataalteracaoppa ?>
          </td>
          <td>
            <?
              db_inputdata('o142_dataalteracaoppaano4', @$o142_dataalteracaoppaano4_dia, @$o142_dataalteracaoppaano4_mes,
              @$o142_dataalteracaoppaano4_ano, true,'text',$db_opcao,"style='background-color: #E6E4F1;'")
            ?>
          </td>
        </tr>
        <tr>
        <td>
             <?=@$Lo142_datapubalteracao ?>
          </td>
          <td>
            <?
              db_inputdata('o142_datapubalteracaoano4', @$o142_datapubalteracaoano4_dia, @$o142_datapubalteracaoano4_mes, @$o142_datapubalteracaoano4_ano,
              true,'text',$db_opcao,"style='background-color: #E6E4F1;'")
            ?>
          </td>
        </tr>
</table>
</fieldset>
</td>
</tr>   
<tr>
<td>
<fieldset id="LegendfieldsetLegendFirstYear"><legend onclick="toggleFieldset('fieldsetLegendFirstYear')" class="legend-arrow"><b><div id="firstYear"></div> </b></legend>
<table border="0" id="fieldsetLegendFirstYear" style="display: none;">
  <tr>
    <td nowrap title="<?=@$To01_numerolei?>">
      <b>Número da LDO:</b>
    </td>
    <td>
<?
db_input('o01_numerolei',10,$Io01_numerolei,true,'text',$db_opcao,"","","","",6)
?>
    </td>
    <td>
      <?=$Lo142_dataldo ?>
    </td>
    <td>
      <?
        db_inputdata('o142_dataldo', @$o142_dataldo_dia ,  @$o142_dataldo_mes,  @$o142_dataldo_ano,
                     true,'text',$db_opcao,"");
      ?>
    </td>
  </tr>
  <tr>
    <td>
      <?=$Lo142_datapublicacaoldo ?>
    </td>
    <td>
      <?
        db_inputdata('o142_datapublicacaoldo', @$o142_datapublicacaoldo_dia, @$o142_datapublicacaoldo_mes, @$o142_datapublicacaoldo_ano,
        true, "text", $db_opcao, "")
      ?>
    </td>
   </tr>
   <tr>
    <td>
    <b>Número da Lei de Alteração da LDO:</b>
          </td>
          <td>
            <?
              db_input('o142_leialteracaoldo', 10, $Io142_leialteracaoldo ,true, 'text', $db_opcao, "style='background-color: #E6E4F1;'","","","",6)
            ?>
          </td>
        </tr>
        <tr>
        <td>
        <b>Data da Lei de Alteração da LDO:</b>
          </td>
          <td>
            <?
              db_inputdata('o142_dataalteracaoldo', @$o142_dataalteracaoldo_dia, @$o142_dataalteracaoldo_mes,
              @$o142_dataalteracaoldo_ano, true,'text',$db_opcao,"style='background-color: #E6E4F1;'")
            ?>
          </td>
        </tr>
        <tr>
        <td>
        <b>Data de Publicação da Lei de Alteração da LDO:</b>
          </td>
          <td>
            <?
              db_inputdata('o142_datapubalteracaoldo', @$o142_datapubalteracaoldo_dia, @$o142_datapubalteracaoldo_mes, @$o142_datapubalteracaoldo_ano,
              true,'text',$db_opcao,"style='background-color: #E6E4F1;'")
            ?>
          </td>
        </tr>
    <tr>
      <td>
        <?=$Lo142_numeroloa ?>
      </td>
      <td>
        <?
          db_input('o142_numeroloa', 10, $Io142_numeroloa, true, 'text', $db_opcao, "","","","",6)
        ?>
      </td>
      <td>
        <?=$Lo142_dataloa ?>
      </td>
      <td>
        <?
          db_inputdata('o142_dataloa', @$o142_dataloa_dia, @$o142_dataloa_mes, @$o142_dataloa_ano, true, 'text', $db_opcao, "")
        ?>
      </td>
    </tr>
    <tr>
      <td>
        <?=$Lo142_datapubloa ?>
      </td>
      <td>
        <?
          db_inputdata('o142_datapubloa', @$o142_datapubloa_dia, @$o142_datapubloa_mes, @$o142_datapubloa_ano, true, 'text', $db_opcao, "")
        ?>
      </td>
    </tr>
    <tr>
      <td>
        <?=$Lo142_percsuplementacao ?>
      </td>
      <td>
        <?
          db_input('o142_percsuplementacao', 10, $Io142_percsuplementacao, true, 'text', $db_opcao, "")
        ?>
      </td>
     </tr>
     <tr>
      <td>
        <?=$Lo142_percaro ?>
      </td>
      <td>
        <?
          db_input('o142_percaro', 10, $Io142_percaro, true, 'text', $db_opcao, "")
        ?>
      </td>
     </tr>
     <tr>
      <td>
        <?=$Lo142_percopercredito ?>
      </td>
      <td>
        <?
          db_input('o142_percopercredito', 10, $Io142_percopercredito, true, 'text', $db_opcao, "")
        ?>
      </td>
     </tr>
     <tr>
        <td nowrap title="<?=@$To142_orcmodalidadeaplic ?>">
            <?=@$Lo142_orcmodalidadeaplic ?>
        </td>
        <td><?
            $aOpcoes = array("f"=>"Não","t"=>"Sim",""=>"Selecione");
            db_select("o142_orcmodalidadeaplic",$aOpcoes,true,$db_opcao, "style='width: 84px;'");
            ?>
        </td>
    </tr>
  </table>
  </fieldset>
  </td>
  </tr>
   <tr>
<td>
 <fieldset id="LegendfieldsetLegendSecondYear"><legend onclick="toggleFieldset('fieldsetLegendSecondYear')" class="legend-arrow"><b><div id="secondYear"></div> </b></legend>
<table border="0" id="fieldsetLegendSecondYear" style="display: none;">
  <tr>
    <td nowrap title="<?=@$To01_numerolei?>">
      <b>Número da LDO:</b>
    </td>
    <td>
<?
db_input('o01_numeroleiano2',10,$Io01_numeroleiano2,true,'text',$db_opcao,"style='background-color: #E6E4F1;'","","","",6)
?>
    </td>
    <td>
      <?=$Lo142_dataldo ?>
    </td>
    <td>
      <?
        db_inputdata('o142_dataldoano2', @$o142_dataldoano2_dia ,  @$o142_dataldoano2_mes,  @$o142_dataldoano2_ano,
                     true,'text',$db_opcao,"style='background-color: #E6E4F1;'");
      ?>
    </td>
  </tr>
  <tr>
    <td>
      <?=$Lo142_datapublicacaoldo ?>
    </td>
    <td>
      <?
        db_inputdata('o142_datapublicacaoldoano2', @$o142_datapublicacaoldoano2_dia, @$o142_datapublicacaoldoano2_mes, @$o142_datapublicacaoldoano2_ano,
        true, "text", $db_opcao, "style='background-color: #E6E4F1;'")
      ?>
    </td>
   </tr>
   <tr>
    <td>
    <b>Número da Lei de Alteração da LDO:</b>
          </td>
          <td>
            <?
              db_input('o142_leialteracaoldoano2', 10, $Io142_leialteracaoldoano2 ,true, 'text', $db_opcao, "style='background-color: #E6E4F1;'","","","",6)
            ?>
          </td>
        </tr>
        <tr>
        <td>
        <b>Data da Lei de Alteração da LDO:</b>
          </td>
          <td>
            <?
              db_inputdata('o142_dataalteracaoldoano2', @$o142_dataalteracaoldoano2_dia, @$o142_dataalteracaoldoano2_mes,
              @$o142_dataalteracaoldoano2_ano, true,'text',$db_opcao,"style='background-color: #E6E4F1;'")
            ?>
          </td>
        </tr>
        <tr>
        <td>
        <b>Data de Publicação da Lei de Alteração da LDO:</b>
          </td>
          <td>
            <?
              db_inputdata('o142_datapubalteracaoldoano2', @$o142_datapubalteracaoldoano2_dia, @$o142_datapubalteracaoldoano2_mes, @$o142_datapubalteracaoldoano2_ano,
              true,'text',$db_opcao,"style='background-color: #E6E4F1;'")
            ?>
          </td>
        </tr>
    <tr>
      <td>
        <?=$Lo142_numeroloa ?>
      </td>
      <td>
        <?
          db_input('o142_numeroloaano2', 10, $Io142_numeroloaano2, true, 'text', $db_opcao, "style='background-color: #E6E4F1;'","","","",6)
        ?>
      </td>
      <td>
        <?=$Lo142_dataloa ?>
      </td>
      <td>
        <?
          db_inputdata('o142_dataloaano2', @$o142_dataloaano2_dia, @$o142_dataloaano2_mes, @$o142_dataloaano2_ano, true, 'text', $db_opcao, "style='background-color: #E6E4F1;'")
        ?>
      </td>
    </tr>
    <tr>
      <td>
        <?=$Lo142_datapubloa ?>
      </td>
      <td>
        <?
          db_inputdata('o142_datapubloaano2', @$o142_datapubloaano2_dia, @$o142_datapubloaano2_mes, @$o142_datapubloaano2_ano, true, 'text', $db_opcao, "style='background-color: #E6E4F1;'")
        ?>
      </td>
    </tr>
    <tr>
      <td>
        <?=$Lo142_percsuplementacao ?>
      </td>
      <td>
        <?
          db_input('o142_percsuplementacaoano2', 10, $Io142_percsuplementacaoano2, true, 'text', $db_opcao, "style='background-color: #E6E4F1;'")
        ?>
      </td>
     </tr>
     <tr>
      <td>
        <?=$Lo142_percaro ?>
      </td>
      <td>
        <?
          db_input('o142_percaroano2', 10, $Io142_percaroano2, true, 'text', $db_opcao, "style='background-color: #E6E4F1;'")
        ?>
      </td>
     </tr>
     <tr>
      <td>
        <?=$Lo142_percopercredito ?>
      </td>
      <td>
        <?
          db_input('o142_percopercreditoano2', 10, $Io142_percopercreditoano2, true, 'text', $db_opcao, "style='background-color: #E6E4F1;'")
        ?>
      </td>
     </tr>
     <tr>
        <td nowrap title="<?=@$To142_orcmodalidadeaplic ?>">
            <?=@$Lo142_orcmodalidadeaplic ?>
        </td>
        <td><?
            $aOpcoes = array("f"=>"Não","t"=>"Sim",""=>"Selecione");
            db_select("o142_orcmodalidadeaplicano2",$aOpcoes,true,$db_opcao, "style='width: 84px;'");
            ?>
        </td>
    </tr>
  </table>
  </fieldset>
  </td>
  </tr>
   <tr>
<td>
 <fieldset id="LegendfieldsetLegendThirdYear"><legend onclick="toggleFieldset('fieldsetLegendThirdYear')" class="legend-arrow"><b><div id="thirdYear"></div> </b></legend>
<table border="0" id="fieldsetLegendThirdYear" style="display: none;">
  <tr>
    <td nowrap title="<?=@$To01_numerolei?>">
      <b>Número da LDO:</b>
    </td>
    <td>
<?
db_input('o01_numeroleiano3',10,$Io01_numeroleiano3,true,'text',$db_opcao,"style='background-color: #E6E4F1;'","","","",6)
?>
    </td>
    <td>
      <?=$Lo142_dataldo ?>
    </td>
    <td>
      <?
        db_inputdata('o142_dataldoano3', @$o142_dataldoano3_dia ,  @$o142_dataldoano3_mes,  @$o142_dataldoano3_ano,
                     true,'text',$db_opcao,"style='background-color: #E6E4F1;'");
      ?>
    </td>
  </tr>
  <tr>
    <td>
      <?=$Lo142_datapublicacaoldo ?>
    </td>
    <td>
      <?
        db_inputdata('o142_datapublicacaoldoano3', @$o142_datapublicacaoldoano3_dia, @$o142_datapublicacaoldoano3_mes, @$o142_datapublicacaoldoano3_ano,
        true, "text", $db_opcao, "style='background-color: #E6E4F1;'")
      ?>
    </td>
   </tr>
   <tr>
    <td>
    <b>Número da Lei de Alteração da LDO:</b>
          </td>
          <td>
            <?
              db_input('o142_leialteracaoldoano3', 10, $Io142_leialteracaoldoano3 ,true, 'text', $db_opcao, "style='background-color: #E6E4F1;'","","","",6)
            ?>
          </td>
        </tr>
        <tr>
        <td>
        
        <b>Data da Lei de Alteração da LDO:</b>
          </td>
          <td>
            <?
              db_inputdata('o142_dataalteracaoldoano3', @$o142_dataalteracaoldoano3_dia, @$o142_dataalteracaoldoano3_mes,
              @$o142_dataalteracaoldoano3_ano, true,'text',$db_opcao,"style='background-color: #E6E4F1;'")
            ?>
          </td>
        </tr>
        <tr>
        <td>
        <b>Data de Publicação da Lei de Alteração da LDO:</b>
          </td>
          <td>
            <?
              db_inputdata('o142_datapubalteracaoldoano3', @$o142_datapubalteracaoldoano3_dia, @$o142_datapubalteracaoldoano3_mes, @$o142_datapubalteracaoldoano3_ano,
              true,'text',$db_opcao,"style='background-color: #E6E4F1;'")
            ?>
          </td>
        </tr>
    <tr>
      <td>
        <?=$Lo142_numeroloa ?>
      </td>
      <td>
        <?
          db_input('o142_numeroloaano3', 10, $Io142_numeroloaano3, true, 'text', $db_opcao, "style='background-color: #E6E4F1;'","","","",6)
        ?>
      </td>
      <td>
        <?=$Lo142_dataloa ?>
      </td>
      <td>
        <?
          db_inputdata('o142_dataloaano3', @$o142_dataloaano3_dia, @$o142_dataloaano3_mes, @$o142_dataloaano3_ano, true, 'text', $db_opcao, "style='background-color: #E6E4F1;'")
        ?>
      </td>
    </tr>
    <tr>
      <td>
        <?=$Lo142_datapubloa ?>
      </td>
      <td>
        <?
          db_inputdata('o142_datapubloaano3', @$o142_datapubloaano3_dia, @$o142_datapubloaano3_mes, @$o142_datapubloaano3_ano, true, 'text', $db_opcao, "style='background-color: #E6E4F1;'")
        ?>
      </td>
    </tr>
    <tr>
      <td>
        <?=$Lo142_percsuplementacao ?>
      </td>
      <td>
        <?
          db_input('o142_percsuplementacaoano3', 10, $Io142_percsuplementacaoano3, true, 'text', $db_opcao, "style='background-color: #E6E4F1;'")
        ?>
      </td>
     </tr>
     <tr>
      <td>
        <?=$Lo142_percaro ?>
      </td>
      <td>
        <?
          db_input('o142_percaroano3', 10, $Io142_percaroano3, true, 'text', $db_opcao, "style='background-color: #E6E4F1;'")
        ?>
      </td>
     </tr>
     <tr>
      <td>
        <?=$Lo142_percopercredito ?>
      </td>
      <td>
        <?
          db_input('o142_percopercreditoano3', 10, $Io142_percopercreditoano3, true, 'text', $db_opcao, "style='background-color: #E6E4F1;'")
        ?>
      </td>
     </tr>
     <tr>
        <td nowrap title="<?=@$To142_orcmodalidadeaplic ?>">
            <?=@$Lo142_orcmodalidadeaplic ?>
        </td>
        <td><?
            $aOpcoes = array("f"=>"Não","t"=>"Sim",""=>"Selecione");
            db_select("o142_orcmodalidadeaplicano3",$aOpcoes,true,$db_opcao, "style='width: 84px;'");
            ?>
        </td>
    </tr>
  </table>
  </fieldset>
  </td>
  </tr>
   <tr>
<td>
<fieldset id="LegendfieldsetLegendForthYear" ><legend  onclick="toggleFieldset('fieldsetLegendForthYear')" class="legend-arrow"><b><div id="forthYear"></div> </b></legend>
<table border="0" id="fieldsetLegendForthYear" style="display: none;">
  <tr>
    <td nowrap title="<?=@$To01_numerolei?>">
      <b>Número da LDO:</b>
    </td>
    <td>
<?
db_input('o01_numeroleiano4',10,$Io01_numeroleiano4,true,'text',$db_opcao,"style='background-color: #E6E4F1;'","","","",6)
?>
    </td>
    <td>
      <?=$Lo142_dataldo ?>
    </td>
    <td>
      <?
        db_inputdata('o142_dataldoano4', @$o142_dataldoano4_dia ,  @$o142_dataldoano4_mes,  @$o142_dataldoano4_ano,
                     true,'text',$db_opcao,"style='background-color: #E6E4F1;'");
      ?>
    </td>
  </tr>
  <tr>
    <td>
      <?=$Lo142_datapublicacaoldo ?>
    </td>
    <td>
      <?
        db_inputdata('o142_datapublicacaoldoano4', @$o142_datapublicacaoldoano4_dia, @$o142_datapublicacaoldoano4_mes, @$o142_datapublicacaoldoano4_ano,
        true, "text", $db_opcao, "style='background-color: #E6E4F1;'")
      ?>
    </td>
   </tr>
   <tr>
    <td>
    <b>Número da Lei de Alteração da LDO:</b>
          </td>
          <td>
            <?
              db_input('o142_leialteracaoldoano4', 10, $Io142_leialteracaoldoano4 ,true, 'text', $db_opcao, "style='background-color: #E6E4F1;'","","","",6)
            ?>
          </td>
        </tr>
        <tr>
        <td>
        <b>Data da Lei de Alteração da LDO:</b>
          </td>
          <td>
            <?
              db_inputdata('o142_dataalteracaoldoano4', @$o142_dataalteracaoldoano4_dia, @$o142_dataalteracaoldoano4_mes,
              @$o142_dataalteracaoldoano4_ano, true,'text',$db_opcao,"style='background-color: #E6E4F1;'")
            ?>
          </td>
        </tr>
        <tr>
        <td>
            <b>Data de Publicação da Lei de Alteração da LDO:</b>
          </td>
          <td>
            <?
              db_inputdata('o142_datapubalteracaoldoano4', @$o142_datapubalteracaoldoano4_dia, @$o142_datapubalteracaoldoano4_mes, @$o142_datapubalteracaoldoano4_ano,
              true,'text',$db_opcao,"style='background-color: #E6E4F1;'")
            ?>
          </td>
        </tr>
    <tr>
    <tr>
      <td>
        <?=$Lo142_numeroloa ?>
      </td>
      <td>
        <?
          db_input('o142_numeroloaano4', 10, $Io142_numeroloaano4, true, 'text', $db_opcao, "style='background-color: #E6E4F1;'","","","",6)
        ?>
      </td>
      <td>
        <?=$Lo142_dataloa ?>
      </td>
      <td>
        <?
          db_inputdata('o142_dataloaano4', @$o142_dataloaano4_dia, @$o142_dataloaano4_mes, @$o142_dataloaano4_ano, true, 'text', $db_opcao, "style='background-color: #E6E4F1;'")
        ?>
      </td>
    </tr>
    <tr>
      <td>
        <?=$Lo142_datapubloa ?>
      </td>
      <td>
        <?
          db_inputdata('o142_datapubloaano4', @$o142_datapubloaano4_dia, @$o142_datapubloaano4_mes, @$o142_datapubloaano4_ano, true, 'text', $db_opcao, "style='background-color: #E6E4F1;'")
        ?>
      </td>
    </tr>
      <td>
        <?=$Lo142_percsuplementacao ?>
      </td>
      <td>
        <?
          db_input('o142_percsuplementacaoano4', 10, $Io142_percsuplementacaoano4, true, 'text', $db_opcao, "style='background-color: #E6E4F1;'")
        ?>
      </td>
     </tr>
     <tr>
      <td>
        <?=$Lo142_percaro ?>
      </td>
      <td>
        <?
          db_input('o142_percaroano4', 10, $Io142_percaroano4, true, 'text', $db_opcao, "style='background-color: #E6E4F1;'")
        ?>
      </td>
     </tr>
     <tr>
      <td>
        <?=$Lo142_percopercredito ?>
      </td>
      <td>
        <?
          db_input('o142_percopercreditoano4', 10, $Io142_percopercreditoano4, true, 'text', $db_opcao, "style='background-color: #E6E4F1;'")
        ?>
      </td>
     </tr>
     <tr>
        <td nowrap title="<?=@$To142_orcmodalidadeaplic ?>">
            <?=@$Lo142_orcmodalidadeaplic ?>
        </td>
        <td><?
            $aOpcoes = array("f"=>"Não","t"=>"Sim",""=>"Selecione");
            db_select("o142_orcmodalidadeaplicano4",$aOpcoes,true,$db_opcao, "style='width: 84px;'");
            ?>
        </td>
    </tr>
  </table>
  </fieldset>
  </td>
  </tr>
  </table>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>"
       type="submit" id="db_opcao" onclick="return js_validarCadastro()";
       value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>"
       <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
var db_opcao = <?php echo $db_opcao; ?>; 
function js_pesquisao01_instit(mostra)
{
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_db_config','func_db_config.php?funcao_js=parent.js_mostradb_config1|codigo|nomeinst','Pesquisa',true);
  }else{
     if(document.form1.o01_instit.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_db_config','func_db_config.php?pesquisa_chave='+document.form1.o01_instit.value+'&funcao_js=parent.js_mostradb_config','Pesquisa',false);
     }else{
       document.form1.nomeinst.value = '';
     }
  }
}
function js_mostradb_config(chave,erro)
{
  document.form1.nomeinst.value = chave;
  if(erro==true){
    document.form1.o01_instit.focus();
    document.form1.o01_instit.value = '';
  }
}
function js_mostradb_config1(chave1,chave2)
{
  document.form1.o01_instit.value = chave1;
  document.form1.nomeinst.value = chave2;
  db_iframe_db_config.hide();
}
function js_pesquisa()
{
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_ppalei','func_ppalei.php?funcao_js=parent.js_preenchepesquisa|o01_sequencial','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_ppalei.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}

function js_adicionaAno() 
{
  var iAnoInicial = new Number(document.getElementById('o01_anoinicio').value);
  var iAnoFinal   = iAnoInicial+3;

  if (document.getElementById('o01_anofinal').value == "" && document.getElementById('o01_anoinicio').value != "") {

    document.getElementById('o01_anofinal').value = iAnoFinal;

  }
  updateFirstYear(document.getElementById('o01_anoinicio').value);

}
function js_validarCadastro() 
{
  var iAnoInicial = new Number(document.getElementById('o01_anoinicio').value);
  var iAnoFinal   = new Number(document.getElementById('o01_anofinal').value);
  if (iAnoFinal <= iAnoInicial) {

    alert('Ano Final deve ser maior que o ano inicial');
    return false;

  }

  if ((iAnoFinal - iAnoInicial) != 3) {

    alert('A diferença entre o ano final e ano inicial deve ser 4 anos');
    return false;

  }
}
function updateFirstYear(startingYear) 
{ 
  var startingYear      = Number(startingYear) || 1;
  var firstYearElement  = document.getElementById('firstYear');
  var secondYearElement = document.getElementById('secondYear');
  var thirdYearElement  = document.getElementById('thirdYear');
  var forthYearElement  = document.getElementById('forthYear');

  if (!isNaN(startingYear) && firstYearElement && secondYearElement && thirdYearElement && forthYearElement) {
    firstYearElement.innerHTML  = '<b>LDO / LOA ANO ' + startingYear + '</b>';
    secondYearElement.innerHTML = '<b>LDO / LOA ANO ' + (startingYear + 1) + '</b>';
    thirdYearElement.innerHTML  = '<b>LDO / LOA ANO ' + (startingYear + 2) + '</b>';
    forthYearElement.innerHTML  = '<b>LDO / LOA ANO ' + (startingYear + 3) + '</b>';
  }
  document.getElementById('o142_anoinicialppa').value = document.getElementById('o01_anoinicio').value
  document.getElementById('o142_anofinalppa').value = document.getElementById('o01_anofinal').value
  updateFirstYearPpa(startingYear);
}
function updateFirstYearPpa(startingYear) 
{ 

  var startingYear         = Number(startingYear) || 1;
  var firstYearPpaElement  = document.getElementById('firstYearPpa');
  var secondYearPpaElement = document.getElementById('secondYearPpa');
  var thirdYearPpaElement  = document.getElementById('thirdYearPpa');
  var forthYearPpaElement  = document.getElementById('forthYearPpa');

  if (!isNaN(startingYear) && firstYearPpaElement && secondYearPpaElement && thirdYearPpaElement && forthYearPpaElement) {
    firstYearPpaElement.innerHTML  = '<b>Lei do PPA ANO ' + startingYear + '</b>';
    secondYearPpaElement.innerHTML = '<b>Lei do PPA ANO ' + (startingYear + 1) + '</b>';
    thirdYearPpaElement.innerHTML  = '<b>Lei do PPA ANO ' + (startingYear + 2) + '</b>';
    forthYearPpaElement.innerHTML  = '<b>Lei do PPA ANO ' + (startingYear + 3) + '</b>';
  }
}
function toggleFieldset(fieldsetId) 
{
  var fieldset = document.getElementById(fieldsetId);
  if (fieldset.style.display === 'none' || fieldset.style.display === '') {
    openFieldset(fieldsetId);
    fieldset.style.display = 'block';
    
  } else {
    closeFieldset(fieldsetId);
    fieldset.style.display = 'none';
  }
}
function openFieldset(fieldsetId)  
{
    var fieldset = document.getElementById('Legend'+fieldsetId);
    fieldset.classList.add('fieldset-open');
    fieldset.classList.remove('fieldset-closed');
}
function closeFieldset(fieldsetId)  
{
  var fieldset = document.getElementById('Legend'+fieldsetId);
  fieldset.classList.add('fieldset-closed');
  fieldset.classList.remove('fieldset-open');
}
function loadScreen(db_opcao) 
{
  updateFirstYear(document.getElementById('o01_anoinicio').value);
  updateFirstYearPpa(document.getElementById('o01_anoinicio').value);
  if (db_opcao == 1) {
    document.getElementById("o142_orcmodalidadeaplic").value = "f";
    document.getElementById("o142_orcmodalidadeaplicano2").value = "f";
    document.getElementById("o142_orcmodalidadeaplicano3").value = "f";
    document.getElementById("o142_orcmodalidadeaplicano4").value = "f";
  }
}
loadScreen(db_opcao);
</script>

<style>
.legend-arrow {
  cursor: pointer;
  display: flex;
  align-items: left;
}

.legend-arrow::after {
  content: "\25B8";
  margin-left: 15px;
}

.fieldset-closed .legend-arrow::after {
  content: "\25B8";
}

.fieldset-open .legend-arrow::after {
  content: "\25BE";
}
</style>