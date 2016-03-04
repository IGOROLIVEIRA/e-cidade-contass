<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_contratos102016_classe.php");
require_once ("classes/db_contratos112016_classe.php");
require_once ("classes/db_contratos122016_classe.php");
require_once ("classes/db_contratos132016_classe.php");
require_once ("classes/db_contratos202016_classe.php");
require_once ("classes/db_contratos212016_classe.php");
require_once ("classes/db_contratos302016_classe.php");
require_once ("classes/db_contratos402016_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2016/GerarCONTRATOS.model.php");


 /**
  * Contratos Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoContratos extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 163;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'CONTRATOS';
  
  /**
   * 
   * Construtor da classe
   */
  public function __construct() {
    
  }
  
  /**
	 * Retorna o codigo do layout
	 *
	 * @return Integer
	 */
  public function getCodigoLayout(){
    return $this->iCodigoLayout;
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios 
   *para o escritor gerar o arquivo CSV 
   */
  public function getCampos(){
    
  }
  
  /**
   * selecionar os dados de Leis de Alteraзгo
   * 
   */
  public function gerarDados() {
    
    $clcontratos10 = new cl_contratos102016();
    $clcontratos11 = new cl_contratos112016();
    $clcontratos12 = new cl_contratos122016();
    $clcontratos13 = new cl_contratos132016();
    $clcontratos20 = new cl_contratos202016();
    $clcontratos21 = new cl_contratos212016();
    $clcontratos30 = new cl_contratos302016();
    $clcontratos40 = new cl_contratos402016();
    
    db_inicio_transacao();
    // matriz de entrada
    $what = array("°",chr(13),chr(10), 'д','г','а','б','в','к','л','и','й','п','м','н','ц','х','т','у','ф','ь','щ','ъ','ы','А','Б','Г','Й','Н','У','Ъ','с','С','з','З',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','Є','є' );

    // matriz de saнda
    $by   = array('','','', 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','A','E','I','O','U','n','n','c','C',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ' );

    /*
     * excluir informacoes do mes selecionado registro 13
     */
    $result = $clcontratos13->sql_record($clcontratos13->sql_query(NULL,"*",NULL,"si86_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si86_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      
      $clcontratos13->excluir(NULL,"si86_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si86_instit = ".db_getsession("DB_instit"));
      if ($clcontratos13->erro_status == 0) {
        throw new Exception($clcontratos13->erro_msg);
      }
    }
    //echo pg_last_error();exit;
    
    /*
     * excluir informacoes do mes selecionado registro 12
     */
    $result = $clcontratos12->sql_record($clcontratos12->sql_query(NULL,"*",NULL,"si85_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si85_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      
      $clcontratos12->excluir(NULL,"si85_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si85_instit = ".db_getsession("DB_instit"));
      if ($clcontratos12->erro_status == 0) {
        throw new Exception($clcontratos12->erro_msg);
      }
    }

     /*
     * excluir informacoes do mes selecionado registro 11
     */
    $result = $clcontratos11->sql_record($clcontratos11->sql_query(NULL,"*",NULL,"si84_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si84_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      
      $clcontratos11->excluir(NULL,"si84_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si84_instit = ".db_getsession("DB_instit"));
      if ($clcontratos11->erro_status == 0) {
        throw new Exception($clcontratos11->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 10
     */
    $result = $clcontratos10->sql_record($clcontratos10->sql_query(NULL,"*",NULL,"si83_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si83_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clcontratos10->excluir(NULL,"si83_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si83_instit = ".db_getsession("DB_instit"));
      if ($clcontratos10->erro_status == 0) {
        throw new Exception($clcontratos10->erro_msg);
      }
    }
    
    /*
     * excluir informacoes do mes selecionado registro 21
     */
    $result = $clcontratos21->sql_record($clcontratos21->sql_query(NULL,"*",NULL,"si88_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si88_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clcontratos21->excluir(NULL,"si88_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si88_instit = ".db_getsession("DB_instit"));
      if ($clcontratos21->erro_status == 0) {
        throw new Exception($clcontratos21->erro_msg);
      }
    }
    
    /*
     * excluir informacoes do mes selecionado registro 20
     */
    $result = $clcontratos20->sql_record($clcontratos20->sql_query(NULL,"*",NULL,"si87_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si87_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clcontratos20->excluir(NULL,"si87_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si87_instit = ".db_getsession("DB_instit"));
      if ($clcontratos20->erro_status == 0) {
        throw new Exception($clcontratos20->erro_msg);
      }
    }
    
    /*
     * excluir informacoes do mes selecionado registro 30
     */
    $result = $clcontratos30->sql_record($clcontratos30->sql_query(NULL,"*",NULL,"si89_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si89_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clcontratos30->excluir(NULL,"si89_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si89_instit = ".db_getsession("DB_instit"));
      if ($clcontratos30->erro_status == 0) {
        throw new Exception($clcontratos30->erro_msg);
      }
    }
    
    /*
     * excluir informacoes do mes selecionado registro 40
     */
    $result = $clcontratos40->sql_record($clcontratos40->sql_query(NULL,"*",NULL,"si91_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si91_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clcontratos40->excluir(NULL,"si91_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si91_instit = ".db_getsession("DB_instit"));
      if ($clcontratos40->erro_status == 0) {
        throw new Exception($clcontratos40->erro_msg);
      }
    }
   db_fim_transacao();
    $sSql  = "SELECT si09_codorgaotce AS codorgao
              FROM infocomplementaresinstit
              WHERE si09_instit = ".db_getsession("DB_instit");
      
    $rsResult  = db_query($sSql);
    $sCodorgao = db_utils::fieldsMemory($rsResult, 0)->codorgao;
    
    /*
     * selecionar informacoes registro 10
     */

    $sArquivo = "config/sicom/".(db_getsession("DB_anousu")-1)."/{$sCnpj}_sicomdadoscompllicitacao.xml";
		/*if (!file_exists($sArquivo)) {
		 throw new Exception("Arquivo de dados compl licitacao inexistente!");
	 	}*/
		$sTextoXml    = file_get_contents($sArquivo);
		$oDOMDocument = new DOMDocument();
		$oDOMDocument->loadXML($sTextoXml);
		$oDadosComplLicitacoes = $oDOMDocument->getElementsByTagName('dadoscompllicitacao');
		  
    $sSql = "select distinct contratos.*,liclicita.l20_edital,liclicita.l20_anousu,l20_codepartamento,
    (CASE
    WHEN o41_subunidade != 0
         OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
            OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
              OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0)
    ELSE lpad((CASE WHEN o40_codtri = '0'
         OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
           OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)
   END) as codunidadesubresp
    from contratos 
    left join liclicita on si172_licitacao = l20_codigo
    left join db_departorg on l20_codepartamento = db01_coddepto and db01_anousu = ".db_getsession("DB_anousu")."
    left join orcunidade on db01_orgao = o41_orgao and db01_unidade = o41_unidade and db01_anousu = o41_anousu and o41_anousu = ".db_getsession("DB_anousu")."
    left join orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
    where si172_dataassinatura <= '{$this->sDataFinal}' 
    and si172_dataassinatura >= '{$this->sDataInicial}' 
    and si172_instit = ". db_getsession("DB_instit");

    $rsResult10 = db_query($sSql);//echo $sSql;db_criatabela($rsResult10);
       db_inicio_transacao();
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
      
      $clcontratos10 = new cl_contratos102016();

      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

      //if ($oDados10->si172_contdeclicitacao != 1) {
        $sSql  = "select CASE WHEN o40_codtri = '0'
            OR NULL THEN o40_orgao::varchar ELSE o40_codtri END AS db01_orgao,
            CASE WHEN o41_codtri = '0'
              OR NULL THEN o41_unidade::varchar ELSE o41_codtri END AS db01_unidade,o41_subunidade from db_departorg 
         join orcunidade on db01_orgao = o41_orgao and db01_unidade = o41_unidade
         and db01_anousu = o41_anousu
         JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
         where db01_anousu = ".db_getsession("DB_anousu")." and db01_coddepto = ".$oDados10->si172_codunidadesubresp;
      
        $rsDepart    = db_query($sSql);//echo $sSql;db_criatabela($rsDepart);
        $sOrgDepart  = db_utils::fieldsMemory($rsDepart, 0)->db01_orgao;
        $sUnidDepart = db_utils::fieldsMemory($rsDepart, 0)->db01_unidade;
        $sSubUnidade = db_utils::fieldsMemory($rsDepart, 0)->o41_subunidade;

      //}

      if ($oDados10->si172_contdeclicitacao == 5 || $oDados10->si172_contdeclicitacao == 6) {
      	$sCodorgaoResp = $sCodorgao;
      } else {
      	$sCodorgaoResp = 0;
      }

      $sCodUnidade = str_pad($sOrgDepart, 2, "0", STR_PAD_LEFT).str_pad($sUnidDepart, 3, "0", STR_PAD_LEFT);
      if ($sSubUnidade == 1) {
      	$sCodUnidade .= str_pad($sSubUnidade, 3, "0", STR_PAD_LEFT);
      }
      
      /**
       * caso o empenho seja de 2013 pegar o si83_nroprocesso do xml conforme era enviado em 2013
       */
      /*if ($oDados10->l20_anousu < 2015) {
	      	
		    foreach ($oDadosComplLicitacoes as $oDadosComplLicitacao) {
			
			    if ($oDadosComplLicitacao->getAttribute('instituicao') == db_getsession("DB_instit")
				    && $oDadosComplLicitacao->getAttribute('nroProcessoLicitatorio') == $oEmpenho->l20_codigo
				    && $oEmpenho->l20_codigo != '') {
			
			      $sNroProcesso = substr($oDadosComplLicitacao->getAttribute('codigoProcesso'), 0, 12);
				
			    }
				
			  }
			    
	    } else {
	    	$sNroProcesso = $oDados10->l20_edital;
	    }*/
      $sNroProcesso = $oDados10->l20_edital;
      $clcontratos10->si83_tiporegistro                  = 10;
      $clcontratos10->si83_codcontrato                   = $oDados10->si172_sequencial;
      $clcontratos10->si83_codorgao                      = $sCodorgao;
      $clcontratos10->si83_codunidadesub                 = $sCodUnidade;
      $clcontratos10->si83_nrocontrato                   = $oDados10->si172_nrocontrato;
      $clcontratos10->si83_exerciciocontrato             = $oDados10->si172_exerciciocontrato;
      $clcontratos10->si83_dataassinatura                = $oDados10->si172_dataassinatura;
      $clcontratos10->si83_contdeclicitacao              = $oDados10->si172_contdeclicitacao;
      $clcontratos10->si83_codorgaoresp                  = $oDados10->si172_contdeclicitacao == 5 || $oDados10->si172_contdeclicitacao == 6 ? $sCodorgao : ' ';
      $clcontratos10->si83_codunidadesubresp             = $oDados10->si172_contdeclicitacao == 1 || $oDados10->si172_contdeclicitacao == 8 ? ' ' : $oDados10->codunidadesubresp;
      $clcontratos10->si83_nroprocesso                   = $oDados10->si172_contdeclicitacao == 1 ? 0 : $sNroProcesso;
      $clcontratos10->si83_exercicioprocesso             = $oDados10->si172_contdeclicitacao == 1 ? 0 : $oDados10->l20_anousu;
      $clcontratos10->si83_tipoprocesso                  = $oDados10->si172_contdeclicitacao == 1 || $oDados10->si172_contdeclicitacao == 2 ? 0 : $oDados10->si172_tipoprocesso;
      $clcontratos10->si83_naturezaobjeto                = $oDados10->si172_naturezaobjeto;
      $clcontratos10->si83_objetocontrato                = substr($this->removeCaracteres($oDados10->si172_objetocontrato), 0,500);
      $clcontratos10->si83_tipoinstrumento               = $oDados10->si172_tipoinstrumento;
      $clcontratos10->si83_datainiciovigencia            = $oDados10->si172_datainiciovigencia;
      $clcontratos10->si83_datafinalvigencia             = $oDados10->si172_datafinalvigencia;
      $clcontratos10->si83_vlcontrato                    = $oDados10->si172_vlcontrato;
      $clcontratos10->si83_formafornecimento             = $this->removeCaracteres($oDados10->si172_formafornecimento);
      $clcontratos10->si83_formapagamento                = $this->removeCaracteres($oDados10->si172_formapagamento);
      $clcontratos10->si83_prazoexecucao                 = $this->removeCaracteres($oDados10->si172_prazoexecucao);
      $clcontratos10->si83_multarescisoria               = $this->removeCaracteres($oDados10->si172_multarescisoria);
      $clcontratos10->si83_multainadimplemento           = $this->removeCaracteres($oDados10->si172_multainadimplemento);
      $clcontratos10->si83_garantia                      = $oDados10->si172_garantia;
      $clcontratos10->si83_cpfsignatariocontratante      = $oDados10->si172_cpfsignatariocontratante;
      $clcontratos10->si83_datapublicacao                = $oDados10->si172_datapublicacao;
      $clcontratos10->si83_veiculodivulgacao             = $this->removeCaracteres($oDados10->si172_veiculodivulgacao);
      $clcontratos10->si83_mes                           = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clcontratos10->si83_instit                        = $oDados10->si172_instit;
      
      $clcontratos10->incluir(null);

      if ($clcontratos10->erro_status == 0) {
        throw new Exception($clcontratos10->erro_msg);
      }
        
      /*
       * selecionar informacoes registro 11
       */

       if($oDados10->si172_licitacao != '') {
        $sSqlItemLicitacao = "SELECT (solicitempcmater.pc16_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) AS pc01_codmater,
 pcorcamval.pc23_quant as quantidade, pcorcamval.pc23_vlrun as valorun
from liclicitem 
	INNER JOIN pcorcamitemlic ON (liclicitem.l21_codigo = pcorcamitemlic.pc26_liclicitem )      
	INNER JOIN pcorcamitem ON (pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem)      
	INNER JOIN pcorcamjulg ON (pcorcamitem.pc22_orcamitem = pcorcamjulg.pc24_orcamitem )
	INNER JOIN pcorcamforne ON (pcorcamjulg.pc24_orcamforne = pcorcamforne.pc21_orcamforne)
INNER JOIN pcorcamval ON (pcorcamitem.pc22_orcamitem = pcorcamval.pc23_orcamitem and pcorcamforne.pc21_orcamforne=pcorcamval.pc23_orcamforne)
INNER JOIN pcprocitem  ON (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
	INNER JOIN solicitem ON (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
	INNER JOIN solicitempcmater ON (solicitem.pc11_codigo=solicitempcmater.pc16_solicitem)
LEFT JOIN solicitemunid AS solicitemunid ON solicitem.pc11_codigo = solicitemunid.pc17_codigo
  LEFT JOIN matunid AS matunid ON solicitemunid.pc17_unid = matunid.m61_codmatunid
where liclicitem.l21_codliclicita = ".$oDados10->si172_licitacao." and pc21_numcgm = ".$oDados10->si172_fornecedor;
        $rsItem = db_query($sSqlItemLicitacao);//db_criatabela($rsItem);echo $sSql;

       } 
       
       if (pg_num_rows($rsItem) == 0 || $oDados10->si172_licitacao == '') {
         $sSqlItemEmpenho = "SELECT (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) AS pc01_codmater,
m60_codmater,m60_codmatunid,m61_descr,e60_numemp, e60_codemp, e60_anousu,e60_emiss, pc01_descrmater,  
e62_quant as quantidade, e62_vlrun as valorun from empcontratos 
inner join empempenho on e60_codemp = si173_empenho::varchar and e60_anousu = si173_anoempenho
left join empempitem on e62_numemp = e60_numemp 
left join pcmater on e62_item = pc01_codmater left join transmater on pc01_codmater =  m63_codpcmater 
left join matmater on m60_codmater = m63_codmatmater 
left join matunid on m60_codmatunid = m61_codmatunid  
where si173_codcontrato = '".$oDados10->si172_sequencial."'";
         $rsItem = db_query($sSqlItemEmpenho);//db_criatabela($rsItem);echo $sSql;

       }
       
        $aDadosAgrupados = array();  
        for ($iContItens = 0; $iContItens < pg_num_rows($rsItem); $iContItens++) {
        
        	$oItens = db_utils::fieldsMemory($rsItem, $iContItens);
        	$sHash = $oItens->pc01_codmater;
        	if (!isset($aDadosAgrupados[$sHash])) {
        		
	        	$oContrato11 = new stdClass();
	          $oContrato11->si84_tiporegistro           = 11;
	          $oContrato11->si84_reg10                  = $clcontratos10->si83_sequencial;
	          $oContrato11->si84_codcontrato            = $oDados10->si172_sequencial;
	          $oContrato11->si84_coditem                = $oItens->pc01_codmater;
	          $oContrato11->si84_quantidadeitem         = $oItens->quantidade;
	          $oContrato11->si84_valorunitarioitem      = ($oItens->valorun*$oItens->quantidade);
	          $oContrato11->si84_mes                    = $this->sDataFinal['5'].$this->sDataFinal['6'];
	          $oContrato11->si84_instit                 = db_getsession("DB_instit");
	          $aDadosAgrupados[$sHash] = $oContrato11;
 
        	} else {
        		$aDadosAgrupados[$sHash]->si84_quantidadeitem    += $oItens->quantidade;
        		$aDadosAgrupados[$sHash]->si84_valorunitarioitem += ($oItens->valorun*$oItens->quantidade);
        	}

        }
      
      foreach ($aDadosAgrupados as $oDadosReg11) {
      	
      	$clcontratos11 = new cl_contratos112016();
        
        $clcontratos11->si84_tiporegistro           = 11;
        $clcontratos11->si84_reg10                  = $oDadosReg11->si84_reg10;
        $clcontratos11->si84_codcontrato            = $oDadosReg11->si84_codcontrato;
        $clcontratos11->si84_coditem                = $oDadosReg11->si84_coditem;
        $clcontratos11->si84_quantidadeitem         = $oDadosReg11->si84_quantidadeitem;
        $clcontratos11->si84_valorunitarioitem      = $oDadosReg11->si84_valorunitarioitem/$oDadosReg11->si84_quantidadeitem;
        $clcontratos11->si84_mes                    = $oDadosReg11->si84_mes;
        $clcontratos11->si84_instit                 = $oDadosReg11->si84_instit;
        
        $clcontratos11->incluir(null);
        if ($clcontratos11->erro_status == 0) {
          throw new Exception($clcontratos11->erro_msg);
        }
      	
      }

      if (count($aDadosAgrupados) > 0) {
        $sSql = "UPDATE contratos102016 set si83_vlcontrato = (
        SELECT SUM(si84_valorunitarioitem*si84_quantidadeitem)
        FROM contratos112016 WHERE si84_reg10 = {$clcontratos10->si83_sequencial}) WHERE si83_sequencial = {$clcontratos10->si83_sequencial}";
        $result = db_query($sSql);
      }
      /*
       * selecionar informacoes registro 12
       */

      $sSql = "select * from contratos left join empcontratos on si173_codcontrato = si172_sequencial 
      where si172_dataassinatura <= '{$this->sDataFinal}' and si172_dataassinatura >= '{$this->sDataInicial}' 
      and si172_instit = ". db_getsession("DB_instit") ." and si172_sequencial = ".$oDados10->si172_sequencial;

      $rsResult12 = db_query($sSql);//db_criatabela($rsResult12);
      $aDadosAgrupados12 = array();
      if ($oDados10->si172_naturezaobjeto != 4 || $oDados10->si172_naturezaobjeto != 5 ) {
      for ($iCont12 = 0; $iCont12 < pg_num_rows($rsResult12); $iCont12++) {
        
        $oDados12 = db_utils::fieldsMemory($rsResult12, $iCont12);

        if ($oDados12->si172_licitacao != '') {
           $sSql = "SELECT distinct on (o58_coddot)
                         o58_coddot,
                         CASE WHEN o40_codtri = '0'
            OR NULL THEN o40_orgao::varchar ELSE o40_codtri END AS o58_orgao,
									       CASE WHEN o41_codtri = '0'
              OR NULL THEN o41_unidade::varchar ELSE o41_codtri END AS o58_unidade,  
              o58_funcao, o58_subfuncao,o58_programa,o58_projativ, o55_origemacao, 
                   o56_elemento,o15_codtri,o58_valor,o41_subunidade from 
                   liclicitem 
                   INNER JOIN pcprocitem  ON (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
                   INNER JOIN solicitem ON (pcprocitem.pc81_solicitem = solicitem.pc11_codigo) 
                   join pcdotac on (pcdotac.pc13_codigo = solicitem.pc11_codigo) 
                   join orcdotacao on (pcdotac.pc13_anousu = orcdotacao.o58_anousu) and (pcdotac.pc13_coddot = orcdotacao.o58_coddot)
                   and (orcdotacao.o58_instit = ".db_getsession("DB_instit").") 
                   join orcelemento on o58_codele = o56_codele and o56_anousu = ".db_getsession("DB_anousu")." 
                   join orctiporec on o58_codigo = o15_codigo 
                   join orcprojativ on o55_projativ = o58_projativ and o55_anousu = o58_anousu 
                   join orcunidade on o58_orgao = o41_orgao and o58_unidade = o41_unidade and o58_anousu = o41_anousu 
                   JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
                   where liclicitem.l21_codliclicita = ".$oDados12->si172_licitacao;
           $rsDados = db_query($sSql);
        } 
        if (($oDados12->si172_licitacao == '' || pg_num_rows($rsDados)==0) && $oDados12->si173_anoempenho != '') {
          $sSql = "SELECT distinct on (o58_coddot)
                         o58_coddot,
                         CASE WHEN o40_codtri = '0'
            OR NULL THEN o40_orgao::varchar ELSE o40_codtri END AS o58_orgao,
									       CASE WHEN o41_codtri = '0'
              OR NULL THEN o41_unidade::varchar ELSE o41_codtri END AS o58_unidade, 
              o58_funcao, o58_subfuncao,o58_programa,o58_projativ, o55_origemacao,
                      o56_elemento,o15_codtri,o58_valor,o41_subunidade from empempenho 
                      join orcdotacao on e60_coddot = o58_coddot 
                      join orcelemento on o58_codele = o56_codele and o56_anousu =   ".db_getsession("DB_anousu")." 
                      join orctiporec on o58_codigo = o15_codigo
                      join orcprojativ on o55_projativ = o58_projativ and o55_anousu = o58_anousu
                      join orcunidade on o58_orgao = o41_orgao and o58_unidade = o41_unidade and o58_anousu = o41_anousu
                      JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
                      where o58_anousu =  ".db_getsession("DB_anousu")." and e60_anousu = ".db_getsession("DB_anousu")."
                      and e60_codemp = '".$oDados12->si173_empenho ."' and e60_anousu = '".$oDados12->si173_anoempenho ."'";
          //$sSql   .= " and e60_anousu = ".db_getsession("DB_anousu")." ";
          $rsDados = db_query($sSql);   
        }
        if (pg_num_rows($rsDados)==0 && $oDados12->si172_licitacao != '') {
        	$sSql = "SELECT distinct on (o58_coddot)
                         o58_coddot,
                         CASE WHEN o40_codtri = '0'
            OR NULL THEN o40_orgao::varchar ELSE o40_codtri END AS o58_orgao,
									       CASE WHEN o41_codtri = '0'
              OR NULL THEN o41_unidade::varchar ELSE o41_codtri END AS o58_unidade,
									       o58_funcao,
									       o58_subfuncao,
									       o58_programa,
									       o58_projativ,
									       o55_origemacao,
									       o56_elemento,
									       o15_codtri,
									       o58_valor,
									       o41_subunidade
									FROM solicitem 
									JOIN pcdotac ON (pcdotac.pc13_codigo = solicitem.pc11_codigo)
									JOIN orcdotacao ON (pcdotac.pc13_anousu = orcdotacao.o58_anousu)
									AND (pcdotac.pc13_coddot = orcdotacao.o58_coddot)
									AND (orcdotacao.o58_instit = 1)
									JOIN orcelemento ON o58_codele = o56_codele
									AND o56_anousu = ".db_getsession("DB_anousu")."
									JOIN orctiporec ON o58_codigo = o15_codigo
									JOIN orcprojativ ON o55_projativ = o58_projativ
									AND o55_anousu = o58_anousu
									JOIN orcunidade ON o58_orgao = o41_orgao
									AND o58_unidade = o41_unidade
									AND o58_anousu = o41_anousu
									JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
									WHERE pc11_numero in (select solicitacao.pc53_solicitafilho from solicitavinculo compilacao
									join solicitavinculo abertura on compilacao.pc53_solicitafilho = abertura.pc53_solicitafilho
									join solicitavinculo estimativa on estimativa.pc53_solicitapai = abertura.pc53_solicitapai
									/*and estimativa.pc53_solicitafilho != compilacao.pc53_solicitafilho*/
									join solicitavinculo solicitacao on estimativa.pc53_solicitafilho = solicitacao.pc53_solicitapai
									where compilacao.pc53_solicitafilho = (select solicitem.pc11_numero FROM liclicitem
									INNER JOIN pcprocitem ON (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
									INNER JOIN solicitem ON (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
									WHERE liclicitem.l21_codliclicita = {$oDados12->si172_licitacao} order by pc11_numero desc limit 1))";
        	$rsDados = db_query($sSql);
        }

      for ($iContDot = 0;$iContDot < pg_num_rows($rsDados); $iContDot++) {
        $oDadosElemento = db_utils::fieldsMemory($rsDados, $iContDot);        
      
        $sHash  = $oDados12->si173_codcontrato.$sCodorgao.str_pad($oDadosElemento->o58_orgao, 2, "0", STR_PAD_LEFT).str_pad($oDadosElemento->o58_unidade, 3, "0", STR_PAD_LEFT);
        $sHash .= $oDadosElemento->o58_funcao.$oDadosElemento->o58_subfuncao.$oDadosElemento->o58_programa.$oDadosElemento->o58_projativ;
        $sHash .= $oDadosElemento->o56_elemento.$oDadosElemento->o15_codtri;
        
        if (!isset($aDadosAgrupados12[$sHash])) {
        	
        	$sCodUnidade = str_pad($oDadosElemento->o58_orgao, 2, "0", STR_PAD_LEFT).str_pad($oDadosElemento->o58_unidade, 3, "0", STR_PAD_LEFT);
        	if ($oDadosElemento->o41_subunidade == 1) {
        		$sCodUnidade .= str_pad($oDadosElemento->o41_subunidade, 3, "0", STR_PAD_LEFT);
        	}
        	$result = db_dotacaosaldo(8, 2, 2, true, " o58_coddot = {$oDadosElemento->o58_coddot} and o58_anousu = {$oDados10->si172_exerciciocontrato}", 
        	                          $oDados10->si172_exerciciocontrato, $oDados10->si172_dataassinatura, $oDados10->si172_dataassinatura);
        	if (pg_num_rows($result) > 0) {
        	  $oDot = db_utils::fieldsMemory($result, 0);
        	  $oDadosElemento->o58_valor = ($oDot->dot_ini+$oDot->suplementado_acumulado-$oDot->reduzido_acumulado)-$oDot->empenhado_acumulado+$oDot->anulado_acumulado;
        	}
        	
	        $oContrato12 = new stdClass();
        	$oContrato12->si85_tiporegistro           = 12;
	        $oContrato12->si85_reg10                  = $clcontratos10->si83_sequencial;
	        $oContrato12->si85_codcontrato            = $oDados12->si172_sequencial;
	        $oContrato12->si85_codorgao               = $sCodorgao;
	        $oContrato12->si85_codunidadesub          = $sCodUnidade;
	        $oContrato12->si85_codfuncao              = $oDadosElemento->o58_funcao;
	        $oContrato12->si85_codsubfuncao           = $oDadosElemento->o58_subfuncao;
	        $oContrato12->si85_codprograma            = $oDadosElemento->o58_programa;
	        $oContrato12->si85_idacao                 = $oDadosElemento->o58_projativ;
	        $oContrato12->si85_idsubacao              = $oDadosElemento->o55_origemacao;
	        $oContrato12->si85_naturezadespesa        = $oDadosElemento->o56_elemento;
	        $oContrato12->si85_codfontrecursos        = $oDadosElemento->o15_codtri;
	        $oContrato12->si85_vlrecurso              = $oDadosElemento->o58_valor;
	        $oContrato12->si85_mes                    = $this->sDataFinal['5'].$this->sDataFinal['6'];
	        $oContrato12->si85_instit                 = db_getsession("DB_instit");
	        $aDadosAgrupados12[$sHash] = $oContrato12;
	        
        } else {
        	$aDadosAgrupados12[$sHash]->si85_vlrecurso += $oDadosElemento->o58_valor;
        }
      }
        
      }
      }
      //echo "<pre>";print_r($aDadosAgrupados12);
      
      foreach ($aDadosAgrupados12 as $oDadosReg12) {
      	
      	$clcontratos12 = new cl_contratos122016();
      	$clcontratos12->si85_tiporegistro           = 12;
        $clcontratos12->si85_reg10                  = $oDadosReg12->si85_reg10;
        $clcontratos12->si85_codcontrato            = $oDadosReg12->si85_codcontrato;
        $clcontratos12->si85_codorgao               = $oDadosReg12->si85_codorgao;
        $clcontratos12->si85_codunidadesub          = $oDadosReg12->si85_codunidadesub;
        $clcontratos12->si85_codfuncao              = $oDadosReg12->si85_codfuncao;
        $clcontratos12->si85_codsubfuncao           = $oDadosReg12->si85_codsubfuncao;
        $clcontratos12->si85_codprograma            = $oDadosReg12->si85_codprograma;
        $clcontratos12->si85_idacao                 = $oDadosReg12->si85_idacao;
        $clcontratos12->si85_idsubacao              = $oDadosReg12->si85_idsubacao;
        $clcontratos12->si85_naturezadespesa        = substr($oDadosReg12->si85_naturezadespesa,1,6);
        $clcontratos12->si85_codfontrecursos        = $oDadosReg12->si85_codfontrecursos;
        $clcontratos12->si85_vlrecurso              = $oDadosReg12->si85_vlrecurso;
        $clcontratos12->si85_mes                    = $oDadosReg12->si85_mes;
        $clcontratos12->si85_instit                 = $oDadosReg12->si85_instit;
        
        $clcontratos12->incluir(null);

        if ($clcontratos12->erro_status == 0) {
          throw new Exception($clcontratos12->erro_msg);
        }
      	
      }
      
      $sSql = "select case when length(fornecedor.z01_cgccpf) = 11 then 1 else 2 end as tipodocumento,fornecedor.z01_cgccpf as nrodocumento, 
      representante.z01_cgccpf as cpfrepresentantelegal
      from cgm as fornecedor
      join pcfornereprlegal on fornecedor.z01_numcgm = pcfornereprlegal.pc81_cgmforn
      join cgm as representante on pcfornereprlegal.pc81_cgmresp = representante.z01_numcgm
      where pcfornereprlegal.pc81_tipopart = 1 and fornecedor.z01_numcgm = ".$oDados10->si172_fornecedor;

      $rsResult13 = db_query($sSql);//db_criatabela($rsResult13);
      $oDados13 = db_utils::fieldsMemory($rsResult13, 0);
      
      $clcontratos13 = new cl_contratos132016;
      $clcontratos13->si86_tiporegistro           = 13;
      $clcontratos13->si86_codcontrato            = $oDados10->si172_sequencial;
      $clcontratos13->si86_tipodocumento          = $oDados13->tipodocumento;
      $clcontratos13->si86_nrodocumento           = $oDados13->nrodocumento;
      $clcontratos13->si86_cpfrepresentantelegal  = substr($oDados13->cpfrepresentantelegal,0,11);
      $clcontratos13->si86_reg10                  = $clcontratos10->si83_sequencial;
      $clcontratos13->si86_instit                 = db_getsession("DB_instit");
      $clcontratos13->si86_mes                    = $this->sDataFinal['5'].$this->sDataFinal['6'];
      
      $clcontratos13->incluir(null);

      if ($clcontratos13->erro_status == 0) {
        throw new Exception($clcontratos13->erro_msg);
      }
 
    }
    
    /*
     * selecionar informacoes registro 20
     */
    $sSql       = "select distinct aditivoscontratos.* 
    from aditivoscontratos 
    left JOIN contratos  on extract(year from si174_dataassinaturacontoriginal) = si172_exerciciocontrato and si174_nrocontrato = si172_nrocontrato
    where (case when si172_naturezaobjeto is null then 2 else si172_naturezaobjeto end) not in (4,5) 
    and si174_dataassinaturatermoaditivo <= '{$this->sDataFinal}' 
    and si174_dataassinaturatermoaditivo >= '{$this->sDataInicial}' 
    and si174_instit = ". db_getsession("DB_instit") ." ";
        
    $rsResult20 = db_query($sSql);//db_criatabela($rsResult20);echo $sSql;
    
    for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {
      
      $clcontratos20 = new cl_contratos202016();
      $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);
      
      if ($oDados20->si174_tipotermoaditivo != '6' && $oDados20->si174_tipotermoaditivo != '14') {
        $oDados20->si174_dscalteracao = '';
      } 
      if ($oDados20->si174_tipotermoaditivo != '7' && $oDados20->si174_tipotermoaditivo != '13') {
        $oDados20->si174_novadatatermino = '';
      } 
      
       $sSql  = "select  (CASE
    WHEN o41_subunidade != 0
         OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
            OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
              OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0)
    ELSE lpad((CASE WHEN o40_codtri = '0'
         OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
           OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)
   END) as codunidadesub 
   from db_departorg join orcunidade on db01_orgao = o41_orgao and db01_unidade = o41_unidade
         and db01_anousu = o41_anousu
         JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
         where db01_anousu = ".db_getsession("DB_anousu")." and db01_coddepto = ".$oDados20->si174_codunidadesub;
      $result = db_query($sSql);//db_criatabela($result);echo $sSql;
      $sCodUnidade = db_utils::fieldsMemory($result, 0)->codunidadesub;
      
      
      $clcontratos20->si87_tiporegistro                   = 20;
      $clcontratos20->si87_codaditivo                     = $oDados20->si174_sequencial;
      $clcontratos20->si87_codorgao                       = $sCodorgao;
      $clcontratos20->si87_codunidadesub                  = $sCodUnidade;
      $clcontratos20->si87_nrocontrato                    = $oDados20->si174_nrocontrato;
      $clcontratos20->si87_dataassinaturacontoriginal     = $oDados20->si174_dataassinaturacontoriginal;
      $clcontratos20->si87_nroseqtermoaditivo             = $oDados20->si174_nroseqtermoaditivo;
      $clcontratos20->si87_dtassinaturatermoaditivo       = $oDados20->si174_dataassinaturatermoaditivo;
      $clcontratos20->si87_tipoalteracaovalor             = $oDados20->si174_tipoalteracaovalor;
      $clcontratos20->si87_tipotermoaditivo               = $oDados20->si174_tipotermoaditivo;
      $clcontratos20->si87_dscalteracao                   = substr($this->removeCaracteres($oDados20->si174_dscalteracao),0,250);
      $clcontratos20->si87_novadatatermino                = $oDados20->si174_novadatatermino;
      $clcontratos20->si87_valoraditivo                   = ($oDados20->si174_tipoalteracaovalor == 3 ? 0 : $oDados20->si174_valoraditivo);
      $clcontratos20->si87_datapublicacao                 = $oDados20->si174_datapublicacao;
      $clcontratos20->si87_veiculodivulgacao              = $this->removeCaracteres($oDados20->si174_veiculodivulgacao);
      $clcontratos20->si87_mes                            = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clcontratos20->si87_instit                         = $oDados20->si174_instit;
      
      $clcontratos20->incluir(null);
      if ($clcontratos20->erro_status == 0) {
        throw new Exception($clcontratos20->erro_msg);
      }
      
      /*
       * selecionar informacoes registro 21
       */

      $sSql = "select distinct itensaditivados.*, 
      (itensaditivados.si175_coditem::varchar || (CASE WHEN e55_unid = 0 THEN 1 ELSE e55_unid END)::varchar) AS coditem,
      pc01_descrmater
       from aditivoscontratos 
      inner join itensaditivados on si174_sequencial = si175_codaditivo
      inner join pcmater on pc01_codmater = si175_coditem
      LEFT JOIN contratos  on extract(year from si174_dataassinaturacontoriginal) = si172_exerciciocontrato and si174_nrocontrato = si172_nrocontrato
      LEFT JOIN empcontratos ON si173_codcontrato = si172_sequencial 
      LEFT JOIN empempenho ON empempenho.e60_codemp = empcontratos.si173_empenho::varchar
      LEFT JOIN empempaut ON e60_numemp=e61_numemp
      LEFT JOIN empautoriza ON e61_autori = e54_autori
      LEFT JOIN empautitem ON e54_autori = e55_autori
      LEFT JOIN matunid ON empautitem.e55_unid = matunid.m61_codmatunid
      where aditivoscontratos.si174_tipotermoaditivo::integer in (9,10,11,14)
      and si174_dataassinaturatermoaditivo <= '{$this->sDataFinal}' 
      and si174_dataassinaturatermoaditivo >= '{$this->sDataInicial}' 
      and si174_sequencial = ". $oDados20->si174_sequencial ."
      and si174_instit = ". db_getsession("DB_instit");

      $rsResult21 = db_query($sSql);//db_criatabela($rsResult21);echo $sSql;
      for ($iCont21 = 0; $iCont21 < pg_num_rows($rsResult21); $iCont21++) {
        
        $clcontratos21 = new cl_contratos212016();
        $oDados21 = db_utils::fieldsMemory($rsResult21, $iCont21);
        if ($oDados21->coditem == '') {
        	$sSql = "SELECT si43_coditem FROM item102014 WHERE si43_dscitem LIKE 
        	'".trim(preg_replace("/[^a-zA-Z0-9 ]/", "",str_replace($what, $by,  $oDados21->pc01_descrmater)))."%'";
        	$result = db_query($sSql);//db_criatabela($result);
        	$oDados21->coditem = db_utils::fieldsMemory($result, 0)->si43_coditem;
        }
        
        $clcontratos21->si88_tiporegistro            = 21;
        $clcontratos21->si88_reg20                   = $clcontratos20->si87_sequencial;
        $clcontratos21->si88_codaditivo              = $oDados21->si175_codaditivo;
        $clcontratos21->si88_coditem                 = $oDados21->coditem;
        $clcontratos21->si88_tipoalteracaoitem       = $oDados21->si175_tipoalteracaoitem;
        $clcontratos21->si88_quantacrescdecresc      = $oDados21->si175_quantacrescdecresc;
        $clcontratos21->si88_valorunitarioitem       = $oDados21->si175_valorunitarioitem;
        $clcontratos21->si88_mes                     = $this->sDataFinal['5'].$this->sDataFinal['6'];
        $clcontratos21->si88_instit                  = db_getsession("DB_instit");
        
        $clcontratos21->incluir(null);
        if ($clcontratos21->erro_status == 0) {
          throw new Exception($clcontratos21->erro_msg);
        }
        
      }
      
    }

    /*
     * selecionar informacoes registro 30
     */
    $sSql       = "select * from apostilamento
    left join contratos on si03_numcontrato=si172_sequencial
    where si03_dataapostila <= '{$this->sDataFinal}' 
    and si03_dataapostila >= '{$this->sDataInicial}'
    and si03_instit = ". db_getsession("DB_instit");
        
    $rsResult30 = db_query($sSql);
    
    for ($iCont30 = 0; $iCont30 < pg_num_rows($rsResult30); $iCont30++) {
      
    	$oDados30 = db_utils::fieldsMemory($rsResult30, $iCont30);
    	$aAnoContrato = explode("-", $oDados30->si03_dataassinacontrato);
    	
    	if ($aAnoContrato[0] > 2013) {
    	  $sSql  = "select  (CASE
    WHEN o41_subunidade != 0
         OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
            OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
              OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0)
    ELSE lpad((CASE WHEN o40_codtri = '0'
         OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
           OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)
   END) as codunidadesub 
   from db_departorg join orcunidade on db01_orgao = o41_orgao and db01_unidade = o41_unidade
         and db01_anousu = o41_anousu
         JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
                  where db01_anousu = ".$aAnoContrato[0]." and db01_coddepto = 
                  (select si172_codunidadesubresp::integer from contratos where si172_sequencial = {$oDados30->si03_numcontrato})";
    	  $result = db_query($sSql);//db_criatabela($result);echo $sSql;echo pg_last_error();
    	  $sCodUnidadeSub = db_utils::fieldsMemory($result, 0)->codunidadesub;
    	} else {
    		$sCodUnidadeSub = ' ';
    	}
    	
      $clcontratos30 = new cl_contratos302016();
      
      $clcontratos30->si89_tiporegistro                   = 30;
      $clcontratos30->si89_codorgao                       = $sCodorgao;
      $clcontratos30->si89_codunidadesub                  = $sCodUnidadeSub;
      $clcontratos30->si89_nrocontrato                    = $oDados30->si172_nrocontrato == '' ? $oDados30->si03_numcontratoanosanteriores : $oDados30->si172_nrocontrato;
      $clcontratos30->si89_dtassinaturacontoriginal       = $oDados30->si03_dataassinacontrato;
      $clcontratos30->si89_tipoapostila                   = $oDados30->si03_tipoapostila;
      $clcontratos30->si89_nroseqapostila                 = $oDados30->si03_numapostilamento;
      $clcontratos30->si89_dataapostila                   = $oDados30->si03_dataapostila;
      $clcontratos30->si89_tipoalteracaoapostila          = $oDados30->si03_tipoalteracaoapostila;
      $clcontratos30->si89_dscalteracao                   = substr($this->removeCaracteres($oDados30->si03_descrapostila),0,250);
      $clcontratos30->si89_valorapostila                  = $oDados30->si03_valorapostila;
      $clcontratos30->si89_mes                            = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clcontratos30->si89_instit                         = $oDados30->si03_instit;
    
      $clcontratos30->incluir(null);
      if ($clcontratos30->erro_status == 0) {
        throw new Exception($clcontratos30->erro_msg);
      }

    }

     /*
     * selecionar informacoes registro 40
     */
    $sSql       = "select * from rescisaocontrato 
      join contratos on si176_nrocontrato = si172_sequencial
      where si1176_datarescisao <= '{$this->sDataFinal}' 
      and si1176_datarescisao >= '{$this->sDataInicial}' 
      and si172_instit = ".db_getsession("DB_instit");
    
    $rsResult40 = db_query($sSql);//db_criatabela($rsResult40);
    
    for ($iCont40 = 0; $iCont40 < pg_num_rows($rsResult40); $iCont40++) {
      
      $clcontratos40 = new cl_contratos402016();
      $oDados40 = db_utils::fieldsMemory($rsResult40, $iCont40);
      
      $clcontratos40->si91_tiporegistro                   = 40;
      $clcontratos40->si91_codorgao                       = $sCodorgao;
      $clcontratos40->si91_codunidadesub                  = " ";
      $clcontratos40->si91_nrocontrato                    = $oDados40->si172_nrocontrato;
      $clcontratos40->si91_dtassinaturacontoriginal       = $oDados40->si176_dataassinaturacontoriginal;
      $clcontratos40->si91_datarescisao                   = $oDados40->si1176_datarescisao;
      $clcontratos40->si91_valorcancelamentocontrato      = $oDados40->si176_valorcancelamentocontrato;
      $clcontratos40->si91_mes                            = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clcontratos40->si91_instit                         = $oDados40->si172_instit;

      $clcontratos40->incluir(null);

      if ($clcontratos40->erro_status == 0) {
        throw new Exception($clcontratos40->erro_msg);
      }
      
    }

    db_fim_transacao();
    
    $oGerarCONTRATOS = new GerarCONTRATOS();
    $oGerarCONTRATOS->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarCONTRATOS->gerarDados();
    
  }
  
}			
