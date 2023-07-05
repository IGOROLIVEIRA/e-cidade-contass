<?php
//MODULO: contabilidade
include("dbforms/db_classesgenericas.php");
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clconvdetalhaconcedentes->rotulo->label();
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
     $c207_nrodocumento = "";
     $c207_esferaconcedente = "";
     $c207_valorconcedido = "";
     $c207_sequencial = "";
   }
}
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tc207_sequencial?>">
       <?=@$Lc207_sequencial?>
    </td>
    <td>
      <?php db_input('c207_sequencial',14,$Ic207_sequencial,true,'text',3,"") ?>
    </td>
  </tr>

  <tr>
    <td nowrap title="<?=@$Tc207_nrodocumento?>">
      <?php db_ancora($Lc207_nrodocumento,"js_pesquisaz01_numcgm(true);",1);?>
    </td>
    <td>
      <?php db_input('c207_nrodocumento',14,$Ic207_nrodocumento,true,'text',3,"") ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc207_esferaconcedente?>">
       <?=@$Lc207_esferaconcedente?>
    </td>
    <td>
      <?php
        $x = array("1"=>"Federal","2"=>"Estadual","3"=>"Municipal","4"=>"Exterior","5"=>"Instituição Privada");
        if(db_getsession('DB_anousu') > 2021)
          $x = array("1"=>"Federal","2"=>"Estadual","3"=>"Municipal","5"=>"Instituição Privada");
        db_select('c207_esferaconcedente',$x,true,$db_opcao,'onchange="setDescrConcedente(this.value)"');
      ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc207_valorconcedido?>">
       <?=@$Lc207_valorconcedido?>
    </td>
    <td>
      <?php db_input('c207_valorconcedido',14,$Ic207_valorconcedido,true,'text',$db_opcao,"")
      ?>
    </td>
  </tr>
  <tr id="descrconcedente">
    <td nowrap title="<?=@$Tc207_descrconcedente?>">
       <?=@$Lc207_descrconcedente?>
    </td>
    <td>
      <?php db_input('c207_descrconcedente',44,$Ic207_descrconcedente,true,'text',$db_opcao,"")
      ?>
    </td>
  </tr>

    <?php db_input('c207_codconvenio',12,$Ic207_codconvenio,true,'hidden',$db_opcao,"") ?>

  </tr>
    <td colspan="2" align="center">
 <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?>  >
 <input name="novo" type="button" id="cancelar" value="Novo" onclick="js_cancelar();" <?=($db_opcao==1||isset($db_opcaoal)?"style='visibility:hidden;'":"")?> >
    </td>
  </tr>
  </table>
 <table>
  <tr>
    <td valign="top" align="center">
    <?php
  	 $chavepri= array("c207_sequencial"=>@$c207_sequencial);
  	 $cliframe_alterar_excluir->chavepri=$chavepri;
  	 $cliframe_alterar_excluir->sql     = $clconvdetalhaconcedentes->sql_query_file(null,"*",null,"c207_codconvenio = $c207_codconvenio");
  	 $cliframe_alterar_excluir->campos  ="c207_sequencial,c207_nrodocumento,c207_esferaconcedente,c207_valorconcedido,c207_codconvenio";
  	 $cliframe_alterar_excluir->legenda="ITENS LANÇADOS";
  	 $cliframe_alterar_excluir->iframe_height ="160";
  	 $cliframe_alterar_excluir->iframe_width ="700";
  	 $cliframe_alterar_excluir->iframe_alterar_excluir($db_opcao);
    ?>
    </td>
   </tr>
 </table>
  </center>
</form>
<script>
function js_cancelar(){
  var opcao = document.createElement("input");
  opcao.setAttribute("type","hidden");
  opcao.setAttribute("name","novo");
  opcao.setAttribute("value","true");
  document.form1.appendChild(opcao);
  document.form1.submit();
}

//Função que pesquisa caso seja TRUE a pesquisa foi feita atraves da ancora caso seja FALSE a pesquisa foi digitada um numero de CGM
function js_pesquisaz01_numcgm(mostra)
{
  if(mostra==true)
  {
    js_OpenJanelaIframe('','func_nome','func_nome.php?funcao_js=parent.js_mostranumcgm1|z01_cgccpf&z01_tipcre_cnpj','Pesquisa',true);
  }
}

function js_mostranumcgm1(chave1)
{
  document.form1.c207_nrodocumento.value = chave1;
  func_nome.hide();
}

function setDescrConcedente(c207_esferaconcedente)
{
  var c207_descrconcedente = document.getElementById('descrconcedente');
  if (c207_esferaconcedente == 4) {
    c207_descrconcedente.style.display = "table-row";
  } else {
      c207_descrconcedente.style.display = "none";
  }
}
</script>
