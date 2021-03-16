<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_ctb102020_classe.php");
require_once("classes/db_ctb202020_classe.php");
require_once("classes/db_ctb212020_classe.php");
require_once("classes/db_ctb222020_classe.php");
require_once("classes/db_ctb302020_classe.php");
require_once("classes/db_ctb312020_classe.php");
require_once("classes/db_ctb402020_classe.php");
require_once("classes/db_ctb412020_classe.php");
require_once("classes/db_ctb502020_classe.php");
require_once("classes/db_ctb602020_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2020/GerarCTB.model.php");


/**
 * Contas bancarias Sicom Acompanhamento Mensal
 * @author robson
 * @package Contabilidade
 */
class SicomArquivoContasBancarias extends SicomArquivoBase implements iPadArquivoBaseCSV
{

  /**
   *
   * Codigo do layout. (db_layouttxt.db50_codigo)
   * @var Integer
   */
  protected $iCodigoLayout = 164;

  /**
   *
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'CTB';

  /**
   * @var array Fontes encerradas em 2020
   */
  protected $aFontesEncerradas = array('148', '149', '150', '151', '152', '248', '249', '250', '251', '252');

  /**
   * @var bollean
   * Realiza transferência de fontes utilizadas no reg 20 para fonte principal da conta (PCASP)
   */
  protected $bEncerramento = false;

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

  }

  public function setEncerramentoCtb($iEncerramento) {
	if ($iEncerramento == 1) {
		$this->bEncerramento = true;
	}
  }

  /**
   * selecionar os dados das contas bancarias
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados()
  {


    $cCtb10 = new cl_ctb102020();
    $cCtb20 = new cl_ctb202020();
    $cCtb21 = new cl_ctb212020();
    $cCtb22 = new cl_ctb222020();
    $cCtb30 = new cl_ctb302020();
    $cCtb31 = new cl_ctb312020();
    $cCtb40 = new cl_ctb402020();
    $cCtb41 = new cl_ctb412020();
    $cCtb50 = new cl_ctb502020();


    /**
     * selecionar arquivo xml com dados das receitas
     */
    $sSql = "SELECT * FROM db_config ";
    $sSql .= "	WHERE prefeitura = 't'";

    $rsInst = db_query($sSql);
    $sCnpj = db_utils::fieldsMemory($rsInst, 0)->cgc;
    $sArquivo = "config/sicom/" . db_getsession("DB_anousu") . "/{$sCnpj}_sicomnaturezareceita.xml";

    $sTextoXml = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oNaturezaReceita = $oDOMDocument->getElementsByTagName('receita');

    /**
     * excluir informacoes do mes caso ja tenha sido gerado anteriormente
     */

    $result = $cCtb20->sql_record($cCtb20->sql_query(null, "*", null, "si96_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']
      . " and si96_instit = " . db_getsession("DB_instit")));


    db_inicio_transacao();
    if (pg_num_rows($result) > 0) {

      $cCtb50->excluir(null, "si102_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si102_instit = " . db_getsession("DB_instit"));
      if ($cCtb50->erro_status == 0) {
        throw new Exception($cCtb50->erro_msg);
      }

      $cCtb40->excluir(null, "si101_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si101_instit = " . db_getsession("DB_instit"));
      if ($cCtb40->erro_status == 0) {
        throw new Exception($cCtb40->erro_msg);
      }

      $cCtb22->excluir(null, "si98_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si98_instit = " . db_getsession("DB_instit"));
      if ($cCtb22->erro_status == 0) {

        throw new Exception($cCtb22->erro_msg);
      }
      $cCtb21->excluir(null, "si97_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si97_instit = " . db_getsession("DB_instit"));
      if ($cCtb21->erro_status == 0) {

        throw new Exception($cCtb21->erro_msg);
      }
      $cCtb20->excluir(null, "si96_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si96_instit = " . db_getsession("DB_instit"));
      if ($cCtb20->erro_status == 0) {

        throw new Exception($cCtb20->erro_msg);
      }
      $cCtb10->excluir(null, "si95_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si95_instit = " . db_getsession("DB_instit"));
      if ($cCtb10->erro_status == 0) {

        throw new Exception($cCtb10->erro_msg);
      }
    }
    db_fim_transacao();

    $sSqlGeral = "select  10 as tiporegistro,
					     k13_reduz as codctb,
					     c61_codtce as codtce, 
					     si09_codorgaotce,
				             c63_banco, 
				             c63_agencia, 
				             c63_conta, 
				             c63_dvconta, 
				             c63_dvagencia,
				             case when db83_tipoconta in (2,3) then 2 else 1 end as tipoconta,
				             case when (select si09_tipoinstit from infocomplementaresinstit where si09_instit = " . db_getsession("DB_instit") . " ) = 5 and db83_tipoconta in (2,3)
				             then db83_tipoaplicacao::varchar else ' ' end as tipoaplicacao,
				             case when (select si09_tipoinstit from infocomplementaresinstit where si09_instit = " . db_getsession("DB_instit") . " ) = 5 and db83_tipoconta in (2,3)
				             then db83_nroseqaplicacao::varchar else ' ' end as nroseqaplicacao,
				             db83_descricao as desccontabancaria,
				             CASE WHEN db83_numconvenio is null then 2 else  1 end as contaconvenio,
				             CASE WHEN db83_numconvenio is null then ' ' else  c206_nroconvenio end as nroconvenio,
				             CASE WHEN db83_numconvenio is null then null else  c206_dataassinatura end as dataassinaturaconvenio,
				             o15_codtri as recurso
				       from saltes 
				       join conplanoreduz on k13_reduz = c61_reduz and c61_anousu = " . db_getsession("DB_anousu") . "
				       join conplanoconta on c63_codcon = c61_codcon and c63_anousu = c61_anousu
				       join orctiporec on c61_codigo = o15_codigo
				  left join conplanocontabancaria on c56_codcon = c61_codcon and c56_anousu = c61_anousu
				  left join contabancaria on c56_contabancaria = db83_sequencial
				  left join convconvenios on db83_numconvenio = c206_sequencial
				  left join infocomplementaresinstit on si09_instit = c61_instit ";
    if( db_getsession("DB_anousu") == 2020 && $this->sDataFinal['5'] . $this->sDataFinal['6'] == 1 ) {
        $sSqlGeral .= " where (k13_limite is null or k13_limite >= '" . $this->sDataFinal . "') 
    				     and c61_instit = " . db_getsession("DB_instit") . " order by k13_reduz";
    }else {
        $sSqlGeral .= " where (k13_limite is null or k13_limite >= '" . $this->sDataFinal . "') 
				    and (date_part('MONTH',k13_dtimplantacao) <= " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " 
				    or date_part('YEAR',k13_dtimplantacao) < " . db_getsession("DB_anousu") . ")
    				  and c61_instit = " . db_getsession("DB_instit") . " order by k13_reduz"; 
    }

    $rsContas = db_query($sSqlGeral);
    //echo $sSqlGeral;
    //db_criatabela($rsContas);

    $aBancosAgrupados = array();
    /* RECEITAS QUE DEVEM SER SUBSTIUIDAS RUBRICA CADASTRADA ERRADA */
    $aRectce = array('111202', '111208', '172136', '191138', '191139', '191140',
      '191308', '191311', '191312', '191313', '193104', '193111',
      '193112', '193113', '172401', '247199', '247299');

    for ($iCont = 0; $iCont < pg_num_rows($rsContas); $iCont++) {

      $oRegistro10 = db_utils::fieldsMemory($rsContas, $iCont);


      $aHash = $oRegistro10->si09_codorgaotce;
      $aHash .= intval($oRegistro10->c63_banco);
      $aHash .= intval($oRegistro10->c63_agencia);
      $aHash .= $oRegistro10->c63_dvagencia;
      $aHash .= intval($oRegistro10->c63_conta);
      $aHash .= $oRegistro10->c63_dvconta;
      $aHash .= $oRegistro10->tipoconta;
      if ($oRegistro10->si09_codorgaotce == 5) {
        $aHash .= $oRegistro10->tipoaplicacao;
      }

      if ($oRegistro10->si09_tipoinstit != 5) {

        if (!isset($aBancosAgrupados[$aHash])) {

          $cCtb10 = new cl_ctb102020();


          $cCtb10->si95_tiporegistro = $oRegistro10->tiporegistro;
          $cCtb10->si95_codctb = $oRegistro10->codtce != 0 ? $oRegistro10->codtce : $oRegistro10->codctb;
          $cCtb10->si95_codorgao = $oRegistro10->si09_codorgaotce;
          $cCtb10->si95_banco = $oRegistro10->c63_banco;
          $cCtb10->si95_agencia = $oRegistro10->c63_agencia;
          $cCtb10->si95_digitoverificadoragencia = $oRegistro10->c63_dvagencia;
          $cCtb10->si95_contabancaria = $oRegistro10->c63_conta;
          $cCtb10->si95_digitoverificadorcontabancaria = $oRegistro10->c63_dvconta;
          $cCtb10->si95_tipoconta = $oRegistro10->tipoconta;
          $cCtb10->si95_tipoaplicacao = $oRegistro10->tipoaplicacao;
          $cCtb10->si95_nroseqaplicacao = $oRegistro10->nroseqaplicacao;
          $cCtb10->si95_desccontabancaria = substr($oRegistro10->desccontabancaria, 0, 50);
          $cCtb10->si95_contaconvenio = $oRegistro10->contaconvenio;
          $cCtb10->si95_nroconvenio = $oRegistro10->nroconvenio;
          $cCtb10->si95_dataassinaturaconvenio = $oRegistro10->dataassinaturaconvenio;
          $cCtb10->si95_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
          $cCtb10->si95_instit = db_getsession("DB_instit");
          $cCtb10->recurso = $oRegistro10->recurso;
          $cCtb10->contas = array();

          $sSqlVerifica = "SELECT 'ctb102020' AS ano, si95_codctb, si95_nroconvenio FROM ctb102020 ";
          $sSqlVerifica .= "WHERE si95_codorgao::int = $oRegistro10->si09_codorgaotce 
                              AND si95_banco = '$oRegistro10->c63_banco'
                              AND si95_agencia = '$oRegistro10->c63_agencia' 
                              AND si95_digitoverificadoragencia = '$oRegistro10->c63_dvagencia' 
                              AND si95_contabancaria = '$oRegistro10->c63_conta'
                              AND si95_digitoverificadorcontabancaria = '$oRegistro10->c63_dvconta' 
                              AND si95_tipoconta::int = $oRegistro10->tipoconta 
                              AND si95_mes <= " . $this->sDataFinal['5'] . $this->sDataFinal['6'] ."
                              AND si95_instit = " . db_getsession('DB_instit');
          $sSqlVerifica .= " UNION ";
          $sSqlVerifica .= " SELECT 'ctb102019' AS ano, si95_codctb, si95_nroconvenio FROM ctb102019 ";
          $sSqlVerifica .= " WHERE si95_codorgao::int = $oRegistro10->si09_codorgaotce 
                               AND si95_banco = '$oRegistro10->c63_banco'
                               AND si95_agencia = '$oRegistro10->c63_agencia' 
                               AND si95_digitoverificadoragencia = '$oRegistro10->c63_dvagencia' 
                               AND si95_contabancaria = '$oRegistro10->c63_conta'
                               AND si95_digitoverificadorcontabancaria = '$oRegistro10->c63_dvconta' 
                               AND si95_tipoconta::int = $oRegistro10->tipoconta 
                               AND si95_instit = " . db_getsession('DB_instit');
          $sSqlVerifica .= " UNION ";
          $sSqlVerifica .= " SELECT 'ctb102018' AS ano, si95_codctb, si95_nroconvenio::varchar FROM ctb102018 ";
          $sSqlVerifica .= " WHERE si95_codorgao::int = $oRegistro10->si09_codorgaotce 
                               AND si95_banco = '$oRegistro10->c63_banco' 
                               AND si95_agencia = '$oRegistro10->c63_agencia' 
                               AND si95_digitoverificadoragencia = '$oRegistro10->c63_dvagencia' 
                               AND si95_contabancaria = '$oRegistro10->c63_conta' 
                               AND si95_digitoverificadorcontabancaria = '$oRegistro10->c63_dvconta' 
                               AND si95_tipoconta::int = $oRegistro10->tipoconta 
                               AND si95_instit = " . db_getsession('DB_instit');
          $sSqlVerifica .= " UNION ";
          $sSqlVerifica .= " SELECT 'ctb102017' AS ano, si95_codctb, si95_nroconvenio::varchar FROM ctb102017 ";
          $sSqlVerifica .= " WHERE si95_codorgao::int = $oRegistro10->si09_codorgaotce 
                               AND si95_banco = '$oRegistro10->c63_banco' 
                               AND si95_agencia = '$oRegistro10->c63_agencia' 
                               AND si95_digitoverificadoragencia = '$oRegistro10->c63_dvagencia' 
                               AND si95_contabancaria = '$oRegistro10->c63_conta' 
                               AND si95_digitoverificadorcontabancaria = '$oRegistro10->c63_dvconta' 
                               AND si95_tipoconta::int = $oRegistro10->tipoconta 
                               AND si95_instit = " . db_getsession('DB_instit');
          $sSqlVerifica .= " UNION ";
          $sSqlVerifica .= " SELECT 'ctb102016' AS ano, si95_codctb, si95_nroconvenio::varchar FROM ctb102016 ";
          $sSqlVerifica .= " WHERE si95_codorgao::int = $oRegistro10->si09_codorgaotce 
                               AND si95_banco = '$oRegistro10->c63_banco'
                               AND si95_agencia = '$oRegistro10->c63_agencia' 
                               AND si95_digitoverificadoragencia = '$oRegistro10->c63_dvagencia' 
                               AND si95_contabancaria = '$oRegistro10->c63_conta'
                               AND si95_digitoverificadorcontabancaria = '$oRegistro10->c63_dvconta' 
                               AND si95_tipoconta::int = $oRegistro10->tipoconta 
                               AND si95_instit = " . db_getsession('DB_instit');
          $sSqlVerifica .= " UNION ";
          $sSqlVerifica .= " SELECT 'ctb102015' AS ano, si95_codctb, si95_nroconvenio::varchar FROM ctb102015 ";
          $sSqlVerifica .= " WHERE si95_codorgao::int = $oRegistro10->si09_codorgaotce 
                               AND si95_banco = '$oRegistro10->c63_banco'
                               AND si95_agencia = '$oRegistro10->c63_agencia' 
                               AND si95_digitoverificadoragencia = '$oRegistro10->c63_dvagencia' 
                               AND si95_contabancaria = '$oRegistro10->c63_conta' 
                               AND si95_digitoverificadorcontabancaria = '$oRegistro10->c63_dvconta' 
                               AND si95_tipoconta::int = $oRegistro10->tipoconta 
                               AND si95_instit = " . db_getsession('DB_instit');
          $sSqlVerifica .= " UNION ";
          $sSqlVerifica .= " SELECT 'ctb102014' AS ano, si95_codctb, si95_nroconvenio::varchar FROM ctb102014 ";
          $sSqlVerifica .= " WHERE si95_codorgao::int = '$oRegistro10->si09_codorgaotce' 
                               AND si95_banco = '$oRegistro10->c63_banco' 
                               AND si95_agencia = '$oRegistro10->c63_agencia' 
                               AND si95_digitoverificadoragencia = '$oRegistro10->c63_dvagencia' 
                               AND si95_contabancaria = '$oRegistro10->c63_conta' 
                               AND si95_digitoverificadorcontabancaria = '$oRegistro10->c63_dvconta' 
                               AND si95_tipoconta::int = $oRegistro10->tipoconta 
                               AND si95_instit = " . db_getsession('DB_instit');

          $rsResultVerifica = db_query($sSqlVerifica);

          /**
          * Adicionada consulta abaixo para verificação da data de cadastro da conta
          **/
          $sSqlDtCad = "SELECT k13_dtimplantacao,
                               si09_codorgaotce,
                               CASE
                                   WHEN c61_codtce = 0 OR c61_codtce IS NULL THEN c61_reduz
                                   ELSE c61_codtce
                               END AS codctb
                        FROM conplanoconta 
                        JOIN conplanoreduz ON (c61_codcon, c61_anousu) = (c63_codcon, c63_anousu) 
                        JOIN saltes ON (k13_reduz) = (c61_reduz)
                        LEFT JOIN infocomplementaresinstit on si09_instit = c61_instit 
                        WHERE si09_codorgaotce = $oRegistro10->si09_codorgaotce 
                          AND c63_banco = '$oRegistro10->c63_banco'
                          AND c63_agencia = '$oRegistro10->c63_agencia' 
                          AND c63_dvagencia = '$oRegistro10->c63_dvagencia' 
                          AND c63_conta = '$oRegistro10->c63_conta'
                          AND c63_dvconta = '$oRegistro10->c63_dvconta' 
                          AND (($oRegistro10->tipoconta IN (2,3) AND c63_tipoconta IN (2,3)) OR ($oRegistro10->tipoconta = 1 AND c63_tipoconta = 1))
                          AND c61_instit = " . db_getsession('DB_instit') ."
                          AND c61_anousu = " . db_getsession('DB_anousu');

          $rsResultDtCad = db_query($sSqlDtCad);
          $oDtCadastro = db_utils::fieldsMemory($rsResultDtCad, 0);

          /*
           * condição adicionada para criar um registro das contas bancaria de aplicação que foram alteradas o tipo de aplicação no MES de 01/2018
           * a tabela acertactb será preenchida pelo menu CONTABILAIDE > PROCEDIMENTOS > DUPLICAR CTB
           */
          if (pg_num_rows($rsResultVerifica) != 0 && (db_getsession("DB_anousu") == 2018 && $this->sDataFinal['5'] . $this->sDataFinal['6'] == 1)) {

              $sql = "select * from  acertactb where si95_reduz =".$oRegistro10->codctb ;
              $rsCtb = db_query($sql);
              if (pg_num_rows($rsCtb) != 0) {
                  $cCtb10->si95_codctb = $oRegistro10->codctb;
                  $cCtb10->incluir(null);
                  if ($cCtb10->erro_status == 0) {
                      throw new Exception($cCtb10->erro_msg);
                  }
              }

          /*
           * Verificação se a data de cadastro da conta está dentro do período de geração do arquivo.
           * */

          } elseif ((pg_num_rows($rsResultVerifica) == 0) && ($oDtCadastro->k13_dtimplantacao <= $this->sDataFinal)) {

                  $cCtb10->incluir(null);

                  if ($cCtb10->erro_status == 0) {
                      throw new Exception($cCtb10->erro_msg);
                  }
          }

          $cCtb10->si95_codctb = $oRegistro10->codtce != 0 ? $oRegistro10->codtce : $oRegistro10->codctb;
          $sql = "select * from  acertactb where si95_reduz =".$oRegistro10->codctb ;
          $rsCtb = db_query($sql);
          if (pg_num_rows($rsCtb) != 0 && (db_getsession("DB_anousu") == 2018 && $this->sDataFinal['5'] . $this->sDataFinal['6'] != 1)) {
              $cCtb10->si95_codctb = $oRegistro10->codctb;
          }
          $oConta = new stdClass();
		  $oConta->codctb 	= $oRegistro10->codctb;
		  $oConta->recurso 	= in_array($oRegistro10->recurso, $this->aFontesEncerradas) ? substr($oRegistro10->recurso, 0, 1).'59' : $oRegistro10->recurso;

		  $cCtb10->contas[] = $oConta;
          $aBancosAgrupados[$aHash] = $cCtb10;

        } else {			
			$oConta = new stdClass();
			$oConta->codctb 	= $oRegistro10->codctb;
			$oConta->recurso 	= $aBancosAgrupados[$aHash]->contas[0]->recurso;

			$aBancosAgrupados[$aHash]->contas[] = $oConta;
        }


      } else {
        /*
         * FALTA AGRUPA AS CONTAS QUANDO A INSTIUICAO FOR IGUAL A 5 RPPS
         */
      }

    }
	
	$aCtb20Agrupado = array();

    foreach ($aBancosAgrupados as $oContaAgrupada) {

      	$nMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

		$oCtb20FontRec = new stdClass();
		foreach ($oContaAgrupada->contas as $oConta) {


        	$sSql20Fonte = "select distinct codctb, fontemovimento from (
									select c61_reduz  as codctb, o15_codtri  as fontemovimento
									  from conplano
								inner join conplanoreduz on conplanoreduz.c61_codcon = conplano.c60_codcon and conplanoreduz.c61_anousu = conplano.c60_anousu
								inner join orctiporec on o15_codigo = c61_codigo
									 where conplanoreduz.c61_reduz  in ({$oConta->codctb})
									   and conplanoreduz.c61_anousu = " . db_getsession("DB_anousu") . "
								 union all
								select c61_reduz  as codctb, ces02_fonte::varchar  as fontemovimento
									  from conctbsaldo
								inner join conplanoreduz on conctbsaldo.ces02_reduz = conplanoreduz.c61_reduz and conplanoreduz.c61_anousu = conctbsaldo.ces02_anousu
								inner join orctiporec on o15_codigo = c61_codigo
									 where conctbsaldo.ces02_reduz  in ({$oConta->codctb})
									   and conctbsaldo.ces02_anousu = " . db_getsession("DB_anousu") . "
								 union all
								select contacredito.c61_reduz as codctb,
									   case when c71_coddoc in (5,35,37,6,36,38) then fontempenho.o15_codtri
											when c71_coddoc in (100,101,115,116) then fontereceita.o15_codtri
											when c71_coddoc in (140,141) then contadebitofonte.o15_codtri
											else  contacreditofonte.o15_codtri
										end as fontemovimento
								  from conlancamdoc
							inner join conlancamval on conlancamval.c69_codlan  = conlancamdoc.c71_codlan
							inner join conplanoreduz contadebito on  contadebito.c61_reduz = conlancamval.c69_debito and contadebito.c61_anousu = conlancamval.c69_anousu
							inner join conplanoreduz contacredito on  contacredito.c61_reduz = conlancamval.c69_credito and contacredito.c61_anousu = conlancamval.c69_anousu
							 left join conlancamemp on conlancamemp.c75_codlan = conlancamdoc.c71_codlan
							 left join empempenho on empempenho.e60_numemp = conlancamemp.c75_numemp
							 left join orcdotacao on orcdotacao.o58_anousu = empempenho.e60_anousu and orcdotacao.o58_coddot = empempenho.e60_coddot
							 left join orctiporec fontempenho on fontempenho.o15_codigo = orcdotacao.o58_codigo
							 left join orctiporec contacreditofonte on contacreditofonte.o15_codigo = contacredito.c61_codigo
							 left join orctiporec contadebitofonte on contadebitofonte.o15_codigo = contadebito.c61_codigo
							 left join conlancamrec on conlancamrec.c74_codlan = conlancamdoc.c71_codlan
							 left join orcreceita on orcreceita.o70_codrec = conlancamrec.c74_codrec and orcreceita.o70_anousu = conlancamrec.c74_anousu
							 left join orcfontes receita on receita.o57_codfon  = orcreceita.o70_codfon  and receita.o57_anousu  = orcreceita.o70_anousu
							 left join orctiporec fontereceita on fontereceita.o15_codigo = orcreceita.o70_codigo
								 where DATE_PART('YEAR',conlancamdoc.c71_data) = " . db_getsession("DB_anousu") . "
								   and DATE_PART('MONTH',conlancamdoc.c71_data) <= " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
								   and conlancamval.c69_credito in ({$oConta->codctb})
							 union all
								select contadebito.c61_reduz as codctb,
									   case when c71_coddoc in (5,35,37,6,36,38) then fontempenho.o15_codtri
											when c71_coddoc in (100,101,115,116) then fontereceita.o15_codtri
											when c71_coddoc in (140,141) then contacreditofonte.o15_codtri
											else  contadebitofonte.o15_codtri
									   end as fontemovimento
								  from conlancamdoc
							inner join conlancamval on conlancamval.c69_codlan  = conlancamdoc.c71_codlan
							inner join conplanoreduz contadebito on  contadebito.c61_reduz = conlancamval.c69_debito and contadebito.c61_anousu = conlancamval.c69_anousu
							inner join conplanoreduz contacredito on  contacredito.c61_reduz = conlancamval.c69_credito and contacredito.c61_anousu = conlancamval.c69_anousu
							 left join conlancamemp on conlancamemp.c75_codlan = conlancamdoc.c71_codlan
							 left join empempenho on empempenho.e60_numemp = conlancamemp.c75_numemp
							 left join orcdotacao on orcdotacao.o58_anousu = empempenho.e60_anousu and orcdotacao.o58_coddot = empempenho.e60_coddot
							 left join orctiporec fontempenho on fontempenho.o15_codigo = orcdotacao.o58_codigo
							 left join orctiporec contacreditofonte on contacreditofonte.o15_codigo = contacredito.c61_codigo
							 left join orctiporec contadebitofonte on contadebitofonte.o15_codigo = contadebito.c61_codigo
							 left join conlancamrec on conlancamrec.c74_codlan = conlancamdoc.c71_codlan
							 left join orcreceita on orcreceita.o70_codrec = conlancamrec.c74_codrec and orcreceita.o70_anousu = conlancamrec.c74_anousu
							 left join orcfontes receita on receita.o57_codfon  = orcreceita.o70_codfon  and receita.o57_anousu  = orcreceita.o70_anousu
							 left join orctiporec fontereceita on fontereceita.o15_codigo = orcreceita.o70_codigo
								 where DATE_PART('YEAR',conlancamdoc.c71_data) = " . db_getsession("DB_anousu") . "
								   and DATE_PART('MONTH',conlancamdoc.c71_data) <= " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
								   and conlancamval.c69_debito in ({$oConta->codctb})
                union all 
              select ces02_reduz,ces02_fonte::varchar from conctbsaldo where ces02_reduz in ({$oConta->codctb}) and ces02_anousu = " . db_getsession("DB_anousu") . "
							) as xx";
        	$rsReg20Fonte = db_query($sSql20Fonte) or die($sSql20Fonte);//db_criatabela($rsReg20Fonte);


        	for ($iCont20 = 0; $iCont20 < pg_num_rows($rsReg20Fonte); $iCont20++) {

				/* DADOS REGISTRO 20*/
				$iFonte = db_utils::fieldsMemory($rsReg20Fonte, $iCont20)->fontemovimento;


				$sSqlMov = "select
					round(substr(fc_saldoctbfonte(" . db_getsession("DB_anousu") . ",$oConta->codctb,'" . $iFonte . "'," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),29,15)::float8,2)::float8 as saldo_anterior,
					round(substr(fc_saldoctbfonte(" . db_getsession("DB_anousu") . ",$oConta->codctb,'" . $iFonte . "'," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),43,15)::float8,2)::float8 as debitomes,
					round(substr(fc_saldoctbfonte(" . db_getsession("DB_anousu") . ",$oConta->codctb,'" . $iFonte . "'," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),57,15)::float8,2)::float8 as creditomes,
					round(substr(fc_saldoctbfonte(" . db_getsession("DB_anousu") . ",$oConta->codctb,'" . $iFonte . "'," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),72,15)::float8,2)::float8 as saldo_final,
					substr(fc_saldoctbfonte(" . db_getsession("DB_anousu") . ",$oConta->codctb,'" . $iFonte . "'," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),87,1)::varchar(1) as  sinalanterior,
					substr(fc_saldoctbfonte(" . db_getsession("DB_anousu") . ",$oConta->codctb,'" . $iFonte . "'," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),89,1)::varchar(1) as  sinalfinal ";
				$rsTotalMov = db_query($sSqlMov) or die($sSqlMov);
				//db_criatabela($rsTotalMov);
				//echo $sSqlMov;
				$oTotalMov = db_utils::fieldsMemory($rsTotalMov);

				//OC11537
				$bFonteEncerrada  = in_array($iFonte, $this->aFontesEncerradas);
				$bCorrecaoFonte   = ($bFonteEncerrada && $nMes == '01' && db_getsession("DB_anousu") == 2020);

          		$iFonte2 = $bFonteEncerrada ? substr($iFonte, 0, 1).'59' : $iFonte;

          		$sHash20 = $bCorrecaoFonte ? $oContaAgrupada->si95_codctb . $iFonte : $oContaAgrupada->si95_codctb . $iFonte2;
				if (!$aCtb20Agrupado[$sHash20]) {

					$oCtb20 = new stdClass();
					$oCtb20->si96_tiporegistro = '20';
					$oCtb20->si96_codorgao = $oContaAgrupada->si95_codorgao;
					$oCtb20->si96_codctb = $oContaAgrupada->si95_codctb;
					//Modificação para de/para das fontes encerradas tratadas na OC11537
					if ($bFonteEncerrada && $nMes != '01' && db_getsession("DB_anousu") == 2020) {
						$oCtb20->si96_codfontrecursos = $iFonte2;
					} elseif ($bFonteEncerrada && db_getsession("DB_anousu") > 2020) {
						$oCtb20->si96_codfontrecursos = $iFonte2;
					} else {
						$oCtb20->si96_codfontrecursos = $iFonte;
					}
					$oCtb20->si96_vlsaldoinicialfonte = $oTotalMov->sinalanterior == 'C' ? $oTotalMov->saldo_anterior * -1 : $oTotalMov->saldo_anterior;
					$oCtb20->si96_vlsaldofinalfonte = ($bFonteEncerrada && $bCorrecaoFonte) ? 0 : ($oTotalMov->sinalfinal == 'C' ? $oTotalMov->saldo_final * -1 : $oTotalMov->saldo_final);
					$oCtb20->si96_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
					$oCtb20->si96_instit = db_getsession("DB_instit");
					$oCtb20->iFontePrincipal = $oConta->recurso;
					$oCtb20->ext21 = array();
					$aCtb20Agrupado[$sHash20] = $oCtb20;

				} else {
					$oCtb20 = $aCtb20Agrupado[$sHash20];
					$oCtb20->si96_vlsaldoinicialfonte += ($bFonteEncerrada && $bCorrecaoFonte) ? 0 : ($oTotalMov->sinalanterior == 'C' ? $oTotalMov->saldo_anterior * -1 : $oTotalMov->saldo_anterior);
					$oCtb20->si96_vlsaldofinalfonte += $oTotalMov->sinalfinal == 'C' ? $oTotalMov->saldo_final * -1 : $oTotalMov->saldo_final;
				}

				//Cria registros 20 e 21 de para OC11537
				if($bFonteEncerrada && $bCorrecaoFonte) {

					$sHash20  = $oContaAgrupada->si95_codctb . $iFonte2;
					$shash20b = $oContaAgrupada->si95_codctb . $iFonte;

					if (!$aCtb20Agrupado[$sHash20]) {

						$oCtb20 = new stdClass();
						$oCtb20->si96_tiporegistro = '20';
						$oCtb20->si96_codorgao = $oContaAgrupada->si95_codorgao;
						$oCtb20->si96_codctb = $oContaAgrupada->si95_codctb;
						$oCtb20->si96_codfontrecursos = $iFonte2;
						$oCtb20->si96_vlsaldoinicialfonte = 0;
						$oCtb20->si96_vlsaldofinalfonte = $oTotalMov->sinalfinal == 'C' ? $oTotalMov->saldo_final * -1 : $oTotalMov->saldo_final;
						$oCtb20->si96_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
						$oCtb20->si96_instit = db_getsession("DB_instit");
						$oCtb20->ext21 = array();
						$aCtb20Agrupado[$sHash20] = $oCtb20;

					} else {
						$oCtb20 = $aCtb20Agrupado[$sHash20];
						$oCtb20->si96_vlsaldofinalfonte += $oTotalMov->sinalfinal == 'C' ? $oTotalMov->saldo_final * -1 : $oTotalMov->saldo_final;
					}

					if ($oTotalMov->sinalanterior == 'D' && $oTotalMov->saldo_anterior != 0) {

						$sHash21a = $oContaAgrupada->si95_codctb . $iFonte2 . '01';

						if (!$aCtb20Agrupado[$sHash20]->ext21[$sHash21a]) {

							$oDadosMovi21 = new stdClass();
							$oDadosMovi21->si97_tiporegistro = '21';
							$oDadosMovi21->si97_codctb = $oContaAgrupada->si95_codctb;
							$oDadosMovi21->si97_codfontrecursos = $iFonte2;
							$oDadosMovi21->si97_codreduzidomov = $oContaAgrupada->si95_codctb . $iFonte . 1;
							$oDadosMovi21->si97_tipomovimentacao = 1;
							$oDadosMovi21->si97_tipoentrsaida = '98';
							$oDadosMovi21->si97_dscoutrasmov = ' ';
							$oDadosMovi21->si97_valorentrsaida = $oTotalMov->saldo_anterior;
							$oDadosMovi21->si97_codctbtransf = ' ';
							$oDadosMovi21->si97_codfontectbtransf = ' ';
							$oDadosMovi21->si97_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
							$oDadosMovi21->si97_instit = db_getsession("DB_instit");
							$oDadosMovi21->registro22 = array();

									$aCtb20Agrupado[$sHash20]->ext21[$sHash21a] = $oDadosMovi21;

						} else {
								$aCtb20Agrupado[$sHash20]->ext21[$sHash21a]->si97_valorentrsaida += $oTotalMov->saldo_anterior;
						}

						$sHash21b = $oContaAgrupada->si95_codctb . $iFonte . '02';

						if (!$aCtb20Agrupado[$shash20b]->ext21[$sHash21b]) {

							$oDadosMovi21 = new stdClass();
							$oDadosMovi21->si97_tiporegistro = '21';
							$oDadosMovi21->si97_codctb = $oContaAgrupada->si95_codctb;
							$oDadosMovi21->si97_codfontrecursos = $iFonte;
							$oDadosMovi21->si97_codreduzidomov = $oContaAgrupada->si95_codctb . $iFonte . 2;
							$oDadosMovi21->si97_tipomovimentacao = 2;
							$oDadosMovi21->si97_tipoentrsaida = '98';
							$oDadosMovi21->si97_dscoutrasmov = ' ';
							$oDadosMovi21->si97_valorentrsaida = $oTotalMov->saldo_anterior;
							$oDadosMovi21->si97_codctbtransf = ' ';
							$oDadosMovi21->si97_codfontectbtransf = ' ';
							$oDadosMovi21->si97_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
							$oDadosMovi21->si97_instit = db_getsession("DB_instit");
							$oDadosMovi21->registro22 = array();

							$aCtb20Agrupado[$shash20b]->ext21[$sHash21b] = $oDadosMovi21;

						} else {
								$aCtb20Agrupado[$shash20b]->ext21[$sHash21b]->si97_valorentrsaida += $oTotalMov->saldo_anterior;
						}

					} elseif ($oTotalMov->saldo_anterior != 0) {

						$sHash21c = $oContaAgrupada->si95_codctb . $iFonte2 . '02';

						if (!$aCtb20Agrupado[$sHash20]->ext21[$sHash21c]) {

							$oDadosMovi21 = new stdClass();
							$oDadosMovi21->si97_tiporegistro = '21';
							$oDadosMovi21->si97_codctb = $oContaAgrupada->si95_codctb;
							$oDadosMovi21->si97_codfontrecursos = $iFonte2;
							$oDadosMovi21->si97_codreduzidomov = $oContaAgrupada->si95_codctb . $iFonte . 2;
							$oDadosMovi21->si97_tipomovimentacao = 2;
							$oDadosMovi21->si97_tipoentrsaida = '98';
							$oDadosMovi21->si97_dscoutrasmov = ' ';
							$oDadosMovi21->si97_valorentrsaida = $oTotalMov->saldo_anterior * -1;
							$oDadosMovi21->si97_codctbtransf = ' ';
							$oDadosMovi21->si97_codfontectbtransf = ' ';
							$oDadosMovi21->si97_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
							$oDadosMovi21->si97_instit = db_getsession("DB_instit");
							$oDadosMovi21->registro22 = array();

									$aCtb20Agrupado[$sHash20]->ext21[$sHash21c] = $oDadosMovi21;

						} else {
									$aCtb20Agrupado[$sHash20]->ext21[$sHash21c]->si97_valorentrsaida += $oTotalMov->saldo_anterior * -1;
						}

						$sHash21d = $oContaAgrupada->si95_codctb . $iFonte . '01';

						if (!$aCtb20Agrupado[$shash20b]->ext21[$sHash21d]) {

							$oDadosMovi21 = new stdClass();
							$oDadosMovi21->si97_tiporegistro = '21';
							$oDadosMovi21->si97_codctb = $oContaAgrupada->si95_codctb;
							$oDadosMovi21->si97_codfontrecursos = $iFonte;
							$oDadosMovi21->si97_codreduzidomov = $oContaAgrupada->si95_codctb . $iFonte . 1;
							$oDadosMovi21->si97_tipomovimentacao = 1;
							$oDadosMovi21->si97_tipoentrsaida = '98';
							$oDadosMovi21->si97_dscoutrasmov = ' ';
							$oDadosMovi21->si97_valorentrsaida = $oTotalMov->saldo_anterior * -1;
							$oDadosMovi21->si97_codctbtransf = ' ';
							$oDadosMovi21->si97_codfontectbtransf = ' ';
							$oDadosMovi21->si97_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
							$oDadosMovi21->si97_instit = db_getsession("DB_instit");
							$oDadosMovi21->registro22 = array();

							$aCtb20Agrupado[$shash20b]->ext21[$sHash21d] = $oDadosMovi21;

						} else {
									$aCtb20Agrupado[$shash20b]->ext21[$sHash21d]->si97_valorentrsaida += $oTotalMov->saldo_anterior * -1;
						}

					}

				}

				$sSqlReg21 = "SELECT * FROM
								(SELECT '21' AS tiporegistro,
										c71_codlan AS codreduzido,
										contacredito.c61_reduz AS codctb,
										contacreditofonte.o15_codtri AS codfontrecurso,
										2 AS tipomovimentacao,
										(bancodebito.c63_conta||bancodebito.c63_dvconta)AS bancodebito_c63_conta,
										bancodebito.c63_tipoconta AS bancodebito_c63_tipoconta,
										(bancocredito.c63_conta||bancocredito.c63_dvconta) AS bancocredito_c63_conta,
										bancocredito.c63_tipoconta AS bancocredito_c63_tipoconta,       
										CASE
											WHEN c71_coddoc IN (101, 116)
												AND substr(o57_fonte,0,3) = '49' THEN 2
											WHEN c71_coddoc = 101 THEN 3
											WHEN c71_coddoc IN (35, 37)
												AND (SELECT sum(CASE
																	WHEN c53_tipo = 31 THEN -1 * c70_valor
																	ELSE c70_valor
																END) AS valor
													FROM conlancamdoc
													JOIN conhistdoc ON c53_coddoc = c71_coddoc
													JOIN conlancamord ON c71_codlan = c80_codlan
													JOIN conlancam ON c70_codlan = c71_codlan
													WHERE c53_tipo IN (31, 30)
														AND c70_data <= '" . $this->sDataFinal . "'
														AND c80_codord = (SELECT c80_codord FROM conlancamord
																			WHERE c80_codlan=c69_codlan
																			LIMIT 1)) >= 0 
											OR c71_coddoc = 5
												AND (SELECT sum(CASE
																	WHEN c53_tipo = 31 THEN -1 * c70_valor
																	ELSE c70_valor
																END) AS valor
													FROM conlancamdoc
													JOIN conhistdoc ON c53_coddoc = c71_coddoc
													JOIN conlancamord ON c71_codlan = c80_codlan
													JOIN conlancam ON c70_codlan = c71_codlan
													WHERE c53_tipo IN (31, 30)
														AND c70_data <= '" . $this->sDataFinal . "'
														AND c80_codord = (SELECT c80_codord FROM conlancamord
																			WHERE c80_codlan=c69_codlan
																			LIMIT 1)) >= 0 THEN 8
											WHEN c71_coddoc IN (151, 161, 163)
												AND (SELECT k17_situacao FROM slip
													JOIN conlancamslip ON k17_codigo = c84_slip
													JOIN conlancamdoc ON c71_codlan = c84_conlancam
													WHERE c71_codlan=c69_codlan
														AND c71_coddoc IN (151, 161, 163)
													LIMIT 1) in (2, 4) THEN 8
											WHEN c71_coddoc IN (131, 152, 162) THEN 10
											WHEN c71_coddoc IN (120)
												AND (SELECT k17_situacao FROM slip
													JOIN conlancamslip ON k17_codigo = c84_slip
													JOIN conlancamdoc ON c71_codlan = c84_conlancam
													WHERE c71_codlan=c69_codlan
														AND c71_coddoc IN (120)
													LIMIT 1) = 2 THEN 13
											WHEN c71_coddoc IN (141, 140) AND bancodebito.c63_tipoconta = 1 AND bancocredito.c63_tipoconta IN (2, 3) THEN 7
											WHEN c71_coddoc IN (141, 140) AND bancodebito.c63_tipoconta IN (2, 3) AND bancocredito.c63_tipoconta = 1 THEN 9
											WHEN c71_coddoc IN (141, 140) THEN 6
											ELSE 99
										END AS tipoentrsaida,
										substr(o57_fonte,0,3) AS rubrica,
										conlancamval.c69_valor AS valorentrsaida,
										CASE
											WHEN c71_coddoc IN (140, 141) THEN contadebito.c61_reduz
											ELSE 0
										END AS codctbtransf,
										CASE
											WHEN c71_coddoc IN (140, 141) THEN contacreditofonte.o15_codtri
											ELSE '0'
										END AS codfontectbtransf,
										c71_coddoc,
										c71_codlan,
										CASE
											WHEN c71_coddoc IN (5, 35, 37, 6, 36, 38) THEN fontempenho.o15_codtri
											WHEN c71_coddoc IN (100, 101, 115, 116) THEN fontereceita.o15_codtri
											ELSE contacreditofonte.o15_codtri
										END AS fontemovimento,
										CASE
											WHEN c72_complem ILIKE 'Referente%'
												AND c71_coddoc IN (5,35,37,6,36,38) THEN 1
											ELSE 0
										END AS retencao
								FROM conlancamdoc
								INNER JOIN conlancamval ON conlancamval.c69_codlan = conlancamdoc.c71_codlan
								INNER JOIN conplanoreduz contadebito ON contadebito.c61_reduz = conlancamval.c69_debito AND contadebito.c61_anousu = conlancamval.c69_anousu
								LEFT JOIN conplanoconta bancodebito ON (bancodebito.c63_codcon, bancodebito.c63_anousu) = (contadebito.c61_codcon, contadebito.c61_anousu)
								AND contadebito.c61_reduz = conlancamval.c69_debito
								INNER JOIN conplanoreduz contacredito ON contacredito.c61_reduz = conlancamval.c69_credito AND contacredito.c61_anousu = conlancamval.c69_anousu
								LEFT JOIN conplanoconta bancocredito ON (bancocredito.c63_codcon, bancocredito.c63_anousu) = (contacredito.c61_codcon, contacredito.c61_anousu)
								AND contacredito.c61_reduz = conlancamval.c69_credito
								LEFT JOIN conlancamemp ON conlancamemp.c75_codlan = conlancamdoc.c71_codlan
								LEFT JOIN empempenho ON empempenho.e60_numemp = conlancamemp.c75_numemp
								LEFT JOIN orcdotacao ON orcdotacao.o58_anousu = empempenho.e60_anousu AND orcdotacao.o58_coddot = empempenho.e60_coddot
								LEFT JOIN orctiporec fontempenho ON fontempenho.o15_codigo = orcdotacao.o58_codigo
								LEFT JOIN orctiporec contacreditofonte ON contacreditofonte.o15_codigo = contacredito.c61_codigo
								LEFT JOIN orctiporec contadebitofonte ON contadebitofonte.o15_codigo = contadebito.c61_codigo
								LEFT JOIN conlancamrec ON conlancamrec.c74_codlan = conlancamdoc.c71_codlan
								LEFT JOIN orcreceita ON orcreceita.o70_codrec = conlancamrec.c74_codrec AND orcreceita.o70_anousu = conlancamrec.c74_anousu
								LEFT JOIN orcfontes receita ON receita.o57_codfon = orcreceita.o70_codfon AND receita.o57_anousu = orcreceita.o70_anousu
								LEFT JOIN orctiporec fontereceita ON fontereceita.o15_codigo = orcreceita.o70_codigo
								LEFT JOIN conlancamcompl ON c72_codlan = c71_codlan
								WHERE DATE_PART('YEAR',conlancamdoc.c71_data) = " . db_getsession("DB_anousu") . "
								AND DATE_PART('MONTH',conlancamdoc.c71_data) = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
								AND conlancamval.c69_credito = {$oConta->codctb}
								UNION ALL
								SELECT '21' AS tiporegistro,
										c71_codlan AS codreduzido,
										contadebito.c61_reduz AS codctb,
										contadebitofonte.o15_codtri AS codfontrecurso,
										1 AS tipomovimentacao,
										(bancodebito.c63_conta||bancodebito.c63_dvconta) AS bancodebito_c63_conta,
										bancodebito.c63_tipoconta AS bancodebito_c63_tipoconta,
										(bancocredito.c63_conta||bancocredito.c63_dvconta) AS bancocredito_c63_conta,
										bancocredito.c63_tipoconta AS bancocredito_c63_tipoconta,
										CASE
											WHEN c71_coddoc IN (100, 115)
												AND substr(o57_fonte,0,3) = '49' THEN 16
											WHEN c71_coddoc = 100 AND substr(o57_fonte,2,4) = '1321' AND bancodebito.c63_tipoconta IN (2, 3) THEN 4
											WHEN c71_coddoc = 100 THEN 1
											WHEN c71_coddoc IN (6,36,38,121,153,163) THEN 17
											WHEN c71_coddoc IN (131,152,162) THEN 10
											WHEN c71_coddoc IN (130) THEN 12
											WHEN c71_coddoc IN (141, 140) AND bancodebito.c63_tipoconta = 1 AND bancocredito.c63_tipoconta IN (2, 3) THEN 7
											WHEN c71_coddoc IN (141, 140) AND bancodebito.c63_tipoconta IN (2, 3) AND bancocredito.c63_tipoconta = 1 THEN 9
											WHEN c71_coddoc IN (141, 140) THEN 5
											ELSE 99
										END AS tipoentrsaida,
										substr(o57_fonte,0,3) AS rubrica,
										conlancamval.c69_valor AS valorentrsaida,
										CASE
											WHEN c71_coddoc IN (140, 141) THEN contacredito.c61_reduz
											ELSE 0
										END AS codctbtransf,
										CASE
											WHEN c71_coddoc IN (140, 141) THEN contacreditofonte.o15_codtri
											ELSE '0'
										END AS codfontectbtransf,
										c71_coddoc,
										c71_codlan,
										CASE
											WHEN c71_coddoc IN (5, 35, 37, 6, 36, 38) THEN fontempenho.o15_codtri
											WHEN c71_coddoc IN (100, 101, 115, 116) THEN fontereceita.o15_codtri
											WHEN c71_coddoc IN (140, 141) THEN contacreditofonte.o15_codtri
											ELSE contadebitofonte.o15_codtri
										END AS fontemovimento,
										CASE
											WHEN c72_complem ILIKE 'Referente%'
												AND c71_coddoc IN (5,35,37,6,36,38) THEN 1
											ELSE 0
										END AS retencao
								FROM conlancamdoc
								INNER JOIN conlancamval ON conlancamval.c69_codlan = conlancamdoc.c71_codlan
								INNER JOIN conplanoreduz contadebito ON contadebito.c61_reduz = conlancamval.c69_debito AND contadebito.c61_anousu = conlancamval.c69_anousu
								LEFT JOIN conplanoconta bancodebito ON (bancodebito.c63_codcon, bancodebito.c63_anousu) = (contadebito.c61_codcon, contadebito.c61_anousu)
								AND contadebito.c61_reduz = conlancamval.c69_debito
								INNER JOIN conplanoreduz contacredito ON contacredito.c61_reduz = conlancamval.c69_credito AND contacredito.c61_anousu = conlancamval.c69_anousu
								LEFT JOIN conplanoconta bancocredito ON (bancocredito.c63_codcon, bancocredito.c63_anousu) = (contacredito.c61_codcon, contacredito.c61_anousu)
								AND contacredito.c61_reduz = conlancamval.c69_credito
								LEFT JOIN conlancamemp ON conlancamemp.c75_codlan = conlancamdoc.c71_codlan
								LEFT JOIN empempenho ON empempenho.e60_numemp = conlancamemp.c75_numemp
								LEFT JOIN orcdotacao ON orcdotacao.o58_anousu = empempenho.e60_anousu AND orcdotacao.o58_coddot = empempenho.e60_coddot
								LEFT JOIN orctiporec fontempenho ON fontempenho.o15_codigo = orcdotacao.o58_codigo
								LEFT JOIN orctiporec contacreditofonte ON contacreditofonte.o15_codigo = contacredito.c61_codigo
								LEFT JOIN orctiporec contadebitofonte ON contadebitofonte.o15_codigo = contadebito.c61_codigo
								LEFT JOIN conlancamrec ON conlancamrec.c74_codlan = conlancamdoc.c71_codlan
								LEFT JOIN orcreceita ON orcreceita.o70_codrec = conlancamrec.c74_codrec AND orcreceita.o70_anousu = conlancamrec.c74_anousu
								LEFT JOIN orcfontes receita ON receita.o57_codfon = orcreceita.o70_codfon AND receita.o57_anousu = orcreceita.o70_anousu
								LEFT JOIN orctiporec fontereceita ON fontereceita.o15_codigo = orcreceita.o70_codigo
								LEFT JOIN conlancamcompl ON c72_codlan = c71_codlan WHERE DATE_PART('YEAR',conlancamdoc.c71_data) = " . db_getsession("DB_anousu") . " 
									AND DATE_PART('MONTH',conlancamdoc.c71_data) = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " AND conlancamval.c69_debito = {$oConta->codctb} ) AS xx
							WHERE fontemovimento::integer = $iFonte";

				$rsMovi21 = db_query($sSqlReg21);


				if (pg_num_rows($rsMovi21) != 0) {

					for ($iCont21 = 0; $iCont21 < pg_num_rows($rsMovi21); $iCont21++) {

						$oMovi = db_utils::fieldsMemory($rsMovi21, $iCont21);


						$nValor = $oMovi->valorentrsaida;

						if ($oMovi->codctbtransf != 0 && $oMovi->codctbtransf != '') {
							$sqlcontatransf = "SELECT si09_codorgaotce||(c63_banco::integer)::varchar
													||(c63_agencia::integer)::varchar
													||c63_dvagencia
													||(c63_conta::integer)::varchar
													||c63_dvconta
													||CASE
															WHEN db83_tipoconta IN (2, 3) THEN 2
															ELSE 1
														END AS contadebito,
													c61_reduz,
													CASE
														WHEN db83_tipoconta IN (2, 3) THEN 2
														ELSE 1
													END AS tipo,
													o15_codtri
												FROM saltes
												JOIN conplanoreduz ON k13_reduz = c61_reduz AND c61_anousu = " . db_getsession("DB_anousu") . "
												JOIN conplanoconta ON c63_codcon = c61_codcon AND c63_anousu = c61_anousu
												JOIN orctiporec ON c61_codigo = o15_codigo
												LEFT JOIN conplanocontabancaria ON c56_codcon = c61_codcon AND c56_anousu = c61_anousu
												LEFT JOIN contabancaria ON c56_contabancaria = db83_sequencial
												LEFT JOIN infocomplementaresinstit ON si09_instit = c61_instit
												WHERE k13_reduz = {$oMovi->codctbtransf}";

							$rsConta = db_query($sqlcontatransf);
							//db_criatabela($rsConta);
							//echo $sqlcontatransf;

							if (pg_num_rows($rsConta) == 0) {
							$sSql = "select c60_codsis from saltes join conplanoreduz on k13_reduz = c61_reduz and c61_anousu = " . db_getsession("DB_anousu") . "
										join conplano on c60_codcon = c61_codcon and c60_anousu = c61_anousu where k13_reduz = {$oMovi->codctbtransf} ";
							$rsCodSis = db_query($sSql);
							/**
							 * se o c60_codsis for 5, essa é uma conta caixa
							 */
							$iCodSis = db_utils::fieldsMemory($rsCodSis, 0)->c60_codsis;
							} else {

							$contaTransf = db_utils::fieldsMemory($rsConta, 0)->contadebito;
							$conta = $aBancosAgrupados[$contaTransf]->si95_codctb;
							$recurso = $aBancosAgrupados[$contaTransf]->recurso;

							}


						} else {
							$conta = 0;
							$recurso = 0;
							$iCodSis = 0;
						}


						$sHash = $oMovi->tiporegistro;
						$sHash .= $oCtb20->si96_codctb;
						$sHash .= $oCtb20->si96_codfontrecursos;
						$sHash .= $oMovi->tipomovimentacao;
						/**
						 * quando o codctb for igual codctbtransf, será agrupado a movimentação no tipoentrsaida 99
						 */
						$sHash .= (($iCodSis == 5) || ($oCtb20->si96_codctb == $conta) || ($oMovi->retencao == 1 && $oMovi->tipoentrsaida == 8) ? '99' : $oMovi->tipoentrsaida);
						$sHash .= ((($oMovi->tipoentrsaida == 5 || $oMovi->tipoentrsaida == 6 || $oMovi->tipoentrsaida == 7 || $oMovi->tipoentrsaida == 9)
							&& ($iCodSis != 5) && ($oCtb20->si96_codctb != $conta)) ? $conta : 0);
						$sHash .= ((($oMovi->tipoentrsaida == 5 || $oMovi->tipoentrsaida == 6 || $oMovi->tipoentrsaida == 7 || $oMovi->tipoentrsaida == 9)
							&& ($iCodSis != 5) && ($oCtb20->si96_codctb != $conta)) ? $oMovi->codfontectbtransf : 0);


						if (!isset($oCtb20->ext21[$sHash])) {

							$oDadosMovi21 = new stdClass();

							$oDadosMovi21->si97_tiporegistro = $oMovi->tiporegistro;
							$oDadosMovi21->si97_codctb = $oCtb20->si96_codctb;
							$oDadosMovi21->si97_codfontrecursos = $oCtb20->si96_codfontrecursos;
							$oDadosMovi21->si97_codreduzidomov = $oCtb20->si96_codctb.$oMovi->codreduzido . "0" . $oMovi->tipomovimentacao;
							$oDadosMovi21->si97_tipomovimentacao = $oMovi->tipomovimentacao;
							$oDadosMovi21->si97_tipoentrsaida = (($iCodSis == 5) || ($oCtb20->si96_codctb == $conta) || ($oMovi->retencao == 1 && $oMovi->tipoentrsaida == 8)) ? '99' : $oMovi->tipoentrsaida;
							$oDadosMovi21->si97_dscoutrasmov = ($oMovi->tipoentrsaida == 99 ? 'Recebimento Extra-Orçamentário' : ' ');
							$oDadosMovi21->si97_valorentrsaida = $nValor;
							$oDadosMovi21->si97_codctbtransf = (($oDadosMovi21->si97_tipoentrsaida == 5 || $oDadosMovi21->si97_tipoentrsaida == 6 || $oDadosMovi21->si97_tipoentrsaida == 7 || $oDadosMovi21->si97_tipoentrsaida == 9)
							&& ($iCodSis != 5) && ($oCtb20->si96_codctb != $conta)) ? $conta : 0;
							$oDadosMovi21->si97_codfontectbtransf = (($oDadosMovi21->si97_tipoentrsaida == 5 || $oDadosMovi21->si97_tipoentrsaida == 6 || $oDadosMovi21->si97_tipoentrsaida == 7 || $oDadosMovi21->si97_tipoentrsaida == 9)
							&& ($iCodSis != 5) && ($oCtb20->si96_codctb != $conta)) ? $oMovi->codfontectbtransf : 0;
							$oDadosMovi21->si97_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
							$oDadosMovi21->si97_instit = db_getsession("DB_instit");
							$oDadosMovi21->registro22 = array();

							$oCtb20->ext21[$sHash] = $oDadosMovi21;

						} else {
							$oCtb20->ext21[$sHash]->si97_valorentrsaida += $nValor;
						}
						$sSql = " SELECT 22 AS tiporegistro,
										c74_codlan AS codreduzdio,
										CASE
											WHEN substr(o57_fonte,1,2) = '49' THEN 1
											ELSE 2
										END AS ededucaodereceita,
										CASE
											WHEN substr(o57_fonte,1,2) = '49' THEN substr(o57_fonte,2,2)
											ELSE NULL
										END AS identificadordeducao,
										CASE
											WHEN substr(o57_fonte,1,2) = '49' THEN substr(o57_fonte,4,8)
											ELSE substr(o57_fonte,2,8)
										END AS naturezaReceita,
										c70_valor AS vlrreceitacont
									FROM conlancamrec
									JOIN conlancam ON c70_codlan = c74_codlan AND c70_anousu = c74_anousu
									LEFT JOIN orcreceita ON c74_codrec = o70_codrec AND o70_anousu = " . db_getsession("DB_anousu") . "
									LEFT JOIN orcfontes ON o70_codfon = o57_codfon AND o70_anousu = o57_anousu
									LEFT JOIN orctiporec ON o15_codigo = o70_codigo 
									WHERE c74_codlan = {$oMovi->codreduzido}";

						$rsReceita = db_query($sSql);//echo $sSql;db_criatabela($rsReceita);
						$aTipoEntSaida = array('1', '2', '3', '4', '15', '16');
						if (pg_num_rows($rsReceita) != 0 && (in_array($oCtb20->ext21[$sHash]->si97_tipoentrsaida, $aTipoEntSaida))) {
							/*
							* SQL PARA PEGAR RECEITAS DOS TIPO ENTRA SAIDA 1 RECEITAS ARRECADADA NO MES
							*/

							$oRecita = db_utils::fieldsMemory($rsReceita, 0);

							$sNaturezaReceita = $oRecita->naturezareceita;
							foreach ($oNaturezaReceita as $oNatureza) {

							if ($oNatureza->getAttribute('instituicao') == db_getsession("DB_instit")
								&& $oNatureza->getAttribute('receitaEcidade') == $sNaturezaReceita
							) {
								$oRecita->naturezareceita = $oNatureza->getAttribute('receitaSicom');
								break;

							}

							}


							if (in_array(substr($oRecita->naturezareceita, 0, 6), $aRectce)) {
							$oRecita->naturezareceita = substr($oRecita->naturezareceita, 0, 6) . "00";
							}

							$sHash22 = $oRecita->naturezareceita . $oCtb20->ext21[$sHash]->si97_codreduzidomov;

							if (!isset($oCtb20->ext21[$sHash]->registro22[$sHash22])) {
							$oDadosReceita = new stdClass();

							$oDadosReceita->si98_tiporegistro = $oRecita->tiporegistro;
							$oDadosReceita->si98_codreduzidomov = $oCtb20->ext21[$sHash]->si97_codreduzidomov;
							$oDadosReceita->si98_ededucaodereceita = $oRecita->ededucaodereceita;
							$oDadosReceita->si98_identificadordeducao = $oRecita->identificadordeducao;
							$oDadosReceita->si98_naturezareceita = $oRecita->naturezareceita;
							$oDadosReceita->si98_codfontrecursos = $oCtb20->ext21[$sHash]->si97_codfontrecursos;
							$oDadosReceita->si98_vlrreceitacont = $oRecita->vlrreceitacont;
							$oDadosReceita->si98_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
							$oDadosReceita->si98_reg20 = 0;
							$oDadosReceita->si98_instit = db_getsession("DB_instit");


							$oCtb20->ext21[$sHash]->registro22[$sHash22] = $oDadosReceita;
							} else {
							$oCtb20->ext21[$sHash]->registro22[$sHash22]->si98_vlrreceitacont += $oRecita->vlrreceitacont;
							}

						}
					}

				}
			
				$aCtb20Agrupado[$sHash20] = $oCtb20;

			}

      	}

    }

    /*
     * REGISTRO 40 ALTERACAO DE CONTAS BANCARIAS
     */
    $rsCtasReg40 = db_query($sSqlGeral);

    if (pg_num_rows($rsCtasReg40) != 0) {

      for ($icont40 = 0; $icont40 < pg_num_rows($rsCtasReg40); $icont40++) {

        $oMovi40 = db_utils::fieldsMemory($rsCtasReg40, $icont40);

        /**
         * Adicionada consulta abaixo para verificação da data de cadastro da conta
         **/
        $sSqlDtCad = "SELECT k13_dtimplantacao,
                               si09_codorgaotce,
                               CASE
                                   WHEN c61_codtce = 0 OR c61_codtce IS NULL THEN c61_reduz
                                   ELSE c61_codtce
                               END AS codctb
                        FROM conplanoconta 
                        JOIN conplanoreduz ON (c61_codcon, c61_anousu) = (c63_codcon, c63_anousu) 
                        JOIN saltes ON (k13_reduz) = (c61_reduz)
                        LEFT JOIN infocomplementaresinstit on si09_instit = c61_instit 
                        WHERE si09_codorgaotce = $oMovi40->si09_codorgaotce
                          AND c63_banco = '$oMovi40->c63_banco'
                          AND c63_agencia = '$oMovi40->c63_agencia' 
                          AND c63_dvagencia = '$oMovi40->c63_dvagencia' 
                          AND c63_conta = '$oMovi40->c63_conta'
                          AND c63_dvconta = '$oMovi40->c63_dvconta' 
                          AND (($oMovi40->tipoconta IN (2,3) AND c63_tipoconta IN (2,3)) OR ($oMovi40->tipoconta = 1 AND c63_tipoconta = 1))
                          AND c61_instit = " . db_getsession('DB_instit') ."
                          AND c61_anousu = " . db_getsession('DB_anousu');

        $rsResultDtCad = db_query($sSqlDtCad);
        $oDtCad = db_utils::fieldsMemory($rsResultDtCad, 0);

        $sSqlVerifica = "SELECT 'ctb102020' AS ano, si95_codctb, si95_nroconvenio FROM ctb102020 ";
        $sSqlVerifica .= "WHERE si95_codorgao::int = $oMovi40->si09_codorgaotce 
                            AND si95_banco = '$oMovi40->c63_banco'
                            AND si95_agencia = '$oMovi40->c63_agencia' 
                            AND si95_digitoverificadoragencia = '$oMovi40->c63_dvagencia' 
                            AND si95_contabancaria = '$oMovi40->c63_conta'
                            AND si95_digitoverificadorcontabancaria = '$oMovi40->c63_dvconta' 
                            AND si95_tipoconta::int = $oMovi40->tipoconta 
                            AND si95_mes <= " . $this->sDataFinal['5'] . $this->sDataFinal['6'] ."
                            AND si95_instit = " . db_getsession('DB_instit');
        $sSqlVerifica .= " UNION ";
        $sSqlVerifica .= " SELECT 'ctb102019' AS ano, si95_codctb, si95_nroconvenio FROM ctb102019 ";
        $sSqlVerifica .= " WHERE si95_codorgao::int = $oMovi40->si09_codorgaotce 
                             AND si95_banco = '$oMovi40->c63_banco'
                             AND si95_agencia = '$oMovi40->c63_agencia' 
                             AND si95_digitoverificadoragencia = '$oMovi40->c63_dvagencia' 
                             AND si95_contabancaria = '$oMovi40->c63_conta'
                             AND si95_digitoverificadorcontabancaria = '$oMovi40->c63_dvconta' 
                             AND si95_tipoconta::int = $oMovi40->tipoconta 
                             AND si95_instit = " . db_getsession('DB_instit');
        $sSqlVerifica .= " UNION ";
        $sSqlVerifica .= " SELECT 'ctb102018' AS ano, si95_codctb, si95_nroconvenio::varchar FROM ctb102018 ";
        $sSqlVerifica .= " WHERE si95_codorgao::int = $oMovi40->si09_codorgaotce 
                             AND si95_banco = '$oMovi40->c63_banco' 
                             AND si95_agencia = '$oMovi40->c63_agencia' 
                             AND si95_digitoverificadoragencia = '$oMovi40->c63_dvagencia' 
                             AND si95_contabancaria = '$oMovi40->c63_conta' 
                             AND si95_digitoverificadorcontabancaria = '$oMovi40->c63_dvconta' 
                             AND si95_tipoconta::int = $oMovi40->tipoconta 
                             AND si95_instit = " . db_getsession('DB_instit');
        $sSqlVerifica .= " UNION ";
        $sSqlVerifica .= " SELECT 'ctb102017' AS ano, si95_codctb, si95_nroconvenio::varchar FROM ctb102017 ";
        $sSqlVerifica .= " WHERE si95_codorgao::int = $oMovi40->si09_codorgaotce 
                             AND si95_banco = '$oMovi40->c63_banco' 
                             AND si95_agencia = '$oMovi40->c63_agencia' 
                             AND si95_digitoverificadoragencia = '$oMovi40->c63_dvagencia' 
                             AND si95_contabancaria = '$oMovi40->c63_conta' 
                             AND si95_digitoverificadorcontabancaria = '$oMovi40->c63_dvconta' 
                             AND si95_tipoconta::int = $oMovi40->tipoconta 
                             AND si95_instit = " . db_getsession('DB_instit');
        $sSqlVerifica .= " UNION ";
        $sSqlVerifica .= " SELECT 'ctb102016' AS ano, si95_codctb, si95_nroconvenio::varchar FROM ctb102016 ";
        $sSqlVerifica .= " WHERE si95_codorgao::int = $oMovi40->si09_codorgaotce 
                             AND si95_banco = '$oMovi40->c63_banco'
                             AND si95_agencia = '$oMovi40->c63_agencia' 
                             AND si95_digitoverificadoragencia = '$oMovi40->c63_dvagencia' 
                             AND si95_contabancaria = '$oMovi40->c63_conta'
                             AND si95_digitoverificadorcontabancaria = '$oMovi40->c63_dvconta' 
                             AND si95_tipoconta::int = $oMovi40->tipoconta 
                             AND si95_instit = " . db_getsession('DB_instit');
        $sSqlVerifica .= " UNION ";
        $sSqlVerifica .= " SELECT 'ctb102015' AS ano, si95_codctb, si95_nroconvenio::varchar FROM ctb102015 ";
        $sSqlVerifica .= " WHERE si95_codorgao::int = $oMovi40->si09_codorgaotce 
                             AND si95_banco = '$oMovi40->c63_banco'
                             AND si95_agencia = '$oMovi40->c63_agencia' 
                             AND si95_digitoverificadoragencia = '$oMovi40->c63_dvagencia' 
                             AND si95_contabancaria = '$oMovi40->c63_conta' 
                             AND si95_digitoverificadorcontabancaria = '$oMovi40->c63_dvconta' 
                             AND si95_tipoconta::int = $oMovi40->tipoconta 
                             AND si95_instit = " . db_getsession('DB_instit');
        $sSqlVerifica .= " UNION ";
        $sSqlVerifica .= " SELECT 'ctb102014' AS ano, si95_codctb, si95_nroconvenio::varchar FROM ctb102014 ";
        $sSqlVerifica .= " WHERE si95_codorgao::int = '$oMovi40->si09_codorgaotce' 
                             AND si95_banco = '$oMovi40->c63_banco' 
                             AND si95_agencia = '$oMovi40->c63_agencia' 
                             AND si95_digitoverificadoragencia = '$oMovi40->c63_dvagencia' 
                             AND si95_contabancaria = '$oMovi40->c63_conta' 
                             AND si95_digitoverificadorcontabancaria = '$oMovi40->c63_dvconta' 
                             AND si95_tipoconta::int = $oMovi40->tipoconta 
                             AND si95_instit = " . db_getsession('DB_instit') . " LIMIT 1";

        $rsResultVerifica40 = db_query($sSqlVerifica);
        $oVerificaReg40 = db_utils::fieldsMemory($rsResultVerifica40, 0);

        $sSql40 = "SELECT 'ctb402020' AS ano, ctb402020.* FROM ctb402020
                    WHERE si101_codctb = {$oVerificaReg40->si95_codctb}
                      AND si101_mes <= " . $this->sDataFinal['5'] . $this->sDataFinal['6'] ."
                      AND si101_instit = " . db_getsession('DB_instit');
        $sSql40 .= "UNION ALL ";
        $sSql40 .= "SELECT 'ctb402019' AS ano, ctb402019.* FROM ctb402019
                     WHERE si101_codctb = {$oVerificaReg40->si95_codctb}
                       AND si101_instit = " . db_getsession('DB_instit');
        $sSql40 .= "UNION ALL ";
        $sSql40 .= "SELECT 'ctb402018' AS ano, ctb402018.* FROM ctb402018
                     WHERE si101_codctb = {$oVerificaReg40->si95_codctb}
                       AND si101_instit = " . db_getsession('DB_instit');
        $sSql40 .= "UNION ALL ";
        $sSql40 .= "SELECT 'ctb402017' AS ano, ctb402017.* FROM ctb402017
                     WHERE si101_codctb = {$oVerificaReg40->si95_codctb}
                       AND si101_instit = " . db_getsession('DB_instit');
        $sSql40 .= "UNION ALL ";
        $sSql40 .= "SELECT 'ctb402016' AS ano, ctb402016.* FROM ctb402016
                     WHERE si101_codctb = {$oVerificaReg40->si95_codctb}
                       AND si101_instit = " . db_getsession('DB_instit');
        $sSql40 .= "UNION ALL ";
        $sSql40 .= "SELECT 'ctb402015' AS ano, ctb402015.* FROM ctb402015
                     WHERE si101_codctb = {$oVerificaReg40->si95_codctb}
                       AND si101_instit = " . db_getsession('DB_instit');

        $rsQuery40 = db_query($sSql40);
        $oReg40 = db_utils::fieldsMemory($rsQuery40, 0);

        if ($oMovi40->contaconvenio == 1 && ($oMovi40->nroconvenio != $oReg40->si101_nroconvenio) && empty($oMovi40->nroconvenio)
          && pg_num_rows($rsQuery40) == 0 && ($oDtCad->k13_dtimplantacao <= $this->sDataFinal)) {

          $cCtb40 = new cl_ctb402020();

          $cCtb40->si101_tiporegistro = 40;
          $cCtb40->si101_codorgao = $oMovi40->si09_codorgaotce;
          $cCtb40->si101_codctb = $oMovi40->codtce != 0 ? $oMovi40->codtce : $oMovi40->codctb;
          $cCtb40->si101_desccontabancaria = substr($oMovi40->desccontabancaria,0,50);
          $cCtb40->si101_nroconvenio = $oMovi40->nroconvenio;
          $cCtb40->si101_dataassinaturaconvenio = ($oMovi40->dataassinaturaconvenio == NULL || $oMovi40->dataassinaturaconvenio == ' ') ? NULL : $oMovi40->dataassinaturaconvenio;
          $cCtb40->si101_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
          $cCtb40->si101_instit = db_getsession("DB_instit");

          $cCtb40->incluir(null);
          if ($cCtb40->erro_status == 0) {
            throw new Exception($cCtb40->erro_msg);
          }
        }
      }
    }

    /*
     * REGISTRO 50 CONTAS ENCERRADAS
     */

    $sSqlCtbEncerradas = "select 50 as tiporegistro,
							     si09_codorgaotce,
							     case when c61_codtce <> 0 then c61_codtce else k13_reduz end as codctb,
							     'E' as situacaoconta,
							     k13_limite as dataencerramento
						       from saltes 
						       join conplanoreduz on k13_reduz = c61_reduz and c61_anousu = " . db_getsession("DB_anousu") . "
						       join conplanoconta on c63_codcon = c61_codcon and c63_anousu = c61_anousu
						  left join conplanocontabancaria on c56_codcon = c61_codcon and c56_anousu = c61_anousu
						  left join contabancaria on c56_contabancaria = db83_sequencial
						  left join infocomplementaresinstit on si09_instit = c61_instit
						    where k13_limite between '" . $this->sDataInicial . "' and '" . $this->sDataFinal . "'
							  and c61_instit = " . db_getsession("DB_instit");

    $rsCtbEncerradas = db_query($sSqlCtbEncerradas);
    if (pg_num_rows($rsCtbEncerradas) != 0) {

      for ($iCont50 = 0; $iCont50 < pg_num_rows($rsCtbEncerradas); $iCont50++) {

        $oMovi50 = db_utils::fieldsMemory($rsCtbEncerradas, $iCont50);

        $cCtb50 = new cl_ctb502020();

        $cCtb50->si102_tiporegistro = $oMovi50->tiporegistro;
        $cCtb50->si102_codorgao = $oMovi50->si09_codorgaotce;
        $cCtb50->si102_codctb = $oMovi50->codctb;
        $cCtb50->si102_situacaoconta = $oMovi50->situacaoconta;
        $cCtb50->si102_datasituacao = $oMovi50->dataencerramento;
        $cCtb50->si102_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $cCtb50->si102_instit = db_getsession("DB_instit");

        $cCtb50->incluir(null);
        if ($cCtb50->erro_status == 0) {
          throw new Exception($cCtb50->erro_msg);
        }

      }

    }


	/**
	 * Se a opção "Transferência de Fontes CTB" na tela de geração do sicom for sim
	 */
	if ($this->bEncerramento) {
	  
		/**
		 * Percorre todo array para acertar os saldos finais do reg20.
		 * Para cada reg20 que não seja a fonte principal, será necessário transferir o saldo final para a fonte principal
		 * Caso fonte do registro 20 seja diferente da fonte principal da conta, criamos 2 registros 21:
		 * 1 registro 21 de saída da fonte atual;
		 * 1 registro 21 de entrada na fonte principal.
		 */
	  	foreach ($aCtb20Agrupado as $sHash20 => $oCtb20) {

		  	if ($oCtb20->si96_codfontrecursos != $oCtb20->iFontePrincipal && $oCtb20->si96_vlsaldofinalfonte != 0) {

				//Cria o primeiro registro 21 entrada/saída da fonte atual
				$iTipoMovimentacao 	= $oCtb20->si96_vlsaldofinalfonte > 0 ? 2 : 1;
				$sHash21 			= $oCtb20->si96_codctb.$oCtb20->si96_codfontrecursos.$iTipoMovimentacao;

				if (!$aCtb20Agrupado[$sHash20]->ext21[$sHash21]) {

					$oDadosMovi21 = new stdClass();
					$oDadosMovi21->si97_tiporegistro 		= '21';
					$oDadosMovi21->si97_codctb 				= $oCtb20->si96_codctb;
					$oDadosMovi21->si97_codfontrecursos 	= $oCtb20->si96_codfontrecursos;
					$oDadosMovi21->si97_codreduzidomov 		= $oCtb20->si96_codctb . $oCtb20->si96_codfontrecursos . $iTipoMovimentacao;
					$oDadosMovi21->si97_tipomovimentacao 	= $iTipoMovimentacao;
					$oDadosMovi21->si97_tipoentrsaida 		= '98';
					$oDadosMovi21->si97_dscoutrasmov 		= ' ';
					$oDadosMovi21->si97_valorentrsaida 		= $oCtb20->si96_vlsaldofinalfonte;
					$oDadosMovi21->si97_codctbtransf 		= ' ';
					$oDadosMovi21->si97_codfontectbtransf 	= ' ';
					$oDadosMovi21->si97_mes 				= $this->sDataFinal['5'] . $this->sDataFinal['6'];
					$oDadosMovi21->si97_instit 				= db_getsession("DB_instit");

					$aCtb20Agrupado[$sHash20]->ext21[$sHash21] = $oDadosMovi21;
				} else {
					$aCtb20Agrupado[$sHash20]->ext21[$sHash21]->si97_valorentrsaida += $oCtb20->si96_vlsaldofinalfonte;
				}

				//Monta hash do reg 20 da fonte principal
			  	$sHash20recurso = substr($sHash20,0,-3).$oCtb20->iFontePrincipal;
				  
				// Registro 20 da fonte principal recebe saldos finais das demais fontes
				$aCtb20Agrupado[$sHash20recurso]->si96_vlsaldofinalfonte += $oCtb20->si96_vlsaldofinalfonte;

				//Cria segundo registro 21 entrada/saída da fonte principal
				$iTipoMovimentacao 	= $oCtb20->si96_vlsaldofinalfonte > 0 ? 1 : 2;
				$sHash21 			= $oContaAgrupada->si95_codctb.$oCtb20->iFontePrincipal.$iTipoMovimentacao;

				if(!$aCtb20Agrupado[$sHash20recurso]->ext21[$sHash21]) {
				  
					$oDadosMovi21 = new stdClass();
					$oDadosMovi21->si97_tiporegistro 		= '21';
					$oDadosMovi21->si97_codctb 				= $oCtb20->si96_codctb;
					$oDadosMovi21->si97_codfontrecursos 	= $oCtb20->iFontePrincipal;
					$oDadosMovi21->si97_codreduzidomov 		= $oCtb20->si96_codctb . $oCtb20->iFontePrincipal . $iTipoMovimentacao;
					$oDadosMovi21->si97_tipomovimentacao 	= $iTipoMovimentacao;
					$oDadosMovi21->si97_tipoentrsaida 		= '98';
					$oDadosMovi21->si97_dscoutrasmov 		= ' ';
					$oDadosMovi21->si97_valorentrsaida 		= $oCtb20->si96_vlsaldofinalfonte;
					$oDadosMovi21->si97_codctbtransf 		= ' ';
					$oDadosMovi21->si97_codfontectbtransf 	= ' ';
					$oDadosMovi21->si97_mes 				= $this->sDataFinal['5'] . $this->sDataFinal['6'];
					$oDadosMovi21->si97_instit 				= db_getsession("DB_instit");

					$aCtb20Agrupado[$sHash20recurso]->ext21[$sHash21] = $oDadosMovi21;                    

				} else {
					$aCtb20Agrupado[$sHash20recurso]->ext21[$sHash21]->si97_valorentrsaida += $oCtb20->si96_vlsaldofinalfonte;
				}

				// Atualiza saldo final da fonte atual				
				$aCtb20Agrupado[$sHash20]->si96_vlsaldofinalfonte -= $oCtb20->si96_vlsaldofinalfonte;

		  	}

		}

		/**
		 * Percorre array para criar registros com dados criados na rotina (saldotransfctb) 
		 */
		foreach ($aCtb20Agrupado as $sHash20 => $oCtb20) {

			/**
			 * Caso seja informado um valor de Saldo Final nesta rotina (saldotransfctb) para alguma fonte, 
			 * o sistema deverá fazer uma saída (2) do tipo 98 na fonte principal da conta e uma entrada (1) do tipo 98 na fonte informada na rotina.
			 */

			$sSqlSaldoTransfCtb = "	SELECT * FROM saldotransfctb 
										WHERE si202_codctb = {$oCtb20->si96_codctb} 
										AND si202_anousu = ".db_getsession("DB_anousu")." AND si202_instit = ".db_getsession("DB_instit");
		  
			$rsSaldoTransfCtb = db_query($sSqlSaldoTransfCtb);

			if (pg_num_rows($rsSaldoTransfCtb))	{

				for($iSaldoTransfCtb = 0; $iSaldoTransfCtb < pg_num_rows($rsSaldoTransfCtb); $iSaldoTransfCtb++) {

					//Caso a fonte atual seja igual a fonte principal, criamos a saída da fonte principal e entrada na fonte cadastrada na saldotransfctb
					if ($oCtb20->iFontePrincipal == $oCtb20->si96_codfontrecursos) {

						$oSaldoTransfCtb = db_utils::fieldsMemory($rsSaldoTransfCtb, $iSaldoTransfCtb);

						if ($oSaldoTransfCtb->si202_codctb == $oCtb20->si96_codctb) {

							//Cria reg21 de saída da fonte principal para fonte cadastrada na tabela saldotransfctb
							$sHash21 = $oCtb20->si96_codctb.$oCtb20->iFontePrincipal.'2';

							//Cria saída da fonte principal
							if (!$aCtb20Agrupado[$sHash20]->ext21[$sHash21]) {
						  
								$oDadosMovi21 = new stdClass();
								$oDadosMovi21->si97_tiporegistro 		= '21';
								$oDadosMovi21->si97_codctb 				= $oCtb20->si96_codctb;
								$oDadosMovi21->si97_codfontrecursos 	= $oCtb20->iFontePrincipal;
								$oDadosMovi21->si97_codreduzidomov 		= $oCtb20->si96_codctb . $oCtb20->si96_codfontrecursos.'2';
								$oDadosMovi21->si97_tipomovimentacao 	= 2;
								$oDadosMovi21->si97_tipoentrsaida 		= '98';
								$oDadosMovi21->si97_dscoutrasmov 		= ' ';
								$oDadosMovi21->si97_valorentrsaida 		= $oSaldoTransfCtb->si202_saldofinal;
								$oDadosMovi21->si97_codctbtransf 		= ' ';
								$oDadosMovi21->si97_codfontectbtransf 	= ' ';
								$oDadosMovi21->si97_mes 				= $this->sDataFinal['5'] . $this->sDataFinal['6'];
								$oDadosMovi21->si97_instit 				= db_getsession("DB_instit");

								$aCtb20Agrupado[$sHash20]->ext21[$sHash21] = $oDadosMovi21;

							} else {
								$aCtb20Agrupado[$sHash20]->ext21[$sHash21]->si97_valorentrsaida += $oSaldoTransfCtb->si202_saldofinal;
							}

							//Atualiza saldo do reg20
							$aCtb20Agrupado[$sHash20]->si96_vlsaldofinalfonte -= $oSaldoTransfCtb->si202_saldofinal;

							//Cria entrada na fonte cadastrada na tabela saldotransfctb
							$sHash21b = $oCtb20->si96_codctb.$oSaldoTransfCtb->si202_codfontrecursos.'1';
							$sHash20b = substr($sHash20, 0, -3).$oSaldoTransfCtb->si202_codfontrecursos;
						  
							if (!$aCtb20Agrupado[$sHash20b]->ext21[$sHash21b]) {
							
								$oDadosMovi21 = new stdClass();
								$oDadosMovi21->si97_tiporegistro 		= '21';
								$oDadosMovi21->si97_codctb 				= $oCtb20->si96_codctb;
								$oDadosMovi21->si97_codfontrecursos 	= $oSaldoTransfCtb->si202_codfontrecursos;
								$oDadosMovi21->si97_codreduzidomov 		= $oCtb20->si96_codctb . $oSaldoTransfCtb->si202_codfontrecursos.'1';
								$oDadosMovi21->si97_tipomovimentacao 	= 1;
								$oDadosMovi21->si97_tipoentrsaida 		= '98';
								$oDadosMovi21->si97_dscoutrasmov 		= ' ';
								$oDadosMovi21->si97_valorentrsaida 		= $oSaldoTransfCtb->si202_saldofinal;
								$oDadosMovi21->si97_codctbtransf 		= ' ';
								$oDadosMovi21->si97_codfontectbtransf 	= ' ';
								$oDadosMovi21->si97_mes 				= $this->sDataFinal['5'] . $this->sDataFinal['6'];
								$oDadosMovi21->si97_instit 				= db_getsession("DB_instit");
								$oDadosMovi21->codorgao 				= $oContaAgrupada->si95_codorgao;	

								$aCtb20Agrupado[$sHash20b]->ext21[$sHash21b] = $oDadosMovi21;

							} else {
								$aCtb20Agrupado[$sHash20b]->ext21[$sHash21b]->si97_valorentrsaida += $oSaldoTransfCtb->si202_saldofinal;
							}

							//Atualiza saldo do reg20
							$aCtb20Agrupado[$sHash20b]->si96_vlsaldofinalfonte += $oSaldoTransfCtb->si202_saldofinal;

						}
								
					}

				}

			}

			

		}

		/**
	   	 * Percorre array para verificar se existe algum registro 21 criado em um registro 20 vazio
	   	 * Caso exista, um registro 20 é criado utilizando os dados do reg21
	   	*/
		foreach ($aCtb20Agrupado as $oCtb20) {
			
			if (!$oCtb20->si96_tiporegistro) {

				$sHash21 = key($oCtb20->ext21);				

				$oCtb20->si96_tiporegistro 			= 20;
				$oCtb20->si96_codorgao 				= $oCtb20->ext21[$sHash21]->codorgao;
				$oCtb20->si96_codctb 				= $oCtb20->ext21[$sHash21]->si97_codctb;
				$oCtb20->si96_codfontrecursos 		= $oCtb20->ext21[$sHash21]->si97_codfontrecursos;
				$oCtb20->si96_vlsaldoinicialfonte 	= 0;
				$oCtb20->si96_vlsaldofinalfonte 	= $oCtb20->ext21[$sHash21]->si97_valorentrsaida;
				$oCtb20->si96_mes 					= $oCtb20->ext21[$sHash21]->si97_mes;
				$oCtb20->si96_instit 				= $oCtb20->ext21[$sHash21]->si97_instit;
				
			}

		}

	}

	 /**
       * inclusão do registro 20 e 21 do procedimento normal
       */
	foreach ($aCtb20Agrupado as $oCtb20) {

        $bFonteEncerrada  = in_array($oCtb20->si96_codfontrecursos, $this->aFontesEncerradas);
        $bCorrecaoFonte   = ($bFonteEncerrada && $oCtb20->si96_mes == '01' && db_getsession("DB_anousu") == 2020);

        if ($bFonteEncerrada && $bCorrecaoFonte && $oCtb20->si96_vlsaldoinicialfonte == 0) {
          	continue;
        }

        $cCtb20 = new cl_ctb202020();

        $cCtb20->si96_tiporegistro = $oCtb20->si96_tiporegistro;
        $cCtb20->si96_codorgao = $oCtb20->si96_codorgao;
        $cCtb20->si96_codctb = $oCtb20->si96_codctb;
        $cCtb20->si96_codfontrecursos = $oCtb20->si96_codfontrecursos;
        $cCtb20->si96_vlsaldoinicialfonte = $oCtb20->si96_vlsaldoinicialfonte;
        $cCtb20->si96_vlsaldofinalfonte = $oCtb20->si96_vlsaldofinalfonte;
        $cCtb20->si96_vlsaldofinalfonte = (abs(number_format($oCtb20->si96_vlsaldofinalfonte,2,".","")) == 0) ? 0 : $oCtb20->si96_vlsaldofinalfonte;
        $cCtb20->si96_mes = $oCtb20->si96_mes;
        $cCtb20->si96_instit = $oCtb20->si96_instit;

        $cCtb20->incluir(null);
        if ($cCtb20->erro_status == 0) {
			throw new Exception($cCtb20->erro_msg);
        }

        foreach ($oCtb20->ext21 as $oCtb21agrupado) {

			$cCtb21 = new cl_ctb212020();

			$cCtb21->si97_tiporegistro = $oCtb21agrupado->si97_tiporegistro;
			$cCtb21->si97_codctb = $oCtb21agrupado->si97_codctb;
			$cCtb21->si97_codfontrecursos = $oCtb21agrupado->si97_codfontrecursos;
			$cCtb21->si97_codreduzidomov = $oCtb21agrupado->si97_codreduzidomov;
			$cCtb21->si97_tipomovimentacao = $oCtb21agrupado->si97_tipomovimentacao;
			$cCtb21->si97_tipoentrsaida = $oCtb21agrupado->si97_tipoentrsaida;
			$cCtb21->si97_valorentrsaida = abs($oCtb21agrupado->si97_valorentrsaida);
			$cCtb21->si97_dscoutrasmov = ($oCtb21agrupado->si97_tipoentrsaida == 99 ? 'Recebimento Extra-Orçamentário': ' ');
			$cCtb21->si97_codctbtransf = ($oCtb21agrupado->si97_tipoentrsaida == 5 || $oCtb21agrupado->si97_tipoentrsaida == 6 || $oCtb21agrupado->si97_tipoentrsaida == 7 || $oCtb21agrupado->si97_tipoentrsaida == 9) ? $oCtb21agrupado->si97_codctbtransf : 0;
			$cCtb21->si97_codfontectbtransf = ($oCtb21agrupado->si97_tipoentrsaida == 5 || $oCtb21agrupado->si97_tipoentrsaida == 6 || $oCtb21agrupado->si97_tipoentrsaida == 7 || $oCtb21agrupado->si97_tipoentrsaida == 9) ? $oCtb21agrupado->si97_codfontectbtransf : 0;
			$cCtb21->si97_mes = $oCtb21agrupado->si97_mes;
			$cCtb21->si97_reg20 = $cCtb20->si96_sequencial;
			$cCtb21->si97_instit = $oCtb21agrupado->si97_instit;

			$cCtb21->incluir(null);
			if ($cCtb21->erro_status == 0) {
				throw new Exception($cCtb21->erro_msg);
			}


			foreach ($oCtb21agrupado->registro22 as $oCtb22Agrupado) {

				$cCtb22 = new cl_ctb222020();

				$cCtb22->si98_tiporegistro = $oCtb22Agrupado->si98_tiporegistro;
				$cCtb22->si98_codreduzidomov = $oCtb22Agrupado->si98_codreduzidomov;
				$cCtb22->si98_ededucaodereceita = $oCtb22Agrupado->si98_ededucaodereceita;
				$cCtb22->si98_identificadordeducao = $oCtb22Agrupado->si98_identificadordeducao;
				$cCtb22->si98_naturezareceita = $oCtb22Agrupado->si98_naturezareceita;
				$cCtb22->si98_codfontrecursos = $oCtb21agrupado->si97_codfontrecursos;
				$cCtb22->si98_vlrreceitacont = $oCtb22Agrupado->si98_vlrreceitacont;
				$cCtb22->si98_mes = $oCtb22Agrupado->si98_mes;
				$cCtb22->si98_reg21 = $cCtb21->si97_sequencial;
				$cCtb22->si98_instit = $oCtb22Agrupado->si98_instit;

				$cCtb22->incluir(null);
				if ($cCtb22->erro_status == 0) {
					throw new Exception($cCtb22->erro_msg);
				}

			}

		}

    }


    $oGerarCTB = new GerarCTB();
    $oGerarCTB->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];;
    $oGerarCTB->gerarDados();
  }

}
