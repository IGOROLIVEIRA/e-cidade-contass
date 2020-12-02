<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_resplic10$PROXIMO_ANO_classe.php");
require_once ("classes/db_resplic20$PROXIMO_ANO_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarRESPLIC.model.php");

 /**
  * Responsáveis pela Licitação Sicom Acompanhamento Mensal
  * @author Msc Johnatan
  * @package Contabilidade
  */
class SicomArquivoResponsaveisLicitacao extends SicomArquivoBase implements iPadArquivoBaseCSV {

	/**
	 *
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 155;

  /**
   *
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'RESPLIC';

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
                          "exercicioLicitacao",
                          "nroProcessoLicitatorio",
                          "tipoResp",
					    					  "nroCPFResp",
					    					  "nomeResp",
					    					  "logradouro",
					    					  "bairroLogra",
					    					  "codCidadeLogra",
					    					  "ufCidadeLogra",
					    					  "cepLogra",
					    					  "telefone",
					    					  "email"
                        );
    $aElementos[20] = array(
    					            "tipoRegistro",
                          "codOrgao",
                          "codUnidadeSub",
                          "exercicioLicitacao",
                          "nroProcessoLicitatorio",
					    					  "codTipoComissao",
					    					  "descricaoAtoNomeacao",
					    					  "nroAtoNomeacao",
					    					  "dataAtoNomeacao",
					    					  "inicioVigencia",
					    					  "finalVigencia",
					    					  "cpfMembroComissao",
					    					  "nomMembroComLic",
					    					  "codAtribuicao",
					    					  "cargo",
					    					  "naturezaCargo",
					    					  "logradouro",
					    					  "bairroLogra",
					    					  "codCidadeLogra",
					    					  "ufCidadeLogra",
					    					  "cepLogra",
					    					  "telefone",
					    					  "email"
    					);

    return $aElementos;
  }

  /**
   * selecionar os dados de Responsáveis pela Licitação do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
 public function gerarDados(){

  	/**
  	 * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
  	 */
  	$clresplic10$PROXIMO_ANO = new cl_resplic10$PROXIMO_ANO();
  	$clresplic20$PROXIMO_ANO = new cl_resplic20$PROXIMO_ANO();


    /**
     * excluir informacoes do mes selecioado
     */
    db_inicio_transacao();

    $result = db_query($clresplic10$PROXIMO_ANO->sql_query(NULL,"*",NULL,"si55_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si55_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clresplic10$PROXIMO_ANO->excluir(NULL,"si55_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si55_instit=".db_getsession("DB_instit"));
      if ($clresplic10$PROXIMO_ANO->erro_status == 0) {
    	  throw new Exception($clresplic10$PROXIMO_ANO->erro_msg);
      }
    }

    $result = db_query($clresplic20$PROXIMO_ANO->sql_query(NULL,"*",NULL,"si56_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si56_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clresplic20$PROXIMO_ANO->excluir(NULL,"si56_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si56_instit=".db_getsession("DB_instit"));
      if ($clresplic20$PROXIMO_ANO->erro_status == 0) {
    	  throw new Exception($clresplic20$PROXIMO_ANO->erro_msg);
      }
    }
  /**
   *########################### registro 10 #####################
   */


    $sSql=" select '10' as tipoRegistro, db_config.db21_tipoinstit as codOrgaoResp,
			(select lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) from db_departorg where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu").") as codUnidadeSubResp,
			liclicita.l20_anousu as exercicioLicitacao, liclicita.l20_numero as nroProcessoLicitatorio,
			liccomissaocgm.l31_tipo as tipoResp, l20_codigo as codigolicitacao, cgm.z01_cgccpf as nroCPFResp,
			liclicita.l20_codigo as codlicitacao
			FROM liclicita as liclicita
			INNER JOIN homologacaoadjudica as homologacaoadjudica on (liclicita.l20_codigo=homologacaoadjudica.l202_licitacao)
			INNER JOIN liccomissao as liccomissao on (liclicita.l20_liccomissao=liccomissao.l30_codigo)
			INNER JOIN liccomissaocgm as liccomissaocgm on (liccomissao.l30_codigo=liccomissaocgm.l31_liccomissao)
			INNER JOIN protocolo.cgm as cgm on (liccomissaocgm.l31_numcgm=cgm.z01_numcgm)
			INNER JOIN configuracoes.db_config as db_config on (liclicita.l20_instit=db_config.codigo)
			WHERE db_config.codigo= " .db_getsession("DB_instit")." AND DATE_PART('YEAR',homologacaoadjudica.l202_datahomologacao)= ".db_getsession("DB_anousu")."
			AND DATE_PART('MONTH',homologacaoadjudica.l202_datahomologacao)= ".$this->sDataFinal['5'].$this->sDataFinal['6']." ";

    $rsResult10 = db_query($sSql);

    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

    	$clresplic10$PROXIMO_ANO = new cl_resplic10$PROXIMO_ANO();
    	$oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);


