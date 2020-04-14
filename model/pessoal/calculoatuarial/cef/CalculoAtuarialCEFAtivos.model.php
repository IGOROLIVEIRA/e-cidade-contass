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

require_once('model/pessoal/calculoatuarial/cef/CalculoAtuarialCEFBase.model.php');

/**
 * Calculo Atuarial CEF Ativos
 * @author Robson de Jesus <robson.silva@contassconsultoria.com.br>
 */
class CalculoAtuarialCEFAtivos extends CalculoAtuarialCEFBase {

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
		trim(substr(r70_descr,1,20)) ||'#' || trim(substr(rh01_regist,1,40)) ||'#' || '1' ||'#' ||'S' ||'#' ||trim(rh01_sexo) ||'#' ||to_char(rh01_nasc,'DD/MM/YYYY') ||'#' ||
		to_char(rh01_admiss,'DD/MM/YYYY') ||'#' ||
		to_char(rh01_admiss,'DD/MM/YYYY') ||'#' ||
		trim(translate(to_char(round(base,2),'99999999,99'),',','')) ||'#' ||
		case
		when rh37_funcaogrupo in (0) then 4
		else rh37_funcaogrupo
		end
		||'#' ||
		' '
		||'#' ||
		' '
		||'#' ||
		case
		when (select rh31_gparen from rhdepend where rh31_regist = rhpessoal.rh01_regist and rh31_gparen = 'C' limit 1)  is not null then 'S'
		else 'N'
		end
		||'#' ||
		case
		when (select rh31_gparen from rhdepend where rh31_regist = rhpessoal.rh01_regist and rh31_gparen = 'C' limit 1)  is not null then
		(select to_char(rh31_dtnasc,'DD/MM/YYYY') from rhdepend where rh31_regist = rhpessoal.rh01_regist and rh31_gparen = 'C' limit 1)
		else ' '
		end
		||'#' ||
		case
		when (select to_char(rh31_dtnasc,'DD/MM/YYYY') from rhdepend where rh31_regist = rhpessoal.rh01_regist and rh31_especi <> 'N' order by rh31_dtnasc desc  limit 1)  is not null then
		(select to_char(rh31_dtnasc,'DD/MM/YYYY') from rhdepend where rh31_regist = rhpessoal.rh01_regist and rh31_especi <> 'N' order by rh31_dtnasc desc  limit 1)
		else ' '
		end
		||'#' ||
		case
		when (select to_char(rh31_dtnasc,'DD/MM/YYYY') from rhdepend where rh31_regist = rhpessoal.rh01_regist and rh31_especi = 'N' order by rh31_dtnasc desc  limit 1)  is not null then
		(select to_char(rh31_dtnasc,'DD/MM/YYYY') from rhdepend where rh31_regist = rhpessoal.rh01_regist and rh31_especi = 'N' order by rh31_dtnasc desc  limit 1)
		else ' '
		end
		||'#' ||
		' ' as todo
		
		from rhpessoal 
		inner join cgm          on rh01_numcgm = z01_numcgm 
		inner join rhpessoalmov on rh02_regist = rh01_regist 
		and rh02_anousu = $anofolha 
		and rh02_mesusu = $mesfolha 
		inner join rhlota       on r70_codigo = rh02_lota 
		inner join rhfuncao     on rh37_funcao = rh01_funcao
		and rh37_instit = rh02_instit
		inner join rhregime on rh30_codreg = rh02_codreg
		inner join (select r14_regist,
		sum(case when r14_pd != 3 and r14_pd = 1 then r14_valor else 0 end) as prov,
		sum(case when r14_pd != 3 and r14_pd = 2 then r14_valor else 0 end) as desco,
		sum(case when r14_rubric = 'R992' then r14_valor else 0 end ) as base
		from gerfsal 
		where r14_anousu = $anofolha 
		and r14_mesusu = $mesfolha
		group by r14_regist ) as sal on r14_regist = rh01_regist 
		where rh30_vinculo = 'A' 
		and rh30_regime = 1
		$where";

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