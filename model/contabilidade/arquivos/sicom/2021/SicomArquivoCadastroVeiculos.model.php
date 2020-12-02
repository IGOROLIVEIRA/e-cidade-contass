<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_cvc10$PROXIMO_ANO_classe.php");
require_once ("classes/db_cvc20$PROXIMO_ANO_classe.php");
require_once ("classes/db_cvc30$PROXIMO_ANO_classe.php");
require_once ("classes/db_cvc40$PROXIMO_ANO_classe.php");


require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarCVC.model.php");


 /**
  * Dados Cadastro de Ve�culos Sicom Acompanhamento Mensal
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
    
    $aElementos[10] = array(
                          "tipoRegistro",
                          "codOrgao",
                          "codUnidadeSub",
                          "codVeiculo",
                          "tpVeiculo",
                          "subTipoVeiculo",
                          "descVeiculo",
                          "marca",
                          "modelo",
     				              "ano",
                          "placa",
                          "chassi",
                          "numeroRenavam",
                          "nroSerie",
                          "situacao"
                        );
    $aElementos[20] = array(
                          "tipoRegistro",
                          "codOrgao",
                          "codUnidadeSub",
                          "codVeiculo",
    											"origemGasto",
                          "codUnidadeEmpenho",
                          "nroEmpenho",
                          "dtEmpenho",
                          "tpDeslocamento",
                          "MarcacaoInicial",
                          "MarcacaoFinal",
                          "tipoGasto",
                          "qtdeUtilizada",
                          "vlGasto",
                          "dscPecasServicos",
                          "atestadoControle"
                        );
    $aElementos[30] = array(
                          "tipoRegistro",
                          "codOrgao",
                          "codUnidadeSub",
                          "codVeiculo",
                          "nomeEstabelecimento",
                          "localidade",
                          "distanciaEstabelecimento",
                          "numeroPassageiros",
    											"turnos"
                        );
    $aElementos[40] = array(
                          "tipoRegistro",
                          "codOrgao",
                          "codUnidadeSub",
                          "codVeiculo",
                          "tipoBaixa",
                          "descBaixa"
                        );
    return $aElementos;
  }
  
  /**
   * selecionar os dados do cadastro de ve�culos
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
    
/**
  	 * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo 
  	 */
  	$clcvc10$PROXIMO_ANO = new cl_cvc10$PROXIMO_ANO();
  	$clcvc20$PROXIMO_ANO = new cl_cvc20$PROXIMO_ANO();
  	$clcvc30$PROXIMO_ANO = new cl_cvc30$PROXIMO_ANO();
  	$clcvc40$PROXIMO_ANO = new cl_cvc40$PROXIMO_ANO();
  	
    
    /**
     * excluir informacoes do mes selecioado
     */
    db_inicio_transacao();
    $result = db_query($clcvc10$PROXIMO_ANO->sql_query(NULL,"*",NULL,"si146_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si146_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clcvc10$PROXIMO_ANO->excluir(NULL,"si146_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si146_instit=".db_getsession("DB_instit"));
      if ($clcvc10$PROXIMO_ANO->erro_status == 0) {
    	  throw new Exception($clcvc10$PROXIMO_ANO->erro_msg);
      }
    }
   
    $result = db_query($clcvc20$PROXIMO_ANO->sql_query(NULL,"*",NULL,"si147_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si147_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clcvc20$PROXIMO_ANO->excluir(NULL,"si147_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si147_instit=".db_getsession("DB_instit"));
      if ($clcvc20$PROXIMO_ANO->erro_status == 0) {
    	  throw new Exception($clcvc20$PROXIMO_ANO->erro_msg);
      }
    }
    
    $result = db_query($clcvc30$PROXIMO_ANO->sql_query(NULL,"*",NULL,"si148_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si148_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clcvc30$PROXIMO_ANO->excluir(NULL,"s148_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si148_instit=".db_getsession("DB_instit"));
      if ($clcvc30$PROXIMO_ANO>erro_status == 0) {
    	  throw new Exception($clcvc30$PROXIMO_ANO->erro_msg);
      }
    }
     
    $result = db_query($clcvc40$PROXIMO_ANO->sql_query(NULL,"*",NULL,"si149_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si149_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clcvc40$PROXIMO_ANO->excluir(NULL,"si149_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si149_instit=".db_getsession("DB_instit"));
      if ($clcvc40$PROXIMO_ANO->erro_status == 0) {
    	  throw new Exception($clcvc40$PROXIMO_ANO->erro_msg);
      }
    }
    
    $sSql="SELECT '10' as tipoRegistro,
	db_config.db21_tipoinstit  as codOrgao,
	(select lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) from db_departorg where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu").") as codUnidadeSubResp,
	veiculos.ve01_codigo as codVeiculo,
	tipoveiculos.si04_tipoveiculo as tpVeiculo,
	tipoveiculos.si04_especificacao as subTipoVeiculo,
	tipoveiculos.si04_descricao as descVeiculo,
	veiccadmarca.ve21_descr as marca,
	veiccadmodelo.ve22_descr as modelo,
	veiculos.ve01_anofab as ano,
	veiculos.ve01_placa as placa,
	veiculos.ve01_chassi as chassi,
	veiculos.ve01_ranavam as numeroRenavam,
	' ' as nroSerie,
	tipoveiculos.si04_situacao as situacao,
	'01' as tpDeslocament		
	FROM veiculos.veiculos as veiculos
	INNER JOIN veiculos.veiccentral as veiccentral on (veiculos.ve01_codigo =veiccentral.ve40_veiculos)
	INNER JOIN veiculos.veiccadcentral as veiccadcentral on (veiccentral.ve40_veiccadcentral =veiccadcentral.ve36_sequencial)
	INNER JOIN veiculos.veiccadmarca as veiccadmarca on (veiculos.ve01_veiccadmarca=veiccadmarca.ve21_codigo)
	INNER JOIN veiculos.veiccadmodelo as veiccadmodelo on (veiculos.ve01_veiccadmodelo=veiccadmodelo.ve22_codigo)
	INNER JOIN configuracoes.db_depart as db_depart on (veiccadcentral.ve36_coddepto =db_depart.coddepto)
	INNER JOIN configuracoes.db_departorg as db_departorg on (db_depart.coddepto =db_departorg.db01_coddepto)
	INNER JOIN configuracoes.db_config as db_config on (db_depart.instit=db_config.codigo)
	INNER JOIN sicom.tipoveiculos as tipoveiculos on (veiculos.ve01_codigo=tipoveiculos.si04_veiculos)
	INNER JOIN  liclicita on  db_config.codigo= liclicita.l20_instit
	WHERE db_config.codigo =  " .db_getsession("DB_instit")."
	AND  DATE_PART('YEAR',veiculos.ve01_dtaquis) = ".db_getsession("DB_anousu")."
	AND  DATE_PART('MONTH',veiculos.ve01_dtaquis) = " .$this->sDataFinal['5'].$this->sDataFinal['6']."";
    
    
    
    //INNER JOIN  liclicita on  db_config.codigo= liclicita.l20_instit linha adicionada
    $rsResult10 = db_query($sSql);
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
      
    	$clcvc10$PROXIMO_ANO = new cl_cvc10$PROXIMO_ANO();
    	$oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
	   
	    $clcvc10$PROXIMO_ANO->si146_tiporegistro    	= 10;
		$clcvc10$PROXIMO_ANO->si146_codorgao			= $oDados10->codorgao;
		$clcvc10$PROXIMO_ANO->si146_codunidadesub		= $oDados10->codunidadesub;
		$clcvc10$PROXIMO_ANO->si146_codveiculo			= $oDados10->codveiculo;
		$clcvc10$PROXIMO_ANO->si146_tpveiculo			= $oDados10->tpveiculo;
		$clcvc10$PROXIMO_ANO->si146_subtipoveiculo		= $oDados10->subtipoveiculo;
		$clcvc10$PROXIMO_ANO->si146_descveiculo			= $oDados10->descveiculo;   
		$clcvc10$PROXIMO_ANO->si146_marca				= $oDados10->marca;        
		$clcvc10$PROXIMO_ANO->si146_modelo				= $oDados10->modelo;       
		$clcvc10$PROXIMO_ANO->si146_ano					= $oDados10->ano ;         
		$clcvc10$PROXIMO_ANO->si146_placa				= $oDados10->placa;        
		$clcvc10$PROXIMO_ANO->si146_chassi				= $oDados10->chassi;       
		$clcvc10$PROXIMO_ANO->si146_numerorenavam		= $oDados10->numerorenavam;
		$clcvc10$PROXIMO_ANO->si146_nroserie			= $oDados10->nroserie;       
		$clcvc10$PROXIMO_ANO->si146_situacao			= $oDados10->situacao;     
		$clcvc10$PROXIMO_ANO->si146_tpdeslocamento		= $oDados10->tpdeslocament;
		$clcvc10$PROXIMO_ANO->si146_instit				= db_getsession("DB_instit");
		$clcvc10$PROXIMO_ANO->si146_mes             	= $this->sDataFinal['5'].$this->sDataFinal['6']; 
		
		  
		  
		  $clcvc10$PROXIMO_ANO->incluir(null);
		  if ($clcvc10$PROXIMO_ANO->erro_status == 0) {
		  	throw new Exception($clcvc10$PROXIMO_ANO->erro_msg);
		  }
		  
    }
    
    /*
     * Registro 20  
     */
		$sSql =" SELECT '20' AS tipoRegistro,
		db_config.db21_tipoinstit AS codOrgao,
		(SELECT lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0)
		FROM db_departorg
		WHERE db01_coddepto=l20_codepartamento
		AND db01_anousu=$PROXIMO_ANO) AS codUnidadeSubResp,
		veiculos.ve01_codigo AS codVeiculo,
		1 AS origemGasto,
		lpad(o58_orgao,2,0) || lpad(o58_unidade,3,0)  as codUnidadeSubEmpenho,	
		e60_codemp AS nroEmpenho,
		e60_emiss  AS dtEmpenho,
		'08' AS tipoGasto,
		(SELECT sum(veicmanutitem.ve63_quant) AS quantidade
		FROM veiculos.veicmanut AS veicmanut
		INNER JOIN veiculos.veicmanutitem AS veicmanutitem ON (veicmanut.ve62_codigo = veicmanutitem.ve63_veicmanut)
		INNER JOIN veiculos.veicmanutitempcmater AS veicmanutitempcmater ON (veicmanutitem.ve63_codigo = veicmanutitempcmater.ve64_veicmanutitem)
		INNER JOIN compras.pcmater AS pcmater ON (veicmanutitempcmater.ve64_pcmater = pcmater.pc01_codmater)
		WHERE veicmanut.ve62_veiculos = veiculos.ve01_codigo
		AND pcmater.pc01_servico = TRUE) AS qtdeUtilizada,
		(SELECT sum(veicmanut.ve62_vlrmobra) AS valorPecas
		FROM veiculos.veicmanut AS veicmanut
		WHERE veicmanut.ve62_veiculos = veiculos.ve01_codigo) AS vlGasto,
		' ' AS dscPecasServicos,
		'1' AS atestadoControle
		FROM veiculos.veiculos AS veiculos
		INNER JOIN veiculos.veiccentral AS veiccentral ON (veiculos.ve01_codigo =veiccentral.ve40_veiculos)
		INNER JOIN veiculos.veiccadcentral AS veiccadcentral ON (veiccentral.ve40_veiccadcentral =veiccadcentral.ve36_sequencial)
		INNER JOIN configuracoes.db_depart AS db_depart ON (veiccadcentral.ve36_coddepto =db_depart.coddepto)
		INNER JOIN configuracoes.db_config AS db_config ON (db_depart.instit=db_config.codigo)
		INNER JOIN veiculos .veicmanut AS veicmanut ON (veiculos. ve01_codigo=veicmanut. ve62_veiculos)
		INNER JOIN  liclicita on  db_config.codigo= liclicita.l20_instit
		INNER JOIN  empempenho  on  db_config.codigo=empempenho.e60_instit 
		INNER JOIN  orcdotacao  on  db_config.codigo=orcdotacao.o58_instit
		WHERE db_config.codigo = " .db_getsession("DB_instit")."
		AND DATE_PART('YEAR',veicmanut.ve62_dtmanut) = ".db_getsession("DB_anousu")."
		AND DATE_PART('MONTH',veicmanut.ve62_dtmanut) = " .$this->sDataFinal['5'].$this->sDataFinal['6']."
		
		UNION
		
		SELECT '20' AS tipoRegistro,
		db_config.db21_tipoinstit AS codOrgao,
		(select lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) from db_departorg where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu").") as codUnidadeSubResp,
		veiculos.ve01_codigo AS codVeiculo,
		1 AS origemGasto,
		lpad(o58_orgao,2,0) || lpad(o58_unidade,3,0)  as codUnidadeSubEmpenho,	
		e60_codemp AS nroEmpenho,
		e60_emiss  AS dtEmpenho,
		'08' AS tipoGasto,
		(SELECT sum(veicmanutitem.ve63_quant) AS quantidade
		FROM veiculos.veicmanut AS veicmanut
		INNER JOIN veiculos.veicmanutitem AS veicmanutitem ON (veicmanut.ve62_codigo = veicmanutitem.ve63_veicmanut)
		INNER JOIN veiculos.veicmanutitempcmater AS veicmanutitempcmater ON (veicmanutitem.ve63_codigo = veicmanutitempcmater.ve64_veicmanutitem)
		INNER JOIN compras.pcmater pcmater ON (veicmanutitempcmater.ve64_pcmater = pcmater.pc01_codmater)
		WHERE veicmanut.ve62_veiculos = veiculos.ve01_codigo
		AND pcmater.pc01_servico = TRUE) AS qtdeUtilizada,
		(SELECT sum(veicmanut.ve62_vlrpecas) AS valorPecas
		FROM veiculos.veicmanut AS veicmanut
		WHERE veicmanut.ve62_veiculos = veiculos.ve01_codigo) AS vlGasto,
		' ' AS dscPecasServicos,
		'1' AS atestadoControle
		FROM veiculos.veiculos AS veiculos
		INNER JOIN veiculos.veiccentral AS veiccentral ON (veiculos.ve01_codigo =veiccentral.ve40_veiculos)
		INNER JOIN veiculos.veiccadcentral AS veiccadcentral ON (veiccentral.ve40_veiccadcentral =veiccadcentral.ve36_sequencial)
		INNER JOIN configuracoes.db_depart AS db_depart ON (veiccadcentral.ve36_coddepto =db_depart.coddepto)
		INNER JOIN configuracoes.db_config AS db_config ON (db_depart.instit=db_config.codigo)
		INNER JOIN veiculos .veicmanut AS veicmanut ON (veiculos. ve01_codigo=veicmanut. ve62_veiculos)
		INNER JOIN  liclicita on  db_config.codigo= liclicita.l20_instit
		INNER JOIN  empempenho  on  db_config.codigo=empempenho.e60_instit 
		INNER JOIN  orcdotacao  on  db_config.codigo=orcdotacao.o58_instit 
		WHERE db_config.codigo =" .db_getsession("DB_instit")."
		AND DATE_PART('YEAR',veicmanut.ve62_dtmanut) = ".db_getsession("DB_anousu")."
		AND DATE_PART('MONTH',veicmanut.ve62_dtmanut) = " .$this->sDataFinal['5'].$this->sDataFinal['6']."
		
		UNION
		
		SELECT '20' AS tipoRegistro,
		db_config.db21_tipoinstit AS codOrgao,
		(SELECT lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0)
		FROM db_departorg
		WHERE db01_coddepto=l20_codepartamento
		AND db01_anousu=".db_getsession("DB_anousu").") AS codUnidadeSubResp,
		veiculos.ve01_codigo AS codVeiculo,
		2 AS origemGasto,
		lpad(o58_orgao,2,0) || lpad(o58_unidade,3,0)  as codUnidadeSubEmpenho,	
		e60_codemp AS nroEmpenho,
		e60_emiss  AS dtEmpenho,
		(CASE veicabast.ve70_veiculoscomb
		WHEN 1 THEN '02'
		WHEN 2 THEN '01'
		WHEN 3 THEN '04'
		ELSE '03'
		END) AS tipoGasto,
		sum(veicabast.ve70_litros) AS qtdeUtilizada,
		sum(veicabast.ve70_valor) AS vlGasto,
		' ' AS dscPecasServicos,
		(CASE empveiculos.si05_atestado
		WHEN 't' THEN '2'
		ELSE '1'
		END) AS atestadoControle
		FROM veiculos.veiculos AS veiculos
		INNER JOIN veiculos.veiccentral AS veiccentral ON (veiculos.ve01_codigo =veiccentral.ve40_veiculos)
		INNER JOIN veiculos.veiccadcentral AS veiccadcentral ON (veiccentral.ve40_veiccadcentral =veiccadcentral.ve36_sequencial)
		INNER JOIN configuracoes.db_depart AS db_depart ON (veiccadcentral.ve36_coddepto =db_depart.coddepto)
		INNER JOIN configuracoes.db_config AS db_config ON (db_depart.instit=db_config.codigo)
		INNER JOIN veiculos.veicabast AS veicabast ON (veiculos.ve01_codigo=veicabast.ve70_veiculos)
		INNER JOIN sicom.empveiculos AS empveiculos ON (veicabast.ve70_codigo = empveiculos.si05_codabast)
		INNER JOIN empenho.empempenho AS empempenho ON (empveiculos.si05_numemp = empempenho.e60_numemp)
		INNER JOIN orcamento.orcdotacao AS orcdotacao ON (empempenho.e60_coddot = orcdotacao.o58_coddot
		AND empempenho.e60_anousu = orcdotacao.o58_anousu)
		INNER JOIN  liclicita on  db_config.codigo= liclicita.l20_instit
		WHERE db_config.codigo =" .db_getsession("DB_instit")."
		AND DATE_PART('YEAR' ,veicabast.ve70_dtabast) = ".db_getsession("DB_anousu")."
		AND DATE_PART('MONTH',veicabast.ve70_dtabast) = " .$this->sDataFinal['5'].$this->sDataFinal['6']."
		GROUP BY veiculos.ve01_codigo, ve70_veiculoscomb, e60_codemp, si05_atestado, e60_emiss,
		o58_orgao,
		o58_unidade,
		db_config.db21_tipoinstit,
		empempenho.e60_codemp,
		empempenho.e60_emiss,
		l20_codepartamento "; 
		
		//--order by veiculos.ve01_codigo
		
		
		$rsResult20 = db_query($sSql);
		/**
		 * registro 20
		 */
		for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {
		  	
		  	$clcvc20$PROXIMO_ANO = new cl_cvc20$PROXIMO_ANO();
			$oDados20       = db_utils::fieldsMemory($rsResult20, $iCont20);
		  	
			$clcvc20$PROXIMO_ANO->si147_tiporegistro 			= 20;
			$clcvc20$PROXIMO_ANO->si147_codorgao				= $oDados20->codorgao  ;
			$clcvc20$PROXIMO_ANO->si147_codunidadesub			= $oDados20->codunidadesub ;      
			$clcvc20$PROXIMO_ANO->si147_codveiculo				= $oDados20->codveiculo   ;        
			$clcvc20$PROXIMO_ANO->si147_origemgasto				= $oDados20->origemgasto ;        
			$clcvc20$PROXIMO_ANO->si147_codunidadesubempenho	= $oDados20->codunidadesubempenho;
			$clcvc20$PROXIMO_ANO->si147_nroempenho				= $oDados20->nroempenho   ;       
			$clcvc20$PROXIMO_ANO->si147_dtempenho				= $oDados20->dtempenho  ;         
			$clcvc20$PROXIMO_ANO->si147_tipogasto				= $oDados20->tipogasto  ;         
			$clcvc20$PROXIMO_ANO->si147_qtdeutilizada			= $oDados20->qtdeutilizada ;      
			$clcvc20$PROXIMO_ANO->si147_vlgasto					= $oDados20->vlgasto   ;           
			$clcvc20$PROXIMO_ANO->si147_dscpecasservicos		= $oDados20->dscpecasservicos  ;    
			$clcvc20$PROXIMO_ANO->si147_atestadocontrole		= $oDados20->atestadocontrole ;   
			$clcvc20$PROXIMO_ANO->si147_instit					= db_getsession("DB_instit");
			$clcvc20$PROXIMO_ANO->si147_mes            			= $this->sDataFinal['5'].$this->sDataFinal['6'];
			
		   /**
		 	*          MARCA��O INICIAL E FINAL DE MANUTEN��O DO VEICULO: 
		 	*/			
			$sSqlm= "SELECT min(veicmanut.ve62_medida) as km_inicial_manu, max(veicmanut.ve62_medida) as km_final__manu 
			FROM veiculos.veicmanut  as veicmanut  
			WHERE veicmanut.ve62_veiculos =  $oDados20->codveiculo
			AND  DATE_PART('YEAR',veicmanut.ve62_dtmanut)= ".db_getsession("DB_anousu")."
			AND DATE_PART('MONTH',veicmanut.ve62_dtmanut)=  " .$this->sDataFinal['5'].$this->sDataFinal['6']."";
			
			$rsResultVeiculo = db_query($sSqlm);
			$oDadosVeiculo       = db_utils::fieldsMemory($rsResultVeiculo, 0); 
		
			/**
			 * MARCA��O INICIAL E FINAL DE ABASTECIMENTO DO VEICULO:
			 */

	         $sSqlabs="SELECT min(veicabast.ve70_medida) as km_inicial_comb, max(veicabast.ve70_medida) as km_final_comb 
	         FROM veiculos.veicabast as veicabast 
	         WHERE veicabast.ve70_veiculos =  $oDados20->codveiculo
	         AND  DATE_PART('YEAR',veicabast.ve70_dtabast)= ".db_getsession("DB_anousu")."
	         AND DATE_PART('MONTH',veicabast.ve70_dtabast)= " .$this->sDataFinal['5'].$this->sDataFinal['6']."";
	          
	         $rsResultAbas 	   = db_query($sSqlabs);
			 $oDadosAbs       = db_utils::fieldsMemory($rsResultAbas,0);
			/**
			 * sele��o da menor marca��o inicial e da maior marca��o final, esta pesquisa ser� realizada para cada ve�culo retornado pelo comando sql de sele��o
			 */
			
			$marcacaoInicial =  $oDadosVeiculo->km_inicial_manu;
			if ($oDadosVeiculo->km_inicial_manu >  $oDadosAbs->km_inicial_comb){
			$marcacaoInicial =  $oDadosAbs->km_inicial_comb;
			}
			$marcacaoFinal =  $oDadosVeiculo->km_final_manu;
			if ($oDadosVeiculo->km_inicial_manu <  $oDadosAbs->km_final_comb){
			$marcacaoFinal =  $oDadosAbs->km_inicial_comb;
			}
          	
          	$clcvc20$PROXIMO_ANO->si147_marcacaoinicial		= $marcacaoInicial;
          	$clcvc20$PROXIMO_ANO->si147_marcacaofinal		= $marcacaoFinal;
			
			echo $sSqlabs;exit;
		  	
		  $clcvc20$PROXIMO_ANO->incluir(null);
		  if ($clcvc20$PROXIMO_ANO->erro_status == 0) {
		    throw new Exception($clcvc20$PROXIMO_ANO->erro_msg);
		  }
		  	
		}
		  
    /*
     * Registro 30  
     */
		$sSql =" SELECT '30' AS tipoRegistro,
       db_config.db21_tipoinstit AS codOrgao,
       (SELECT lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0)
		FROM db_departorg
		WHERE db01_coddepto=l20_codepartamento
		AND db01_anousu=".db_getsession("DB_anousu").") AS codUnidadeSubResp,
       veiculos.ve01_codigo AS codVeiculo,
       transporteescolar.v200_escola AS nomeEstabelecimento,
       transporteescolar.v200_localidade AS localidade,
       transporteescolar.v200_diasrodados AS qtdeDiasRodados,
       transporteescolar.v200_distancia AS distanciaEstabelecimento,
       transporteescolar.v200_numpassageiros AS numeroPassageiros,
       transporteescolar.v200_turno AS turnos
		FROM veiculos.veiculos AS veiculos
		INNER JOIN veiculos.veiccentral AS veiccentral ON (veiculos.ve01_codigo =veiccentral.ve40_veiculos)
		INNER JOIN veiculos.veiccadcentral AS veiccadcentral ON (veiccentral.ve40_veiccadcentral =veiccadcentral.ve36_sequencial)
		INNER JOIN configuracoes.db_depart AS db_depart ON (veiccadcentral.ve36_coddepto =db_depart.coddepto)
		INNER JOIN configuracoes.db_config AS db_config ON (db_depart.instit=db_config.codigo)
		INNER JOIN veiculos.veicabast AS veicabast ON (veiculos.ve01_codigo=veicabast.ve70_veiculos)
		INNER JOIN sicom.empveiculos AS empveiculos ON (veicabast.ve70_codigo = empveiculos.si05_codabast)
		INNER JOIN empenho.empempenho AS empempenho ON (empveiculos.si05_numemp = empempenho.e60_numemp)
		INNER JOIN orcamento.orcdotacao AS orcdotacao ON (empempenho.e60_coddot = orcdotacao.o58_coddot
		                                                  AND empempenho.e60_anousu = orcdotacao.o58_anousu)
		INNER JOIN veiculos.transporteescolar AS transporteescolar ON (veiculos.ve01_codigo=transporteescolar.v200_veiculo)
		INNER JOIN  liclicita on  db_config.codigo= liclicita.l20_instit
		WHERE db_config.codigo =" .db_getsession("DB_instit")."";
