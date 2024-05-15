<?
set_time_limit(0);

/************************************************/
$dbname   = "ontem_20060329_0201";
$dbhost   = "localhost";
$dbarq    = "./inscrzona.csv";
$dblogsql = "/tmp/logconverisszona.sql";
/***********************************************/

$conn = pg_connect("dbname=$dbname user=postgres host=$dbhost") or die('ERRO AO CONECTAR NA BASE DE DADOS !!');
system("echo 'Aguarde conectando na base de dados...'");
system("echo 'BEGIN;' > $dblogsql");
$arquivo = fopen ("$dbarq", "r");
pg_query("BEGIN;");
$i = 0;
while (!feof($arquivo)){
    $linha = fgets($arquivo,4096);
    if($linha==""){
        continue;
    }
    $colunas = split (';', $linha);

    $zona  = $colunas[0];
    $inscr = $colunas[1];

    $select    = "select * from isszona where q35_inscr = $inscr";
//    die($select);
    $rsIsszona = pg_query($select);
//    db_fieldsmemory($rsIsszona,0);
    $numrows = pg_num_rows($rsIsszona);
    if($numrows == 0){      
        $sql   = "INSERT INTO isszona VALUES ($inscr,$zona)";
    }else{
        $sql   = "UPDATE isszona SET q35_zona = $zona WHERE q35_inscr = $inscr";
    }     
    
    $i++;
    echo "$sql -- $i \n" ;
    system("echo '".$sql."'>> $dblogsql");
    pg_query($sql) or die ("erro executando $sql");
 /*   if ($i == 10){      
      exit;
    }*/
}

fclose($arquivo);
//pg_query("ROLLBACK;");
pg_query("COMMIT;");
?>
