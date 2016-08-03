<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_ntf102014_classe.php");
require_once ("classes/db_ntf112014_classe.php");
require_once ("classes/db_ntf122014_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2014/GerarNTF.model.php");

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
    
  	$clntf102014 = new cl_ntf102014();
    $clntf112014 = new cl_ntf112014();
    $clntf122014 = new cl_ntf122014();

    
    
      db_inicio_transacao();
    
    /*
     * excluir informacoes do mes selecionado registro 12
     */
    $result = $clntf122014->sql_record($clntf122014->sql_query(NULL,"*",NULL,"si145_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si145_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      
      $clntf122014->excluir(NULL,"si145_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si145_instit = ".db_getsession("DB_instit"));
      if ($clntf122014->erro_status == 0) {
        throw new Exception($clntf122014->erro_msg);
      }
    }

     /*
     * excluir informacoes do mes selecionado registro 11
     */
    $result = $clntf112014->sql_record($clntf112014->sql_query(NULL,"*",NULL,"si144_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si144_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      
      $clntf112014->excluir(NULL,"si144_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si144_instit = ".db_getsession("DB_instit"));
      if ($clntf112014->erro_status == 0) {
        throw new Exception($clntf112014->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 10
     */
    $result = $clntf102014->sql_record($clntf102014->sql_query(NULL,"*",NULL,"si143_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si143_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clntf102014->excluir(NULL,"si143_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si143_instit = ".db_getsession("DB_instit"));
      if ($clntf102014->erro_status == 0) {
        throw new Exception($clntf102014->erro_msg);
      }
    }
    
    $sSqlTrataUnidade = "select si08_tratacodunidade from infocomplementares where si08_instit = ".db_getsession("DB_instit");
	$rsResultTrataUnidade = db_query($sSqlTrataUnidade);
	$sTrataCodUnidade = db_utils::fieldsMemory($rsResultTrataUnidade, 0)->si08_tratacodunidade;
    
    $sSql  = "SELECT si09_codorgaotce AS codorgao
              FROM infocomplementaresinstit
              WHERE si09_instit = ".db_getsession("DB_instit");
      
    $rsResult  = db_query($sSql);
    $sCodorgao = db_utils::fieldsMemory($rsResult, 0)->codorgao;
    
    /*
     * selecionar informacoes registro 10
     */


    $sSql = "select distinct  '10' as tiporegistro,
              empnota.e69_codnota as codnotafiscal,
              si09_codorgaotce as codorgao,
              empnota.e69_numero as nfnumero,
              'A' as nfserie,
              (case length(cgm.z01_cgccpf) when 11 then 1
                else 2
              end) as tipodocumento,
              cgm.z01_cgccpf  as nrodocumento,
              REPLACE(cgm.z01_incest,'.','') as nroinscestadual,
              cgm.z01_incmunici as nroinscmunicipal,
              cadendermunicipio.db72_descricao as nomemunicipio,
              cgm.z01_cep as cepmunicipio,
              cgm.z01_uf as ufcredor,
              3 as notafiscaleletronica,
              ' ' as chaveacesso,
              ' ' as chaveacessomunicipal,
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
            where   db_config.codigo = ".db_getsession("DB_instit")."
            and empempenho.e60_anousu = ".db_getsession("DB_anousu")."
            and date_part('year',empnota.e69_dtnota) = ".$this->sDataFinal['0'].$this->sDataFinal['1'].$this->sDataFinal['2'].$this->sDataFinal['3']."
            and   date_part('month',empnota.e69_dtnota) = ".$this->sDataFinal['5'].$this->sDataFinal['6']."
            and date_part('year',pagordem.e50_data) = ".$this->sDataFinal['0'].$this->sDataFinal['1'].$this->sDataFinal['2'].$this->sDataFinal['3']."
            and   date_part('month',pagordem.e50_data) = ".$this->sDataFinal['5'].$this->sDataFinal['6']."
            order by empnota .e69_numero";

    $rsResult10 = db_query($sSql);//db_criatabela($rsResult10);
    
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
      
      $clntf102014 = new cl_ntf102014();

      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
      
      
      $clntf102014->si143_tiporegistro              = 10;
      $clntf102014->si143_codnotafiscal             = $oDados10->codnotafiscal;
      $clntf102014->si143_codorgao                  = $oDados10->codorgao;

      $oDados10->nfnumero = str_replace("/", "", $oDados10->nfnumero);
      if(!ereg('[^0-9]',$oDados10->nfnumero)){
        $clntf102014->si143_nfnumero                  = null;
      }else{
        $clntf102014->si143_nfnumero                  = $oDados10->nfnumero;
      }

      $clntf102014->si143_nfserie                   = $oDados10->nfserie;
      $clntf102014->si143_tipodocumento             = $oDados10->tipodocumento;
      $clntf102014->si143_nrodocumento              = $oDados10->nrodocumento;
      $clntf102014->si143_nroinscestadual           = preg_replace("/[^0-9]/", "", $oDados10->nroinscestadual);//is_int($oDados10->nroinsdestadual)== true? $oDados10->nroinsdestadual:' ';
      $clntf102014->si143_nroinscmunicipal          = is_int($oDados10->nroinscmunicipal)==true?$oDados10->nroinscmunicipal:' '; 
      $clntf102014->si143_nomemunicipio             = $oDados10->nomemunicipio;
      $clntf102014->si143_cepmunicipio              = $oDados10->cepmunicipio;
      $clntf102014->si143_ufcredor                  = $oDados10->ufcredor;
      $clntf102014->si143_notafiscaleletronica      = $oDados10->notafiscaleletronica;
      $clntf102014->si143_chaveacesso               = $oDados10->chaveacesso;
      $clntf102014->si143_chaveacessomunicipal      = $oDados10->chaveacessomunicipal;
      $clntf102014->si143_nfaidf                    = $oDados10->nfaidf;
      $clntf102014->si143_dtemissaonf               = $oDados10->dtemissaonf;
      $clntf102014->si143_dtvencimentonf            = $oDados10->dtvencimentonf;
      $clntf102014->si143_nfvalortotal              = $oDados10->nfvalortotal;
      $clntf102014->si143_nfvalordesconto           = $oDados10->nfvalordesconto;
      $clntf102014->si143_nfvalorliquido            = $oDados10->nfvalorliquido;
      $clntf102014->si143_mes                       = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clntf102014->si143_instit                    = db_getsession("DB_instit");

      $clntf102014->incluir(null);

      if ($clntf102014->erro_status == 0) {

        throw new Exception($clntf102014->erro_msg);
      }
        
      /*
       * selecionar informacoes registro 11
       */

      /*$sSql = "select distinct '11' as tiporegistro,e72_sequencial,
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
      where empnota.e69_codnota = ".$clntf102014->si143_codnotafiscal;
      
      $rsResult11 = db_query($sSql);//db_criatabela($rsResult11);

      $aDadosAgrupados11 = array();
      for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {
        
        $oDados11 = db_utils::fieldsMemory($rsResult11, $iCont11);

        $sHash11 = $oDados11->coditem;
        if (!isset($aDadosAgrupados11[$sHash11])) {
        
        	$oNtf112014 = new stdClass();
        	$oNtf112014->si144_tiporegistro           = 11;
          $oNtf112014->si144_reg10                  = $clntf102014->si143_sequencial;
          $oNtf112014->si144_codnotafiscal          = $oDados11->codnotafiscal;
          $oNtf112014->si144_coditem                = $oDados11->coditem;
          $oNtf112014->si144_quantidadeitem         = $oDados11->quantidadeitem;
          $oNtf112014->si144_valorunitarioitem      = $oDados11->valorunitarioitem;
          $oNtf112014->si144_mes                    = $this->sDataFinal['5'].$this->sDataFinal['6'];
          $oNtf112014->si144_instit                 = db_getsession("DB_instit");
          $aDadosAgrupados11[$sHash11] = $oNtf112014;
          
        } else {
        	$aDadosAgrupados11[$sHash11]->si144_quantidadeitem    += $oDados11->quantidadeitem;
        	$aDadosAgrupados11[$sHash11]->si144_valorunitarioitem += $oDados11->valorunitarioitem;
        }
        
        
      }
      
      foreach ($aDadosAgrupados11 as $oDadosAgrupados11) {
        
        $clntf112014 = new cl_ntf112014();

        $clntf112014->si144_tiporegistro           = $oDadosAgrupados11->si144_tiporegistro;
        $clntf112014->si144_reg10                  = $oDadosAgrupados11->si144_reg10;
        $clntf112014->si144_codnotafiscal          = $oDadosAgrupados11->si144_codnotafiscal;
        $clntf112014->si144_coditem                = $oDadosAgrupados11->si144_coditem;
        $clntf112014->si144_quantidadeitem         = $oDadosAgrupados11->si144_quantidadeitem;
        $clntf112014->si144_valorunitarioitem      = $oDadosAgrupados11->si144_valorunitarioitem/$oDadosAgrupados11->si144_quantidadeitem;
        $clntf112014->si144_mes                    = $oDadosAgrupados11->si144_mes;
        $clntf112014->si144_instit                 = $oDadosAgrupados11->si144_instit;
        
        //echo "<pre>";print_r($clntf112014);exit;
        
        $clntf112014->incluir(null);

        if ($clntf112014->erro_status == 0) {
          throw new Exception($clntf112014->erro_msg);
        }
        
      }*/

      /*
       * selecionar informacoes registro 12
       */

      $sSql = "select '12' as tiporegistro,
        empnota.e69_codnota as codnotafiscal,
        lpad(o58_orgao,2,0)||lpad(o58_unidade,3,0) as codunidadesub,
        empempenho.e60_emiss as dtempenho,
        empempenho.e60_codemp as nroempenho,
        pagordem.e50_data as dtliquidacao,
        pagordemnota.e71_codnota as nroliquidacao,   
        orcdotacao.o58_unidade as unidade,
        orcdotacao.o58_orgao as orgao,
        lpad(o41_subunidade::varchar,3,0) as subunidade
      from empenho.empnota as empnota
      inner join empenho.empempenho as empempenho on (empnota.e69_numemp=empempenho.e60_numemp)
      inner join empenho.pagordemnota as pagordemnota on (empnota.e69_codnota=pagordemnota.e71_codnota and pagordemnota.e71_anulado = false)
      inner join empenho.pagordem as pagordem on (pagordemnota.e71_codord=pagordem.e50_codord)
      inner join orcamento.orcdotacao as orcdotacao on (empempenho.e60_coddot = orcdotacao.o58_coddot)
      left join infocomplementaresinstit on si09_instit = empempenho.e60_instit
      LEFT JOIN orcunidade on o58_anousu = o41_anousu and o58_orgao = o41_orgao and o58_unidade = o41_unidade
      where orcdotacao.o58_anousu = ". db_getsession("DB_anousu") ."
      and empnota.e69_codnota = ". $clntf102014->si143_codnotafiscal;
      
      //orcdotacao pegar orgão e unidade
      $rsResult12 = db_query($sSql);
      for ($iCont12 = 0; $iCont12 < pg_num_rows($rsResult12); $iCont12++) {
        
        $clntf122014 = new cl_ntf122014();
        $oDados12 = db_utils::fieldsMemory($rsResult12, $iCont12);
        
        $clntf122014->si145_tiporegistro           = 12;
        $clntf122014->si145_reg10                  = $clntf102014->si143_sequencial;
        $clntf122014->si145_codnotafiscal          = $oDados12->codnotafiscal;
        $clntf122014->si145_codunidadesub          = $oDados12->codunidadesub.($oDados12->subunidade == '001' ?$oDados12->subunidade : '');
        $clntf122014->si145_dtempenho              = $oDados12->dtempenho;
        $clntf122014->si145_nroempenho             = $oDados12->nroempenho;
        $clntf122014->si145_dtliquidacao           = $oDados12->dtliquidacao;
        $clntf122014->si145_nroliquidacao          = $oDados12->nroliquidacao;
        $clntf122014->si145_mes                    = $this->sDataFinal['5'].$this->sDataFinal['6'];
        $clntf122014->si145_instit                 = db_getsession("DB_instit");
        
        $clntf122014->incluir(null);

        if ($clntf122014->erro_status == 0) {
          throw new Exception($clntf122014->erro_msg);
        }
        
      }
 
    }

    db_fim_transacao();
    
    $oGerarNTF = new GerarNTF();
    $oGerarNTF->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarNTF->gerarDados();
    
  }

}