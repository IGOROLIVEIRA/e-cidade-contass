<?
//MODULO: caixa
//CLASSE DA ENTIDADE conciliacao
class cl_conciliacao {
	// cria variaveis de erro
	var $rotulo     = null;
	var $query_sql  = null;
	var $numrows    = 0;
	var $numrows_incluir = 0;
	var $numrows_alterar = 0;
	var $numrows_excluir = 0;
	var $erro_status= null;
	var $erro_sql   = null;
	var $erro_banco = null;
	var $erro_msg   = null;
	var $erro_campo = null;
	var $pagina_retorno = null;
	// cria variaveis do arquivo
	var $k199_saldofinalextrato = 0;
	var $k199_periodofinal_dia = null;
	var $k199_periodofinal_mes = null;
	var $k199_periodofinal_ano = null;
	var $k199_periodofinal = null;
	var $k199_codconta = 0;
	var $k199_sequencial = 0;
	var $k199_periodoini_dia = null;
	var $k199_periodoini_mes = null;
	var $k199_periodoini_ano = null;
	var $k199_periodoini = null;
	// cria propriedade com as variaveis do arquivo
	var $campos = "
                 k199_saldofinalextrato = float8 = Saldo final do extrato 
                 k199_periodofinal = date =  
                 k199_codconta = int8 = Conta 
                 k199_sequencial = int8 = Código  sequencial 
                 k199_periodoini = date = Período 
                 ";
	//funcao construtor da classe
	function cl_conciliacao() {
		//classes dos rotulos dos campos
		$this->rotulo = new rotulo("conciliacao");
		$this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
	}
	//funcao erro
	function erro($mostra,$retorna) {
		if(($this->erro_status == "0") || ($mostra == true && $this->erro_status != null )){
			echo "<script>alert(\"".$this->erro_msg."\");</script>";
			if($retorna==true){
				echo "<script>location.href='".$this->pagina_retorno."'</script>";
			}
		}
	}
	// funcao para atualizar campos
	function atualizacampos($exclusao=false) {
		if($exclusao==false){
			$this->k199_saldofinalextrato = ($this->k199_saldofinalextrato == ""?@$GLOBALS["HTTP_POST_VARS"]["k199_saldofinalextrato"]:$this->k199_saldofinalextrato);
			if($this->k199_periodofinal == ""){
				$this->k199_periodofinal_dia = ($this->k199_periodofinal_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["k199_periodofinal_dia"]:$this->k199_periodofinal_dia);
				$this->k199_periodofinal_mes = ($this->k199_periodofinal_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["k199_periodofinal_mes"]:$this->k199_periodofinal_mes);
				$this->k199_periodofinal_ano = ($this->k199_periodofinal_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["k199_periodofinal_ano"]:$this->k199_periodofinal_ano);
				if($this->k199_periodofinal_dia != ""){
					$this->k199_periodofinal = $this->k199_periodofinal_ano."-".$this->k199_periodofinal_mes."-".$this->k199_periodofinal_dia;
				}
			}
			$this->k199_codconta = ($this->k199_codconta == ""?@$GLOBALS["HTTP_POST_VARS"]["k199_codconta"]:$this->k199_codconta);
			$this->k199_sequencial = ($this->k199_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["k199_sequencial"]:$this->k199_sequencial);
			if($this->k199_periodoini == ""){
				$this->k199_periodoini_dia = ($this->k199_periodoini_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["k199_periodoini_dia"]:$this->k199_periodoini_dia);
				$this->k199_periodoini_mes = ($this->k199_periodoini_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["k199_periodoini_mes"]:$this->k199_periodoini_mes);
				$this->k199_periodoini_ano = ($this->k199_periodoini_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["k199_periodoini_ano"]:$this->k199_periodoini_ano);
				if($this->k199_periodoini_dia != ""){
					$this->k199_periodoini = $this->k199_periodoini_ano."-".$this->k199_periodoini_mes."-".$this->k199_periodoini_dia;
				}
			}
		}else{
			$this->k199_sequencial = ($this->k199_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["k199_sequencial"]:$this->k199_sequencial);
		}
	}
	// funcao para inclusao
	function incluir ($k199_sequencial){
		$this->atualizacampos();
		if($this->k199_saldofinalextrato == null ){
			$this->erro_sql = " Campo Saldo final do extrato nao Informado.";
			$this->erro_campo = "k199_saldofinalextrato";
			$this->erro_banco = "";
			$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
			$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
			$this->erro_status = "0";
			return false;
		}
		if($this->k199_periodofinal == null ){
			$this->erro_sql = " Campo  nao Informado.";
			$this->erro_campo = "k199_periodofinal_dia";
			$this->erro_banco = "";
			$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
			$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
			$this->erro_status = "0";
			return false;
		}
		if($this->k199_codconta == null ){
			$this->erro_sql = " Campo Conta nao Informado.";
			$this->erro_campo = "k199_codconta";
			$this->erro_banco = "";
			$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
			$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
			$this->erro_status = "0";
			return false;
		}
		if($this->k199_periodoini == null ){
			$this->erro_sql = " Campo Período nao Informado.";
			$this->erro_campo = "k199_periodoini_dia";
			$this->erro_banco = "";
			$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
			$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
			$this->erro_status = "0";
			return false;
		}
		if($this->k199_periodoini > $this->k199_periodofinal)
		{
			$this->erro_sql = " A data inicial  não deve ser superior a data final  .";
			$this->erro_campo = "k199_periodoini";
			$this->erro_banco = "";
			$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
			$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Verifique: \\n\\n ".$this->erro_banco." \\n"));
			$this->erro_status = "0";
			return false;
		}

		if(($this->k199_sequencial == null) || ($this->k199_sequencial == "") ){
			$result = db_query("select nextval('cai_conciliacao_k199_sequencial_seq')");
			if($result==false){
				$this->erro_banco = str_replace("\n","",@pg_last_error());
				$this->erro_sql   = "Verifique o cadastro da sequencia: cai_conciliacao_k199_sequencial_seq do campo: k199_sequencial";
				$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
				$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
				$this->erro_status = "0";
				return false;
			}
			$this->k199_sequencial = pg_result($result,0,0);
		}else{
			$result = db_query("select last_value from cai_conciliacao_k199_sequencial_seq");
			if(($result != false) && (pg_result($result,0,0) < $k199_sequencial)){
				$this->erro_sql = " Campo k199_sequencial maior que último número da sequencia.";
				$this->erro_banco = "Sequencia menor que este número.";
				$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
				$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
				$this->erro_status = "0";
				return false;
			}else{
				$this->k199_sequencial = $k199_sequencial;
			}
		}
		 
		$sql=" select * from conciliacao where k199_periodofinal='{$this->k199_periodofinal}' and k199_codconta=$this->k199_codconta  and k199_periodoini='{$this->k199_periodoini}'";
		$result = db_query($sql);

		$row=pg_num_rows($result);
		/*
		 * Para verificar a existência de uma conciliação já realizada para este período;
		 */
		/* if($row!=0){
		 echo "<script>var x=confirm('Já existe uma conciliação para este período. Deseja alterá-la?');
		 if(x){

		 }
		 else{
		 alert('passou');
		 }
		 </script>";

		 //exit;
		 /*$this->erro_sql = " Já existe uma conciliação para este período. Para alterá-la, você deverá entrar no menu: Procedimentos > Conciliação Bancária Manual>> Conciliar>>Alteração";
		 $this->erro_banco = "";
		 $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
		 $this->erro_status = "0";
		 return false;
		 }*/

		 
		$sql = "insert into conciliacao(
                                       k199_saldofinalextrato 
                                      ,k199_periodofinal 
                                      ,k199_codconta 
                                      ,k199_sequencial 
                                      ,k199_periodoini 
                       )
                values (
                $this->k199_saldofinalextrato
                               ,".($this->k199_periodofinal == "null" || $this->k199_periodofinal == ""?"null":"'".$this->k199_periodofinal."'")." 
                               ,$this->k199_codconta 
                               ,$this->k199_sequencial 
                               ,".($this->k199_periodoini == "null" || $this->k199_periodoini == ""?"null":"'".$this->k199_periodoini."'")." 
                      )";
                $result = db_query($sql);
                 
