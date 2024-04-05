<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once ("libs/exceptions/BusinessException.php");
require_once ("libs/exceptions/DBException.php");
require_once ("libs/exceptions/ParameterException.php");

$oGet              = db_utils::postMemory($_GET, false);


$sSqlManutencao = "SELECT
                   SUBSTRING(t98_descricao, 1, 500) AS t98_descricao,
                   t98_vlrmanut,
                   z01_nome,
                   t98_data,
                   t100_descr
                   FROM bemmanutencao
                   JOIN db_usuarios ON id_usuario = t98_idusuario
                   JOIN cgmcorreto ON z10_login = id_usuario
                   JOIN cgm ON z01_numcgm = z10_numcgm
                   JOIN bens ON t52_bem = t98_bem
                   JOIN tipomanubem ON t100_codigo = t98_tipo
                   WHERE t52_bem = $oGet->t52_bem
                   AND t98_manutencaoprocessada = 't'";


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
  <body>
    <center>
      <fieldset>
        <legend><strong>Historico de Manutenção</strong></legend>
        <?php 
          db_lovrot($sSqlManutencao  , 15, "", "");
        ?>
      </fieldset>
    </center>
  </body>
</html>