<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_cvc102014_classe.php");
require_once ("classes/db_cvc202014_classe.php");
require_once ("classes/db_cvc302014_classe.php");
require_once ("classes/db_cvc402014_classe.php");


require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2014/GerarCVC.model.php");


 /**
  * Dados Cadastro de Veículos Sicom Acompanhamento Mensal
  * @author robson
  * @package Contabilidade
  */
class SicomArquivoCadastroVeiculos extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 175;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'CVC';
  
  /**
   * 
   * Construtor da classe
   */
  public function __construct() {
    
  }
  
  /**
	 * Retorna o codigo do layout
	 *
	 * @return Integer
	 */
  public function getCodigoLayout(){
    return $this->iCodigoLayout;
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV 
   */
  public function getCampos(){
    
    
  }
  
  /**
   * selecionar os dados do cadastro de veículos
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
    
/**
  	 * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo 
  	 */
  	$clcvc102014 = new cl_cvc102014();
  	$clcvc202014 = new cl_cvc202014();
  	$clcvc302014 = new cl_cvc302014();
  	$clcvc402014 = new cl_cvc402014();
  	
  	$sSqlTrataUnidade = "select si08_tratacodunidade from infocomplementares where si08_instit = ".db_getsession("DB_instit");
	$rsResultTrataUnidade = db_query($sSqlTrataUnidade);
	$sTrataCodUnidade = db_utils::fieldsMemory($rsResultTrataUnidade, 0)->si08_tratacodunidade;
	
    
    /**
     * excluir informacoes do mes selecioado
     */
    db_inicio_transacao();
    $result = db_query($clcvc102014->sql_query(NULL,"*",NULL,"si146_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']."
               and si146_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clcvc102014->excluir(NULL,"si146_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si146_instit=".db_getsession("DB_instit"));
      if ($clcvc102014->erro_status == 0) {
    	  throw new Exception($clcvc102014->erro_msg);
      }
    }
   
    $result = db_query($clcvc202014->sql_query(NULL,"*",NULL,"si147_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." 
        and si147_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clcvc202014->excluir(NULL,"si147_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si147_instit=".db_getsession("DB_instit"));
      if ($clcvc202014->erro_status == 0) {
    	  throw new Exception($clcvc202014->erro_msg);
      }
    }
    
    $result = db_query($clcvc302014->sql_query(NULL,"*",NULL,"si148_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si148_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clcvc302014->excluir(NULL,"s148_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si148_instit=".db_getsession("DB_instit"));
      if ($clcvc302014>erro_status == 0) {
    	  throw new Exception($clcvc302014->erro_msg);
      }
    }
     
    $result = db_query($clcvc402014->sql_query(NULL,"*",NULL,"si149_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si149_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clcvc402014->excluir(NULL,"si149_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si149_instit=".db_getsession("DB_instit"));
      if ($clcvc402014->erro_status == 0) {
    	  throw new Exception($clcvc402014->erro_msg);
      }
    }
    
    $sSql="SELECT DISTINCT '10' as tipoRegistro,
	si09_codorgaotce  as codOrgao,
	case when (unveic.o41_codtri::int != 0 and orveic.o40_codtri::int = 0) then lpad(orveic.o40_orgao,2,0)||lpad(unveic.o41_codtri,3,0) 
	     when (unveic.o41_codtri::int = 0 and orveic.o40_codtri::int != 0) then lpad(orveic.o40_codtri,2,0)||lpad(unveic.o41_unidade,3,0)
	     when (unveic.o41_codtri::int != 0 and orveic.o40_codtri::int != 0) then lpad(orveic.o40_codtri,2,0)||lpad(unveic.o41_codtri,3,0)	
            else lpad(orveic.o40_orgao,2,0)||lpad(unveic.o41_unidade,3,0) end as codunidadesub,
	veiculos.ve01_codigo as codVeiculo,
	tipoveiculos.si04_tipoveiculo as tpVeiculo,
	tipoveiculos.si04_especificacao as subTipoVeiculo,
	substr(tipoveiculos.si04_descricao, 1, 100) as descVeiculo,
	veiccadmarca.ve21_descr as marca,
	veiccadmodelo.ve22_descr as modelo,
	veiculos.ve01_anofab as ano,
	veiculos.ve01_placa as placa,
	veiculos.ve01_chassi as chassi,
	veiculos.ve01_ranavam as numeroRenavam,
	veiculos.ve01_nroserie as nroSerie,
	tipoveiculos.si04_situacao as situacao,
	'01' as tpDeslocament,
	o41_subunidade as subunidade		
	FROM veiculos.veiculos as veiculos
	INNER JOIN veiculos.veiccentral as veiccentral on (veiculos.ve01_codigo =veiccentral.ve40_veiculos)
	INNER JOIN veiculos.veiccadcentral as veiccadcentral on (veiccentral.ve40_veiccadcentral =veiccadcentral.ve36_sequencial)
	INNER JOIN veiculos.veiccadmarca as veiccadmarca on (veiculos.ve01_veiccadmarca=veiccadmarca.ve21_codigo)
	INNER JOIN veiculos.veiccadmodelo as veiccadmodelo on (veiculos.ve01_veiccadmodelo=veiccadmodelo.ve22_codigo)
	INNER JOIN configuracoes.db_depart as db_depart on (veiccadcentral.ve36_coddepto =db_depart.coddepto)
	INNER JOIN configuracoes.db_departorg as db_departorg on (db_depart.coddepto =db_departorg.db01_coddepto)
	INNER JOIN configuracoes.db_config as db_config on (db_depart.instit=db_config.codigo)
	INNER JOIN tipoveiculos on (veiculos.ve01_codigo=tipoveiculos.si04_veiculos)
	inner join orcunidade unveic on db01_orgao = unveic.o41_orgao and db01_unidade = unveic.o41_unidade and unveic.o41_anousu = ".db_getsession("DB_anousu")."
	inner join orcorgao orveic on o41_anousu = orveic.o40_anousu and o41_orgao = orveic.o40_orgao 
	left join infocomplementaresinstit on si09_instit = db_depart.instit ";

  if (db_getsession("DB_anousu") <= 2014 && ($this->sDataFinal['5'].$this->sDataFinal['6']) == '01') {
  	$sSql .= " WHERE db_config.codigo =  " .db_getsession("DB_instit");
  } else {
	  $sSql .= " WHERE db_config.codigo =  " .db_getsession("DB_instit") ."
	  AND  DATE_PART('YEAR',veiculos.ve01_dtaquis) = ".db_getsession("DB_anousu")."
	  AND  DATE_PART('MONTH',veiculos.ve01_dtaquis) = " .$this->sDataFinal['5'].$this->sDataFinal['6']."";
  }
  	
    
    
    
    //INNER JOIN  liclicita on  db_config.codigo= liclicita.l20_instit linha adicionada
    
    $rsResult10 = db_query($sSql);
    //echo pg_last_error();
    //db_criatabela($rsResult10);echo $sSql;exit;
    if(pg_num_rows($rsResult10) != 0){
	    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
	    	
	    	$clcvc102014 = new cl_cvc102014();
	    	$oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
		   
	    	if ($oDados10->subunidade == 1) {
	    		$oDados10->codunidadesub .= str_pad($oDados10->subunidade,3,"0",STR_PAD_LEFT);
	    	}
	    	 
	    	$sSqlVerifica = "select * from cvc102014 where si146_codveiculo = '{$oDados10->codveiculo}' 
	    	and si146_mes <= " .$this->sDataFinal['5'].$this->sDataFinal['6'];
	    	$rsResultVerifica = db_query($sSqlVerifica);
	    	if (pg_num_rows($rsResultVerifica) > 0) {
	    		continue;
	    	}
	    	
		    $clcvc102014->si146_tiporegistro    	= 10;
			$clcvc102014->si146_codorgao			= $oDados10->codorgao;
			$clcvc102014->si146_codunidadesub		= $oDados10->codunidadesub;
			$clcvc102014->si146_codveiculo			= $oDados10->codveiculo;
			$clcvc102014->si146_tpveiculo			= $oDados10->tpveiculo;
			$clcvc102014->si146_subtipoveiculo		= $oDados10->subtipoveiculo;
			$clcvc102014->si146_descveiculo			= $this->removeCaracteres($oDados10->descveiculo);   
			$clcvc102014->si146_marca				= $oDados10->marca;        
			$clcvc102014->si146_modelo				= $oDados10->modelo;       
			$clcvc102014->si146_ano					= $oDados10->ano ;         
			$clcvc102014->si146_placa				= $oDados10->tpveiculo == 3 ? $oDados10->placa : ' ';        
			$clcvc102014->si146_chassi				= $oDados10->tpveiculo == 3 ? $oDados10->chassi : ' ';       
			$clcvc102014->si146_numerorenavam		= $oDados10->tpveiculo == 3 ? $oDados10->numerorenavam : '0';
			$clcvc102014->si146_nroserie			= $oDados10->nroserie;       
			$clcvc102014->si146_situacao			= $oDados10->situacao;     
			$clcvc102014->si146_tpdeslocamento		= $oDados10->tpdeslocament;
			$clcvc102014->si146_instit				= db_getsession("DB_instit");
			$clcvc102014->si146_mes             	= $this->sDataFinal['5'].$this->sDataFinal['6']; 
			
			  
			  
			  $clcvc102014->incluir(null);
			  if ($clcvc102014->erro_status == 0) {
			  	throw new Exception($clcvc102014->erro_msg);
			  }
			  
	    }
    }
    
    /*
     * Registro 20  
     */
		$sSql =" SELECT '20' AS tipoRegistro,
		si09_codorgaotce AS codOrgao,
		case when (unveic.o41_codtri::int != 0 and orveic.o40_codtri::int = 0) then lpad(orveic.o40_orgao,2,0)||lpad(unveic.o41_codtri,3,0) 
	    when (unveic.o41_codtri::int = 0 and orveic.o40_codtri::int != 0) then lpad(orveic.o40_codtri,2,0)||lpad(unveic.o41_unidade,3,0)
	    when (unveic.o41_codtri::int != 0 and orveic.o40_codtri::int != 0) then lpad(orveic.o40_codtri,2,0)||lpad(unveic.o41_codtri,3,0)	
            else lpad(orveic.o40_orgao,2,0)||lpad(unveic.o41_unidade,3,0) end as codunidadesub,
		veiculos.ve01_codigo AS codVeiculo,
		1 AS origemGasto,
		' ' as codUnidadeSubEmpenho,	
		' ' AS nroEmpenho,
		' '  AS dtEmpenho,
		'09' AS tipoGasto,
		(SELECT case when sum(veicmanutitem.ve63_quant) is null then 1 else sum(veicmanutitem.ve63_quant) end AS quantidade
                FROM veiculos.veicmanut AS veicmanut
                INNER JOIN veiculos.veicmanutitem AS veicmanutitem ON (veicmanut.ve62_codigo = veicmanutitem.ve63_veicmanut)
                INNER JOIN veiculos.veicmanutitempcmater AS veicmanutitempcmater ON (veicmanutitem.ve63_codigo = veicmanutitempcmater.ve64_veicmanutitem)
                INNER JOIN compras.pcmater AS pcmater ON (veicmanutitempcmater.ve64_pcmater = pcmater.pc01_codmater)
                WHERE veicmanut.ve62_veiculos = veiculos.ve01_codigo
                AND pcmater.pc01_servico = TRUE AND DATE_PART('YEAR' ,veicmanut.ve62_dtmanut) = ".db_getsession("DB_anousu")."
		AND DATE_PART('MONTH',veicmanut.ve62_dtmanut) = " .$this->sDataFinal['5'].$this->sDataFinal['6'].") AS qtdeUtilizada,
    (SELECT sum(veicmanut.ve62_vlrmobra) AS valorServico
                FROM veiculos.veicmanut AS veicmanut
                WHERE veicmanut.ve62_veiculos = veiculos.ve01_codigo AND DATE_PART('YEAR' ,veicmanut.ve62_dtmanut) = ".db_getsession("DB_anousu")."
		AND DATE_PART('MONTH',veicmanut.ve62_dtmanut) = " .$this->sDataFinal['5'].$this->sDataFinal['6'].") AS vlGasto,
		' ' AS dscPecasServicos,
		'1' AS atestadoControle,
		unveic.o41_subunidade as subunidade,
		DATE_PART('YEAR',veiculos.ve01_dtaquis) as anoveiculo
		FROM veiculos.veiculos AS veiculos
		INNER JOIN veiculos.veiccentral AS veiccentral ON (veiculos.ve01_codigo =veiccentral.ve40_veiculos)
		INNER JOIN veiculos.veiccadcentral AS veiccadcentral ON (veiccentral.ve40_veiccadcentral =veiccadcentral.ve36_sequencial)
		INNER JOIN configuracoes.db_depart AS db_depart ON (veiccadcentral.ve36_coddepto =db_depart.coddepto)
		INNER JOIN configuracoes.db_config AS db_config ON (db_depart.instit=db_config.codigo)
		INNER JOIN veiculos .veicmanut AS veicmanut ON (veiculos. ve01_codigo=veicmanut. ve62_veiculos)
		INNER JOIN  orcdotacao  on  db_config.codigo=orcdotacao.o58_instit
		inner join db_departorg on db01_coddepto = db_depart.coddepto and db01_anousu = ".db_getsession("DB_anousu")."
		inner join orcunidade unveic on db01_orgao = unveic.o41_orgao and db01_unidade = unveic.o41_unidade and unveic.o41_anousu = db01_anousu
		inner join orcorgao orveic on o41_anousu = orveic.o40_anousu and o41_orgao = orveic.o40_orgao 
		inner join orcunidade unemp on db01_orgao = unemp.o41_orgao and db01_unidade = unemp.o41_unidade and unemp.o41_anousu = db01_anousu
		inner join orcorgao orcemp on unemp.o41_anousu = orcemp.o40_anousu and unemp.o41_orgao = orcemp.o40_orgao
		left join infocomplementaresinstit on si09_instit = db_config.codigo
		WHERE db_config.codigo = " .db_getsession("DB_instit")."
		AND DATE_PART('YEAR',veicmanut.ve62_dtmanut) = ".db_getsession("DB_anousu")."
		AND DATE_PART('MONTH',veicmanut.ve62_dtmanut) = " .$this->sDataFinal['5'].$this->sDataFinal['6']."
		
		UNION
		
		SELECT '20' AS tipoRegistro,
		si09_codorgaotce AS codOrgao,
		case when (unveic.o41_codtri::int != 0 and orveic.o40_codtri::int = 0) then lpad(orveic.o40_orgao,2,0)||lpad(unveic.o41_codtri,3,0) 
	    when (unveic.o41_codtri::int = 0 and orveic.o40_codtri::int != 0) then lpad(orveic.o40_codtri,2,0)||lpad(unveic.o41_unidade,3,0)
	    when (unveic.o41_codtri::int != 0 and orveic.o40_codtri::int != 0) then lpad(orveic.o40_codtri,2,0)||lpad(unveic.o41_codtri,3,0)	
            else lpad(orveic.o40_orgao,2,0)||lpad(unveic.o41_unidade,3,0) end as codunidadesub,
		veiculos.ve01_codigo AS codVeiculo,
		1 AS origemGasto,
		' ' as codUnidadeSubEmpenho,	
		' ' AS nroEmpenho,
		' '  AS dtEmpenho,
		'08' AS tipoGasto,
		(SELECT sum(veicmanutitem.ve63_quant) AS quantidade
		FROM veiculos.veicmanut AS veicmanut
		INNER JOIN veiculos.veicmanutitem AS veicmanutitem ON (veicmanut.ve62_codigo = veicmanutitem.ve63_veicmanut)
		INNER JOIN veiculos.veicmanutitempcmater AS veicmanutitempcmater ON (veicmanutitem.ve63_codigo = veicmanutitempcmater.ve64_veicmanutitem)
		INNER JOIN compras.pcmater pcmater ON (veicmanutitempcmater.ve64_pcmater = pcmater.pc01_codmater)
		WHERE veicmanut.ve62_veiculos = veiculos.ve01_codigo
		AND pcmater.pc01_servico = FALSE AND DATE_PART('YEAR' ,veicmanut.ve62_dtmanut) = ".db_getsession("DB_anousu")."
		AND DATE_PART('MONTH',veicmanut.ve62_dtmanut) = " .$this->sDataFinal['5'].$this->sDataFinal['6'].") AS qtdeUtilizada,
		(SELECT sum(veicmanut.ve62_vlrpecas) AS valorPecas
		FROM veiculos.veicmanut AS veicmanut
		WHERE veicmanut.ve62_veiculos = veiculos.ve01_codigo AND DATE_PART('YEAR' ,veicmanut.ve62_dtmanut) = ".db_getsession("DB_anousu")."
		AND DATE_PART('MONTH',veicmanut.ve62_dtmanut) = " .$this->sDataFinal['5'].$this->sDataFinal['6'].") AS vlGasto,
		' ' AS dscPecasServicos,
		'1' AS atestadoControle,
		unveic.o41_subunidade as subunidade,
		DATE_PART('YEAR',veiculos.ve01_dtaquis) as anoveiculo
		FROM veiculos.veiculos AS veiculos
		INNER JOIN veiculos.veiccentral AS veiccentral ON (veiculos.ve01_codigo =veiccentral.ve40_veiculos)
		INNER JOIN veiculos.veiccadcentral AS veiccadcentral ON (veiccentral.ve40_veiccadcentral =veiccadcentral.ve36_sequencial)
		INNER JOIN configuracoes.db_depart AS db_depart ON (veiccadcentral.ve36_coddepto =db_depart.coddepto)
		INNER JOIN configuracoes.db_config AS db_config ON (db_depart.instit=db_config.codigo)
		INNER JOIN veiculos .veicmanut AS veicmanut ON (veiculos. ve01_codigo=veicmanut. ve62_veiculos)
		INNER JOIN  orcdotacao  on  db_config.codigo=orcdotacao.o58_instit
		inner join db_departorg on db01_coddepto = db_depart.coddepto and db01_anousu = ".db_getsession("DB_anousu")."
		inner join orcunidade unveic on db01_orgao = unveic.o41_orgao and db01_unidade = unveic.o41_unidade and unveic.o41_anousu = db01_anousu
		inner join orcorgao orveic on o41_anousu = orveic.o40_anousu and o41_orgao = orveic.o40_orgao
		inner join orcunidade unemp on db01_orgao = unemp.o41_orgao and db01_unidade = unemp.o41_unidade and unemp.o41_anousu = db01_anousu
		inner join orcorgao orcemp on unemp.o41_anousu = orcemp.o40_anousu and unemp.o41_orgao = orcemp.o40_orgao
		left join infocomplementaresinstit on si09_instit = db_config.codigo 
		WHERE db_config.codigo =" .db_getsession("DB_instit")."
		AND DATE_PART('YEAR',veicmanut.ve62_dtmanut) = ".db_getsession("DB_anousu")."
		AND DATE_PART('MONTH',veicmanut.ve62_dtmanut) = " .$this->sDataFinal['5'].$this->sDataFinal['6']."
		
		UNION
		
		SELECT '20' AS tipoRegistro,
		si09_codorgaotce AS codOrgao,
		case when (unveic.o41_codtri::int != 0 and orveic.o40_codtri::int = 0) then lpad(orveic.o40_orgao,2,0)||lpad(unveic.o41_codtri,3,0) 
	    when (unveic.o41_codtri::int = 0 and orveic.o40_codtri::int != 0) then lpad(orveic.o40_codtri,2,0)||lpad(unveic.o41_unidade,3,0)
	    when (unveic.o41_codtri::int != 0 and orveic.o40_codtri::int != 0) then lpad(orveic.o40_codtri,2,0)||lpad(unveic.o41_codtri,3,0)	
            else lpad(orveic.o40_orgao,2,0)||lpad(unveic.o41_unidade,3,0) end as codunidadesub,
		veiculos.ve01_codigo AS codVeiculo,
		2 AS origemGasto,  
		case when (unemp.o41_codtri::int != 0 and orcemp.o40_codtri::int = 0) then lpad(o58_orgao,2,0)||lpad(unemp.o41_codtri,3,0) 
	    when (unemp.o41_codtri::int = 0 and orcemp.o40_codtri::int != 0) then lpad(orcemp.o40_codtri,2,0)||lpad(o58_unidade,3,0)
	    when (unemp.o41_codtri::int != 0 and orcemp.o40_codtri::int != 0) then lpad(orcemp.o40_codtri,2,0)||lpad(unemp.o41_codtri,3,0)	
            else lpad(o58_orgao,2,0)||lpad(o58_unidade,3,0) end as codUnidadeSubEmpenho,	
		e60_codemp AS nroEmpenho,
		e60_emiss::varchar  AS dtEmpenho,
		(CASE veicabast.ve70_veiculoscomb
		WHEN 1 THEN '02'
		WHEN 2 THEN '01'
		WHEN 3 THEN '04'
		WHEN 4 THEN '03'
		ELSE '02'
		END) AS tipoGasto,
		sum(ve70_litros) as qtdeUtilizada,
		sum(ve70_valor) as vlGasto,
		' ' AS dscPecasServicos,
		(CASE empveiculos.si05_atestado
		WHEN 't' THEN '2'
		ELSE '1'
		END) AS atestadoControle,
		unveic.o41_subunidade as subunidade,
		DATE_PART('YEAR',veiculos.ve01_dtaquis) as anoveiculo
		FROM veiculos.veiculos AS veiculos
		INNER JOIN veiculos.veiccentral AS veiccentral ON (veiculos.ve01_codigo =veiccentral.ve40_veiculos)
		INNER JOIN veiculos.veiccadcentral AS veiccadcentral ON (veiccentral.ve40_veiccadcentral =veiccadcentral.ve36_sequencial)
		INNER JOIN configuracoes.db_depart AS db_depart ON (veiccadcentral.ve36_coddepto =db_depart.coddepto)
		INNER JOIN configuracoes.db_config AS db_config ON (db_depart.instit=db_config.codigo)
		INNER JOIN veiculos.veicabast AS veicabast ON (veiculos.ve01_codigo=veicabast.ve70_veiculos)
		INNER JOIN empveiculos ON (veicabast.ve70_codigo = empveiculos.si05_codabast)
		INNER JOIN empenho.empempenho AS empempenho ON (empveiculos.si05_numemp = empempenho.e60_numemp)
		INNER JOIN orcamento.orcdotacao AS orcdotacao ON (empempenho.e60_coddot = orcdotacao.o58_coddot
		AND empempenho.e60_anousu = orcdotacao.o58_anousu)
		inner join db_departorg on db01_coddepto = db_depart.coddepto and db01_anousu = ".db_getsession("DB_anousu")."
		inner join orcunidade unveic on db01_orgao = unveic.o41_orgao and db01_unidade = unveic.o41_unidade and unveic.o41_anousu = db01_anousu
		inner join orcorgao orveic on o41_anousu = orveic.o40_anousu and o41_orgao = orveic.o40_orgao
		inner join orcunidade unemp on orcdotacao.o58_orgao = unemp.o41_orgao and orcdotacao.o58_unidade = unemp.o41_unidade and unemp.o41_anousu = orcdotacao.o58_anousu
		inner join orcorgao orcemp on unemp.o41_anousu = orcemp.o40_anousu and unemp.o41_orgao = orcemp.o40_orgao
		left join infocomplementaresinstit on si09_instit = db_config.codigo
		WHERE db_config.codigo =" .db_getsession("DB_instit")."
		AND DATE_PART('YEAR' ,veicabast.ve70_dtabast) = ".db_getsession("DB_anousu")."
		AND DATE_PART('MONTH',veicabast.ve70_dtabast) = " .$this->sDataFinal['5'].$this->sDataFinal['6']."
		GROUP BY veiculos.ve01_codigo, ve70_veiculoscomb, si05_atestado,
		o58_orgao,unemp.o41_codtri,orcemp.o40_codtri,orcemp.o40_orgao,unemp.o41_unidade,
		unveic.o41_codtri,orveic.o40_codtri,orveic.o40_orgao,unveic.o41_unidade,si09_codorgaotce,
		o58_unidade,
		db_config.db21_tipoinstit,
		empempenho.e60_codemp,
		empempenho.e60_emiss,
		db_depart.coddepto,unveic.o41_subunidade "; 
		
		//--order by veiculos.ve01_codigo
		//echo $sSql;exit;
		$rsResult20 = db_query($sSql);//db_criatabela($rsResult20);exit;
		//echo pg_last_error();
		//db_criatabela($rsResult20);exit;
		/**
		 * registro 20
		 */
		$aDadosAgrupados20 = array();
		for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {
		  
			$oResult20 = db_utils::fieldsMemory($rsResult20, $iCont20);
			
			$sHash20 = $oResult20->codveiculo.$oResult20->nroempenho.$oResult20->dtempenho.$oResult20->tipogasto.$oResult20->atestadocontrole;
			if (!isset($aDadosAgrupados20[$sHash20])) {
				
				$oDados20  = new stdClass();
			  if ($oResult20->subunidade == 1) {
	        $oResult20->codunidadesubempenho .= str_pad($oResult20->subunidade,3,"0",STR_PAD_LEFT);
	        if ($oResult20->anoveiculo == 2014) {
	      	  $oResult20->codunidadesub .= str_pad($oResult20->subunidade,3,"0",STR_PAD_LEFT);
	        }
	      }
		    
			  $oDados20->si147_tiporegistro 			  = 20;
			  $oDados20->si147_codorgao				      = $oResult20->codorgao  ;
			  $oDados20->si147_codunidadesub			  = $oResult20->codunidadesub;      
			  $oDados20->si147_codveiculo				    = $oResult20->codveiculo   ;        
			  $oDados20->si147_origemgasto				  = $oResult20->origemgasto ;        
			  $oDados20->si147_codunidadesubempenho	= $oResult20->codunidadesubempenho;
			  $oDados20->si147_nroempenho				    = $oResult20->nroempenho   ;       
			  $oDados20->si147_dtempenho				    = $oResult20->dtempenho  ;         
			  $oDados20->si147_tipogasto				    = $oResult20->tipogasto  ;         
			  $oDados20->si147_qtdeutilizada			  = $oResult20->qtdeutilizada ;      
			  $oDados20->si147_vlgasto					    = $oResult20->vlgasto   ;           
			  $oDados20->si147_dscpecasservicos		  = $oResult20->dscpecasservicos  ;    
			  $oDados20->si147_atestadocontrole		  = $oResult20->atestadocontrole ;   
			  $oDados20->si147_instit					      = db_getsession("DB_instit");
			  $oDados20->si147_mes            			= $this->sDataFinal['5'].$this->sDataFinal['6'];
			
		    /**
		 	   *          MARCAÇÃO INICIAL E FINAL DE MANUTENÇÃO DO VEICULO: 
		 	   */			
			  $sSqlm= "SELECT min(veicmanut.ve62_medida) as km_inicial_manu, max(veicmanut.ve62_medida) as km_final__manu 
			  FROM veiculos.veicmanut  as veicmanut  
			  WHERE veicmanut.ve62_veiculos =  $oResult20->codveiculo
			  AND  DATE_PART('YEAR',veicmanut.ve62_dtmanut)= ".db_getsession("DB_anousu")."
			  AND DATE_PART('MONTH',veicmanut.ve62_dtmanut)=  " .$this->sDataFinal['5'].$this->sDataFinal['6']."";
			
			  $rsResultVeiculo = db_query($sSqlm);//echo $oResult20->codveiculo;
			  //db_criatabela($rsResultVeiculo);
			  $oDadosVeiculo       = db_utils::fieldsMemory($rsResultVeiculo, 0); 
		
			  /**
			   * MARCAÇÃO INICIAL E FINAL DE ABASTECIMENTO DO VEICULO:
			   */

	      $sSqlabs="SELECT min(veicabast.ve70_medida) as km_inicial_comb, max(veicabast.ve70_medida) as km_final_comb 
	      FROM veiculos.veicabast as veicabast 
	      WHERE veicabast.ve70_veiculos =  $oResult20->codveiculo
	      AND  DATE_PART('YEAR',veicabast.ve70_dtabast)= ".db_getsession("DB_anousu")."
	      AND DATE_PART('MONTH',veicabast.ve70_dtabast)= " .$this->sDataFinal['5'].$this->sDataFinal['6']."";
	          
	      $rsResultAbas 	   = db_query($sSqlabs);//db_criatabela($rsResultAbas);
			  $oDadosAbs       = db_utils::fieldsMemory($rsResultAbas,0);
			 /**
			  * seleção da menor marcação inicial e da maior marcação final, esta pesquisa será realizada para cada veículo retornado pelo comando sql de seleção
			  */
			
			  if ($oDadosVeiculo->km_inicial_manu != '') {
			    $marcacaoInicial =  $oDadosVeiculo->km_inicial_manu;
			    if ($oDadosVeiculo->km_inicial_manu >  $oDadosAbs->km_inicial_comb && $oDadosAbs->km_final_comb != ''){
			      $marcacaoInicial =  $oDadosAbs->km_inicial_comb;
			    }
			  } else if ($oDadosAbs->km_final_comb != '') {
			  	$marcacaoInicial =  $oDadosAbs->km_inicial_comb;
			  }
			  
			  
			  if ($oDadosVeiculo->km_inicial_manu != '') {
			    $marcacaoFinal =  $oDadosVeiculo->km_final_manu;
			    if ($oDadosVeiculo->km_final_manu <  $oDadosAbs->km_final_comb && $oDadosAbs->km_final_comb != ''){
			      $marcacaoFinal =  $oDadosAbs->km_final_comb;
			    }
			  } else if ($oDadosAbs->km_final_comb != '') {
			  	$marcacaoFinal =  $oDadosAbs->km_final_comb;
			  }
          	
        $oDados20->si147_marcacaoinicial = $marcacaoInicial;
        $oDados20->si147_marcacaofinal	 = $marcacaoFinal;
      
        $aDadosAgrupados20[$sHash20] = $oDados20;
			
		  } else {
		  	
		  	//$aDadosAgrupados20[$sHash20]->si147_qtdeutilizada	+= $oResult20->qtdeutilizada;      
			  //$aDadosAgrupados20[$sHash20]->si147_vlgasto				+= $oResult20->vlgasto;
		  	
		  }
		  		  	
		}
		  
		foreach ($aDadosAgrupados20 as $oDadosAgrupados20) {
			
			$clcvc202014 = new cl_cvc202014();
			$clcvc202014->si147_tiporegistro 			= 20;
			$clcvc202014->si147_codorgao				= $oDadosAgrupados20->si147_codorgao  ;
			$clcvc202014->si147_codunidadesub			= $oDadosAgrupados20->si147_codunidadesub;      
			$clcvc202014->si147_codveiculo				= $oDadosAgrupados20->si147_codveiculo   ;        
			$clcvc202014->si147_origemgasto				= $oDadosAgrupados20->si147_origemgasto ;        
			$clcvc202014->si147_codunidadesubempenho	= $oDadosAgrupados20->si147_codunidadesubempenho;
			$clcvc202014->si147_nroempenho				= $oDadosAgrupados20->si147_nroempenho   ;       
			$clcvc202014->si147_dtempenho				= $oDadosAgrupados20->si147_dtempenho  ;         
			$clcvc202014->si147_tipogasto				= $oDadosAgrupados20->si147_tipogasto  ;         
			$clcvc202014->si147_qtdeutilizada			= $oDadosAgrupados20->si147_qtdeutilizada ;      
			$clcvc202014->si147_vlgasto					= $oDadosAgrupados20->si147_vlgasto;           
			$clcvc202014->si147_dscpecasservicos		= $oDadosAgrupados20->si147_dscpecasservicos  ;    
			$clcvc202014->si147_atestadocontrole		= $oDadosAgrupados20->si147_atestadocontrole;
			$clcvc202014->si147_marcacaoinicial		= $oDadosAgrupados20->si147_marcacaoinicial;
      $clcvc202014->si147_marcacaofinal		= $oDadosAgrupados20->si147_marcacaofinal;   
			$clcvc202014->si147_instit					= db_getsession("DB_instit");
			$clcvc202014->si147_mes            			= $this->sDataFinal['5'].$this->sDataFinal['6'];
		
			$clcvc202014->incluir(null);
		  if ($clcvc202014->erro_status == 0) {
		    throw new Exception($clcvc202014->erro_msg);
		  }
			
		}
    /*
     * Registro 30  
     */
		$sSql =" SELECT '30' AS tipoRegistro,
       si09_codorgaotce AS codOrgao,
       case when (unveic.o41_codtri::int != 0 and orveic.o40_codtri::int = 0) then lpad(orveic.o40_orgao,2,0)||lpad(unveic.o41_codtri,3,0) 
	    when (unveic.o41_codtri::int = 0 and orveic.o40_codtri::int != 0) then lpad(orveic.o40_codtri,2,0)||lpad(unveic.o41_unidade,3,0)
	    when (unveic.o41_codtri::int != 0 and orveic.o40_codtri::int != 0) then lpad(orveic.o40_codtri,2,0)||lpad(unveic.o41_codtri,3,0)	
            else lpad(orveic.o40_orgao,2,0)||lpad(unveic.o41_unidade,3,0) end as codunidadesub,
       veiculos.ve01_codigo AS codVeiculo,
       transporteescolar.v200_escola AS nomeEstabelecimento,
       transporteescolar.v200_localidade AS localidade,
       transporteescolar.v200_diasrodados AS qtdeDiasRodados,
       transporteescolar.v200_distancia AS distanciaEstabelecimento,
       transporteescolar.v200_numpassageiros AS numeroPassageiros,
       transporteescolar.v200_turno AS turnos,
       o41_subunidade as subunidade
		FROM veiculos.veiculos AS veiculos
		INNER JOIN veiculos.veiccentral AS veiccentral ON (veiculos.ve01_codigo =veiccentral.ve40_veiculos)
		INNER JOIN veiculos.veiccadcentral AS veiccadcentral ON (veiccentral.ve40_veiccadcentral =veiccadcentral.ve36_sequencial)
		INNER JOIN configuracoes.db_depart AS db_depart ON (veiccadcentral.ve36_coddepto =db_depart.coddepto)
		INNER JOIN configuracoes.db_config AS db_config ON (db_depart.instit=db_config.codigo)
		INNER JOIN veiculos.veicabast AS veicabast ON (veiculos.ve01_codigo=veicabast.ve70_veiculos)
		INNER JOIN empveiculos ON (veicabast.ve70_codigo = empveiculos.si05_codabast)
		INNER JOIN empenho.empempenho AS empempenho ON (empveiculos.si05_numemp = empempenho.e60_numemp)
		INNER JOIN orcamento.orcdotacao AS orcdotacao ON (empempenho.e60_coddot = orcdotacao.o58_coddot
		                                                  AND empempenho.e60_anousu = orcdotacao.o58_anousu)
		INNER JOIN veiculos.transporteescolar AS transporteescolar ON (veiculos.ve01_codigo=transporteescolar.v200_veiculo)
		
		inner join db_departorg on db01_coddepto = db_depart.coddepto and db01_anousu = ".db_getsession("DB_anousu")."
		inner join orcunidade unveic on db01_orgao = unveic.o41_orgao and db01_unidade = unveic.o41_unidade and unveic.o41_anousu = db01_anousu
		inner join orcorgao orveic on o41_anousu = orveic.o40_anousu and o41_orgao = orveic.o40_orgao
		left join infocomplementaresinstit on si09_instit = db_config.codigo
		WHERE db_config.codigo =" .db_getsession("DB_instit")."";
//		AND veiculos.ve01_codigo = [ Código do Veículo ] ;
		
		$rsResult30 = db_query($sSql);
		//db_criatabela($rsResult30);exit;
		/**
		 * registro 30
		 */
		
		if(pg_num_rows($rsResult30) > 0 ){
			for ($iCont0 = 30; $iCont30 < pg_num_rows($rsResult30); $iCont30++) {
			  	
			  	$clcvc302014 = new cl_cvc302014();
				$oDados30       = db_utils::fieldsMemory($rsResult30, $iCont30);
				
			  if ($oDados30->subunidade == 1) {
	        $oDados30->codunidadesub .= str_pad($oDados30->subunidade,3,"0",STR_PAD_LEFT);
	      }
							  	
				$clcvc302014->si148_tiporegistro 				= 30;			 
				$clcvc302014->si148_codorgao					= $oDados30->codorgao;
				$clcvc302014->si148_codunidadesub				= $oDados30->codunidadesub;
				$clcvc302014->si148_codveiculo					= $oDados30->codveiculo  ;
				$clcvc302014->si148_nomeestabelecimento			= $oDados30->nomeestabelecimento; 
				$clcvc302014->si148_localidade					= $oDados30->localidade  ;
				$clcvc302014->si148_qtdediasrodados				= $oDados30->qtdediasrodados;
				$clcvc302014->si148_distanciaestabelecimento	= $oDados30->distanciaestabelecimento; 
				$clcvc302014->si148_numeropassageiros			= $oDados30->numeropassageiros; 
				$clcvc302014->si148_turnos						= $oDados30->turnos;
				$clcvc302014->si148_instit						= db_getsession("DB_instit");
				$clcvc302014->si148_mes            				= $this->sDataFinal['5'].$this->sDataFinal['6'];
			  	
			  	$clcvc302014->incluir(null);
			  if ($clcvc302014->erro_status == 0) {
			    throw new Exception($clcvc302014->erro_msg);
			  }
			  	
			}
		} 
			$sSql = "SELECT DISTINCT '40' as tipoRegistro,
			si09_codorgaotce  as codOrgao,
			case when (unveic.o41_codtri::int != 0 and orveic.o40_codtri::int = 0) then lpad(orveic.o40_orgao,2,0)||lpad(unveic.o41_codtri,3,0) 
			    when (unveic.o41_codtri::int = 0 and orveic.o40_codtri::int != 0) then lpad(orveic.o40_codtri,2,0)||lpad(unveic.o41_unidade,3,0)
			    when (unveic.o41_codtri::int != 0 and orveic.o40_codtri::int != 0) then lpad(orveic.o40_codtri,2,0)||lpad(unveic.o41_codtri,3,0)	
		            else lpad(orveic.o40_orgao,2,0)||lpad(unveic.o41_unidade,3,0) end as codunidadesub,
			veiculos.ve01_codigo as codVeiculo,
			veicbaixa.ve04_veiccadtipobaixa as tipoBaixa,
			veicbaixa.ve04_motivo as descBaixa,
			veicbaixa.ve04_data as dtBaixa,
			o41_subunidade as subunidade		
			FROM veiculos.veiculos as veiculos
			INNER JOIN veiculos.veiccentral as veiccentral on (veiculos.ve01_codigo =veiccentral.ve40_veiculos)
			INNER JOIN veiculos.veiccadcentral as veiccadcentral on (veiccentral.ve40_veiccadcentral =veiccadcentral.ve36_sequencial)
			INNER JOIN configuracoes.db_depart as db_depart on (veiccadcentral.ve36_coddepto =db_depart.coddepto)
			INNER JOIN configuracoes.db_config as db_config on (db_depart.instit=db_config.codigo)
			INNER JOIN veiculos.veicabast as veicabast on (veiculos.ve01_codigo=veicabast.ve70_veiculos)
			INNER JOIN empveiculos on (veicabast.ve70_codigo = empveiculos.si05_codabast)
			INNER JOIN empenho.empempenho as empempenho on (empveiculos.si05_numemp = empempenho.e60_numemp)
			INNER JOIN orcamento.orcdotacao as orcdotacao on (empempenho.e60_coddot = orcdotacao.o58_coddot and empempenho.e60_anousu = orcdotacao.o58_anousu )
			INNER JOIN veiculos.veicitensobrig as veicitensobrig on (veiculos.ve01_codigo=veicitensobrig.ve09_veiculos)
			INNER JOIN veiculos.veiccaditensobrig as veiccaditensobrig on (veicitensobrig.ve09_veiccaditensobrig=veiccaditensobrig.ve08_sequencial)
			INNER JOIN veiculos.veicbaixa as veicbaixa on (veicitensobrig.ve09_veiculos=veicbaixa.ve04_veiculo)
			
			inner join db_departorg on db01_coddepto = db_depart.coddepto and db01_anousu = ".db_getsession("DB_anousu")."
			inner join orcunidade unveic on db01_orgao = unveic.o41_orgao and db01_unidade = unveic.o41_unidade and unveic.o41_anousu = db01_anousu
			inner join orcorgao orveic on o41_anousu = orveic.o40_anousu and o41_orgao = orveic.o40_orgao
			left join infocomplementaresinstit on si09_instit = db_config.codigo
			WHERE db_config.codigo = " .db_getsession("DB_instit")."
			AND  DATE_PART('YEAR',veicbaixa.ve04_data) =".db_getsession("DB_anousu")."
			AND  DATE_PART('MONTH',veicbaixa.ve04_data) =" .$this->sDataFinal['5'].$this->sDataFinal['6']."";
		  
		  $rsResult40 = db_query($sSql);//echo $sSql;db_criatabela($rsResult40);
		  
		  
		  //echo pg_last_error();
		  /**
		   * registro 40
		   */
		  if(pg_num_rows($rsResult40) > 0 ){
				  for ($iCont40 = 0; $iCont40 < pg_num_rows($rsResult40); $iCont40++) {
				  	
				    $clcvc402014= new cl_cvc402014();
				  	$oDados40       =  db_utils::fieldsMemory($rsResult40, $iCont40);
				  	
				  	if ($oDados10->subunidade == 1) {
	          $oDados30->codunidadesub .= str_pad($oDados30->subunidade,3,"0",STR_PAD_LEFT);
	        }
									  	
				  $clcvc402014->si149_tiporegistro 	= 40;
				  $clcvc402014->si149_codorgao		  = $oDados40->codorgao;
					$clcvc402014->si149_codunidadesub	= $oDados40->codunidadesub;
					$clcvc402014->si149_codveiculo		= $oDados40->codveiculo;
					$clcvc402014->si149_tipobaixa			= $oDados40->tipobaixa;
					$clcvc402014->si149_descbaixa			= $oDados40->descbaixa;
					$clcvc402014->si149_dtbaixa     	= $oDados40->dtbaixa;
					$clcvc402014->si149_instit				= db_getsession("DB_instit");
					$clcvc402014->si149_mes           = $this->sDataFinal['5'].$this->sDataFinal['6'];
				  	
				  	
				    $clcvc402014->incluir(null);
				    if ($clcvc402014->erro_status == 0) {
				  	  throw new Exception($clcvc402014->erro_msg);
				    }	
				}
		  }
		   
    db_fim_transacao();
    
    $oGerarCVC = new GerarCVC();
    $oGerarCVC->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarCVC->gerarDados();
    
  }
}
  	
