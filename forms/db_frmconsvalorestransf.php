<?
//MODULO: contabilidade
include("dbforms/db_classesgenericas.php");
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clconsvalorestransf->rotulo->label();
if(isset($db_opcaoal) && !isset($opcao) && !isset($excluir)){
   $db_opcao=33;
    $db_botao=false;
}else if(isset($opcao) && $opcao=="alterar"){
    $db_botao=true;
    $db_opcao = 2;
}else if(isset($opcao) && $opcao=="excluir"){
    $db_opcao = 3;
    $db_botao=true;
}else if (!isset($excluir)) {  
	if (isset($alterar) && $sqlerro==true) {  	
	  $db_opcao = 2;
	} else {
		$db_opcao = 1;
	}
   $db_botao=true;
   if(isset($novo) || (isset($alterar) && $sqlerro==false) || (isset($incluir) && $sqlerro==false ) ){
     $c201_sequencial = "";
    	//$c201_consconsorcios = "";
     $c201_mescompetencia = "";
     $c201_valortransf = "";
     $c201_enviourelatorios = "";
     $c201_codfontrecursos = "";
   }
} 
?>
<form name="form1" method="post" action="">
<center>
<fieldset style="margin-left: 80px; margin-top: 10px;">
<legend>Valores Transferidos por Contrato de Rateio</legend>
<table border="0">
  <tr>
    <td nowrap title="<?//=@$Tc201_sequencial?>">
       <?//=@$Lc201_sequencial?>
    </td>
    <td> 
<?
db_input('c201_sequencial',10,$Ic201_sequencial,true,'hidden',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc201_consconsorcios?>">
       <?=@$Lc201_consconsorcios?>
    </td>
    <td> 
<?
db_input('c201_consconsorcios',10,$Ic201_consconsorcios,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc201_mescompetencia?>">
       <?=@$Lc201_mescompetencia?>
    </td>
    <td> 
<?
$x = array("1"=>"JANEIRO","2"=>"FEVEREIRO","3"=>"MARÇO","4"=>"ABRIL","5"=>"MAIO","6"=>"JUNHO","7"=>"JULHO","8"=>"AGOSTO","9"=>"SETRMBRO","10"=>"OUTUBRO","11"=>"NOVEMBRO","12"=>"DEZEMBRO");
db_select('c201_mescompetencia',$x,true,$db_opcao,"");
//db_input('c201_mescompetencia',10,$Ic201_mescompetencia,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="Código da fonte de recursos">
       <b>Fonte de Recursos: </b>
    </td>
    <td> 
<?
db_input('c201_codfontrecursos',10,$Ic201_codfontrecursos,true,'text',$db_opcao,"","","","",3)
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc201_valortransf?>">
       <?=@$Lc201_valortransf?>
    </td>
    <td> 
<?
db_input('c201_valortransf',11,$Ic201_valortransf,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc201_enviourelatorios?>">
       <?=@$Lc201_enviourelatorios?>
    </td>
    <td> 
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('c201_enviourelatorios',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  </tr>
    <td colspan="2" align="center">
 <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?>  >
 <input name="novo" type="button" id="cancelar" value="Novo" onclick="js_cancelar();" <?=($db_opcao==1||isset($db_opcaoal)?"style='visibility:hidden;'":"")?> >
    </td>
  </tr>
  </table>
 <table>
  <tr>
    <td valign="top"  align="center">  
    <?
	 $chavepri= array("c201_sequencial"=>@$c201_sequencial);
	 $cliframe_alterar_excluir->chavepri=$chavepri;
	 $cliframe_alterar_excluir->sql     = $clconsvalorestransf->sql_query_file(null,"*",null,"c201_consconsorcios=$c201_consconsorcios and c201_anousu = ".db_getsession("DB_anousu"));
	 $cliframe_alterar_excluir->campos  ="c201_sequencial,c201_consconsorcios,c201_mescompetencia,c201_valortransf,c201_enviourelatorios";
	 $cliframe_alterar_excluir->legenda="ITENS LANÇADOS";
	 $cliframe_alterar_excluir->iframe_height ="160";
	 $cliframe_alterar_excluir->iframe_width ="700";
   $cliframe_alterar_excluir->iframe_alterar_excluir(1); 
    ?>
    </td>
   </tr>
   <tr>
   <td nowrap title="Código da fonte de recursos" align="left" colspan="2">
      <b>Total de Valores Transferidos: </b>
      <?
          $sqlTotValTransf  = $clconsvalorestransf->sql_query_file(null,"sum(c201_valortransf) as total",null,"c201_consconsorcios=$c201_consconsorcios and c201_anousu = ".db_getsession("DB_anousu"));
          $rsTotValTransf   = db_query($sqlTotValTransf);
          $totalValTransf   = db_formatar(db_utils::fieldsMemory($rsTotValTransf,0)->total, 'f');
          db_input('totalValTransf',11,'totalValTransf',true,'text',3,"");
      ?>
      </td>
   </tr>
 </table>
 </fieldset>
  </center>
</form>
<script>
function js_cancelar(){
  var opcao = document.createElement("input");
  opcao.setAttribute("type","hidden");
  opcao.setAttribute("name","novo");
  opcao.setAttribute("value","true");
  document.form1.appendChild(opcao);
  document.form1.c201_codfontrecursos.value = null;
  document.form1.submit();
}
</script>
