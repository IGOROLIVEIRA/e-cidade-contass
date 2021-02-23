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
    //@var array
    public $aMapa = array();
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
        $this->dtFim = $this->iAnoUsu.'-'.$this->iMes.'-'.$dtFim->modify("last day of {$this->getMes($this->iMes)}")->format('d');

    }

    public function setNomeArquivo($sNomeArq) {
        $this->sNomeArquivo = $sNomeArq;
    }

    public function getNomeArquivo() {
        return $this->sNomeArquivo;
    }

    public function gerarMapaCsv() {

        $aDados = $this->aMapa;

        if (file_exists("model/contabilidade/arquivos/caspweb/".db_getsession("DB_anousu")."/CaspwebCsv.model.php")) {

            require_once("model/contabilidade/arquivos/caspweb/" . db_getsession("DB_anousu") . "/CaspwebCsv.model.php");

            $csv = new CaspwebCsv;
            $csv->setNomeArquivo($this->getNomeArquivo());
            $csv->gerarArquivoCSV($aDados);

        }

    }

    public function gerarMapaApropriacao() {

        $sSqlMapaApropriacao = "    SELECT
                                        codtipomapa,
                                        codentcont,
                                        exercicio,
                                        mes,
                                        contacontabil,
                                        CASE 
                                            WHEN contacontabil = '21892980400000000' THEN 'P' 
                                            ELSE indsuperavit 
                                        END AS indsuperavit,
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
                                        coalesce(debito,0) AS debito,
                                        coalesce(credito,0) AS credito
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
                                        CASE 
                                            WHEN substr(c60_estrut,1,1) IN ('1','2') THEN c60_identificadorfinanceiro
                                            ELSE ''
                                        END AS indsuperavit,
                                        substr(c63_banco, 1, 9) AS codbanco, 
                                        CASE
                                            WHEN c63_agencia = '233' THEN '23337'
                                            ELSE substr(c63_agencia, 1, 7)
                                        END AS codagencia, 
                                        CASE 
                                            WHEN ltrim(c63_conta,'0') = '2' OR c63_conta = '001' THEN '06000002-2'
                                            ELSE substr(c63_conta, 1, 15) 
                                        END AS codconta,
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
                                        AND substr(c60_estrut,1,1)::integer IN (1,2,3,4,7,8)
                                        AND substr(c60_estrut,1,7) NOT IN ('2371101', '2371102')) AS x
                                    WHERE debito != 0
                                    OR credito != 0
                                    ORDER BY contacontabil, codbanco";

        $rsMapaAprop = db_query($sSqlMapaApropriacao);

        for ($iCont = 0; $iCont < pg_num_rows($rsMapaAprop); $iCont++) {

            $oContaContabil = db_utils::fieldsMemory($rsMapaAprop, $iCont);

            $sHash = $oContaContabil->contacontabil;

            if(!isset($this->aMapa[$sHash])) {

                $aMapaAprop = array();
                $aMapaAprop['codtipomapa'] = $oContaContabil->codtipomapa;
                $aMapaAprop['codentcont'] = $oContaContabil->codentcont;
                $aMapaAprop['exercicio'] = $oContaContabil->exercicio;
                $aMapaAprop['mes'] = $oContaContabil->mes;
                $aMapaAprop['contacontabil'] = $oContaContabil->contacontabil;
                $aMapaAprop['indsuperavit'] = $oContaContabil->indsuperavit;
                $aMapaAprop['codbanco'] = $oContaContabil->codbanco;
                $aMapaAprop['codagencia'] = $oContaContabil->codagencia;
                $aMapaAprop['codconta'] = $oContaContabil->codconta;
                $aMapaAprop['indapfincanc'] = $oContaContabil->indapfincanc;
                $aMapaAprop['dotorcamentaria'] = $oContaContabil->dotorcamentaria;
                $aMapaAprop['tipopesssoa'] = $oContaContabil->tipopesssoa;
                $aMapaAprop['codcred_forn'] = $oContaContabil->codcred_forn;
                $aMapaAprop['grupfontanalitica'] = $oContaContabil->grupfontanalitica;
                $aMapaAprop['espfontanalitica'] = $oContaContabil->espfontanalitica;
                $aMapaAprop['instjuridico'] = $oContaContabil->instjuridico;
                $aMapaAprop['codenttransfinanc'] = $oContaContabil->codenttransfinanc;
                $aMapaAprop['debito'] = $oContaContabil->debito;
                $aMapaAprop['credito'] = $oContaContabil->credito;

                $this->aMapa[$sHash] = $aMapaAprop;

            } else {

                $this->aMapa[$sHash]['debito'] += $oContaContabil->debito;
                $this->aMapa[$sHash]['credito'] += $oContaContabil->credito;

            }

        }

    }

    public function gerarMapaRsp () {

        $aContasContRSP = "'531200000000000', '532200000000000', '631100000000000', '631200000000000', '631300000000000', 
                            '631400000000000', '631910000000000', '632100000000000', '632200000000000', '632910000000000', '631990000000000'";

        $sSqlContasContabeis = "    SELECT 
                                        reduz,
                                        contacontabil
                                    FROM	
                                    (SELECT 
                                        c61_reduz AS reduz,
                                        CASE 
                                            WHEN c232_estrutcaspweb IS NULL THEN c60_estrut
                                            ELSE c232_estrutcaspweb
                                        END AS contacontabil,
                                        (SELECT sum(c69_valor) FROM conlancamval WHERE c69_credito = c61_reduz AND c69_data BETWEEN '2020-01-01' AND '2020-01-31') AS credito,
                                        (SELECT sum(c69_valor) FROM conlancamval WHERE c69_debito = c61_reduz AND c69_data BETWEEN '2020-01-01' AND '2020-01-31') AS debito
                                    FROM contabilidade.conplano
                                    INNER JOIN conplanoreduz ON c61_codcon = c60_codcon AND c61_anousu = c60_anousu AND c61_instit = $this->iInstit
                                    INNER JOIN conplanoexe ON c62_reduz = c61_reduz AND c61_anousu = c62_anousu
                                    LEFT JOIN conplanoconta ON c63_codcon = c60_codcon AND c63_anousu = c60_anousu
                                    LEFT JOIN vinculocaspweb ON c232_estrutecidade = c60_estrut AND c232_anousu = c60_anousu
                                    WHERE c60_anousu = $this->iAnoUsu
                                    AND c60_estrut IN ($aContasContRSP)) AS X
                                    WHERE (debito != 0 OR credito != 0)
                                    ORDER BY contacontabil";

        $rsContasContabeis = db_query($sSqlContasContabeis);

        for ($iContCont = 0; $iContCont < pg_num_rows($rsContasContabeis); $iContCont++) {

            $oContaContabil = db_utils::fieldsMemory($rsContasContabeis, $iContCont);

            $sSqlRestos = " SELECT DISTINCT
                                lpad(o58_funcao,2,'0') AS codfuncao,
                                lpad(o58_subfuncao,3,'0') AS codsubfuncao,
                                lpad(substr(o58_programa,1,3),3,'0') AS codprograma,
                                lpad(o58_projativ,4,'0') AS acao,
                                o55_origemacao AS subacao,
                                substr(o56_elemento,2,6) AS naturezadadespesa,
                                substr(o56_elemento,8,2) AS itemdespesa,
                                CASE 
                                    WHEN substr(o56_elemento,2,2) = '31' THEN '01'
                                    WHEN substr(o56_elemento,2,2) = '33' THEN '03'
                                    WHEN substr(o56_elemento,2,2) = '44' THEN '04'
                                    ELSE '00'
                                END AS fonte,
                                e60_codemp nroempenho,
                                e60_numemp numemp,
                                e60_anousu anoinscricao
                            FROM conlancamval
                            INNER JOIN contacorrentedetalheconlancamval ON c28_conlancamval = c69_sequen
                            INNER JOIN contacorrentedetalhe ON c19_sequencial = c28_contacorrentedetalhe
                            INNER JOIN empempenho ON e60_numemp = c19_numemp
                            INNER JOIN orcdotacao ON e60_anousu = o58_anousu AND o58_coddot = e60_coddot
                            INNER JOIN orcunidade ON o41_anousu = o58_anousu AND o41_orgao = o58_orgao AND o41_unidade = o58_unidade
                            INNER JOIN orcorgao ON o40_orgao = o41_orgao AND o40_anousu = o41_anousu
                            INNER JOIN empelemento ON e64_numemp = e60_numemp
                            INNER JOIN empresto ON e91_numemp = e60_numemp
                            LEFT JOIN orcelemento ON o56_codele = e64_codele AND e60_anousu = o56_anousu
                            INNER JOIN orcprojativ ON o58_anousu = o55_anousu AND o58_projativ = o55_projativ
                            INNER JOIN orctiporec ON o58_codigo = o15_codigo
                            LEFT JOIN infocomplementaresinstit ON o58_instit = si09_instit
                            WHERE (c69_credito IN ($oContaContabil->reduz)
                                   OR c69_debito IN ($oContaContabil->reduz))
                                AND c69_data BETWEEN '$this->dtIni' AND '$this->dtFim'";

            $rsRestos = db_query($sSqlRestos);

            for ($iContRestos = 0; $iContRestos < pg_num_rows($rsRestos); $iContRestos++) {

                $oResto = db_utils::fieldsMemory($rsRestos, $iContRestos);

                $sSqlDebCred = "    SELECT 
                                            (SELECT sum(c69_valor)
                                                 FROM conlancamval
                                                 INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan AND conlancam.c70_anousu = conlancamval.c69_anousu
                                                 INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                                 INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                                 INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                                 INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                                 WHERE c28_tipo = 'C'
                                                     AND c69_data BETWEEN '$this->dtIni' AND '$this->dtFim'
                                                     AND c19_contacorrente = 106
                                                     AND c19_reduz IN ($oContaContabil->reduz)
                                                     AND c19_instit = $this->iInstit
                                                     AND c19_numemp = $oResto->numemp
                                                     AND conhistdoc.c53_tipo NOT IN (1000)
                                                 GROUP BY c28_tipo) AS creditos,
                                            
                                                (SELECT sum(c69_valor)
                                                 FROM conlancamval
                                                 INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                                 AND conlancam.c70_anousu = conlancamval.c69_anousu
                                                 INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                                 INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                                 INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                                 INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                                 WHERE c28_tipo = 'D'
                                                     AND c69_data BETWEEN '$this->dtIni' AND '$this->dtFim'
                                                     AND c19_contacorrente = 106
                                                     AND c19_reduz IN ($oContaContabil->reduz)
                                                     AND c19_instit = $this->iInstit
                                                     AND c19_numemp = $oResto->numemp
                                                     AND conhistdoc.c53_tipo NOT IN (1000)
                                                 GROUP BY c28_tipo) AS debitos";

                $rsDebCred  = db_query($sSqlDebCred);
                $oDebCred   = db_utils::fieldsMemory($rsDebCred, 0);

                $sDotacaoOrcamentaria  = "0101.";                       //Unidade Orçamentária: sempre 0101
                $sDotacaoOrcamentaria .= "1000.";                       //Unidade Administrativa: por enquanto 1000
                $sDotacaoOrcamentaria .= "$oResto->codfuncao.";         //Função: o58_funcao
                $sDotacaoOrcamentaria .= "$oResto->codsubfuncao.";      //Subfunção: o58_subfuncao
                $sDotacaoOrcamentaria .= "$oResto->codprograma.";       //Programa: o58_programa s/ 0 esquerda
                $sDotacaoOrcamentaria .= "000.";                        //SubPrograma: 000
                $sDotacaoOrcamentaria .= substr($oResto->acao,0,1).".".substr($oResto->acao,1,3).".";//Ação: o58_projativ
                $sDotacaoOrcamentaria .= "0001.";                       //Sub-ação: o55_origemacao eu não sei se tá retornando no sistema, mas é sempre 0001
                $sDotacaoOrcamentaria .= "$oResto->naturezadadespesa";  //Natureza Despesa: substr(o56_elemento,2,6)
                $sDotacaoOrcamentaria .= "$oResto->itemdespesa.";        //Item Despesa: substr(o56_elemento,8,2)
                $sDotacaoOrcamentaria .= "$oResto->fonte";              //Fonte: elemento iniciado em 31 a fonte é 01, ini em 33 é 03 e ini em 44 é 04
                $sDotacaoOrcamentaria .= "00";                          //Fonte Detalhe: 00

                $sHash = substr($oContaContabil->contacontabil,0,13).$oResto->anoinscricao.$sDotacaoOrcamentaria;

                if(!isset($this->aMapa[$sHash])) {

                    $aMapaRsp = array();
                    $aMapaRsp['codtipomapa'] = 33;
                    $aMapaRsp['codentcont'] = 227;
                    $aMapaRsp['exercicio'] = $this->iAnoUsu;
                    $aMapaRsp['mes'] = $this->iMes;
                    $aMapaRsp['contacontabil'] = substr($oContaContabil->contacontabil, 0, 13) . $oResto->anoinscricao;
                    $aMapaRsp['indsuperavit'] = '';
                    $aMapaRsp['codbanco'] = '';
                    $aMapaRsp['codagencia'] = '';
                    $aMapaRsp['codconta'] = '';
                    $aMapaRsp['indapfincanc'] = '';
                    $aMapaRsp['dotorcamentaria'] = $sDotacaoOrcamentaria;
                    $aMapaRsp['tipopesssoa'] = '';
                    $aMapaRsp['codcred_forn'] = '';
                    $aMapaRsp['grupfontanalitica'] = '';
                    $aMapaRsp['espfontanalitica'] = '';
                    $aMapaRsp['instjuridico'] = '';
                    $aMapaRsp['codenttransfinanc'] = '';
                    $aMapaRsp['debito'] = $oDebCred->debitos != '' ? $oDebCred->debitos : 0;
                    $aMapaRsp['credito'] = $oDebCred->creditos != '' ? $oDebCred->creditos : 0;

                    $this->aMapa[$sHash] = $aMapaRsp;

                } else {

                    $this->aMapa[$sHash]['debito'] += $oDebCred->debitos != '' ? $oDebCred->debitos : 0;
                    $this->aMapa[$sHash]['credito'] += $oDebCred->creditos != '' ? $oDebCred->creditos : 0;

                }

            }

        }

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
