<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_orgao102021_classe.php");
require_once("classes/db_orgao112021_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2021/GerarORGAO.model.php");

/**
 * selecionar dados de Orgao Sicom Acompanhamento Mensal
 * @author robson
 * @package Contabilidade
 */
class SicomArquivoAmOrgao extends SicomArquivoBase implements iPadArquivoBaseCSV
{

  /**
   *
   * Codigo do layout
   * @var Integer
   */
  protected $iCodigoLayout = 148;

  /**
   *
   * Nome do arquivo a ser criado
   * @var unknown_type
   */
  protected $sNomeArquivo = 'ORGAO';

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

    $aElementos[10] = array(
      "tipoRegistro",
      "codOrgao",
      "descOrgao",
      "tipoOrgao",
      "cnpjOrgao",
      "lograOrgao",
      "bairroLograOrgao",
      "cepLograOrgao",
      "telefoneOrgao",
      "emailOrgao"
    );
    $aElementos[11] = array(
      "tipoRegistro",
      "tipoResponsavel",
      "nome",
      "cartIdent",
      "orgEmissorCi",
      "cpf",
      "crcContador",
      "ufCrcContador",
      "cargoOrdDespDeleg",
      "dtInicio",
      "dtFinal",
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
   * selecionar os dados do Orgao referente a instituicao logada
   *
   */
  public function gerarDados()
  {

    $clorgao10 = new cl_orgao102021();
    $clorgao11 = new cl_orgao112021();

    db_inicio_transacao();
    /**
     * excluir informacoes do mes selecionado
     */
    $result = $clorgao11->sql_record($clorgao11->sql_query(null, "*", null, "si15_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si15_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clorgao11->excluir(null, "si15_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si15_instit = " . db_getsession("DB_instit"));
      if ($clorgao11->erro_status == 0) {
        throw new Exception($clorgao11->erro_msg);
      }
    }

    $result = $clorgao10->sql_record($clorgao10->sql_query(null, "*", null, "si14_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si14_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clorgao10->excluir(null, "si14_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si14_instit = " . db_getsession("DB_instit"));
      if ($clorgao10->erro_status == 0) {
        throw new Exception($clorgao10->erro_msg);
      }
    }

    /**
     * selecionar informacoes
     */
    $sSql = "SELECT db21_codigomunicipoestado AS codmunicipio,
          cgc as cnpjmunicipio,
          si09_tipoinstit as tipoorgao,
          si09_codorgaotce as codorgao,
          prefeitura,
          si09_assessoriacontabil as assessoriacontabil,
          CASE WHEN LENGTH(cgmassessoria.z01_cgccpf) = 11 THEN 1
          WHEN  LENGTH(cgmassessoria.z01_cgccpf) = 14 THEN 2
          ELSE NULL END AS tipodocumentoassessoria,
          cgmassessoria.z01_cgccpf AS nrodocumentoassessoria
FROM db_config
LEFT JOIN infocomplementaresinstit ON si09_instit = codigo
LEFT JOIN cgm AS cgmassessoria ON infocomplementaresinstit.si09_cgmassessoriacontabil = cgmassessoria.z01_numcgm
  WHERE codigo = " . db_getsession("DB_instit");

    $rsResult10 = db_query($sSql); //db_criatabela($rsResult10);

    /**
     * tirar caracteres de campo
     */
    $aCaracteres = array(".", "-");
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

      $clorgao10 = new cl_orgao102021();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

      $clorgao10->si14_tiporegistro = 10;
      $clorgao10->si14_codorgao = $oDados10->codorgao;
      $clorgao10->si14_tipoorgao = $oDados10->tipoorgao;
      $clorgao10->si14_cnpjorgao = $oDados10->cnpjmunicipio;
      $clorgao10->si14_tipodocumentofornsoftware = 2;

      if ($oDados10->cnpjmunicipio == '25218645000126')
        $clorgao10->si14_nrodocumentofornsoftware = $oDados10->cnpjmunicipio;
      else
        $clorgao10->si14_nrodocumentofornsoftware = "09016362000145";

      $clorgao10->si14_versaosoftware = "2.3.31";
      $clorgao10->si14_assessoriacontabil = $oDados10->assessoriacontabil;
      $clorgao10->si14_tipodocumentoassessoria = $oDados10->tipodocumentoassessoria;
      $clorgao10->si14_nrodocumentoassessoria = $oDados10->nrodocumentoassessoria;
      $clorgao10->si14_cnpjorgao = $oDados10->cnpjmunicipio;
      $clorgao10->si14_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clorgao10->si14_instit = db_getsession("DB_instit");

      $clorgao10->incluir(null);
      if ($clorgao10->erro_status == 0) {
        throw new Exception($clorgao10->erro_msg);
      }

      $sSql = "select * from identificacaoresponsaveis join cgm on si166_numcgm = z01_numcgm where si166_instit = " . db_getsession("DB_instit") . " and si166_tiporesponsavel in (1,2,3,4) and (si166_dataini <= '{$this->sDataInicial}' AND si166_datafim >= '{$this->sDataInicial}') AND (si166_dataini <= '{$this->sDataFinal}' AND si166_datafim >= '{$this->sDataFinal}')";
      $rsResult11 = db_query($sSql); //db_criatabela($rsResult11);

      for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {

        $clorgao11 = new cl_orgao112021();
        $oDados11 = db_utils::fieldsMemory($rsResult11, $iCont11);
        //if (strlen($oDados11->z01_cgccpf) > 11)
        //echo $oDados11->z01_numcgm." | ".$oDados11->z01_cgccpf."<br>";
        $clorgao11->si15_tiporegistro = 11; //echo $clorgao11->si15_tiporegistro ;
        $clorgao11->si15_tiporesponsavel = $oDados11->si166_tiporesponsavel;
        $clorgao11->si15_cartident = str_replace($aCaracteres, "", $oDados11->z01_ident);
        $clorgao11->si15_orgemissorci = str_replace($aCaracteres, "", $oDados11->z01_identorgao);
        $clorgao11->si15_cpf = $oDados11->z01_cgccpf;
        $clorgao11->si15_crccontador = $oDados11->si166_crccontador;
        $clorgao11->si15_ufcrccontador = $oDados11->si166_ufcrccontador;
        $clorgao11->si15_cargoorddespdeleg = $oDados11->si166_cargoorddespesa;
        $clorgao11->si15_dtinicio = $this->sDataInicial;
        $clorgao11->si15_dtfinal = $this->sDataFinal;
        $clorgao11->si15_email = $oDados11->z01_email;
        $clorgao11->si15_reg10 = $clorgao10->si14_sequencial;
        $clorgao11->si15_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $clorgao11->si15_instit = db_getsession("DB_instit");

        $clorgao11->incluir(null);
        if ($clorgao11->erro_status == 0) {
          throw new Exception($clorgao11->erro_msg);
        }
      }
    }

    db_fim_transacao();

    $oGerarOrgao = new GerarORGAO();
    $oGerarOrgao->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarOrgao->gerarDados();
  }
}
