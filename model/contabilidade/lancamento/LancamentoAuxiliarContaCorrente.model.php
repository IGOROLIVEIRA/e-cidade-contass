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
 
require_once "interfaces/ILancamentoAuxiliar.interface.php";
require_once "model/contabilidade/lancamento/LancamentoAuxiliarBase.model.php";

/**
 * Classe que implementa os métodos necessarios para generalizar um lançamento auxiliar
 * Utilizada no reprocessamento de lançamentos contábeis
 * @author Bruno Silva
 * @version $Revision: 1.8 $
 */
class LancamentoAuxiliarContaCorrente extends LancamentoAuxiliarBase implements ILancamentoAuxiliar{

	/**
	 * Sequencial da conta corrente (c19_contacorrente - contacorrentedetalhe)
	 * @var integer $iContaCorrente
	 */
	private $iContaCorrente;
	
	/**
	 * Código da receita
	 * @var integer $iTipoReceita
	 */
	private $iTipoReceita;

	/**
	 * Código da instituição (db_config)
	 * @var integer $iInstituicao
	 */
	private $iInstituicao;

	/**
	 * Característica Peculiar
	 * @var String $sCaracteristicaPeculiar
	 */
	private $sCaracteristicaPeculiar;

	/**
	 * Código da conta bancária
	 * @var integer $iContaBancaria
	 */
	private $iContaBancaria;
	 
	/**
	 * Código reduzido da conta bancária
	 * @var integer $iReduzidoContaBancaria
	 */
	private $iReduzidoContaBancaria;
	 

	/**
	 * Código do CGM
	 * @var integer $iCgm
	 */
	private $iCgm;

	/**
	 * Código do recurso
	 * @var integer $iCodigoRecurso
	 */
	private $iCodigoRecurso;

	/**
	 * Ano da Unidade
	 * @var integer $iUnidadeAnousu
	 */
	private $iUnidadeAnousu;

	/**
	 * Unidade do órgão
	 * @var integer $iUnidadeDoOrgao
	 */
	private $iUnidadeDoOrgao;

	/**
	 * Código da unidade
	 * @var integer $iUnidade
	 */
	private $iUnidade;

	/**
   * Ano do órgão
   * @var integer $iOrgaoAnousu
	 */
	private $iOrgaoAnousu;

	/**
	 * Código do órgão
	 * @var integer $iOrgao
	 */
	private $iOrgao;

	/**
	 * Propriedades Obrigatorias da Interface
	 */

	/**
	 * Código do histórico
	 * @var integer $iCodigoHistorico
	 */
	private $iCodigoHistorico;
	/**
	 * Valor total
	 * @var numeric $nValorTotal
	 */
	private $nValorTotal;

	/**
	 * sequencial do acordo
	 */
	private $iAcordo;

