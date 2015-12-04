<?php

/**
 * Enter description here...
 *
 */
/**
 * Motivos para este refactor
 * 
 * 1 - Maior escalabilidade, facilidade para novas mudanças
 * 2 - Possibilidade de implementacao de biblioteca de traducao msgs do banco
 * 3 - Possibilidade de implementacao de i18n (necessario mais cedo ou mais tarde teremos que fazer)
 * 4 - Evolucao dos metodos de programacao, se aproximando mais de POO
 * 5 - Codigo centralizado
 * 6 - A caminho de um ORM
 *
 */

abstract class DAOBasica {
	
	public $rotulo = null;
	public $query_sql = null;
	public $numrows = 0;
	public $numrows_incluir = 0;
	public $numrows_alterar = 0;
	public $numrows_excluir = 0;
	public $erro_status = null;
	public $erro_sql = null;
	public $erro_banco = null;
	public $erro_msg = null;
	public $erro_campo = null;
	public $pagina_retorno = null;
	
	private $aDados   = array ();
	private $DDTabela = null;
	
	const INSERT    = 1;
	const UPDATE    = 2;
	const DELETE    = 3;
	const QUERY     = 4;
	const QUERYFULL = 3;
	
	
	public function __construct($sTableName) {
		
		$this->rotulo = new rotulo ( $sTableName );

		$this->DDTabela = DDXMLFactory::getInstance ( $sTableName );
		// @todo verificar possibilidade de implementar classe static para manipular
		// GPC e $_SERVER
		$this->pagina_retorno = basename ( $_SERVER ["PHP_SELF"] );
		
	//    foreach ($this->DDTabela->aCampos as $oCampo){
	//      $this->{$oCampo->name} = $this->getValorComparacaoPorTipo($oCampo->conteudo);
	//    }	

	}
	
	public function __set($sName, $sValue) {
		// @todo implementar maquina de estado (nao sei se eh aqui)
		$this->aDados [$sName] = $sValue;
	}
	
	public function __get($sName) {
		if (isset ( $this->aDados [$sName] )) {
			return $this->aDados [$sName];
		}
		// @todo verificar qual o melhor retorno
		return null;
	}
	
	public function loadPost($aCamposVerificar = Array()) {
		
		foreach ( $this->DDTabela->aCampos as $oCampo ) {
			
			if (count ( $aCamposVerificar ) > 0 && ! in_array ( $oCampo->name, $aCamposVerificar )) {
				continue;
			}
//			$tmp = $this->{$oCampo->name};
//   	  echo "LoadPost : " . $oCampo->name . " -- " . "-- ".$oCampo->conteudo." -- ".@$_POST [$oCampo->name] . "<br>";
//			if ( ! isset($tmp) || 
//			     ( $tmp == $this->getValorComparacaoPorTipo ( $oCampo->conteudo ) ) ) {
			if ($this->{$oCampo->name} == $this->getValorComparacaoPorTipo ( $oCampo->conteudo ) || true ) {
				//echo "LoadPost : " . $oCampo->name . " -- " . $_POST [$oCampo->name] . "<br>";

        // @todo - versao com problema quando seta codigo direto via RPC -- verificar
        
				$this->{$oCampo->name} =  ( !empty($_POST[$oCampo->name]) || 
				                            $this->{$oCampo->name} == $this->getValorComparacaoPorTipo($oCampo->conteudo) ? 
				                            @$_POST[$oCampo->name]:$this->{$oCampo->name} );

/*
        $this->{$oCampo->name} =  ( $this->{$oCampo->name} == $this->getValorComparacaoPorTipo($oCampo->conteudo) ? 
                                    @$_POST[$oCampo->name]:$this->{$oCampo->name} );
*/			                            
//  		  echo "Setando valor para propriedade de classe : {$oCampo->name} => ".$this->{$oCampo->name}." <br>";
			}
		}
	}
	
