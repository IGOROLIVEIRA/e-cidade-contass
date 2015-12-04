<?
require("libs/db_stdlib.php");
require("libs/db_conn.php");
include("classes/db_aguaconsumo_classe.php");
include("classes/db_aguaconsumorec_classe.php");



function db_msg($_msg="") {
  echo $_msg . "\n";
  return;
}

function db_termo($pos, $total, $msg="") {
  $perc = round(($pos/$total)*100, 2);
  $msg = !empty($msg)?" [$msg]":"";
  echo "  . Processando ($pos/$total) $perc % concluido...$msg\r";
  return;
}  

function db_tempodecorrido($segundo_inicial, $segundo_final) {
  
  $tempo = number_format(($segundo_final - $segundo_inicial),0);
  
  /*inicializando as vari�veis*/
  $horas       = 0;
  $sobra_horas = 0;
  $minutos     = 0;
  $segundos    = 0;
  
  /*Calculando horas, minutos e segundos*/
  if ($tempo >= 3600) {
    $horas = number_format(($tempo / 3600),0);
    $sobra_horas = $tempo - ($horas*3600);
    if ($sobra_horas > 60) {
      $minutos = number_format(($sobra_horas/60),0);
      $segundos = $sobra_horas - ($minutos*60);
    }
  } else if (($tempo < 3600) && ($tempo >=60)) {
    $minutos = number_format(($tempo/60),0);
    $segundos = $tempo - ($minutos*60);
  } else {
    $segundos = $tempo;
  }
  
  /* Configurando exibi��o conforme resultado*/
  if ($horas > 0) {
    $duracao = "{$horas} hora(s) {$minutos} minuto(s) {$segundos} segundo(s).";
  } else if ($minutos > 0) {
    $duracao = "{$minutos} minuto(s) {$segundos} segundo(s).";
  } else {
    $duracao = "{$segundos} segundo(s).";
  }
  
  return $duracao;
}


// Bage
$DB_BASE     = "daeb";
$DB_SERVIDOR = "localhost";
$DB_PORTA    = "5434";
$DB_USUARIO  = "postgres";
$DB_SENHA    = "";

db_msg("");
db_msg("VIRADA MODULO AGUA   Base: ".$DB_BASE." - 3 segundos... se quiser cancelar CTRL+C");
db_msg("");
//sleep(3);


if(!($conn = @pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))) {
  db_msg("ERRO: Estabelecendo conexao com banco de dados (host=$DB_SERVIDOR base=$DB_NAME porta=$DB_PORTA user=$DB_USUARIO senha=$DB_SENHA)");
  exit;
}

// Parametros do Calculo
$anoorigem  = 2006;
$anodestino = 2007;
$percentual = 2.71;
//--------------------


$erro = false;
set_time_limit(0);

// Instancia classes
$claguaconsumo    = new cl_aguaconsumo;
$claguaconsumorec = new cl_aguaconsumorec;

$result = pg_exec("begin;");

$iniciovirada = mktime(date("H"), date("i"), date("s"), 0, 0, 0);
db_msg("- Inicio da Virada do Modulo �gua: ".date("H:i:s", $iniciovirada));
db_msg("");

$sql = $claguaconsumo->sql_query_file(null, "*", "x19_codconsumo", "x19_exerc = $anoorigem");

//die($sql);
$resultconsumo = $claguaconsumo->sql_record($sql);
if ($claguaconsumo->numrows==0) {
  db_msg("ERRO: Sem registros para efetuar virada!");
  exit;
}

$sql_erro  = false;
$total_reg = $claguaconsumo->numrows;
//die("tot reg:  $total_reg  \n");

for($x=0; $x<$total_reg; $x++) {
  //
  db_fieldsmemory($resultconsumo, $x);
  db_termo($x+1, $total_reg);

  $sqlnext = "select nextval('aguaconsumo_x19_codconsumo_seq') as nextaguaconsumo";
  $resultnext = pg_query($sqlnext);
  db_fieldsmemory($resultnext, 0);

  $x19_zona = empty($x19_zona)?'null':$x19_zona;

  $insertaguaconsumo = "
    insert into aguaconsumo (
      x19_codconsumo,
      x19_exerc,     
      x19_areaini,   
      x19_areafim,   
      x19_caract,   
      x19_conspadrao,
      x19_descr,     
      x19_ativo,     
      x19_zona
    ) values (
      $nextaguaconsumo,
      $anodestino,
      $x19_areaini,   
      $x19_areafim,   
      $x19_caract,   
      $x19_conspadrao,
      '$x19_descr',     
      '$x19_ativo',     
      $x19_zona
    );";

  $resultinsert = pg_query($insertaguaconsumo);
  if(!$resultinsert){
    $sql_erro = true;
    $erro_msg = "ERRO: Ao incluir novo aguaconsumo";
    exit;
  }

  $sqlaguaconsumorec = $claguaconsumorec->sql_query_file($x19_codconsumo, null, "*", null, ""); 

  $resultconsumorec = pg_query($sqlaguaconsumorec);
  
  $rowsconsumorec = pg_num_rows($resultconsumorec);

  if($rowsconsumorec>0) {
    
    for($y=0; $y<$rowsconsumorec; $y++) {
      db_fieldsmemory($resultconsumorec, $y);
      
      $x20_valor = $percentual<>0?round($x20_valor + ($x20_valor * ($percentual/100)), 2):$x20_valor;
      
      $insertaguaconsumorec = "
        insert into aguaconsumorec (
          x20_codconsumo,    
          x20_codconsumotipo,
          x20_valor         
        ) values (
          $nextaguaconsumo,    
          $x20_codconsumotipo,
          $x20_valor
        )";
      //die($insertaguaconsumorec); 
      $resultinsert = pg_query($insertaguaconsumorec);;
      if(!$resultinsert){
        $sql_erro = true;
        $erro_msg = "ERRO: Ao incluir novo aguaconsumorec";
        exit;
      }
    }    

  }    

  if($sql_erro == true) {
    exit;
  }

}  

$fimvirada = mktime(date("H"), date("i"), date("s"), 0, 0, 0);
db_msg("\n");
db_msg("-    Fim da Virada: ".date("H:i:s", $fimvirada));
db_msg();

if($sql_erro == true) {
  pg_query("rollback");
  db_msg($erro_msg);
} else {
  
  pg_query("commit");
  db_msg("\n>>> Virada do Modulo Agua Efetuado com Sucesso! <<<");

  db_msg("- Inicio da Virada: ".date("H:i:s", $iniciovirada));
  db_msg("-    Fim da Virada: ".date("H:i:s", $fimvirada));
  $decorrido = db_tempodecorrido($iniciovirada, $fimvirada);
  db_msg("-  Tempo decorrido: $decorrido");
  db_msg("");

}

?>
