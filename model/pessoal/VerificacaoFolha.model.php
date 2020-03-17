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

require_once("libs/db_utils.php");

/**
 * Classse de Verificacoes do modulo Pessoal
 * @package  Pessoal
 * @author   Robson de Jesus <robson.silva@contassconsultoria.com.br> 
 */
class VerificacaoFolha {

	const RUBRICA_R928 = 'R928';
	const SALARIO = 1;
	const ADIANTAMENTO = 2;
	CONST FERIAS = 3;
	const RESCISAO = 4;
	const DECIMO_TERCEIRO = 5;
	const COMPLEMENTAR = 8;
	const FIXO = 10;

	function __construct(){
		
	}

	public function verificaValorNegativo($matriculas, $opcao) {
		$oDaoFolha = $this->getClassTipoFolha($opcao);
		$sSqlValor = $oDaoFolha->verificaValorNegativo($matriculas);

		$rsVerificaRubrica = db_query($sSqlValor);
		$aMatriculasVerificar = array();
		for ($iVerifica = 0; $iVerifica < pg_num_rows($rsVerificaRubrica); $iVerifica++) { 
			$aMatriculasVerificar[] = db_utils::fieldsMemory($rsVerificaRubrica, $iVerifica)->regist;
		}
		return $aMatriculasVerificar;
	}

	public function verificaServidoresRubricaR928($matriculas, $opcao) {
		$oDaoFolha = $this->getClassTipoFolha($opcao);
		$sSqlRubrica = $oDaoFolha->verificaRubrica(VerificacaoFolha::RUBRICA_R928, $matriculas);

		$rsVerificaRubrica = db_query($sSqlRubrica);
		$aMatriculasVerificar = array();
		for ($iVerifica = 0; $iVerifica < pg_num_rows($rsVerificaRubrica); $iVerifica++) { 
			$aMatriculasVerificar[] = db_utils::fieldsMemory($rsVerificaRubrica, $iVerifica)->regist;
		}
		return $aMatriculasVerificar;
	}

	public function getClassTipoFolha($opcao) {

		switch ($opcao) {
			case VerificacaoFolha::SALARIO:
			    return db_utils::getDao("gerfsal");
			break;
			case VerificacaoFolha::RESCISAO:
			    return db_utils::getDao("gerfres");
			break;
			case VerificacaoFolha::DECIMO_TERCEIRO:
			    return db_utils::getDao("gerfs13");
			break;
			case VerificacaoFolha::COMPLEMENTAR:
			    return db_utils::getDao("gerfcom");
			break;

			default:
			    return db_utils::getDao("gerfsal");
			break;
		}

	}
}