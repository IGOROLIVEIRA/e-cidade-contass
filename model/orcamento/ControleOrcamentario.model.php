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
    private $deParaFonte6DigitosEEsfera;

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
        $this->deParaFonteCompleta = array(
            '15000001' => '1001',
            '15000002' => '1002',
            '15400007' => '1070',
            '15420007' => '1070',
            '18000001' => '1111',
            '18000001' => '1121',
        );
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
            '602000' => array('1' => '3110', '2' => '3120', '4' => '7000'),
            '603000' => array('1' => '3110', '2' => '3120', '4' => '7000'),
            '660000' => array('1' => '3110', '2' => '3120', '4' => '7000'),
            '700000' => array('1' => '3110', '2' => '3120', '4' => '7000'),
            '700007' => array('1' => '3110', '2' => '3120', '4' => '7000'),
            '710000' => array('1' => '3110', '2' => '3120', '4' => '7000'),
            '571000' => array('1' => '3210', '2' => '3220', '4' => '7001'),
            '576000' => array('1' => '3210', '2' => '3220', '4' => '7001'),
            '576001' => array('1' => '3210', '2' => '3220', '4' => '7001'),
            '621000' => array('1' => '3210', '2' => '3220', '4' => '7001'),
            '632000' => array('1' => '3210', '2' => '3220', '4' => '7001'),
            '661000' => array('1' => '3210', '2' => '3220', '4' => '7001'),
            '701000' => array('1' => '3210', '2' => '3220', '4' => '7001'),
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
        $this->iEmendaParlamentar = $iEmendaParlamentar;
    }
    
    public function setEsferaEmendaParlamentar($iEsferaEmendaParlamentar)
    {
        $this->iEsferaEmendaParlamentar = $iEsferaEmendaParlamentar;
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
                if (array_key_exists($this->iEmendaParlamentar, $this->deParaFonte6DigitosEEsfera[$iFonte6Digitos][$this->iEsferaEmendaParlamentar]))
                    $this->sCodigo = $this->deParaFonte6DigitosEEsfera[$this->iEsferaEmendaParlamentar][$this->iEmendaParlamentar];

        return;
    }

    public function getCodigoParaEmpenho()
    {
        $this->setCodigoPorFonte();
        $this->setCodigoPorFonte6Digitos();
        $this->setCodigoPorFonte6DigitosEEsfera();
        return $this->sCodigo;
    }
}
