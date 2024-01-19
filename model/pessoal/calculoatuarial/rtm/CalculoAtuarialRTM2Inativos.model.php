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
 * Calculo Atuarial RTM2 Inativos
 * @author Robson de Jesus <robson.silva@contassconsultoria.com.br>
 */
class CalculoAtuarialRTM2Inativos extends CalculoAtuarialRTMBase {

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
	    rh02_anousu as NU_ANO,
	    rh02_mesusu as NU_MES,
	    1 as CO_TIPO_FUNDO,
	    4 as CO_COMP_MASSA,
	    instituicao.z01_cgccpf as CNPJ_ORGAO,
	    db_config.nomeinst as NO_ORGAO,
	    db21_tipopoder as CO_PODER,
	    1 as CO_TIPO_PODER,
	    rh01_regist as ID_APOSENTADO_MATRICULA,
	    servidor.z01_nome as ID_NOME,
	    servidor.z01_cgccpf as ID_APOSENTADO_CPF,
	    coalesce(servidor.z01_pis,' ') as ID_APOSENT_PIS_PASEP,
	    CASE WHEN rh01_sexo = 'M' THEN 2 ELSE 1 END  as CO_SEXO_APOSENTADO,
	    to_char(rh01_nasc, 'DD/MM/YYYY') as DT_NASC_APOSENTADO,
	    ' ' as DT_ING_SERV_PUB,
	    to_char(rh01_dtingressocargoefetivo, 'DD/MM/YYYY') as DATA_DE_INGRESSO_NO_ENTE,
	    CASE WHEN rh01_estciv IN (0,4) THEN 9 ELSE rh01_estciv END as CO_EST_CIVIL_APOSENTADO,
	    ' ' as ID_UNIAO,
	    rh01_matorgaobeneficio as ID_MAT,
	    CASE WHEN rh37_funcaogrupo = 2 THEN 2 ELSE 7 END AS CO_TIPO_CARGO,
	    2 as IN_PREV_COMP,
	    CASE WHEN rh02_rhtipoapos = 4 THEN 2 ELSE 1 END AS CO_CONDICAO_APOSENTADO,
	    CASE WHEN rh02_rhtipoapos = 2 THEN 2
		WHEN rh02_rhtipoapos = 3 THEN 1
		WHEN rh02_rhtipoapos = 4 THEN 4
		WHEN rh02_rhtipoapos = 5 THEN 3
		WHEN rh02_rhtipoapos = 6 THEN 5
	    END AS CO_TIPO_APOSENTADORIA,
	    to_char(rh01_admiss, 'DD/MM/YYYY') as DT_INICIO_APOSENTADORIA,
	    trim(translate(round(COALESCE(sal.total,0),2)::varchar,'.',',')) AS VL_APOSENTADORIA,
	    ' ' AS OCUP_VLR_REAJUSTE,
	    ' ' AS VL_CONTRIBUICAO,
	    ' ' AS VL_COMPENS_PREVID,
	    ' ' AS VL_TETO_ESPECIFICO,
	    CASE WHEN rh01_reajusteparidade = 2 THEN 1 ELSE 2 END AS IN_PARID_SERV,
	    ' ' AS OCUP_TSANT_RGPS,
	    ' ' AS NU_TEMPO_RPPS_MUN,
	    ' ' AS NU_TEMPO_RPPS_EST,
	    ' ' AS NU_TEMPO_RPPS_FED,
	    ' ' AS NU_TEMPO_RPPS,
	    (SELECT count(*)
	    FROM rhdepend
	    WHERE rh31_regist = rh01_regist) AS NU_DEPENDENTES
	    FROM rhpessoal
	    INNER JOIN rhpessoalmov ON rh02_regist = rh01_regist
	    AND rh02_anousu = {$anofolha}
	    AND rh02_mesusu = {$mesfolha}
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
	    WHEN r14_rubric = 'R992' THEN r14_valor
	    ELSE 0
	    END) AS salariobase,
	    sum(CASE
	    WHEN r14_rubric = 'R993' THEN r14_valor
	    ELSE 0
	    END) AS vlrcontribuicao,
	    sum(CASE
	    WHEN r14_pd = 1 THEN r14_valor
	    ELSE 0
	    END) AS total
	    FROM gerfsal
	    WHERE r14_anousu = {$anofolha}
	    AND r14_mesusu = {$mesfolha}
	    GROUP BY r14_regist) AS sal ON r14_regist = rh01_regist
	    JOIN db_config ON codigo = rh01_instit
	    JOIN cgm instituicao ON db_config.numcgm=instituicao.z01_numcgm
	    JOIN cgm servidor ON servidor.z01_numcgm = rh01_numcgm
	    WHERE rh30_vinculo = 'I'
	    {$where}";

	    $rsResult = db_query($sSql);
	    // db_criatabela($rsResult);echo pg_num_rows($rsResult);die($sSql);
	    $iNum = pg_numrows($rsResult);

	    $this->abreArquivo();
	    $aFields = array('NU_ANO','NU_MES','CO_TIPO_FUNDO','CO_COMP_MASSA','CNPJ_ORGAO','NO_ORGAO','CO_PODER','CO_TIPO_PODER','ID_APOSENTADO_MATRICULA','ID_NOME','ID_APOSENTADO_CPF','ID_APOSENT_PIS_PASEP','CO_SEXO_APOSENTADO','DT_NASC_APOSENTADO','DT_ING_SERV_PUB','DATA_DE_INGRESSO_NO_ENTE','CO_EST_CIVIL_APOSENTADO','ID_UNIAO','ID_MAT','CO_TIPO_CARGO','IN_PREV_COMP','CO_CONDICAO_APOSENTADO','CO_TIPO_APOSENTADORIA','DT_INICIO_APOSENTADORIA','VL_APOSENTADORIA','OCUP_VLR_REAJUSTE','VL_CONTRIBUICAO','VL_COMPENS_PREVID','VL_TETO_ESPECIFICO','IN_PARID_SERV','OCUP_TSANT_RGPS','NU_TEMPO_RPPS_MUN','NU_TEMPO_RPPS_EST','NU_TEMPO_RPPS_FED','NU_TEMPO_RPPS','NU_DEPENDENTES');
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