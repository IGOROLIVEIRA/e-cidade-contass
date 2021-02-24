<?php
//MODULO: sicom
//CLASSE DA ENTIDADE pessoasobra102021
class cl_pessoasobra102021 {
  // cria variaveis de erro
  public $rotulo     = null;
  public $query_sql  = null;
  public $numrows    = 0;
  public $numrows_incluir = 0;
  public $numrows_alterar = 0;
  public $numrows_excluir = 0;
  public $erro_status= null;
  public $erro_sql   = null;
  public $erro_banco = null;
  public $erro_msg   = null;
  public $erro_campo = null;
  public $pagina_retorno = null;
  // cria variaveis do arquivo
  public $si194_sequencial = 0;
  public $si194_tiporegistro = 0;
  public $si194_nrodocumento = null;
  public $si194_nome = null;
  public $si194_tipocadastro = 0;
  public $si194_justificativaalteracao = null;
  public $si194_mes = 0;
  public $si194_instit = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 si194_sequencial = int8 = Sequencial
                 si194_tiporegistro = int8 = Tiporegistro
                 si194_nrodocumento = text = Numero Documento
                 si194_nome = text = Nome
                 si194_tipocadastro = int4 = Tipo Cadastro
                 si194_justificativaalteracao = text = Justificativa Alteracao
                 si194_mes = int4 = Mes
                 si194_instit = int4 = Instituição
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("pessoasobra102021");
    $this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
  }

  //funcao erro
  function erro($mostra,$retorna) {
    if (($this->erro_status == "0") || ($mostra == true && $this->erro_status != null )) {
      echo "<script>alert(\"".$this->erro_msg."\");</script>";
      if ($retorna==true) {
        echo "<script>location.href='".$this->pagina_retorno."'</script>";
      }
    }
  }

  // funcao para atualizar campos
  function atualizacampos($exclusao=false) {
    if ($exclusao==false) {
      $this->si194_sequencial = ($this->si194_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_sequencial"]:$this->si194_sequencial);
      $this->si194_tiporegistro = ($this->si194_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_tiporegistro"]:$this->si194_tiporegistro);
      $this->si194_nrodocumento = ($this->si194_nrodocumento == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_nrodocumento"]:$this->si194_nrodocumento);
      $this->si194_nome = ($this->si194_nome == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_nome"]:$this->si194_nome);
      $this->si194_tipocadastro = ($this->si194_tipocadastro == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_tipocadastro"]:$this->si194_tipocadastro);
      $this->si194_justificativaalteracao = ($this->si194_justificativaalteracao == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_justificativaalteracao"]:$this->si194_justificativaalteracao);
      $this->si194_mes = ($this->si194_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_mes"]:$this->si194_mes);
      $this->si194_instit = ($this->si194_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_instit"]:$this->si194_instit);
    } else {
    }
  }

  // funcao para inclusao
  function incluir () {
    $this->atualizacampos();
    if ($this->si194_sequencial == null ) {
      $result = db_query("select nextval('pessoasobra102021_si194_sequencial_seq')");
      if($result==false){
        $this->erro_banco = str_replace("\n","",@pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: pessoasobra102021_si194_sequencial_seq do campo: si194_sequencial";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si194_sequencial = pg_result($result,0,0);
    }

    if ($this->si194_tiporegistro == null ) {
      $this->erro_sql = " Campo Tiporegistro não informado.";
      $this->erro_campo = "si194_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si194_nrodocumento == null ) {
      $this->erro_sql = " Campo Numero Documento não informado.";
      $this->erro_campo = "si194_nrodocumento";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si194_nome == null ) {
      $this->erro_sql = " Campo Nome não informado.";
      $this->erro_campo = "si194_nome";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si194_tipocadastro == null ) {
      $this->erro_sql = " Campo Tipo Cadastro não informado.";
      $this->erro_campo = "si194_tipocadastro";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
//    if ($this->si194_justificativaalteracao == null ) {
//      $this->erro_sql = " Campo Justificativa Alteracao não informado.";
//      $this->erro_campo = "si194_justificativaalteracao";
//      $this->erro_banco = "";
//      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//      $this->erro_status = "0";
//      return false;
//    }
    if ($this->si194_mes == null ) {
      $this->erro_sql = " Campo Mes não informado.";
      $this->erro_campo = "si194_mes";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si194_instit == null ) {
      $this->erro_sql = " Campo Instituição não informado.";
      $this->erro_campo = "si194_instit";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into pessoasobra102021(
                                       si194_sequencial
                                      ,si194_tiporegistro
                                      ,si194_nrodocumento
                                      ,si194_nome
                                      ,si194_tipocadastro
                                      ,si194_justificativaalteracao
                                      ,si194_mes
                                      ,si194_instit
                       )
                values (
                                $this->si194_sequencial
                               ,$this->si194_tiporegistro
                               ,'$this->si194_nrodocumento'
                               ,'$this->si194_nome'
                               ,$this->si194_tipocadastro
                               ,'$this->si194_justificativaalteracao'
                               ,$this->si194_mes
                               ,$this->si194_instit
                      )";
    $result = db_query($sql);
    if ($result==false) {
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
        $this->erro_sql   = "cadastro pessoas obra () nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_banco = "cadastro pessoas obra já Cadastrado";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      } else {
        $this->erro_sql   = "cadastro pessoas obra () nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir= 0;
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
    $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
    $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
    $this->erro_status = "1";
    $this->numrows_incluir= pg_affected_rows($result);
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
        && ($lSessaoDesativarAccount === false))) {

    }
    return true;
  }

  // funcao para alteracao
  function alterar ( $si194_sequencial=null ) {
    $this->atualizacampos();
    $sql = " update pessoasobra102021 set ";
    $virgula = "";
    if (trim($this->si194_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_sequencial"])) {
      $sql  .= $virgula." si194_sequencial = $this->si194_sequencial ";
      $virgula = ",";
      if (trim($this->si194_sequencial) == null ) {
        $this->erro_sql = " Campo Sequencial não informado.";
        $this->erro_campo = "si194_sequencial";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si194_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_tiporegistro"])) {
      $sql  .= $virgula." si194_tiporegistro = $this->si194_tiporegistro ";
      $virgula = ",";
      if (trim($this->si194_tiporegistro) == null ) {
        $this->erro_sql = " Campo Tiporegistro não informado.";
        $this->erro_campo = "si194_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si194_nrodocumento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_nrodocumento"])) {
      $sql  .= $virgula." si194_nrodocumento = '$this->si194_nrodocumento' ";
      $virgula = ",";
      if (trim($this->si194_nrodocumento) == null ) {
        $this->erro_sql = " Campo Numero Documento não informado.";
        $this->erro_campo = "si194_nrodocumento";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si194_nome)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_nome"])) {
      $sql  .= $virgula." si194_nome = '$this->si194_nome' ";
      $virgula = ",";
      if (trim($this->si194_nome) == null ) {
        $this->erro_sql = " Campo Nome não informado.";
        $this->erro_campo = "si194_nome";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si194_tipocadastro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_tipocadastro"])) {
      $sql  .= $virgula." si194_tipocadastro = $this->si194_tipocadastro ";
      $virgula = ",";
      if (trim($this->si194_tipocadastro) == null ) {
        $this->erro_sql = " Campo Tipo Cadastro não informado.";
        $this->erro_campo = "si194_tipocadastro";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si194_justificativaalteracao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_justificativaalteracao"])) {
      $sql  .= $virgula." si194_justificativaalteracao = '$this->si194_justificativaalteracao' ";
      $virgula = ",";
      if (trim($this->si194_justificativaalteracao) == null ) {
        $this->erro_sql = " Campo Justificativa Alteracao não informado.";
        $this->erro_campo = "si194_justificativaalteracao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si194_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_mes"])) {
      $sql  .= $virgula." si194_mes = $this->si194_mes ";
      $virgula = ",";
      if (trim($this->si194_mes) == null ) {
        $this->erro_sql = " Campo Mes não informado.";
        $this->erro_campo = "si194_mes";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si194_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_instit"])) {
      $sql  .= $virgula." si194_instit = $this->si194_instit ";
      $virgula = ",";
      if (trim($this->si194_instit) == null ) {
        $this->erro_sql = " Campo Instituição não informado.";
        $this->erro_campo = "si194_instit";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    $sql .= "si194_sequencial = '$si194_sequencial'";     $result = db_query($sql);
    if ($result==false) {
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "cadastro pessoas obra nao Alterado. Alteracao Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result)==0) {
        $this->erro_banco = "";
        $this->erro_sql = "cadastro pessoas obra nao foi Alterado. Alteracao Executada.\\n";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ( $si194_sequencial=null ,$dbwhere=null) {

    $sql = " delete from pessoasobra102021
                    where ";
    $sql2 = "";
    if ($dbwhere==null || $dbwhere =="") {
      $sql2 = "si194_sequencial = '$si194_sequencial'";
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql.$sql2);
    if ($result==false) {
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "cadastro pessoas obra nao Excluído. Exclusão Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result)==0) {
        $this->erro_banco = "";
        $this->erro_sql = "cadastro pessoas obra nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao do recordset
  function sql_record($sql) {
    $result = db_query($sql);
    if ($result==false) {
      $this->numrows    = 0;
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "Erro ao selecionar os registros.";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    $this->numrows = pg_numrows($result);
    if ($this->numrows==0) {
      $this->erro_banco = "";
      $this->erro_sql   = "Record Vazio na Tabela:pessoasobra102021";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }

  // funcao do sql
  function sql_query ( $si194_sequencial = null,$campos="*",$ordem=null,$dbwhere="") {
    $sql = "select ";
    if ($campos != "*" ) {
      $campos_sql = explode("#", $campos);
      $virgula = "";
      for($i=0;$i<sizeof($campos_sql);$i++) {
        $sql .= $virgula.$campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    $sql .= " from pessoasobra102021 ";
    $sql2 = "";
    if ($dbwhere=="") {
      if ( $si194_sequencial != "" && $si194_sequencial != null) {
        $sql2 = " where pessoasobra102021.si194_sequencial = '$si194_sequencial'";
      }
    } else if ($dbwhere != "") {
      $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if ($ordem != null ) {
      $sql .= " order by ";
      $campos_sql = explode("#", $ordem);
      $virgula = "";
      for($i=0;$i<sizeof($campos_sql);$i++) {
        $sql .= $virgula.$campos_sql[$i];
        $virgula = ",";
      }
    }
    return $sql;
  }

  // funcao do sql
  function sql_query_file ( $si194_sequencial = null,$campos="*",$ordem=null,$dbwhere="") {
    $sql = "select ";
    if ($campos != "*" ) {
      $campos_sql = explode("#", $campos);
      $virgula = "";
      for($i=0;$i<sizeof($campos_sql);$i++) {
        $sql .= $virgula.$campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    $sql .= " from pessoasobra102021 ";
    $sql2 = "";
    if ($dbwhere=="") {
    } else if ($dbwhere != "") {
      $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if ($ordem != null ) {
      $sql .= " order by ";
      $campos_sql = explode("#", $ordem);
      $virgula = "";
      for($i=0;$i<sizeof($campos_sql);$i++) {
        $sql .= $virgula.$campos_sql[$i];
        $virgula = ",";
      }
    }
    return $sql;
  }
}
?>
