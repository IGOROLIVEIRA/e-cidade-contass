<?

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_utils.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("std/db_stdClass.php");


$objJSON    = new services_json();
//$oParam   = $objJSON->decode(db_stdClass::db_stripTagsJson(str_replace("\\","",$_POST["json"])));
//$oParam   = $objJSON->decode(str_replace("\\","",$_POST["json"]));
//echo "tt".$oParam;exit;
/*print_r($oParam);
if(empty($oParam)){ echo "passou";exit;*/
	$oParam =json_decode(stripslashes($_POST["json"]), true);	
//}

//print_r($oParam);exit;
/*$jsonObj =$objJSON->decode($_POST["json"]);
$teste = $jsonObj->arquivo;*/
//print_r($value);exit;
//$oParam   = $objJSON->decode($_POST["json"], JSON_FORCE_OBJECT);


//echo $_POST["json"];exit;

//print_r($oParam);exit;
//$oParam= (object)$oParam;
 
foreach ($oParam as $chave){
	foreach ($chave as $arr){
		//print_r($arr);exit;
		$arr= (object)$arr;
	//	$arr->idprint_r($arr);exit;
	//echo $arr->autenticacao;exit;
	$arr->autenticacao;
//	$arr->id;
	$arr->conciliacao;
 	$arr->tipopendencia;
	$arr->datapendenciaextrato;
 	$arr->credito;
	$arr->debito;
	$arr->alterou;
	$arr->datapend;
	$arr->sequencialpe;
	$arr->insertaltera;
	//echo $arr->id;exit;
	//print_r($arr->id);exit;
//	echo $arr->id;exit;
	$teste=0;
	$data=implode("-",array_reverse(explode("/", $arr->datapend)));
	$data= str_replace(" ", "",$data);

	$search=array('.',',');
	$replace=array('','.');

	$debito= str_replace($search, $replace, $arr->debito);
	$debito= str_replace(" ", "",$debito);
//print_r($arr->id);exit;
/*
 * SE o alterar for igual a true , então deverá reailizar as alterações nas tabelas da pendência.///fazer uma consulta para verificar se ja existe uma  pendencia  se já existir nao inserir de novo se nao inserir 
 */

if($arr->insertaltera=='true')
{ //echo "passou1";exit;
        if($arr->tipopendencia==1 || $arr->tipopendencia==2)
		{  	       
		    $sql= "  DELETE FROM   concmanupendecaixa  WHERE k201_autenticacao=$arr->autenticacao AND k201_conciliacao=$arr->conciliacao AND k201_tipopendencia=$arr->sequencialpe AND k201_datapendencia='$data';    ";
		    $result = db_query($sql);	
		     if($result==true){
						echo '3|||'.$objJSON->encode(true);
					}
		}//teste
		else
		{
	       	$sql= "   DELETE FROM   concmanupendeextrato WHERE k200_conciliacao=$arr->conciliacao AND k200_datapendencia='$data';      "; 
	       	$result = db_query($sql);	
	       	 if($result==true){
						echo '3|||'.$objJSON->encode(true);
					}
		}	
	//	echo "pasou";exit;
				if($arr->tipopendencia==1 || $arr->tipopendencia==2)
				{  
					$sql= " SELECT k201_tipopendencia FROM concmanupendecaixa WHERE k201_datapendencia='$data' AND k201_conciliacao=$arr->conciliacao AND k201_tipopendencia=$arr->sequencialpe";

					$result = db_query($sql);
					$row=pg_num_rows($result);
				    if($row==0){
					    $result = db_query("select nextval ('cai_concmanupendecaixa_k201_sequencial_seq')");
				       	$sequencialcaixa= pg_result($result,0,0);
				       	    $sql= "INSERT INTO concmanupendecaixa(k201_sequencial,k201_datapendencia,k201_conciliacao,k201_tipopendencia,k201_tipo) VALUES($sequencialcaixa,'$data',$arr->conciliacao,$arr->sequencialpe,1)";     
					    //$sql= "INSERT INTO concmanupendecaixa(k201_sequencial,k201_datapendencia,k201_conciliacao,k201_tipopendencia,k201_tipo) VALUES($sequencialcaixa,'$data',$arr->conciliacao,$arr->id,1)";
					    $result5 = db_query($sql);
					    
					    $sql="UPDATE conciliacao SET k199_status=1 WHERE k199_sequencial= $arr->conciliacao";
					    $result = db_query($sql);
				    }	
				  if($result5==true){
						echo '3|||'.$objJSON->encode(true);
					}
				    	
				}
				else
				{
					$sql= "SELECT k200_conciliacao FROM concmanupendeextrato WHERE k200_datapendencia='$data' AND k200_valor=$debito AND k200_autenticacao=$arr->autenticacao";
					//echo $sql;exit;
					$result = db_query($sql);
					$row=pg_num_rows($result);
					//if($arr->insertaltera=='true')
					if($row==0  && $arr->insertaltera=='false'){
					
					$result = db_query("select nextval ('cai_concmanupendeextrato_k200_sequencial_seq')");
			       	$sequencialextrato= pg_result($result,0,0);
			      
				 	$sql= "INSERT INTO concmanupendeextrato(k200_sequencial,k200_conciliacao,k200_datapendencia,k200_valor,k200_descricao,k200_tipopendencia,k200_autenticacao,k200_id) VALUES($sequencialextrato,$arr->conciliacao,'$data',$debito,'',1,$arr->autenticacao,$arr->sequencialpe)";
		
				 	$result6 = db_query($sql);
					
				 	$sql="UPDATE conciliacao SET k199_status=1 WHERE k199_sequencial= $arr->conciliacao";
				        $result = db_query($sql);
					}  
						if($result6==true){
							echo '3|||'.$objJSON->encode(true);
						}
				}
//echo "passou teste e tereeeeeeeeeeeeeeee";exit;
}
else{
	if($arr->alterou=='true')
	{
		 if($arr->tipopendencia==1 || $arr->tipopendencia==2)
		 {

					$sql= " SELECT k201_tipopendencia FROM concmanupendecaixa WHERE k201_datapendencia='$data' AND k201_conciliacao=$arr->conciliacao AND k201_tipopendencia=$arr->sequencialpe";

					$result = db_query($sql);
					$row=pg_num_rows($result);
				    if($row==0){
				    $result = db_query("select nextval ('cai_concmanupendecaixa_k201_sequencial_seq')");
			       	$sequencialcaixa= pg_result($result,0,0);
			       	       
				    $sql= "INSERT INTO concmanupendecaixa(k201_sequencial,k201_datapendencia,k201_conciliacao,k201_tipopendencia,k201_tipo) VALUES($sequencialcaixa,'$data',$arr->conciliacao,$arr->sequencialpe,1)";
				    $result3 = db_query($sql);
				    
				    $sql="UPDATE conciliacao SET k199_status=1 WHERE k199_sequencial= $arr->conciliacao";
				    $result = db_query($sql);
			}
			 if($result3==true){
				echo '3|||'.$objJSON->encode(true);
			}		   
		  }
		  else
		  {
					$sql= "SELECT k200_conciliacao FROM concmanupendeextrato WHERE k200_datapendencia='$data' AND k200_valor=$debito AND k200_autenticacao=$arr->autenticacao";
					
					$result = db_query($sql);
					$row=pg_num_rows($result);
					
					if($row==0){
					    $result = db_query("select nextval ('cai_concmanupendeextrato_k200_sequencial_seq')");
				       	$sequencialextrato= pg_result($result,0,0);
				      
					 	$sql= "INSERT INTO concmanupendeextrato(k200_sequencial,k200_conciliacao,k200_datapendencia,k200_valor,k200_descricao,k200_tipopendencia,k200_autenticacao,k200_id) VALUES($sequencialextrato,$arr->conciliacao,'$data',$debito,'',1,$arr->autenticacao,$arr->sequencialpe)"; 
		
					 	$result4 = db_query($sql);
						
					 	$sql="UPDATE conciliacao SET k199_status=1 WHERE k199_sequencial= $arr->conciliacao";
					    $result = db_query($sql);
					}
					 if($result4==true){
							echo '3|||'.$objJSON->encode(true);
						}
		  }
	 }
	 else 
	 {
	 /*
	   * Esse bloco de código, serve para o momento da inserção das pendencias no menu INSERIR e nao alterar nem excluir
	   */

			   /*
				* É verificado para qual tabela deverá ser inserida a pendência. Se é no caixa ou no extrato; 
				*/
				if($arr->tipopendencia==1 || $arr->tipopendencia==2)
				{
					$sql= " SELECT k201_tipopendencia FROM concmanupendecaixa WHERE k201_datapendencia='$data' AND k201_conciliacao=$arr->conciliacao AND k201_tipopendencia=$arr->sequencialpe";

					$result = db_query($sql);
					$row=pg_num_rows($result);
				    if($row==0){
					    $result = db_query("select nextval ('cai_concmanupendecaixa_k201_sequencial_seq')");
				       	$sequencialcaixa= pg_result($result,0,0);
				       	    $sql= "INSERT INTO concmanupendecaixa(k201_sequencial,k201_datapendencia,k201_conciliacao,k201_tipopendencia,k201_tipo) VALUES($sequencialcaixa,'$data',$arr->conciliacao,$arr->sequencialpe,1)";     
					    //$sql= "INSERT INTO concmanupendecaixa(k201_sequencial,k201_datapendencia,k201_conciliacao,k201_tipopendencia,k201_tipo) VALUES($sequencialcaixa,'$data',$arr->conciliacao,$arr->id,1)";
					    $result5 = db_query($sql);
					    $sql="UPDATE conciliacao SET k199_status=1 WHERE k199_sequencial= $arr->conciliacao";
					    $result = db_query($sql);
				    }	
				   if($result5==true){
						echo '3|||'.$objJSON->encode(true);
					}
				    	
				}
				else
				{    
					$sql= "SELECT k200_conciliacao FROM concmanupendeextrato WHERE k200_datapendencia='$data' AND k200_valor=$debito AND k200_autenticacao=$arr->autenticacao";
					//echo $sql;exit;
					$result = db_query($sql);
					$row=pg_num_rows($result);
					
					if($row==0){
					
					$result = db_query("select nextval ('cai_concmanupendeextrato_k200_sequencial_seq')");
			       	$sequencialextrato= pg_result($result,0,0);
			      
				 	$sql= "INSERT INTO concmanupendeextrato(k200_sequencial,k200_conciliacao,k200_datapendencia,k200_valor,k200_descricao,k200_tipopendencia,k200_autenticacao,k200_id) VALUES($sequencialextrato,$arr->conciliacao,'$data',$debito,'',1,$arr->autenticacao,$arr->sequencialpe)";
							   // echo $sql;exit;
				 	
				 	$result = db_query($sql);
					
				 	$sql="UPDATE conciliacao SET k199_status=1 WHERE k199_sequencial= $arr->conciliacao";
				        $result = db_query($sql);
					}  
						if($result==true){
							echo '3|||'.$objJSON->encode(true);
						}
				}
		  }
	  }
   }
}
//echo '3|||'.$objJSON->encode(true);

//echo "<script>verificaChecks(5);</script>";
//echo $insert=true;
//$insert=true;

//echo 'insert'.$objJSON->encode($insert);

//echo "ate".$arr->alterou;exit;


	//exit;
?>
