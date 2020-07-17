<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se não, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

//MODULO: licitacao
//CLASSE DA ENTIDADE liclancedital
class cl_liclancedital
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
	var $l47_sequencial = 0;
	var $l47_linkpub = null;
	var $l47_origemrecurso = null;
	var $l47_descrecurso = null;
	var $l47_dataenvio_dia = null;
	var $l47_dataenvio_mes = null;
	var $l47_dataenvio_ano = null;
	var $l47_dataenvio = null;
	var $l47_datareenvio = null;
	var $l47_datareenvio_dia = null;
	var $l47_datareenvio_mes = null;
	var $l47_datareenvio_ano = null;
	var $l47_liclicita = null;

	// cria propriedade com as variaveis do arquivo
	var $campos = "
                 l47_sequencial = int8 = Sequencial
                 l47_linkpub = varchar(200) = Link da publicação
                 l47_origemrecurso = int8 = Origem do recurso
                 l47_descrecurso = varchar(250) = Descrição do recurso
                 l47_dataenvio = date = Data envio
                 l47_datareenvio = date = Data envio SICOM
                 l47_liclicita = int4 = Número da licitação
                  ";

	//funcao construtor da classe
	function cl_liclancedital()
	{
		//classes dos rotulos dos campos
		$this->rotulo = new rotulo("liclancedital");
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
			$this->l47_sequencial = ($this->l47_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["l47_sequencial"] : $this->l47_sequencial);
			$this->l47_linkpub = ($this->l47_linkpub == "" ? @$GLOBALS["HTTP_POST_VARS"]["l47_linkpub"] : $this->l47_linkpub);
			$this->l47_origemrecurso = ($this->l47_origemrecurso == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->l47_origemrecurso"] : $this->l47_origemrecurso);
			$this->l47_descrecurso = ($this->l47_descrecurso == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->l47_descrecurso"] : $this->l47_descrecurso);
			$this->l47_liclicita = ($this->l47_liclicita == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->l47_liclicita"] : $this->l47_liclicita);
			$this->l47_dataenvio = ($this->l47_dataenvio == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->l47_dataenvio"] : $this->l47_dataenvio);

			if ($this->l47_dataenvio == "") {
				$this->l47_dataenvio_dia = ($this->l47_dataenvio_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["l47_dataenvio_dia"] : $this->l47_dataenvio_dia);
				$this->l47_dataenvio_mes = ($this->l47_dataenvio_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["l47_dataenvio_mes"] : $this->l47_dataenvio_mes);
				$this->l47_dataenvio_ano = ($this->l47_dataenvio_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["l47_dataenvio_ano"] : $this->l47_dataenvio_ano);
				if ($this->l47_dataenvio_dia != "") {
					$this->l47_dataenvio = $this->l47_dataenvio_ano . "-" . $this->l47_dataenvio_mes . "-" . $this->l47_dataenvio_dia;
				}
			}

			if ($this->l47_datareenvio == "") {
				$this->l47_datareenvio = ($this->l47_datareenvio == "" ? @$GLOBALS["HTTP_POST_VARS"]["l47_datareenvio"] : $this->l47_datareenvio);
				$this->l47_datareenvio = ($this->l47_datareenvio == "" ? @$GLOBALS["HTTP_POST_VARS"]["l47_datareenvio"] : $this->l47_datareenvio);
				$this->l47_datareenvio = ($this->l47_datareenvio == "" ? @$GLOBALS["HTTP_POST_VARS"]["l47_datareenvio"] : $this->l47_datareenvio);
				if ($this->l47_datareenvio != "") {
					$this->l47_datareenvio = $this->l47_datareenvio . "-" . $this->l47_datareenvio . "-" . $this->l47_datareenvio;
				}
			}

		} else {
			$this->l47_sequencial = ($this->l47_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["l47_sequencial"] : $this->l47_sequencial);
		}
	}

	// funcao para inclusao aqui
	function incluir($l47_sequencial)
	{
		$this->atualizacampos();

		if ($l47_sequencial == "" || $l47_sequencial == null) {
			$result = db_query("select nextval('liclancedital_l47_sequencial_seq')");
			if ($result == false) {
				$this->erro_banco = str_replace("\n", "", @pg_last_error());
				$this->erro_sql = "Verifique o cadastro da sequencia: liclancedital_l47_sequencial_seq do campo: l47_sequencial";
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
				$this->erro_status = "0";
				return false;
			}
			$this->l47_sequencial = pg_result($result, 0, 0);
		} else {
			$result = db_query("select last_value from liclancedital_l47_sequencial_seq");
			if (($result != false) && (pg_result($result, 0, 0) < $l47_sequencial)) {
				$this->erro_sql = " Campo l47_sequencial maior que último número da sequencia.";
				$this->erro_banco = "Sequencia menor que este número.";
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
				$this->erro_status = "0";
				return false;
			} else {
				$this->l47_sequencial = $l47_sequencial;
			}
		}

		if ($this->l47_liclicita == "" || $this->l47_liclicita == null) {
			$this->erro_banco = str_replace("\n", "", @pg_last_error());
			$this->erro_sql = "Verifique o número do edital";
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			$this->erro_status = "0";
			return false;
		}

		if ($this->l47_dataenvio == "" || $this->l47_dataenvio == null) {
			$this->erro_banco = str_replace("\n", "", @pg_last_error());
			$this->erro_sql = "Verifique a data de envio";
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			$this->erro_status = "0";
			return false;
		}

		if (!$this->l47_origemrecurso || $this->l47_origemrecurso == null) {
			$this->erro_banco = str_replace("\n", "", @pg_last_error());
			$this->erro_sql = "Verifique a origem do recurso";
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			$this->erro_status = "0";
			return false;
		}

		if ($this->l47_origemrecurso == 9) {
			if (!$this->l47_descrecurso == null || trim($this->l47_descrecurso) == '') {
				$this->erro_banco = str_replace("\n", "", @pg_last_error());
				$this->erro_sql = "Verifique a descrição da origem do recurso";
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
				$this->erro_status = "0";
				return false;
			}
		}

		$sql = "insert into liclancedital(
                          l47_sequencial
                         ,l47_linkpub
                         ,l47_origemrecurso
                         ,l47_descrecurso
                         ,l47_dataenvio
                         ,l47_liclicita
                         ,l47_datareenvio
                )
                values (
                 $this->l47_sequencial
                ,'$this->l47_linkpub'
                ,$this->l47_origemrecurso
                ,'$this->l47_descrecurso'
                ," . ($this->l47_dataenvio == "null" || $this->l47_dataenvio == "" ? "null" : "'" . $this->l47_dataenvio . "'") . "
                ,$this->l47_liclicita
                ," . ($this->l47_datareenvio == "null" || $this->l47_datareenvio == "" ? "null" : "'" . $this->l47_datareenvio . "'") . "
                      )";

		$result = db_query($sql);
		if ($result == false) {
			$this->erro_banco = str_replace("\n", "", @pg_last_error());
			if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
				$this->erro_sql = "liclancedital ($this->l47_edital) não Incluído. Inclusao Abortada.";
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_banco = "liclancedital já Cadastrado";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			} else {
				$this->erro_sql = "liclancedital ($this->l47_sequencial) não Incluído. Inclusão Abortada.";
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			}
			$this->erro_status = "0";
			$this->numrows_incluir = 0;
			return false;
		}
		$this->erro_banco = "";
		$this->erro_sql = "Inclusão do edital efetuado com Sucesso\\n";
		$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
		$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
		$this->erro_status = "1";
		$this->numrows_incluir = pg_affected_rows($result);
//    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);

		return true;
	}

	// funcao para alteracao
	function alterar($l47_sequencial = null)
	{
		$this->atualizacampos();
		$sql = db_query('SELECT l20_cadinicial from liclicita where l20_codigo = '.$this->l47_liclicita);
		$statusLicitacao = db_utils::fieldsMemory($sql, 0)->l20_cadinicial;

		$virgula = " ";
		$sql = " update liclancedital set ";
		if (trim($this->l47_linkpub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["$this->l47_linkpub"])) {
			$sql .= $virgula . " l47_linkpub = '$this->l47_linkpub' ";
			$virgula = ",";
		}

//		if (!$this->l47_datareenvio || $this->l47_datareenvio == null) {
			if (trim($this->l47_origemrecurso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l47_origemrecurso"])) {
				$sql .= $virgula . " l47_origemrecurso = $this->l47_origemrecurso ";
				$virgula = ",";
			}
			else {
				$this->erro_sql = " Campo Origem Recurso não Informado.";
				$this->erro_campo = "l47_origemrecurso";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
				$this->erro_status = "0";
				return false;
			}

			if (trim($this->l47_dataenvio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l47_dataenvio"]) && !isset($this->l47_datareenvio)) {
				$sql .= $virgula . " l47_dataenvio = '$this->l47_dataenvio' ";
				$virgula = ",";
			} else {
				if(!$this->l47_datareenvio && $statusLicitacao == 2){
					$this->erro_sql = " Campo Data Envio não Informado.";
					$this->erro_campo = "l47_dataenvio";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
					$this->erro_status = "0";
					return false;
				}
			}

			if(!trim($this->l47_datareenvio) && $statusLicitacao == 3){
				$this->erro_sql = " Campo Data Reenvio não Informado.";
				$this->erro_campo = "l47_datareenvio";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
				$this->erro_status = "0";
				return false;
			}else{
				if($this->l47_datareenvio){
					$sSql = 'SELECT l47_dataenvio FROM liclancedital WHERE l47_liclicita = '.$this->l47_liclicita;
					$rsSql = pg_query($sSql);
					$iEnvio = db_utils::fieldsMemory($rsSql, 0)->l47_dataenvio;

					if($iEnvio > $this->l47_datareenvio){
						$this->erro_sql = " Campo Data Reenvio menor que a Data de Envio.";
						$this->erro_campo = "l47_datareenvio";
						$this->erro_banco = "";
						$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
						$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
						$this->erro_status = "0";
						return false;
					}

					$sql .= $virgula . " l47_datareenvio = ".(isset($this->l47_datareenvio) != null ? "'".$this->l47_datareenvio."'" : 'null');
				}
			}

			if (!trim($this->l47_origemrecurso)) {
				if (trim($this->l47_descrecurso) == null && $this->l47_origemrecurso == 9) {
					$this->erro_sql = " Campo Descrição da Origem do Recurso não Informado.";
					$this->erro_campo = "l47_descrecurso";
					$this->erro_banco = "";
					$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
					$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
					$this->erro_status = "0";
					return false;
				} else {
					$sql .= $virgula . " l47_descrecurso = '$this->l47_descrecurso' ";
				}
			}
//		}

		$sql .= " where ";

		if ($l47_sequencial != null) {
			$sql .= " l47_sequencial = $l47_sequencial";
		}
		$result = db_query($sql);

		if ($result == false) {
			$this->erro_banco = str_replace("\n", "", @pg_last_error());
			$this->erro_sql = "liclancedital não Alterado. Alteração Abortada.\\n";
			$this->erro_sql .= "Valores : " . $this->l47_sequencial;
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			$this->erro_status = "0";
			$this->numrows_alterar = 0;
			return false;
		} else {
			if (pg_affected_rows($result) == 0) {
				$this->erro_banco = "";
				$this->erro_sql = "liclancedital não foi Alterado. Alteração Executada.\\n";
				$this->erro_sql .= "Valores : " . $this->l47_sequencial;
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
				$this->erro_status = "1";
				$this->numrows_alterar = 0;
				return true;
			} else {
				$this->erro_banco = "";
				$this->erro_sql = "Alteração efetuada com Sucesso\\n";
//        $this->erro_sql .= "Valores : " . $this->l47_sequencial;
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
				$this->erro_status = "1";
				$this->numrows_alterar = pg_affected_rows($result);
				return true;
			}
		}
	}

	// funcao para exclusao
	public function excluir($l20_codigo = null, $dbwhere = null)
	{

		$sql = " delete from liclancedital
                    where ";
		$sql2 = "";
		if ($dbwhere == null || $dbwhere == "") {
			if ($l20_codigo != "") {
				if ($sql2 != "") {
					$sql2 .= " and ";
				}
				$sql2 .= " l47_sequencial = $l47_sequencial ";
			}
		} else {
			$sql2 = $dbwhere;
		}
		$result = db_query($sql . $sql2);
		if ($result == false) {
			$this->erro_banco = str_replace("\n", "", @pg_last_error());
			$this->erro_sql = "liclancedital não Excluído. Exclusão Abortada.\\n";
			$this->erro_sql .= "Valores : " . $l20_codigo;
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			$this->erro_status = "0";
			$this->numrows_excluir = 0;
			return false;
		} else {
			if (pg_affected_rows($result) == 0) {
				$this->erro_banco = "";
				$this->erro_sql = "liclancedital não Encontrado. Exclusão não Efetuada.\\n";
				$this->erro_sql .= "Valores : " . $l47_sequencial;
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
				$this->erro_status = "1";
				$this->numrows_excluir = 0;
				return true;
			} else {
				$this->erro_banco = "";
				$this->erro_sql = "Exclusão efetuada com Sucesso\\n";
				$this->erro_sql .= "Valores : " . $l47_sequencial;
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
				$this->erro_status = "1";
				$this->numrows_excluir = pg_affected_rows($result);
				return true;
			}
		}
	}

	// funcao do recordset
	public function sql_record($sql)
	{
		$result = db_query($sql);
		if ($result == false) {
			$this->numrows = 0;
			$this->erro_banco = str_replace("\n", "", @pg_last_error());
			$this->erro_sql = "Erro ao selecionar os registros.";
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			$this->erro_status = "0";
			return false;
		}
		$this->numrows = pg_numrows($result);
		if ($this->numrows == 0) {
			$this->erro_banco = "";
			$this->erro_sql = "Record Vazio na Tabela:liclancedital";
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			$this->erro_status = "0";
			return false;
		}
		return $result;
	}

	// funcao do sql

	function sql_query($l47_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "", $groupby = null)
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
		$sql .= " from liclicita ";
		$sql .= " LEFT JOIN liclancedital ON liclicita.l20_codigo = l47_liclicita ";
		$sql2 = "";
		if ($dbwhere == "") {
			if ($l47_sequencial != null) {
				$sql2 .= " where liclancedital.l47_sequencial = $l47_sequencial ";
			}
		} else if ($dbwhere != "") {
			$sql2 = " where $dbwhere";
		}
		$sql .= $sql2;
		if ($groupby != null) {
			$sql .= " group by ";
			$campos_sql = split("#", $groupby);
			$virgula = "";
			for ($i = 0; $i < sizeof($campos_sql); $i++) {
				$sql .= $virgula . $campos_sql[$i];
				$virgula = ",";
			}
		} else {
			$sql .= $groupby;
		}
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
	function sql_query_file($l47_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
		$sql .= " from liclancedital ";
		$sql2 = "";
		if ($dbwhere == "") {
			if ($l47_sequencial != null) {
				$sql2 .= " where liclancedital.l47_sequencial = $l47_sequencial ";
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

	function sql_query_completo($l47_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
		$sql .= " from liclancedital ";
		$sql .= " JOIN liclicita ON liclicita.l20_codigo = l47_liclicita ";
		$sql .= " LEFT JOIN editaldocumentos ON editaldocumentos.l48_liclicita = liclancedital.l47_liclicita ";
		$sql2 = "";
		if ($dbwhere == "") {
			if ($l47_sequencial != null) {
				$sql2 .= " where liclancedital.l47_sequencial = $l47_sequencial ";
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
