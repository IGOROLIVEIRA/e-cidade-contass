<?php
//MODULO: protocolo
//CLASSE DA ENTIDADE tiposnotificacao
class cl_tiposnotificacao
{
  // cria variaveis de erro
  public $rotulo     = null;
  public $query_sql  = null;
  public $numrows    = 0;
  public $numrows_incluir = 0;
  public $numrows_alterar = 0;
  public $numrows_excluir = 0;
  public $erro_status = null;
  public $erro_sql   = null;
  public $erro_banco = null;
  public $erro_msg   = null;
  public $erro_campo = null;
  public $pagina_retorno = null;
  // cria variaveis do arquivo
  public $p110_sequencial = 0;
  public $p110_tipo = null;
  public $p110_textoemail = null;
  public $p110_vinculonotificacao = null;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 p110_sequencial = int4 = Sequencial
                 p110_tipo = varchar(100) = Tipo
                 p110_textoemail = text = Texto Padrão
                 p110_vinculonotificacao = int4 = Vinculo
                 ";

  //funcao construtor da classe
  function __construct()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("tiposnotificacao");
    $this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
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
      $this->p110_sequencial = ($this->p110_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["p110_sequencial"] : $this->p110_sequencial);
      $this->p110_tipo = ($this->p110_tipo == "" ? @$GLOBALS["HTTP_POST_VARS"]["p110_tipo"] : $this->p110_tipo);
      $this->p110_textoemail = ($this->p110_textoemail == "" ? @$GLOBALS["HTTP_POST_VARS"]["p110_textoemail"] : $this->p110_textoemail);
      $this->p110_vinculonotificacao = ($this->p110_vinculonotificacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["p110_vinculonotificacao"] : $this->p110_vinculonotificacao);
    } else {
      $this->p110_sequencial = ($this->p110_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["p110_sequencial"] : $this->p110_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($p110_sequencial)
  {
    $this->atualizacampos();
    if ($this->p110_tipo == null) {
      $this->erro_sql = " Campo Tipo não informado.";
      $this->erro_campo = "p110_tipo";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->p110_textoemail == null) {
      $this->erro_sql = " Campo Texto Padrão não informado.";
      $this->erro_campo = "p110_textoemail";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->p110_vinculonotificacao == null) {
      $this->p110_vinculonotificacao = "null";
    }
    if ($p110_sequencial == "" || $p110_sequencial == null) {
      $result = db_query("select nextval('tiposnotificacao_p110_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: tiposnotificacao_p110_sequencial_seq do campo: p110_sequencial";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->p110_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from tiposnotificacao_p110_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $p110_sequencial)) {
        $this->erro_sql = " Campo p110_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      } else {
        $this->p110_sequencial = $p110_sequencial;
      }
    }
    if (($this->p110_sequencial == null) || ($this->p110_sequencial == "")) {
      $this->erro_sql = " Campo p110_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    $sql = "insert into tiposnotificacao(
                                       p110_sequencial
                                      ,p110_tipo
                                      ,p110_textoemail
                                      ,p110_vinculonotificacao
                       )
                values (
                                $this->p110_sequencial
                               ,'$this->p110_tipo'
                               ,'$this->p110_textoemail'
                               ,$this->p110_vinculonotificacao
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql   = "tiposnotificacao ($this->p110_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_banco = "tiposnotificacao já Cadastrado";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      } else {
        $this->erro_sql   = "tiposnotificacao ($this->p110_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
    $this->erro_sql .= "Valores : " . $this->p110_sequencial;
    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
//    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
//    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
//        && ($lSessaoDesativarAccount === false))) {
//
//      $resaco = $this->sql_record($this->sql_query_file($this->p110_sequencial));
//      if (($resaco != false) || ($this->numrows != 0)) {
//
//        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//        $acount = pg_result($resac, 0, 0);
//        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//        $resac = db_query("insert into db_acountkey values($acount,1009244,'$this->p110_sequencial','I')");
//        $resac = db_query("insert into db_acount values($acount,1010193,1009244,'','" . AddSlashes(pg_result($resaco, 0, 'p110_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,1010193,1009245,'','" . AddSlashes(pg_result($resaco, 0, 'p110_tipo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,1010193,1009246,'','" . AddSlashes(pg_result($resaco, 0, 'p110_textoemail')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,1010193,3002004,'','" . AddSlashes(pg_result($resaco, 0, 'p110_vinculonotificacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      }
//    }
    return true;
  }

  // funcao para alteracao
  function alterar($p110_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update tiposnotificacao set ";
    $virgula = "";
    if (trim($this->p110_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["p110_sequencial"])) {
      $sql  .= $virgula . " p110_sequencial = $this->p110_sequencial ";
      $virgula = ",";
      if (trim($this->p110_sequencial) == null) {
        $this->erro_sql = " Campo Sequencial não informado.";
        $this->erro_campo = "p110_sequencial";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->p110_tipo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["p110_tipo"])) {
      $sql  .= $virgula . " p110_tipo = '$this->p110_tipo' ";
      $virgula = ",";
      if (trim($this->p110_tipo) == null) {
        $this->erro_sql = " Campo Tipo não informado.";
        $this->erro_campo = "p110_tipo";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->p110_textoemail) != "" || isset($GLOBALS["HTTP_POST_VARS"]["p110_textoemail"])) {
      $sql  .= $virgula . " p110_textoemail = '$this->p110_textoemail' ";
      $virgula = ",";
      if (trim($this->p110_textoemail) == null) {
        $this->erro_sql = " Campo Texto Padrão não informado.";
        $this->erro_campo = "p110_textoemail";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->p110_vinculonotificacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["p110_vinculonotificacao"])) {
      if (trim($this->p110_vinculonotificacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["p110_vinculonotificacao"])) {
        $this->p110_vinculonotificacao = "null";
      }
      $sql  .= $virgula . " p110_vinculonotificacao = $this->p110_vinculonotificacao ";
      $virgula = ",";
    }
    $sql .= " where ";
    if ($p110_sequencial != null) {
      $sql .= " p110_sequencial = $this->p110_sequencial";
    }
//        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
//        if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
//                && ($lSessaoDesativarAccount === false))) {
//
//            $resaco = $this->sql_record($this->sql_query_file($this->p110_sequencial));
//            if ($this->numrows > 0) {
//
//                for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
//
//                    $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//                    $acount = pg_result($resac, 0, 0);
//                    $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//                    $resac = db_query("insert into db_acountkey values($acount,1009244,'$this->p110_sequencial','A')");
//                    if (isset($GLOBALS["HTTP_POST_VARS"]["p110_sequencial"]) || $this->p110_sequencial != "")
//                        $resac = db_query("insert into db_acount values($acount,1010193,1009244,'" . AddSlashes(pg_result($resaco, $conresaco, 'p110_sequencial')) . "','$this->p110_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//                    if (isset($GLOBALS["HTTP_POST_VARS"]["p110_tipo"]) || $this->p110_tipo != "")
//                        $resac = db_query("insert into db_acount values($acount,1010193,1009245,'" . AddSlashes(pg_result($resaco, $conresaco, 'p110_tipo')) . "','$this->p110_tipo'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//                    if (isset($GLOBALS["HTTP_POST_VARS"]["p110_textoemail"]) || $this->p110_textoemail != "")
//                        $resac = db_query("insert into db_acount values($acount,1010193,1009246,'" . AddSlashes(pg_result($resaco, $conresaco, 'p110_textoemail')) . "','$this->p110_textoemail'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//                    if (isset($GLOBALS["HTTP_POST_VARS"]["p110_vinculonotificacao"]) || $this->p110_vinculonotificacao != "")
//                        $resac = db_query("insert into db_acount values($acount,1010193,3002004,'" . AddSlashes(pg_result($resaco, $conresaco, 'p110_vinculonotificacao')) . "','$this->p110_vinculonotificacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//                }
//            }
//        }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "tiposnotificacao nao Alterado. Alteracao Abortada.\\n";
      $this->erro_sql .= "Valores : " . $this->p110_sequencial;
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "tiposnotificacao nao foi Alterado. Alteracao Executada.\\n";
        $this->erro_sql .= "Valores : " . $this->p110_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->p110_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($p110_sequencial = null, $dbwhere = null)
  {

    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
        && ($lSessaoDesativarAccount === false))) {

      if ($dbwhere == null || $dbwhere == "") {

        $resaco = $this->sql_record($this->sql_query_file($p110_sequencial));
      } else {
        $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
      }
      if (($resaco != false) || ($this->numrows != 0)) {

        for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

          $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac, 0, 0);
          $resac  = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
          $resac  = db_query("insert into db_acountkey values($acount,1009244,'$p110_sequencial','E')");
          $resac  = db_query("insert into db_acount values($acount,1010193,1009244,'','" . AddSlashes(pg_result($resaco, $iresaco, 'p110_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac  = db_query("insert into db_acount values($acount,1010193,1009245,'','" . AddSlashes(pg_result($resaco, $iresaco, 'p110_tipo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac  = db_query("insert into db_acount values($acount,1010193,1009246,'','" . AddSlashes(pg_result($resaco, $iresaco, 'p110_textoemail')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac  = db_query("insert into db_acount values($acount,1010193,3002004,'','" . AddSlashes(pg_result($resaco, $iresaco, 'p110_vinculonotificacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
      }
    }
    $sql = " delete from tiposnotificacao
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($p110_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " p110_sequencial = $p110_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "tiposnotificacao nao Excluído. Exclusão Abortada.\\n";
      $this->erro_sql .= "Valores : " . $p110_sequencial;
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "tiposnotificacao nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_sql .= "Valores : " . $p110_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;///
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $p110_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
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
      $this->numrows    = 0;
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "Erro ao selecionar os registros.";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    $this->numrows = pg_numrows($result);
    if ($this->numrows == 0) {
      $this->erro_banco = "";
      $this->erro_sql   = "Record Vazio na Tabela:tiposnotificacao";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }

  // funcao do sql
  function sql_query($p110_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from tiposnotificacao ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($p110_sequencial != null) {
        $sql2 .= " where tiposnotificacao.p110_sequencial = $p110_sequencial ";
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
  function sql_query_file($p110_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from tiposnotificacao ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($p110_sequencial != null) {
        $sql2 .= " where tiposnotificacao.p110_sequencial = $p110_sequencial ";
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
