<center>
<form name="form1" method="post" onSubmit="return js_submeter()">
    <table width="59%" border="0" cellspacing="0" cellpadding="0">
      <tr> 
        <td width="25%" height="25"><strong>C&oacute;digo:</strong></td>
        <td width="75%" height="25"><input name="k11_id" type="text" id="k11_id" value="<?=@$k11_id?>" size="10" readonly></td>
      </tr>
      <tr> 
        <td height="25"><strong>Identifica&ccedil;&atilde;o 1:</strong></td>
        <td height="25"><input name="k11_ident1" type="text" id="k11_ident1" value="<?=@$k11_ident1?>" size="2" maxlength="1"></td>
      </tr>
      <tr> 
        <td height="25"><strong>Identifica&ccedil;&atilde;o 2:</strong></td>
        <td height="25"><input name="k11_ident2" type="text" id="k11_ident2" value="<?=@$k11_ident2?>" size="2" maxlength="1"></td>
      </tr>
      <tr> 
        <td height="25"><strong>Identifica&ccedil;&atilde;o 3:</strong></td>
        <td height="25"><input name="k11_ident3" type="text" id="k11_ident3" value="<?=@$k11_ident3?>" size="2" maxlength="1"></td>
      </tr>
      <tr> 
        <td height="25"><strong>IP Terminal Caixa:</strong></td>
        <td height="25"><input name="k11_ipterm" type="text" id="k11_ipterm" value="<?=@$k11_ipterm?>" size="20" maxlength="20"></td>
      </tr>
      <tr> 
        <td height="25"><strong>Local:</strong></td>
        <td height="25"><input name="k11_local" type="text" id="k11_local" value="<?=@$k11_local?>" size="30" maxlength="30"></td>
      </tr>
      <tr> 
        <td height="25"><strong>Sequencia 1:</strong></td>
        <td height="25"><input name="k11_aut1" type="text" id="k11_aut1" value="<?=@$k11_aut1?>" size="20" maxlength="20"></td>
      </tr>
      <tr>
        <td height="25"><strong>Sequencia 2:</strong></td>
        <td height="25"><input name="k11_aut2" type="text" id="k11_aut2" value="<?=@$k11_aut2?>" size="20" maxlength="20"></td>
      </tr>
      <tr> 
        <td height="25">&nbsp;</td>
        <td height="25"><input name="enviar" type="submit" id="enviar" value="Enviar"></td>
      </tr>
    </table>
</form>
</center>
<script>
function js_submeter() {
  var str = new String(document.form1.k11_ipterm.value);
  var expr1 = /\./g;
  var expr2 = /\d{1,3}\.\d{1,3}\.\d{1,3}\.[0-9]{1,3}/;  
  if(str.match(expr1) != ".,.,." || str.match(expr2) == null) {
    alert("Endereço IP inválido!\n Formato xxx.xxx.xxx.xxx");
	document.form1.k11_ipterm.select();
	return false;
  } 
 
  return true;
}
js_Ipassacampo();
if(document.form1)
  document.form1.elements[1].focus();
</script>