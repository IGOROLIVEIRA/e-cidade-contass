<?
	//MODULO: sicom
	//CLASSE DA ENTIDADE emp302020
	class cl_emp302020
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
		var $si206_sequencial = 0;
		var $si206_tiporegistro = 0;
		var $si206_codorgao = null;
		var $si206_codunidadesub = null;
		var $si206_nroempenho = 0;
		var $si206_dtempenho_dia = null;
		var $si206_dtempenho_mes = null;
		var $si206_dtempenho_ano = null;
		var $si206_dtempenho = null;
		var $si206_codorgaorespcontrato = null;
		var $si206_codunidadesubrespcontrato = null;
		var $si206_nrocontrato = 0;
		var $si206_dtassinaturacontrato_dia = null;
		var $si206_dtassinaturacontrato_mes = null;
		var $si206_dtassinaturacontrato_ano = null;
		var $si206_dtassinaturacontrato = null;
		var $si206_nrosequencialtermoaditivo = 0;
		var $si206_nroconvenio = null;
		var $si206_dtassinaturaconvenio_dia = null;
		var $si206_dtassinaturaconvenio_mes = null;
		var $si206_dtassinaturaconvenio_ano = null;
		var $si206_dtassinaturaconvenio = null;
		var $si206_dtassinaturaconge_dia = null;
		var $si206_dtassinaturaconge_mes = null;
		var $si206_dtassinaturaconge_ano = null;
		var $si206_nroconvenioconge = null;
		var $si206_dtassinaturaconge = null;
    var $si206_mes = 0;
		var $si206_instit = 0;
		// cria propriedade com as variaveis do arquivo
		var $campos = "
                 si206_sequencial = int8 = sequencial
                 si206_tiporegistro = int8 = Tipo do  registro
                 si206_codorgao = varchar(2) = Código do Órgão
                 si206_codunidadesub = varchar(8) = Código da unidade
                 si206_nroempenho = int8 = Número do  empenho
                 si206_dtempenho = date = Data do empenho
                 si206_codorgaorespcontrato = varchar(2) = Código do Órgão
                 si206_codunidadesubrespcontrato = varchar(8) = Código da unidade ou subunidade
                 si206_nrocontrato = int8 = Número do contrato
                 si206_dtassinaturacontrato = date = Data da assinatura
                 si206_nrosequencialtermoaditivo = int8 = Número sequencial do termo aditivo
                 si206_nroconvenio = varchar(30) = Número do convênio
                 si206_dtassinaturaconvenio = date = Data da assinatura do convênio
                 si206_nroconvenioconge = varchar(30) = Número do convênio conge
                 si206_dtassinaturaconge = date = Data da assinatura conge
                 si206_mes = int8 = Mês
                 si206_instit = int8 = Instituição
                 ";

		//funcao construtor da classe
		function cl_emp302020()
		{
			//classes dos rotulos dos campos
			$this->rotulo = new rotulo("emp302020");
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
				$this->si206_sequencial = ($this->si206_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si206_sequencial"] : $this->si206_sequencial);
				$this->si206_tiporegistro = ($this->si206_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si206_tiporegistro"] : $this->si206_tiporegistro);
				$this->si206_codunidadesub = ($this->si206_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si206_codunidadesub"] : $this->si206_codunidadesub);
				$this->si206_codorgao = ($this->si206_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si206_codorgao"] : $this->si206_codorgao);
				$this->si206_codunidadesub = ($this->si206_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si206_codunidadesub"] : $this->si206_codunidadesub);
				$this->si206_nroempenho = ($this->si206_nroempenho == "" ? @$GLOBALS["HTTP_POST_VARS"]["si206_nroempenho"] : $this->si206_nroempenho);
				if ($this->si206_dtempenho == "") {
					$this->si206_dtempenho_dia = ($this->si206_dtempenho_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si206_dtempenho_dia"] : $this->si206_dtempenho_dia);
					$this->si206_dtempenho_mes = ($this->si206_dtempenho_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si206_dtempenho_mes"] : $this->si206_dtempenho_mes);
					$this->si206_dtempenho_ano = ($this->si206_dtempenho_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si206_dtempenho_ano"] : $this->si206_dtempenho_ano);
					if ($this->si206_dtempenho_dia != "") {
						$this->si206_dtempenho = $this->si206_dtempenho_ano . "-" . $this->si206_dtempenho_mes . "-" . $this->si150_dtpublicacaoleiautorizacao_dia;
					}
				}
				$this->si206_codorgaorespcontrato = ($this->si206_codorgaorespcontrato == "" ? @$GLOBALS["HTTP_POST_VARS"]["si206_codorgaorespcontrato"] : $this->si206_codorgaorespcontrato);
				$this->si206_codunidadesubrespcontrato = ($this->si206_codunidadesubrespcontrato == "" ? @$GLOBALS["HTTP_POST_VARS"]["si206_codunidadesubrespcontrato"] : $this->si206_codunidadesubrespcontrato);
				$this->si206_nrocontrato = ($this->si206_nrocontrato == "" ? @$GLOBALS["HTTP_POST_VARS"]["si206_nrocontrato"] : $this->si206_nrocontrato);
				if ($this->si206_dtassinaturacontrato == "") {
					$this->si206_dtassinaturacontrato_dia = ($this->si206_dtassinaturacontrato_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si206_dtassinaturacontrato_dia"] : $this->si206_dtassinaturacontrato_dia);
					$this->si206_dtassinaturacontrato_mes = ($this->si206_dtassinaturacontrato_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si206_dtassinaturacontrato_mes"] : $this->si206_dtassinaturacontrato_mes);
					$this->si206_dtassinaturacontrato_ano = ($this->si206_dtassinaturacontrato_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si206_dtassinaturacontrato_ano"] : $this->si206_dtassinaturacontrato_ano);
					if ($this->si206_dtassinaturacontrato_dia != "") {
						$this->si206_dtassinaturacontrato = $this->si206_dtassinaturacontrato_ano . "-" . $this->si206_dtassinaturacontrato_mes . "-" . $this->si150_dtpublicacaoleiautorizacao_dia;
					}
				}
				$this->si206_nrosequencialtermoaditivo = ($this->si206_nrosequencialtermoaditivo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si206_nrosequencialtermoaditivo"] : $this->si206_nrosequencialtermoaditivo);
				$this->si206_nroconvenio = ($this->si206_nroconvenio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si206_nroconvenio"] : $this->si206_nroconvenio);
				if ($this->si206_dtassinaturacontrato == "") {
					$this->si206_dtassinaturacontrato_dia = ($this->si206_dtassinaturacontrato_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si206_dtassinaturacontrato_dia"] : $this->si206_dtassinaturacontrato_dia);
					$this->si206_dtassinaturacontrato_mes = ($this->si206_dtassinaturacontrato_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si206_dtassinaturacontrato_mes"] : $this->si206_dtassinaturacontrato_mes);
					$this->si206_dtassinaturacontrato_ano = ($this->si206_dtassinaturacontrato_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si206_dtassinaturacontrato_ano"] : $this->si206_dtassinaturacontrato_ano);
					if ($this->si206_dtassinaturacontrato_dia != "") {
						$this->si206_dtassinaturacontrato = $this->si206_dtassinaturacontrato_ano . "-" . $this->si206_dtassinaturacontrato_mes . "-" . $this->si150_dtpublicacaoleiautorizacao_dia;
					}
				}
				$this->si206_nroconvenioconge = ($this->si206_nroconvenioconge == "" ? @$GLOBALS["HTTP_POST_VARS"]["si206_nroconvenioconge"] : $this->si206_nroconvenioconge);
				if ($this->si206_dtassinaturaconge == "") {
					$this->si206_dtassinaturaconge_dia = ($this->si206_dtassinaturaconge_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si206_dtassinaturaconge_dia"] : $this->si206_dtassinaturaconge_dia);
					$this->si206_dtassinaturaconge_mes = ($this->si206_dtassinaturaconge_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si206_dtassinaturaconge_mes"] : $this->si206_dtassinaturaconge_mes);
					$this->si206_dtassinaturaconge_ano = ($this->si206_dtassinaturaconge_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si206_dtassinaturaconge_ano"] : $this->si206_dtassinaturaconge_ano);
					if ($this->si206_dtassinaturaconge_dia != "") {
						$this->si206_dtassinaturaconge = $this->si206_dtassinaturaconge_ano . "-" . $this->si206_dtassinaturaconge_mes . "-" . $this->si150_dtpublicacaoleiautorizacao_dia;
					}
				}

				$this->si206_mes = ($this->si206_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si206_mes"] : $this->si206_mes);
				$this->si206_instit = ($this->si206_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si206_instit"] : $this->si206_instit);
			} else {
				$this->si206_sequencial = ($this->si206_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si206_sequencial"] : $this->si206_sequencial);
			}
		}

		// funcao para inclusao
		function incluir($si206_sequencial)
		{
			$this->atualizacampos();
			if ($this->si206_tiporegistro == null) {
				$this->erro_sql = " Campo Tipo do  registro nao Informado.";
				$this->erro_campo = "si206_tiporegistro";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si206_codorgao == null) {
				$this->erro_sql = " Campo Código do órgão não Informado.";
				$this->erro_campo = "si206_codorgao";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si206_codunidadesub == null) {
				$this->erro_sql = " Campo Código da unidade ou subunidade não Informado.";
				$this->erro_campo = "si206_codunidadesub";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si206_nroempenho == null) {
				$this->erro_sql = " Campo Número do Empenho não Informado.";
				$this->erro_campo = "si206_nroempenho";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si206_dtempenho == null) {
        $this->erro_sql = " Campo Data do Empenho não Informado.";
        $this->erro_campo = "si206_dtempenho";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      if ($this->si206_mes == null) {
				$this->erro_sql = " Campo Mês nao Informado.";
				$this->erro_campo = "si206_mes";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si206_instit == null) {
				$this->erro_sql = " Campo Instituição nao Informado.";
				$this->erro_campo = "si206_instit";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($si206_sequencial == "" || $si206_sequencial == null) {
				$result = db_query("select nextval('emp302020_si206_sequencial_seq')");
				if ($result == false) {
					$this->erro_banco = str_replace("", "", @pg_last_error());
					$this->erro_sql = "Verifique o cadastro da sequencia: emp302020_si206_sequencial_seq do campo: si206_sequencial";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
				$this->si206_sequencial = pg_result($result, 0, 0);
			} else {
				$result = db_query("select last_value from emp302020_si206_sequencial_seq");
				if (($result != false) && (pg_result($result, 0, 0) < $si206_sequencial)) {
					$this->erro_sql = " Campo si206_sequencial maior que último número da sequencia.";
					$this->erro_banco = "Sequencia menor que este número.";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				} else {
					$this->si206_sequencial = $si206_sequencial;
				}
			}
			if (($this->si206_sequencial == null) || ($this->si206_sequencial == "")) {
				$this->erro_sql = " Campo si206_sequencial nao declarado.";
				$this->erro_banco = "Chave Primaria zerada.";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}

			$sql = "insert into emp302020(
                                       si206_sequencial
                                      ,si206_tiporegistro
                                      ,si206_codorgao
                                      ,si206_codunidadesub
                                      ,si206_nroempenho
                                      ,si206_dtempenho
                                      ,si206_codorgaorespcontrato
                                      ,si206_codunidadesubrespcontrato
                                      ,si206_nrocontrato
                                      ,si206_dtassinaturacontrato
                                      ,si206_nrosequencialtermoaditivo
                                      ,si206_nroconvenio
                                      ,si206_dtassinaturaconvenio
                                      ,si206_nroconvenioconge
                                      ,si206_dtassinaturaconge
                                      ,si206_mes
                                      ,si206_instit
                       )
                values (
                                $this->si206_sequencial
                               ,$this->si206_tiporegistro
                               ,'$this->si206_codorgao'
                               ,'$this->si206_codunidadesub'
                               ,$this->si206_nroempenho
                               ," . ($this->si206_dtempenho == "null" || $this->si206_dtempenho == "" ? "null" : "'" . $this->si206_dtempenho . "'") . "
                               ,'$this->si206_codorgaorespcontrato'
                               ,'$this->si206_codunidadesubrespcontrato'
                               ," . ($this->si206_nrocontrato == "null" || $this->si206_nrocontrato == "" ? "null" : "'" . $this->si206_nrocontrato . "'") . "
                               ," . ($this->si206_dtassinaturacontrato == "null" || $this->si206_dtassinaturacontrato == "" ? "null" : "'" . $this->si206_dtassinaturacontrato . "'") . "
                               ," . ($this->si206_nrosequencialtermoaditivo == "null" || $this->si206_nrosequencialtermoaditivo == "" ? "null" : "'" . $this->si206_nrosequencialtermoaditivo . "'") . "
                               ,'$this->si206_nroconvenio'
                               ," . ($this->si206_dtassinaturaconvenio == "null" || $this->si206_dtassinaturaconvenio == "" ? "null" : "'" . $this->si206_dtassinaturaconvenio . "'") . "
                               ,'$this->si206_nroconvenioconge'
                               ," . ($this->si206_dtassinaturaconge == "null" || $this->si206_dtassinaturaconge == "" ? "null" : "'" . $this->si206_dtassinaturaconge . "'") . "
                               ,$this->si206_mes
                               ,$this->si206_instit
                      )";

			$result = db_query($sql);
			if ($result == false) {
				$this->erro_banco = str_replace("", "", @pg_last_error());
				if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
					$this->erro_sql = "emp302020 ($this->si206_sequencial) nao Incluído. Inclusao Abortada.";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_banco = "emp302020 já Cadastrado";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				} else {
					$this->erro_sql = "emp302020 ($this->si206_sequencial) nao Incluído. Inclusao Abortada.";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				}
				$this->erro_status = "0";
				$this->numrows_incluir = 0;

				return false;
			}
			$this->erro_banco = "";
			$this->erro_sql = "Inclusao efetuada com Sucesso\n";
			$this->erro_sql .= "Valores : " . $this->si206_sequencial;
			$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
			$this->erro_status = "1";
			$this->numrows_incluir = pg_affected_rows($result);
//			$resaco = $this->sql_record($this->sql_query_file($this->si206_sequencial));
//			if (($resaco != false) || ($this->numrows != 0)) {
//				$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//				$acount = pg_result($resac, 0, 0);
//				$resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//				$resac = db_query("insert into db_acountkey values($acount,2010682,'$this->si206_sequencial','I')");
//				$resac = db_query("insert into db_acount values($acount,2010337,2010682,'','" . AddSlashes(pg_result($resaco, 0, 'si206_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010337,2010683,'','" . AddSlashes(pg_result($resaco, 0, 'si206_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010337,2010684,'','" . AddSlashes(pg_result($resaco, 0, 'si206_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010337,2010685,'','" . AddSlashes(pg_result($resaco, 0, 'si206_nroempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010337,2010686,'','" . AddSlashes(pg_result($resaco, 0, 'si206_nroreforco')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010337,2010687,'','" . AddSlashes(pg_result($resaco, 0, 'si206_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010337,2010688,'','" . AddSlashes(pg_result($resaco, 0, 'si206_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010337,2010689,'','" . AddSlashes(pg_result($resaco, 0, 'si206_vlreforco')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010337,2011621,'','" . AddSlashes(pg_result($resaco, 0, 'si206_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//			}

			return true;
		}

		// funcao para alteracao
		function alterar($si206_sequencial = null)
		{
			$this->atualizacampos();
			$sql = " update emp302020 set ";
			$virgula = "";
			if (trim($this->si206_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si206_sequencial"])) {
				if (trim($this->si206_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si206_sequencial"])) {
					$this->si206_sequencial = "0";
				}
				$sql .= $virgula . " si206_sequencial = $this->si206_sequencial ";
				$virgula = ",";
			}
			if (trim($this->si206_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si206_tiporegistro"])) {
				$sql .= $virgula . " si206_tiporegistro = $this->si206_tiporegistro ";
				$virgula = ",";
				if (trim($this->si206_tiporegistro) == null) {
					$this->erro_sql = " Campo Tipo do  registro nao Informado.";
					$this->erro_campo = "si206_tiporegistro";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si206_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si206_codorgao"])) {
				$sql .= $virgula . " si206_codorgao = '$this->si206_codorgao' ";
				$virgula = ",";
        if (trim($this->si206_tiporegistro) == null) {
          $this->erro_sql = " Campo Código Órgão nao Informado.";
          $this->erro_campo = "si206_codorgao";
          $this->erro_banco = "";
          $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
          $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
          $this->erro_status = "0";

          return false;
        }
			}
			if (trim($this->si206_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si206_codunidadesub"])) {
				$sql .= $virgula . " si206_codunidadesub = '$this->si206_codunidadesub' ";
				$virgula = ",";
        if (trim($this->si206_codunidadesub) == null) {
          $this->erro_sql = " Campo Código da unidade ou subunidade não Informado.";
          $this->erro_campo = "si206_codunidadesub";
          $this->erro_banco = "";
          $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
          $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
          $this->erro_status = "0";

          return false;
        }
			}
			if (trim($this->si206_nroempenho) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si206_nroempenho"])) {
				if (trim($this->si206_nroempenho) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si206_nroempenho"])) {
					$this->si206_nroempenho = "0";
				}
				$sql .= $virgula . " si206_nroempenho = $this->si206_nroempenho ";
				$virgula = ",";
        if (trim($this->si206_nroempenho) == null) {
          $this->erro_sql = " Campo Número do Empenho não Informado.";
          $this->erro_campo = "si206_nroempenho";
          $this->erro_banco = "";
          $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
          $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
          $this->erro_status = "0";

          return false;
        }
			}
			if (trim($this->si206_dtempenho) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si206_dtempenho"])) {
        $sql .= $virgula . " si206_dtempenho = '$this->si206_dtempenho' ";
        $virgula = ",";
        if (trim($this->si206_dtempenho) == null) {
          $this->erro_sql = " Campo data do empenho não Informado.";
          $this->erro_campo = "si206_dtempenho";
          $this->erro_banco = "";
          $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
          $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
          $this->erro_status = "0";

          return false;
        }
      }

      if (trim($this->si206_codorgaorespcontrato) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si206_codorgaorespcontrato"])) {
        $sql .= $virgula . " si206_codorgaorespcontrato = '$this->si206_codorgaorespcontrato' ";
        $virgula = ",";
      }

      if (trim($this->si206_codunidadesubrespcontrato) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si206_codunidadesubrespcontrato"])) {
        $sql .= $virgula . " si206_codunidadesubrespcontrato = '$this->si206_codunidadesubrespcontrato' ";
        $virgula = ",";
      }

      if (trim($this->si206_nrocontrato) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si206_nrocontrato"])) {
        $sql .= $virgula . " si206_nrocontrato = '$this->si206_nrocontrato' ";
        $virgula = ",";
      }

      if (trim($this->si206_dtassinaturacontrato) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si206_dtassinaturacontrato"])) {
        $sql .= $virgula . " si206_dtassinaturacontrato = '$this->si206_dtassinaturacontrato' ";
        $virgula = ",";
      }

      if (trim($this->si206_nrosequencialtermoaditivo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si206_nrosequencialtermoaditivo"])) {
        $sql .= $virgula . " si206_nrosequencialtermoaditivo = '$this->si206_nrosequencialtermoaditivo' ";
        $virgula = ",";
      }

      if (trim($this->si206_nroconvenio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si206_nroconvenio"])) {
        $sql .= $virgula . " si206_nroconvenio = '$this->si206_nroconvenio' ";
        $virgula = ",";
      }

      if (trim($this->si206_dtassinaturaconvenio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si206_dtassinaturaconvenio"])) {
        $sql .= $virgula . " si206_dtassinaturaconvenio = '$this->si206_dtassinaturaconvenio' ";
        $virgula = ",";
      }

      if (trim($this->si206_nroconvenioconge) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si206_nroconvenioconge"])) {
        $sql .= $virgula . " si206_nroconvenioconge = '$this->si206_nroconvenioconge' ";
        $virgula = ",";
      }

      if (trim($this->si206_dtassinaturaconge) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si206_dtassinaturaconge"])) {
				$sql .= $virgula . " si206_dtassinaturaconge = '$this->si206_dtassinaturaconge' ";
				$virgula = ",";
			}

      if (trim($this->si206_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si206_mes"])) {
				$sql .= $virgula . " si206_mes = $this->si206_mes ";
				$virgula = ",";
				if (trim($this->si206_mes) == null) {
					$this->erro_sql = " Campo Mês nao Informado.";
					$this->erro_campo = "si206_mes";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si206_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si206_instit"])) {
				$sql .= $virgula . " si206_instit = $this->si206_instit ";
				$virgula = ",";
				if (trim($this->si206_instit) == null) {
					$this->erro_sql = " Campo Instituição nao Informado.";
					$this->erro_campo = "si206_instit";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			$sql .= " where ";
			if ($si206_sequencial != null) {
				$sql .= " si206_sequencial = $this->si206_sequencial";
			}
			$resaco = $this->sql_record($this->sql_query_file($this->si206_sequencial));
//			if ($this->numrows > 0) {
//				for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
//					$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//					$acount = pg_result($resac, 0, 0);
//					$resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//					$resac = db_query("insert into db_acountkey values($acount,2010682,'$this->si206_sequencial','A')");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si206_sequencial"]) || $this->si206_sequencial != "")
//						$resac = db_query("insert into db_acount values($acount,2010337,2010682,'" . AddSlashes(pg_result($resaco, $conresaco, 'si206_sequencial')) . "','$this->si206_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si206_tiporegistro"]) || $this->si206_tiporegistro != "")
//						$resac = db_query("insert into db_acount values($acount,2010337,2010683,'" . AddSlashes(pg_result($resaco, $conresaco, 'si206_tiporegistro')) . "','$this->si206_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si206_codunidadesub"]) || $this->si206_codunidadesub != "")
//						$resac = db_query("insert into db_acount values($acount,2010337,2010684,'" . AddSlashes(pg_result($resaco, $conresaco, 'si206_codunidadesub')) . "','$this->si206_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si206_nroempenho"]) || $this->si206_nroempenho != "")
//						$resac = db_query("insert into db_acount values($acount,2010337,2010685,'" . AddSlashes(pg_result($resaco, $conresaco, 'si206_nroempenho')) . "','$this->si206_nroempenho'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si206_nroreforco"]) || $this->si206_nroreforco != "")
//						$resac = db_query("insert into db_acount values($acount,2010337,2010686,'" . AddSlashes(pg_result($resaco, $conresaco, 'si206_nroreforco')) . "','$this->si206_nroreforco'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si206_codfontrecursos"]) || $this->si206_codfontrecursos != "")
//						$resac = db_query("insert into db_acount values($acount,2010337,2010687,'" . AddSlashes(pg_result($resaco, $conresaco, 'si206_codfontrecursos')) . "','$this->si206_codfontrecursos'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si206_mes"]) || $this->si206_mes != "")
//						$resac = db_query("insert into db_acount values($acount,2010337,2010688,'" . AddSlashes(pg_result($resaco, $conresaco, 'si206_mes')) . "','$this->si206_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si206_vlreforco"]) || $this->si206_vlreforco != "")
//						$resac = db_query("insert into db_acount values($acount,2010337,2010689,'" . AddSlashes(pg_result($resaco, $conresaco, 'si206_vlreforco')) . "','$this->si206_vlreforco'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si206_instit"]) || $this->si206_instit != "")
//						$resac = db_query("insert into db_acount values($acount,2010337,2011621,'" . AddSlashes(pg_result($resaco, $conresaco, 'si206_instit')) . "','$this->si206_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				}
//			}
			$result = db_query($sql);
			if ($result == false) {
				$this->erro_banco = str_replace("", "", @pg_last_error());
				$this->erro_sql = "emp302020 nao Alterado. Alteracao Abortada.\n";
				$this->erro_sql .= "Valores : " . $this->si206_sequencial;
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";
				$this->numrows_alterar = 0;

				return false;
			} else {
				if (pg_affected_rows($result) == 0) {
					$this->erro_banco = "";
					$this->erro_sql = "emp302020 nao foi Alterado. Alteracao Executada.\n";
					$this->erro_sql .= "Valores : " . $this->si206_sequencial;
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "1";
					$this->numrows_alterar = 0;

					return true;
				} else {
					$this->erro_banco = "";
					$this->erro_sql = "Alteração efetuada com Sucesso\n";
					$this->erro_sql .= "Valores : " . $this->si206_sequencial;
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "1";
					$this->numrows_alterar = pg_affected_rows($result);

					return true;
				}
			}
		}

		// funcao para exclusao
		function excluir($si206_sequencial = null, $dbwhere = null)
		{
			if ($dbwhere == null || $dbwhere == "") {
				$resaco = $this->sql_record($this->sql_query_file($si206_sequencial));
			} else {
				$resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
			}
//			if (($resaco != false) || ($this->numrows != 0)) {
//				for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
//					$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//					$acount = pg_result($resac, 0, 0);
//					$resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//					$resac = db_query("insert into db_acountkey values($acount,2010682,'$si206_sequencial','E')");
//					$resac = db_query("insert into db_acount values($acount,2010337,2010682,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si206_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010337,2010683,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si206_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010337,2010684,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si206_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010337,2010685,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si206_nroempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010337,2010686,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si206_nroreforco')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010337,2010687,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si206_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010337,2010688,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si206_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010337,2010689,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si206_vlreforco')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010337,2011621,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si206_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				}
//			}
			$sql = " delete from emp302020
                    where ";
			$sql2 = "";
			if ($dbwhere == null || $dbwhere == "") {
				if ($si206_sequencial != "") {
					if ($sql2 != "") {
						$sql2 .= " and ";
					}
					$sql2 .= " si206_sequencial = $si206_sequencial ";
				}
			} else {
				$sql2 = $dbwhere;
			}
			$result = db_query($sql . $sql2);
			if ($result == false) {
				$this->erro_banco = str_replace("", "", @pg_last_error());
				$this->erro_sql = "emp302020 nao Excluído. Exclusão Abortada.\n";
				$this->erro_sql .= "Valores : " . $si206_sequencial;
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";
				$this->numrows_excluir = 0;

				return false;
			} else {
				if (pg_affected_rows($result) == 0) {
					$this->erro_banco = "";
					$this->erro_sql = "emp302020 nao Encontrado. Exclusão não Efetuada.\n";
					$this->erro_sql .= "Valores : " . $si206_sequencial;
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
					$this->erro_status = "1";
					$this->numrows_excluir = 0;

					return true;
				} else {
					$this->erro_banco = "";
					$this->erro_sql = "Exclusão efetuada com Sucesso\n";
					$this->erro_sql .= "Valores : " . $si206_sequencial;
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
				$this->erro_sql = "Record Vazio na Tabela:emp302020";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "0";

				return false;
			}

			return $result;
		}

		// funcao do sql
		function sql_query($si206_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
			$sql .= " from emp302020 ";
		  $sql2 = "";
			if ($dbwhere == "") {
				if ($si206_sequencial != null) {
					$sql2 .= " where emp302020.si206_sequencial = $si206_sequencial ";
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
		function sql_query_file($si206_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
			$sql .= " from emp302020 ";
			$sql2 = "";
			if ($dbwhere == "") {
				if ($si206_sequencial != null) {
					$sql2 .= " where emp302020.si206_sequencial = $si206_sequencial ";
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
