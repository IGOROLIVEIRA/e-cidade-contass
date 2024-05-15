<?php

/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

/**
 * Controle Orcamentario
 * @package Orcamento
 * @author widouglas
 */
class ControleOrcamentario
{
    private $iNaturezaReceita;
    private $iFonte;
    private $sCodigo;
    private $deParaFonteCompleta;
    private $deParaFonteInicial;
    private $iEmendaParlamentar;
    private $iEsferaEmendaParlamentar;
    private $deParaFonte6Digitos;
    private $deParaFonte8Digitos;
    private $deParaFonte6DigitosEEsfera;
    private $iTipodespesa;
    private $sDescricao;
    private $sDescricaoPorCO;
    private $iCodco;

    public function __construct()
    {
        $this->setDeParaFonteCompleta();
        $this->setDeParaFonteInicial();
        $this->setDeParaFonte6Digitos();
        $this->setDeParaFonte6DigitosEEsfera();
        $this->sCodigo = '0000';
    }

    public function setDeParaFonteCompleta()
    {

        if (empty($this->iTipodespesa)){

            $this->deParaFonteCompleta = array(
                '15000001' => '1001',
                '15000002' => '1002',
                '15400007' => '1070',
                '25400007' => '1070',
                '15420007' => '1070',
                '18000001' => '1111',
                '18000002' => '1121',
                '25000001' => '1001',
                '25000002' => '1002',
                '15020001' => '1001',
                '15020002' => '1002',
                '25020001' => '1001',
                '25020002' => '1002',
                '28000001' => '1111',
                '28000002' => '1121',
                '25420007' => '1070',
            );
        }
        if ($this->iTipodespesa) {
            if ($this->iTipodespesa == 0) {
                $this->deParaFonteCompleta = array(
                    '15000001' => '1001',
                    '15000002' => '1002',
                    '15400007' => '1070',
                    '25400007' => '1070',
                    '15420007' => '1070',
                    '18000001' => '1111',
                    '18000002' => '1121',
                    '25000001' => '1001',
                    '25000002' => '1002',
                    '15020001' => '1001',
                    '15020002' => '1002',
                    '25020001' => '1001',
                    '25020002' => '1002',
                    '28000001' => '1111',
                    '28000002' => '1121',
                    '25420007' => '1070',
                );
            }
            if ($this->iTipodespesa == 1) {
                $this->deParaFonteCompleta = array(
                    '15000001' => '1001',
                    '15000002' => '1002',
                    '15400007' => '1070',
                    '25400007' => '1070',
                    '15420007' => '1070',
                    '18000000' => '1111',
                    '18000001' => '1111',
                    '18000002' => '1121',
                    '25000001' => '1001',
                    '25000002' => '1002',
                    '15020001' => '1001',
                    '15020002' => '1002',
                    '25020001' => '1001',
                    '25020002' => '1002',
                    '28000001' => '1111',
                    '28000002' => '1121',
                    '25420007' => '1070',
                    '28000000' => '1111',
                );
            }
            if ($this->iTipodespesa == 2) {
                $this->deParaFonteCompleta = array(
                    '15000001' => '1001',
                    '15000002' => '1002',
                    '15400007' => '1070',
                    '25400007' => '1070',
                    '15420007' => '1070',
                    '18000001' => '1111',
                    '18000000' => '1121',
                    '18000002' => '1121',
                    '25000001' => '1001',
                    '25000002' => '1002',
                    '15020001' => '1001',
                    '15020002' => '1002',
                    '25020001' => '1001',
                    '25020002' => '1002',
                    '28000001' => '1111',
                    '28000002' => '1121',
                    '25420007' => '1070',
                    '28000000' => '1121',
                );
            }
        }

    }

