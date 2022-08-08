<?php

echo "<br><br>Processando VINCULAÇÕES DO PCASP!! <br><br>";
require_once(__DIR__ . "/../libs/db_conn.php");

$uploaddir = '/tmp/';

$uploadfile = $uploaddir . $_FILES['arquivo']['name'];

if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $uploadfile)){
	
}else {
	echo "Erro ao enviar arquivo!";
}

$db = $DB_BASE;
$dbport = $DB_PORTA;
$dbano = $_POST['dbano'];
$conexao_postgre = pg_connect("host=localhost port='".$dbport."' dbname='".$db."' user=dbportal password=") 
or die("Não foi possível conectar ao Banco de dados.");

$rsResult = pg_query($conexao_postgre, "SELECT fc_startsession()");

$rsResult = pg_query($conexao_postgre, "CREATE TEMPORARY TABLE w_pcaspconf(
  	codpcasp character varying(170) ,
  	descpcasp character varying(170),
  	planoorc character varying(170) ,
  	descplano character varying(170),
  	ano character varying(170)
)");

/* Insira aqui a pasta que deseja salvar o arquivo*/


//system("cp pcaspconf".$dbano.".csv /tmp");
$rsResult = pg_query($conexao_postgre, "COPY w_pcaspconf from '/tmp/pcaspconf".$dbano.".csv' with csv header");
$rsResult = pg_query($conexao_postgre, "select * from w_pcaspconf");
$aDados = array();
if (pg_num_rows($rsResult) > 0) {
  
  for($y = 0; $y< pg_num_rows($rsResult);$y++){
	$linha = pg_fetch_object($rsResult,$y);
	$oDados = array();
	$oDados['codpcasp'] = str_pad(str_replace(".", "", str_replace(" ", "", $linha->codpcasp)),15,'0',STR_PAD_RIGHT);
	$oDados['descpcasp'] = $linha->descpcasp;
	$oDados['planoorc'] =$linha->planoorc;
	$oDados['planoorc'] =  $linha->planoorc;
	$oDados['descplano'] = $linha->descplano;
	
	
	
	if(substr($linha->planoorc, 0,1) != '3' && substr($linha->planoorc, 0,1) != '4'){
		$oDados['planoorc'] = "4".str_pad(str_replace(".", "", str_replace(" ", "", $linha->planoorc)),14,'0',STR_PAD_RIGHT);
		
	}else{
		$oDados['planoorc'] = "3".str_pad(str_replace(".", "", str_replace(" ", "", $linha->planoorc)),14,'0',STR_PAD_RIGHT);
	}	
	$aDados[]=$oDados;
	
  }
} else {
	echo "Não retornou nada!<br><br>";
	echo pg_last_error();
	exit;
}

$erro = 0;
$rsResult_apagar = pg_query($conexao_postgre, "select * from conplanoconplanoorcamento where c72_anousu = ".$dbano); 

if(pg_num_rows($rsResult_apagar) > 0){
   		pg_query($conexao_postgre, "DELETE FROM conplanoconplanoorcamento where c72_anousu = ".$dbano);
   		$rsResult = pg_query($conexao_postgre, "select setval('conplanoconplanoorcamento_c72_sequencial_seq',
			(select max(c72_sequencial) from conplanoconplanoorcamento))");
}

$oDadosDb = array();

//print_r($aDados);exit;
foreach ($aDados as $aD) {

   $erro = 0;
   
    $rsResult_pcasp = pg_query($conexao_postgre, "select c60_codcon 
   							from conplano WHERE c60_estrut = '{$aD['codpcasp']}' and c60_anousu = ".$dbano);
            if (pg_num_rows($rsResult_pcasp) > 0) {
          		for($x = 0; $x< pg_num_rows($rsResult_pcasp);$x++){
						$linha = pg_fetch_object($rsResult_pcasp,$x);
						$oDadosDb['codpcasp'] = $linha->c60_codcon;
          		}
                
            } else {
	    		echo "Estrutural ".$aD['codpcasp']." - ".$aD['descpcasp']." não cadastrado no PCASP <br><br>";
	    		$erro = 1;
            }
            
   $rsResult_planoroc = pg_query($conexao_postgre, "select c60_codcon 
   						from conplanoorcamento WHERE c60_estrut = '{$aD['planoorc']}' and c60_anousu = ".$dbano);
	
          	if (pg_num_rows($rsResult_planoroc) > 0) {
          		for($i = 0; $i< pg_num_rows($rsResult_planoroc);$i++){
						$linha = pg_fetch_object($rsResult_planoroc,$i);
						$oDadosDb['planoorc'] = $linha->c60_codcon;
          		}
                
            } else {
	    		echo "Estrutural ".$aD['planoorc']." - ".$aD['descplano']." não cadastrado no PLANO ORÇAMENTARIO <br><br>";
	    		$erro = 1;
            }
            
    		if($erro == 0){
	    		$sSql_insert = "INSERT INTO conplanoconplanoorcamento (c72_sequencial,c72_conplano,c72_conplanoorcamento,c72_anousu) 
					VALUES (nextval('conplanoconplanoorcamento_c72_sequencial_seq'),
                            {$oDadosDb['codpcasp']},{$oDadosDb['planoorc']},{$dbano})";
	            pg_query($conexao_postgre, $sSql_insert);
    		}
}
	echo "<br><br>Fim Configuração PCASP!!";
?>
