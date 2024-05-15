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

require_once('model/pessoal/calculoatuarial/sprev/CalculoAtuarialSPREVBase.model.php');

/**
 * Calculo Atuarial SPREV Inativos
 * @author Robson de Jesus <robson.silva@contassconsultoria.com.br>
 */
class CalculoAtuarialSPREVInativos extends CalculoAtuarialSPREVBase {

	/**
    * arquivo que sera gerado
    * @var String
    */
	protected $sFile = '/tmp/calc_inativos.txt';
	
	function __construct()
	{
		
	}

	public function processar($anofolha,$mesfolha,$where) {

		$sSql = "SELECT DISTINCT 
		rh02_anousu ||'# '||
		rh02_mesusu ||'# '||
		'1' ||'# '||
		'3' ||'# '||
		instituicao.z01_cgccpf ||'# '||
		instituicao.z01_nome ||'# '||
		db21_tipopoder ||'# '||
		'1' ||'# '||
		'4' ||'# '||
		CASE
		WHEN rhfuncao.rh37_funcaogrupo = 3 THEN 4
		WHEN rhfuncao.rh37_funcaogrupo NOT IN(1,2) THEN 7
		ELSE rhfuncao.rh37_funcaogrupo
		END ||'# '||
		CASE
		WHEN rhpessoalmov.rh02_rhtipoapos = 2 THEN 2
		WHEN rhpessoalmov.rh02_rhtipoapos = 3 THEN 1
		WHEN rhpessoalmov.rh02_rhtipoapos = 4 THEN 4
		WHEN rhpessoalmov.rh02_rhtipoapos = 5 THEN 3
		ELSE rhpessoalmov.rh02_rhtipoapos
		END ||'# '||
		rh01_regist ||'# '||
		servidor.z01_cgccpf ||'# '||
		coalesce(servidor.z01_pis,' ') ||'# '||
		CASE
		WHEN rh01_sexo = 'M' THEN 2
		ELSE 1
		END ||'# '||
		CASE
		WHEN rh01_estciv IN(4,6) THEN 9
		ELSE rh01_estciv
		END 
		||'# '||
		to_char(rh01_nasc, 'DD/MM/YYYY') ||'# '||
		' ' ||'# '||
		to_char(rh01_admiss, 'DD/MM/YYYY') ||'# '||
		trim(translate(round(COALESCE(rhpessoalmov.rh02_salari, 0),2)::varchar,'.',','))||'# '||
		' ' ||'# '||
		CASE WHEN rh01_reajusteparidade = 2 THEN 1 ELSE 2 END||'# '||
		CASE WHEN rh02_rhtipoapos = 4 THEN 2 ELSE 1 END||'# '||
		' ' ||'# '||
		'2' ||'# '||
		' ' ||'# '||
		' ' ||'# '||
		' ' ||'# '||
		' ' ||'# '||
		' ' ||'# '||
		' ' ||'# '||
		' ' ||'# '||
		(SELECT count(*)
		FROM rhdepend
		WHERE rh31_regist = rh01_regist) ||'# '||
		COALESCE((SELECT string_agg(depend,'# ') FROM (SELECT to_char(rh31_dtnasc, 'DD/MM/YYYY')||'# '||
		CASE WHEN rh31_especi IN('C','S') THEN 2
		ELSE 1 END||'# '||
		CASE WHEN rh31_gparen = 'C' THEN 1
		WHEN rh31_gparen = 'F' AND (rh31_especi = 'N' OR rh31_especi IS NULL) THEN 2
		WHEN rh31_gparen = 'F' AND rh31_especi IN ('C','S') THEN 3
		ELSE 6 END AS depend
		FROM rhdepend WHERE rh31_regist = rh01_regist ORDER BY rh01_regist DESC) AS dependentes)::varchar,' ')
		AS todo
		FROM rhpessoal
		INNER JOIN rhpessoalmov ON rh02_regist = rh01_regist
		AND rh02_anousu = $anofolha
		AND rh02_mesusu = $mesfolha
		AND rh01_instit = ".db_getsession('DB_instit')."
		INNER JOIN rhlota ON r70_codigo = rh02_lota
		AND r70_instit = rh02_instit
		INNER JOIN rhfuncao ON rh37_funcao = rh01_funcao
		AND rh37_instit = rh02_instit
		INNER JOIN rhregime ON rh30_codreg = rh02_codreg
		AND rh30_instit = rh02_instit
		INNER JOIN
		(SELECT r14_regist,
		sum(CASE
		WHEN r14_pd = 1 THEN r14_valor
		ELSE 0
		END) AS prov,
		sum(CASE
		WHEN r14_pd = 2 THEN r14_valor
		ELSE 0
		END) AS desco,
		sum(CASE
		WHEN r14_rubric = 'R992' THEN r14_valor
		ELSE 0
		END) AS base
		FROM gerfsal
		WHERE r14_anousu = $anofolha
		AND r14_mesusu = $mesfolha
		GROUP BY r14_regist) AS sal ON r14_regist = rh01_regist
		JOIN db_config ON codigo = rh01_instit
		JOIN cgm instituicao ON db_config.numcgm=instituicao.z01_numcgm
		JOIN cgm servidor ON servidor.z01_numcgm = rh01_numcgm
		WHERE rh30_vinculo = 'I'

		$where ";

		$rsResult = db_query($sSql);
	    
	    $iNum = pg_numrows($rsResult);

	    $this->abreArquivo();
	    for($iCont = 0;$iCont < pg_numrows($rsResult);$iCont++) {
	    
	    	db_atutermometro($iCont,$iNum,'calculo_folha1',1);
	    	$sLine = db_utils::fieldsMemory($rsResult,$iCont)->todo;
	    	if (empty($sLine)) {
	    		continue;
	    	}
	    	$this->adicionaLinha($sLine);
	    }
	    $this->fechaArquivo();
	}
}