                if($result==false){
                	$this->erro_banco = str_replace("\n","",@pg_last_error());
                	if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
                		$this->erro_sql   = " ($this->k199_sequencial) nao Incluído. Inclusao Abortada.";
                		$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                		$this->erro_banco = " já Cadastrado";
                		$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                	}else{
                		$this->erro_sql   = " ($this->k199_sequencial) nao Incluído. Inclusao Abortada.";
                		$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                		$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                	}
                	$this->erro_status = "0";
                	$this->numrows_incluir= 0;
                	return false;
                }
                $this->erro_banco = "";
                $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$this->k199_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_incluir= pg_affected_rows($result);
                $resaco = $this->sql_record($this->sql_query_file($this->k199_sequencial));
                if(($resaco!=false)||($this->numrows!=0)){
                	$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                	$acount = pg_result($resac,0,0);
                	$resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
                	$resac = db_query("insert into db_acountkey values($acount,1009244,'$this->k199_sequencial','I')");
                	$resac = db_query("insert into db_acount values($acount,2010209,2009343,'','".AddSlashes(pg_result($resaco,0,'k199_saldofinalextrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                	$resac = db_query("insert into db_acount values($acount,2010209,2009341,'','".AddSlashes(pg_result($resaco,0,'k199_periodofinal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                	$resac = db_query("insert into db_acount values($acount,2010209,2009339,'','".AddSlashes(pg_result($resaco,0,'k199_codconta'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                	$resac = db_query("insert into db_acount values($acount,2010209,2009344,'','".AddSlashes(pg_result($resaco,0,'k199_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                	$resac = db_query("insert into db_acount values($acount,2010209,2009342,'','".AddSlashes(pg_result($resaco,0,'k199_periodoini'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                }
                return true;
	}
	// funcao para alteracao
	function alterar ($k199_sequencial=null) {
		$this->atualizacampos();
		$sql = " update conciliacao set ";
		$virgula = "";
		if(trim($this->k199_saldofinalextrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k199_saldofinalextrato"])){
			$sql  .= $virgula." k199_saldofinalextrato = $this->k199_saldofinalextrato ";
			$virgula = ",";
			if(trim($this->k199_saldofinalextrato) == null ){
				$this->erro_sql = " Campo Saldo final do extrato nao Informado.";
				$this->erro_campo = "k199_saldofinalextrato";
				$this->erro_banco = "";
				$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
				$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
				$this->erro_status = "0";
				return false;
			}
		}
		if(trim($this->k199_periodofinal)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k199_periodofinal_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["k199_periodofinal_dia"] !="") ){
			$sql  .= $virgula." k199_periodofinal = '$this->k199_periodofinal' ";
			$virgula = ",";
			if(trim($this->k199_periodofinal) == null ){
				$this->erro_sql = " Campo  nao Informado.";
				$this->erro_campo = "k199_periodofinal_dia";
				$this->erro_banco = "";
				$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
				$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
				$this->erro_status = "0";
				return false;
			}
		}     else{
			if(isset($GLOBALS["HTTP_POST_VARS"]["k199_periodofinal_dia"])){
				$sql  .= $virgula." k199_periodofinal = null ";
				$virgula = ",";
				if(trim($this->k199_periodofinal) == null ){
					$this->erro_sql = " Campo  nao Informado.";
					$this->erro_campo = "k199_periodofinal_dia";
					$this->erro_banco = "";
					$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
					$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
					$this->erro_status = "0";
					return false;
				}
			}
		}
		if(trim($this->k199_codconta)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k199_codconta"])){
			$sql  .= $virgula." k199_codconta = $this->k199_codconta ";
			$virgula = ",";
			if(trim($this->k199_codconta) == null ){
				$this->erro_sql = " Campo Conta nao Informado.";
				$this->erro_campo = "k199_codconta";
				$this->erro_banco = "";
				$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
				$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
				$this->erro_status = "0";
				return false;
			}
		}
		if(trim($this->k199_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k199_sequencial"])){
			$sql  .= $virgula." k199_sequencial = $this->k199_sequencial ";
			$virgula = ",";
			if(trim($this->k199_sequencial) == null ){
				$this->erro_sql = " Campo Código  sequencial nao Informado.";
				$this->erro_campo = "k199_sequencial";
				$this->erro_banco = "";
				$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
				$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
				$this->erro_status = "0";
				return false;
			}
		}
		if(trim($this->k199_periodoini)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k199_periodoini_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["k199_periodoini_dia"] !="") ){
			$sql  .= $virgula." k199_periodoini = '$this->k199_periodoini' ";
			$virgula = ",";
			if(trim($this->k199_periodoini) == null ){
				$this->erro_sql = " Campo Período nao Informado.";
				$this->erro_campo = "k199_periodoini_dia";
				$this->erro_banco = "";
				$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
				$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
				$this->erro_status = "0";
				return false;
			}
		}     else{
			if(isset($GLOBALS["HTTP_POST_VARS"]["k199_periodoini_dia"])){
				$sql  .= $virgula." k199_periodoini = null ";
				$virgula = ",";
				if(trim($this->k199_periodoini) == null ){
					$this->erro_sql = " Campo Período nao Informado.";
					$this->erro_campo = "k199_periodoini_dia";
					$this->erro_banco = "";
					$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
					$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
					$this->erro_status = "0";
					return false;
				}
			}
		}
		$sql .= " where ";
		if($k199_sequencial!=null){
			$sql .= " k199_sequencial = $this->k199_sequencial";
		}
		$resaco = $this->sql_record($this->sql_query_file($this->k199_sequencial));
		if($this->numrows>0){
			for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
				$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
				$acount = pg_result($resac,0,0);
				$resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
				$resac = db_query("insert into db_acountkey values($acount,1009244,'$this->k199_sequencial','A')");
				if(isset($GLOBALS["HTTP_POST_VARS"]["k199_saldofinalextrato"]) || $this->k199_saldofinalextrato != "")
				$resac = db_query("insert into db_acount values($acount,2010209,2009343,'".AddSlashes(pg_result($resaco,$conresaco,'k199_saldofinalextrato'))."','$this->k199_saldofinalextrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
				if(isset($GLOBALS["HTTP_POST_VARS"]["k199_periodofinal"]) || $this->k199_periodofinal != "")
				$resac = db_query("insert into db_acount values($acount,2010209,2009341,'".AddSlashes(pg_result($resaco,$conresaco,'k199_periodofinal'))."','$this->k199_periodofinal',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
				if(isset($GLOBALS["HTTP_POST_VARS"]["k199_codconta"]) || $this->k199_codconta != "")
				$resac = db_query("insert into db_acount values($acount,2010209,2009339,'".AddSlashes(pg_result($resaco,$conresaco,'k199_codconta'))."','$this->k199_codconta',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
				if(isset($GLOBALS["HTTP_POST_VARS"]["k199_sequencial"]) || $this->k199_sequencial != "")
				$resac = db_query("insert into db_acount values($acount,2010209,2009344,'".AddSlashes(pg_result($resaco,$conresaco,'k199_sequencial'))."','$this->k199_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
				if(isset($GLOBALS["HTTP_POST_VARS"]["k199_periodoini"]) || $this->k199_periodoini != "")
				$resac = db_query("insert into db_acount values($acount,2010209,2009342,'".AddSlashes(pg_result($resaco,$conresaco,'k199_periodoini'))."','$this->k199_periodoini',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
			}
		}
		$result = db_query($sql);
		if($result==false){
			$this->erro_banco = str_replace("\n","",@pg_last_error());
			$this->erro_sql   = " nao Alterado. Alteracao Abortada.\\n";
			$this->erro_sql .= "Valores : ".$this->k199_sequencial;
			$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
			$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
			$this->erro_status = "0";
			$this->numrows_alterar = 0;
			return false;
		}else{
			if(pg_affected_rows($result)==0){
				$this->erro_banco = "";
				$this->erro_sql = " nao foi Alterado. Alteracao Executada.\\n";
				$this->erro_sql .= "Valores : ".$this->k199_sequencial;
				$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
				$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
				$this->erro_status = "1";
				$this->numrows_alterar = 0;
				return true;
			}else{
				$this->erro_banco = "";
				$this->erro_sql = "Alteração efetuada com Sucesso\\n";
				$this->erro_sql .= "Valores : ".$this->k199_sequencial;
				$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
				$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
				$this->erro_status = "1";
				$this->numrows_alterar = pg_affected_rows($result);
				return true;
			}
		}
	}
	// funcao para exclusao
	function excluir ($k199_sequencial=null,$dbwhere=null) {
		if($dbwhere==null || $dbwhere==""){
			$resaco = $this->sql_record($this->sql_query_file($k199_sequencial));
		}else{
			$resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
		}
		if(($resaco!=false)||($this->numrows!=0)){
			for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
				$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
				$acount = pg_result($resac,0,0);
				$resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
				$resac = db_query("insert into db_acountkey values($acount,1009244,'$k199_sequencial','E')");
				$resac = db_query("insert into db_acount values($acount,2010209,2009343,'','".AddSlashes(pg_result($resaco,$iresaco,'k199_saldofinalextrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
				$resac = db_query("insert into db_acount values($acount,2010209,2009341,'','".AddSlashes(pg_result($resaco,$iresaco,'k199_periodofinal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
				$resac = db_query("insert into db_acount values($acount,2010209,2009339,'','".AddSlashes(pg_result($resaco,$iresaco,'k199_codconta'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
				$resac = db_query("insert into db_acount values($acount,2010209,2009344,'','".AddSlashes(pg_result($resaco,$iresaco,'k199_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
				$resac = db_query("insert into db_acount values($acount,2010209,2009342,'','".AddSlashes(pg_result($resaco,$iresaco,'k199_periodoini'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
			}
		}
		 
		/*
		 * Verificando se o sequencial nao esta zerado, para logo após verificar as tabelas filhas existem dados pertinentes a serem excluídos, de acordo com o cod sequencial
		 */
		if($k199_sequencial!="")
		{
			$sqlpendcaixa=" delete from concmanupendecaixa where k201_conciliacao=$k199_sequencial";
				
			$result= db_query($sqlpendcaixa);
			if($result==false)
			{
				$this->erro_sql   = " nao Excluído. Exclusão Abortada.\\n";
				return false;
			}

			$sqlpendextrato=" delete from concmanupendeextrato where k200_conciliacao=$k199_sequencial";
				
			$result= db_query($sqlpendextrato);
			if($result==false)
			{
				$this->erro_sql   = " nao Excluído. Exclusão Abortada.\\n";
				return false;
			}
		}
		 
		 
		$sql = " delete from conciliacao
                    where ";
		$sql2 = "";
		if($dbwhere==null || $dbwhere ==""){
			if($k199_sequencial != ""){
				if($sql2!=""){
					$sql2 .= " and ";
				}
				$sql2 .= " k199_sequencial = $k199_sequencial ";
			}
		}else{
			$sql2 = $dbwhere;
		}
		$result = db_query($sql.$sql2);
		if($result==false){
			$this->erro_banco = str_replace("\n","",@pg_last_error());
			$this->erro_sql   = " nao Excluído. Exclusão Abortada.\\n";
			$this->erro_sql .= "Valores : ".$k199_sequencial;
			$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
			$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
			$this->erro_status = "0";
			$this->numrows_excluir = 0;
			return false;
		}else{
			if(pg_affected_rows($result)==0){
				$this->erro_banco = "";
				$this->erro_sql = " nao Encontrado. Exclusão não Efetuada.\\n";
				$this->erro_sql .= "Valores : ".$k199_sequencial;
				$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
				$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
				$this->erro_status = "1";
				$this->numrows_excluir = 0;
				return true;
			}else{
				$this->erro_banco = "";
				$this->erro_sql = "Exclusão efetuada com Sucesso\\n";
				$this->erro_sql .= "Valores : ".$k199_sequencial;
				$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
				$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
				$this->erro_status = "1";
				$this->numrows_excluir = pg_affected_rows($result);
				return true;
			}
		}
	}
	// funcao do recordset
	function sql_record($sql) {
		$result = db_query($sql);
		if($result==false){
			$this->numrows    = 0;
			$this->erro_banco = str_replace("\n","",@pg_last_error());
			$this->erro_sql   = "Erro ao selecionar os registros.";
			$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
			$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
			$this->erro_status = "0";
			return false;
		}
		$this->numrows = pg_numrows($result);
		if($this->numrows==0){
			$this->erro_banco = "";
			$this->erro_sql   = "Record Vazio na Tabela:conciliacao";
			$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
			$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
			$this->erro_status = "0";
			return false;
		}
		return $result;
	}
	// funcao do sql
	function sql_query ( $k199_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
		$sql = "select ";
		if($campos != "*" ){
			$campos_sql = explode("#",$campos);
			$virgula = "";
			for($i=0;$i<sizeof($campos_sql);$i++){
				$sql .= $virgula.$campos_sql[$i];
				$virgula = ",";
			}
		}else{
			$sql .= $campos;
		}
		$sql .= " from conciliacao ";
		$sql .= "      inner join contabancaria  on  contabancaria.db83_sequencial = conciliacao.k199_codconta";
		$sql .= "      inner join bancoagencia  on  bancoagencia.db89_sequencial = contabancaria.db83_bancoagencia";
		$sql2 = "";
		if($dbwhere==""){
			if($k199_sequencial!=null ){
				$sql2 .= " where conciliacao.k199_sequencial = $k199_sequencial ";
			}
		}else if($dbwhere != ""){
			$sql2 = " where $dbwhere";
		}
		$sql .= $sql2;
		if($ordem != null ){
			$sql .= " order by ";
			$campos_sql = explode("#",$ordem);
			$virgula = "";
			for($i=0;$i<sizeof($campos_sql);$i++){
				$sql .= $virgula.$campos_sql[$i];
				$virgula = ",";
			}
		}// echo $sql;exit;
		return $sql;
	}
	// funcao do sql
	function sql_query_file ( $k199_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
		$sql = "select ";
		if($campos != "*" ){
			$campos_sql = explode("#",$campos);
			$virgula = "";
			for($i=0;$i<sizeof($campos_sql);$i++){
				$sql .= $virgula.$campos_sql[$i];
				$virgula = ",";
			}
		}else{
			$sql .= $campos;
		}
		$sql .= " from conciliacao ";
		$sql2 = "";
		if($dbwhere==""){
			if($k199_sequencial!=null ){
				$sql2 .= " where conciliacao.k199_sequencial = $k199_sequencial ";
			}
		}else if($dbwhere != ""){
			$sql2 = " where $dbwhere";
		}
		$sql .= $sql2;
		if($ordem != null ){
			$sql .= " order by ";
			$campos_sql = explode("#",$ordem);
			$virgula = "";
			for($i=0;$i<sizeof($campos_sql);$i++){
				$sql .= $virgula.$campos_sql[$i];
				$virgula = ",";
			}
		}
		return $sql;
	}
}
?>
