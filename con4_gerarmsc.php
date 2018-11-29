<?php
//echo "<pre>"; ini_set("display_errors",true);
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");

$aMeses = array(
  "01" => "Janeiro", "02" => "Fevereiro", "03" => "Março", "04" => "Abril", "05" => "Maio", "06" => "Junho", "07" => "Julho", "08" => "Agosto", "09" => "Setembro", "10" => "Outubro", "11" => "Novembro", "12" => "Dezembro"
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
<script language="JavaScript" type="text/javascript" src="scripts/widgets/dbmessageBoard.widget.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<style>
  div .formatdiv{
    margin-top: 5px;
    margin-bottom: 10px;
    padding-left: 5px;
  }
  .container {
    width: 400px;
  }
  .formatselect {
    width: 200px;
    height: 18px;
  }
</style>
</head>
<body bgcolor="#cccccc" style="margin-top: 25px;">
  <form name="form1" method="post" action="">
    <div class="center container">
      <fieldset>
        <legend>Matriz de Saldos Contábeis</legend>
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
          <strong style="margin-right:55px">Matriz:&nbsp;</strong>
          <select name="matriz" class="formatselect">
            <option value="">Selecione...</option>
            <option value="a">Agregada</option>
            <option value="b">Desagregada</option>
          </select> 
        </div> 
        <div class="formatdiv" align="left"> 
          <strong style="margin-right:31px">Formato:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>
          <select name="formato" class="formatselect">
            <option value="">Selecione...</option>
            <option value="xbrl">XBRL</option>
            <option value="csv">CSV</option>
          </select> 
        </div>    
      </fieldset>
      <div class="formatdiv" align="center"> 
        <input type="button" value="Processar" onclick="gerarMsc()">
      </div>
      <div id="arquivo" style="display: none" class="formatdiv" align="center"> 
      </div> 
    </div>
  </form>
  <script>
    function novoAjax(params, onComplete) {

      var request = new Ajax.Request('con4_msc.RPC.php', {
        method:'post',
        parameters:'json='+Object.toJSON(params),
        onComplete: onComplete
      });

    }
    function gerarMsc() {

      var iMes     = document.form1.mes.value;
      var sMatriz  = document.form1.matriz.value;
      var sFormato = document.form1.formato.value;

      js_divCarregando('Aguarde', 'div_aguarde');
      var params = {
        exec: 'gerarMsc',
        mes: iMes,
        matriz: sMatriz,
        formato: sFormato
      };
      
      novoAjax(params, function(e) {
        var oRetorno = JSON.parse(e.responseText);
          if (oRetorno.status == 1) {
            js_removeObj('div_aguarde');
            alert("Processo concluído com sucesso!");
            var sArquivo = document.getElementById('arquivo');
            var sLink = " <strong>Arquivo Gerado:&nbsp;</strong>"; 
            sLink += "<a href='db_download.php?arquivo="+oRetorno.caminho+"'>"+oRetorno.nome+"</a>";
            sArquivo.innerHTML = sLink;
            sArquivo.style.display = "inline-block";
          } else {
              js_removeObj('div_aguarde');
              alert(oRetorno.message);
          }
        });

    }
  </script>
  <? db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit")); ?>
</body>
</html>