	private function getValorComparacaoPorTipo($sTipo) {
		
		$aTipos ['boolean'] = "f";
		$aTipos ['bool']    = "f";
		$aTipos ['char']    = "";
		$aTipos ['varchar'] = "";
		$aTipos ['text']    = "";
		$aTipos ['date']    = "";
		$aTipos ['float4']  = "";
		$aTipos ['float8']  = "";
		$aTipos ['int4']    = "";
		$aTipos ['int8']    = "";
    $aTipos ['oid']     = "";
		
		$sChave = strtolower ( trim ( substr ( $sTipo, 0, (strpos ( $sTipo, "(" ) ? strpos ( $sTipo, "(" ) : strlen ( $sTipo )) ) ) );
		//echo "Tipo : ".$aTipos[$sChave]." Chave ; $sChave <br>";    
		return $aTipos [$sChave];
	}

  private function getValorComparacaoInsert($sTipo) {
    
    $aTipos ['boolean'] = null;
    $aTipos ['bool']    = null;
    $aTipos ['char']    = "";
    $aTipos ['varchar'] = "";
    $aTipos ['text']    = "";
    $aTipos ['date']    = "";
    $aTipos ['float4']  = "";
    $aTipos ['float8']  = "";
    $aTipos ['int4']    = null;
    $aTipos ['int8']    = null;
    
    $sChave = strtolower ( trim ( substr ( $sTipo, 0, (strpos ( $sTipo, "(" ) ? strpos ( $sTipo, "(" ) : strlen ( $sTipo )) ) ) );
    //echo "Tipo : ".$aTipos[$sChave]." Chave ; $sChave <br>";    
    return $aTipos [$sChave];
  }
	
	// @todo comentar metodos antigos com @deprecated  
	public function atualizacampos($exclusao = false) {
		if ($exclusao == false) {
			$this->loadPost ();
		} else {
			// $this->ht09_sequencial = ($this->ht09_sequencial == "" ? @$GLOBALS ["HTTP_POST_VARS"] ["ht09_sequencial"] : $this->ht09_sequencial);      
			// @todo retirar campo fixo e ler do dicionario chave primaria
			

			$aCampos = array ();
			foreach ( $this->DDTabela->getFieldsPk () as $oCampoChave ) {
				$aCampos [] = $oCampoChave->name;
			}
			$this->loadPost ( $aCampos );
		}
	}
	
	// @todo comentar metodos antigos com @deprecated
	public function erro($mostra, $retorna) {
		if (($this->erro_status == "0") || ($mostra == true && $this->erro_status != null)) {
			echo "<script>alert(\"" . $this->erro_msg . "\");</script>";
			if ($retorna == true) {
				echo "<script>location.href='" . $this->pagina_retorno . "'</script>";
			}
		}
	}
	
	public function getParametros($aParametros = array(), $iOperacao) {
		
		$aRetorno = array ();
		$iIndice = 0;
		//var_dump_pre($aParametros);
		
		foreach ( $this->DDTabela->getFieldsPk () as $oCampo ) {

			if (!isset($aParametros [$iIndice])){
				$iIndice ++;
				continue;
			}		
			$aRetorno [$oCampo->name] = $aParametros [$iIndice];
			$this->{$oCampo->name}    = $aParametros [$iIndice];
			$iIndice ++;
		}
		
		switch ($iOperacao) {
			
			case self::INSERT :
				
				break;
			
			case self::UPDATE :
				
				//@todo testar melhor este codigo
				//$aRetorno ["sWhere"] = $aParametros [++ $iIndice];
				$aRetorno ["sWhere"] = (! empty ( $aParametros [$iIndice] ) ? $aParametros [$iIndice] : null);
				break;
			
			case self::DELETE :
				
				// @todo testar melhor este codigo
				//$aRetorno ["sWhere"] = $aParametros [++ $iIndice];
				$aRetorno ["sWhere"] = (! empty ( $aParametros [$iIndice] ) ? $aParametros [$iIndice] : null);
				break;
			
			case self::QUERY :
				
				// @todo testar melhor este codigo
				// $aRetorno ["sWhere"] = $aParametros [++ $iIndice];
				$aRetorno ["sCampos"]  = (! empty ( $aParametros [$iIndice] ) ? $aParametros [$iIndice] : null);
				$aRetorno ["sOrderBy"] = (! empty ( $aParametros [++ $iIndice] ) ? $aParametros [$iIndice] : null);
				$aRetorno ["sWhere"]   = (! empty ( $aParametros [++ $iIndice] ) ? $aParametros [$iIndice] : null);
				$aRetorno ["sGroupBy"] = (! empty ( $aParametros [++ $iIndice] ) ? $aParametros [$iIndice] : null);
				break;
			
			default :
				break;
		
		}
		
		return $aRetorno;
	
	}
	
