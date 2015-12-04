<?php


/**
 * Carregamos as bibliotecas nescessárias
 */
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");


db_postmemory($HTTP_POST_VARS);
if ($_FILES['arquivoVinculoPcasp']['type'] != 'text/csv') {
  
  $sErrorMessage = "O arquivo enviado não é do formato correto. Favor verificar o arquivo.";
  db_redireciona("pcasp001.php?lErro=true&sErrorMessage=".$sErrorMessage);
}
if (!move_uploaded_file($_FILES['arquivoVinculoPcasp']['tmp_name'], "/tmp/{$_FILES['arquivoVinculoPcasp']['name']}")) {
  
  $sErrorMessage = "Arquivo não encontrado para importação. Favor verificar o arquivo.";
  db_redireciona("pcasp001.php?lErro=true&sErrorMessage=".$sErrorMessage);
}

$rsResult = db_query("CREATE TEMPORARY TABLE w_pcaspconf(
					  	codpcasp character varying(170) ,
					  	descpcasp character varying(170),
					  	planoorc character varying(170) ,
					  	descplano character varying(170),
					  	ano character varying(170))");

//system("cp pcaspconf.csv /tmp");
$rsResult = db_query("COPY w_pcaspconf from '/tmp/pcaspconf.csv' with csv header");
$rsResult = db_query("select * from w_pcaspconf");
$aDados = array();
if (pg_num_rows($rsResult) > 0) {
  
  for($y = 0; $y< pg_num_rows($rsResult);$y++){
	$linha = pg_fetch_object($rsResult,$y);
	$oDados = array();
	$oDados['codpcasp'] = $linha->codpcasp;
	$oDados['descpcasp'] = $linha->descpcasp;
	$oDados['planoorc'] = $linha->planoorc;
	$oDados['descplano'] = $linha->descplano;
	$aDados[]=$oDados;	
	
  }
} else {
	$sErrorMessage = "Não existe dados para importação!. Favor verificar o arquivo.";
  db_redireciona("pcasp001.php?lErro=true&sErrorMessage=".$sErrorMessage);
}

$erro = 0;
$rsResult_apagar = db_query("select * from conplanoconplanoorcamento where c72_anousu = ".db_getsession('DB_anousu')); 

if(pg_num_rows($rsResult_apagar) > 0){
   		db_query("DELETE FROM conplanoconplanoorcamento where c72_anousu = ".db_getsession('DB_anousu'));
   		$rsResult = db_query("select setval('conplanoconplanoorcamento_c72_sequencial_seq',
			(select max(c72_sequencial) from conplanoconplanoorcamento))");
}

$oDadosDb = array();

$aErroPcaspAgrupado = array();
$aErroOrcamentoAgrupado = array();


foreach ($aDados as $aD) {

  $aErroPcasp = array();
  $aErroOrcamento = array();

   $erro = 0;
   
    $rsResult_pcasp = db_query("select c60_codcon 
   							from conplano WHERE c60_estrut = '{$aD['codpcasp']}' and c60_anousu = ".db_getsession('DB_anousu'));
	
          	if (pg_num_rows($rsResult_pcasp) > 0) {
            		for($x = 0; $x< pg_num_rows($rsResult_pcasp);$x++){
        						$linha = pg_fetch_object($rsResult_pcasp,$x);
        						$oDadosDb['codpcasp'] = $linha->c60_codcon;
            		}
                
            } else {
				 $aErroPcasp['estrutural'] = $aD['codpcasp'];
              	 $aErroPcasp['descricao']  = $aD['descpcasp'];
                 $aErroPcaspAgrupado[]     = $aErroPcasp;
      	    		 $erro = 1;
            }
            
   $rsResult_planoroc = db_query("select c60_codcon 
   						from conplanoorcamento WHERE c60_estrut = '{$aD['planoorc']}' and c60_anousu = ".db_getsession('DB_anousu'));
	
          	if (pg_num_rows($rsResult_planoroc) > 0) {
          		for($i = 0; $i< pg_num_rows($rsResult_planoroc);$i++){
						$linha = pg_fetch_object($rsResult_planoroc,$i);
						$oDadosDb['planoorc'] = $linha->c60_codcon;
          		}
                
            } else {
	    		$aErroOrcamento['estrutural'] = $aD['planoorc'];
	    		$$aErroOrcamento['descricao'] = $aD['descplano'];
                $aErroOrcamentoAgrupado[]=$aErroOrcamento;
	    		$erro = 1;
            }
            
    		if($erro == 0){
	    		$sSql_insert = "INSERT INTO conplanoconplanoorcamento (c72_sequencial,c72_conplano,c72_conplanoorcamento,c72_anousu) 
					VALUES (nextval('conplanoconplanoorcamento_c72_sequencial_seq'),
                            {$oDadosDb['codpcasp']},{$oDadosDb['planoorc']},".db_getsession('DB_anousu').")";
	            db_query($sSql_insert);

    		}
}

$sErrorMessage =" Fim Configuração de Vinculações do PCASP!!";


db_redireciona("pcasp001.php?lErro=true&sErrorMessage=".$sErrorMessage."&pcasp=".$aErroPcaspAgrupado."&orcamento=".$aErroOrcamentoAgrupado);
	
	
