<?
	/**
	 * Created by Victor F.
	 * User: contass
	 * Date: 24/01/19
	 * Time: 10:02
	 */
	//MODULO: sicom
	//CLASSE DA ENTIDADE cute102021
	class cl_cute102021
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
		var $si199_sequencial = 0;
		var $si199_tiporegistro = 0;
		var $si199_codorgao = null;
		var $si199_codctb = 0;
		var $si199_codfontrecursos = 0;
		var $si199_vlsaldoinicialfonte = null;
		var $si199_vlsaldofinalfonte = null;
		var $si199_mes = 0;
		var $si199_instit = 0;
		// cria propriedade com as variaveis do arquivo
		var $campos = "
                 si199_sequencial = int8 = sequencial 
                 si199_tiporegistro = int8 = Tipo do registro 
                 si199_codorgao = varchar(2) = Código do órgão
                 si199_codctb = int8 = Código da conta
                 si199_codfontrecursos = int8 = Código da fonte de recursos 
                 si199_vlsaldoinicialfonte = int8 = Valor do saldo do início do mês
                 si199_vlsaldofinalfonte = int8 = Valor do saldo do final do mês
                 si199_mes = int8 = Mês 
                 si199_instit = int8 = Instituição 
                 ";

		//funcao construtor da classe
		function cl_cute102021()
		{
			//classes dos rotulos dos campos
			$this->rotulo = new rotulo("cute102021");
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
				$this->si199_sequencial = ($this->si199_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si199_sequencial"] : $this->si199_sequencial);
				$this->si199_tiporegistro = ($this->si199_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si199_tiporegistro"] : $this->si199_tiporegistro);
				$this->si199_codorgao = ($this->si199_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si199_codorgao"] : $this->si199_codorgao);
				$this->si199_codctb = ($this->si199_codctb == "" ? @$GLOBALS["HTTP_POST_VARS"]["si199_codctb"] : $this->si199_codctb);
				$this->si199_codfontrecursos = ($this->si199_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->si199_codfontrecursos"] : $this->si199_codfontrecursos);
				$this->si199_vlsaldoinicialfonte = ($this->si199_vlsaldoinicialfonte == "" ? @$GLOBALS["HTTP_POST_VARS"]["si199_vlsaldoinicialfonte"] : $this->si199_vlsaldoinicialfonte);
				$this->si199_vlsaldofinalfonte = ($this->si199_vlsaldofinalfonte == "" ? @$GLOBALS["HTTP_POST_VARS"]["si199_vlsaldofinalfonte"] : $this->si199_vlsaldofinalfonte);
				$this->si199_mes = ($this->si199_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si199_mes"] : $this->si199_mes);
				$this->si199_instit = ($this->si199_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si199_instit"] : $this->si199_instit);
			} else {
				$this->si199_sequencial = ($this->si199_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si199_sequencial"] : $this->si199_sequencial);
			}
		}

		// funcao para inclusao
		function incluir($si199_sequencial)
		{
			$this->atualizacampos();
			if ($this->si199_tiporegistro == null) {
				$this->erro_sql = " Campo Tipo do registro nao Informado.";
				$this->erro_campo = "si199_tiporegistro";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si199_codorgao == null) {
				$this->si199_codorgao = "0";
			}
			if ($this->si199_codctb == null) {
				$this->si199_codctb = "0";
			}
			if ($this->si199_codfontrecursos == null) {
				$this->si199_codfontrecursos = "0";
			}
			if ($this->si199_vlsaldoinicialfonte == null) {
				$this->si199_vlsaldoinicialfonte = "0";
			}
			if ($this->si199_vlsaldofinalfonte == null) {
				$this->si199_vlsaldofinalfonte = "0";
			}

			if ($this->si199_mes == null) {
				$this->erro_sql = " Campo Mês nao Informado.";
				$this->erro_campo = "si199_mes";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si199_instit == null) {
				$this->erro_sql = " Campo Instituição nao Informado.";
				$this->erro_campo = "si199_instit";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($si199_sequencial == "" || $si199_sequencial == null) {
				$result = db_query("select nextval('cute102021_si199_sequencial_seq')");
				if ($result == false) {
					$this->erro_banco = str_replace("
", "", @pg_last_error());
					$this->erro_sql = "Verifique o cadastro da sequencia: cute102021_si199_sequencial_seq do campo: si199_sequencial";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
				$this->si199_sequencial = pg_result($result, 0, 0);
			} else {
				$result = db_query("select last_value from cute102021_si199_sequencial_seq");
				if (($result != false) && (pg_result($result, 0, 0) < $si199_sequencial)) {
					$this->erro_sql = " Campo si199_sequencial maior que último número da sequencia.";
					$this->erro_banco = "Sequencia menor que este número.";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				} else {
					$this->si199_sequencial = $si199_sequencial;
				}
			}
			if (($this->si199_sequencial == null) || ($this->si199_sequencial == "")) {
				$this->erro_sql = " Campo si199_sequencial nao declarado.";
				$this->erro_banco = "Chave Primaria zerada.";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			$sql = "insert into cute102021(
                                       si199_sequencial 
                                      ,si199_tiporegistro 
                                      ,si199_codorgao
                                      ,si199_codctb
                                      ,si199_codfontrecursos 
                                      ,si199_vlsaldoinicialfonte 
                                      ,si199_vlsaldofinalfonte 
                                      ,si199_mes 
                                      ,si199_instit 
                       )
                values (
                                $this->si199_sequencial 
                               ,$this->si199_tiporegistro 
                               ,'$this->si199_codorgao' 
                               ,$this->si199_codctb 
                               ,$this->si199_codfontrecursos
                               ,$this->si199_vlsaldoinicialfonte 
                               ,$this->si199_vlsaldofinalfonte 
                               ,$this->si199_mes 
                               ,$this->si199_instit 
                      )";
			$result = db_query($sql);
			if ($result == false) {
				$this->erro_banco = str_replace("
", "", @pg_last_error());
				if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
					$this->erro_sql = "cute102021 ($this->si199_sequencial) nao Incluído. Inclusao Abortada.";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_banco = "cute102021 já Cadastrado";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				} else {
					$this->erro_sql = "cute102021 ($this->si199_sequencial) nao Incluído. Inclusao Abortada.";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				}
				$this->erro_status = "0";
				$this->numrows_incluir = 0;

				return false;
			}
			$this->erro_banco = "";
			$this->erro_sql = "Inclusao efetuada com Sucesso\n";
			$this->erro_sql .= "Valores : " . $this->si199_sequencial;
			$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
			$this->erro_status = "1";
			$this->numrows_incluir = pg_affected_rows($result);
			$resaco = $this->sql_record($this->sql_query_file($this->si199_sequencial));
//			if (($resaco != false) || ($this->numrows != 0)) {
//				$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//				$acount = pg_result($resac, 0, 0);
//				$resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//				$resac = db_query("insert into db_acountkey values($acount,2010632,'$this->si199_sequencial','I')");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010632,'','" . AddSlashes(pg_result($resaco, 0, 'si199_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010633,'','" . AddSlashes(pg_result($resaco, 0, 'si199_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010634,'','" . AddSlashes(pg_result($resaco, 0, 'si199_tipoconta')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010635,'','" . AddSlashes(pg_result($resaco, 0, 'si199_codctb')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010636,'','" . AddSlashes(pg_result($resaco, 0, 'si199_identificadordeducao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010637,'','" . AddSlashes(pg_result($resaco, 0, 'si199_naturezareceita')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010638,'','" . AddSlashes(pg_result($resaco, 0, 'si199_vlsaldoinicialfonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010639,'','" . AddSlashes(pg_result($resaco, 0, 'si199_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010640,'','" . AddSlashes(pg_result($resaco, 0, 'si199_vlsaldofinalfonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2011618,'','" . AddSlashes(pg_result($resaco, 0, 'si199_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//			}

			return true;
		}

		// funcao para alteracao
		function alterar($si199_sequencial = null)
		{
			$this->atualizacampos();
			$sql = " update cute102021 set ";
			$virgula = "";
			if (trim($this->si199_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si199_sequencial"])) {
				if (trim($this->si199_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si199_sequencial"])) {
					$this->si199_sequencial = "0";
				}
				$sql .= $virgula . " si199_sequencial = $this->si199_sequencial ";
				$virgula = ",";
			}
			if (trim($this->si199_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si199_tiporegistro"])) {
				$sql .= $virgula . " si199_tiporegistro = $this->si199_tiporegistro ";
				$virgula = ",";
				if (trim($this->si199_tiporegistro) == null) {
					$this->erro_sql = " Campo Tipo do registro nao Informado.";
					$this->erro_campo = "si199_tiporegistro";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}

			if (trim($this->si199_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si199_codorgao"])) {
				if (trim($this->si199_codorgao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si199_codorgao"])) {
					$this->si199_codorgao = "0";
				}
				$sql .= $virgula . " si199_codorgao = $this->si199_codorgao ";
				$virgula = ",";
			}

			if (trim($this->si199_codfontrecursos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["$this->si199_codfontrecursos"])) {
				if (trim($this->si199_codfontrecursos) == "" && isset($GLOBALS["HTTP_POST_VARS"]["$this->si199_codfontrecursos"])) {
					$this->si199_codfontrecursos = "0";
				}
				$sql .= $virgula . " si199_codorgao = $this->si199_codorgao ";
				$virgula = ",";
			}

			if (trim($this->si199_codctb) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si199_codctb"])) {
				if (trim($this->si199_codctb) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si199_codctb"])) {
					$this->si199_codctb = "0";
				}
				$sql .= $virgula . " si199_codctb = $this->si199_codctb ";
				$virgula = ",";
			}

			if (trim($this->si199_vlsaldoinicialfonte) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si199_vlsaldoinicialfonte"])) {
				if (trim($this->si199_vlsaldoinicialfonte) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si199_vlsaldoinicialfonte"])) {
					$this->si199_vlsaldoinicialfonte = "0";
				}
				$sql .= $virgula . " si199_vlsaldoinicialfonte = $this->si199_vlsaldoinicialfonte ";
				$virgula = ",";
			}
			if (trim($this->si199_vlsaldofinalfonte) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si199_vlsaldofinalfonte"])) {
				if (trim($this->si199_vlsaldofinalfonte) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si199_vlsaldofinalfonte"])) {
					$this->si199_vlsaldofinalfonte = "0";
				}
				$sql .= $virgula . " si199_vlsaldofinalfonte = $this->si199_vlsaldofinalfonte ";
				$virgula = ",";
			}
			if (trim($this->si199_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si199_mes"])) {
				$sql .= $virgula . " si199_mes = $this->si199_mes ";
				$virgula = ",";
				if (trim($this->si199_mes) == null) {
					$this->erro_sql = " Campo Mês nao Informado.";
					$this->erro_campo = "si199_mes";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si199_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si199_instit"])) {
				$sql .= $virgula . " si199_instit = $this->si199_instit ";
				$virgula = ",";
				if (trim($this->si199_instit) == null) {
					$this->erro_sql = " Campo Instituição nao Informado.";
					$this->erro_campo = "si199_instit";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			$sql .= " where ";
			if ($si199_sequencial != null) {
				$sql .= " si199_sequencial = $this->si199_sequencial";
			}
//			$resaco = $this->sql_record($this->sql_query_file($this->si199_sequencial));
//			if ($this->numrows > 0) {
//				for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
//					$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//					$acount = pg_result($resac, 0, 0);
//					$resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//					$resac = db_query("insert into db_acountkey values($acount,2010632,'$this->si199_sequencial','A')");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si199_sequencial"]) || $this->si199_sequencial != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010632,'" . AddSlashes(pg_result($resaco, $conresaco, 'si199_sequencial')) . "','$this->si199_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si199_tiporegistro"]) || $this->si199_tiporegistro != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010633,'" . AddSlashes(pg_result($resaco, $conresaco, 'si199_tiporegistro')) . "','$this->si199_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si199_tipoconta"]) || $this->si199_tipoconta != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010634,'" . AddSlashes(pg_result($resaco, $conresaco, 'si199_tipoconta')) . "','$this->si199_tipoconta'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si199_codctb"]) || $this->si199_codctb != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010635,'" . AddSlashes(pg_result($resaco, $conresaco, 'si199_codctb')) . "','$this->si199_codctb'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si199_identificadordeducao"]) || $this->si199_identificadordeducao != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010636,'" . AddSlashes(pg_result($resaco, $conresaco, 'si199_identificadordeducao')) . "','$this->si199_identificadordeducao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si199_naturezareceita"]) || $this->si199_naturezareceita != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010637,'" . AddSlashes(pg_result($resaco, $conresaco, 'si199_naturezareceita')) . "','$this->si199_naturezareceita'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si199_vlsaldoinicialfonte"]) || $this->si199_vlsaldoinicialfonte != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010638,'" . AddSlashes(pg_result($resaco, $conresaco, 'si199_vlsaldoinicialfonte')) . "','$this->si199_vlsaldoinicialfonte'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si199_mes"]) || $this->si199_mes != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010639,'" . AddSlashes(pg_result($resaco, $conresaco, 'si199_mes')) . "','$this->si199_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si199_vlsaldofinalfonte"]) || $this->si199_vlsaldofinalfonte != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010640,'" . AddSlashes(pg_result($resaco, $conresaco, 'si199_vlsaldofinalfonte')) . "','$this->si199_vlsaldofinalfonte'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si199_instit"]) || $this->si199_instit != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2011618,'" . AddSlashes(pg_result($resaco, $conresaco, 'si199_instit')) . "','$this->si199_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				}
//			}
			$result = db_query($sql);
			if ($result == false) {
				$this->erro_banco = str_replace("
", "", @pg_last_error());
				$this->erro_sql = "cute102021 nao Alterado. Alteracao Abortada.\n";
				$this->erro_sql .= "Valores : " . $this->si199_sequencial;
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";
				$this->numrows_alterar = 0;

				return false;
			} else {
				if (pg_affected_rows($result) == 0) {
					$this->erro_banco = "";
					$this->erro_sql = "cute102021 nao foi Alterado. Alteracao Executada.\n";
					$this->erro_sql .= "Valores : " . $this->si199_sequencial;
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "1";
					$this->numrows_alterar = 0;

					return true;
				} else {
					$this->erro_banco = "";
					$this->erro_sql = "Alteração efetuada com Sucesso\n";
					$this->erro_sql .= "Valores : " . $this->si199_sequencial;
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "1";
					$this->numrows_alterar = pg_affected_rows($result);

					return true;
				}
			}
		}

		// funcao para exclusao
		function excluir($si199_sequencial = null, $dbwhere = null)
		{
			if ($dbwhere == null || $dbwhere == "") {
				$resaco = $this->sql_record($this->sql_query_file($si199_sequencial));
			} else {
				$resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
			}
//			if (($resaco != false) || ($this->numrows != 0)) {
//				for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
//					$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//					$acount = pg_result($resac, 0, 0);
//					$resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//					$resac = db_query("insert into db_acountkey values($acount,2010632,'$si199_sequencial','E')");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010632,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si199_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010633,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si199_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010634,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si199_tipoconta')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010635,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si199_codctb')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010636,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si199_identificadordeducao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010637,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si199_naturezareceita')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010638,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si199_vlsaldoinicialfonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010639,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si199_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010640,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si199_vlsaldofinalfonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2011618,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si199_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				}
//			}
			$sql = " delete from cute102021
                    where ";
			$sql2 = "";
			if ($dbwhere == null || $dbwhere == "") {
				if ($si199_sequencial != "") {
					if ($sql2 != "") {
						$sql2 .= " and ";
					}
					$sql2 .= " si199_sequencial = $si199_sequencial ";
				}
			} else {
				$sql2 = $dbwhere;
			}
			$result = db_query($sql . $sql2);
			if ($result == false) {
				$this->erro_banco = str_replace("
", "", @pg_last_error());
				$this->erro_sql = "cute102021 nao Excluído. Exclusão Abortada.\n";
				$this->erro_sql .= "Valores : " . $si199_sequencial;
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";
				$this->numrows_excluir = 0;

				return false;
			} else {
				if (pg_affected_rows($result) == 0) {
					$this->erro_banco = "";
					$this->erro_sql = "cute102021 nao Encontrado. Exclusão não Efetuada.\n";
					$this->erro_sql .= "Valores : " . $si199_sequencial;
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "1";
					$this->numrows_excluir = 0;

					return true;
				} else {
					$this->erro_banco = "";
					$this->erro_sql = "Exclusão efetuada com Sucesso\n";
					$this->erro_sql .= "Valores : " . $si199_sequencial;
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
				$this->erro_sql = "Record Vazio na Tabela:cute102021";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}

			return $result;
		}

		// funcao do sql
		function sql_query($si199_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
		{
			$sql = "select ";
			if ($campos != "*") {
				$campos_sql = split("#", $campos);
				$virgula = "";
				for ($i = 0; $i < sizeof($campos_sql); $i++) {
					$sql .= $virgula . $campos_sql[$i];
					$virgula = ",";
				}
			} else {
				$sql .= $campos;
			}
			$sql .= " from cute102021 ";
			$sql2 = "";
			if ($dbwhere == "") {
				if ($si199_sequencial != null) {
					$sql2 .= " where cute102021.si199_sequencial = $si199_sequencial ";
				}
			} else if ($dbwhere != "") {
				$sql2 = " where $dbwhere";
			}
			$sql .= $sql2;
			if ($ordem != null) {
				$sql .= " order by ";
				$campos_sql = split("#", $ordem);
				$virgula = "";
				for ($i = 0; $i < sizeof($campos_sql); $i++) {
					$sql .= $virgula . $campos_sql[$i];
					$virgula = ",";
				}
			}

			return $sql;
		}

		// funcao do sql
		function sql_query_file($si199_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
		{
			$sql = "select ";
			if ($campos != "*") {
				$campos_sql = split("#", $campos);
				$virgula = "";
				for ($i = 0; $i < sizeof($campos_sql); $i++) {
					$sql .= $virgula . $campos_sql[$i];
					$virgula = ",";
				}
			} else {
				$sql .= $campos;
			}
			$sql .= " from cute102021 ";
			$sql2 = "";
			if ($dbwhere == "") {
				if ($si199_sequencial != null) {
					$sql2 .= " where cute102021.si199_sequencial = $si199_sequencial ";
				}
			} else if ($dbwhere != "") {
				$sql2 = " where $dbwhere";
			}
			$sql .= $sql2;
			if ($ordem != null) {
				$sql .= " order by ";
				$campos_sql = split("#", $ordem);
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
