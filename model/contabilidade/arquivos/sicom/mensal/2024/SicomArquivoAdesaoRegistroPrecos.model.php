<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_regadesao102024_classe.php");
require_once("classes/db_regadesao112024_classe.php");
require_once("classes/db_regadesao122024_classe.php");
require_once("classes/db_regadesao132024_classe.php");
require_once("classes/db_regadesao142024_classe.php");
require_once("classes/db_regadesao202024_classe.php");
require_once("classes/db_regadesao302024_classe.php");
require_once("classes/db_regadesao402024_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2024/GerarREGADESAO.model.php");

/**
 * Adeso a Registro de Preos Sicom Acompanhamento Mensal
 * @author robson
 * @package Contabilidade
 */
class SicomArquivoAdesaoRegistroPrecos extends SicomArquivoBase implements iPadArquivoBaseCSV
{

  /**
   *
   * Codigo do layout. (db_layouttxt.db50_codigo)
   * @var Integer
   */
  protected $iCodigoLayout = 160;

  /**
   *
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'REGADESAO';

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
   *metodo implementado criando um array dos campos para o escritor gerar o arquivo CSV
   */
  public function getCampos()
  {

    $aElementos[10] = array(
      "tipoRegistro",
      "tipoCadastro",
      "codOrgao",
      "codUnidadeSub",
      "nroProcAdesao",
      "dtAbertura",
      "nomeOrgaoGerenciador",
      "exercicioLicitacao",
      "nroProcessoLicitatorio",
      "codModalidadeLicitacao",
      "nroEdital",
      "exercicioEdital",
      "dtAtaRegPreco",
      "dtValidade",
      "naturezaProcedimento",
      "dtPublicacaoAvisoIntencao",
      "objetoAdesao",
      "cpfResponsavel",
      "nomeResponsavel",
      "logradouro",
      "bairroLogra",
      "codCidadeLogra",
      "ufCidadeLogra",
      "cepLogra",
      "telefone",
      "email",
      "descontoTabela",
    );
    $aElementos[11] = array(
      "tipoRegistro",
      "codOrgao",
      "codUnidadeSub",
      "nroProcAdesao",
      "dtAbertura",
      "nroLote",
      "nroItem",
      "dtCotacao",
      "dscItem",
      "vlCotPrecosUnitario",
      "quantidade",
      "unidade"
    );
    $aElementos[12] = array(
      "tipoRegistro",
      "codOrgao",
      "codUnidadeSub",
      "nroProcAdesao",
      "dtAbertura",
      "nroLote",
      "nroItem",
      "dscItem",
      "precoUnitario",
      "quantidadeLicitada",
      "quantidadeAderida",
      "unidade",
      "nomeVencedor",
      "tipoDocumento",
      "nroDocumento"
    );
    $aElementos[20] = array(
      "tipoRegistro",
      "codOrgao",
      "codUnidadeSub",
      "nroProcAdesao",
      "dtAbertura",
      "nroLote",
      "dscLote",
      "percDesconto",
      "nomeVencedor",
      "tipoDocumento",
      "nroDocumento"
    );
    return $aElementos;
  }

