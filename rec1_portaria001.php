<?php
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2014  DBSeller Servicos de Informatica             
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa e software livre; voce pode redistribui-lo e/ou     
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versao 2 da      
 *  Licenca como (a seu criterio) qualquer versao mais nova.          
 *                                                                    
 *  Este programa e distribuido na expectativa de ser util, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de              
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM           
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU     
 *  junto com este programa; se nao, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Copia da licenca no diretorio licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_utils.php");
require_once("dbforms/db_funcoes.php");

db_postmemory($HTTP_POST_VARS);

$imprimir = false;

$clrhparam         = new cl_rhparam;
$clportaria        = new cl_portaria;
$classenta         = new cl_assenta;
$clrhpessoal       = new cl_rhpessoal;
$clportariaassenta = new cl_portariaassenta;
$clportariatipo    = new cl_portariatipo;

$db_opcao = 1;
$db_opcao_numero = 1;
$db_botao = true;

$sqlerro  = false;
$erro_msg = "";

if ( isset($incluir) ) {
  
  $db_botao = false;
  
  db_inicio_transacao();

  /**
   * Pesquisa parametro da numeracao da portaria, caso encontre pega proxima numeracao, nextval() 
   */
  $sWhereRhParam  = " h36_ultimaportaria > 0 and h36_instit = ".db_getsession("DB_instit");
  $sSqlRhParam    = $clrhparam->sql_query_file(null,"h36_ultimaportaria",null,$sWhereRhParam);
  $rsDadosRhParam = $clrhparam->sql_record($sSqlRhParam);
  $lSeqAutomatico = false;

  if ( $clrhparam->numrows > 0 ) {
    $lSeqAutomatico = true;
  } 
  
  if ( $lSeqAutomatico ) {

    $sSqlSequence       = " select nextval('rhparam_h36_ultimaportaria_seq') as seq ";  
    $rsConsultaSequence = db_query($sSqlSequence);
    $oSeqPortaria       = db_utils::fieldsMemory($rsConsultaSequence,0);
    $iNroPort           = $oSeqPortaria->seq;

  } else {
    $iNroPort = $h31_numero;
  }  
  
  /**
   * Inclui portaria 
   */
  if (isset($h31_sequencial) && trim(@$h31_sequencial)==""){

       $clportaria->h31_numero = $iNroPort;
       $clportaria->incluir($h31_sequencial);
       if ($clportaria->erro_status == "0"){
         $sqlerro          = true;
         $erro_msg         = $clportaria->erro_msg;
       } else {
         $h31_sequencial   = $clportaria->h31_sequencial;
         $h31_portariatipo = $clportaria->h31_portariatipo;
       }
  }
  
  /**
   * Inclui assentamento 
   */
  if (isset($h16_regist) && trim(@$h16_regist) !="" && !$sqlerro){
    
    $rsPortariaTipo = db_query($clportariatipo->sql_query_file($h31_portariatipo,"h30_tipoasse",null));
    $oPortariaTipo  = db_utils::fieldsMemory($rsPortariaTipo,0);
    
    $oAssentamento = new Assentamento();
    $oAssentamento->setMatricula($h16_regist);
    $oAssentamento->setTipoAssentamento($oPortariaTipo->h30_tipoasse);
    $oAssentamento->setDataConcessao(new DBDate($h16_dtconc));
    $oAssentamento->setHistorico($h16_histor);
    $oAssentamento->setCodigoPortaria($iNroPort);
    $oAssentamento->setDescricaoAto($h16_atofic);
    $oAssentamento->setDias($h16_quant);
    $oAssentamento->setPercentual("0");
    $oAssentamento->setDataTermino(new DBDate($h16_dtterm));
    $oAssentamento->setSegundoHistorico('');
    $oAssentamento->setLoginUsuario(db_getsession("DB_id_usuario"));
    $oAssentamento->setDataLancamento(date("Y-m-d",db_getsession("DB_datausu")));
    $oAssentamento->setConvertido("false");
    $oAssentamento->setAnoPortaria($h16_anoato);

    AssentamentoRepository::persist($oAssentamento);


    if ($classenta->erro_status == "0") {
     $sqlerro    = true;
     $erro_msg   = $classenta->erro_msg;
     $clportaria->erro_msg = $erro_msg;
    } 

    if (!$sqlerro) {

     $h16_codigo = $oAssentamento->getCodigo();

     $clportariaassenta->h33_portaria = $h31_sequencial;
     $clportariaassenta->h33_assenta  = $h16_codigo;
     $clportariaassenta->incluir(null);

     if ($clportariaassenta->erro_status == "0"){
        $sqlerro  = true;
        $erro_msg = $clportariaassenta->erro_msg;
        $clportaria->erro_msg = $erro_msg;
     }
    }

    if (!$sqlerro && !empty($h80_db_cadattdinamicovalorgrupo)) {

      $oDaoAssentaAttr = new cl_assentadb_cadattdinamicovalorgrupo();              
      $oDaoAssentaAttr->h80_assenta                     = $h16_codigo;      
      $oDaoAssentaAttr->h80_db_cadattdinamicovalorgrupo = $h80_db_cadattdinamicovalorgrupo;
      $oDaoAssentaAttr->incluir($h16_codigo, $h80_db_cadattdinamicovalorgrupo);

      if ($oDaoAssentaAttr->erro_status == "0") {
       $sqlerro  = true;
       $erro_msg = $oDaoAssentaAttr->erro_msg;
      }
    }

    $imprimir = true;
  }

  /**
   * Altera parametro(h36_ultimaportaria) com numero da ultima portaria
   * - caso sequencial for automatico
   * - caso nao exitir erro 
   */
  if (!$sqlerro && $lSeqAutomatico) {
    
    $sSqlSequence       = " select last_value as seq from rhparam_h36_ultimaportaria_seq";  
    $rsConsultaSequence = db_query($sSqlSequence);
    $oSeqPortaria       = db_utils::fieldsMemory($rsConsultaSequence,0);
    
    $clrhparam->h36_ultimaportaria = $oSeqPortaria->seq;
    $clrhparam->h36_instit         = db_getsession("DB_instit");
    $clrhparam->alterar(db_getsession("DB_instit"));
    
    if ( $clrhparam->erro_status == "0" ) {
      $sqlerro  = true;
      $erro_msg = $clrhparam->erro_msg;
      $clportaria->erro_msg = $erro_msg;
    }
    
  }

  if(!$sqlerro) {
    if(isset($rh161_regist)) {

      if (empty($rh161_regist)) {
        $sqlerro  = true;
        $erro_msg = 'Informe a matrícula do servidor substituído';
        db_redireciona("");
      }

      $oAssentamentoSubstituicao = new AssentamentoSubstituicao($oAssentamento->getCodigo());
      $oAssentamentoSubstituicao->setSubstituido(ServidorRepository::getInstanciaByCodigo($rh161_regist, DBPessoal::getAnoFolha(), DBPessoal::getMesFolha()));
      
      $mResponse = $oAssentamentoSubstituicao->persist();
  
      if($mResponse !== true) {
        $sqlerro  = true;
        $erro_msg = $mResponse;
      }    
    }
  }
  
  db_fim_transacao($sqlerro);

  
  if ( $sqlerro ) {
    $db_botao = true;
  }

  if (!$sqlerro) {
    db_msgbox("Alteração Realizada com Sucesso.");
    db_redireciona("");
  }
} 

