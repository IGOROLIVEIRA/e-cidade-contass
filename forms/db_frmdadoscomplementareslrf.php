<?
//MODULO: sicom
$cldadoscomplementareslrf->rotulo->label();
?>
<form name="form1" method="post" action="">

<table border="0" >
  <tr>
  <td>

  <table>
  <tr>
    <td nowrap title="<?=@$Tsi170_sequencial?>">
       <?=@$Lsi170_sequencial?>
    </td>
    <td>
<?
db_input('si170_sequencial',10,$Isi170_sequencial,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap >
       <b>Saldo atual das concessões com garantia interna:</b>
    </td>
    <td>
<?
db_input('si170_vlsaldoatualconcgarantiainterna',14,4,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi170_vlsaldoatualconcgarantia?>">
       <b>Saldo atual das concessões com garantia externa:</b>
    </td>
    <td>
<?
db_input('si170_vlsaldoatualconcgarantia',14,$Isi170_vlsaldoatualconcgarantia,true,'text',$db_opcao,"")
?>
    </td>
  </tr>

    <tr>
    <td nowrap >
       <b>Saldo atual das contragarantias interna recebidas:</b>
    </td>
    <td>
<?
db_input('si170_vlsaldoatualcontragarantiainterna',14,4,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap>
       <b>Saldo atual das contragarantias externa recebidas:</b>
    </td>
    <td>
<?
db_input('si170_vlsaldoatualcontragarantiaexterna',14,4,true,'text',$db_opcao,"")
?>
    </td>
  </tr>

  <!-- novos campos -->
  <tr nowrap>
    <td><b>Valores dos passivos reconhecidos</b></td>
    <td>
      <?php db_input('si170_passivosreconhecidos', 14, 4, true, 'text', $db_opcao, ""); ?>
    </td>
  </tr>
  <tr nowrap>
    <td><b>Valor das Transferências obrigatórias da União relativas às emendas individuais</b></td>
    <td>
      <?php db_input('si170_vltransfobrigemindiv', 14, 4, true, 'text', $db_opcao, ""); ?>
    </td>
  </tr>
  <tr nowrap>
    <td><b>Valor da dotação atualizada de Incentivo a Contribuinte</b></td>
    <td>
      <?php db_input('si170_vldotatualizadaincentcontrib', 14, 4, true, 'text', $db_opcao, ""); ?>
    </td>
  </tr>
  <tr nowrap>
    <td><b>Valor empenhado de Incentivo a Contribuinte</b></td>
    <td>
      <?php db_input('si170_vlempenhadoicentcontrib', 14, 4, true, 'text', $db_opcao, ""); ?>
    </td>
  </tr>
  <tr nowrap>
    <td><b>Valor da dotação atualizada de Incentivo concedido por Instituição Financeira</b></td>
    <td>
      <?php db_input('si170_vldotatualizadaincentinstfinanc', 14, 4, true, 'text', $db_opcao, ""); ?>
    </td>
  </tr>
  <tr nowrap>
    <td><b>Valor empenhado de Incentivo concedido por Instituição Financeira</b></td>
    <td>
      <?php db_input('si170_vlempenhadoincentinstfinanc', 14, 4, true, 'text', $db_opcao, ""); ?>
    </td>
  </tr>


    <tr>
    <td colspan="2" >
    <fieldset><legend><b>Medidas corretivas adotadas:</b></legend>
<?
db_textarea('si170_medidascorretivas',8,60,0,true,'text',$db_opcao,"","","",4000)
?>
</fieldset>
    </td>
  </tr>


  <tr>
    <td nowrap title="<?=@$Tsi170_recprivatizacao?>">
       <?=@$Lsi170_recprivatizacao?>
    </td>
    <td>
<?
db_input('si170_recprivatizacao',14,$Isi170_recprivatizacao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi170_vlliqincentcontrib?>">
       <?=@$Lsi170_vlliqincentcontrib?>
    </td>
    <td>
<?
db_input('si170_vlliqincentcontrib',14,$Isi170_vlliqincentcontrib,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi170_vlliqincentInstfinanc?>">
       <?=@$Lsi170_vlliqincentInstfinanc?>
    </td>
    <td>
<?
db_input('si170_vlliqincentinstfinanc',14,$Isi170_vlliqincentInstfinanc,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi170_vlIrpnpincentcontrib?>">
       <?=@$Lsi170_vlIrpnpincentcontrib?>
    </td>
    <td>
<?
db_input('si170_vlirpnpincentcontrib',14,$Isi170_vlIrpnpincentcontrib,true,'text',$db_opcao,"")
?>
    </td>
  </tr>


  <?
$si170_instit = db_getsession("DB_instit");
db_input('si170_instit',10,$Isi170_instit,true,'hidden',$db_opcao,"")
?>

  </table>
  </td>


  <td>
  <table>

    <tr>
    <td nowrap title="<?=@$Tsi170_vllrpnpincentinstfinanc?>">
       <?=@$Lsi170_vllrpnpincentinstfinanc?>
    </td>
    <td>
<?
db_input('si170_vllrpnpincentinstfinanc',14,$Isi170_vllrpnpincentinstfinanc,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi170_vlcompromissado?>">
       <?=@$Lsi170_vlcompromissado?>
    </td>
    <td>
<?
db_input('si170_vlcompromissado',14,$Isi170_vlcompromissado,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi170_vlrecursosnaoaplicados?>">
       <?=@$Lsi170_vlrecursosnaoaplicados?>
    </td>
    <td>
<?
db_input('si170_vlrecursosnaoaplicados',14,$Isi170_vlrecursosnaoaplicados,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
    <tr>
    <td nowrap>
       <b>Publicação dos relatórios da LRF:</b>
    </td>
    <td>
<?
$x = array("0"=>"","1"=>"SIM","2"=>"NÃO");
db_select('si170_publiclrf',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
    <tr>
    <td nowrap>
       <b>Data de publicação dos relatórios da LRF:</b>
 </td>
    <td>
<?
db_inputdata('si170_dtpublicacaorelatoriolrf',@$si170_dtpublicacaorelatoriolrf_dia,@$si170_dtpublicacaorelatoriolrf_mes,@$si170_dtpublicacaorelatoriolrf_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
      <tr>
    <td nowrap>
       <b>Periodo a que se refere a data de publicação da LRF:</b>
    </td>
    <td>
<?
$x = array("0"=>"","1"=>"Primeiro Bimestre","2"=>"Segundo Bimestre / Primeiro quadrimestre","3"=>"Terceiro Bimestre / Primeiro semestre","4"=>"Quarto Bimestre / Segundo quadrimestre semestre",
"5"=>"Quinto Bimestre","6"=>"Sexto Bimestre / Terceiro quadrimestre / Segundo semestre");
db_select('si170_tpbimestre',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <tr>
    <td nowrap>
       <b>Publicação dos relatórios da LRF:</b>
    </td>
    <td>
<?
$x = array("0"=>"","1"=>"SIM","2"=>"NÃO");
db_select('si170_metarrecada',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <tr >
    <td colspan="2" >
    <fieldset><legend><b>Medidas adotadas e a adotar:</b></legend>
<?
db_textarea('si170_dscmedidasadotadas',8,60,0,true,'text',$db_opcao,"","","",4000)
?>
</fieldset>
    </td>
  </tr>
  <tr>
    <td colspan="2" title="<?=@$Tsi170_mesreferencia?>">
       <?=@$Lsi170_mesreferencia?>
<?
$x = array("1"=>"jan","2"=>"fev","3"=>"mar","4"=>"abr","5"=>"mai","6"=>"jun","7"=>"jul","8"=>"ago","9"=>"sete","10"=>"outu","11"=>"nov","12"=>"dez");
db_select('si170_mesreferencia',$x,true,$db_opcao,"");
//db_input('si170_mesreferencia',10,$Isi170_mesreferencia,true,'text',$db_opcao,"")
?>
    </td>
  </tr>

  </table>
  </td>
  </tr>
  </table>

<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisa(){
  js_OpenJanelaIframe('top.corpo','db_iframe_dadoscomplementareslrf','func_dadoscomplementareslrf.php?funcao_js=parent.js_preenchepesquisa|si170_sequencial','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_dadoscomplementareslrf.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
