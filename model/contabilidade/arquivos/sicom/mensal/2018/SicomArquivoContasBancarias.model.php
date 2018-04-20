<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_ctb102018_classe.php");
require_once("classes/db_ctb202018_classe.php");
require_once("classes/db_ctb212018_classe.php");
require_once("classes/db_ctb222018_classe.php");
require_once("classes/db_ctb302018_classe.php");
require_once("classes/db_ctb312018_classe.php");
require_once("classes/db_ctb402018_classe.php");
require_once("classes/db_ctb412018_classe.php");
require_once("classes/db_ctb502018_classe.php");
require_once("classes/db_ctb602018_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2018/GerarCTB.model.php");


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

  /**
   * selecionar os dados das contas bancarias
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados()
  {


    $cCtb10 = new cl_ctb102018();
    $cCtb20 = new cl_ctb202018();
    $cCtb21 = new cl_ctb212018();
    $cCtb22 = new cl_ctb222018();
    $cCtb30 = new cl_ctb302018();
    $cCtb31 = new cl_ctb312018();
    $cCtb40 = new cl_ctb402018();
    $cCtb41 = new cl_ctb412018();
    $cCtb50 = new cl_ctb502018();


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
				             CASE WHEN (db83_convenio is null or db83_convenio = 2) then 2 else  1 end as contaconvenio,
				             case when db83_convenio = 1 then db83_numconvenio else null end as nroconvenio,
				             case when db83_convenio = 1 then db83_dataconvenio else null end as dataassinaturaconvenio,
				             o15_codtri as recurso
				       from saltes 
				       join conplanoreduz on k13_reduz = c61_reduz and c61_anousu = " . db_getsession("DB_anousu") . "
				       join conplanoconta on c63_codcon = c61_codcon and c63_anousu = c61_anousu
				       join orctiporec on c61_codigo = o15_codigo
				  left join conplanocontabancaria on c56_codcon = c61_codcon and c56_anousu = c61_anousu
				  left join contabancaria on c56_contabancaria = db83_sequencial
				  left join infocomplementaresinstit on si09_instit = c61_instit ";
    if( db_getsession("DB_anousu") == 2018 && $this->sDataFinal['5'] . $this->sDataFinal['6'] == 1 ) {
        $sSqlGeral .= " where (k13_limite is null or k13_limite >= '" . $this->sDataFinal . "') 
    				     and c61_instit = " . db_getsession("DB_instit") . " order by k13_reduz";
    }else {
        $sSqlGeral .= " where (k13_limite is null or k13_limite >= '" . $this->sDataFinal . "') 
				    and (date_part('MONTH',k13_dtimplantacao) <= " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " 
				    or date_part('YEAR',k13_dtimplantacao) < " . db_getsession("DB_anousu") . ")
    				  and c61_instit = " . db_getsession("DB_instit") . " order by k13_reduz";
    }

    //echo $sSqlGeral k13_reduz in (4190,4208) and;
    $rsContas = db_query($sSqlGeral);//db_criatabela($rsContas);

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

          $cCtb10 = new cl_ctb102018();


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

          // vericando se o ctb foi enviado em 2018
          $sSqlVerifica = "SELECT si95_codctb FROM ctb102018 ";
          $sSqlVerifica .= "WHERE si95_codorgao::int = $oRegistro10->si09_codorgaotce ";
          $sSqlVerifica .= " AND si95_banco = '$oRegistro10->c63_banco'";
          $sSqlVerifica .= " AND si95_agencia = '$oRegistro10->c63_agencia' ";
          $sSqlVerifica .= " AND si95_digitoverificadoragencia = '$oRegistro10->c63_dvagencia' ";
          $sSqlVerifica .= " AND si95_contabancaria = '$oRegistro10->c63_conta'";
          $sSqlVerifica .= " AND si95_digitoverificadorcontabancaria = '$oRegistro10->c63_dvconta' ";
          $sSqlVerifica .= " AND si95_tipoconta::int = $oRegistro10->tipoconta ";
          $sSqlVerifica .= " AND si95_mes < " . $this->sDataFinal['5'] . $this->sDataFinal['6'] ;
          $sSqlVerifica .= " AND si95_instit = " . db_getsession('DB_instit');

            // vericando se o ctb foi enviado em 2017
          $sSqlVerifica .= " UNION SELECT si95_codctb FROM ctb102017 ";
          $sSqlVerifica .= "WHERE si95_codorgao::int = $oRegistro10->si09_codorgaotce ";
          $sSqlVerifica .= " AND si95_banco = '$oRegistro10->c63_banco' ";
          $sSqlVerifica .= " AND si95_agencia = '$oRegistro10->c63_agencia' ";
          $sSqlVerifica .= " AND si95_digitoverificadoragencia = '$oRegistro10->c63_dvagencia' ";
          $sSqlVerifica .= " AND si95_contabancaria = '$oRegistro10->c63_conta' ";
          $sSqlVerifica .= " AND si95_digitoverificadorcontabancaria = '$oRegistro10->c63_dvconta' ";
          $sSqlVerifica .= " AND si95_tipoconta::int = $oRegistro10->tipoconta ";
          $sSqlVerifica .= " AND si95_instit = " . db_getsession('DB_instit');

            // vericando se o ctb foi enviado em 2016
          $sSqlVerifica .= " UNION SELECT si95_codctb FROM ctb102016 ";
          $sSqlVerifica .= "WHERE si95_codorgao::int = $oRegistro10->si09_codorgaotce ";
          $sSqlVerifica .= " AND si95_banco = '$oRegistro10->c63_banco'";
          $sSqlVerifica .= " AND si95_agencia = '$oRegistro10->c63_agencia' ";
          $sSqlVerifica .= " AND si95_digitoverificadoragencia = '$oRegistro10->c63_dvagencia' ";
          $sSqlVerifica .= " AND si95_contabancaria = '$oRegistro10->c63_conta'";
          $sSqlVerifica .= " AND si95_digitoverificadorcontabancaria = '$oRegistro10->c63_dvconta' ";
          $sSqlVerifica .= " AND si95_tipoconta::int = $oRegistro10->tipoconta ";
          $sSqlVerifica .= " AND si95_instit = " . db_getsession('DB_instit');

            // vericando se o ctb foi enviado em 2015
          $sSqlVerifica .= " UNION SELECT si95_codctb FROM ctb102015 ";
          $sSqlVerifica .= "WHERE si95_codorgao::int = $oRegistro10->si09_codorgaotce ";
          $sSqlVerifica .= " AND si95_banco = '$oRegistro10->c63_banco'";
          $sSqlVerifica .= " AND si95_agencia = '$oRegistro10->c63_agencia' ";
          $sSqlVerifica .= " AND si95_digitoverificadoragencia = '$oRegistro10->c63_dvagencia' ";
          $sSqlVerifica .= " AND si95_contabancaria = '$oRegistro10->c63_conta' ";
          $sSqlVerifica .= " AND si95_digitoverificadorcontabancaria = '$oRegistro10->c63_dvconta' ";
          $sSqlVerifica .= " AND si95_tipoconta::int = $oRegistro10->tipoconta ";
          $sSqlVerifica .= " AND si95_instit = " . db_getsession('DB_instit');

          // vericando se o ctb foi enviado em 2014
          $sSqlVerifica .= " UNION SELECT si95_codctb FROM ctb102014 ";
          $sSqlVerifica .= "WHERE si95_codorgao::int = '$oRegistro10->si09_codorgaotce' ";
          $sSqlVerifica .= " AND si95_banco = '$oRegistro10->c63_banco' ";
          $sSqlVerifica .= " AND si95_agencia = '$oRegistro10->c63_agencia' ";
          $sSqlVerifica .= " AND si95_digitoverificadoragencia = '$oRegistro10->c63_dvagencia' ";
          $sSqlVerifica .= " AND si95_contabancaria = '$oRegistro10->c63_conta' ";
          $sSqlVerifica .= " AND si95_digitoverificadorcontabancaria = '$oRegistro10->c63_dvconta' ";
          $sSqlVerifica .= " AND si95_tipoconta::int = $oRegistro10->tipoconta ";
          $sSqlVerifica .= " AND si95_instit = " . db_getsession('DB_instit');

          $rsResultVerifica = db_query($sSqlVerifica);//echo $sSqlVerifica; db_criatabela($rsResultVerifica);

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

          }else {
              if (pg_num_rows($rsResultVerifica) == 0 ){
                  $cCtb10->incluir(null);
                  if ($cCtb10->erro_status == 0) {
                      throw new Exception($cCtb10->erro_msg);
                  }
              }
          }
          $cCtb10->si95_codctb = $oRegistro10->codtce != 0 ? $oRegistro10->codtce : $oRegistro10->codctb;
          $cCtb10->contas[] = $oRegistro10->codctb;
          $aBancosAgrupados[$aHash] = $cCtb10;

        } else {
          $aBancosAgrupados[$aHash]->contas[] = $oRegistro10->codctb;
        }


      } else {
        /*
         * FALTA AGRUPA AS CONTAS QUANDO A INSTIUICAO FOR IGUAL A 5 RPPS
         */
      }

    }
    //echo "<pre>";print_r($aBancosAgrupados);
    foreach ($aBancosAgrupados as $oContaAgrupada) {


      $nMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $aCtb20Agrupado = array();
      $oCtb20FontRec = new stdClass();
      foreach ($oContaAgrupada->contas as $nConta) {


        $sSql20Fonte = "select distinct codctb, fontemovimento from (
									select c61_reduz  as codctb, o15_codtri  as fontemovimento
									  from conplano
								inner join conplanoreduz on conplanoreduz.c61_codcon = conplano.c60_codcon and conplanoreduz.c61_anousu = conplano.c60_anousu
								inner join orctiporec on o15_codigo = c61_codigo
									 where conplanoreduz.c61_reduz  in ({$nConta})
									   and conplanoreduz.c61_anousu = " . db_getsession("DB_anousu") . "
								 union all
								select c61_reduz  as codctb, ces02_fonte::varchar  as fontemovimento
									  from conctbsaldo
								inner join conplanoreduz on conctbsaldo.ces02_reduz = conplanoreduz.c61_reduz and conplanoreduz.c61_anousu = conctbsaldo.ces02_anousu
								inner join orctiporec on o15_codigo = c61_codigo
									 where conctbsaldo.ces02_reduz  in ({$nConta})
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
								   and conlancamval.c69_credito in ({$nConta})
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
								   and conlancamval.c69_debito in ({$nConta})
                union all 
              select ces02_reduz,ces02_fonte::varchar from conctbsaldo where ces02_reduz in ({$nConta}) and ces02_anousu = " . db_getsession("DB_anousu") . "
							) as xx";
        $rsReg20Fonte = db_query($sSql20Fonte) or die($sSql20Fonte);//db_criatabela($rsReg20Fonte);

        for ($iCont20 = 0; $iCont20 < pg_num_rows($rsReg20Fonte); $iCont20++) {

          /* DADOS REGISTRO 20*/
          $iFonte = db_utils::fieldsMemory($rsReg20Fonte, $iCont20)->fontemovimento;


          $sSqlMov = "select
round(substr(fc_saldoctbfonte(" . db_getsession("DB_anousu") . ",$nConta,'" . $iFonte . "'," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),29,15)::float8,2)::float8 as saldo_anterior,
round(substr(fc_saldoctbfonte(" . db_getsession("DB_anousu") . ",$nConta,'" . $iFonte . "'," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),43,15)::float8,2)::float8 as debitomes,
round(substr(fc_saldoctbfonte(" . db_getsession("DB_anousu") . ",$nConta,'" . $iFonte . "'," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),57,15)::float8,2)::float8 as creditomes,
round(substr(fc_saldoctbfonte(" . db_getsession("DB_anousu") . ",$nConta,'" . $iFonte . "'," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),72,15)::float8,2)::float8 as saldo_final,
substr(fc_saldoctbfonte(" . db_getsession("DB_anousu") . ",$nConta,'" . $iFonte . "'," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),87,1)::varchar(1) as  sinalanterior,
substr(fc_saldoctbfonte(" . db_getsession("DB_anousu") . ",$nConta,'" . $iFonte . "'," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),89,1)::varchar(1) as  sinalfinal ";
          $rsTotalMov = db_query($sSqlMov) or die($sSqlMov);
          //db_criatabela($rsTotalMov);
          //echo $sSqlMov;
          $oTotalMov = db_utils::fieldsMemory($rsTotalMov);



          $sHash20 = $oContaAgrupada->si95_codctb . $iFonte;
          if (!$aCtb20Agrupado[$sHash20]) {

            $oCtb20 = new stdClass();
            $oCtb20->si96_tiporegistro = '20';
            $oCtb20->si96_codorgao = $oContaAgrupada->si95_codorgao;
            $oCtb20->si96_codctb = $oContaAgrupada->si95_codctb;
            $oCtb20->si96_codfontrecursos = $iFonte;
            $oCtb20->si96_vlsaldoinicialfonte = $oTotalMov->sinalanterior == 'C' ? $oTotalMov->saldo_anterior * -1 : $oTotalMov->saldo_anterior;
            $oCtb20->si96_vlsaldofinalfonte = $oTotalMov->sinalfinal == 'C' ? $oTotalMov->saldo_final * -1 : $oTotalMov->saldo_final;
            $oCtb20->si96_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $oCtb20->si96_instit = db_getsession("DB_instit");
            $oCtb20->ext21 = array();
            $aCtb20Agrupado[$sHash20] = $oCtb20;

          } else {
            $oCtb20 = $aCtb20Agrupado[$sHash20];
            $oCtb20->si96_vlsaldoinicialfonte += $oTotalMov->sinalanterior == 'C' ? $oTotalMov->saldo_anterior * -1 : $oTotalMov->saldo_anterior;
            $oCtb20->si96_vlsaldofinalfonte += $oTotalMov->sinalfinal == 'C' ? $oTotalMov->saldo_final * -1 : $oTotalMov->saldo_final;
          }

          $sSqlReg21 = "select * from (
								select '21' as tiporegistro,
									   c71_codlan as codreduzido,
									   contacredito.c61_reduz  as codctb,
									   contacreditofonte.o15_codtri as codfontrecurso,
									   2 as tipomovimentacao,
									   case when c71_coddoc  in (101,116) and substr(o57_fonte,0,3) = '49' then 2 /*anteriormente estava c71_coddoc = 101*/
											when c71_coddoc = 101 then 3
											when c71_coddoc in (5,35,37) and
											(select sum(case when c53_tipo = 21 then -1 * c70_valor else c70_valor end) as valor
                              from conlancamdoc
                              join conhistdoc on c53_coddoc = c71_coddoc
                              join conlancamord on c71_codlan =  c80_codlan
                              join conlancam on c70_codlan = c71_codlan
                              where c53_tipo in (21,20)
                              and c70_data <= '" . $this->sDataFinal . "' and  c80_codord = (select c80_codord from conlancamord where c80_codlan=c69_codlan limit 1)) > 0
											then 8
											when c71_coddoc in (161) and
											(select   k17_situacao
                                             from slip
                                             join conlancamslip on k17_codigo = c84_slip
                                             join conlancamdoc  on c71_codlan = c84_conlancam
                                             where c71_codlan=c69_codlan and c71_coddoc in (161) limit 1) = 2 then 8
											when c71_coddoc in (131,152,163) then 10
											when c71_coddoc in (120) and
											 (select   k17_situacao
                                             from slip
                                             join conlancamslip on k17_codigo = c84_slip
                                             join conlancamdoc  on c71_codlan = c84_conlancam
                                             where c71_codlan=c69_codlan and c71_coddoc in (120) limit 1) = 2 then 13
											when c71_coddoc in (141,140) then 6
											--incluir validacao para verificar se a conta (debito) é caixa e o tipo do doc é 140 ou 141 
											else 99
									   end as tipoentrsaida,
									   substr(o57_fonte,0,3) as rubrica,
									   conlancamval.c69_valor as valorentrsaida,
									   case when c71_coddoc in (140,141) then contadebito.c61_reduz
											 else 0 end as codctbtransf,
									   case when c71_coddoc in (140,141) then contacreditofonte.o15_codtri else '0'end as codfontectbtransf,
									   c71_coddoc,
									   c71_codlan,
									   case when c71_coddoc in (5,35,37,6,36,38) then fontempenho.o15_codtri
											when c71_coddoc in (100,101,115,116) then fontereceita.o15_codtri
											else  contacreditofonte.o15_codtri
										end as fontemovimento,
										case when c72_complem ilike 'Referente%' and c71_coddoc in (5,35,37) then 1 else 0 end as retencao
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
							 left join conlancamcompl on c72_codlan = c71_codlan
								 where DATE_PART('YEAR',conlancamdoc.c71_data) = " . db_getsession("DB_anousu") . "
								   and DATE_PART('MONTH',conlancamdoc.c71_data) = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
								   and conlancamval.c69_credito = {$nConta}
							 union all
							 select '21' as tiporegistro,
									   c71_codlan as codreduzido,
									   contadebito.c61_reduz as codctb,
									   contadebitofonte.o15_codtri as codfontrecurso,
									   1	as tipomovimentacao,
									   case when c71_coddoc in (100,115) and substr(o57_fonte,0,3) = '49' then 16 /*anteriormente estava c71_coddoc = 100*/
											when c71_coddoc = 100 then 1
											when c71_coddoc in (6,36,38,162) then 17
											when c71_coddoc in (153) then 10
											when c71_coddoc in (130) then 12
											when c71_coddoc in (141,140) then 5
											--incluir validacao para verificar se a conta (debito) é caixa e o tipo do doc é 140 ou 141
											else 99
									   end as tipoentrsaida,
									   substr(o57_fonte,0,3) as rubrica,
									   conlancamval.c69_valor as valorentrsaida,
									   case when c71_coddoc in (140,141) then contacredito.c61_reduz
											 else 0 end as codctbtransf,
									   case when c71_coddoc in (140,141) then contacreditofonte.o15_codtri else '0' end as codfontectbtransf,
									   c71_coddoc,
									   c71_codlan,
									   case when c71_coddoc in (5,35,37,6,36,38) then fontempenho.o15_codtri
											when c71_coddoc in (100,101,115,116) then fontereceita.o15_codtri
											when c71_coddoc in (140,141) then contacreditofonte.o15_codtri
											else  contadebitofonte.o15_codtri
										end as fontemovimento,
										case when c72_complem ilike 'Referente%' and c71_coddoc in (5,35,37) then 1 else 0 end as retencao
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
							 left join conlancamcompl on c72_codlan = c71_codlan
								 where DATE_PART('YEAR',conlancamdoc.c71_data) = " . db_getsession("DB_anousu") . "
								   and DATE_PART('MONTH',conlancamdoc.c71_data) = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
								   and conlancamval.c69_debito = {$nConta}
							) as xx where fontemovimento::integer = $iFonte";

          $rsMovi21 = db_query($sSqlReg21);

          /*echo $nConta."<br>";
          if($nConta==4362){
  //db_criatabela($rsMovi21);
}
//echo pg_last_error();*/


          if (pg_num_rows($rsMovi21) != 0) {

            for ($iCont21 = 0; $iCont21 < pg_num_rows($rsMovi21); $iCont21++) {

              $oMovi = db_utils::fieldsMemory($rsMovi21, $iCont21);


              $nValor = $oMovi->valorentrsaida;

              if ($oMovi->codctbtransf != 0 && $oMovi->codctbtransf != '') {
                $sqlcontatransf = "select  si09_codorgaotce||(c63_banco::integer)::varchar||(c63_agencia::integer)::varchar||c63_dvagencia||(c63_conta::integer)::varchar||
										             c63_dvconta||case when db83_tipoconta in (2,3) then 2 else 1 end as contadebito,
										             o15_codtri
										       from saltes
										       join conplanoreduz on k13_reduz = c61_reduz and c61_anousu = " . db_getsession("DB_anousu") . "
										       join conplanoconta on c63_codcon = c61_codcon and c63_anousu = c61_anousu
										       join orctiporec on c61_codigo = o15_codigo
										  left join conplanocontabancaria on c56_codcon = c61_codcon and c56_anousu = c61_anousu
										  left join contabancaria on c56_contabancaria = db83_sequencial
										  left join infocomplementaresinstit on si09_instit = c61_instit
										    where k13_reduz = {$oMovi->codctbtransf}";

                $rsConta = db_query($sqlcontatransf);//echo $sqlcontatransf;db_criatabela($rsConta);
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
                  //$recurso = db_utils::fieldsMemory($rsConta, 0)->o15_codtri;
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
                $oDadosMovi21->si97_codreduzidomov = $oMovi->codreduzido . "0" . $oMovi->tipomovimentacao;
                $oDadosMovi21->si97_tipomovimentacao = $oMovi->tipomovimentacao;
                $oDadosMovi21->si97_tipoentrsaida = (($iCodSis == 5) || ($oCtb20->si96_codctb == $conta) || ($oMovi->retencao == 1 && $oMovi->tipoentrsaida == 8)) ? '99' : $oMovi->tipoentrsaida;
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
              $sSql = "select 22 as tiporegistro,
								       c74_codlan as codreduzdio,
								       case when substr(o57_fonte,1,2) = '49' then 1
								            else 2
								        end as ededucaodereceita,
								       case when substr(o57_fonte,1,2) = '49' then substr(o57_fonte,2,2)
								            else null
								        end as identificadordeducao,
								        case when substr(o57_fonte,1,2) = '49' then substr(o57_fonte,4,8)
								        else substr(o57_fonte,2,8) end as naturezaReceita,
								       c70_valor as vlrreceitacont
								     from conlancamrec
								     join conlancam on c70_codlan = c74_codlan and c70_anousu = c74_anousu
								left join orcreceita on c74_codrec = o70_codrec and o70_anousu = " . db_getsession("DB_anousu") . "
								left join orcfontes on o70_codfon = o57_codfon and o70_anousu = o57_anousu
								left join orctiporec on o15_codigo = o70_codigo
								    where c74_codlan = {$oMovi->codreduzido}";

              $rsReceita = db_query($sSql);//echo $sSql;db_criatabela($rsReceita);
              $aTipoEntSaida = array('1', '2', '3', '15', '16');
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
      //echo pg_last_error();
      //echo "<pre>";print_r($oCtb20);

      /**
       * inclusão do registro 20 e 21 do procedimento normal
       */
      foreach ($aCtb20Agrupado as $oCtb20) {
        $cCtb20 = new cl_ctb202018();
        $sql = "select * from  acertactb where si95_codtceant =".$oCtb20->si96_codctb ;
        $rsCtb = db_query($sql);
        $alterarAplicacao = false;
        if (db_getsession("DB_anousu")==2018 && $this->sDataFinal['5'] . $this->sDataFinal['6']==1 && pg_num_rows($rsCtb) != 0) {
            $oCtb = db_utils::fieldsMemory($rsCtb,0);
            $alterarAplicacao = true;
        }
        $cCtb20->si96_tiporegistro = $oCtb20->si96_tiporegistro;
        $cCtb20->si96_codorgao = $oCtb20->si96_codorgao;
        $cCtb20->si96_codctb = $oCtb20->si96_codctb;
        $cCtb20->si96_codfontrecursos = $oCtb20->si96_codfontrecursos;
        $cCtb20->si96_vlsaldoinicialfonte = $oCtb20->si96_vlsaldoinicialfonte;
        if(db_getsession("DB_anousu")==2018 && $this->sDataFinal['5'] . $this->sDataFinal['6']==1 && $alterarAplicacao)
            $cCtb20->si96_vlsaldofinalfonte = 0;
        else
            $cCtb20->si96_vlsaldofinalfonte = $oCtb20->si96_vlsaldofinalfonte;
        $cCtb20->si96_mes = $oCtb20->si96_mes;
        $cCtb20->si96_instit = $oCtb20->si96_instit;
        $cCtb20->incluir(null);
        if ($cCtb20->erro_status == 0) {
              throw new Exception($cCtb20->erro_msg);
        }
        if( db_getsession("DB_anousu")==2018 && $this->sDataFinal['5'] . $this->sDataFinal['6']==1 && $alterarAplicacao){
            if($oCtb20->si96_vlsaldoinicialfonte != 0) {

                //criar o movimento de saldo do saldo da conta de origem
                $cCtb21alt = new cl_ctb212018();
                $cCtb21alt->si97_tiporegistro = 21;
                $cCtb21alt->si97_codctb = $oCtb20->si96_codctb;
                $cCtb21alt->si97_codfontrecursos = $cCtb20->si96_codfontrecursos;
                $cCtb21alt->si97_codreduzidomov = $cCtb20->si96_sequencial . "6";
                $cCtb21alt->si97_tipomovimentacao = 2;
                $cCtb21alt->si97_tipoentrsaida = 6;
                $cCtb21alt->si97_valorentrsaida = abs($oCtb20->si96_vlsaldofinalfonte);
                $cCtb21alt->si97_codctbtransf = $oCtb->si95_reduz;
                $cCtb21alt->si97_codfontectbtransf = $oCtb20->si96_codfontrecursos;
                $cCtb21alt->si97_mes = $oCtb20->si96_mes;
                $cCtb21alt->si97_reg20 = $cCtb20->si96_sequencial;
                $cCtb21alt->si97_instit = $oCtb20->si96_instit;

                $cCtb21alt->incluir(null);
                if ($cCtb21alt->erro_status == 0) {

                    throw new Exception($cCtb21alt->erro_msg);
                }
            }
        }

        if(db_getsession("DB_anousu")==2018 && $this->sDataFinal['5'] . $this->sDataFinal['6']==1  ){

            if ($alterarAplicacao) {

                $cCtb20alt = new cl_ctb202018();
                $cCtb20alt->si96_tiporegistro = $oCtb20->si96_tiporegistro;
                $cCtb20alt->si96_codorgao = $oCtb20->si96_codorgao;
                $cCtb20alt->si96_codctb = $oCtb->si95_reduz;
                $cCtb20alt->si96_codfontrecursos = $oCtb20->si96_codfontrecursos;
                $cCtb20alt->si96_vlsaldoinicialfonte = 0;
                $cCtb20alt->si96_vlsaldofinalfonte = $oCtb20->si96_vlsaldofinalfonte;
                $cCtb20alt->si96_mes = $oCtb20->si96_mes;
                $cCtb20alt->si96_instit = $oCtb20->si96_instit;
                $cCtb20alt->incluir(null);
                if ($cCtb20alt->erro_status == 0) {
                    throw new Exception($cCtb20alt->erro_msg);
                }
                if($oCtb20->si96_vlsaldoinicialfonte != 0) {
                    //zerar o saldo da conta de origem
                    $cCtb20alt->si96_vlsaldofinalfonte = 0;

                    //criar um moviemnto de entrada na conta de destino
                    $cCtb21alt2 = new cl_ctb212018();
                    $cCtb21alt2->si97_tiporegistro = 21;
                    $cCtb21alt2->si97_codctb = $oCtb->si95_reduz;
                    $cCtb21alt2->si97_codfontrecursos = $cCtb20alt->si96_codfontrecursos;
                    $cCtb21alt2->si97_codreduzidomov = $cCtb20alt->si96_sequencial . "5";
                    $cCtb21alt2->si97_tipomovimentacao = 1;
                    $cCtb21alt2->si97_tipoentrsaida = 5;
                    $cCtb21alt2->si97_valorentrsaida = abs($oCtb20->si96_vlsaldofinalfonte);
                    $cCtb21alt2->si97_codctbtransf = $oCtb20->si96_codctb;
                    $cCtb21alt2->si97_codfontectbtransf = $oCtb20->si96_codfontrecursos;
                    $cCtb21alt2->si97_mes = $oCtb20->si96_mes;
                    $cCtb21alt2->si97_reg20 = $cCtb20alt->si96_sequencial;
                    $cCtb21alt2->si97_instit = $oCtb20->si96_instit;

                    $cCtb21alt2->incluir(null);
                    if ($cCtb21alt2->erro_status == 0) {

                        throw new Exception($cCtb21alt2->erro_msg);
                    }
                }
            }
        }



        foreach ($oCtb20->ext21 as $oCtb21agrupado) {

          $cCtb21 = new cl_ctb212018();

          $cCtb21->si97_tiporegistro = $oCtb21agrupado->si97_tiporegistro;
          $cCtb21->si97_codctb = $oCtb21agrupado->si97_codctb;
          $cCtb21->si97_codfontrecursos = $oCtb21agrupado->si97_codfontrecursos;
          $cCtb21->si97_codreduzidomov = $oCtb21agrupado->si97_codreduzidomov;
          $cCtb21->si97_tipomovimentacao = $oCtb21agrupado->si97_tipomovimentacao;
          $cCtb21->si97_tipoentrsaida = $oCtb21agrupado->si97_tipoentrsaida;
          $cCtb21->si97_valorentrsaida = abs($oCtb21agrupado->si97_valorentrsaida);
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

            $cCtb22 = new cl_ctb222018();

            $cCtb22->si98_tiporegistro = $oCtb22Agrupado->si98_tiporegistro;
            $cCtb22->si98_codreduzidomov = $oCtb22Agrupado->si98_codreduzidomov;
            $cCtb22->si98_ededucaodereceita = $oCtb22Agrupado->si98_ededucaodereceita;
            $cCtb22->si98_identificadordeducao = $oCtb22Agrupado->si98_identificadordeducao;
            $cCtb22->si98_naturezareceita = $oCtb22Agrupado->si98_naturezareceita;
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

    }


    /*
     * REGISTRO 50 CONTAS ENCERRADAS
     */

    $sSqlCtbEncerradas = "select 50 as tiporegistro,
							     si09_codorgaotce,
							     k13_reduz as codctb,
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

        $cCtb50 = new cl_ctb502018();

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


    //Procedimento realizado apenas para acerto do ano de 2018
    if(db_getsession("DB_anousu")==2018 && $this->sDataFinal['5'] . $this->sDataFinal['6']==1){
        /*
         * REGISTRO 50 CONTAS ENCERRADAS
         */
        $sSqlCtbEncerradas2 = "select * from  acertactb left join infocomplementaresinstit on si09_instit = ".db_getsession("DB_instit");
        $rsCtbEncerradas2 = db_query($sSqlCtbEncerradas2);
        if (pg_num_rows($rsCtbEncerradas2) != 0) {

            for ($iCont502018 = 0; $iCont502018 < pg_num_rows($rsCtbEncerradas2); $iCont502018++) {

                $oMovi50 = db_utils::fieldsMemory($rsCtbEncerradas2, $iCont502018);

                $cCtb50 = new cl_ctb502018();

                $cCtb50->si102_tiporegistro = 50;
                $cCtb50->si102_codorgao = $oMovi50->si09_codorgaotce;
                $cCtb50->si102_codctb = $oMovi50->si95_codtceant;
                $cCtb50->si102_situacaoconta = 'E';
                $cCtb50->si102_datasituacao = '2018-01-31';
                $cCtb50->si102_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                $cCtb50->si102_instit = db_getsession("DB_instit");

                $cCtb50->incluir(null);
                if ($cCtb50->erro_status == 0) {
                    throw new Exception($cCtb50->erro_msg);
                }

            }

        }
    }


    $oGerarCTB = new GerarCTB();
    $oGerarCTB->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];;
    $oGerarCTB->gerarDados();
  }

}
