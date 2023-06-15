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

require_once("classes/db_evt5001consulta_classe.php");

/**
 * Classe para importação de dados de contribuição previdenciária dos eventos S1200, S2299 e S2399.
 * @author Robson de Jesus <robson.silva@contassconsultoria.com.br>
 */
class ImportarDadosEvt5001
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
     * @var cl_evt5001consulta
     */
    protected $evt5001consulta;

    /**
     * @var boolean
     */
    protected $bImportViaEnvioEsocial;

    /**
     * @var dadosEvento
     */
    protected $dadosEvento;

    const BASE_CALC_CONTRIB_PREVID_NORMAL = "11";
    const BASE_CALC_CONTRIB_PREVID_ADICIONAL_15_ANOS = "12";
    const BASE_CALC_CONTRIB_PREVID_ADICIONAL_20_ANOS = "13";
    const BASE_CALC_CONTRIB_PREVID_ADICIONAL_25_ANOS = "14";

    public function __construct($sFile = null, $oXml = null, $dadosEvento = null)
    {
        $this->sFile = $sFile;
        $this->bImportViaEnvioEsocial = empty($sFile);
        $this->oXml = $oXml;
        $this->dadosEvento = $dadosEvento;
        $this->evt5001consulta = new cl_evt5001consulta();
    }

    /**
     * Importa dados do xml para o bancode dados
     * @return int 
     */
    public function processar()
    {
        $this->openFile();
        $aPerApur = explode("-", $this->oXml->evtBasesTrab->ideEvento->perApur);
        $this->evt5001consulta->rh218_perapurano = $aPerApur[0];
        $this->evt5001consulta->rh218_perapurmes = isset($aPerApur[1]) ? $aPerApur[1] : null;
        $this->evt5001consulta->rh218_numcgm = $this->getCgm($this->oXml->evtBasesTrab->ideTrabalhador->cpfTrab);
        $this->evt5001consulta->rh218_regist = null;
        if (!empty($this->oXml->evtBasesTrab->infoCp->ideEstabLot->infoCategIncid->matricula)) {
            $this->evt5001consulta->rh218_regist = $this->getMatricula($this->oXml->evtBasesTrab->ideTrabalhador->cpfTrab, $this->oXml->evtBasesTrab->infoCp->ideEstabLot->infoCategIncid->matricula);
        }
        $this->evt5001consulta->rh218_codcateg = $this->oXml->evtBasesTrab->infoCp->ideEstabLot->infoCategIncid->codCateg;
        $this->evt5001consulta->rh218_vrdescseg = $this->oXml->evtBasesTrab->infoCpCalc->vrDescSeg;
        $this->evt5001consulta->rh218_vrcpseg = $this->oXml->evtBasesTrab->infoCpCalc->vrCpSeg;
        $this->evt5001consulta->rh218_instit = $this->getInstitCgm($this->dadosEvento->rh213_empregador);
        $this->evt5001consulta->rh218_vlrbasecalc = $this->getValorBaseCalcContribSocial($this->oXml);
        if (!empty($this->oXml->evtBasesTrab->infoCp->ideEstabLot->infoCategIncid->matricula)) {
            $this->evt5001consulta->rh218_instit = $this->getInstitMatricula($this->evt5001consulta->rh218_regist);
        }
        $this->evt5001consulta->incluir(null);
        if ($this->evt5001consulta->erro_status == "0") {
            throw new Exception($this->evt5001consulta->erro_msg);
        }
        return $this->evt5001consulta->rh218_sequencial;
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
     * Buscar matricula do servidor para garantir que o servidor está cadastrado 
     * para esta instituição
     * @param string $cpf
     * @param int $matricula
     * @return int
     */
    protected function getMatricula($cpf, $matricula)
    {
        $regist = $this->evt5001consulta->sqlMatricula($cpf, $matricula);
        if (empty($regist)) {
            throw new Exception("Matrícula $matricula não encontrada no evento 5001.");
        }
        return $regist;
    }

    /**
     * Buscar cgm do servidor para garantir que o servidor está cadastrado 
     * para esta instituição
     * @param string $cpf
     * @return int
     */
    protected function getCgm($cpf)
    {
        $cgm = $this->evt5001consulta->sqlCgm($cpf);
        if (empty($cgm)) {
            throw new Exception("Cgm $cgm não encontrada no evento 5001.");
        }
        return $cgm;
    }

    /**
     * Buscar instituição da matricula caso a importação seja via envio do esocial
     * @param int $matricula
     * @return int
     */
    protected function getInstitMatricula($matricula)
    {
        if (!$this->bImportViaEnvioEsocial) {
            return db_getsession("DB_instit");
        }
        $instit = $this->evt5001consulta->sqlInstitMatricula($matricula);
        if (empty($instit)) {
            throw new Exception("instituição da Matrícula não encontrada.");
        }
        return $instit;
    }

    protected function getInstitCgm($cgmEmpregador)
    {
        if (!$this->bImportViaEnvioEsocial) {
            return db_getsession("DB_instit");
        }
        $instit = $this->evt5001consulta->sqlInstitCgm($cgmEmpregador);
        if (empty($instit)) {
            throw new Exception("instituição do Empregador não encontrada.");
        }
        return $instit;
    }

    /**
     * @param object
     * @return float
     */
    protected function getValorBaseCalcContribSocial($oXml)
    {
        $oInfoCategIncid = $oXml->evtBasesTrab->infoCp->ideEstabLot->infoCategIncid;
        $nValorBase = 0;
        foreach ($oInfoCategIncid->infoBaseCS as $oInfoBaseCS) {
            if (in_array($oInfoBaseCS->tpValor, array(self::BASE_CALC_CONTRIB_PREVID_NORMAL, 
                self::BASE_CALC_CONTRIB_PREVID_ADICIONAL_15_ANOS, 
                self::BASE_CALC_CONTRIB_PREVID_ADICIONAL_20_ANOS, 
                self::BASE_CALC_CONTRIB_PREVID_ADICIONAL_25_ANOS
            ))) {
                $nValorBase += floatval($oInfoBaseCS->valor);
            }
        }
        return $nValorBase;
    }
}