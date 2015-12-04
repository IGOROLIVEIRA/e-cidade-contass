<?
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

//http://localhost/dbportal_prj/dbissonline.php?ano=2007&mes=04&cgccpf_empresa=12345678912&valor=500&cgccpf_resp=22233344455&nome=karina&endereco=ruaxxx

// cabecalho do XML
$xmlRetorno  = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?> \n";
$xmlRetorno .= "<dbissonline> \n";
$xmlRetorno .= "<ano>".$ano."</ano> \n";
$xmlRetorno .= "<mes>".$mes."</mes> \n";
$xmlRetorno .= "<tipocobranca>2</tipocobranca> \n";
$xmlRetorno .= "<codigobarras>00197348100000453002436290000000805669500121</codigobarras> \n";
$xmlRetorno .= "<linhadigitavel>00192.43625 90000.000803 56695.001216  7  34810000045300</linhadigitavel> \n";
$xmlRetorno .= "<vencimento>20070419</vencimento> \n";
$xmlRetorno .= "<valorcorrigido>".($valor*100)."</valorcorrigido> \n";
$xmlRetorno .= "<valorjuros>00</valorjuros> \n";
$xmlRetorno .= "<valormulta>00</valormulta> \n";
$xmlRetorno .= "<valordesconto>00</valordesconto> \n";
$xmlRetorno .= "<valortotal>".($valor*100)."</valortotal> \n";
$xmlRetorno .= "<msgerro></msgerro> \n";
$xmlRetorno .= "</dbissonline> \n";

// seta o cabecalho da requisicao para xml
header("Content-type: application/xml; charset=ISO-8859-1");
// retorna o XML
echo $xmlRetorno;
?>
