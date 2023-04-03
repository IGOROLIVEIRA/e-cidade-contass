<?
set_time_limit(0);
include(__DIR__ . "/../../../libs/db_conn.php");

//$DB_SERVIDOR = "10.1.1.11";
//$DB_BASE     = "bage";
//$DB_USUARIO  = "postgres";
//$DB_SENHA    = "";
//$DB_PORTA    = "5432";

if (!($conn = pg_connect('host='.$DB_SERVIDOR.' dbname='.$DB_BASE.' user='.$DB_USUARIO.' password='.$DB_SENHA.' port='.$DB_PORTA))) {

 echo "Erro ao conectar...\n\n";
 exit;

}

function Progresso($linha,$total,$dado1,$dado2,$titulo) {

  $linha++;
  $percent = ($linha/$total)*100;
  $percorrido = floor($percent);
  $restante = 100-$percorrido;
  $tracos = "";
  for ($t = 0; $t < $percorrido; $t++) {
    $tracos .= "#";
  }
  $brancos = "";
  for ($t = 0; $t < $restante; $t++) {
    $brancos .= ".";
  }
  echo " $titulo";
  echo " $linha de $total registros.\n";
  echo " [".$tracos.$brancos."] ".number_format($percent,2,".",".")."%\n";
  if ($titulo != " PROGRESSÃO TOTAL DA TAREFA") {
    echo " ---> ".trim($dado1)." -- ".trim($dado2)."\n";
  }

}
 
echo "conectado...\n\n";
pg_query($conn, "SELECT fc_startsession()");

echo " ->Iniciando processo...";
sleep(1);
system("clear");
pg_exec("begin");

