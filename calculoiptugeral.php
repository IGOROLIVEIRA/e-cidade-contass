<?
require("libs/db_stdlib.php");
require("libs/db_conn.php");
include("classes/db_iptubase_classe.php");

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
  
  /*inicializando as variáveis*/
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
  
  /* Configurando exibição conforme resultado*/
  if ($horas > 0) {
    $duracao = "{$horas} hora(s) {$minutos} minuto(s) {$segundos} segundo(s).";
  } else if ($minutos > 0) {
    $duracao = "{$minutos} minuto(s) {$segundos} segundo(s).";
  } else {
    $duracao = "{$segundos} segundo(s).";
  }
  
  return $duracao;
}

$DB_BASE     = "robson_sap_20070909";
$DB_BASE     = "sap_iptu_2008";
$DB_SERVIDOR = "192.168.0.34";
$DB_PORTA    = "5432";

$DB_USUARIO  = "postgres";
$DB_SENHA    = "";

db_msg("");
db_msg("CALCULO GERAL IPTU   Base: ".$DB_BASE." - 3 segundos... se quiser cancelar CTRL+C");
db_msg("");
//sleep(3);

if(!($conn = @pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))) {
  db_msg("ERRO: Estabelecendo conexao com banco de dados (host=$DB_SERVIDOR base=$DB_NAME porta=$DB_PORTA user=$DB_USUARIO senha=$DB_SENHA)");
  exit;
}

// Parametros do Calculo
$anousu     = 2007;
$financeiro = 1;
//--------------------


$erro = false;
set_time_limit(0);
$cliptubase = new cl_iptubase;
$result = pg_exec("begin;");

$ini = mktime();

$iniciocalculo = mktime(date("H"), date("i"), date("s"), 0, 0, 0);
db_msg("- Inicio do Calculo: ".date("H:i:s", $iniciocalculo));
db_msg("");
db_msg("inicio: " . date("H:i:s", $ini));

$sql = " select j01_matric from iptubase ";

//$sql = " select k00_matric as j01_matric from matriculas_calcular ";

$result = $cliptubase->sql_record($sql);

if ($cliptubase->numrows==0) {
  db_msg("ERRO: Sem matrículas a calcular!");
} else {
  $total_reg = $cliptubase->numrows;
  $sqlnextval = "select nextval('iptucalclog_j27_codigo_seq') as j27_codigo";
  $resultnextval = pg_exec($sqlnextval);
  if ($resultnextval == false) {
    db_msg("ERRO: Nao consegui buscar proxima sequencia 'iptucalclog_j27_codigo_seq'");
  } else {
    db_fieldsmemory($resultnextval,0);
    $insert = "insert into iptucalclog values ($j27_codigo,$anousu,'".date('Y-m-d')."','".db_hora()."', 1,false," . $cliptubase->numrows . ")";
    $resultinsert = pg_exec($insert) or die($insert);
    if ($resultinsert == false) {
      db_msg("ERRO: Gerando registro na tabela iptucalclog!");
    } else {

      pg_exec("commit;");
     
      // For para calcular matriculas
      for ($ii=0; $ii<$total_reg; $ii++) {
        db_fieldsmemory($result,$ii);
        
        pg_exec("begin;");

				$resultcfiptu=pg_query("select distinct j18_anousu, j18_permvenc from cfiptu order by j18_anousu desc");
				$j18_permvenc = 1;
				if(pg_numrows($resultcfiptu) > 0){
					db_fieldsmemory($resultcfiptu,0);
				}
				if ($j18_permvenc == 0) {
					$j18_permvenc = 1;
				}
				
				if ($j18_permvenc == 1) {
					$sql = "select fc_calculoiptu($j01_matric,$anousu,true,false,false,false,false,0,0,0)";
				} elseif ($j18_permvenc == 2) {
					$sql = "select fc_calculoiptu($j01_matric,$anousu,true,false,false,false,false,0,0)";
				}
				//die($sql);
        $resultcalc = $cliptubase->sql_record($sql);
        if ($resultcalc != false) {
          db_fieldsmemory($resultcalc,0);
          db_termo($ii+1, $total_reg, "Matricula: $j01_matric");
          $insert = "insert into iptucalclogmat values ($j27_codigo,$j01_matric,".substr($fc_calculoiptu,0,2).",'".trim(substr($fc_calculoiptu,2))."')";
          $resultinsert = pg_exec($insert) or die($insert);
          if ($resultinsert == false) {
            $erro=true;
          }
        } else {
          $erro=true;
        }
        //if ($erro == true) {
        //  db_msg("\nERRO: Ocorreu um erro durante o processamento, Calculo abortado ! Matricula: $j01_matric");
        //  exit;
        //}
        pg_exec("commit;");
      }

      $fimcalculo = mktime(date("H"), date("i"), date("s"), 0, 0, 0);
      $fim = mktime();

      $tempo = date("H:i:s", $fim - $ini);

      db_msg("\n");
      db_msg("-    Fim do Calculo: ".date("H:i:s", $fimcalculo));
      db_msg();
      db_msg("tempo: $tempo");

      if ($erro == true) {
        db_msg("ERRO: Ocorreram erros durante o processamento! Emite relatorio de erros!");
			}

			db_msg("\n>>> Cálculo finalizado! <<<");

      db_msg("- Inicio do Calculo: ".date("H:i:s", $iniciocalculo));
      db_msg("-    Fim do Calculo: ".date("H:i:s", $fimcalculo));
      $decorrido = db_tempodecorrido($iniciocalculo, $fimcalculo);
      db_msg("-   Tempo decorrido: $decorrido");
      db_msg(""); 
    }
  }
}
?>
