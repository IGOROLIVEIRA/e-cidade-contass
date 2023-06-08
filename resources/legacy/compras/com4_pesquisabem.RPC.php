<?php

require_once 'libs/db_stdlib.php';
require_once 'libs/db_conecta.php';
require_once 'libs/db_sessoes.php';
require_once 'libs/db_usuariosonline.php';
require_once 'libs/JSON.php';
require_once 'libs/db_utils.php';
$oJson         = new services_json();
$sName    = $_POST["string"];

$sql = "select t52_bem as cod, t52_descr as label from bens where t52_descr ilike '" . $sName . "%'";
$result   = db_query($sql);
$iNumRows = pg_num_rows($result);
$array    = db_utils::getColectionByRecord($result);
echo $oJson->encode($array);
