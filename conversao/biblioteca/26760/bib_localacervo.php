<?
//PARAMETROS PARA CONECTAR AO BANCO
$host="localhost";
$base="auto_capivari_20090619_v110";
$porta="5434";
$usuario="postgres";
$senha ="";
$dbcon = pg_connect("host=$host port=$porta dbname=$base user=$usuario password=$senha");
if(!$dbcon){
 echo "Erro Conexão!";
 exit;
}

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
echo "\n Processo Iniciado...";
pg_query("begin");
$erro = false;
$sql0 = "SELECT count(*) FROM localacervo";
$result0 = pg_query($sql0);
$linhas0 = pg_result($result0,0,0);
$sql = "SELECT bi09_codigo,bi09_nome FROM localizacao ORDER BY bi09_codigo";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
$cont = 0;
for($x=0;$x<$linhas;$x++){
 $cod_localizacao = pg_result($result,$x,'bi09_codigo');
 $nome_localizacao = pg_result($result,$x,'bi09_nome');
 $sql1 = "SELECT *
          FROM localacervo
           inner join acervo on bi06_seq = bi20_acervo
          WHERE bi20_localizacao = $cod_localizacao
          ORDER BY bi20_sequencia";
 $result1 = pg_query($sql1);
 $linhas1 = pg_num_rows($result1);
 for($y=0;$y<$linhas1;$y++){
  $cod_localacervo = pg_result($result1,$y,'bi20_codigo');
  $_sequencia = pg_result($result1,$y,'bi20_sequencia');
  $acervo = pg_result($result1,$y,'bi06_seq');
  $nomeacervo = pg_result($result1,$y,'bi06_titulo');
  $_seqcerta = $y+1;
  $sql2 = "UPDATE localacervo SET
            bi20_sequencia = $_seqcerta
           WHERE bi20_codigo = $cod_localacervo";
  $result2 = pg_query($sql2);
  if($result2==false){
   $erro = true;
   break;
  }else{
   system("clear");
   echo Progresso($cont,$linhas0,$acervo,$nomeacervo," PROGRESSÃO: TABELA LOCALACERVO");
  }
  $cont++;
 }
 if($erro==true){
  break;
 }
}
if($erro==true){
 pg_exec("rollback");
 exit;
}else{
 echo " \n->Terminado processo...\n\n";
 pg_exec("commit");
}
?>