<?php

require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");

$aMeses = array(
  "01" => "Janeiro", "02" => "Fevereiro", "03" => "Março", "04" => "Abril", "05" => "Maio", "06" => "Junho", "07" => "Julho", "08" => "Agosto", "09" => "Setembro", "10" => "Outubro", "11" => "Novembro", "12" => "Dezembro", "13" => "Encerramento"
);

?>

<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/micoxUpload.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/widgets/dbmessageBoard.widget.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<style>
  div .formatdiv{
    margin-top: 5px;
    margin-bottom: 10px;
    padding-left: 5px;
  }
  .container {
    width: auto;
  }
  .formatselect {
    width: 200px;
    height: 18px;
  }
  .fieldS1 {
    position:relative;
    float: left;
  }
  .fieldS2 {
    position: relative;
    float: left;
    height: 115px;
  }
  #file {
    width: 200px !important;
  }
</style>
</head>
<body bgcolor="#cccccc" style="margin-top: 25px;">
  <form id='form1' name="form1" method="post" action="" enctype="multipart/form-data">
    <div class="center container">
      <fieldset class="fieldS1"> <legend>Balancete MSC</legend>
        <div class="formatdiv" align="left">
          <strong>Mês Referência:&nbsp;</strong>
          <select name="mes" class="formatselect">
            <option value="">Selecione...</option>
              <?php foreach ($aMeses as $key => $value) : ?>
                <option value="<?= $key ?>" >
                  <?= $value ?>
                </option>
              <?php endforeach; ?>
          </select>
        </div>

        <div class="formatdiv" align="left">
          <strong style="margin-right:55px">Tipo:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>
          <select name="matriz" class="formatselect">
            <option value="">Selecione...</option>
            <option value="a">Agregada</option>
            <option value="d">Desagregada</option>
          </select>
        </div>

        <div class="formatdiv" align="left">
          <strong style="margin-right:31px">Formato:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>
          <select name="formato" class="formatselect">
            <option value="">Selecione...</option>
            <option value="pdf">PDF</option>
            <option value="csv">CSV</option>
          </select>
        </div>
        <div id="MSC" class="recebe">&nbsp;</div>
      </fieldset>
      <div class="formatdiv" align="center">
        <input type="button" value="Imprimir" onclick="js_emite()">
      </div>
    </div>
  </form>
  <script>

  function js_emite(){
    var mes     = document.form1.mes.value;
    var matriz  = document.form1.matriz.value;
    var formato = document.form1.formato.value;
    var arquivo = "";

    if (!mes || !matriz || !formato) {
      alert("Todos os campos são obrigatórios");
      return false;
    }

    if (formato == 'pdf') {
      arquivo = 'con2_balancetemsc002.php';
    } else {
      arquivo = 'con2_balancetemsc002_csv.php';
    }

    var query = "";
    query += ("mes="+mes+"&matriz="+matriz);

    jan = window.open(
      arquivo+"?" + query,
      "",
      'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0'
    );
    jan.moveTo(0,0);
  }
  </script>
  <? db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit")); ?>
</body>
</html>