//		AND veiculos.ve01_codigo = [ C�digo do Ve�culo ] ;
		
		$rsResult30 = db_query($sSql);
		/**
		 * registro 30
		 */
		for ($iCont0 = 30; $iCont30 < pg_num_rows($rsResult30); $iCont30++) {
		  	
		  	$clcvc30$PROXIMO_ANO = new cl_cvc30$PROXIMO_ANO();
			$oDados30       = db_utils::fieldsMemory($rsResult30, $iCont30);
		  	
			$clcvc30$PROXIMO_ANO->si148_tiporegistro 				= 30;			 
			$clcvc30$PROXIMO_ANO->si148_codorgao					= $oDados30->codorgao;
			$clcvc30$PROXIMO_ANO->si148_codunidadesub				= $oDados30->codunidadesubresp;
			$clcvc30$PROXIMO_ANO->si148_codveiculo					= $oDados30->codveiculo  ;
			$clcvc30$PROXIMO_ANO->si148_nomeestabelecimento			= $oDados30->nomeestabelecimento; 
			$clcvc30$PROXIMO_ANO->si148_localidade					= $oDados30->localidade  ;
			$clcvc30$PROXIMO_ANO->si148_qtdediasrodados				= $oDados30->qtdediasrodados;
			$clcvc30$PROXIMO_ANO->si148_distanciaestabelecimento	= $oDados30->distanciaestabelecimento; 
			$clcvc30$PROXIMO_ANO->si148_numeropassageiros			= $oDados30->numeropassageiros; 
			$clcvc30$PROXIMO_ANO->si148_turnos						= $oDados30->turnos;
			$clcvc30$PROXIMO_ANO->si148_instit						= db_getsession("DB_instit");
			$clcvc30$PROXIMO_ANO->si148_mes            				= $this->sDataFinal['5'].$this->sDataFinal['6'];
		  	
		  	$clcvc30$PROXIMO_ANO->incluir(null);
		  if ($clcvc30$PROXIMO_ANO->erro_status == 0) {
		    throw new Exception($clcvc30$PROXIMO_ANO->erro_msg);
		  }
		  	
		}
		  
			$sSql = "SELECT '40' as tipoRegistro,
			db_config.db21_tipoinstit  as codOrgao,
			(SELECT lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0)
			FROM db_departorg
			WHERE db01_coddepto=l20_codepartamento
			AND db01_anousu=".db_getsession("DB_anousu").") AS codUnidadeSubResp,
			veiculos.ve01_codigo as codVeiculo,
			veicbaixa.ve04_veiccadtipobaixa as tipoBaixa,
			veicbaixa.ve04_motivo as descBaixa,
			veicbaixa.ve04_data as dtBaixa		
			FROM veiculos.veiculos as veiculos
			INNER JOIN veiculos.veiccentral as veiccentral on (veiculos.ve01_codigo =veiccentral.ve40_veiculos)
			INNER JOIN veiculos.veiccadcentral as veiccadcentral on (veiccentral.ve40_veiccadcentral =veiccadcentral.ve36_sequencial)
			INNER JOIN configuracoes.db_depart as db_depart on (veiccadcentral.ve36_coddepto =db_depart.coddepto)
			INNER JOIN configuracoes.db_config as db_config on (db_depart.instit=db_config.codigo)
			INNER JOIN veiculos.veicabast as veicabast on (veiculos.ve01_codigo=veicabast.ve70_veiculos)
			INNER JOIN sicom.empveiculos as empveiculos on (veicabast.ve70_codigo = empveiculos.si05_codabast)
			INNER JOIN empenho.empempenho as empempenho on (empveiculos.si05_numemp = empempenho.e60_numemp)
			INNER JOIN orcamento.orcdotacao as orcdotacao on (empempenho.e60_coddot = orcdotacao.o58_coddot and empempenho.e60_anousu = orcdotacao.o58_anousu )
			INNER JOIN veiculos.veicitensobrig as veicitensobrig on (veiculos.ve01_codigo=veicitensobrig.ve09_veiculos)
			INNER JOIN veiculos.veiccaditensobrig as veiccaditensobrig on (veicitensobrig.ve09_veiccaditensobrig=veiccaditensobrig.ve08_sequencial)
			INNER JOIN veiculos.veicbaixa as veicbaixa on (veicitensobrig.ve09_veiculos=veicbaixa.ve04_veiculo)
			INNER JOIN  liclicita on  db_config.codigo= liclicita.l20_instit
			WHERE db_config.codigo = " .db_getsession("DB_instit")."
			AND  DATE_PART('YEAR',veicbaixa.ve04_data) =".db_getsession("DB_anousu")."
			AND  DATE_PART('MONTH',veicbaixa.ve04_data) =" .$this->sDataFinal['5'].$this->sDataFinal['6']."";
		  
		  $rsResult40 = db_query($sSql);
		  /**
		   * registro 40
		   */
		  for ($iCont40 = 0; $iCont40 < pg_num_rows($rsResult40); $iCont40++) {
		  	
		    $clcvc40$PROXIMO_ANO= new cl_cvc40$PROXIMO_ANO();
		  	$oDados40       =  db_utils::fieldsMemory($rsResult40, $iCont40);
		  	
		  	$clcvc40$PROXIMO_ANO->si149_tiporegistro 				= 40;
		  	$clcvc40$PROXIMO_ANO->si149_codorgao					= $oDados40->codorgao;
			$clcvc40$PROXIMO_ANO->si149_codunidadesub				= $oDados40->codunidadesubresp;
			$clcvc40$PROXIMO_ANO->si149_codveiculo					= $oDados40->codveiculo;
			$clcvc40$PROXIMO_ANO->si149_nomeestabelecimento			= $oDados40->nomeestabelecimento;
			$clcvc40$PROXIMO_ANO->si149_localidade					= $oDados40->localidade;
			$clcvc40$PROXIMO_ANO->si149_qtdediasrodados				= $oDados40->qtdediasrodados;
			$clcvc40$PROXIMO_ANO->si149_distanciaestabelecimento	= $oDados40->distanciaestabelecimento;
			$clcvc40$PROXIMO_ANO->si149_numeropassageiros			= $oDados40->numeropassageiros;
			$clcvc40$PROXIMO_ANO->si149_turnos						= $oDados40->turnos;
			$clcvc40$PROXIMO_ANO->si149_instit						= db_getsession("DB_instit");
			$clcvc40$PROXIMO_ANO->si149_mes           				= $this->sDataFinal['5'].$this->sDataFinal['6'];
		  	
		  	
		    $clcvc40$PROXIMO_ANO->incluir(null);
		    if ($clcvc40$PROXIMO_ANO->erro_status == 0) {
		  	  throw new Exception($clcvc40$PROXIMO_ANO->erro_msg);
		    }	
		}  
    db_fim_transacao();
    
    $oGerarCVC = new GerarCVC();
    $oGerarCVC->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarCVC->gerarDados();
    
  }
}
  	
