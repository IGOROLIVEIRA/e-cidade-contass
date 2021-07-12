<?
	//MODULO: sicom
	//CLASSE DA ENTIDADE emp202019
	class cl_emp202019
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
		var $si109_sequencial = 0;
		var $si109_tiporegistro = 0;
		var $si109_codorgao = null;
		var $si109_codunidadesub = null;
		var $si109_nroempenho = 0;
		var $si109_dtempenho_dia = null;
		var $si109_dtempenho_mes = null;
		var $si109_dtempenho_ano = null;
		var $si109_dtempenho = null;
		var $si109_nroreforco = 0;
		var $si109_dtreforco_dia = null;
		var $si109_dtreforco_mes = null;
		var $si109_dtreforco_ano = null;
		var $si109_dtreforco = null;
		var $si109_codfontrecursos = 0;
		var $si109_vlreforco = 0;
    var $si109_mes = 0;
		var $si109_instit = 0;
		// cria propriedade com as variaveis do arquivo
		var $campos = "
                 si109_sequencial = int8 = sequencial
                 si109_tiporegistro = int8 = Tipo do  registro
                 si109_codorgao = varchar(2) = Código do Órgão
                 si109_codunidadesub = varchar(8) = Código da unidade
                 si109_nroempenho = int8 = Número do  empenho
                 si109_dtempenho = date = Data do Empenho
                 si109_nroreforco = int8 = Número do reforço
                 si109_dtreforco = date = Data do reforço do empenho
                 si109_codfontrecursos = Código da fonte de recursos
                 si109_vlreforco = float8 = Valor do reforço do empenho
                 si109_mes = int8 = Mês
                 si109_instit = int8 = Instituição
                 ";

		//funcao construtor da classe
		function cl_emp202019()
		{
			//classes dos rotulos dos campos
			$this->rotulo = new rotulo("emp202019");
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
				$this->si109_sequencial = ($this->si109_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si109_sequencial"] : $this->si109_sequencial);
				$this->si109_tiporegistro = ($this->si109_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si109_tiporegistro"] : $this->si109_tiporegistro);
				$this->si109_codorgao = ($this->si109_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si109_codorgao"] : $this->si109_codorgao);
        $this->si109_codunidadesub = ($this->si109_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si109_codunidadesub"] : $this->si109_codunidadesub);
				$this->si109_nroempenho = ($this->si109_nroempenho == "" ? @$GLOBALS["HTTP_POST_VARS"]["si109_nroempenho"] : $this->si109_nroempenho);
				if ($this->si109_dtempenho == "") {
					$this->si109_dtempenho_dia = ($this->si109_dtempenho_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si109_dtempenho_dia"] : $this->si109_dtempenho_dia);
					$this->si109_dtempenho_mes = ($this->si109_dtempenho_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si109_dtempenho_mes"] : $this->si109_dtempenho_mes);
					$this->si109_dtempenho_ano = ($this->si109_dtempenho_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si109_dtempenho_ano"] : $this->si109_dtempenho_ano);
					if ($this->si109_dtempenho_dia != "") {
						$this->si109_dtempenho = $this->si109_dtempenho_ano . "-" . $this->si109_dtempenho_mes . "-" . $this->si150_dtpublicacaoleiautorizacao_dia;
					}
				}
				$this->si109_nroreforco = ($this->si109_nroreforco == "" ? @$GLOBALS["HTTP_POST_VARS"]["si109_nroreforco"] : $this->si109_nroreforco);
				if ($this->si109_dtreforco == "") {
					$this->si109_dtreforco_dia = ($this->si109_dtreforco_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si109_dtreforco_dia"] : $this->si109_dtreforco_dia);
					$this->si109_dtreforco_mes = ($this->si109_dtreforco_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si109_dtreforco_mes"] : $this->si109_dtreforco_mes);
					$this->si109_dtreforco_ano = ($this->si109_dtreforco_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si109_dtreforco_ano"] : $this->si109_dtreforco_ano);
					if ($this->si109_dtreforco_dia != "") {
						$this->si109_dtreforco = $this->si109_dtreforco_ano . "-" . $this->si109_dtreforco_mes . "-" . $this->si150_dtpublicacaoleiautorizacao_dia;
					}
				}
				$this->si109_codfontrecursos = ($this->si109_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si109_codfontrecursos"] : $this->si109_codfontrecursos);
				$this->si109_vlreforco = ($this->si109_vlreforco == "" ? @$GLOBALS["HTTP_POST_VARS"]["si109_vlreforco"] : $this->si109_vlreforco);
				$this->si109_mes = ($this->si109_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si109_mes"] : $this->si109_mes);
				$this->si109_instit = ($this->si109_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si109_instit"] : $this->si109_instit);
      } else {
				$this->si109_sequencial = ($this->si109_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si109_sequencial"] : $this->si109_sequencial);
			}
		}

		// funcao para inclusao
		function incluir($si109_sequencial)
		{
			$this->atualizacampos();
			if ($this->si109_tiporegistro == null) {
				$this->erro_sql = " Campo Tipo do  registro nao Informado.";
				$this->erro_campo = "si109_tiporegistro";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si109_codorgao == null) {
				$this->erro_sql = " Campo Código do órgão não Informado.";
				$this->erro_campo = "si109_codorgao";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si109_codunidadesub == null) {
				$this->erro_sql = " Campo Código da unidade ou subunidade não Informado.";
				$this->erro_campo = "si109_codunidadesub";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si109_nroempenho == null) {
				$this->erro_sql = " Campo Número do Empenho não Informado.";
				$this->erro_campo = "si109_nroempenho";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si109_dtempenho == null) {
				$this->erro_sql = " Campo Data do Empenho não Informado.";
				$this->erro_campo = "si109_dtempenho";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}

			if ($this->si109_nroreforco == null) {
				$this->erro_sql = " Campo Número do reforço não Informado.";
				$this->erro_campo = "si109_nroreforco";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}

			if ($this->si109_dtreforco == null) {
				$this->erro_sql = " Campo Data do reforço não Informado.";
				$this->erro_campo = "si109_dtreforco";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si109_codfontrecursos == null) {
				$this->erro_sql = " Campo Código da fonte de recursos não Informado.";
				$this->erro_campo = "si109_codfontrecursos";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}

			if ($this->si109_vlreforco == null) {
				$this->erro_sql = " Campo Valor do reforço não Informado.";
				$this->erro_campo = "si109_vlreforco";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}

			if ($this->si109_mes == null) {
				$this->erro_sql = " Campo Mês nao Informado.";
				$this->erro_campo = "si109_mes";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si109_instit == null) {
				$this->erro_sql = " Campo Instituição nao Informado.";
				$this->erro_campo = "si109_instit";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($si109_sequencial == "" || $si109_sequencial == null) {
				$result = db_query("select nextval('emp202019_si109_sequencial_seq')");
				if ($result == false) {
					$this->erro_banco = str_replace("", "", @pg_last_error());
					$this->erro_sql = "Verifique o cadastro da sequencia: emp202019_si109_sequencial_seq do campo: si109_sequencial";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
				$this->si109_sequencial = pg_result($result, 0, 0);
			} else {
				$result = db_query("select last_value from emp202019_si109_sequencial_seq");
				if (($result != false) && (pg_result($result, 0, 0) < $si109_sequencial)) {
					$this->erro_sql = " Campo si109_sequencial maior que último número da sequencia.";
					$this->erro_banco = "Sequencia menor que este número.";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				} else {
					$this->si109_sequencial = $si109_sequencial;
				}
			}
			if (($this->si109_sequencial == null) || ($this->si109_sequencial == "")) {
				$this->erro_sql = " Campo si109_sequencial nao declarado.";
				$this->erro_banco = "Chave Primaria zerada.";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			$sql = "insert into emp202019(
                                       si109_sequencial
                                      ,si109_tiporegistro
                                      ,si109_codorgao
                                      ,si109_codunidadesub
                                      ,si109_nroempenho
                                      ,si109_dtempenho
                                      ,si109_nroreforco
                                      ,si109_dtreforco
                                      ,si109_codfontrecursos
                                      ,si109_vlreforco
                                      ,si109_mes
                                      ,si109_instit
                       )
                values (
                                $this->si109_sequencial
                               ,$this->si109_tiporegistro
                               ,$this->si109_codorgao
                               ,'$this->si109_codunidadesub'
                               ,$this->si109_nroempenho
                               ," . ($this->si109_dtempenho == "null" || $this->si109_dtempenho == "" ? "null" : "'" . $this->si109_dtempenho . "'") . "
                               ,$this->si109_nroreforco
                               ," . ($this->si109_dtreforco == "null" || $this->si109_dtreforco == "" ? "null" : "'" . $this->si109_dtreforco . "'") . "
                               ,$this->si109_codfontrecursos
                               ,$this->si109_vlreforco
                               ,$this->si109_mes
                               ,$this->si109_instit
                      )";
			$result = db_query($sql);
			if ($result == false) {
				$this->erro_banco = str_replace("", "", @pg_last_error());
				if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
					$this->erro_sql = "emp202019 ($this->si109_sequencial) nao Incluído. Inclusao Abortada.";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_banco = "emp202019 já Cadastrado";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				} else {
					$this->erro_sql = "emp202019 ($this->si109_sequencial) nao Incluído. Inclusao Abortada.";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				}
				$this->erro_status = "0";
				$this->numrows_incluir = 0;

				return false;
			}
			$this->erro_banco = "";
			$this->erro_sql = "Inclusao efetuada com Sucesso\n";
			$this->erro_sql .= "Valores : " . $this->si109_sequencial;
			$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
			$this->erro_status = "1";
			$this->numrows_incluir = pg_affected_rows($result);
//			$resaco = $this->sql_record($this->sql_query_file($this->si109_sequencial));
//			if (($resaco != false) || ($this->numrows != 0)) {
//				$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//				$acount = pg_result($resac, 0, 0);
//				$resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//				$resac = db_query("insert into db_acountkey values($acount,2010682,'$this->si109_sequencial','I')");
//				$resac = db_query("insert into db_acount values($acount,2010337,2010682,'','" . AddSlashes(pg_result($resaco, 0, 'si109_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010337,2010683,'','" . AddSlashes(pg_result($resaco, 0, 'si109_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010337,2010684,'','" . AddSlashes(pg_result($resaco, 0, 'si109_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010337,2010685,'','" . AddSlashes(pg_result($resaco, 0, 'si109_nroempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010337,2010686,'','" . AddSlashes(pg_result($resaco, 0, 'si109_nroreforco')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010337,2010687,'','" . AddSlashes(pg_result($resaco, 0, 'si109_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010337,2010688,'','" . AddSlashes(pg_result($resaco, 0, 'si109_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010337,2010689,'','" . AddSlashes(pg_result($resaco, 0, 'si109_vlreforco')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010337,2011621,'','" . AddSlashes(pg_result($resaco, 0, 'si109_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//			}

			return true;
		}

		// funcao para alteracao
		function alterar($si109_sequencial = null)
		{
			$this->atualizacampos();
			$sql = " update emp202019 set ";
			$virgula = "";
			if (trim($this->si109_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si109_sequencial"])) {
				if (trim($this->si109_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si109_sequencial"])) {
					$this->si109_sequencial = "0";
				}
				$sql .= $virgula . " si109_sequencial = $this->si109_sequencial ";
				$virgula = ",";
			}
			if (trim($this->si109_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si109_tiporegistro"])) {
				$sql .= $virgula . " si109_tiporegistro = $this->si109_tiporegistro ";
				$virgula = ",";
				if (trim($this->si109_tiporegistro) == null) {
					$this->erro_sql = " Campo Tipo do  registro nao Informado.";
					$this->erro_campo = "si109_tiporegistro";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si109_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si109_codunidadesub"])) {
				$sql .= $virgula . " si109_codunidadesub = '$this->si109_codunidadesub' ";
				$virgula = ",";
			}
			if (trim($this->si109_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si109_codorgao"])) {
				$sql .= $virgula . " si109_codorgao = '$this->si109_codorgao' ";
				$virgula = ",";
			}
			if (trim($this->si109_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si109_codunidadesub"])) {
				$sql .= $virgula . " si109_codunidadesub = '$this->si109_codunidadesub' ";
				$virgula = ",";
			}
			if (trim($this->si109_nroempenho) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si109_nroempenho"])) {
				if (trim($this->si109_nroempenho) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si109_nroempenho"])) {
					$this->si109_nroempenho = "0";
				}
				$sql .= $virgula . " si109_nroempenho = $this->si109_nroempenho ";
				$virgula = ",";
			}
			if (trim($this->si109_dtempenho) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si109_dtempenho"])) {
				$sql .= $virgula . " si109_dtempenho = '$this->si109_dtempenho' ";
				$virgula = ",";
			}

			if (trim($this->si109_nroreforco) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si109_nroreforco"])) {
				if (trim($this->si109_nroreforco) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si109_nroreforco"])) {
					$this->si109_nroreforco = "0";
				}
				$sql .= $virgula . " si109_nroreforco = $this->si109_nroreforco ";
				$virgula = ",";
			}
			if (trim($this->si109_dtreforco) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si109_dtreforco"])) {
				$sql .= $virgula . " si109_dtreforco = '$this->si109_dtreforco' ";
				$virgula = ",";
			}
			if (trim($this->si109_codfontrecursos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si109_codfontrecursos"])) {
				$sql .= $virgula . " si109_codfontrecursos = '$this->si109_codfontrecursos' ";
				$virgula = ",";
			}
      if (trim($this->si109_vlreforco) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si109_vlreforco"])) {
				$sql .= $virgula . " si109_vlreforco = '$this->si109_vlreforco' ";
				$virgula = ",";
			}
      if (trim($this->si109_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si109_mes"])) {
				$sql .= $virgula . " si109_mes = $this->si109_mes ";
				$virgula = ",";
				if (trim($this->si109_mes) == null) {
					$this->erro_sql = " Campo Mês nao Informado.";
					$this->erro_campo = "si109_mes";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si109_vlreforco) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si109_vlreforco"])) {
				if (trim($this->si109_vlreforco) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si109_vlreforco"])) {
					$this->si109_vlreforco = "0";
				}
				$sql .= $virgula . " si109_vlreforco = $this->si109_vlreforco ";
				$virgula = ",";
			}
			if (trim($this->si109_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si109_instit"])) {
				$sql .= $virgula . " si109_instit = $this->si109_instit ";
				$virgula = ",";
				if (trim($this->si109_instit) == null) {
					$this->erro_sql = " Campo Instituição nao Informado.";
					$this->erro_campo = "si109_instit";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			$sql .= " where ";
			if ($si109_sequencial != null) {
				$sql .= " si109_sequencial = $this->si109_sequencial";
			}
			$resaco = $this->sql_record($this->sql_query_file($this->si109_sequencial));
//			if ($this->numrows > 0) {
//				for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
//					$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//					$acount = pg_result($resac, 0, 0);
//					$resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//					$resac = db_query("insert into db_acountkey values($acount,2010682,'$this->si109_sequencial','A')");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si109_sequencial"]) || $this->si109_sequencial != "")
//						$resac = db_query("insert into db_acount values($acount,2010337,2010682,'" . AddSlashes(pg_result($resaco, $conresaco, 'si109_sequencial')) . "','$this->si109_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si109_tiporegistro"]) || $this->si109_tiporegistro != "")
//						$resac = db_query("insert into db_acount values($acount,2010337,2010683,'" . AddSlashes(pg_result($resaco, $conresaco, 'si109_tiporegistro')) . "','$this->si109_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si109_codunidadesub"]) || $this->si109_codunidadesub != "")
//						$resac = db_query("insert into db_acount values($acount,2010337,2010684,'" . AddSlashes(pg_result($resaco, $conresaco, 'si109_codunidadesub')) . "','$this->si109_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si109_nroempenho"]) || $this->si109_nroempenho != "")
//						$resac = db_query("insert into db_acount values($acount,2010337,2010685,'" . AddSlashes(pg_result($resaco, $conresaco, 'si109_nroempenho')) . "','$this->si109_nroempenho'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si109_nroreforco"]) || $this->si109_nroreforco != "")
//						$resac = db_query("insert into db_acount values($acount,2010337,2010686,'" . AddSlashes(pg_result($resaco, $conresaco, 'si109_nroreforco')) . "','$this->si109_nroreforco'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si109_codfontrecursos"]) || $this->si109_codfontrecursos != "")
//						$resac = db_query("insert into db_acount values($acount,2010337,2010687,'" . AddSlashes(pg_result($resaco, $conresaco, 'si109_codfontrecursos')) . "','$this->si109_codfontrecursos'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si109_mes"]) || $this->si109_mes != "")
//						$resac = db_query("insert into db_acount values($acount,2010337,2010688,'" . AddSlashes(pg_result($resaco, $conresaco, 'si109_mes')) . "','$this->si109_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si109_vlreforco"]) || $this->si109_vlreforco != "")
//						$resac = db_query("insert into db_acount values($acount,2010337,2010689,'" . AddSlashes(pg_result($resaco, $conresaco, 'si109_vlreforco')) . "','$this->si109_vlreforco'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si109_instit"]) || $this->si109_instit != "")
//						$resac = db_query("insert into db_acount values($acount,2010337,2011621,'" . AddSlashes(pg_result($resaco, $conresaco, 'si109_instit')) . "','$this->si109_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				}
//			}
			$result = db_query($sql);
			if ($result == false) {
				$this->erro_banco = str_replace("", "", @pg_last_error());
				$this->erro_sql = "emp202019 nao Alterado. Alteracao Abortada.\n";
				$this->erro_sql .= "Valores : " . $this->si109_sequencial;
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";
				$this->numrows_alterar = 0;

				return false;
			} else {
				if (pg_affected_rows($result) == 0) {
					$this->erro_banco = "";
					$this->erro_sql = "emp202019 nao foi Alterado. Alteracao Executada.\n";
					$this->erro_sql .= "Valores : " . $this->si109_sequencial;
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "1";
					$this->numrows_alterar = 0;

					return true;
				} else {
					$this->erro_banco = "";
					$this->erro_sql = "Alteração efetuada com Sucesso\n";
					$this->erro_sql .= "Valores : " . $this->si109_sequencial;
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "1";
					$this->numrows_alterar = pg_affected_rows($result);

					return true;
				}
			}
		}

		// funcao para exclusao
		function excluir($si109_sequencial = null, $dbwhere = null)
		{
			if ($dbwhere == null || $dbwhere == "") {
				$resaco = $this->sql_record($this->sql_query_file($si109_sequencial));
			} else {
				$resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
			}
//			if (($resaco != false) || ($this->numrows != 0)) {
//				for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
//					$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//					$acount = pg_result($resac, 0, 0);
//					$resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//					$resac = db_query("insert into db_acountkey values($acount,2010682,'$si109_sequencial','E')");
//					$resac = db_query("insert into db_acount values($acount,2010337,2010682,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si109_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010337,2010683,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si109_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010337,2010684,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si109_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010337,2010685,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si109_nroempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010337,2010686,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si109_nroreforco')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010337,2010687,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si109_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010337,2010688,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si109_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010337,2010689,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si109_vlreforco')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010337,2011621,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si109_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				}
//			}
			$sql = " delete from emp202019
                    where ";
			$sql2 = "";
			if ($dbwhere == null || $dbwhere == "") {
				if ($si109_sequencial != "") {
					if ($sql2 != "") {
						$sql2 .= " and ";
					}
					$sql2 .= " si109_sequencial = $si109_sequencial ";
				}
			} else {
				$sql2 = $dbwhere;
			}
			$result = db_query($sql . $sql2);
			if ($result == false) {
				$this->erro_banco = str_replace("", "", @pg_last_error());
				$this->erro_sql = "emp202019 nao Excluído. Exclusão Abortada.\n";
				$this->erro_sql .= "Valores : " . $si109_sequencial;
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";
				$this->numrows_excluir = 0;

				return false;
			} else {
				if (pg_affected_rows($result) == 0) {
					$this->erro_banco = "";
					$this->erro_sql = "emp202019 nao Encontrado. Exclusão não Efetuada.\n";
					$this->erro_sql .= "Valores : " . $si109_sequencial;
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "1";
					$this->numrows_excluir = 0;

					return true;
				} else {
					$this->erro_banco = "";
					$this->erro_sql = "Exclusão efetuada com Sucesso\n";
					$this->erro_sql .= "Valores : " . $si109_sequencial;
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
				$this->erro_banco = str_replace("", "", @pg_last_error());
				$this->erro_sql = "Erro ao selecionar os registros.";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			$this->numrows = pg_numrows($result);
			if ($this->numrows == 0) {
				$this->erro_banco = "";
				$this->erro_sql = "Record Vazio na Tabela:emp202019";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}

			return $result;
		}

		// funcao do sql
		function sql_query($si109_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
			$sql .= " from emp202019 ";
			$sql2 = "";
      if ($dbwhere == "") {
				if ($si109_sequencial != null) {
					$sql2 .= " where emp202019.si109_sequencial = $si109_sequencial ";
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
		function sql_query_file($si109_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
			$sql .= " from emp202019 ";
			$sql2 = "";
			if ($dbwhere == "") {
				if ($si109_sequencial != null) {
					$sql2 .= " where emp202019.si109_sequencial = $si109_sequencial ";
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
