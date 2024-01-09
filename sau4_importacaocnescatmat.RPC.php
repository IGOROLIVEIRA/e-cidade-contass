<?php
use App\Services\ExcelService;

define( 'MENSAGENS_SAU4_IMPORTACAOCATMAT_RPC', 'saude.farmacia.far1_importacaoxls_RPC.' );

require_once("libs/db_stdlib.php");
require_once("libs/db_app.utils.php");
require_once("libs/JSON.php");
require_once("std/db_stdClass.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_conecta.php");
require_once("libs/db_utils.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");

$oJson               = new Services_JSON();
$oParam              = $oJson->decode(str_replace("\\", "", $_POST["json"]));
$oRetorno            = new stdClass();
$oRetorno->iStatus   = 1;
$oRetorno->sMensagem = '';
$oRetorno->erro      = false;

$iInstituicao = db_getsession( 'DB_instit' );

try {

    switch( $oParam->sExecuta ) {

        case 'processar':

            if(empty( $oParam->sCaminhoArquivo )) {
                throw new ParameterException( _M( MENSAGENS_SAU4_IMPORTACAOCATMAT_RPC . 'caminho_nao_informado' ) );
            }

            $excelService = new ExcelService();
            $nome_arquivo = $oParam->sCaminhoArquivo;

            $aDadosPlanilha = $excelService->importFile($nome_arquivo);

            foreach ($aDadosPlanilha as $key => $iCadMat){
              echo "<pre>";
              print_r($iCadMat);
              exit;
            }

            //db_inicio_transacao();

            //db_fim_transacao();

            break;

    }
 } catch ( Exception $oErro ) {

    db_fim_transacao(true);
    $oRetorno->iStatus   = 2;
    $oRetorno->sMensagem = urlencode( $oErro->getMessage() );
    $oRetorno->erro      = true;
}

echo $oJson->encode($oRetorno);
