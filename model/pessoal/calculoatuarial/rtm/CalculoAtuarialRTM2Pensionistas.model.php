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

require_once('model/pessoal/calculoatuarial/rtm/CalculoAtuarialRTMBase.model.php');

/**
 * Calculo Atuarial RTM2 Pensionistas
 * @author Robson de Jesus <robson.silva@contassconsultoria.com.br>
 */
class CalculoAtuarialRTM2Pensionistas extends CalculoAtuarialRTMBase {

	/**
    * arquivo que sera gerado
    * @var String
    */
	protected $sFile = '/tmp/calc_pens.txt';

	function __construct()
	{
		
	}

	public function processar($anofolha,$mesfolha,$where) {

	    $sSql = "SELECT DISTINCT 
	    rh02_anousu as NU_ANO,
	    rh02_mesusu as NU_MES,
	    1 as CO_COMP_MASSA,
	    1 as CO_TIPO_FUNDO,
	    instituicao.z01_cgccpf as CNPJ_ORGAO,
	    db_config.nomeinst as NO_ORGAO,
	    db21_tipopoder as CO_PODER,
	    1 as CO_TIPO_PODER,
	    rh02_cgminstituidor as ID_INSTITUIDOR_MATRICULA,
	    coalesce(instintuidor.z01_nome,' ') as ID_NOME,
	    coalesce(instintuidor.z01_cgccpf::varchar,' ') as ID_INSTITUIDOR_CPF,
	    coalesce(instintuidor.z01_pis,' ') as ID_INSTITUIDOR_PIS_PASEP,
	    CASE WHEN instintuidor.z01_sexo = 'M' THEN 2 ELSE 1 END  as CO_SEXO_INSTITUIDOR,
	    to_char(instintuidor.z01_nasc, 'DD/MM/YYYY') as DT_NASC_INSTITUIDOR,
	    ' ' as OCUP_POSSE_DT,
	    ' ' as OCUP_CARREIRA_TIPO,
	    ' ' as VL_TETO_ESPECIFICO,
	    2 as IN_PREV_COMP,
	    ' ' as OCUP_TSANT_RGPS,
	    ' ' as OCUP_TSANT_RPPS1,
	    ' ' as CO_TIPO_INSTITUIDOR,
	    ' ' as OCUP_BEN_DT,
	    ' ' as ID_UNIAO,
	    to_char(instintuidor.z01_dtfalecimento, 'DD/MM/YYYY') as DT_OBITO_INSTITUIDOR,
	    rh01_regist as ID_PENSIONISTA_MATRICULA,
	    servidor.z01_nome as DEP_NOME,
	    servidor.z01_cgccpf as ID_PENSIONISTA_CPF,
	    servidor.z01_pis as DEP_PIS_PASEP,
	    CASE WHEN rh01_sexo = 'M' THEN 2 ELSE 1 END  as CO_SEXO_PENSIONISTA,
	    to_char(rh01_nasc, 'DD/MM/YYYY') as DT_NASC_PENSIONISTA,
	    1 as CO_CONDICAO,
	    CASE
	    WHEN rh02_tipoparentescoinst = 1 THEN 2
		WHEN rh02_tipoparentescoinst IN (3,7,8) THEN 1
		WHEN rh02_tipoparentescoinst = 4 THEN 3
		WHEN rh02_tipoparentescoinst IN (5,6) THEN 4
		WHEN rh02_tipoparentescoinst = 3 THEN 1
		ELSE 99 END AS CO_TIPO_RELACAO,
		to_char(rh01_admiss, 'DD/MM/YYYY') AS DT_INICIO_PENSAO,
		rh02_salari AS VL_BENEF_PENSAO,
		' ' AS VL_TOT_PENSAO,
		' ' AS OCUP_VLR_REAJUSTE,
		' ' AS VL_CONTRIBUICAO,
		' ' AS VL_PCT_QUOTA,
		' ' AS VL_COMPENS_PREVID,
		CASE WHEN rh01_reajusteparidade = 2 THEN 1 ELSE 2 END AS IN_PARID_SERV,
		CASE WHEN rh02_validadepensao IS NOT NULL THEN 2 ELSE 1 END as CO_DURACAO,
		coalesce(to_char(rh02_validadepensao, 'DD/MM/YYYY'), ' ') as NU_TEMPO_DURACAO
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
		sum(case when r14_pd = 1 then r14_valor else 0 end) as prov,
		sum(case when r14_pd = 2 then r14_valor else 0 end) as desco,
		sum(case when r14_rubric = 'R992' then r14_valor else 0 end ) as base
		FROM gerfsal
		WHERE r14_anousu = $anofolha
		AND r14_mesusu = $mesfolha
		GROUP BY r14_regist) AS sal ON r14_regist = rh01_regist

		join db_config on codigo = rh01_instit
		join cgm instituicao on db_config.numcgm=instituicao.z01_numcgm
		join cgm servidor on servidor.z01_numcgm = rh01_numcgm
		left join cgm instintuidor on instintuidor.z01_numcgm = rh02_cgminstituidor
		where rh30_vinculo = 'P'
	    {$where}";

	    $rsResult = db_query($sSql);
	    // db_criatabela($rsResult);echo pg_numrows($rsResult);die($sSql);
	    $iNum = pg_numrows($rsResult);

	    $this->abreArquivo();
	    $aFields = array('NU_ANO','NU_MES','CO_COMP_MASSA','CO_TIPO_FUNDO','CNPJ_ORGAO','NO_ORGAO','CO_PODER','CO_TIPO_PODER','ID_INSTITUIDOR_MATRICULA','ID_NOME','ID_INSTITUIDOR_CPF','ID_INSTITUIDOR_PIS_PASEP','CO_SEXO_INSTITUIDOR','DT_NASC_INSTITUIDOR','OCUP_POSSE_DT','OCUP_CARREIRA_TIPO','VL_TETO_ESPECIFICO','IN_PREV_COMP','OCUP_TSANT_RGPS','OCUP_TSANT_RPPS1','CO_TIPO_INSTITUIDOR','OCUP_BEN_DT','ID_UNIAO','DT_OBITO_INSTITUIDOR','ID_PENSIONISTA_MATRICULA','DEP_NOME','ID_PENSIONISTA_CPF','DEP_PIS_PASEP','CO_SEXO_PENSIONISTA','DT_NASC_PENSIONISTA','CO_CONDICAO','CO_TIPO_RELACAO','DT_INICIO_PENSAO','VL_BENEF_PENSAO','VL_TOT_PENSAO','OCUP_VLR_REAJUSTE','VL_CONTRIBUICAO','VL_PCT_QUOTA','VL_COMPENS_PREVID','IN_PARID_SERV','CO_DURACAO','NU_TEMPO_DURACAO');
	    $sLine = implode("#", $aFields);
	    $this->adicionaLinha($sLine);
	    for($iCont = 0;$iCont < pg_numrows($rsResult);$iCont++) {
	    
	    	db_atutermometro($iCont,$iNum,'calculo_folha',1);
	    	$oResult = db_utils::fieldsMemory($rsResult,$iCont);
	    	$aLine  = array();
	    	foreach ($aFields as $field) {
	    		$fieldDB = strtolower($field);
	    		$aLine[] = $oResult->{$fieldDB};
	    	}
	    	if (count($aLine) == 0) {
	    		continue;
	    	}
	    	$this->adicionaLinha(implode("#", $aLine));
	    }
	    $this->fechaArquivo();
	}
}