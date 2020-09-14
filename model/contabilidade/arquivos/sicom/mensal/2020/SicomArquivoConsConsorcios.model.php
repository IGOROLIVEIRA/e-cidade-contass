<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_consor102020_classe.php");
require_once("classes/db_consor202020_classe.php");
require_once("classes/db_consor302020_classe.php");
require_once("classes/db_consor402020_classe.php");
require_once("classes/db_consor502020_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2020/GerarCONSOR.model.php");

/**
 * gerar arquivo de identificacao da Remessa Sicom Acompanhamento Mensal
 * @author robson
 * @package Contabilidade
 */
class SicomArquivoConsConsorcios extends SicomArquivoBase implements iPadArquivoBaseCSV
{

  /**
   *
   * Codigo do layout. (db_layouttxt.db50_codigo)
   * @var Integer
   */
  protected $iCodigoLayout = 0;

  /**
   *
   * NOme do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'CONSOR';

  /**
   *
   * Contrutor da classe
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
   * selecionar os dados de indentificacao da remessa pra gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados()
  {

    /**
     * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
     */
    $clconsor10 = new cl_consor102020();
    $clconsor20 = new cl_consor202020();
    $clconsor30 = new cl_consor302020();
    $clconsor40 = new cl_consor402020();
    $clconsor50 = new cl_consor502020();

    /**
     * excluir informacoes do mes selecioado
     */
    db_inicio_transacao();

