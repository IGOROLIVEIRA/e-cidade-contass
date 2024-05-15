<?
$clrotulo = new rotulocampo;
$clrotulo->label('DBtxt23');
$clrotulo->label('DBtxt25');
$clrotulo->label('DBtxt27');
$clrotulo->label('DBtxt28');
db_postmemory($HTTP_POST_VARS);
?>
<table align="center">
  <form name="form1" method="post" action="" onsubmit="return js_verifica();">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left" nowrap title="Digite o Ano / Mes de competência" >
    <strong>Ano / Mês :&nbsp;&nbsp;</strong>
    </td>
    <td>
      <?
       $DBtxt23 = db_anofolha();
       db_input('DBtxt23',4,$IDBtxt23,true,'text',2,'')
      ?>
      &nbsp;/&nbsp;
      <?
       $DBtxt25 = db_mesfolha();
       db_input('DBtxt25',2,$IDBtxt25,true,'text',2,'')
      ?>
    </td>
  </tr>
  <tr>
    <td><b>Ponto</b</td>
    <td>
     <?
       $x = array("s"=>"Salário","c"=>"Complementar","d"=>"13o. Salário","r"=>"Rescisão","a"=>"Adiantamento");
       db_select('ponto',$x,true,4,"");
     ?>
    </td>
  </tr>
  <tr>
    <td><b>Tipo de empenho</b</td>
    <td>
     <?
       $x = array("n"=>"Normal","p"=>"Previdência","f"=>"FGTS");
       db_select('rh40_tipo',$x,true,4,"");
     ?>
    </td>
  </tr>
  <tr>
    <td colspan="2" align = "center"> 
      <input  name="gera" id="gera" type="submit" value="Processar" onsubmit="js_verifica();">
    </td>
  </tr>
  </form>
</table>
</body>
<script>
function js_verifica(){
return true;
}
</script>  
</html>
