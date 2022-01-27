<?php
//arquivo: configuracoes
//CLASSE DA ENTIDADE relatorios
class cl_relatorios
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
  public $rel_sequencial = 0;
  public $rel_descricao = null;
  public $rel_arquivo = 0;
  public $rel_corpo = null;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 rel_sequencial = int4 = Sequencial
                 rel_descricao = varchar(50) = Descrição
                 rel_arquivo = int4 = arquivo
                 rel_corpo = varchar(500) = Corpo
                 ";

  //funcao construtor da classe
  function __construct()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("relatorios");
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
      $this->rel_sequencial = ($this->rel_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["rel_sequencial"] : $this->rel_sequencial);
      $this->rel_descricao = ($this->rel_descricao == "" ? @$GLOBALS["HTTP_POST_VARS"]["rel_descricao"] : $this->rel_descricao);
      $this->rel_arquivo = ($this->rel_arquivo == "" ? @$GLOBALS["HTTP_POST_VARS"]["rel_arquivo"] : $this->rel_arquivo);
      $this->rel_corpo = ($this->rel_corpo == "" ? @$GLOBALS["HTTP_POST_VARS"]["rel_corpo"] : $this->rel_corpo);
    } else {
      $this->rel_sequencial = ($this->rel_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["rel_sequencial"] : $this->rel_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($rel_sequencial)
  {
    $this->atualizacampos();
    if ($this->rel_descricao == null) {
      $this->erro_sql = " Campo Descrição não informado.";
      $this->erro_campo = "rel_descricao";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->rel_arquivo == null) {
      $this->erro_sql = " Campo arquivo não informado.";
      $this->erro_campo = "rel_arquivo";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->rel_corpo == null) {
      $this->erro_sql = " Campo Corpo não informado.";
      $this->erro_campo = "rel_corpo";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($rel_sequencial == "" || $rel_sequencial == null) {
      $result = db_query("select nextval('relatorios_rel_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: relatorios_rel_sequencial_seq do campo: rel_sequencial";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->rel_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from relatorios_rel_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $rel_sequencial)) {
        $this->erro_sql = " Campo rel_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      } else {
        $this->rel_sequencial = $rel_sequencial;
      }
    }
    if (($this->rel_sequencial == null) || ($this->rel_sequencial == "")) {
      $this->erro_sql = " Campo rel_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into relatorios(
                                       rel_sequencial
                                      ,rel_descricao
                                      ,rel_arquivo
                                      ,rel_corpo
                       )
                values (
                                $this->rel_sequencial
                               ,'$this->rel_descricao'
                               ,$this->rel_arquivo
                               ,'$this->rel_corpo'
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql   = "relatorios ($this->rel_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_banco = "relatorios já Cadastrado";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      } else {
        $this->erro_sql   = "relatorios ($this->rel_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
    $this->erro_sql .= "Valores : " . $this->rel_sequencial;
    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    // if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
    //   && ($lSessaoDesativarAccount === false))) {

    //   $resaco = $this->sql_record($this->sql_query_file($this->rel_sequencial));
    //   if (($resaco != false) || ($this->numrows != 0)) {

    //     $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
    //     $acount = pg_result($resac, 0, 0);
    //     $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
    //     $resac = db_query("insert into db_acountkey values($acount,2012515,'$this->rel_sequencial','I')");
    //     $resac = db_query("insert into db_acount values($acount,1010192,2012515,'','" . AddSlashes(pg_result($resaco, 0, 'rel_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,1010192,2012516,'','" . AddSlashes(pg_result($resaco, 0, 'rel_descricao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,1010192,2012517,'','" . AddSlashes(pg_result($resaco, 0, 'rel_arquivo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,1010192,2012518,'','" . AddSlashes(pg_result($resaco, 0, 'rel_corpo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   }
    // }
    return true;
  }

  // funcao para alteracao
  function alterar($rel_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update relatorios set ";
    $virgula = "";
    if (trim($this->rel_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["rel_sequencial"])) {
      $sql  .= $virgula . " rel_sequencial = $this->rel_sequencial ";
      $virgula = ",";
      if (trim($this->rel_sequencial) == null) {
        $this->erro_sql = " Campo Sequencial não informado.";
        $this->erro_campo = "rel_sequencial";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->rel_descricao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["rel_descricao"])) {
      $sql  .= $virgula . " rel_descricao = '$this->rel_descricao' ";
      $virgula = ",";
      if (trim($this->rel_descricao) == null) {
        $this->erro_sql = " Campo Descrição não informado.";
        $this->erro_campo = "rel_descricao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->rel_arquivo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["rel_arquivo"])) {
      $sql  .= $virgula . " rel_arquivo = $this->rel_arquivo ";
      $virgula = ",";
      if (trim($this->rel_arquivo) == null) {
        $this->erro_sql = " Campo arquivo não informado.";
        $this->erro_campo = "rel_arquivo";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->rel_corpo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["rel_corpo"])) {
      $sql  .= $virgula . " rel_corpo = '$this->rel_corpo' ";
      $virgula = ",";
      if (trim($this->rel_corpo) == null) {
        $this->erro_sql = " Campo Corpo não informado.";
        $this->erro_campo = "rel_corpo";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    if ($rel_sequencial != null) {
      $sql .= " rel_sequencial = $this->rel_sequencial";
    }
    // $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    // if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
    //   && ($lSessaoDesativarAccount === false))) {

    //   $resaco = $this->sql_record($this->sql_query_file($this->rel_sequencial));
    //   if ($this->numrows > 0) {

    //     for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {

    //       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
    //       $acount = pg_result($resac, 0, 0);
    //       $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
    //       $resac = db_query("insert into db_acountkey values($acount,2012515,'$this->rel_sequencial','A')");
    //       if (isset($GLOBALS["HTTP_POST_VARS"]["rel_sequencial"]) || $this->rel_sequencial != "")
    //         $resac = db_query("insert into db_acount values($acount,1010192,2012515,'" . AddSlashes(pg_result($resaco, $conresaco, 'rel_sequencial')) . "','$this->rel_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //       if (isset($GLOBALS["HTTP_POST_VARS"]["rel_descricao"]) || $this->rel_descricao != "")
    //         $resac = db_query("insert into db_acount values($acount,1010192,2012516,'" . AddSlashes(pg_result($resaco, $conresaco, 'rel_descricao')) . "','$this->rel_descricao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //       if (isset($GLOBALS["HTTP_POST_VARS"]["rel_arquivo"]) || $this->rel_arquivo != "")
    //         $resac = db_query("insert into db_acount values($acount,1010192,2012517,'" . AddSlashes(pg_result($resaco, $conresaco, 'rel_arquivo')) . "','$this->rel_arquivo'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //       if (isset($GLOBALS["HTTP_POST_VARS"]["rel_corpo"]) || $this->rel_corpo != "")
    //         $resac = db_query("insert into db_acount values($acount,1010192,2012518,'" . AddSlashes(pg_result($resaco, $conresaco, 'rel_corpo')) . "','$this->rel_corpo'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     }
    //   }
    // }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "relatorios nao Alterado. Alteracao Abortada.\\n";
      $this->erro_sql .= "Valores : " . $this->rel_sequencial;
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "relatorios nao foi Alterado. Alteracao Executada.\\n";
        $this->erro_sql .= "Valores : " . $this->rel_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->rel_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($rel_sequencial = null, $dbwhere = null)
  {
    $sql = " delete from relatorios
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($rel_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " rel_sequencial = $rel_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "relatorios nao Excluído. Exclusão Abortada.\\n";
      $this->erro_sql .= "Valores : " . $rel_sequencial;
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "relatorios nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_sql .= "Valores : " . $rel_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $rel_sequencial;
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
      $this->erro_sql   = "Record Vazio na Tabela:relatorios";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }

  // funcao do sql
  function sql_query($rel_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from relatorios ";
    $sql .= "      inner join db_sysarquivo  on  db_sysarquivo.codarq = relatorios.rel_arquivo";
    $sql .= "      left join db_sysarqmod  on  db_sysarqmod.codarq = db_sysarquivo.codarq";
    $sql .= "      left join db_sysmodulo on db_sysarqmod.codmod = db_sysmodulo.codmod";
    $sql .= "      left join db_modulos on nome_manual = nomemod";
    $sql2 = "";

    if ($dbwhere == "") {
      if ($rel_sequencial != null) {
        $sql2 .= " where relatorios.rel_sequencial = $rel_sequencial ";
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
  function sql_query_file($rel_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from relatorios ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($rel_sequencial != null) {
        $sql2 .= " where relatorios.rel_sequencial = $rel_sequencial ";
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
