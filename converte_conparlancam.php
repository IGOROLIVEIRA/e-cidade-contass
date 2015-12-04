<?
$conn = pg_connect("dbname=base_alegrete  user=postgres host=192.168.1.15");

//////////////funcoes/////////////////
// 1-
// 2- liquidação despesa corrente e capital
// 3- pagamento 
// 4-
//////////////////////////////////////
$funcao = x;
/////////////////////////////////////

if($funcao==1){
    // rotina que incluir os debitos de tipo de compra
    // empenho por modalidades de licitação           
    // $arr_debito = array(299,300,301,302,303,304,305,306,307,308);
    // $arr_debito = array(719,720,721,722,723,724,725,726,727,728);
    $arr_credito = array(338,339,340,341,342,343,344,345,346,347);
    $arr_debito = array(348,349,350,351,352,353,354,355,356,357);

    //$arr_credito = array(299,300,301,302,303,304,305,306,307,308);
    //
   // for($i=0; $i<count($arr_credito); $i++){
   for($i=0; $i<count($arr_debito); $i++){
        $debito = $arr_debito[$i];      
	$credito = $arr_credito[$i];
	//$debito = 370;
	// $credito  = 370;
        $sequen=47;
        $sql = "insert into contranslr( 
                   c47_seqtranslr,
		   c47_seqtranslan,
		   c47_debito,
		   c47_credito,
		   c47_obs,
		   c47_instit,
		   c47_anousu,
		   c47_ref ) 
   	        values 
		 ( (select nextval('contranslr_c47_seqtranslr_seq')),
		    $sequen,
		    $debito,
		    $credito, 
		    '',
		    1,
		    2005,
		    ".($i+1).")";
		    
	 echo "\n".$sql."\n";		     
	 pg_query($sql);
    }
}else if($funcao==2){    
  //rotina que inclui no contranslr os dados que estavam no comparlancam
  //default codele =  debito   codconpas = credito
  /////////////////// liquidação despesa corrente
             ////////////////////////////////////////
  $sql ="select c61_reduz 
         from conplano 
  	        inner join conplanoreduz on c61_codcon = c60_codcon and c61_instit = " . db_getsession('DB_instit') . "
                                                  and c61_anousu=c60_anousu
	     where c60_anousu = ".db_getsession("DB_anousu")." and c60_estrut like '34%'";

  $result = pg_exec($sql);
  $numrows = pg_numrows($result);
  pg_exec("begin");
  for($i = 0;$i < $numrows;$i++) {
	 //codele    = pg_result($result,$i,"c91_codele");
	 $sequencia= 42;
	 // $debito= pg_result($result,$i,"c61_reduz");
         $credito =  pg_result($result,$i,"c61_reduz");
	 $debito = 246;
	 // $credito = 246;
 	 $instit=1;
	 $anousu=2005;
	 //////////////////-- liq da despesa corrente
         $sql02=" insert into contranslr( 
	                         c47_seqtranslr , 
	                         c47_seqtranslan ,
				 c47_debito ,
				 c47_credito ,
				 c47_obs,
				 c47_instit,
				 c47_anousu,
				 c47_ref )
          	   values(
		     (select nextval('contranslr_c47_seqtranslr_seq')),
		     $sequencia,
		     $debito,
		     $credito,
		     '',
		     $instit,
		     $anousu,
		     0
		   )	 
	       ";
         ////////////////
         $re=pg_exec($sql02);

	 if($re==false){
	   echo 'erro';
	 }else{
	   echo 'ok';
	 }
  }
  pg_exec("commit");
}else if($funcao==3){   
  //PAGAMENTO DE EMPENHO -- PRIMEIRO LANÇAMENTO
  //rotina para pegar os valores dos crédito da liquidação para incluir no débito do pagamento
  //guaiba
  /*
   dados da liquidação
       código do documento = 3
       codigo da transação = 7 
       sequencia           = 3 
*/

/*       
   dados do estorno pagamento
       código do documento = 6
       codigo da transação = 11
       sequencia           = 32 
  
   */
   pg_exec("begin");
  
   $sqlerro=false;
   //$seqtranslan = 67;    //considerar corrente e capital 
   $seqtranslan = 3;
   $sql = "select c47_credito from contranslr where c47_instit = " . db_getsession('DB_instit') . " and c47_seqtranslan= $seqtranslan  ";
   $result = pg_exec($sql);
   $numrows = pg_numrows($result);
   pg_exec("begin");

   $sequencia = 32;
   $instit = 1;
   $anousu = 2005;
   for($i = 0;$i < $numrows;$i++) {
	 
	 $credito = pg_result($result,$i,"c47_credito");

     
         $sql02=" insert into contranslr( 
	                         c47_seqtranslr , 
	                         c47_seqtranslan ,
				 c47_debito ,
				 c47_credito ,
				 c47_obs,
				 c47_instit,
				 c47_anousu,
				 c47_ref )
          	   values(
		     (select nextval('contranslr_c47_seqtranslr_seq')),
		     $sequencia,
		     $credito,
		     0,
		     '',
		     $instit,
		     $anousu,
		     0
		   )	 
	       ";
         $re=pg_exec($sql02);
	 if($re==false){
	   echo 'erro';
	   $sqlerro=true;
	   break;
	 }else{
	   echo 'ok';
	 }


   }
   if($sqlerro==false){
      pg_exec("commit");
   }else{
      pg_exec("rollback");
   }

  
}else if($funcao==4){   
  //ESTORNO DE PAGAMENTO PRIMEIRO LANÇAMENTO 
  //rotina para pegar os valores dos crédito da liquidação para incluir no débito do pagamento
  //guaiba
  /*
   dados da liquidação
       código do documento = 3
       codigo da transação = 7 
       sequencia           = 3 
*/
/*
   dados do pagamento
       código do documento = 5
       codigo da transação = 10 
       sequencia           = 30 
   
  
   */

  pg_exec("begin");

   
   $sqlerro=false;
   $seqtranslan=67;   // lançamentos de capital 
   // $seqtranslan=3;    // lançamentos de corrente
   $sequencia = 32;   
   $sql = "select c47_credito from contranslr where c47_instit = " . db_getsession('DB_instit') . " and c47_seqtranslan= $seqtranslan ";
   $result = pg_exec($sql);
   $numrows = pg_numrows($result);
   pg_exec("begin");
   $instit = 1;
   $anousu = 2005;
   echo $numrows;
   for($i = 0;$i < $numrows;$i++) {
	
	 $debito  = 0;
	 $credito = pg_result($result,$i,"c47_credito");

     
         $sql02=" insert into contranslr( 
	                         c47_seqtranslr , 
	                         c47_seqtranslan ,
				 c47_debito ,
				 c47_credito ,
				 c47_obs,
				 c47_instit,
				 c47_anousu,
				 c47_ref )
          	   values(
		     (select nextval('contranslr_c47_seqtranslr_seq')),
		     $sequencia,
		     $debito,
		     $credito,
		     '',
		     $instit,
		     $anousu,
		     0
		   )	 
	       ";
         $re=pg_exec($sql02);
	 if($re==false){
	   echo 'erro';
	   $sqlerro=true;
	   break;
	 }else{
	   echo 'ok--';
	 }


   }
   if($sqlerro==false){
     pg_exec("commit");
   }else{
      pg_exec("rollback");
   }

  
}
?>
