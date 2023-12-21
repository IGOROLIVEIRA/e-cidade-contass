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
require_once("classes/db_veicretirada_classe.php");
require_once("classes/db_veicdevolucao_classe.php");
require_once("classes/db_veiculos_classe.php");
require_once("classes/db_cgm_classe.php");
require_once("classes/db_veicmotoristas_classe.php");
require_once("classes/db_veicabast_classe.php");
require_once("classes/db_empempenho_classe.php");
require_once("classes/db_empveiculos_classe.php");
require_once("classes/db_empresto_classe.php");
require_once("classes/db_veiccadposto_classe.php");
require_once("classes/db_veicabastposto_classe.php");
require_once("classes/db_veiccadpostoexterno_classe.php");
require_once("classes/db_veicabastretirada_classe.php");
require_once("classes/db_veicbaixa_classe.php");
require_once("classes/db_veiccentral_classe.php");
require_once("classes/db_veiccadcentral_classe.php");
require_once("classes/db_veiccadcomb_classe.php");
require_once("classes/db_veicparam_classe.php");
require_once("classes/db_veicmanutencaomedida_classe.php");


$oJson             = new services_json();
//$oParam            = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\","",$_POST["json"])));
$oParam           = $oJson->decode(str_replace("\\", "", $_POST["json"]));
$oErro             = new stdClass();
$oRetorno          = new stdClass();
$oRetorno->status  = 1;

$clveicretirada    = new cl_veicretirada();
$clveiculos        = new cl_veiculos();
$clcgm             = new cl_cgm();
$clveicmotoristas  = new cl_veicmotoristas();
$clveicdevolucao   = new cl_veicdevolucao();
$clveicabast       = new cl_veicabast();
$clempempenho      = new cl_empempenho();
$clempempenho1     = new cl_empempenho();
$clempveiculos     = new cl_empveiculos();
$clempresto        = new cl_empresto();
$clveiccadposto    = new cl_veiccadposto();
$clveicabastposto  = new cl_veicabastposto();
$clveiccadpostoexterno  = new cl_veiccadpostoexterno();
$clveicabastretirada    = new cl_veicabastretirada();
$clveicbaixa            = new cl_veicbaixa();
$clveiccentral          = new cl_veiccentral();
$clveiccadcentral       = new cl_veiccadcentral();
$clveiccadcomb          = new cl_veiccadcomb();
$clveicparam             = new cl_veicparam();
$clveicmanutencaomedida  = new cl_veicmanutencaomedida;



/**
 * matriz de entrada
 */
$what = array(',', '-', '/', chr(13), chr(10), "'");

/**
 * matriz de saida
 */
$by   = array('', '', '');

$resultadoPlanilha = $oParam->valor;
$resultadoEmpenho = $oParam->itensEmpenho;
$dataI = $oParam->dataI;
$dataF = $oParam->dataF;

