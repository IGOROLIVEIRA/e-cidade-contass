<?php
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once('libs/db_app.utils.php');
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("std/DBTime.php");
require_once("std/DBDate.php");
require_once("classes/db_licobrasmedicao_classe.php");
require_once("classes/db_licobrasanexo_classe.php");
require_once("classes/db_licobrasresponsaveis_classe.php");
require_once("classes/db_homologacaoadjudica_classe.php");
include("classes/db_condataconf_classe.php");



db_app::import("configuracao.DBDepartamento");

$oJson             = new services_json();
//$oParam            = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\","",$_POST["json"])));
$oParam           = $oJson->decode(str_replace("\\","",$_POST["json"]));

$oErro             = new stdClass();

$oRetorno          = new stdClass();
$oRetorno->status  = 1;

switch($oParam->exec) {

  case 'getAnexos':

    $cllicobrasanexos = new cl_licobrasanexo();
    $resultAnexos = $cllicobrasanexos->sql_record($cllicobrasanexos->sql_query(null,"*",null,"obr04_licobrasmedicao = $oParam->codmedicao"));

    for ($iCont = 0; $iCont < pg_num_rows($resultAnexos); $iCont++) {
      $oDadosAnexo = db_utils::fieldsMemory($resultAnexos, $iCont);

      $oDocumentos      = new stdClass();
      $oDocumentos->iCodigo    = $oDadosAnexo->obr04_sequencial;
      $oDocumentos->sLegenda   = $oDadosAnexo->obr04_legenda;
      $oRetorno->dados[] = $oDocumentos;
    }

    $oRetorno->detalhe    = "documentos";

    break;

  case 'excluirAnexo':

    $cllicobrasanexos = new cl_licobrasanexo();
    $resultAnexos = $cllicobrasanexos->sql_record($cllicobrasanexos->sql_query(null,"*",null,"obr04_sequencial = $oParam->codAnexo"));
    db_fieldsmemory($resultAnexos,0);

    //cria caminho para o arquivo
    $anexo = 'imagens/obras/'.$obr04_codimagem;

    //apaga o arquivo no diretorio
    if(!unlink($anexo)){
      $erro = true;
    };

    if($erro == false){
      $cllicobrasanexos->excluir($obr04_sequencial);
    }
    if($erro == true){
      $oRetorno->message = "Erro ! Arquivo nao excluido contate o Suporte.";
    }
    break;

  case 'alterarAnexo':

      $cllicobrasanexos = new cl_licobrasanexo();
      $rsAnexo =  $cllicobrasanexos->sql_record($cllicobrasanexos->sql_query(null,"*",null,"obr04_licobrasmedicao = $oParam->codmedicao"));
      if(pg_num_rows($rsAnexo) < 1){
          $ultimoregistro = $cllicobrasanexos->sql_record($cllicobrasanexos->sql_query(null,"max(obr04_sequencial) as obr04_sequencial",null,""));
          db_fieldsmemory($ultimoregistro,0);
          $cllicobrasanexos->obr04_legenda = $oParam->legenda;
          $cllicobrasanexos->alterar($obr04_sequencial);
      }else{
       $oRetorno->status = 2;
       $rsAnexo =  $cllicobrasanexos->sql_record($cllicobrasanexos->sql_query(null,"obr04_sequencial,obr04_codimagem",null,"obr04_legenda like '%foto sem legenda%'"));
       db_fieldsmemory($rsAnexo,0);
       $cllicobrasanexos->excluir($obr04_sequencial);
       $arquivo = "imagens/obras/".$obr04_codimagem;
       if(unlink($arquivo)){
           echo "apagou";
       };
      }

    break;

  case 'SalvarResp':

    $cllicobrasresponsaveis = new cl_licobrasresponsaveis();
    $clhomologacaoadjudica = new cl_homologacaoadjudica();
    $clcondataconf = new cl_condataconf;

    $resulthomologacao = $clhomologacaoadjudica->sql_record($clhomologacaoadjudica->sql_query_file(null,"l202_datahomologacao",null,"l202_licitacao = $oParam->licitacao"));
    db_fieldsmemory($resulthomologacao,0);
    $data = (implode("/",(array_reverse(explode("-",$l202_datahomologacao)))));
    $datahomologacao = DateTime::createFromFormat('d/m/Y', $data);
    $datainicioatividades = DateTime::createFromFormat('d/m/Y', $oParam->obr05_dtcadastrores);

      $sWhere = "obr05_seqobra = $oParam->obr05_seqobra and obr05_responsavel = $oParam->obr05_responsavel and obr05_tiporesponsavel = $oParam->obr05_tiporesponsavel";
      $sWhere .= "and obr05_tiporegistro = $oParam->obr05_tiporegistro and obr05_vinculoprofissional = $oParam->obr05_vinculoprofissional";
      $resultresp = $cllicobrasresponsaveis->sql_record($cllicobrasresponsaveis->sql_query(null,"*",null,$sWhere));
      db_fieldsmemory($resultresp,0);

    try{
      if($datahomologacao != null){
        if($datainicioatividades < $datahomologacao){
          throw new Exception("Usuário: Campo Data de Inicio das atividades deve ser maior que data de Homologação da Licitação.");
        }
      }

      /**
       * validação com sicom
       */
      if(!empty($datainicioatividades)){
        $anousu = db_getsession('DB_anousu');
        $instituicao = db_getsession('DB_instit');
        $result = $clcondataconf->sql_record($clcondataconf->sql_query_file($anousu,$instituicao,"c99_datapat",null,null));
        db_fieldsmemory($result);
        $data = (implode("/",(array_reverse(explode("-",$c99_datapat)))));
        $dtencerramento = DateTime::createFromFormat('d/m/Y', $data);

        if ($datainicioatividades <= $dtencerramento) {
          throw new Exception("O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.");
        }
      }
    }catch (Exception $eErro){
      $oRetorno->message = urlencode($eErro->getMessage());
    }

    if(pg_num_rows($resultresp) > 0){
      $cllicobrasresponsaveis->obr05_responsavel = $oParam->obr05_responsavel;
      $cllicobrasresponsaveis->obr05_tiporesponsavel = $oParam->obr05_tiporesponsavel;
      $cllicobrasresponsaveis->obr05_tiporegistro = $oParam->obr05_tiporegistro;
      $cllicobrasresponsaveis->obr05_numregistro = $oParam->obr05_numregistro;
      $cllicobrasresponsaveis->obr05_numartourrt = $oParam->obr05_numartourrt;
      $cllicobrasresponsaveis->obr05_vinculoprofissional = $oParam->obr05_vinculoprofissional;
      $cllicobrasresponsaveis->obr05_dtcadastrores = $oParam->obr05_dtcadastrores;
      $cllicobrasresponsaveis->alterar($obr05_sequencial);

      if ($cllicobrasresponsaveis->erro_status == 0) {
        $erro = $cllicobrasresponsaveis->erro_msg;
        $oRetorno->message = urlencode($erro);
        $oRetorno->status = 2;

      } else {
        $oRetorno->status = 1;
        $oRetorno->message = urlencode("Responsável Alterado com Sucesso.");
      }

    }else {

      $cllicobrasresponsaveis->obr05_seqobra = $oParam->obr05_seqobra;
      $cllicobrasresponsaveis->obr05_responsavel = $oParam->obr05_responsavel;
      $cllicobrasresponsaveis->obr05_tiporesponsavel = $oParam->obr05_tiporesponsavel;
      $cllicobrasresponsaveis->obr05_tiporegistro = $oParam->obr05_tiporegistro;
      $cllicobrasresponsaveis->obr05_numregistro = $oParam->obr05_numregistro;
      if($oParam->obr05_numartourrt == ""){
        $cllicobrasresponsaveis->obr05_numartourrt =  NULL;
      }else{
        $cllicobrasresponsaveis->obr05_numartourrt = $oParam->obr05_numartourrt;
      }
      $cllicobrasresponsaveis->obr05_vinculoprofissional = $oParam->obr05_vinculoprofissional;
      $cllicobrasresponsaveis->obr05_dtcadastrores = $oParam->obr05_dtcadastrores;
      $cllicobrasresponsaveis->obr05_instit = db_getsession("DB_instit");
      $cllicobrasresponsaveis->incluir();

      if ($cllicobrasresponsaveis->erro_status == 0) {
        $erro = $cllicobrasresponsaveis->erro_msg;
        $oRetorno->message = urlencode($erro);
        $oRetorno->status = 2;
      } else {
        $oRetorno->status = 1;
        $oRetorno->message = urlencode("Responsável salvo com sucesso.");
      }
    }
    break;

  case 'getResponsaveis':
    $cllicobrasresponsaveis = new cl_licobrasresponsaveis();

    $rsResponsaveis = $cllicobrasresponsaveis->sql_record($cllicobrasresponsaveis->sql_query(null,"obr05_sequencial,obr05_tiporesponsavel,z01_nome",null,"obr05_seqobra = $oParam->obr05_seqobra"));

    for ($iCont = 0; $iCont < pg_num_rows($rsResponsaveis); $iCont++) {
      $oDadosResponsavel = db_utils::fieldsMemory($rsResponsaveis, $iCont);

      $oResponsaveis                        = new stdClass();
      $oResponsaveis->iCodigo               = $oDadosResponsavel->obr05_sequencial;

      if($oDadosResponsavel->obr05_tiporesponsavel == "1"){
        $oResponsaveis->iTiporesponsavel = urlencode("Fiscalização");
      }elseif ($oDadosResponsavel->obr05_tiporesponsavel == "2"){
        $oResponsaveis->iTiporesponsavel = urlencode("Execução");
      }elseif ($oDadosResponsavel->obr05_tiporesponsavel == "3"){
        $oResponsaveis->iTiporesponsavel = urlencode("Projetista");
      }else{
        $oResponsaveis->iTiporesponsavel = urlencode("Selecione");
      }
      $oResponsaveis->sNome                 = urlencode($oDadosResponsavel->z01_nome);
      $oRetorno->dados[] = $oResponsaveis;
    }
    break;

  case 'excluirResp':
    $cllicobrasresponsaveis = new cl_licobrasresponsaveis();
    $cllicobrasresponsaveis->excluir($oParam->iCodigo);

    if($cllicobrasresponsaveis->erro_status == 0){
      $erro = $cllicobrasresponsaveis->erro_msg;
      $oRetorno->message = urlencode($erro);
    }else{
      $oRetorno->message = urlencode("Responsável Excluido com sucesso.");
    }
    break;

  case 'getDadosResponsavel':
    $cllicobrasresponsaveis = new cl_licobrasresponsaveis();
    $rsResponsaveis = $cllicobrasresponsaveis->sql_record($cllicobrasresponsaveis->sql_query(null,"*",null,"obr05_sequencial = $oParam->iCodigo"));

    for ($iCont = 0; $iCont < pg_num_rows($rsResponsaveis); $iCont++) {
      $oDadosResponsavel = db_utils::fieldsMemory($rsResponsaveis, $iCont);

      $oRetorno->dados[] = $oDadosResponsavel;
    }

  case 'downloadDocumento':

    $cllicobrasanexos = new cl_licobrasanexo();

    $result = $cllicobrasanexos->sql_record($cllicobrasanexos->sql_query(null,"*", null, "obr04_sequencial = $oParam->iCodigoDocumento"));
    db_fieldsmemory($result,0);

    db_inicio_transacao();

    // Abrindo o objeto no modo leitura "r" passando como parâmetro o OID.
    $sNomeArquivo = "imagens/obras/$obr04_codimagem";
//    pg_lo_export($conn, $oDocumento->getArquivo(), $sNomeArquivo);
    db_fim_transacao(true);
    $oRetorno->nomearquivo = $sNomeArquivo;
    // Setando Cabeçalho do browser para interpretar que o binário que será carregado é de uma foto do tipo JPEG.

    break;
}
echo json_encode($oRetorno);


?>
