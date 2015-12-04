<?
ini_set("upload_max_filesize","10485760");
ini_set("post_max_size","10485760");
ini_set("memory_limit","10485760");
set_time_limit(0);
?>
<html>
<head>
<title>Documento sem t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script>
function js_copia() {
   if(document.form1.arquivo.value == '' ){
      alert('Você deverá selecionar um arquivo a ser enviado.');
       return false;
   }else if(document.form1.email.value == '' ){
      alert('Você deverá informar um email válido.');
      return false;
   }else{
     document.getElementById('tabela').style.visibility = 'visible';
     return true;
   }
   return false;
}

</script>

</head>
<body bgcolor=#CCCCCC bgcolor="#726623" leftmargin="10" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" height="450" cellspacing="0" >
  <tr> 
    <td height="20%"><div align="center"> <strong><font color="#FFFFFF" size="+2" face="Arial, Helvetica, sans-serif"><em>Essencial</em></font></strong> 
      </div></td>
  </tr>
  <tr valign="bottom" bgcolor="#999933"> 
    <td height="5%" bgcolor="#958D2B"><hr></td>
  </tr>
  <form name="form1" method="post" enctype="multipart/form-data" action="processando.php">
    <tr> 
      <td valign="middle" bgcolor="#958D2B"><div align="justify"> <strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Ap&oacute;s 
          o envio dos arquivos para nosso servidor, o sistema ir&aacute; processar 
          os dados dos mesmos e liberar&aacute; o acesso aos relatorios. </font><font size="2" face="Arial, Helvetica, sans-serif"><br>
          <strong><br>
          </strong></font></div></td>
    </tr>
    <tr valign="top" bgcolor="#958D2B"> 
      <td height="257"> <div align="center"> <hr> <table width="100%">
          <tr> 
            <td colspan="2" align="center"><font face="Arial, Helvetica, sans-serif"><br>
              Informe abaixo a localiza&ccedil;&atilde;o dos arquivo <br>
              <br>
              </font></td>
          </tr>
          <tr> 
            <td width="22%" align="right">Guiab.txt</td>
            <td width="78%"><input name="arquivo2" type="file" id="arquivo5" size="60" accept="image/jpeg"></td>
          </tr>
          <tr> 
            <td align="right">Cadastro.txt</td>
            <td><input name="arquivo" type="file" id="arquivo4" size="60" accept="image/jpeg"></td>
          </tr>
          <tr> 
            <td colspan="2" align="center">&nbsp;</td>
          </tr>
          <tr> 
            <td align="right">E-mail: </td>
            <td><input name="email" type="text" id="email3" size="40"></td>
          </tr>
          <tr> 
            <td colspan="2" align="center"><br>
              <input name="enviar" type="submit" id="enviar3" value="Enviar Arquivos"  onClick="return js_copia()"></td>
          </tr>
        </table>
        <hr></td>
    </tr>
  </form>
  <tr> 
    <td height="10%"><div align="center"> 
        <table id="tabela" style="visibility:hidden" width="100%">
          <tr> 
            <td height="21" bgcolor="#FF0000"><div align="center"><strong><em><font color="#FFFFFF">Copiando 
                Arquivo para o servidor. Aguarde ... </font></em></strong></div></td>
          </tr>
        </table>
      </div></td>
  </tr>
</table>
</body>
</html>