$erro = false;
$sql0 = "SELECT ed52_i_codigo,ed52_c_descr,ed52_c_aulasabado,ed52_i_diasletivos,ed52_i_semletivas FROM calendario ORDER BY ed52_i_ano"; 
$result0 = pg_query($sql0);
$linhas0 = pg_num_rows($result0);
if($linhas0==0){
 echo "Nenhum calendário para conversão\n\n";
 echo "Processo concluído\n\n"; 
 pg_exec("rollback");
 exit;
}else{
 for($dd=0;$dd<$linhas0;$dd++){
  $calendario = pg_result($result0,$dd,'ed52_i_codigo');
  $descrcalendario = trim(pg_result($result0,$dd,'ed52_c_descr'));  
  $sabado = pg_result($result0,$dd,'ed52_c_aulasabado');
  $dia_letivo_old = pg_result($result0,$dd,'ed52_i_diasletivos');
  $sem_letiva_old = pg_result($result0,$dd,'ed52_i_semletivas');
  $sql  = " SELECT * FROM periodocalendario";
  $sql .= "  inner join periodoavaliacao  on  periodoavaliacao.ed09_i_codigo = periodocalendario.ed53_i_periodoavaliacao";
  $sql .= "  inner join calendario  on  calendario.ed52_i_codigo = periodocalendario.ed53_i_calendario";
  $sql .= "  inner join duracaocal  on  duracaocal.ed55_i_codigo = calendario.ed52_i_duracaocal";
  $sql .= " WHERE ed09_c_somach = 'S' and ed53_i_calendario = $calendario ";  
  $result = pg_query($sql);
  $linhas = pg_num_rows($result);
  if($linhas>0){
   for($xx=0;$xx<$linhas;$xx++){
    $ed53_d_inicio = pg_result($result,$xx,'ed53_d_inicio');
    $ed53_d_fim = pg_result($result,$xx,'ed53_d_fim');
    $ed53_i_codigo = pg_result($result,$xx,'ed53_i_codigo');
    $data_in = mktime(0,0,0,substr($ed53_d_inicio,5,2),substr($ed53_d_inicio,8,2),substr($ed53_d_inicio,0,4));
    $data_out = mktime(0,0,0,substr($ed53_d_fim,5,2),substr($ed53_d_fim,8,2),substr($ed53_d_fim,0,4));
    $data_entre = $data_out - $data_in;
    $dias = ceil($data_entre/86400);
    $dias2 = $dias;
    $day = 0;
    $nao_util = 0;
    $d = date('d', $data_in);
    $m = date('m', $data_in);
    $y = date('Y', $data_in);
    $m2 = date('m', $data_out);
    $y2 = date('Y', $data_out);
    $days_month = date("t", $data_in);
    $mi = date('m', $data_in);
    $semanas = 0;
    $primeiro_dia = date("w", mktime (0,0,0,substr($ed53_d_inicio,5,2),substr($ed53_d_inicio,8,2),substr($ed53_d_inicio,0,4)));
    if($dias+$d <= $days_month){
     for ($i = 0; $i < $dias+1; $i++){
      $day++;
      if(date("w", mktime (0,0,0,$m,$d+$i,$y))==1){
       $semanas++;
      }
      if($sabado=="N"){
       if (date("w", mktime (0,0,0,$m,$d+$i,$y)) == 0 || date("w", mktime (0,0,0,$m,$d+$i,$y)) == 6){
        $res = pg_query("SELECT * FROM feriado WHERE extract(month from ed54_d_data)=$m AND extract(day from ed54_d_data)=$d+$i AND ed54_i_calendario=$calendario");
        if(pg_num_rows($res)==0){
         $nao_util++;
        }else{
         if(pg_result($res,0,'ed54_c_dialetivo')=="N"){
          $nao_util++;
         }
        }
       }else{
        $res = pg_query("SELECT * FROM feriado WHERE extract(month from ed54_d_data)=$m AND extract(day from ed54_d_data)=$d+$i AND ed54_i_calendario=$calendario AND ed54_c_dialetivo = 'N' ");
        if($row = pg_fetch_assoc($res)){
         $nao_util++;
        }
       }
      }else{
       if (date("w", mktime (0,0,0,$m,$d+$i,$y)) == 0 ){
        $res = pg_query("SELECT * FROM feriado WHERE extract(month from ed54_d_data)=$m AND extract(day from ed54_d_data)=$d+$i AND ed54_i_calendario=$calendario");
        if(pg_num_rows($res)==0){
         $nao_util++;
        }else{
         if(pg_result($res,0,'ed54_c_dialetivo')=="N"){
          $nao_util++;
         }
        }
       }else{
        $res = pg_query("SELECT * FROM feriado WHERE extract(month from ed54_d_data)=$m AND extract(day from ed54_d_data)=$d+$i AND ed54_i_calendario=$calendario AND ed54_c_dialetivo = 'N' ");
        if($row = pg_fetch_assoc($res)){
         $nao_util++;
        }
       }
      }
     }
    }else{
     while($m != $m2 || $y != $y2){
      if($m==$mi){
       $days_month = date("t", mktime (0,0,0,$m,$d,$y))-$d+1;
      }else{
       $days_month = date("t", mktime (0,0,0,$m,$d,$y));
      }
      for ($i = 0; $i < $days_month; $i++){
       $day++;
       if(date("w", mktime (0,0,0,$m,$d+$i,$y))==1){
        $semanas++;
       }
       if($sabado=="N"){
        if (date("w", mktime (0,0,0,$m,$d+$i,$y)) == 0 || date("w", mktime (0,0,0,$m,$d+$i,$y)) == 6){
         $res = pg_query("SELECT * FROM feriado WHERE extract(month from ed54_d_data)=$m AND extract(day from ed54_d_data)=$d+$i AND ed54_i_calendario=$calendario");
         if(pg_num_rows($res)==0){
          $nao_util++;
         }else{
          if(pg_result($res,0,'ed54_c_dialetivo')=="N"){
           $nao_util++;
          }
         }
        }else{
         $res = pg_query("SELECT * FROM feriado WHERE extract(month from ed54_d_data)=$m AND extract(day from ed54_d_data)=$d+$i AND ed54_i_calendario=$calendario AND ed54_c_dialetivo = 'N' ");
         if($row = pg_fetch_assoc($res)){
          $nao_util++;
         }
        }
       }else{
        if (date("w", mktime (0,0,0,$m,$d+$i,$y)) == 0 ){
         $res = pg_query("SELECT * FROM feriado WHERE extract(month from ed54_d_data)=$m AND extract(day from ed54_d_data)=$d+$i AND ed54_i_calendario=$calendario");
         if(pg_num_rows($res)==0){
          $nao_util++;
         }else{
          if(pg_result($res,0,'ed54_c_dialetivo')=="N"){
           $nao_util++;
          }
         }
        }else{
         $res = pg_query("SELECT * FROM feriado WHERE extract(month from ed54_d_data)=$m AND extract(day from ed54_d_data)=$d+$i AND ed54_i_calendario=$calendario AND ed54_c_dialetivo = 'N' ");
         if($row = pg_fetch_assoc($res)){
          $nao_util++;
         }
        }
       }
      }
      if($m == 12){
       $m = 1;
       $y++;
      }else{
       $m++;
      }
      $d = 1;
      if($m==$m2){
       $d3 = date('d', $data_out);
       $m3 = date('m', $data_out);
       $y3 = date('Y', $data_out);
       for ($i = 0; $i < $d3; $i++){
        $day++;
        if(date("w", mktime (0,0,0,$m3,$d+$i,$y3))==1){
         $semanas++;
        }       
        if($sabado=="N"){
         if (date("w", mktime (0,0,0,$m3,$d+$i,$y3)) == 0 || date("w", mktime (0,0,0,$m3,$d+$i,$y3)) == 6){
          $res = pg_query("SELECT * FROM feriado WHERE extract(month from ed54_d_data)=$m3 AND extract(day from ed54_d_data)=$d+$i AND ed54_i_calendario=$calendario");
          if(pg_num_rows($res)==0){
           $nao_util++;
          }else{
           if(pg_result($res,0,'ed54_c_dialetivo')=="N"){
            $nao_util++;
           }
          }
         }else{
          $res = pg_query("SELECT * FROM feriado WHERE extract(month from ed54_d_data)=$m3 AND extract(day from ed54_d_data)=$d+$i AND ed54_i_calendario=$calendario AND ed54_c_dialetivo = 'N' ");
          if($row = pg_fetch_assoc($res)){
           $nao_util++;
          }
         }
        }else{
         if (date("w", mktime (0,0,0,$m3,$d+$i,$y3)) == 0 ){
          $res = pg_query("SELECT * FROM feriado WHERE extract(month from ed54_d_data)=$m3 AND extract(day from ed54_d_data)=$d+$i AND ed54_i_calendario=$calendario");
          if(pg_num_rows($res)==0){
           $nao_util++;
          }else{
           if(pg_result($res,0,'ed54_c_dialetivo')=="N"){
            $nao_util++;
           }
          }
         }else{
          $res = pg_query("SELECT * FROM feriado WHERE extract(month from ed54_d_data)=$m3 AND extract(day from ed54_d_data)=$d+$i AND ed54_i_calendario=$calendario AND ed54_c_dialetivo = 'N' ");
          if($row = pg_fetch_assoc($res)){
           $nao_util++;
          }
         }
        }
       }
      }
     }
    }
    $diasletivos = $day-$nao_util;
    if($primeiro_dia>1 && $primeiro_dia<6){
     $semanas++;
    }
    $semletivas = $semanas;      
    $sql1 = "UPDATE periodocalendario SET
              ed53_i_diasletivos = $diasletivos, 
              ed53_i_semletivas = $semletivas
             WHERE ed53_i_codigo = $ed53_i_codigo
            ";
    $query1 = pg_query($sql1);
    if(!$query1){
     $erro = true;
     break;
    }
   }
   $sql2  = " SELECT sum(ed53_i_diasletivos) as dias1,sum(ed53_i_semletivas) as semanas1";
   $sql2 .= " FROM periodocalendario";
   $sql2 .= "  inner join periodoavaliacao  on  periodoavaliacao.ed09_i_codigo = periodocalendario.ed53_i_periodoavaliacao";
   $sql2 .= "  inner join calendario  on  calendario.ed52_i_codigo = periodocalendario.ed53_i_calendario";
   $sql2 .= "  inner join duracaocal  on  duracaocal.ed55_i_codigo = calendario.ed52_i_duracaocal";
   $sql2 .= " WHERE ed53_i_calendario = $calendario AND ed09_c_somach = 'S' ";  
   $result2 = pg_query($sql2);
   $dias1 = pg_result($result2,0,'dias1');
   $semanas1 = pg_result($result2,0,'semanas1');
   if($dias1==""){
    $dias1 = 0;
    $semanas1 = 0;
   }
   $sql3 = "UPDATE calendario SET
             ed52_i_diasletivos = $dias1,
             ed52_i_semletivas = $semanas1
            WHERE ed52_i_codigo = $calendario
           ";
   $query3 = pg_query($sql3);
   if(!$query3 || $erro==true){
   	$erro = true;
    break;
   }
  } 
  system("clear");
  echo Progresso($dd,$linhas0,$calendario,$descrcalendario," PROGRESSÃO CALENDARIO:");
 }
 if($erro==true){
  pg_exec("rollback"); 
 }else{
  pg_exec("commit"); 
  echo "\n\nProcesso Concluído!\n\n";
 } 
}
?>
