<?
//MODULO: sicom
$clconsideracoes->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0" style="margin-top:10px;">
  <tr>
    <td nowrap title="<?=@$Tsi171_sequencial?>">
       <?=@$Lsi171_sequencial?>
    </td>
    <td>
      <? db_input('si171_sequencial',10,$Isi171_sequencial,true,'text',3,""); ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi171_codarquivo?>">
       <?=@$Lsi171_codarquivo?>
    </td>
    <td>
      <?
      $x = array("IDE"=>"IDE","PESSOA"=>"PESSOA","ORGAO"=>"ORGAO","CONSOR"=>"CONSOR","PAREC"=>"PAREC",
        "REC"=>"REC","ARC"=>"ARC","LAO"=>"LAO","AOC"=>"AOC","ITEM"=>"ITEM","REGLIC"=>"REGLIC","ABERLIC"=>"ABERLIC",
         "RESPLIC"=>"RESPLIC","HABLIC"=>"HABLIC","JULGLIC"=>"JULGLIC","HOMOLIC"=>"HOMOLIC","PARELIC"=>"PARELIC","REGADESAO"=>"REGADESAO","DISPENSA"=>"DISPENSA",
         "CONTRATOS"=>"CONTRATOS","CONV"=>"CONV","CTB"=>"CTB","CAIXA"=>"CAIXA","EMP"=>"EMP","ANL"=>"ANL","RSP"=>"RSP",
         "LQD"=>"LQD","ALQ"=>"ALQ","EXT"=>"EXT","AEX"=>"AEX","OPS"=>"OPS","AOP"=>"AOP","OBELAC"=>"OBELAC",
         "AOB"=>"AOB","NTF"=>"NTF","CVC"=>"CVC","DDC"=>"DDC","PARPPS"=>"PARPPS","DCLRF"=>"DCLRF","CONSID"=>"CONSID",
         "IP_IDE"=>"IP_IDE","IP_ORGAO"=>"IP_ORGAO","IP_LPP"=>"IP_LPP","IP_LOA"=>"IP_LOA","IP_LDO"=>"IP_LDO","IP_UOC"=>"IP_UOC",
         "IP_PRO"=>"IP_PRO","IP_AMP"=>"IP_AMP","IP_DSP"=>"IP_DSP","IP_REC"=>"IP_REC","IP_MTFIS"=>"IP_MTFIS","IP_RFIS"=>"IP_RFIS",
         "IP_MTBIARREC"=>"IP_MTBIARREC","CUTE"=>"CUTE","CRONEM"=>"CRONEM","METAREAL"=>"METAREAL","IDERP"=>"IDERP","CONGE"=>"CONGE"
       );
      db_select('si171_codarquivo',$x,true,$db_opcao,"");
      //db_input('si171_codarquivo',2,$Isi171_codarquivo,true,'text',$db_opcao,"")
      ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi171_consideracoes?>">
       <?=@$Lsi171_consideracoes?>
    </td>
    <td>
      <?
      db_textarea('si171_consideracoes',8,30,$Isi171_consideracoes,true,'text',$db_opcao,"")
      ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi171_anousu?>">
       <?=@$Lsi171_anousu?>
    </td>
    <td>
      <? db_input('si171_anousu',10,$Isi171_anousu,true,'text',3,""); ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi171_mesreferencia?>">
       <?=@$Lsi171_mesreferencia?>
    </td>
    <td>
      <?
      $x = array("1"=>"jan","2"=>"fev","3"=>"mar","4"=>"abr","5"=>"mai","6"=>"jun","7"=>"jul","8"=>"ago","9"=>"sete","10"=>"outu","11"=>"nov","12"=>"dez");
      db_select('si171_mesreferencia',$x,true,$db_opcao,"");
      //db_input('si171_mesreferencia',10,$Isi171_mesreferencia,true,'text',$db_opcao,"")
      ?>
    </td>
  </tr>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
<?
  if($db_opcao == 1){
    echo "document.form1.si171_anousu.value = ".db_getsession("DB_anousu");
  }
?>

function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_consideracoes','func_consideracoes.php?funcao_js=parent.js_preenchepesquisa|si171_sequencial','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_consideracoes.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
