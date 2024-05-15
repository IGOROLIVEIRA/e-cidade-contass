<?php
	/**
	 * Created by Victor F.
	 * User: contass
	 * Date: 24/01/19
	 * Time: 10:02
	 */

	//MODULO: sicom
	//CLASSE DA ENTIDADE cute302021
	class cl_cute302021
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
		var $si202_sequencial = 0;
		var $si202_tiporegistro = 0;
		var $si202_codorgao = null;
		var $si202_codctb = 0;
		var $si202_situacaoconta = null;
		var $si202_datasituacao_dia = null;
		var $si202_datasituacao_mes = null;
		var $si202_datasituacao_ano = null;
		var $si202_datasituacao = null;
		var $si202_mes = 0;
		var $si202_instit = 0;
		// cria propriedade com as variaveis do arquivo
		var $campos = "
                 si202_sequencial = int8 = Sequencial 
                 si202_tiporegistro = int8 = Tipo do registro 
                 si202_codorgao = varchar(2) = Código do órgão
                 si202_codctb = int8 = Código da identificador da conta 
                 si202_situacaoconta = varchar(1) = Situação atual  
                 si202_datasituacao = date = Data da situação 
                 si202_mes = int8 = Mês 
                 si202_instit = int8 = Instituição
                 ";

		//funcao construtor da classe
		function cl_cute302021()
		{
			//classes dos rotulos dos campos
			$this->rotulo = new rotulo("cute302021");
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
				$this->si202_sequencial = ($this->si202_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si202_sequencial"] : $this->si202_sequencial);
				$this->si202_tiporegistro = ($this->si202_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si202_tiporegistro"] : $this->si202_tiporegistro);
				$this->si202_codorgao = ($this->si202_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si202_codorgao"] : $this->si202_codorgao);
				$this->si202_codctb = ($this->si202_codctb == "" ? @$GLOBALS["HTTP_POST_VARS"]["si202_codctb"] : $this->si202_codctb);
				$this->si202_situacaoconta = ($this->si202_situacaoconta == "" ? @$GLOBALS["HTTP_POST_VARS"]["si202_situacaoconta"] : $this->si202_situacaoconta);

				if($this->si202_datasituacao == ""){
					$this->si202_datasituacao_dia = ($this->si202_datasituacao_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si202_datasituacao_dia"] : $this->si202_datasituacao_dia);
					$this->si202_datasituacao_mes = ($this->si202_datasituacao_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si202_datasituacao_mes"] : $this->si202_datasituacao_mes);
					$this->si202_datasituacao_ano = ($this->si202_datasituacao_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si202_datasituacao_ano"] : $this->si202_datasituacao_ano);
					if ($this->si202_datasituacao_dia != "") {
						$this->si202_datasituacao = $this->si202_datasituacao_ano . "-" . $this->si202_datasituacao_mes . "-" . $this->si202_datasituacao_dia;
					}
				}

				$this->si202_mes = ($this->si202_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si202_mes"] : $this->si202_mes);
				$this->si202_instit = ($this->si202_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si202_instit"] : $this->si202_instit);
			} else {
				$this->si202_sequencial = ($this->si202_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si202_sequencial"] : $this->si202_sequencial);
			}
		}

		// funcao para inclusao
		function incluir($si202_sequencial)
		{
			$this->atualizacampos();
			if ($this->si202_tiporegistro == null) {
				$this->erro_sql = " Campo Tipo do registro nao Informado.";
				$this->erro_campo = "si202_tiporegistro";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si202_codorgao == null) {
				$this->si202_codorgao = "0";
			}
			if ($this->si202_codctb == null) {
				$this->si202_codctb = "0";
			}
			if ($this->si202_situacaoconta == null) {
				$this->si202_situacaoconta = "0";
			}
			if ($this->si202_datasituacao == null) {
				$this->si202_datasituacao = "0";
			}
			if ($this->si202_mes == null) {
				$this->erro_sql = " Campo Mês nao Informado.";
				$this->erro_campo = "si202_mes";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si202_instit == null) {
				$this->erro_sql = " Campo Instituição nao Informado.";
				$this->erro_campo = "si202_instit";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($si202_sequencial == "" || $si202_sequencial == null) {
				$result = db_query("select nextval('cute302021_si202_sequencial_seq')");
				if ($result == false) {
					$this->erro_codfontrecursos = str_replace("", "", @pg_last_error());
					$this->erro_sql = "Verifique o cadastro da sequencia: cute302021_si202_sequencial_seq do campo: si202_sequencial";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
					$this->erro_status = "0";

					return false;
				}
				$this->si202_sequencial = pg_result($result, 0, 0);
			} else {
				$result = db_query("select last_value from cute302021_si202_sequencial_seq");
				if (($result != false) && (pg_result($result, 0, 0) < $si202_sequencial)) {
					$this->erro_sql = " Campo si202_sequencial maior que último número da sequencia.";
					$this->erro_codfontrecursos = "Sequencia menor que este número.";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
					$this->erro_status = "0";

					return false;
				} else {
					$this->si202_sequencial = $si202_sequencial;
				}
			}
			if (($this->si202_sequencial == null) || ($this->si202_sequencial == "")) {
				$this->erro_sql = " Campo si202_sequencial nao declarado.";
				$this->erro_codfontrecursos = "Chave Primaria zerada.";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
				$this->erro_status = "0";

				return false;
			}
			$sql = "insert into cute302021(
                                       si202_sequencial 
                                      ,si202_tiporegistro 
                                      ,si202_codorgao
                                      ,si202_codctb
                                      ,si202_situacaoconta 
                                      ,si202_datasituacao
                                      ,si202_mes 
                                      ,si202_instit 
                       )
                values (
                                $this->si202_sequencial 
                               ,$this->si202_tiporegistro 
                               ,'$this->si202_codorgao'
                               ,$this->si202_codctb 
                               ,$this->si202_situacaoconta 
                               ," . ($this->si202_datasituacao == "null" || $this->si202_datasituacao == "" ? "null" : "'" . $this->si202_datasituacao . "'") . " 
                               ,$this->si202_mes 
                               ,$this->si202_instit 
                      )";
			$result = db_query($sql);
			if ($result == false) {
				$this->erro_codfontrecursos = str_replace("", "", @pg_last_error());
				if (strpos(strtolower($this->erro_codfontrecursos), "duplicate key") != 0) {
					$this->erro_sql = "cute302021 ($this->si202_sequencial) nao Incluído. Inclusao Abortada.";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_codfontrecursos = "cute302021 já Cadastrado";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
				} else {
					$this->erro_sql = "cute302021 ($this->si202_sequencial) nao Incluído. Inclusao Abortada.";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
				}
				$this->erro_status = "0";
				$this->numrows_incluir = 0;

				return false;
			}
			$this->erro_codfontrecursos = "";
			$this->erro_sql = "Inclusao efetuada com Sucesso\n";
			$this->erro_sql .= "Valores : " . $this->si202_sequencial;
			$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
			$this->erro_status = "1";
			$this->numrows_incluir = pg_affected_rows($result);
			$resaco = $this->sql_record($this->sql_query_file($this->si202_sequencial));
//			if (($resaco != false) || ($this->numrows != 0)) {
//				$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//				$acount = pg_result($resac, 0, 0);
//				$resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//				$resac = db_query("insert into db_acountkey values($acount,2010632,'$this->si202_sequencial','I')");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010632,'','" . AddSlashes(pg_result($resaco, 0, 'si202_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010633,'','" . AddSlashes(pg_result($resaco, 0, 'si202_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010634,'','" . AddSlashes(pg_result($resaco, 0, 'si202_tipoconta')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010635,'','" . AddSlashes(pg_result($resaco, 0, 'si202_codctb')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010636,'','" . AddSlashes(pg_result($resaco, 0, 'si202_identificadordeducao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010637,'','" . AddSlashes(pg_result($resaco, 0, 'si202_naturezareceita')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010638,'','" . AddSlashes(pg_result($resaco, 0, 'si202_tipomovimentacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010639,'','" . AddSlashes(pg_result($resaco, 0, 'si202_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010640,'','" . AddSlashes(pg_result($resaco, 0, 'si202_situacaoconta')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2011618,'','" . AddSlashes(pg_result($resaco, 0, 'si202_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//			}

			return true;
		}

		// funcao para alteracao
		function alterar($si202_sequencial = null)
		{
			$this->atualizacampos();
			$sql = " update cute302021 set ";
			$virgula = "";
			if (trim($this->si202_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si202_sequencial"])) {
				if (trim($this->si202_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si202_sequencial"])) {
					$this->si202_sequencial = "0";
				}
				$sql .= $virgula . " si202_sequencial = $this->si202_sequencial ";
				$virgula = ",";
			}
			if (trim($this->si202_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si202_tiporegistro"])) {
				$sql .= $virgula . " si202_tiporegistro = $this->si202_tiporegistro ";
				$virgula = ",";
				if (trim($this->si202_tiporegistro) == null) {
					$this->erro_sql = " Campo Tipo do registro nao Informado.";
					$this->erro_campo = "si202_tiporegistro";
					$this->erro_codfontrecursos = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
			if (trim($this->si202_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si202_codorgao"])) {
				if (trim($this->si202_codorgao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si202_codorgao"])) {
					$this->si202_codorgao = "0";
				}
				$sql .= $virgula . " si202_codorgao = $this->si202_codorgao ";
				$virgula = ",";
			}
			if (trim($this->si202_codctb) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si202_codctb"])) {
				if (trim($this->si202_codctb) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si202_codctb"])) {
					$this->si202_codctb = "0";
				}
				$sql .= $virgula . " si202_codctb = $this->si202_codctb ";
				$virgula = ",";
			}
			if (trim($this->si202_situacaoconta) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si202_situacaoconta"])) {
				if (trim($this->si202_situacaoconta) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si202_situacaoconta"])) {
					$this->si202_situacaoconta = "0";
				}
				$sql .= $virgula . " si202_situacaoconta = $this->si202_situacaoconta ";
				$virgula = ",";
			}
			if (trim($this->si202_datasituacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si202_datasituacao_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si202_datasituacao_dia"] != "")) {
				$sql .= $virgula . " si202_datasituacao = '$this->si202_datasituacao' ";
				$virgula = ",";
			}else {
				if (isset($GLOBALS["HTTP_POST_VARS"]["si202_datasituacao"])) {
					$sql .= $virgula . " si202_datasituacao = null ";
					$virgula = ",";
				}
			}
			if (trim($this->si202_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si202_mes"])) {
				$sql .= $virgula . " si202_mes = $this->si202_mes ";
				$virgula = ",";
				if (trim($this->si202_mes) == null) {
					$this->erro_sql = " Campo Mês nao Informado.";
					$this->erro_campo = "si202_mes";
					$this->erro_codfontrecursos = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
					$this->erro_status = "0";

					return false;
				}
			if (trim($this->si202_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si202_instit"])) {
				$sql .= $virgula . " si202_instit = $this->si202_instit ";
				$virgula = ",";
				if (trim($this->si202_instit) == null) {
					$this->erro_sql = " Campo Instituição nao Informado.";
					$this->erro_campo = "si202_instit";
					$this->erro_codfontrecursos = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
		}
			$sql .= " where ";
			if ($si202_sequencial != null) {
				$sql .= " si202_sequencial = $this->si202_sequencial";
			}
//			$resaco = $this->sql_record($this->sql_query_file($this->si202_sequencial));
//			if ($this->numrows > 0) {
//				for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
//					$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//					$acount = pg_result($resac, 0, 0);
//					$resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//					$resac = db_query("insert into db_acountkey values($acount,2010632,'$this->si202_sequencial','A')");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si202_sequencial"]) || $this->si202_sequencial != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010632,'" . AddSlashes(pg_result($resaco, $conresaco, 'si202_sequencial')) . "','$this->si202_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si202_tiporegistro"]) || $this->si202_tiporegistro != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010633,'" . AddSlashes(pg_result($resaco, $conresaco, 'si202_tiporegistro')) . "','$this->si202_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si202_tipoconta"]) || $this->si202_tipoconta != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010634,'" . AddSlashes(pg_result($resaco, $conresaco, 'si202_tipoconta')) . "','$this->si202_tipoconta'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si202_codctb"]) || $this->si202_codctb != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010635,'" . AddSlashes(pg_result($resaco, $conresaco, 'si202_codctb')) . "','$this->si202_codctb'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si202_identificadordeducao"]) || $this->si202_identificadordeducao != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010636,'" . AddSlashes(pg_result($resaco, $conresaco, 'si202_identificadordeducao')) . "','$this->si202_identificadordeducao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si202_naturezareceita"]) || $this->si202_naturezareceita != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010637,'" . AddSlashes(pg_result($resaco, $conresaco, 'si202_naturezareceita')) . "','$this->si202_naturezareceita'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si202_tipomovimentacao"]) || $this->si202_tipomovimentacao != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010638,'" . AddSlashes(pg_result($resaco, $conresaco, 'si202_tipomovimentacao')) . "','$this->si202_tipomovimentacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si202_mes"]) || $this->si202_mes != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010639,'" . AddSlashes(pg_result($resaco, $conresaco, 'si202_mes')) . "','$this->si202_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si202_situacaoconta"]) || $this->si202_situacaoconta != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010640,'" . AddSlashes(pg_result($resaco, $conresaco, 'si202_situacaoconta')) . "','$this->si202_situacaoconta'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si202_instit"]) || $this->si202_instit != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2011618,'" . AddSlashes(pg_result($resaco, $conresaco, 'si202_instit')) . "','$this->si202_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				}
//			}
			$result = db_query($sql);
			if ($result == false) {
				$this->erro_codfontrecursos = str_replace("", "", @pg_last_error());
				$this->erro_sql = "cute302021 nao Alterado. Alteracao Abortada.\n";
				$this->erro_sql .= "Valores : " . $this->si202_sequencial;
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
				$this->erro_status = "0";
				$this->numrows_alterar = 0;

				return false;
			} else {
				if (pg_affected_rows($result) == 0) {
					$this->erro_codfontrecursos = "";
					$this->erro_sql = "cute302021 nao foi Alterado. Alteracao Executada.\n";
					$this->erro_sql .= "Valores : " . $this->si202_sequencial;
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
					$this->erro_status = "1";
					$this->numrows_alterar = 0;

					return true;
				} else {
					$this->erro_codfontrecursos = "";
					$this->erro_sql = "Alteração efetuada com Sucesso\n";
					$this->erro_sql .= "Valores : " . $this->si202_sequencial;
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
					$this->erro_status = "1";
					$this->numrows_alterar = pg_affected_rows($result);

					return true;
				}
			}
		}

		// funcao para exclusao
		function excluir($si202_sequencial = null, $dbwhere = null)
		{
			if ($dbwhere == null || $dbwhere == "") {
				$resaco = $this->sql_record($this->sql_query_file($si202_sequencial));
			} else {
				$resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
			}
//			if (($resaco != false) || ($this->numrows != 0)) {
//				for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
//					$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//					$acount = pg_result($resac, 0, 0);
//					$resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//					$resac = db_query("insert into db_acountkey values($acount,2010632,'$si202_sequencial','E')");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010632,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si202_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010633,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si202_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010634,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si202_tipoconta')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010635,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si202_codctb')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010636,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si202_identificadordeducao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010637,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si202_naturezareceita')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010638,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si202_tipomovimentacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010639,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si202_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010640,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si202_situacaoconta')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2011618,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si202_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				}
//			}
			$sql = " delete from cute302021
                    where ";
			$sql2 = "";
			if ($dbwhere == null || $dbwhere == "") {
				if ($si202_sequencial != "") {
					if ($sql2 != "") {
						$sql2 .= " and ";
					}
					$sql2 .= " si202_sequencial = $si202_sequencial ";
				}
			} else {
				$sql2 = $dbwhere;
			}
			$result = db_query($sql . $sql2);
			if ($result == false) {
				$this->erro_codfontrecursos = str_replace("", "", @pg_last_error());
				$this->erro_sql = "cute302021 nao Excluído. Exclusão Abortada.\n";
				$this->erro_sql .= "Valores : " . $si202_sequencial;
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
				$this->erro_status = "0";
				$this->numrows_excluir = 0;

				return false;
			} else {
				if (pg_affected_rows($result) == 0) {
					$this->erro_codfontrecursos = "";
					$this->erro_sql = "cute302021 nao Encontrado. Exclusão não Efetuada.\n";
					$this->erro_sql .= "Valores : " . $si202_sequencial;
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
					$this->erro_status = "1";
					$this->numrows_excluir = 0;

					return true;
				} else {
					$this->erro_codfontrecursos = "";
					$this->erro_sql = "Exclusão efetuada com Sucesso\n";
					$this->erro_sql .= "Valores : " . $si202_sequencial;
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
				$this->erro_sql = "Record Vazio na Tabela:cute302021";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
				$this->erro_status = "0";

				return false;
			}

			return $result;
		}

		// funcao do sql
		function sql_query($si202_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
			$sql .= " from cute302021 ";
			$sql .= "      left  join cute102020  on  cute102020.si199_sequencial = caixa212020.si202_datasituacao";
			$sql2 = "";
			if ($dbwhere == "") {
				if ($si202_sequencial != null) {
					$sql2 .= " where cute302021.si202_sequencial = $si202_sequencial ";
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
		function sql_query_file($si202_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
			$sql .= " from cute302021 ";
			$sql2 = "";
			if ($dbwhere == "") {
				if ($si202_sequencial != null) {
					$sql2 .= " where cute302021.si202_sequencial = $si202_sequencial ";
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
