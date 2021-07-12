<?php
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

//MODULO: edital
//CLASSE DA ENTIDADE editaldocumento
class cl_editaldocumento
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
	var $l48_sequencial = 0;
	var $l48_tipo = null;
	var $l48_nomearquivo = null;
	var $l48_liclicita = 0;
	var $l48_arquivo = '';

	// cria propriedade com as variaveis do arquivo
	var $campos = "
                 l48_sequencial = int4 = Sequencia 
                 l48_tipo = varchar(2) = Tipo do Edital 
                 l48_nomearquivo = varchar(100) = Nome do Arquivo 
                 l48_liclicita = bigint = Número do edital 
                 l48_arquivo = oid = Arquivo anexo 
                 ";

	//funcao construtor da classe
	function cl_editaldocumento()
	{
		//classes dos rotulos dos campos
		$this->rotulo = new rotulo("editaldocumento");
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
			$this->l48_sequencial = ($this->l48_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["l48_sequencial"] : $this->l48_sequencial);
			$this->l48_tipo = ($this->l48_tipo == "" ? @$GLOBALS["HTTP_POST_VARS"]["l48_tipo"] : $this->l48_tipo);
			$this->l48_nomearquivo = ($this->l48_nomearquivo == "" ? @$GLOBALS["HTTP_POST_VARS"]["l48_nomearquivo"] : $this->l48_nomearquivo);
			$this->l48_liclicita = ($this->l48_liclicita == "" ? @$GLOBALS["HTTP_POST_VARS"]["l48_liclicita"] : $this->l48_liclicita);
			$this->l48_arquivo = ($this->l48_arquivo == "" ? @$GLOBALS["HTTP_POST_VARS"]["l48_arquivo"] : $this->l48_arquivo);
		} else {
			$this->l48_sequencial = ($this->l48_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["l48_sequencial"] : $this->l48_sequencial);
		}
	}

	// funcao para inclusao
	function incluir($l48_sequencial)
	{

		$this->atualizacampos();
		if ($this->l48_tipo == null) {
			$this->erro_sql = " Campo Tipo nao Informado.";
			$this->erro_campo = "l48_tipo";
			$this->erro_banco = "";
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			$this->erro_status = "0";
			return false;
		}
		if ($l48_sequencial == "" || $l48_sequencial == null) {
			$result = db_query("select nextval('editaldocumentos_l48_sequencial_seq')");
			if ($result == false) {
				$this->erro_banco = str_replace("\n", "", @pg_last_error());
				$this->erro_sql = "Verifique o cadastro da sequencia: editaldocumentos_l48_sequencial_seq do campo: l48_sequencial";
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
				$this->erro_status = "0";
				return false;
			}
			$this->l48_sequencial = pg_result($result, 0, 0);
		} else {
			$result = db_query("select last_value from editaldocumento_l48_sequencial_seq");
			if (($result != false) && (pg_result($result, 0, 0) < $l48_sequencial)) {
				$this->erro_sql = " Campo l48_sequencial maior que último número da sequencia.";
				$this->erro_banco = "Sequencia menor que este número.";
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
				$this->erro_status = "0";
				return false;
			} else {
				$this->l48_sequencial = $l48_sequencial;
			}
		}
		if (($this->l48_sequencial == null) || ($this->l48_sequencial == "")) {
			$this->erro_sql = " Campo l48_sequencial nao declarado.";
			$this->erro_banco = "Chave Primaria zerada.";
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			$this->erro_status = "0";
			return false;
		}
		if (($this->l48_liclicita == null) || ($this->l48_liclicita == "")) {
			$this->erro_sql = " Campo l48_liclicita nao declarado.";
			$this->erro_banco = "Chave Primaria zerada.";
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			$this->erro_status = "0";
			return false;
		}

		if (($this->l48_arquivo == null) || ($this->l48_arquivo == "")) {
			$this->erro_sql = " Campo l48_arquivo nao declarado.";
			$this->erro_banco = $this->erro_banco = str_replace("\n", "", @pg_last_error());
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			$this->erro_status = "0";
			return false;
		}

		$sql = "insert into editaldocumentos(
                                       l48_sequencial 
                                      ,l48_tipo 
                                      ,l48_nomearquivo 
                                      ,l48_liclicita 
                                      ,l48_arquivo 
                       )
                values (
                                $this->l48_sequencial 
                               ,'$this->l48_tipo' 
                               ,'$this->l48_nomearquivo' 
                               ,$this->l48_liclicita 
                               ,$this->l48_arquivo 
                      )";
		$result = db_query($sql);
		if ($result == false) {
			$this->erro_banco = str_replace("\n", "", @pg_last_error());
			if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
				$this->erro_sql = "Documento do Edital ($this->l48_sequencial) nao Incluído. Inclusao Abortada.";
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_banco = "Documento do Edital já Cadastrado";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			} else {
				$this->erro_sql = "Documento do Edital ($this->l48_sequencial) nao Incluído. Inclusao Abortada.";
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			}
			$this->erro_status = "0";
			$this->numrows_incluir = 0;
			return false;
		}
		$this->erro_banco = "";
		$this->erro_sql = "Inclusao efetuada com Sucesso\\n";
		$this->erro_sql .= "Valores : " . $this->l48_sequencial;
		$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
		$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
		$this->erro_status = "1";
		$this->numrows_incluir = pg_affected_rows($result);

		return true;
	}

	// funcao para alteracao
	function alterar($l48_sequencial = null)
	{
		$this->atualizacampos();
		$sql = " update editaldocumentos set ";
		$virgula = "";
		if (trim($this->l48_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l48_sequencial"])) {
			$sql .= $virgula . " l48_sequencial = $this->l48_sequencial ";
			$virgula = ",";
			if (trim($this->l48_sequencial) == null) {
				$this->erro_sql = " Campo Sequencia nao Informado.";
				$this->erro_campo = "l48_sequencial";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
				$this->erro_status = "0";
				return false;
			}
		}
		if (trim($this->l48_tipo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l48_tipo"])) {
			$sql .= $virgula . " l48_tipo = '$this->l48_tipo' ";
			$virgula = ",";
			if (trim($this->l48_tipo) == null) {
				$this->erro_sql = " Campo Descrição nao Informado.";
				$this->erro_campo = "l48_tipo";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
				$this->erro_status = "0";
				return false;
			}
		}
		if (trim($this->l48_nomearquivo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l48_nomearquivo"])) {
			$sql .= $virgula . " l48_nomearquivo = '$this->l48_nomearquivo' ";
			$virgula = ",";
		}

		if (trim($this->l48_arquivo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l48_arquivo"])) {
			$sql .= $virgula . " l48_arquivo = '$this->l48_arquivo' ";
			$virgula = ",";
		}
//    $resaco = $this->sql_record($this->sql_query_file($this->l48_sequencial));
//    if($this->numrows>0){
//      for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
//        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//        $acount = pg_result($resac,0,0);
//        $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
//        $resac = db_query("insert into db_acountkey values($acount,18488,'$this->l48_sequencial','A')");
//        if(isset($GLOBALS["HTTP_POST_VARS"]["l48_sequencial"]) || $this->l48_sequencial != "")
//          $resac = db_query("insert into db_acount values($acount,3267,18488,'".AddSlashes(pg_result($resaco,$conresaco,'l48_sequencial'))."','$this->l48_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//        if(isset($GLOBALS["HTTP_POST_VARS"]["l48_edital"]) || $this->l48_edital != "")
//          $resac = db_query("insert into db_acount values($acount,3267,18489,'".AddSlashes(pg_result($resaco,$conresaco,'l48_edital'))."','$this->l48_edital',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//        if(isset($GLOBALS["HTTP_POST_VARS"]["l48_tipo"]) || $this->l48_tipo != "")
//          $resac = db_query("insert into db_acount values($acount,3267,18491,'".AddSlashes(pg_result($resaco,$conresaco,'l48_tipo'))."','$this->l48_tipo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//        if(isset($GLOBALS["HTTP_POST_VARS"]["l48_nomearquivo"]) || $this->l48_nomearquivo != "")
//          $resac = db_query("insert into db_acount values($acount,3267,18492,'".AddSlashes(pg_result($resaco,$conresaco,'l48_nomearquivo'))."','$this->l48_nomearquivo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//        if(isset($GLOBALS["HTTP_POST_VARS"]["l48_arquivo"]) || $this->l48_arquivo != "")
//          $resac = db_query("insert into db_acount values($acount,3267,18490,'".AddSlashes(pg_result($resaco,$conresaco,'l48_arquivo'))."','$this->l48_arquivo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//      }
//    }
		$result = db_query($sql);
		if ($result == false) {
			$this->erro_banco = str_replace("\n", "", @pg_last_error());
			$this->erro_sql = "Documento do Edital nao Alterado. Alteracao Abortada.\\n";
			$this->erro_sql .= "Valores : " . $this->l48_sequencial;
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			$this->erro_status = "0";
			$this->numrows_alterar = 0;
			return false;
		} else {
			if (pg_affected_rows($result) == 0) {
				$this->erro_banco = "";
				$this->erro_sql = "Documento do Edital nao foi Alterado. Alteracao Executada.\\n";
				$this->erro_sql .= "Valores : " . $this->l48_sequencial;
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
				$this->erro_status = "1";
				$this->numrows_alterar = 0;
				return true;
			} else {
				$this->erro_banco = "";
				$this->erro_sql = "Alteração efetuada com Sucesso\\n";
				$this->erro_sql .= "Valores : " . $this->l48_sequencial;
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
				$this->erro_status = "1";
				$this->numrows_alterar = pg_affected_rows($result);
				return true;
			}
		}
	}

	// funcao para exclusao
	function excluir($l48_sequencial = null, $dbwhere = null)
	{
//     if($dbwhere==null || $dbwhere==""){
//       $resaco = $this->sql_record($this->sql_query_file($l48_sequencial));
//     }else{
//       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
//     }
//     if(($resaco!=false)||($this->numrows!=0)){
//       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
//         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//         $acount = pg_result($resac,0,0);
//         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
//         $resac = db_query("insert into db_acountkey values($acount,18488,'$l48_sequencial','E')");
//         $resac = db_query("insert into db_acount values($acount,3267,18488,'','".AddSlashes(pg_result($resaco,$iresaco,'l48_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         $resac = db_query("insert into db_acount values($acount,3267,18489,'','".AddSlashes(pg_result($resaco,$iresaco,'l48_edital'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         $resac = db_query("insert into db_acount values($acount,3267,18491,'','".AddSlashes(pg_result($resaco,$iresaco,'l48_tipo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         $resac = db_query("insert into db_acount values($acount,3267,18492,'','".AddSlashes(pg_result($resaco,$iresaco,'l48_nomearquivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         $resac = db_query("insert into db_acount values($acount,3267,18490,'','".AddSlashes(pg_result($resaco,$iresaco,'l48_arquivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//       }
//     }
		$sql = " delete from editaldocumentos
                    where ";
		$sql2 = "";
		if ($dbwhere == null || $dbwhere == "") {
			if ($l48_sequencial != "") {
				if ($sql2 != "") {
					$sql2 .= " and ";
				}
				$sql2 .= " l48_sequencial = $l48_sequencial ";
			}
		} else {
			$sql2 = $dbwhere;
		}
		$result = db_query($sql . $sql2);
		if ($result == false) {
			$this->erro_banco = str_replace("\n", "", @pg_last_error());
			$this->erro_sql = "Documento do Edital nao Excluído. Exclusão Abortada.\\n";
			$this->erro_sql .= "Valores : " . $l48_sequencial;
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			$this->erro_status = "0";
			$this->numrows_excluir = 0;
			return false;
		} else {
			if (pg_affected_rows($result) == 0) {
				$this->erro_banco = "";
				$this->erro_sql = "Documento do Edital nao Encontrado. Exclusão não Efetuada.\\n";
				$this->erro_sql .= "Valores : " . $l48_sequencial;
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
				$this->erro_status = "1";
				$this->numrows_excluir = 0;
				return true;
			} else {
				$this->erro_banco = "";
				$this->erro_sql = "Exclusão efetuada com Sucesso\\n";
				$this->erro_sql .= "Valores : " . $l48_sequencial;
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
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
			$this->erro_sql = "Record Vazio na Tabela:editaldocumentos";
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			$this->erro_status = "0";
			return false;
		}
		return $result;
	}

	// funcao do sql
	function sql_query($l48_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
		$sql .= " from editaldocumentos ";
		$sql2 = "";
		if ($dbwhere == "") {
			if ($l48_sequencial != null) {
				$sql2 .= " where editaldocumentos.l48_sequencial = $l48_sequencial ";
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
	function sql_query_file($l48_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
		$sql .= " from editaldocumentos ";
		$sql .= " JOIN liclicita on liclicita.l20_codigo = editaldocumentos.l48_liclicita ";
		$sql2 = "";
		if ($dbwhere == "") {
			if ($l48_sequencial != null) {
				$sql2 .= " where editaldocumentos.l48_sequencial = $l48_sequencial ";
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
