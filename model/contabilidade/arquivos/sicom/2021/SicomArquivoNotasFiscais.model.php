<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_ntf102021_classe.php");
require_once ("classes/db_ntf112021_classe.php");
require_once ("classes/db_ntf122021_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarNTF.model.php");

 /**
  * selecionar dados de Notas Fiscais Sicom Acompanhamento Mensal
  * @author robson
  * @package Contabilidade
  */
class SicomArquivoNotasFiscais extends SicomArquivoBase implements iPadArquivoBaseCSV {

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
  public function __construct() {

  }

  /**
   * retornar o codio do layout
   *
   *@return Integer
   */
  public function getCodigoLayout(){
    return $this->iCodigoLayout;
  }

  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
   *@return Array
   */
  public function getCampos() {

  }

  /**
   * selecionar os dados de Notas Fiscais referentes a instituicao logada
   *
   */
  public function gerarDados() {

  	$clntf102021 = new cl_ntf102021();
    $clntf112021 = new cl_ntf112021();
    $clntf122021 = new cl_ntf122021();



      db_inicio_transacao();

    /*
     * excluir informacoes do mes selecionado registro 12
     */
    $result = $clntf122021->sql_record($clntf122021->sql_query(NULL,"*",NULL,"si145_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si145_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {

      $clntf122021->excluir(NULL,"si145_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si145_instit = ".db_getsession("DB_instit"));
      if ($clntf122021->erro_status == 0) {
        throw new Exception($clntf122021->erro_msg);
      }
    }

     /*
     * excluir informacoes do mes selecionado registro 11
     */
    $result = $clntf112021->sql_record($clntf112021->sql_query(NULL,"*",NULL,"si144_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si144_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {

      $clntf112021->excluir(NULL,"si144_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si144_instit = ".db_getsession("DB_instit"));
      if ($clntf112021->erro_status == 0) {
        throw new Exception($clntf112021->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 10
     */
    $result = $clntf102021->sql_record($clntf102021->sql_query(NULL,"*",NULL,"si143_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si143_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clntf102021->excluir(NULL,"si143_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si143_instit = ".db_getsession("DB_instit"));
      if ($clntf102021->erro_status == 0) {
        throw new Exception($clntf102021->erro_msg);
      }
    }

    $sSql  = "SELECT si09_codorgaotce AS codorgao
              FROM infocomplementaresinstit
              WHERE si09_instit = ".db_getsession("DB_instit");

    $rsResult  = db_query($sSql);
    $sCodorgao = db_utils::fieldsMemory($rsResult, 0)->codorgao;

    /*
     * selecionar informacoes registro 10
     */


    $sSql = "select   '10' as tiporegistro,
              empnota.e69_codnota as codnotafiscal,
              db_config.db21_tipoinstit as codorgao,
              empnota.e69_numero as nfnumero,
              'a' as nfserie,
              (case length(cgm.z01_cgccpf) when 11 then 1
                else 2
              end) as tipodocumento,
              cgm.z01_cgccpf  as nrodocumento,
              cgm.z01_incest as nroinscestadual,
              cgm.z01_incmunici as nroinscmunicipal,
              cgm.z01_munic as nomemunicipio,
              cgm.z01_cep as cepmunicipio,
              cgm.z01_uf as ufcredor  ,
              3 as notafiscaleletronica,
              ' ' as chaveacesso,
              ' ' as chaveacessomunicipal,
              ' ' as nfaidf,
              empnota.e69_dtnota as dtemissaonf,
              empempenho.e60_vencim as dtvencimentonf,
              (select sum(empnotaitem.e72_vlrliq) from empenho.empnotaitem as empnotaitem where empnotaitem.e72_codnota = empnota.e69_codnota) as nfvalortotal,
              0.0 as nfvalordesconto,
              (select sum(empnotaitem.e72_vlrliq) from empenho.empnotaitem as empnotaitem where empnotaitem.e72_codnota = empnota.e69_codnota) as nfvalorliquido
            from empenho.empnota as empnota
            inner join empenho.empempenho as empempenho on (empnota.e69_numemp=empempenho.e60_numemp)
            inner join  protocolo.cgm as cgm on (empempenho.e60_numcgm=cgm.z01_numcgm)
            inner join configuracoes.db_config as db_config on (empempenho.e60_instit=db_config.codigo)
            inner join patrimonio.cgmendereco as cgmendereco on (cgm.z01_numcgm=cgmendereco.z07_numcgm)
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
            where   db_config.codigo = ".db_getsession("DB_instit")."
            and empempenho.e60_anousu = ".db_getsession("DB_anousu")."
            and date_part('year',empnota.e69_dtnota) = ".$this->sDataFinal['0'].$this->sDataFinal['1'].$this->sDataFinal['2'].$this->sDataFinal['3']."
            and   date_part('month',empnota.e69_dtnota) = ".$this->sDataFinal['5'].$this->sDataFinal['6']."
            and date_part('year',pagordem.e50_data) = ".$this->sDataFinal['0'].$this->sDataFinal['1'].$this->sDataFinal['2'].$this->sDataFinal['3']."
            and   date_part('month',pagordem.e50_data) = ".$this->sDataFinal['5'].$this->sDataFinal['6']."
            order by empnota .e69_numero";

    $rsResult10 = db_query($sSql);

    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

      $clntf102021 = new cl_ntf102021();

      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

      $clntf102021->si143_tiporegistro              = 10;
      $clntf102021->si143_codnotafiscal             = $oDados10->codnotafiscal;
      $clntf102021->si143_codorgao                  = $oDados10->codorgao;

      $oDados10->nfnumero = str_replace("/", "", $oDados10->nfnumero);
      if(ereg('[^0-9]',$oDados10->nfnumero)){
        $clntf102021->si143_nfnumero                  = null;
      }else{
        $clntf102021->si143_nfnumero                  = $oDados10->nfnumero;
      }

      $clntf102021->si143_nfserie                   = $oDados10->nfserie;
      $clntf102021->si143_tipodocumento             = $oDados10->tipodocumento;
      $clntf102021->si143_nrodocumento              = $oDados10->nrodocumento;
      $clntf102021->si143_nroinscestadual           = $oDados10->nroinscestadual;
      $clntf102021->si143_nroinscmunicipal          = $oDados10->nroinscmunicipal;
      $clntf102021->si143_nomemunicipio             = $oDados10->nomemunicipio;
      $clntf102021->si143_cepmunicipio              = $oDados10->cepmunicipio;
      $clntf102021->si143_ufcredor                  = $oDados10->ufcredor;
      $clntf102021->si143_notafiscaleletronica      = $oDados10->notafiscaleletronica;
      $clntf102021->si143_chaveacesso               = $oDados10->chaveacesso;
      $clntf102021->si143_chaveacessomunicipal      = $oDados10->chaveacessomunicipal;
      $clntf102021->si143_nfaidf                    = $oDados10->nfaidf;
      $clntf102021->si143_dtemissaonf               = $oDados10->dtemissaonf;
      $clntf102021->si143_dtvencimentonf            = $oDados10->dtvencimentonf;
      $clntf102021->si143_nfvalortotal              = $oDados10->nfvalortotal;
      $clntf102021->si143_nfvalordesconto           = $oDados10->nfvalordesconto;
      $clntf102021->si143_nfvalorliquido            = $oDados10->nfvalorliquido;
      $clntf102021->si143_mes                       = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clntf102021->si143_instit                    = db_getsession("DB_instit");

      $clntf102021->incluir(null);

      if ($clntf102021->erro_status == 0) {

        throw new Exception($clntf102021->erro_msg);
      }

      /*
       * selecionar informacoes registro 11
       */

      $sSql = "select '11' as tiporegistro,
        empnota.e69_codnota as codnotafiscal,
        pcmater.pc01_descrmater as coditem,
        empnotaitem.e72_qtd as quantidadeitem,
        empnotaitem.e72_vlrliq as valorunitarioitem
      from empenho.empnota as empnota
      inner join empenho.empnotaitem as empnotaitem on (empnota.e69_codnota=empnotaitem.e72_codnota)
      inner join empenho.empempitem as empempitem on (empnotaitem.e72_empempitem=empempitem.e62_sequencial)
      inner join empenho.empempenho as empempenho on (empnota.e69_numemp=empempenho.e60_numemp)
      inner join compras.pcmater as pcmater on (empempitem.e62_item = pcmater.pc01_codmater)
      inner join empenho.pagordemnota as pagordemnota on (empnota.e69_codnota=pagordemnota.e71_codnota and pagordemnota.e71_anulado = false)
      where empnota.e69_codnota = ".$clntf102021->si143_codnotafiscal;

      $rsResult11 = db_query($sSql);

      for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {

        $clntf112021 = new cl_ntf112021();
        $oDados11 = db_utils::fieldsMemory($rsResult11, $iCont11);

        $clntf112021->si144_tiporegistro           = 11;
        $clntf112021->si144_reg10                  = $clntf102021->si143_sequencial;
        $clntf112021->si144_codnotafiscal          = $clntf112021->codnotafiscal;
        $clntf112021->si144_coditem                = $clntf112021->coditem;
        $clntf112021->si144_quantidadeitem         = $clntf112021->quantidadeitem;
        $clntf112021->si144_valorunitarioitem      = $clntf112021->valorunitarioitem;
        $clntf112021->si144_mes                    = $this->sDataFinal['5'].$this->sDataFinal['6'];
        $clntf112021->si144_instit                 = db_getsession("DB_instit");

        $clntf112021->incluir(null);

        if ($clntf112021->erro_status == 0) {
          throw new Exception($clntf112021->erro_msg);
        }

      }

      /*
       * selecionar informacoes registro 12
       */

      $sSql = "select '12' as tiporegistro,
        empnota.e69_codnota as codnotafiscal,
        'codunidadesub' as codunidadesub,
        empempenho.e60_emiss as dtempenho,
        empempenho.e60_codemp as nroempenho,
        pagordem.e50_data as dtliquidacao,
        pagordemnota.e71_codnota as nroliquidacao,
        orcdotacao.o58_unidade as unidade,
        orcdotacao.o58_orgao as orgao
      from empenho.empnota as empnota
      inner join empenho.empempenho as empempenho on (empnota.e69_numemp=empempenho.e60_numemp)
      inner join empenho.pagordemnota as pagordemnota on (empnota.e69_codnota=pagordemnota.e71_codnota and pagordemnota.e71_anulado = false)
      inner join empenho.pagordem as pagordem on (pagordemnota.e71_codord=pagordem.e50_codord)
      inner join orcamento.orcdotacao as orcdotacao on (empempenho.e60_coddot = orcdotacao.o58_coddot)
      where orcdotacao.o58_anousu = ". db_getsession("DB_anousu") ."
      and empnota.e69_codnota = ". $clntf102021->si143_codnotafiscal;

      //orcdotacao pegar orgão e unidade
      $rsResult12 = db_query($sSql);
      for ($iCont12 = 0; $iCont12 < pg_num_rows($rsResult12); $iCont12++) {

        $clntf122021 = new cl_ntf122021();
        $oDados12 = db_utils::fieldsMemory($rsResult12, $iCont12);

        $clntf122021->si145_tiporegistro           = 12;
        $clntf122021->si145_reg10                  = $clntf102021->si143_sequencial;
        $clntf122021->si145_codnotafiscal          = $oDados12->codnotafiscal;
        $clntf122021->si145_codunidadesub          = str_pad($oDados12->orgao, 2, "0", STR_PAD_LEFT).str_pad($oDados12->unidade, 3, "0", STR_PAD_LEFT);
        $clntf122021->si145_dtempenho              = $oDados12->dtempenho;
        $clntf122021->si145_nroempenho             = $oDados12->nroempenho;
        $clntf122021->si145_dtliquidacao           = $oDados12->dtliquidacao;
        $clntf122021->si145_nroliquidacao          = $oDados12->nroliquidacao;
        $clntf122021->si145_mes                    = $this->sDataFinal['5'].$this->sDataFinal['6'];
        $clntf122021->si145_instit                 = db_getsession("DB_instit");

        $clntf122021->incluir(null);

        if ($clntf122021->erro_status == 0) {
          throw new Exception($clntf122021->erro_msg);
        }

      }

    }

    db_fim_transacao();

    $oGerarNTF = new GerarNTF();
    $oGerarNTF->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarNTF->gerarDados();

  }

}