	public function getStringCamposChave() {
		
		$sIfem = "";
		$sCampos = "";
		foreach ( $this->DDTabela->getFieldsPk () as $oCampoChavePrimaria ) {
			$sCampos .= $this->{$oCampoChavePrimaria->name} . $sIfem;
			$sIfem = "-";
		}
		if (! empty ( $sCampos )) {
			return $sCampos;
		}
		return false;
	}
	
	private function formatarAtributo($sNomeCampo, $sValor) {
		
		//echo "Formata atributos : $sNomeCampo => $sValor"; 
		
		$aValoresFormatados ['boolean'] = ( $sValor == "t" || $sValor == "true" || $sValor === true ? "true" : "false");
		$aValoresFormatados ['bool']    = ( $sValor == "t" || $sValor == "true" || $sValor === true ? "true" : "false");
		$aValoresFormatados ['char']    = "'" . $sValor . "'";
		$aValoresFormatados ['varchar'] = "'" . $sValor . "'";
		$aValoresFormatados ['text']    = "'" . $sValor . "'";
		$aValoresFormatados ['date']    = (empty($sValor)?"null":"'" . implode("-", array_reverse(explode("/",$sValor))) . "'");
		$aValoresFormatados ['float4']  = (empty($sValor)?"null":$sValor);
		$aValoresFormatados ['float8']  = (empty($sValor)?"null":$sValor);
		$aValoresFormatados ['oid']     = (empty($sValor)?"null":$sValor);
		$aValoresFormatados ['int4']    = (empty($sValor)?"0":$sValor);
		$aValoresFormatados ['int8']    = (empty($sValor)?"0":$sValor);
		
		foreach ( $this->DDTabela->aCampos as $oCampo ) {
			if ($oCampo->name == $sNomeCampo) {
				$sChave = strtolower ( trim ( substr ( $oCampo->conteudo, 0, (strpos ( $oCampo->conteudo, "(" ) ? strpos ( $oCampo->conteudo, "(" ) : strlen ( $oCampo->conteudo )) ) ) );
				return $aValoresFormatados [$sChave];
			}
		}
		
		return $sValor;
	}
	
	public function getValoresInsert() {
		
		$sValoresInsert = false;
		
		$aDados = array ();
		
		foreach ( $this->aDados as $sKey => $sValue ) {
			
			$aDados [$sKey] = $this->formatarAtributo ( $sKey, $sValue );
			//echo "Chave : $sKey Value : $sValue <br>";
		}
		
		return implode ( ',', $aDados );
	}
	
