<?
set_time_limit(0);

/************************************************/
$dbname   = "auto_dae_3003";
$dbhost   = "192.168.0.37";
$dbarq    = "/tmp/sib201_001.txt";//BANCO DO BRASIL
//$dbarq    = "/tmp/sib201_041.txt";//BANRISUL
//$dbarq    = "/tmp/sib201_104.txt";//CAIXA
/***********************************************/

$conn = pg_connect("dbname=$dbname user=postgres host=$dbhost") or die('ERRO AO CONECTAR NA BASE DE DADOS !!');
system("echo 'Aguarde conectando na base de dados...'");
$arquivo = fopen ("$dbarq", "r");
pg_query("BEGIN;");
$cont=0;
$cont_sim=0;
$cont_naum=0;
$banco=1;//BANCO DO BRASIL
//$banco=41;//BANRISUL
//$banco=104;//CAIXA
$instit=4;//DAEB
system("> erros_$banco.txt");
while (!feof($arquivo)){
    $linha = fgets($arquivo,4096);
    $cont++;
	if($linha==""||$cont==1){
        continue;
    }
    $colunas = split (';', $linha);
    $matricula=substr($colunas[0],0,6);
    $nome=$colunas[1];
    $ident_banco=$colunas[2];//ignorar
    $cod_agencia=$colunas[3];
    $dig_agencia=$colunas[4];
    $num_conta=$colunas[5];
    $dig_conta=$colunas[6];
    $dt_lanc=$colunas[7];
    $dt_canc=$colunas[8];
    $dt_lanc=date("Y-m-d",$dt_lanc);
    $result_arrecad = pg_exec("select distinct arrecad.k00_numpre,arrecad.k00_numpar from arrematric inner join arrecad on arrematric.k00_numpre=arrecad.k00_numpre where k00_matric = $matricula and k00_tipo = 37");
    if(pg_numrows($result_arrecad)>0){    	    	
    	$d63_codigo_seq = pg_query("select nextval('debcontapedido_d63_codigo_seq')");
    	$d63_codigo = pg_result($d63_codigo_seq,0,0);  
    	$inclui_debcontapedido = pg_exec("insert into debcontapedido values ($d63_codigo,$instit,$banco,$cod_agencia,$num_conta,'$dt_lanc','00:01',2)");
    	$inclui_debcontapedidomatric = pg_exec("insert into debcontapedidomatric values ($d63_codigo,$matricula)");
    	$d66_sequencial_seq = pg_query("select nextval('debcontapedidotipo_d66_sequencial_seq')");
    	$d66_sequencial = pg_result($d66_sequencial_seq,0,0);  
    	$inclui_debcontapedidotipo = pg_exec("insert into debcontapedidotipo values ($d66_sequencial,$d63_codigo,37)");
    	for($x=0;$x<pg_numrows($result_arrecad);$x++){
    		$k00_numpre = pg_result($result_arrecad,$x,'k00_numpre');
    		$k00_numpar = pg_result($result_arrecad,$x,'k00_numpar');
    		$d67_sequencial_seq = pg_query("select nextval('debcontapedidotiponumpre_d67_sequencial_seq')");
    		$d67_sequencial = pg_result($d67_sequencial_seq,0,0);  
    		$inclui_debcontapedidotiponumpre = pg_exec("insert into debcontapedidotiponumpre values ($d67_sequencial,$d63_codigo,$k00_numpre,$k00_numpar)");
    	}
    	echo "Matricula Nº $matricula Incluida!!\n";
    	$cont_sim++;
    }else{
    	system("echo \"matricula nao cadastrada $matricula\">> /tmp/erros_$banco.txt");
    	echo "Matricula Nº $matricula sem debitos!!\n";
    	$cont_naum++;
    }    
}
echo "Foram incluidas $cont_sim\n";
echo "Matriculas sem debitos $cont_naum\n";
fclose($arquivo);
//pg_query("ROLLBACK;");
pg_query("COMMIT;");
?>
