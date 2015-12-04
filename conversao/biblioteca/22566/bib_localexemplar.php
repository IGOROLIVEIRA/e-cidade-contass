<?
//PARAMETROS PARA CONECTAR AO BANCO
$host="127.0.0.1";
$base="sapiranga2";
$porta="5432";
$usuario="postgres";
$senha ="";
$dbcon = pg_connect("host=$host port=$porta dbname=$base user=$usuario password=$senha");
if(!$dbcon){
 echo "Erro Conexão!";
 exit;
}

function Progresso($linha,$total,$sequencia,$letra,$titulo){
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
 system("clear");
 echo " PROGRESSÃO:";
 echo " $linha de $total registros.\n\n";
 echo " [".$tracos.$brancos."] ".number_format($percent,2,".",".")."%\n\n";
 echo " --> $linha  <-- $sequencia".($letra!=""?" - $letra":"")." -> $titulo";

}
system("clear");
echo "\n Processo Iniciado...";

pg_query("begin");
$alfabeto = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
$sql = "SELECT bi20_codigo,bi20_acervo,bi20_sequencia,bi06_titulo
        FROM localacervo
         inner join acervo on bi06_seq = bi20_acervo
        ORDER BY bi20_localizacao,bi20_sequencia
       ";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
for($x=0;$x<$linhas;$x++){
 $cod_localacervo = pg_result($result,$x,'bi20_codigo');
 $cod_acervo      = pg_result($result,$x,'bi20_acervo');
 $sequencia       = pg_result($result,$x,'bi20_sequencia');
 $titulo          = pg_result($result,$x,'bi06_titulo');
 $sql1 = "SELECT bi23_codigo
          FROM exemplar
          WHERE bi23_acervo = $cod_acervo
          AND bi23_situacao = 'S'
          ORDER BY bi23_codigo";
 $result1 = pg_query($sql1);
 $linhas1 = pg_num_rows($result1);
 for($y=0;$y<$linhas1;$y++){
  $cod_exemplar = pg_result($result1,$y,'bi23_codigo');
  $letra = $linhas1==1?"":$alfabeto[$y];
  $sql2 = "INSERT INTO localexemplar
           VALUES(nextval('localexemplar_bi27_codigo_seq'),$cod_localacervo,$cod_exemplar,'$letra')";
  $result2 = pg_query($sql2);
  echo Progresso($x,$linhas,$sequencia,$letra,$titulo);
 }
}
pg_query("commit");

echo "\n\n Operacao Concluida\n\n";
?>