    public function setDeParaFonte6Digitos()
    {
        $this->deParaFonte6Digitos = array(
            '551000' => array('1' => '3110', '2' => '3120', '4' => '7000'),
            '552000' => array('1' => '3110', '2' => '3120', '4' => '7000'),
            '553000' => array('1' => '3110', '2' => '3120', '4' => '7000'),
            '569000' => array('1' => '3110', '2' => '3120', '4' => '7000'),
            '570000' => array('1' => '3110', '2' => '3120', '4' => '7000'),
            '600000' => array('1' => '3110', '2' => '3120', '4' => '7000'),
            '601000' => array('1' => '3110', '2' => '3120', '4' => '7000'),
            '602000' => array('1' => '3110', '2' => '3120', '4' => '7000'),
            '603000' => array('1' => '3110', '2' => '3120', '4' => '7000'),
            '631000' => array('1' => '3110', '2' => '3120', '4' => '7000'),
            '660000' => array('1' => '3110', '2' => '3120', '4' => '7000'),
            '700000' => array('1' => '3110', '2' => '3120', '4' => '7000'),
            '700014' => array('1' => '3110', '2' => '3120', '4' => '7000'),
            '706000' => array('1' => '3110', '2' => '3120', '4' => '7000'),
            '749014' => array('1' => '3110', '2' => '3120', '4' => '7000'),
            '759014' => array('1' => '3110', '2' => '3120', '4' => '7000'),
            '700007' => array('1' => '3110', '2' => '3120', '4' => '7000'),
            '710000' => array('1' => '3210', '2' => '3220', '4' => '7001'),
            '571000' => array('1' => '3210', '2' => '3220', '4' => '7001'),
            '576000' => array('1' => '3210', '2' => '3220', '4' => '7001'),
            '576001' => array('1' => '3210', '2' => '3220', '4' => '7001'),
            '621000' => array('1' => '3210', '2' => '3220', '4' => '7001'),
            '632000' => array('1' => '3210', '2' => '3220', '4' => '7001'),
            '661000' => array('1' => '3210', '2' => '3220', '4' => '7001'),
            '701000' => array('1' => '3210', '2' => '3220', '4' => '7001'),
            '701015' => array('1' => '3210', '2' => '3220', '4' => '7001'),
            '749015' => array('1' => '3210', '2' => '3220', '4' => '7001'),
        );
    }

    public function setDeParaFonte6DigitosEEsfera()
    {
        $this->deParaFonte6DigitosEEsfera = array(
            '665000' => array(
                '1' => array(
                    '1' => '3110',
                    '2' => '3120',
                    '3' => '7000'
                ),
                '2' => array(
                    '1' => '3210',
                    '2' => '3220',
                    '3' => '7001'
                ),
            )
        );
    }

    public function setDeParaFonteInicial()
    {
        $this->deParaFonteInicial = array(
            '4171' => array(
                '1' => 3110,
                '2' => 3120,
                '4' => 7000
            ),
            '4241' => array(
                '1' => 3110,
                '2' => 3120,
                '4' => 7000
            ),
            '4172' => array(
                '1' => 3210,
                '2' => 3220,
                '4' => 7001
            ),
            '4241' => array(
                '1' => 3110,
                '2' => 3120,
                '4' => 7000
            ),
        );
    }

    public function setFonte($iFonte)
    {
        $this->iFonte = $iFonte;
    }

    public function setNaturezaReceita($iNaturezaReceita)
    {
        $this->iNaturezaReceita = $iNaturezaReceita;
    }

    public function setEmendaParlamentar($iEmendaParlamentar)
    {
        if (in_array($this->iFonte, array(17060000, 27060000, 17100000, 27100000)) and !$iEmendaParlamentar) {
            $this->iEmendaParlamentar = 1;
            return;
        }
        $this->iEmendaParlamentar = $iEmendaParlamentar;
    }

    public function setEsferaEmendaParlamentar($iEsferaEmendaParlamentar)
    {
        $this->iEsferaEmendaParlamentar = $iEsferaEmendaParlamentar;
    }

    public function setTipoDespesa($iTipodespesa)
    {
        $this->iTipodespesa = $iTipodespesa;
    }

    public function setCodigoPorNatureza4Digitos()
    {
        if (array_key_exists(substr($this->iNaturezaReceita, 0, 4), $this->deParaFonteInicial))
            if (array_key_exists($this->iEmendaParlamentar, $this->deParaFonteInicial[substr($this->iNaturezaReceita, 0, 4)]))
                $this->sCodigo = $this->deParaFonteInicial[substr($this->iNaturezaReceita, 0, 4)][$this->iEmendaParlamentar];

        return;
    }

    public function getCodigoPorReceita()
    {
        $this->setCodigoPorFonte();
        $this->setCodigoPorNatureza4Digitos();
        $this->setCodigoPorFonte6Digitos();
        return $this->sCodigo;
    }

    public function setCodigoPorFonte()
    {
        if (array_key_exists($this->iFonte, $this->deParaFonteCompleta))
            $this->sCodigo = $this->deParaFonteCompleta[$this->iFonte];
        return;
    }

    public function setCodigoPorFonte6Digitos()
    {
        $iFonte6Digitos = substr($this->iFonte, 1, 6);
        if (array_key_exists($iFonte6Digitos, $this->deParaFonte6Digitos))
            if (array_key_exists($this->iEmendaParlamentar, $this->deParaFonte6Digitos[$iFonte6Digitos]))
                $this->sCodigo = $this->deParaFonte6Digitos[$iFonte6Digitos][$this->iEmendaParlamentar];

        return;
    }