	/**
	 * Construtor da classe
	 * A classe é contruída a partir de um dos parâmetros passados para o construtor
	 * 1) a partir de um código de lançamento:
	 * 	- buscando todos atributos necessários para o preenchimento do objeto
	 * 2) a partir do código do detalhamento do lançamento
	 * 	- busca na tabela mapeada pela classe, e reconstroi o objeto
	 *
	 * @param int $iCodigoLancamento
	 * @throws Exception
	 */
	public function __construct($iCodigoLancamento) {

		$this->iContaCorrente    = null;
		$this->iInstituicao      = db_getsession("DB_instit");
		$this->iCodigoLancamento = $iCodigoLancamento;
			
		/**
		 * propriedades setadas durante reconstrução do lançamento
		 */
		$this->iContaBancaria         = null;
		$this->iReduzidoContaBancaria = null;

    $oContaCorrenteDetalhe = new ContaCorrenteDetalhe();

    /**
     * Dados da Receita
     */

    $oDaoConlancamRec = new  cl_conlancamrec();
    $sSqlDadosReceita = $oDaoConlancamRec->sql_query_dados_receita($iCodigoLancamento);
    $rsDadosReceita   = $oDaoConlancamRec->sql_record($sSqlDadosReceita);
    if ($oDaoConlancamRec->numrows > 0) {

      $oDadosReceita = db_Utils::fieldsMemory($rsDadosReceita, 0);
      $oContaCorrenteDetalhe->setRecurso(RecursoRepository::getRecursoPorCodigo($oDadosReceita->o70_codigo));
      $oContaCorrenteDetalhe->setEstrutural($oDadosReceita->o57_fonte);
    }


		/**
		 *	Busca dados referente ao cgm, empenho e caracteristica peculiar
		 */
		$oDAOConlancam	= db_utils::getDao("conlancam");
		$sWhere					= "c70_codlan = {$this->iCodigoLancamento}";
		$sSQLConlancam	= $oDAOConlancam->sql_query_empenho_cgm(null, "*", null, $sWhere);
		$rsConlancam		= $oDAOConlancam->sql_record($sSQLConlancam);
			
		if ($oDAOConlancam->numrows > 0) {

			$oConlancam							       = db_utils::fieldsMemory($rsConlancam, 0);
			$this->iCgm 					         = $oConlancam->c76_numcgm;
			$this->iNumeroEmpenho          = $oConlancam->e60_numemp;
			$this->sCaracteristicaPeculiar = $oConlancam->c08_concarpeculiar;


      if (!empty($this->iCgm)) {

        $oCgm = CgmFactory::getInstanceByCgm($this->iCgm);
        $oContaCorrenteDetalhe->setCredor($oCgm);
      }

      if (!empty($this->iNumeroEmpenho)) {

        $oEmpenho = EmpenhoFinanceiroRepository::getEmpenhoFinanceiroPorNumero($this->iNumeroEmpenho);
        $oContaCorrenteDetalhe->setEmpenho($oEmpenho);
        $oRecurso  = $oEmpenho->getDotacao()->getDadosRecurso();
        $oContaCorrenteDetalhe->setRecurso($oRecurso);

      }
			/**
			 * Caso não vir característica peculiar, pegar a mesma do registro do empenho
			 */
			if (empty($this->sCaracteristicaPeculiar)) {
				$this->sCaracteristicaPeculiar = $oConlancam->e60_concarpeculiar;
			}
		}

    /**
     * Verificamos a conta bancaria do lançamento,
     */
    $oDaoConlancamPag     = new cl_conlancampag();
    $sSqlDadosLancamento  = $oDaoConlancamPag->sql_query_file($iCodigoLancamento);
    $rsDadosContaPagadora = $oDaoConlancamPag->sql_record($sSqlDadosLancamento);
    if ($rsDadosContaPagadora && $oDaoConlancamPag->numrows > 0) {

      $oDadosContaPagadora = db_utils::fieldsMemory($rsDadosContaPagadora, 0);
      $oContaPlano         = ContaPlanoPCASPRepository::getContaPorReduzido($oDadosContaPagadora->c82_reduz,
                                                                            $oDadosContaPagadora->c82_anousu
                                                                           );
      if (!empty($oContaPlano) && $oContaPlano->getContaBancaria() != '') {
        $oContaCorrenteDetalhe->setContaBancaria($oContaPlano->getContaBancaria());
      }
    }
    /**
		 *  Busca dados referente a unidade e orgão
		 */
		$oDAOConlancamdot	= db_utils::getDao("conlancamdot");
		$sSQLConlancamdot	= $oDAOConlancamdot->sql_query(null, "*", null, $sWhere);
		$rsConlancamdot		= $oDAOConlancamdot->sql_record($sSQLConlancamdot);
			
		if ($oDAOConlancamdot->numrows > 0) {

			$oConlancamdotorcunidade = db_utils::fieldsMemory($rsConlancamdot, 0);
      $oDotacao                = new Dotacao($oConlancamdotorcunidade->o58_coddot, $oConlancamdotorcunidade->o58_anousu);
      $oContaCorrenteDetalhe->setDotacao($oDotacao);

			$this->iUnidadeAnousu    = $oConlancamdotorcunidade->o41_anousu;
			$this->iUnidadeDoOrgao   = $oConlancamdotorcunidade->o41_orgao;
			$this->iUnidade          = $oConlancamdotorcunidade->o41_unidade;
			$this->iOrgaoAnousu      = $oConlancamdotorcunidade->o40_anousu;
			$this->iOrgao            = $oConlancamdotorcunidade->o40_orgao;

		} elseif(!empty($this->iNumeroEmpenho)) {

			/**
			 * Caso não tenha dotação na conlancamdot, será passado o ano e dotação do empenho.
			 * Isso acontece quando o empenho e de Restos a Pagar
			 */
			$oDotacao  = new Dotacao($oEmpenho->getDotacao()->getCodigo(), $oEmpenho->getDotacao()->getAnoUsu());
			$oContaCorrenteDetalhe->setDotacao($oDotacao);

			$this->iUnidadeAnousu    = $oEmpenho->getDotacao()->getAnoUsu();
			$this->iUnidadeDoOrgao   = $oEmpenho->getDotacao()->getOrgao();
			$this->iUnidade          = $oEmpenho->getDotacao()->getUnidade();
			$this->iOrgaoAnousu      = $oEmpenho->getDotacao()->getAnoUsu();
			$this->iOrgao            = $oEmpenho->getDotacao()->getOrgao();
		}
			
		$oDAOConlancamgrupocorrente	= db_utils::getDao("conlancamcorgrupocorrente");
		$sWhere											= "c70_codlan = {$this->iCodigoLancamento}";
		$sSQLConlancamgrupocorrente	= $oDAOConlancamgrupocorrente->sql_query_recurso(null, "*", null, $sWhere);
		$rsConlancamgrupocorrente   = $oDAOConlancamgrupocorrente->sql_record($sSQLConlancamgrupocorrente);
			
		$this->iCodigoRecurso		= null;
		if($oDAOConlancamgrupocorrente->numrows > 0) {

			$this->iCodigoRecurso = db_utils::fieldsMemory($rsConlancamgrupocorrente, 0)->k00_recurso;
      $oRecurso             = RecursoRepository::getRecursoPorCodigo($this->iCodigoRecurso);
      $oContaCorrenteDetalhe->setRecurso($oRecurso);
		}

		/**
		 * Se for empenho, buscar o número do acordo (contrato)
		 */
		if (!empty($this->iNumeroEmpenho)) {

			$oDAOEmpempenhocontrato	= db_utils::getDao("empempenhocontrato");
			$sWhere									= "e100_numemp = {$this->iNumeroEmpenho}";
			$sSQLEmpempenhocontrato	= $oDAOEmpempenhocontrato->sql_query_file(null, "*", null, $sWhere);
			$rsEmpempenhocontrato   = $oDAOEmpempenhocontrato->sql_record($sSQLEmpempenhocontrato);

			if($oDAOEmpempenhocontrato->numrows > 0) {

				$this->iAcordo = db_utils::fieldsMemory($rsEmpempenhocontrato, 0)->e100_acordo;
        $oContaCorrenteDetalhe->setAcordo(new Acordo($this->iAcordo));
			}
		}

		/**
		 * Busca o campo referente a emenda parlamentar na planilha de arrecadação
		 */
		$oDAOPlacaixarec 	= db_utils::getDao("placaixarec");
		$sSqlPlacaixarec 	= $oDAOPlacaixarec->sql_query_placaixarec_lancam(null, "k81_emparlamentar", null, "c86_conlancam = {$this->iCodigoLancamento}");
		$rsPlacaixarec		= $oDAOPlacaixarec->sql_record($sSqlPlacaixarec);

		if ($oDAOPlacaixarec->numrows > 0) {

			$iEmendaParlamentar = db_utils::fieldsMemory($rsPlacaixarec, 0)->k81_emparlamentar;
			$oContaCorrenteDetalhe->setEmendaParlamentar($iEmendaParlamentar);
			
		}

    $this->setContaCorrenteDetalhe($oContaCorrenteDetalhe);
	}