	public function incluir() {
		
		$this->loadPost ();
		
		$sCampos = $this->getStringCamposChave ();
		
		$aParametros = $this->getParametros ( func_get_args (), self::INSERT );
/*		
		// carregar valores da assinatura do metodos dinamicamente
		// apos loadPost
    // @todo - verificar para limpar depois 
		foreach ($aParametros as $sIndice => $sValor) {
			if (isset()){
				
			}
		}
*/		
		
	//	echo "Incluir classe : {$this->DDTabela->name} <br>";
		
		foreach ( $this->DDTabela->getCampos () as $oCampo ) {

	//		echo "{$oCampo->name} : ".$this->{$oCampo->name}." empty ??? ".(empty($this->{$oCampo->name})?"true":"false")." Null : {$oCampo->null} <br>";
			
			if ($oCampo->null == 'f' && ! $oCampo->getSequence ()) {
				
				// $tmp = $this->{$oCampo->name};
				// echo "{$oCampo->name} : ".$tmp." empty ??? ".(empty($tmp)?"true":"false")."<br>";
				// var_dump_pre($tmp);
				//if (empty($tmp)) {
				
				/*
				 
				 echo $this->{$oCampo->name}." == ".$this->getValorComparacaoInsert($oCampo->conteudo)." && ". 
             $aParametros[$oCampo->name]." == ".$this->getValorComparacaoInsert($oCampo->conteudo) ;
        
         if ( $this->{$oCampo->name}      == $this->getValorComparacaoInsert($oCampo->conteudo) && 
              $aParametros[$oCampo->name] == $this->getValorComparacaoInsert($oCampo->conteudo) ) { 
        */
				
				if ( $this->{$oCampo->name} == $this->getValorComparacaoInsert($oCampo->conteudo) ) {
				
				//	echo "{$oCampo->name} : ".$this->{$oCampo->name}." --  empty ??? ".(empty($this->{$oCampo->name})?"true":"false")."<br>";
				
					$this->erro_sql = " Campo {$oCampo->description} nao Informado.";
					$this->erro_campo = $oCampo->name;
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
					$this->erro_msg .= str_replace ( '"', "", str_replace ( "'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n" ) );
					$this->erro_status = "0";
					return false;
				}
			}
			
			/**
			 * Se tem sequencia para o campo
			 */
			//    	echo "<pre>";
			//    	var_dump($oCampo);
			//    	echo "</pre>";

			if ($oCampo->getSequence ()) {
				if ($this->{$oCampo->name} == "" || $this->{$oCampo->name} == null) {
					$rsNextval = db_query ( "select nextval('{$oCampo->getSequence()->name}')" );
					if ($rsNextval == false) {
						$this->erro_banco = str_replace ( "\n", "", @pg_last_error () );
						$this->erro_sql = "Verifique o cadastro da sequencia: {$oCampo->getSequence()->name} do campo: {$oCampo->name}";
						$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
						$this->erro_msg .= str_replace ( '"', "", str_replace ( "'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n" ) );
						$this->erro_status = "0";
						return false;
					}
					$this->{$oCampo->name} = pg_result ( $rsNextval, 0, 0 );
				} else {
					$rsLastVal = db_query ( "select last_value from {$oCampo->getSequence()->name}" );
					if (($rsLastVal != false) && (pg_result ( $rsLastVal, 0, 0 ) < $this->{$oCampo->name})) {
						$this->erro_sql = " Campo {$this->{$oCampo->name}} maior que último número da sequencia.";
						$this->erro_banco = "Sequencia menor que este número.";
						$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
						$this->erro_msg .= str_replace ( '"', "", str_replace ( "'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n" ) );
						$this->erro_status = "0";
						return false;
					} else {
						$this->{$oCampo->name} = $aParametros [$oCampo->name];
					}
				}
			}
			
			if ($oCampo->isPk () && $this->{$oCampo->name} == "") {
				$this->erro_sql = " Campo {$oCampo->name} nao declarado.";
				$this->erro_banco = "Chave Primaria zerada.";
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace ( '"', "", str_replace ( "'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n" ) );
				$this->erro_status = "0";
				return false;
			}
		}
		
		$sCamposInsert = implode ( ',', array_keys ( $this->aDados ) );
		$sValoresInsert = $this->getValoresInsert ();
		$sSql = "INSERT INTO {$this->DDTabela->name} ({$sCamposInsert}) VALUES ($sValoresInsert) ";
		// echo $sSql."<br>";
		$rsInsert = db_query ( $sSql );
		
		if (! $rsInsert) {
			$this->erro_banco = str_replace ( "\n", "", @pg_last_error () );
			if (strpos ( strtolower ( $this->erro_banco ), "duplicate key" ) != 0) {
				$this->erro_sql = "{$this->description} ({$sCampos}) nao Incluído. Inclusao Abortada.";
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_banco = "{$this->description} já Cadastrado";
				$this->erro_msg .= str_replace ( '"', "", str_replace ( "'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n" ) );
			} else {
				$this->erro_sql = "{$this->description} ({$sCampos}) nao Incluído. Inclusao Abortada.";
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace ( '"', "", str_replace ( "'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n" ) );
			}
			$this->erro_status = "0";
			$this->numrows_incluir = 0;
			return false;
		}
		
		$this->erro_banco = "";
		$this->erro_sql = "Inclusao efetuada com Sucesso\\n";
		$this->erro_sql .= "Valores : " . $sCampos;
		$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
		$this->erro_msg .= str_replace ( '"', "", str_replace ( "'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n" ) );
		$this->erro_status = "1";
		
		return true;
	
	}
	
