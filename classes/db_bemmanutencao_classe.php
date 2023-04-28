<?php
//MODULO: patrimonio
//CLASSE DA ENTIDADE bemmanutencao
class cl_bemmanutencao
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
  public $t98_sequencial = 0;
  public $t98_bem = null;
  public $t98_data = null;
  public $t98_descricao = null;
  public $t98_vlrmanut = null;
  public $t98_idusuario = null;
  public $t98_dataservidor = null;
  public $t98_horaservidor = null;
  public $t98_tipo = null;

  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 t98_sequencial int8 
                t98_bem = int8 = Sequencial 
                t98_data = data = Data 
                t98_descricao = varchar(500) = Descrição
                t98_vlrmanut = float = Valor da manutenção
                t98_idusuario = int = Id do usuário
                t98_dataservidor = date = Data do Servidor
                t98_horaservidor = time = Horário do Servidor
                t98_tipo = int4 = Tipo da Manutenção
                 ";

  //funcao construtor da classe 
  function __construct()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("bemmanutencao");
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
      $this->t98_sequencial = ($this->t98_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["t98_sequencial"] : $this->t98_sequencial);
      $this->t98_bem = ($this->t98_bem == "" ? @$GLOBALS["HTTP_POST_VARS"]["t98_bem"] : $this->t98_bem);
      $this->t98_data = ($this->t98_data == "" ? @$GLOBALS["HTTP_POST_VARS"]["t98_data"] : $this->t98_data);
      $this->t98_descricao = ($this->t98_descricao == "" ? @$GLOBALS["HTTP_POST_VARS"]["t98_descricao"] : $this->t98_descricao);
      $this->t98_vlrmanut = ($this->t98_vlrmanut == "" ? @$GLOBALS["HTTP_POST_VARS"]["t98_vlrmanut"] : $this->t98_vlrmanut);
      $this->t98_dataservidor = ($this->t98_dataservidor == "" ? @$GLOBALS["HTTP_POST_VARS"]["t98_dataservidor"] : $this->t98_dataservidor);
      $this->t98_horaservidor = ($this->t98_horaservidor == "" ? @$GLOBALS["HTTP_POST_VARS"]["t98_horaservidor"] : $this->t98_horaservidor);
      $this->t98_tipo = ($this->t98_tipo == "" ? @$GLOBALS["HTTP_POST_VARS"]["t98_tipo"] : $this->t98_tipo);
    } else {
    }
  }

  // funcao para inclusao
  function incluir()
  {
    $this->atualizacampos();

    if ($this->t98_sequencial == "" || $this->t98_sequencial == null) {
      $result = db_query("select nextval('bemmanutencao_t98_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: bemmanutencao_t98_sequencial_seq do campo: t98_sequencial";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->t98_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from bemmanutencao_t98_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $this->t98_sequencial)) {
        $this->erro_sql = " Campo t98_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      } else {
        $this->t98_sequencial = $this->t98_sequencial;
      }
    }

    if ($this->t98_bem == null) {
      $this->erro_sql = " Campo Codigo do Bem não informado.";
      $this->erro_campo = "t98_bem";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    if ($this->t98_data == null) {
      $this->erro_sql = " Campo Data não informado.";
      $this->erro_campo = "t98_data";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    if ($this->t98_descricao == null) {
      $this->erro_sql = " Campo Descrição não informado.";
      $this->erro_campo = "t98_descricao";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    if ($this->t98_vlrmanut == null) {
      $this->erro_sql = " Campo Valor da Manutenção não informado.";
      $this->erro_campo = "t98_vlrmanut";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    if ($this->t98_tipo == "0") {
      $this->erro_sql = " Campo Tipo da Manutenção não informado.";
      $this->erro_campo = "t98_tipo";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }


    $sql = "insert into bemmanutencao(
                    t98_sequencial 
                    ,t98_bem 
                    ,t98_data 
                    ,t98_descricao  
                    ,t98_vlrmanut 
                    ,t98_idusuario 
                    ,t98_dataservidor
                    ,t98_horaservidor
                    ,t98_tipo)
                values ($this->t98_sequencial,  
                               $this->t98_bem, 
                               '$this->t98_data', 
                               '$this->t98_descricao', 
                               $this->t98_vlrmanut, 
                               $this->t98_idusuario, 
                               '$this->t98_dataservidor',
                               '$this->t98_horaservidor' ,
                               '$this->t98_tipo' 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql   = "Manutenção de bem () nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_banco = "Manutenção de bem já Cadastrado";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      } else {
        $this->erro_sql   = "Manutenção de bem () nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      return false;
    }

    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
      && ($lSessaoDesativarAccount === false))) {
    }
    return true;
  }



  // funcao para alteracao
  function alterar($sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update bemmanutencao set ";
    $virgula = "";
    if (trim($this->t98_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t98_sequencial"])) {
      $sql  .= $virgula . " t98_sequencial = $this->t98_sequencial ";
      $virgula = ",";
      if (trim($this->t98_sequencial) == null) {
        $this->erro_sql = " Campo Sequencial não informado.";
        $this->erro_campo = "t98_sequencial";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t98_bem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t98_bem"])) {
      $sql  .= $virgula . " t98_bem = $this->t98_bem ";
      $virgula = ",";
      if (trim($this->t98_bem) == null) {
        $this->erro_sql = " Campo Codigo do Bem não informado.";
        $this->erro_campo = "t98_bem";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }

    if (trim($this->t98_data) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t98_data"])) {
      $sql  .= $virgula . " t98_data = '$this->t98_data' ";
      $virgula = ",";
      if (trim($this->t98_data) == null) {
        $this->erro_sql = " Campo Data da Manutenção não informado.";
        $this->erro_campo = "t98_data";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }

    if (trim($this->t98_descricao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t98_descricao"])) {
      $sql  .= $virgula . " t98_descricao = '$this->t98_descricao' ";
      $virgula = ",";
      if (trim($this->t98_data) == null) {
        $this->erro_sql = " Campo Descrição da Manutenção não informado.";
        $this->erro_campo = "t98_descricao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }

    if (trim($this->t98_vlrmanut) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t98_vlrmanut"])) {
      $sql  .= $virgula . " t98_vlrmanut = $this->t98_vlrmanut ";
      $virgula = ",";
      if (trim($this->t98_vlrmanut) == null) {
        $this->erro_sql = " Campo Valor da Manutenção não informado.";
        $this->erro_campo = "t98_vlrmanut";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }

    if (trim($this->t98_tipo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t98_tipo"])) {
      $sql  .= $virgula . " t98_tipo = $this->t98_tipo ";
      $virgula = ",";
      if (trim($this->t98_tipo) == null) {
        $this->erro_sql = " Campo Tipo da Manutenção não informado.";
        $this->erro_campo = "t98_tipo";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }



    $sql .= " where ";
    $sql .= "t98_sequencial = $sequencial";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "Manutenção do bem nao Alterado. Alteracao Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "Manutenção do bem nao foi Alterado. Alteracao Executada.\\n";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        $this->numrows_alterar = 0;
        return true;
      } else {

        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  function excluir($sequencial = null, $dbwhere = null)
  {

    $sql = " delete from bemmanutencao
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      $sql2 = "t98_sequencial = $sequencial";
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   =  "Bem de Manutencao nao Excluído. Exclusão Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "Bem de Manutencao nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = pg_affected_rows($result);
        return true;
      }
    }
  }
}

  /*

  // funcao para exclusao 
  function excluir($sequencial = null, $dbwhere = null)
  {

    $protprocessodocumento = db_query("select * from protprocessodocumento where p01_nivelacesso = $sequencial");

    if (pg_num_rows($protprocessodocumento) == 0) {
      $result = db_query("delete from perfispermanexo where p203_permanexo = $sequencial");
    } else {
      $this->erro_msg = "Uusário: permissões de anexo que estejam vinculadas a documentos não podem ser excluidas";
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    }


    $sql = " delete from permanexo
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      $sql2 = "p202_sequencial = $sequencial";
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   =  "Permissão de anexo nao Excluído. Exclusão Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "Permissão de anexo nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
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
      $this->erro_sql   = "Record Vazio na Tabela:permanexo";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }

  // funcao do sql 
  function sql_query($oid = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from permanexo ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($oid != "" && $oid != null) {
        $sql2 = " where p202_sequencial = $oid";
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
  function sql_query_file($oid = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from permanexo ";
    $sql2 = "";
    if ($dbwhere == "") {
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
}  */