switch ($oParam->exec) {

    case 'validacaoAbastecimentoPorEmpenho':

        $rsVeicparam = $clveicparam->sql_record($clveicparam->sql_query_file(null, "*", null, "ve50_instit = " . db_getsession("DB_instit")));
        $ve50_abastempenho = db_utils::fieldsMemory($rsVeicparam, 0)->ve50_abastempenho;

        if($ve50_abastempenho == 1){

            $aEmpenhosInvalidos = array();

            foreach ($resultadoEmpenho as $empenhoDoAbastecimento) {

                $aEmpenho = explode("/", $empenhoDoAbastecimento);
                $e60_codemp = $aEmpenho[0];
                $e60_anousu = $aEmpenho[1];

                $rsEmpenho = $clempempenho->sql_record($clempempenho->sql_query(null, "e60_emiss", null, "e60_codemp like '$e60_codemp' and e60_anousu = $e60_anousu and e60_instit = ". db_getsession('DB_instit')));
                $e60_emiss = db_utils::fieldsMemory($rsEmpenho, 0)->e60_emiss;
                $ve50_datacorte = db_utils::fieldsMemory($rsVeicparam, 0)->ve50_datacorte;

                if($ve50_datacorte > $e60_emiss){
                    $aEmpenhosInvalidos[] = $empenhoDoAbastecimento;
                }
            }

            $oRetorno->aEmpenhosInvalidos = $aEmpenhosInvalidos;

        }

    break;    

    case 'importar':

        $erro = false;


        //monto o nome do arquivo
        $dir = "libs/Pat_xls_import/";
        $files1 = scandir($dir, 1);
        $arquivo = "libs/Pat_xls_import/" . $files1[0];

        //verificar se existe o arquivo
        if (!file_exists($arquivo)) {
            $oRetorno->status = 2;
            $oRetorno->message = urlencode("Erro ! Arquivo de planilha nao existe.");
            $erro = true;
        } else {
            //verifica empenhos
            $e = 0;
            $data = date("Y-m-d", db_getsession("DB_datausu"));
            $data = explode("-", $data);
            $anoAtual = $data[0];
            $anoAnterior = $data[0] - 1;
            $controleDataEmp = 0;
            $controleDataEmpenho = 0;
            $controleAno = 0;
            $controleVerificarEmp = 0;


            $arrayEmp = array();
            $arrayBaixa = array();
            $arrayVeic = array();
            $opBaixa = 0;
            $opBaixaCompleta = 0;
            $opNumBaixa = 0;
            $opVeic = 0;
            $b = 0;
            $ve = 0;
            $aSaldoUtilizadoPorEmpenho = array();
            $aEmpenhosComSaldoTotalUtilizado = array();

            $resultParam = $clveicparam->sql_record($clveicparam->sql_query_file(null, "*", null, "ve50_instit = " . db_getsession("DB_instit")));
            $resultParamres = db_utils::fieldsMemory($resultParam, 0);
            
            //verifica data do empenho

            foreach($resultadoPlanilha as $key => $row){
                $sEmpenho = $resultadoEmpenho[$key];
                $codEmpenho = explode("/",$resultadoEmpenho[$key]);
                $codEmp = $codEmpenho[0];
                $anoEmp = $codEmpenho[1];

                $rsEmpenho = $clempempenho->sql_record($clempempenho->sql_query_file(null,"e60_emiss,e60_vlremp-e60_vlrutilizado as saldodisponivel",null,"e60_codemp ='$codEmp' and e60_anousu = $anoEmp and e60_instit = " .db_getsession('DB_instit')));
                $resultEmpenho = db_utils::fieldsMemory($rsEmpenho, 0);

                if($resultParamres->ve50_abastempenho == 1 && !in_array($sEmpenho, $oParam->aEmpenhosInvalidos)){

                    if(array_key_exists($sEmpenho, $aSaldoUtilizadoPorEmpenho)){
                        $aSaldoUtilizadoPorEmpenho[$sEmpenho] += $row->valor;
                    }

                    if(!array_key_exists($sEmpenho, $aSaldoUtilizadoPorEmpenho)){
                        $aSaldoUtilizadoPorEmpenho[$sEmpenho] = $row->valor;
                    } 

                    if($resultEmpenho->saldodisponivel < $aSaldoUtilizadoPorEmpenho[$sEmpenho]){
                        array_push($aEmpenhosComSaldoTotalUtilizado, $sEmpenho);
                    }
                }

                $dtAbastecimento = (implode("/",(array_reverse(explode("-",$row->data)))));
                $dtAbastecimento = DateTime::createFromFormat('d/m/Y', $dtAbastecimento);

                $dtEmpenho = (implode("/",(array_reverse(explode("-",$resultEmpenho->e60_emiss)))));
                $dtEmpenho = DateTime::createFromFormat('d/m/Y', $dtEmpenho);

                if($dtAbastecimento < $dtEmpenho){
                    $controleDataEmpenho = 1;
                }
            }

            if(!empty($aEmpenhosComSaldoTotalUtilizado)){
                $oRetorno->saldoutilizado = $aSaldoUtilizadoPorEmpenho;
                $sEmpenhosComSaldoTotalUtilizado = implode(", ", array_unique($aEmpenhosComSaldoTotalUtilizado));
                $oRetorno->message = urlencode("Usuário: Abastecimento(s): não incluído(s), valor total do(s) abastecimento(s) ultrapassaram o valor disponível no(s) empenho(s): $sEmpenhosComSaldoTotalUtilizado.");
                $erro = true;
                $oRetorno->status = 6;
                break;
            }

            foreach($aSaldoUtilizadoPorEmpenho as $key => $row){
                $sEmpenho = $key;
                $saldoUtilizado = $row;
                if(!in_array($sEmpenho, $aEmpenhosComSaldoTotalUtilizado)){
                    $sEmpenho = explode("/", $sEmpenho);
                    $e60_codemp = $sEmpenho[0];
                    $e60_anousu = $sEmpenho[1];
                    $rsEmpenho = $clempempenho->sql_record($clempempenho->sql_query(null, "*", null, "e60_codemp like '$e60_codemp' and e60_anousu = $e60_anousu and e60_instit = ". db_getsession('DB_instit')));
                    $rsEmpenho = db_utils::fieldsMemory($rsEmpenho, 0);
                    $e60_numemp = $rsEmpenho->e60_numemp;
                    $clempempenho->e60_vlrutilizado =  $rsEmpenho->e60_vlrutilizado + $saldoUtilizado;
                    $clempempenho->sql_query_valorutilizado($e60_numemp);
                }              
            }

            //verifica Baixa de Veiculos 
            foreach ($resultadoPlanilha as $row) {
                $opNumBaixa  =  0;
                $test1       = $row->placa;
                $datasaida   = $row->data;
                $hora        = $row->hora;
                $valor       = $row->valor;
                $vUnitario   = floor($row->vUnitario * 100) / 100;
                $litros      = $row->litros;
                $combust     = $row->combust;
                $medidasaida = $row->medidasaida;
                $motorista       = $row->motorista;
                $motoristaNome       = $row->motoristaNome;

                $resultadoVeiculo = $clveiculos->sql_record($clveiculos->sql_query(null, "*", null, "ve01_placa like '$test1'"));


                if ($clveiculos->numrows == 0) {
                    $opVeic = 1;
                    $arrayVeic[$ve][0] = $test1;
                    $ve++;
                } else if ($clveiculos->numrows == 1) {
                    $resultVeiculo = db_utils::fieldsMemory($resultadoVeiculo, 0);
                    $resultadoBaixa = $clveicbaixa->sql_record($clveicbaixa->sql_query_file(null, "*", null, "ve04_veiculo = $resultVeiculo->ve01_codigo"));
                    if ($clveicbaixa->numrows > 0) {
                        $resultBaixa = db_utils::fieldsMemory($resultadoBaixa, 0);
                        $cod1 = $resultBaixa->ve04_veiculo;
                        $arrayBaixa[$b][0]  = $resultBaixa->ve04_veiculo;
                        $arrayBaixa[$b][1]  = $test1;
                        $opBaixa = 1;
                        $b++;
                    }
                } else {
                    for ($i = 0; $i < $clveiculos->numrows; $i++) {
                        $resultVeiculo = db_utils::fieldsMemory($resultadoVeiculo, $i);
                        $resultadoBaixa = $clveicbaixa->sql_record($clveicbaixa->sql_query_file(null, "*", null, "ve04_veiculo = $resultVeiculo->ve01_codigo"));
                        $te = $resultVeiculo->ve01_codigo;
                        if ($clveicbaixa->numrows > 0) {
                            $resultBaixa = db_utils::fieldsMemory($resultadoBaixa, 0);
                            $cod1 = $resultBaixa->ve04_veiculo;
                            $arrayBaixa[$b][0]  = $resultBaixa->ve04_veiculo;
                            $arrayBaixa[$b][1]  = $test1;
                            $opNumBaixa++;
                            $b++;
                        } else {
                            $codVeic = $resultVeiculo->ve01_codigo;
                        }
                    }
                    if ($clveiculos->numrows == $opNumBaixa) {
                        $opBaixaCompleta = 1;
                    }
                }
            }


            if ($opVeic == 1) {
                $arrayRetornoVeiculoN = array();
                foreach ($arrayVeic as $keyRow => $Row) {

                    $objValorPlanilhaVeiculoN = new stdClass();
                    foreach ($Row as $keyCel => $cell) {

                        if ($keyCel == 0) {
                            $objValorPlanilhaVeiculoN->placa    =  $cell;
                        }
                    }
                    $objValorPlanilhaVeiculoN->identificador = 6;
                    $arrayRetornoVeiculoN[] = $objValorPlanilhaVeiculoN;
                }
            }



            if ($opBaixaCompleta == 1 || $opBaixa == 1) {
                $arrayRetornoBaixa = array();
                foreach ($arrayBaixa as $keyRow => $Row) {

                    $objValorPlanilhaBaixa = new stdClass();
                    foreach ($Row as $keyCel => $cell) {

                        if ($keyCel == 0) {
                            $objValorPlanilhaBaixa->codigo    =  $cell;
                        }
                        if ($keyCel == 1) {
                            $objValorPlanilhaBaixa->placa     =  $cell;
                        }
                    }
                    $objValorPlanilhaBaixa->identificador = 4;
                    $arrayRetornoBaixa[] = $objValorPlanilhaBaixa;
                }
            }
            //verifica o ultimo KM
            $arrayKm = array();
            $k = 0;
            $opKm = 0;
            foreach ($resultadoPlanilha as $row) {

                $test1       = $row->placa;
                $datasaida   = $row->data;
                $hora        = $row->hora;
                $valor       = $row->valor;
                $vUnitario   = floor($row->vUnitario * 100) / 100;
                $litros      = $row->litros;
                $combust     = $row->combust;
                $medidasaida = $row->medidasaida;
                $motorista       = $row->motorista;
                $motoristaNome       = $row->motoristaNome;

                $resultadoVeiculo = $clveiculos->sql_record($clveiculos->sql_query(null, "*", null, "ve01_placa like '$test1'"));
                if ($clveiculos->numrows > 1) {
                    for ($i = 0; $i < $clveiculos->numrows; $i++) {
                        $resultVeiculo = db_utils::fieldsMemory($resultadoVeiculo, $i);
                        $resultadoBaixa = $clveicbaixa->sql_record($clveicbaixa->sql_query_file(null, "*", null, "ve04_veiculo = $resultVeiculo->ve01_codigo"));
                        if ($clveicbaixa->numrows == 0) {
                            $codigoVeic = $resultVeiculo->ve01_codigo;
                        }
                    }
                } else {
                    $resultVeiculo = db_utils::fieldsMemory($resultadoVeiculo, 0);
                    $codigoVeic = $resultVeiculo->ve01_codigo;
                }

                $resultadoAbast = $clveicabast->sql_record($clveicabast->sql_query_valorMax(null, "max(veicabast.ve70_codigo)", null, "ve70_veiculos = $codigoVeic"));
                $resultAbaste = db_utils::fieldsMemory($resultadoAbast, 0);

                $resultdatamanumedida = $clveicmanutencaomedida->sql_record("select ve66_data from veicmanutencaomedida where ve66_sequencial = (select max(ve66_sequencial) from veicmanutencaomedida where ve66_veiculo = $codigoVeic and ve66_ativo = 't')");
                $oDatamanumedida = db_utils::fieldsMemory($resultdatamanumedida, 0);
                $resultdataultabast = $clveicabast->sql_record("select ve70_dtabast from veicabast where ve70_codigo = (select max(veicabast.ve70_codigo)from veicabast where ve70_veiculos = $codigoVeic)");
                $oDataultimoabast = db_utils::fieldsMemory($resultdataultabast, 0);
                $resultdatanter = $clveicmanutencaomedida->sql_record("select ve70_medida,ve70_dtabast,ve70_hora,ve70_veiculos from veicabast where ve70_veiculos = $codigoVeic and ve70_dtabast<='$datasaida' union select '0' as ve66_medidaanterior,ve66_data,ve66_hora,ve66_veiculo from veicmanutencaomedida where ve66_veiculo=$codigoVeic and ve66_data<='$datasaida' order by ve70_dtabast DESC,ve70_medida limit 1");
                $oDatanter = db_utils::fieldsMemory($resultdatanter, 0);
                $medidaanterior = $oDatanter->ve70_medida;
                if(pg_num_rows($resultdatanter)==0){
                    $medidaanterior=0;
                }
                $resultdatapost = $clveicmanutencaomedida->sql_record("select ve70_medida,ve70_dtabast,ve70_hora,ve70_veiculos from veicabast where ve70_veiculos = $codigoVeic and ve70_dtabast>='$datasaida' and ve70_medida<>$oDatanter->ve70_medida  union select '0' as ve66_medidaanterior,ve66_data,ve66_hora,ve66_veiculo from veicmanutencaomedida where ve66_veiculo=$codigoVeic and ve66_data>='$datasaida' and ve66_medidaanterior <>$oDatanter->ve70_medida order by ve70_dtabast ASC,ve70_medida limit 1");
                $oDatapost = db_utils::fieldsMemory($resultdatapost, 0);
                $medidaposterior = $oDatapost->ve70_medida;
                if(pg_num_rows($resultdatapost)==0){
                    $medidaposterior=0;
                }

                if ($medidaanterior > $medidasaida || ($medidaposterior < $medidasaida && $medidaposterior != 0)) {
                    $arrayKm[$k][0]  = $codigoVeic;
                    $arrayKm[$k][1]  = $test1;
                    $arrayKm[$k][2]  = $medidasaida;
                    $arrayKm[$k][3]  = $resultAbaste->ve70_medida;
                    $opKm = 1;
                    $k++;
                }
            }

            if ($opKm == 1) {
                $arrayRetornoKm = array();
                //echo "<pre>"; print_r($arrayKm);exit;
                foreach ($arrayKm as $keyRow => $Row) {

                    $objValorPlanilhaKm = new stdClass();
                    foreach ($Row as $keyCel => $cell) {

                        if ($keyCel == 0) {
                            $objValorPlanilhaKm->codigo    =  $cell;
                        }
                        if ($keyCel == 1) {
                            $objValorPlanilhaKm->placa     =  $cell;
                        }
                        if ($keyCel == 2) {
                            $objValorPlanilhaKm->km     =  $cell;
                        }
                        if ($keyCel == 3) {
                            $objValorPlanilhaKm->kmfinal     =  $cell;
                        }
                    }
                    $objValorPlanilhaKm->identificador = 5;
                    $arrayRetornoKm[] = $objValorPlanilhaKm;
                }
            }

            foreach ($resultadoEmpenho as $row) {
                $valorEm[$e] = $row;
                $codemp = explode("/", $valorEm[$e]);
                $codEmp = $codemp[0];
                $anoEmp = $codemp[1];

                $resultadoEm = $clempempenho->sql_record($clempempenho->sql_query(null, "*", null, "e60_codemp like '$codEmp' and e60_anousu = $anoEmp and e60_instit = ". db_getsession('DB_instit')));
                $resultEm = db_utils::fieldsMemory($resultadoEm, 0);

                $resultParam = $clveicparam->sql_record($clveicparam->sql_query_file(null, "*", null, "ve50_instit = " . db_getsession("DB_instit")));
                $resultParamres = db_utils::fieldsMemory($resultParam, 0);

                $quantidade = count($arrayValores);
                $opEmpenho = 0;
                $controleData = 0;
                if ($resultParamres->ve50_abastempenho == 1) {
                        if ($quantidade > 0) {
                            for ($i = 0; $i < $quantidade; $i++) {
                                if ($arrayValores[$i][0] == $resultEm->e60_numemp) {
                                    $opEmpenho = 1;
                                    break;
                                }
                            }
                            if ($opEmpenho == 0) {
                                if ($resultEm->e60_vlrutilizado == "" || $resultEm->e60_vlrutilizado == 0) {
                                    $sql = "select si05_codabast from empveiculos where si05_numemp = $resultEm->e60_numemp";

                                    $result = db_query($sql);
                                    $soma = 0;
                                    for ($i = 0; $i < pg_num_rows($result); $i++) {
                                        $rsAbastecimento = db_utils::fieldsMemory($result, $i);
                                        $sql = "select ve70_valor from veicabast where ve70_codigo = $rsAbastecimento->si05_codabast";
                                        $result1 = db_query($sql);
                                        $rsAbastecimento1 = db_utils::fieldsMemory($result1, 0);

                                        $valorutilizado += $rsAbastecimento1->ve70_valor;
                                    }
                                    $valorautilizar = $resultEm->e60_vlremp - $valorutilizado;
                                    $arrayValores[$j][0] = $resultEm->e60_numemp;
                                    $arrayValores[$j][1] = $valorautilizar;
                                    $arrayValores[$j][2] = $codEmp;
                                    $j++;
                                } else {
                                    $arrayValores[$j][0] = $resultEm->e60_numemp;
                                    $arrayValores[$j][1] = $resultEm->e60_vlremp - $resultEm->e60_vlrutilizado;
                                    $arrayValores[$j][2] = $codEmp;
                                    $j++;
                                }
                            }
                        } else {
                            if ($resultEm->e60_vlrutilizado == "" || $resultEm->e60_vlrutilizado == 0) {
                                $sql = "select si05_codabast from empveiculos where si05_numemp = $resultEm->e60_numemp";

                                $result = db_query($sql);
                                $soma = 0;
                                for ($i = 0; $i < pg_num_rows($result); $i++) {
                                    $rsAbastecimento = db_utils::fieldsMemory($result, $i);
                                    $sql = "select ve70_valor from veicabast where ve70_codigo = $rsAbastecimento->si05_codabast";
                                    $result1 = db_query($sql);
                                    $rsAbastecimento1 = db_utils::fieldsMemory($result1, 0);

                                    $valorutilizado += $rsAbastecimento1->ve70_valor;
                                }
                                $valorautilizar = $resultEm->e60_vlremp - $valorutilizado;
                                $arrayValores[$j][0] = $resultEm->e60_numemp;
                                $arrayValores[$j][1] = $valorautilizar;
                                $arrayValores[$j][2] = $codEmp;
                                $j++;
                            } else {
                                $arrayValores[$j][0] = $resultEm->e60_numemp;
                                $arrayValores[$j][1] = $resultEm->e60_vlremp - $resultEm->e60_vlrutilizado;
                                $arrayValores[$j][2] = $codEmp;
                                $j++;
                            }
                        }
                }
                //final 

                if ($clempempenho->numrows == 0) {
                    $controleVerificarEmp = 1;
                    $arrayEmp[] = $codEmp . "/" . $anoEmp;
                }

                if ($anoAtual != $anoEmp && $anoAnterior != $anoEmp) {
                    $controleDataEmp = 1;
                }
                $filtroempelemento = 1;
                $data = date('d/m/Y');
                $resultadoEmpenhoo = $clempempenho1->sql_record($clempempenho1->sql_query(null, "*", null, "e60_instit = " .db_getsession('DB_instit'). " and elementoempenho.o56_elemento in ('3339030010000','3390330100000','3390339900000','3339033990000','3339030030000','3339092000000','3339033000000','3339093010000','3339093020000','3339093030000','3339039990000') AND ((date_part('year', empempenho.e60_emiss) < date_part('year', date '$data') AND date_part('month', empempenho.e60_emiss) <= 12)
                    OR (date_part('year', empempenho.e60_emiss) = date_part('year', date '$data') AND date_part('month', empempenho.e60_emiss) <= date_part('month', date '$data'))) and e60_codemp like '$codEmp' and e60_anousu = $anoEmp", $filtroempelemento));
                $resultEmpenho = db_utils::fieldsMemory($resultadoEmpenhoo, 0);

                if ($clempempenho1->numrows == 0) {
                    $controleAno = 2;
                }

                if ($anoAnterior == $anoEmp) {
                    $resultadoEmpenhoo = $clempempenho->sql_record($clempempenho->sqlQueryValidacaoEmpenhoAnoAnterior(null, "*", null, "e60_instit = " .db_getsession('DB_instit'). " and e60_codemp like '$codEmp' and e60_anousu = $anoEmp and orcelemento.o56_elemento in ('3339030010000','3390330100000','3390339900000','3339033990000','3339030030000','3339092000000','3339033000000','3339093010000','3339093020000','3339093030000','3449030000000','3339039990000') or orcelemento.o56_elemento like '335041%'"));
                    $resultEmpenho = db_utils::fieldsMemory($resultadoEmpenhoo, 0);
                    
                    if ($clempempenho->numrows == 0) {
                        $controleAno = 1;
                    }

                    $resultadoEmpresto = $clempresto->sql_record($clempresto->sql_query(null, $resultEmpenho->e60_numemp, "*", ""));
                    $resultEmpre = db_utils::fieldsMemory($resultadoEmpresto, 0);


                    $objItensEmpAno = new stdClass();
                    foreach ($Row as $keyCel => $cell) {

                        if ($keyCel == 0) {
                            $objItensEmpAno->emp   =  $cell;
                        }
                    }

                    $arrayRetornoEmpAno[] = $objItensEmpAno;
                }
            }
            //mudança
            if ($resultParamres->ve50_abastempenho == 1) {
                $deixarInserir = 0;
                for ($i = 0; $i < count($arrayValoresEmpenhos); $i++) {
                    if ($arrayValoresEmpenhos[$i][0] == $arrayValores[$i][0]) {
                        if ($arrayValoresEmpenhos[$i][1] > $arrayValores[$i][1]) {
                            $deixarInserir = 1;
                        }
                    }
                }

                if ($deixarInserir == 1) {
                    $arrayRetornoSoma = array();
                    foreach ($arrayValores as $keyRow => $Row) {


                        $objItensSoma = new stdClass();
                        foreach ($Row as $keyCel => $cell) {

                            if ($keyCel == 0) {
                                $objItensSoma->numemp   =  $cell;
                            }
                            if ($keyCel == 1) {
                                $objItensSoma->liberado     =  $cell;
                            }
                            if ($keyCel == 2) {
                                $objItensSoma->codemp     =  $cell;
                            }
                        }
                        $objItensSoma->identificador = 8;
                        $arrayRetornoSoma[] = $objItensSoma;
                    }
                }
            }

            //verifica se possui lançamentos com datas informadas
            $arrayValoresLancados = array();
            $resultadoAbaste = $clveicabast->sql_record($clveicabast->sql_query_AbasData(null, "*", null, "ve70_dtabast BETWEEN '$dataI' AND '$dataF'"));
            $controleIguais = 0;
            $v = 0;
            for ($i = 0; $i < $clveicabast->numrows; $i++) {
                $resultAbast = db_utils::fieldsMemory($resultadoAbaste, $i);
                $nuCodigo = $resultAbast->ve70_codigo;
                $nuVeiculo = $resultAbast->ve70_veiculos;
                $dataAbast = $resultAbast->ve70_dtabast;
                $nLitros = $resultAbast->ve70_litros;
                $nValor = $resultAbast->ve70_valor;


                foreach ($resultadoPlanilha as $row) {
                    $placa       = $row->placa;
                    $datasaida   = $row->data;
                    $hora        = $row->hora;
                    $valor       = $row->valor;
                    $litros      = $row->litros;

                    $resultadoVeiculo = $clveiculos->sql_record($clveiculos->sql_query(null, "*", null, "ve01_placa like '$placa'"));
                    $resultVeiculo = db_utils::fieldsMemory($resultadoVeiculo, 0);

                    if (strtotime($dataAbast) == strtotime($datasaida)) {

                        if ($resultVeiculo->ve01_codigo == $nuVeiculo) {

                            if ($valor == $nValor) {

                                if ($nLitros == $litros) {
                                    $controleIguais = 1;
                                    $arrayValoresLancados[$v][0]  = $nuCodigo;
                                    $arrayValoresLancados[$v][1]  = $datasaida;
                                    $arrayValoresLancados[$v][2]  = $valor;
                                    $arrayValoresLancados[$v][3]  = $nLitros;
                                    $v++;
                                }
                            }
                        }
                    }
                }
            }
            if ($controleIguais == 1) {
                $arrayRetornoIguais = array();
                foreach ($arrayValoresLancados as $keyRow => $Row) {

                    $objValorPlanilha = new stdClass();
                    foreach ($Row as $keyCel => $cell) {

                        if ($keyCel == 0) {
                            $objValorPlanilha->placa      =  $cell;
                        }
                        if ($keyCel == 1) {
                            $objValorPlanilha->data     =  $cell;
                        }
                        if ($keyCel == 2) {
                            $objValorPlanilha->valor     =  $cell;
                        }
                        if ($keyCel == 3) {
                            $objValorPlanilha->litros     =  $cell;
                        }
                    }
                    $objValorPlanilha->identificador = 1;
                    $arrayRetornoIguais[] = $objValorPlanilha;
                }
            }


            $arrayItensPlanilha = array();
            $arrayItensPlanilhaMotorista = array();

            $i = 0;
            $controle = 0;
            $j = 0;
            $h = 0;

            //Verifica se exite devolução em aberto
            foreach ($resultadoPlanilha as $row) {

                $test1       = $row->placa;
                $datasaida   = $row->data;
                $hora        = $row->hora;
                $valor       = $row->valor;
                $vUnitario   = floor($row->vUnitario * 100) / 100;
                $litros      = $row->litros;
                $combust     = $row->combust;
                $medidasaida = $row->medidasaida;
                $motorista       = $row->motorista;
                $motoristaNome       = $row->motoristaNome;


                if ($codVeic == null) {
                    //faz a busca do veiculo por placa 
                    $resultadoVeiculo = $clveiculos->sql_record($clveiculos->sql_query(null, "*", null, "ve01_placa like '$test1'"));
                    $resultVeiculo = db_utils::fieldsMemory($resultadoVeiculo, 0);

                    //verifica se veiculo já possui retirada
                    $resultadoRetirada = $clveicretirada->sql_record($clveicretirada->sql_query(null, "max(veicretirada.ve60_codigo)", null, "ve60_veiculo = $resultVeiculo->ve01_codigo"));
                    $resultRetirada = db_utils::fieldsMemory($resultadoRetirada, 0);
                } else {
                    //verifica se veiculo já possui retirada
                    $resultadoRetirada = $clveicretirada->sql_record($clveicretirada->sql_query(null, "max(veicretirada.ve60_codigo)", null, "ve60_veiculo = $codVeic"));
                    $resultRetirada = db_utils::fieldsMemory($resultadoRetirada, 0);
                }




                $resultadoMot1 = $clcgm->sql_record($clcgm->sql_query(null, "*", null, "z01_cgccpf = '$motorista'"));
                $verificaMotor = 0;
                for ($i = 0; $i < pg_num_rows($resultadoMot1); $i++) {
                    $resultadoMot2 = db_utils::fieldsMemory($resultadoMot1, $i);
                    $resultadoMotCod = $clveicmotoristas->sql_record($clveicmotoristas->sql_query(null, "*", null, "ve05_numcgm = $resultadoMot2->z01_numcgm"));
                    $resultMotCod = db_utils::fieldsMemory($resultadoMotCod, 0);

                    if ($resultMotCod->ve05_codigo != "") {
                        $verificaMotor = 1;
                    }
                }

                /*if($clveicmotoristas->numrows == 0){
                echo"<pre>";
                var_dump($clcgm->sql_query(null,"*",null,"z01_cgccpf = '$motorista'")."-".$clveicmotoristas->sql_query(null,"*",null,"ve05_numcgm = $resultadoMot2->z01_numcgm"));
                exit;
            }*/


                if ($verificaMotor == 0) {
                    $controle1 = 1;
                    $arrayItensPlanilhaMotorista[$h][0] = $motorista;
                    $arrayItensPlanilhaMotorista[$h][1] = $motoristaNome;
                    $h++;
                }



                if ($resultRetirada->max != "") {
                    $resultadoDevolucao = $clveicdevolucao->sql_record($clveicdevolucao->sql_query(null, "*", null, "ve61_veicretirada = $resultRetirada->max"));
                    $resultDevolucao = db_utils::fieldsMemory($resultadoDevolucao, 0);

                    if ($clveicdevolucao->numrows == 0) {
                        $controle = 1;
                        $arrayItensPlanilha[$j][0] = $test1;
                        $arrayItensPlanilha[$j][1] = $resultVeiculo->ve01_codigo;
                        $j++;
                    }
                }
            }
            if ($controle == 1) {

                $arrayRetornoPlanilha = array();
                foreach ($arrayItensPlanilha as $keyRow => $Row) {


                    $objItensPlanilha = new stdClass();
                    foreach ($Row as $keyCel => $cell) {

                        if ($keyCel == 0) {
                            $objItensPlanilha->placa      =  $cell;
                        }
                        if ($keyCel == 1) {
                            $objItensPlanilha->codigo     =  $cell;
                        }
                    }
                    $objItensPlanilha->identificador = 2;
                    $arrayRetornoPlanilha[] = $objItensPlanilha;
                }
            }

            if ($controle1 == 1) {

                $arrayRetornoPlanilhaMoto = array();
                foreach ($arrayItensPlanilhaMotorista as $keyRow => $Row) {


                    $objItensPlanilhaMot = new stdClass();
                    foreach ($Row as $keyCel => $cell) {

                        if ($keyCel == 0) {
                            $objItensPlanilhaMot->cpf      =  $cell;
                        }
                        if ($keyCel == 1) {
                            $objItensPlanilhaMot->motorista     =  $cell;
                        }
                    }
                    $objItensPlanilhaMot->identificador = 3;
                    $arrayRetornoPlanilhaMoto[] = $objItensPlanilhaMot;
                }
            }

            //Valida o tipo de combustivel 
            $arrayComb = array();
            $com = 0;
            $controleCom = 0;
            foreach ($resultadoPlanilha as $row) {

                $placa       = $row->placa;
                $datasaida   = $row->data;
                $hora        = $row->hora;
                $valor       = $row->valor;
                $vUnitario   = floor($row->vUnitario * 100) / 100;
                $litros      = $row->litros;
                $combust     = strtoupper($row->combust);
                $medidasaida = $row->medidasaida;
                $motorista       = $row->motorista;
                $motoristaNome       = $row->motoristaNome;

                $resultadoComb = $clveiccadcomb->sql_record($clveiccadcomb->sql_query(null, "*", null, "ve26_descr like '$combust'"));

                if ($clveiccadcomb->numrows == 0) {
                    $arrayComb[$com][0] = $combust;
                    $arrayComb[$com][1] = $placa;
                    $controleCom = 1;
                    $com++;
                }
            }

            if ($controleCom == 1) {

                $arrayRetornoComb = array();
                foreach ($arrayComb as $keyRow => $Row) {


                    $objItensPlanilhaCom = new stdClass();
                    foreach ($Row as $keyCel => $cell) {

                        if ($keyCel == 0) {
                            $objItensPlanilhaCom->comb      =  $cell;
                        }
                        if ($keyCel == 1) {
                            $objItensPlanilhaCom->placa     =  $cell;
                        }
                    }
                    $objItensPlanilhaCom->identificador = 7;
                    $arrayRetornoComb[] = $objItensPlanilhaCom;
                }
            }

            db_inicio_transacao();

            //após a verificação de todas validações realiza a importar
            /**
             * ###########################################INICIOOO IMPORTACAO#################################################################################
             */

            if ($controle == 0 && $controleDataEmpenho == 0 && $controleDataEmp == 0 && $controleAno == 0  && $controleVerificarEmp == 0 && $controleIguais == 0 && $controle1 == 0 && $opBaixaCompleta == 0 && $opBaixa == 0 && $opKm == 0 && $opVeic == 0 && $controleCom == 0 && $deixarInserir == 0 && $controleData == 0) {
                $emp = 0;
                foreach ($resultadoPlanilha as $chave => $row) {
                    $test1       = $row->placa;
                    $datasaida   = $row->data;
                    $hora        = $row->hora;
                    $valor       = $row->valor;
                    //$vUnitario   = floor($row->vUnitario*100)/100;
                    $vUnitario   = $row->vUnitario;
                    $litros      = $row->litros;
                    $combust     = strtoupper($row->combust);
                    //Busca o codigo do combustivel
                    $resultadoComb     = $clveiccadcomb->sql_record($clveiccadcomb->sql_query(null, "*", null, "ve26_descr like '$combust'"));
                    $resultadoCombCodi = db_utils::fieldsMemory($resultadoComb, 0);
                    $codCombust        = $resultadoCombCodi->ve26_codigo;
                    $medidasaida       = $row->medidasaida;
                    $motorista         = $row->motorista;
                    $nota              = $row->nota;

                    //faz a busca do veiculo por placa
                    //$resultadoVeiculo = $clveiculos->sql_record($clveiculos->sql_query(null,"ve01_codigo,z01_cgccpf",null,"ve01_placa = '$test1'"));
                    $resultadoVeiculo = $clveiculos->sql_record($clveiculos->sql_query(null, "*", null, "ve01_placa like '$test1'"));
                    if ($clveiculos->numrows > 1) {
                        for ($i = 0; $i < $clveiculos->numrows; $i++) {
                            $resultVeiculo = db_utils::fieldsMemory($resultadoVeiculo, $i);
                            $resultadoBaixa = $clveicbaixa->sql_record($clveicbaixa->sql_query_file(null, "*", null, "ve04_veiculo = $resultVeiculo->ve01_codigo"));
                            if ($clveicbaixa->numrows == 0) {
                                $codigoVeic = $resultVeiculo->ve01_codigo;
                            }
                        }
                    } else {
                        $resultVeiculo = db_utils::fieldsMemory($resultadoVeiculo, 0);
                        $codigoVeic = $resultVeiculo->ve01_codigo;
                    }


                    //verifica se veiculo já possui retirada
                    $resultadoRetirada = $clveicretirada->sql_record($clveicretirada->sql_query(null, "max(veicretirada.ve60_codigo)", null, "ve60_veiculo = $codigoVeic"));
                    $resultRetirada = db_utils::fieldsMemory($resultadoRetirada, 0);



                    //Identifica o motorista no cgm
                    $resultadoMotorita = $clcgm->sql_record($clcgm->sql_query(null, "*", null, "z01_cgccpf = '$motorista'"));
                    $resultMotorista = db_utils::fieldsMemory($resultadoMotorita, 0);

                    for ($i = 0; $i < pg_num_rows($resultadoMot1); $i++) {
                        $resultMotorista = db_utils::fieldsMemory($resultadoMotorita, 0);
                        //Identifica Cod do motorista
                        $resultadoMotCod = $clveicmotoristas->sql_record($clveicmotoristas->sql_query(null, "*", null, "ve05_numcgm = $resultMotorista->z01_numcgm"));
                        $resultMotCod = db_utils::fieldsMemory($resultadoMotCod, 0);

                        if ($resultMotCod->ve05_codigo != "") {
                            $motoristaCodigo = $resultMotCod->ve05_codigo;
                        }
                    }

                    //Verifica codigo do departamento de cada veiculo.
                    $resultCodDepart =  $clveiccentral->sql_record($clveiccentral->sql_query_file(null, "*", null, "ve40_veiculos = $codigoVeic"));
                    $resultCodDeparto = db_utils::fieldsMemory($resultCodDepart, 0);

                    $resultDeparta =  $clveiccadcentral->sql_record($clveiccadcentral->sql_query_file(null, "*", null, "ve36_sequencial = $resultCodDeparto->ve40_veiccadcentral"));
                    $resultDepartaCod = db_utils::fieldsMemory($resultDeparta, 0);

                    // Incluir a retirada do veiculo

                    $clveicretirada->ve60_veiculo              = $codigoVeic;
                    $clveicretirada->ve60_veicmotoristas       = $motoristaCodigo;
                    $clveicretirada->ve60_datasaida            = $datasaida;
                    $clveicretirada->ve60_horasaida            = $hora;
                    $clveicretirada->ve60_medidasaida          = $medidasaida;
                    $clveicretirada->ve60_destino              = " ";
                    $clveicretirada->ve60_coddepto             = $resultDepartaCod->ve36_coddepto;
                    $clveicretirada->ve60_data                 = date("Y-m-d", db_getsession("DB_datausu"));
                    $clveicretirada->ve60_hora                 = db_hora();
                    $clveicretirada->ve60_usuario              = db_getsession("DB_id_usuario");
                    $clveicretirada->ve60_destinonovo          = null;
                    $clveicretirada->ve60_importado            = "t";
                    $clveicretirada->incluir(null);
                    
                    $clveicabast                       = new cl_veicabast();
                    $clveicabast->ve70_veiculos        = $codigoVeic;
                    $clveicabast->ve70_veiculoscomb    = $codCombust;
                    $clveicabast->ve70_litros          = $litros;
                    $clveicabast->ve70_valor           = $valor;
                    $clveicabast->ve70_vlrun           = $vUnitario;
                    $clveicabast->ve70_medida          = $medidasaida;
                    $clveicabast->ve70_dtabast         = $datasaida;
                    $clveicabast->ve70_ativo           = 1;
                    $clveicabast->ve70_usuario         = db_getsession("DB_id_usuario");
                    $clveicabast->ve70_data            = date("Y-m-d", db_getsession("DB_datausu"));
                    $clveicabast->ve70_hora            = $hora;
                    $clveicabast->ve70_observacao      = null;
                    $clveicabast->ve70_origemgasto     = 2;
                    $clveicabast->ve70_importado       = "t";
                    $clveicabast->incluir();

                    $codemp = explode("/", $resultadoEmpenho[$chave]);
                    $codEmp = $codemp[0];
                    $anoEmp = $codemp[1];


                    $resultadoEmpenhox = $clempempenho->sql_record($clempempenho->sql_query(null, "*", null, "e60_codemp like '$codEmp' and e60_anousu = $anoEmp"));
                    $resultEmpenho = db_utils::fieldsMemory($resultadoEmpenhox, 0);

                    $clempveiculos->si05_numemp            = $resultEmpenho->e60_numemp;
                    $clempveiculos->si05_atestado          = "t";
                    $clempveiculos->si05_codabast          = $clveicabast->ve70_codigo;
                    $clempveiculos->si05_item_empenho      = "f";
                    $clempveiculos->incluir(null);

                    $emp++;

                    $clveicabastretirada->ve73_veicabast    = $clveicabast->ve70_codigo;
                    $clveicabastretirada->ve73_veicretirada = $clveicretirada->ve60_codigo;
                    $clveicabastretirada->incluir(null);

                    $clveicdevolucao->ve61_veicretirada      = $clveicretirada->ve60_codigo;
                    $clveicdevolucao->ve61_veicmotoristas    = $motoristaCodigo;
                    $clveicdevolucao->ve61_datadevol         = $datasaida;
                    $clveicdevolucao->ve61_horadevol         = $hora;
                    $clveicdevolucao->ve61_usuario           = db_getsession("DB_id_usuario");
                    $clveicdevolucao->ve61_data              = $datasaida;
                    $clveicdevolucao->ve61_hora              = db_hora();
                    $clveicdevolucao->ve61_medidadevol       = $medidasaida;
                    $clveicdevolucao->ve61_importado         = "t";
                    $clveicdevolucao->incluir(null);
                    
                    $verificarposto = $clveiccadpostoexterno->sql_record($clveiccadpostoexterno->sql_query_file(null, "*", null, "ve34_numcgm = $resultEmpenho->e60_numcgm"));
                    if ($clveiccadpostoexterno->numrows == 0) {

                        $clveiccadposto->ve29_tipo = 2;
                        $clveiccadposto->incluir(null);

                        $resultadoPost = $clveiccadposto->sql_record($clveiccadposto->sql_query(null, "max(veiccadposto.ve29_codigo)", null, ""));
                        $resultPost = db_utils::fieldsMemory($resultadoPost, 0);

                        $clveicabastposto->ve71_veicabast = $clveicabast->ve70_codigo;
                        $clveicabastposto->ve71_veiccadposto = $clveiccadposto->ve29_codigo;
                        $clveicabastposto->ve71_nota = $nota;
                        $clveicabastposto->incluir(null);

                        $clveiccadpostoexterno->ve34_veiccadposto = $resultPost->max;
                        $clveiccadpostoexterno->ve34_numcgm = $resultEmpenho->e60_numcgm;
                        $clveiccadpostoexterno->incluir(null);
                    } else {
                        $verificarpostoresult = db_utils::fieldsMemory($verificarposto, 0);

                        $resultadoPost = $clveiccadposto->sql_record($clveiccadposto->sql_query(null, "*", null, "ve29_codigo = $verificarpostoresult->ve34_veiccadposto"));
                        $resultPost = db_utils::fieldsMemory($resultadoPost, 0);

                        $clveicabastposto->ve71_veicabast = $clveicabast->ve70_codigo;
                        $clveicabastposto->ve71_veiccadposto = $resultPost->ve29_codigo;
                        $clveicabastposto->ve71_nota = $nota;
                        $clveicabastposto->incluir(null);
                    }
                    
                    if ($erro == false) {
                        unlink($arquivo);
                    }

                    $oRetorno->status = 3;
                    $oRetorno->message = urlencode("Dados inseridos!!");
                    $erro = false;
                }
            } else {
                if ($opVeic == 1) {
                    if ($erro == false) {
                        unlink($arquivo);
                    }

                    $oRetorno->itens = $arrayRetornoVeiculoN;
                } else if ($controleDataEmpenho == 1){
                    $oRetorno->status = 6;
                    $oRetorno->message = urlencode("Usuário: Data do empenho e posterior a data do abastecimento");
                    $erro = true;
                } else if ($controleAno == 1) {
                    $oRetorno->status = 2;
                    $oRetorno->message = urlencode("Empenho com ano anterior não consta para uso!");
                    $erro = true;
                } else if ($controleAno == 2) {
                    $oRetorno->status = 4;
                    $oRetorno->message = urlencode("Empenho inválido para abastecimento!");
                    $erro = true;
                } else if ($controleVerificarEmp == 1) {
                    $oRetorno->status = 2;
                    $oRetorno->message = urlencode("Empenho inválido: ");
                    $oRetorno->itens = $arrayEmp;
                    $erro = true;
                } else if ($controle == 1) {
                    //apago o arquivo se ocorreu tudo certo
                    if ($erro == false) {
                        unlink($arquivo);
                    }
                    $erro = true;
                    //$arrayItensPlanilha[] = $objItensPlanilha;
                    //$arrayItens = array_pop($arrayRetornoPlanilha);

                    $codigo = $arrayRetornoPlanilha[0];

                    //echo "<pre>";
                    //var_dump($codigo->codigo);
                    //exit;    

                    $oRetorno->itens = $arrayRetornoPlanilha;
                } else if ($controleIguais == 1) {
                    //apago o arquivo se ocorreu tudo certo
                    if ($erro == false) {
                        unlink($arquivo);
                    }
                    $erro = true;

                    $oRetorno->itens = $arrayRetornoIguais;
                } else if ($controle1 == 1) {

                    if ($erro == false) {
                        unlink($arquivo);
                    }
                    $erro = true;

                    $oRetorno->itens = $arrayRetornoPlanilhaMoto;
                } else if ($opBaixaCompleta == 1 || $opBaixa == 1) {

                    if ($erro == false) {
                        unlink($arquivo);
                    }
                    $erro = true;

                    $oRetorno->itens = $arrayRetornoBaixa;
                } else if ($opKm == 1) {

                    if ($erro == false) {
                        unlink($arquivo);
                    }
                    $erro = true;

                    $oRetorno->itens = $arrayRetornoKm;
                } else if ($controleCom == 1) {

                    if ($erro == false) {
                        unlink($arquivo);
                    }
                    $erro = true;

                    $oRetorno->itens = $arrayRetornoComb;
                }
            }
        }

        db_fim_transacao($erro);

        break;
}
echo json_encode($oRetorno);
