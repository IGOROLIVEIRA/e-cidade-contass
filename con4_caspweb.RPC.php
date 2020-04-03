<?php
require_once("std/db_stdClass.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_utils.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/JSON.php");
require_once("std/DBDate.php");
require_once("libs/db_liborcamento.php");
include("libs/db_libcontabilidade.php");
require_once("classes/db_orcorgao_classe.php");

db_postmemory($_POST);

$oJson              = new services_json();

$oParam             = $oJson->decode(str_replace("\\","",$_POST["json"]));
$iMes               = (!empty($oParam->iMes)) ? $oParam->iMes : '';

$iInstit            = db_getsession('DB_instit');
$iAnoUsu            = date("Y", db_getsession("DB_datausu"));

$oRetorno           = new stdClass();
$oRetorno->status   = 1;
$sNomeArqmapaAprop  = "Mapa-de-Apropriacao";
$sNomeArqmapaRsp    = "Mapa-de-Restos-a-Pagar";
$sNomeZip           = "Caspweb";

switch ($oParam->exec) {

    case 'gerarCaspweb':

        try {

            if (count($oParam->arquivos) > 0) {

                $sArquivosZip = "";

                if (file_exists("model/contabilidade/arquivos/caspweb/".db_getsession("DB_anousu")."/Caspweb.model.php")) {

                    require_once("model/contabilidade/arquivos/caspweb/" . db_getsession("DB_anousu") . "/Caspweb.model.php");

                    foreach ($oParam->arquivos as $index => $sArquivo) {

                        if ($sArquivo == 'mapaAprop') {

                            $oCaspweb = new Caspweb();
                            $oCaspweb->setAno($iAnoUsu);
                            $oCaspweb->setInstit($iInstit);
                            $oCaspweb->setMes($iMes);
                            $oCaspweb->setPeriodo();
                            $oCaspweb->setNomeArquivo($sNomeArqmapaAprop);
                            $oCaspweb->gerarMapaApropriacao();


                            if ($oCaspweb->status == 2) {
                                $oRetorno->message = "Não foi possível gerar o Caspweb. De/Para dos seguintes estruturais não encontrado: {$oCaspweb->sMensagem}";
                                $oRetorno->status = 2;
                            }

                            if ($oCaspweb->getErroSQL() > 0) {
                                throw new Exception ("Ocorreu um erro ao gerar Caspweb " . $oCaspweb->getErroSQL());
                            }

                            $oRetorno->arquivos->$index->nome = "{$oCaspweb->getNomeArquivo()}.csv";
                            $sArquivosZip .= " {$oCaspweb->getNomeArquivo()}.csv ";

                        }

                        if ($sArquivo == 'mapaRsp') {

                            $oCaspweb = new Caspweb();


                            if ($oCaspweb->status == 2) {
                                $oRetorno->message = "Não foi possível gerar o Caspweb. De/Para dos seguintes estruturais não encontrado: {$oCaspweb->sMensagem}";
                                $oRetorno->status = 2;
                            }

                            if ($oCaspweb->getErroSQL() > 0) {
                                throw new Exception ("Ocorreu um erro ao gerar Caspweb " . $oCaspweb->getErroSQL());
                            }

                            $oRetorno->arquivos->$index->nome = "{$oCaspweb->getNomeArquivo()}.csv";
                            $sArquivosZip .= " {$oCaspweb->getNomeArquivo()}.csv ";

                        }

                    }

                    system("rm -f {$sNomeZip}.zip");
                    system("bin/zip -q {$sNomeZip}.zip $sArquivosZip");
                    $oRetorno->caminhoZip = $oRetorno->nomeZip = "{$sNomeZip}.zip";

                } else {

                    $oRetorno->status  = 2;
                    $sGetMessage       = "Arquivos Caspweb não encontrados para o ano $iAnoUsu.";
                    $oRetorno->message = $sGetMessage;

                }

            }

        } catch(Exception $eErro) {

            $oRetorno->status  = 2;
            $sGetMessage       = "Arquivo retornou com erro: \n \n {$eErro->getMessage()}";
            $oRetorno->message = $sGetMessage;

        }

        break;

}

if ($oRetorno->status == 2) {
    $oRetorno->message = utf8_encode($oRetorno->message);
}
echo $oJson->encode($oRetorno);
