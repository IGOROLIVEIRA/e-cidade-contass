<?php

require_once("libs/db_liborcamento.php");
require_once("libs/db_libcontabilidade.php");


class Caspweb {

    //@var integer
    public $iInstit;
    //@var integer
    public $iAnoUsu;
    //@var integer
    public $iMes;
    //@var string
    public $dtIni;
    //@var string
    public $dtFim;
    //@var string
    public $sNomeArquivo;
    //@var resource
    public $rsMapa;
    //@var integer
    public $status;
    //@var integer
    public $iErroSQL;

    public function setErroSQL($iErroSQL) {
        $this->iErroSQL = $iErroSQL;
    }

    public function getErroSQL() {
        return $this->iErroSQL;
    }

    public function setAno($iAnoUsu) {
        $this->iAnoUsu = $iAnoUsu;
    }

    public function setInstit($iInstit) {
        $this->iInstit = $iInstit;
    }

    public function setMes($iMes) {
        $this->iMes = $iMes;
    }

    public function setPeriodo() {

        $dtIni = new \DateTime("$this->iAnoUsu-$this->iMes-01");
        $dtFim = new \DateTime();

        $this->dtIni = $dtIni->format('Y-m-d');
        $this->dtFim = $dtFim->modify("last day of {$this->getMes($this->iMes)}")->format('Y-m-d');

    }

    public function setNomeArquivo($sNomeArq) {
        $this->sNomeArquivo = $sNomeArq;
    }

    public function getNomeArquivo() {
        return $this->sNomeArquivo;
    }

    public function gerarMapaCsv() {

        $rsDados = $this->rsMapa;

        if (file_exists("model/contabilidade/arquivos/caspweb/".db_getsession("DB_anousu")."/CaspwebCsv.model.php")) {

            require_once("model/contabilidade/arquivos/caspweb/" . db_getsession("DB_anousu") . "/CaspwebCsv.model.php");

            $csv = new CaspwebCsv;
            $csv->setNomeArquivo($this->getNomeArquivo());
            $csv->gerarArquivoCSV($rsDados);

        }

    }

    public function gerarMapaApropriacao() {

        $sSqlMapaApropriacao = "    SELECT
                                        codtipomapa,
                                        codentcont,
                                        exercicio,
                                        mes,
                                        contacontabil,
                                        indsuperavit,
                                        codbanco, 
                                        codagencia, 
                                        codconta,
                                        indapfincanc,
                                        NULL AS dotorcamentaria,
                                        NULL AS tipopesssoa,
                                        NULL AS codcred_forn,
                                        NULL AS grupfontanalitica,
                                        NULL AS espfontanalitica,
                                        NULL AS instjuridico,
                                        codenttransfinanc,
                                        replace(TO_CHAR(ABS(coalesce(debito,0)),'99999999990D99'),'.',',') AS debito,
                                        replace(TO_CHAR(ABS(coalesce(credito,0)),'99999999990D99'),'.',',') AS credito,
                                        NULL AS saldoini
                                    FROM
                                    (SELECT 
                                        32 AS codtipomapa,
                                        227 AS codentcont,
                                        $this->iAnoUsu AS exercicio,
                                        lpad($this->iMes, 2, '0') AS mes,
                                        CASE 
                                            WHEN c232_estrutcaspweb IS NULL THEN rpad(c60_estrut, 17, '0')
                                            ELSE rpad(c232_estrutcaspweb, 17, '0')
                                        END AS contacontabil,
                                        c60_identificadorfinanceiro AS indsuperavit,
                                        substr(c63_banco, 1, 9) AS codbanco, 
                                        substr(c63_agencia, 1, 7) AS codagencia, 
                                        substr(c63_conta, 1, 15) AS codconta,
                                        CASE 
                                            WHEN c63_tipoconta IN (2,3) THEN 'S'
                                            WHEN c63_tipoconta = 1 THEN 'N'
                                            ELSE ''
                                        END as indapfincanc,
                                        CASE 
                                            WHEN substr(c60_estrut,1,5) IN ('35112','45112') THEN '201'
                                            ELSE ''
                                        END AS codenttransfinanc,
                                        (SELECT sum(c69_valor)
                                            FROM conlancamval
                                            WHERE c69_credito = c61_reduz
                                            AND c69_data BETWEEN '$this->dtIni' AND '$this->dtFim') AS credito,
                                        (SELECT sum(c69_valor)
                                            FROM conlancamval
                                            WHERE c69_debito = c61_reduz
                                            AND c69_data BETWEEN '$this->dtIni' AND '$this->dtFim') AS debito	
                                        FROM contabilidade.conplano
                                        INNER JOIN conplanoreduz ON c61_codcon = c60_codcon AND c61_anousu = c60_anousu AND c61_instit = $this->iInstit
                                        INNER JOIN conplanoexe ON c62_reduz = c61_reduz AND c61_anousu = c62_anousu
                                        LEFT JOIN conplanoconta ON c63_codcon = c60_codcon AND c63_anousu = c60_anousu
                                        LEFT JOIN vinculocaspweb ON c232_estrutecidade = c60_estrut AND c232_anousu = c60_anousu
                                        WHERE c60_anousu = $this->iAnoUsu
                                        AND substr(c60_estrut,1,1)::integer IN (1,2,3,4,7,8)) AS x
                                    WHERE debito != 0
                                    OR credito != 0
                                    ORDER BY contacontabil";

        $this->rsMapa = db_query($sSqlMapaApropriacao);

    }

    function getMes($iMes) {
        $sMes = "";

        if ( $iMes == '01' ) {
            $sMes = 'January';
        }else if ( $iMes == '02') {
            $sMes = 'February';
        }else if ( $iMes == '03') {
            $sMes = 'March';
        }else if ( $iMes == '04') {
            $sMes = 'April';
        }else if ( $iMes == '05') {
            $sMes = 'May';
        }else if ( $iMes == '06') {
            $sMes = 'June';
        }else if ( $iMes == '07') {
            $sMes = 'July';
        }else if ( $iMes == '08') {
            $sMes = 'August';
        }else if ( $iMes == '09') {
            $sMes = 'September';
        }else if ( $iMes == '10') {
            $sMes = 'October';
        }else if ( $iMes == '11') {
            $sMes = 'November';
        }else if ( $iMes == '12') {
            $sMes = 'December';
        }

        return $sMes;
    }


}