	//public function alterar($ht09_sequencial = null) {
	public function alterar() {
		
		$this->loadPost ();
		$aParametros = $this->getParametros ( func_get_args (), self::UPDATE );
		
		foreach ( $this->DDTabela->getCampos () as $oCampo ) {
			
			if ($oCampo->nulo == 'f') {
				if ($this->aDados [$oCampo->name] == null) {
					$this->erro_sql = " Campo {$oCampo->description} nao Informado.";
					$this->erro_campo = $oCampo->name;
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
					$this->erro_msg .= str_replace ( '"', "", str_replace ( "'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n" ) );
					$this->erro_status = "0";
					return false;
				}
			}
			
			if ($oCampo->isPk () && $this->{$oCampo->name} == "") {
				$this->erro_sql = " Campo {$oCampo->name} nao declarado.";
				$this->erro_banco = "Chave Primaria zerada.";
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace ( '"', "", str_replace ( "'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n" ) );
				$this->erro_status = "0";
				return false;
			}
		}
		
		$sCamposUpdate = "";
		$sVirgula = "";
		foreach ( $this->aDados as $sChave => $sValor ) {
			$sCamposUpdate .= "{$sVirgula} {$sChave} = " . $this->formatarAtributo ( $sChave, $sValor );
			$sVirgula = ",";
		}
		/**
		 * Montando where para campos chave primaria
		 */
		$sWhere = "";
		$sAnd = "";
		foreach ( $this->DDTabela->getFieldsPk () as $oChave ) {

			if ($this->{$oChave->name} != null) {
				$sWhere .= " {$sAnd} {$oChave->name} = " . $this->formatarAtributo ( $oChave->name, $this->{$oChave->name} );
				$sAnd = "and";
			}
		}
		
		if (! empty ( $sWhere )) {
			$sWhere = " where {$sWhere} ";
		}
		
		$sSql = "UPDATE {$this->DDTabela->name} SET {$sCamposUpdate} {$sWhere}";
		
		//echo $sSql . "<br>";
		$rsUpdate = db_query ( $sSql );
		
		if ($rsUpdate == false) {
			$this->erro_banco = str_replace ( "\n", "", @pg_last_error () );
			$this->erro_sql = "{$this->description} nao Alterado. Alteracao Abortada.\\n";
			$this->erro_sql .= "Valores : " . $this->getStringCamposChave ();
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace ( '"', "", str_replace ( "'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n" ) );
			$this->erro_status = "0";
			$this->numrows_alterar = 0;
			return false;
		} else {
			if (pg_affected_rows ( $rsUpdate ) == 0) {
				$this->erro_banco = "";
				$this->erro_sql = "{$this->descricao} nao foi Alterado. Alteracao Executada.\\n";
				$this->erro_sql .= "Valores : " . $this->getStringCamposChave ();
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace ( '"', "", str_replace ( "'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n" ) );
				$this->erro_status = "1";
				$this->numrows_alterar = 0;
				return true;
			} else {
				$this->erro_banco = "";
				$this->erro_sql = "Alteração efetuada com Sucesso\\n";
				$this->erro_sql .= "Valores : " . $this->getStringCamposChave ();
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace ( '"', "", str_replace ( "'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n" ) );
				$this->erro_status = "1";
				$this->numrows_alterar = pg_affected_rows ( $rsUpdate );
				return true;
			}
		}
		return true;
	}
	
	// funcao para exclusao
	

