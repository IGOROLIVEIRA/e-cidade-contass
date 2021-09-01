<?php
require_once(__DIR__ . "/../libs/db_conn.php");
	
	$sNomeArquivo = "pregao";
	$iSeqPregao = $_GET["pregao"];
	
    //arquivo 
    $nomeArquivo= $sNomeArquivo;
    /*
     * DADOS PARA CONEXAO
     */
    $db = $DB_BASE;
    $dbport = $DB_PORTA;
    
    $conexao_postgre = pg_connect("host=localhost port='".$dbport."' dbname='".$db."' user=dbportal password=") 
    or die("Não foi possível conectar ao Banco de dados.");
    /*
     * PEGA OS DADOS DO PREGAO
     */
    $rsResult = pg_query($conexao_postgre, "SELECT fc_startsession()");
    $sql = "select l20_tipojulg, l20_codigo, 
                l20_numero, l20_edital, l20_dataaber, l20_objeto, 
                 date_part('YEAR',l20_dataaber) as ano
                from licitacao.liclicita 
                join licitacao.cflicita on l20_codtipocom = l03_codigo and l03_tipo = 'P' 
                 where l20_licsituacao = 0
                 and l20_codigo = ".$iSeqPregao;

   $rsResultPregao = pg_query($conexao_postgre, $sql);
   
   if(pg_num_rows($rsResultPregao) > 0){
   	
	   
	 
	   $oPregao = array();
	   
	  
	   $aDadosPregao = array();
	   
	   for($y = 0; $y< pg_num_rows($rsResultPregao);$y++){
	   		
	   	    $linha = pg_fetch_object($rsResultPregao,$y);
	
			$oPregao['l20_tipojulg'] = $linha->l20_tipojulg;
	  		$oPregao['l20_codigo']   = $linha->l20_codigo;
	   		$oPregao['l20_numero']   = $linha->l20_numero;
	   		$oPregao['l20_edital']   = $linha->l20_edital;
	   		$oPregao['l20_dataaber'] = $linha->l20_dataaber;
	        $oPregao['l20_objeto']   = $linha->l20_objeto;
	        $oPregao['ano']          = $linha->ano;
	        
	        $aDadosPregao[] = $oPregao;
	
	   }
	   /*
	    * PEGAR OS ITENS DO PREGÃO
	    */
	    $sqlItens = "select pc01_codmater, 
                 pc01_descrmater,
                 pc01_complmater,
                 l04_descricao , 
                 sum(pc11_quant) as qtde, 
                 max(pc11_vlrun) as valor, 
                 avg(pc11_vlrun) as valormedio 
                 from licitacao.liclicita 
                        join licitacao.liclicitem on l20_codigo = l21_codliclicita 
                        join compras.pcprocitem on l21_codpcprocitem = pc81_codprocitem 
                        join compras.solicitem on pc81_solicitem = pc11_codigo 
                        join compras.solicitempcmater on pc16_solicitem = pc11_codigo 
                        join compras.pcmater on pc16_codmater = pc01_codmater 
                        left join licitacao.liclicitemlote on l04_liclicitem = l21_codigo 
                  where l21_codliclicita = ".$iSeqPregao."
                 group by pc01_codmater, 
                 pc01_descrmater, 
                 pc01_complmater,
                 l04_descricao";
       
       $rsResultPregaoItem = pg_query($conexao_postgre, $sqlItens);
       
       
       for($x = 0; $x< pg_num_rows($rsResultPregaoItem);$x++){
	   		
	   	    $linha1 = pg_fetch_object($rsResultPregaoItem,$x);
			$oPregao = array();
			$oPregao['pc01_codmater']   = $linha1->pc01_codmater;
	  		$oPregao['pc01_descrmater'] = $linha1->pc01_descrmater;
	   		$oPregao['pc01_complmater'] = $linha1->pc01_complmater;
	   		$oPregao['l04_descricao']   = $linha1->l04_descricao;
	   		$oPregao['qtde']            = $linha1->qtde;
	        $oPregao['valor']           = $linha1->valor;
	        $oPregao['valormedio']      = $linha1->valormedio;
	        
	        $aDadosPregao[] = $oPregao;
	
	   }
	  
	   
	  /*
	   * RETORNA UM CSV DIRETAMENTE NO URL 
	   */
	  $cabecalho = 0;
      $delimitador = ';';
      $cerca = '"';
		
	  $f = fopen('php://output', 'w');
	  if ($f) {
		    header('Content-Type: text/csv; charset=UTF-8; header=present');
		    header('Content-Disposition: inline; filename="pregao.csv"');
		    fputcsv($f, $cabecalho, $delimitador, $cerca);
		    foreach ($aDadosPregao as $linha) {
		        fputcsv($f, $linha, $delimitador, $cerca);
		    }
		    fclose($f);
	  }
	  exit(0);
	
   }
?>