    public function setCodigoPorFonte6DigitosEEsfera()
    {
        $iFonte6Digitos = substr($this->iFonte, 1, 6);
        if (array_key_exists($iFonte6Digitos, $this->deParaFonte6DigitosEEsfera))
            if (array_key_exists($this->iEsferaEmendaParlamentar, $this->deParaFonte6DigitosEEsfera[$iFonte6Digitos]))
                if (array_key_exists($this->iEmendaParlamentar, $this->deParaFonte6DigitosEEsfera[$iFonte6Digitos][$this->iEsferaEmendaParlamentar])) {
                    $this->sCodigo = $this->deParaFonte6DigitosEEsfera[$iFonte6Digitos][$this->iEsferaEmendaParlamentar][$this->iEmendaParlamentar];
                }
        return;
    }

    public function getCodigoParaEmpenho()
    {
        $this->setCodigoPorFonte();
        $this->setCodigoPorFonte6Digitos();
        $this->setCodigoPorFonte6DigitosEEsfera();
        return $this->sCodigo;
    }

    public function getCodigoParaDotacao()
    {
        $this->setCodigoPorFonte();
        return $this->sCodigo;
    }

    public function setCodCO($iCodco)
    {
        $this->iCodco= $iCodco;
    }

    public function getDescricaoCO()
    {
        $this->setDescricaoCO();
        $this->sDescricao = $this->sDescricaoPorCO[$this->iCodco];
        return $this->sDescricao;
    }

    public function setDescricaoCO()
    {
        $this->sDescricaoPorCO = array(
            '0000' => 'Sem Identificação de CO',
            '1001' => 'Despesas com manutenção e desenvolvimento do ensino',
            '1002' => 'Despesas com ações e serviços públicos de saúde',
            '1070' => 'Percentual aplicado no pagamento da remuneração dos profissionais da educação básica em efetivo exercício',
            '1111' => 'Benefícios previdenciários - Poder Executivo - Fundo em Capitalização (Plano Previdenciário)',
            '1121' => 'Benefícios previdenciários - Poder Legislativo - Fundo em Capitalização (Plano Previdenciário)',
            '2111' => 'Benefícios previdenciários - Poder Executivo - Fundo em Repartição (Plano Financeiro)',
            '2121' => 'Benefícios previdenciários - Poder Legislativo - Fundo em Repartição (Plano Financeiro)',
            '3110' => 'Transferências da União decorrentes de emendas parlamentares individuais',
            '3120' => 'Transferências da União decorrentes de emendas parlamentares de bancada',
            '3210' => 'Transferências dos Estados decorrentes de emendas parlamentares individuais',
            '3220' => 'Transferências dos Estados decorrentes de emendas parlamentares de bancada',
            '7000' => 'Transferências da União decorrentes de emendas parlamentares não impositivas',
            '7001' => 'Transferências do Estado decorrentes de emendas parlamentares não impositivas'
        );
    }

    public function getDescricaoResumoCO()
    {
        $this->setDescricaoResumoCO();
        $this->sDescricao = $this->sDescricaoPorCO[$this->iCodco];
        return $this->sDescricao;
    }

    public function setDescricaoResumoCO()
    {
        $this->sDescricaoPorCO = array(
            '0000' => 'SEM IDENTIFICAÇÃO DE CO',
            '1001' => 'MANUTENÇÃO E DESENVOLVIMENTO DO ENSINO',
            '1002' => 'AÇÕES E SERVIÇOS PÚBLICOS DE SAÚDE',
            '1070' => 'APLICAÇÃO NA REMUNERAÇÃO DO FUNDEB',
            '1111' => 'BENEF. PREV. PODER EXECUTIVO CAPITALIZAÇÃO',
            '1121' => 'BENEF. PREV. PODER LEGISLATIVO CAPITALIZAÇÃO',
            '2111' => 'BENEF. PREV. PODER EXECUTIVO REPARTIÇÃO',
            '2121' => 'BENEF. PREV. PODER LEGISLATIVO REPARTIÇÃO ',
            '3110' => 'EMEN. PARLAMENTARES INDIVIDUAIS(UNIÃO)',
            '3120' => 'EMEN. PARLAMENTARES DE BANCADA(UNIÃO)',
            '3210' => 'EMEN. PARLAMENTARES INDIVIDUAIS(ESTADO)',
            '3220' => 'EMEN. PARLAMENTARES DE BANCADA(ESTADO)',
            '7000' => 'EMEN. PARLAMENTARES NÃO IMPOSITIVAS(UNIÃO)',
            '7001' => 'EMEN. PARLAMENTARES NÃO IMPOSITIVAS(ESTADO)',
        );
    }

