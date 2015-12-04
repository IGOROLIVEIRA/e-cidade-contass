<?
require("db_conn.php");
if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))) {
  $pdf->Cell(200,4,"Erro ao conectar","LRBT",1,"C",0);
  exit;
}
?>
