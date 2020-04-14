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

/**
 * Calculo Atuarial BB
 * @author Robson de Jesus <robson.silva@contassconsultoria.com.br>
 */
 class CalculoAtuarialBB {

 	function __construct()
	{
		
	}

 	public function processar($anofolha,$mesfolha,$where) {
 		$oAtivos = $this->getSpecificInstance($anofolha,'Ativos');
 		$oAtivos->processar($anofolha,$mesfolha,$where);

 		$oInativos = $this->getSpecificInstance($anofolha,'Inativos');
 		$oInativos->processar($anofolha,$mesfolha,$where);

 		$oPensionistas = $this->getSpecificInstance($anofolha,'Pensionistas');
 		$oPensionistas->processar($anofolha,$mesfolha,$where);
 	}

 	private function getSpecificInstance($anofolha,$sArquivo) {
 		$sPathBB = 'model/pessoal/calculoatuarial/bb/';
 		if (file_exists($sPathBB."{$anofolha}/CalculoAtuarialBB{$sArquivo}{$anofolha}.model.php")) {
 			require_once($sPathBB."{$anofolha}/CalculoAtuarialBB{$sArquivo}{$anofolha}.model.php");
 			$sClassName = "CalculoAtuarialBB{$sArquivo}";
 			return new $sClassName;
 		}
 		require_once($sPathBB."CalculoAtuarialBB{$sArquivo}.model.php");
 		$sClassName = "CalculoAtuarialBB{$sArquivo}";
 		return new $sClassName;
 	}
 }