		 $clresplic10$PROXIMO_ANO->si55_tiporegistro   				= 10;
		 $clresplic10$PROXIMO_ANO->si55_codorgao					= $oDados10->codorgaoresp           ;
		 $clresplic10$PROXIMO_ANO->si55_codunidadesub				= $oDados10->codunidadesubresp      ;
		 $clresplic10$PROXIMO_ANO->si55_exerciciolicitacao			= $oDados10->exerciciolicitacao    ;
		 $clresplic10$PROXIMO_ANO->si55_nroprocessolicitatorio		= $oDados10->nroprocessolicitatorio;
		 $clresplic10$PROXIMO_ANO->si55_tiporesp					= $oDados10->tiporesp        ;
		 $clresplic10$PROXIMO_ANO->si55_nrocpfresp					= $oDados10->nrocpfresp   ;
		 $clresplic10$PROXIMO_ANO->si55_instit		    			= db_getsession("DB_instit");
		 $clresplic10$PROXIMO_ANO->si55_mes             			= $this->sDataFinal['5'].$this->sDataFinal['6'];

		 $clresplic10$PROXIMO_ANO->incluir(null);
		  if ($clresplic10$PROXIMO_ANO->erro_status == 0) {
		  	throw new Exception($clresplic10$PROXIMO_ANO->erro_msg);
		  }

    }
  /**
   *########################### registro 20 #####################
   */
		  $sSql = "select '20' as tipoRegistro,
				db_config.db21_tipoinstit as codOrgaoResp,
				(select lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) from db_departorg where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu").") as codUnidadeSubResp,
				liclicita.l20_anousu as exercicioLicitacao,
				liclicita.l20_numero as nroProcessoLicitatorio,
				licpregao.l45_tipo as codTipoComissao,
				licpregao.l45_descrnomeacao as descricaoAtoNomeacao,
				licpregao.l45_numatonomeacao as nroAtoNomeacao,
				licpregao.l45_data as dataAtoNomeacao,
				licpregao.l45_data as inicioVigencia,
				licpregao.l45_validade as finalVigencia,
				cgm.z01_cgccpf as cpfMembroComissao,
				licpregaocgm.l46_tipo as codAtribuicao,
				l46_cargo as cargo,
				l46_naturezacargo as naturezaCargo
				FROM liclicita as liclicita
				INNER JOIN licpregao as licpregao on (liclicita.l20_equipepregao=licpregao.l45_sequencial)
				INNER JOIN licpregaocgm as licpregaocgm on (licpregao.l45_sequencial=licpregaocgm.l46_sequencial)
				INNER JOIN protocolo.cgm as cgm  on (licpregaocgm.l46_numcgm=cgm.z01_numcgm)
				INNER JOIN configuracoes.db_config as db_config on (liclicita.l20_instit=db_config.codigo)
				WHERE db_config.codigo=".db_getsession("DB_anousu")."
				AND liclicita.l20_codigo= {$oDados10->codlicitacao}";

		  $rsResult20 = db_query($sSql);

		  for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {

    	    $clresplic20$PROXIMO_ANO = new cl_resplic20$PROXIMO_ANO();
    	    $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);

		  	$clresplic20$PROXIMO_ANO->si56_tiporegistro           = 20;
		  	$clresplic20$PROXIMO_ANO->si56_codorgao               = $oDados20->codorgaoresp;
		  	$clresplic20$PROXIMO_ANO->si56_codunidadesub          = $oDados20->codunidadesubresp;
		  	$clresplic20$PROXIMO_ANO->si56_exerciciolicitacao     = $oDados20->exerciciolicitacao;
		  	$clresplic20$PROXIMO_ANO->si56_nroprocessolicitatorio = $oDados20->nroprocessolicitatorio;
		  	$clresplic20$PROXIMO_ANO->si56_codtipocomissao        = $oDados20->codtipocomissao;
		  	$clresplic20$PROXIMO_ANO->si56_descricaoatonomeacao   = $oDados20->descricaoatonomeacao;
		  	$clresplic20$PROXIMO_ANO->si56_nroatonomeacao         = $oDados20->nroatonomeacao;
		  	$clresplic20$PROXIMO_ANO->si56_dataatonomeacao        = $oDados20->dataatonomeacao;
		  	$clresplic20$PROXIMO_ANO->si56_iniciovigencia         = $oDados20->iniciovigencia;
		  	$clresplic20$PROXIMO_ANO->si56_finalvigencia          = $oDados20->finalvigencia;
		  	$clresplic20$PROXIMO_ANO->si56_cpfmembrocomissao      = $oDados20->cpfmembrocomissao;
		  	$clresplic20$PROXIMO_ANO->si56_codatribuicao          = $oDados20->codatribuicao;
		  	$clresplic20$PROXIMO_ANO->si56_cargo 			      = $oDados20->cargo;
		  	$clresplic20$PROXIMO_ANO->si56_naturezacargo	 	  = $oDados20->naturezacargo;
		  	$clresplic20$PROXIMO_ANO->si56_instit		     	  = db_getsession("DB_instit");
		  	$clresplic20$PROXIMO_ANO->si56_mes                    = $this->sDataFinal['5'].$this->sDataFinal['6'];

			$clresplic20$PROXIMO_ANO->incluir(null);
			if ($clresplic20$PROXIMO_ANO->erro_status == 0) {
			  throw new Exception($clresplic20$PROXIMO_ANO->erro_msg);
			}
			
		  }	  
    
    
    
    db_fim_transacao();
    
    $oGerarRESPLIC = new GerarRESPLIC();
    $oGerarRESPLIC->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarRESPLIC->gerarDados();
    
  }
  
}
