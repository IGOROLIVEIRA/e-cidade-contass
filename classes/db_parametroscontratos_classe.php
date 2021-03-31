<?php
//MODULO: acordos
//CLASSE DA ENTIDADE parametroscontratos
class cl_parametroscontratos {
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
  public $pc01_liberaautorizacao = 'f';
  public $pc01_liberarcadastrosemvigencia = 'f';
  public $pc01_liberarsemassinaturaaditivo = 'f';
  public $pc01_libcontratodepart = 't';
  public $pc01_liberargerenciamentocontratos = 'f';
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 pc01_liberaautorizacao = bool = Liberar autorização de empenho sem assinatura
                 pc01_liberarcadastrosemvigencia = bool = Liberar cadastro de contratos sem vigência
                 pc01_liberarsemassinaturaaditivo = bool = Liberar autotização de empenho sem assinatura de aditivo
                 pc01_libcontratodepart = bool = Controlar a alteração de dados do contrato por departamento
                 pc01_liberargerenciamentocontratos = bool = Liberar Gerenciamento de Contratos
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("parametroscontratos");
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
       $this->pc01_liberaautorizacao = ($this->pc01_liberaautorizacao == "f"?@$GLOBALS["HTTP_POST_VARS"]["pc01_liberaautorizacao"]:$this->pc01_liberaautorizacao);
       $this->pc01_liberarcadastrosemvigencia = ($this->pc01_liberarcadastrosemvigencia == "f"?@$GLOBALS["HTTP_POST_VARS"]["pc01_liberarcadastrosemvigencia"]:$this->pc01_liberarcadastrosemvigencia);
       $this->pc01_liberarsemassinaturaaditivo = ($this->pc01_liberarsemassinaturaaditivo == "f"?@$GLOBALS["HTTP_POST_VARS"]["pc01_liberarsemassinaturaaditivo"]:$this->pc01_liberarsemassinaturaaditivo);
       $this->pc01_libcontratodepart = ($this->pc01_libcontratodepart == "t" ? @$GLOBALS["HTTP_POST_VARS"]["pc01_libcontratodepart"] : $this->pc01_libcontratodepart);
       $this->pc01_liberargerenciamentocontratos = ($this->pc01_liberargerenciamentocontratos == "t" ? @$GLOBALS["HTTP_POST_VARS"]["pc01_liberargerenciamentocontratos"] : $this->pc01_liberargerenciamentocontratos);
      } else {
     }
   }

  // funcao para inclusao
  function incluir () {
      $this->atualizacampos();
     if ($this->pc01_liberaautorizacao == null ) {
       $this->erro_sql = " Campo Liberar autorização de empenho sem assinatura não informado.";
       $this->erro_campo = "pc01_liberaautorizacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->pc01_liberarcadastrosemvigencia == null ) {
       $this->erro_sql = " Campo Liberar autorização de empenho sem assinatura não informado.";
       $this->erro_campo = "pc01_liberarcadastrosemvigencia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->pc01_liberarsemassinaturaaditivo == null ) {
       $this->erro_sql = " Campo Liberar autorização de empenho sem assinatura não informado.";
       $this->erro_campo = "pc01_liberarsemassinaturaaditivo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->pc01_libcontratodepart == null ) {
      $this->erro_sql = " Campo Controlar a alteração de dados do contrato por departamento.";
      $this->erro_campo = "pc01_libcontratodepart";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->pc01_liberargerenciamentocontratos == null ) {
      $this->erro_sql = " Campo Liberar gerenciamento de contratos";
      $this->erro_campo = "pc01_liberargerenciamentocontratos";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
     $sql = "insert into parametroscontratos(
                                       pc01_liberaautorizacao,
                                       pc01_liberarcadastrosemvigencia,
                                       pc01_liberarsemassinaturaaditivo,
                                       pc01_libcontratodepart,
                                       pc01_liberargerenciamentocontratos
                       )
                values (
                                '$this->pc01_liberaautorizacao' ,
                                '$this->pc01_liberarcadastrosemvigencia' ,
                                '$this->pc01_liberarsemassinaturaaditivo' ,
                                '$this->pc01_libcontratodepart',
                                '$this->pc01_liberargerenciamentocontratos'
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "parametroscontratos () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "parametroscontratos já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "parametroscontratos () nao Incluído. Inclusao Abortada.";
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
  function alterar ( $oid=null ) {
      $this->atualizacampos();
     $sql = " update parametroscontratos set ";
     $virgula = "";
     if (trim($this->pc01_liberaautorizacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc01_liberaautorizacao"])) {
       $sql  .= $virgula." pc01_liberaautorizacao = '$this->pc01_liberaautorizacao' ";
       $virgula = ",";
       if (trim($this->pc01_liberaautorizacao) == null ) {
         $this->erro_sql = " Campo Liberar autorização de empenho sem assinatura não informado.";
         $this->erro_campo = "pc01_liberaautorizacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->pc01_liberarcadastrosemvigencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc01_liberarcadastrosemvigencia"])) {
       $sql  .= $virgula." pc01_liberarcadastrosemvigencia = '$this->pc01_liberarcadastrosemvigencia' ";
       $virgula = ",";
       if (trim($this->pc01_liberarcadastrosemvigencia) == null ) {
         $this->erro_sql = " Campo Liberar autorização de empenho sem assinatura não informado.";
         $this->erro_campo = "pc01_liberarcadastrosemvigencia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->pc01_liberarsemassinaturaaditivo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc01_liberarsemassinaturaaditivo"])) {
       $sql  .= $virgula." pc01_liberarsemassinaturaaditivo = '$this->pc01_liberarsemassinaturaaditivo' ";
       $virgula = ",";
       if (trim($this->pc01_liberarsemassinaturaaditivo) == null ) {
         $this->erro_sql = " Campo Liberar autorização de empenho sem assinatura não informado.";
         $this->erro_campo = "pc01_liberarsemassinaturaaditivo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->pc01_libcontratodepart) !="" || isset($GLOBALS["HTTP_POST_VARS"]["pc01_libcontratodepart"])) {
      $sql  .= $virgula." pc01_libcontratodepart = '$this->pc01_libcontratodepart' ";
      $virgula = ",";
      if (trim($this->pc01_libcontratodepart) == null ) {
        $this->erro_sql = " Campo Controlar a alteração de dados do contrato por departamento.";
        $this->erro_campo = "pc01_libcontratodepart";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->pc01_liberargerenciamentocontratos) !="" || isset($GLOBALS["HTTP_POST_VARS"]["pc01_liberargerenciamentocontratos"])) {
        $sql  .= $virgula." pc01_liberargerenciamentocontratos = '$this->pc01_liberargerenciamentocontratos' ";
        $virgula = ",";
        if (trim($this->pc01_liberargerenciamentocontratos) == null ) {
            $this->erro_sql = " Campo Liberar gerenciamento de contratos.";
            $this->erro_campo = "pc01_liberargerenciamentocontratos";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
    }
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "parametroscontratos nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "parametroscontratos nao foi Alterado. Alteracao Executada.\\n";
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
  function excluir ( $oid=null ,$dbwhere=null) {

     $sql = " delete from parametroscontratos
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
       $sql2 = "oid = '$oid'";
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "parametroscontratos nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "parametroscontratos nao Encontrado. Exclusão não Efetuada.\\n";
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
        $this->erro_sql   = "Record Vazio na Tabela:parametroscontratos";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $oid = null,$campos="parametroscontratos.oid,*",$ordem=null,$dbwhere="") {
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
     $sql .= " from parametroscontratos ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ( $oid != "" && $oid != null) {
          $sql2 = " where parametroscontratos.oid = '$oid'";
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
  function sql_query_file ( $oid = null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from parametroscontratos ";
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