	function excluir() {
		
		$aParametros = $this->getParametros ( func_get_args (), self::DELETE );
		
		//var_dump_pre ( $aParametros );
		
		$sSql = " DELETE FROM {$this->DDTabela->name} WHERE ";
		$sWhere = "";
		$sAnd = "";
		
		if ($aParametros ['sWhere'] == null || $aParametros ['sWhere'] == "") {
			
			//echo "Dentro do if <br>";
			foreach ( $aParametros as $sNomeParametro => $sValorParametro ) {
				
				//echo "Dentro do for : $sNomeParametro => $sValorParametro <br>";
				
				if ($sNomeParametro == 'sWhere') {
					//echo "Passando para o proximo <br>";
					continue;
				}
				if (! empty ( $sValorParametro )) {
					$sWhere .= " {$sAnd} {$sNomeParametro} = {$sValorParametro} ";
  				$sAnd = "and";
				}
			
			}
		} else {
			$sWhere = $aParametros ['sWhere'];
		}
		
		$sSql .= $sWhere;
		
		//echo $sSql . "<br>";
		
		$result = db_query ( $sSql );
		if ($result == false) {
			$this->erro_banco = str_replace ( "\n", "", @pg_last_error () );
			$this->erro_sql = "Documentos do Tipo de Grupo de Programa nao Excluído. Exclusão Abortada.\\n";
			$this->erro_sql .= "Valores : " . $this->getStringCamposChave ();
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace ( '"', "", str_replace ( "'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n" ) );
			$this->erro_status = "0";
			$this->numrows_excluir = 0;
			return false;
		} else {
			if (pg_affected_rows ( $result ) == 0) {
				$this->erro_banco = "";
				$this->erro_sql = "Documentos do Tipo de Grupo de Programa nao Encontrado. Exclusão não Efetuada.\\n";
				$this->erro_sql .= "Valores : " . $this->getStringCamposChave ();
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace ( '"', "", str_replace ( "'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n" ) );
				$this->erro_status = "1";
				$this->numrows_excluir = 0;
				return true;
			} else {
				$this->erro_banco = "";
				$this->erro_sql = "Exclusão efetuada com Sucesso\\n";
				$this->erro_sql .= "Valores : " . $this->getStringCamposChave ();
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace ( '"', "", str_replace ( "'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n" ) );
				$this->erro_status = "1";
				$this->numrows_excluir = pg_affected_rows ( $result );
				return true;
			}
		}
	}
	
	// funcao do recordset 
	function sql_record($sSql) {
		
		$rsQuery = db_query ( $sSql );
		if ($rsQuery == false) {
			$this->numrows = 0;
			$this->erro_banco = str_replace ( "\n", "", @pg_last_error () );
			$this->erro_sql =  "Erro ao selecionar os registros." ;
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace ( '"', "", str_replace ( "'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n" ) );
			$this->erro_status = "0";
			return false;
		}
		$this->numrows = pg_num_rows ( $rsQuery );
		if ($this->numrows == 0) {
			$this->erro_banco = "";
			$this->erro_sql = "Record Vazio na Tabela:conciliatipo";
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace ( '"', "", str_replace ( "'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n" ) );
			$this->erro_status = "0";
			return false;
		}
		return $rsQuery;
	
	}
	
	// @todo criar classe para fazer a geracao de sql
	function sql_query_file() {
		
		//   sql_query_file ( $k65_sequencial=null,$campos="*",$ordem=null,$dbwhere="")
		$aParametros = $this->getParametros ( func_get_args (), self::QUERY );
		//var_dump_pre ( $aParametros );
		$sCampos       = "*";
		$sWhere        = "";
		$sOrderBy      = "";
		$sGroupBy      = "";
		$sWhereStr     = "WHERE";
		$aParametrosPk = array();
		
		if ($aParametros ['sWhere'] == null || $aParametros ['sWhere'] == "") {
			
			foreach ( $aParametros as $sNomeParametro => $sValorParametro ) {
				if ($sNomeParametro == 'sCampos' || $sNomeParametro == 'sWhere' || $sNomeParametro == 'sOrderBy' || $sNomeParametro == 'sGroupBy') {
					//echo "Passando para o proximo [{$sNomeParametro}] <br> ";
					continue;
				}
				$aParametrosPk[$sNomeParametro] = $sValorParametro;
			}
		} 
		
		return $this->query( $aParametrosPk,
		                     $aParametros['sCampos'],
		                     $aParametros['sWhere'],
		                     $aParametros['sGroupBy'],
		                     $aParametros['sOrderBy'],
		                     0 );
	}
	
