<?
	//MODULO: sicom
	//CLASSE DA ENTIDADE balancete282021
	class cl_balancete282021
	{
		// cria variaveis de erro
		var $rotulo = null;
		var $query_sql = null;
		var $numrows = 0;
		var $numrows_incluir = 0;
		var $numrows_alterar = 0;
		var $numrows_excluir = 0;
		var $erro_status = null;
		var $erro_sql = null;
		var $erro_banco = null;
		var $erro_msg = null;
		var $erro_campo = null;
		var $pagina_retorno = null;
		// cria variaveis do arquivo
		var $si198_sequencial = 0;
		var $si198_tiporegistro = 0;
		var $si198_contacontabil = 0;
		var $si198_codfundo = null;
		var $si198_ctb = 0;
		var $si198_codctb = 0;
		var $si198_codfonterecursos = 0;
		var $si198_saldoinicialctbfonte = 0;
		var $si198_naturezasaldoinicialctbfonte = null;
		var $si198_totaldebitosctbfonte = 0;
		var $si198_totalcreditosctbfonte = 0;
		var $si198_saldofinalctbfonte = 0;
		var $si198_naturezasaldofinalctbfonte = null;
		var $si198_mes = 0;
		var $si198_instit = 0;
		var $si198_reg10 = null;
		// cria propriedade com as variaveis do arquivo
		var $campos = "
                 si198_sequencial = int8 = Sequencial
                 si198_tiporegistro = int8 = Tipo de registro
                 si198_contacontabil = int8 = Código da Conta Contábil
                 si198_codfundo = varchar(8) = Código identificador do Fundo
                 si198_codctb = int8 = Código identificador da conta
                 si198_codfontrecursos = int8 = Código da Fonte 
                 si198_saldoinicialctbfonte = float8 = Saldo no inicio do mes 
                 si198_naturezasaldoinicialctbfonte = varchar(1) = Natureza do saldo inicial 
                 si198_totaldebitosctbfonte = float8 = Total de débitos
                 si198_totalcreditosctbfonte = float8 = Total de créditos  
                 si198_saldofinalctbfonte = float8 = Saldo final no mês 
                 si198_naturezasaldofinalctbfonte = varchar(1) = Natureza do saldo final 
                 si198_mes = int8 = si198_mes 
                 si198_instit = int8 = si198_instit 
                 ";

		//funcao construtor da classe
		function cl_balancete282021()
		{
			//classes dos rotulos dos campos
			$this->rotulo = new rotulo("balancete282021");
			$this->pagina_retorno = basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
		}

		//funcao erro
		function erro($mostra, $retorna)
		{
			if (($this->erro_status == "0") || ($mostra == true && $this->erro_status != null)) {
				echo "<script>alert(\"" . $this->erro_msg . "\");</script>";
				if ($retorna == true) {
					echo "<script>location.href='" . $this->pagina_retorno . "'</script>";
				}
			}
		}

		// funcao para atualizar campos
		function atualizacampos($exclusao = false)
		{
			if ($exclusao == false) {
				$this->si198_sequencial = ($this->si198_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si198_sequencial"] : $this->si198_sequencial);
				$this->si198_tiporegistro = ($this->si198_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si198_tiporegistro"] : $this->si198_tiporegistro);
				$this->si198_contacontabil = ($this->si198_contacontabil == "" ? @$GLOBALS["HTTP_POST_VARS"]["si198_contacontabil"] : $this->si198_contacontabil);
				$this->si198_codfundo = ($this->si198_codfundo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si198_codfundo"] : $this->si198_codfundo);
				$this->si198_codctb = ($this->si198_codctb == "" ? @$GLOBALS["HTTP_POST_VARS"]["si198_codctb"] : $this->si198_codctb);
				$this->si198_codfontrecursos = ($this->si198_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si198_codfontrecursos"] : $this->si198_codfontrecursos);
				$this->si198_saldoinicialctbfonte = ($this->si198_saldoinicialctbfonte == "" ? @$GLOBALS["HTTP_POST_VARS"]["si198_saldoinicialctbfonte"] : $this->si198_saldoinicialctbfonte);
				$this->si198_naturezasaldoinicialctbfonte = ($this->si198_naturezasaldoinicialctbfonte == "" ? @$GLOBALS["HTTP_POST_VARS"]["si198_naturezasaldoinicialctbfonte"] : $this->si198_naturezasaldoinicialctbfonte);
				$this->si198_totaldebitosctbfonte = ($this->si198_totaldebitosctbfonte == "" ? @$GLOBALS["HTTP_POST_VARS"]["si198_totaldebitosctbfonte"] : $this->si198_totaldebitosctbfonte);
				$this->si198_totalcreditosctbfonte = ($this->si198_totalcreditosctbfonte == "" ? @$GLOBALS["HTTP_POST_VARS"]["si198_totalcreditosctbfonte"] : $this->si198_totalcreditosctbfonte);
				$this->si198_saldofinalctbfonte = ($this->si198_saldofinalctbfonte == "" ? @$GLOBALS["HTTP_POST_VARS"]["si198_saldofinalctbfonte"] : $this->si198_saldofinalctbfonte);
				$this->si198_naturezasaldofinalctbfonte = ($this->si198_naturezasaldofinalctbfonte == "" ? @$GLOBALS["HTTP_POST_VARS"]["si198_naturezasaldofinalctbfonte"] : $this->si198_naturezasaldofinalctbfonte);
				$this->si198_mes = ($this->si198_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si198_mes"] : $this->si198_mes);
				$this->si198_instit = ($this->si198_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si198_instit"] : $this->si198_instit);
			} else {
				$this->si198_sequencial = ($this->si198_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si198_sequencial"] : $this->si198_sequencial);
			}
		}

		// funcao para inclusao
		function incluir($si198_sequencial)
		{
			$this->atualizacampos();
			if ($this->si198_tiporegistro == null) {
				$this->erro_sql = " Campo si198_tiporegistro não informado.";
				$this->erro_campo = "si198_tiporegistro";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si198_contacontabil == null) {
				$this->erro_sql = " Campo si198_contacontabil não informado.";
				$this->erro_campo = "si198_contacontabil";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si198_tipodocumentoctbfonte == null) {
				$this->erro_sql = " Campo si198_tipodocumentoctbfonte não informado.";
				$this->erro_campo = "si198_tipodocumentoctbfonte";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si198_nrodocumentoctbfonte == null) {
				$this->erro_sql = " Campo si198_nrodocumentoctbfonte não informado.";
				$this->erro_campo = "si198_nrodocumentoctbfonte";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}

			if ($this->si198_atributosf == null) {
				$this->erro_sql = " Campo si198_atributosf não informado.";
				$this->erro_campo = "si198_atributosf";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}

			if ($this->si198_saldoinicialctbfonte == null) {
				$this->erro_sql = " Campo si198_saldoinicialctbfonte não informado.";
				$this->erro_campo = "si198_saldoinicialctbfonte";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si198_naturezasaldoinicialctbfonte == null) {
				$this->erro_sql = " Campo si198_naturezasaldoinicialctbfonte não informado.";
				$this->erro_campo = "si198_naturezasaldoinicialctbfonte";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si198_totaldebitosctbfonte == null) {
				$this->erro_sql = " Campo si198_totaldebitosctbfonte não informado.";
				$this->erro_campo = "si198_totaldebitosctbfonte";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si198_totalcreditosctbfonte == null) {
				$this->erro_sql = " Campo si198_totalcreditosctbfonte não informado.";
				$this->erro_campo = "si198_totalcreditosctbfonte";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si198_saldofinalctbfonte == null) {
				$this->erro_sql = " Campo si198_saldofinalctbfonte não informado.";
				$this->erro_campo = "si198_saldofinalctbfonte";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si198_naturezasaldofinalctbfonte == null) {
				$this->erro_sql = " Campo si198_naturezasaldofinalctbfonte não informado.";
				$this->erro_campo = "si198_naturezasaldofinalctbfonte";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si198_mes == null) {
				$this->erro_sql = " Campo si198_mes não informado.";
				$this->erro_campo = "si198_mes";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si198_instit == null) {
				$this->erro_sql = " Campo si198_instit não informado.";
				$this->erro_campo = "si198_instit";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}

			if ($si198_sequencial == "" || $si198_sequencial == null) {
				$result = db_query("select nextval('balancete282021_si198_sequencial_seq')");
				if ($result == false) {
					$this->erro_banco = str_replace("
", "", @pg_last_error());
					$this->erro_sql = "Verifique o cadastro da sequencia: balancete282021_si198_sequencial_seq do campo: si198_sequencial";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
				$this->si198_sequencial = pg_result($result, 0, 0);
			} else {
				$result = db_query("select last_value from balancete282021_si198_sequencial_seq");
				if (($result != false) && (pg_result($result, 0, 0) < $si198_sequencial)) {
					$this->erro_sql = " Campo si198_sequencial maior que último número da sequencia.";
					$this->erro_banco = "Sequencia menor que este número.";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				} else {
					$this->si198_sequencial = $si198_sequencial;
				}
			}
			if (($this->si198_sequencial == null) || ($this->si198_sequencial == "")) {
				$this->erro_sql = " Campo si198_sequencial nao declarado.";
				$this->erro_banco = "Chave Primaria zerada.";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			$sql = "insert into balancete282021(
                                       si198_sequencial 
                                      ,si198_tiporegistro 
                                      ,si198_contacontabil 
                                      ,si198_codfundo
                                      ,si198_codctb
                                      ,si198_codfontrecursos
                                      ,si198_saldoinicialctbfonte 
                                      ,si198_naturezasaldoinicialctbfonte 
                                      ,si198_totaldebitosctbfonte 
                                      ,si198_totalcreditosctbfonte 
                                      ,si198_saldofinalctbfonte 
                                      ,si198_naturezasaldofinalctbfonte 
                                      ,si198_mes 
                                      ,si198_instit
                                      ,si198_reg10
                       )
                values (
                                $this->si198_sequencial 
                               ,$this->si198_tiporegistro 
                               ,$this->si198_contacontabil 
                               ,'$this->si198_codfundo'
                               ,$this->si198_codctb
                               ,$this->si198_codfontrecursos
                               ,$this->si198_saldoinicialctbfonte 
                               ,'$this->si198_naturezasaldoinicialctbfonte' 
                               ,$this->si198_totaldebitosctbfonte 
                               ,$this->si198_totalcreditosctbfonte 
                               ,$this->si198_saldofinalctbfonte 
                               ,'$this->si198_naturezasaldofinalctbfonte' 
                               ,$this->si198_mes 
                               ,$this->si198_instit
                               ,$this->si198_reg10
                      )";
			$result = db_query($sql);
			if ($result == false) {
				$this->erro_banco = str_replace("
", "", @pg_last_error());
				if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
					$this->erro_sql = "balancete282021 ($this->si198_sequencial) nao Incluído. Inclusao Abortada.";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_banco = "balancete282021 já Cadastrado";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				} else {
					$this->erro_sql = "balancete282021 ($this->si198_sequencial) nao Incluído. Inclusao Abortada.";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				}
				$this->erro_status = "0";
				$this->numrows_incluir = 0;

				return false;
			}
			$this->erro_banco = "";
			$this->erro_sql = "Inclusao efetuada com Sucesso\n";
			$this->erro_sql .= "Valores : " . $this->si198_sequencial;
			$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
			$this->erro_status = "1";
			$this->numrows_incluir = pg_affected_rows($result);
			$lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
			if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {

				$resaco = $this->sql_record($this->sql_query_file($this->si198_sequencial));
				if (($resaco != false) || ($this->numrows != 0)) {

					/*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
					$acount = pg_result($resac,0,0);
					$resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
					$resac = db_query("insert into db_acountkey values($acount,2011784,'$this->si198_sequencial','I')");
					$resac = db_query("insert into db_acount values($acount,1010198,2011784,'','".AddSlashes(pg_result($resaco,0,'si198_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
					$resac = db_query("insert into db_acount values($acount,1010198,2011785,'','".AddSlashes(pg_result($resaco,0,'si198_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
					$resac = db_query("insert into db_acount values($acount,1010198,2011786,'','".AddSlashes(pg_result($resaco,0,'si198_contacontabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
					$resac = db_query("insert into db_acount values($acount,1010198,2011787,'','".AddSlashes(pg_result($resaco,0,'si198_atributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
					$resac = db_query("insert into db_acount values($acount,1010198,2011788,'','".AddSlashes(pg_result($resaco,0,'si198_saldoinicialctbfonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
					$resac = db_query("insert into db_acount values($acount,1010198,2011789,'','".AddSlashes(pg_result($resaco,0,'si198_naturezasaldoinicialctbfonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
					$resac = db_query("insert into db_acount values($acount,1010198,2011790,'','".AddSlashes(pg_result($resaco,0,'si198_totaldebitosctbfonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
					$resac = db_query("insert into db_acount values($acount,1010198,2011791,'','".AddSlashes(pg_result($resaco,0,'si198_totalcreditosctbfonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
					$resac = db_query("insert into db_acount values($acount,1010198,2011792,'','".AddSlashes(pg_result($resaco,0,'si198_saldofinalctbfonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
					$resac = db_query("insert into db_acount values($acount,1010198,2011793,'','".AddSlashes(pg_result($resaco,0,'si198_naturezasaldofinalctbfonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
					$resac = db_query("insert into db_acount values($acount,1010198,2011794,'','".AddSlashes(pg_result($resaco,0,'si198_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
					$resac = db_query("insert into db_acount values($acount,1010198,2011795,'','".AddSlashes(pg_result($resaco,0,'si198_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
				}
			}

			return true;
		}

		// funcao para alteracao
		function alterar($si198_sequencial = null)
		{
			$this->atualizacampos();
			$sql = " update balancete282021 set ";
			$virgula = "";
			if (trim($this->si198_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si198_sequencial"])) {
				$sql .= $virgula . " si198_sequencial = $this->si198_sequencial ";
				$virgula = ",";
				if (trim($this->si198_sequencial) == null) {
					$this->erro_sql = " Campo si198_sequencial não informado.";
					$this->erro_campo = "si198_sequencial";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si198_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si198_tiporegistro"])) {
				$sql .= $virgula . " si198_tiporegistro = $this->si198_tiporegistro ";
				$virgula = ",";
				if (trim($this->si198_tiporegistro) == null) {
					$this->erro_sql = " Campo si198_tiporegistro não informado.";
					$this->erro_campo = "si198_tiporegistro";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si198_contacontabil) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si198_contacontabil"])) {
				$sql .= $virgula . " si198_contacontabil = $this->si198_contacontabil ";
				$virgula = ",";
				if (trim($this->si198_contacontabil) == null) {
					$this->erro_sql = " Campo si198_contacontabil não informado.";
					$this->erro_campo = "si198_contacontabil";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si198_codfundo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si198_codfundo"])) {
				$sql .= $virgula . " si198_codfundo = '$this->si198_codfundo' ";
				$virgula = ",";
				if (trim($this->si198_codfundo) == null) {
					$this->erro_sql = " Campo si198_codfundo não informado.";
					$this->erro_campo = "si198_codfundo";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}

			if (trim($this->si198_codctb) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si198_codctb"])) {
				$sql .= $virgula . " si198_codctb = '$this->si198_codctb' ";
				$virgula = ",";
				if (trim($this->si198_codctb) == null) {
					$this->erro_sql = " Campo si198_codctb não informado.";
					$this->erro_campo = "si198_codctb";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}

			if (trim($this->si198_saldoinicialctbfonte) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si198_saldoinicialctbfonte"])) {
				$sql .= $virgula . " si198_saldoinicialctbfonte = $this->si198_saldoinicialctbfonte ";
				$virgula = ",";
				if (trim($this->si198_saldoinicialctbfonte) == null) {
					$this->erro_sql = " Campo si198_saldoinicialctbfonte não informado.";
					$this->erro_campo = "si198_saldoinicialctbfonte";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si198_naturezasaldoinicialctbfonte) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si198_naturezasaldoinicialctbfonte"])) {
				$sql .= $virgula . " si198_naturezasaldoinicialctbfonte = '$this->si198_naturezasaldoinicialctbfonte' ";
				$virgula = ",";
				if (trim($this->si198_naturezasaldoinicialctbfonte) == null) {
					$this->erro_sql = " Campo si198_naturezasaldoinicialctbfonte não informado.";
					$this->erro_campo = "si198_naturezasaldoinicialctbfonte";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si198_totaldebitosctbfonte) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si198_totaldebitosctbfonte"])) {
				$sql .= $virgula . " si198_totaldebitosctbfonte = $this->si198_totaldebitosctbfonte ";
				$virgula = ",";
				if (trim($this->si198_totaldebitosctbfonte) == null) {
					$this->erro_sql = " Campo si198_totaldebitosctbfonte não informado.";
					$this->erro_campo = "si198_totaldebitosctbfonte";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si198_totalcreditosctbfonte) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si198_totalcreditosctbfonte"])) {
				$sql .= $virgula . " si198_totalcreditosctbfonte = $this->si198_totalcreditosctbfonte ";
				$virgula = ",";
				if (trim($this->si198_totalcreditosctbfonte) == null) {
					$this->erro_sql = " Campo si198_totalcreditosctbfonte não informado.";
					$this->erro_campo = "si198_totalcreditosctbfonte";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si198_saldofinalctbfonte) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si198_saldofinalctbfonte"])) {
				$sql .= $virgula . " si198_saldofinalctbfonte = $this->si198_saldofinalctbfonte ";
				$virgula = ",";
				if (trim($this->si198_saldofinalctbfonte) == null) {
					$this->erro_sql = " Campo si198_saldofinalctbfonte não informado.";
					$this->erro_campo = "si198_saldofinalctbfonte";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si198_naturezasaldofinalctbfonte) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si198_naturezasaldofinalctbfonte"])) {
				$sql .= $virgula . " si198_naturezasaldofinalctbfonte = '$this->si198_naturezasaldofinalctbfonte' ";
				$virgula = ",";
				if (trim($this->si198_naturezasaldofinalctbfonte) == null) {
					$this->erro_sql = " Campo si198_naturezasaldofinalctbfonte não informado.";
					$this->erro_campo = "si198_naturezasaldofinalctbfonte";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si198_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si198_mes"])) {
				$sql .= $virgula . " si198_mes = $this->si198_mes ";
				$virgula = ",";
				if (trim($this->si198_mes) == null) {
					$this->erro_sql = " Campo si198_mes não informado.";
					$this->erro_campo = "si198_mes";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si198_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si198_instit"])) {
				$sql .= $virgula . " si198_instit = $this->si198_instit ";
				$virgula = ",";
				if (trim($this->si198_instit) == null) {
					$this->erro_sql = " Campo si198_instit não informado.";
					$this->erro_campo = "si198_instit";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			$sql .= " where ";
			if ($si198_sequencial != null) {
				$sql .= " si198_sequencial = $this->si198_sequencial";
			}
			$lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
			if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {

				$resaco = $this->sql_record($this->sql_query_file($this->si198_sequencial));
				if ($this->numrows > 0) {

					for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {

						/*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
						$acount = pg_result($resac,0,0);
						$resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
						$resac = db_query("insert into db_acountkey values($acount,2011784,'$this->si198_sequencial','A')");
						if(isset($GLOBALS["HTTP_POST_VARS"]["si198_sequencial"]) || $this->si198_sequencial != "")
						  $resac = db_query("insert into db_acount values($acount,1010198,2011784,'".AddSlashes(pg_result($resaco,$conresaco,'si198_sequencial'))."','$this->si198_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						if(isset($GLOBALS["HTTP_POST_VARS"]["si198_tiporegistro"]) || $this->si198_tiporegistro != "")
						  $resac = db_query("insert into db_acount values($acount,1010198,2011785,'".AddSlashes(pg_result($resaco,$conresaco,'si198_tiporegistro'))."','$this->si198_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						if(isset($GLOBALS["HTTP_POST_VARS"]["si198_contacontabil"]) || $this->si198_contacontabil != "")
						  $resac = db_query("insert into db_acount values($acount,1010198,2011786,'".AddSlashes(pg_result($resaco,$conresaco,'si198_contacontabil'))."','$this->si198_contacontabil',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						if(isset($GLOBALS["HTTP_POST_VARS"]["si198_atributosf"]) || $this->si198_atributosf != "")
						  $resac = db_query("insert into db_acount values($acount,1010198,2011787,'".AddSlashes(pg_result($resaco,$conresaco,'si198_atributosf'))."','$this->si198_atributosf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						if(isset($GLOBALS["HTTP_POST_VARS"]["si198_saldoinicialctbfonte"]) || $this->si198_saldoinicialctbfonte != "")
						  $resac = db_query("insert into db_acount values($acount,1010198,2011788,'".AddSlashes(pg_result($resaco,$conresaco,'si198_saldoinicialctbfonte'))."','$this->si198_saldoinicialctbfonte',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						if(isset($GLOBALS["HTTP_POST_VARS"]["si198_naturezasaldoinicialctbfonte"]) || $this->si198_naturezasaldoinicialctbfonte != "")
						  $resac = db_query("insert into db_acount values($acount,1010198,2011789,'".AddSlashes(pg_result($resaco,$conresaco,'si198_naturezasaldoinicialctbfonte'))."','$this->si198_naturezasaldoinicialctbfonte',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						if(isset($GLOBALS["HTTP_POST_VARS"]["si198_totaldebitosctbfonte"]) || $this->si198_totaldebitosctbfonte != "")
						  $resac = db_query("insert into db_acount values($acount,1010198,2011790,'".AddSlashes(pg_result($resaco,$conresaco,'si198_totaldebitosctbfonte'))."','$this->si198_totaldebitosctbfonte',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						if(isset($GLOBALS["HTTP_POST_VARS"]["si198_totalcreditosctbfonte"]) || $this->si198_totalcreditosctbfonte != "")
						  $resac = db_query("insert into db_acount values($acount,1010198,2011791,'".AddSlashes(pg_result($resaco,$conresaco,'si198_totalcreditosctbfonte'))."','$this->si198_totalcreditosctbfonte',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						if(isset($GLOBALS["HTTP_POST_VARS"]["si198_saldofinalctbfonte"]) || $this->si198_saldofinalctbfonte != "")
						  $resac = db_query("insert into db_acount values($acount,1010198,2011792,'".AddSlashes(pg_result($resaco,$conresaco,'si198_saldofinalctbfonte'))."','$this->si198_saldofinalctbfonte',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						if(isset($GLOBALS["HTTP_POST_VARS"]["si198_naturezasaldofinalctbfonte"]) || $this->si198_naturezasaldofinalctbfonte != "")
						  $resac = db_query("insert into db_acount values($acount,1010198,2011793,'".AddSlashes(pg_result($resaco,$conresaco,'si198_naturezasaldofinalctbfonte'))."','$this->si198_naturezasaldofinalctbfonte',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						if(isset($GLOBALS["HTTP_POST_VARS"]["si198_mes"]) || $this->si198_mes != "")
						  $resac = db_query("insert into db_acount values($acount,1010198,2011794,'".AddSlashes(pg_result($resaco,$conresaco,'si198_mes'))."','$this->si198_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						if(isset($GLOBALS["HTTP_POST_VARS"]["si198_instit"]) || $this->si198_instit != "")
						  $resac = db_query("insert into db_acount values($acount,1010198,2011795,'".AddSlashes(pg_result($resaco,$conresaco,'si198_instit'))."','$this->si198_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
					}
				}
			}
			$result = db_query($sql);
			if ($result == false) {
				$this->erro_banco = str_replace("
", "", @pg_last_error());
				$this->erro_sql = "balancete282021 nao Alterado. Alteracao Abortada.\n";
				$this->erro_sql .= "Valores : " . $this->si198_sequencial;
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";
				$this->numrows_alterar = 0;

				return false;
			} else {
				if (pg_affected_rows($result) == 0) {
					$this->erro_banco = "";
					$this->erro_sql = "balancete282021 nao foi Alterado. Alteracao Executada.\n";
					$this->erro_sql .= "Valores : " . $this->si198_sequencial;
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "1";
					$this->numrows_alterar = 0;

					return true;
				} else {
					$this->erro_banco = "";
					$this->erro_sql = "Alteração efetuada com Sucesso\n";
					$this->erro_sql .= "Valores : " . $this->si198_sequencial;
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "1";
					$this->numrows_alterar = pg_affected_rows($result);

					return true;
				}
			}
		}

		// funcao para exclusao
		function excluir($si198_sequencial = null, $dbwhere = null)
		{

			$lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
			if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {

				if ($dbwhere == null || $dbwhere == "") {

					$resaco = $this->sql_record($this->sql_query_file($si198_sequencial));
				} else {
					$resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
				}
				if (($resaco != false) || ($this->numrows != 0)) {

					for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

						/*$resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
						$acount = pg_result($resac,0,0);
						$resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
						$resac  = db_query("insert into db_acountkey values($acount,2011784,'$si198_sequencial','E')");
						$resac  = db_query("insert into db_acount values($acount,1010198,2011784,'','".AddSlashes(pg_result($resaco,$iresaco,'si198_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						$resac  = db_query("insert into db_acount values($acount,1010198,2011785,'','".AddSlashes(pg_result($resaco,$iresaco,'si198_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						$resac  = db_query("insert into db_acount values($acount,1010198,2011786,'','".AddSlashes(pg_result($resaco,$iresaco,'si198_contacontabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						$resac  = db_query("insert into db_acount values($acount,1010198,2011787,'','".AddSlashes(pg_result($resaco,$iresaco,'si198_atributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						$resac  = db_query("insert into db_acount values($acount,1010198,2011788,'','".AddSlashes(pg_result($resaco,$iresaco,'si198_saldoinicialctbfonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						$resac  = db_query("insert into db_acount values($acount,1010198,2011789,'','".AddSlashes(pg_result($resaco,$iresaco,'si198_naturezasaldoinicialctbfonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						$resac  = db_query("insert into db_acount values($acount,1010198,2011790,'','".AddSlashes(pg_result($resaco,$iresaco,'si198_totaldebitosctbfonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						$resac  = db_query("insert into db_acount values($acount,1010198,2011791,'','".AddSlashes(pg_result($resaco,$iresaco,'si198_totalcreditosctbfonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						$resac  = db_query("insert into db_acount values($acount,1010198,2011792,'','".AddSlashes(pg_result($resaco,$iresaco,'si198_saldofinalctbfonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						$resac  = db_query("insert into db_acount values($acount,1010198,2011793,'','".AddSlashes(pg_result($resaco,$iresaco,'si198_naturezasaldofinalctbfonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						$resac  = db_query("insert into db_acount values($acount,1010198,2011794,'','".AddSlashes(pg_result($resaco,$iresaco,'si198_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						$resac  = db_query("insert into db_acount values($acount,1010198,2011795,'','".AddSlashes(pg_result($resaco,$iresaco,'si198_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
					}
				}
			}
			$sql = " delete from balancete282021
                    where ";
			$sql2 = "";
			if ($dbwhere == null || $dbwhere == "") {
				if ($si198_sequencial != "") {
					if ($sql2 != "") {
						$sql2 .= " and ";
					}
					$sql2 .= " si198_sequencial = $si198_sequencial ";
				}
			} else {
				$sql2 = $dbwhere;
			}
			$result = db_query($sql . $sql2);
			if ($result == false) {
				$this->erro_banco = str_replace("
", "", @pg_last_error());
				$this->erro_sql = "balancete282021 nao Excluído. Exclusão Abortada.\n";
				$this->erro_sql .= "Valores : " . $si198_sequencial;
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";
				$this->numrows_excluir = 0;

				return false;
			} else {
				if (pg_affected_rows($result) == 0) {
					$this->erro_banco = "";
					$this->erro_sql = "balancete282021 nao Encontrado. Exclusão não Efetuada.\n";
					$this->erro_sql .= "Valores : " . $si198_sequencial;
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "1";
					$this->numrows_excluir = 0;

					return true;
				} else {
					$this->erro_banco = "";
					$this->erro_sql = "Exclusão efetuada com Sucesso\n";
					$this->erro_sql .= "Valores : " . $si198_sequencial;
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "1";
					$this->numrows_excluir = pg_affected_rows($result);

					return true;
				}
			}
		}

		// funcao do recordset
		function sql_record($sql)
		{
			$result = db_query($sql);
			if ($result == false) {
				$this->numrows = 0;
				$this->erro_banco = str_replace("
", "", @pg_last_error());
				$this->erro_sql = "Erro ao selecionar os registros.";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			$this->numrows = pg_numrows($result);
			if ($this->numrows == 0) {
				$this->erro_banco = "";
				$this->erro_sql = "Record Vazio na Tabela:balancete282021";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}

			return $result;
		}

		// funcao do sql
		function sql_query($si198_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
		{
			$sql = "select ";
			if ($campos != "*") {
				$campos_sql = explode("#", $campos);
				$virgula = "";
				for ($i = 0; $i < sizeof($campos_sql); $i++) {
					$sql .= $virgula . $campos_sql[$i];
					$virgula = ",";
				}
			} else {
				$sql .= $campos;
			}
			$sql .= " from balancete282021 ";
			$sql2 = "";
			if ($dbwhere == "") {
				if ($si198_sequencial != null) {
					$sql2 .= " where balancete282021.si198_sequencial = $si198_sequencial ";
				}
			} else {
				if ($dbwhere != "") {
					$sql2 = " where $dbwhere";
				}
			}
			$sql .= $sql2;
			if ($ordem != null) {
				$sql .= " order by ";
				$campos_sql = explode("#", $ordem);
				$virgula = "";
				for ($i = 0; $i < sizeof($campos_sql); $i++) {
					$sql .= $virgula . $campos_sql[$i];
					$virgula = ",";
				}
			}

			return $sql;
		}

		// funcao do sql
		function sql_query_file($si198_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
		{
			$sql = "select ";
			if ($campos != "*") {
				$campos_sql = explode("#", $campos);
				$virgula = "";
				for ($i = 0; $i < sizeof($campos_sql); $i++) {
					$sql .= $virgula . $campos_sql[$i];
					$virgula = ",";
				}
			} else {
				$sql .= $campos;
			}
			$sql .= " from balancete282021 ";
			$sql2 = "";
			if ($dbwhere == "") {
				if ($si198_sequencial != null) {
					$sql2 .= " where balancete282021.si198_sequencial = $si198_sequencial ";
				}
			} else {
				if ($dbwhere != "") {
					$sql2 = " where $dbwhere";
				}
			}
			$sql .= $sql2;
			if ($ordem != null) {
				$sql .= " order by ";
				$campos_sql = explode("#", $ordem);
				$virgula = "";
				for ($i = 0; $i < sizeof($campos_sql); $i++) {
					$sql .= $virgula . $campos_sql[$i];
					$virgula = ",";
				}
			}

			return $sql;
		}
	}

?>
