<?
require(__DIR__ . "/../dbportal2_hoje/libs/db_conn.php");
if(!($conn = @pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))) {
  echo "Não conectou!"; 
  exit;
}
$doc =  5;
$sql =  "select c71_codlan from conlancamdoc where c71_coddoc=$doc";
$result = pg_query($sql);
$numrows =  pg_num_rows($result);
for($i=0; $i<$numrows; $i++){
  echo "\n".$i."\n\n";
   $codlan =  pg_result($result,$i,0);
   $sql  = "delete from conlancamval where c69_codlan = $codlan" ;
   echo "\n$sql\n";
   $result01 = pg_query($sql);
   if($result01==false){
     echo "Não Exclui $codlan \n\n";
   }else{
     echo "Exclui $codlan com ".pg_affected_rows($result01) ." registro tirados\n\n";
   }
  
}

?>
