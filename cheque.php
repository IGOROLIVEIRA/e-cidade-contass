<?

include("libs/db_stdlib.php");

$valor = 123;
$ip_imprime = "192.168.78.16";
$data = "01/01/2007";

$codbco = "001";
$nome = "JOAO DA SILVA";
$municipio = "BAGE";

// modelo 1 - CHRONOS
// modelo 2 - BEMATECH (DP 20)
$modelo=3;

$valor = trim(db_formatar($valor, 'f', '', 2));

// abre socket
$fd = fsockopen($ip_imprime, 4444);

if($modelo == 2){
  $data = str_replace("-", "/", $data);
  $imprimir  = chr(27).chr(177);
  $imprimir .= chr(27).chr(162).$codbco.chr(13);
  $imprimir .= chr(27).chr(163).$valor.chr(13);
  $imprimir .= chr(27).chr(160).$nome.chr(13);
  $imprimir .= chr(27).chr(161).$municipio.chr(13);
  $imprimir .= chr(27).chr(164).$data.chr(13);
  $imprimir .= chr(27).chr(176);
  fputs($fd, $imprimir);
} elseif($modelo == 3){
//  $data = str_replace("-", "/", $data);
//die("xxx: $valor\n");
  $imprimir  = chr(27).chr(64);
  $imprimir .= chr(27).chr(163)."99999999999,99";
  $imprimir .= chr(27).chr(162).$codbco;
  $imprimir .= chr(27).chr(164)."2007/01/01";
  $imprimir .= chr(27).chr(166).$nome;
  $imprimir .= chr(27).chr(167).$municipio;
  $imprimir .= chr(27).chr(177);
  $imprimir .= chr(27).chr(176);
  fputs($fd, $imprimir);
}else{
  fputs($fd, chr(27).chr(160)." $nome\n");
  fputs($fd, chr(27).chr(161)." $municipio\n");
  fputs($fd, chr(27).chr(162)." $codbco\n");
  fputs($fd, chr(27).chr(163)." $valor\n");
  fputs($fd, chr(27).chr(164)." $data\n");
  fputs($fd, chr(27).chr(176));
  
  fputs($fd, " \n");
  fputs($fd, " \n");
  fputs($fd, " \n");
  fputs($fd, " \n");
  fputs($fd, " \n");
  fputs($fd, " \n");
  fputs($fd, " \n");
  fputs($fd, "          Prefeito:"."\n");
}

fclose($fd);

?>
