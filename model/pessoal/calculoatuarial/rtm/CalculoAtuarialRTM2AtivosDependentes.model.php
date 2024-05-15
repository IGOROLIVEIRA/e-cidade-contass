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
 * Calculo Atuarial RTM2 Ativos Dependentes
 * @author Robson de Jesus <robson.silva@contassconsultoria.com.br>
 */
class CalculoAtuarialRTM2AtivosDependentes extends CalculoAtuarialRTMBase {

	/**
    * arquivo que sera gerado
    * @var String
    */
	protected $sFile = '/tmp/calc_ativos_dependentes.txt';

	function __construct()
	{
		
	}

	public function processar($anofolha,$mesfolha,$where) {

	    $sSql = "SELECT DISTINCT 
	    rh02_anousu as NU_ANO,
	    rh02_mesusu as NU_MES,
	    (select
            db125_codigosistema
        from
            cadendermunicipio
        inner join cadendermunicipiosistema on
            cadendermunicipiosistema.db125_cadendermunicipio = cadendermunicipio.db72_sequencial
            and cadendermunicipiosistema.db125_db_sistemaexterno = 4
        where to_ascii(db72_descricao) = to_ascii(trim(instituicao.z01_munic)) LIMIT 1) as CO_IBGE,
        db_config.nomeinst as NO_ENTE,
        'MG' as SG_UF,
        1 as CO_COMP_MASSA,
        3 as CO_TIPO_FUNDO,
        instituicao.z01_cgccpf as CNPJ_ORGAO,
        db_config.nomeinst as NO_ORGAO,
        db21_tipopoder as CO_PODER,
        1 as CO_TIPO_PODER,
        rh01_regist as ID_SEGURADO_MATRICULA,
        servidor.z01_cgccpf as ID_SEGURADO_CPF,
        coalesce(servidor.z01_pis,' ') as ID_SEGURADO_PIS_PASEP,
        CASE WHEN rh01_sexo = 'M' THEN 2 ELSE 1 END  as CO_SEXO_SEGURADO,
        ' ' as ID_DEPENDENTE,
        rh31_cpf as ID_DEPENDENTE_CPF,
        to_char(rh31_dtnasc, 'DD/MM/YYYY') as DT_NASC_DEPENDENTE,
        CASE WHEN rh31_sexo = 'M' THEN 2 ELSE 1 END  as CO_SEXO_DEPENDENTE,
        CASE WHEN rh31_especi in ('C','S') THEN 2 ELSE 1 END AS CO_CONDICAO_DEPENDENTE,
        CASE 
        WHEN rh31_gparen = 'C' THEN 1 
        WHEN rh31_gparen = 'F' THEN 3 
        WHEN rh31_gparen IN ('P','M') AND rh31_irf = '6' THEN 5 
        ELSE 99 END AS CO_TIPO_DEPENDECIA
	    FROM rhpessoal
	    INNER JOIN rhpessoalmov ON rh02_regist = rh01_regist
	    AND rh02_anousu = {$anofolha}
	    AND rh02_mesusu = {$mesfolha}
	    AND rh01_instit = ".db_getsession('DB_instit')."
	    INNER JOIN rhdepend ON rh01_regist = rh31_regist
	    INNER JOIN rhlota ON r70_codigo = rh02_lota
	    AND r70_instit = rh02_instit
	    INNER JOIN rhfuncao ON rh37_funcao = rh01_funcao
	    AND rh37_instit = rh02_instit
	    INNER JOIN rhregime ON rh30_codreg = rh02_codreg
	    AND rh30_instit = rh02_instit
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
	    {$where}
	    ORDER BY rh01_regist";

	    $rsResult = db_query($sSql);
	    // db_criatabela($rsResult);echo pg_last_error();die($sSql);
	    $iNum = pg_numrows($rsResult);

	    $this->abreArquivo();
	    $aFields = array('NU_ANO','NU_MES','CO_IBGE','NO_ENTE','SG_UF','CO_COMP_MASSA','CO_TIPO_FUNDO','CNPJ_ORGAO','NO_ORGAO','CO_PODER','CO_TIPO_PODER','ID_SEGURADO_MATRICULA','ID_SEGURADO_CPF','ID_SEGURADO_PIS_PASEP','CO_SEXO_SEGURADO','ID_DEPENDENTE','ID_DEPENDENTE_CPF','DT_NASC_DEPENDENTE','CO_SEXO_DEPENDENTE','CO_CONDICAO_DEPENDENTE','CO_TIPO_DEPENDECIA');
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