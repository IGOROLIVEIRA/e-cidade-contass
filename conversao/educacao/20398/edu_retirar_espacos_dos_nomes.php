<?
//PARAMETROS PARA CONECTAR AO BANCO
$host="127.0.0.1";
$base="sapiranga";
$porta="5432";
$usuario="postgres";
$senha ="";
$dbcon = pg_connect("host=$host port=$porta dbname=$base user=$usuario password=$senha");
if(!$dbcon){
 echo "Erro Conexão!";
 exit;
}

function TiraEspaco($nome){
 $sep = "";
 $str = "";
 $parte=explode(" ",$nome);
 for($i=0;$i<count($parte);$i++){
  if(trim($parte[$i])!=""){
   $str .= $sep.trim($parte[$i]);
   $sep=" ";
  }
 }
 return $str;
}
function Progresso($linha,$total,$nomeant,$nomeatual){
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
 echo " ----> $linha  - ".trim($nomeant)." por $nomeatual";

}
system("clear");
echo "\n Processo Iniciado...";

pg_query("begin");

$sql = "SELECT ed47_i_codigo,ed47_v_nome FROM aluno ORDER BY ed47_v_nome";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
for($x=0;$x<$linhas;$x++){
 $ed47_v_nome = pg_result($result,$x,1);
 $ed47_i_codigo = pg_result($result,$x,0);
 $nome = TiraEspaco($ed47_v_nome);
 $nome = str_replace(chr(39),"",$nome);
 $sql2 = " UPDATE aluno SET
            ed47_v_nome = '$nome'
           WHERE ed47_i_codigo = $ed47_i_codigo";
 $result2 = pg_query($sql2);
 echo Progresso($x,$linhas,$ed47_v_nome,$nome);
}
pg_query("commit");

echo "\n\n Operacao Concluida\n\n";
?>