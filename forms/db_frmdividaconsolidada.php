<?
//MODULO: sicom
include("dbforms/db_classesgenericas.php");
$cldividaconsolidada->rotulo->label();
$clcgm->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("z01_nome");
$clrotulo->label("l20_codigo");
?>
<form name="form1" method="post" action="">
  <center>
    <table>
      <tr>
        <td style="vertical-align:top;">
          <fieldset style="margin-top: 10px;">
            <table border="0">
              <tr>
                <td nowrap title="<?=@$Tsi167_sequencial?>">

                </td>
                <td>
                  <?
                  db_input('si167_sequencial',10,$Isi167_sequencial,true,'hidden',3,"")
                  ?>
                </td>
              </tr>
              <tr>
                <td nowrap title="<?=@$Tsi167_nroleiautorizacao?>">
                 <?=@$Lsi167_nroleiautorizacao?>
               </td>
               <td>
                <?
//db_textarea('si167_nroleiautorizacao',0,0,$Isi167_nroleiautorizacao,true,'text',$db_opcao,"")
                db_input('si167_nroleiautorizacao',14,$Isi167_nrodocumentocredor,true,'text',$db_opcao,"")
                ?>
              </td>
            </tr>
            <tr>
              <td nowrap title="<?=@$Tsi167_dtleiautorizacao?>">
               <?=@$Lsi167_dtleiautorizacao?>
             </td>
             <td>
              <?
              db_inputdata('si167_dtleiautorizacao',@$si167_dtleiautorizacao_dia,@$si167_dtleiautorizacao_mes,@$si167_dtleiautorizacao_ano,true,'text',$db_opcao,"")
              ?>
            </td>
          </tr>
          <tr>
            <td nowrap title="<?=@$Tsi167_dtpublicacaoleiautorizacao?>">
             <?=@$Lsi167_dtpublicacaoleiautorizacao?>
           </td>
           <td>
            <?
            db_inputdata('si167_dtpublicacaoleiautorizacao',@$si167_dtpublicacaoleiautorizacao_dia,@$si167_dtpublicacaoleiautorizacao_mes,@$si167_dtpublicacaoleiautorizacao_ano,true,'text',$db_opcao,"")
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?=@$Tsi167_nrocontratodivida?>">
           <?=@$Lsi167_nrocontratodivida?>
         </td>
         <td>
          <?
          db_input('si167_nrocontratodivida',14,$Isi167_nrocontratodivida,true,'text',$db_opcao,"")
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tsi167_dtassinatura?>">
         <?=@$Lsi167_dtassinatura?>
       </td>
       <td>
        <?
        db_inputdata('si167_dtassinatura',@$si167_dtassinatura_dia,@$si167_dtassinatura_mes,@$si167_dtassinatura_ano,true,'text',$db_opcao,"")
        ?>
      </td>
    </tr>

    <?
//$x = array("1"=>"CPF","2"=>"CNPJ","3"=>"Documento de Estrangeiros");
//db_select('si167_tipodocumentocredor',$x,true,$db_opcao,"");
//db_input('si167_tipodocumentocredor',1,$Isi167_tipodocumentocredor,true,'text',$db_opcao,"")
    ?>

    <?
    db_input('si167_nrodocumentocredor',14,$Isi167_nrodocumentocredor,true,'hidden',$db_opcao,"")
    ?>


    <tr>
      <td align="right"  nowrap title="<?=@$Tz01_numcgm?>">
        <?
        db_ancora(@$Lz01_numcgm,"js_pesquisaz01_numcgm(true);",$db_opcao);
        ?>
      </td>
      <td>
        <?
        db_input('z01_numcgm',8,$Iz01_numcgm,true,'text',$db_opcao," onchange='js_pesquisaz01_numcgm(false);'")
        ?>
        <?
        db_input('z01_nome',40,$Iz01_nome,true,'text',3);
        ?>
      </td>
    </tr>

    <tr>
      <td nowrap title="<?=@$Tsi167_contratodeclei?>">
       <?=@$Lsi167_contratodeclei?>
     </td>
     <td>
      <?
      $x = array("1"=>"Sim","2"=>"Não");
      db_select('si167_contratodeclei',$x,true,$db_opcao,"");