    public function setDeParaFonte8digitos()
    {
        $this->deParaFonte8Digitos = array(
            '100' => '15000000', '101' => '15000001', '102' => '15000002', '103' => '18000000',
            '104' => '18010000', '105' => '18020000', '106' => '15760010', '107' => '15440000',
            '108' => '17080000', '112' => '16590020', '113' => '15990030', '116' => '17500000',
            '117' => '17510000', '118' => '15400007', '119' => '15400000', '120' => '15760000',
            '121' => '16220000', '122' => '15700000', '123' => '16310000', '124' => '17000000',
            '129' => '16600000', '130' => '18990040', '131' => '17590050', '132' => '16040000',
            '133' => '17150000', '134' => '17160000', '135' => '17170000', '136' => '17180000',
            '142' => '16650000', '143' => '15510000', '144' => '15520000', '145' => '15530000',
            '146' => '15690000', '147' => '15500000', '148' => '16000000', '149' => '16000000',
            '150' => '16000000', '151' => '16000000', '152' => '16000000', '153' => '16010000',
            '154' => '16590000', '155' => '16210000', '156' => '16610000', '157' => '17520000',
            '158' => '18990060', '159' => '16000000', '160' => '17040000', '161' => '17070000',
            '162' => '17490120', '163' => '17130070', '164' => '17060000', '165' => '17490000',
            '166' => '15420007', '167' => '15420000', '168' => '17100100', '169' => '17100000',
            '170' => '15010000', '171' => '15710000', '172' => '15720000', '173' => '15750000',
            '174' => '15740000', '175' => '15730000', '176' => '16320000', '177' => '16330000',
            '178' => '16360000', '179' => '16340000', '180' => '16350000', '181' => '17010000',
            '182' => '17020000', '183' => '17030000', '184' => '17090000', '185' => '17530000',
            '186' => '17040000', '187' => '17050000', '188' => '15000000', '189' => '15000000',
            '190' => '17540000', '191' => '17540000', '192' => '17550000', '193' => '18990000',
            '200' => '25000000', '201' => '25000001', '202' => '25000002', '203' => '28000000',
            '204' => '28010000', '205' => '28020000', '206' => '25760010', '207' => '25440000',
            '208' => '27080000', '212' => '26590020', '213' => '25990030', '216' => '27500000',
            '217' => '27510000', '218' => '25400007', '219' => '25400000', '220' => '25760000',
            '221' => '26220000', '222' => '25700000', '223' => '26310000', '224' => '27000000',
            '229' => '26600000', '230' => '28990040', '231' => '27590050', '232' => '26040000',
            '233' => '27150000', '234' => '27160000', '235' => '27170000', '236' => '27180000',
            '242' => '26650000', '243' => '25510000', '244' => '25520000', '245' => '25530000',
            '246' => '25690000', '247' => '25500000', '248' => '26000000', '249' => '26000000',
            '250' => '26000000', '251' => '26000000', '252' => '26000000', '253' => '26010000',
            '254' => '26590000', '255' => '26210000', '256' => '26610000', '257' => '27520000',
            '258' => '28990060', '259' => '26000000', '260' => '27040000', '261' => '27070000',
            '262' => '27490120', '263' => '27130070', '264' => '27060000', '265' => '27490000',
            '266' => '25420007', '267' => '25420000', '268' => '27100100', '269' => '27100000',
            '270' => '25010000', '271' => '25710000', '272' => '25720000', '273' => '25750000',
            '274' => '25740000', '275' => '25730000', '276' => '26320000', '277' => '26330000',
            '278' => '26360000', '279' => '26340000', '280' => '26350000', '281' => '27010000',
            '282' => '27020000', '283' => '27030000', '284' => '27090000', '285' => '27530000',
            '286' => '27040000', '287' => '27050000', '288' => '25000000', '289' => '25000000',
            '290' => '27540000', '291' => '27540000', '292' => '27550000', '293' => '28990000');
    }

    public function setFonte3PorFonte8()
    {
        if (array_key_exists($this->iFonte, $this->deParaFonte8Digitos))
            $this->sCodigo = $this->deParaFonte8Digitos[$this->iFonte];
        return;
    }

    public function getFonte3ParaFonte8()
    {
        $this->setFonte3PorFonte8();
        return $this->sCodigo;
    }
}
