<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_rsp102014_classe.php");
require_once ("classes/db_rsp112014_classe.php");
require_once ("classes/db_rsp202014_classe.php");
require_once ("classes/db_rsp212014_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2014/GerarRSP.model.php");

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

    
    $clrsp102014 = new cl_rsp102014();
    $clrsp112014 = new cl_rsp112014();
    $clrsp122014 = new cl_rsp122014();
    $clrsp202014 = new cl_rsp202014();
    $clrsp212014 = new cl_rsp212014();
    
    db_inicio_transacao();
    
   /*
     * excluir informacoes do mes selecionado registro 12
     */
    $result = $clrsp122014->sql_record($clrsp122014->sql_query(NULL,"*",NULL,"si114_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si114_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      
      $clrsp122014->excluir(NULL,"si114_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si114_instit = ".db_getsession("DB_instit"));
      if ($clrsp122014->erro_status == 0) {
        throw new Exception($clrsp122014->erro_msg);
      }
    }

        /*
     * excluir informacoes do mes selecionado registro 11
     */
    $result = $clrsp112014->sql_record($clrsp112014->sql_query(NULL,"*",NULL,"si113_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si113_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      
      $clrsp112014->excluir(NULL,"si113_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si113_instit = ".db_getsession("DB_instit"));
      if ($clrsp112014->erro_status == 0) {
        throw new Exception($clrsp112014->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 10
     */
    $result = $clrsp102014->sql_record($clrsp102014->sql_query(NULL,"*",NULL,"si112_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si112_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $clrsp102014->excluir(NULL,"si112_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si112_instit = ".db_getsession("DB_instit"));
      if ($clrsp102014->erro_status == 0) {
        throw new Exception($clrsp102014->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 21
     */
    $result = $clrsp212014->sql_record($clrsp212014->sql_query(NULL,"*",NULL,"si116_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si116_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $clrsp212014->excluir(NULL,"si116_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6'] ." and si116_instit = ".db_getsession("DB_instit"));
      if ($clrsp212014->erro_status == 0) {
        throw new Exception($clrsp212014->erro_msg);
      }
    }
    
    /*
     * excluir informacoes do mes selecionado registro 20
     */
    $result = $clrsp202014->sql_record($clrsp202014->sql_query(NULL,"*",NULL,"si115_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si115_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $clrsp202014->excluir(NULL,"si115_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si115_instit = ".db_getsession("DB_instit"));
      if ($clrsp202014->erro_status == 0) {
        throw new Exception($clrsp202014->erro_msg);
      }
    }
    
    //echo db_getsession("DB_anousu");

    //echo $this->sDataFinal;exit;
    
    /*$sSql  = "SELECT si09_codorgaotce AS codorgao
              FROM infocomplementaresinstit
              WHERE si09_instit = ".db_getsession("DB_instit");
      
    $rsResult  = db_query($sSql);
    $sCodorgao = db_utils::fieldsMemory($rsResult, 0)->codorgao;*/
  
    if( $this->sDataFinal['5'].$this->sDataFinal['6'] == '01'){
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
       (vlrliq - vlrpag) as vlsaldoantproce,
       codfontrecursos,vlremp , vlranu , vlrliq,vlrpag,tipodoccredor,documentocreddor,e60_anousu,pessoal
 from (select '10' as tiporegistro, 
  e60_numemp as codreduzidorsp,
  si09_codorgaotce as codorgao,
        lpad(o58_orgao,2,0)||lpad(o58_unidade,3,0) as codunidadesub,
        e60_codemp as nroempenho,
        e60_anousu as exercicioempenho,
  e60_emiss as dtempenho, 
  case when e60_anousu = 2013 then ' ' else
  lpad(o58_funcao,2,0)||lpad(o58_subfuncao,3,0)||lpad(o58_programa,4,0)||lpad(o58_projativ,4,0)||
  substr(o56_elemento,2,6)||'00' end as dotorig,
                sum(case when c71_coddoc IN (select c53_coddoc from conhistdoc where c53_tipo = 10)          then round(c70_valor,2) else 0 end) as vlremp,
                sum(case when c71_coddoc in (select c53_coddoc from conhistdoc where c53_tipo = 11) then round(c70_valor,2) else 0 end) as vlranu,
                sum(case when c71_coddoc in (select c53_coddoc from conhistdoc where c53_tipo = 20) then round(c70_valor,2)
                         when c71_coddoc in (select c53_coddoc from conhistdoc where c53_tipo = 21) then round(c70_valor,2) *-1     
                         else 0 end) as vlrliq,
                sum(case when c71_coddoc in (select c53_coddoc from conhistdoc where c53_tipo = 30) then round(c70_valor,2)
                         when c71_coddoc in (select c53_coddoc from conhistdoc where c53_tipo = 31) then round(c70_valor,2) *-1
                         else 0 end) as vlrpag,
                         o15_codtri as codfontrecursos, 
                         case when length(z01_cgccpf) = 11 then 1 else 2 end as tipodoccredor, 
                         z01_cgccpf as documentocreddor,e60_anousu,
                         substr(o56_elemento,2,6) as pessoal
       from     empempenho
                inner join empresto     on e60_numemp = e91_numemp and e91_anousu = ".db_getsession("DB_anousu")." 
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
       where    e60_anousu < ".db_getsession("DB_anousu")." and e60_instit = ".db_getsession("DB_instit")."
            and c70_data <=  '".(db_getsession("DB_anousu") -1)."-12-31'
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
    where (vlremp - vlranu - vlrliq) >= 0 and (vlrliq - vlrpag) >= 0";

    $rsResult10 = db_query($sSql);
    //echo $sSql; db_criatabela($rsResult10);exit;
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

      $clrsp102014 = new cl_rsp102014();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
      
      $clrsp102014->si112_tiporegistro                 = 10;
      $clrsp102014->si112_codreduzidorsp               = $oDados10->codreduzidorsp;
      $clrsp102014->si112_codorgao                     = $oDados10->codorgao;
      $clrsp102014->si112_codunidadesub                = $oDados10->codunidadesub;
      $clrsp102014->si112_codunidadesuborig            = $oDados10->codunidadesub;
      $clrsp102014->si112_nroempenho                   = $oDados10->nroempenho;
      $clrsp102014->si112_exercicioempenho             = $oDados10->exercicioempenho;
      $clrsp102014->si112_dtempenho                    = $oDados10->dtempenho;
      $clrsp102014->si112_dotorig                      = $oDados10->dotorig;
      $clrsp102014->si112_vloriginal                   = $oDados10->vloriginal;
      $clrsp102014->si112_vlsaldoantproce              = $oDados10->vlsaldoantproce;
      $clrsp102014->si112_vlsaldoantnaoproc            = $oDados10->vlsaldoantnaoproc;
      $clrsp102014->si112_mes                          = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clrsp102014->si112_instit                       = db_getsession("DB_instit");
      
      $clrsp102014->incluir(null);

      if ($clrsp102014->erro_status == 0) {
        throw new Exception($clrsp102014->erro_msg);
      }
      
        $clrsp112014->si113_tiporegistro           = 11;
        $clrsp112014->si113_reg10                  = $clrsp102014->si112_sequencial;
        $clrsp112014->si113_codreduzidorsp         = $oDados10->codreduzidorsp;
        $clrsp112014->si113_codfontrecursos        = $oDados10->codfontrecursos;
        $clrsp112014->si113_vloriginalfonte        = $oDados10->vloriginal;
        $clrsp112014->si113_vlsaldoantprocefonte   = $oDados10->vlsaldoantproce;
        $clrsp112014->si113_vlsaldoantnaoprocfonte = $oDados10->vlsaldoantnaoproc;
        $clrsp112014->si113_mes                    = $this->sDataFinal['5'].$this->sDataFinal['6'];
        $clrsp112014->si113_instit                 = db_getsession("DB_instit");
        
        $clrsp112014->incluir(null);

        if ($clrsp112014->erro_status == 0) {
          throw new Exception($clrsp112014->erro_msg);
        }
        
        if( $oDados10->e60_anousu != 2013 ){
        	if ( $oDados10->pessoal != '319011' || $oDados10->pessoal != '319004'){
		        $clrsp122014->si114_tiporegistro           = 12;
		        $clrsp122014->si114_reg10                  = $clrsp102014->si112_sequencial;
		        $clrsp122014->si114_codreduzidorsp         = $oDados10->codreduzidorsp;
		        $clrsp122014->si114_tipodocumento          = $oDados10->tipodoccredor;
		        $clrsp122014->si114_nrodocumento       	   = $oDados10->documentocreddor;
		        $clrsp122014->si114_mes                    = $this->sDataFinal['5'].$this->sDataFinal['6'];
		        $clrsp122014->si114_instit                 = db_getsession("DB_instit");
		        
		        $clrsp122014->incluir(null);
		
		        if ($clrsp122014->erro_status == 0) {
		          throw new Exception($clrsp122014->erro_msg);
		        }
        	}
        }
      
      
    }
  }
    /*
     * selecionar informacoes registro 20
     */
    $sSql       = "select '20' as  tiporegistro,
					       c70_codlan as codreduzidomov,
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
					       e60_codemp as atocancelamento,
					       c71_data as dataatocancelamento,o15_codtri as codfontrecursos
        from conlancamdoc 
        join conlancamemp on c71_codlan = c75_codlan
        join empempenho on c75_numemp = e60_numemp
        join conlancam on c70_codlan = c71_codlan
        join orcdotacao on e60_coddot = o58_coddot and e60_anousu = o58_anousu
        join orcelemento  on o58_codele = o56_codele and o58_anousu = o56_anousu
        join orctiporec on o58_codigo = o15_codigo
        join db_config on codigo = e60_instit
        join empanulado on e94_numemp = e60_numemp and c71_data = e94_data and c70_valor = e94_valor
        left join infocomplementaresinstit on codigo = si09_instit
        where c71_coddoc in (31,32) and c71_data between '{$this->sDataInicial}' and '{$this->sDataFinal}' ";
        
    $rsResult20 = db_query($sSql);
    //echo $sSql;db_criatabela($rsResult20);
    
    $aDadosAgrupados = array();
    for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {
      
    	$oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);
    	$sHash = $oDados20->nroempenho.$oDados20->exercicioempenho.$oDados20->dtmovimentacao;
    	if (!$aDadosAgrupados[$sHash]) {
    		
	    	$clrsp202014 = new stdClass();
	      
	      $clrsp202014->si115_tiporegistro                   = 20;
	      $clrsp202014->si115_codreduzidomov                 = $oDados20->codreduzidomov;
	      $clrsp202014->si115_codorgao                       = $oDados20->codorgao;
	      $clrsp202014->si115_codunidadesub                  = $oDados20->codunidadesub;
	      $clrsp202014->si115_nroempenho                     = $oDados20->nroempenho;
	      $clrsp202014->si115_exercicioempenho               = $oDados20->exercicioempenho;
	      $clrsp202014->si115_dtempenho                      = $oDados20->dtempenho;
	      $clrsp202014->si115_tiporestospagar                = $oDados20->tiporestospagar;
	      $clrsp202014->si115_tipomovimento                  = $oDados20->tipomovimento;
	      $clrsp202014->si115_dtmovimentacao                 = $oDados20->dtmovimentacao;
	      $clrsp202014->si115_dotorig                        = $oDados20->dotorig;
	      $clrsp202014->si115_vlmovimentacao                 = $oDados20->vlmovimentacao;
	      $clrsp202014->si115_codorgaoencampatribuic         = $oDados20->codorgaoencampatribuic;
	      $clrsp202014->si115_codunidadesubencampatribuic    = $oDados20->codunidadesubencampatribuic;
	      $clrsp202014->si115_justificativa                  = $oDados20->justificativa;
	      $clrsp202014->si115_atocancelamento                = $oDados20->atocancelamento;
	      $clrsp202014->si115_dataatocancelamento            = $oDados20->dataatocancelamento;
	      $clrsp202014->si115_mes                            = $this->sDataFinal['5'].$this->sDataFinal['6'];
	      $clrsp202014->si115_instit                         = db_getsession("DB_instit");
	      
	      $aDadosAgrupados[$sHash] = $clrsp202014;
      
             
        $clrsp212014 = new stdClass();
       
        $clrsp212014->si116_tiporegistro            = 21;
        $clrsp212014->si116_codreduzidomov          = $oDados20->codreduzidomov;
        $clrsp212014->si116_codfontrecursos         = $oDados20->codfontrecursos;
        $clrsp212014->si116_vlmovimentacaofonte     = $oDados20->vlmovimentacao;
        $clrsp212014->si116_mes                     = $this->sDataFinal['5'].$this->sDataFinal['6'];
        $clrsp212014->si116_instit                  = db_getsession("DB_instit");
        
        $aDadosAgrupados[$sHash]->reg21 = $clrsp212014;
        
    	} else {
    		$aDadosAgrupados[$sHash]->si115_vlmovimentacao += $oDados20->vlmovimentacao;
    		$aDadosAgrupados[$sHash]->reg21->si116_vlmovimentacaofonte += $oDados20->vlmovimentacao;
    	}
    	
    }
    
    foreach ($aDadosAgrupados as $oDados) {
      
      $clrsp202014 = new cl_rsp202014();
      
      $clrsp202014->si115_tiporegistro                   = 20;
      $clrsp202014->si115_codreduzidomov                 = $oDados->si115_codreduzidomov;
      $clrsp202014->si115_codorgao                       = $oDados->si115_codorgao;
      $clrsp202014->si115_codunidadesub                  = $oDados->si115_codunidadesub;
      $clrsp202014->si115_nroempenho                     = $oDados->si115_nroempenho;
      $clrsp202014->si115_exercicioempenho               = $oDados->si115_exercicioempenho;
      $clrsp202014->si115_dtempenho                      = $oDados->si115_dtempenho;
      $clrsp202014->si115_tiporestospagar                = $oDados->si115_tiporestospagar;
      $clrsp202014->si115_tipomovimento                  = $oDados->si115_tipomovimento;
      $clrsp202014->si115_dtmovimentacao                 = $oDados->si115_dtmovimentacao;
      $clrsp202014->si115_dotorig                        = $oDados->si115_dotorig;
      $clrsp202014->si115_vlmovimentacao                 = $oDados->si115_vlmovimentacao;
      $clrsp202014->si115_codorgaoencampatribuic         = $oDados->si115_codorgaoencampatribuic;
      $clrsp202014->si115_codunidadesubencampatribuic    = $oDados->si115_codunidadesubencampatribuic;
      $clrsp202014->si115_justificativa                  = $oDados->si115_justificativa;
      $clrsp202014->si115_atocancelamento                = $oDados->si115_atocancelamento;
      $clrsp202014->si115_dataatocancelamento            = $oDados->si115_dataatocancelamento;
      $clrsp202014->si115_mes                            = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clrsp202014->si115_instit                         = db_getsession("DB_instit");
      
      $clrsp202014->incluir(null);
      if ($clrsp202014->erro_status == 0) {
        throw new Exception($clrsp202014->erro_msg);
      }
      
             
        $clrsp212014 = new cl_rsp212014();
       
        
        $clrsp212014->si116_tiporegistro            = 21;
        $clrsp212014->si116_reg20                   = $clrsp202014->si115_sequencial;
        $clrsp212014->si116_codreduzidomov          = $oDados->reg21->si116_codreduzidomov;
        $clrsp212014->si116_codfontrecursos         = $oDados->reg21->si116_codfontrecursos;
        $clrsp212014->si116_vlmovimentacaofonte     = $oDados->reg21->si116_vlmovimentacaofonte;
        $clrsp212014->si116_mes                     = $this->sDataFinal['5'].$this->sDataFinal['6'];
        $clrsp212014->si116_instit                  = db_getsession("DB_instit");
        
        $clrsp212014->incluir(null);
        if ($clrsp212014->erro_status == 0) {
          throw new Exception($clrsp212014->erro_msg);
        }
      
    }
    
    db_fim_transacao();
    
    $oGerarRSP = new GerarRSP();
    $oGerarRSP->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarRSP->gerarDados();
    
  }
  
}