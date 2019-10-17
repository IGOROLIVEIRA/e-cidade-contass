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
$iBimestre          = (!empty($oParam->bimestre)) ? $oParam->bimestre : '';

$iInstit            = db_getsession('DB_instit');
$iAnoUsu            = date("Y", db_getsession("DB_datausu"));

$oRetorno           = new stdClass();
$oRetorno->status   = 1;
$sNomeZip           = "Siops";

switch ($oParam->exec) {

    case 'gerarSiops':

        try {

            if (count($oParam->arquivos) > 0) {

                $sArquivosZip = "";

                if (file_exists("model/contabilidade/arquivos/siops/".db_getsession("DB_anousu")."/Siops.model.php")) {

                    require_once("model/contabilidade/arquivos/siops/" . db_getsession("DB_anousu") . "/Siops.model.php");

                    foreach ($oParam->arquivos as $index => $sArquivo) {

                        if ($sArquivo == 'despesa') {

                            $siopsDespesa = new Siops;
                            $siopsDespesa->setAno($iAnoUsu);
                            $siopsDespesa->setInstit($iInstit);
                            $siopsDespesa->setBimestre($iBimestre);
                            $siopsDespesa->setPeriodo();
                            $siopsDespesa->setFiltrosDespesa();
                            $siopsDespesa->setOrcado();
                            $siopsDespesa->setDespesas();

                            echo '<pre>';
                            print_r($siopsDespesa);
                            echo '</pre>';
                            die();

                            if ($siopsDespesa->getErroSQL() > 0) {
                                throw new Exception ("Ocorreu um erro ao gerar Siops " . $siopsDespesa->getErroSQL());
                            }

                        }

                        if ($sArquivo == 'receita') {

                            $siopsReceita = new Siops();
                            $siopsReceita->setAno($iAnoUsu);
                            $siopsReceita->setInstit($iInstit);
                            $siopsReceita->setBimestre($iBimestre);
                            $siopsReceita->setPeriodo();


                            if ($siopsReceita->getErroSQL() > 0) {
                                throw new Exception ("Ocorreu um erro ao gerar Siops " . $siopsReceita->getErroSQL());
                            }

                        }

                    }

                }

                system("rm -f {$sNomeZip}.zip");
                system("bin/zip -q {$sNomeZip}.zip $sArquivosZip");
                $oRetorno->caminhoZip = $oRetorno->nomeZip = "{$sNomeZip}.zip";

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
