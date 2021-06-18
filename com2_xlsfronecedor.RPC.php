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
include("libs/PHPExcel/Classes/PHPExcel.php");
require_once("classes/db_pcorcam_classe.php");
require_once("classes/db_pcorcamitem_classe.php");

$oJson             = new services_json();
//$oParam            = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\","",$_POST["json"])));
$oParam           = $oJson->decode(str_replace("\\","",$_POST["json"]));
$oErro             = new stdClass();
$oRetorno          = new stdClass();
$oRetorno->status  = 1;

/**
 * matriz de entrada
 */
$what = array( ',','-','/',chr(13),chr(10),"'");

/**
 * matriz de saida
 */
$by   = array( '','','');

switch($oParam->exec) {

    case 'importar':

        $clpcorcam   = new cl_pcorcam();
        $erro = false;
        $result_fornecedores = $clpcorcam->sql_record($clpcorcam->sql_query_pcorcam_itemsol(null,"DISTINCT pc22_codorc,pc81_codproc,z01_nome,z01_cgccpf,pc21_orcamforne",null,"pc20_codorc = $oParam->pc20_codorc AND pc21_orcamforne = $oParam->pc21_orcamforne"));
        db_fieldsmemory($result_fornecedores,0);

        //monto o nome do arquivo
        $dir = "libs/Pat_xls_import/";
        $files1 = scandir($dir,1);
        $arquivo = "libs/Pat_xls_import/".$files1[0];

        //verificar se existe o arquivo
        if (!file_exists($arquivo)) {
            $oRetorno->status = 2;
            $oRetorno->message = urlencode("Erro ! Arquivo de planilha nao existe.");
            $erro = true;
        }else{
            $objPHPExcel = PHPExcel_IOFactory::load($arquivo);
            $objWorksheet = $objPHPExcel->getActiveSheet();

            //monto array com todos as linhas da planilha
            foreach ($objWorksheet->getRowIterator() as $row) {
                $rowIndex = $row->getRowIndex();
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(True); //varre todas as células
                foreach ($cellIterator as $cell) {
                    $colIndex = PHPExcel_Cell::columnIndexFromString($cell->getColumn());
                    $val = $cell->getValue();
                    $dataArr[$rowIndex][$colIndex] = $val;
                }
            }

            //valido cgccpf do fornecedor
            if($z01_cgccpf != iconv('UTF-8', 'ISO-8859-1//IGNORE',str_replace($what, $by, $dataArr[5][5]))){
                $oRetorno->status = 2;
                $oRetorno->message = urlencode("Erro ! CPF/CNPJ da planilha:".$dataArr[5][5]." diferente do CPF/CNPJ do fornecedor:".$z01_cgccpf.".");
                $erro = true;
            }
            $arrayItensPlanilha = array();

            foreach ($dataArr as $keyRow => $Row){

                if($keyRow >= 8){
                    $objItensPlanilha = new stdClass();
                    foreach ($Row as $keyCel => $cell){
                        if($keyCel == 1){
                            //busco codigo do item na tabela orcamitem para preencher valor dos itens na tela
                            $rsOrcamitem = $clpcorcam->sql_record($clpcorcam->sql_query_pcorcam_itemsol(null,"pc22_orcamitem",null,"pc20_codorc = $oParam->pc20_codorc AND pc21_orcamforne = $oParam->pc21_orcamforne AND pc01_codmater = $cell"));
                            $objItensPlanilha->item =  db_utils::fieldsMemory($rsOrcamitem, 0)->pc22_orcamitem;
                            if($objItensPlanilha->item == null){
                                $oRetorno->status = 2;
                                $oRetorno->message = urlencode("Erro! Item:".$cell." invalido para o orçamento verifique a planilha.");
                                $erro = true;
                            }
                        }
                        if($keyCel == 14){
                            $objItensPlanilha->quantidade    =  $cell;
                        }
                        if($keyCel == 15){
                            $objItensPlanilha->valorunitario =  $cell == null ? 0 : $cell;
                        }
                        if($keyCel == 18){
                            $objItensPlanilha->marca         =  $cell == null ? '' : $cell;
                        }
                    }
                    $arrayItensPlanilha[] = $objItensPlanilha;
                }
            }

            //apago o arquivo se ocorreu tudo certo
            if($erro == false){
                unlink($arquivo);
            }
            $arrayItens = array_pop($arrayItensPlanilha);
            $oRetorno->itens = $arrayItensPlanilha;
        }
        break;
    case 'importarlicitacao':

        $clpcorcamitem   = new cl_pcorcamitem();
        $erro = false;
        $result_fornecedores = $clpcorcamitem->sql_record($clpcorcamitem->sql_query_pcmaterlic(null,"DISTINCT pc22_codorc,pc81_codproc,z01_nome,z01_cgccpf,pc21_orcamforne",null,"pc20_codorc = $oParam->pc20_codorc AND pc21_orcamforne = $oParam->pc21_orcamforne"));
        db_fieldsmemory($result_fornecedores,0);

        //monto o nome do arquivo
        $dir = "libs/Pat_xls_import/";
        $files1 = scandir($dir,1);
        $arquivo = "libs/Pat_xls_import/".$files1[0];

        //verificar se existe o arquivo
        if (!file_exists($arquivo)) {
            $oRetorno->status = 2;
            $oRetorno->message = urlencode("Erro ! Arquivo de planilha nao existe.");
            $erro = true;
        }else{
            $objPHPExcel = PHPExcel_IOFactory::load($arquivo);
            $objWorksheet = $objPHPExcel->getActiveSheet();

            //monto array com todos as linhas da planilha
            foreach ($objWorksheet->getRowIterator() as $row) {
                $rowIndex = $row->getRowIndex();
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(True); //varre todas as células
                foreach ($cellIterator as $cell) {
                    $colIndex = PHPExcel_Cell::columnIndexFromString($cell->getColumn());
                    $val = $cell->getValue();
                    $dataArr[$rowIndex][$colIndex] = $val;
                }
            }
            //valido cgccpf do fornecedor
            if($z01_cgccpf != iconv('UTF-8', 'ISO-8859-1//IGNORE',str_replace($what, $by, $dataArr[5][5]))){
                $oRetorno->status = 2;
                $oRetorno->message = urlencode("Erro ! CPF/CNPJ da planilha:".$dataArr[5][5]." diferente do CPF/CNPJ do fornecedor:".$z01_cgccpf.".");
                $erro = true;
            }

            $arrayItensPlanilha = array();
            foreach ($dataArr as $keyRow => $Row){

                if($keyRow >= 8){
                    $objItensPlanilha = new stdClass();
                    foreach ($Row as $keyCel => $cell){
                        if($keyCel == 1){
                            //busco codigo do item na tabela orcamitem para preencher valor dos itens na tela
                            $rsOrcamitem = $clpcorcamitem->sql_record($clpcorcamitem->sql_query_pcmaterlic(null,"pc22_orcamitem",null,"pc20_codorc = $oParam->pc20_codorc AND pc21_orcamforne = $oParam->pc21_orcamforne AND pc01_codmater = $cell"));
                            $objItensPlanilha->item =  db_utils::fieldsMemory($rsOrcamitem, 0)->pc22_orcamitem;
                            if($objItensPlanilha->item == null){
                                $oRetorno->status = 2;
                                $oRetorno->message = urlencode("Erro! Item:".$cell." invalido para o orçamento verifique a planilha.");
                                $erro = true;
                            }
                        }
                        if($keyCel == 14){
                            $objItensPlanilha->quantidade    =  $cell;
                        }
                        if($keyCel == 15){
                            $objItensPlanilha->valorunitario =  $cell == null ? 0 : $cell;
                        }
                        if($keyCel == 18){
                            $objItensPlanilha->marca         =  $cell == null ? '' : $cell;
                        }
                    }
                    $arrayItensPlanilha[] = $objItensPlanilha;
                }
            }

            //apago o arquivo se ocorreu tudo certo
            if($erro == false) {
                unlink($arquivo);
            }
            $arrayItens = array_pop($arrayItensPlanilha);

            $oRetorno->itens = $arrayItensPlanilha;
        }
        break;
}
echo json_encode($oRetorno);