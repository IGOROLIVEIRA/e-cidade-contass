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
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

//MODULO: licitacao
//CLASSE DA ENTIDADE historicocgm
class cl_historicocgm
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
	var $z09_sequencial = 0;
	var $z09_motivo = null;
	var $z09_usuario = null;

	var $z09_datacadastro_dia = null;
	var $z09_datacadastro_mes = null;
	var $z09_datacadastro_ano = null;
	var $z09_datacadastro = null;

	var $z09_dataservidor_dia = null;
	var $z09_dataservidor_mes = null;
	var $z09_dataservidor_ano = null;
	var $z09_dataservidor = null;

	var $z09_numcgm = null;
	var $z09_horaalt = null;

	// cria propriedade com as variaveis do arquivo
	var $campos = "
                 z09_sequencial = int8 = Sequencial
                 z09_motivo = varchar(100) = Motivo da Alteração
                 z09_usuario = int8 = Usuário da sessão
                 z09_datacadastro = date = Data cadastro
                 z09_dataservidor = date = Data do servidor
                 z09_numcgm = int4 = Número do CGM
                 z09_horaalt varchar(5) = Hora da alteração do CGM
                  ";

	//funcao construtor da classe
	function cl_historicocgm()
	{
		//classes dos rotulos dos campos
		$this->rotulo = new rotulo("historicocgm");
		$this->pagina_retorno = basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
	}

	//funcao erro
	function erro($mostra, $retorna){
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
			$this->z09_sequencial = ($this->z09_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["z09_sequencial"] : $this->z09_sequencial);
			$this->z09_motivo = ($this->z09_motivo == "" ? @$GLOBALS["HTTP_POST_VARS"]["z09_motivo"] : $this->z09_motivo);
			$this->z09_usuario = ($this->z09_usuario == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->z09_usuario"] : $this->z09_usuario);
			$this->z09_numcgm = ($this->z09_numcgm == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->z09_numcgm"] : $this->z09_numcgm);
			$this->z09_datacadastro = ($this->z09_datacadastro == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->z09_datacadastro"] : $this->z09_datacadastro);

			if ($this->z09_datacadastro == "") {
				$this->z09_datacadastro_dia = ($this->z09_datacadastro_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["z09_datacadastro_dia"] : $this->z09_datacadastro_dia);
				$this->z09_datacadastro_mes = ($this->z09_datacadastro_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["z09_datacadastro_mes"] : $this->z09_datacadastro_mes);
				$this->z09_datacadastro_ano = ($this->z09_datacadastro_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["z09_datacadastro_ano"] : $this->z09_datacadastro_ano);
				if ($this->z09_datacadastro_dia != "") {
					$this->z09_datacadastro = $this->z09_datacadastro_ano . "-" . $this->z09_datacadastro_mes . "-" . $this->z09_datacadastro_dia;
				}
			}

			if ($this->z09_dataservidor == "") {
				$this->z09_dataservidor_dia = ($this->z09_dataservidor_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["z09_dataservidor_dia"] : $this->z09_dataservidor_dia);
				$this->z09_dataservidor_mes = ($this->z09_dataservidor_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["z09_dataservidor_mes"] : $this->z09_dataservidor_mes);
				$this->z09_dataservidor_ano = ($this->z09_dataservidor_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["z09_dataservidor_ano"] : $this->z09_dataservidor_ano);
				if ($this->z09_dataservidor_dia != "") {
					$this->z09_dataservidor = $this->z09_dataservidor_ano . "-" . $this->z09_dataservidor_mes . "-" . $this->z09_dataservidor_dia;
				}
			}

		} else {
			$this->z09_sequencial = ($this->z09_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["z09_sequencial"] : $this->z09_sequencial);
		}
	}

	// funcao para inclusao aqui
	function incluir($z09_sequencial)
	{
		$this->atualizacampos();

		if ($z09_sequencial == "" || $z09_sequencial == null) {
			$result = db_query("select nextval('historicocgm_z09_sequencial_seq')");
			if ($result == false) {
				$this->erro_banco = str_replace("\n", "", @pg_last_error());
				$this->erro_sql = "Verifique o cadastro da sequencia: historicocgm_z09_sequencial_seq do campo: z09_sequencial";
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
				$this->erro_status = "0";
				return false;
			}
			$this->z09_sequencial = pg_result($result, 0, 0);
		} else {
			$result = db_query("select last_value from historicocgm_z09_sequencial_seq");
			if (($result != false) && (pg_result($result, 0, 0) < $z09_sequencial)) {
				$this->erro_sql = " Campo z09_sequencial maior que último número da sequencia.";
				$this->erro_banco = "Sequencia menor que este número.";
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
				$this->erro_status = "0";
				return false;
			} else {
				$this->z09_sequencial = $z09_sequencial;
			}
		}

		if ($this->z09_numcgm == "" || $this->z09_numcgm == null) {
			$this->erro_banco = str_replace("\n", "", @pg_last_error());
			$this->erro_sql = "Verifique o número do cgm";
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			$this->erro_status = "0";
			return false;
		}

		if ($this->z09_datacadastro == "" || $this->z09_datacadastro == null) {
			$this->erro_banco = str_replace("\n", "", @pg_last_error());
			$this->erro_sql = "Verifique a data de cadastro";
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			$this->erro_status = "0";
			return false;
		}

        if ($this->z09_dataservidor == "" || $this->z09_dataservidor == null) {
        	$this->z09_dataservidor = date('Y-m-d');
        }

        if($this->z09_horaalt == '' || $this->z09_horaalt == null){
			$this->z09_horaalt = db_hora();
		}

		$sql = "insert into historicocgm(
						  z09_sequencial
                         ,z09_numcgm
                         ,z09_motivo
                         ,z09_usuario
                         ,z09_datacadastro
                         ,z09_dataservidor
                         ,z09_horaalt
                )
                values (
                		  $this->z09_sequencial
                        , $this->z09_numcgm 
                        ,'$this->z09_motivo'
                        ,$this->z09_usuario
                        ,'$this->z09_datacadastro'
                        ,'$this->z09_dataservidor' 
                        ,'$this->z09_horaalt' 
                )";

		$result = db_query($sql);
		if ($result == false) {
			$this->erro_banco = str_replace("\n", "", @pg_last_error());
			if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
				$this->erro_sql = "historicocgm ($this->z09_numcgm) não Incluído. Inclusão Abortada.";
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_banco = "historicocgm já Cadastrado";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			} else {
				$this->erro_sql = "historicocgm ($this->z09_sequencial) não Incluído. Inclusão Abortada.";
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			}
			$this->erro_status = "0";
			$this->numrows_incluir = 0;
			return false;
		}
		$this->erro_banco = "";
		$this->erro_sql = "Inclusão efetuada com Sucesso\\n";
		$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
		$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
		$this->erro_status = "1";
		$this->numrows_incluir = pg_affected_rows($result);
//    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);

		return true;
	}

	// funcao para alteracao
	function alterar($z09_sequencial = null)
	{
		$this->atualizacampos();

		$virgula = " ";
		$sql = " update historicocgm set ";
		if (trim($this->z09_motivo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["$this->z09_motivo"])) {
			$sql .= $virgula . " z09_motivo = '$this->z09_motivo' ";
			$virgula = ",";
		}

		if ((trim($this->z09_usuario) != "" || isset($GLOBALS["HTTP_POST_VARS"]["z09_usuario"]))) {
			$sql .= $virgula . " z09_usuario = $this->z09_usuario ";
			$virgula = ",";
		}

		if ($this->z09_datacadastro != "" || !isset($GLOBALS["HTTP_POST_VARS"]["z09_datacadastro"])) {
			$sql .= $virgula . " z09_datacadastro = '$this->z09_datacadastro' ";
			$virgula = ",";
		}

		if ($this->z09_dataservidor != "" || !isset($GLOBALS["HTTP_POST_VARS"]["z09_dataservidor"])) {
			$sql .= $virgula . " z09_dataservidor = '$this->z09_dataservidor' ";
			$virgula = ",";
		}

		if ($this->z09_horaalt != "" || !isset($GLOBALS["HTTP_POST_VARS"]["z09_horaalt"])) {
			$sql .= $virgula . " z09_horaalt = '$this->z09_horaalt' ";
			$virgula = ",";
		}

		$sql .= " where ";

		if ($z09_sequencial != null) {
			$sql .= " z09_sequencial = $z09_sequencial";
		}

		$result = db_query($sql);

		if ($result == false) {
			$this->erro_banco = str_replace("\n", "", @pg_last_error());
			$this->erro_sql = "historicocgm nao Alterado. Alteracao Abortada.\\n";
			$this->erro_sql .= "Valores : " . $this->z09_sequencial;
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			$this->erro_status = "0";
			$this->numrows_alterar = 0;
			return false;
		} else {
			if (pg_affected_rows($result) == 0) {
				$this->erro_banco = "";
				$this->erro_sql = "historicocgm nao foi Alterado. Alteracao Executada.\\n";
				$this->erro_sql .= "Valores : " . $this->z09_sequencial;
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
				$this->erro_status = "1";
				$this->numrows_alterar = 0;
				return true;
			} else {
				$this->erro_banco = "";
				$this->erro_sql = "Alteração efetuada com Sucesso\\n";
//        $this->erro_sql .= "Valores : " . $this->z09_sequencial;
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
				$this->erro_status = "1";
				$this->numrows_alterar = pg_affected_rows($result);
				return true;
			}
		}
	}

	// funcao para exclusao
	public function excluir($z09_sequencial = null, $dbwhere = null)
	{

		$sql = " delete from historicocgm
                    where ";
		$sql2 = "";
		if ($dbwhere == null || $dbwhere == "") {
			if ($z09_sequencial != "") {
				if ($sql2 != "") {
					$sql2 .= " and ";
				}
				$sql2 .= " z09_sequencial = $z09_sequencial ";
			}
		} else {
			$sql2 = $dbwhere;
		}
		$result = db_query($sql . $sql2);
		if ($result == false) {
			$this->erro_banco = str_replace("\n", "", @pg_last_error());
			$this->erro_sql = "historicocgm nao Excluído. Exclusão Abortada.\\n";
			$this->erro_sql .= "Valores : " . $z09_sequencial;
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			$this->erro_status = "0";
			$this->numrows_excluir = 0;
			return false;
		} else {
			if (pg_affected_rows($result) == 0) {
				$this->erro_banco = "";
				$this->erro_sql = "historicocgm nao Encontrado. Exclusão não Efetuada.\\n";
				$this->erro_sql .= "Valores : " . $z09_sequencial;
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
				$this->erro_status = "1";
				$this->numrows_excluir = 0;
				return true;
			} else {
				$this->erro_banco = "";
				$this->erro_sql = "Exclusão efetuada com Sucesso\\n";
				$this->erro_sql .= "Valores : " . $z09_sequencial;
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
			$this->erro_sql = "Record Vazio na Tabela:historicocgm";
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			$this->erro_status = "0";
			return false;
		}
		return $result;
	}

	// funcao do sql
	function sql_query_file($z09_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
		$sql .= " from historicocgm ";
		$sql2 = "";
		if ($dbwhere == "") {
			if ($z09_sequencial != null) {
				$sql2 .= " where historicocgm.z09_sequencial = $z09_sequencial ";
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