//db_input('si167_contratodeclei',1,$Isi167_contratodeclei,true,'text',$db_opcao,"")
      ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi167_tipolancamento?>">
     <?=@$Lsi167_tipolancamento?>
   </td>
   <td>
    <?
    if(db_getsession("DB_anousu") >= 2018 ){
      $x = array(
"01" => "01 D&#237;vida Mobili&#225;ria;",
        "02" => "02 D&#237;vida Contratual de PPP;",
        "03" => "03 D&#237;vida Contratual de Aquisi&#231;&#227;oFinanciada de Bens;",
        "04" => "04 D&#237;vida Contratualde Empr&#233;stimos;",
        "05" => "05 D&#237;vida Contratualde Financiamentos;",
        "06" => "06 D&#237;vida Contratualde Antecipa&#231;&#227;o de Receita pela Venda a Termo de Bens e Servi&#231;os;",
        "07" => "07 D&#237;vida Contratualde Assun&#231;&#227;o, Reconhecimento e Confiss&#227;o de D&#237;vidas (LRF, art. 29, &#167; 1&#186;);",
        "08" => "08 D&#237;vida Contratualde Opera&#231;&#245;es de cr&#233;dito previstas no art. 7&#186; &#167; 3&#186; da RSF n&#186; 43/2001;",
        "09" => "09 D&#237;vida Contratualde Parcelamento e Renegocia&#231;&#227;o de D&#237;vidas de Tributos;",
        "10" => "10 D&#237;vida Contratualde Parcelamento e Renegocia&#231;&#227;o de D&#237;vidas de Contribui&#231;&#245;es Sociais Previdenci&#225;rias;",
        "11" => "11 D&#237;vida Contratualde Parcelamento e Renegocia&#231;&#227;o de D&#237;vidas deOutras Contribui&#231;&#245;es Sociais;",
        "12" => "12 D&#237;vida Contratualde Parcelamento e Renegocia&#231;&#227;o de D&#237;vidas do FGTS;",
        "13" => "13 D&#237;vida Contratualde Parcelamento e Renegocia&#231;&#227;o de D&#237;vida com Institui&#231;&#227;o n&#227;o Financeira; (Vide Manual de Demonstrativos Fiscais. Ex.: Cemig, Copasa, etc);",
        "14" => "14 D&#237;vida Contratualcom Institui&#231;&#227;o Financeira;",
        "15" => "15 Demais D&#237;vidas Contratuais;",
        "16" => "16 Outras Opera&#231;&#245;es de Cr&#233;dito sujeitasao limite;",
        "17" => "17 Precat&#243;rios Posteriores a 05/05/2000 (inclusive) - Vencidos e n&#227;o Pagos;",
        "18" => "18 Precat&#243;rios Posteriores a 05/05/2000 (N&#227;o inclu&#237;dos na DC);Vide Manual de ,Demonstrativos Fiscais - MDF",
        "19" => "19 Reestrutura&#231;&#227;o Fiscal dos Munic&#237;pios;",
        "20" => "20 Outras D&#237;vidas;",
        "21" => "21 Outras Opera&#231;&#245;es de Cr&#233;dito n&#227;o Sujeitas ao Limite (Exemplo: Programa de Ilumina&#231;&#227;o P&#250;blica – RELUZ. Conforme MDF.);",
        "22" => "22 Opera&#231;&#245;es de Cr&#233;dito Vedadas;",
        "23" => "23 Precat&#243;rios Anteriores a 05/05/2000;",
        "24" => "24 Apropria&#231;&#227;o de Dep&#243;sitos Judiciais - LC 151/2015;",

        );
    }else{
      $x = array(
"01" => "01 D&#237;vida Mobili&#225;ria",
        "02" => "02 D&#237;vida Contratual de PPP",
        "03" => "03 D&#237;vida Contratual de Empr&#233;stimos",
        "04" => "04 D&#237;vida Contratual de Financiamentos",
        "05" => "05 D&#237;vida Contratual de Antecipa&#231;&#227;o de Receita pela Venda a Termo de Bens e Servi&#231;os",
        "06" => "06 D&#237;vida Contratual de Assun&#231;&#227;o, Reconhecimento e Confiss&#227;o de D&#237;vidas (LRF, art.29, &#167; 1&#186;)",
        "07" => "07 D&#237;vida Contratual de Opera&#231;&#245;es de cr&#233;dito previstas no art. 7&#186; &#167; 3&#186; da RSF n&#186; 43/2001",
        "08" => "08 D&#237;vida Contratual de Parcelamento e Renegocia&#231;&#227;o de D&#237;vidas de Tributos",
        "09" => "09 D&#237;vida Contratual de Parcelamento e Renegocia&#231;&#227;o de D&#237;vidas de Contribui&#231;&#245;es Sociais Previdenci&#225;rias",
        "10" => "10 D&#237;vida Contratual de Parcelamento e Renegocia&#231;&#227;o de D&#237;vidas de Outras Contribui&#231;&#245;es Sociais",
        "11" => "11 D&#237;vida Contratual de Parcelamento e Renegocia&#231;&#227;o de D&#237;vidas do FGTS",
        "12" => "12 D&#237;vida Contratual de Parcelamento e Renegocia&#231;&#227;o de D&#237;vida com Institui&#231;&#227;o n&#227;o Financeira",
        "13" => "13 D&#237;vida Contratual com Institui&#231;&#227;o Financeira",
        "14" => "14 Demais D&#237;vidas Contratuais",
        "15" => "15 Outras Opera&#231;&#245;es de Cr&#233;dito sujeitas ao limite",
        "16" => "16 Precat&#243;rios Posteriores a 05/05/2000 (inclusive) - Vencidos e n&#227;o Pagos",
        "17" => "17 Reestrutura&#231;&#227;o Fiscal dos Munic&#237;pios",
        "18" => "18 Outras D&#237;vidas",
        "19" => "19 Outras Opera&#231;&#245;es de Cr&#233;dito n&#227;o Sujeitas ao Limite (Exemplo: Programa de Ilumina&#231;&#227;o P&#250;blica ? RELUZ. Conforme MDF.)",
        "20" => "20 Opera&#231;&#245;es de Cr&#233;dito Vedadas",
        "21" => "21 Precat&#243;rios Anteriores a 05/05/2000",
        "22" => "22 Passivos Reconhecidos"

        );
    }
    db_select('si167_tipolancamento', $x, true, $db_opcao, " onchange='verificaTipoLancamento(this);' ");
    ?>
  </td>
