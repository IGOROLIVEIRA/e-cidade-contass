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

require_once("model/pessoal/arquivoGRRF/RegistroBase.model.php");

/**
 * Arquivo Guia de Recolhimento Rescisório do FGTS
 * Registro 10
 * @author Robson de Jesus <robson.silva@contassconsultoria.com.br>
 */
class Registro10 extends RegistroBase {

    /**
     * gerar dados para o registro
     */
	public function gerarRegistro()
	{
		$oDaoCfpess = db_utils::getDao('cfpess');
        $rsCfpess = $oDaoCfpess->sql_record($oDaoCfpess->sql_query_file($this->iAnoFolha,$this->iMesFolha,db_getsession("DB_instit"), "r11_cdfpas"));
        $fpass = db_utils::fieldsMemory($rsCfpess, 0)->r11_cdfpas;
        $aLinha = array();
        $aLinha['tipoRegistro'] = "10";
        $aLinha['tipoInscricaoEmpresa'] = "1";
        $aLinha['inscricaoEmpresa'] = $this->formatarCampo($this->oConfig->cgc, 14);
        $aLinha['zeros'] = $this->preencherCampo('0', 36);
        $aLinha['nomeEmpresaRazaoSocial'] = $this->formatarCampo($this->oConfig->nomeinst, 40);
        $aLinha['logradouro'] = $this->formatarCampo("{$this->oConfig->ender} {$this->oConfig->numero}", 50);
        $aLinha['bairro'] = $this->formatarCampo($this->oConfig->bairro, 20);
        $aLinha['cep'] = $this->formatarCampo($this->oConfig->cep, 8);
        $aLinha['cidade'] = $this->formatarCampo($this->oConfig->munic, 20);
        $aLinha['uf'] = $this->formatarCampo($this->oConfig->uf, 2);
        $aLinha['telefone'] = $this->formatarCampo($this->oDadosAdicionais->fone, 12, true);
        $aLinha['cnaeFiscal'] = $this->formatarCampo($this->oDadosAdicionais->cnae, 7);
        $aLinha['simples'] = "1";
        $aLinha['fpass'] = $this->formatarCampo($fpass, 3);
        $aLinha['brancos'] = $this->preencherCampo(' ', 143);
        $aLinha['finalLinha'] = "*";
        return implode("", $aLinha);
	}
}