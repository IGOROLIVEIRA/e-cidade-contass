<?php
include 'conexao_oracle.php';
include 'conexao_postgre.php';

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_utils.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("classes/db_matestoque_classe.php");
require_once("classes/db_matestoqueitem_classe.php");
require_once("classes/db_matestoqueini_classe.php");
require_once("classes/db_matestoqueinimei_classe.php");
require_once("classes/db_db_depart_classe.php");
require_once("classes/db_transmater_classe.php");
require_once("classes/db_empempitem_classe.php");
require_once("classes/db_empparametro_classe.php");
require_once("classes/db_matestoqueitemnotafiscalmanual_classe.php");
require_once("dbforms/db_funcoes.php");

$clempparametro     = new cl_empparametro;
$clmatestoque       = new cl_matestoque;
$clmatestoqueitem   = new cl_matestoqueitem;
$clmatestoqueini    = new cl_matestoqueini;
$clmatestoqueinimei = new cl_matestoqueinimei;
$cldb_depart        = new cl_db_depart;
$cltransmater       = new cl_transmater;
$clempempitem       = new cl_empempitem;
$oDaoMatEstoqueItemNotaFiscal = db_utils::getDao("matestoqueitemnotafiscalmanual");

$res_empparametro = $clempparametro->sql_record($clempparametro->sql_query(db_getsession("DB_anousu"),"e30_numdec"));
if ($clempparametro->numrows > 0){
  db_fieldsmemory($res_empparametro,0);
  if (trim($e30_numdec) == "" || $e30_numdec == 0){
    $numdec = 2;
  } else {
    $numdec = $e30_numdec;
  }
} else {
  $numdec = 2;
}

$db_opcao = 1;
$db_botao = true;
$passou=false;


//echo date('H:i:s');exit;

$sql = "SELECT spea.PE_COD_MATERIAL,sm.ID_MATERIAL AS COD_MATERIAL, spea.PE_ANO_ALMOX AS ANO_REFERENCIA, spea.PE_FISICO AS QUANT_ESTOQUE, 
spea.PE_FINANCEIRO AS VL_TOTAL, spea.PE_ALMOX AS ALMOX_CENTRAL
FROM SIGMAT_POSICAO_ESTOQUE_ALMOX spea JOIN SIGMAT_MATERIAL sm ON spea.PE_COD_MATERIAL =  sm.COD_MATERIAL WHERE spea.PE_ANO_ALMOX = 2012 AND spea.PE_ALMOX = 1
AND PE_FISICO > 0 AND PE_FINANCEIRO > 0";

$sql_parse = OCIParse($conexao_oracle,$sql); 
OCIExecute($sql_parse); 
$aDadosAgrupadosOracle = array();
while (OCIFetch($sql_parse)) {
  
  $dados_oracle = array();
  $id_material = explode(".", OCIResult($sql_parse,"COD_MATERIAL"));
	$dados_oracle['COD_MATERIAL']   = $id_material[0].str_pad($id_material[1], 2, "0", STR_PAD_LEFT).str_pad($id_material[2], 2, "0", STR_PAD_LEFT);
	$dados_oracle['ANO_REFERENCIA'] = OCIResult($sql_parse,"ANO_REFERENCIA");
	$dados_oracle['QUANT_ESTOQUE']  = OCIResult($sql_parse,"QUANT_ESTOQUE");
	$dados_oracle['VL_TOTAL']       = str_replace(",", ".", OCIResult($sql_parse,"VL_TOTAL"));
	$dados_oracle['ALMOX_CENTRAL']  = OCIResult($sql_parse,"ALMOX_CENTRAL");
	$aDadosAgrupadosOracle[] = $dados_oracle;

}

$rsResult = pg_query($conexao_postgre, "SELECT fc_startsession();");

