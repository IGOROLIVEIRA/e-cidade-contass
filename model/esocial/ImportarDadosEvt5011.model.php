<?php
/*
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

require_once("classes/db_evt5011consulta_classe.php");

/**
 * Classe para importação de dados de contribuição social por contribuinte do evento S1299.
 * @author Robson de Jesus <robson.silva@contassconsultoria.com.br>
 */
class ImportarDadosEvt5011
{
    /**
     * @var String
     */
    protected $sFile = '';

    /**
     * @var SimpleXMLElement
     */
    protected $oXml;

    /**
     * @var cl_evt5011consulta
     */
    protected $evt5011consulta;

    /**
     * @var boolean
     */
    protected $bImportViaEnvioEsocial;

    /**
     * @var dadosEvento
     */
    protected $dadosEvento;

    public function __construct($sFile = null, $oXml = null, $dadosEvento = null)
    {
        $this->sFile = $sFile;
        $this->bImportViaEnvioEsocial = empty($sFile);
        $this->oXml = $oXml;
        $this->dadosEvento = $dadosEvento;
        $this->evt5011consulta = new cl_evt5011consulta();
    }

    /**
     * Importa dados do xml para o bancode dados
     * @return int 
     */
    public function processar()
    {
        $this->openFile();
        $aPerApur = explode("-", $this->oXml->evtCS->ideEvento->perApur);
        $this->evt5011consulta->rh219_perapurano = $aPerApur[0];
        $this->evt5011consulta->rh219_perapurmes = isset($aPerApur[1]) ? $aPerApur[1] : null;
        $this->evt5011consulta->rh219_indapuracao = $this->oXml->evtCS->ideEvento->indApuracao;
        $this->evt5011consulta->rh219_instit = $this->getInstitCgm($this->dadosEvento->rh213_empregador);
        $this->evt5011consulta->rh219_classtrib = $this->oXml->evtCS->infoCS->infoContrib->classTrib;
        $this->evt5011consulta->rh219_cnaeprep = $this->oXml->evtCS->infoCS->ideEstab->infoEstab->cnaePrep;
        $this->evt5011consulta->rh219_aliqrat = $this->oXml->evtCS->infoCS->ideEstab->infoEstab->aliqRat;
        $this->evt5011consulta->rh219_fap = $this->oXml->evtCS->infoCS->ideEstab->infoEstab->fap;
        $this->evt5011consulta->rh219_aliqratajust = $this->oXml->evtCS->infoCS->ideEstab->infoEstab->aliqRatAjust;
        $this->evt5011consulta->rh219_fpas = $this->oXml->evtCS->infoCS->ideEstab->ideLotacao->fpas;
        $this->evt5011consulta->rh219_vrbccp00 = $this->getTotalValorBaseCalcVrBcCp00();
        $this->evt5011consulta->rh219_baseaposentadoria = $this->getTotalBaseCalcAposentadoriaEspecial();
        $this->evt5011consulta->rh219_vrsalfam = $this->getTotalValorSalarioFamilia();
        $this->evt5011consulta->rh219_vrsalmat = $this->getTotalValorSalarioMaternidade();
        $this->evt5011consulta->rh219_vrdesccp = $this->oXml->evtCS->infoCS->infoCPSeg->vrDescCP;
        $this->evt5011consulta->rh219_vrcpseg = $this->oXml->evtCS->infoCS->infoCPSeg->vrCpSeg;
        $this->evt5011consulta->rh219_vrcr = $this->getTotalValorDevidoPrevidencia();
        $this->evt5011consulta->incluir(null);
        if ($this->evt5011consulta->erro_status == "0") {
            throw new Exception($this->evt5011consulta->erro_msg);
        }
        return $this->evt5011consulta->rh219_sequencial;
    }

    /**
     * Converter arquivo xml em um objeto 
     */
    protected function openFile()
    {
        if (!empty($this->oXml)) {
            return;
        }
        if (file_exists("../../{$this->sFile}")) {
            throw new Exception("Arquivo não encontrado.");
        }
        $this->oXml = simplexml_load_file($this->sFile);
        if (!$this->oXml) {
            throw new Exception("Erro ao carregar xml.");
        }
    }

    /**
     * @param int 
     * @return int
     */
    protected function getInstitCgm($cgmEmpregador)
    {
        if (!$this->bImportViaEnvioEsocial) {
            return db_getsession("DB_instit");
        }
        $instit = $this->evt5011consulta->sqlInstitCgm($cgmEmpregador);
        if (empty($instit)) {
            throw new Exception("instituição do Empregador não encontrada.");
        }
        return $instit;
    }

    /**
     * @param object
     * @return float
     */
    protected function getTotalValorBase($sField)
    {
        $aBasesRemun = $this->oXml->evtCS->infoCS->ideEstab->ideLotacao->basesRemun;
        $nBase = 0;
        foreach ($aBasesRemun as $oBase) {
            $nBase += floatval($oBase->basesCp->{$sField});
        }
        return $nBase;
    }

    /**
     * @param object
     * @return float
     */
    protected function getTotalValorBaseCalcVrBcCp00()
    {
        return $this->getTotalValorBase("vrBcCp00");
    }

    /**
     * @param object
     * @return float
     */
    protected function getTotalValorSalarioFamilia()
    {
        return $this->getTotalValorBase("vrSalFam");
    }

    /**
     * @param object
     * @return float
     */
    protected function getTotalValorSalarioMaternidade()
    {
        return $this->getTotalValorBase("vrSalMat");
    }

    /**
     * @param object
     * @return float
     */
    protected function getTotalBaseCalcAposentadoriaEspecial()
    {
        $aBasesRemun = $this->oXml->evtCS->infoCS->ideEstab->ideLotacao->basesRemun;
        $nBaseCalcAposentadoriaEspecial = 0;
        foreach ($aBasesRemun as $oBase) {
            $nBaseCalcAposentadoriaEspecial += (floatval($oBase->basesCp->vrBcCp15) + floatval($oBase->basesCp->vrBcCp20) + floatval($oBase->basesCp->vrBcCp25));
        }
        return $nBaseCalcAposentadoriaEspecial;
    }

    /**
     * @param object
     * @return float
     */
    protected function getTotalValorDevidoPrevidencia()
    {
        $aValor = $this->oXml->evtCS->infoCS->ideEstab->infoCREstab;
        $nValor = 0;
        foreach ($aValor as $oBase) {
            $nValor += floatval($oBase->vrCR);
        }
        return $nValor;
    }
}