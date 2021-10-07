<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_ctb102021_classe.php");
require_once("classes/db_ctb202021_classe.php");
require_once("classes/db_ctb212021_classe.php");
require_once("classes/db_ctb222021_classe.php");
require_once("classes/db_ctb302021_classe.php");
require_once("classes/db_ctb312021_classe.php");
require_once("classes/db_ctb402021_classe.php");
require_once("classes/db_ctb412021_classe.php");
require_once("classes/db_ctb502021_classe.php");
require_once("classes/db_ctb602021_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2021/GerarCTB.model.php");


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
   * @var array Tipo Entrada/Saída que devem informar conta
   */
  protected $aTiposObrigConta = array(5,6,7,9);

  /**
   * @var array Tipo Entrada/Saída que devem informar fonte
   */
  protected $aTiposObrigFonte = array(5,6,7,9,11,18);

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


    $cCtb10 = new cl_ctb102021();
    $cCtb20 = new cl_ctb202021();
    $cCtb21 = new cl_ctb212021();
    $cCtb22 = new cl_ctb222021();
    $cCtb30 = new cl_ctb302021();
    $cCtb31 = new cl_ctb312021();
    $cCtb40 = new cl_ctb402021();
    $cCtb41 = new cl_ctb412021();
    $cCtb50 = new cl_ctb502021();

    // matriz de entrada
    $what = array("°",chr(13),chr(10), 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','Ã','É','Í','Ó','Ú','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º' );

    // matriz de saída
    $by   = array('','','', 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','A','E','I','O','U','n','n','c','C',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ' );

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
                     		 o15_codtri as recurso,
							 CASE WHEN substr(c60_estrut, 1, 3) = '111'
								  	AND substr(c60_estrut, 1, 7) != '1111101'
								  	AND substr(c60_estrut, 1, 7) != '1111102'
								  	AND substr(c60_estrut, 1, 6) != '111113'
								  	AND substr(c60_estrut, 1, 7) != '1112101'
								  THEN 1
								ELSE 2
							 END AS saldocec
				       from saltes
				       join conplanoreduz on k13_reduz = c61_reduz and c61_anousu = " . db_getsession("DB_anousu") . "
				       join conplanoconta on c63_codcon = c61_codcon and c63_anousu = c61_anousu
					   join conplano on c60_codcon = c61_codcon and c60_anousu = c61_anousu
				       join orctiporec on c61_codigo = o15_codigo
				  left join conplanocontabancaria on c56_codcon = c61_codcon and c56_anousu = c61_anousu
				  left join contabancaria on c56_contabancaria = db83_sequencial
				  left join convconvenios on db83_numconvenio = c206_sequencial
				  left join infocomplementaresinstit on si09_instit = c61_instit ";
    if( db_getsession("DB_anousu") == 2021 && $this->sDataFinal['5'] . $this->sDataFinal['6'] == 1 ) {
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

          $cCtb10 = new cl_ctb102021();


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
          $cCtb10->si95_desccontabancaria = preg_replace("/[^a-zA-Z0-9 ]/", "",str_replace($what, $by,  substr($oRegistro10->desccontabancaria, 0, 50)));
          $cCtb10->si95_contaconvenio = $oRegistro10->contaconvenio;
          $cCtb10->si95_nroconvenio = $oRegistro10->nroconvenio;
          $cCtb10->si95_dataassinaturaconvenio = $oRegistro10->dataassinaturaconvenio;
          $cCtb10->si95_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
          $cCtb10->si95_instit = db_getsession("DB_instit");
          $cCtb10->recurso = $oRegistro10->recurso;
          $cCtb10->contas = array();

          $sSqlVerifica = "SELECT 'ctb102021' AS ano, si95_codctb, si95_nroconvenio FROM ctb102021 ";
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
          $sSqlVerifica .= " SELECT 'ctb102020' AS ano, si95_codctb, si95_nroconvenio FROM ctb102020 ";
          $sSqlVerifica .= " WHERE si95_codorgao::int = $oRegistro10->si09_codorgaotce
                               AND si95_banco = '$oRegistro10->c63_banco'
                               AND si95_agencia = '$oRegistro10->c63_agencia'
                               AND si95_digitoverificadoragencia = '$oRegistro10->c63_dvagencia'
                               AND si95_contabancaria = '$oRegistro10->c63_conta'
                               AND si95_digitoverificadorcontabancaria = '$oRegistro10->c63_dvconta'
                               AND si95_tipoconta::int = $oRegistro10->tipoconta
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
          * Adicionada consulta abaixo para verificaÃ§Ã£o da data de cadastro da conta
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
           * condiÃ§Ã£o adicionada para criar um registro das contas bancaria de aplicaÃ§Ã£o que foram alteradas o tipo de aplicaÃ§Ã£o no MES de 01/2018
           * a tabela acertactb serÃ¡ preenchida pelo menu CONTABILAIDE > PROCEDIMENTOS > DUPLICAR CTB
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
           * VerificaÃ§Ã£o se a data de cadastro da conta estÃ¡ dentro do perÃ­odo de geraÃ§Ã£o do arquivo.
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
		  $oConta->saldocec = $oRegistro10->saldocec;

		  $cCtb10->contas[] = $oConta;
          $aBancosAgrupados[$aHash] = $cCtb10;

        } else {
			$oConta = new stdClass();
			$oConta->codctb 	= $oRegistro10->codctb;
			$oConta->saldocec = $oRegistro10->saldocec;

			$aBancosAgrupados[$aHash]->contas[] = $oConta;
        }


      } else {
        /*
         * FALTA AGRUPA AS CONTAS QUANDO A INSTIUICAO FOR IGUAL A 5 RPPS
         */
      }

    }

    //echo "<pre>";print_r($aContasDoMes);
    foreach ($aBancosAgrupados as $oContaAgrupada) {

      //if ($oContaAgrupada->contas == $oCtasValidas->codctb) {}

      $nMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $aCtb20Agrupado = array();
      $oCtb20FontRec = new stdClass();
      foreach ($oContaAgrupada->contas as $oConta) {


        $sSql20Fonte = "select distinct codctb,
                                fontemovimento
                                from (
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
          $iFonteMovimento = db_utils::fieldsMemory($rsReg20Fonte, $iCont20)->fontemovimento;

          $sSqlMov = "select
						round(substr(fc_saldoctbfonte(" . db_getsession("DB_anousu") . ",$oConta->codctb,'" . $iFonteMovimento . "'," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),29,15)::float8,2)::float8 as saldo_anterior,
						round(substr(fc_saldoctbfonte(" . db_getsession("DB_anousu") . ",$oConta->codctb,'" . $iFonteMovimento . "'," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),43,15)::float8,2)::float8 as debitomes,
						round(substr(fc_saldoctbfonte(" . db_getsession("DB_anousu") . ",$oConta->codctb,'" . $iFonteMovimento . "'," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),57,15)::float8,2)::float8 as creditomes,
						round(substr(fc_saldoctbfonte(" . db_getsession("DB_anousu") . ",$oConta->codctb,'" . $iFonteMovimento . "'," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),72,15)::float8,2)::float8 as saldo_final,
						substr(fc_saldoctbfonte(" . db_getsession("DB_anousu") . ",$oConta->codctb,'" . $iFonteMovimento . "'," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),87,1)::varchar(1) as  sinalanterior,
						substr(fc_saldoctbfonte(" . db_getsession("DB_anousu") . ",$oConta->codctb,'" . $iFonteMovimento . "'," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),89,1)::varchar(1) as  sinalfinal ";
          $rsTotalMov = db_query($sSqlMov) or die($sSqlMov);
          //db_criatabela($rsTotalMov);
          //echo $sSqlMov;
          $oTotalMov = db_utils::fieldsMemory($rsTotalMov);

          $iFonte = (in_array($iFonteMovimento, $this->aFontesEncerradas)) ? substr($iFonteMovimento,0,1).'59' : $iFonteMovimento;

          $sHash20 = $oContaAgrupada->si95_codctb . $iFonte;
          if (!$aCtb20Agrupado[$sHash20]) {

            $oCtb20 = new stdClass();
            $oCtb20->si96_tiporegistro = '20';
            $oCtb20->si96_codorgao = $oContaAgrupada->si95_codorgao;
            $oCtb20->si96_codctb = $oContaAgrupada->si95_codctb;
            $oCtb20->si96_codfontrecursos = $iFonte;
			$oCtb20->si96_saldocec = $oConta->saldocec;
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

          $sSqlReg21 = "SELECT * FROM
                             (SELECT '21' AS tiporegistro,
                                     c71_codlan AS codreduzido,
                                     contacredito.c61_reduz AS codctb,
									 conplanodebito.c60_codsis as codsisctb,
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
                                                   LIMIT 1) = 2  THEN 13
                                         WHEN c71_coddoc IN (141, 140) AND bancodebito.c63_tipoconta = 1 AND bancocredito.c63_tipoconta IN (2, 3)
                                              AND k131_concarpeculiar = '095' THEN 95
                                         WHEN c71_coddoc IN (141, 140) AND bancodebito.c63_tipoconta = 1 AND bancocredito.c63_tipoconta IN (2, 3) THEN 7
                                         WHEN c71_coddoc IN (141, 140) AND bancodebito.c63_tipoconta IN (2, 3) AND bancocredito.c63_tipoconta = 1 THEN 9
                                         WHEN c71_coddoc IN (141, 140) THEN 6
                                         ELSE 99
                                     END AS tipoentrsaida,
                                     substr(o57_fonte,0,3) AS rubrica,
                                     conlancamval.c69_valor AS valorentrsaida,
									 CASE
										WHEN substr(conplanocredito.c60_estrut, 1, 3) = '111'
											AND substr(conplanocredito.c60_estrut, 1, 7) != '1111101'
											AND substr(conplanocredito.c60_estrut, 1, 7) != '1111102'
											AND substr(conplanocredito.c60_estrut, 1, 6) != '111113'
											AND substr(conplanocredito.c60_estrut, 1, 7) != '1112101' THEN 1
										ELSE 2
									END AS saldocec,
                                     CASE
                                         WHEN c71_coddoc IN (140, 141) THEN contadebito.c61_reduz
                                         ELSE 0
                                     END AS codctbtransf,
                                     CASE
                                         WHEN c71_coddoc IN (140, 141) THEN contacreditofonte.o15_codtri
                                         ELSE '0'
                                     END AS codfontectbtransf,
									 CASE
    									WHEN c71_coddoc IN (140, 141) THEN CASE
                                      		WHEN substr(conplanodebito.c60_estrut, 1, 3) = '111'
                                           		AND substr(conplanodebito.c60_estrut, 1, 7) != '1111101'
                                           		AND substr(conplanodebito.c60_estrut, 1, 7) != '1111102'
                                           		AND substr(conplanodebito.c60_estrut, 1, 6) != '111113'
                                           		AND substr(conplanodebito.c60_estrut, 1, 7) != '1112101' THEN 1
                                      		ELSE 2
                                  			END
    									ELSE 0
									END AS saldocectransf,
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
                                     END AS retencao, k131_concarpeculiar
                             FROM conlancamdoc
                             INNER JOIN conlancamval ON conlancamval.c69_codlan = conlancamdoc.c71_codlan
                             INNER JOIN conplanoreduz contadebito ON contadebito.c61_reduz = conlancamval.c69_debito AND contadebito.c61_anousu = conlancamval.c69_anousu
                             LEFT JOIN conplanoconta bancodebito ON (bancodebito.c63_codcon, bancodebito.c63_anousu) = (contadebito.c61_codcon, contadebito.c61_anousu)
                             AND contadebito.c61_reduz = conlancamval.c69_debito
                             INNER JOIN conplanoreduz contacredito ON contacredito.c61_reduz = conlancamval.c69_credito AND contacredito.c61_anousu = conlancamval.c69_anousu
							 INNER JOIN conplano conplanocredito ON contacredito.c61_codcon = conplanocredito.c60_codcon and contacredito.c61_anousu = conplanocredito.c60_anousu
     	 					 INNER JOIN conplano conplanodebito ON contacredito.c61_codcon = conplanodebito.c60_codcon and contacredito.c61_anousu = conplanodebito.c60_anousu
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
                             LEFT JOIN conlancamslip ON c71_codlan=c84_conlancam
                             LEFT JOIN slipconcarpeculiar on k131_slip=c84_slip and k131_tipo=2
                             WHERE DATE_PART('YEAR',conlancamdoc.c71_data) = " . db_getsession("DB_anousu") . "
                               AND DATE_PART('MONTH',conlancamdoc.c71_data) = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
                               AND conlancamval.c69_credito = {$oConta->codctb}
                             UNION ALL
                             SELECT '21' AS tiporegistro,
                                    c71_codlan AS codreduzido,
                                    contadebito.c61_reduz AS codctb,
									conplanodebito.c60_codsis as codsisctb,
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
                                        WHEN c71_coddoc IN (141, 140) AND bancodebito.c63_tipoconta = 1 AND bancocredito.c63_tipoconta IN (2, 3)
                                        AND k131_concarpeculiar = '096' THEN 96
                                        WHEN c71_coddoc IN (141, 140) AND bancodebito.c63_tipoconta = 1 AND bancocredito.c63_tipoconta IN (2, 3) THEN 7
                                        WHEN c71_coddoc IN (141, 140) AND bancodebito.c63_tipoconta IN (2, 3) AND bancocredito.c63_tipoconta = 1 THEN 9
                                        WHEN c71_coddoc IN (141, 140) THEN 5
                                        ELSE 99
                                    END AS tipoentrsaida,
                                    substr(o57_fonte,0,3) AS rubrica,
									conlancamval.c69_valor AS valorentrsaida,
									CASE
										WHEN substr(conplanocredito.c60_estrut, 1, 3) = '111'
											AND substr(conplanocredito.c60_estrut, 1, 7) != '1111101'
											AND substr(conplanocredito.c60_estrut, 1, 7) != '1111102'
											AND substr(conplanocredito.c60_estrut, 1, 6) != '111113'
											AND substr(conplanocredito.c60_estrut, 1, 7) != '1112101' THEN 1
										ELSE 2
									END AS saldocec,
                                    CASE
                                        WHEN c71_coddoc IN (140, 141) THEN contacredito.c61_reduz
                                        ELSE 0
                                    END AS codctbtransf,
                                    CASE
                                        WHEN c71_coddoc IN (140, 141) THEN contacreditofonte.o15_codtri
                                        ELSE '0'
									END AS codfontectbtransf,
									CASE
    									WHEN c71_coddoc IN (140, 141) THEN CASE
                                      		WHEN substr(conplanodebito.c60_estrut, 1, 3) = '111'
                                           		AND substr(conplanodebito.c60_estrut, 1, 7) != '1111101'
                                           		AND substr(conplanodebito.c60_estrut, 1, 7) != '1111102'
                                           		AND substr(conplanodebito.c60_estrut, 1, 6) != '111113'
                                           		AND substr(conplanodebito.c60_estrut, 1, 7) != '1112101' THEN 1
                                      		ELSE 2
                                  			END
    									ELSE 0
									END AS saldocectransf,
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
                                    END AS retencao, '0' as k131_concarpeculiar
                             FROM conlancamdoc
                             INNER JOIN conlancamval ON conlancamval.c69_codlan = conlancamdoc.c71_codlan
							 INNER JOIN conplanoreduz contadebito ON contadebito.c61_reduz = conlancamval.c69_debito AND contadebito.c61_anousu = conlancamval.c69_anousu
							 INNER JOIN conplano conplanocredito ON contadebito.c61_codcon = conplanocredito.c60_codcon AND contadebito.c61_anousu = conplanocredito.c60_anousu
							 INNER JOIN conplano conplanodebito ON contadebito.c61_codcon = conplanodebito.c60_codcon AND contadebito.c61_anousu = conplanodebito.c60_anousu
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
                             LEFT JOIN conlancamslip ON c71_codlan=c84_conlancam
                             LEFT JOIN slipconcarpeculiar on k131_slip=c84_slip and k131_tipo=1
                             LEFT JOIN conlancamcompl ON c72_codlan = c71_codlan WHERE DATE_PART('YEAR',conlancamdoc.c71_data) = " . db_getsession("DB_anousu") . "
                                  AND DATE_PART('MONTH',conlancamdoc.c71_data) = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " AND conlancamval.c69_debito = {$oConta->codctb} ) AS xx
                        WHERE fontemovimento::integer = $iFonteMovimento";

          $rsMovi21 = db_query($sSqlReg21);


            if (pg_num_rows($rsMovi21) != 0) {

            for ($iCont21 = 0; $iCont21 < pg_num_rows($rsMovi21); $iCont21++) {

              $oMovi = db_utils::fieldsMemory($rsMovi21, $iCont21);

              $nValor = $oMovi->valorentrsaida;

			  $iCodSis     = 0;
			  $conta       = 0;

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
                   * se o c60_codsis for 5, essa Ã© uma conta caixa
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
			  $sHash .= $oMovi->saldocec;
              /**
               * quando o codctb for igual codctbtransf, serÃ¡ agrupado a movimentaÃ§Ã£o no tipoentrsaida 99
               */

			  if ( ($iCodSis != '' || $iCodSis != 0) && ($oMovi->codsisctb == 6 && $iCodSis == 5) && $oMovi->tipomovimentacao == 2 ) {
				$iTipoEntrSaida = '11';
			  } elseif ( ($iCodSis != '' || $iCodSis != 0) && ($oMovi->codsisctb == 6 && $iCodSis == 5) && $oMovi->tipomovimentacao == 1 ) {
				$iTipoEntrSaida = '18';
			  } elseif (($iCodSis == 5) || ($oCtb20->si96_codctb == $conta) || ($oMovi->retencao == 1 && $oMovi->tipoentrsaida == 8)) {
				$iTipoEntrSaida = '99';
			  } else {
				$iTipoEntrSaida = $oMovi->tipoentrsaida;
			  }

              $sHash .= $iTipoEntrSaida;
              $sHash .= (in_array($oMovi->tipoentrsaida, $this->aTiposObrigConta) && ($iCodSis != 5) && ($oCtb20->si96_codctb != $conta)) ? $conta : 0;
              $sHash .= ((in_array($oMovi->tipoentrsaida, $this->aTiposObrigFonte) && ($iCodSis != 5) && ($oCtb20->si96_codctb != $conta)) ? $oMovi->codfontectbtransf : 0);

              if (!isset($oCtb20->ext21[$sHash])) {

                $oDadosMovi21 = new stdClass();

                $oDadosMovi21->si97_tiporegistro = $oMovi->tiporegistro;
                $oDadosMovi21->si97_codctb = $oCtb20->si96_codctb;
                $oDadosMovi21->si97_codfontrecursos = $oCtb20->si96_codfontrecursos;
                $oDadosMovi21->si97_codreduzidomov = $oMovi->codreduzido . "0" . $oMovi->tipomovimentacao;
                $oDadosMovi21->si97_tipomovimentacao = $oMovi->tipomovimentacao;
				$oDadosMovi21->si97_tipoentrsaida = $iTipoEntrSaida;
				$oDadosMovi21->si97_valorentrsaida = $nValor;
				$oDadosMovi21->si97_saldocec = $oMovi->saldocec;
                $oDadosMovi21->si97_dscoutrasmov = ($oMovi->tipoentrsaida == 99 ? 'Recebimento Extra Orcamentario' :
                    ($iTipoEntrSaida == 10 ? 'Estorno de recebimentos' : ' '));
                $oDadosMovi21->si97_codctbtransf = (in_array($iTipoEntrSaida, $this->aTiposObrigConta)
					&& ($iCodSis != 5) && ($oCtb20->si96_codctb != $conta)) ? $conta : 0;
                $oDadosMovi21->si97_codfontectbtransf = (in_array($iTipoEntrSaida, $this->aTiposObrigFonte)
					&& ($iCodSis != 5 || ($iCodSis == 5 && ($iTipoEntrSaida == 11 || $iTipoEntrSaida == 18))) && ($oCtb20->si96_codctb != $conta)) ? $oMovi->codfontectbtransf : 0;
				$oDadosMovi21->si97_saldocectransf = (in_array($iTipoEntrSaida, $this->aTiposObrigFonte)
					&& ($iCodSis != 5 || ($iCodSis == 5 && $iTipoEntrSaida == 11 && $oMovi->tipomovimentacao != 2) ) && ($oCtb20->si96_codctb != $conta)) ? $oMovi->saldocectransf : 0;
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
				  $oDadosReceita->si98_saldocec = $oCtb20->ext21[$sHash]->si97_saldocec;
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

      /**
       * inclusÃ£o do registro 20 e 21 do procedimento normal
       */
      foreach ($aCtb20Agrupado as $oCtb20) {

        $cCtb20 = new cl_ctb202021();

        $cCtb20->si96_tiporegistro = $oCtb20->si96_tiporegistro;
        $cCtb20->si96_codorgao = $oCtb20->si96_codorgao;
        $cCtb20->si96_codctb = $oCtb20->si96_codctb;
		$cCtb20->si96_codfontrecursos = $oCtb20->si96_codfontrecursos;
		$cCtb20->si96_saldocec = $oCtb20->si96_saldocec;
        $cCtb20->si96_vlsaldoinicialfonte = $oCtb20->si96_vlsaldoinicialfonte;
        $cCtb20->si96_vlsaldofinalfonte = $oCtb20->si96_vlsaldofinalfonte;
        $cCtb20->si96_mes = $oCtb20->si96_mes;
        $cCtb20->si96_instit = $oCtb20->si96_instit;

        $cCtb20->incluir(null);
        if ($cCtb20->erro_status == 0) {
              throw new Exception($cCtb20->erro_msg);
        }

        foreach ($oCtb20->ext21 as $oCtb21agrupado) {

          $cCtb21 = new cl_ctb212021();

          $cCtb21->si97_tiporegistro = $oCtb21agrupado->si97_tiporegistro;
          $cCtb21->si97_codctb = $oCtb21agrupado->si97_codctb;
          $cCtb21->si97_codfontrecursos = $oCtb21agrupado->si97_codfontrecursos;
          $cCtb21->si97_codreduzidomov = $oCtb21agrupado->si97_codreduzidomov;
          $cCtb21->si97_tipomovimentacao = $oCtb21agrupado->si97_tipomovimentacao;
          $cCtb21->si97_tipoentrsaida = $oCtb21agrupado->si97_tipoentrsaida;
		  $cCtb21->si97_saldocec = $oCtb21agrupado->si97_saldocec;
          $cCtb21->si97_valorentrsaida = abs($oCtb21agrupado->si97_valorentrsaida);
          $cCtb21->si97_dscoutrasmov = ($oCtb21agrupado->si97_tipoentrsaida == 99 ? 'Recebimento Extra Orcamentario' :
            ($cCtb21->si97_tipoentrsaida == 10 ? $oCtb21agrupado->si97_dscoutrasmov : ' '));
          $cCtb21->si97_codctbtransf = $oCtb21agrupado->si97_codctbtransf;
          $cCtb21->si97_codfontectbtransf = $oCtb21agrupado->si97_codfontectbtransf;
		  $cCtb21->si97_saldocectransf = $oCtb21agrupado->si97_saldocectransf;
		  $cCtb21->si97_mes = $oCtb21agrupado->si97_mes;
          $cCtb21->si97_reg20 = $cCtb20->si96_sequencial;
          $cCtb21->si97_instit = $oCtb21agrupado->si97_instit;

          $cCtb21->incluir(null);
          if ($cCtb21->erro_status == 0) {

            throw new Exception($cCtb21->erro_msg);
          }


          foreach ($oCtb21agrupado->registro22 as $oCtb22Agrupado) {

            $cCtb22 = new cl_ctb222021();

            $cCtb22->si98_tiporegistro = $oCtb22Agrupado->si98_tiporegistro;
            $cCtb22->si98_codreduzidomov = $oCtb22Agrupado->si98_codreduzidomov;
            $cCtb22->si98_ededucaodereceita = $oCtb22Agrupado->si98_ededucaodereceita;
            $cCtb22->si98_identificadordeducao = $oCtb22Agrupado->si98_identificadordeducao;
            $cCtb22->si98_naturezareceita = $oCtb22Agrupado->si98_naturezareceita;
            $cCtb22->si98_codfontrecursos = $oCtb21agrupado->si97_codfontrecursos;
			$cCtb22->si98_saldocec = $oCtb22Agrupado->si98_saldocec;
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
     * REGISTRO 40 ALTERACAO DE CONTAS BANCARIAS
     */
    $rsCtasReg40 = db_query($sSqlGeral);

    if (pg_num_rows($rsCtasReg40) != 0) {

      for ($icont40 = 0; $icont40 < pg_num_rows($rsCtasReg40); $icont40++) {

        $oMovi40 = db_utils::fieldsMemory($rsCtasReg40, $icont40);

        /**
         * Adicionada consulta abaixo para verificaÃ§Ã£o da data de cadastro da conta
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

        $sSqlVerifica = "SELECT 'ctb102021' AS ano, si95_codctb, si95_nroconvenio FROM ctb102021 ";
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
        $sSqlVerifica .= " SELECT 'ctb102020' AS ano, si95_codctb, si95_nroconvenio FROM ctb102020 ";
        $sSqlVerifica .= " WHERE si95_codorgao::int = $oMovi40->si09_codorgaotce
                             AND si95_banco = '$oMovi40->c63_banco'
                             AND si95_agencia = '$oMovi40->c63_agencia'
                             AND si95_digitoverificadoragencia = '$oMovi40->c63_dvagencia'
                             AND si95_contabancaria = '$oMovi40->c63_conta'
                             AND si95_digitoverificadorcontabancaria = '$oMovi40->c63_dvconta'
                             AND si95_tipoconta::int = $oMovi40->tipoconta
                             AND si95_instit = " . db_getsession('DB_instit');
        $sSqlVerifica .= " UNION ";
        $sSqlVerifica .= " SELECT 'ctb102019' AS ano, si95_codctb, si95_nroconvenio::varchar FROM ctb102019 ";
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
        $sSqlVerifica .= " WHERE si95_codorgao::int = '$oMovi40->si09_codorgaotce'
                             AND si95_banco = '$oMovi40->c63_banco'
                             AND si95_agencia = '$oMovi40->c63_agencia'
                             AND si95_digitoverificadoragencia = '$oMovi40->c63_dvagencia'
                             AND si95_contabancaria = '$oMovi40->c63_conta'
                             AND si95_digitoverificadorcontabancaria = '$oMovi40->c63_dvconta'
                             AND si95_tipoconta::int = $oMovi40->tipoconta
							 AND si95_instit = " . db_getsession('DB_instit') . " LIMIT 1";
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

        $sSql40 = "SELECT 'ctb402021' AS ano, ctb402021.* FROM ctb402021
                    WHERE si101_codctb = {$oVerificaReg40->si95_codctb}
                      AND si101_mes <= " . $this->sDataFinal['5'] . $this->sDataFinal['6'] ."
                      AND si101_instit = " . db_getsession('DB_instit');
        $sSql40 .= "UNION ALL ";
        $sSql40 .= "SELECT 'ctb402020' AS ano, ctb402020.* FROM ctb402020
                     WHERE si101_codctb = {$oVerificaReg40->si95_codctb}
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

          $cCtb40 = new cl_ctb402021();

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

        $cCtb50 = new cl_ctb502021();

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


    $oGerarCTB = new GerarCTB();
    $oGerarCTB->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];;
    $oGerarCTB->gerarDados();
  }

}
