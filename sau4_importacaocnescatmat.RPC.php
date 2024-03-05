<?php
use App\Services\ExcelService;
use App\Models\MaterCatMat;
use Illuminate\Database\Capsule\Manager as DB;

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
$materCatMat = new MaterCatMat();

try {

    switch( $oParam->sExecuta ) {

        case 'processar':

            if(empty( $oParam->sCaminhoArquivo )) {
                throw new ParameterException( _M( MENSAGENS_SAU4_IMPORTACAOCATMAT_RPC . 'caminho_nao_informado' ) );
            }

            $excelService = new ExcelService();
            $nome_arquivo = $oParam->sCaminhoArquivo;

            $aDadosImportar = [];
            $aDadosPlanilha = array_slice($excelService->importFile($nome_arquivo),1);

            foreach ($aDadosPlanilha as $key => $dados){
                $aDadosImportar [] = [
                    'faxx_i_codigo' => $materCatMat->getNextval(),
                    'faxx_i_catmat' => $dados['A'],
                    'faxx_i_desc' => $dados['B'],
                    'faxx_i_ativo' => $dados['C'],
                    'faxx_i_susten' => $dados['D'],
                ];
            }

            $resultadoChunks = array_chunk($aDadosImportar, 500);

            foreach ($resultadoChunks as $iCadMat){
                DB::beginTransaction();

                    MaterCatMat::insert($iCadMat);

                DB::commit();
            }

            break;
    }
 } catch ( Exception $oErro ) {
    DB::rollBack();

    $oRetorno->iStatus   = 2;
    $oRetorno->sMensagem =  $oErro->getMessage() ;
}

echo $oJson->encode($oRetorno);
