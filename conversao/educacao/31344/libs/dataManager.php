<?
class tableDataManager { 

  private $iPkLastReg       = 0;
  private $iTamanhoBloco    = 1000;
  private $sTableName       = "";
  private $sCampoPk         = "";
  private $aData            = array();
  private $aCopyRows        = array();
  private $aTableProperties = array();
  private $aLinhaAtual      = array();
  private $pConexao         = null;
  private $lAutoStore       = true;

  function __construct($pConexao,$sTableName,$sCampoPk='',$lAutoStore=true,$iTamanhoBloco=1000){

    if(!is_resource($pConexao) || empty($sTableName)) {
      throw new Exception("Conexao invalida [tableDataManager]");
    }

    if (empty($sTableName)) {
      throw new Exception("Nome da tabela nao informado [tableDataManager]");      
    }
    
    $this->sTableName    = $sTableName;
    $this->pConexao      = $pConexao;
    $this->iTamanhoBloco = $iTamanhoBloco;
    $this->sCampoPk      = $sCampoPk;
    $this->lAutoStore    = $lAutoStore;
    
    $this->getTableAtt();

    if (!empty($sCampoPk)){
      // metodo para buscar o ultimo valor do campo PK para setar o atributo $this->iPkLastReg
      $this->iPkLastReg = $this->getMaxValueField($sCampoPk);
    }

    // var_dump($this->aTableProperties);
  }

  function getMaxValueField($sFieldName){
    
    $iMaxValue    = 0;
    $sSqlMaxValue = "select max({$sFieldName}) as maior_codigo from {$this->sTableName}";
    $rsMaxValue   = pg_query($this->pConexao,  $sSqlMaxValue);
    $oMaxValue    = db_utils::fieldsMemory($rsMaxValue,0);
    if ( ! empty($oMaxValue->maior_codigo) ) {
      $iMaxValue = $oMaxValue->maior_codigo;
    }

    return $iMaxValue;

  }

  function __set($sAttName, $sValor) {

    $this->aLinhaAtual[$sAttName] = $sValor;

  }

  private function getTableAtt(){

    //
    // Montar um array ordenado pelos campos da tabela 
    //   e guardar o nome do campo e o tipo de dado

    $sSqlTable         = "select * from {$this->sTableName} limit 0";
    $rsTableProperties = pg_query($this->pConexao, $sSqlTable) or die($sSqlTable);
    $iContaCampos      = pg_num_fields($rsTableProperties);

    for($iCont=0; $iCont<$iContaCampos; $iCont++) {

      $sNomeCampo  = pg_field_name($rsTableProperties, $iCont);
      $sTipoCampo  = pg_field_type($rsTableProperties, $iCont);

      $this->aTableProperties[$iCont] = array($sNomeCampo,$sTipoCampo);

    }

  }

  function setTableName($sTableName){
    $this->sTableName = $sTableName;
  }

  function setTamanhoBloco($iTamanhoBloco){
    $this->sTableName = $iTamanhoBloco;
  }

  function getNextSequence(){
    return ++$this->iPkLastReg;
  }

  function getLastPk(){
    return $this->iPkLastReg;
  }

  function insertValue() { 

    //    var_dump($this->aLinhaAtual);
    //    var_dump($this->aTableProperties);exit;
    //    echo "\nInserindo na tabela {$this->sTableName}\n";

    if (!count($this->aLinhaAtual) > 0) {
      return false;
    }

   foreach ($this->aLinhaAtual as $intkey => $sCampo){

       foreach ($this->aTableProperties as $aTabela) {

	 $sTipo = $aTabela[1];

	 //if ( ! array_key_exists($aTabela[0],$this->aLinhaAtual) ) {
	 //  throw new Exception("[tableDataManager] Erro : Nao definido campo {$this->sTableName}.".$aTabela[0]);
	 //}
	 //if ( array_key_exists($aTabela[0],$this->aLinhaAtual) ) {
	 if( $aTabela[0] == $intkey ){
	    if (trim($aTabela[0]) == trim($this->sCampoPk)) {
	      $sValor      = $this->getNextSequence();
	    }else{
	      $sValor      = $this->aLinhaAtual[$aTabela[0]];
	    }

	   $aLinha[] = trim($this->formatValue($sValor,$sTipo));
           break;
	 }
       }
   }

    $this->aData[] = $aLinha;

    if ($this->lAutoStore) {
      if (count($this->aData) == $this->iTamanhoBloco) {
        try {
          $this->persist();
        } catch (Exception $e){
          throw new Exception($e->getMessage());
        }
      }
    }

//    echo "{$this->sTableName} -- {$this->getLastPk()} \n";
    return $this->getLastPk();

  }

  function persist(){

    $iCont = 0;
    $sVirgula = "";
    $sCampos = "";
	foreach ($this->aLinhaAtual as $intkey => $sCampo){
       $sCampos .= $sVirgula.trim($intkey);
       $sVirgula = ", ";
	}
	
	if( count($this->aData) > 0 ){
	    $cmdinicial = "copy {$this->sTableName} ($sCampos) from stdin with delimiter '|';";
	    $cmdinicial = "copy {$this->sTableName} ($sCampos) from stdin;";
	    pg_query($this->pConexao, $cmdinicial);

	    foreach ($this->aData as $aLinha) {
	
	      $sLinha  = implode("\t", $aLinha);
//	      $sLinha  = implode("|", $aLinha);
	      $sLinha .= "\n";
	      // echo $sLinha;
	      if(!pg_put_line($this->pConexao, $sLinha)) {
	        throw new Exception("[tableDataManager] Erro linha numero: {$iCont} \n $cmdinicial \n {$sLinha}".pg_errormessage() );
	      }
	
	      $iCont++;
	
	    }
	
	    // var_dump($this->aData);
	    // echo "Copy total ; {$iCont} Tabela {$this->sTableName} -- \n ";
	
	    pg_put_line($this->pConexao, "\\.\n"); // Finaliza o Copy
	    pg_end_copy($this->pConexao);
	
	    $this->aData       = array();
	    $this->aLinha      = array();
	    $this->aLinhaAtual = array();
	}
    return true;

  }  

  function formatValue($valor, $tipo) {

    $aValorDefault = array (
        'int'      => "0",
        'int4'     => "0",
        'int8'     => "0",
        'float8'   => "0",
        'numeric'  => "0",
        'date'     => "null",
        'bpchar'   => "null",
        'string'   => "null"
        );
    if ($valor != '') {
      if ($tipo == 'int' || $tipo == 'numeric' || $tipo == 'int8' || $tipo == 'int4' || $tipo == 'float8') {
        return $valor;
      } else {
        $valor = "" . $valor . "";
        return $valor;
      }
    } else {
      return $aValorDefault[$tipo];
    }

  }



}

?>
