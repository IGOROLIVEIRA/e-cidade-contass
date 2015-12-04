<?
require("libs/db_conn.php");
include("dbforms/db_classesgenericas.php");
$cldb_estrut = new cl_db_estrut;
if(!($conn = @pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))) {
  echo "Não conectou!"; 
  exit;
}

/*incluir na tabela a partir de um array
$arr0 =  array ("codigo"=>"1","descr"=>"ze","obs"=>"ob");
$arr = pg_convert ( $conn, 'ze', $arr0);
print_r($arr);
pg_copy_from($conn,'ze',$arr) or die('falhou');
die('ok');
*/


$mascara = "1.0.0.0.0.00.00.00.0000";

function php_verifica_mae($fonte,$proces=0){
  $proces++;
    global $mascara,$cldb_estrut;
    
    //rotina que atualiza as propriedades $cldb_estrut->nivel com o numero do nivel da fonte e a
    //    $cldb_estrut->mae com a mae da fonte
    $cldb_estrut->db_nivel($fonte,$mascara,false);
  

    //rotina que verifica o nivel da fonte
    if($cldb_estrut->nivel==1){
      echo "\n\n\nconta mae eh ".$fonte;
      $sql = " select c60_estrut from conplano where c60_estrut='".$fonte."'" ;
      $result =  pg_query($sql);
      $numrows = pg_numrows($result);
    }
    
    //rotina que verifica se a fonte já não foi incluida 
    $sql = " select c60_estrut from conplano where c60_estrut='".$fonte."'" ;
    $result =  pg_query($sql);
    $numrows = pg_numrows($result);
    if($numrows>0){
      echo "\nFonte $fonte já incluida..";
      return true;
    }


    
    $sql = " select c60_estrut from conplano where c60_estrut='".$cldb_estrut->mae."'" ;
    $result =  pg_query($sql);
    $numrows = pg_numrows($result);
    if($numrows>0){
      echo " Tem mae... \n";
    }else{
     echo "Naum Tem mae $fonte... \n";
      $mae = $cldb_estrut->mae;
      php_verifica_mae(1,$mae);
    }


    //rotina que inclui no conplano
    $sql = " select * from cadcontas where o57_fonte ='$fonte'" ;
    $result = @pg_query($sql);
    $numrows = @pg_numrows($result);
    if($numrows==0){
      echo "Fonte $fonte não existe na tabela cadcontas";
    }else{
       $result01 = @pg_query("select nextval('conplano_c60_codcon_seq') as codcon"); 
       $codcon   =  pg_result($result01,0,"codcon");
       
       $fonte    =  pg_result($result,0,"o57_fonte");
       $descr    =  pg_result($result,0,"o57_descr");
       $finali   =  pg_result($result,0,"o57_finali");
       $codsis   =  pg_result($result,0,"c60_codsis");
       $codcla   =  pg_result($result,0,"c60_codcla");

       $sql = "insert into conplano(
                                       c60_codcon 
                                      ,c60_estrut 
                                      ,c60_descr 
                                      ,c60_finali 
                                      ,c60_codsis 
                                      ,c60_codcla 
				      
                       )
                values (
                                $codcon 
                               ,'$fonte' 
                               ,'$descr' 
                               ,'$finali' 
                               ,'$codsis' 
                               ,'$codcla' 
                      )";
      $result = @pg_query($sql); 
      if($result==false){ 
	echo "Inclusão não efetuada\n";
       echo  @pg_last_error()."\n\n";
      }else{
        echo "fonte $fonte incluida";
      } 
     
      //rotina que inclui no conplanoreduz
	  // - pega c61_reduz
	    $result22 =pg_query("select nextval('conplanoreduz_c61_reduz_seq') as c61_reduz"); 
            $c61_reduz  =  pg_result($result22,0,"c61_reduz");
	  //fim
      

	   $sql = "insert into conplanoreduz(
					     c61_codcon 
					    ,c61_reduz 
					    ,c61_instit 
					    ,c61_codigo 
			     )
		      values (
				      $codcon 
				     ,$c61_reduz 
				     ,1 
				     ,1 
			    )";
	    $result = @pg_query($sql); 
	    if($result==false){ 
	      echo "Inclusão não efetuada\n";
	     echo  @pg_last_error()."\n\n";
	    }else{
	      echo "fonte $fonte incluida";
	    } 
      //final 	    

      //rotina que inclui na tabela conplanoexe
        $sql = "insert into conplanoexe(
                                       c62_anousu 
                                      ,c62_reduz 
                                      ,c62_codrec 
                                      ,c62_vlrcre 
                                      ,c62_vlrdeb 
                       )
                values (
                                2005 
                               ,$c61_reduz 
                               ,1 
                               ,0 
                               ,0 
                      )";

      
	    $result = @pg_query($sql); 
	    if($result==false){ 
	      echo "Inclusão não efetuada\n";
	     echo  @pg_last_error()."\n\n";
	    }else{
	      echo "fonte $fonte incluida";
	    } 
      //final 	    

    }

}
$result = pg_query("select * from cadcontas ");
$numrows = pg_num_rows($result);
for($i=0; $i<$numrows; $i++){
  $fonte   =  pg_result($result,$i,"o57_fonte");
  php_verifica_mae($fonte);
  
} 
?>
