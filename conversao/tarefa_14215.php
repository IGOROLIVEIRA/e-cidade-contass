<?

set_time_limit(0);

//include(__DIR__ . "/../libs/db_conn.php");

$DB_BASE ="auto_ita_20080307";

$DB_SERVIDOR="192.168.0.2";

$DB_PORTA ="5432";

$conn = pg_connect("dbname=$DB_BASE user=postgres host=$DB_SERVIDOR port=$DB_PORTA") or die('ERRO AO CONECTAR NA BASE DE DADOS !!');

echo "Conectado a base $DB_BASE\n";
echo "backup tabela";

pg_query($conn, "begin");
pg_exec("create table lotedist_back_work as select * from lotedist");
pg_query($conn, "commit");

echo "alterando tabela lotedist" ;
pg_exec("alter table lotedist add j54_orientacao integer");

// Inicia Transacao
pg_query($conn, "begin");

$sql_lotedist   = "select * from lotedist";
$res_lotedist     = @pg_query($conn,$sql_lotedist);
$numrows_lotedist = pg_numrows($res_lotedist);

if ($numrows_lotedist > 0){

   for($x = 0; $x < $numrows_lotedist; $x++){
     $j54_idbql     = pg_result($res_lotedist,$x,"j54_idbql");
     $j54_ponto     = trim(pg_result($res_lotedist,$x,"j54_ponto"));
     
   
 
       if ($j54_ponto == "norte" ){
          pg_exec("update lotedist set j54_orientacao=1 where j54_idbql=$j54_idbql");
          echo "aqui-1-norte \n";
       }

       if ($j54_ponto == "sul"){
          pg_exec("update lotedist set j54_orientacao=2 where j54_idbql=$j54_idbql");
          echo "aqui-2-sul \n";
       }

       if ($j54_ponto == "leste"){
          pg_exec("update lotedist set j54_orientacao=3 where j54_idbql=$j54_idbql");
           echo "aqui-3-leste \n";
       }

       if ($j54_ponto == "oeste"){
           pg_exec("update lotedist set j54_orientacao=4 where j54_idbql=$j54_idbql");
            echo "aqui-4-oeste \n";
       }

   }

}
pg_exec("alter table lotedist drop j54_ponto");
pg_query($conn, "commit");

?>
