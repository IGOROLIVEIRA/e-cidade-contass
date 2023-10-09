<?php

require_once("classes/db_condataconf_classe.php");

class ValidaDataApostilamentoCommand
{

    public function execute($dataReferencia, $dataApostila, $validaDtApostila, $oContrato, $oRetorno)
    {
        $clcondataconf = new cl_condataconf;

        $anousu = db_getsession('DB_anousu');
        $sSQL = "select to_char(c99_datapat,'YYYY') c99_datapat
                from condataconf
                  where c99_instit = " . db_getsession('DB_instit') . "
                    order by c99_anousu desc limit 1";
        $rsResult       = db_query($sSQL);
        $maxC99_datapat = db_utils::fieldsMemory($rsResult, 0)->c99_datapat;
        $sNSQL = "";
        if ($anousu > $maxC99_datapat) {
            $sNSQL = $clcondataconf->sql_query_file($maxC99_datapat, db_getsession('DB_instit'), 'c99_datapat');
        } else {
            $sNSQL = $clcondataconf->sql_query_file($anousu, db_getsession('DB_instit'), 'c99_datapat');
        }
        $result = db_query($sNSQL);
        $rsData = db_utils::fieldsMemory($result, 0)->c99_datapat;
        $c99_datapat = (implode("/",(array_reverse(explode("-",$rsData)))));
        $c99_datapat = DateTime::createFromFormat('d/m/Y', $c99_datapat);
        $datareferencia = DateTime::createFromFormat('d/m/Y', $dataReferencia);
        $dateApostila = DateTime::createFromFormat('d/m/Y', $dataApostila);
        $dateAssinaturaContrato = DateTime::createFromFormat('d/m/Y', $oContrato->getDataAssinatura());
        if ($dataReferencia != "") {
            $datareferenciaapostila = implode("-", array_reverse(explode("/", $dataReferencia)));
            if (substr($rsData, 0, 4) == substr($datareferenciaapostila, 0, 4) && mb_substr($c99_datapat, 5, 2) == mb_substr($datareferenciaapostila, 5, 2)) {
                throw new Exception('Usuário: A data de referência deverá ser no mês posterior ao mês da data inserida.');
            }

            if ($c99_datapat != "" && $datareferencia <= $c99_datapat) {
                throw new Exception(' O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.');
            }
        }

        if ($rsData != "" && $dateApostila <= $c99_datapat && $validaDtApostila) {
            $oRetorno->datareferencia = true;
            throw new Exception(' O período já foi encerrado para envio do SICOM. Preencha o campo Data de Referência com uma data no mês subsequente.');
        }
        
        if($dateApostila < $dateAssinaturaContrato && $validaDtApostila) {
            throw new Exception('Usuário: A data da apostila não pode ser anterior a data de assinatura do contrato. Assinatura do contrato: ' . $oContrato->getDataAssinatura());
        }
    }
}
