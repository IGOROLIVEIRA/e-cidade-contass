<?
//MODULO: orcamento
include("dbforms/db_classesgenericas.php");
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clorcleialtorcamentaria->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("o138_numerolei");
if(isset($db_opcaoal)){
   	$db_opcao=33;
   	$db_botao=false;
}else if(isset($opcao) && $opcao=="alterar"){
    $db_botao=true;
    $db_opcao = 2;
}else if(isset($opcao) && $opcao=="excluir"){
    $db_opcao = 3;
    $db_botao=true;
}else{
    $db_opcao = 1;
    $db_botao=true;
    if(isset($novo) || isset($alterar) ||   isset($excluir) || (isset($incluir) && $sqlerro==false ) ){
     $o200_sequencial = "";
    	//$o201_orcprojetolei = "";
     $o200_tipoleialteracao = "";
     $o200_artleialteracao  = "";
     $o200_descrartigo      = "";
     $o200_vlautorizado     = "";
     $o200_percautorizado   = "";
   }
}
?>
<form name="form1" method="post" action="">
<center>
<fieldset style="margin:30px;">
<legend></legend>
<table border="0">
  <tr>
    <td nowrap title="<?=@$To200_sequencial?>">
       <?=@$Lo200_sequencial?>
    </td>
    <td>
<?
db_input('o200_sequencial',11,$Io200_sequencial,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$To200_orcprojetolei?>">
    <?=@$Lo200_orcprojetolei?>
    </td>
    <td>
<?
db_input('o200_orcprojetolei',11,$Io200_orcprojetolei,true,'text',3)
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$To200_tipoleialteracao?>">
       <?=@$Lo200_tipoleialteracao?>
    </td>
    <td>
<?
if ($o138_altpercsuplementacao == 1) {
	$x = array("1"=>"Abertura de créditos suplementares","2"=>"Contratação de operações de crédito","3"=>"Contratação de operações de crédito por antecipação de receita");
} else {
	$x = array("1"=>"Lei autorizativa de Crédito Suplementar","2"=>"Lei autorizativa de Crédito Especial","3"=>"Lei autorizativa de Remanejamento /transposição / transferência","4"=>"Lei autorizativa de alteração da fonte de recurso","5"=>"Lei autorizativa de suplementação de Crédito Especial");
}
//db_input('o200_tipoleialteracao',11,$Io200_tipoleialteracao,true,'text',$db_opcao,"")
db_select('o200_tipoleialteracao', $x, true,$db_opcao);
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$To200_artleialteracao?>">
       <?=@$Lo200_artleialteracao?>
    </td>
    <td>
<?
db_input('o200_artleialteracao',6,$Io200_artleialteracao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$To200_descrartigo?>">
       <?=@$Lo200_descrartigo?>
    </td>
    <td>
<?
db_textarea('o200_descrartigo',7,60,$Io200_descrartigo,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <? if($o138_altpercsuplementacao == 1) {?>
  <tr>
    <td nowrap title="Percentual Autorizado ">
      <b>Percentual Autorizado</b>
    </td>
    <td>
      <?
      db_input('o200_percautorizado',14,$Io200_percautorizado,true,'text',$db_opcao,"")
      ?>
    </td>
  </tr>
  <? } else { ?>
  <tr>
    <td nowrap title="<?=@$To200_vlautorizado?>">
       <?=@$Lo200_vlautorizado?>
    </td>
    <td>
    <?
    db_input('o200_vlautorizado',14,$Io200_vlautorizado,true,'text',$db_opcao,"")
    ?>
    </td>
  </tr>
  <? } ?>
  </table>
  <br>
  <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
   <table>
  <tr>
    <td valign="top"  align="center">
    <?
    if ($o138_altpercsuplementacao == 1) {
    	$campossql = "o200_sequencial,o200_orcprojetolei,
    	case when o200_tipoleialteracao = 1 then 'Abertura de créditos suplementares' when o200_tipoleialteracao = 2 then 'Contratação de operações de crédito'
    	when o200_tipoleialteracao = 3 then 'Contratação de operações de crédito por antecipação de receita' end as o200_tipoleialteracao,
    	o200_artleialteracao,o200_descrartigo,o200_percautorizado";
    	$campos = "o200_sequencial,o200_orcprojetolei,o200_tipoleialteracao,o200_artleialteracao,o200_percautorizado";
    } else {
    	$campossql = "o200_sequencial,o200_orcprojetolei,
    	case when o200_tipoleialteracao = 1 then 'Lei autorizativa de Crédito Suplementar' when o200_tipoleialteracao = 2 then 'Lei autorizativa de Crédito Especial'
    	when o200_tipoleialteracao = 3 then 'Lei autorizativa de Remanejamento /transposição / transferência' when o200_tipoleialteracao = 4 then 'Lei autorizativa de alteração da fonte de recurso'
    	when o200_tipoleialteracao = 5 then 'Lei autorizativa de suplementação de Crédito Especial' end as o200_tipoleialteracao,
    	o200_artleialteracao,o200_descrartigo,o200_vlautorizado";
    	$campos = "o200_sequencial,o200_orcprojetolei,o200_tipoleialteracao,o200_artleialteracao,o200_vlautorizado";
    }
    $sql = $clorcleialtorcamentaria->sql_query_file(null,$campossql,null,"o200_orcprojetolei=$o200_orcprojetolei");
	 $chavepri= array("o200_sequencial"=>@$o200_sequencial);
	 $cliframe_alterar_excluir->chavepri=$chavepri;
	 $cliframe_alterar_excluir->sql     = $sql;
	 $cliframe_alterar_excluir->campos  =$campos;
	 $cliframe_alterar_excluir->legenda="";
	 $cliframe_alterar_excluir->iframe_height ="160";
	 $cliframe_alterar_excluir->iframe_width ="700";
	 $cliframe_alterar_excluir->iframe_alterar_excluir(1);
	 $numrows = pg_num_rows(db_query($sql));
    ?>
    </td>
   </tr>
 </table>
  </fieldset>
  </center>
</form>
<script>
function js_pesquisao200_orcprojetolei(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcprojetolei','func_orcprojetolei.php?funcao_js=parent.js_mostraorcprojetolei1|o138_sequencial|o138_numerolei','Pesquisa',true);
  }else{
     if(document.form1.o200_orcprojetolei.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcprojetolei','func_orcprojetolei.php?pesquisa_chave='+document.form1.o200_orcprojetolei.value+'&funcao_js=parent.js_mostraorcprojetolei','Pesquisa',false);
     }else{
       document.form1.o138_numerolei.value = '';
     }
  }
}
function js_mostraorcprojetolei(chave,erro){
  document.form1.o138_numerolei.value = chave;
  if(erro==true){
    document.form1.o200_orcprojetolei.focus();
    document.form1.o200_orcprojetolei.value = '';
  }
}
function js_mostraorcprojetolei1(chave1,chave2){
  document.form1.o200_orcprojetolei.value = chave1;
  document.form1.o138_numerolei.value = chave2;
  db_iframe_orcprojetolei.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcleialtorcamentaria','func_orcleialtorcamentaria.php?funcao_js=parent.js_preenchepesquisa|o200_sequencial','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_orcleialtorcamentaria.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