	/**
	 * Retorna o Código do caracteristica peculiar
	 * @return integer
	 */
	public function getCaracteristicaPeculiar() {
		return $this->sCaracteristicaPeculiar;
	}

	/**
	 * Retorna o Número do Empenho
	 * @return integer
	 */
	public function getNumeroEmpenho() {
		return $this->iNumeroEmpenho;
	}

	/**
	 * Retorna o Código do Recurso
	 * @return integer
	 */
	public function getCodigoRecurso() {
		return $this->iCodigoRecurso;
	}

	/**
	 * Retorna o Código do Acordo
	 * @return integer
	 */
	public function getAcordo() {
		return $this->iAcordo;
	}

	/**
	 * Retorna o Código do Favorecido
	 * @return integer
	 */
	public function getFavorecido() {
		return $this->iCgm;
	}


	/**
	 * Seta o valor total do lancamento
	 * @see ILancamentoAuxiliar::setValorTotal()
	 */
	public function setValorTotal($nValorTotal) {
		$this->nValorTotal = $nValorTotal;
	}

	/**
	 * Retorna o valor total
	 * @see ILancamentoAuxiliar::getValorTotal()
	 */
	public function getValorTotal() {
		return $this->nValorTotal;
	}

	/**
	 * Seta o codigo do historico
	 * @see ILancamentoAuxiliar::setHistorico()
	 */
	public function setHistorico($iHistorico) {
		$this->iCodigoHistorico = $iHistorico;
	}

	/**
	 * Retorna o codigo do historico
	 * @see ILancamentoAuxiliar::getHistorico()
	 */
	public function getHistorico() {
		return $this->iCodigoHistorico;
	}

	/**
	 * Retorna o complemento do lancamento contabil
	 * @see ILancamentoAuxiliar::getObservacaoHistorico()
	 */
	public function getObservacaoHistorico() {
		return $this->sObservacao;
	}

	/**
	 * Seta o complemento do lancamento contabil
	 * @see ILancamentoAuxiliar::setObservacaoHistorico()
	 */
	public function setObservacaoHistorico($sObservacao) {
		$this->sObservacao = $sObservacao;
	}

	/**
	 * Executa o lançamento Auxiliar
	 * Método necessário para implementar a interface ILancamentoAuxiliar
	 * @see ILancamentoAuxiliar::executaLancamentoAuxiliar()
	 */
	public function executaLancamentoAuxiliar($iCodigoLancamento, $dtLancamento) {
		return true;
	}

}

?>
