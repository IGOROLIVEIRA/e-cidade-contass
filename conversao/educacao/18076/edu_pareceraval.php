<?
$HOST = "127.0.0.1";
$BASE = "sapiranga";
$PORT = "5432";
$USER = "postgres";
$PASS = "";
set_time_limit(0);
if(!($conn = pg_connect("host=$HOST dbname=$BASE port=$PORT user=$USER password=$PASS"))){
 echo "Erro ao conectar base de dados...\n";
 exit;
}
system("clear");
pg_exec("begin");

$sql_campo = "ALTER TABLE pareceraval ADD ed93_t_parecer text";
$result_campo = pg_query($sql_campo);
if(!$result_campo){
 pg_exec("rollback");
 exit;
}
$sql_campo = "UPDATE pareceraval SET ed93_t_parecer = 'nada'";
$result_campo = pg_query($sql_campo);

$sql = "SELECT ed93_i_diarioavaliacao,ed92_i_sequencial,ed92_c_descr,ed91_c_descr
	FROM pareceraval
	 inner join parecer on ed92_i_codigo = ed93_i_parecer
	 left join parecerlegenda on ed91_i_codigo = ed93_i_parecerlegenda
	ORDER BY ed93_i_diarioavaliacao,ed92_i_sequencial";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
if($linhas>0){
 echo "Começando CONVERSÃO em $linhas registros:\n\n";
 sleep(3);
 $primeiro = pg_result($result,0,'ed93_i_diarioavaliacao');
 $parecerconcatenado = "";
 $sep = "";
 $num_diarios = 0;
 for($x=0;$x<$linhas;$x++){
  $insert = false;
  $diarioavaliacao = pg_result($result,$x,'ed93_i_diarioavaliacao');
  $sequencial      = pg_result($result,$x,'ed92_i_sequencial');
  $parecer         = trim(pg_result($result,$x,'ed92_c_descr'));
  $parecerlegenda  = trim(pg_result($result,$x,'ed91_c_descr'));
  if($primeiro!=$diarioavaliacao){
   $diarioanterior = pg_result($result,($x-1),'ed93_i_diarioavaliacao');
   $sql1 = "INSERT INTO pareceraval
             (ed93_i_codigo,ed93_i_diarioavaliacao,ed93_i_parecer,ed93_i_parecerlegenda,ed93_t_parecer)
            VALUES
             (nextval('pareceraval_ed93_i_codigo_seq'),$diarioanterior,null,null,'$parecerconcatenado')";
   $result1 = pg_query($sql1);
   $reginserido = $diarioanterior;
   $num_diarios++;
   $primeiro = $diarioavaliacao;
   $parecerconcatenado = "";
   $sep = "";
   $insert = true;
  }
  $parecerconcatenado .= $sep.$sequencial." - ".$parecer."".($parecerlegenda!=""?"=> $parecerlegenda":"");
  $sep = " ** ";
  if($x==($linhas-1)){
   $num_diarios++;
   $sql1 = "INSERT INTO pareceraval
             (ed93_i_codigo,ed93_i_diarioavaliacao,ed93_i_parecer,ed93_i_parecerlegenda,ed93_t_parecer)
            VALUES
	     (nextval('pareceraval_ed93_i_codigo_seq'),$diarioavaliacao,null,null,'$parecerconcatenado')";
   $result1 = pg_query($sql1);
   $reginserido = $diarioavaliacao;
   $insert = true;
  }
  if($insert==true){
   if(!$result1){
    pg_exec("rollback");
    break;
   }else{
    echo str_pad(($num_diarios),6,0,STR_PAD_LEFT)." -> INSERT registro $reginserido \n";
   }
  }
 }
 echo "\n\n Terminada CONVERSÃO em $linhas registros.\n\n";
}
$sql_delete = "DELETE FROM pareceraval WHERE ed93_t_parecer = 'nada' ";
$result_delete = pg_query($sql_delete);
$sql_campo1 = "ALTER TABLE pareceraval DROP ed93_i_parecer";
$result_campo1 = pg_query($sql_campo1);
$sql_campo2 = "ALTER TABLE pareceraval DROP ed93_i_parecerlegenda";
$result_campo2 = pg_query($sql_campo2);
$sql_campo3 = "CREATE UNIQUE INDEX pareceraval_diario_in ON pareceraval(ed93_i_diarioavaliacao)";
$result_campo3 = pg_query($sql_campo3);

pg_exec("commit");
?>