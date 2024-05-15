<?
$db_fonte_codversao = '1';

/* PEGA A ULTIMA RELEASE */
$sqlCodRelease = " select db30_codrelease as ultimarelease from db_versao order by db30_codver desc limit 1";
$rsCodRelease  = pg_query($sqlCodRelease);
$codRelease    = pg_result($rsCodRelease,0,"ultimarelease");

$db_fonte_codrelease= "$codRelease";
?>
