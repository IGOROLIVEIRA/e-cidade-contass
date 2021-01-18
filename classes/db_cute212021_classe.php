<?
	/**
	 * Created by Victor F.
	 * User: contass
	 * Date: 24/01/19
	 * Time: 10:02
	 */
	//MODULO: sicom
	//CLASSE DA ENTIDADE cute212021
	class cl_cute212021
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
		var $si201_sequencial = 0;
		var $si201_tiporegistro = 0;
		var $si201_codctb = 0;
		var $si201_codfontrecursos = 0;
		var $si201_tipomovimentacao = 0;
		var $si201_tipoentrsaida = "";
		var $si201_valorentrsaida = 0;
		var $si201_codorgaotransf = null;
		var $si201_mes = 0;
		var $si201_instit = 0;
		var $si201_reg10 = 0;
		// cria propriedade com as variaveis do arquivo
		var $campos = "
                 si201_sequencial = int8 = Sequencial 
                 si201_tiporegistro = int8 = Tipo do registro 
                 si201_codctb = int8 = Código da identificador da conta 
                 si201_codfontrecursos = int8 = Código da fonte de recursos
                 si201_tipomovimentacao = int8 = Tipo de movimentação 
                 si201_tipoentrsaida = varchar(2) = Tipo de entrada ou saída 
                 si201_valorentrsaida = float8 = Valor da entrada  
                 si201_codorgaotransf = varchar(2) = Código do órgão
                 si201_reg10 = int8 = reg10 
                 si201_mes = int8 = Mês 
                 si201_instit = int8 = Instituição
                 ";

		//funcao construtor da classe
		function cl_cute212021()
		{
			//classes dos rotulos dos campos
			$this->rotulo = new rotulo("cute212021");
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
				$this->si201_sequencial = ($this->si201_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si201_sequencial"] : $this->si201_sequencial);
				$this->si201_tiporegistro = ($this->si201_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si201_tiporegistro"] : $this->si201_tiporegistro);
				$this->si201_codctb = ($this->si201_codctb == "" ? @$GLOBALS["HTTP_POST_VARS"]["si201_codctb"] : $this->si201_codctb);
				$this->si201_codfontrecursos = ($this->si201_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si201_codfontrecursos"] : $this->si201_codfontrecursos);
				$this->si201_tipomovimentacao = ($this->si201_tipomovimentacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si201_tipomovimentacao"] : $this->si201_tipomovimentacao);
				$this->si201_tipoentrsaida = ($this->si201_tipoentrsaida == "" ? @$GLOBALS["HTTP_POST_VARS"]["si201_tipoentrsaida"] : $this->si201_tipoentrsaida);
				$this->si201_valorentrsaida = ($this->si201_valorentrsaida == "" ? @$GLOBALS["HTTP_POST_VARS"]["si201_valorentrsaida"] : $this->si201_valorentrsaida);
				$this->si201_codorgaotransf = ($this->si201_codorgaotransf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si201_codorgaotransf"] : $this->si201_codorgaotransf);
				$this->si201_mes = ($this->si201_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si201_mes"] : $this->si201_mes);
				$this->si201_instit = ($this->si201_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si201_instit"] : $this->si201_instit);
				$this->si201_reg10 = ($this->si201_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si201_reg10"] : $this->si201_reg10);
			} else {
				$this->si201_sequencial = ($this->si201_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si201_sequencial"] : $this->si201_sequencial);
			}
		}

		// funcao para inclusao
		function incluir($si201_sequencial)
		{
			$this->atualizacampos();
			if ($this->si201_tiporegistro == null) {
				$this->erro_sql = " Campo Tipo do registro nao Informado.";
				$this->erro_campo = "si201_tiporegistro";
				$this->erro_codfontrecursos = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si201_codorgaotransf == null) {
				$this->si201_codorgaotransf = "0";
			}
			if ($this->si201_codctb == null) {
				$this->si201_codctb = "0";
			}
			if ($this->si201_codfontrecursos == null) {
				$this->si201_codfontrecursos = "0";
			}
			if ($this->si201_tipomovimentacao == null) {
				$this->si201_tipomovimentacao = "0";
			}
			if ($this->si201_valorentrsaida == null) {
				$this->si201_valorentrsaida = "0";
			}
			if ($this->si201_reg10 == null) {
				$this->si201_reg10 = "0";
			}
			if ($this->si201_mes == null) {
				$this->erro_sql = " Campo Mês nao Informado.";
				$this->erro_campo = "si201_mes";
				$this->erro_codfontrecursos = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($this->si201_instit == null) {
				$this->erro_sql = " Campo Instituição nao Informado.";
				$this->erro_campo = "si201_instit";
				$this->erro_codfontrecursos = "";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
				$this->erro_status = "0";

				return false;
			}
			if ($si201_sequencial == "" || $si201_sequencial == null) {
				$result = db_query("select nextval('cute212021_si201_sequencial_seq')");
				if ($result == false) {
					$this->erro_codfontrecursos = str_replace("", "", @pg_last_error());
					$this->erro_sql = "Verifique o cadastro da sequencia: cute212021_si201_sequencial_seq do campo: si201_sequencial";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
					$this->erro_status = "0";

					return false;
				}
				$this->si201_sequencial = pg_result($result, 0, 0);
			} else {
				$result = db_query("select last_value from cute212021_si201_sequencial_seq");
				if (($result != false) && (pg_result($result, 0, 0) < $si201_sequencial)) {
					$this->erro_sql = " Campo si201_sequencial maior que último número da sequencia.";
					$this->erro_codfontrecursos = "Sequencia menor que este número.";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
					$this->erro_status = "0";

					return false;
				} else {
					$this->si201_sequencial = $si201_sequencial;
				}
			}
			if (($this->si201_sequencial == null) || ($this->si201_sequencial == "")) {
				$this->erro_sql = " Campo si201_sequencial nao declarado.";
				$this->erro_codfontrecursos = "Chave Primaria zerada.";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
				$this->erro_status = "0";

				return false;
			}
			$sql = "insert into cute212021(
                                       si201_sequencial 
                                      ,si201_tiporegistro 
                                      ,si201_codctb
                                      ,si201_codfontrecursos
                                      ,si201_tipomovimentacao
                                      ,si201_tipoentrsaida
                                      ,si201_valorentrsaida 
                                      ,si201_codorgaotransf
                                      ,si201_reg10
                                      ,si201_mes 
                                      ,si201_instit 
                       )
                values (
                                $this->si201_sequencial 
                               ,$this->si201_tiporegistro 
                               ,$this->si201_codctb 
                               ,$this->si201_codfontrecursos
                               ,$this->si201_tipomovimentacao
                               ,'$this->si201_tipoentrsaida' 
                               ,$this->si201_valorentrsaida 
                               ,'$this->si201_codorgaotransf'
                               ,$this->si201_reg10 
                               ,$this->si201_mes 
                               ,$this->si201_instit 
                      )";
			$result = db_query($sql);
			if ($result == false) {
				$this->erro_codfontrecursos = str_replace("", "", @pg_last_error());
				if (strpos(strtolower($this->erro_codfontrecursos), "duplicate key") != 0) {
					$this->erro_sql = "cute212021 ($this->si201_sequencial) nao Incluído. Inclusao Abortada.";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_codfontrecursos = "cute212021 já Cadastrado";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
				} else {
					$this->erro_sql = "cute212021 ($this->si201_sequencial) nao Incluído. Inclusao Abortada.";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
				}
				$this->erro_status = "0";
				$this->numrows_incluir = 0;

				return false;
			}
			$this->erro_codfontrecursos = "";
			$this->erro_sql = "Inclusao efetuada com Sucesso\n";
			$this->erro_sql .= "Valores : " . $this->si201_sequencial;
			$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
			$this->erro_status = "1";
			$this->numrows_incluir = pg_affected_rows($result);
			$resaco = $this->sql_record($this->sql_query_file($this->si201_sequencial));
//			if (($resaco != false) || ($this->numrows != 0)) {
//				$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//				$acount = pg_result($resac, 0, 0);
//				$resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//				$resac = db_query("insert into db_acountkey values($acount,2010632,'$this->si201_sequencial','I')");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010632,'','" . AddSlashes(pg_result($resaco, 0, 'si201_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010633,'','" . AddSlashes(pg_result($resaco, 0, 'si201_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010634,'','" . AddSlashes(pg_result($resaco, 0, 'si201_tipoconta')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010635,'','" . AddSlashes(pg_result($resaco, 0, 'si201_codctb')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010636,'','" . AddSlashes(pg_result($resaco, 0, 'si201_identificadordeducao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010637,'','" . AddSlashes(pg_result($resaco, 0, 'si201_naturezareceita')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010638,'','" . AddSlashes(pg_result($resaco, 0, 'si201_tipomovimentacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010639,'','" . AddSlashes(pg_result($resaco, 0, 'si201_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2010640,'','" . AddSlashes(pg_result($resaco, 0, 'si201_valorentrsaida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				$resac = db_query("insert into db_acount values($acount,2010334,2011618,'','" . AddSlashes(pg_result($resaco, 0, 'si201_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//			}

			return true;
		}

		// funcao para alteracao
		function alterar($si201_sequencial = null)
		{
			$this->atualizacampos();
			$sql = " update cute212021 set ";
			$virgula = "";
			if (trim($this->si201_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si201_sequencial"])) {
				if (trim($this->si201_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si201_sequencial"])) {
					$this->si201_sequencial = "0";
				}
				$sql .= $virgula . " si201_sequencial = $this->si201_sequencial ";
				$virgula = ",";
			}
			if (trim($this->si201_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si201_tiporegistro"])) {
				$sql .= $virgula . " si201_tiporegistro = $this->si201_tiporegistro ";
				$virgula = ",";
				if (trim($this->si201_tiporegistro) == null) {
					$this->erro_sql = " Campo Tipo do registro nao Informado.";
					$this->erro_campo = "si201_tiporegistro";
					$this->erro_codfontrecursos = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}

			if (trim($this->si201_codctb) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si201_codctb"])) {
				if (trim($this->si201_codctb) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si201_codctb"])) {
					$this->si201_codctb = "0";
				}
				$sql .= $virgula . " si201_codctb = $this->si201_codctb ";
				$virgula = ",";
			}

			if (trim($this->si201_codfontrecursos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si201_codfontrecursos"])) {
				if (trim($this->si201_codfontrecursos) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si201_codfontrecursos"])) {
					$this->si201_codfontrecursos = "0";
				}
				$sql .= $virgula . " si201_codfontrecursos = $this->si201_codfontrecursos ";
				$virgula = ",";
			}

			if (trim($this->si201_tipomovimentacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si201_tipomovimentacao"])) {
				if (trim($this->si201_tipomovimentacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si201_tipomovimentacao"])) {
					$this->si201_tipomovimentacao = "0";
				}
				$sql .= $virgula . " si201_tipomovimentacao = $this->si201_tipomovimentacao ";
				$virgula = ",";
			}
			if (trim($this->si201_tipoentrsaida) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si201_tipoentrsaida"])) {
				if (trim($this->si201_tipoentrsaida) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si201_tipoentrsaida"])) {
					$this->si201_tipoentrsaida = "0";
				}
				$sql .= $virgula . " si201_tipoentrsaida = $this->si201_tipoentrsaida ";
				$virgula = ",";
			}
			if (trim($this->si201_valorentrsaida) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si201_valorentrsaida"])) {
				if (trim($this->si201_valorentrsaida) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si201_valorentrsaida"])) {
					$this->si201_valorentrsaida = "0";
				}
				$sql .= $virgula . " si201_valorentrsaida = $this->si201_valorentrsaida ";
				$virgula = ",";
			}
			if (trim($this->si201_codorgaotransf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si201_codorgaotransf"])) {
				if (trim($this->si201_codorgaotransf) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si201_codorgaotransf"])) {
					$this->si201_codorgaotransf = "0";
				}
				$sql .= $virgula . " si201_codorgaotransf = $this->si201_codorgaotransf ";
				$virgula = ",";
			}
			if (trim($this->si201_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si201_reg10"])) {
				if (trim($this->si201_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si201_reg10"])) {
					$this->si201_reg10 = "0";
				}
				$sql .= $virgula . " si201_reg10 = $this->si201_reg10 ";
				$virgula = ",";
			}
			if (trim($this->si201_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si201_mes"])) {
				$sql .= $virgula . " si201_mes = $this->si201_mes ";
				$virgula = ",";
				if (trim($this->si201_mes) == null) {
					$this->erro_sql = " Campo Mês nao Informado.";
					$this->erro_campo = "si201_mes";
					$this->erro_codfontrecursos = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
					$this->erro_status = "0";

					return false;
				}
			if (trim($this->si201_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si201_instit"])) {
				$sql .= $virgula . " si201_instit = $this->si201_instit ";
				$virgula = ",";
				if (trim($this->si201_instit) == null) {
					$this->erro_sql = " Campo Instituição nao Informado.";
					$this->erro_campo = "si201_instit";
					$this->erro_codfontrecursos = "";
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
					$this->erro_status = "0";

					return false;
				}
			}
		}
			$sql .= " where ";
			if ($si201_sequencial != null) {
				$sql .= " si201_sequencial = $this->si201_sequencial";
			}
//			$resaco = $this->sql_record($this->sql_query_file($this->si201_sequencial));
//			if ($this->numrows > 0) {
//				for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
//					$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//					$acount = pg_result($resac, 0, 0);
//					$resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//					$resac = db_query("insert into db_acountkey values($acount,2010632,'$this->si201_sequencial','A')");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si201_sequencial"]) || $this->si201_sequencial != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010632,'" . AddSlashes(pg_result($resaco, $conresaco, 'si201_sequencial')) . "','$this->si201_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si201_tiporegistro"]) || $this->si201_tiporegistro != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010633,'" . AddSlashes(pg_result($resaco, $conresaco, 'si201_tiporegistro')) . "','$this->si201_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si201_tipoconta"]) || $this->si201_tipoconta != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010634,'" . AddSlashes(pg_result($resaco, $conresaco, 'si201_tipoconta')) . "','$this->si201_tipoconta'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si201_codctb"]) || $this->si201_codctb != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010635,'" . AddSlashes(pg_result($resaco, $conresaco, 'si201_codctb')) . "','$this->si201_codctb'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si201_identificadordeducao"]) || $this->si201_identificadordeducao != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010636,'" . AddSlashes(pg_result($resaco, $conresaco, 'si201_identificadordeducao')) . "','$this->si201_identificadordeducao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si201_naturezareceita"]) || $this->si201_naturezareceita != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010637,'" . AddSlashes(pg_result($resaco, $conresaco, 'si201_naturezareceita')) . "','$this->si201_naturezareceita'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si201_tipomovimentacao"]) || $this->si201_tipomovimentacao != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010638,'" . AddSlashes(pg_result($resaco, $conresaco, 'si201_tipomovimentacao')) . "','$this->si201_tipomovimentacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si201_mes"]) || $this->si201_mes != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010639,'" . AddSlashes(pg_result($resaco, $conresaco, 'si201_mes')) . "','$this->si201_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si201_valorentrsaida"]) || $this->si201_valorentrsaida != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2010640,'" . AddSlashes(pg_result($resaco, $conresaco, 'si201_valorentrsaida')) . "','$this->si201_valorentrsaida'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					if (isset($GLOBALS["HTTP_POST_VARS"]["si201_instit"]) || $this->si201_instit != "")
//						$resac = db_query("insert into db_acount values($acount,2010334,2011618,'" . AddSlashes(pg_result($resaco, $conresaco, 'si201_instit')) . "','$this->si201_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				}
//			}
			$result = db_query($sql);
			if ($result == false) {
				$this->erro_codfontrecursos = str_replace("", "", @pg_last_error());
				$this->erro_sql = "cute212021 nao Alterado. Alteracao Abortada.\n";
				$this->erro_sql .= "Valores : " . $this->si201_sequencial;
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
				$this->erro_status = "0";
				$this->numrows_alterar = 0;

				return false;
			} else {
				if (pg_affected_rows($result) == 0) {
					$this->erro_codfontrecursos = "";
					$this->erro_sql = "cute212021 nao foi Alterado. Alteracao Executada.\n";
					$this->erro_sql .= "Valores : " . $this->si201_sequencial;
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
					$this->erro_status = "1";
					$this->numrows_alterar = 0;

					return true;
				} else {
					$this->erro_codfontrecursos = "";
					$this->erro_sql = "Alteração efetuada com Sucesso\n";
					$this->erro_sql .= "Valores : " . $this->si201_sequencial;
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
					$this->erro_status = "1";
					$this->numrows_alterar = pg_affected_rows($result);

					return true;
				}
			}
		}

		// funcao para exclusao
		function excluir($si201_sequencial = null, $dbwhere = null)
		{
			if ($dbwhere == null || $dbwhere == "") {
				$resaco = $this->sql_record($this->sql_query_file($si201_sequencial));
			} else {
				$resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
			}
//			if (($resaco != false) || ($this->numrows != 0)) {
//				for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
//					$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//					$acount = pg_result($resac, 0, 0);
//					$resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//					$resac = db_query("insert into db_acountkey values($acount,2010632,'$si201_sequencial','E')");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010632,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si201_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010633,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si201_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010634,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si201_tipoconta')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010635,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si201_codctb')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010636,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si201_identificadordeducao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010637,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si201_naturezareceita')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010638,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si201_tipomovimentacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010639,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si201_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2010640,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si201_valorentrsaida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//					$resac = db_query("insert into db_acount values($acount,2010334,2011618,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si201_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//				}
//			}
			$sql = " delete from cute212021
                    where ";
			$sql2 = "";
			if ($dbwhere == null || $dbwhere == "") {
				if ($si201_sequencial != "") {
					if ($sql2 != "") {
						$sql2 .= " and ";
					}
					$sql2 .= " si201_sequencial = $si201_sequencial ";
				}
			} else {
				$sql2 = $dbwhere;
			}
			$result = db_query($sql . $sql2);
			if ($result == false) {
				$this->erro_codfontrecursos = str_replace("", "", @pg_last_error());
				$this->erro_sql = "cute212021 nao Excluído. Exclusão Abortada.\n";
				$this->erro_sql .= "Valores : " . $si201_sequencial;
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
				$this->erro_status = "0";
				$this->numrows_excluir = 0;

				return false;
			} else {
				if (pg_affected_rows($result) == 0) {
					$this->erro_codfontrecursos = "";
					$this->erro_sql = "cute212021 nao Encontrado. Exclusão não Efetuada.\n";
					$this->erro_sql .= "Valores : " . $si201_sequencial;
					$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
					$this->erro_status = "1";
					$this->numrows_excluir = 0;

					return true;
				} else {
					$this->erro_codfontrecursos = "";
					$this->erro_sql = "Exclusão efetuada com Sucesso\n";
					$this->erro_sql .= "Valores : " . $si201_sequencial;
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
				$this->erro_sql = "Record Vazio na Tabela:cute212021";
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_codfontrecursos . " \n"));
				$this->erro_status = "0";

				return false;
			}

			return $result;
		}

		// funcao do sql
		function sql_query($si201_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
			$sql .= " from cute212021 ";
			$sql .= "      left  join cute102020  on  cute102020.si199_sequencial = cute212021.si201_reg10";
			$sql2 = "";
			if ($dbwhere == "") {
				if ($si201_sequencial != null) {
					$sql2 .= " where cute212021.si201_sequencial = $si201_sequencial ";
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
		function sql_query_file($si201_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
			$sql .= " from cute212021 ";
			$sql2 = "";
			if ($dbwhere == "") {
				if ($si201_sequencial != null) {
					$sql2 .= " where cute212021.si201_sequencial = $si201_sequencial ";
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
