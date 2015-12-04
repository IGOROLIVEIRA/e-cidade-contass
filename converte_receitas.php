<?
$conn = pg_connect("dbname=guaiba_2602  user=postgres host=192.168.1.15");

//////////////funcoes/////////////////
/*
  insere todos os reduzidos da receita nas transações 
  de receita e estorno de receita 
  
*/
//////////////////////////////////////
$funcao = 1;
$instit = 1;
/////////////////////////////////////

//if($funcao==1){
  $sequencia= 66; // alegrete
  $sequencia= 64; // guaiba

  $result = pg_exec("delete from contranslr where c47_seqtranslan = $sequencia");

  $sql ="select c61_reduz 
         from conplano 
  	         inner join conplanoreduz on c61_codcon = c60_codcon and c61_anousu=c60_anousu
	     where c61_instit = $instit and c60_estrut like '4%'";

  $result = pg_exec($sql);
  $numrows = pg_numrows($result);
//  pg_exec("begin");
  for($i = 0;$i < $numrows;$i++) {
         $credito = pg_result($result,$i,"c61_reduz");
	 $debito  = 0; // bancos
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
				 c47_ref,
				 c47_compara)
          	   values(
		     (select nextval('contranslr_c47_seqtranslr_seq')),
		     $sequencia,
		     $debito,
		     $credito,
		     '',
		     $instit,
		     $anousu,
		     0,
		     2
		   )	 
	       ";
         ////////////////
         $re=pg_exec($sql02);
	 if($re==false){
	   echo 'erro problema na sequencia';
	 }else{
	   echo 'ok';
	 }
  }
//  pg_exec("commit");
//}


// estorno de arrecadacao
//if($funcao==2){
  $sequencia= 83; // alegrete
  $sequencia= 65; // guaiba

  $result = pg_exec("delete from contranslr where c47_seqtranslan = $sequencia");
  
  $sql ="select c61_reduz 
         from conplano 
  	     inner join conplanoreduz on c61_codcon = c60_codcon and c61_instit = " . db_getsession("DB_instit") . "
	 where c60_estrut like '4%'";

  $result = pg_exec($sql);
  $numrows = pg_numrows($result);
  pg_exec("begin");
  for($i = 0;$i < $numrows;$i++) {
	 $debito  = pg_result($result,$i,"c61_reduz");
         $credito = 0; // caixa/banco
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
				 c47_ref,
				 c47_compara)
          	   values(
		     (select nextval('contranslr_c47_seqtranslr_seq')),
		     $sequencia,
		     $debito,
		     $credito,
		     '',
		     $instit,
		     $anousu,
		     0,
		     1
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
//}


?>