/**
 * Nao exise post $incluir, pesquisa proxima numeracao da portaria
 */
else {
  
  $lExibirNumeracaoPortaria = true;
  $rsConsultaParametros = $clrhparam->sql_record($clrhparam->sql_query_file(null,"h36_ultimaportaria ",null," h36_ultimaportaria > 0 and h36_instit = ".db_getsession("DB_instit")));

  if ($clrhparam->numrows > 0) {

    $oParametros = db_utils::fieldsMemory($rsConsultaParametros,0);
    $h31_numero  = $oParametros->h36_ultimaportaria + 1;
    $lExibirNumeracaoPortaria = false;
  }

  $h80_db_cadattdinamicovalorgrupo = "";
}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/geradorrelatorios.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/widgets/DBToogle.widget.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/dates.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
  <?php include("forms/db_frmportaria.php"); ?>
  <?php db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit")); ?>
</body>
</html>
<script>
//js_tabulacaoforms("form1","h31_portariatipo",true,1,"h31_portariatipo",true);
js_criarCamposAdicionais("<?= (!empty($h12_codigo) ? $h16_codigo : null ) ?>");
</script>
<?php
if(isset($incluir)){
  
  if ($sqlerro) {
    $clportaria->erro(true,false);
  }
  
}
if ($imprimir == true){
  echo " <script> js_imprimeConf(); </script> ";
}

?>
