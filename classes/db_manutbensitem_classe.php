<?php
//MODULO: patrimonio
//CLASSE DA ENTIDADE bemmanutencao
class cl_manutbensitem
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
  public $t99_sequencial = 0;
  public $t99_itemsistema = null;
  public $t99_valor = null;
  public $t99_descricao = null;
  public $t99_codpcmater = null;
  public $t99_codbensdispensatombamento = null;
  public $t99_codbemmanutencao = null;

  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                t99_sequencial = int8 = Sequencial 
                t99_itemsistema = int4 = Item do Sistema 
                t99_valor = float = Valor 
                t99_descricao = varchar(200) = Descrição
                t99_codpcmater = int = Codigo Do Material
                t99_codbensdispensatombamento = int = Codigo Dispensa Tombamento
                t99_codbemmanutencao = int = Codigo da Manutencao
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
      $this->t99_sequencial = ($this->t99_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["t99_sequencial"] : $this->t99_sequencial);
      $this->t99_itemsistema = ($this->t99_itemsistema == "" ? @$GLOBALS["HTTP_POST_VARS"]["t99_itemsistema"] : $this->t99_itemsistema);
      $this->t99_valor = ($this->t99_valor == "" ? @$GLOBALS["HTTP_POST_VARS"]["t99_valor"] : $this->t99_valor);
      $this->t99_descricao = ($this->t99_descricao == "" ? @$GLOBALS["HTTP_POST_VARS"]["t99_descricao"] : $this->t99_descricao);
      $this->t99_codpcmater = ($this->t99_codpcmater == "" ? @$GLOBALS["HTTP_POST_VARS"]["t99_codpcmater"] : $this->t99_codpcmater);
      $this->t99_codbensdispensatombamento = ($this->t99_codbensdispensatombamento == "" ? @$GLOBALS["HTTP_POST_VARS"]["t99_codbensdispensatombamento"] : $this->t99_codbensdispensatombamento);
      $this->t99_codbemmanutencao = ($this->t99_codbemmanutencao == "" ? @$GLOBALS["HTTP_POST_VARS"]["t99_codbemmanutencao"] : $this->t99_codbemmanutencao);
    } else {
    }
  }

  // funcao para inclusao
  function incluir()
  {

    $this->atualizacampos();

    if ($this->t99_sequencial == "" || $this->t99_sequencial == null) {
      $result = db_query("select nextval('manutbensitem_t99_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: manutbensitem_t99_sequencial_seq do campo: t99_sequencial";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->t99_sequencial = pg_result($result, 0, 0);
    }

    $result = db_query("select last_value from manutbensitem_t99_sequencial_seq");
    if (($result != false) && (pg_result($result, 0, 0) < $this->t99_sequencial)) {
      $this->erro_sql = " Campo t99_sequencial maior que último número da sequencia.";
      $this->erro_banco = "Sequencia menor que este número.";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    $this->t99_sequencial = $this->t99_sequencial;

    if ($this->t99_itemsistema == "0") {
      $this->erro_sql = " Informe a origem do item.";
      $this->erro_campo = "t99_itemsistema";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    if ($this->t99_valor == null) {
      $this->erro_sql = " Campo Valor não informado.";
      $this->erro_campo = "t99_valor";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    if ($this->t99_descricao == null) {
      $this->erro_sql = " Campo Descrição não informado.";
      $this->erro_campo = "t99_descricao";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    if ($this->t99_codbemmanutencao == null) {
      $this->erro_sql = " Campo t99_codbemmanutencao não informado.";
      $this->erro_campo = "t99_codbemmanutencao";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    if ($this->t99_itemsistema == "1" && $this->t99_codpcmater == null) {
      $this->erro_sql = " Bem de dispensa de tombamento não encontrado.";
      $this->erro_campo = "t99_codbensdispensatombamento";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    if ($this->t99_codpcmater == "") {
      $this->t99_codpcmater = "null";
    }

    if ($this->t99_codbensdispensatombamento == "") {
      $this->t99_codbensdispensatombamento = "null";
    }


    $sql = "insert into manutbensitem(
                    t99_sequencial 
                    ,t99_itemsistema 
                    ,t99_valor 
                    ,t99_descricao  
                    ,t99_codpcmater 
                    ,t99_codbensdispensatombamento 
                    ,t99_codbemmanutencao)
                values ($this->t99_sequencial,  
                               $this->t99_itemsistema, 
                               $this->t99_valor, 
                               '$this->t99_descricao', 
                               $this->t99_codpcmater, 
                               $this->t99_codbensdispensatombamento, 
                               $this->t99_codbemmanutencao
                      )";

    db_inicio_transacao();
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql   = "Componente do bem () nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_banco = "Componente do bem já Cadastrado";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        $this->numrows_incluir = 0;

        db_fim_transacao(true);
        return false;
      }
      $this->erro_sql   = "Componente do bem () nao Incluído. Inclusao Abortada.";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      db_fim_transacao(true);
      return false;
    }

    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);

    db_fim_transacao(false);
    return true;
  }

  // funcao para alteracao
  function alterar($sequencial = null)
  {

    $this->atualizacampos();
    $sql = " update manutbensitem set ";
    $virgula = "";
    if (trim($this->t99_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t99_sequencial"])) {
      $sql  .= $virgula . " t99_sequencial = $this->t99_sequencial ";
      $virgula = ",";
      if (trim($this->t99_sequencial) == null) {
        $this->erro_sql = " Campo Sequencial não informado.";
        $this->erro_campo = "t99_sequencial";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t99_itemsistema) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t99_itemsistema"])) {
      $sql  .= $virgula . " t99_itemsistema = $this->t99_itemsistema ";
      $virgula = ",";
      if (trim($this->t99_itemsistema) == null) {
        $this->erro_sql = " Campo Item do Sistema não informado.";
        $this->erro_campo = "t99_itemsistema";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }

    if (trim($this->t99_valor) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t99_valor"])) {
      $sql  .= $virgula . " t99_valor = '$this->t99_valor' ";
      $virgula = ",";
      if (trim($this->t99_valor) == null) {
        $this->erro_sql = " Campo Valor não informado.";
        $this->erro_campo = "t99_valor";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }

    if (trim($this->t99_descricao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t99_descricao"])) {
      $sql  .= $virgula . " t99_descricao = '$this->t99_descricao' ";
      $virgula = ",";
      if (trim($this->t99_descricao) == null) {
        $this->erro_sql = " Campo Descrição do Componente não informado.";
        $this->erro_campo = "t99_descricao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }

    if (trim($this->t99_codpcmater) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t99_codpcmater"])) {
      $sql  .= $virgula . " t99_codpcmater = $this->t99_codpcmater ";
      $virgula = ",";
      if (trim($this->t99_codpcmater) == null) {
        $this->erro_sql = " Campo t99_codpcmater não informado.";
        $this->erro_campo = "t99_codpcmater";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }

    if (trim($this->t99_codbensdispensatombamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t99_codbensdispensatombamento"])) {
      $sql  .= $virgula . " t99_codbensdispensatombamento = $this->t99_codbensdispensatombamento ";
      $virgula = ",";
      if (trim($this->t99_codbensdispensatombamento) == null) {
        $this->erro_sql = " Campo t99_codbensdispensatombamento não informado.";
        $this->erro_campo = "t99_codbensdispensatombamento";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }

    if (trim($this->t99_codbemmanutencao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t99_codbemmanutencao"])) {
      $sql  .= $virgula . " t99_codbemmanutencao = $this->t99_codbemmanutencao ";
      $virgula = ",";
      if (trim($this->t99_codbemmanutencao) == null) {
        $this->erro_sql = " Campo t99_codbemmanutencao não informado.";
        $this->erro_campo = "t99_codbemmanutencao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }

    $sql .= " where ";
    $sql .= "t99_sequencial = $sequencial";
    db_inicio_transacao();
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "Componente do bem nao Alterado. Alteracao Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      db_fim_transacao(true);
      return false;
    }

    if (pg_affected_rows($result) == 0) {
      $this->erro_banco = "";
      $this->erro_sql = "Componente do bem nao foi Alterado. Alteracao Executada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      db_fim_transacao(true);
      return true;
    }

    $this->erro_banco = "";
    $this->erro_sql = "Alteração efetuada com Sucesso\\n";
    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
    $this->erro_status = "1";
    $this->numrows_alterar = pg_affected_rows($result);
    db_fim_transacao(false);
    return true;
  }

  function excluir($sequencial = null, $dbwhere = null)
  {

    $sql = " delete from manutbensitem
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      $sql2 = "t99_sequencial = $sequencial";
    } else {
      $sql2 = $dbwhere;
    }

    db_inicio_transacao();
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   =  "Componente do Bem nao Excluído. Exclusão Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      db_fim_transacao(true);
      return false;
    }
    if (pg_affected_rows($result) == 0) {
      $this->erro_banco = "";
      $this->erro_sql = "Componente do Bem nao Encontrado. Exclusão não Efetuada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      db_fim_transacao(true);
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
    $this->erro_status = "1";
    $this->numrows_excluir = pg_affected_rows($result);
    db_fim_transacao(false);
    return true;
  }

  function excluircomponentes($t99_codbemmanutencao)
  {


    $sql = " delete from manutbensitem
                    where t99_codbemmanutencao = $t99_codbemmanutencao";


    db_inicio_transacao();
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   =  "$sql Componentes do Bem nao Excluído. Exclusão Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      db_fim_transacao(true);
      return false;
    }
    if (pg_affected_rows($result) == 0) {
      $this->erro_banco = "";
      $this->erro_sql = "Componentes do Bem nao Encontrado. Exclusão não Efetuada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      db_fim_transacao(true);
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
    $this->erro_status = "1";
    $this->numrows_excluir = pg_affected_rows($result);
    db_fim_transacao(false);
    return true;
  }

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
    $sql .= " from manutbensitem ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($oid != "" && $oid != null) {
        $sql2 = " where t99_codbemmanutencao = $oid";
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
