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

require_once('model/pessoal/calculoatuarial/bb/CalculoAtuarialBBBase.model.php');

/**
 * Calculo Atuarial BB Ativos
 * @author Robson de Jesus <robson.silva@contassconsultoria.com.br>
 */
class CalculoAtuarialBBAtivos extends CalculoAtuarialBBBase {

	/**
    * arquivo que sera gerado
    * @var String
    */
	protected $sFile = '/tmp/calc_ativos.txt';

	function __construct()
	{
		
	}

	public function processar($anofolha,$mesfolha,$where) {

		$sSql = "SELECT rh01_regist AS matricula,
		'1'||'#' 
		||'1'||'#' 
		||instituicao.z01_cgccpf||'#' 
		||instituicao.z01_nome||'#' 
		||'1'||'#' 
		||'1'||'#' 
		||'1'||'#' 
		||case when rhfuncao.rh37_funcaogrupo != 2 then 4 else 2 end||'#' 
		||' '||'#' 
		||' '||'#' 
		||lpad(rh01_regist::text,9,'0') ||'#' 
		||servidor.z01_cgccpf||'#' 
		||coalesce(servidor.z01_pis,' ')||'#' 
		||CASE
		WHEN rh01_sexo = 'M' THEN 2
		ELSE 1
		END ||'#'
		||rh01_estciv||'#'
		||to_char(rh01_nasc, 'DD/MM/YYYY')||'#' 
		||'1'||'#' 
		||'1'||'#' 
		||to_char(rh01_admiss, 'DD/MM/YYYY')||'#' 
		||to_char(rh01_admiss, 'DD/MM/YYYY')||'#' 
		||rhfuncao.rh37_descr||'#' 
		||to_char(rh01_admiss, 'DD/MM/YYYY')||'#' 
		||rhfuncao.rh37_descr||'#' 
		||trim(translate(to_char(round(sal.salariobase,2),'999999999.99'),'.',','))||'#' 
		||trim(translate(to_char(round(sal.total,2),'999999999.99'),'.',','))||'#' 
		||' '||'#' 
		||' '||'#'||
		(SELECT count(*)
		FROM rhdepend
		WHERE rh31_regist = rh01_regist) ||'#' ||

		coalesce(to_char(
		(SELECT rh31_dtnasc
		FROM rhdepend
		WHERE rh31_regist=rh01_regist
		AND rh31_gparen='C'
		LIMIT 1), 'DD/MM/YYYY'),' ')||'#'||
		coalesce(
		(SELECT CASE
		WHEN rh31_especi = 'N' THEN '1'
		ELSE '2'
		END AS cond
		FROM rhdepend
		WHERE rh31_regist=rh01_regist
		AND rh31_gparen='C'
		LIMIT 1),' ')||'#' ||
		
		COALESCE( (
		SELECT to_char(rh31_dtnasc, 'DD/MM/YYYY')
		FROM rhdepend
		WHERE rh31_regist = rh01_regist
		ORDER BY rh31_dtnasc DESC
		LIMIT 1), '')  ||'#' ||

		COALESCE((SELECT CASE
		WHEN rh31_especi = 'C'
		OR rh31_especi = 'S' THEN 2
		ELSE 1
		END AS condicao
		FROM rhdepend
		WHERE rh31_codigo =
		(SELECT rh31_codigo
		FROM rhdepend
		WHERE rh31_regist = rh01_regist
		ORDER BY rh31_dtnasc desc
		LIMIT 1) LIMIT 1)::varchar,'')||'#'||
		
		COALESCE(
		(SELECT to_char(rh31_dtnasc, 'DD/MM/YYYY')
		FROM rhdepend
		WHERE rh31_regist = rh01_regist
		ORDER BY rh31_dtnasc DESC
		LIMIT 1 OFFSET 1
		), '') ||'#'||

		COALESCE((SELECT CASE
		WHEN rh31_especi = 'S' OR rh31_especi = 'C' THEN 2
		ELSE 1
		END AS condicao
		FROM rhdepend
		WHERE rh31_codigo = (SELECT rh31_codigo
		FROM rhdepend
		WHERE rh31_regist = rh01_regist
		ORDER BY rh31_dtnasc DESC
		LIMIT 1 OFFSET 1) LIMIT 1)::varchar,'' )||'#'||

		CASE WHEN rh02_abonopermanencia = 'f' THEN 2 ELSE 1 END ||'#'||
		' ' AS todo
		FROM rhpessoal
		INNER JOIN rhpessoalmov ON rh02_regist = rh01_regist AND rh02_anousu = $anofolha AND rh02_mesusu = $mesfolha AND rh01_instit = ".db_getsession('DB_instit')."
		INNER JOIN rhlota ON r70_codigo = rh02_lota
		AND r70_instit = rh02_instit
		INNER JOIN rhfuncao ON rh37_funcao = rh01_funcao
		AND rh37_instit = rh02_instit
		INNER JOIN rhregime ON rh30_codreg = rh02_codreg
		AND rh30_instit = rh02_instit
		INNER JOIN
		(SELECT r14_regist,
		sum(CASE
		WHEN r14_rubric = 'R985' THEN r14_valor
		ELSE 0
		END) AS salariobase,
		sum(case when r14_pd = 1 then r14_valor else 0 end) as total
		FROM gerfsal
		WHERE r14_anousu = $anofolha
		AND r14_mesusu = $mesfolha
		GROUP BY r14_regist) AS sal ON r14_regist = rh01_regist

		join db_config on codigo = rh01_instit
		join cgm instituicao on db_config.numcgm=instituicao.z01_numcgm
		join cgm servidor on servidor.z01_numcgm = rh01_numcgm
		LEFT JOIN afasta ON r45_regist = rh01_regist
		AND r45_anousu = $anofolha
		AND r45_mesusu = $mesfolha
		where rh30_vinculo = 'A'
		and rh30_regime = 1

		$where ";

	    $rsResult = db_query($sSql);
	    
	    $iNum = pg_numrows($rsResult);

	    $this->abreArquivo();
	    for($iCont = 0;$iCont < pg_numrows($rsResult);$iCont++) {
	    
	    	db_atutermometro($iCont,$iNum,'calculo_folha',1);
	    	$sLine = db_utils::fieldsMemory($rsResult,$iCont)->todo;
	    	if (empty($sLine)) {
	    		continue;
	    	}
	    	$this->adicionaLinha($sLine);
	    }
	    $this->fechaArquivo();
	}
}