<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_ntf102021_classe.php");
require_once("classes/db_ntf112021_classe.php");
require_once("classes/db_ntf202021_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2021/GerarNTF.model.php");

/**
 * selecionar dados de Notas Fiscais Sicom Acompanhamento Mensal
 * @author robson
 * @package Contabilidade
 */
class SicomArquivoNotasFiscais extends SicomArquivoBase implements iPadArquivoBaseCSV
{

  /**
   *
   * Codigo do layout
   * @var Integer
   */
  protected $iCodigoLayout = 174;

  /**
   *
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'NTF';

  /**
   *
   * Contrutor da classe
   */
  public function __construct()
  {

  }

  /**
   * retornar o codio do layout
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
   * selecionar os dados de Notas Fiscais referentes a instituicao logada
   *
   */
  public function gerarDados()
  {

    $clntf10 = new cl_ntf102021();
    $clntf11 = new cl_ntf112021();
    $clntf20 = new cl_ntf202021();


    db_inicio_transacao();

    /*
     * excluir informacoes do mes selecionado registro 20
     */
    $result = $clntf20->sql_record($clntf20->sql_query(null, "*", null, "si145_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si145_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {

      $clntf20->excluir(null, "si145_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si145_instit = " . db_getsession("DB_instit"));
      if ($clntf20->erro_status == 0) {
        throw new Exception($clntf20->erro_msg);
      }
    }

    /*
    * excluir informacoes do mes selecionado registro 11
    */
    $result = $clntf11->sql_record($clntf11->sql_query(null, "*", null, "si144_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si144_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {

      $clntf11->excluir(null, "si144_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si144_instit = " . db_getsession("DB_instit"));
      if ($clntf11->erro_status == 0) {
        throw new Exception($clntf11->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 10
     */
    $result = $clntf10->sql_record($clntf10->sql_query(null, "*", null, "si143_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si143_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clntf10->excluir(null, "si143_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si143_instit = " . db_getsession("DB_instit"));
      if ($clntf10->erro_status == 0) {
        throw new Exception($clntf10->erro_msg);
      }
    }

    db_fim_transacao();

    $sSqlTrataUnidade = "select si08_tratacodunidade from infocomplementares where si08_instit = " . db_getsession("DB_instit");
    $rsResultTrataUnidade = db_query($sSqlTrataUnidade);
    $sTrataCodUnidade = db_utils::fieldsMemory($rsResultTrataUnidade, 0)->si08_tratacodunidade;

    $sSql = "SELECT si09_codorgaotce AS codorgao
              FROM infocomplementaresinstit
              WHERE si09_instit = " . db_getsession("DB_instit");

    $rsResult = db_query($sSql);
    $sCodorgao = db_utils::fieldsMemory($rsResult, 0)->codorgao;

    /*
     * selecionar informacoes registro 10
     */
    db_inicio_transacao();

    $sSql = "select distinct  '10' as tiporegistro,
              empnota.e69_codnota as codnotafiscal,
              si09_codorgaotce as codorgao,
              empnota.e69_numero as nfnumero,
              case when empnota.e69_notafiscaleletronica = 2 OR empnota.e69_notafiscaleletronica = 3 then empnota.e69_nfserie else ' ' end as nfserie,
              (case length(cgm.z01_cgccpf) when 11 then 1
                else 2
              end) as tipodocumento,
              cgm.z01_cgccpf  as nrodocumento,
              REPLACE(cgm.z01_incest,'.','') as nroinscestadual,
              cgm.z01_incmunici as nroinscmunicipal,
              cadendermunicipio.db72_descricao as nomemunicipio,
              cgm.z01_cep as cepmunicipio,
              cgm.z01_uf as ufcredor,
              empnota.e69_notafiscaleletronica as notafiscaleletronica,
              case when empnota.e69_notafiscaleletronica=1 or empnota.e69_notafiscaleletronica=4 then empnota.e69_chaveacesso else ' ' end as chaveacesso,
              case when empnota.e69_notafiscaleletronica=2 then empnota.e69_chaveacesso else ' ' end as outrachaveacesso,
              ' ' as nfaidf,
              empnota.e69_dtnota as dtemissaonf,
              ' ' as dtvencimentonf,
              (select sum(empnotaitem.e72_vlrliq) from empenho.empnotaitem as empnotaitem where empnotaitem.e72_codnota = empnota.e69_codnota) as nfvalortotal,
              0.0 as nfvalordesconto,
              (select sum(empnotaitem.e72_vlrliq) from empenho.empnotaitem as empnotaitem where empnotaitem.e72_codnota = empnota.e69_codnota) as nfvalorliquido
            from empenho.empnota as empnota
            inner join empenho.empempenho as empempenho on (empnota.e69_numemp=empempenho.e60_numemp)
            inner join  protocolo.cgm as cgm on (empempenho.e60_numcgm=cgm.z01_numcgm)
            inner join configuracoes.db_config as db_config on (empempenho.e60_instit=db_config.codigo)
            inner join patrimonio.cgmendereco as cgmendereco on (cgm.z01_numcgm=cgmendereco.z07_numcgm and z07_tipo = 'P')
            inner join configuracoes.endereco as endereco on (cgmendereco.z07_endereco = endereco.db76_sequencial)
            inner join configuracoes.cadenderlocal as cadenderlocal on (endereco.db76_cadenderlocal = cadenderlocal.db75_sequencial)
            inner join configuracoes.cadenderbairrocadenderrua as cadenderbairrocadenderrua  on (cadenderbairrocadenderrua.db87_sequencial = cadenderlocal.db75_cadenderbairrocadenderrua)
            inner join configuracoes.cadenderbairro as cadenderbairro on (cadenderbairro.db73_sequencial = cadenderbairrocadenderrua.db87_cadenderbairro)
            inner join configuracoes.cadenderrua as cadenderrua on  (cadenderrua.db74_sequencial = cadenderbairrocadenderrua.db87_cadenderrua)
            inner join configuracoes.cadenderruaruastipo as cadenderruaruastipo on (cadenderruaruastipo.db85_cadenderrua = cadenderrua.db74_sequencial)
            inner join configuracoes.cadendermunicipio as cadendermunicipio on (cadendermunicipio.db72_sequencial = cadenderrua.db74_cadendermunicipio)
            inner join configuracoes.cadenderestado as cadenderestado on (cadenderestado.db71_sequencial = cadendermunicipio.db72_cadenderestado)
            inner join empenho.pagordemnota as pagordemnota on (pagordemnota.e71_codnota = empnota.e69_codnota and pagordemnota.e71_anulado = false)
            inner join empenho.pagordem as pagordem on (pagordemnota.e71_codord=pagordem.e50_codord)
            inner join orcdotacao on e60_coddot = o58_coddot and e60_anousu = o58_anousu
            left join infocomplementaresinstit on si09_instit = empempenho.e60_instit
            where   db_config.codigo = " . db_getsession("DB_instit") . "
            and empempenho.e60_anousu = " . db_getsession("DB_anousu") . "
            and date_part('year',empnota.e69_dtnota) = " . $this->sDataFinal['0'] . $this->sDataFinal['1'] . $this->sDataFinal['2'] . $this->sDataFinal['3'] . "
            and   date_part('month',empnota.e69_dtnota) = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
            and date_part('year',pagordem.e50_data) = " . $this->sDataFinal['0'] . $this->sDataFinal['1'] . $this->sDataFinal['2'] . $this->sDataFinal['3'] . "
            and   date_part('month',pagordem.e50_data) = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
            and empnota.e69_numero != 'S/N'
            order by empnota .e69_numero";

    $rsResult10 = db_query($sSql);
    $aDadosAgrupados = array();
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
      $sHash10 = $oDados10->codorgao . ltrim($oDados10->nfnumero, "0") . $this->removeCaracteres($oDados10->nfserie) . $oDados10->tipodocumento . $oDados10->nrodocumento;
      $sHash10 .= $oDados10->chaveacesso . $oDados10->dtemissaonf;

      if (!$aDadosAgrupados[$sHash10]) {

        $clntf10 = new stdClass();
        $clntf10->si143_tiporegistro = 10;
        $clntf10->si143_codnotafiscal = $oDados10->codnotafiscal;
        $clntf10->si143_codorgao = $oDados10->codorgao;

        $oDados10->nfnumero = str_replace("/", "", $oDados10->nfnumero);
        if (ereg('[^0-9]', $oDados10->nfnumero)) {
          //$clntf10->si143_nfnumero                  = null;
          continue;
        } else {
          $clntf10->si143_nfnumero = $oDados10->nfnumero;
        }

        $clntf10->si143_nfserie = $this->removeCaracteres($oDados10->nfserie);
        $clntf10->si143_tipodocumento = $oDados10->tipodocumento;
        $clntf10->si143_nrodocumento = $oDados10->nrodocumento;
        $clntf10->si143_nroinscestadual = preg_replace("/[^0-9]/", "", $oDados10->nroinscestadual);//is_int($oDados10->nroinsdestadual)== true? $oDados10->nroinsdestadual:' ';
        $clntf10->si143_nroinscmunicipal = is_int($oDados10->nroinscmunicipal) == true ? $oDados10->nroinscmunicipal : ' ';
        $clntf10->si143_nomemunicipio = $this->removeCaracteres($oDados10->nomemunicipio);
        $clntf10->si143_cepmunicipio = $oDados10->cepmunicipio;
        $clntf10->si143_ufcredor = $oDados10->ufcredor;
        $clntf10->si143_notafiscaleletronica = $oDados10->notafiscaleletronica;
        $clntf10->si143_chaveacesso = $oDados10->chaveacesso;
        $clntf10->si143_outraChaveAcesso = $oDados10->outrachaveacesso;
        $clntf10->si143_nfaidf = $oDados10->nfaidf;
        $clntf10->si143_dtemissaonf = $oDados10->dtemissaonf;
        $clntf10->si143_dtvencimentonf = $oDados10->dtvencimentonf;
        $clntf10->si143_nfvalortotal = $oDados10->nfvalortotal;
        $clntf10->si143_nfvalordesconto = $oDados10->nfvalordesconto;
        $clntf10->si143_nfvalorliquido = $oDados10->nfvalorliquido;
        $clntf10->si143_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $clntf10->si143_instit = db_getsession("DB_instit");
        $clntf10->reg20 = array();

        $aDadosAgrupados[$sHash10] = $clntf10;

      } else {
        $aDadosAgrupados[$sHash10]->si143_nfvalortotal += $oDados10->nfvalortotal;
        $aDadosAgrupados[$sHash10]->si143_nfvalordesconto += $oDados10->nfvalordesconto;
        $aDadosAgrupados[$sHash10]->si143_nfvalorliquido += $oDados10->nfvalorliquido;
      }
      /*
       * selecionar informacoes registro 11
       */

      /*  $sSql = "select distinct '11' as tiporegistro,e72_sequencial,
          empnota.e69_codnota as codnotafiscal,
          (pcmater.pc01_codmater::varchar || (select (case when empautitem.e55_unid = 0 then 1 else empautitem.e55_unid end)::varchar AS unid from empautitem
  where e55_item = pcmater.pc01_codmater and e55_autori = empautoriza.e54_autori limit 1) )::varchar  AS coditem,
          empnotaitem.e72_qtd as quantidadeitem,
          empnotaitem.e72_vlrliq as valorunitarioitem
        from empenho.empnota as empnota
        inner join empenho.empnotaitem as empnotaitem on (empnota.e69_codnota=empnotaitem.e72_codnota)
        inner join empenho.empempitem as empempitem on (empnotaitem.e72_empempitem=empempitem.e62_sequencial)
        inner join empenho.empempenho as empempenho on (empnota.e69_numemp=empempenho.e60_numemp)
        inner join compras.pcmater as pcmater on (empempitem.e62_item = pcmater.pc01_codmater)
        inner join empenho.pagordemnota as pagordemnota on (empnota.e69_codnota=pagordemnota.e71_codnota and pagordemnota.e71_anulado = false)
        INNER JOIN empempaut ON e60_numemp=e61_numemp
        INNER JOIN empautoriza ON e61_autori = e54_autori
        where empnota.e69_codnota = ".$clntf10->si143_codnotafiscal;

        $rsResult11 = db_query($sSql);//db_criatabela($rsResult11);

        $aDadosAgrupados11 = array();
        for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {

          $oDados11 = db_utils::fieldsMemory($rsResult11, $iCont11);

          $sHash11 = $oDados11->coditem;
          if (!isset($aDadosAgrupados11[$sHash11])) {

            $oNtf112021 = new stdClass();
            $oNtf112021->si144_tiporegistro           = 11;
            $oNtf112021->si144_reg10                  = $clntf10->si143_sequencial;
            $oNtf112021->si144_codnotafiscal          = $oDados11->codnotafiscal;
            $oNtf112021->si144_coditem                = $oDados11->coditem;
            $oNtf112021->si144_quantidadeitem         = $oDados11->quantidadeitem;
            $oNtf112021->si144_valorunitarioitem      = $oDados11->valorunitarioitem;
            $oNtf112021->si144_mes                    = $this->sDataFinal['5'].$this->sDataFinal['6'];
            $oNtf112021->si144_instit                 = db_getsession("DB_instit");
            $aDadosAgrupados11[$sHash11] = $oNtf112021;

          } else {
            $aDadosAgrupados11[$sHash11]->si144_quantidadeitem    += $oDados11->quantidadeitem;
            $aDadosAgrupados11[$sHash11]->si144_valorunitarioitem += $oDados11->valorunitarioitem;
          }


        }

        foreach ($aDadosAgrupados11 as $oDadosAgrupados11) {

          $clntf11 = new cl_ntf112021();

          $clntf11->si144_tiporegistro           = $oDadosAgrupados11->si144_tiporegistro;
          $clntf11->si144_reg10                  = $oDadosAgrupados11->si144_reg10;
          $clntf11->si144_codnotafiscal          = $oDadosAgrupados11->si144_codnotafiscal;
          $clntf11->si144_coditem                = $oDadosAgrupados11->si144_coditem;
          $clntf11->si144_quantidadeitem         = $oDadosAgrupados11->si144_quantidadeitem;
          $clntf11->si144_valorunitarioitem      = $oDadosAgrupados11->si144_valorunitarioitem/$oDadosAgrupados11->si144_quantidadeitem;
          $clntf11->si144_mes                    = $oDadosAgrupados11->si144_mes;
          $clntf11->si144_instit                 = $oDadosAgrupados11->si144_instit;

          //echo "<pre>";print_r($clntf11);exit;

          $clntf11->incluir(null);

          if ($clntf11->erro_status == 0) {
            throw new Exception($clntf11->erro_msg);
          }

        }*/

      /*
       * selecionar informacoes registro 20
       */

      $sSql = "select '20' as tiporegistro,
        empnota.e69_numero as nfnumero,
        case when empnota.e69_notafiscaleletronica = 2 OR empnota.e69_notafiscaleletronica = 3 then empnota.e69_nfserie else ' ' end as nfserie,
        (case length(cgm.z01_cgccpf) when 11 then 1
                else 2
              end) as tipodocumento,
        cgm.z01_cgccpf  as nrodocumento,
        case when empnota.e69_notafiscaleletronica=1 or empnota.e69_notafiscaleletronica=4 then empnota.e69_chaveacesso else ' ' end as chaveacesso,
        empnota.e69_dtnota as dtemissaonf,
        lpad((CASE WHEN o40_codtri = '0'
         OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
           OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0) as codunidadesub,
        empempenho.e60_emiss as dtempenho,
        empempenho.e60_codemp as nroempenho,
        pagordem.e50_data as dtliquidacao,
        (rpad(e71_codnota::varchar,9,'0') || lpad(e71_codord::varchar,9,'0')) as nroliquidacao,
        orcdotacao.o58_unidade as unidade,
        orcdotacao.o58_orgao as orgao,
        lpad(o41_subunidade::varchar,3,0) as subunidade
      from empenho.empnota as empnota
      inner join empenho.empempenho as empempenho on (empnota.e69_numemp=empempenho.e60_numemp)
      inner join empenho.pagordemnota as pagordemnota on (empnota.e69_codnota=pagordemnota.e71_codnota and pagordemnota.e71_anulado = false)
      inner join empenho.pagordem as pagordem on (pagordemnota.e71_codord=pagordem.e50_codord)
      inner join orcamento.orcdotacao as orcdotacao on (empempenho.e60_coddot = orcdotacao.o58_coddot)
      inner join cgm on (empempenho.e60_numcgm=cgm.z01_numcgm)
      left join infocomplementaresinstit on si09_instit = empempenho.e60_instit
      LEFT JOIN orcunidade on o58_anousu = o41_anousu and o58_orgao = o41_orgao and o58_unidade = o41_unidade
      LEFT JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
      where orcdotacao.o58_anousu = " . db_getsession("DB_anousu") . "
      and empnota.e69_codnota = " . $oDados10->codnotafiscal;

      //orcdotacao pegar orgão e unidade
      $rsResult20 = db_query($sSql);//db_criatabela($rsResult20);echo $sSql;echo pg_last_error();
      for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {

        $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);
        $sHash20 = $oDados20->nfnumero . $this->removeCaracteres($oDados20->nfserie) . $oDados20->tipodocumento . $oDados20->nrodocumento . $oDados20->chaveacesso . $oDados20->dtemissaonf;
        $sHash20 .= $oDados20->codunidadesub . $oDados20->dtempenho . $oDados20->nroempenho . $oDados20->dtliquidacao . $oDados20->nroliquidacao;

        if (!$aDadosAgrupados[$sHash10]->reg20[$sHash20]) {

          $clntf20 = new stdClass();
          $clntf20->si145_tiporegistro = 20;

          $oDados20->nfnumero = str_replace("/", "", $oDados20->nfnumero);
          if (ereg('[^0-9]', $oDados20->nfnumero)) {
            //$clntf20->si145_nfnumero                  = null;
            continue;
          } else {
            $clntf20->si145_nfnumero = $oDados20->nfnumero;
          }
          $clntf20->si145_nfserie = $this->removeCaracteres($oDados20->nfserie);
          $clntf20->si145_tipodocumento = $oDados20->tipodocumento;
          $clntf20->si145_nrodocumento = $oDados20->nrodocumento;
          $clntf20->si145_chaveacesso = $oDados20->chaveacesso;
          $clntf20->si145_dtemissaonf = $oDados20->dtemissaonf;

          $clntf20->si145_codunidadesub = $oDados20->codunidadesub . ($oDados20->subunidade != '' && $oDados20->subunidade != 0 && $oDados20->subunidade != '000' ? $oDados20->subunidade : '');
          $clntf20->si145_dtempenho = $oDados20->dtempenho;
          $clntf20->si145_nroempenho = $oDados20->nroempenho;
          $clntf20->si145_dtliquidacao = $oDados20->dtliquidacao;
          $clntf20->si145_nroliquidacao = $oDados20->nroliquidacao;
          $clntf20->si145_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
          $clntf20->si145_instit = db_getsession("DB_instit");

          $aDadosAgrupados[$sHash10]->reg20[$sHash20] = $clntf20;

        }

      }

    }
//    echo "<pre>";print_r($aDadosAgrupados);
    /**
     * desagrupar e inserir dados
     */
    foreach ($aDadosAgrupados as $oDados10) {

      $clntf10 = new cl_ntf102021();
      $clntf10->si143_tiporegistro = $oDados10->si143_tiporegistro;
      $clntf10->si143_codnotafiscal = $oDados10->si143_codnotafiscal;
      $clntf10->si143_codorgao = $oDados10->si143_codorgao;
      $clntf10->si143_nfnumero = $oDados10->si143_nfnumero;
      $clntf10->si143_nfserie = $oDados10->si143_nfserie;
      $clntf10->si143_tipodocumento = $oDados10->si143_tipodocumento;
      $clntf10->si143_nrodocumento = $oDados10->si143_nrodocumento;
      $clntf10->si143_nroinscestadual = $oDados10->si143_nroinscestadual;
      $clntf10->si143_nroinscmunicipal = $oDados10->si143_nroinscmunicipal;
      $clntf10->si143_nomemunicipio = $oDados10->si143_nomemunicipio;
      $clntf10->si143_cepmunicipio = $oDados10->si143_cepmunicipio;
      $clntf10->si143_ufcredor = $oDados10->si143_ufcredor;
      $clntf10->si143_notafiscaleletronica = $oDados10->si143_notafiscaleletronica;
      $clntf10->si143_chaveacesso = $oDados10->si143_chaveacesso;
      $clntf10->si143_outraChaveAcesso = $oDados10->si143_outraChaveAcesso;
      $clntf10->si143_nfaidf = $oDados10->si143_nfaidf;
      $clntf10->si143_dtemissaonf = $oDados10->si143_dtemissaonf;
      $clntf10->si143_dtvencimentonf = $oDados10->si143_dtvencimentonf;
      $clntf10->si143_nfvalortotal = $oDados10->si143_nfvalortotal;
      $clntf10->si143_nfvalordesconto = $oDados10->si143_nfvalordesconto;
      $clntf10->si143_nfvalorliquido = $oDados10->si143_nfvalorliquido;
      $clntf10->si143_mes = $oDados10->si143_mes;
      $clntf10->si143_instit = $oDados10->si143_instit;

      $clntf10->incluir(null);
      if ($clntf10->erro_status == 0) {
        throw new Exception($clntf10->erro_msg);
      }

      foreach ($oDados10->reg20 as $oDados20) {

        $clntf20 = new cl_ntf202021();
        $clntf20->si145_tiporegistro = $oDados20->si145_tiporegistro;
        $clntf20->si145_reg10 = $clntf10->si143_sequencial;
        $clntf20->si145_nfnumero = $oDados20->si145_nfnumero;
        $clntf20->si145_nfserie = $oDados20->si145_nfserie;
        $clntf20->si145_tipodocumento = $oDados20->si145_tipodocumento;
        $clntf20->si145_nrodocumento = $oDados20->si145_nrodocumento;
        $clntf20->si145_chaveacesso = $oDados20->si145_chaveacesso;
        $clntf20->si145_dtemissaonf = $oDados20->si145_dtemissaonf;
        $clntf20->si145_codunidadesub = $oDados20->si145_codunidadesub;
        $clntf20->si145_dtempenho = $oDados20->si145_dtempenho;
        $clntf20->si145_nroempenho = $oDados20->si145_nroempenho;
        $clntf20->si145_dtliquidacao = $oDados20->si145_dtliquidacao;
        $clntf20->si145_nroliquidacao = $oDados20->si145_nroliquidacao;
        $clntf20->si145_mes = $oDados20->si145_mes;
        $clntf20->si145_instit = $oDados20->si145_instit;
        $clntf20->incluir(null);

        if ($clntf20->erro_status == 0) {
          throw new Exception($clntf20->erro_msg);
        }

      }

    }

    db_fim_transacao();

    $oGerarNTF = new GerarNTF();
    $oGerarNTF->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarNTF->gerarDados();

  }

}
