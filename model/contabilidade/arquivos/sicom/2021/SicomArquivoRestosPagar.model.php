<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_rsp102021_classe.php");
require_once ("classes/db_rsp112021_classe.php");
require_once ("classes/db_rsp202121_classe.php");
require_once ("classes/db_rsp212021_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarRSP.model.php");

 /**
  * selecionar dados de Leis de Alteração Sicom Acompanhamento Mensal
  * @author Marcelo
  * @package Contabilidade
  */
class SicomArquivoRestosPagar extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
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
  protected $sNomeArquivo = 'RSP';
  
  /* 
   * Contrutor da classe
   */
  public function __construct() {
    
  }
  
  /**
   * retornar o codigo do layout
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
  public function getCampos(){

  }
  
  /**
   * selecionar os dados de Leis de Alteração
   * 
   */
  public function gerarDados() {

    
    $clrsp10 = new cl_rsp102021();
    $clrsp11 = new cl_rsp112021();
    $clrsp20 = new cl_rsp202121();
    $clrsp21 = new cl_rsp212021();
    
    db_inicio_transacao();

        /*
     * excluir informacoes do mes selecionado registro 11
     */
    $result = $clrsp11->sql_record($clrsp11->sql_query(NULL,"*",NULL,"si113_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si113_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      
      $clrsp11->excluir(NULL,"si113_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si113_instit = ".db_getsession("DB_instit"));
      if ($clrsp11->erro_status == 0) {
        throw new Exception($clrsp11->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 10
     */
    $result = $clrsp10->sql_record($clrsp10->sql_query(NULL,"*",NULL,"si112_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si112_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $clrsp10->excluir(NULL,"si112_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si112_instit = ".db_getsession("DB_instit"));
      if ($clrsp10->erro_status == 0) {
        throw new Exception($clrsp10->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 21
     */
    $result = $clrsp21->sql_record($clrsp21->sql_query(NULL,"*",NULL,"si116_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si116_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $clrsp21->excluir(NULL,"si116_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6'] ." and si116_instit = ".db_getsession("DB_instit"));
      if ($clrsp21->erro_status == 0) {
        throw new Exception($clrsp21->erro_msg);
      }
    }
    
    /*
     * excluir informacoes do mes selecionado registro 20
     */
    $result = $clrsp20->sql_record($clrsp20->sql_query(NULL,"*",NULL,"si115_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si115_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $clrsp20->excluir(NULL,"si115_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si115_instit = ".db_getsession("DB_instit"));
      if ($clrsp20->erro_status == 0) {
        throw new Exception($clrsp20->erro_msg);
      }
    }
    
    //echo db_getsession("DB_anousu");

    //echo $this->sDataFinal;exit;
    
    /*$sSql  = "SELECT si09_codorgaotce AS codorgao
              FROM infocomplementaresinstit
              WHERE si09_instit = ".db_getsession("DB_instit");
      
    $rsResult  = db_query($sSql);
    $sCodorgao = db_utils::fieldsMemory($rsResult, 0)->codorgao;*/
  
    /*
     * selecionar informacoes registro 10
     */
    $sSql = "select tiporegistro,
       codreduzidorsp,
       codorgao,
       codunidadesub,
       nroempenho,
       exercicioempenho,
       dtempenho,
       dotorig,
       vlremp as vloriginal,
       (vlremp - vlranu - vlrliq) as vlsaldoantnaoproc, 
       (vlrliq - vlrpag) as vlsaldoantproce
 from (select '10' as tiporegistro, 
  e60_numemp as codreduzidorsp,
  si09_codorgaotce as codorgao,
        lpad(o58_orgao,2,0)||lpad(o58_unidade,3,0) as codunidadesub,
        e60_codemp as nroempenho,
        e60_anousu as exercicioempenho,
  e60_emiss as dtempenho, 
  case when e60_anousu >= 2013 then ' ' else
  lpad(o58_funcao,2,0)||lpad(o58_subfuncao,3,0)||lpad(o58_programa,3,0)||lpad(o58_projativ,4,0)||
  substr(o56_elemento,2,6)||'00' end as dotorig,
                sum(case when c71_coddoc = 1          then round(c70_valor,2) else 0 end) as vlremp,
                sum(case when c71_coddoc in (2,31,32) then round(c70_valor,2) else 0 end) as vlranu,
                sum(case when c71_coddoc in (3,23,33) then round(c70_valor,2)
                         when c71_coddoc in (4,24,34) then round(c70_valor,2) *-1     
                         else 0 end) as vlrliq,
                sum(case when c71_coddoc in (5,35,37) then round(c70_valor,2)
                         when c71_coddoc in (6,36,38) then round(c70_valor,2) *-1
                         else 0 end) as vlrpag
       from     empempenho
                inner join empresto     on e60_numemp = e91_numemp
                inner join conlancamemp on e60_numemp = c75_numemp
                inner join conlancamcgm on c75_codlan = c76_codlan
                inner join cgm          on c76_numcgm = z01_numcgm
                inner join conlancamdoc on c75_codlan = c71_codlan
                inner join conlancam    on c75_codlan = c70_codlan
                inner join orcdotacao   on e60_coddot = o58_coddot
                                       and e60_anousu = o58_anousu
                inner join orcelemento  on o58_codele = o56_codele
                                       and o58_anousu = o56_anousu
                join orctiporec on o58_codigo = o15_codigo
                join db_config on codigo = e60_instit
                left join infocomplementaresinstit on codigo = si09_instit
       where    e60_anousu < ". db_getsession("DB_anousu") ."
            and c70_data <=  '". (db_getsession("DB_anousu") - 1) ."-12-31'
     group by   e60_anousu,
                e60_codemp,
                e60_emiss,
                z01_numcgm,
                z01_cgccpf,
                z01_nome,
                e60_numemp,
                o58_codigo,
                o58_orgao, 
                o58_unidade, 
                o58_funcao, 
                o58_subfuncao, 
                o58_programa, 
                o58_projativ,
                o56_elemento,
                o15_codtri,
                si09_codorgaotce) as restos
    where (vlremp - vlranu - vlrliq) != 0 or (vlrliq - vlrpag) != 0;";

    $rsResult10 = db_query($sSql);
    
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

      $clrsp10 = new cl_rsp102021();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
      
      $clrsp10->si112_tiporegistro                 = 10;
      $clrsp10->si112_codreduzidorsp               = $oDados10->codreduzidorsp;
      $clrsp10->si112_codorgao                     = $oDados10->codorgao;
      $clrsp10->si112_codunidadesub                = $oDados10->codunidadesub;
      $clrsp10->si112_nroempenho                   = $oDados10->nroempenho;
      $clrsp10->si112_exercicioempenho             = $oDados10->exercicioempenho;
      $clrsp10->si112_dtempenho                    = $oDados10->dtempenho;
      $clrsp10->si112_dotorig                      = $oDados10->dotorig;
      $clrsp10->si112_vloriginal                   = $oDados10->vloriginal;
      $clrsp10->si112_vlsaldoantproce              = $oDados10->vlsaldoantproce;
      $clrsp10->si112_vlsaldoantnaoproc            = $oDados10->vlsaldoantnaoproc;
      $clrsp10->si112_mes                          = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clrsp10->si112_instit                       = db_getsession("DB_instit");
      
      $clrsp10->incluir(null);

      if ($clrsp10->erro_status == 0) {
        throw new Exception($clrsp10->erro_msg);
      }
      
      /*
       * selecionar informacoes registro 11
       */
      $sSql = "select tiporegistro,
       codreduzidorsp,
       codfontrecursos,
       vlremp as vloriginal,
       (vlremp - vlranu - vlrliq) as vlsaldoantnaoproc, 
       (vlrliq - vlrpag) as vlsaldoantproce
       from (select '11' as tiporegistro, 
        e60_numemp as codreduzidorsp,
        si09_codorgaotce as codorgao,
        lpad(o58_orgao,2,0)||lpad(o58_unidade,3,0) as codunidadesub,
        e60_codemp as nroempenho,
        e60_anousu as exercicioempenho,
        e60_emiss as dtempenho,
        o15_codtri as codfontrecursos,  
        case when e60_anousu = 2013 then ' ' else
        lpad(o58_funcao,2,0)||lpad(o58_subfuncao,3,0)||lpad(o58_programa,3,0)||lpad(o58_projativ,4,0)||
        substr(o56_elemento,2,6)||'00' end as dotorig,
                sum(case when c71_coddoc = 1          then round(c70_valor,2) else 0 end) as vlremp,
                sum(case when c71_coddoc in (2,31,32) then round(c70_valor,2) else 0 end) as vlranu,
                sum(case when c71_coddoc in (3,23,33) then round(c70_valor,2)
                         when c71_coddoc in (4,24,34) then round(c70_valor,2) *-1     
                         else 0 end) as vlrliq,
                sum(case when c71_coddoc in (5,35,37) then round(c70_valor,2)
                         when c71_coddoc in (6,36,38) then round(c70_valor,2) *-1
                         else 0 end) as vlrpag
        from     empempenho
                inner join empresto     on e60_numemp = e91_numemp
                inner join conlancamemp on e60_numemp = c75_numemp
                inner join conlancamcgm on c75_codlan = c76_codlan
                inner join cgm          on c76_numcgm = z01_numcgm
                inner join conlancamdoc on c75_codlan = c71_codlan
                inner join conlancam    on c75_codlan = c70_codlan
                inner join orcdotacao   on e60_coddot = o58_coddot
                                       and e60_anousu = o58_anousu
                inner join orcelemento  on o58_codele = o56_codele
                                       and o58_anousu = o56_anousu
                join orctiporec on o58_codigo = o15_codigo
                join db_config on codigo = e60_instit
                left join infocomplementaresinstit on codigo = si09_instit
        where   e60_numemp =  '{$clrsp10->si112_codreduzidorsp}'
        group by   e60_anousu,
                e60_codemp,
                e60_emiss,
                z01_numcgm,
                z01_cgccpf,
                z01_nome,
                e60_numemp,
                o58_codigo,
                o58_orgao, 
                o58_unidade, 
                o58_funcao, 
                o58_subfuncao, 
                o58_programa, 
                o58_projativ,
                o56_elemento,
                o15_codtri,
                si09_codorgaotce) as restos
        where (vlremp - vlranu - vlrliq) != 0 or (vlrliq - vlrpag) != 0;";

      $rsResult11 = db_query($sSql);
      for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {
        
        $clrsp11 = new cl_rsp112021();
        $oDados11 = db_utils::fieldsMemory($rsResult11, $iCont11);
        
        $clrsp11->si113_tiporegistro           = 11;
        $clrsp11->si113_reg10                  = $clrsp10->si112_sequencial;
        $clrsp11->si113_codreduzidorsp         = $oDados11->codreduzidorsp;
        $clrsp11->si113_codfontrecursos        = $oDados11->codfontrecursos;
        $clrsp11->si113_vloriginalfonte        = $oDados11->vloriginal;
        $clrsp11->si113_vlsaldoantprocefonte   = $oDados11->vlsaldoantproce;
        $clrsp11->si113_vlsaldoantnaoprocfonte = $oDados11->vlsaldoantnaoproc;
        $clrsp11->si113_mes                    = $this->sDataFinal['5'].$this->sDataFinal['6'];
        $clrsp11->si113_instit                 = db_getsession("DB_instit");
        
        $clrsp11->incluir(null);

        if ($clrsp11->erro_status == 0) {
          throw new Exception($clrsp11->erro_msg);
        }
        
      }
      
    }
    
    /*
     * selecionar informacoes registro 20
     */
    $sSql       = "select '20' as  tiporegistro,
       e60_numemp as codreduzidomov,
       si09_codorgaotce as codorgao,
       lpad(o58_orgao,2,0)||lpad(o58_unidade,3,0) as codunidadesub,
       e60_codemp as nroempenho,
       e60_anousu as exercicioempenho,
       e60_emiss as dtempenho,
       case when c71_coddoc = 32 then 2 else 1 end as tiporestospagar,
       '1' as tipomovimento,
       c71_data as dtmovimentacao,
       case when e60_anousu = 2013 then ' ' else
       lpad(o58_funcao,2,0)||lpad(o58_subfuncao,3,0)||lpad(o58_programa,3,0)||lpad(o58_projativ,4,0)||
       substr(o56_elemento,2,6)||'00' end as dotorig,
       c70_valor as vlmovimentacao,
       ' ' as codorgaoencampatribuic,
       ' ' as codunidadesubencampatribuic,
       e94_motivo as justificativa,
       '99' as atocancelamento,
       '99' as dataatocancelamento
        from conlancamdoc 
        join conlancamemp on c71_codlan = c75_codlan
        join empempenho on c75_numemp = e60_numemp
        join conlancam on c70_codlan = c71_codlan
        inner join orcdotacao on e60_coddot = o58_coddot and e60_anousu = o58_anousu
        inner join orcelemento  on o58_codele = o56_codele and o58_anousu = o56_anousu
        join orctiporec on o58_codigo = o15_codigo
        join db_config on codigo = e60_instit
        join empanulado on e94_numemp = e60_numemp
        left join infocomplementaresinstit on codigo = si09_instit
        where c71_coddoc in (31,32) and c71_data between '{$this->sDataInicial}' and '{$this->sDataFinal}';";
        
    $rsResult20 = db_query($sSql);
    
    for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {
      
      $clrsp20 = new cl_rsp202121();
      $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);
      
      $clrsp20->si115_tiporegistro                   = 20;
      $clrsp20->si115_codreduzidomov                 = $oDados20->codreduzidomov;
      $clrsp20->si115_codorgao                       = $oDados20->codorgao;
      $clrsp20->si115_codunidadesub                  = $oDados20->codunidadesub;
      $clrsp20->si115_nroempenho                     = $oDados20->nroempenho;
      $clrsp20->si115_exercicioempenho               = $oDados20->exercicioempenho;
      $clrsp20->si115_dtempenho                      = $oDados20->dtempenho;
      $clrsp20->si115_tiporestospagar                = $oDados20->tiporestospagar;
      $clrsp20->si115_tipomovimento                  = $oDados20->tipomovimento;
      $clrsp20->si115_dtmovimentacao                 = $oDados20->dtmovimentacao;
      $clrsp20->si115_dotorig                        = $oDados20->dotorig;
      $clrsp20->si115_vlmovimentacao                 = $oDados20->vlmovimentacao;
      $clrsp20->si115_codorgaoencampatribuic         = $oDados20->codorgaoencampatribuic;
      $clrsp20->si115_codunidadesubencampatribuic    = $oDados20->codunidadesubencampatribuic;
      $clrsp20->si115_justificativa                  = $oDados20->justificativa;
      $clrsp20->si115_atocancelamento                = $oDados20->atocancelamento;
      $clrsp20->si115_dataatocancelamento            = $oDados20->dataatocancelamento;
      $clrsp20->si115_mes                            = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clrsp20->si115_instit                         = db_getsession("DB_instit");
      
      $clrsp20->incluir(null);
      if ($clrsp20->erro_status == 0) {
        throw new Exception($clrsp20->erro_msg);
      }
      
      /*
       * selecionar informacoes registro 21
       */

      $sSql = "select '21' as  tiporegistro,
       e60_numemp as codreduzidomov,
       o15_codtri as codfontrecursos, 
       c70_valor as vlmovimentacao
       from conlancamdoc 
       join conlancamemp on c71_codlan = c75_codlan
       join empempenho on c75_numemp = e60_numemp
       join conlancam on c70_codlan = c71_codlan
       inner join orcdotacao on e60_coddot = o58_coddot and e60_anousu = o58_anousu
       inner join orcelemento  on o58_codele = o56_codele and o58_anousu = o56_anousu
       join orctiporec on o58_codigo = o15_codigo
       join db_config on codigo = e60_instit
       join empanulado on e94_numemp = e60_numemp
       left join infocomplementaresinstit on codigo = si09_instit
       where c71_data between '{$this->sDataInicial}' and '{$this->sDataFinal}' and e60_numemp = '{$clrsp20->si115_codreduzidomov}';";

      $rsResult21 = db_query($sSql);
      for ($iCont21 = 0; $iCont21 < pg_num_rows($rsResult21); $iCont21++) {
        
        $clrsp21 = new cl_rsp212021();
        $oDados21 = db_utils::fieldsMemory($rsResult21, $iCont21);
        
        $clrsp21->si116_tiporegistro            = 21;
        $clrsp21->si116_reg20                   = $clrsp20->si115_sequencial;
        $clrsp21->si116_codreduzidomov          = $oDados20->codreduzidomov;
        $clrsp21->si116_codfontrecursos         = $oDados21->codfontrecursos;
        $clrsp21->si116_vlmovimentacaofonte     = $oDados21->vlmovimentacaofonte;
        $clrsp21->si116_mes                     = $this->sDataFinal['5'].$this->sDataFinal['6'];
        $clrsp21->si116_instit                  = db_getsession("DB_instit");
        
        $clrsp21->incluir(null);
        if ($clrsp21->erro_status == 0) {
          throw new Exception($clrsp21->erro_msg);
        }
        
      }
      
    }
    
    db_fim_transacao();
    
    $oGerarRSP = new GerarRSP();
    $oGerarRSP->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarRSP->gerarDados();
    
  }
  
}