foreach ($aDadosAgrupadosOracle as $aDados) {
	
	$m60_codmater = $aDados['COD_MATERIAL'];
	$coddepto     = 1;
	$m71_valor    = $aDados['VL_TOTAL'];
	$m71_quant    = $aDados['QUANT_ESTOQUE'];
	$incluir      = 1;
	$m80_codtipo  = 1;
	$m80_obs      = "Obs";
	//db_postmemory($HTTP_POST_VARS);
$clempparametro     = new cl_empparametro;
$clmatestoque       = new cl_matestoque;
$clmatestoqueitem   = new cl_matestoqueitem;
$clmatestoqueini    = new cl_matestoqueini;
$clmatestoqueinimei = new cl_matestoqueinimei;
$cldb_depart        = new cl_db_depart;
$cltransmater       = new cl_transmater;
$clempempitem       = new cl_empempitem;
$oDaoMatEstoqueItemNotaFiscal = db_utils::getDao("matestoqueitemnotafiscalmanual");	
	
if(isset($incluir)){
	
  if(isset($m60_codmater) && trim($m60_codmater)!=""){
  	
		if ($m71_valor == 0 or $m71_quant == 0) {
			$sqlerro = true;
			echo "Valores zerados!";exit;
		} else {
			$sqlerro = false;
			db_inicio_transacao();
			$result_matestoque = $clmatestoque->sql_record($clmatestoque->sql_query_file(null,"m70_codigo,m70_quant,m70_valor","","m70_codmatmater=$m60_codmater and m70_coddepto=$coddepto"));
			if($clmatestoque->numrows>0){echo "teste";exit;
				db_fieldsmemory($result_matestoque,0);
				$quant = 0;
				$valor = 0;
				$quant = $m70_quant+$m71_quant;
				if ($quant > 0){
					$valor = $m70_valor+$m71_valor;
				}
				$clmatestoque->m70_valor = "$valor";
				$clmatestoque->m70_quant = "$quant";
				$clmatestoque->m70_codigo= $m70_codigo;
				$clmatestoque->alterar($m70_codigo);
				if($clmatestoque->erro_status==0){
					$sqlerro=true;
					echo "Erro sql 1";exit;
				}
				echo $clmatestoque->erro_msg;exit;
			}else{
				$clmatestoque->m70_codmatmater = $m60_codmater;
				$clmatestoque->m70_coddepto    = $coddepto;
				$clmatestoque->m70_valor       = $m71_valor;
				$clmatestoque->m70_quant       = $m71_quant;
				$clmatestoque->incluir(null);
				if($clmatestoque->erro_status==0){
					$sqlerro=true;
					echo "Erro sql 2";exit;
				}
				$m70_codigo = $clmatestoque->m70_codigo;
				$erro_msg   = $clmatestoque->erro_msg;
			}
			if($sqlerro == false){
				$clmatestoqueini->m80_login          = db_getsession("DB_id_usuario");
				$clmatestoqueini->m80_data           = date("Y-m-d",db_getsession("DB_datausu"));
				$clmatestoqueini->m80_hora           = date('H:i:s');
				$clmatestoqueini->m80_obs            = $m80_obs;
				$clmatestoqueini->m80_codtipo        = $m80_codtipo;
				$clmatestoqueini->m80_coddepto       = $coddepto;
				
				/*$rsResult = pg_query($conexao_postgre, "SELECT CASE WHEN max(m80_codigo) IS NULL THEN 0 ELSE max(m80_codigo)+1 END 
	      as max_m80_codigo from matestoqueini");
	      $aCodMaxEstoque = pg_fetch_object($rsResult);*/
				
				$clmatestoqueini->incluir(@$m80_codigo);
				if($clmatestoqueini->erro_status==0){
					$sqlerro=true;
					echo "Erro sql 3".$clmatestoqueini->erro_msg;exit;
				}
				$m82_matestoqueini = $clmatestoqueini->m80_codigo;
				//echo $clmatestoqueini->erro_msg."teste incluir 1";exit;
			}
			if($sqlerro == false){
				if(isset($m70_codigo) && trim($m70_codigo)!=""){	
					$clmatestoqueitem->m71_codmatestoque = $m70_codigo;
					$clmatestoqueitem->m71_data          = date("Y-m-d",db_getsession("DB_datausu"));
					$clmatestoqueitem->m71_valor         = $m71_valor;
					$clmatestoqueitem->m71_quant         = $m71_quant;
					$clmatestoqueitem->m71_quantatend    = '0';
					$clmatestoqueitem->incluir(null);
					if($clmatestoqueitem->erro_status==0){
						$sqlerro=true;
						echo "Erro sql 4";exit;
					}
					$m80_matestoqueitem = $clmatestoqueitem->m71_codlanc;
					//echo $clmatestoqueitem->erro_msg."teste incluir 2";exit;
				}
				
				if (!$sqlerro) {
				  
				  /**
				   * Inclui nota fiscal manual
				   */
				  if (!empty($m79_notafiscal) && !empty($m79_data)) {
				    
  				  $oDaoMatEstoqueItemNotaFiscal->m79_sequencial     = null;
  				  $oDaoMatEstoqueItemNotaFiscal->m79_matestoqueitem = $m80_matestoqueitem;
  				  $oDaoMatEstoqueItemNotaFiscal->m79_notafiscal     = $m79_notafiscal;
  				  $oDaoMatEstoqueItemNotaFiscal->m79_data           = $m79_data;
				    $oDaoMatEstoqueItemNotaFiscal->incluir(null);
				  }
				}
				
				if ($sqlerro == false) {
				  
				  if (trim($m77_lote) != "") {
				    
				    $clmatestoqueitemlote = db_utils::getDao("matestoqueitemlote");
				    $clmatestoqueitemlote->m77_lote = $m77_lote;
				    $clmatestoqueitemlote->m77_dtvalidade = implode("-",array_reverse(explode("/", $m77_dtvalidade)));
				    $clmatestoqueitemlote->m77_matestoqueitem = $m80_matestoqueitem;
				    $clmatestoqueitemlote->incluir(null);
				    if ($clmatestoqueitemlote->erro_status == 0){
				      
				      echo $clmatestoqueitemlote->erro_msg."teste incluir 3";exit;
					  $sqlerro  = true;
				      
				    }
				    
				  }
				  
				}
				if (!$sqlerro) {
				  
				  if (trim($m78_matfabricante) != "") {
				    
				    $clmatestoqueitemfabric = db_utils::getDao("matestoqueitemfabric");
				    $clmatestoqueitemfabric->m78_matestoqueitem = $m80_matestoqueitem;
				    $clmatestoqueitemfabric->m78_matfabricante  = $m78_matfabricante;
				    $clmatestoqueitemfabric->incluir(null); 
				    if ($clmatestoqueitemfabric->erro_status  == 0) {

				      echo $clmatestoqueitemfabric->erro_msg;exit;
					  $sqlerro  = true;
				      
				    }
				  }
				}
				if($sqlerro == false){
					$clmatestoqueinimei->m82_matestoqueitem = $m80_matestoqueitem;
					$clmatestoqueinimei->m82_matestoqueini  = $m82_matestoqueini;
					$clmatestoqueinimei->m82_quant          = $m71_quant;
					
					/*$rsResult = pg_query($conexao_postgre, "SELECT CASE WHEN max(m82_codigo) IS NULL THEN 0 ELSE max(m82_codigo)+1 END 
	        as max_m82_codigo from matestoqueinimei");
	        $aCodMaxEstoque = pg_fetch_object($rsResult);*/
	        
					$clmatestoqueinimei->incluir(@$m82_codigo);
					if($clmatestoqueinimei->erro_status==0){
						echo $clmatestoqueinimei->erro_msg;exit;
						$sqlerro=true;
					}
				}
			}
			if ($sqlerro==false){
				$passou=true;
			}
			db_fim_transacao($sqlerro);
			// exit;
		}
  }else{
    $sqlerro = true;
    echo "UsuÃ¡rio: \\n\\ncódigo do material não informado.\\n\\nAdministrador:";exit;
  }
}
	
}

$rsResult = pg_query($conexao_postgre, "select * from matestoque");
while ($dados = pg_fetch_array($rsResult)) {
	echo $dados['m70_codigo']."<br>";
}
echo pg_num_rows($rsResult);

?>
