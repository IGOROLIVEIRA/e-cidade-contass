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
switch($oParam->exec) {

    case 'importar':

        $clpcorcam   = new cl_pcorcam();
        $erro = false;
        $result_fornecedores = $clpcorcam->sql_record($clpcorcam->sql_query_pcorcam_itemsol(null,"DISTINCT pc22_codorc,pc81_codproc,z01_nome,z01_cgccpf,pc21_orcamforne",null,"pc20_codorc = $oParam->pc20_codorc AND pc21_orcamforne = $oParam->pc21_orcamforne"));
        db_fieldsmemory($result_fornecedores,0);

        //monto o nome do arquivo
        $arquivo = "libs/Pat_xls_import/prc_".$pc81_codproc."_".db_getsession('DB_instit')."."."xlsx";

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
            if($z01_cgccpf != $dataArr[4][5]){
                $oRetorno->status = 2;
                $oRetorno->message = urlencode("Erro ! CPF/CNPJ da planilha:".$dataArr[4][5]." difetente do CPF/CNPJ do fornecedor:".$z01_cgccpf.".");
                $erro = true;
            }
            //valido codigo do orcamento do fornecedor

//            if($pc21_orcamforne != $dataArr[3][5]){
//                $oRetorno->status = 2;
//                $oRetorno->message = urlencode("Erro ! Fornecedor da planilha diferente do fornecedor do orçamento.");
//                $erro = true;
//            }

            $arrayItensPlanilha = array();
            foreach ($dataArr as $keyRow => $Row){

                if($keyRow >= 7){
                    $objItensPlanilha = new stdClass();
                    foreach ($Row as $keyCel => $cell){
                        if($keyCel == 1){
                            //busco codigo do item na tabela orcamitem para preencher valor dos itens na tela
                            $rsOrcamitem = $clpcorcam->sql_record($clpcorcam->sql_query_pcorcam_itemsol(null,"pc22_orcamitem",null,"pc20_codorc = $oParam->pc20_codorc AND pc21_orcamforne = $oParam->pc21_orcamforne AND pc01_codmater = $cell"));
                            $objItensPlanilha->item =  db_utils::fieldsMemory($rsOrcamitem, 0)->pc22_orcamitem;
                        }
                        if($keyCel == 8){
                            $objItensPlanilha->quantidade    =  $cell;
                        }
                        if($keyCel == 9){
                            $objItensPlanilha->valorunitario =  $cell == null ? 0 : $cell;
                        }
                        if($keyCel == 11){
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

            $oRetorno->itens = $arrayItensPlanilha;
        }
        break;
    case 'importarlicitacao':

        $clpcorcamitem   = new cl_pcorcamitem();
        $erro = false;
        $result_fornecedores = $clpcorcamitem->sql_record($clpcorcamitem->sql_query_pcmaterlic(null,"DISTINCT pc22_codorc,pc81_codproc,z01_nome,z01_cgccpf,pc21_orcamforne",null,"pc20_codorc = $oParam->pc20_codorc AND pc21_orcamforne = $oParam->pc21_orcamforne"));
        db_fieldsmemory($result_fornecedores,0);

        //monto o nome do arquivo
        $arquivo = "libs/Pat_xls_import/licprc_".$pc81_codproc."_".db_getsession('DB_instit')."."."xlsx";

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

            if($z01_cgccpf != $dataArr[4][5]){
                $oRetorno->status = 2;
                $oRetorno->message = urlencode("Erro ! CPF/CNPJ da planilha:".$dataArr[4][5]." difetente do CPF/CNPJ do fornecedor:".$z01_cgccpf.".");
                $erro = true;
            }
            //valido codigo do orcamento do fornecedor

//            if($pc21_orcamforne != $dataArr[3][5]){
//                $oRetorno->status = 2;
//                $oRetorno->message = urlencode("Erro ! Fornecedor da planilha diferente do fornecedor do orçamento.");
//                $erro = true;
//            }

            $arrayItensPlanilha = array();
            foreach ($dataArr as $keyRow => $Row){

                if($keyRow >= 7){
                    $objItensPlanilha = new stdClass();
                    foreach ($Row as $keyCel => $cell){
                        if($keyCel == 1){
                            //busco codigo do item na tabela orcamitem para preencher valor dos itens na tela
                            $rsOrcamitem = $clpcorcamitem->sql_record($clpcorcamitem->sql_query_pcmaterlic(null,"pc22_orcamitem",null,"pc20_codorc = $oParam->pc20_codorc AND pc21_orcamforne = $oParam->pc21_orcamforne AND pc01_codmater = $cell"));
                            $objItensPlanilha->item =  db_utils::fieldsMemory($rsOrcamitem, 0)->pc22_orcamitem;
                        }
                        if($keyCel == 8){
                            $objItensPlanilha->quantidade    =  $cell;
                        }
                        if($keyCel == 9){
                            $objItensPlanilha->valorunitario =  $cell == null ? 0 : $cell;
                        }
                        if($keyCel == 11){
                            $objItensPlanilha->marca         =  $cell == null ? '' : $cell;
                        }
                    }
                    $arrayItensPlanilha[] = $objItensPlanilha;
                }
            }

            //apago o arquivo se ocorreu tudo certo

            unlink($arquivo);

            $oRetorno->itens = $arrayItensPlanilha;
        }
        break;
}
echo json_encode($oRetorno);