	 // @todo criar classe para fazer a geracao de sql
  function sql_query() {
    
    $aParametros = $this->getParametros ( func_get_args (), self::QUERY );
    //var_dump_pre ( $aParametros );
    $sCampos       = "*";
    $sWhere        = "";
    $sOrderBy      = "";
    $sGroupBy      = "";
    $sWhereStr     = "WHERE";
    $aParametrosPk = array();
    
    if ($aParametros ['sWhere'] == null || $aParametros ['sWhere'] == "") {
      foreach ( $aParametros as $sNomeParametro => $sValorParametro ) {
        if ($sNomeParametro == 'sCampos' || $sNomeParametro == 'sWhere' || $sNomeParametro == 'sOrderBy' || $sNomeParametro == 'sGroupBy') {
          //echo "Passando para o proximo [{$sNomeParametro}] <br> ";
          continue;
        }
        $aParametrosPk[$sNomeParametro] = $sValorParametro;
      }
    } 
    
    return $this->query( $aParametrosPk,
                         $aParametros['sCampos'],
                         $aParametros['sWhere'],
                         $aParametros['sGroupBy'],
                         $aParametros['sOrderBy'],
                         1 );
  }


  
  // @todo - verificar possibilidade de uso da pdo
  // @todo - implementar cache das strings de processamento
  //
  //   controlar por instancia
  //   verificar insert, update, delete e select
  //
	function query(array $aValuesPk, $sCamposP=null, $sWhereP=null, $sGroupByP=null, $sOrderByP=null, $iNivel=0) {
		
    $sAnd      = "";
    $sCampos   = "*";
    $sWhere    = "";
    $sOrderBy  = "";
    $sJoins    = "";
    $sGroupBy  = "";
    $sWhereStr = "WHERE";
    
    //var_dump_pre ( $aValuesPk );
    
    if (empty($sWhereP)) {
      
      foreach ( $aValuesPk as $sNomeParametro => $sValorParametro ) {
      	
        //echo "Dentro do for : $sNomeParametro => $sValorParametro <br>";
        if (! empty ( $sValorParametro )) {
          $sWhere .= "{$sWhereStr} {$sAnd} {$sNomeParametro} = {$sValorParametro} ";
          $sAnd = "and";
          $sWhereStr = "";
        }
      
      }
    } else {
      $sWhere = "{$sWhereStr} {$sWhereP}";
    }
    
    if ( $iNivel == 1){
    	
    	foreach ($this->DDTabela->getFks() as $oFk) {
    		
    		$inner   = "INNER";
    		
    		if ($oFk->inner == 'false') {
    			$inner   = "LEFT";
    		}

    		$sAnd    = "";
    		$sJoins .= " {$inner} JOIN {$oFk->reference} ON ";
    		
    	  foreach ($oFk->getFields() as $oFieldFk) {
    		  $sJoins .= " $sAnd {$oFk->reference}.{$oFieldFk->reference} =  {$this->DDTabela->name}.{$oFieldFk->name} \n";
    		  $sAnd    = "AND";
    	  }
    	}
    }
		
		if (! empty ( $sCamposP )) {
			$sCampos = $sCamposP;
		}
		
		if (! empty ( $sOrderByP)) {
			$sOrderBy = "ORDER BY {$sOrderByP}";
		}
		
		if (! empty ( $sGroupByP )) {
			$sOrderBy = "GROUP BY {$sGroupByP}";
		}
		
		$sSql = " SELECT {$sCampos} ";
		$sSql .= "   FROM {$this->DDTabela->name} ";
		$sSql .= "        {$sJoins}   ";
		$sSql .= " {$sWhere}   ";
		$sSql .= " {$sGroupBy} ";
		$sSql .= " {$sOrderBy} ";
		
//		echo $sSql . "<br><br>";
		return $sSql;
	}

}
//}

/*

class cl_arrecad extends DAObasica {
  
  public function __construct(){

    parent::__construct(__CLASS__);
    
    
  }  
  
}
*/

