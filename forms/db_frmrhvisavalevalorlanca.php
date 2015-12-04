<?
//MODULO: pessoal
$clrhvisavale->rotulo->label();
$clrhvisavalecad->rotulo->label();
$clrotulo = new rotulocampo;
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
<td>
      <fieldset><legend><b>Processar valor mensal </b></legend>
<table>
  <tr>
    <td nowrap title="Ano / Mês de competência" align="right">
      <b>Ano / Mês:</b>
    </td>
    <td> 
      <?
      if(!isset($rh49_anousu)){
        $rh49_anousu = db_anofolha();
      }
      if(!isset($rh49_mesusu)){
        $rh49_mesusu = db_mesfolha();
      }
      db_input('rh49_anousu',4,$Irh49_anousu,true,'text',3,"")
      ?>
      &nbsp;/&nbsp;
      <?
      db_input('rh49_mesusu',2,$Irh49_mesusu,true,'text',3,"")
      ?>
    </td>
  </tr>
  <tr >
    <td align="left" nowrap title="Digite o Ano / Mes para levar em consideração os afastamentos" >
    <strong>Ano / Mês Afastamentos:</strong>
    </td>
    <td>
      <?
       if(!isset($anoafa)){
         $anoafa = db_anofolha();
       }
       db_input('anoafa',4, 1,true,'text',2,'');
      ?>
      &nbsp;/&nbsp;
      <?
       if(!isset($mesafa)){
         $mesafa = db_mesfolha();
       }
       db_input('mesafa',2, 1,true,'text',2,'');
      ?>
    </td>
  </tr>
</table>  
</fieldset>
</td>  
</table>
</center>
<input name="incluir" type="submit" id="db_opcao" value="Processar" <?=($db_botao==false?"disabled":"")?> onclick="return js_testacampos();">
</form>
<script>
function js_testacampos(){
  if(confirm("Todos os registros serão processados.Deseja continuar?")){
    return true;
  }else{
  return false;
  }
}
</script>
