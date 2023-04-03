<?
set_time_limit(0);

include(__DIR__ . "/../../../../libs/db_conn.php");
if(!($conn = pg_connect("host='$DB_SERVIDOR' dbname='$DB_BASE' user='$DB_USUARIO' password='$DB_SENHA' port='$DB_PORTA'"))) {
 echo "Erro ao conectar...\n\n";
 exit;
}else{
 echo "conectado...\n\n";
}
pg_query($conn, "SELECT fc_startsession()");

function Progresso($linha,$total,$dado1,$dado2,$titulo){
 $linha++;
 $percent = ($linha/$total)*100;
 $percorrido = floor($percent);
 $restante = 100-$percorrido;
 $tracos = "";
 for($t=0;$t<$percorrido;$t++){
  $tracos .= "#";
 }
 $brancos = "";
 for($t=0;$t<$restante;$t++){
  $brancos .= ".";
 }
 echo " $titulo";
 echo " $linha de $total registros.\n";
 echo " [".$tracos.$brancos."] ".number_format($percent,2,".",".")."%\n";
 if($titulo!=" PROGRESSÃO TOTAL DA TAREFA"){
  echo " ---> ".trim($dado1)." -- ".trim($dado2)."\n";
 }
}
system("clear");

echo " ->Iniciando processo...\n\n";
sleep(1);

echo " ->Iniciando processo...";
$sql="select count(*) as count1,bi18_carteira,bi18_retirada
      from emprestimo
      group by bi18_carteira,bi18_retirada having count(*)>1
      order by count1 desc";
$result = pg_query($sql) or die($sql."  sql  ");
$linhas1= pg_num_rows($result);
$erro = false;
for($a=0;$a<$linhas1;$a++){
  $bi18_carteira = pg_result($result,$a,'bi18_carteira');
  $bi18_retirada= pg_result($result,$a,'bi18_retirada');
  $sql2=" select count(*) as count2,bi19_exemplar
              from emprestimoacervo
               inner join emprestimo on bi18_codigo = bi19_emprestimo
                where bi18_carteira=$bi18_carteira and bi18_retirada='$bi18_retirada'
                 group by bi19_exemplar";
  $result2 = pg_query($sql2) or die($sql2."  sql2   ");
  $linhas2= pg_num_rows($result2);
  for($e=0;$e<$linhas2;$e++){
    $count2=pg_result($result2,$e,'count2');
    $bi19_exemplar= pg_result($result2,$e,'bi19_exemplar');
    if($count2>1){
      $sql3="select bi18_codigo from emprestimo
                    inner join emprestimoacervo on bi18_codigo = bi19_emprestimo
                     where bi18_carteira = $bi18_carteira
                      and  bi18_retirada = '$bi18_retirada'
                       and  bi19_exemplar = $bi19_exemplar";
      $result3 = pg_query($sql3) or die($sql3."  sql3  ");
      $linhas3= pg_num_rows($result3);
      for($r=0;$r<$linhas3;$r++){
        if($r>0){
          $bi18_codigo=pg_result($result3,$r,'bi18_codigo');
          $deleta_devolucao = pg_query("delete from devolucaoacervo
                                        where bi21_emprestimoacervo
                                        in (select bi19_codigo from emprestimoacervo
                                            where bi19_emprestimo = $bi18_codigo)");
          $deleta_empracervo = pg_query("delete from emprestimoacervo
                                    where bi19_emprestimo = $bi18_codigo");
          $deleta_emprestimo=pg_query("delete from emprestimo
                                    where bi18_codigo = $bi18_codigo");
        }
      }
    }
  }
  echo Progresso($a,$linhas1,$bi18_codigo,$bi18_carteira," PROGRESSÃO:");
}
if($erro==true){
 echo "\n\n ERRO: ".pg_errormessage()."\n SQL: ".$sql2."\n\n";
 pg_exec("rollback");
 exit;
}else{
 echo "  \nProcesso Concluído\n\n";
 pg_exec("commit");
}
?>
