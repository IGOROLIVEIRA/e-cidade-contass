<?php

require_once("dbforms/db_funcoes.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
$oGet = db_utils::postMemory($_GET);
$oDaoPrecoReferencia = db_utils::getDao("precoreferencia");
$sSqlProcessoCompras = $oDaoPrecoReferencia->sql_query_file(
  "",
  "si01_sequencial,si01_datacotacao,CASE
  WHEN si01_tipoprecoreferencia = 1 then 'Preço Médio'
  WHEN si01_tipoprecoreferencia = 2 then 'Maior Preço'
  ELSE 'Menor Preço'
  END as si01_tipoprecoreferencia,CASE
  WHEN si01_cotacaoitem = 1 then 'No mínimo uma cotação'
  WHEN si01_cotacaoitem = 2 then 'No mínimo duas cotação'
  WHEN si01_cotacaoitem = 2 then 'No mínimo três cotação'
  ELSE '-'
  END as si01_cotacaoitem",
  "",
  "si01_processocompra = {$oGet->iProcesso}"
);

?>
<html>
  <head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
  </head>
  <body bgcolor="#cccccc" onload="">
    <center>
      <form name="form1" method="post">
        <div style="display: table;">
          <fieldset>
            <legend><b>Preço de Referência</b></legend>
          <?
           db_lovrot($sSqlProcessoCompras, 15);
          ?>
          </fieldset>
        </div>
      </form>
    </center>
  </body>
</html>