</tr>

<tr>
  <td nowrap title="Subtipo do Lan&#231;amento:">
    <strong>Subtipo do Lan&#231;amento:</strong>
  </td>
  <td>
    <?
    $x = array(
      '0' => "",
      '1' => "Interno",
      '2' => "Externo"
      );
    db_select('si167_subtipo', $x, true, $db_opcao, "");
    ?>
  </td>
</tr>


<tr>
  <td nowrap title="<?=@$Tsi167_objetocontratodivida?>" colspan="2">
    <fieldset><legend><?=@$Lsi167_objetocontratodivida?></legend>

      <?
      db_textarea('si167_objetocontratodivida', 13, 80,'',true,"text",$db_opcao,"","","",1000)
      ?>
    </fieldset>
  </td>
</tr>
</table>
</fieldset>
</td>

<td style="vertical-align:top;">
  <fieldset style="margin-top: 10px; ">
    <table border="0">
      <tr>
        <td nowrap title="<?=@$Tsi167_especificacaocontratodivida?>" colspan="2">
         <fieldset><legend><?=@$Lsi167_especificacaocontratodivida?></legend>

          <?
          db_textarea('si167_especificacaocontratodivida', 5, 80,'',true,"text",$db_opcao,"","","",500)
          ?>
        </fieldset>
      </td>
    </tr>

    <tr>
      <td nowrap title="<?=@$Tsi167_vlsaldoanterior?>">
       <?=@$Lsi167_vlsaldoanterior?>
     </td>
     <td>
      <?
      db_input('si167_vlsaldoanterior',14,$Isi167_vlsaldoanterior,true,'text',$db_opcao,"")
      ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi167_vlcontratacao?>">
     <?=@$Lsi167_vlcontratacao?>
   </td>
   <td>
    <?
    db_input('si167_vlcontratacao',14,$Isi167_vlcontratacao,true,'text',$db_opcao,"")
    ?>
  </td>
</tr>
<tr>
  <td nowrap title="<?=@$Tsi167_vlamortizacao?>">
   <?=@$Lsi167_vlamortizacao?>
 </td>
 <td>
  <?
  db_input('si167_vlamortizacao',14,$Isi167_vlamortizacao,true,'text',$db_opcao,"")
  ?>
</td>
</tr>
<tr>
  <td nowrap title="<?=@$Tsi167_vlcancelamento?>">
   <?=@$Lsi167_vlcancelamento?>
 </td>
 <td>
  <?
  db_input('si167_vlcancelamento',14,$Isi167_vlcancelamento,true,'text',$db_opcao,"")
  ?>
</td>
</tr>
<tr>
  <td nowrap title="<?=@$Tsi167_vlencampacao?>">
   <?=@$Lsi167_vlencampacao?>
 </td>
 <td>
  <?
  db_input('si167_vlencampacao',14,$Isi167_vlencampacao,true,'text',$db_opcao,"")
  ?>
