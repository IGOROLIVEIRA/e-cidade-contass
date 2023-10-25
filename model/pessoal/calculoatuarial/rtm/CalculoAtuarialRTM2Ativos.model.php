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
 * Calculo Atuarial RTM2 Ativos
 * @author Robson de Jesus <robson.silva@contassconsultoria.com.br>
 */
class CalculoAtuarialRTM2Ativos extends CalculoAtuarialRTMBase {

	/**
    * arquivo que sera gerado
    * @var String
    */
	protected $sFile = '/tmp/calc_ativos.txt';

	function __construct()
	{
		
	}

	public function processar($anofolha,$mesfolha,$where) {

	    $sSql = "SELECT DISTINCT 
	    rh02_anousu as NU_ANO,
	    rh02_mesusu as NU_MES,
	    1 as CO_TIPO_FUNDO,
	    1 as CO_COMP_MASSA,
	    instituicao.z01_cgccpf as NU_CNPJ_ORGAO,
	    db_config.nomeinst as NO_ORGAO,
	    db21_tipopoder as CO_PODER,
	    1 as CO_TIPO_PODER,
	    rh01_regist as ID_SERVIDOR_MATRICULA,
	    servidor.z01_nome as ID_NOME,
	    servidor.z01_cgccpf as ID_SERVIDOR_CPF,
	    coalesce(servidor.z01_pis,' ') as ID_SERVIDOR_PIS_PASEP,
	    CASE WHEN rh01_sexo = 'M' THEN 2 ELSE 1 END  as CO_SEXO_SERVIDOR,
	    CASE WHEN rh01_estciv IN (0,4) THEN 9 ELSE rh01_estciv END as CO_EST_CIVIL_SERVIDOR,
	    ' ' as ID_UNIAO,
	    to_char(rh01_nasc, 'DD/MM/YYYY') as DT_NASC_SERVIDOR,
	    CASE
	    WHEN r45_situac = 2 OR r45_situac = 7 THEN 3
	    WHEN r45_situac = 6 THEN 14
	    WHEN r45_situac = 5 THEN 15
	    WHEN r45_situac = 13 THEN 2
	    WHEN r45_situac = 11 THEN 9
	    WHEN r45_situac = 3 OR r45_situac = 4 OR r45_situac = 9 THEN 99
	    ELSE 1 END as CO_SITUACAO_FUNCIONAL,
	    CASE WHEN r45_situac = 3 OR r45_situac = 9 THEN to_char(r45_dtreto, 'DD/MM/YYYY') ELSE NULL END AS OCUP_SIT_FUNC_DT,
	    CASE 
	    WHEN rh30_regime = 1 AND rh30_naturezaregime = 1 THEN 1
	    WHEN rh30_regime = 1 AND rh30_naturezaregime = 2 THEN 2
	    ELSE NULL END AS CO_TIPO_VINCULO,
	    to_char(rh01_admiss, 'DD/MM/YYYY') as DT_ING_SERV_PUB,
	    to_char(rh01_admiss, 'DD/MM/YYYY') as DT_ING_ENTE,
	    '1' as CO_TIPO_POPULACAO,
	    CASE WHEN rh37_funcaogrupo = 2 THEN 3 ELSE 1 END AS CO_CRITERIO_ELEGIBILIDADE,
	    CASE WHEN rh02_abonopermanencia = 't' THEN 1 ELSE 2 END AS IN_ABONO_PERMANENCIA,
	    CASE WHEN rh02_abonopermanencia = 't' THEN rh02_datainicio ELSE NULL END AS DT_INICIO_ABONO,
	    '2' AS IN_PREV_COMP,
	    ' ' as VL_TETO_ESPECIFICO,
	    to_char(rh01_admiss, 'DD/MM/YYYY') as DT_ING_CARREIRA,
	    rh37_descr AS NO_CARREIRA,
	    to_char(rh01_admiss, 'DD/MM/YYYY') as DT_ING_CARGO,
	    CASE WHEN rh37_funcaogrupo = 2 THEN 2 ELSE 7 END AS CO_TIPO_CARGO,
	    rh37_descr AS NO_CARGO,
	    trim(translate(round(COALESCE(sal.salariobase,0),2)::varchar,'.',',')) AS VL_BASE_CALCULO,
	    trim(translate(round(COALESCE(sal.total,0),2)::varchar,'.',',')) AS VL_REMUNERACAO,
	    trim(translate(round(COALESCE(sal.vlrcontribuicao,0),2)::varchar,'.',',')) AS VL_CONTRIBUICAO,
	    ' ' AS OCUP_VLR_REAJUSTE,
	    ' ' AS OCUP_TSANT_RGPS_PRI,
	    ' ' AS OCUP_TSANT_RGPS_PUB,
	    ' ' AS NU_TEMPO_RPPS_MUN,
	    ' ' AS NU_TEMPO_RPPS_EST,
	    ' ' AS NU_TEMPO_RPPS_FED,
	    ' ' AS NU_TEMPO_RPPS,
	    ' ' AS VL_PISO_ESPECIFICO,
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
	    LEFT JOIN
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
	    LEFT JOIN (SELECT * FROM afasta 
	    WHERE DATE_PART('YEAR', r45_dtafas) = {$anofolha}
	    AND  DATE_PART('MONTH', r45_dtafas) = {$mesfolha} LIMIT 1) as afasta
	    ON r45_regist = rh01_regist
	    AND DATE_PART('YEAR', r45_dtafas) = {$anofolha}
	    AND  DATE_PART('MONTH', r45_dtafas) = {$mesfolha}
	    WHERE rh30_vinculo = 'A'
	    AND rh30_regime = 1
	    AND NOT EXISTS
	    (SELECT *
	    FROM rhpesrescisao
	    WHERE rh05_seqpes = rhpessoalmov.rh02_seqpes)
	    {$where}";

	    $rsResult = db_query($sSql);
	     //db_criatabela($rsResult);echo pg_last_error();die($sSql);
	    $iNum = pg_numrows($rsResult);

	    $this->abreArquivo();
	    $aFields = array('NU_ANO','NU_MES','CO_TIPO_FUNDO','CO_COMP_MASSA','NU_CNPJ_ORGAO','NO_ORGAO','CO_PODER','CO_TIPO_PODER','ID_SERVIDOR_MATRICULA','ID_NOME','ID_SERVIDOR_CPF','ID_SERVIDOR_PIS_PASEP','CO_SEXO_SERVIDOR','CO_EST_CIVIL_SERVIDOR','ID_UNIAO','DT_NASC_SERVIDOR','CO_SITUACAO_FUNCIONAL','OCUP_SIT_FUNC_DT','CO_TIPO_VINCULO','DT_ING_SERV_PUB','DT_ING_ENTE','CO_TIPO_POPULACAO','CO_CRITERIO_ELEGIBILIDADE','IN_ABONO_PERMANENCIA','DT_INICIO_ABONO','IN_PREV_COMP','VL_TETO_ESPECIFICO','DT_ING_CARREIRA','NO_CARREIRA','DT_ING_CARGO','CO_TIPO_CARGO','NO_CARGO','VL_BASE_CALCULO','VL_REMUNERACAO','VL_CONTRIBUICAO','OCUP_VLR_REAJUSTE','OCUP_TSANT_RGPS_PRI','OCUP_TSANT_RGPS_PUB','NU_TEMPO_RPPS_MUN','NU_TEMPO_RPPS_EST','NU_TEMPO_RPPS_FED','NU_TEMPO_RPPS','VL_PISO_ESPECIFICO','NU_DEPENDENTES');
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