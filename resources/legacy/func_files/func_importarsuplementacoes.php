<?php 
//ini_set('display_errors','On'); error_reporting(E_ALL);
require_once ('libs/db_conn.php');
require_once ('libs/db_stdlib.php');
require_once ('libs/db_utils.php');
require_once ("libs/db_app.utils.php");
require_once ('libs/db_conecta.php');
require_once ('dbforms/db_funcoes.php');
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_orclei_classe.php");
include("funcoes/db_func_orclei.php");
include("classes/db_orcprojeto_classe.php");
include ("classes/db_orcprojlan_classe.php");
require_once("libs/JSON.php");
include ("dbforms/db_suplementacao.php"); // contem a função que processa a suplementação
db_app::import("orcamento.suplementacao.*");
db_app::import("exceptions.*");
db_postmemory($HTTP_POST_VARS);
$oJson = new services_json();
$oRetorno = new stdClass();
$oRetorno->erro = false;
$oRetorno->status = 1;
$oRetorno->message = '';
$anousu = db_getsession("DB_anousu");
try{
   $aDadosSuple = getDadosSuplementacoes();
   if (empty($aDadosSuple)){
      throw new Exception("Não foram encontrados Suplementações para Migrar!");
   }
   db_inicio_transacao();
   foreach ($aDadosSuple as $oProjeto ){
      $clorcsuplem = new cl_orcsuplem;
      $clorcsuplem = salvarOrcProjeto($oProjeto);//salvar o decreto e a lei
      //print_r($clorcsuplem);die;
      salvarOrcSuplemVal($oProjeto->suplem , $clorcsuplem->o46_codsup);//salvar os valores das dotacoes e um decreto
      //encerrarSuplementacao($clorcsuplem);
   }
   db_fim_transacao(false);
   //$rsResult = db_query("drop table suplementcao");
   //$rsResult = db_query("drop table dotacao");
   

} catch (Exception $eErro) {
   
   db_fim_transacao(true);
   $oRetorno->erro = true;
   $oRetorno->status = 2;
   $oRetorno->message = $eErro->getMessage();

}
function salvarOrcProjeto($orcProjeto){
	$clorcprojeto = new cl_orcprojeto;
	$clorclei = new cl_orclei;
	
	$sqlOrclei = $clorclei->sql_query(null,$campos="*",$ordem=null," o45_numlei::integer =".$orcProjeto->o45_numlei);
    $o39_codlei = db_utils::fieldsMemory(db_query($sqlOrclei),0)->o45_codlei;
    //print_r($o39_codlei);die;
    //die(pg_last_error());
    if(empty($o39_codlei)){

       $clorclei = new cl_orclei;
       //$clorclei->o45_codlei=$orcProjeto[0]->o45_numlei;
       $clorclei->o45_numlei=$orcProjeto->o45_numlei;
       $clorclei->o45_descr="Lei Orcamentaria Anual para o Exercicio de ".db_getsession('DB_anousu');
       $clorclei->o45_datafim=db_getsession('DB_anousu')."-01-01";
       $clorclei->o45_dataini=db_getsession('DB_anousu')."-12-31";
       $clorclei->o45_tipolei=1;
       $clorclei->o45_datalei=null;
       
       $clorclei->incluir();

       if ($clorclei->erro_status == "0" ){
         throw new Exception($clorclei->erro_msg);
       }  
       
       $o39_codlei = $clorclei->o45_codlei;
       
    }

    $sqlOrcProjeto = $clorcprojeto->sql_query(null,$campos="*",$ordem=null," o39_codproj =".$orcProjeto->o39_numero);
    $o39_codproj = db_utils::fieldsMemory(db_query($sqlOrcProjeto),0)->o39_codproj;
    
    if(empty($o39_codproj)){

      $clorcprojeto = new cl_orcprojeto;
      $o39_texto = " Art 2. -  Para cobertura do Crédito aberto de acordo com o Art 1.,";
      $o39_texto .= " será usado como recurso as seguintes reduções orçamentárias:   ";
      $clorcprojeto->o39_codproj = $orcProjeto->o39_numero;
      $clorcprojeto->o39_descr = "Decreto de Credito Suplementar"; 
      $clorcprojeto->o39_codlei = $o39_codlei; 
      $clorcprojeto->o39_tipoproj = 1; 
      $clorcprojeto->o39_anousu = db_getsession('DB_anousu'); 
      $clorcprojeto->o39_numero = $orcProjeto->o39_numero;
      $clorcprojeto->o39_data = $orcProjeto->o39_data;
      $clorcprojeto->o39_lei = null;  
      $clorcprojeto->o39_leidata = null; 
      $clorcprojeto->o39_texto = $o39_texto; 
      $clorcprojeto->o39_textolivre = null; 
      $clorcprojeto->o39_compllei = null; 
      $clorcprojeto->o39_usalimite = 't'; 
      $clorcprojeto->incluir();

      if ($clorcprojeto->erro_status == "0" ){
       throw new Exception($clorcprojeto->erro_msg);
      } 

     $clorcsuplem = new cl_orcsuplem;
     $clorcsuplem->o46_codlei = $clorcprojeto->o39_codproj;
     $clorcsuplem->o46_data = $orcProjeto->o39_data;   
     $clorcsuplem->o46_instit = db_getsession("DB_instit");
     $clorcsuplem->o46_tiposup = 1001;
     $clorcsuplem->incluir(null);
     if ($clorcsuplem->erro_status == "0" ){
       throw new Exception("OrcSuplem :".$clorcsuplem->erro_msg);
     }

   } 
   return $clorcsuplem;
}
function salvarOrcSuplemVal($aSuplementacao, $o46_codlei){
  foreach ($aSuplementacao as $suplem) {
    $clorcsuplemval = new cl_orcsuplemval;
  	$clorcsuplemval->o47_valor = $suplem->vlsuplemen - $suplem->vlreducoes;
    $clorcsuplemval->o47_anousu = db_getsession("DB_anousu");
    $clorcsuplemval->o47_concarpeculiar = "000";
    $o47_coddot = getDotacao($suplem->orgao,$suplem->unidade,$suplem->funcao,$suplem->subfuncao,
      	                            $suplem->programa ,$suplem->projatv,$suplem->natureza,$suplem->cdftce);
    if(empty($o47_coddot)){
      throw new Exception("Decreto ".$suplem->o39_numero ." Dotaçãoo não encontrada: ".
        str_pad($suplem->orgao, 2, "0", STR_PAD_LEFT).".".
        str_pad($suplem->unidade, 2, "0", STR_PAD_LEFT).".".
        str_pad($suplem->funcao,2, "0", STR_PAD_LEFT).".".
        str_pad($suplem->subfuncao,3, "0", STR_PAD_LEFT).".".
        str_pad($suplem->programa,4, "0", STR_PAD_LEFT).".".
        str_pad($suplem->projatv,4, "0", STR_PAD_LEFT).".".
        $suplem->natureza.".".
        $suplem->cdftce);
    }
    if($clorcsuplemval->o47_valor != 0)
      $clorcsuplemval->incluir($o46_codlei,db_getsession("DB_anousu"),$o47_coddot);
    if ($clorcsuplemval->erro_status == "0" ){
      print_r($suplem);
      print_r($clorcsuplemval);
      throw new Exception("OrcSuplemVal :".$clorcsuplemval->erro_msg);
    } 
  }
}