</td>
</tr>
<tr>
  <td nowrap title="<?=@$Tsi167_vlatualizacao?>">
   <?=@$Lsi167_vlatualizacao?>
 </td>
 <td>
  <?
  db_input('si167_vlatualizacao',14,$Isi167_vlatualizacao,true,'text',$db_opcao,"")
  ?>
</td>
</tr>
<tr>
  <td nowrap title="<?=@$Tsi167_vlsaldoatual?>">
   <?=@$Lsi167_vlsaldoatual?>
 </td>
 <td>
  <?
  db_input('si167_vlsaldoatual',14,$Isi167_vlsaldoatual,true,'text',$db_opcao,"")
  ?>
</td>
</tr>

<tr>
  <td nowrap title="<?=@$Tsi167_mesreferencia?>">
   <?=@$Lsi167_mesreferencia?>
 </td>
 <td>
  <?
  $x = array("0"=>"","1"=>"jan","2"=>"fev","3"=>"mar","4"=>"abr","5"=>"mai","6"=>"jun","7"=>"jul","8"=>"ago","9"=>"sete","10"=>"outu","11"=>"nov","12"=>"dez");
  db_select('si167_mesreferencia',$x,true,$db_opcao,"");
//db_input('si167_mesreferencia',2,$Isi167_mesreferencia,true,'text',$db_opcao,"")
  ?>
</td>
</tr>
<tr>
  <td nowrap title="Justificativa Cancelamento" colspan="2">
    <fieldset><legend>Justificativa Cancelamento</legend>

      <?
      db_textarea('si167_justificativacancelamento', 6, 80,'',true,"text",$db_opcao,"","","",500)
      ?>
    </fieldset>
  </td>
</tr>
</table>
</fieldset>
</td>
</tr>
</table>
</center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
<input name="importar" type="button" id="importar" value="Importar" onclick="js_importar();" <?=($db_opcao!=1?"disabled":"") ?>>
</form>
<script>

  function verificaTipoLancamento(select) {
    var nTipoLancamento = parseInt(select.value);
    var si167_subtipo   = document.getElementById('si167_subtipo');

    si167_subtipo.innerHTML = "";
    var sOptions = "";

    sOptions += "<option value='' disabled></option>";
    sOptions += "<option value='1'>Interno</option>";
    sOptions += "<option value='2'>Externo</option>";

    si167_subtipo.innerHTML = sOptions;

    if( !((nTipoLancamento >= 1) && (nTipoLancamento <= 15)) ) {
      si167_subtipo.value = '';
      si167_subtipo.setAttribute('disabled',true);
    } else {
      si167_subtipo.value = 1;
      si167_subtipo.removeAttribute('disabled');
    }

  }


  function js_pesquisa(){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_dividaconsolidada','func_dividaconsolidada.php?funcao_js=parent.js_preenchepesquisa|si167_sequencial','Pesquisa',true);
  }
  function js_preenchepesquisa(chave){
    db_iframe_dividaconsolidada.hide();
    <?
    if($db_opcao!=1){
      echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
    }
    ?>
  }
  function js_importar(){
   js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_dividaconsolidada','func_importadividaconsolidada.php?funcao_js=parent.js_preencheimportacao|si167_nroleiautorizacao|si167_nrocontratodivida|dl_ano|si167_mesreferencia','Pesquisa',true);
 }
 function js_preencheimportacao(chave1,chave2,chave3,chave4){
   db_iframe_dividaconsolidada.hide();
   <?
   echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisaimporta[si167_nroleiautorizacao]='+chave1+'&chavepesquisaimporta[si167_nrocontratodivida]='+chave2+
   '&chavepesquisaimporta[si167_anoreferencia]='+chave3+'&chavepesquisaimporta[si167_mesreferencia]='+chave4";
   ?>
 }


 function js_pesquisaz01_numcgm(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','func_nome','func_nome.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome','Pesquisa',true);
  }else{
    if(document.form1.z01_numcgm.value != ''){
      js_OpenJanelaIframe('','func_nome','func_nome.php?pesquisa_chave='+document.form1.z01_numcgm.value+'&funcao_js=parent.js_mostracgm','Pesquisa',false);
    }else{
      document.form1.z01_nome.value = '';
    }
  }
}
function js_mostracgm(erro,chave){
  document.form1.z01_nome.value = chave;
  if(erro==true){
    document.form1.z01_numcgm.focus();
    document.form1.z01_numcgm.value = '';
  }
}
function js_mostracgm1(chave1,chave2){
  document.form1.z01_numcgm.value = chave1;
  document.form1.z01_nome.value = chave2;
  func_nome.hide();
}
document.form1.si167_tipolancamento.style.width = '365px';
</script>
