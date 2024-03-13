<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL);
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_libcontabilidade.php");
require_once("libs/db_liborcamento.php");
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_libpostgres.php");
require_once("libs/db_sessoes.php");
require_once("model/padArquivoEscritorXML.model.php");
require_once("model/PadArquivoEscritorCSV.model.php");

$oJson = new services_json();
$oParam = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\", "", $_POST["json"])));


$oArquivoImportado = new stdClass();
$aListaArquivos = array();
$oRetorno = new stdClass();
$oRetorno->status = 1;
$oRetorno->message = 1;
$oRetorno->itens = array();

switch ($oParam->exec) {

    case "importaSicom":

        $path = "importarsicom/";
        $diretorio = dir($path);
        $sArquivo = $diretorio->read();
        while ($tempArquivo = $diretorio->read()) {
            $aTempArquivo = explode('.', $tempArquivo);
            if ($aTempArquivo[1] == 'zip') {
                $sArquivo = $tempArquivo;
            }
        }
        ob_start();
        $aArquivo = explode('_', $sArquivo);
        $tipo = $aArquivo[0];
        $mes = $aArquivo[3];
        $aAno = explode('.', $aArquivo[4]);
        $ano = $aAno[0];

        system("bin/unzip importarsicom/$sArquivo -d importarsicom/");


        ob_end_clean();

        if ($sArquivo == '..') {
            $oRetorno->status = 2;
            $oRetorno->message = 'Envie o arquivo zip para importar!';
        }

        $diretorio = dir($path);

        while ($arquivo = $diretorio->read()) {

            if (strtoupper(substr($arquivo, -3)) == 'CSV') {

                if (($handle = fopen($path . $arquivo, "r")) !== FALSE) {

                    db_inicio_transacao();

                    $iCtrDelete = 0;
                    $iCtrListaArquivos = 0;

                    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                        $num = count($data);
                        $aArquivoCSV = explode(".", $arquivo);



                        if ((($data[0] != 99 &&
                            $aArquivoCSV[0] == 'EMP' || $aArquivoCSV[0] == 'ANL' || $aArquivoCSV[0] == 'LQD' || $aArquivoCSV[0] == 'ALQ' ||
                            $aArquivoCSV[0] == 'OPS' || $aArquivoCSV[0] == 'AOP' || $aArquivoCSV[0] == 'EXT' || $aArquivoCSV[0] == 'CTB' ||
                            $aArquivoCSV[0] == 'RSP' || $aArquivoCSV[0] == 'BALANCETE' || $aArquivoCSV[0] == 'CVC' ) && ($ano > 2013)) ||
                            ($data[0] != 99 && $aArquivoCSV[0] == 'EMP' && $ano == 2013)
                        ) {
                            if ($data[0] == 99) {
                                continue;
                            }
                            $sCaminhoClasse = "classes/db_" . strtolower($aArquivoCSV[0]) . $data[0] . $ano . "_classe.php";

                            if (file_exists($sCaminhoClasse) && $sCaminhoClasse != 'classes/db_ext24'.$ano.'_classe.php') {

                                require_once $sCaminhoClasse;
                                $sTabela = strtolower($aArquivoCSV[0]) . $data[0] . $ano;
                                $sClasse = "cl_" . $sTabela;
                                $oClasse = new $sClasse;

                            } else {
                                continue;
                                //throw new Exception("Arquivo $sCaminhoClasse nao encontrado!");

                            }

                            db_inicio_transacao();
                            $sSqlCampos = "SELECT column_name,data_type FROM information_schema.columns WHERE table_name ='" . $sTabela . "' order by table_name";
                            $rsSqlCampos = pg_query($sSqlCampos);
                            $aCampos = db_utils::getColectionByRecord($rsSqlCampos);

                            $aSigla = explode('_', $aCampos[0]->column_name);


                            if ($iCtrDelete == 0) {
                                /**
                                 * EXCLUIR DADOS DA TABELA
                                 */

                                $sSqlDeleteTables = "SELECT distinct table_name FROM information_schema.columns WHERE table_name ilike '" .
                                    strtolower($aArquivoCSV[0]) . "%" . $ano . "' order by 1 DESC";
                                $rsSqlDeleteTables = db_query($sSqlDeleteTables);
                                $aTables = db_utils::getColectionByRecord($rsSqlDeleteTables);

                                foreach ($aTables as $oTable) {

                                    $sSqlSIGLA = "SELECT column_name FROM information_schema.columns WHERE table_name ='" . $oTable->table_name . "' limit 1 ";
                                    $rsSqlSIGLA = db_query($sSqlSIGLA);
                                    $SiglaDelete = db_utils::fieldsMemory($rsSqlSIGLA, 0)->column_name;

                                    $aSiglaDelete = explode('_', $SiglaDelete);

                                    $result = db_query("Select * from $oTable->table_name where $aSiglaDelete[0]_mes = " . $mes . " and $aSiglaDelete[0]_instit = " . db_getsession("DB_instit"));
                                    if (pg_num_rows($result) > 0) {

                                        db_query("delete from $oTable->table_name where $aSiglaDelete[0]_mes = " . $mes . " and $aSiglaDelete[0]_instit = " . db_getsession("DB_instit"))
                                        or die("Erro aqui".pg_last_error());

                                    }
                                }

                                $iCtrDelete = 1;

                            }
                            $c = 0;
                            foreach ($aCampos as $oCampo) {
                                $aux = explode("_", $oCampo->column_name);
                                $sColuna = $oCampo->column_name;

                                if ($aux[1] == "sequencial") {
                                    $oClasse->$sColuna = null;
                                } elseif ($aux[1] == "mes") {
                                    $oClasse->$sColuna = $mes;
                                } elseif ($aux[1] == "instit") {
                                    $oClasse->$sColuna = db_getsession('DB_instit');
                                } elseif ($aux[1] == "vlsaldoinicialfonte" && $sColuna == "si96_vlsaldoinicialfonte") {
                                    $oClasse->$sColuna = str_replace("'","",trim($data[5]));
                                } elseif ($aux[1] == "vlsaldofinalfonte" && $sColuna == "si96_vlsaldofinalfonte") {
                                    $oClasse->$sColuna = str_replace("'","",trim($data[6]));
                                } elseif ($aux[1] == "saldocec" && $sColuna == "si96_saldocec" ) {
                                    $oClasse->$sColuna = $data[4];   
                                } elseif ($aux[1] == "exerciciocompdevo" && $sColuna == "si165_exerciciocompdevo") {
                                    $oClasse->$sColuna = $data[4] == '' ? $data[4] : 0;
                                } elseif ($aux[1] == "vlsaldoanteriorfonte" && $sColuna == "si165_vlsaldoanteriorfonte") {
                                    $oClasse->$sColuna = str_replace("'","",trim($data[5]));
                                } elseif ($aux[1] == "natsaldoanteriorfonte" && $sColuna == "si165_natsaldoanteriorfonte" ) {
                                    $oClasse->$sColuna = $data[6];
                                } elseif ($aux[1] == "totaldebitos" && $sColuna == "si165_totaldebitos" ) {
                                    $oClasse->$sColuna = str_replace("'","",trim($data[7]));   
                                } elseif ($aux[1] == "totalcreditos" && $sColuna == "si165_totalcreditos" ) {
                                    $oClasse->$sColuna = str_replace("'","",trim($data[8]));   
                                } elseif ($aux[1] == "vlsaldoatualfonte" && $sColuna == "si165_vlsaldoatualfonte" ) {
                                    $oClasse->$sColuna = str_replace("'","",trim($data[9]));  
                                } elseif ($aux[1] == "natsaldoatualfonte" && $sColuna == "si165_natsaldoatualfonte" ) {
                                    $oClasse->$sColuna = $data[10];     
                                } elseif (substr($aux[1], 0, 3) == "reg") {

                                    $sTabelaAnterior = strtolower($aArquivoCSV[0]) . substr($aux[1], -2) . $ano;
                                    $sClasseAnterior = 'cl_' . strtolower($aArquivoCSV[0]) . substr($aux[1], -2) . $ano;

                                    $sSqlCamposAnteriores = "SELECT column_name, data_type FROM information_schema.columns WHERE table_name ='" . $sTabelaAnterior . "'";
                                    $rsSqlCamposAnteriores = db_query($sSqlCamposAnteriores);
                                    $oCamposAnteriores = db_utils::fieldsMemory($rsSqlCamposAnteriores, 0);

                                    $oClasseAnterior = new $sClasseAnterior;
                                    $rsResultAnterior = db_query($oClasseAnterior->sql_query('', "max($oCamposAnteriores->column_name) as chave"))
                                    or die("Erro aqui ".$sClasseAnterior.pg_last_error());
                                    $iChave = db_utils::fieldsMemory($rsResultAnterior, 0)->chave;

                                    $oClasse->$sColuna = $iChave;

                                } else {

                                    $tipoCampo = explode(" ", $oCampo->data_type);
                                    if ($tipoCampo[0] == 'double') {

                                        $data[$c] = str_replace(',', '.', $data[$c]);
                                    }
                                    if ($tipoCampo[0] == 'bigint' && trim($data[$c]) == "") {
                                        $oClasse->$sColuna = null;
                                        $c++;
                                    } elseif ($tipoCampo[0] == 'date') {
                                        if ($data[$c] == " " || trim($data[$c]) == "" || empty($data[$c])) {
                                            $oClasse->$sColuna = null;
                                            $c++;
                                        } else {

                                            $oClasse->$sColuna = substr($data[$c], -4) . '-' . substr($data[$c], 2, -4) . '-' . substr($data[$c], 0, 2);
                                            $c++;
                                        }
                                    } else {
                                        $oClasse->$sColuna = str_replace("'","",trim($data[$c]));
                                        $c++;
                                    }
                                }
                            }

                            try {

                                $oClasse->incluir(null);
                                if($oClasse->erro_status == 0) {
                                    $oRetorno->status = 2;
                                    $oRetorno->message = ("Erro importacao  $sClasse  {$oClasse->erro_msg}");
                                }
                                if ($iCtrListaArquivos == 0) {
                                    $oArquivoImportado->nome = $aArquivoCSV[0];
                                    $aListaArquivos[] = $aArquivoCSV[0];
                                    $iCtrListaArquivos = 1;
                                }

                            } catch (Exception $e) {
                                $oRetorno->status = 2;
                                $oRetorno->message = $e->getMessage();
                            }

                        }
                        db_fim_transacao();
                    }
                    fclose($handle);
                    db_fim_transacao();
                    $oRetorno->itens = $aListaArquivos;
                }
            }
        }

        system("rm importarsicom/* ");


        break;

}

echo $oJson->encode($oRetorno);
