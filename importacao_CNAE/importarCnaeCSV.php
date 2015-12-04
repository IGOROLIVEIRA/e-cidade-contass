<?php
  require_once 'class.conexao.php';
?>
 <form name="form" method="POST" enctype="multipart/form-data">
<html>
<body>

<pre>
Servidor:    <input type="text" id="Server" name="Server"><br>
Base:        <input type="text" id="Base" name="Base"><br>
Porta:       <input type="text" id="Porta" name="Porta"><br>
Usuario:     <input type="text" id="Usuario" name="Usuario"><br>
Senha:       <input type="password" id="Senha" name="Senha"><br>

Arquivo CSV: <input type="file" name="arquivo" id="arquivo" >
        
             <input type="button" value="Enviar" onclick="js_valida()">

</pre>


 </body>


</form>

</html>
<script>



  function js_valida() {
    
    if (document.form.arquivo.value == '') {
      alert("Nenhum arquivo informado!");
      return false; 
    }
    
    document.form.submit();
  }
</script>

<?php



//print_r($_POST);

if ((isset($_POST['Server']) && $_POST['Server'] != '')    &&
   (isset($_POST['Base'])    && $_POST['Base'] != '')      &&
   (isset($_POST['Usuario']) && $_POST['Usuario'] != '')   &&
   (isset($_POST['Porta'])   && $_POST['Porta'] != '')) {
 
	echo $_POST['Server'] . ' ' .$_POST['Base'] .  '   ' .$_POST['Porta']. ' ' . $_POST['Usuario'];

 $DB_SERVIDOR = $_POST['Server']; //"192.168.0.25";
 $DB_BASE     = $_POST['Base'];   //"auto_guaiba_20110407_v2_2_51";
 $DB_PORTA    = $_POST['Porta'];  //"5432";
 $DB_USUARIO  = $_POST['Usuario'];//"postgres";
 $DB_SENHA    = $_POST['Senha'];  //"";

}


 $iCont=0; 
 $iUpd =0;
 $iIns =0;
 
 if( isset($_FILES["arquivo"]) ){
 
// 	  echo "<pre>";
//    print_r( file($_FILES["arquivo"]["tmp_name"]));
//    echo "</pre>";
 	
 	/*
 	 * busca registros das tabelas cnae e cnaeanalitica
 	 */
 	  if (!($conn = @pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))) {
     echo "Erro ao conectar com a base de dados";
     exit;
   }
  
   /*
    * inicia sessão
    */
   $sSqlSession = "select fc_startsession()";
   pg_query($sSqlSession);

   /*
    * seta valor de sequence cnae
    */
   $sSqlSeqCnae = "select max(q71_sequencial) as q71_sequencial from cnae";
   $rsSeq       = pg_query($sSqlSeqCnae);
   while ( $iSeqCnae = pg_fetch_assoc($rsSeq) ){
   	$iSeq = $iSeqCnae['q71_sequencial'];
   } 
   $iSeq++;
   pg_query("ALTER SEQUENCE cnae_q71_sequencial_seq RESTART with $iSeq");
   
   
   /*
    * seta valor de sequence para cnaenalitica
    */
   $sSqlSeqCnaeanalitica = "select max(q72_sequencial) as q72_sequencial from cnaeanalitica";
   $rsSeqanalitica       = pg_query($sSqlSeqCnaeanalitica);
   while ( $iSeqCnaeanalitica = pg_fetch_assoc($rsSeqanalitica) ){
    $iSeqanalitica = $iSeqCnaeanalitica['q72_sequencial'];
   } 
   $iSeqanalitica++;
   pg_query("ALTER SEQUENCE cnaeanalitica_q72_sequencial_seq RESTART with $iSeqanalitica");
   
   /*
    * inicia tranasação
    */
   pg_query("Begin");
   
  /*
   * inicia variavel fora do for // sera alterada apenas com um novo valor
   */
  $sClasse = '';    
   
  foreach( file($_FILES["arquivo"]["tmp_name"]) as $slinha ){

 	  //inicia variaveis dentro do for para limpar o conteudo a cada volta do laço
    $sEstrutural = '';
    $sDescri     = '';
 	 
    //indentifica linha da sessao e passa valor para variavel   
    if( substr(trim($slinha), 1, 5) == 'Seção' ){
        //echo 'valor  <br>'. substr($slinha, 1, 5);
        $sClasse = str_replace('-','',str_replace(',','',str_replace('"','',$slinha) ) );   
        $sClasse = substr(trim($sClasse), 5, 3);
    
    
	 //senão é sessao filtra caracteres especiais e concatena valores 
	 } else {
	 	
	 	 $sEst_Desc   = str_replace('"','', str_replace('/','', str_replace(',','',$slinha) ) );
	 	 $sEstrutural = str_replace('-','', substr( trim($sEst_Desc), 0, 8));
	   $sDescri     = substr($sEst_Desc, 8, strlen($sEst_Desc));
	 }
	 
	      
	 
	    $sEstrutural = trim($sClasse) . trim($sEstrutural);
	    $sDescri;
	
	    
	    if ( ( $sEstrutural != $sClasse ) && ($sDescri != '') && ( strlen($sEstrutural) <= 8 ) ){
	    	$iCont++; 
	    	//print $sEstrutural.' '.$sDescri;
	    	 //print '<br>';
          
	    	/*
	    	 * para cada laço do foreach testa (procura) se existe o codigo estrutural na tabela cnae
	    	 */
	    	  $sSqlCnaeWhere     = "select * from cnae where q71_estrutural = '$sEstrutural' ";
	    	  $rsResultCnaeWhere = pg_query($sSqlCnaeWhere);    	  
	    	  $numrows           = pg_num_rows($rsResultCnaeWhere); 
	    	  
	    	  if( $numrows > 0){  

	    	  	$iUpd++;
	    	  	
	    	     while ( $sLinha = pg_fetch_assoc($rsResultCnaeWhere) ){
          
               $sSqlCnaeAtualiza = "update cnae
                                       set q71_descr  = '$sDescri' 
                                      where 
                                       q71_estrutural = '$sEstrutural'
                                   ";
               //echo $sSqlCnaeAtualiza .'<br>';       
               $rsSqlErro =  pg_query($sSqlCnaeAtualiza);
                                     
	    	     }

	    	  } else {
          	    $iIns++; 
	    	  	
                /*
                 * insere na cnae
                 */
		          	$sSqlCnaeInsere = "insert into cnae (q71_sequencial, q71_estrutural, q71_descr) 
		          	                                      values
		          	                                    (nextval('cnae_q71_sequencial_seq'), '$sEstrutural', '$sDescri')";
		            // echo '<br><br>'. $sSqlCnaeInsere;
		            $rsSqlErro = pg_query($sSqlCnaeInsere);
		
		            
				    	  /*
				    	   *  pega o sequencial do registro inserido na cnae
				    	   */
			          $rsSeqAna = pg_query("select max(q71_sequencial) as q71_sequencial from cnae");
			          while ($sSeq = pg_fetch_assoc($rsSeqAna)){
			          	$iLastSeqCnae = $sSeq['q71_sequencial'];           
			          } 

			          /*
			           * insere na cnaeanalitica
			           */
                $sSqlCnaeanaliticaInsere = "insert into cnaeanalitica( q72_sequencial, q72_cnae)
		                                                                    values
		                                                                  (nextval('cnaeanalitica_q72_sequencial_seq'), $iLastSeqCnae )" ;
		             echo $iLastSeqCnae . ' - ' . $sEstrutural .'  '.$sDescri . '<br>';                                                               
                //echo $sSqlCnaeanaliticaInsere . '<br>';
		            $rsSqlErro = pg_query($sSqlCnaeanaliticaInsere);
           
       }//fim de insert
        
	    	
	   }//fim teste se insert ou update
	    
     
}

     if (!$rsSqlErro) {
         echo "ERRO executando sql: {$rsSqlErro}. Erro: ".pg_last_error()."<br>";
         pg_query("rollback");
         echo "<script> alert('Erro durante a importaÃ§Ã£o do arquivo!'); </script>";
     } else {
          pg_query("commit");
         echo "<script> alert('importaÃ§Ã£o do arquivo completa!'); </script>";
     }
    
     echo 'Verificados = '.$iCont.'<br>'; 
     echo 'Atualizados = '.$iUpd .'<br>';
     echo 'Inseridos   = '.$iIns .'<br>';
     $total = $iUpd + $iIns;
     echo 'total       = '. $total.'<br>';  
    
 
}
 

 

?>
