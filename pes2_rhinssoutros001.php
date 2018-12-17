<?php

require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");

?>

<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/widgets/dbmessageBoard.widget.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<style>
  div .formatdiv{
    margin-top: 5px;
    margin-bottom: 10px;
    padding-left: 5px;
  }
  .container {
    width: 225;
  }
</style>
</head>
<body bgcolor="#cccccc" style="margin-top: 25px;">
  <form name="form1" method="post" action="">
    <div class="center container">
      <fieldset>
        <legend>Desconto Externo de Previdência</legend>
        <div class="formatdiv" align="left">
          <strong>Competência:&nbsp;</strong>
          <input style="width: 80px" type="text" name="competencia" placeholder="mm/aaaa" maxlength="7" onkeypress="mascaraCompetencia(this, event)">
        </div> 
      </fieldset>
      <div class="formatdiv" align="center"> 
        <input type="button" value="Emitir" onClick="js_emite()">
      </div>
    </div>
  </form>
  <? db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit")); ?>
</body>
<script>
  function mascaraCompetencia(campo, e) {
    var kC   = (document.all) ? event.keyCode : e.keyCode;
    var data = campo.value;
    
    if(kC != 8 && kC != 46) {
      if(data.length == 2) {
        campo.value = data += '/';
      }
    }
  }

  function js_emite() {
    var comp = document.form1.competencia.value;
    var mes  = parseInt(comp.split("/")[0]);
    var ano  = parseInt(comp.split("/")[1]);

    if (isNaN(mes) || isNaN(ano)) {
      alert("Competência Inválida!");
      return false;
    } else if((mes == 0 || ano == 0) || mes > 12) {
        alert("Competência Inválida!");
        return false;
    }
    
    var query = "";
    query += ("mes="+mes+"&ano="+ano);

    jan = window.open(
      "pes2_rhinssoutros002.php?" + query,
      "",
      'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0'
    );
    jan.moveTo(0,0);
  }
</script>
</html>