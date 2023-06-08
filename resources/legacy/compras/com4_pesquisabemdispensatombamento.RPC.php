<?php

require_once 'libs/db_stdlib.php';
require_once 'libs/db_conecta.php';
require_once 'libs/db_sessoes.php';
require_once 'libs/db_usuariosonline.php';
require_once 'libs/JSON.php';
require_once 'libs/db_utils.php';
$oJson         = new services_json();
$sName    = $_POST["string"];

$sql = "select e139_sequencial as cod, pc01_descrmater as label from bensdispensatombamento
inner join matestoqueitem on m71_codlanc = e139_matestoqueitem
inner join matestoque on m70_codigo = m71_codmatestoque
inner join matmater on m70_codmatmater = m60_codmater
inner join transmater on m63_codmatmater = m60_codmater
inner join pcmater on pc01_codmater = m63_codpcmater where pc01_descrmater ilike '" . $sName . "%'";
$result   = db_query($sql);
$iNumRows = pg_num_rows($result);
$array    = db_utils::getColectionByRecord($result);
echo $oJson->encode($array);
