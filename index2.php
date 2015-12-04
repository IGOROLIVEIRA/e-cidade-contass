<html>
<head>
<title>DBPoprtal2</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/javascript" src="scripts/md5.js"></script>
<script>
function js_submeter() {
  document.form1.DB_senha.value = calcMD5(document.form1.senha.value);
  document.form1.DB_login.value = document.form1.login.value;
  document.form1.senha.disabled = true;
  document.form1.login.disabled = true;
  return true;
  //wname = 'wname' + Math.floor(Math.random() * 10000);
  //jan1 = window.open('abrir.php?estenaoserveparanada=1&DB_login=' + document.form1.DB_login.value + '&DB_senha=' + document.form1.DB_senha.value,wname,'width=1,height=1');
//  jan1.blur();  
 // document.form1.login.focus();
// window.close();
}
</script>
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="if(document.form1) document.form1.login.focus();">
<form name="form1" method="get"  onsubmit="return js_submeter()" action="abrir.php">
  <table style="font-family: Arial, Helvetica, sans-serif;font-size:13px" width="200" border="0" cellspacing="0" cellpadding="5">
    <tr> 
      <td width="49"><strong>Login:</strong></td>
      <td width="151"><input name="login" type="text" id="login" maxlength="20"></td>
    </tr>
    <tr> 
      <td><strong>Senha:</strong></td>
      <td><input name="senha" type="password" id="senha" maxlength="20"></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td><input type="submit" name="enviar"  value="Enviar"></td>
    </tr>
  </table>
   <input type="hidden" name="DB_senha">
<input type="hidden" name="DB_login">
</form>
</body>
</html>
