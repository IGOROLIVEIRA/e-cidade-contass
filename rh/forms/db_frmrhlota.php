<?
//MODULO: pessoal
$clrhlota->rotulo->label();
$cllotacao->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("db77_descr");
$clrotulo->label("o40_orgao");
$clrotulo->label("o40_descr");
$clrotulo->label("o41_unidade");
$clrotulo->label("o41_descr");

/*
     $mascara    = "0.0.0.0.0.00.00.00.00.00";
//echo $r70_estrut = "6.2.3.4.1.09.00.00.00.00";
//echo $r70_estrut = "1.9.9.5.6.02.01.00.20.00"; //
echo $r70_estrut = "1.1.2.2.1.90.10.00.00.00";  //mae analitica
echo "<br>";
$cldb_estrut->db_estrut_inclusao($r70_estrut,$mascara,"conplano","c60_estrut","c60_analitica");
db_msgbox($cldb_estrut->erro_msg);
die();
*/
if($db_opcao==1){
  $ac="pes1_rhlota004.php";
}else if($db_opcao==22 || $db_opcao==2){
  $ac="pes1_rhlota005.php";
}else if($db_opcao==33 || $db_opcao==3){
  $ac="pes1_rhlota006.php";
}
?>
<form name="form1" method="post" action="<?=$ac?>">
<center>
<table cellpadding='0' cellspacing='0'>
  <tr>
  <td>
   <fieldset><legend><b>Dados da conta</b></legend>
<table border="0" cellpadding='0' cellspacing='0'>
  <tr>
    <td nowrap title="<?=@$Tr70_codigo?>">
       <?=@$Lr70_codigo?>
    </td>
    <td>
<?
db_input('r70_codigo',4,$Ir70_codigo,true,'text',3)
?>
    </td>
  </tr>
<?
   //rotina que na alteração mantém a estrutura original
     if(isset($estrutura_altera) ||   isset($chavepesquisa)&&isset($r70_estrut)){
	if(empty($estrutura_altera)){
	   $estrutura_altera=$r70_estrut;
	}
         db_input('estrutura_altera',4,$Ir70_codigo,true,'hidden',3);
     }
   //fianl

   if(isset($db_atualizar) && (empty($estrutura_altera) || (isset($estrutura_altera) && str_replace(".","",$r70_estrut) != $estrutura_altera) )){
//      $cldb_estrut->db_estrut_inclusao($r70_estrut,$mascara,"rhlota","r70_estrut","r70_analitica");
//      if($cldb_estrut->erro_status==0){
///         $err_estrutural = $cldb_estrut->erro_msg;
//      }else{
//	$focar=true;
//      }

   }
   $anofolha = db_anofolha();
   $mesfolha = db_mesfolha();
   $result = $clcfpess->sql_record($clcfpess->sql_query_file($anofolha,$mesfolha,"r11_codestrut"));
   if($clcfpess->numrows>0){
      db_fieldsmemory($result,0);
   }else{
      echo 'Não existem registros na tabela cfpess para o ano '.$anofolha.' e mês '.$mesfolha.' ...';
      exit;
   }

// $cldb_estrut->funcao_onchange  = "js_pesquisao70_codfon(false);";
   $cldb_estrut->autocompletar = true;
   $cldb_estrut->mascara = true;
   $cldb_estrut->reload  = false;
   $cldb_estrut->input   = false;
   $cldb_estrut->size    = 22;
   $cldb_estrut->nome    = "r70_estrut";
   $opcaoestrut = 1;
   if($db_opcao!=1){
     $opcaoestrut = 3;
   }
   $cldb_estrut->db_opcao= $opcaoestrut;
   $cldb_estrut->db_mascara("$r11_codestrut");
?>


  <tr>
    <td nowrap title="<?=@$Tr70_descr?>">
       <?=@$Lr70_descr?>
    </td>
    <td>
<?
db_input('r70_descr',50,$Ir70_descr,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tr70_analitica?>">
       <?=@$Lr70_analitica?>
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('r70_analitica',$x,true,$db_opcao,"onchange='js_troca();'");
?>
    </td>
  </tr>
</table>
</fieldset>
</td>
<tr>
<?
   if(isset($r70_analitica) && $r70_analitica=="t"){
?>
   <tr>
   <td>
   <fieldset><legend><b>Órgão / Unidade</b></legend>
   <center>
<table border='0' cellpadding='0' cellspacing='0'>
  <tr>
    <td nowrap title="<?=@$To40_orgao?>">
       <?
db_ancora(@$Lo40_orgao,"js_pesquisaorgunid(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
if(isset($o40_orgao) && trim($o40_orgao)!=""){
  $result_orgao = $clorcorgao->sql_record($clorcorgao->sql_query_file(db_getsession("DB_anousu"),$o40_orgao,"o40_descr"));
  if($clorcorgao->numrows>0){
    db_fieldsmemory($result_orgao,0);
  }
}
db_input('o40_orgao',8,$Io40_descr,true,'text',3,"");
db_input('o40_descr',40,$Io40_descr,true,'text',3,"");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$To41_unidade?>">
    <?
db_ancora(@$Lo41_unidade,"js_pesquisaorgunid(true);",$db_opcao);
    ?>
    </td>
    <td>
<?
if(isset($o41_unidade) && trim($o41_unidade)!=""){
  $result_unidade = $clorcunidade->sql_record($clorcunidade->sql_query_file(db_getsession("DB_anousu"),$o40_orgao,$o41_unidade,"o41_descr"));
  if($clorcunidade->numrows>0){
    db_fieldsmemory($result_unidade,0);
  }
}
db_input('o41_unidade',8,$Io41_descr,true,'text',3,"");
db_input('o41_descr',40,$Io41_descr,true,'text',3,"");
?>
    </td>
  </tr>
  </table>
   </center>
   </fieldset>
  </td>
</tr>
<?
   }
?>
  <tr>
    <td colspan="2" align='center'>
     <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
     <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
    </td>
  </tr>
  </table>
  </center>
</form>
<script>
function js_pesquisaorgunid(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_rhlota','db_iframe_orcunidade','func_orcunidade.php?funcao_js=CurrentWindow.corpo.iframe_rhlota.js_mostraorgunid1|o40_orgao|o41_unidade','Pesquisa',true,'0','1','790','405');
  }else{
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_rhlota','db_iframe_orcunidade','func_orcunidade.php?funcao_js=CurrentWindow.corpo.iframe_rhlota.js_mostraorgunid1|o40_orgao|o41_unidade','Pesquisa',false,'0','1','790','405');
  }
}
function js_mostraorgunid1(chave1,chave2){
  document.form1.o40_orgao.value = chave1;
  document.form1.o41_unidade.value = chave2;
  db_iframe_orcunidade.hide();
  document.form1.submit();
}
function js_troca(){
  document.form1.submit();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo.iframe_rhlota','db_iframe_rhlota','func_rhlota.php?funcao_js=parent.js_preenchepesquisa|r70_codigo','Pesquisa',true,0,0,780,390);
}
function js_preenchepesquisa(chave){
  db_iframe_rhlota.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
<?
if(isset($r70_estrut) && trim($r70_estrut)!=""){
  echo "\njs_mascara03_r70_estrut(document.form1.r70_estrut.value);\n";
}
?>
</script>
<?
if(isset($focar)){
      echo "<script>
	       document.form1.r70_descr.focus();
	    </script>";
}
if(isset($err_estrutural)){
  db_msgbox($err_estrutural);
      echo "<script> document.form1.r70_estrut.style.backgroundColor='#99A9AE';</script>";
}

?>
