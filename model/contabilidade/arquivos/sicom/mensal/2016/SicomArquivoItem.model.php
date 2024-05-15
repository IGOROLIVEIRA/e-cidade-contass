<?php  
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_item102016_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2016/GerarITEM.model.php");

 /**
  * gerar arquivo de identificacao da Remessa Sicom Acompanhamento Mensal
  * @author robson
  * @package Contabilidade
  */
class SicomArquivoItem extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
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
  protected $sNomeArquivo = 'ITEM';
  
  /**
   * 
   * Contrutor da classe
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
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV 
   */
  public function getCampos(){

  }
  
  /**
   * selecionar os dados de indentificacao da remessa pra gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados(){
 		
  	/**
  	 * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo 
  	 */
  	$clitem10 = new cl_item102016();
  	
  	/**
     * excluir informacoes do mes selecioado
     */
    db_inicio_transacao(); 
    $result = db_query($clitem10->sql_query(NULL,"*",NULL,"si43_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si43_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clitem10->excluir(NULL,"si43_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si43_instit=".db_getsession("DB_instit"));
      if ($clitem10->erro_status == 0) {
    	  throw new Exception($clitem10->erro_msg);
      }
    }
    
  	
	   $sSql="SELECT distinct  '10' AS tipoRegistro ,
       (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) AS coditem,
       (pcmater.pc01_descrmater||substring(pc01_complmater,1,900) ) AS dscItem ,
       (CASE WHEN m61_abrev IS NULL THEN 'UNIDAD' ELSE m61_abrev END) AS unidadeMedida ,
       '1' AS tipoCadastro ,
       '' AS justificativaAlteracao
FROM liclicita AS licitacao 
INNER JOIN liclicitem ON liclicitem.l21_codliclicita = licitacao.l20_codigo
INNER JOIN pcprocitem ON liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem
INNER JOIN compras . solicitem AS solicitem ON pcprocitem.pc81_solicitem = solicitem.pc11_codigo
INNER JOIN compras . solicitempcmater AS solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
INNER JOIN compras . pcmater AS pcmater ON (pcmater . pc01_codmater = solicitempcmater . pc16_codmater)
LEFT JOIN compras . solicitemunid AS solicitemunid ON (solicitem . pc11_codigo = solicitemunid . pc17_codigo)
LEFT JOIN material . matunid AS matunid ON (solicitemunid . pc17_unid = matunid . m61_codmatunid)
INNER JOIN db_config on (licitacao.l20_instit=db_config.codigo)
WHERE licitacao.l20_codigo in ( SELECT homologacao . l202_licitacao FROM homologacaoadjudica as homologacao
WHERE DATE_PART ('YEAR' , homologacao . l202_datahomologacao) =".db_getsession("DB_anousu")."
  AND DATE_PART ('MONTH' , homologacao . l202_datahomologacao) = " .$this->sDataFinal['5'].$this->sDataFinal['6'].") 
  AND licitacao.l20_instit = ".db_getsession("DB_instit")." 
UNION
SELECT distinct '10' AS tipoRegistro ,
       (pcmater.pc01_codmater::varchar || (CASE WHEN e55_unid = 0 THEN 1 ELSE e55_unid END)::varchar) AS coditem,
       (pcmater.pc01_descrmater||substring(pc01_complmater,1,900) ) AS dscItem ,
       (CASE WHEN m61_abrev IS NULL THEN 'UNIDAD' ELSE m61_abrev END) AS unidadeMedida ,
       '1' AS tipoCadastro ,
       '' AS justificativaAlteracao
FROM empenho.empnota AS empnota
INNER JOIN empenho.empnotaitem AS empnotaitem ON (empnota.e69_codnota=empnotaitem.e72_codnota)
INNER JOIN empenho.empempitem AS empempitem ON (empnotaitem.e72_empempitem=empempitem.e62_sequencial)
INNER JOIN empenho.empempenho AS empempenho ON (empnota.e69_numemp=empempenho.e60_numemp)
INNER JOIN compras.pcmater AS pcmater ON (empempitem.e62_item = pcmater.pc01_codmater)
INNER JOIN empenho.pagordemnota AS pagordemnota ON (empnota.e69_codnota=pagordemnota.e71_codnota
                                                    AND pagordemnota.e71_anulado = FALSE)
INNER JOIN empempaut ON e60_numemp=e61_numemp
INNER JOIN empautoriza ON e61_autori = e54_autori
INNER JOIN empautitem ON e54_autori = e55_autori
LEFT JOIN matunid ON empautitem.e55_unid = matunid.m61_codmatunid
WHERE empempenho.e60_instit = ".db_getsession("DB_instit")." AND ((DATE_PART ('YEAR' , empnota . e69_dtinclusao) =".db_getsession("DB_anousu")."
  AND DATE_PART ('MONTH' , empnota . e69_dtinclusao) = " .$this->sDataFinal['5'].$this->sDataFinal['6'].")
  OR (date_part('year',empnota.e69_dtnota) = ".$this->sDataFinal['0'].$this->sDataFinal['1'].$this->sDataFinal['2'].$this->sDataFinal['3']."
            and   date_part('month',empnota.e69_dtnota) = ".$this->sDataFinal['5'].$this->sDataFinal['6']."))
  UNION 
  SELECT distinct '10' AS tipoRegistro ,
       (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) AS coditem,
       (pcmater.pc01_descrmater||substring(pc01_complmater,1,900) ) AS dscItem ,
       (CASE WHEN m61_abrev IS NULL THEN 'UNIDAD' ELSE m61_abrev END) AS unidadeMedida ,
       '1' AS tipoCadastro ,
       '' AS justificativaAlteracao
FROM empempenho
INNER JOIN empempitem ON e62_numemp = e60_numemp
INNER JOIN pcmater ON e62_item = pc01_codmater
INNER JOIN empcontratos ON empempenho.e60_codemp = empcontratos.si173_empenho::varchar
INNER JOIN contratos ON si173_codcontrato = si172_sequencial
LEFT  JOIN transmater ON pc01_codmater = m63_codpcmater
LEFT  JOIN matmater ON m60_codmater = m63_codmatmater
LEFT  JOIN matunid ON m60_codmatunid = m61_codmatunid
WHERE DATE_PART ('MONTH' , si172_dataassinatura) = ".$this->sDataFinal['5'].$this->sDataFinal['6']."
  AND e60_anousu = ".db_getsession("DB_anousu")."  and si172_instit = ".db_getsession("DB_instit")."
  
  UNION 
  select distinct '10' AS tipoRegistro ,
       (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) AS coditem,
       (pcmater.pc01_descrmater||substring(pc01_complmater,1,900) ) AS dscItem ,
       (CASE WHEN m61_abrev IS NULL THEN 'UNIDAD' ELSE m61_abrev END) AS unidadeMedida ,
       '1' AS tipoCadastro ,
       '' AS justificativaAlteracao	
		FROM liclicitem
		INNER JOIN liclicita on (liclicitem.l21_codliclicita=liclicita.l20_codigo)
		INNER JOIN cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
		INNER JOIN pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
		INNER JOIN pcprocitem  on (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
		INNER JOIN solicitem on (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
		INNER JOIN solicitempcmater on (solicitem.pc11_codigo = solicitempcmater.pc16_solicitem)
		INNER JOIN pcmater on (solicitempcmater.pc16_codmater = pcmater.pc01_codmater)
		INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
		LEFT JOIN solicitemunid AS solicitemunid ON solicitem.pc11_codigo = solicitemunid.pc17_codigo
    LEFT JOIN matunid AS matunid ON solicitemunid.pc17_unid = matunid.m61_codmatunid
		LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
		INNER JOIN liclicitasituacao ON liclicitasituacao.l11_liclicita = liclicita.l20_codigo
		WHERE db_config.codigo= " .db_getsession("DB_instit")." AND liclicitasituacao.l11_licsituacao = 1
		AND pctipocompratribunal.l44_sequencial in (100,101,102) AND DATE_PART('YEAR',liclicitasituacao.l11_data)=".db_getsession("DB_anousu")."
	AND DATE_PART('MONTH',liclicitasituacao.l11_data)=".$this->sDataFinal['5'].$this->sDataFinal['6']."
	
	UNION 
  SELECT distinct '10' AS tipoRegistro ,
       (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) AS coditem,
       (pcmater.pc01_descrmater||substring(pc01_complmater,1,900) ) AS dscItem ,
       (CASE WHEN m61_abrev IS NULL THEN 'UNIDAD' ELSE m61_abrev END) AS unidadeMedida ,
       '1' AS tipoCadastro ,
       '' AS justificativaAlteracao
      from aditivoscontratos 
      INNER JOIN itensaditivados on si174_sequencial = si175_codaditivo
      INNER JOIN pcmater on pc01_codmater = si175_coditem
      LEFT JOIN contratos  on extract(year from si174_dataassinaturacontoriginal) = si172_exerciciocontrato and si174_nrocontrato = si172_nrocontrato
      LEFT JOIN empcontratos ON si173_codcontrato = si172_sequencial 
      LEFT JOIN empempenho ON empempenho.e60_codemp = empcontratos.si173_empenho::varchar
      LEFT JOIN empempaut ON e60_numemp=e61_numemp
      LEFT JOIN empautoriza ON e61_autori = e54_autori
      LEFT JOIN empautitem ON e54_autori = e55_autori
      LEFT JOIN matunid ON empautitem.e55_unid = matunid.m61_codmatunid
      and si174_dataassinaturatermoaditivo <= '{$this->sDataFinal}' 
      and si174_dataassinaturatermoaditivo >= '{$this->sDataInicial}'
      and si174_instit = ". db_getsession("DB_instit")."
      union
      SELECT DISTINCT '10' AS tipoRegistro,
            (pcmater.pc01_codmater::varchar || (CASE
            WHEN m61_codmatunid IS NULL THEN 1
            ELSE m61_codmatunid
            END)::varchar) AS coditem,
            (pcmater.pc01_descrmater||substring(pc01_complmater,1,900)) AS dscItem,
            (CASE
            WHEN m61_abrev IS NULL THEN 'UNIDAD'
            ELSE m61_abrev
            END) AS unidadeMedida,
            '1' AS tipoCadastro,
            '' AS justificativaAlteracao
            FROM itensregpreco
            INNER JOIN adesaoregprecos ON si07_sequencialadesao = si06_sequencial
            INNER JOIN pcmater ON pcmater.pc01_codmater = itensregpreco.si07_item
            INNER JOIN db_usuarios ON db_usuarios.id_usuario = pcmater.pc01_id_usuario
            INNER JOIN pcsubgrupo ON pcsubgrupo.pc04_codsubgrupo = pcmater.pc01_codsubgrupo
            LEFT JOIN cgm ON si07_fornecedor = z01_numcgm
            LEFT JOIN matunid ON si07_codunidade = m61_codmatunid
            WHERE si06_dataadesao between '{$this->sDataInicial}' and '{$this->sDataFinal}'
      ";

		 $rsResult10 = db_query($sSql);//echo $sSql;db_criatabela($rsResult10);
    //$aCaracteres = array("/","\\","'","\"","°","ª","º","§");
    // matriz de entrada
    $what = array("°",chr(13),chr(10), 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','Ã','É','Í','Ó','Ú','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º' );

    // matriz de saída
    $by   = array('','','', 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','A','E','I','O','U','n','n','c','C',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ' );
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
      
    	$clitem10 = new cl_item102016();
    	$oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
    	
    	//$sSqlitem="select si43_coditem,si43_unidademedida from item102016  where si43_coditem=".$oDados10->coditem." and si43_unidademedida='{$oDados10->unidademedida}'";
    	$sSqlitem  ="select si43_coditem,si43_unidademedida from item102016  where si43_coditem=".$oDados10->coditem." and si43_mes <= ".$this->sDataFinal['5'].$this->sDataFinal['6'];
    	$sSqlitem .=" union 
    	select si43_coditem,si43_unidademedida from item102015  where si43_coditem=".$oDados10->coditem;
    	$sSqlitem .=" union 
    	select si43_coditem,si43_unidademedida from item102014  where si43_coditem=".$oDados10->coditem;
    	$rsResultitem = db_query($sSqlitem);//db_criatabela($rsResultitem);echo $sSqlitem;
    	/**
    	 * verifica se já nao existe o registro  na base de dados do sicom
    	 */
       if(pg_num_rows($rsResultitem) == 0 ){
        	 	
    	  	
		          $clitem10->si43_tiporegistro           = 10;
				  $clitem10->si43_coditem                = $oDados10->coditem;
				  $clitem10->si43_dscItem                = trim(preg_replace("/[^a-zA-Z0-9 ]/", "",str_replace($what, $by,  $oDados10->dscitem)))." $oDados10->coditem";
				  $clitem10->si43_unidademedida          = trim(preg_replace("/[^a-zA-Z0-9 ]/", "",str_replace($what, $by,  $oDados10->unidademedida)));
				  $clitem10->si43_tipocadastro           = $oDados10->tipocadastro;        
				  $clitem10->si43_justificativaalteracao = $oDados10->justificativaalteracao;
				  $clitem10->si43_instit		   				   = db_getsession("DB_instit");
				  $clitem10->si43_mes                    = $this->sDataFinal['5'].$this->sDataFinal['6'];
				  //echo pg_last_error();
				  $clitem10->incluir(null);
				  if ($clitem10->erro_status == 0) {
				  	throw new Exception($clitem10->erro_msg);
				  }
       }
    }
		
     db_fim_transacao();
    
    $oGerarItem = new GerarITEM();
    $oGerarItem->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarItem->gerarDados();
    
  }
  
}