function encerrarSuplementacao($oOrcSuplem){
  $clorcprojlan = db_utils::getDao("orcprojlan");
  $clorcprojlan->o51_id_usuario = db_getsession("DB_id_usuario");
  $clorcprojlan->o51_data = $oOrcSuplem->o46_data;
  $clorcprojlan->incluir($oOrcSuplem->o46_codlei);
  if ($clorcprojlan->erro_status == "0" ){
      throw new Exception("Processa Suplementação. :".$clorcprojlan->erro_msg);
  } 
  $teste = processa_suplementacao($oOrcSuplem->o46_codsup,$oOrcSuplem->o46_data,db_getsession("DB_id_usuario"));
  if ($teste){
      throw new Exception(" Erro ao processar lançamentos suplementação.");
  }
}

function getDadosSuplementacoes(){
  $sqlSuplementacoes  = " SELECT tpcredito, nrdecreto AS o39_numero, nrlei AS o45_numlei, tplei, dtsuplem AS o39_data, orgao, unidade,
                         subuni, funcao, programa AS subfuncao, subprog AS programa, projatv, natureza, suplementa.cdftce,
                         case when suplementa.vlsuplemen > 0 then 's' else 'r' end as tipo,
                         sum(suplementa.vlsuplemen) AS vlsuplemen, sum(suplementa.vlreducoes )AS vlreducoes
                        FROM suplementa
                        INNER JOIN dotacao ON dotacao.nrficha = suplementa.nrficha
                        where florgao in (0,2)
                        group by 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15
                        order by nrdecreto ";
  $rsSuple = db_query($sqlSuplementacoes);
  $aSuplem = db_utils::getCollectionByRecord($rsSuple);
  $aSuplemAgrupadas = array();
  foreach($aSuplem as $oSuplem){
    //agrupar os descretos e suas movimentacoes
    $sHash = $oSuplem->o39_numero;
    if(!isset($aSuplemAgrupadas[$sHash])) {
      $oSuplementacao =  new stdClass();
      $oSuplementacao->o45_numlei = $oSuplem->o45_numlei;
      $oSuplementacao->o39_numero = $oSuplem->o39_numero;
      $oSuplementacao->o39_data = $oSuplem->o39_data;
      $oSuplementacao->suplem = array();
      $oSuplementacao->suplem[] = $oSuplem;
      $sHashSumple  = $oSuplem->orgao.$oSuplem->unidade.$oSuplem->funcao.$oSuplem->subfuncao;
      $sHashSumple .= $oSuplem->programa.$oSuplem->projatv.$oSuplem->natureza.$oSuplem->cdftce;
      $aSuplemAgrupadas[$sHash] = $oSuplementacao;
    } else {
      $sHashSumple  = $oSuplem->orgao.$oSuplem->unidade.$oSuplem->funcao.$oSuplem->subfuncao;
      $sHashSumple .= $oSuplem->programa.$oSuplem->projatv.$oSuplem->natureza.$oSuplem->cdftce;
      //caso uma dotacao for anulada e suplementada no mesmo decreto.
      if(!isset($aSuplemAgrupadas[$sHash]->suplem[$sHashSumple])){
        $aSuplemAgrupadas[$sHash]->suplem[$sHashSumple] = $oSuplem;
      }else{
          $aSuplemAgrupadas[$sHash]->suplem[$sHashSumple]->vlsuplemen = $oSuplem->vlsuplemen + $aSuplemAgrupadas[$sHash]->suplem[$sHashSumple]->vlsuplemen;
          $aSuplemAgrupadas[$sHash]->suplem[$sHashSumple]->vlreducoes = $oSuplem->vlreducoes + $aSuplemAgrupadas[$sHash]->suplem[$sHashSumple]->vlreducoes;
      }
    }
  }
  return $aSuplemAgrupadas;
}

//pega o coddot da orcdotacao do anoUsu da sessao.
function getDotacao($orgao, $unidade, $funcao, $subfuncao, $programa, $projeto, $elemento, $fonte){

	$sqlDotacao  = "select o58_coddot from orcdotacao where o58_anousu = ".db_getsession('DB_anousu')." ";
    $sqlDotacao .= " and o58_orgao     = ".$orgao;
    $sqlDotacao .= " and o58_unidade   = ".$unidade; 
    $sqlDotacao .= " and o58_subfuncao = ".$subfuncao; 
    $sqlDotacao .= " and o58_projativ  = ".$projeto ; 
    $sqlDotacao .= " and o58_codigo    = ".$fonte; 
    $sqlDotacao .= " and o58_funcao    = ".$funcao;
    $sqlDotacao .= " and o58_programa  = ".$programa; 
    $sqlDotacao .= " and o58_codele    = (select o56_codele from orcelemento where o56_anousu=".db_getsession('DB_anousu')." and o56_elemento='3".$elemento."0000') ";  
    $sqlDotacao .= " and o58_instit    = ".db_getsession('DB_instit');
	return db_utils::fieldsMemory(db_query($sqlDotacao),0)->o58_coddot;

}
echo $oJson->encode($oRetorno);
?>
