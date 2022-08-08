<?
	//MODULO: sicom
	//CLASSE DA ENTIDADE balancete272019
	class cl_balancete272019
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
		var $si197_sequencial = 0;
		var $si197_tiporegistro = 0;
		var $si197_contacontabil = 0;
		var $si197_codfundo = null;
		var $si197_codorgao = null;
		var $si197_codunidadesub = null;
		var $si197_codfontrecursos = 0;
		var $si197_atributosf = null;
		var $si197_saldoinicialoufontesf = 0;
		var $si197_naturezasaldoinicialoufontesf = null;
		var $si197_totaldebitosoufontesf = 0;
		var $si197_totalcreditosoufontesf = 0;
		var $si197_saldofinaloufontesf = 0;
		var $si197_naturezasaldofinaloufontesf = null;
		var $si197_mes = 0;
		var $si197_instit = 0;
		var $si197_reg10 = null;
		// cria propriedade com as variaveis do arquivo
		var $campos = "
                 si197_sequencial = int8 = si197_sequencial 
                 si197_tiporegistro = int8 = si197_tiporegistro 
                 si197_contacontabil = int8 = si197_contacontabil 
                 si197_codfundo = varchar(8) = si197_codfundo
                 si197_codorgao = varchar(2) = si197_codorgao
                 si197_codunidadesub = varchar(8) = si197_codunidadesub
                 si197_codfontrecursos = int8 = si197_codfontrecursos 
                 si197_atributosf = varchar(1) = si197_atributosf
                 si197_saldoinicialoufontesf = float8 = si197_saldoinicialoufontesf 
                 si197_naturezasaldoinicialoufontesf = varchar(1) = si197_naturezasaldoinicialoufontesf 
                 si197_totaldebitosoufontesf = float8 = si197_totaldebitosoufontesf 
                 si197_totalcreditosoufontesf = float8 = si197_totalcreditosoufontesf 
                 si197_saldofinaloufontesf = float8 = si197_saldofinaloufontesf 
                 si197_naturezasaldofinaloufontesf = varchar(1) = si197_naturezasaldofinaloufontesf 
                 si197_mes = int8 = si197_mes 
                 si197_instit = int8 = si197_instit 
                 ";

		//funcao construtor da classe
		function cl_balancete272019()
		{
			//classes dos rotulos dos campos
			$this->rotulo = new rotulo("balancete272019");
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
				$this->si197_sequencial = ($this->si197_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si197_sequencial"] : $this->si197_sequencial);
				$this->si197_tiporegistro = ($this->si197_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si197_tiporegistro"] : $this->si197_tiporegistro);
				$this->si197_contacontabil = ($this->si197_contacontabil == "" ? @$GLOBALS["HTTP_POST_VARS"]["si197_contacontabil"] : $this->si197_contacontabil);
				$this->si197_codfundo = ($this->si197_codfundo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si197_codfundo"] : $this->si197_codfundo);
				$this->si197_codorgao = ($this->si197_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si197_codorgao"] : $this->si197_codorgao);
				$this->si197_codunidadesub = ($this->si197_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si197_codunidadesub"] : $this->si197_codunidadesub);
				$this->si197_codfontrecursos = ($this->si197_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si197_codfontrecursos"] : $this->si197_codfontrecursos);
				$this->si197_atributosf = ($this->si197_atributosf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si197_atributosf"] : $this->si197_atributosf);
				$this->si197_saldoinicialoufontesf = ($this->si197_saldoinicialoufontesf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si197_saldoinicialoufontesf"] : $this->si197_saldoinicialoufontesf);
				$this->si197_naturezasaldoinicialoufontesf = ($this->si197_naturezasaldoinicialoufontesf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si197_naturezasaldoinicialoufontesf"] : $this->si197_naturezasaldoinicialoufontesf);
				$this->si197_totaldebitosoufontesf = ($this->si197_totaldebitosoufontesf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si197_totaldebitosoufontesf"] : $this->si197_totaldebitosoufontesf);
				$this->si197_totalcreditosoufontesf = ($this->si197_totalcreditosoufontesf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si197_totalcreditosoufontesf"] : $this->si197_totalcreditosoufontesf);
				$this->si197_saldofinaloufontesf = ($this->si197_saldofinaloufontesf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si197_saldofinaloufontesf"] : $this->si197_saldofinaloufontesf);
				$this->si197_naturezasaldofinaloufontesf = ($this->si197_naturezasaldofinaloufontesf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si197_naturezasaldofinaloufontesf"] : $this->si197_naturezasaldofinaloufontesf);
				$this->si197_mes = ($this->si197_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si197_mes"] : $this->si197_mes);
				$this->si197_instit = ($this->si197_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si197_instit"] : $this->si197_instit);
			} else {
				$this->si197_sequencial = ($this->si197_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si197_sequencial"] : $this->si197_sequencial);
			}
		}

		// funcao para inclusao
		function incluir($si197_sequencial)
		{
			$this->atualizacampos();
			if ($this->si197_tiporegistro == null) {
				$this->erro_sql = " Campo si197_tiporegistro não informado.";
				$this->erro_campo = "si197_tiporegistro";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si197_contacontabil == null) {
				$this->erro_sql = " Campo si197_contacontabil não informado.";
				$this->erro_campo = "si197_contacontabil";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si197_tipodocumentooufontesf == null) {
				$this->erro_sql = " Campo si197_tipodocumentooufontesf não informado.";
				$this->erro_campo = "si197_tipodocumentooufontesf";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si197_nrodocumentooufontesf == null) {
				$this->erro_sql = " Campo si197_nrodocumentooufontesf não informado.";
				$this->erro_campo = "si197_nrodocumentooufontesf";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}

			if ($this->si197_atributosf == null) {
				$this->erro_sql = " Campo si197_atributosf não informado.";
				$this->erro_campo = "si197_atributosf";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}

			if ($this->si197_saldoinicialoufontesf == null) {
				$this->erro_sql = " Campo si197_saldoinicialoufontesf não informado.";
				$this->erro_campo = "si197_saldoinicialoufontesf";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si197_naturezasaldoinicialoufontesf == null) {
				$this->erro_sql = " Campo si197_naturezasaldoinicialoufontesf não informado.";
				$this->erro_campo = "si197_naturezasaldoinicialoufontesf";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si197_totaldebitosoufontesf == null) {
				$this->erro_sql = " Campo si197_totaldebitosoufontesf não informado.";
				$this->erro_campo = "si197_totaldebitosoufontesf";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si197_totalcreditosoufontesf == null) {
				$this->erro_sql = " Campo si197_totalcreditosoufontesf não informado.";
				$this->erro_campo = "si197_totalcreditosoufontesf";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si197_saldofinaloufontesf == null) {
				$this->erro_sql = " Campo si197_saldofinaloufontesf não informado.";
				$this->erro_campo = "si197_saldofinaloufontesf";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si197_naturezasaldofinaloufontesf == null) {
				$this->erro_sql = " Campo si197_naturezasaldofinaloufontesf não informado.";
				$this->erro_campo = "si197_naturezasaldofinaloufontesf";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si197_mes == null) {
				$this->erro_sql = " Campo si197_mes não informado.";
				$this->erro_campo = "si197_mes";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si197_instit == null) {
				$this->erro_sql = " Campo si197_instit não informado.";
				$this->erro_campo = "si197_instit";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}

			if ($si197_sequencial == "" || $si197_sequencial == null) {
				$result = db_query("select nextval('balancete272019_si197_sequencial_seq')");
				if ($result == false) {
					$this->erro_banco = str_replace("
", "", @pg_last_error());
					$this->erro_sql = "Verifique o cadastro da sequencia: balancete272019_si197_sequencial_seq do campo: si197_sequencial";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
				$this->si197_sequencial = pg_result($result, 0, 0);
			} else {
				$result = db_query("select last_value from balancete272019_si197_sequencial_seq");
				if (($result != false) && (pg_result($result, 0, 0) < $si197_sequencial)) {
					$this->erro_sql = " Campo si197_sequencial maior que último número da sequencia.";
					$this->erro_banco = "Sequencia menor que este número.";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				} else {
					$this->si197_sequencial = $si197_sequencial;
				}
			}
			if (($this->si197_sequencial == null) || ($this->si197_sequencial == "")) {
				$this->erro_sql = " Campo si197_sequencial nao declarado.";
				$this->erro_banco = "Chave Primaria zerada.";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			$sql = "insert into balancete272019(
                                       si197_sequencial 
                                      ,si197_tiporegistro 
                                      ,si197_contacontabil 
                                      ,si197_codfundo
                                      ,si197_codorgao
                                      ,si197_codunidadesub
                                      ,si197_codfontrecursos
                                      ,si197_atributosf 
                                      ,si197_saldoinicialoufontesf 
                                      ,si197_naturezasaldoinicialoufontesf 
                                      ,si197_totaldebitosoufontesf 
                                      ,si197_totalcreditosoufontesf 
                                      ,si197_saldofinaloufontesf 
                                      ,si197_naturezasaldofinaloufontesf 
                                      ,si197_mes 
                                      ,si197_instit
                                      ,si197_reg10
                       )
                values (
                                $this->si197_sequencial 
                               ,$this->si197_tiporegistro 
                               ,$this->si197_contacontabil 
                               ,'$this->si197_codfundo'
                               ,'$this->si197_codorgao'
                               ,$this->codunicodunidadesub
                               ,$this->si197_codfontrecursos
                               ,'$this->si197_atributosf' 
                               ,$this->si197_saldoinicialoufontesf 
                               ,'$this->si197_naturezasaldoinicialoufontesf' 
                               ,$this->si197_totaldebitosoufontesf 
                               ,$this->si197_totalcreditosoufontesf 
                               ,$this->si197_saldofinaloufontesf 
                               ,'$this->si197_naturezasaldofinaloufontesf' 
                               ,$this->si197_mes 
                               ,$this->si197_instit
                               ,$this->si197_reg10
                      )";
			$result = db_query($sql);
			if ($result == false) {
				$this->erro_banco = str_replace("
", "", @pg_last_error());
				if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
					$this->erro_sql = "balancete272019 ($this->si197_sequencial) nao Incluído. Inclusao Abortada.";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_banco = "balancete272019 já Cadastrado";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				} else {
					$this->erro_sql = "balancete272019 ($this->si197_sequencial) nao Incluído. Inclusao Abortada.";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				}
				$this->erro_status = "0";
				$this->numrows_incluir = 0;

				return false;
			}
			$this->erro_banco = "";
			$this->erro_sql = "Inclusao efetuada com Sucesso\n";
			$this->erro_sql .= "Valores : " . $this->si197_sequencial;
			$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
			$this->erro_status = "1";
			$this->numrows_incluir = pg_affected_rows($result);
			$lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
			if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {

				$resaco = $this->sql_record($this->sql_query_file($this->si197_sequencial));
				if (($resaco != false) || ($this->numrows != 0)) {

					/*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
					$acount = pg_result($resac,0,0);
					$resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
					$resac = db_query("insert into db_acountkey values($acount,2011784,'$this->si197_sequencial','I')");
					$resac = db_query("insert into db_acount values($acount,1010197,2011784,'','".AddSlashes(pg_result($resaco,0,'si197_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
					$resac = db_query("insert into db_acount values($acount,1010197,2011785,'','".AddSlashes(pg_result($resaco,0,'si197_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
					$resac = db_query("insert into db_acount values($acount,1010197,2011786,'','".AddSlashes(pg_result($resaco,0,'si197_contacontabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
					$resac = db_query("insert into db_acount values($acount,1010197,2011787,'','".AddSlashes(pg_result($resaco,0,'si197_atributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
					$resac = db_query("insert into db_acount values($acount,1010197,2011788,'','".AddSlashes(pg_result($resaco,0,'si197_saldoinicialoufontesf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
					$resac = db_query("insert into db_acount values($acount,1010197,2011789,'','".AddSlashes(pg_result($resaco,0,'si197_naturezasaldoinicialoufontesf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
					$resac = db_query("insert into db_acount values($acount,1010197,2011790,'','".AddSlashes(pg_result($resaco,0,'si197_totaldebitosoufontesf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
					$resac = db_query("insert into db_acount values($acount,1010197,2011791,'','".AddSlashes(pg_result($resaco,0,'si197_totalcreditosoufontesf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
					$resac = db_query("insert into db_acount values($acount,1010197,2011792,'','".AddSlashes(pg_result($resaco,0,'si197_saldofinaloufontesf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
					$resac = db_query("insert into db_acount values($acount,1010197,2011793,'','".AddSlashes(pg_result($resaco,0,'si197_naturezasaldofinaloufontesf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
					$resac = db_query("insert into db_acount values($acount,1010197,2011794,'','".AddSlashes(pg_result($resaco,0,'si197_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
					$resac = db_query("insert into db_acount values($acount,1010197,2011795,'','".AddSlashes(pg_result($resaco,0,'si197_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
				}
			}

			return true;
		}

		// funcao para alteracao
		function alterar($si197_sequencial = null)
		{
			$this->atualizacampos();
			$sql = " update balancete272019 set ";
			$virgula = "";
			if (trim($this->si197_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si197_sequencial"])) {
				$sql .= $virgula . " si197_sequencial = $this->si197_sequencial ";
				$virgula = ",";
				if (trim($this->si197_sequencial) == null) {
					$this->erro_sql = " Campo si197_sequencial não informado.";
					$this->erro_campo = "si197_sequencial";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si197_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si197_tiporegistro"])) {
				$sql .= $virgula . " si197_tiporegistro = $this->si197_tiporegistro ";
				$virgula = ",";
				if (trim($this->si197_tiporegistro) == null) {
					$this->erro_sql = " Campo si197_tiporegistro não informado.";
					$this->erro_campo = "si197_tiporegistro";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si197_contacontabil) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si197_contacontabil"])) {
				$sql .= $virgula . " si197_contacontabil = $this->si197_contacontabil ";
				$virgula = ",";
				if (trim($this->si197_contacontabil) == null) {
					$this->erro_sql = " Campo si197_contacontabil não informado.";
					$this->erro_campo = "si197_contacontabil";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si197_codfundo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si197_codfundo"])) {
				$sql .= $virgula . " si197_codfundo = '$this->si197_codfundo' ";
				$virgula = ",";
				if (trim($this->si197_codfundo) == null) {
					$this->erro_sql = " Campo si197_codfundo não informado.";
					$this->erro_campo = "si197_codfundo";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si197_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si197_codorgao"])) {
				$sql .= $virgula . " si197_codorgao = '$this->si197_codorgao' ";
				$virgula = ",";
				if (trim($this->si197_codorgao) == null) {
					$this->erro_sql = " Campo si197_codorgao não informado.";
					$this->erro_campo = "si197_codorgao";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si197_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si197_codunidadesub"])) {
				$sql .= $virgula . " si197_codunidadesub = '$this->si197_codunidadesub' ";
				$virgula = ",";
				if (trim($this->si197_codunidadesub) == null) {
					$this->erro_sql = " Campo si197_codunidadesub não informado.";
					$this->erro_campo = "si197_codunidadesub";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}

			if (trim($this->si197_codfontrecursos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si197_codfontrecursos"])) {
				$sql .= $virgula . " si197_codfontrecursos = '$this->si197_codfontrecursos' ";
				$virgula = ",";
				if (trim($this->si197_codfontrecursos) == null) {
					$this->erro_sql = " Campo si197_codfontrecursos não informado.";
					$this->erro_campo = "si197_codfontrecursos";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}

			if (trim($this->si197_atributosf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si197_atributosf"])) {
				$sql .= $virgula . " si197_atributosf = '$this->si197_atributosf' ";
				$virgula = ",";
				if (trim($this->si197_atributosf) == null) {
					$this->erro_sql = " Campo si197_atributosf não informado.";
					$this->erro_campo = "si197_atributosf";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si197_saldoinicialoufontesf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si197_saldoinicialoufontesf"])) {
				$sql .= $virgula . " si197_saldoinicialoufontesf = $this->si197_saldoinicialoufontesf ";
				$virgula = ",";
				if (trim($this->si197_saldoinicialoufontesf) == null) {
					$this->erro_sql = " Campo si197_saldoinicialoufontesf não informado.";
					$this->erro_campo = "si197_saldoinicialoufontesf";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si197_naturezasaldoinicialoufontesf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si197_naturezasaldoinicialoufontesf"])) {
				$sql .= $virgula . " si197_naturezasaldoinicialoufontesf = '$this->si197_naturezasaldoinicialoufontesf' ";
				$virgula = ",";
				if (trim($this->si197_naturezasaldoinicialoufontesf) == null) {
					$this->erro_sql = " Campo si197_naturezasaldoinicialoufontesf não informado.";
					$this->erro_campo = "si197_naturezasaldoinicialoufontesf";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si197_totaldebitosoufontesf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si197_totaldebitosoufontesf"])) {
				$sql .= $virgula . " si197_totaldebitosoufontesf = $this->si197_totaldebitosoufontesf ";
				$virgula = ",";
				if (trim($this->si197_totaldebitosoufontesf) == null) {
					$this->erro_sql = " Campo si197_totaldebitosoufontesf não informado.";
					$this->erro_campo = "si197_totaldebitosoufontesf";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si197_totalcreditosoufontesf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si197_totalcreditosoufontesf"])) {
				$sql .= $virgula . " si197_totalcreditosoufontesf = $this->si197_totalcreditosoufontesf ";
				$virgula = ",";
				if (trim($this->si197_totalcreditosoufontesf) == null) {
					$this->erro_sql = " Campo si197_totalcreditosoufontesf não informado.";
					$this->erro_campo = "si197_totalcreditosoufontesf";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si197_saldofinaloufontesf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si197_saldofinaloufontesf"])) {
				$sql .= $virgula . " si197_saldofinaloufontesf = $this->si197_saldofinaloufontesf ";
				$virgula = ",";
				if (trim($this->si197_saldofinaloufontesf) == null) {
					$this->erro_sql = " Campo si197_saldofinaloufontesf não informado.";
					$this->erro_campo = "si197_saldofinaloufontesf";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si197_naturezasaldofinaloufontesf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si197_naturezasaldofinaloufontesf"])) {
				$sql .= $virgula . " si197_naturezasaldofinaloufontesf = '$this->si197_naturezasaldofinaloufontesf' ";
				$virgula = ",";
				if (trim($this->si197_naturezasaldofinaloufontesf) == null) {
					$this->erro_sql = " Campo si197_naturezasaldofinaloufontesf não informado.";
					$this->erro_campo = "si197_naturezasaldofinaloufontesf";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si197_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si197_mes"])) {
				$sql .= $virgula . " si197_mes = $this->si197_mes ";
				$virgula = ",";
				if (trim($this->si197_mes) == null) {
					$this->erro_sql = " Campo si197_mes não informado.";
					$this->erro_campo = "si197_mes";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si197_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si197_instit"])) {
				$sql .= $virgula . " si197_instit = $this->si197_instit ";
				$virgula = ",";
				if (trim($this->si197_instit) == null) {
					$this->erro_sql = " Campo si197_instit não informado.";
					$this->erro_campo = "si197_instit";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			$sql .= " where ";
			if ($si197_sequencial != null) {
				$sql .= " si197_sequencial = $this->si197_sequencial";
			}
			$lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
			if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {

				$resaco = $this->sql_record($this->sql_query_file($this->si197_sequencial));
				if ($this->numrows > 0) {

					for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {

						/*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
						$acount = pg_result($resac,0,0);
						$resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
						$resac = db_query("insert into db_acountkey values($acount,2011784,'$this->si197_sequencial','A')");
						if(isset($GLOBALS["HTTP_POST_VARS"]["si197_sequencial"]) || $this->si197_sequencial != "")
						  $resac = db_query("insert into db_acount values($acount,1010197,2011784,'".AddSlashes(pg_result($resaco,$conresaco,'si197_sequencial'))."','$this->si197_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						if(isset($GLOBALS["HTTP_POST_VARS"]["si197_tiporegistro"]) || $this->si197_tiporegistro != "")
						  $resac = db_query("insert into db_acount values($acount,1010197,2011785,'".AddSlashes(pg_result($resaco,$conresaco,'si197_tiporegistro'))."','$this->si197_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						if(isset($GLOBALS["HTTP_POST_VARS"]["si197_contacontabil"]) || $this->si197_contacontabil != "")
						  $resac = db_query("insert into db_acount values($acount,1010197,2011786,'".AddSlashes(pg_result($resaco,$conresaco,'si197_contacontabil'))."','$this->si197_contacontabil',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						if(isset($GLOBALS["HTTP_POST_VARS"]["si197_atributosf"]) || $this->si197_atributosf != "")
						  $resac = db_query("insert into db_acount values($acount,1010197,2011787,'".AddSlashes(pg_result($resaco,$conresaco,'si197_atributosf'))."','$this->si197_atributosf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						if(isset($GLOBALS["HTTP_POST_VARS"]["si197_saldoinicialoufontesf"]) || $this->si197_saldoinicialoufontesf != "")
						  $resac = db_query("insert into db_acount values($acount,1010197,2011788,'".AddSlashes(pg_result($resaco,$conresaco,'si197_saldoinicialoufontesf'))."','$this->si197_saldoinicialoufontesf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						if(isset($GLOBALS["HTTP_POST_VARS"]["si197_naturezasaldoinicialoufontesf"]) || $this->si197_naturezasaldoinicialoufontesf != "")
						  $resac = db_query("insert into db_acount values($acount,1010197,2011789,'".AddSlashes(pg_result($resaco,$conresaco,'si197_naturezasaldoinicialoufontesf'))."','$this->si197_naturezasaldoinicialoufontesf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						if(isset($GLOBALS["HTTP_POST_VARS"]["si197_totaldebitosoufontesf"]) || $this->si197_totaldebitosoufontesf != "")
						  $resac = db_query("insert into db_acount values($acount,1010197,2011790,'".AddSlashes(pg_result($resaco,$conresaco,'si197_totaldebitosoufontesf'))."','$this->si197_totaldebitosoufontesf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						if(isset($GLOBALS["HTTP_POST_VARS"]["si197_totalcreditosoufontesf"]) || $this->si197_totalcreditosoufontesf != "")
						  $resac = db_query("insert into db_acount values($acount,1010197,2011791,'".AddSlashes(pg_result($resaco,$conresaco,'si197_totalcreditosoufontesf'))."','$this->si197_totalcreditosoufontesf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						if(isset($GLOBALS["HTTP_POST_VARS"]["si197_saldofinaloufontesf"]) || $this->si197_saldofinaloufontesf != "")
						  $resac = db_query("insert into db_acount values($acount,1010197,2011792,'".AddSlashes(pg_result($resaco,$conresaco,'si197_saldofinaloufontesf'))."','$this->si197_saldofinaloufontesf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						if(isset($GLOBALS["HTTP_POST_VARS"]["si197_naturezasaldofinaloufontesf"]) || $this->si197_naturezasaldofinaloufontesf != "")
						  $resac = db_query("insert into db_acount values($acount,1010197,2011793,'".AddSlashes(pg_result($resaco,$conresaco,'si197_naturezasaldofinaloufontesf'))."','$this->si197_naturezasaldofinaloufontesf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						if(isset($GLOBALS["HTTP_POST_VARS"]["si197_mes"]) || $this->si197_mes != "")
						  $resac = db_query("insert into db_acount values($acount,1010197,2011794,'".AddSlashes(pg_result($resaco,$conresaco,'si197_mes'))."','$this->si197_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						if(isset($GLOBALS["HTTP_POST_VARS"]["si197_instit"]) || $this->si197_instit != "")
						  $resac = db_query("insert into db_acount values($acount,1010197,2011795,'".AddSlashes(pg_result($resaco,$conresaco,'si197_instit'))."','$this->si197_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
					}
				}
			}
			$result = db_query($sql);
			if ($result == false) {
				$this->erro_banco = str_replace("
", "", @pg_last_error());
				$this->erro_sql = "balancete272019 nao Alterado. Alteracao Abortada.\n";
				$this->erro_sql .= "Valores : " . $this->si197_sequencial;
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";
				$this->numrows_alterar = 0;

				return false;
			} else {
				if (pg_affected_rows($result) == 0) {
					$this->erro_banco = "";
					$this->erro_sql = "balancete272019 nao foi Alterado. Alteracao Executada.\n";
					$this->erro_sql .= "Valores : " . $this->si197_sequencial;
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "1";
					$this->numrows_alterar = 0;

					return true;
				} else {
					$this->erro_banco = "";
					$this->erro_sql = "Alteração efetuada com Sucesso\n";
					$this->erro_sql .= "Valores : " . $this->si197_sequencial;
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "1";
					$this->numrows_alterar = pg_affected_rows($result);

					return true;
				}
			}
		}

		// funcao para exclusao
		function excluir($si197_sequencial = null, $dbwhere = null)
		{

			$lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
			if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {

				if ($dbwhere == null || $dbwhere == "") {

					$resaco = $this->sql_record($this->sql_query_file($si197_sequencial));
				} else {
					$resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
				}
				if (($resaco != false) || ($this->numrows != 0)) {

					for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

						/*$resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
						$acount = pg_result($resac,0,0);
						$resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
						$resac  = db_query("insert into db_acountkey values($acount,2011784,'$si197_sequencial','E')");
						$resac  = db_query("insert into db_acount values($acount,1010197,2011784,'','".AddSlashes(pg_result($resaco,$iresaco,'si197_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						$resac  = db_query("insert into db_acount values($acount,1010197,2011785,'','".AddSlashes(pg_result($resaco,$iresaco,'si197_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						$resac  = db_query("insert into db_acount values($acount,1010197,2011786,'','".AddSlashes(pg_result($resaco,$iresaco,'si197_contacontabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						$resac  = db_query("insert into db_acount values($acount,1010197,2011787,'','".AddSlashes(pg_result($resaco,$iresaco,'si197_atributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						$resac  = db_query("insert into db_acount values($acount,1010197,2011788,'','".AddSlashes(pg_result($resaco,$iresaco,'si197_saldoinicialoufontesf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						$resac  = db_query("insert into db_acount values($acount,1010197,2011789,'','".AddSlashes(pg_result($resaco,$iresaco,'si197_naturezasaldoinicialoufontesf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						$resac  = db_query("insert into db_acount values($acount,1010197,2011790,'','".AddSlashes(pg_result($resaco,$iresaco,'si197_totaldebitosoufontesf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						$resac  = db_query("insert into db_acount values($acount,1010197,2011791,'','".AddSlashes(pg_result($resaco,$iresaco,'si197_totalcreditosoufontesf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						$resac  = db_query("insert into db_acount values($acount,1010197,2011792,'','".AddSlashes(pg_result($resaco,$iresaco,'si197_saldofinaloufontesf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						$resac  = db_query("insert into db_acount values($acount,1010197,2011793,'','".AddSlashes(pg_result($resaco,$iresaco,'si197_naturezasaldofinaloufontesf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						$resac  = db_query("insert into db_acount values($acount,1010197,2011794,'','".AddSlashes(pg_result($resaco,$iresaco,'si197_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
						$resac  = db_query("insert into db_acount values($acount,1010197,2011795,'','".AddSlashes(pg_result($resaco,$iresaco,'si197_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
					}
				}
			}
			$sql = " delete from balancete272019
                    where ";
			$sql2 = "";
			if ($dbwhere == null || $dbwhere == "") {
				if ($si197_sequencial != "") {
					if ($sql2 != "") {
						$sql2 .= " and ";
					}
					$sql2 .= " si197_sequencial = $si197_sequencial ";
				}
			} else {
				$sql2 = $dbwhere;
			}
			$result = db_query($sql . $sql2);
			if ($result == false) {
				$this->erro_banco = str_replace("
", "", @pg_last_error());
				$this->erro_sql = "balancete272019 nao Excluído. Exclusão Abortada.\n";
				$this->erro_sql .= "Valores : " . $si197_sequencial;
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";
				$this->numrows_excluir = 0;

				return false;
			} else {
				if (pg_affected_rows($result) == 0) {
					$this->erro_banco = "";
					$this->erro_sql = "balancete272019 nao Encontrado. Exclusão não Efetuada.\n";
					$this->erro_sql .= "Valores : " . $si197_sequencial;
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "1";
					$this->numrows_excluir = 0;

					return true;
				} else {
					$this->erro_banco = "";
					$this->erro_sql = "Exclusão efetuada com Sucesso\n";
					$this->erro_sql .= "Valores : " . $si197_sequencial;
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
				$this->erro_sql = "Record Vazio na Tabela:balancete272019";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}

			return $result;
		}

		// funcao do sql
		function sql_query($si197_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
			$sql .= " from balancete272019 ";
			$sql2 = "";
			if ($dbwhere == "") {
				if ($si197_sequencial != null) {
					$sql2 .= " where balancete272019.si197_sequencial = $si197_sequencial ";
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
		function sql_query_file($si197_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
			$sql .= " from balancete272019 ";
			$sql2 = "";
			if ($dbwhere == "") {
				if ($si197_sequencial != null) {
					$sql2 .= " where balancete272019.si197_sequencial = $si197_sequencial ";
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
