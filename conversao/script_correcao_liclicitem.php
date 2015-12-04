<?
//script que corrige o campo l21_ordem das licitações que estão com a item todos com 1.
//configurar de acordo com cada cliente - tarefa(18908).
$host  = "localhost";
$base  = "bage";
$porta = "5432";
//

//conexão com a base de dados
$con = pg_connect("host = $host dbname = $base user = postgres port = $porta");
   if (!$con){
        echo "Não foi possivel conectar a base de dados $base";
        exit;
   }  
//
//backup da tabela//
$sql = "create table backup_liclititem as select * from liclicitem";
pg_exec($sql);
//


//Início da transação
pg_exec("begin");
$sql = "select l21_codliclicita from liclicitem where l21_ordem = 1 group by l21_codliclicita having count(*) > 1";
echo "\n SQL-1:$sql \n ";
$result  = pg_query($sql);
$numrows = pg_numrows($result);

for ($i = 0; $i < $numrows; $i++){
     
     $l21_codliclicita  = pg_result($result,$i,0);
    
     $sql2 = "select l21_codigo,l21_codliclicita,l21_codpcprocitem from liclicitem where l21_codliclicita = $l21_codliclicita order by l21_codigo";
     echo "\n SQL-2:$sql2 \n ";
     
     $result2  = pg_query($sql2);
     $numrows2 = pg_numrows($result2);

     for ($j=0; $j < $numrows2; $j++){
          $acertaOrdem   = $j+1;
          $Codigo        = pg_result($result2,$j,0);
          $Codliclicita  = pg_result($result2,$j,1);
          $Codpcprocitem = pg_result($result2,$j,2);
          
          $sql = "update liclicitem set l21_ordem = $acertaOrdem where l21_codigo = $Codigo and l21_codliclicita = $l21_codliclicita and l21_codpcprocitem = $Codpcprocitem";
          pg_exec($sql);
          echo "\n SQL-3:$sql \n ";

    }
    echo "\n Total de registros licitação n $l21_codliclicita: $j \n ";
}
//fim da transação
pg_exec("commit");


?>
