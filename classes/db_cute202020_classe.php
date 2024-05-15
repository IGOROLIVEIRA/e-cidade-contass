<?
	/**
	 * Created by Victor F.
	 * User: contass
	 * Date: 24/01/19
	 * Time: 10:02
	 */
	//MODULO: sicom
	//CLASSE DA ENTIDADE cute202020
	class cl_cute202020
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
		var $erro_codfontrecursos = null;
		var $erro_msg = null;
		var $erro_campo = null;
		var $pagina_retorno = null;
		// cria variaveis do arquivo
		var $si200_sequencial = 0;
		var $si200_tiporegistro = 0;
		var $si200_codorgao = null;
		var $si200_codctb = 0;
		var $si200_codfontrecursos = 0;
		var $si200_vlsaldoinicialfonte = 0;
		var $si200_vlsaldofinalfonte = 0;
		var $si200_mes = 0;
		var $si200_instit = 0;
		// cria propriedade com as variaveis do arquivo
		var $campos = "
                 si200_sequencial = int8 = Sequencial 
                 si200_tiporegistro = int8 = Tipo do registro 
                 si200_codorgao = varchar(2) = Código do órgão
                 si200_codctb = int8 = Código da identificador da conta 
                 si200_codfontrecursos = int8 = Código da fonte de recursos
                 si200_vlsaldoinicialfonte = float8 = Valor do saldo do início do mês 
                 si200_vlsaldofinalfonte = float8 = Valor do saldo do final do mês  
                 si200_mes = int8 = Mês 
                 si200_instit = int8 = Instituição 
                 ";

		//funcao construtor da classe
		function cl_cute202020()
		{
			//classes dos rotulos dos campos
			$this->rotulo = new rotulo("cute202020");
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
				$this->si200_sequencial = ($this->si200_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si200_sequencial"] : $this->si200_sequencial);
				$this->si200_tiporegistro = ($this->si200_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si200_tiporegistro"] : $this->si200_tiporegistro);
				$this->si200_codorgao = ($this->si200_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si200_codorgao"] : $this->si200_codorgao);
				$this->si200_codctb = ($this->si200_codctb == "" ? @$GLOBALS["HTTP_POST_VARS"]["si200_codctb"] : $this->si200_codctb);
				$this->si200_codfontrecursos = ($this->si200_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si200_codfontrecursos"] : $this->si200_codfontrecursos);
				$this->si200_vlsaldoinicialfonte = ($this->si200_vlsaldoinicialfonte == "" ? @$GLOBALS["HTTP_POST_VARS"]["si200_vlsaldoinicialfonte"] : $this->si200_vlsaldoinicialfonte);
				$this->si200_vlsaldofinalfonte = ($this->si200_vlsaldofinalfonte == "" ? @$GLOBALS["HTTP_POST_VARS"]["si200_vlsaldofinalfonte"] : $this->si200_vlsaldofinalfonte);
				$this->si200_mes = ($this->si200_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si200_mes"] : $this->si200_mes);
				$this->si200_instit = ($this->si200_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si200_instit"] : $this->si200_instit);
			} else {
				$this->si200_sequencial = ($this->si200_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si200_sequencial"] : $this->si200_sequencial);
			}
		}

		// funcao para inclusao
		function incluir($si200_sequencial)
		{
			$this->atualizacampos();
			if ($this->si200_tiporegistro == null) {
				$this->erro_sql = " Campo Tipo do registro nao Informado.";
				$this->erro_campo = "si200_tiporegistro";
				$this->erro_codfontrecursos = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si200_codorgao == null) {
				$this->si200_codorgao = "0";
			}
			if ($this->si200_codctb == null) {
				$this->si200_codctb = "0";
			}
			if ($this->si200_codfontrecursos == null) {
				$this->si200_codfontrecursos = "0";
			}
			if ($this->si200_vlsaldoinicialfonte == null) {
				$this->si200_vlsaldoinicialfonte = "0";
			}
			if ($this->si200_vlsaldofinalfonte == null) {
				$this->si200_vlsaldofinalfonte = "0";
			}
			if ($this->si200_mes == null) {
				$this->erro_sql = " Campo Mês nao Informado.";
				$this->erro_campo = "si200_mes";
				$this->erro_codfontrecursos = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si200_instit == null) {
				$this->erro_sql = " Campo Instituição nao Informado.";
				$this->erro_campo = "si200_instit";
				$this->erro_codfontrecursos = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($si200_sequencial == "" || $si200_sequencial == null) {
				$result = db_query("select nextval('cute202020_si200_sequencial_seq')");
				if ($result == false) {
					$this->erro_codfontrecursos = str_replace("", "", @pg_last_error());
					$this->erro_sql = "Verifique o cadastro da sequencia: cute202020_si200_sequencial_seq do campo: si200_sequencial";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
					$this->erro_status = "0";

					return false;
				}
				$this->si200_sequencial = pg_result($result, 0, 0);
			} else {
				$result = db_query("select last_value from cute202020_si200_sequencial_seq");
				if (($result != false) && (pg_result($result, 0, 0) < $si200_sequencial)) {
					$this->erro_sql = " Campo si200_sequencial maior que último número da sequencia.";
					$this->erro_codfontrecursos = "Sequencia menor que este número.";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
					$this->erro_status = "0";

					return false;
				} else {
					$this->si200_sequencial = $si200_sequencial;
				}
			}
			if (($this->si200_sequencial == null) || ($this->si200_sequencial == "")) {
				$this->erro_sql = " Campo si200_sequencial nao declarado.";
				$this->erro_codfontrecursos = "Chave Primaria zerada.";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
				$this->erro_status = "0";

				return false;
			}
			$sql = "insert into cute202020(
                                       si200_sequencial 
                                      ,si200_tiporegistro 
                                      ,si200_codorgao
                                      ,si200_codctb
                                      ,si200_codfontrecursos
                                      ,si200_vlsaldoinicialfonte 
                                      ,si200_vlsaldofinalfonte 
                                      ,si200_mes 
                                      ,si200_instit 
                       )
                values (
                                $this->si200_sequencial 
                               ,$this->si200_tiporegistro 
                               ,'$this->si200_codorgao' 
                               ,$this->si200_codctb 
                               ,$this->si200_codfontrecursos
                               ,$this->si200_vlsaldoinicialfonte 
                               ,$this->si200_vlsaldofinalfonte 
                               ,$this->si200_mes 
                               ,$this->si200_instit 
                      )";
			$result = db_query($sql);
			if ($result == false) {
				$this->erro_codfontrecursos = str_replace("", "", @pg_last_error());
				if (strpos(strtolower($this->erro_codfontrecursos), "duplicate key") != 0) {
					$this->erro_sql = "cute202020 ($this->si200_sequencial) nao Incluído. Inclusao Abortada.";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_codfontrecursos = "cute202020 já Cadastrado";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
				} else {
					$this->erro_sql = "cute202020 ($this->si200_sequencial) nao Incluído. Inclusao Abortada.";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
				}
				$this->erro_status = "0";
				$this->numrows_incluir = 0;

				return false;
			}
			$this->erro_codfontrecursos = "";
			$this->erro_sql = "Inclusao efetuada com Sucesso\n";
			$this->erro_sql .= "Valores : " . $this->si200_sequencial;
			$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
			$this->erro_status = "1";
			$this->numrows_incluir = pg_affected_rows($result);
			$resaco = $this->sql_record($this->sql_query_file($this->si200_sequencial));
//			if (($resaco != false) || ($this->numrows != 0)) {
//				$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//				$acount = pg_result($resac, 0, 0);
//				$resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//				$resac = db_query("insert into db_acountkey values($acount,2010632,'$this->si200_sequencial','I')");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010632,'','" . AddSlashes(pg_result($resaco, 0, 'si200_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010633,'','" . AddSlashes(pg_result($resaco, 0, 'si200_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010634,'','" . AddSlashes(pg_result($resaco, 0, 'si200_tipoconta')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010635,'','" . AddSlashes(pg_result($resaco, 0, 'si200_codctb')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010636,'','" . AddSlashes(pg_result($resaco, 0, 'si200_identificadordeducao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010637,'','" . AddSlashes(pg_result($resaco, 0, 'si200_naturezareceita')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010638,'','" . AddSlashes(pg_result($resaco, 0, 'si200_vlsaldoinicialfonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010639,'','" . AddSlashes(pg_result($resaco, 0, 'si200_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010640,'','" . AddSlashes(pg_result($resaco, 0, 'si200_vlsaldofinalfonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2011618,'','" . AddSlashes(pg_result($resaco, 0, 'si200_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//			}

			return true;
		}

		// funcao para alteracao
		function alterar($si200_sequencial = null)
		{
			$this->atualizacampos();
			$sql = " update cute202020 set ";
			$virgula = "";
			if (trim($this->si200_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si200_sequencial"])) {
				if (trim($this->si200_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si200_sequencial"])) {
					$this->si200_sequencial = "0";
				}
				$sql .= $virgula . " si200_sequencial = $this->si200_sequencial ";
				$virgula = ",";
			}
			if (trim($this->si200_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si200_tiporegistro"])) {
				$sql .= $virgula . " si200_tiporegistro = $this->si200_tiporegistro ";
				$virgula = ",";
				if (trim($this->si200_tiporegistro) == null) {
					$this->erro_sql = " Campo Tipo do registro nao Informado.";
					$this->erro_campo = "si200_tiporegistro";
					$this->erro_codfontrecursos = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}

			if (trim($this->si200_codctb) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si200_codctb"])) {
				if (trim($this->si200_codctb) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si200_codctb"])) {
					$this->si200_codctb = "0";
				}
				$sql .= $virgula . " si200_codctb = $this->si200_codctb ";
				$virgula = ",";
			}
			if (trim($this->si200_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si200_codorgao"])) {
				if (trim($this->si200_codorgao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si200_codorgao"])) {
					$this->si200_codorgao = "0";
				}
				$sql .= $virgula . " si200_codorgao = $this->si200_codorgao ";
				$virgula = ",";
			}
			if (trim($this->si200_codfontrecursos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si200_codfontrecursos"])) {
				if (trim($this->si200_codfontrecursos) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si200_codfontrecursos"])) {
					$this->si200_codfontrecursos = "0";
				}
				$sql .= $virgula . " si200_codfontrecursos = $this->si200_codfontrecursos ";
				$virgula = ",";
			}

			if (trim($this->si200_vlsaldoinicialfonte) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si200_vlsaldoinicialfonte"])) {
				if (trim($this->si200_vlsaldoinicialfonte) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si200_vlsaldoinicialfonte"])) {
					$this->si200_vlsaldoinicialfonte = "0";
				}
				$sql .= $virgula . " si200_vlsaldoinicialfonte = $this->si200_vlsaldoinicialfonte ";
				$virgula = ",";
			}
			if (trim($this->si200_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si200_mes"])) {
				$sql .= $virgula . " si200_mes = $this->si200_mes ";
				$virgula = ",";
				if (trim($this->si200_mes) == null) {
					$this->erro_sql = " Campo Mês nao Informado.";
					$this->erro_campo = "si200_mes";
					$this->erro_codfontrecursos = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si200_vlsaldofinalfonte) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si200_vlsaldofinalfonte"])) {
				if (trim($this->si200_vlsaldofinalfonte) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si200_vlsaldofinalfonte"])) {
					$this->si200_vlsaldofinalfonte = "0";
				}
				$sql .= $virgula . " si200_vlsaldofinalfonte = $this->si200_vlsaldofinalfonte ";
				$virgula = ",";
			}
			if (trim($this->si200_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si200_instit"])) {
				$sql .= $virgula . " si200_instit = $this->si200_instit ";
				$virgula = ",";
				if (trim($this->si200_instit) == null) {
					$this->erro_sql = " Campo Instituição nao Informado.";
					$this->erro_campo = "si200_instit";
					$this->erro_codfontrecursos = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			$sql .= " where ";
			if ($si200_sequencial != null) {
				$sql .= " si200_sequencial = $this->si200_sequencial";
			}
//			$resaco = $this->sql_record($this->sql_query_file($this->si200_sequencial));
//			if ($this->numrows > 0) {
//				for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
//					$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//					$acount = pg_result($resac, 0, 0);
//					$resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//					$resac = db_query("insert into db_acountkey values($acount,2010632,'$this->si200_sequencial','A')");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si200_sequencial"]) || $this->si200_sequencial != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010632,'" . AddSlashes(pg_result($resaco, $conresaco, 'si200_sequencial')) . "','$this->si200_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si200_tiporegistro"]) || $this->si200_tiporegistro != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010633,'" . AddSlashes(pg_result($resaco, $conresaco, 'si200_tiporegistro')) . "','$this->si200_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si200_tipoconta"]) || $this->si200_tipoconta != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010634,'" . AddSlashes(pg_result($resaco, $conresaco, 'si200_tipoconta')) . "','$this->si200_tipoconta'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si200_codctb"]) || $this->si200_codctb != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010635,'" . AddSlashes(pg_result($resaco, $conresaco, 'si200_codctb')) . "','$this->si200_codctb'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si200_identificadordeducao"]) || $this->si200_identificadordeducao != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010636,'" . AddSlashes(pg_result($resaco, $conresaco, 'si200_identificadordeducao')) . "','$this->si200_identificadordeducao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si200_naturezareceita"]) || $this->si200_naturezareceita != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010637,'" . AddSlashes(pg_result($resaco, $conresaco, 'si200_naturezareceita')) . "','$this->si200_naturezareceita'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si200_vlsaldoinicialfonte"]) || $this->si200_vlsaldoinicialfonte != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010638,'" . AddSlashes(pg_result($resaco, $conresaco, 'si200_vlsaldoinicialfonte')) . "','$this->si200_vlsaldoinicialfonte'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si200_mes"]) || $this->si200_mes != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010639,'" . AddSlashes(pg_result($resaco, $conresaco, 'si200_mes')) . "','$this->si200_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si200_vlsaldofinalfonte"]) || $this->si200_vlsaldofinalfonte != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010640,'" . AddSlashes(pg_result($resaco, $conresaco, 'si200_vlsaldofinalfonte')) . "','$this->si200_vlsaldofinalfonte'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si200_instit"]) || $this->si200_instit != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2011618,'" . AddSlashes(pg_result($resaco, $conresaco, 'si200_instit')) . "','$this->si200_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				}
//			}
			$result = db_query($sql);
			if ($result == false) {
				$this->erro_codfontrecursos = str_replace("", "", @pg_last_error());
				$this->erro_sql = "cute202020 nao Alterado. Alteracao Abortada.\n";
				$this->erro_sql .= "Valores : " . $this->si200_sequencial;
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
				$this->erro_status = "0";
				$this->numrows_alterar = 0;

				return false;
			} else {
				if (pg_affected_rows($result) == 0) {
					$this->erro_codfontrecursos = "";
					$this->erro_sql = "cute202020 nao foi Alterado. Alteracao Executada.\n";
					$this->erro_sql .= "Valores : " . $this->si200_sequencial;
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
					$this->erro_status = "1";
					$this->numrows_alterar = 0;

					return true;
				} else {
					$this->erro_codfontrecursos = "";
					$this->erro_sql = "Alteração efetuada com Sucesso\n";
					$this->erro_sql .= "Valores : " . $this->si200_sequencial;
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
					$this->erro_status = "1";
					$this->numrows_alterar = pg_affected_rows($result);

					return true;
				}
			}
		}

		// funcao para exclusao
		function excluir($si200_sequencial = null, $dbwhere = null)
		{
			if ($dbwhere == null || $dbwhere == "") {
				$resaco = $this->sql_record($this->sql_query_file($si200_sequencial));
			} else {
				$resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
			}
//			if (($resaco != false) || ($this->numrows != 0)) {
//				for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
//					$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//					$acount = pg_result($resac, 0, 0);
//					$resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//					$resac = db_query("insert into db_acountkey values($acount,2010632,'$si200_sequencial','E')");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010632,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si200_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010633,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si200_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010634,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si200_tipoconta')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010635,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si200_codctb')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010636,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si200_identificadordeducao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010637,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si200_naturezareceita')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010638,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si200_vlsaldoinicialfonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010639,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si200_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010640,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si200_vlsaldofinalfonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2011618,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si200_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				}
//			}
			$sql = " delete from cute202020
                    where ";
			$sql2 = "";
			if ($dbwhere == null || $dbwhere == "") {
				if ($si200_sequencial != "") {
					if ($sql2 != "") {
						$sql2 .= " and ";
					}
					$sql2 .= " si200_sequencial = $si200_sequencial ";
				}
			} else {
				$sql2 = $dbwhere;
			}
			$result = db_query($sql . $sql2);
			if ($result == false) {
				$this->erro_codfontrecursos = str_replace("", "", @pg_last_error());
				$this->erro_sql = "cute202020 nao Excluído. Exclusão Abortada.\n";
				$this->erro_sql .= "Valores : " . $si200_sequencial;
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
				$this->erro_status = "0";
				$this->numrows_excluir = 0;

				return false;
			} else {
				if (pg_affected_rows($result) == 0) {
					$this->erro_codfontrecursos = "";
					$this->erro_sql = "cute202020 nao Encontrado. Exclusão não Efetuada.\n";
					$this->erro_sql .= "Valores : " . $si200_sequencial;
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
					$this->erro_status = "1";
					$this->numrows_excluir = 0;

					return true;
				} else {
					$this->erro_codfontrecursos = "";
					$this->erro_sql = "Exclusão efetuada com Sucesso\n";
					$this->erro_sql .= "Valores : " . $si200_sequencial;
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
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
				$this->erro_codfontrecursos = str_replace("", "", @pg_last_error());
				$this->erro_sql = "Erro ao selecionar os registros.";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
				$this->erro_status = "0";

				return false;
			}
			$this->numrows = pg_numrows($result);
			if ($this->numrows == 0) {
				$this->erro_codfontrecursos = "";
				$this->erro_sql = "Record Vazio na Tabela:cute202020";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
				$this->erro_status = "0";

				return false;
			}

			return $result;
		}

		// funcao do sql
		function sql_query($si200_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
			$sql .= " from cute202020 ";
			$sql2 = "";
			if ($dbwhere == "") {
				if ($si200_sequencial != null) {
					$sql2 .= " where cute202020.si200_sequencial = $si200_sequencial ";
				}
			} else if ($dbwhere != "") {
				$sql2 = " where $dbwhere";
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
		function sql_query_file($si200_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
			$sql .= " from cute202020 ";
			$sql2 = "";
			if ($dbwhere == "") {
				if ($si200_sequencial != null) {
					$sql2 .= " where cute202020.si200_sequencial = $si200_sequencial ";
				}
			} else if ($dbwhere != "") {
				$sql2 = " where $dbwhere";
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
