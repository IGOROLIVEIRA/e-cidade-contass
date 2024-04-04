<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_parelic102024_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2024/GerarPARELIC.model.php");

/**
 * Parecer da Licita��o Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class SicomArquivoParecerLicitacao extends SicomArquivoBase implements iPadArquivoBaseCSV
{

  /**
   *
   * Codigo do layout. (db_layouttxt.db50_codigo)
   * @var Integer
   */
  protected $iCodigoLayout = 159;

  /**
   *
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'PARELIC';

  /**
   *
   * Construtor da classe
   */
  public function __construct()
  {

  }

  /**
   * Retorna o codigo do layout
   *
   * @return Integer
   */
  public function getCodigoLayout()
  {
    return $this->iCodigoLayout;
  }

  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
   */
  public function getCampos()
  {

    $aElementos = array(
      "codOrgao",
      "codUnidadeSub",
      "exercicioLicitacao",
      "nroProcessoLicitatorio",
      "dataParecer",
      "tipoParecer",
      "nroCpf",
      "nomRespParecer",
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
   * Parecer da Licita��o do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados()
  {

    /**
     * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
     */
    $clparelic10 = new cl_parelic102024();

    /**
     * excluir informacoes do mes selecioado
     */
    db_inicio_transacao();
    $result = db_query($clparelic10->sql_query(null, "*", null, "si66_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si66_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clparelic10->excluir(null, "si66_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si66_instit=" . db_getsession("DB_instit"));
      if ($clparelic10->erro_status == 0) {
        throw new Exception($clparelic10->erro_msg);
      }
    }
    //


    $sSql = " 	SELECT distinct '10' AS tipoRegistro,
         infocomplementaresinstit.si09_codorgaotce as codOrgaoResp,
	(SELECT CASE
    WHEN o41_subunidade != 0
         OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
            OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
              OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0)
    ELSE lpad((CASE WHEN o40_codtri = '0'
         OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
           OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)
   END AS codunidadesub
   FROM db_departorg
   JOIN infocomplementares ON si08_anousu = db01_anousu
   AND si08_instit = " . db_getsession("DB_instit") . "
   JOIN orcunidade ON db01_orgao=o41_orgao
   AND db01_unidade=o41_unidade
   AND db01_anousu = o41_anousu
   JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
   WHERE db01_coddepto=l20_codepartamento and db01_anousu=" . db_getsession("DB_anousu") . " LIMIT 1) as codUnidadeSubResp,
         liclicita.l20_anousu AS exercicioLicitacao,
         liclicita.l20_edital AS nroProcessoLicitatorio,
         parecerlicitacao.l200_data AS dataParecer,
         parecerlicitacao.l200_tipoparecer AS tipoParecer,
         cgm.z01_cgccpf AS nroCpf,
         manutencaolicitacao.manutlic_codunidsubanterior AS codunidsubant
		 FROM liclicita AS liclicita
		 INNER JOIN homologacaoadjudica ON (liclicita.l20_codigo=homologacaoadjudica.l202_licitacao)
		 INNER JOIN parecerlicitacao ON (liclicita.l20_codigo=parecerlicitacao.l200_licitacao)
		 INNER JOIN cgm ON (parecerlicitacao.l200_numcgm=cgm.z01_numcgm)
		 INNER JOIN db_config ON (liclicita.l20_instit=db_config.codigo)
		 INNER JOIN cflicita ON (cflicita.l03_codigo = liclicita.l20_codtipocom)
	INNER JOIN pctipocompratribunal ON (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
		 LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
     LEFT JOIN manutencaolicitacao on (manutencaolicitacao.manutlic_licitacao = liclicita.l20_codigo)
		 WHERE db_config.codigo= " . db_getsession("DB_instit") . "
         AND DATE_PART('YEAR',homologacaoadjudica.l202_datareferencia)= " . db_getsession("DB_anousu") . "
         AND DATE_PART('MONTH',homologacaoadjudica.l202_datareferencia)= " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
         AND pctipocompratribunal.l44_sequencial IN ('48',
		                                                  '49',
		                                                  '50',
		                                                  '51',
		                                                  '52',
		                                                  '53',
		                                                  '54')";

    $rsResult10 = db_query($sSql);//db_criatabela($rsResult10);

    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

      $clparelic10 = new cl_parelic102024();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

      $clparelic10->si66_tiporegistro = 10;
      $clparelic10->si66_codorgao = $oDados10->codorgaoresp;
      if($oDados10->codunidsubant!= null || $oDados10->codunidsubant!=''){
        $clparelic10->si66_codunidadesub = $oDados10->codunidsubant;
      }else{
        $clparelic10->si66_codunidadesub = $oDados10->codunidadesubresp;
      }

      $clparelic10->si66_exerciciolicitacao = $oDados10->exerciciolicitacao;
      $clparelic10->si66_nroprocessolicitatorio = $oDados10->nroprocessolicitatorio;
      $clparelic10->si66_dataparecer = $oDados10->dataparecer;
      $clparelic10->si66_tipoparecer = $oDados10->tipoparecer;
      $clparelic10->si66_nrocpf = $oDados10->nrocpf;
      $clparelic10->si66_instit = db_getsession("DB_instit");
      $clparelic10->si66_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

      $clparelic10->incluir(null);
      if ($clparelic10->erro_status == 0) {
        throw new Exception($clparelic10->erro_msg);
      }

    }
    db_fim_transacao();

    $oGerarPARELIC = new GerarPARELIC();
    $oGerarPARELIC->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarPARELIC->gerarDados();
  }
}
