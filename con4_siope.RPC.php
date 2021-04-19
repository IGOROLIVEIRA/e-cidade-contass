<?php
require_once("std/db_stdClass.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_utils.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/JSON.php");
require_once("libs/db_liborcamento.php");
require_once("libs/db_libcontabilidade.php");
require_once("model/contabilidade/arquivos/siope/".db_getsession("DB_anousu")."/Siope.model.php");

db_postmemory($_POST);

$oJson              = new services_json();

$oParam             = $oJson->decode(str_replace("\\","",$_POST["json"]));
$iBimestre          = (!empty($oParam->bimestre)) ? $oParam->bimestre : '';

$iInstit            = db_getsession('DB_instit');
$iAnoUsu            = db_getsession("DB_anousu");

$oRetorno           = new stdClass();
$oRetorno->status   = 1;
$sNomeArqDespesa    = "Siope-despesa";
$sNomeArqReceita    = "Siope-receita";
$sNomeZip           = "Siope";

switch ($oParam->exec) {

    case 'gerarSiope':

        try {

            if (count($oParam->arquivos) > 0) {

                $sArquivosZip = "";

                foreach ($oParam->arquivos as $index => $sArquivo) {

                    if ($sArquivo == 'despesa') {

                        if (file_exists("model/contabilidade/arquivos/siope/{$iAnoUsu}/SiopeDespesa.model.php")) {

                            require_once("model/contabilidade/arquivos/siope/{$iAnoUsu}/SiopeDespesa.model.php");

                            $siopeDespesa = new SiopeDespesa;
                            $siopeDespesa->setAno($iAnoUsu);
                            $siopeDespesa->setInstit($iInstit);
                            $siopeDespesa->setBimestre($iBimestre);
                            $siopeDespesa->setPeriodo();
                            $siopeDespesa->setFiltros();
                            if ($iAnoUsu <= 2020) {
                                $siopeDespesa->setOrcado();
                            }
                            $siopeDespesa->setDespesas();
                            $siopeDespesa->agrupaDespesas();
                            $siopeDespesa->geraLinhaVazia();
                            $siopeDespesa->ordenaDespesas();
                            $siopeDespesa->setNomeArquivo($sNomeArqDespesa);
                            $siopeDespesa->gerarSiope();

                            if ($siopeDespesa->status == 2) {
                                $oRetorno->message = "Não foi possível gerar a Despesa. De/Para dos seguintes elementos não encontrado: {$siopeDespesa->sMensagem}";
                                $oRetorno->status = 2;
                            }

                            if ($siopeDespesa->getErroSQL() > 0) {
                                throw new Exception ("Ocorreu um erro ao gerar Siope " . $siopeDespesa->getErroSQL());
                            }

                            $oRetorno->arquivos->$index->nome = "{$siopeDespesa->getNomeArquivo()}.csv";
                            $sArquivosZip .= " {$siopeDespesa->getNomeArquivo()}.csv ";

                        } else {
                            throw new Exception("Arquivos Siope Despesa não encontrados para o ano $iAnoUsu.");
                        }

                    }

                    if ($sArquivo == 'receita') {

                        if (file_exists("model/contabilidade/arquivos/siope/{$iAnoUsu}/SiopeReceita.model.php")) {

                            require_once("model/contabilidade/arquivos/siope/{$iAnoUsu}/SiopeReceita.model.php");

                            $siopeReceita = new SiopeReceita;
                            $siopeReceita->setAno($iAnoUsu);
                            $siopeReceita->setInstit($iInstit);
                            $siopeReceita->setBimestre($iBimestre);
                            $siopeReceita->setPeriodo();
                            $siopeReceita->setFiltros();
                            if ($iAnoUsu <= 2020) {
                                $siopeReceita->setOrcado();
                            }
                            $siopeReceita->setReceitas();
                            $siopeReceita->agrupaReceitas();
                            $siopeReceita->ordenaReceitas();
                            $siopeReceita->setNomeArquivo($sNomeArqReceita);
                            $siopeReceita->gerarSiope();

                            if ($siopeReceita->status == 2) {
                                $oRetorno->message = "Não foi possível gerar a Receita. De/Para dos seguintes estruturais não encontrado: {$siopeReceita->sMensagem}";
                                $oRetorno->status = 2;
                            }

                            if ($siopeReceita->getErroSQL() > 0) {
                                throw new Exception ("Ocorreu um erro ao gerar Siope " . $siopeReceita->getErroSQL());
                            }

                            $oRetorno->arquivos->$index->nome = "{$siopeReceita->getNomeArquivo()}.csv";
                            $sArquivosZip .= " {$siopeReceita->getNomeArquivo()}.csv ";

                        } else {
                            throw new Exception("Arquivos Siope Receita não encontrados para o ano $iAnoUsu.");
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
