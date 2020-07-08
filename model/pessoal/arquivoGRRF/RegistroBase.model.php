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

require_once("model/pessoal/arquivoGRRF/IRegistroBase.model.php");

/**
 * Arquivo Guia de Recolhimento Rescisório do FGTS
 * @author Robson de Jesus <robson.silva@contassconsultoria.com.br>
 */
abstract class RegistroBase implements IRegistroBase {

	/**
    * @var Integer
    */
    protected $iAnoFolha;

   /**
    * @var Integer
    */
    protected $iMesFolha;

   /**
    * @var string
    */
    protected $sServidores;

    /**
     * @var object
     */
    protected $oConfig;

    /**
     * @var object
     */
    protected $oDadosAdicionais;

    public function __construct($oDados, $oConfig = null) 
    {
    	$this->iAnoFolha = $oDados->iAnoUsu;
        $this->iMesFolha = $oDados->iMesUsu;
        $this->sServidores = $oDados->selecionados;
        $this->oDadosAdicionais->contato = $oDados->contato;
        $this->oDadosAdicionais->fone = $oDados->fone;
        $this->oDadosAdicionais->dtrecfgts = $oDados->dtrecfgts;
        $this->oDadosAdicionais->cnae = $oDados->cnae;
        $this->oConfig = $oConfig;
    }

	public function gerarRegistro()
	{

	}

	/**
     * @param string $sValor
     * @param integer $iTamanho
     * @param Boolean $lLeft
     */
    protected function formatarCampo($sValor, $iTamanho, $lLeft = false)
    {
        if ($lLeft) {
            return substr(str_pad($sValor, $iTamanho, "0", STR_PAD_LEFT), 0, $iTamanho);
        }
        return substr(str_pad($sValor, $iTamanho, " ", STR_PAD_RIGHT), 0, $iTamanho);
    }

    /**
     * @param string $sValor
     * @param integer $iTamanho
     */
    protected function preencherCampo($sValor, $iTamanho)
    {
        return str_pad($sValor, $iTamanho, $sValor, STR_PAD_RIGHT);
    }

    /**
     * @param string $data
     */
    protected function formatarData($data)
    {
        return $this->formatarCampo(str_replace("/","",$data),8);
    }

    /**
     * @param string $data
     */
    protected function formatarDataBanco($data)
    {
        return str_pad(implode("", array_reverse(explode("-", $data))), 8, " ", STR_PAD_RIGHT);
    }
}