  /**
   * selecionar os dados da adeso a registro de preo do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados()
  {

    $regadesao10 = new cl_regadesao102024();
    $regadesao11 = new cl_regadesao112024();
    $regadesao12 = new cl_regadesao122024();
    $regadesao13 = new cl_regadesao132024();
    $regadesao14 = new cl_regadesao142024();
    $regadesao20 = new cl_regadesao202024();
    $regadesao30 = new cl_regadesao302024();
    $regadesao40 = new cl_regadesao402024();

    db_inicio_transacao();

    $result = db_query($regadesao40->sql_query(NULL, "*", NULL, "si73_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si73_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $regadesao40->excluir(NULL, "si73_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si73_instit=" . db_getsession("DB_instit"));
      if ($regadesao40->erro_status == 0) {
        throw new Exception($regadesao40->erro_msg);
      }
    }

    $result = db_query($regadesao30->sql_query(NULL, "*", NULL, "si74_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si74_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
        $regadesao30->excluir(NULL, "si74_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si74_instit=" . db_getsession("DB_instit"));
        if ($regadesao30->erro_status == 0) {
            throw new Exception($regadesao30->erro_msg);
        }
    }

    $result = db_query($regadesao20->sql_query(NULL, "*", NULL, "si72_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si72_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $regadesao20->excluir(NULL, "si72_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si72_instit=" . db_getsession("DB_instit"));
      if ($regadesao20->erro_status == 0) {
        throw new Exception($regadesao20->erro_msg);
      }
    }

    $result = db_query($regadesao14->sql_query(NULL, "*", NULL, "si71_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si71_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $regadesao14->excluir(NULL, "si71_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si71_instit=" . db_getsession("DB_instit"));
      if ($regadesao14->erro_status == 0) {
        throw new Exception($regadesao14->erro_msg);
      }
    }

    $result = db_query($regadesao13->sql_query(NULL, "*", NULL, "si70_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si70_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $regadesao13->excluir(NULL, "si70_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si70_instit=" . db_getsession("DB_instit"));
      if ($regadesao13->erro_status == 0) {
        throw new Exception($regadesao13->erro_msg);
      }
    }

    $result = db_query($regadesao12->sql_query(NULL, "*", NULL, "si69_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si69_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $regadesao12->excluir(NULL, "si69_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si69_instit=" . db_getsession("DB_instit"));
      if ($regadesao12->erro_status == 0) {
        throw new Exception($regadesao12->erro_msg);
      }
    }

    $result = db_query($regadesao11->sql_query(NULL, "*", NULL, "si68_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si68_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $regadesao11->excluir(NULL, "si68_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si68_instit=" . db_getsession("DB_instit"));
      if ($regadesao11->erro_status == 0) {
        throw new Exception($regadesao11->erro_msg);
      }
    }

    $result = db_query($regadesao10->sql_query(NULL, "*", NULL, "si67_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si67_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $regadesao10->excluir(NULL, "si67_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si67_instit=" . db_getsession("DB_instit"));
      if ($regadesao10->erro_status == 0) {
        throw new Exception($regadesao10->erro_msg);
      }
    }

    db_fim_transacao();

    $sSql = "select adesaoregprecos.*,si06_dataadesao as exercicioadesao,orgaogerenciador.z01_cgccpf as cnpjorgaogerenciador,responsavel.z01_cgccpf as cpfresponsavel,
                       infocomplementaresinstit.si09_codorgaotce as codorgao,si06_anoproc as exerciciolicitacao,
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
                 AND o41_instit = " . db_getsession("DB_instit") . "
                 JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu and o40_instit = " . db_getsession("DB_instit") . "
                 WHERE db01_coddepto=si06_departamento and db01_anousu=" . db_getsession("DB_anousu") . " LIMIT 1) as codunidadesub
                from adesaoregprecos
                join cgm orgaogerenciador on si06_orgaogerenciador = orgaogerenciador.z01_numcgm
                join cgm responsavel on si06_cgm = responsavel.z01_numcgm
                INNER JOIN pcproc on si06_processocompra = pc80_codproc
                LEFT JOIN infocomplementaresinstit on adesaoregprecos.si06_instit = infocomplementaresinstit.si09_instit
                where si06_instit= " . db_getsession("DB_instit") . " and date_part('month',si06_dataadesao) = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
                and date_part('year',si06_dataadesao) = " . db_getsession("DB_anousu");

    $rsResult10 = db_query($sSql);

    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
      $regadesao10->si67_tiporegistro = 10;//1
      $regadesao10->si67_tipocadastro = $oDados10->si06_cadinicial;//2
      $regadesao10->si67_codorgao = $oDados10->codorgao;//3
      if ($oDados10->si06_codunidadesubant != "") {
        $regadesao10->si67_codunidadesub = $oDados10->si06_codunidadesubant;//4
      } else {
        $regadesao10->si67_codunidadesub = $oDados10->codunidadesub;//4
      }
      $regadesao10->si67_nroprocadesao = $oDados10->si06_numeroadm;//5
      $regadesao10->si63_exercicioadesao = substr($oDados10->exercicioadesao, 0, 4);//6
      $regadesao10->si67_dtabertura = $oDados10->si06_dataabertura;//7
      $regadesao10->si67_cnpjorgaogerenciador = $oDados10->cnpjorgaogerenciador;//8
      $regadesao10->si67_exerciciolicitacao = $oDados10->exerciciolicitacao;//9
      $regadesao10->si67_nroprocessolicitatorio = $oDados10->si06_numeroprc;//10
      $regadesao10->si67_regimecontratacao = $oDados10->si06_regimecontratacao;//11
      $regadesao10->si67_tipocriterio = $oDados10->si06_criterioadjudicacao;//13
      $regadesao10->si67_codmodalidadelicitacao = $oDados10->si06_modalidade;//12
      $regadesao10->si67_nroedital = $oDados10->si06_edital;//14
      $regadesao10->si67_exercicioedital = $oDados10->exerciciolicitacao;//15
      if($oDados10->si06_regimecontratacao == "2" || $oDados10->si06_regimecontratacao == "3"){
         $regadesao10->si67_codmodalidadelicitacao = '';//12
         $regadesao10->si67_nroedital = '';//14
         $regadesao10->si67_exercicioedital = '';//15
      }
      $regadesao10->si67_dtataregpreco = $oDados10->si06_dataata;//16
      $regadesao10->si67_dtvalidade = $oDados10->si06_datavalidade;//17
      $regadesao10->si67_naturezaprocedimento = $oDados10->si06_orgarparticipante;//18
      $regadesao10->si67_dtpublicacaoavisointencao = $oDados10->si06_publicacaoaviso;//19
      $regadesao10->si67_objetoadesao = $this->removeCaracteres($oDados10->si06_objetoadesao);//20
      $regadesao10->si67_cpfresponsavel = $oDados10->cpfresponsavel;//21
      $regadesao10->si67_processoporlote = $oDados10->si06_processoporlote;//23
      $regadesao10->si67_leidalicitacao = $oDados10->si06_leidalicitacao;//24
      $regadesao10->si67_instit = db_getsession("DB_instit");//25
      $regadesao10->si67_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];//26
      $regadesao10->incluir(null);


      if ($regadesao10->erro_status == 0) {
        throw new Exception($regadesao10->erro_msg);
      }

      $sSql = "select distinct si07_numerolote,(select si07_descricaolote from itensregpreco desclote
                   where desclote.si07_numerolote=itensregpreco.si07_numerolote and desclote.si07_sequencialadesao = itensregpreco.si07_sequencialadesao limit 1) as desclote
                   from itensregpreco where si07_numerolote > 0 and si07_numerolote is not null and si07_sequencialadesao = $oDados10->si06_sequencial ";
      $rsResult11 = db_query($sSql);
      for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {

        $oDados11 = db_utils::fieldsMemory($rsResult11, $iCont11);
        $regadesao11 = new cl_regadesao112024();
        $regadesao11->si68_tiporegistro = 11;
        $regadesao11->si68_codorgao = $oDados10->codorgao;
        if ($oDados10->si06_codunidadesubant != "") {
          $regadesao11->si68_codunidadesub = $oDados10->si06_codunidadesubant;
        } else {
          $regadesao11->si68_codunidadesub = $oDados10->codunidadesub;
        }
        $regadesao11->si68_nroprocadesao = $oDados10->si06_numeroadm;
        $regadesao11->si68_exercicioadesao = substr($oDados10->exercicioadesao, 0, 4);
        $regadesao11->si68_nrolote = $oDados11->si07_numerolote;
        $regadesao11->si68_dsclote = $this->removeCaracteres($oDados11->desclote);
        $regadesao11->si68_instit = db_getsession("DB_instit");
        $regadesao11->si68_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $regadesao11->si68_reg10 = $regadesao10->si67_sequencial;

        $regadesao11->incluir(null);
        if ($regadesao11->erro_status == 0) {
          throw new Exception($regadesao11->erro_msg);
        }
      }

      $sSql = "select si07_numeroitem,
      CASE
      WHEN (pcmater.pc01_codmaterant != 0 or pcmater.pc01_codmaterant != null) THEN pcmater.pc01_codmaterant::varchar
    ELSE (pcmater.pc01_codmater::varchar || (CASE WHEN si07_codunidade IS NULL THEN 1 ELSE si07_codunidade END)::varchar) END AS coditem
      from itensregpreco
      inner join pcmater on
                   		pcmater.pc01_codmater = si07_item
      where si07_sequencialadesao = $oDados10->si06_sequencial ";
      //print_r($sSql);
      $rsResult12 = db_query($sSql);
      for ($iCont12 = 0; $iCont12 < pg_num_rows($rsResult12); $iCont12++) {

        $oDados12 = db_utils::fieldsMemory($rsResult12, $iCont12);
        $regadesao12 = new cl_regadesao122024();
        $regadesao12->si69_tiporegistro = 12;
        $regadesao12->si69_codorgao = $oDados10->codorgao;
        if ($oDados10->si06_codunidadesubant != "") {
          $regadesao12->si69_codunidadesub = $oDados10->si06_codunidadesubant;
        } else {
          $regadesao12->si69_codunidadesub = $oDados10->codunidadesub;
        }
        $regadesao12->si69_nroprocadesao = $oDados10->si06_numeroadm;
        $regadesao12->si69_exercicioadesao = substr($oDados10->exercicioadesao, 0, 4);
        $regadesao12->si69_coditem = $oDados12->coditem;
        $regadesao12->si69_nroitem = $iCont12 + 1;
        $regadesao12->si69_instit = db_getsession("DB_instit");
        $regadesao12->si69_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $regadesao12->si69_reg10 = $regadesao10->si67_sequencial;

        $regadesao12->incluir(null);
        if ($regadesao12->erro_status == 0) {
          throw new Exception($regadesao12->erro_msg);
        }
      }

      $sSql = "select si07_numerolote,
                   CASE
      WHEN (pcmater.pc01_codmaterant != 0 or pcmater.pc01_codmaterant != null) THEN pcmater.pc01_codmaterant::varchar
    ELSE (pcmater.pc01_codmater::varchar || (CASE WHEN si07_codunidade IS NULL THEN 1 ELSE si07_codunidade END)::varchar) END AS coditem
                   from itensregpreco
                   inner join pcmater on
                   		pcmater.pc01_codmater = si07_item
                   where si07_sequencialadesao = $oDados10->si06_sequencial
                   and (select si06_processoporlote from adesaoregprecos where  si06_sequencial = $oDados10->si06_sequencial) = 1";
      $rsResult13 = db_query($sSql);
      for ($iCont13 = 0; $iCont13 < pg_num_rows($rsResult13); $iCont13++) {

        $oDados13 = db_utils::fieldsMemory($rsResult13, $iCont13);
        $regadesao13 = new cl_regadesao132024();
        $regadesao13->si70_tiporegistro = 13;
        $regadesao13->si70_codorgao = $oDados10->codorgao;
        if ($oDados10->si06_codunidadesubant != "") {
          $regadesao13->si70_codunidadesub = $oDados10->si06_codunidadesubant;
        } else {
          $regadesao13->si70_codunidadesub = $oDados10->codunidadesub;
        }
        $regadesao13->si70_nroprocadesao = $oDados10->si06_numeroadm;
        $regadesao13->si70_exercicioadesao = substr($oDados10->exercicioadesao, 0, 4);
        $regadesao13->si70_nrolote = $oDados13->si07_numerolote;
        $regadesao13->si70_coditem = $oDados13->coditem;
        $regadesao13->si70_instit = db_getsession("DB_instit");
        $regadesao13->si70_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $regadesao13->si70_reg10 = $regadesao10->si67_sequencial;

        $regadesao13->incluir(null);
        if ($regadesao13->erro_status == 0) {
          throw new Exception($regadesao13->erro_msg);
        }
      }

      $sSql = "select * from (SELECT
                pc01_codmater,
                pc01_descrmater||'. '||pc01_complmater as pc01_descrmater,
                m61_abrev,
                sum(pc11_quant) as pc11_quant
                from (
                SELECT DISTINCT pc01_servico,
                                pc11_codigo,
                                pc11_seq,
                                pc11_quant,
                                pc11_prazo,
                                pc11_pgto,
                                pc11_resum,
                                pc11_just,
                                m61_abrev,
                                m61_descr,
                                pc17_quant,
                                pc01_codmater,
                                pc01_descrmater,pc01_complmater,
                                pc10_numero,
                                pc90_numeroprocesso AS processo_administrativo,
                                (pc11_quant * pc11_vlrun) AS pc11_valtot,
                                m61_usaquant
                FROM solicitem
                INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
                LEFT JOIN solicitaprotprocesso ON solicitaprotprocesso.pc90_solicita = solicita.pc10_numero
                LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
                LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
                LEFT JOIN pcprocitem ON pcprocitem.pc81_solicitem = solicitem.pc11_codigo
                LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
                LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
                LEFT JOIN solicitemele ON solicitemele.pc18_solicitem = solicitem.pc11_codigo
                LEFT JOIN orcelemento ON solicitemele.pc18_codele = orcelemento.o56_codele
                AND orcelemento.o56_anousu = " . db_getsession("DB_anousu") . "
                WHERE pc81_codproc = $oDados10->si06_processocompra
                  AND pc10_instit = " . db_getsession("DB_instit") . "
                ORDER BY pc11_seq) as x GROUP BY
                                pc01_codmater,
                                pc01_descrmater,pc01_complmater,m61_abrev ) as matquan join
                (SELECT DISTINCT
                                pc11_seq,
                                round(si02_vlprecoreferencia,2) as si02_vlprecoreferencia,
                                pc01_codmater,
                                si01_datacotacao,
                                si07_numerolote,
                                CASE
                      WHEN (pcmater.pc01_codmaterant != 0 or pcmater.pc01_codmaterant != null) THEN pcmater.pc01_codmaterant::varchar
                    ELSE (pcmater.pc01_codmater::varchar || (CASE WHEN si07_codunidade IS NULL THEN 1 ELSE si07_codunidade END)::varchar) END AS coditem
                FROM pcproc
                JOIN pcprocitem ON pc80_codproc = pc81_codproc
                JOIN pcorcamitemproc ON pc81_codprocitem = pc31_pcprocitem
                JOIN pcorcamitem ON pc31_orcamitem = pc22_orcamitem
                JOIN pcorcamval ON pc22_orcamitem = pc23_orcamitem
                JOIN solicitem ON pc81_solicitem = pc11_codigo
                JOIN solicitempcmater ON pc11_codigo = pc16_solicitem
                JOIN pcmater ON pc16_codmater = pc01_codmater
                JOIN itemprecoreferencia ON pc23_orcamitem = si02_itemproccompra
                JOIN precoreferencia ON itemprecoreferencia.si02_precoreferencia = precoreferencia.si01_sequencial
                JOIN itensregpreco ON si07_item = pc01_codmater AND si07_sequencialadesao = $oDados10->si06_sequencial
                WHERE pc80_codproc = $oDados10->si06_processocompra
                ORDER BY pc11_seq) as matpreco on matpreco.pc01_codmater = matquan.pc01_codmater order by pc11_seq";
      $rsResult14 = db_query($sSql);
      for ($iCont14 = 0; $iCont14 < pg_num_rows($rsResult14); $iCont14++) {

        $oDados14 = db_utils::fieldsMemory($rsResult14, $iCont14);
        $regadesao14 = new cl_regadesao142024();
        $regadesao14->si71_tiporegistro = 14;
        $regadesao14->si71_codorgao = $oDados10->codorgao;
        if ($oDados10->si06_codunidadesubant != "") {
          $regadesao14->si71_codunidadesub = $oDados10->si06_codunidadesubant;
        } else {
          $regadesao14->si71_codunidadesub = $oDados10->codunidadesub;
        }
        $regadesao14->si71_nroprocadesao = $oDados10->si06_numeroadm;
        $regadesao14->si71_exercicioadesao = substr($oDados10->exercicioadesao, 0, 4);
        $regadesao14->si71_nrolote = $oDados14->si07_numerolote;
        $regadesao14->si71_coditem = $oDados14->coditem;
        $regadesao14->si71_dtcotacao = $oDados14->si01_datacotacao;
        $regadesao14->si71_vlcotprecosunitario = $oDados14->si02_vlprecoreferencia;
        $regadesao14->si71_quantidade = $oDados14->pc11_quant;
        $regadesao14->si71_instit = db_getsession("DB_instit");
        $regadesao14->si71_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $regadesao14->si71_reg10 = $regadesao10->si67_sequencial;

        $regadesao14->incluir(null);
        if ($regadesao14->erro_status == 0) {
          throw new Exception($regadesao14->erro_msg);
        }
      }

      //REGISTRO 20

          $sSql = "select si07_numerolote,si07_precounitario,si07_quantidadelicitada,si07_quantidadeaderida,
                        case when length(z01_cgccpf) = 11 then 1 when length(z01_cgccpf) = 14 then 2 else 0 end as tipodocumento,
                        z01_cgccpf,
                        CASE
                              WHEN (pcmater.pc01_codmaterant != 0 or pcmater.pc01_codmaterant != null) THEN pcmater.pc01_codmaterant::varchar
                            ELSE (pcmater.pc01_codmater::varchar || (CASE WHEN si07_codunidade IS NULL THEN 1 ELSE si07_codunidade END)::varchar) END AS coditem
                        from itensregpreco
                        INNER JOIN adesaoregprecos on  si07_sequencialadesao = si06_sequencial
                        INNER join cgm on si07_fornecedor = z01_numcgm
                        inner join pcmater on
                                                pcmater.pc01_codmater = si07_item
                        where si07_sequencialadesao = {$oDados10->si06_sequencial} and si06_criterioadjudicacao = 3";
          $rsResult20 = db_query($sSql);

          for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {

              $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);
              $regadesao20 = new cl_regadesao202024();
              $regadesao20->si72_tiporegistro = 20;
              $regadesao20->si72_codorgao = $oDados10->codorgao;
              if ($oDados10->si06_codunidadesubant != "") {
                  $regadesao20->si72_codunidadesub = $oDados10->si06_codunidadesubant;
              } else {
                  $regadesao20->si72_codunidadesub = $oDados10->codunidadesub;
              }
              $regadesao20->si72_nroprocadesao = $oDados10->si06_numeroadm;
              $regadesao20->si72_exercicioadesao = substr($oDados10->exercicioadesao, 0, 4);
              $regadesao20->si72_nrolote = $oDados20->si07_numerolote;
              $regadesao20->si72_coditem = $oDados20->coditem;
              $regadesao20->si72_precounitario = $oDados20->si07_precounitario;
              $regadesao20->si72_quantidadelicitada = $oDados20->si07_quantidadelicitada;
              $regadesao20->si72_quantidadeaderida = $oDados20->si07_quantidadeaderida;
              $regadesao20->si72_tipodocumento = $oDados20->tipodocumento;
              $regadesao20->si72_nrodocumento = $oDados20->z01_cgccpf;
              $regadesao20->si72_instit = db_getsession("DB_instit");
              $regadesao20->si72_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
              $regadesao20->si72_reg10 = $regadesao10->si67_sequencial;

              $regadesao20->incluir(null);
              if ($regadesao20->erro_status == 0) {
                  throw new Exception($regadesao20->erro_msg);
              }
          }

        //REGISTRO 30

        $sSql = "select si07_numerolote,si07_precounitario,si07_quantidadelicitada,si07_quantidadeaderida,si07_percentual,
                case when length(z01_cgccpf) = 11 then 1 when length(z01_cgccpf) = 14 then 2 else 0 end as tipodocumento,
                z01_cgccpf,
                CASE
                      WHEN (pcmater.pc01_codmaterant != 0 or pcmater.pc01_codmaterant != null) THEN pcmater.pc01_codmaterant::varchar
                    ELSE (pcmater.pc01_codmater::varchar || (CASE WHEN si07_codunidade IS NULL THEN 1 ELSE si07_codunidade END)::varchar) END AS coditem
                from itensregpreco
                INNER JOIN adesaoregprecos on  si07_sequencialadesao = si06_sequencial
                INNER join cgm on si07_fornecedor = z01_numcgm
                inner join pcmater on
                                        pcmater.pc01_codmater = si07_item
                where si07_sequencialadesao = {$oDados10->si06_sequencial} and si06_criterioadjudicacao = 1";
        $rsResult30 = db_query($sSql);

        for ($iCont30 = 0; $iCont30 < pg_num_rows($rsResult30); $iCont30++) {

            $oDados30 = db_utils::fieldsMemory($rsResult30, $iCont30);
            $regadesao30 = new cl_regadesao302024();
            $regadesao30->si74_tiporegistro = 30;
            $regadesao30->si74_codorgao = $oDados10->codorgao;
            if ($oDados10->si06_codunidadesubant != "") {
                $regadesao30->si74_codunidadesub = $oDados10->si06_codunidadesubant;
            } else {
                $regadesao30->si74_codunidadesub = $oDados10->codunidadesub;
            }
            $regadesao30->si74_nroprocadesao = $oDados10->si06_numeroadm;
            $regadesao30->si74_exercicioadesao = substr($oDados10->exercicioadesao, 0, 4);
            $regadesao30->si74_nrolote = $oDados30->si07_numerolote;
            $regadesao30->si74_coditem = $oDados30->coditem;
            $regadesao30->si74_percdesconto = $oDados30->si07_percentual;
            $regadesao30->si74_tipodocumento = $oDados30->tipodocumento;
            $regadesao30->si74_nrodocumento = $oDados30->z01_cgccpf;
            $regadesao30->si74_instit = db_getsession("DB_instit");
            $regadesao30->si74_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $regadesao30->si74_reg10 = $regadesao10->si67_sequencial;

            $regadesao30->incluir(null);
            if ($regadesao30->erro_status == 0) {
                throw new Exception($regadesao30->erro_msg);
            }
        }

        //REGISTRO 40

          $sSql = "select si07_numerolote,si07_precounitario,si07_quantidadelicitada,si07_quantidadeaderida,si07_percentual,
                case when length(z01_cgccpf) = 11 then 1 when length(z01_cgccpf) = 14 then 2 else 0 end as tipodocumento,
                z01_cgccpf,
                CASE
                      WHEN (pcmater.pc01_codmaterant != 0 or pcmater.pc01_codmaterant != null) THEN pcmater.pc01_codmaterant::varchar
                    ELSE (pcmater.pc01_codmater::varchar || (CASE WHEN si07_codunidade IS NULL THEN 1 ELSE si07_codunidade END)::varchar) END AS coditem
                from itensregpreco
                INNER JOIN adesaoregprecos on  si07_sequencialadesao = si06_sequencial
                INNER join cgm on si07_fornecedor = z01_numcgm
                inner join pcmater on
                                        pcmater.pc01_codmater = si07_item
                where si07_sequencialadesao = {$oDados10->si06_sequencial} and si06_criterioadjudicacao = 2";
          $rsResult40 = db_query($sSql);

          for ($iCont40 = 0; $iCont40 < pg_num_rows($rsResult40); $iCont40++) {

              $oDados40 = db_utils::fieldsMemory($rsResult40, $iCont40);
              $regadesao40 = new cl_regadesao402024();
              $regadesao40->si73_tiporegistro = 40;
              $regadesao40->si73_codorgao = $oDados10->codorgao;
              if ($oDados10->si06_codunidadesubant != "") {
                  $regadesao40->si73_codunidadesub = $oDados10->si06_codunidadesubant;
              } else {
                  $regadesao40->si73_codunidadesub = $oDados10->codunidadesub;
              }
              $regadesao40->si73_nroprocadesao = $oDados10->si06_numeroadm;
              $regadesao40->si73_exercicioadesao = substr($oDados10->exercicioadesao, 0, 4);
              $regadesao40->si73_nrolote = $oDados40->si07_numerolote;
              $regadesao40->si73_coditem = $oDados40->coditem;
              $regadesao40->si73_percdesconto = $oDados40->si07_percentual;
              $regadesao40->si73_tipodocumento = $oDados40->tipodocumento;
              $regadesao40->si73_nrodocumento = $oDados40->z01_cgccpf;
              $regadesao40->si73_instit = db_getsession("DB_instit");
              $regadesao40->si73_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
              $regadesao40->si73_reg10 = $regadesao10->si67_sequencial;

              $regadesao40->incluir(null);
              if ($regadesao40->erro_status == 0) {
                  throw new Exception($regadesao40->erro_msg);
              }
          }

    }

    $oGerarREGADESAO = new GerarREGADESAO();
    $oGerarREGADESAO->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];;
    $oGerarREGADESAO->gerarDados();
  }
}
