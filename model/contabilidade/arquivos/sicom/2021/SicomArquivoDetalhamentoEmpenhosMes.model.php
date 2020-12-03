<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_emp102021_classe.php");
require_once ("classes/db_emp112021_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarEMP.model.php");

/**
 * detalhamento dos empenhos do mês Sicom Acompanhamento Mensal
 * @author robson
 * @package Contabilidade
 */
class SicomArquivoDetalhamentoEmpenhosMes extends SicomArquivoBase implements iPadArquivoBaseCSV {

	/**
	 *
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
	protected $iCodigoLayout = 166;

	/**
	 *
	 * Nome do arquivo a ser criado
	 * @var String
	 */
	protected $sNomeArquivo = 'EMP';

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
	 * selecionar os dados dos empenhos do mes para gerar o arquivo
	 * @see iPadArquivoBase::gerarDados()
	 */
	public function gerarDados() {
		
		$cEmp102021 = new cl_emp102021();
		$cEmp112021 = new cl_emp112021();
		
		$sSqlInstit = "select cgc from db_config where codigo = ".db_getsession("DB_instit");
		$rsResultCnpj = db_query($sSqlInstit);
		$sCnpj = db_utils::fieldsMemory($rsResultCnpj, 0)->cgc;
		
		
		$sSqlTrataUnidade = "select si08_tratacodunidade from infocomplementares where si08_instit = ".db_getsession("DB_instit");
		$rsResultTrataUnidade = db_query($sSqlTrataUnidade);
		$sTrataCodUnidade = db_utils::fieldsMemory($rsResultTrataUnidade, 0)->si08_tratacodunidade;
		
		
		 db_inicio_transacao();
			/**
		  	 * excluir informacoes do mes caso ja tenha sido gerado anteriormente
		  	 */
		    
		    $result = $cEmp102021->sql_record($cEmp102021->sql_query(NULL,"*",NULL,"si106_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6'])
		     ." si106_instit = ".db_getsession("DB_instit"));
		    
		    if (pg_num_rows($result) > 0) {
		    	$cEmp112021->excluir(NULL,"si107_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']
		    	." si107_instit = ".db_getsession("DB_instit"));
		    	$cEmp102021->excluir(NULL,"si106_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']
		    	." si106_instit = ".db_getsession("DB_instit"));
		      if ($cEmp102021->erro_status == 0) {
		    	  throw new Exception($claoc112021->erro_msg);
		      }
		    }
		    
		 db_fim_transacao();
		
		  /**
		   * selecionar arquivo xml de dados elemento da despesa
		   */
		  $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomelementodespesa.xml";
		  if (!file_exists($sArquivo)) {
			  throw new Exception("Arquivo de elemento da despesa inexistente!");
	 	  }
		  $sTextoXml    = file_get_contents($sArquivo);
		  $oDOMDocument = new DOMDocument();
		  $oDOMDocument->loadXML($sTextoXml);
		  $oElementos = $oDOMDocument->getElementsByTagName('elemento');

		$sSql = "SELECT DISTINCT 10 as tiporegistro,o58_orgao,o58_unidade,o15_codtri,
				       si09_codorgaotce as codorgao, 
				       lpad(o58_orgao,2,0)||lpad(o58_unidade,3,0) as codunidadesub,
				       o58_funcao as codfuncao,
				       o58_subfuncao as codsubfuncao,
				       o58_programa as codprograma,
				       o58_projativ as idacao,
				       ' ' as idsubacao,
				       substr(o56_elemento,2,8) as naturezadadespesa,
				       substr(o56_elemento,7,2) as subelemento,
				       e60_codemp as nroempenho,
				       e60_emiss as dtempenho,
				       case when e60_codtipo = 2 then 3
				            when e60_codtipo = 3 then 2
				            else 1 end as modalidadempenho,
				       case when substr(o56_elemento,1,3) = '346' then 2 else 1 end as tpempenho,
				       e60_vlremp as vlbruto,
				       e60_resumo as especificaoempenho,
				       case when si173_codcontrato is null then 2 else 1 end as despdeccontrato,
				       ' '::char as codorgaorespcontrato,
				       case when si173_codcontrato is null then null else lpad(db01_orgao,2,0)||lpad(db01_unidade,3,0) end as codunidadesubrespcontrato,
				       case when si173_codcontrato is null then null else si172_nrocontrato end as nrocontrato,
				       case when si173_codcontrato is null then null else si172_dataassinatura end as dataassinaturacontrato,
				       case when si174_sequencial is null then null else si174_nroseqtermoaditivo end as nrosequencialtermoaditivo,
				       case when e60_convenio = 1 then 1 else 2 end as despdecconvenio,
				       case when e60_convenio = 2 then null else e60_numconvenio end as nroconvenio,
				       case when e60_convenio = 2 then null else e60_dataconvenio end as dataassinaturaconvenio,
				       case when l20_codigo is null then 1
				            when l03_pctipocompratribunal in (100,101,102) then 3 else 2 end as despDecLicitacao,
				       ' ' as codorgaoresplicit,
				       case when l20_codigo is null then null else (select lpad(db01_orgao,2,0)||lpad(db01_unidade,3,0) as unidadesub 
				          from db_departorg 
				         where db01_coddepto = l20_codepartamento 
				         and db01_anousu = e60_anousu) 
				         end as codunidadesubresplicit,
				       case when l20_codigo is null then null else l20_edital end nroprocessolicitatorio,
				       case when l20_codigo is null then null else l20_anousu end exercicioprocessolicitatorio,
				       case when l20_codigo is null then null
				            when l03_pctipocompratribunal not in (100,101,102) then null 
				            when l03_pctipocompratribunal = 100 then 2 
				            when l03_pctipocompratribunal = 101 then 1  
				            else 3 end as tipoprocesso,
				       o.z01_cgccpf as ordenador,    
				       e60_numemp as numemp
				     FROM empempenho
				     JOIN orcdotacao ON e60_coddot = o58_coddot
				     JOIN empelemento ON e60_numemp = e64_numemp
				     JOIN orcelemento ON e64_codele = o56_codele
				     JOIN orctiporec ON o58_codigo = o15_codigo
				     JOIN emptipo ON e60_codtipo = e41_codtipo
				     JOIN cgm ON e60_numcgm = z01_numcgm
				     JOIN pctipocompra on e60_codcom = pc50_codcom 
				LEFT JOIN cflicita on  l03_codcom = pc50_codcom 
				LEFT JOIN infocomplementaresinstit on si09_instit = e60_instit
				LEFT JOIN empcontratos on e60_anousu = si173_anoempenho and e60_codemp::int = si173_empenho
				LEFT JOIN contratos on si173_codcontrato = si172_sequencial
				LEFT JOIN db_departorg ON si172_codunidadesubresp::int = db01_coddepto AND db01_anousu = e60_anousu
				LEFT JOIN aditivoscontratos on si174_nrocontrato = si173_codcontrato
				LEFT JOIN rescisaocontrato on si176_nrocontrato = si173_codcontrato
				LEFT JOIN liclicita ON ((string_to_array(e60_numerol, '/'))[1])::int = l20_numero 
				      AND l20_anousu = ((string_to_array(e60_numerol, '/'))[2])::int 
				      AND l03_codigo = l20_codtipocom
				LEFT JOIN orcunidade on o58_anousu = o41_anousu and o58_orgao = o41_orgao and o58_unidade = o41_unidade
				   LEFT JOIN cgm o on o.z01_numcgm = o41_orddespesa
				    WHERE e60_anousu = ".db_getsession("DB_anousu")."
				      AND o56_anousu = ".db_getsession("DB_anousu")."
				      AND o58_anousu = ".db_getsession("DB_anousu")."
				      AND e60_instit = ".db_getsession("DB_instit")." 
				      AND e60_emiss between '".$this->sDataInicial."' AND '".$this->sDataFinal."'";
		
        
		$rsEmpenho = db_query($sSql);
     
		$aCaracteres = array("°",chr(13),chr(10),"'",);
		
		
		
		for ($iCont = 0; $iCont < pg_num_rows($rsEmpenho); $iCont++) {
			 
			$oEmpenho = db_utils::fieldsMemory($rsEmpenho, $iCont);
      
						
		  if ($sTrataCodUnidade == '1') {
      		
	            $sCodUnidade  = str_pad($oEmpenho->o58_orgao, 2, "0", STR_PAD_LEFT);
		   		$sCodUnidade .= str_pad($oEmpenho->o58_unidade, 3, "0", STR_PAD_LEFT);
		   		  
	      } else {
	      		
	          $sCodUnidade  = $oEmpenho->codunidadesub;
	      		
	      }
			
           $sElemento = substr($oEmpenho->naturezadadespesa, 0, 8);
	      /**
	       * percorrer xml elemento despesa
	       */
	      foreach ($oElementos as $oElemento) {
	      	
	      	if ($oElemento->getAttribute('instituicao') == db_getsession("DB_instit") 
							&& $oElemento->getAttribute('elementoEcidade') == $sElemento) {
								
	      	  $sElemento = $oElemento->getAttribute('elementoSicom');
	      	  break; 	
	      	  
	      	}
	      	
	      }
          db_inicio_transacao();
	            
			$oDadosEmpenho = new cl_emp102021();
	
			$oDadosEmpenho->si106_tiporegistro                 = $oEmpenho->tiporegistro;
			$oDadosEmpenho->si106_codorgao                     = $oEmpenho->codorgao;
			$oDadosEmpenho->si106_codunidadesub                = $sCodUnidade;
			$oDadosEmpenho->si106_codfuncao                    = $oEmpenho->codfuncao;
			$oDadosEmpenho->si106_codsubfuncao                 = $oEmpenho->codsubfuncao;
			$oDadosEmpenho->si106_codprograma                  = $oEmpenho->codprograma;
			$oDadosEmpenho->si106_idacao                       = $oEmpenho->idacao;
			$oDadosEmpenho->si106_idsubacao					   = ' ';
			$oDadosEmpenho->si106_naturezadespesa              = substr($sElemento, 0, 6);
			$oDadosEmpenho->si106_subelemento                  = substr($sElemento, 6, 2);
			$oDadosEmpenho->si106_nroempenho                   = $oEmpenho->nroempenho;
			$oDadosEmpenho->si106_dtempenho                    = $oEmpenho->dtempenho;
			$oDadosEmpenho->si106_modalidadeempenho            = $oEmpenho->modalidadempenho;
			$oDadosEmpenho->si106_tpempenho                    = $oEmpenho->tpempenho;
			$oDadosEmpenho->si106_vlbruto                      = $oEmpenho->vlbruto;
			$oDadosEmpenho->si106_especificacaoempenho         = $oEmpenho->especificaoempenho == '' ? 'SEM HISTORICO'  : substr(str_replace($aCaracteres, '', $oEmpenho->especificaoempenho),0,200);
			$oDadosEmpenho->si106_despdeccontrato              = $oEmpenho->despdeccontrato;
			$oDadosEmpenho->si106_codorgaorespcontrato	       = $oEmpenho->codorgaorespcontrato;
			$oDadosEmpenho->si106_codunidadesubrespcontrato    = $oEmpenho->codunidadesubrespcontrato;
			$oDadosEmpenho->si106_nrocontrato                  = $oEmpenho->nrocontrato;
			$oDadosEmpenho->si106_dtassinaturacontrato         = $oEmpenho->dtassinaturacontrato;
			$oDadosEmpenho->si106_nrosequencialtermoaditivo    = $oEmpenho->nrosequencialtermoaditivo;
			$oDadosEmpenho->si106_despdecconvenio              = $oEmpenho->despdecconvenio;
			$oDadosEmpenho->si106_nroconvenio 				   = $oEmpenho->nroconvenio; 
			$oDadosEmpenho->si106_dataassinaturaconvenio	   = $oEmpenho->dataassinaturaconvenio;
			$oDadosEmpenho->si106_despdeclicitacao             = $oEmpenho->despdeclicitacao;
			$oDadosEmpenho->si106_codunidadesubresplicit       = $oEmpenho->codunidadesubresplicit;
			$oDadosEmpenho->si106_nroprocessolicitatorio       = $oEmpenho->nroprocessolicitatorio;
			$oDadosEmpenho->si106_exercicioprocessolicitatorio = $oEmpenho->exercicioprocessolicitatorio;
			$oDadosEmpenho->si106_tipoprocesso                 = $oEmpenho->tipoprocesso;
			$oDadosEmpenho->si106_cpfordenador				   = substr($oEmpenho->ordenador,0,11);
			$oDadosEmpenho->si106_mes						   = $this->sDataFinal['5'].$this->sDataFinal['6'];
			$oDadosEmpenho->si106_instit					   = db_getsession("DB_instit");
			
			
			$oDadosEmpenho->incluir();
			if ($oDadosEmpenho->erro_status == 0) {
	    	  throw new Exception($oDadosEmpenho->erro_msg);
	        }
			
			/**
			 * dados registro 11
			 */
			$oDadosEmpenhoFonte = new cl_emp112021();
			
			$oDadosEmpenhoFonte->si107_tiporegistro    = 11;
			$oDadosEmpenhoFonte->si107_codunidadesub   = $sCodUnidade;
			$oDadosEmpenhoFonte->si107_nroempenho      = $oEmpenho->nroempenho;
			$oDadosEmpenhoFonte->si107_codfontrecursos = $oEmpenho->o15_codtri;
			$oDadosEmpenhoFonte->si107_valorfonte      = $oEmpenho->vlbruto;
			$oDadosEmpenhoFonte->si107_mes             = $this->sDataFinal['5'].$this->sDataFinal['6'];
			$oDadosEmpenhoFonte->si107_reg10           = $oDadosEmpenho->si106_sequencial;
			$oDadosEmpenhoFonte->si107_instit					   = db_getsession("DB_instit");
			
			$oDadosEmpenhoFonte->incluir(null);
		    if ($oDadosEmpenhoFonte->erro_status == 0) {
	    	  throw new Exception($oDadosEmpenhoFonte->erro_msg);
	        }
			db_fim_transacao();
		}
	
	    $oGerarEMP = new GerarEMP();
	    $oGerarEMP->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];;
	    $oGerarEMP->gerarDados();

	}

}
