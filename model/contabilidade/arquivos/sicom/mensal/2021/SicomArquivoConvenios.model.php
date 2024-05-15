<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_conv102021_classe.php");
require_once("classes/db_conv112021_classe.php");
require_once("classes/db_conv202021_classe.php");
require_once("classes/db_conv212021_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2021/GerarCONV.model.php");

/**
 * selecionar dados de Convenios Sicom Acompanhamento Mensal
 * @author Marcelo
 * @package Contabilidade
 */
class SicomArquivoConvenios extends SicomArquivoBase implements iPadArquivoBaseCSV
{

  /**
   *
   * Codigo do layout
   * @var Integer
   */
  protected $iCodigoLayout;

  /**
   *
   * Nome do arquivo a ser criado
   * @var unknown_type
   */
  protected $sNomeArquivo = 'CONV';

  /*
   * Contrutor da classe
   */
  public function __construct()
  {

  }

  /**
   * retornar o codigo do layout
   *
   * @return Integer
   */
  public function getCodigoLayout()
  {
    return $this->iCodigoLayout;
  }

  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
   * @return Array
   */
  public function getCampos()
  {
  }

  /**
   * selecionar os dados de Leis de Alteração
   *
   */
  public function gerarDados()
  {

    $clconv10 = new cl_conv102021();
    $clconv11 = new cl_conv112021();
    $clconv20 = new cl_conv202021();
    $clconv21 = new cl_conv212021();
    $clconv30 = new cl_conv302021();
    $clconv31 = new cl_conv312021();

    db_inicio_transacao();


    /*
   * excluir informacoes do mes selecionado registro 11
   */
    $result = $clconv11->sql_record($clconv11->sql_query(null, "*", null, "si93_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si93_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {

      $clconv11->excluir(null, "si93_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si93_instit = " . db_getsession("DB_instit"));
      if ($clconv11->erro_status == 0) {
        throw new Exception($clconv11->erro_msg);
      }
    }


    /*
     * excluir informacoes do mes selecionado registro 10
     */

    $result = $clconv10->sql_record($clconv10->sql_query(null, "*", null, "si92_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si92_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clconv10->excluir(null, "si92_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si92_instit = " . db_getsession("DB_instit"));
      if ($clconv10->erro_status == 0) {
        throw new Exception($clconv10->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 20
     */
    $result = $clconv20->sql_record($clconv20->sql_query(null, "*", null, "si94_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si94_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clconv20->excluir(null, "si94_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si94_instit = " . db_getsession("DB_instit"));
      if ($clconv20->erro_status == 0) {
        throw new Exception($clconv20->erro_msg);
      }
    }

      /*
       * excluir informacoes do mes selecionado registro 21
       */
      $result = $clconv21->sql_record($clconv21->sql_query(null, "*", null, "si232_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si232_instint = " . db_getsession("DB_instit")));
      if (pg_num_rows($result) > 0) {
          $clconv21->excluir(null, "si232_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si232_instint = " . db_getsession("DB_instit"));
          if ($clconv21->erro_status == 0) {
              throw new Exception($clconv21->erro_msg);
          }
      }

    /*
     * excluir informacoes do mes selecionado registro 30
     */
    if ($this->sDataInicial[5].$this->sDataInicial[6] == 12) {
        $result = $clconv30->sql_record($clconv30->sql_query(null, "*", null, "si203_mes = {$this->sDataFinal['5']}{$this->sDataFinal['6']} and si203_instit = " . db_getsession("DB_instit")));

        if (pg_num_rows($result) > 0) {
            $clconv30->excluir(null, "si203_mes = {$this->sDataFinal['5']}{$this->sDataFinal['6']} and si203_instit = " . db_getsession("DB_instit"));
            if ($clconv30->erro_status == 0) {
                throw new Exception($clconv30->erro_msg);
            }
        }
    }

    /*
     * excluir informacoes do mes selecionado registro 31
     */

    if ($this->sDataInicial[5].$this->sDataInicial[6] == 12) {
        $result = $clconv31->sql_record($clconv31->sql_query(null, "*", null, "si204_mes = {$this->sDataFinal['5']}{$this->sDataFinal['6']} and si204_instit = " . db_getsession("DB_instit")));

        if (pg_num_rows($result) > 0) {
            $clconv31->excluir(null, "si204_mes = {$this->sDataFinal['5']}{$this->sDataFinal['6']} and si204_instit = " . db_getsession("DB_instit"));
            if ($clconv31->erro_status == 0) {
                throw new Exception($clconv31->erro_msg);
            }
        }
    }

    $sSql = "SELECT si09_codorgaotce AS codorgao
              FROM infocomplementaresinstit
              WHERE si09_instit = " . db_getsession("DB_instit");

    $rsResult = db_query($sSql);
    $sCodorgao = db_utils::fieldsMemory($rsResult, 0)->codorgao;

    /*
     * selecionar informacoes registro 10
     */
    $sSql = "select * from convconvenios inner join orctiporec on o15_codigo = c206_tipocadastro where c206_datacadastro >= '{$this->sDataInicial}' and c206_datacadastro <= '{$this->sDataFinal}' and c206_instit = " . db_getsession("DB_instit");

    $rsResult10 = db_query($sSql);
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

      $clconv10 = new cl_conv102021();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

      $clconv10->si92_tiporegistro = 10;
      $clconv10->si92_codconvenio = $oDados10->c206_sequencial;
      $clconv10->si92_codorgao = $sCodorgao;
      $clconv10->si92_nroconvenio = $oDados10->c206_nroconvenio;
      $clconv10->si92_dataassinatura = $oDados10->c206_dataassinatura;
      $clconv10->si92_objetoconvenio = $oDados10->c206_objetoconvenio;
      $clconv10->si92_datainiciovigencia = $oDados10->c206_datainiciovigencia;
      $clconv10->si92_datafinalvigencia = $oDados10->c206_datafinalvigencia;
      $clconv10->si92_codfontrecursos = $oDados10->o15_codtri;
      $clconv10->si92_vlconvenio = $oDados10->c206_vlconvenio;
      $clconv10->si92_vlcontrapartida = $oDados10->c206_vlcontrapartida;
      $clconv10->si92_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clconv10->si92_instit = db_getsession("DB_instit");

      $clconv10->incluir(null);

      if ($clconv10->erro_status == 0) {
        throw new Exception($clconv10->erro_msg);
      }
      /*
       * selecionar informacoes registro 11
       */
      $sSql = "select * from convdetalhaconcedentes cd
               inner join convconvenios cc on cc.c206_sequencial = cd.c207_codconvenio
               where c206_datacadastro >= '{$this->sDataInicial}' and c206_datacadastro <= '{$this->sDataFinal}'
               and c207_codconvenio = '{$oDados10->c206_sequencial}'
               and c206_instit = " . db_getsession("DB_instit");

      $rsResult11 = db_query($sSql);

      for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {

        $clconv11 = new cl_conv112021();
        $oDados11 = db_utils::fieldsMemory($rsResult11, $iCont11);

        $clconv11->si93_tiporegistro = 11;
        $clconv11->si93_codconvenio = $oDados10->c206_sequencial;
        $clconv11->si93_tipodocumento = ($oDados11->c207_esferaconcedente != 4) ? 2 : '';
        $clconv11->si93_nrodocumento = $oDados11->c207_nrodocumento;
        $clconv11->si93_esferaconcedente = $oDados11->c207_esferaconcedente;
        $clconv11->si93_dscexterior = $oDados11->c207_descrconcedente;
        $clconv11->si93_valorconcedido = $oDados11->c207_valorconcedido;
        $clconv11->si93_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $clconv11->si93_reg10 = $clconv10->si92_sequencial;
        $clconv11->si93_instit = db_getsession("DB_instit");

        $clconv11->incluir(null);

        if ($clconv11->erro_status == 0) {
          throw new Exception($clconv11->erro_msg);
        }

      }

    }

    /*
        * selecionar informacoes registro 20 e 21
      */
      $sSql = "select * from convdetalhatermos cdt
               inner join convconvenios cc on cc.c206_sequencial = cdt.c208_codconvenio
               where c208_datacadastro >= '{$this->sDataInicial}' and c208_datacadastro <= '{$this->sDataFinal}'
               and c206_instit = " . db_getsession("DB_instit");

      $rsResult20 = db_query($sSql);

      for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {

        $clconv20 = new cl_conv202021();
        $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);

        $clconv20->si94_tiporegistro = 20;
        $clconv20->si94_codorgao = $sCodorgao;
        $clconv20->si94_nroconvenio = $oDados20->c206_nroconvenio;
        $clconv20->si94_dtassinaturaconvoriginal = $oDados20->c206_dataassinatura;
        $clconv20->si94_nroseqtermoaditivo = $oDados20->c208_nroseqtermo;
        $clconv20->si94_dscalteracao = $oDados20->c208_dscalteracao;
        $clconv20->si94_codconvaditivo = $oDados20->c206_sequencial.$oDados20->c208_sequencial;
        $clconv20->si94_dtassinaturatermoaditivo = $oDados20->c208_dataassinaturatermoaditivo;
        $clconv20->si94_datafinalvigencia = $oDados20->c208_datafinalvigencia;
        $clconv20->si94_valoratualizadoconvenio = $oDados20->c208_valoratualizadoconvenio;
        $clconv20->si94_valoratualizadocontrapartida = $oDados20->c208_valoratualizadocontrapartida;
        $clconv20->si94_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $clconv20->si94_instit = db_getsession("DB_instit");

        $clconv20->incluir(null);
        if ($clconv20->erro_status == 0) {
          throw new Exception($clconv20->erro_msg);
        }

        $clconv21 = new cl_conv212021();
        $clconv21->si232_tiporegistro = 21;
        $clconv21->si232_codconvaditivo = $oDados20->c206_sequencial.$oDados20->c208_sequencial;
        $clconv21->si232_tipotermoaditivo = $oDados20->c208_tipotermoaditivo;
        $clconv21->si232_dsctipotermoaditivo = $oDados20->c208_dsctipotermoaditivo;
        $clconv21->si232_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $clconv21->si232_instint = db_getsession("DB_instit");

        $clconv21->incluir(null);
        if ($clconv21->erro_status == 0) {
            throw new Exception($clconv21->erro_msg);
        }

      }

      /*
       * selecionar informacoes registro 30 e 31
       */
      if ($this->sDataInicial[5].$this->sDataInicial[6] == 12) {

		$iAnoUsu = db_getsession('DB_anousu');
		$iInstit = db_getsession("DB_instit");

        $sSql = " 	SELECT  o57_fonte,
							o57_descr,
							o70_codigo,
							o70_valor,
							o70_codrec,
							c229_vlprevisto,
							CAST(coalesce(nullif(substr(fc_receitasaldo,55,12),''),'0') AS float8) AS saldo_arrecadado,
							c229_semassinatura
					FROM
						(SELECT o57_fonte,
								o57_descr,
								o70_codigo,
								o70_valor,
								o70_codrec,
								COALESCE(SUM(c229_vlprevisto),0) c229_vlprevisto,
								fc_receitasaldo({$iAnoUsu},o70_codrec,3,'{$iAnoUsu}-01-01','{$iAnoUsu}-12-31'),
								CASE
									WHEN (COALESCE(SUM(c229_vlprevisto),0) > 0) THEN (o70_valor - COALESCE(SUM(c229_vlprevisto),0))
									ELSE 0
								END AS c229_semassinatura
						FROM orcfontes
							LEFT JOIN orcreceita ON o57_codfon = o70_codfon AND o57_anousu = o70_anousu
							LEFT JOIN prevconvenioreceita ON c229_anousu = o70_anousu AND c229_fonte = o70_codrec
						WHERE o70_codigo IN ('122','123','124','142','163')
							AND o70_anousu = {$iAnoUsu}
							AND o70_instit = {$iInstit}
							AND o70_valor > 0
						GROUP BY 1,2,3,4,5) AS x";

        $rsResult30 = db_query($sSql);

        for ($iCont30 = 0; $iCont30 < pg_num_rows($rsResult30); $iCont30++) {

            $clconv30 = new cl_conv302021();
            $oDados30 = db_utils::fieldsMemory($rsResult30, $iCont30);

            $clconv30->si203_tiporegistro = 30;
            $clconv30->si203_codreceita = $oDados30->o70_codrec;
            $clconv30->si203_codorgao = $sCodorgao;
            $clconv30->si203_naturezareceita = $oDados30->o57_fonte;
            $clconv30->si203_codfontrecursos = $oDados30->o70_codigo;
            $clconv30->si203_vlprevisao = $oDados30->o70_valor;
            $clconv30->si203_mes = 12;
            $clconv30->si203_instit = db_getsession("DB_instit");

            $clconv30->incluir(null);
            if ($clconv30->erro_status == 0) {
                throw new Exception($clconv30->erro_msg);
            }

            if ($oDados30->saldo_arrecadado > 0) {
						
				$sSql31 = " SELECT  o70_codrec,
									c206_sequencial,
									c206_nroconvenio,
									c229_convenio,
									c206_objetoconvenio,
									c206_dataassinatura,
									sum(c229_vlprevisto) AS c229_vlprevisto,
									sum(valor_arrecadado) as valor_arrecadado
							FROM 
								(SELECT	o70_codrec,
										c206_sequencial,
										c206_nroconvenio,
										c229_convenio,
										c206_objetoconvenio,
										c206_dataassinatura,
										sum(c229_vlprevisto) AS c229_vlprevisto,
										0 AS valor_arrecadado
								FROM prevconvenioreceita
									LEFT JOIN orcreceita ON c229_anousu = o70_anousu AND c229_fonte = o70_codrec 
									LEFT JOIN convconvenios ON c206_sequencial = c229_convenio
								WHERE o70_codigo IN ('122','123','124','142')
									AND o70_anousu = {$iAnoUsu}
									AND o70_instit = {$iInstit}
									AND o70_valor > 0
									AND o70_codrec = {$oDados30->o70_codrec}                    
								GROUP BY 1,2,3,4,5
								UNION
								SELECT *
								FROM
									(SELECT o70_codrec,
											c206_sequencial,
											c206_nroconvenio,
											c229_convenio,
											c206_objetoconvenio,
											c206_dataassinatura,
											0 AS c229_vlprevisto,
											round(sum(CASE WHEN c71_coddoc = 100 THEN c70_valor ELSE c70_valor * -1 END),2) AS valor_arrecadado
									FROM orcreceita 
										LEFT JOIN conlancamrec ON c74_anousu = o70_anousu AND c74_codrec = o70_codrec
										INNER JOIN conlancam ON c70_codlan = c74_codlan
										LEFT JOIN conlancamdoc ON c74_codlan = c71_codlan
										LEFT JOIN conlancamcorrente ON c86_conlancam = c74_codlan
										LEFT JOIN corplacaixa ON (k82_id,k82_data,k82_autent) = (c86_id,c86_data,c86_autent)
										LEFT JOIN placaixarec ON k81_seqpla = k82_seqpla
										LEFT JOIN convconvenios ON c206_sequencial = k81_convenio
										LEFT JOIN prevconvenioreceita ON c229_anousu = o70_anousu AND c229_fonte = o70_codrec AND c229_convenio = c206_sequencial
									WHERE o70_codigo IN ('122','123','124','142')
										AND o70_anousu = {$iAnoUsu}
										AND o70_instit = {$iInstit}
										AND o70_valor > 0
										AND o70_codrec = {$oDados30->o70_codrec}
										AND c206_sequencial IS NOT NULL
									GROUP BY 1,2,3,4,5,6) AS x
								WHERE valor_arrecadado > 0) AS xx GROUP BY 1,2,3,4,5,6 ";						
				
				$rsResult31 = db_query($sSql31);

				if (pg_num_rows($rsResult31) > 0) {

					for ($iCont31 = 0; $iCont31 < pg_num_rows($rsResult31); $iCont31++) {

						$clconv31 = new cl_conv312021();
						$oDados31 = db_utils::fieldsMemory($rsResult31, $iCont31);

						$clconv31->si204_tiporegistro = 31;
						$clconv31->si204_codreceita = $oDados31->o70_codrec;
						$clconv31->si204_prevorcamentoassin = $oDados31->valor_arrecadado > 0 ? 1 : 2;
						$clconv31->si204_nroconvenio = "'{$oDados31->c206_nroconvenio}'";
						$clconv31->si204_dataassinatura = "'{$oDados31->c206_dataassinatura}'";
						$clconv31->si204_vlprevisaoconvenio = $oDados31->c229_vlprevisto;
						$clconv31->si204_mes = 12;
						$clconv31->si204_instit = db_getsession("DB_instit");

						$clconv31->incluir(null);
						if ($clconv31->erro_status == 0) {
							throw new Exception($clconv31->erro_msg);
						}

					}

				} 

			}

			$clconv31 = new cl_conv312021();

			$clconv31->si204_tiporegistro = 31;
			$clconv31->si204_codreceita = $oDados30->o70_codrec;
			$clconv31->si204_prevorcamentoassin = 2;
			if ($oDados30->c229_semassinatura > 0 && $oDados30->saldo_arrecadado > 0) {
				$clconv31->si204_vlprevisaoconvenio = $oDados30->c229_semassinatura;
			} else {
				$clconv31->si204_vlprevisaoconvenio = $oDados30->o70_valor;
			}
			$clconv31->si204_mes = 12;
			$clconv31->si204_instit = db_getsession("DB_instit");

			$clconv31->incluir(null);
			if ($clconv31->erro_status == 0) {
				throw new Exception($clconv31->erro_msg);
			}

        }

    }

    db_fim_transacao();

    $oGerarCONV = new GerarCONV();
    $oGerarCONV->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarCONV->gerarDados();

  }

}