    $result = db_query($clconsor50->sql_query(null, "*", null, "si20_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si20_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clconsor50->excluir(null, "si20_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si20_instit = " . db_getsession("DB_instit"));
      if ($clconsor50->erro_status == 0) {
        throw new Exception($clconsor50->erro_msg);
      }
    }

    $result = db_query($clconsor40->sql_query(null, "*", null, "si19_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']));
    if (pg_num_rows($result) > 0) {
      $clconsor40->excluir(null, "si19_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']);
      if ($clconsor40->erro_status == 0) {
        throw new Exception($clconsor40->erro_msg);
      }
    }

    $result = db_query($clconsor30->sql_query(null, "*", null, "si18_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si18_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clconsor30->excluir(null, "si18_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si18_instit = " . db_getsession("DB_instit"));
      if ($clconsor30->erro_status == 0) {
        throw new Exception($clconsor30->erro_msg);
      }
    }

    $result = db_query($clconsor20->sql_query(null, "*", null, "si17_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si17_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clconsor20->excluir(null, "si17_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si17_instit = " . db_getsession("DB_instit"));
      if ($clconsor20->erro_status == 0) {
        throw new Exception($clconsor20->erro_msg);
      }
    }

    $result = db_query($clconsor10->sql_query(null, "*", null, "si16_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']) . " and si16_instit = " . db_getsession("DB_instit"));
    if (pg_num_rows($result) > 0) {
      $clconsor10->excluir(null, "si16_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si16_instit = " . db_getsession("DB_instit"));
      if ($clconsor10->erro_status == 0) {
        throw new Exception($clconsor10->erro_msg);
      }
    }

    if ($this->sDataFinal['5'] . $this->sDataFinal['6'] == 01) {
      $sSql = "select si09_codorgaotce,z01_cgccpf,c200_areaatuacao,c200_descrarea,c200_dataadesao from consconsorcios join cgm on z01_numcgm = c200_numcgm
      join db_config on c200_instit = codigo join infocomplementaresinstit on codigo = si09_instit where c200_instit = " . db_getsession("DB_instit")."
      and extract(MONTH from c200_dataadesao) = '".$this->sDataFinal['5'] . $this->sDataFinal['6']."'
      and extract(YEAR from c200_dataadesao)='".$this->sDataFinal['0'] . $this->sDataFinal['1']. $this->sDataFinal['2']. $this->sDataFinal['3']."'";
    } else {
      $sSql = "select si09_codorgaotce,z01_cgccpf,c200_areaatuacao,c200_descrarea from consconsorcios join cgm on z01_numcgm = c200_numcgm
      join db_config on c200_instit = codigo join infocomplementaresinstit on codigo = si09_instit
      where c200_dataadesao >= '{$this->sDataInicial}' and c200_dataadesao <= '{$this->sDataFinal}' and c200_instit = " . db_getsession("DB_instit");
    }

    $rsResult10 = db_query($sSql);
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

      $clconsor10 = new cl_consor102020();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
      $clconsor10->si16_tiporegistro = 10;
      $clconsor10->si16_codorgao = $oDados10->si09_codorgaotce;
      $clconsor10->si16_cnpjconsorcio = $oDados10->z01_cgccpf;
      $clconsor10->si16_areaatuacao = $oDados10->c200_areaatuacao;
      $clconsor10->si16_descareaatuacao = $oDados10->c200_areaatuacao == '99' ? $oDados10->c200_descrarea : '0';
      $clconsor10->si16_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clconsor10->si16_instit = db_getsession("DB_instit");

      $clconsor10->incluir(null);
      if ($clconsor10->erro_status == 0) {
        throw new Exception($clconsor10->erro_msg);
      }

    }

    $sSql = "select si09_codorgaotce, z01_cgccpf,c201_valortransf,c201_enviourelatorios,c201_codfontrecursos from consvalorestransf
		join consconsorcios on c201_consconsorcios = c200_sequencial
		join cgm on c200_numcgm = z01_numcgm
		join db_config on c200_instit = codigo
		join infocomplementaresinstit on codigo = si09_instit where c201_anousu = " . db_getsession("DB_anousu") . "
		and c201_mescompetencia = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and c200_instit = " . db_getsession("DB_instit");
    $rsResult20 = db_query($sSql);//db_criatabela($rsResult20);
    /**
     * registro 20
     */
    for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {

      $clconsor20 = new cl_consor202020();
      $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);

      $clconsor20->si17_tiporegistro = 20;
      $clconsor20->si17_codorgao = $oDados20->si09_codorgaotce;
      $clconsor20->si17_cnpjconsorcio = $oDados20->z01_cgccpf;
      $clconsor20->si17_codfontrecursos = $oDados20->c201_codfontrecursos;
      $clconsor20->si17_vltransfrateio = $oDados20->c201_valortransf;
      $clconsor20->si17_prestcontas = $oDados20->c201_enviourelatorios == 't' ? 1 : 2;
      $clconsor20->si17_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clconsor20->si17_instit = db_getsession("DB_instit");

      $clconsor20->incluir(null);
      if ($clconsor20->erro_status == 0) {
        throw new Exception($clconsor20->erro_msg);
      }

    }
    $sSql = " select * from(
              select *,
                (select c201_enviourelatorios 
                from consvalorestransf
                where c201_consconsorcios = c202_consconsorcios
                  and c201_anousu = c202_anousu
                  and c201_codfontrecursos = c202_codfontrecursos 
                  limit 1) as c201_enviourelatorios
                  from
                  (select si09_codorgaotce, z01_cgccpf, consexecucaoorc.* 
                    from consexecucaoorc
                      join consconsorcios on c202_consconsorcios = c200_sequencial
                      join cgm on c200_numcgm = z01_numcgm join db_config on c200_instit = codigo
                      join infocomplementaresinstit on codigo = si09_instit
                    where c202_anousu = " . db_getsession("DB_anousu") . " and c202_mesreferenciasicom  = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
                    and c200_instit = " . db_getsession("DB_instit") .") as x) as xx where c201_enviourelatorios = 't'";
    $rsResult30 = db_query($sSql);//db_criatabela($rsResult30);
    /**
     * registro 30
     */
    for ($iCont30 = 0; $iCont30 < pg_num_rows($rsResult30); $iCont30++) {

      $clconsor30 = new cl_consor302020();
      $oDados30 = db_utils::fieldsMemory($rsResult30, $iCont30);

      $clconsor30->si18_tiporegistro = 30;
      $clconsor30->si18_cnpjconsorcio = $oDados30->z01_cgccpf;
      $clconsor30->si18_mesreferencia = $oDados30->c202_mescompetencia;
      $clconsor30->si18_codfuncao = $oDados30->c202_funcao;
      $clconsor30->si18_codsubfuncao = $oDados30->c202_subfuncao;
      $clconsor30->si18_naturezadespesa = substr($oDados30->c202_elemento, 0, 6);
      $clconsor30->si18_subelemento = substr($oDados30->c202_elemento, 6, 2);
      $clconsor30->si18_codfontrecursos = $oDados30->c202_codfontrecursos;
      $clconsor30->si18_vlempenhadofonte = $oDados30->c202_valorempenhado;
      $clconsor30->si18_vlanulacaoempenhofonte = $oDados30->c202_valorempenhadoanu;
      $clconsor30->si18_vlliquidadofonte = $oDados30->c202_valorliquidado;
      $clconsor30->si18_vlanulacaoliquidacaofonte = $oDados30->c202_valorliquidadoanu;
      $clconsor30->si18_vlpagofonte = $oDados30->c202_valorpago;
      $clconsor30->si18_vlanulacaopagamentofonte = $oDados30->c202_valorpagoanu;
      $clconsor30->si18_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clconsor30->si18_instit = db_getsession("DB_instit");

      $clconsor30->incluir(null);
      if ($clconsor30->erro_status == 0) {
        throw new Exception($clconsor30->erro_msg);
      }

    }

    /**
     * registro gerado apenas no mes de dezembro
     */
    if ($this->sDataFinal['5'] . $this->sDataFinal['6'] == 12) {

      $sSql = "select si09_codorgaotce, z01_cgccpf,c203_valor,c203_codfontrecursos from consdispcaixaano join consconsorcios on c203_consconsorcios = c200_sequencial
		  join cgm on c200_numcgm = z01_numcgm join db_config on c200_instit = codigo
		  join infocomplementaresinstit on codigo = si09_instit where c203_anousu = " . db_getsession("DB_anousu") . " and c200_instit = " . db_getsession("DB_instit");
      $rsResult40 = db_query($sSql);
      /**
       * registro 40
       */
      for ($iCont40 = 0; $iCont40 < pg_num_rows($rsResult40); $iCont40++) {

        $clconsor40 = new cl_consor402020();
        $oDados40 = db_utils::fieldsMemory($rsResult40, $iCont40);

        $clconsor40->si19_tiporegistro = 40;
        $clconsor40->si19_cnpjconsorcio = $oDados40->z01_cgccpf;
        $clconsor40->si19_codfontrecursos = $oDados40->c203_codfontrecursos;
        $clconsor40->si19_vldispcaixa = $oDados40->c203_valor;
        $clconsor40->si19_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $clconsor40->si19_instit = db_getsession("DB_instit");

        $clconsor40->incluir(null);
        if ($clconsor40->erro_status == 0) {
          throw new Exception($clconsor40->erro_msg);
        }

      }

    }

    $sSql = "select si09_codorgaotce, z01_cgccpf,c204_tipoencerramento,c204_dataencerramento from consretiradaexclusao
		join consconsorcios on c204_consconsorcios = c200_sequencial
		join cgm on c200_numcgm = z01_numcgm join db_config on c200_instit = codigo
		join infocomplementaresinstit on codigo = si09_instit
		where c204_dataencerramento is not null
		and c204_dataencerramento >= '{$this->sDataInicial}' and c204_dataencerramento <= '{$this->sDataFinal}' and c200_instit = " . db_getsession("DB_instit");
    $rsResult50 = db_query($sSql);

    for ($iCont50 = 0; $iCont50 < pg_num_rows($rsResult50); $iCont50++) {

      $clconsor50 = new cl_consor502020();
      $oDados50 = db_utils::fieldsMemory($rsResult50, $iCont50);

      $clconsor50->si20_tiporegistro = 50;
      $clconsor50->si20_codorgao = $oDados50->si09_codorgaotce;
      $clconsor50->si20_cnpjconsorcio = $oDados50->z01_cgccpf;
      $clconsor50->si20_tipoencerramento = $oDados50->c204_tipoencerramento;
      $clconsor50->si20_dtencerramento = $oDados50->c204_dataencerramento;
      $clconsor50->si20_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clconsor50->si20_instit = db_getsession("DB_instit");

      $clconsor50->incluir(null);
      if ($clconsor50->erro_status == 0) {
        throw new Exception($clconsor50->erro_msg);
      }

    }

    db_fim_transacao();

    $oGerarCONSOR = new GerarCONSOR();
    $oGerarCONSOR->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarCONSOR->gerarDados();

  }

}
